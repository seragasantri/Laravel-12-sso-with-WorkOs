<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use WorkOS\SSO;
use WorkOS\Profile;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use function Psy\debug;

$workos_api_key = env('WORKOS_API_KEY');
$workos_client_id = env('WORKOS_CLIENT_ID');
$sso = new SSO($workos_api_key);

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth');

Route::get('/login', function () {

    $providers = [
        'GoogleOAuth' => [
            'name' => 'Google',
            'icon' => 'fab fa-google',
            'color' => 'bg-red-500 hover:bg-red-600'
        ],
        'MicrosoftOAuth' => [
            'name' => 'Microsoft',
            'icon' => 'fab fa-microsoft',
            'color' => 'bg-blue-500 hover:bg-blue-600'
        ],
        'GitHubOAuth' => [
            'name' => 'GitHub',
            'icon' => 'fab fa-github',
            'color' => 'bg-gray-800 hover:bg-gray-900'
        ],
    ];

    return view('auth.login', compact('providers'));
})->name('login');


Route::get('/auth/redirect/{provider}', function (Request $request, $provider) use ($sso, $workos_client_id) {
    $domain = 'http://laravel-12.test/';


    $state = bin2hex(random_bytes(16));

    Session::put('workos_state', $state);
    Session::put('workos_provider', $provider);

    $redirectUri = url('/auth/callback');

    $authorizationUrl = $sso->getAuthorizationUrl(
        domain: $domain,
        provider: $provider,
        redirectUri: $redirectUri,
        state: $state,
    );

    return redirect($authorizationUrl);
})->name('auth.redirect');


Route::get('/auth/callback', function (Request $request) use ($sso) {
    $provider = Session::get('workos_provider');

    Log::info('Auth callback started', [
        'has_code' => !empty($request->code),
        'has_state' => !empty($request->state)
    ]);

    // Verify state
    $state = Session::get('workos_state');
    $requestState = $request->state;
    $cleanedRequestState = trim($requestState, '"');

    Log::info('State comparison', [
        'session_state' => $state,
        'request_state' => $requestState,
        'cleaned_request_state' => $cleanedRequestState
    ]);

    if (!$state || $state !== $cleanedRequestState) {
        Log::error('Invalid state parameter - redirecting to login', [
            'session_state' => $state,
            'request_state' => $requestState
        ]);
        return redirect('/login')->withErrors(['error' => 'Authentication failed: Invalid state parameter']);
    }

    try {
        Log::info('Getting profile with code', ['code' => $request->code]);


        $profile = $sso->getProfileAndToken($request->code, url('/auth/callback'));

        Log::info('Profile received', [
            'has_profile' => !empty($profile),
            'profile_data' => $profile ?? 'No profile'
        ]);

        $userProfile = $profile->profile;


        Log::info('User profile', [
            'email' => $userProfile->email ?? 'No email',
            'first_name' => $userProfile->firstName ?? 'No first name',
            'last_name' => $userProfile->lastName ?? 'No last name'
        ]);

        try {

            $user = User::updateOrCreate(
                ['email' => $userProfile->email],
                [
                    'name' => ($userProfile->firstName ?? '') . ' ' . ($userProfile->lastName ?? ''),
                    'workos_id' => $userProfile->id,
                    'email_verified_at' => now(),
                    'password' => Hash::make(Str::random(24)),
                    'auth_provider' => $provider,
                ]
            );

            Log::info('User created/updated', ['user_id' => $user->id]);

            Auth::login($user);
            Log::info('User logged in', ['user_id' => $user->id]);

            Session::forget('workos_state');
            return redirect('/dashboard');
        } catch (\Exception $e) {
            Log::error('Error creating/updating user', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect('/login')->withErrors(['error' => 'Authentication failed: Error creating user account']);
        }
    } catch (\Exception $e) {
        Log::error('WorkOS authentication error', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        return redirect('/login')->withErrors(['error' => 'Authentication failed: ' . $e->getMessage()]);
    }
})->name('auth.callback');

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('home');
})->middleware('auth')->name('logout');

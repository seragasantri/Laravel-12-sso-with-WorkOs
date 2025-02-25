<!-- resources/views/auth/login.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gray-50">
        <div class="max-w-md w-full space-y-8 p-8 bg-white rounded-lg shadow-lg">
            <div class="text-center">
                <h2 class="mt-6 text-3xl font-extrabold text-gray-900">
                    Sign in to your account
                </h2>
                <p class="mt-2 text-sm text-gray-600">
                    Choose your preferred login method
                </p>
            </div>

            @if (session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            <div class="mt-8 space-y-4">
                @foreach ($providers as $providerId => $provider)
                    <a href="{{ route('auth.redirect', $providerId) }}"
                        class="w-full flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-white {{ $provider['color'] }} focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <i class="{{ $provider['icon'] }} mr-2"></i>
                        Continue with {{ $provider['name'] }}
                    </a>
                @endforeach

                <div class="mt-6 text-center">
                    <p class="text-xs text-gray-500">
                        By signing in, you agree to our
                        <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">
                            Terms of Service
                        </a>
                        and
                        <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">
                            Privacy Policy
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection

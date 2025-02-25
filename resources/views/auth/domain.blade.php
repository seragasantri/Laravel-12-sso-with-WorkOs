<!-- resources/views/auth/domain.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gray-50">
        <div class="max-w-md w-full space-y-8 p-8 bg-white rounded-lg shadow-lg">
            <div class="text-center">
                <h2 class="mt-6 text-3xl font-extrabold text-gray-900">
                    Enterprise SSO
                </h2>
                <p class="mt-2 text-sm text-gray-600">
                    Enter your company domain to continue
                </p>
            </div>

            <form class="mt-8 space-y-6" action="{{ route('auth.redirect', $provider) }}" method="GET">
                <div>
                    <label for="domain" class="block text-sm font-medium text-gray-700">
                        Company Domain
                    </label>
                    <div class="mt-1">
                        <input id="domain" name="domain" type="text" required
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="company.com">
                    </div>
                    <p class="mt-1 text-sm text-gray-500">
                        For example: acme.com, example.org
                    </p>
                </div>

                <div>
                    <button type="submit"
                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Continue
                    </button>
                </div>

                <div class="text-center">
                    <a href="{{ route('login') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                        ← Back to login options
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        @yield('content')
    </div>
</body>

</html>

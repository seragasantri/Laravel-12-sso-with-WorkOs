<!-- resources/views/welcome.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="relative flex items-top justify-center min-h-screen bg-gray-100 sm:items-center py-4 sm:pt-0">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-center pt-8 sm:justify-start sm:pt-0">
                <h1 class="text-4xl font-bold text-indigo-600">Your Application</h1>
            </div>

            <div class="mt-8 bg-white overflow-hidden shadow sm:rounded-lg">
                <div class="grid grid-cols-1 md:grid-cols-2">
                    <div class="p-6">
                        <div class="flex items-center">
                            <i class="fas fa-lock fa-2x text-gray-500"></i>
                            <div class="ml-4 text-lg leading-7 font-semibold">Multi-Provider SSO</div>
                        </div>

                        <div class="ml-12">
                            <div class="mt-2 text-gray-600 text-sm">
                                Log in with your preferred authentication provider. We support Google, Microsoft, GitHub,
                                Okta, and Enterprise SSO via SAML.
                            </div>
                        </div>
                    </div>

                    <div class="p-6 border-t border-gray-200 md:border-t-0 md:border-l">
                        <div class="flex items-center">
                            <i class="fas fa-shield-alt fa-2x text-gray-500"></i>
                            <div class="ml-4 text-lg leading-7 font-semibold">Secure Authentication</div>
                        </div>

                        <div class="ml-12">
                            <div class="mt-2 text-gray-600 text-sm">
                                Your security is our priority. We use industry-standard authentication protocols to keep
                                your account safe.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-center mt-4 sm:items-center">
                <div class="text-center text-sm text-gray-500 sm:text-left">
                    <div class="flex items-center">
                        @if (Auth::check())
                            <a href="{{ route('dashboard') }}" class="ml-1 underline">
                                Go to Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="ml-1 underline">
                                Sign In
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

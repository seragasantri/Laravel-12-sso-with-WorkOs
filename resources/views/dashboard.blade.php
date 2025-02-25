<!-- resources/views/dashboard.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-100">
        <nav class="bg-white shadow">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <div class="flex-shrink-0 flex items-center">
                            <span class="text-xl font-bold text-indigo-600">Your App</span>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <div class="relative ml-3">
                            <div class="flex items-center">
                                @if (Auth::user()->profile_photo_url)
                                    <img class="h-8 w-8 rounded-full object-cover"
                                        src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}">
                                @else
                                    <div
                                        class="h-8 w-8 rounded-full bg-indigo-500 flex items-center justify-center text-white">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </div>
                                @endif
                                <span class="ml-2 text-gray-700">{{ Auth::user()->name }}</span>
                                <form method="POST" action="{{ route('logout') }}" class="ml-4">
                                    @csrf
                                    <button type="submit" class="text-sm text-gray-500 hover:text-gray-700">
                                        Sign out
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold text-gray-900">
                    Dashboard
                </h1>
            </div>
        </header>

        <main>
            <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
                <div class="px-4 py-6 sm:px-0">
                    <div class="border-4 border-dashed border-gray-200 rounded-lg h-96 p-6">
                        <h2 class="text-lg font-medium text-gray-900">Welcome to Your Dashboard</h2>
                        <p class="mt-2 text-gray-600">
                            You've successfully logged in via {{ Auth::user()->auth_provider }}
                        </p>
                        <div class="mt-6">
                            <h3 class="text-md font-medium text-gray-900">Your Account Information:</h3>
                            <ul class="mt-2 list-disc list-inside text-gray-600">
                                <li>Name: {{ Auth::user()->name }}</li>
                                <li>Email: {{ Auth::user()->email }}</li>
                                <li>Authentication Provider: {{ Auth::user()->auth_provider }}</li>
                                <li>Joined: {{ Auth::user()->created_at->format('F j, Y') }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
@endsection

@extends('layouts.app')

@section('content')
    <div class="container mx-auto">
        <div class="flex justify-center">
            <div class="w-full max-w-md">
                <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg px-8 py-6 mt-10">
                    <div class="text-xl font-semibold mb-6">{{ __('Reset Password') }}</div>
                    <form method="POST" action="{{ route('password.perbaharui') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        <div class="mb-4">
                            <label for="email" class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-2">{{ __('Email Address') }}</label>
                            <input id="email" type="email" class="form-input w-full dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 @error('email') border-red-500 @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                            @error('email')
                                <span class="text-sm text-red-500 mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="password" class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-2">{{ __('Password') }}</label>
                            <input id="password" type="password" class="form-input w-full dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 @error('password') border-red-500 @enderror" name="password" required autocomplete="new-password">
                            @error('password')
                                <span class="text-sm text-red-500 mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="password-confirm" class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-2">{{ __('Confirm Password') }}</label>
                            <input id="password-confirm" type="password" class="form-input w-full dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 " name="password_confirmation" required autocomplete="new-password">
                        </div>
                        <div class="flex justify-center">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">{{ __('Reset Password') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

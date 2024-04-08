@extends('layouts.app')

@section('content')
    @if ($errors->any())
        <div id="alert-border-1" class="flex items-center p-4 mb-4 text-red-800 border-t-4 border-red-300 bg-red-50 dark:text-red-400 dark:bg-gray-800 dark:border-red-800 mt-5" role="alert">
            <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
            </svg>
            <div class="ml-3 text-sm font-medium">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-red-400 dark:hover:bg-gray-700" data-dismiss-target="#alert-border-1" aria-label="Close">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
            </button>
        </div>
    @endif
    <div class="container">
        <div class="flex justify-center">
            <div class="w-full max-w-md">
                <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg px-8 py-6 mt-10">
                    <div class="text-xl font-semibold mb-6">{{ __('Masuk') }}</div>
                    <form method="POST" action="{{ route('checkrole') }}">
                        @csrf
                        <div class="mb-4">
                            <label for="email" class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-2">{{ __('Email') }}</label>
                            <input id="email" type="email" class="form-input w-full dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 @error('email') border-red-500 @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            @error('email')
                                <span class="text-sm text-red-500 mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="role_id" class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-2">{{ __('Role Anda') }}</label>
                            <select class="form-input w-full dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400  w-full dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" name="role_id" id="role_id">
                                <option value="1">Staff/Karyawan</option>
                                <option value="2">Admin</option>
                                <option value="3">user</option>
                                <option value="4">Superadmin</option>
                            </select>
                        </div>
                        <div class="flex justify-end">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">{{ __('Pilih Role') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

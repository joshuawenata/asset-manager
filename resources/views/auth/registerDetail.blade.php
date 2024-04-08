@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <div class="flex justify-center">
        <div class="w-1/2">
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg pl-10 py-6 mt-10">
                <div class="text-xl font-semibold mb-6">{{ __('Daftar') }}</div>
                <form method="POST" action="insert-account" onsubmit="tambah()">
                <div class="flex flex-row">

                    <div class="flex flex-col w-96">
                        @csrf
                        <div class="mb-4">
                            <label for="name" class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-2">{{ __('Nama') }}</label>
                            <input id="name" type="text" class="form-input w-full dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 @error('name') border-red-500 @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                            @error('name')
                                <span class="text-sm text-red-500 mt-1">{{ $message }}</span>
                            @enderror
                        </div>
    
                        {{-- 1. BINUSIAN ID --}}
                        <div class="mb-4">
                            <label for="binusianid" class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-2">{{ __('Binusian ID') }}</label>
                            <input id="binusianid" type="text" class="form-input w-full dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 @error('binusianid') border-red-500 @enderror" name="binusianid" value="{{ old('binusianid') }}" required autocomplete="binusianid" autofocus>
                            @error('binusianid')
                                <span class="text-sm text-red-500 mt-1">{{ $message }}</span>
                            @enderror
                        </div>
    
                        {{-- 3. PHONE NUMBER --}}
                        <div class="mb-4">
                            <label for="phone" class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-2">{{ __('Nomor HP') }}</label>
                            <input id="phone" type="text" class="form-input w-full dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 @error('phone') border-red-500 @enderror" name="phone" value="{{ old('phone') }}" required autocomplete="phone" autofocus>
                            @error('phone')
                                <span class="text-sm text-red-500 mt-1">{{ $message }}</span>
                            @enderror
                        </div>
    
                        {{-- 4. PRODI (Dropdown) --}}
                        <div class="mb-4">
                            <label for="division_id" class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-2">{{ __('Prodi/Divisi') }}</label>
                            <select class="form-input w-full dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400  w-full dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 @error('division_id') border-red-500 @enderror" name="division_id" id="division_id">
                                @foreach ($data as $index => $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                            @error('division_id')
                                <span class="text-sm text-red-500 mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="flex flex-col mx-5 w-96">
                        <div class="mb-4">
                            <label for="email" class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-2">{{ __('Email') }}</label>
                            <div class="flex">
                                <input id="email" type="text" class="form-input w-full dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-blue-400 @error('email') border-red-500 @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                <span class="input-group-text bg-gray-200 dark:bg-gray-700 dark:text-gray-300 rounded-r-lg" id="basic-addon2">@binus.edu</span>
                            </div>
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
                            <label for="password-confirm" class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-2">{{ __('Konfirmasi Password') }}</label>
                            <input id="password-confirm" type="password" class="form-input w-full dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 " name="password_confirmation" required autocomplete="new-password">
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-2">{{ __('Role Anda') }}</label>
                            <div class="form-check">
                                <input class="form-checkbox mt-2" name="role[]" type="checkbox" id="isStaff" name="isStaff" value="1">
                                <label class="inline-block ml-2 text-sm text-gray-700 dark:text-gray-300" for="isStaff">Staff</label>
                            </div>
                            <div class="form-check">
                                <input class="form-checkbox mt-2" name="role[]" type="checkbox" id="isAdmin" name="isAdmin" value="2">
                                <label class="inline-block ml-2 text-sm text-gray-700 dark:text-gray-300" for="isAdmin">Admin</label>
                            </div>
                            <div class="form-check">
                                <input class="form-checkbox mt-2" name="role[]" type="checkbox" id="isApprover" name="isApprover" value="3">
                                <label class="inline-block ml-2 text-sm text-gray-700 dark:text-gray-300" for="isApprover">Approver</label>
                            </div>
                        </div>

                        <input type="hidden" id="role_id" name="role_id" value="{{ $role_id }}">
                    </div>
                </div>

                    <div class="flex justify-center">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">{{ __('Daftar') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var elem = document.getElementById('email');
        elem.value = "";
    });

    function tambah() {
        var elem = document.getElementById('email');
        var old = elem.value;
        var tambahan = document.getElementById('basic-addon2');
        elem.value = old + tambahan.innerHTML;
    }
</script>
@endsection

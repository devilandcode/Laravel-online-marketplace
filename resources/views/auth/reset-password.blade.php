@extends('layouts.auth')
@section('title', 'Reset password')
@section('content')
    <x-forms.auth-forms title='Reset password' action="{{ route('password.update') }}" method="POST">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <x-forms.text-input
            type="email"
            name="email"
            placeholder="E-mail"
            :isError="$errors->has('email')"
            value="{{ request('email') }}"
            required></x-forms.text-input>
        @error('email')
        <x-forms.error>
            {{ $message }}
        </x-forms.error>
        @enderror

        <x-forms.text-input
            type="password"
            name="password"
            placeholder="Password"
            :isError="$errors->has('password')"
            required></x-forms.text-input>
        @error('password')
        <x-forms.error>
            {{ $message }}
        </x-forms.error>
        @enderror
        <x-forms.text-input
            type="password"
            name="password_confirmation"
            placeholder="Confirm password"
            :isError="$errors->has('password_confirmation')"
            required></x-forms.text-input>
        @error('password_confirmation')
        <x-forms.error>
            {{ $message }}
        </x-forms.error>
        @enderror

        <x-forms.primary-button>
            Refresh Password
        </x-forms.primary-button>
        <x-slot:socialAuth>
        </x-slot:socialAuth>
        <x-slot:buttons>
        </x-slot:buttons>
    </x-forms.auth-forms>
@endsection


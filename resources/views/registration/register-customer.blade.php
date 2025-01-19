@extends('layouts.background')

@section('content')
<div class="max-w-xl w-full mx-auto p-2 bg-orange-400 rounded-lg shadow-lg text-center">
    <h1 class="text-xl font-bold text-white mt-1 mb-4">Welcome to Food For Everyone!</h1>
    <div class="bg-white p-10 rounded-lg shadow-md">
        <form method="POST" action="{{ route('register.form') }}">
            @csrf
            <input type="hidden" name="role" value="customer">
            <div class="flex justify-between gap-4 mb-6">
                <input type="text" name="first_name" placeholder="First Name" required class="w-full p-3 border border-gray-300 rounded">
                <input type="text" name="last_name" placeholder="Last Name" required class="w-full p-3 border border-gray-300 rounded">
            </div>
            <input type="date" name="date_of_birth" placeholder="Date of Birth" required class="w-full p-3 border border-gray-300 rounded mb-6">
            <input type="email" name="email" placeholder="E-mail" required class="w-full p-3 border border-gray-300 rounded mb-6">
            <input type="password" name="password" placeholder="Password" required class="w-full p-3 border border-gray-300 rounded mb-6">
            <input type="password" name="password_confirmation" placeholder="Confirm Password" required class="w-full p-3 border border-gray-300 rounded mb-6">
            <button type="submit" class="w-full py-3 bg-orange-500 hover:bg-orange-600 text-white rounded-full shadow font-bold mb-6 transition duration-300">Sign Up</button>
        </form>
        <p class="text-sm text-gray-600 mb-6">Have an account? <a href="{{ route('login') }}" class="text-orange-500 hover:underline">Login</a></p>
        <div class="flex items-center justify-center my-6">
            <div class="border-t border-gray-300 flex-grow mr-3"></div>
            <div class="text-gray-600">Sign up with</div>
            <div class="border-t border-gray-300 flex-grow ml-3"></div>
        </div>
        <div class="flex justify-center gap-4 mt-4">
            <a href="{{ route('socialite.redirect', 'facebook') }}" class="flex items-center px-4 py-2 space-x-2 rounded-full border border-gray-300 shadow-sm text-gray-600 hover:text-gray-900 hover:bg-gray-100">
                <img src="https://upload.wikimedia.org/wikipedia/commons/c/c2/F_icon.svg" alt="Facebook" class="h-6 w-6">
                <span>Facebook</span>
            </a>
            <a href="{{ route('socialite.redirect', 'google') }}" class="flex items-center px-4 py-2 space-x-2 rounded-full border border-gray-300 shadow-sm text-gray-600 hover:text-gray-900 hover:bg-gray-100">
                <img src="{{ asset('images/google.png') }}" alt="Google" class="h-6 w-6">
                <span>Google</span>
            </a>
        </div>
    </div>
</div>
@endsection
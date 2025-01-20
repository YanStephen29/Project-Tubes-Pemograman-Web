@extends('layouts.background')

@section('content')
<div class="bg-orange-400 p-2 rounded-lg shadow-lg w-1/3 text-center">
    <h1 class="text-xl font-bold text-white mt-1 mb-4">Welcome to Food For Everyone!</h1>
    <p class="text-sm text-white mb-8 mx-10">Your go-to app for a hassle-free life. We are here to help all your needs, anytime and anywhere</p>
    <div class="bg-white m-2 p-6 rounded-lg shadow-md flex flex-col items-center justify-center border-2">
        <form action="{{route('login')}}" method="POST">
            @csrf
            <input type="email" name="email" placeholder="Email" class="block w-80 h-12 p-6 mb-4 border-2 mt-2 focus:border-orange-500 focus:ring-orange-500">
            <input type="password" name="password" placeholder="Password" class="block w-80 h-12 p-5 ml- mb-4 border-2 mt-2 focus:border-orange-500 focus:ring-orange-500">            <div class="flex flex-col items-center">
                <a href="{{route('register')}}" class="text-orange-500 hover:underline mb-6">Forgot password?</a>
                <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white py-4 rounded-full w-auto px-20 shadow-lg">Login</button>
            </div>
        </form>
        <p class="text-sm text-gray-600 mt-4">Don't have an account? <a href="{{ route('register.role') }}" class="text-orange-500 hover:underline">Sign Up</a></p>
        
        <div class="flex items-center justify-center mt-6">
            <div class="border-t border-gray-300 flex-grow mr-3"></div>
            <div class="text-gray-600">Sign in with</div>
            <div class="border-t border-gray-300 flex-grow ml-3"></div>
        </div>
        <div class="flex justify-center gap-4 mt-4">
            <a href="#" class="flex items-center px-4 py-2 space-x-2 rounded-full border border-gray-300 shadow-sm text-gray-600 hover:text-gray-900 hover:bg-gray-100">
                <img src="https://upload.wikimedia.org/wikipedia/commons/c/c2/F_icon.svg" alt="Facebook" class="h-6 w-6">
                <span>Facebook</span>
            </a>
            <a href="#" class="flex items-center px-4 py-2 space-x-2 rounded-full border border-gray-300 shadow-sm text-gray-600 hover:text-gray-900 hover:bg-gray-100">
                <img src="{{ asset('images/google.png') }}" alt="Google" class="h-6 w-6">
                <span>Google</span>
            </a>
        </div>
    </div>
</div>
@endsection

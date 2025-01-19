@extends('layouts.background')

@section('content')
<div class="max-w-xl w-full mx-auto p-2 bg-orange-400 rounded-lg shadow-lg text-center">
    <h1 class="text-xl font-bold text-white mt-1 mb-4">Lets Regist Your Restaurant!!</h1>
    <div class="bg-white p-10 rounded-lg shadow-md">
        <form method="POST" action="{{ route('register.form') }}">
            @csrf
            <input type="hidden" name="role" value="restaurant">

            <div class="mb-3">
                <input type="text" name="name" placeholder="Restaurant Name" required class="w-full p-3 border border-gray-300 rounded" required>
            </div>
            <div class="mb-3">
                <input type="email" name="email" placeholder="Email" required class="w-full p-3 border border-gray-300 rounded" required>
            </div>
            <div class="mb-3">
                <input type="text" name="phone" placeholder="Phone Number" required class="w-full p-3 border border-gray-300 rounded" required>
            </div>
            <div class="mb-3">
                <textarea name="address" placeholder="Address" required class="w-full p-3 border border-gray-300 rounded" required></textarea>
            </div>
            <div class="mb-3">
                <label for="categories" class="block text-gray-700 text-sm font-bold mb-2">Select Categories</label>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                    @foreach ($categories as $category)
                    <div class="flex items-center">
                        <input type="checkbox" id="category{{ $category->id }}" name="categories[]" value="{{ $category->id }}" class="form-checkbox h-5 w-5 text-orange-600">
                        <label for="category{{ $category->id }}" class="ml-2 text-gray-700">{{ $category->name }}</label>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="mb-3">
                <input type="password" name="password" required placeholder="Password" class="w-full p-3 border border-gray-300 rounded" required>
            </div>
            <div class="mb-3">
                <input type="password" name="password_confirmation" required placeholder="Confirm Password" class="w-full p-3 border border-gray-300 rounded" required>
            </div>

            <button type="submit" class="w-full py-3 bg-orange-500 hover:bg-orange-600 text-white rounded-full shadow font-bold mb-6 transition duration-300">Register</button>
        </form>
    </div>
</div>
@endsection


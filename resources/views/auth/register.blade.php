@extends('layouts.app')

@section('content')
    <div class="min-h-screen flex flex-col justify-center bg-cover bg-center relative"
        style="background-image: url('{{ asset('images/dashboard-bg-img.png') }}')">
        <div class="absolute inset-0 bg-gray-800/50"></div>

        <div class="flex-grow flex items-center justify-center relative z-10">
            <div class="w-full max-w-md px-6 py-8 bg-white rounded-lg shadow-lg">
                <h2 class="text-2xl font-semibold text-center mb-2">Create Your Account</h2>
                <p class="text-center text-gray-600 mb-6">Join us and start preserving memories</p>

                <form method="POST" action="{{ url('/register') }}" id="register-form">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" required placeholder="John Doe"
                            class="w-full rounded-full border border-gray-300 px-4 py-2 focus:ring focus:ring-blue-200 focus:outline-none">
                        @error('name') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                        <input type="email" name="email" value="{{ old('email') }}" required placeholder="john@example.com"
                            class="w-full rounded-full border border-gray-300 px-4 py-2 focus:ring focus:ring-blue-200 focus:outline-none">
                        @error('email') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <input type="password" name="password" required placeholder="Password"
                            class="w-full rounded-full border border-gray-300 px-4 py-2 focus:ring focus:ring-blue-200 focus:outline-none">
                        @error('password') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                        <input type="password" name="password_confirmation" required placeholder="Confirm Password"
                            class="w-full rounded-full border border-gray-300 px-4 py-2 focus:ring focus:ring-blue-200 focus:outline-none">
                    </div>

                    <button type="submit" class="w-full bg-[#FCDA98] hover:bg-[#ffc248] py-2 rounded-md transition cursor-pointer">
                        Register
                    </button>
                </form>

                <p class="mt-4 text-center text-sm text-gray-600">
                    Already have an account?
                    <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Login</a>
                </p>
            </div>
        </div>
    </div>
@endsection
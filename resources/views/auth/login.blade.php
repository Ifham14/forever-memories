@extends('layouts.app')

@section('content')
    <div class="min-h-screen flex flex-col justify-between bg-cover bg-center relative"
        style="background-image: url('{{ asset('images/dashboard-bg-img.png') }}')">
        <div class="absolute inset-0 bg-gray-800/50"></div>
        <div class="flex-grow flex items-center justify-center relative z-10">
            <div class="w-full max-w-md px-6 py-8 bg-white rounded-lg shadow-lg">
                <h2 class="text-2xl font-semibold text-center mb-2">Welcome Back!</h2>
                <p class="text-center text-gray-600 mb-4">Enter your credentials to access your account</p>
                <div class="border-t border-gray-200 mb-4"></div>
                <p class="text-center text-gray-500 mb-6">Continue with email address</p>
                <form method="POST" action="{{ url('login') }}" id="login-form">
                    @csrf
                    <div class="mb-4">
                        <div class="flex items-center border border-gray-300 rounded-md px-3 py-2">
                            <svg class="w-5 h-5 text-gray-400 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M2 4a2 2 0 012-2h16a2 2 0 012 2v16a2 2 0 01-2 2H4a2 2 0 01-2-2V4zm2 0v.01L12 13 20 4.01V4H4zm0 2.83V20h16V6.83l-8 7.14-8-7.14z"/>
                            </svg>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required class="w-full focus:outline-none" placeholder="Email address">
                        </div>
                        @error('email')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <div class="flex items-center border border-gray-300 rounded-md px-3 py-2">
                            <svg class="w-5 h-5 text-gray-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v2H5a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-1V6a4 4 0 00-4-4zM8 6a2 2 0 114 0v2H8V6z" clip-rule="evenodd"/>
                            </svg>
                            <input type="password" id="password" name="password" required class="w-full focus:outline-none" placeholder="Password">
                        </div>
                        @error('password')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between mb-4">
                        <label class="flex items-center text-gray-700">
                            <input type="checkbox" name="remember" class="mr-2"> Remember me
                        </label>
                        <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:underline">Forgot password?</a>
                    </div>

                    <button type="submit" class="w-full bg-[#FCDA98] hover:bg-[#ffc248] py-2 rounded-md  transition cursor-pointer"> Login </button>
                </form>
            </div>
        </div>
        <p class="text-white text-center text-sm mt-6 z-10 relative">
            &copy;2025 Forever Memories. All rights reserved | Designed and Developed by Futuristic Web Studios
        </p> 
    </div>
@endsection
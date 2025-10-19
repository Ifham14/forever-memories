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

                    <!-- <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <input type="password" name="password" required placeholder="Password"
                            class="w-full rounded-full border border-gray-300 px-4 py-2 focus:ring focus:ring-blue-200 focus:outline-none">
                        @error('password') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div> -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <div class="relative">
                            <input type="password" name="password" id="password" required placeholder="Password"
                                class="w-full rounded-full border border-gray-300 px-4 py-2 pr-10 focus:ring focus:ring-blue-200 focus:outline-none">
                            <!-- Toggle icon -->
                            <button type="button" onclick="toggleVisibility('password', 'togglePasswordIcon')" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700">
                                <svg id="togglePasswordIcon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.522 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.478 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                        @error('password') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                        <input type="password" name="password_confirmation" required placeholder="Confirm Password" class="w-full rounded-full border border-gray-300 px-4 py-2 focus:ring focus:ring-blue-200 focus:outline-none">
                    </div> -->

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                        <div class="relative">
                            <input type="password" name="password_confirmation" id="password_confirmation" required placeholder="Confirm Password"
                                class="w-full rounded-full border border-gray-300 px-4 py-2 pr-10 focus:ring focus:ring-blue-200 focus:outline-none">
                            <!-- Toggle icon -->
                            <button type="button" onclick="toggleVisibility('password_confirmation', 'toggleConfirmIcon')" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700">
                                <svg id="toggleConfirmIcon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.522 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.478 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
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


    <script>
    function toggleVisibility(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);

        if (input.type === "password") {
            input.type = "text";
            icon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.965 9.965 0 012.479-4.095M3 3l18 18" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M17.94 17.94A9.965 9.965 0 0021 12c-1.274-4.057-5.064-7-9.542-7a9.963 9.963 0 00-4.95 1.256M9.88 9.88A3 3 0 0112 15a3 3 0 002.12-.88" />
            `;
        } else {
            input.type = "password";
            icon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M2.458 12C3.732 7.943 7.522 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.478 0-8.268-2.943-9.542-7z"/>
            `;
        }
    }
</script>



@endsection
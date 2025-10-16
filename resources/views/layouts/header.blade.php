<header class="bg-white shadow p-4">
    <div class="container mx-auto flex items-center justify-between">
        <!-- Left: Company logo/text -->
        <div class="flex items-center space-x-2">
            <span class="text-2xl font-bold text-gray-800 select-none cursor-default">Forever Memories</span>
        </div>

        <!-- Center: Navigation -->
        <nav class="flex space-x-8">
            @php
                $currentRoute = request()->route()->getName();
            @endphp

            <a href="{{ url('/dashboard') }}" class="flex items-center space-x-1 border-b-2 pb-1 {{ $currentRoute === 'dashboard' ? 'border-blue-600 font-semibold text-blue-600' : 'border-transparent hover:text-blue-600 hover:border-blue-600' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M13 5v6h6M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0h6" />
                </svg>
                <span>Obituary</span>
            </a>

            <a href="{{ url('/profile') }}"
               class="flex items-center space-x-1 border-b-2 pb-1 {{ $currentRoute === 'profile' ? 'border-blue-600 font-semibold text-blue-600' : 'border-transparent hover:text-blue-600 hover:border-blue-600' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A12.011 12.011 0 0112 15c2.21 0 4.28.655 6.01 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zM19.071 19.071a9 9 0 10-14.142 0" />
                </svg>
                <span>Profile & Settings</span>
            </a>
        </nav>

        <div class="flex items-center space-x-4">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center space-x-2 px-4 py-2 rounded-md bg-[#FCDA98] hover:bg-[#ffc248] transition cursor-pointer">
                    <span class="text-sm">Logout</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H7a2 2 0 01-2-2V7a2 2 0 012-2h4a2 2 0 012 2v1" />
                    </svg>
                </button>
            </form>

            <div class="flex items-center space-x-3">
                <img src="{{ auth()->user()->profile_photo_url ?? 'https://avatar.iran.liara.run/public/boy' }}" alt="Profile Picture" class="w-10 h-10 rounded-full object-cover border border-gray-300" />
                <div class="text-sm">
                    <p class="font-semibold text-gray-800">John Doe</p>
                    <p class="text-gray-500">abc@email.com</p>
                </div>
            </div>
        </div>
    </div>
</header>

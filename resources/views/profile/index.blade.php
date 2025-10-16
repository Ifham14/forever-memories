@extends('layouts.app')

@section('content')
    <div class="min-h-screen flex flex-col justify-between bg-cover bg-center relative"
        style="background-image: url('{{ asset('images/dashboard-bg-img.png') }}')">
        <div class="absolute inset-0 bg-gray-800/50"></div>

        <div class="flex-grow flex items-center justify-center relative z-10 py-20">
            <div class="w-full max-w-5xl bg-white rounded-lg shadow-lg p-10 space-y-6">
                <h1 class="text-2xl font-bold text-gray-800">Profile & Setting</h1>

                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-gray-800">Personal Info</h2>
                    <a href="{{ route('profile.edit') }}" class="inline-flex items-center px-4 py-2 text-sm rounded-full transition bg-[#FCDA98] hover:bg-[#ffc248]">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536M9 13l6.536-6.536a2 2 0 112.828 2.828L11.828 15.828A4 4 0 018 17H5v-3a4 4 0 011.172-2.828L15.232 5.232z"/>
                        </svg>
                        Edit Profile
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6 text-sm text-gray-800">
                    <div>
                        <div class="font-medium text-gray-500 mb-1">Full Name</div>
                        <div>{{ Auth::user()->name ?? "N/A" }}</div>
                    </div>
                    <div>
                        <div class="font-medium text-gray-500 mb-1">Email Address</div>
                        <div>{{ Auth::user()->email ?? "N/A" }}</div>
                    </div>
                    <div>
                        <div class="font-medium text-gray-500 mb-1">Address</div>
                        <div>{{ Auth::user()->address ?? "N/A" }}</div>
                    </div>
                    <div>
                        <div class="font-medium text-gray-500 mb-1">Phone Number</div>
                        <div>{{ Auth::user()->phone ?? "N/A" }}</div>
                    </div>
                    <div>
                        <div class="font-medium text-gray-500 mb-1">Guardian Email</div>
                        <div>{{ Auth::user()->guardian_email ?? "N/A" }}</div>
                    </div>
                    <div class="    ">
                        <div class="font-medium text-gray-500 mb-1">Bio</div>
                        <div class="text-gray-700 leading-relaxed">
                           {{ Auth::user()->bio ?? "N/A" }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

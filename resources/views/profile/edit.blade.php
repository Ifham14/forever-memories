@extends('layouts.app')

@section('content')
    <div class="min-h-screen flex flex-col justify-between bg-cover bg-center relative"
        style="background-image: url('{{ asset('images/dashboard-bg-img.png') }}')">
        <div class="absolute inset-0 bg-gray-800/50"></div>
        @if ($errors->any())
            <div class="alert alert-error bg-red-100 text-red-800 p-4 rounded-lg">
                <ul class="list-disc pl-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="flex-grow flex items-center justify-center relative z-10 py-20">
            <form action="{{ route('profile.update') }}" method="POST" class="w-full max-w-5xl bg-white rounded-lg shadow-lg p-10 space-y-6">
                @csrf
                @method('PUT')
                @if (session('success'))
                    <div class="alert alert-success bg-green-100 text-green-800 p-4 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif

                <h1 class="text-2xl font-bold text-gray-800">Edit Profile</h1>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm text-gray-800">
                    <div>
                        <label class="block text-gray-700 font-medium mb-1">Full Name</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}"
                            class="w-full rounded-full border border-gray-300 px-4 py-2 focus:ring focus:ring-blue-200 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium mb-1">Email Address</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}"
                            class="w-full rounded-full border border-gray-300 px-4 py-2 focus:ring focus:ring-blue-200 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium mb-1">Address</label>
                        <input type="text" name="address" value="{{ old('address', $user->address) }}"
                            class="w-full rounded-full border border-gray-300 px-4 py-2 focus:ring focus:ring-blue-200 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium mb-1">Phone Number</label>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                            class="w-full rounded-full border border-gray-300 px-4 py-2 focus:ring focus:ring-blue-200 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium mb-1">Guardian Email</label>
                        <input type="email" name="guardian_email" value="{{ old('guardian_email', $user->guardian_email) }}"
                            class="w-full rounded-full border border-gray-300 px-4 py-2 focus:ring focus:ring-blue-200 focus:outline-none">
                    </div>
                    <div class="">
                        <label class="block text-gray-700 font-medium mb-1">Bio</label>
                        <textarea name="bio" rows="5" class="w-full rounded-xl border border-gray-300 px-4 py-2 resize-none focus:ring focus:ring-blue-200 focus:outline-none">{{ old('bio', $user->bio) }}</textarea>
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit" class="inline-flex items-center px-5 py-2 rounded-full bg-[#FCDA98] hover:bg-[#ffc248] transition text-sm">
                        Save Changes
                    </button>
                    <a href="{{ route('profile') }}" class="inline-flex items-center px-5 py-2 rounded-full bg-gray-200 hover:bg-gray-300 text-gray-800 transition text-sm">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('content')
    <div class="p-10">
        <div class="w-full" style="margin-bottom:40px">
            <div class="max-w-7xl mx-auto">
                <a href="{{ route('admin.dashboard') }}"
                class="inline-flex items-center text-gray-600 hover:text-gray-800 text-sm font-medium">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 19l-7-7 7-7"/>
                    </svg>
                    Back to Dashboard
                </a>
            </div>
        </div>

        <div class=" bg-white rounded-xl shadow p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">User Details</h3>
            <div class="grid grid-cols-2 gap-x-8 gap-y-4 text-gray-700">
                <div>
                    <span class="font-bold">Name: </span>{{ $user->name ?? 'N/A' }}
                </div>
                <div>
                    <span class="font-bold">Email: </span>{{ $user->email ?? 'N/A' }}
                </div>
                <div>
                    <span class="font-bold">Phone: </span>{{ $user->phone ?? 'N/A' }}
                </div>
                <div>
                    <span class="font-bold">Address: </span>{{ $user->address ?? 'N/A' }}
                </div>
                <div>
                    <span class="font-bold">Guardian Email: </span>{{ $user->guardian_email ?? 'N/A' }}
                </div>
                <div>
                    <span class="font-bold">Bio: </span>{{ $user->bio ?? 'N/A' }}
                </div>
            </div>
        </div>

        <div class="w-full flex justify-center px-4 py-12 bg-base-200">
            <div class="w-full max-w-md bg-white rounded-xl shadow p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Change Password</h3>

                <form method="POST" action="{{ route('admin.users.updatePassword', $user) }}" class="space-y-5">
                    @csrf
                    @method('PUT')
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                            New Password
                        </label>
                        <div class="relative">
                            <input id="password" name="password" type="password"
                                placeholder="Enter new password"
                                class="input input-bordered w-full pr-10"
                                required minlength="6" />
                            <button type="button" onclick="togglePassword('password', 'togglePass1')"
                                    class="absolute top-1/2 right-3 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                <svg id="togglePass1" xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5 pointer-events-none" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5 c4.477 0 8.268 2.943 9.542 7 -1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
                            Confirm Password
                        </label>
                        <div class="relative">
                            <input id="password_confirmation" name="password_confirmation" type="password"
                                placeholder="Confirm password"
                                class="input input-bordered w-full pr-10"
                                required minlength="6" />
                            <button type="button" onclick="togglePassword('password_confirmation', 'togglePass2')" class="absolute top-1/2 right-3 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                <svg id="togglePass2" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5 c4.477 0 8.268 2.943 9.542 7 -1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-full">
                        Update Password
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function togglePassword(fieldId, iconId) {
            const input = document.getElementById(fieldId);
            const icon = document.getElementById(iconId);

            if (input.type === 'password') {
                input.type = 'text';
                icon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.96 9.96 0 012.293-3.386M9.88 9.88a3 3 0 014.24 4.24M15 12a3 3 0 01-3 3m0-6a3 3 0 013 3m6.364 6.364L3.636 3.636" />
                `;
            } else {
                input.type = 'password';
                icon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                `;
            }
        }
    </script>
@endpush

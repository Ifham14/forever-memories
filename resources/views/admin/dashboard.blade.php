@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Admin Dashboard</h1>

        <!-- Logout button -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" 
                class="btn btn-sm btn-error hover:bg-red-600 text-white">
                Logout
            </button>
        </form>
    </div>

    <div class="overflow-x-auto bg-white shadow-md rounded-lg">
        <table class="table w-full">
            <thead>
                <tr class="bg-gray-100 text-gray-700">
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Joined</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $index => $user)
                    <tr class="hover">
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone ?? '—' }}</td>
                        <td>{{ $user->created_at->format('M d, Y') }}</td>
                        <td class="text-right">
                            <a href="{{ route('admin.users.show', $user) }}" 
                               class="btn btn-sm btn-outline btn-primary">
                                View
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-gray-500 py-4">
                            No users found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

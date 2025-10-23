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
                        <th>Status</th>
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
                            <td>
                                <input type="checkbox" class="toggle toggle-md toggle-success user-status-toggle" data-user-id="{{ $user->id }}" {{ $user->is_active ? 'checked' : '' }}>
                            </td>
                             <td class="text-right space-x-2">
                                <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm btn-outline btn-primary"> View </a>
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
    <div id="toast-container" class="fixed top-5 left-1/2 -translate-x-1/2 z-50 space-y-2 w-auto max-w-xs"></div>
@endsection


@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
        const toastContainer = document.getElementById('toast-container');

        function showToast(message, type = 'success') {
            const alertColor = type === 'success' ? 'alert-success' : 'alert-error';

            const toast = document.createElement('div');
            toast.className = `alert ${alertColor} text-white shadow-lg animate-fade-in transition-all duration-300`;
            toast.innerHTML = `
                <span>${message}</span>
            `;
            toastContainer.appendChild(toast);

            setTimeout(() => {
                toast.classList.add('opacity-0', '-translate-y-2');
                setTimeout(() => toast.remove(), 300);
            }, 2500);
        }

        document.querySelectorAll('.user-status-toggle').forEach(toggle => {
            toggle.addEventListener('change', function () {
                const userId = this.dataset.userId;

                fetch(`/admin/users/${userId}/toggle-active`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({})
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        showToast(
                            data.status === 'activated' 
                            ? 'User activated successfully.' 
                            : 'User deactivated.'
                        );
                    } else {
                        showToast('Something went wrong.', 'error');
                    }
                })
                .catch(() => {
                    showToast('Server error. Please try again.', 'error');
                });
            });
        });
    });
    </script>
@endpush
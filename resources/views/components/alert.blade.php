@if(session('message'))
    <div 
        id="alert" 
        class="fixed top-4 left-1/2 transform -translate-x-1/2 z-50 max-w-md w-auto alert alert-{{ session('type', 'success') }} shadow-lg flex items-center space-x-4 opacity-0 pointer-events-none transition-opacity duration-500"
        role="alert"
        aria-live="assertive"
        aria-atomic="true"
    >
        @if(session('type', 'success') === 'success')
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" >
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
        @elseif(session('type') === 'error')
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6 text-red-500" fill="none" viewBox="0 0 24 24" >
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        @else
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" >
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01" />
            </svg>
        @endif

        <span class="flex-1">{{ session('message') }}</span>

        <button id="alert-close" class="btn btn-sm btn-ghost btn-circle">
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current h-4 w-4" fill="none" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <script>
        window.addEventListener('DOMContentLoaded', () => {
            const alertBox = document.getElementById('alert');
            const closeBtn = document.getElementById('alert-close');

            if (!alertBox) return;

            // Fade in
            setTimeout(() => {
                alertBox.classList.remove('opacity-0', 'pointer-events-none');
                alertBox.classList.add('opacity-100');
            }, 10); 

            // Auto fade out after 3 seconds
            const timer = setTimeout(() => {
                alertBox.classList.remove('opacity-100');
                alertBox.classList.add('opacity-0', 'pointer-events-none');
            }, 3000);

            // Remove alert after fade out
            alertBox.addEventListener('transitionend', () => {
                if (alertBox.classList.contains('opacity-0')) {
                    alertBox.remove();
                }
            });

            // Close button click handler
            closeBtn.addEventListener('click', () => {
                clearTimeout(timer);
                alertBox.classList.remove('opacity-100');
                alertBox.classList.add('opacity-0', 'pointer-events-none');
            });
        });
    </script>
@endif

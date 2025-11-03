@extends('layouts.app')

@section('content')
    <div class="min-h-screen flex flex-col justify-between bg-cover bg-center relative"
        style="background-image: url('{{ asset('images/dashboard-bg-img.png') }}')">
        <div class="absolute inset-0 bg-gray-800/50"></div>

        <div class="flex-grow flex items-center justify-center relative z-10 py-20">
            <form action="{{ route('notebook.store') }}" enctype="multipart/form-data" method="POST" class="w-full max-w-5xl bg-white rounded-lg shadow-lg p-10 space-y-6">
                @csrf

                {{-- Flash & Validation Messages --}}
                @if ($errors->any())
                    <div id="errorAlert" class="alert alert-error text-white bg-red-500 p-4 rounded mb-4">
                        <ul class="list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('success'))
                    <div id="successAlert" class="alert alert-success text-white bg-green-500 p-4 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div id="failAlert" class="alert alert-error text-white bg-red-500 p-4 rounded mb-4">
                        {{ session('error') }}
                    </div>
                @endif

                <h1 class="text-2xl font-bold text-gray-800">Create Notebook</h1>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Title --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Title <span class="text-red-500">*</span></label>
                        <input type="text" name="title" placeholder="Enter title"
                            class="w-full rounded-full border border-gray-300 px-4 py-2 focus:ring focus:ring-blue-200 focus:outline-none required">
                    </div>

                    {{-- Date --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Date <span class="text-red-500">*</span></label>
                        <input type="date" name="date"
                            class="w-full rounded-full border border-gray-300 px-4 py-2 focus:ring focus:ring-blue-200 focus:outline-none">
                    </div>

                    {{-- Story --}}
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Story <span class="text-red-500">*</span></label>
                        <textarea name="story" rows="6" placeholder="Write your notebook entry..."
                            class="w-full rounded-2xl border border-gray-300 px-4 py-2 focus:ring focus:ring-blue-200 focus:outline-none resize-none"></textarea>
                    </div>
                </div>

                {{-- ===========================
                     ORDER OF SERVICE (Commented)
                ============================ --}}
                {{--
                <div class="mt-10">
                    <h2 class="text-lg font-bold text-gray-800 mb-4">Order of Service</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach ([
                            'processional' => 'Processional',
                            'life_reflection' => 'Reflection',
                            'song_selection' => 'Music / Inspiration',
                            'life_scriptures' => 'Quotes / Scriptures',
                            'prayer' => 'Prayer / Thoughts',
                            'resolution' => 'Resolution / Goals',
                            'acknowledgment' => 'Acknowledgment',
                            'expression' => 'Expression',
                            'invitation_of_discipleship' => 'Reminders / Lessons',
                            'recessional' => 'Recessional'
                        ] as $name => $label)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">{{ $label }}</label>
                                <input type="text" name="{{ $name }}" class="w-full rounded-full border border-gray-300 px-4 py-2">
                            </div>
                        @endforeach
                    </div>
                </div>
                --}}

                {{-- ===========================
                     ADDITIONAL NOTES (Commented)
                ============================ --}}
                {{--
                <div class="mt-10">
                    <h2 class="text-lg font-bold text-gray-800 mb-4">Additional Notes</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Mentions</label>
                            <input type="text" name="honorary_pallbearers" placeholder="Enter mentions"
                                class="w-full rounded-full border border-gray-300 px-4 py-2 focus:ring focus:ring-blue-200 focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Place / Event</label>
                            <input type="text" name="interment" placeholder="Enter place or event"
                                class="w-full rounded-full border border-gray-300 px-4 py-2 focus:ring focus:ring-blue-200 focus:outline-none">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Gratitude Notes</label>
                            <textarea name="grateful_hearts" rows="6" placeholder="Write your gratitude here..."
                                class="w-full rounded-2xl border border-gray-300 px-4 py-2 focus:ring focus:ring-blue-200 focus:outline-none resize-none"></textarea>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Final Notes</label>
                            <input type="text" name="final_arrangement_entrusted_to" placeholder="Enter final notes"
                                class="w-full rounded-full border border-gray-300 px-4 py-2 focus:ring focus:ring-blue-200 focus:outline-none">
                        </div>
                    </div>
                </div>
                --}}

                {{-- Upload Images --}}
                <div class="mt-10">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Upload Images</label>
                    <input type="file" name="images[]" multiple
                        class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring focus:ring-blue-200 focus:outline-none">
                </div>

                <div class="mt-8">
                    <button type="submit"
                        class="bg-[#FCDA98] hover:bg-[#ffc248] px-5 py-2 rounded cursor-pointer">Save Notebook</button>
                    <a href="{{ route('notebook.index') }}"
                        class="ml-4 text-sm text-gray-600 hover:underline cursor-pointer">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    @section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('#errorAlert, #successAlert, #failAlert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.transition = 'opacity 0.6s ease';
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 600);
                }, 4000); // fades after 4 seconds
            });
        });
    </script>
    @endsection


@endsection

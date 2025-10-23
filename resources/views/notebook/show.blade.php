@extends('layouts.app')

@section('content')
    <div class="min-h-screen flex flex-col justify-between bg-cover bg-center relative"
        style="background-image: url('{{ asset('images/dashboard-bg-img.png') }}')">
        <div class="absolute inset-0 bg-gray-800/50"></div>

        <div class="flex-grow flex items-center justify-center relative z-10 py-20">
            <div class="w-full max-w-5xl bg-white rounded-lg shadow-lg p-15 space-y-6">
                <h1 class="text-2xl font-bold text-gray-800">{{ $notebook->title }}</h1>

                <div class="mt-4 text-sm text-gray-600 flex items-center space-x-4">
                    <span class="inline-block mt-1 bg-blue-100 text-blue-800 text-xs px-3 py-1 rounded-full">{{ $notebook->status ?? 'Draft' }}</span>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 00-1-1H6zm0 2h8v1H6V4z"/>
                        </svg>
                        <span>{{ \Carbon\Carbon::parse($notebook->date)->format('F j, Y') }}</span>
                    </div>
                </div>

                <p class="text-sm text-gray-700 leading-relaxed">
                    {{ $notebook->story }}
                </p>

                <div>
                    <h2 class="text-lg font-bold text-gray-800 mb-2">Photos</h2>
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
                        @forelse ($notebook->images as $image)
                            <div class="overflow-hidden rounded-lg border border-gray-200">
                                <img src="{{ asset('storage/' . $image->image_path) }}" alt="Notebook Image" class="w-full h-auto object-cover">
                            </div>
                        @empty
                            <p class="text-sm text-gray-500">No photos uploaded.</p>
                        @endforelse
                    </div>
                </div>

                <div>
                    <h2 class="text-lg font-bold text-gray-800 mb-2">Sections</h2>
                    @php
                        $sections = [
                            'introduction' => 'Introduction',
                            'chapter_1' => 'Chapter 1',
                            'chapter_2' => 'Chapter 2',
                            'chapter_3' => 'Chapter 3',
                            'conclusion' => 'Conclusion',
                        ];
                    @endphp

                    <div class="space-y-5 text-sm text-gray-700">
                        @foreach ($sections as $field => $label)
                            <div class="flex items-start justify-between gap-4">
                                <div class="w-1/3 font-semibold">{{ $label }}</div>
                                <div class="w-2/3 font-medium">{{ $notebook->$field ?? 'Not Specified' }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div>
                    <h2 class="text-lg font-bold text-gray-800 mb-2">Acknowledgments</h2>
                    @php
                        $acknowledgments = [
                            'author' => 'Author',
                            'editor' => 'Editor',
                            'publisher' => 'Publisher',
                            'contributors' => 'Contributors',
                        ];
                    @endphp

                    <div class="space-y-5 text-sm text-gray-700">
                        @foreach ($acknowledgments as $field => $label)
                            <div class="flex items-start justify-between gap-4">
                                <div class="w-1/3 font-semibold">{{ $label }}</div>
                                <div class="w-2/3 font-medium">{{ $notebook->$field ?? 'Not Specified' }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <a href="{{ url('/dashboard') }}" class="inline-flex items-center gap-2 px-5 py-2 mt-20 rounded-md transition bg-[#FCDA98] hover:bg-[#ffc248]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                    Back to List
                </a>
            </div>
        </div>
    </div>
@endsection

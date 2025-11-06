@extends('layouts.app')

@section('content')
    <div class="min-h-screen flex flex-col justify-between bg-cover bg-center relative"
         style="background-image: url('{{ asset('images/dashboard-bg-img.png') }}')">
        <div class="absolute inset-0 bg-gray-800/50"></div>
        
        <div class="flex-grow flex items-center justify-center relative z-10 px-2 py-20">
            <div class="w-full max-w-5xl bg-white rounded-lg shadow-lg p-6 space-y-6">
                <div class="flex justify-between items-center">
                    <h2 class="text-2xl font-semibold text-gray-800">Obituary</h2>
                    <a href="{{ route('journey.create') }}" class="flex text-sm items-center bg-gray-200 text-gray-800 px-4 py-2 rounded-full hover:bg-gray-300 transition cursor-pointer">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        Write Your Obituary
                    </a>
                </div>
                <div class="space-y-4">
                    <div class="space-y-4">
                        @forelse ($journeys as $journey)
                            <div class="rounded-lg p-4 shadow-[0_4px_12px_rgba(0,0,0,0.1)] bg-white transition hover:shadow-[0_6px_16px_rgba(0,0,0,0.15)]">
                                <!-- <div class="flex justify-between items-center">
                                    <h3 class="text-lg font-semibold text-gray-800">{{ $journey->title }}</h3>
                                    <div class="flex space-x-2">
                                        <a href="{{ route('journey.edit', $journey->id) }}" class="flex items-center space-x-1 border border-gray-300 text-gray-700 rounded-full px-3 py-1.5 text-sm hover:bg-gray-100 transition">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M17.414 2.586a2 2 0 010 2.828l-10 10A2 2 0 016 16H4a1 1 0 01-1-1v-2a2 2 0 01.586-1.414l10-10a2 2 0 012.828 0zM5 14h1.586L15 5.586 13.414 4 5 12.414V14z"/>
                                            </svg>
                                            <span>Edit</span>
                                        </a>
                                        <a href="{{ route('journey.show', $journey->id) }}" class="flex items-center space-x-1 border border-gray-300 text-gray-700 rounded-full px-3 py-1.5 text-sm hover:bg-gray-100 transition">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 3C5 3 1.73 7.11 1 10c.73 2.89 4 7 9 7s8.27-4.11 9-7c-.73-2.89-4-7-9-7zm0 12a5 5 0 110-10 5 5 0 010 10zm0-8a3 3 0 100 6 3 3 0 000-6z" />
                                            </svg>
                                            <span>View</span>
                                        </a>
                                    </div>
                                </div> -->
                                <div class="flex justify-between items-center">
                                    <h3 class="text-lg font-semibold text-gray-800">{{ $journey->title }}</h3>
                                    <div class="flex items-center space-x-2">
                                        {{-- Edit Button --}}
                                        <a href="{{ route('journey.edit', $journey->id) }}"
                                        class="inline-flex items-center space-x-1 border border-gray-300 text-gray-700 rounded-full px-3 py-1.5 text-sm hover:bg-gray-100 transition">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M17.414 2.586a2 2 0 010 2.828l-10 10A2 2 0 016 16H4a1 1 0 01-1-1v-2a2 2 0 01.586-1.414l10-10a2 2 0 012.828 0zM5 14h1.586L15 5.586 13.414 4 5 12.414V14z"/>
                                            </svg>
                                            <span>Edit</span>
                                        </a>

                                        {{-- View Button --}}
                                        <a href="{{ route('journey.show', $journey->id) }}"
                                        class="inline-flex items-center space-x-1 border border-gray-300 text-gray-700 rounded-full px-3 py-1.5 text-sm hover:bg-gray-100 transition">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 3C5 3 1.73 7.11 1 10c.73 2.89 4 7 9 7s8.27-4.11 9-7c-.73-2.89-4-7-9-7zm0 12a5 5 0 110-10 5 5 0 010 10zm0-8a3 3 0 100 6 3 3 0 000-6z" />
                                            </svg>
                                            <span>View</span>
                                        </a>

                                        {{-- Delete Button (JS Trigger + hidden form) --}}
                                        <a href="#" 
                                        onclick="event.preventDefault(); if (confirm('Are you sure you want to delete this obituary?')) document.getElementById('delete-form-{{ $journey->id }}').submit();"
                                        class="inline-flex items-center space-x-1 border border-gray-300 text-gray-700 rounded-full px-3 py-1.5 text-sm hover:bg-gray-100 transition">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M6 8a1 1 0 011 1v6a1 1 0 11-2 0V9a1 1 0 011-1zm4 0a1 1 0 011 1v6a1 1 0 11-2 0V9a1 1 0 011-1zm4-3a1 1 0 00-1-1h-2l-1-1H8l-1 1H5a1 1 0 00-1 1v1h10V5z" clip-rule="evenodd" />
                                                <path d="M4 6h12l-1 12H5L4 6z" />
                                            </svg>
                                            <span>Delete</span>
                                        </a>

                                        {{-- Hidden Form --}}
                                        <form id="delete-form-{{ $journey->id }}" 
                                            action="{{ route('journey.destroy', $journey->id) }}" 
                                            method="POST" 
                                            class="hidden">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                </div>
                                <div class="flex items-center text-sm text-gray-600 mt-2 space-x-4">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm0 2h12v10H4V5zm3 2a1 1 0 100 2 1 1 0 000-2zm2 1l2 2.5L13 8l3 4H4l3-4z"/>
                                        </svg>
                                        <span>{{ $journey->images->count() }} photos</span>
                                    </div>
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 00-1-1H6zm0 2h8v1H6V4z"/>
                                        </svg>
                                        <span>{{ \Carbon\Carbon::parse($journey->date)->format('F j, Y') }}</span>
                                    </div>
                                </div>
                                <p class="text-sm text-gray-700 mt-2 line-clamp-2">
                                    {{ \Illuminate\Support\Str::limit($journey->story, 120) }}
                                </p>
                            </div>
                        @empty
                            <div class="flex flex-col items-center justify-center py-16 text-center text-gray-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 mb-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6h6v6m2 4H7a2 2 0 01-2-2V7a2 2 0 012-2h2l2-2h2l2 2h2a2 2 0 012 2v12a2 2 0 01-2 2z" />
                                </svg>
                                <h3 class="text-xl font-semibold mb-2">No Obituaries Yet</h3>
                                <p class="mb-4">You haven't written any obituary journeys yet. Start by sharing a memory or tribute.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
                <div class="flex justify-center mt-6">
                    {{ $journeys->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

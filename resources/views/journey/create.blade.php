@extends('layouts.app')

@section('content')
    <div class="min-h-screen flex flex-col justify-between bg-cover bg-center relative"
        style="background-image: url('{{ asset('images/dashboard-bg-img.png') }}')">
        <div class="absolute inset-0 bg-gray-800/50"></div>

        <div class="flex-grow flex items-center justify-center relative z-10 py-20">
            <form action="{{ route('journey.store') }}" enctype="multipart/form-data" method="POST" class="w-full max-w-5xl bg-white rounded-lg shadow-lg p-10 space-y-6">
                @csrf

                <h1 class="text-2xl font-bold text-gray-800">Create Journey</h1>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Title <span class="text-red-500">*</span></label>
                        <input type="text" name="title" placeholder="Enter title" class="w-full rounded-full border border-gray-300 px-4 py-2 focus:ring focus:ring-blue-200 focus:outline-none required">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Date <span class="text-red-500">*</span></label>
                        <input type="date" name="date" class="w-full rounded-full border border-gray-300 px-4 py-2 focus:ring focus:ring-blue-200 focus:outline-none">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Story</label>
                        <textarea name="story" rows="6" placeholder="Write the story..." class="w-full rounded-2xl border border-gray-300 px-4 py-2 focus:ring focus:ring-blue-200 focus:outline-none resize-none"></textarea>
                    </div>
                </div>
                <div class="mt-10">
                    <h2 class="text-lg font-bold text-gray-800 mb-4">Order of Service</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach ([
                            'processional' => 'Processional',
                            'life_reflection' => "Life's Reflection",
                            'song_selection' => 'Song Selection',
                            'life_scriptures' => 'Life Scriptures (Old and New Testament)',
                            'prayer' => 'Prayer',
                            'resolution' => 'Resolution',
                            'acknowledgment' => 'Acknowledgment',
                            'expression' => 'Expressions',
                            'invitation_of_discipleship' => 'Invitation to Discipleship',
                            'recessional' => 'Recessional'
                        ] as $name => $label)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">{{ $label }}</label>
                                <input type="text" name="{{ $name }}" class="w-full rounded-full border border-gray-300 px-4 py-2">
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="mt-10">
                    <h2 class="text-lg font-bold text-gray-800 mb-4">Order of Service</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Honaray Pallbearers</label>
                            <input type="text" name="honorary_pallbearers" placeholder="Enter Honorary Pallbearers" class="w-full rounded-full border border-gray-300 px-4 py-2 focus:ring focus:ring-blue-200 focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Interment</label>
                            <input type="text" name="interment" placeholder="Enter Interment" class="w-full rounded-full border border-gray-300 px-4 py-2 focus:ring focus:ring-blue-200 focus:outline-none">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Grateful Hearts of Gratitude</label>
                            <textarea name="grateful_hearts" rows="6" placeholder="Write the gratitude here..." class="w-full rounded-2xl border border-gray-300 px-4 py-2 focus:ring focus:ring-blue-200 focus:outline-none resize-none"></textarea>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Interment</label>
                            <input type="text" name="final_arrangement_entrusted_to" placeholder="Enter Final Arrangements Entrusted To" class="w-full rounded-full border border-gray-300 px-4 py-2 focus:ring focus:ring-blue-200 focus:outline-none">
                        </div>
                    </div>
                </div>

                <div class="mt-10">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Upload Images</label>
                    <input type="file" name="images[]" multiple class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring focus:ring-blue-200 focus:outline-none">
                </div>

                <button type="submit"
                    class="w-full bg-[#FCDA98] hover:bg-[#ffc248] py-2 rounded-md transition cursor-pointer">
                    Save Journey
                </button>
                
            </form>
        </div>
    </div>
@endsection
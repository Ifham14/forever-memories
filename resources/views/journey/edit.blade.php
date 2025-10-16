@extends('layouts.app')

@section('content')
    <div class="min-h-screen flex flex-col justify-between bg-cover bg-center relative"
        style="background-image: url('{{ asset('images/dashboard-bg-img.png') }}')">
        <div class="absolute inset-0 bg-gray-800/50"></div>
        <div class="flex-grow flex items-center justify-center relative z-10 py-20">
            <form action="{{ route('journey.update', $journey->id) }}" method="POST" enctype="multipart/form-data" class="w-full max-w-5xl bg-white rounded-lg shadow-lg p-10 space-y-6">
                <h1 class="text-2xl font-bold mb-6 text-gray-800">Edit Journey</h1>
                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @csrf
                @method('PUT')

                <div>
                    <label class="block font-semibold mb-1 text-gray-700">Title <span class="text-red-500">*</span></label>
                    <input type="text" name="title" value="{{ old('title', $journey->title) }}" class="w-full border rounded px-3 py-2" required>
                </div>

                <div>
                    <label class="block font-semibold mb-1 text-gray-700">Date <span class="text-red-500">*</span></label>
                    <input type="date" name="date" value="{{ old('date', \Carbon\Carbon::parse($journey->date)->format('Y-m-d')) }}" class="w-full border rounded px-3 py-2" required>
                </div>

                <div>
                    <label class="block font-semibold mb-1 text-gray-700">Story</label>
                    <textarea name="story" rows="5" class="w-full border rounded px-3 py-2" required>{{ old('story', $journey->story) }}</textarea>
                </div>

                @if ($journey->images->count())
                    <div class="mt-6">
                        <label class="block font-semibold mb-2 text-gray-700">Existing Images</label>
                        <div id="existing-images" class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                            @foreach ($journey->images as $image)
                                <div class="relative border rounded overflow-hidden group">
                                    <img src="{{ asset('storage/' . $image->image_path) }}" class="w-full h-auto object-cover">
                                    
                                    <button type="button"
                                        class="absolute top-1 right-1 bg-red-600 text-white rounded-full w-6 h-6 text-sm font-bold flex items-center justify-center opacity-0 group-hover:opacity-100 transition"
                                        onclick="markImageForDeletion({{ $image->id }}, this)">
                                        &times;
                                    </button>
                                </div>
                            @endforeach
                        </div>
                        {{-- This will collect the IDs of images to delete --}}
                        <input type="hidden" name="deleted_images" id="deleted_images">
                    </div>
                @endif
                <div class="mt-6">
                    <label class="block font-semibold mb-2 text-gray-700">Upload New Images</label>
                    <input type="file" name="images[]" id="imageUpload" multiple accept="image/*" class="block w-full text-sm text-gray-700">
                    <div id="previewImages" class="grid grid-cols-2 sm:grid-cols-3 gap-4 mt-4"></div>
                </div>


                <h2 class="text-lg font-bold text-gray-800 mt-8 mb-4">Order of Service</h2>
                @php
                    $orderFields = [
                        'processional' => 'Processional',
                        'life_reflection' => "Life's Reflection",
                        'song_selection' => 'Song Collection',
                        'life_scriptures' => 'Scriptures (Old and New Testament)',
                        'prayer' => 'Prayer',
                        'resolution' => 'Resolution and Acknowledgment',
                        'acknowledgment' => 'Acknowledgment',
                        'expression' => 'Expressions',
                        'invitation_of_discipleship' => 'The Spoken Word',
                        'recessional' => 'Recessional',
                    ];
                @endphp

                @foreach ($orderFields as $field => $label)
                    <div>
                        <label class="block font-semibold mb-1 text-gray-700">{{ $label }}</label>
                        <input type="text" name="{{ $field }}" value="{{ old($field, $journey->$field) }}" class="w-full border rounded px-3 py-2">
                    </div>
                @endforeach

                <h2 class="text-lg font-bold text-gray-800 mt-8 mb-4">Appreciations</h2>
                @php
                    $appreciationFields = [
                        'honorary_pallbearers' => 'Honorary Pallbearers',
                        'grateful_hearts' => 'Grateful Hearts of Gratitude',
                        'interment' => 'Interment',
                        'final_arrangement_entrusted_to' => 'Final Arrangement Entrusted To',
                    ];
                @endphp

                @foreach ($appreciationFields as $field => $label)
                    <div>
                        <label class="block font-semibold mb-1 text-gray-700">{{ $label }}</label>
                        @if ($field === 'grateful_hearts')
                            <textarea name="{{ $field }}" rows="4" class="w-full border rounded px-3 py-2">{{ old($field, $journey->$field) }}</textarea>
                        @else
                            <input type="text" name="{{ $field }}" value="{{ old($field, $journey->$field) }}" class="w-full border rounded px-3 py-2">
                        @endif
                    </div>
                @endforeach

                <div class="mt-8">
                    <button type="submit" class="bg-[#FCDA98] hover:bg-[#ffc248] px-5 py-2 rounded cursor-pointer">Update Journey</button>
                    <a href="{{ route('dashboard') }}" class="ml-4 text-sm text-gray-600 hover:underline cursor-pointer">Cancel</a>
                </div>
            </form>
        </div>
    </div>
    <script>
        const imageUpload = document.getElementById('imageUpload');
        const previewContainer = document.getElementById('previewImages');
        const deletedImagesInput = document.getElementById('deleted_images');
        let deletedImageIds = [];

        // Handle existing image deletion
        function markImageForDeletion(imageId, button) {
            deletedImageIds.push(imageId);
            deletedImagesInput.value = deletedImageIds.join(',');
            const container = button.closest('.relative');
            container.remove();
        }

        // Handle new image preview
        imageUpload.addEventListener('change', function () {
            previewContainer.innerHTML = ''; // Clear existing previews

            Array.from(this.files).forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const imgWrapper = document.createElement('div');
                    imgWrapper.classList.add('relative', 'border', 'rounded', 'overflow-hidden', 'group');

                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.classList.add('w-full', 'h-auto', 'object-cover');

                    const deleteBtn = document.createElement('button');
                    deleteBtn.type = 'button';
                    deleteBtn.innerHTML = '&times;';
                    deleteBtn.classList.add(
                        'absolute', 'top-1', 'right-1', 'bg-red-600', 'text-white',
                        'rounded-full', 'w-6', 'h-6', 'text-sm', 'font-bold',
                        'flex', 'items-center', 'justify-center'
                    );
                    deleteBtn.addEventListener('click', () => {
                        imageUpload.files[index] = null;
                        imgWrapper.remove();
                    });

                    imgWrapper.appendChild(img);
                    imgWrapper.appendChild(deleteBtn);
                    previewContainer.appendChild(imgWrapper);
                };
                reader.readAsDataURL(file);
            });
        });
    </script>
@endsection




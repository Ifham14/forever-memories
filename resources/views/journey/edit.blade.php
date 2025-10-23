@extends('layouts.app')

@section('content')
    <div class="min-h-screen flex flex-col justify-between bg-cover bg-center relative"
        style="background-image: url('{{ asset('images/dashboard-bg-img.png') }}')">
        <div class="absolute inset-0 bg-gray-800/50"></div>

        <div class="flex-grow flex items-center justify-center relative z-10 py-20">
            <form action="{{ route('journey.update', $journey->id) }}" method="POST" enctype="multipart/form-data"
                class="w-full max-w-5xl bg-white rounded-lg shadow-lg p-10 space-y-6">
                @csrf
                @method('PUT')

                <h1 class="text-2xl font-bold text-gray-800">Edit Journey</h1>

                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Title <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="title" value="{{ old('title', $journey->title) }}"
                            class="w-full rounded-full border border-gray-300 px-4 py-2 focus:ring focus:ring-blue-200 focus:outline-none required">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Date <span
                                class="text-red-500">*</span></label>
                        <input type="date" name="date"
                            value="{{ old('date', \Carbon\Carbon::parse($journey->date)->format('Y-m-d')) }}"
                            class="w-full rounded-full border border-gray-300 px-4 py-2 focus:ring focus:ring-blue-200 focus:outline-none"
                            required>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Story <span
                                class="text-red-500">*</span></label>
                        <textarea name="story" rows="6"
                            class="w-full rounded-2xl border border-gray-300 px-4 py-2 focus:ring focus:ring-blue-200 focus:outline-none resize-none"
                            required>{{ old('story', $journey->story) }}</textarea>
                    </div>
                </div>

                @if ($journey->images->count())
                    <div class="mt-10">
                        <label class="block text-sm font-medium text-gray-700 mb-4">Existing Images</label>
                        <div id="existing-images" class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                            @foreach ($journey->images as $image)
                                <div
                                    class="relative border border-gray-300 rounded overflow-hidden group shadow-sm hover:shadow-md transition">
                                    <img src="{{ asset('storage/' . $image->image_path) }}"
                                        class="w-full h-auto object-cover">
                                    <button type="button"
                                        class="absolute top-1 right-1 bg-red-600 text-white rounded-full w-6 h-6 text-sm font-bold flex items-center justify-center opacity-0 group-hover:opacity-100 transition"
                                        onclick="markImageForDeletion({{ $image->id }}, this)">
                                        &times;
                                    </button>
                                </div>
                            @endforeach
                        </div>
                        <input type="hidden" name="deleted_images" id="deleted_images">
                    </div>
                @endif

                <div class="mt-10">
                    <label class="block text-sm font-medium text-gray-700 mb-4">Upload New Images</label>
                    <input type="file" name="images[]" id="imageUpload" multiple accept="image/*"
                        class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring focus:ring-blue-200 focus:outline-none">
                    <div id="previewImages" class="grid grid-cols-2 sm:grid-cols-3 gap-4 mt-4"></div>
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
                            'recessional' => 'Recessional',
                        ] as $name => $label)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">{{ $label }}</label>
                                <input type="text" name="{{ $name }}"
                                    value="{{ old($name, $journey->$name) }}"
                                    class="w-full rounded-full border border-gray-300 px-4 py-2 focus:ring focus:ring-blue-200 focus:outline-none">
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="mt-10">
    <h2 class="text-lg font-bold text-gray-800 mb-4">Appreciations</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- Honorary Pallbearers --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Honorary Pallbearers</label>
            <input type="text" name="honorary_pallbearers" value="{{ old('honorary_pallbearers', $journey->honorary_pallbearers) }}"
                class="w-full rounded-full border border-gray-300 px-4 py-2 focus:ring focus:ring-blue-200 focus:outline-none">
        </div>

        {{-- Interment --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Interment</label>
            <input type="text" name="interment" value="{{ old('interment', $journey->interment) }}"
                class="w-full rounded-full border border-gray-300 px-4 py-2 focus:ring focus:ring-blue-200 focus:outline-none">
        </div>

        {{-- Final Arrangement Entrusted To (span 2 cols) --}}
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-1">Final Arrangement Entrusted To</label>
            <input type="text" name="final_arrangement_entrusted_to" value="{{ old('final_arrangement_entrusted_to', $journey->final_arrangement_entrusted_to) }}"
                class="w-full rounded-full border border-gray-300 px-4 py-2 focus:ring focus:ring-blue-200 focus:outline-none">
        </div>

        {{-- Grateful Hearts of Gratitude (span 2 cols) --}}
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-1">Grateful Hearts of Gratitude</label>
            <textarea name="grateful_hearts" rows="6"
                class="w-full rounded-2xl border border-gray-300 px-4 py-2 focus:ring focus:ring-blue-200 focus:outline-none resize-none">{{ old('grateful_hearts', $journey->grateful_hearts) }}</textarea>
        </div>
    </div>
</div>


                <div class="mt-8 flex items-center gap-4">
                    <button type="submit"
                        class="bg-[#FCDA98] hover:bg-[#ffc248] px-5 py-2 rounded cursor-pointer">Update Journey</button>
                    <a href="{{ route('dashboard') }}"
                        class="text-sm text-gray-600 hover:underline cursor-pointer">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        const imageUpload = document.getElementById('imageUpload');
        const previewContainer = document.getElementById('previewImages');
        const deletedImagesInput = document.getElementById('deleted_images');
        let deletedImageIds = [];

        function markImageForDeletion(imageId, button) {
            deletedImageIds.push(imageId);
            deletedImagesInput.value = deletedImageIds.join(',');
            const container = button.closest('.relative');
            container.remove();
        }

        imageUpload.addEventListener('change', function() {
            previewContainer.innerHTML = '';

            Array.from(this.files).forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const imgWrapper = document.createElement('div');
                    imgWrapper.classList.add('relative', 'border', 'border-gray-300', 'rounded', 'overflow-hidden', 'group', 'shadow-sm', 'hover:shadow-md', 'transition');

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
                        imgWrapper.remove();

                        // Remove file from input (tricky workaround)
                        const dt = new DataTransfer();
                        const files = imageUpload.files;
                        for (let i = 0; i < files.length; i++) {
                            if (i !== index) {
                                dt.items.add(files[i]);
                            }
                        }
                        imageUpload.files = dt.files;
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

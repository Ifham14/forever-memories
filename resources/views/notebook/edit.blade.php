@extends('layouts.app')

@section('content')
    <div class="min-h-screen flex flex-col justify-between bg-cover bg-center relative"
        style="background-image: url('{{ asset('images/dashboard-bg-img.png') }}')">
        <div class="absolute inset-0 bg-gray-800/50"></div>

        <div class="flex-grow flex items-center justify-center relative z-10 py-20">
            <form action="{{ route('notebook.update', $notebook->id) }}" enctype="multipart/form-data" method="POST"
                class="w-full max-w-5xl bg-white rounded-lg shadow-lg p-10 space-y-6">
                @csrf
                @method('PUT')

                <h1 class="text-2xl font-bold text-gray-800">Edit Notebook</h1>

                @if ($errors->any())
                    <div class="p-4 bg-red-100 text-red-800 rounded">
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
                        <input type="text" name="title" value="{{ old('title', $notebook->title) }}"
                            class="w-full rounded-full border border-gray-300 px-4 py-2 focus:ring focus:ring-blue-200 focus:outline-none required">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Date <span
                                class="text-red-500">*</span></label>
                        <input type="date" name="date"
                            value="{{ old('date', \Carbon\Carbon::parse($notebook->date)->format('Y-m-d')) }}"
                            class="w-full rounded-full border border-gray-300 px-4 py-2 focus:ring focus:ring-blue-200 focus:outline-none">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Story <span
                                class="text-red-500">*</span></label>
                        <textarea name="story" rows="6" class="w-full rounded-2xl border border-gray-300 px-4 py-2 focus:ring focus:ring-blue-200 focus:outline-none resize-none">{{ old('story', $notebook->story) }}</textarea>
                    </div>
                </div>

                {{-- Existing Images --}}
                @if ($notebook->images->count())
                    <div class="mt-10">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Existing Images</label>
                        <div id="existing-images" class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                            @foreach ($notebook->images as $image)
                                <div class="relative border rounded-lg overflow-hidden group">
                                    <img src="{{ asset('storage/' . $image->image_path) }}"
                                        class="w-full h-40 object-cover">
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

                {{-- Upload New Images --}}
                <div class="mt-10">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Upload Images</label>
                    <input type="file" name="images[]" id="imageUpload" multiple
                        class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring focus:ring-blue-200 focus:outline-none">
                    <div id="previewImages" class="grid grid-cols-2 sm:grid-cols-3 gap-4 mt-4"></div>
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
                                <input type="text" name="{{ $name }}"
                                    value="{{ old($name, $notebook->$name) }}"
                                    class="w-full rounded-full border border-gray-300 px-4 py-2 focus:ring focus:ring-blue-200 focus:outline-none">
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
                            <input type="text" name="honorary_pallbearers"
                                value="{{ old('honorary_pallbearers', $notebook->honorary_pallbearers) }}"
                                class="w-full rounded-full border border-gray-300 px-4 py-2 focus:ring focus:ring-blue-200 focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Place / Event</label>
                            <input type="text" name="interment"
                                value="{{ old('interment', $notebook->interment) }}"
                                class="w-full rounded-full border border-gray-300 px-4 py-2 focus:ring focus:ring-blue-200 focus:outline-none">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Gratitude Notes</label>
                            <textarea name="grateful_hearts" rows="6"
                                class="w-full rounded-2xl border border-gray-300 px-4 py-2 focus:ring focus:ring-blue-200 focus:outline-none resize-none">{{ old('grateful_hearts', $notebook->grateful_hearts) }}</textarea>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Final Notes</label>
                            <input type="text" name="final_arrangement_entrusted_to"
                                value="{{ old('final_arrangement_entrusted_to', $notebook->final_arrangement_entrusted_to) }}"
                                class="w-full rounded-full border border-gray-300 px-4 py-2 focus:ring focus:ring-blue-200 focus:outline-none">
                        </div>
                    </div>
                </div>
                --}}

                {{-- Submit --}}
                <div class="mt-8">
                    <button type="submit"
                        class="bg-[#FCDA98] hover:bg-[#ffc248] px-5 py-2 rounded cursor-pointer">Update
                        Notebook</button>
                    <a href="{{ route('notebook.index') }}"
                        class="ml-4 text-sm text-gray-600 hover:underline cursor-pointer">Cancel</a>
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
            button.closest('.relative').remove();
        }

        imageUpload.addEventListener('change', function() {
            previewContainer.innerHTML = '';
            Array.from(this.files).forEach((file) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const wrapper = document.createElement('div');
                    wrapper.classList.add('relative', 'border', 'rounded-lg', 'overflow-hidden', 'group');
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.classList.add('w-full', 'h-40', 'object-cover');
                    const btn = document.createElement('button');
                    btn.type = 'button';
                    btn.innerHTML = '&times;';
                    btn.classList.add(
                        'absolute', 'top-1', 'right-1', 'bg-red-600', 'text-white',
                        'rounded-full', 'w-6', 'h-6', 'text-sm', 'font-bold',
                        'flex', 'items-center', 'justify-center', 'opacity-0', 'group-hover:opacity-100', 'transition'
                    );
                    btn.addEventListener('click', () => wrapper.remove());
                    wrapper.appendChild(img);
                    wrapper.appendChild(btn);
                    previewContainer.appendChild(wrapper);
                };
                reader.readAsDataURL(file);
            });
        });
    </script>
@endsection

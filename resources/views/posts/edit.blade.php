<x-app-layout title="Edit Post">
    <div class="max-w-2xl mx-auto bg-white shadow-xl rounded-3xl p-6 sm:p-10 border border-slate-200/80 animate-fadeIn">
        
        <div class="flex items-center gap-3 mb-8 pb-4 border-b border-slate-100">
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-amber-400 via-pink-500 to-purple-600 flex items-center justify-center text-white text-xl shadow-md shadow-purple-500/20">
                <i class="fas fa-edit"></i>
            </div>
            <div>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 font-heading">Edit Post</h2>
                <p class="text-xs sm:text-sm text-slate-500">Update title, category, or manage post media.</p>
            </div>
        </div>

        @if ($errors->any())
        <div class="mb-6 rounded-2xl border border-rose-200 bg-rose-50/80 p-4 text-xs sm:text-sm">
            <div class="font-bold text-rose-800 mb-1 flex items-center gap-1.5">
                <i class="fas fa-circle-exclamation"></i> Please check the errors below:
            </div>
            <ul class="list-disc list-inside text-rose-700 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('posts.update', $post) }}" enctype="multipart/form-data" class="space-y-6" id="editPostForm">
            @csrf 
            @method('PUT')

            <!-- Title -->
            <div>
                <label class="block mb-2 text-sm font-semibold text-slate-700">
                    Post Title <span class="text-rose-500">*</span>
                </label>
                <input type="text" name="title" value="{{ old('title', $post->title) }}" required
                    class="w-full px-4 py-3 rounded-xl border border-slate-300 bg-slate-50/50 text-slate-900 focus:bg-white focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 focus:outline-none transition duration-200">
                @error('title')
                <p class="text-rose-600 text-xs font-semibold mt-1.5 flex items-center gap-1">
                    <i class="fas fa-circle-exclamation text-[10px]"></i> {{ $message }}
                </p>
                @enderror
            </div>

            <!-- Category -->
            <div>
                <label class="block mb-2 text-sm font-semibold text-slate-700">
                    Category <span class="text-rose-500">*</span>
                </label>
                <select name="category" required
                    class="w-full px-4 py-3 rounded-xl border border-slate-300 bg-slate-50/50 text-slate-900 focus:bg-white focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 focus:outline-none transition duration-200">
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" @selected($cat == old('category', $post->category))>{{ $cat }}</option>
                    @endforeach
                </select>
                @error('category')
                <p class="text-rose-600 text-xs font-semibold mt-1.5 flex items-center gap-1">
                    <i class="fas fa-circle-exclamation text-[10px]"></i> {{ $message }}
                </p>
                @enderror
            </div>

            <!-- Existing Images -->
            @if($post->images->count() > 0)
            <div>
                <label class="block mb-2 text-sm font-semibold text-slate-700">
                    Existing Images ({{ $post->images->count() }})
                </label>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                    @foreach($post->images as $img)
                    <div class="relative rounded-xl overflow-hidden shadow-sm bg-slate-100 aspect-video group existing-card" data-img-id="{{ $img->id }}">
                        <img src="{{ asset('storage/'.$img->path) }}" class="w-full h-full object-cover" onerror="this.onerror=null; this.src='{{ asset('images/headers/header1.jpg') }}';">
                        <input type="hidden" name="keep_images[]" value="{{ $img->id }}" class="keep-input">
                        <button type="button" class="absolute top-1 right-1 bg-rose-600 hover:bg-rose-700 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs shadow transition remove-existing-btn" title="Remove image">
                            &times;
                        </button>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Add More Images -->
            <div>
                <label class="block mb-2 text-sm font-semibold text-slate-700">
                    Upload Additional Images
                </label>
                
                <div class="border-2 border-dashed border-purple-200 hover:border-purple-400 bg-purple-50/40 rounded-2xl p-6 text-center transition duration-200 cursor-pointer relative group" id="dropzoneBox">
                    <input type="file" name="images[]" id="fileUploader" multiple accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                    <div class="pointer-events-none">
                        <div class="w-12 h-12 rounded-2xl bg-purple-100 text-purple-600 flex items-center justify-center mx-auto mb-2 group-hover:scale-110 transition-transform">
                            <i class="fas fa-cloud-arrow-up text-xl"></i>
                        </div>
                        <p class="font-bold text-sm text-slate-800 mb-0.5">Click or drag & drop new images here</p>
                        <p class="text-xs text-slate-500">JPG, PNG, WEBP, GIF</p>
                    </div>
                </div>

                <!-- Live Preview Grid -->
                <div id="livePreviews" class="grid grid-cols-2 sm:grid-cols-4 gap-3 mt-4 hidden"></div>

                @error('images')
                <p class="text-rose-600 text-xs font-semibold mt-1.5 flex items-center gap-1">
                    <i class="fas fa-circle-exclamation text-[10px]"></i> {{ $message }}
                </p>
                @enderror
                @error('images.*')
                <p class="text-rose-600 text-xs font-semibold mt-1.5 flex items-center gap-1">
                    <i class="fas fa-circle-exclamation text-[10px]"></i> {{ $message }}
                </p>
                @enderror
            </div>

            <!-- Active Status -->
            <div class="flex items-center gap-3 p-4 rounded-2xl bg-slate-50 border border-slate-200/80">
                <input type="checkbox" name="is_active" value="1" id="is_active" @checked(old('is_active', $post->is_active))
                    class="h-5 w-5 text-purple-600 border-slate-300 rounded focus:ring-purple-500 transition cursor-pointer">
                <label for="is_active" class="font-semibold text-sm text-slate-800 cursor-pointer">
                    Post is Active (Visible to public)
                </label>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center gap-3 pt-4 border-t border-slate-100">
                <a href="{{ route('home') }}"
                    class="w-1/3 py-3 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-center text-sm transition">
                    Cancel
                </a>
                <button type="submit"
                    class="w-2/3 gradient-btn py-3 rounded-xl text-white font-bold text-sm shadow-md flex items-center justify-center gap-2">
                    <i class="fas fa-save text-xs"></i> Update Post
                </button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Existing image remove
            document.querySelectorAll(".remove-existing-btn").forEach(btn => {
                btn.addEventListener("click", function() {
                    const card = this.closest(".existing-card");
                    if (card) {
                        card.remove();
                    }
                });
            });

            // New upload preview
            const uploader = document.getElementById("fileUploader");
            const previewBox = document.getElementById("livePreviews");
            let fileList = [];

            if (uploader && previewBox) {
                uploader.addEventListener("change", function(e) {
                    for (let f of this.files) {
                        fileList.push(f);
                    }
                    syncFiles();
                    renderPreviews();
                });

                function renderPreviews() {
                    previewBox.innerHTML = "";
                    if (fileList.length === 0) {
                        previewBox.classList.add("hidden");
                        return;
                    }

                    previewBox.classList.remove("hidden");

                    fileList.forEach((file, idx) => {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const card = document.createElement("div");
                            card.className = "relative rounded-xl overflow-hidden shadow-sm bg-slate-100 aspect-video group";
                            card.innerHTML = `
                                <img src="${e.target.result}" class="w-full h-full object-cover">
                                <button type="button" class="absolute top-1 right-1 bg-rose-600 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs shadow hover:bg-rose-700 transition" data-idx="${idx}">
                                    &times;
                                </button>
                                <span class="absolute bottom-0 inset-x-0 bg-black/60 text-white text-[10px] px-1.5 py-0.5 truncate text-center">${file.name}</span>
                            `;

                            card.querySelector("button").addEventListener("click", function(ev) {
                                ev.stopPropagation();
                                fileList.splice(idx, 1);
                                syncFiles();
                                renderPreviews();
                            });

                            previewBox.appendChild(card);
                        };
                        reader.readAsDataURL(file);
                    });
                }

                function syncFiles() {
                    const dt = new DataTransfer();
                    fileList.forEach(file => dt.items.add(file));
                    uploader.files = dt.files;
                }
            }
        });
    </script>

    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(16px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fadeIn { animation: fadeIn 0.4s ease-out; }
    </style>
</x-app-layout>

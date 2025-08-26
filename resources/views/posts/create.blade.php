<x-app-layout title="Create Post">
    <div class="max-w-3xl mx-auto bg-white shadow-lg rounded-2xl p-10 animate-fadeIn">
        <h2 class="text-3xl font-bold mb-8 text-gray-800 flex items-center gap-2">
            <i class="fas fa-pen-to-square text-purple-600"></i>
            Create New Post
        </h2>

        <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            <div>
                <label class="block mb-2 font-medium text-gray-700">Title</label>
                <input type="text" name="title" required
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition duration-200">
                @error('title')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block mb-2 font-medium text-gray-700">Category</label>
                <select name="category" required
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition duration-200">
                    <option value="" disabled selected>Select category</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat }}">{{ $cat }}</option>
                    @endforeach
                </select>
                @error('category')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block mb-2 font-medium text-gray-700">Images</label>
                <button type="button"
                    class="w-full flex justify-center items-center gap-2 py-3 rounded-lg border border-purple-500 text-purple-600 hover:bg-purple-50 transition"
                    data-bs-toggle="modal" data-bs-target="#imageModal">
                    <i class="fas fa-upload"></i> Upload Images
                </button>
                <x-image-modal />
                @error('images')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex items-center gap-3">
                <input type="checkbox" name="is_active" value="1" checked
                    class="h-5 w-5 text-purple-600 border-gray-300 rounded focus:ring-purple-500 transition">
                <span class="font-medium text-gray-700">Active</span>
            </div>
            <button type="submit"
                class="w-full py-3 rounded-lg bg-purple-600 text-white text-lg font-semibold hover:bg-purple-700 focus:ring-2 focus:ring-purple-400 focus:ring-offset-1 transition shadow-md flex items-center justify-center gap-2">
                <i class="fas fa-save"></i> Save Post
            </button>
        </form>
    </div>

    <style>
        @keyframes fadeIn {
            from {opacity: 0; transform: translateY(20px)}
            to {opacity: 1; transform: translateY(0)}
        }
        .animate-fadeIn {animation: fadeIn 0.5s ease-out}
    </style>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</x-app-layout>
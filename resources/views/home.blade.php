    <x-app-layout title="Home">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 mb-6">
            @auth
            <h2 class="text-2xl font-bold">All Posts</h2>
            @else
            <div></div>
            @endauth

            <div class="flex flex-col sm:flex-row sm:items-center gap-3 w-full sm:w-auto">
                <form method="GET" action="{{ route('home') }}"
                    class="flex gap-3 items-center w-full sm:w-auto" id="searchForm">
                    <div class="relative flex-1 sm:flex-none">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Search posts..."
                            class="pl-10 pr-4 py-2 rounded-xl border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:outline-none w-full sm:w-64"
                            id="searchInput">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-5 h-5 absolute left-3 top-2.5 text-gray-400"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-4.35-4.35M10 18a8 8 0 100-16 8 8 0 000 16z" />
                        </svg>
                    </div>
                    @auth
                    <select name="status" onchange="this.form.submit()"
                        class="px-3 py-2 rounded-xl border border-gray-300 focus:ring-2 focus:ring-purple-500">
                        <option value="active" {{ $status == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ $status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="all" {{ $status == 'all' ? 'selected' : '' }}>All</option>
                    </select>
                    @endauth
                </form>

                @auth
                <a href="{{ route('posts.create') }}"
                    class="px-5 py-2.5 rounded-xl bg-purple-600 text-white font-semibold shadow hover:bg-purple-800 text-center">
                    New Post
                </a>
                @endauth
            </div>
        </div>


        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($posts as $post)
            <div class="bg-white rounded-2xl overflow-hidden shadow-md card-hover border border-gray-100">
                <div class="relative overflow-hidden">
                    @if($post->images->first())
                    <a href="{{ route('posts.show', $post) }}" target="_blank">
                        <img src="{{ asset('storage/'.$post->images->first()->path) }}"
                            class="w-full h-60 object-cover post-image">
                    </a>
                    @else
                    <div class="w-full h-48 gradient-bg flex items-center justify-center">
                        <i class="far fa-newspaper text-white text-5xl"></i>
                    </div>
                    @endif

                    @auth
                    <div class="status-badge">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $post->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $post->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                    @endauth

                </div>

                <!-- Card Content -->
                <div class="p-4 ">
                    <h3 class="font-bold text-lg mb-2 text-gray-800 line-clamp-1 text-center">
                        {{ $post->title }}
                    </h3>

                    <div
                        class="flex items-center pt-3 border-t border-gray-100 @guest justify-center @else justify-between @endguest">

                        <a href="{{ route('posts.show',$post) }}" target="_blank"
                            class="px-4 py-2 bg-purple-100 text-purple-700 rounded-lg text-sm font-medium hover:bg-purple-200 transition-colors flex items-center">
                            <i class="fas fa-eye mr-2"></i> View
                        </a>

                        @auth
                        @if($post->user_id === auth()->id())
                        <div class="flex space-x-2">
                            <a href="{{ route('posts.edit',$post) }}"
                                class="px-4 py-2 bg-yellow-100 text-yellow-700 rounded-lg text-sm font-medium hover:bg-yellow-200 transition-colors flex items-center">
                                <i class="fas fa-edit mr-2"></i> Edit
                            </a>

                            <button type="button"
                                class="px-4 py-2 bg-red-100 text-red-700 rounded-lg text-sm font-medium hover:bg-red-200 transition-colors flex items-center deleteBtn"
                                data-id="{{ $post->id }}" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                <i class="fas fa-trash mr-2"></i> Delete
                            </button>
                        </div>
                        @endif
                        @endauth
                    </div>

                </div>
            </div>

            @empty
            <div class="col-span-full flex justify-center">
                <div class="flex flex-col items-center justify-center bg-white rounded-2xl shadow-md p-10 text-center max-w-md w-full">
                    <div class="w-24 h-8 rounded-full gradient-bg flex items-center justify-center mb-6">
                        <i class="fas fa-search text-white text-4xl"></i>
                    </div>
                    @if(request('search') || request('status') !== null)
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">No matching posts found</h3>
                    <p class="text-gray-600 mb-6">Try adjusting your search or filter to find what you're looking for.</p>
                    <a href="{{ route('home') }}"
                        class="px-5 py-2.5 rounded-lg bg-gray-100 text-gray-800 font-medium hover:bg-gray-200 transition-colors flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i> Back to All Posts
                    </a>
                    @else
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">No posts yet</h3>
                    <p class="text-gray-600 mb-6">Be the first to share your thoughts and ideas!</p>
                    <a href="{{ route('posts.create') }}"
                        class="px-5 py-2.5 rounded-lg gradient-bg text-white font-medium shadow-md hover:shadow-lg transition-shadow flex items-center">
                        <i class="fas fa-plus-circle mr-2"></i> Create First Post
                    </a>
                    @endif
                </div>
            </div>
            @endforelse
        </div>
        <div class="mt-10">
            {{ $posts->links('vendor.pagination.custom') }}
        </div>


        <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content rounded-xl shadow-lg">
                    <div class="modal-header border-b">
                        <h5 class="modal-title">Confirm Delete</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p class="text-gray-700">Are you sure you want to delete this post?</p>
                    </div>
                    <div class="modal-footer border-t">
                        <button type="button" class="btn btn-secondary rounded-lg" data-bs-dismiss="modal">Cancel</button>

                        <form method="POST" id="deleteForm">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger rounded-lg">Yes, Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let timer;
            const input = document.getElementById("searchInput");
            const form = document.getElementById("searchForm");
            const deleteButtons = document.querySelectorAll(".deleteBtn");
            const deleteForm = document.getElementById("deleteForm");

            if (input && form) {
                input.addEventListener("input", function() {
                    clearTimeout(timer);
                    timer = setTimeout(() => {
                        form.submit();
                    }, 1000);
                });
            }

            if (deleteButtons.length && deleteForm) {
                deleteButtons.forEach(button => {
                    button.addEventListener("click", function() {
                        const postId = this.getAttribute("data-id");
                        deleteForm.setAttribute("action", `/posts/${postId}`);
                    });
                });
            }
        });
    </script>

    <style>
        .card-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.15);
        }

        .card-hover .post-image {
            transition: transform 0.4s ease;
        }

        .card-hover:hover .post-image {
            transform: scale(1.05);
        }

        body.modal-open {
            overflow: hidden;
            padding-right: 0 !important;
        }

        @media (max-width: 640px) {
            .modal-dialog {
                margin: 0;
                width: 100%;
                max-width: 100%;
                position: fixed;
                bottom: 0;
            }

            .modal-content {
                border-radius: 1rem 1rem 0 0;
            }
        }
    </style>
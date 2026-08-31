<x-app-layout title="Home">
    <!-- Main Content Container -->
    <div id="posts-section" class="space-y-8">

        <!-- Top Header & Search Bar -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 bg-white/80 backdrop-blur-md p-4 sm:p-6 rounded-2xl border border-slate-200/80 shadow-sm">
            <div>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight font-heading">
                    @auth
                        Latest Community Posts
                    @else
                        Explore Trending Vibes
                    @endauth
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    Discover inspiring articles, insights, and shared moments.
                </p>
            </div>

            <!-- Search & Filters -->
            <div class="flex flex-col sm:flex-row sm:items-center gap-3 w-full md:w-auto">
                <form method="GET" action="{{ route('home') }}" class="flex flex-wrap sm:flex-nowrap gap-2 sm:gap-3 items-center w-full sm:w-auto" id="searchForm">
                    <div class="relative flex-1 sm:w-72">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Search by title or category..."
                            class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-300 bg-slate-50/50 text-slate-900 text-sm focus:ring-2 focus:ring-purple-500 focus:bg-white focus:outline-none transition"
                            id="searchInput">
                        <i class="fas fa-search absolute left-3.5 top-3.5 text-slate-400 text-sm"></i>
                        @if(request('search'))
                        <a href="{{ route('home') }}" class="absolute right-3 top-2.5 text-slate-400 hover:text-slate-600 text-xs px-1 py-0.5" title="Clear search">
                            <i class="fas fa-times-circle text-sm"></i>
                        </a>
                        @endif
                    </div>

                    @auth
                    <div class="w-full sm:w-auto">
                        <select name="status" onchange="this.form.submit()"
                            class="w-full sm:w-auto px-3.5 py-2.5 rounded-xl border border-slate-300 bg-slate-50/50 text-slate-800 text-sm font-medium focus:ring-2 focus:ring-purple-500 focus:bg-white focus:outline-none transition">
                            <option value="all" {{ $status == 'all' ? 'selected' : '' }}>All Status</option>
                            <option value="active" {{ $status == 'active' ? 'selected' : '' }}>Active Only</option>
                            <option value="inactive" {{ $status == 'inactive' ? 'selected' : '' }}>Inactive Only</option>
                        </select>
                    </div>
                    @endauth
                </form>

                @auth
                <a href="{{ route('posts.create') }}"
                    class="gradient-btn px-5 py-2.5 rounded-xl text-white font-bold text-sm shadow-md flex items-center justify-center gap-2 whitespace-nowrap">
                    <i class="fas fa-plus"></i> New Post
                </a>
                @else
                <a href="{{ route('posts.create') }}"
                    class="gradient-btn px-5 py-2.5 rounded-xl text-white font-bold text-sm shadow-md flex items-center justify-center gap-2 whitespace-nowrap">
                    <i class="fas fa-plus"></i> Create Post
                </a>
                @endauth
            </div>
        </div>

        <!-- Posts Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
            @forelse($posts as $post)
            <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl card-hover border border-slate-200/80 flex flex-col transition-all duration-300 group">
                
                <!-- Image / Banner Container -->
                <div class="relative h-56 sm:h-60 overflow-hidden bg-slate-100">
                    @if($post->images->first())
                    <a href="{{ route('posts.show', $post) }}" class="block w-full h-full">
                        <img src="{{ asset('storage/'.$post->images->first()->path) }}"
                            alt="{{ $post->title }}"
                            class="w-full h-full object-cover post-image transition-transform duration-500 group-hover:scale-105"
                            onerror="this.onerror=null; this.src='{{ asset('images/headers/header1.jpg') }}';">
                    </a>
                    @else
                    <div class="w-full h-full bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 flex flex-col items-center justify-center text-white p-4">
                        <i class="fas fa-layer-group text-4xl opacity-80 mb-2"></i>
                        <span class="text-xs font-semibold uppercase tracking-wider opacity-90">{{ $post->category ?? 'Post' }}</span>
                    </div>
                    @endif

                    <!-- Category Badge (Top-Left) -->
                    <div class="absolute top-3 left-3 z-10">
                        @php
                            $cat = $post->category ?? 'General';
                            $badgeColor = match(strtolower($cat)) {
                                'technology' => 'bg-blue-600/90 text-white',
                                'health' => 'bg-emerald-600/90 text-white',
                                'business' => 'bg-amber-600/90 text-white',
                                'sports' => 'bg-rose-600/90 text-white',
                                'education' => 'bg-purple-600/90 text-white',
                                default => 'bg-slate-800/90 text-white',
                            };
                        @endphp
                        <span class="px-3 py-1 rounded-full text-xs font-bold shadow-md backdrop-blur-md {{ $badgeColor }}">
                            {{ $cat }}
                        </span>
                    </div>

                    <!-- Status Badge for Auth (Top-Right) -->
                    @auth
                    <div class="absolute top-3 right-3 z-10">
                        <span class="px-2.5 py-1 rounded-full text-[11px] font-bold shadow-md backdrop-blur-md {{ $post->is_active ? 'bg-green-500 text-white' : 'bg-red-500 text-white' }}">
                            {{ $post->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                    @endauth

                    <!-- Image Count Indicator -->
                    @if($post->images->count() > 1)
                    <div class="absolute bottom-3 right-3 z-10 bg-black/60 backdrop-blur-sm text-white px-2 py-0.5 rounded-md text-xs font-semibold flex items-center gap-1">
                        <i class="fas fa-images text-[10px]"></i> {{ $post->images->count() }}
                    </div>
                    @endif
                </div>

                <!-- Card Body -->
                <div class="p-5 flex flex-col flex-1 justify-between">
                    <div>
                        <div class="flex items-center gap-2 text-xs text-slate-400 mb-2">
                            <span><i class="far fa-calendar-alt mr-1"></i>{{ $post->created_at ? $post->created_at->format('M d, Y') : 'Recently' }}</span>
                            @if($post->user)
                            <span>•</span>
                            <span><i class="far fa-user mr-1"></i>{{ $post->user->name }}</span>
                            @endif
                        </div>

                        <h3 class="font-bold text-lg text-slate-800 hover:text-purple-600 transition line-clamp-2 mb-3 font-heading leading-snug">
                            <a href="{{ route('posts.show', $post) }}">
                                {{ $post->title }}
                            </a>
                        </h3>
                    </div>

                    <!-- Action Footer -->
                    <div class="pt-4 border-t border-slate-100 flex items-center justify-between gap-2 mt-auto">
                        <a href="{{ route('posts.show', $post) }}"
                            class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl bg-purple-50 text-purple-700 hover:bg-purple-100 font-semibold text-xs transition duration-200">
                            <i class="fas fa-eye"></i> View Post
                        </a>

                        @auth
                        @if($post->user_id === auth()->id())
                        <div class="flex items-center gap-1.5">
                            <a href="{{ route('posts.edit', $post) }}"
                                class="inline-flex items-center gap-1 px-3 py-1.5 rounded-xl bg-amber-50 text-amber-700 hover:bg-amber-100 font-semibold text-xs transition duration-200"
                                title="Edit post">
                                <i class="fas fa-edit"></i> Edit
                            </a>

                            <button type="button"
                                class="inline-flex items-center gap-1 px-3 py-1.5 rounded-xl bg-rose-50 text-rose-700 hover:bg-rose-100 font-semibold text-xs transition duration-200 deleteBtn"
                                data-id="{{ $post->id }}"
                                data-bs-toggle="modal"
                                data-bs-target="#deleteModal"
                                title="Delete post">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                        @endif
                        @endauth
                    </div>

                </div>
            </div>

            @empty
            <!-- Empty State -->
            <div class="col-span-full flex justify-center py-12">
                <div class="flex flex-col items-center justify-center bg-white rounded-3xl shadow-sm border border-slate-200/80 p-8 sm:p-12 text-center max-w-lg w-full">
                    <div class="w-20 h-20 rounded-2xl bg-gradient-to-tr from-yellow-400 via-pink-500 to-purple-600 flex items-center justify-center text-white text-3xl shadow-lg shadow-purple-500/20 mb-6">
                        <i class="fas fa-folder-open"></i>
                    </div>

                    @if(request('search') || request('status') !== null)
                    <h3 class="text-2xl font-bold text-slate-800 mb-2 font-heading">No matching posts</h3>
                    <p class="text-slate-500 mb-6 text-sm">We couldn't find anything matching your search criteria.</p>
                    <a href="{{ route('home') }}"
                        class="px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-sm transition flex items-center gap-2">
                        <i class="fas fa-arrow-left"></i> View All Posts
                    </a>
                    @else
                    <h3 class="text-2xl font-bold text-slate-800 mb-2 font-heading">No posts published yet</h3>
                    <p class="text-slate-500 mb-6 text-sm">Be the first to share an inspiring story, idea or photography post with the community!</p>
                    <a href="{{ route('posts.create') }}"
                        class="gradient-btn px-6 py-3 rounded-xl text-white font-bold text-sm shadow-md flex items-center gap-2">
                        <i class="fas fa-plus-circle"></i> Create First Post
                    </a>
                    @endif
                </div>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $posts->links('vendor.pagination.custom') }}
        </div>

    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-3xl border-0 shadow-2xl overflow-hidden">
                <div class="modal-header border-b border-slate-100 bg-slate-50/50 px-6 py-4">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-rose-100 text-rose-600 flex items-center justify-center text-sm font-bold">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <h5 class="modal-title font-bold text-slate-900 font-heading">Confirm Delete</h5>
                    </div>
                    <button type="button" class="btn-close text-xs" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body px-6 py-6 text-slate-600 text-sm">
                    <p>Are you sure you want to permanently delete this post and all its images? This action cannot be undone.</p>
                </div>
                <div class="modal-footer border-t border-slate-100 bg-slate-50/50 px-6 py-4 flex gap-2">
                    <button type="button" class="px-4 py-2 rounded-xl text-slate-700 bg-slate-200 hover:bg-slate-300 font-semibold text-sm transition" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <form method="POST" id="deleteForm" class="m-0">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-5 py-2 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-bold text-sm shadow-md transition">
                            Yes, Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

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
                    }, 600);
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
</x-app-layout>
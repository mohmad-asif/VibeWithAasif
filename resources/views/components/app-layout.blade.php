@props(['title' => '', 'header' => true, 'full' => false, 'footer' => true])

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ? $title . ' - ' : '' }}Vibe With Aasif</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Outfit:wght@500;600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Tailwind & Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        h1, h2, h3, h4, .font-heading {
            font-family: 'Outfit', sans-serif;
        }
        a {
            text-decoration: none !important;
            color: inherit !important;
        }
        .glass-nav {
            background: rgba(15, 23, 42, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
        .gradient-brand {
            background: linear-gradient(135deg, #f59e0b, #ec4899, #8b5cf6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .gradient-btn {
            background: linear-gradient(135deg, #ec4899 0%, #8b5cf6 50%, #6366f1 100%);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .gradient-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -5px rgba(139, 92, 246, 0.5);
        }
        .gradient-btn:active {
            transform: translateY(0);
        }
    </style>
</head>

<body class="min-h-screen flex flex-col bg-slate-50 text-slate-900 antialiased selection:bg-purple-500 selection:text-white">

    @if($header)
    <!-- Navigation Bar (Both Guest & Auth) -->
    <header class="glass-nav border-b border-slate-800/60 sticky top-0 z-50 transition-all duration-300">
        <div class="container mx-auto flex items-center justify-between px-4 py-3 sm:px-6">

            <!-- Brand Logo -->
            <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-yellow-400 via-pink-500 to-purple-600 flex items-center justify-center shadow-lg shadow-purple-500/20 group-hover:scale-105 transition-transform duration-300">
                    <i class="fas fa-bolt text-white text-lg"></i>
                </div>
                <div class="flex flex-col">
                    <span class="text-xl sm:text-2xl font-extrabold tracking-tight gradient-brand group-hover:opacity-95 transition">
                        Vibe With Aasif
                    </span>
                    <span class="text-[10px] text-slate-400 tracking-wider uppercase font-semibold hidden sm:inline-block -mt-1">
                        Stories & Ideas
                    </span>
                </div>
            </a>

            <!-- Navigation Links -->
            <nav class="flex items-center gap-2 sm:gap-4 text-white">
                <a href="{{ route('home') }}"
                    class="px-3.5 py-1.5 rounded-lg text-sm font-semibold transition duration-200 {{ request()->routeIs('home') ? 'bg-purple-600/30 text-purple-300 border border-purple-500/40' : 'text-slate-300 hover:text-white hover:bg-slate-800/60' }}">
                    <i class="fas fa-compass mr-1.5 text-xs"></i> Explore
                </a>

                @auth
                <a href="{{ route('posts.create') }}"
                    class="px-3.5 py-1.5 rounded-lg text-sm font-semibold transition duration-200 {{ request()->routeIs('posts.create') ? 'bg-purple-600/30 text-purple-300 border border-purple-500/40' : 'text-slate-300 hover:text-white hover:bg-slate-800/60' }}">
                    <i class="fas fa-plus-circle mr-1.5 text-xs"></i> New Post
                </a>
                @endauth
            </nav>

            <!-- User Auth Actions -->
            <div class="flex items-center gap-2 sm:gap-3">
                @guest
                <a href="{{ route('login.show') }}"
                    class="px-4 py-2 rounded-xl text-sm font-semibold text-slate-200 hover:text-white hover:bg-slate-800 transition duration-200">
                    <i class="fas fa-sign-in-alt mr-1"></i> Log in
                </a>
                <a href="{{ route('register.show') }}"
                    class="gradient-btn px-4 sm:px-5 py-2 rounded-xl text-sm font-bold text-white shadow-md flex items-center gap-1.5">
                    <i class="fas fa-user-plus text-xs"></i>
                    <span>Sign Up</span>
                </a>
                @endguest

                @auth
                <div class="flex items-center gap-3">
                    <div class="hidden sm:flex items-center gap-2 px-3 py-1.5 rounded-xl bg-slate-800/80 border border-slate-700/60">
                        <div class="w-7 h-7 rounded-full bg-gradient-to-tr from-purple-500 to-pink-500 flex items-center justify-center text-xs font-bold text-white uppercase">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                        <span class="text-sm font-medium text-slate-200">
                            {{ auth()->user()->name }}
                        </span>
                    </div>

                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                        @csrf
                        <button type="submit"
                            class="px-3.5 sm:px-4 py-1.5 sm:py-2 rounded-xl bg-red-500/10 hover:bg-red-500/20 text-red-400 border border-red-500/30 text-xs sm:text-sm font-semibold transition duration-200 flex items-center gap-1.5"
                            title="Sign out">
                            <i class="fas fa-power-off"></i>
                            <span class="hidden sm:inline">Logout</span>
                        </button>
                    </form>
                </div>
                @endauth
            </div>

        </div>
    </header>

    @guest
    <!-- Hero Banner Carousel for Guests -->
    <section class="relative bg-slate-950 overflow-hidden shadow-xl">
        <div id="guestCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="4500">
            <!-- Indicators -->
            <div class="carousel-indicators z-20 mb-3">
                <button type="button" data-bs-target="#guestCarousel" data-bs-slide-to="0" class="active rounded-full !w-3 !h-3"></button>
                <button type="button" data-bs-target="#guestCarousel" data-bs-slide-to="1" class="rounded-full !w-3 !h-3"></button>
                <button type="button" data-bs-target="#guestCarousel" data-bs-slide-to="2" class="rounded-full !w-3 !h-3"></button>
                <button type="button" data-bs-target="#guestCarousel" data-bs-slide-to="3" class="rounded-full !w-3 !h-3"></button>
                <button type="button" data-bs-target="#guestCarousel" data-bs-slide-to="4" class="rounded-full !w-3 !h-3"></button>
            </div>

            <!-- Slides -->
            <div class="carousel-inner h-[220px] sm:h-[300px] md:h-[380px] lg:h-[440px]">
                <div class="carousel-item active h-full relative">
                    <img src="{{ asset('storage/images/headers/header1.jpg') }}"
                        class="absolute inset-0 w-full h-full object-cover transform scale-105 transition-transform duration-1000"
                        alt="Digital Lifestyle & Tech Trends"
                        onerror="this.onerror=null; this.src='{{ asset('images/headers/header1.jpg') }}';">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/40 to-slate-950/20"></div>
                </div>
                <div class="carousel-item h-full relative">
                    <img src="{{ asset('storage/images/headers/header2.jpg') }}"
                        class="absolute inset-0 w-full h-full object-cover transform scale-105 transition-transform duration-1000"
                        alt="Cyberpunk & Creative Community"
                        onerror="this.onerror=null; this.src='{{ asset('images/headers/header2.jpg') }}';">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/40 to-slate-950/20"></div>
                </div>
                <div class="carousel-item h-full relative">
                    <img src="{{ asset('storage/images/headers/header3.jpg') }}"
                        class="absolute inset-0 w-full h-full object-cover transform scale-105 transition-transform duration-1000"
                        alt="Modern Lifestyle & Living"
                        onerror="this.onerror=null; this.src='{{ asset('images/headers/header3.jpg') }}';">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/40 to-slate-950/20"></div>
                </div>
                <div class="carousel-item h-full relative">
                    <img src="{{ asset('storage/images/headers/header4.jpg') }}"
                        class="absolute inset-0 w-full h-full object-cover transform scale-105 transition-transform duration-1000"
                        alt="Alpine Mountain Wonders"
                        onerror="this.onerror=null; this.src='{{ asset('images/headers/header4.jpg') }}';">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/40 to-slate-950/20"></div>
                </div>
                <div class="carousel-item h-full relative">
                    <img src="{{ asset('storage/images/headers/header5.jpg') }}"
                        class="absolute inset-0 w-full h-full object-cover transform scale-105 transition-transform duration-1000"
                        alt="Synthwave Metropolis"
                        onerror="this.onerror=null; this.src='{{ asset('images/headers/header5.jpg') }}';">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/40 to-slate-950/20"></div>
                </div>
            </div>

            <!-- Controls -->
            <button class="carousel-control-prev z-20 !w-12 !opacity-70 hover:!opacity-100" type="button"
                data-bs-target="#guestCarousel" data-bs-slide="prev">
                <span class="w-10 h-10 rounded-full bg-black/40 backdrop-blur flex items-center justify-center text-white border border-white/20">
                    <i class="fas fa-chevron-left text-sm"></i>
                </span>
            </button>
            <button class="carousel-control-next z-20 !w-12 !opacity-70 hover:!opacity-100" type="button"
                data-bs-target="#guestCarousel" data-bs-slide="next">
                <span class="w-10 h-10 rounded-full bg-black/40 backdrop-blur flex items-center justify-center text-white border border-white/20">
                    <i class="fas fa-chevron-right text-sm"></i>
                </span>
            </button>

            <!-- Hero Floating Overlay Text -->
            <div class="absolute inset-0 z-10 flex flex-col items-center justify-center text-center text-white px-4 pointer-events-none">
                <div class="max-w-2xl bg-slate-900/40 backdrop-blur-md p-5 sm:p-8 rounded-3xl border border-white/10 shadow-2xl pointer-events-auto">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-gradient-to-r from-yellow-400/20 to-pink-500/20 border border-yellow-300/30 text-yellow-300 text-xs font-semibold uppercase tracking-wider mb-3">
                        <i class="fas fa-sparkles"></i> Welcome to the Community
                    </div>
                    <h1 class="text-2xl sm:text-4xl md:text-5xl font-extrabold tracking-tight drop-shadow-md">
                        Discover & Share <span class="gradient-brand">Great Vibes</span>
                    </h1>
                    <p class="mt-3 text-xs sm:text-base text-slate-200 max-w-lg mx-auto font-medium">
                        Explore inspiring stories, creative photography, technology trends, and modern lifestyle blogs.
                    </p>
                    <div class="mt-4 sm:mt-6 flex items-center justify-center gap-3">
                        <a href="{{ route('register.show') }}"
                            class="gradient-btn px-5 py-2.5 rounded-xl text-sm font-bold text-white shadow-lg">
                            Get Started Free
                        </a>
                        <a href="#posts-section"
                            class="px-4 py-2.5 rounded-xl text-sm font-semibold bg-white/10 hover:bg-white/20 text-white backdrop-blur border border-white/20 transition">
                            Explore Posts <i class="fas fa-arrow-down ml-1 text-xs"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endguest

    @endif

    @if($full)
    <main class="w-screen h-screen m-0 p-0">
        {{ $slot }}
    </main>
    @else
    <main class="container mx-auto px-4 sm:px-6 py-8 flex-1">
        {{ $slot }}
    </main>
    @endif

    @if($footer)
    <!-- Modern Footer -->
    <footer class="bg-slate-900 text-slate-400 border-t border-slate-800 py-8 mt-auto">
        <div class="container mx-auto px-4 sm:px-6">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-tr from-yellow-400 to-purple-600 flex items-center justify-center text-white text-sm font-bold">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <span class="text-lg font-bold text-white">Vibe With Aasif</span>
                </div>
                <p class="text-xs sm:text-sm text-slate-400 text-center sm:text-right">
                    © {{ date('Y') }} Vibe With Aasif. All rights reserved. Created with passion.
                </p>
            </div>
        </div>
    </footer>
    @endif

</body>

</html>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        let selectedFiles = [];
        const imageInput = document.getElementById("imageInput");
        const hiddenInput = document.getElementById("hiddenImageInput");
        const previewContainer = document.getElementById("imagePreview");

        imageInput?.addEventListener("change", function() {
            for (let file of imageInput.files) {
                selectedFiles.push(file);
            }
            renderPreview();
        });

        function renderPreview() {
            document.querySelectorAll(".new-preview").forEach(el => el.remove());

            selectedFiles.forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    let col = document.createElement("div");
                    col.classList.add("col-6", "col-md-3", "text-center", "new-preview", "mb-3");

                    col.innerHTML = `
                    <div class="card shadow-sm position-relative overflow-hidden rounded-xl border-0">
                        <img src="${e.target.result}" class="card-img-top" style="height:120px;object-fit:cover;">
                        <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1 rounded-circle p-1 leading-none" data-index="${index}" style="width:24px;height:24px;">&times;</button>
                    </div>
                `;
                    previewContainer.appendChild(col);

                    col.querySelector("button").addEventListener("click", function() {
                        selectedFiles.splice(index, 1);
                        renderPreview();
                    });
                };
                reader.readAsDataURL(file);
            });
        }

        previewContainer?.addEventListener("click", function(e) {
            if (e.target.classList.contains("remove-existing")) {
                const card = e.target.closest(".existing-image");
                card.remove();
            }
        });

        document.getElementById("saveImagesBtn")?.addEventListener("click", function() {
            let dt = new DataTransfer();
            selectedFiles.forEach(file => dt.items.add(file));
            hiddenInput.files = dt.files;
            bootstrap.Modal.getInstance(document.getElementById("imageModal"))?.hide();
        });
    });
</script>
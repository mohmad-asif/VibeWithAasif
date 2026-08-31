<x-app-layout :header="false" :full="true" :footer="false" title="{{ $post->title }}">

    <!-- Back to Home Floating Button -->
    <a href="{{ route('home') }}"
        class="absolute top-3 sm:top-5 left-3 sm:left-5 z-50 bg-black/60 hover:bg-black/80 text-white px-3.5 py-2 rounded-full text-xs sm:text-sm font-bold backdrop-blur-md border border-white/20 flex items-center gap-2 transition duration-200 shadow-xl">
        <i class="fas fa-arrow-left text-xs"></i>
        <span>Home</span>
    </a>

    <div id="audioOverlay"
        class="absolute inset-0 flex items-center justify-center bg-black/60 backdrop-blur-sm z-50 transition-opacity duration-500 px-4">
        <div class="bg-white/95 text-slate-800 px-5 sm:px-8 py-3.5 sm:py-5 rounded-2xl shadow-2xl cursor-pointer flex items-center space-x-3 text-sm sm:text-base border border-white/40 hover:scale-105 transition-transform duration-200">
            <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-purple-500 to-pink-500 text-white flex items-center justify-center shadow-md">
                <i class="fas fa-volume-up text-base"></i>
            </div>
            <div>
                <span class="font-bold block text-slate-900">Enable Ambient Audio</span>
                <span class="text-xs text-slate-500">Click anywhere to start the vibe</span>
            </div>
        </div>
    </div>

    <!-- Fullscreen Carousel Wrapper -->
    <div id="carouselWrapper" class="relative full-screen h-screen w-screen overflow-hidden bg-black">

        <!-- Carousel -->
        <div class="relative carousel-container w-full h-full" id="carousel">
            @forelse($post->images as $index => $img)
            <div class="carousel-image absolute inset-0 flex items-center justify-center bg-black {{ $index === 0 ? 'active' : '' }}">
                <img src="{{ asset('storage/'.$img->path) }}"
                    alt="{{ $post->title }}"
                    class="w-full h-auto max-h-screen object-contain sm:max-h-full md:object-contain"
                    onerror="this.onerror=null; this.src='{{ asset('images/headers/header1.jpg') }}';">

                <div class="absolute top-0 left-0 right-0 bg-gradient-to-b from-black/80 via-black/40 to-transparent p-4 sm:p-6 text-white text-center">
                    <div class="max-w-2xl mx-auto">
                        <span class="inline-block px-3 py-1 rounded-full text-xs font-bold bg-purple-600/80 text-purple-100 uppercase tracking-wider mb-2">
                            {{ $post->category }}
                        </span>
                        <h1 class="text-lg sm:text-2xl md:text-3xl font-extrabold font-heading tracking-tight drop-shadow-md">
                            {{ $post->title }}
                        </h1>
                    </div>
                </div>
            </div>
            @empty
            <div class="carousel-image active absolute inset-0 flex flex-col items-center justify-center bg-gradient-to-br from-slate-950 via-purple-950 to-slate-900 text-white p-6 text-center">
                <div class="w-20 h-20 rounded-2xl bg-purple-600/30 border border-purple-400/40 flex items-center justify-center text-3xl mb-4">
                    <i class="fas fa-image"></i>
                </div>
                <span class="px-3 py-1 rounded-full text-xs font-bold bg-purple-500/20 text-purple-300 border border-purple-400/30 uppercase tracking-wider mb-2">
                    {{ $post->category }}
                </span>
                <h1 class="text-2xl sm:text-4xl font-extrabold font-heading max-w-xl">
                    {{ $post->title }}
                </h1>
            </div>
            @endforelse
        </div>

        @if($post->images->count() > 0)
        <!-- Slide Counter -->
        <div class="absolute top-3 sm:top-5 right-3 sm:right-5 bg-black/60 backdrop-blur-md text-white px-3 py-1 rounded-full text-xs sm:text-sm font-semibold border border-white/20 z-50">
            <span id="currentImage">1</span> / <span id="totalImages">{{ $post->images->count() }}</span>
        </div>

        <!-- Carousel Bottom Controls -->
        <div class="absolute bottom-0 left-0 w-full bg-gradient-to-t from-black/90 via-black/50 to-transparent text-white px-3 py-3 flex justify-center items-center space-x-4 sm:space-x-8 text-base sm:text-lg z-50">
            <button class="p-2 sm:p-3 hover:text-purple-400 transition focus:outline-none active:scale-95" id="prevBtn" title="Previous image">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button class="p-2 sm:p-3 hover:text-purple-400 transition focus:outline-none active:scale-95" id="playPauseBtn" title="Play / Pause slideshow">
                <i class="fas fa-pause"></i>
            </button>
            <button class="p-2 sm:p-3 hover:text-purple-400 transition focus:outline-none active:scale-95" id="nextBtn" title="Next image">
                <i class="fas fa-chevron-right"></i>
            </button>
            <button class="p-2 sm:p-3 hover:text-purple-400 transition focus:outline-none active:scale-95" id="toggleAudioBtn" title="Toggle audio">
                <i class="fas fa-volume-up"></i>
            </button>
            <button class="p-2 sm:p-3 hover:text-purple-400 transition focus:outline-none active:scale-95" id="fullscreenBtn" title="Toggle fullscreen">
                <i class="fas fa-expand"></i>
            </button>
            <button class="p-2 sm:p-3 hover:text-purple-400 transition focus:outline-none active:scale-95" id="hideControlsBtn" title="Toggle thumbnail bar">
                <i class="fas fa-eye-slash"></i>
            </button>
        </div>

        <!-- Thumbnail Bar -->
        <div id="thumbnailBar" class="absolute bottom-16 sm:bottom-20 left-1/2 -translate-x-1/2 flex space-x-2 sm:space-x-3 bg-black/60 backdrop-blur-md px-3 sm:px-4 py-2 sm:py-2.5 rounded-2xl border border-white/20 overflow-x-auto max-w-[95%] sm:max-w-[90%] z-50 shadow-2xl">
            @foreach($post->images as $index => $img)
            <img
                src="{{ asset('storage/'.$img->path) }}"
                data-index="{{ $index }}"
                class="thumbnail w-14 h-10 sm:w-20 sm:h-14 object-cover rounded-xl cursor-pointer border-2 border-transparent hover:border-purple-500 transition duration-200 flex-shrink-0 shadow"
                onerror="this.onerror=null; this.src='{{ asset('images/headers/header1.jpg') }}';">
            @endforeach
        </div>
        @endif

    </div>

    <!-- Audio Element -->
    <audio id="audioPlayer" class="hidden" loop autoplay muted>
        <source src="{{ asset('storage/audio/music.mp3') }}" type="audio/mpeg">
        <source src="{{ asset('audio/music.mp3') }}" type="audio/mpeg">
    </audio>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/post-show.css') }}">
    <script src="{{ asset('js/post-show.js') }}"></script>

</x-app-layout>
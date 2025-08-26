<x-app-layout :header="false" :full="true" :footer="false" title="{{ $post->title }}">

    <div id="audioOverlay"
        class="absolute inset-0 flex items-center justify-center bg-black/50 z-50 transition-opacity duration-500 px-4">
        <div class="bg-white/90 text-gray-800 px-4 sm:px-6 py-3 sm:py-4 rounded-xl shadow-lg cursor-pointer flex items-center space-x-2 sm:space-x-3 text-sm sm:text-base">
            <i class="fas fa-volume-up text-lg sm:text-2xl"></i>
            <span class="font-semibold">Click to enable audio</span>
        </div>
    </div>

    <!-- Fullscreen Carousel Wrapper -->
    <div id="carouselWrapper" class="relative full-screen h-screen w-screen overflow-hidden">

        <!-- Carousel -->
        <div class="relative carousel-container w-full h-full" id="carousel">
            @foreach($post->images as $index => $img)
            <div class="carousel-image absolute inset-0 flex items-center justify-center bg-black {{ $index === 0 ? 'active' : '' }}">
                <img src="{{ asset('storage/'.$img->path) }}"
                    class="w-full h-auto max-h-screen object-contain sm:max-h-full md:object-contain">

                <div class="absolute top-2 sm:top-4 left-0 right-0 bg-gradient-to-t from-black/20 to-transparent p-2 sm:p-3 text-white">
                    <div class="flex flex-wrap justify-center items-center gap-1 sm:gap-2 text-xs sm:text-sm w-full text-center">
                        <h3 class="text-base sm:text-xl font-bold">{{ $post->title }}</h3>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="absolute top-2 sm:top-4 right-2 sm:right-4 bg-black/50 text-white px-2 sm:px-3 py-0.5 sm:py-1 rounded-full text-xs sm:text-sm z-50">
            <span id="currentImage">1</span> / <span id="totalImages">{{ $post->images->count() }}</span>
        </div>

        <div class="absolute bottom-0 left-0 w-full bg-black/30 text-white px-1 sm:px-2 flex justify-center items-center flex-wrap sm:flex-nowrap space-x-4 sm:space-x-8 text-base sm:text-lg z-50">
            <button class="p-2 sm:p-3 hover:text-blue-300 transition focus:outline-none focus:ring-0 active:scale-95" id="prevBtn">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button class="p-2 sm:p-3 hover:text-blue-300 transition focus:outline-none focus:ring-0 active:scale-95" id="playPauseBtn">
                <i class="fas fa-pause"></i>
            </button>
            <button class="p-2 sm:p-3 hover:text-blue-300 transition focus:outline-none focus:ring-0 active:scale-95" id="nextBtn">
                <i class="fas fa-chevron-right"></i>
            </button>
            <button class="p-2 sm:p-3 hover:text-blue-300 transition focus:outline-none focus:ring-0 active:scale-95" id="toggleAudioBtn">
                <i class="fas fa-volume-up"></i>
            </button>
            <button class="p-2 sm:p-3 hover:text-blue-300 transition focus:outline-none focus:ring-0 active:scale-95" id="fullscreenBtn">
                <i class="fas fa-expand"></i>
            </button>
            <button class="p-2 sm:p-3 hover:text-blue-300 transition focus:outline-none focus:ring-0 active:scale-95" id="hideControlsBtn">
                <i class="fas fa-eye-slash"></i>
            </button>
        </div>

        <div id="thumbnailBar" class="absolute bottom-14 sm:bottom-16 left-1/2 -translate-x-1/2 flex space-x-2 sm:space-x-4 bg-black/50 px-2 sm:px-4 py-2 sm:py-3 rounded-xl overflow-x-auto max-w-[95%] sm:max-w-[90%] z-50">
            @foreach($post->images as $index => $img)
            <img
                src="{{ asset('storage/'.$img->path) }}"
                data-index="{{ $index }}"
                class="thumbnail w-16 h-auto sm:w-28 sm:h-20 object-cover rounded-lg cursor-pointer border-2 border-transparent hover:border-blue-500 transition flex-shrink-0">
            @endforeach
        </div>

    </div>

    <audio id="audioPlayer" class="hidden" loop autoplay muted>
        <source src="{{ asset('storage/audio/music.mp3') }}" type="audio/mpeg">
    </audio>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/post-show.css') }}">
    <script src="{{ asset('js/post-show.js') }}"></script>

</x-app-layout>
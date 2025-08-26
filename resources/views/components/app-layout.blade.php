@props(['title' => '', 'header' => true, 'full' => false, 'footer' => true])

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        a {
            text-decoration: none;
            color: inherit !important;
        }
    </style>
</head>

<body class="min-h-screen flex flex-col bg-gradient-to-br from-indigo-50 via-purple-50 to-pink-100 text-gray-900">

    @if($header)
    @guest
    <header class="relative">
        <div id="guestCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner h-[140px] sm:h-[200px] md:h-[260px] lg:h-[320px] relative">
                <div class="carousel-item active relative h-full">
                    <img src="{{ asset('storage/images/headers/header1.jpg') }}"
                        class="absolute inset-0 w-full h-full object-cover"
                        alt="Slide 1">
                </div>
                <div class="carousel-item relative h-full">
                    <img src="{{ asset('storage/images/headers/header2.jpg') }}"
                        class="absolute inset-0 w-full h-full object-cover"
                        alt="Slide 2">
                </div>
                <div class="carousel-item relative h-full">
                    <img src="{{ asset('storage/images/headers/header3.jpg') }}"
                        class="absolute inset-0 w-full h-full object-cover"
                        alt="Slide 3">
                </div>
                <div class="carousel-item relative h-full">
                    <img src="{{ asset('storage/images/headers/header4.jpg') }}"
                        class="absolute inset-0 w-full h-full object-cover"
                        alt="Slide 4">
                </div>
                <div class="carousel-item relative h-full">
                    <img src="{{ asset('storage/images/headers/header5.jpg') }}"
                        class="absolute inset-0 w-full h-full object-cover"
                        alt="Slide 5">
                </div>
            </div>

            <button class="carousel-control-prev" type="button"
                data-bs-target="#guestCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button"
                data-bs-target="#guestCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>

            <div class="absolute inset-0 bg-black/40 flex flex-col items-center justify-center text-center text-white px-4">
                <h1 class="text-xl sm:text-2xl md:text-3xl font-extrabold tracking-wide drop-shadow-lg">
                    Welcome to Vibe With Aasif
                </h1>
                <p class="mt-2 text-xs sm:text-sm md:text-base max-w-xl drop-shadow">
                    Explore inspiring blogs, stories, and ideas from our community.
                </p>
            </div>
        </div>
    </header>
    @endguest


    @auth
    <header class="bg-gradient-to-r from-gray-900 via-purple-800 to-indigo-900 
               shadow-md sticky top-0 z-50">

        <div class="container mx-auto flex flex-col md:flex-row md:items-center md:justify-between 
                px-3 py-4 gap-4 text-white">

            <a href="{{ route('home') }}"
                class="text-2xl sm:text-3xl font-extrabold tracking-wide 
                  bg-clip-text text-transparent bg-gradient-to-r from-yellow-300 via-pink-400 to-fuchsia-400 
                  hover:from-yellow-400 hover:to-pink-500 transition duration-300 text-center md:text-left">
                Vibe With Aasif
            </a>

            <nav class="flex justify-center md:justify-start gap-6 text-base sm:text-lg font-semibold">
                <a href="{{ route('home') }}"
                    class="relative text-gray-200 hover:text-yellow-300 transition duration-300
                      after:content-[''] after:block after:w-0 after:h-[2px] after:bg-yellow-300 
                      after:transition-all after:duration-300 hover:after:w-full after:mt-1">
                    Home
                </a>
                <a href="{{ route('posts.create') }}"
                    class="relative text-gray-200 hover:text-pink-300 transition duration-300
                      after:content-[''] after:block after:w-0 after:h-[2px] after:bg-pink-300 
                      after:transition-all after:duration-300 hover:after:w-full after:mt-1">
                    New Post
                </a>
            </nav>

            <div class="flex flex-col sm:flex-row items-center gap-3 justify-center md:justify-end">
                <span class="font-medium text-sm sm:text-base text-gray-100 tracking-wide 
                         bg-clip-text text-transparent bg-gradient-to-r from-fuchsia-300 to-yellow-300">
                    {{ auth()->user()->name }}
                </span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="px-5 py-2 rounded-full bg-gradient-to-r from-yellow-300 to-pink-400 
                           text-gray-900 font-semibold shadow-md hover:from-yellow-400 hover:to-pink-500 
                           transition duration-300 w-full sm:w-auto">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </header>
    @endauth

    @endif

    @if($full)
    <main class="w-screen h-screen m-0 p-0">
        {{ $slot }}
    </main>
    @else
    <main class="container mx-auto px-3 sm:px-4 py-6">
        {{ $slot }}
    </main>
    @endif

    @if($footer)
    <footer class="bg-gradient-to-r from-fuchsia-500 via-purple-600 to-indigo-600 text-white py-3 mt-auto">
        <div class="container mx-auto text-center px-2 text-sm sm:text-base">
            <p class="mb-1 sm:mb-2">© {{ date('Y') }} Vibe With Aasif. All rights reserved.</p>
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
                    col.classList.add("col-md-3", "text-center", "new-preview");

                    col.innerHTML = `
                    <div class="card shadow-sm position-relative">
                        <img src="${e.target.result}" class="card-img-top" style="height:120px;object-fit:cover;">
                        <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1" data-index="${index}">&times;</button>
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
            bootstrap.Modal.getInstance(document.getElementById("imageModal")).hide();
        });
    });
</script>
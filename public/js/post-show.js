document.addEventListener('DOMContentLoaded', function () {
    const carousel = document.getElementById('carousel');
    const images = document.querySelectorAll('.carousel-image');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const playPauseBtn = document.getElementById('playPauseBtn');
    const toggleAudioBtn = document.getElementById('toggleAudioBtn');
    const fullscreenBtn = document.getElementById('fullscreenBtn');
    const hideControlsBtn = document.getElementById('hideControlsBtn');
    const bgAudio = document.getElementById('audioPlayer');
    const currentImageEl = document.getElementById('currentImage');
    const totalImagesEl = document.getElementById('totalImages');
    const thumbnails = document.querySelectorAll('.thumbnail');
    const audioOverlay = document.getElementById('audioOverlay');
    const carouselWrapper = document.getElementById('carouselWrapper');

    if (!images || images.length === 0) {
        return;
    }

    let currentImage = 0;
    let autoPlayInterval;
    let isPlaying = true;

    if (totalImagesEl) {
        totalImagesEl.textContent = images.length;
    }

    function showImage(index) {
        if (!images[index]) return;

        images.forEach(image => image.classList.remove('active'));
        thumbnails.forEach(thumb => thumb.classList.remove('active'));

        const imgEl = images[index].querySelector("img");
        if (imgEl) {
            // Remove previous animation
            imgEl.style.animation = "none";

            // Random animation choice
            const animations = ["zoomCenter", "zoomLeft", "zoomRight"];
            const randomAnim = animations[Math.floor(Math.random() * animations.length)];

            // Trigger reflow so animation can restart
            void imgEl.offsetWidth;

            // Apply animation
            imgEl.style.animation = `${randomAnim} 5s ease-in-out forwards`;
        }

        images[index].classList.add('active');
        if (thumbnails[index]) {
            thumbnails[index].classList.add('active');
        }
        if (currentImageEl) {
            currentImageEl.textContent = index + 1;
        }
    }

    function startAutoPlay() {
        if (autoPlayInterval) clearInterval(autoPlayInterval);
        autoPlayInterval = setInterval(() => {
            currentImage = (currentImage + 1) % images.length;
            showImage(currentImage);
        }, 5000);
        isPlaying = true;
        if (playPauseBtn) playPauseBtn.innerHTML = '<i class="fas fa-pause"></i>';
    }

    function pauseAutoPlay() {
        clearInterval(autoPlayInterval);
        isPlaying = false;
        if (playPauseBtn) playPauseBtn.innerHTML = '<i class="fas fa-play"></i>';
    }

    thumbnails.forEach((thumb, i) => {
        thumb.addEventListener('click', () => {
            currentImage = i;
            showImage(currentImage);
            if (isPlaying) {
                pauseAutoPlay();
                startAutoPlay();
            }
        });
    });

    if (nextBtn) {
        nextBtn.addEventListener('click', () => {
            currentImage = (currentImage + 1) % images.length;
            showImage(currentImage);
            if (isPlaying) {
                pauseAutoPlay();
                startAutoPlay();
            }
        });
    }

    if (prevBtn) {
        prevBtn.addEventListener('click', () => {
            currentImage = (currentImage - 1 + images.length) % images.length;
            showImage(currentImage);
            if (isPlaying) {
                pauseAutoPlay();
                startAutoPlay();
            }
        });
    }

    document.addEventListener('keydown', (e) => {
        if (e.key === "ArrowRight") {
            currentImage = (currentImage + 1) % images.length;
            showImage(currentImage);
        } else if (e.key === "ArrowLeft") {
            currentImage = (currentImage - 1 + images.length) % images.length;
            showImage(currentImage);
        }
    });

    if (playPauseBtn) {
        playPauseBtn.addEventListener('click', () => {
            if (isPlaying) pauseAutoPlay();
            else startAutoPlay();
        });
    }

    if (toggleAudioBtn && bgAudio) {
        toggleAudioBtn.addEventListener("click", () => {
            if (bgAudio.muted || bgAudio.paused) {
                bgAudio.muted = false;
                bgAudio.play().catch(() => {});
                toggleAudioBtn.innerHTML = '<i class="fas fa-volume-up"></i>';
            } else {
                bgAudio.pause();
                toggleAudioBtn.innerHTML = '<i class="fas fa-volume-mute"></i>';
            }
        });
    }

    if (fullscreenBtn && carouselWrapper) {
        fullscreenBtn.addEventListener('click', () => {
            if (!document.fullscreenElement) {
                carouselWrapper.requestFullscreen?.();
            } else {
                document.exitFullscreen?.();
            }
        });
    }

    document.addEventListener("fullscreenchange", () => {
        if (fullscreenBtn) {
            if (document.fullscreenElement) {
                fullscreenBtn.innerHTML = '<i class="fas fa-compress"></i>';
            } else {
                fullscreenBtn.innerHTML = '<i class="fas fa-expand"></i>';
            }
        }
    });

    if (hideControlsBtn) {
        hideControlsBtn.addEventListener('click', () => {
            const thumbnailBar = document.getElementById('thumbnailBar');
            if (thumbnailBar) {
                thumbnailBar.classList.toggle('hidden');
                if (thumbnailBar.classList.contains('hidden')) {
                    hideControlsBtn.innerHTML = '<i class="fas fa-eye"></i>';
                } else {
                    hideControlsBtn.innerHTML = '<i class="fas fa-eye-slash"></i>';
                }
            }
        });
    }

    if (audioOverlay && bgAudio) {
        setTimeout(() => {
            audioOverlay.classList.add('opacity-0');
            setTimeout(() => audioOverlay.style.display = 'none', 500);
        }, 4000);

        audioOverlay.addEventListener('click', () => {
            bgAudio.muted = false;
            bgAudio.play().catch(() => {});
            audioOverlay.classList.add('opacity-0');
            setTimeout(() => audioOverlay.style.display = 'none', 500);
        });
    }

    showImage(currentImage);
    startAutoPlay();
});
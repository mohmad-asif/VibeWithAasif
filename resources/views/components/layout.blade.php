<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="min-h-screen bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 flex items-center justify-center p-4">
    <div class="w-full max-w-6xl bg-white shadow-2xl rounded-2xl overflow-hidden flex flex-col md:flex-row animate-fadeIn">
        <div class="hidden md:flex w-1/2 bg-gradient-to-br from-indigo-600 to-purple-700 text-white items-center justify-center p-10 lg:p-16">
            <div class="text-center space-y-5">
                <h1 class="text-4xl lg:text-5xl font-extrabold tracking-tight">Vibe With Aasif</h1>
                <p class="text-lg lg:text-xl opacity-90">Join the community, share your vibes, and explore amazing posts.</p>
                <a href="{{ route('home') }}"
                   class="inline-flex items-center mt-4 px-6 py-3 bg-white text-indigo-700 font-semibold rounded-full shadow-lg hover:bg-gray-100 transition duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Back to Home
                </a>
            </div>
        </div>

        <div class="w-full md:w-1/2 p-6 sm:p-8 md:p-12 flex items-center justify-center">
            <div class="{{ $width }} w-full">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-6 text-center">{{ $title }}</h2>

                @if ($errors->any())
                    <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4 text-sm animate-shake">
                        <ul class="list-disc list-inside text-red-700 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Form Slot -->
                <div class="rounded-2xl bg-gray-50 p-6 sm:p-8 md:p-10 lg:p-14 shadow-inner">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>

    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fadeIn { animation: fadeIn 0.6s ease-out; }

        @keyframes shake {
            10%, 90% { transform: translateX(-2px); }
            20%, 80% { transform: translateX(4px); }
            30%, 50%, 70% { transform: translateX(-6px); }
            40%, 60% { transform: translateX(6px); }
        }
        .animate-shake { animation: shake 0.5s; }
    </style>

</body>
</html>

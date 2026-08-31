<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} - Vibe With Aasif</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Outfit:wght@500;600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Tailwind -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

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

<body class="min-h-screen bg-slate-950 flex items-center justify-center p-4 sm:p-6 selection:bg-purple-500 selection:text-white relative overflow-x-hidden">
    
    <!-- Ambient Background Blobs -->
    <div class="fixed top-[-10%] left-[-10%] w-[45vw] h-[45vw] rounded-full bg-purple-600/20 blur-[120px] pointer-events-none"></div>
    <div class="fixed bottom-[-10%] right-[-10%] w-[45vw] h-[45vw] rounded-full bg-pink-600/20 blur-[120px] pointer-events-none"></div>

    <div class="w-full max-w-5xl bg-white shadow-2xl rounded-3xl overflow-hidden flex flex-col md:flex-row border border-slate-200/40 relative z-10 animate-fadeIn">
        
        <!-- Left Showcase Side -->
        <div class="hidden md:flex w-5/12 bg-gradient-to-br from-slate-900 via-purple-950 to-indigo-950 text-white items-center justify-center p-8 lg:p-12 relative overflow-hidden">
            <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-pink-500/20 via-transparent to-transparent"></div>
            
            <div class="text-center space-y-6 relative z-10">
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-tr from-yellow-400 via-pink-500 to-purple-600 flex items-center justify-center shadow-xl shadow-purple-500/30 mx-auto">
                    <i class="fas fa-bolt text-white text-2xl"></i>
                </div>
                
                <div>
                    <h1 class="text-3xl lg:text-4xl font-extrabold tracking-tight font-heading">Vibe With Aasif</h1>
                    <p class="text-sm lg:text-base text-slate-300 mt-2 font-medium">Join the creator community, share captivating vibe stories, and inspire the world.</p>
                </div>

                <div class="pt-4">
                    <a href="{{ route('home') }}"
                       class="inline-flex items-center gap-2 px-5 py-2.5 bg-white/10 hover:bg-white/20 text-white font-semibold text-sm rounded-xl border border-white/20 backdrop-blur transition duration-300">
                        <i class="fas fa-arrow-left text-xs"></i>
                        Back to Home
                    </a>
                </div>
            </div>
        </div>

        <!-- Right Form Side -->
        <div class="w-full md:w-7/12 p-6 sm:p-10 lg:p-12 flex items-center justify-center bg-white">
            <div class="{{ $width ?? 'max-w-md' }} w-full">
                <div class="md:hidden flex items-center justify-between mb-6 pb-4 border-b border-slate-100">
                    <a href="{{ route('home') }}" class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-gradient-to-tr from-yellow-400 to-purple-600 flex items-center justify-center text-white text-xs font-bold">
                            <i class="fas fa-bolt"></i>
                        </div>
                        <span class="font-bold text-slate-900">Vibe With Aasif</span>
                    </a>
                    <a href="{{ route('home') }}" class="text-xs text-slate-500 hover:text-slate-800 font-semibold">
                        <i class="fas fa-arrow-left mr-1"></i> Home
                    </a>
                </div>

                <h2 class="text-2xl sm:text-3xl font-bold text-slate-900 mb-2 font-heading">{{ $title }}</h2>
                <p class="text-xs sm:text-sm text-slate-500 mb-6">Enter your details below to continue.</p>

                @if ($errors->any())
                    <div class="mb-6 rounded-2xl border border-red-200 bg-red-50/80 p-4 text-xs sm:text-sm animate-shake">
                        <ul class="list-disc list-inside text-red-700 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Form Slot -->
                <div>
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>

    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(16px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fadeIn { animation: fadeIn 0.4s ease-out; }

        @keyframes shake {
            10%, 90% { transform: translateX(-2px); }
            20%, 80% { transform: translateX(4px); }
            30%, 50%, 70% { transform: translateX(-6px); }
            40%, 60% { transform: translateX(6px); }
        }
        .animate-shake { animation: shake 0.4s; }
    </style>

</body>
</html>

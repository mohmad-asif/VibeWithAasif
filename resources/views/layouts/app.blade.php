<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 flex items-center justify-center p-4 text-gray-900">

    <div class="w-full max-w-md bg-white/90 backdrop-blur-sm shadow-2xl rounded-2xl overflow-hidden animate-fadeIn">

        <div class="text-center px-6 pt-8 pb-4 border-b border-gray-100">
            <h1 class="text-2xl md:text-3xl font-extrabold text-indigo-700">Vibe With Aasif</h1>
            <p class="text-sm text-gray-500 mt-1">{{ $title }}</p>
        </div>

        <div class="px-6 py-8">

            @if ($errors->any())
                <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4 text-sm animate-shake">
                    <ul class="list-disc list-inside text-red-700 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Content Slot -->
            <div class="rounded-2xl bg-gray-50 p-6 md:p-8 shadow-inner">
                {{ $slot }}
            </div>
        </div>

        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 text-center text-sm text-gray-500">
            &copy; {{ date('Y') }} Vibe With Aasif. All rights reserved.
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

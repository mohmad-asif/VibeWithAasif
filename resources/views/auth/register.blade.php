<x-layout title="Create Your Account 🚀" width="max-w-md">
    <form method="POST" action="{{ route('register.submit') }}" class="space-y-4">
        @csrf
        <div>
            <label class="block text-xs sm:text-sm font-semibold text-slate-700 mb-1.5">Full Name</label>
            <div class="relative">
                <input type="text" name="name" value="{{ old('name') }}" required autofocus
                    placeholder="Enter your full name"
                    class="w-full rounded-xl border border-slate-300 bg-slate-50/50 pl-10 pr-4 py-2.5 text-sm text-slate-900 focus:bg-white focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 focus:outline-none transition duration-200" />
                <i class="far fa-user absolute left-3.5 top-3.5 text-slate-400 text-xs"></i>
            </div>
        </div>

        <div>
            <label class="block text-xs sm:text-sm font-semibold text-slate-700 mb-1.5">Email Address</label>
            <div class="relative">
                <input type="email" name="email" value="{{ old('email') }}" required
                    placeholder="name@example.com"
                    class="w-full rounded-xl border border-slate-300 bg-slate-50/50 pl-10 pr-4 py-2.5 text-sm text-slate-900 focus:bg-white focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 focus:outline-none transition duration-200" />
                <i class="far fa-envelope absolute left-3.5 top-3.5 text-slate-400 text-xs"></i>
            </div>
        </div>

        <div>
            <label class="block text-xs sm:text-sm font-semibold text-slate-700 mb-1.5">Password</label>
            <div class="relative">
                <input type="password" name="password" required
                    placeholder="••••••••"
                    class="w-full rounded-xl border border-slate-300 bg-slate-50/50 pl-10 pr-4 py-2.5 text-sm text-slate-900 focus:bg-white focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 focus:outline-none transition duration-200" />
                <i class="fas fa-lock absolute left-3.5 top-3.5 text-slate-400 text-xs"></i>
            </div>
        </div>

        <div>
            <label class="block text-xs sm:text-sm font-semibold text-slate-700 mb-1.5">Confirm Password</label>
            <div class="relative">
                <input type="password" name="password_confirmation" required
                    placeholder="••••••••"
                    class="w-full rounded-xl border border-slate-300 bg-slate-50/50 pl-10 pr-4 py-2.5 text-sm text-slate-900 focus:bg-white focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 focus:outline-none transition duration-200" />
                <i class="fas fa-shield-alt absolute left-3.5 top-3.5 text-slate-400 text-xs"></i>
            </div>
        </div>

        <div class="pt-2">
            <button type="submit"
                class="w-full gradient-btn rounded-xl py-3 text-sm font-bold text-white shadow-md flex items-center justify-center gap-2">
                <i class="fas fa-user-plus text-xs"></i> Create Account
            </button>
        </div>

        <p class="text-center text-xs sm:text-sm text-slate-500 pt-3">
            Already have an account?
            <a href="{{ route('login') }}" class="font-bold text-purple-600 hover:text-purple-700 underline decoration-purple-400/40 underline-offset-2 ml-1">
                Log in
            </a>
        </p>
    </form>
</x-layout>
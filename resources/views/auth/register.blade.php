<x-layout title="Sign up" width="max-w-xl">
    <div class="flex items-center justify-center p-8">
        <div class="w-full space-y-6">
            <h2 class="text-3xl font-bold text-gray-900 text-center">Create your account</h2>

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium mb-1">Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                        placeholder="Enter Your Name"
                        class="w-full rounded-xl border-gray-300 px-3 py-2 focus:border-indigo-500 focus:ring-indigo-500" />
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                        placeholder="Enter Your Email"
                        class="w-full rounded-xl border-gray-300 px-3 py-2 focus:border-indigo-500 focus:ring-indigo-500" />
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Password</label>
                    <input type="password" name="password" required
                        placeholder="********"
                        class="w-full rounded-xl border-gray-300 px-3 py-2 focus:border-indigo-500 focus:ring-indigo-500" />
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Confirm Password</label>
                    <input type="password" name="password_confirmation" required
                        placeholder="Re-enter your password"
                        class="w-full rounded-xl border-gray-300 px-3 py-2 focus:border-indigo-500 focus:ring-indigo-500" />
                </div>
                <button type="submit"
                    class="w-full rounded-2xl bg-indigo-600 px-4 py-2 font-semibold text-white hover:bg-indigo-700">
                    Create account
                </button>
                <p class="text-center text-sm text-gray-600">Already have an account?
                    <a href="{{ route('login.show') }}" class="font-medium text-indigo-600 hover:underline">Log in</a>
                </p>
            </form>
        </div>
    </div>
</x-layout>
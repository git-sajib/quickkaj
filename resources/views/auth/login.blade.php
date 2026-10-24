<x-guest-layout>
    <div class="mb-6 text-center">
        <h1 class="text-2xl font-extrabold text-gray-900">{{ __('ui.login') ?? 'লগইন' }}</h1>
        <p class="text-sm text-gray-400 mt-1">{{ __('ui.login_subtitle') ?? 'আপনার অ্যাকাউন্টে প্রবেশ করুন' }}</p>
    </div>

    <form method="POST" action="{{ route('login') }}" id="login-form" class="space-y-4">
        @csrf

        {{-- Email --}}
        <div>
            <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">
                <i class="fa-regular fa-envelope mr-1 text-gray-400"></i>{{ __('Email') }}
            </label>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
                autofocus
                autocomplete="username"
                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-shadow @error('email') border-red-400 ring-1 ring-red-400 @enderror"
                placeholder="you@example.com"
            >
        </div>

        {{-- Password --}}
        <div>
            <div class="flex items-center justify-between mb-1">
                <label for="password" class="block text-sm font-semibold text-gray-700">
                    <i class="fa-solid fa-lock mr-1 text-gray-400"></i>{{ __('Password') }}
                </label>
                @if(Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-xs text-blue-600 hover:underline">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
            </div>
            <div class="relative">
                <input
                    id="password"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password"
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-shadow pr-10 @error('password') border-red-400 ring-1 ring-red-400 @enderror"
                    placeholder="••••••••"
                >
                <button type="button" onclick="togglePwd()" tabindex="-1"
                    class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors">
                    <i class="fa-regular fa-eye" id="pwd-eye"></i>
                </button>
            </div>
        </div>

        {{-- Remember --}}
        <div class="flex items-center gap-2">
            <input id="remember_me" type="checkbox" name="remember"
                class="w-4 h-4 rounded border-gray-300 accent-blue-600">
            <label for="remember_me" class="text-sm text-gray-600 select-none cursor-pointer">
                {{ __('Remember me') }}
            </label>
        </div>

        {{-- Submit --}}
        <button type="submit" id="login-btn"
            class="w-full bg-gradient-to-r from-blue-600 to-violet-600 hover:from-blue-700 hover:to-violet-700 text-white font-bold py-2.5 rounded-xl text-sm transition-all shadow-md hover:shadow-lg active:scale-[.98] flex items-center justify-center gap-2">
            <i class="fa-solid fa-right-to-bracket"></i>
            <span id="login-btn-text">{{ __('Log in') }}</span>
        </button>

        {{-- Register link --}}
        @if(Route::has('register'))
        <p class="text-center text-sm text-gray-400 pt-2">
            {{ __('Don\'t have an account?') }}
            <a href="{{ route('register') }}" class="text-blue-600 font-semibold hover:underline">
                {{ __('Register') }}
            </a>
        </p>
        @endif
    </form>

    <script>
    function togglePwd() {
        const pwd = document.getElementById('password');
        const eye = document.getElementById('pwd-eye');
        if (pwd.type === 'password') {
            pwd.type = 'text';
            eye.className = 'fa-regular fa-eye-slash';
        } else {
            pwd.type = 'password';
            eye.className = 'fa-regular fa-eye';
        }
    }

    document.getElementById('login-form').addEventListener('submit', function () {
        const btn  = document.getElementById('login-btn');
        const text = document.getElementById('login-btn-text');
        btn.disabled = true;
        btn.querySelector('.fa-right-to-bracket').className = 'fa-solid fa-spinner fa-spin';
        text.textContent = 'লগইন হচ্ছে…';
    });

    @if($errors->any())
    document.addEventListener('DOMContentLoaded', function () {
        window.toast.error('{{ $errors->first() }}', { duration: 6000 });
    });
    @endif

    @if(session('status'))
    document.addEventListener('DOMContentLoaded', function () {
        window.toast.success('{{ session('status') }}');
    });
    @endif
    </script>
</x-guest-layout>

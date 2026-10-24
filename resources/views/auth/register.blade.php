<x-guest-layout>
    <div class="mb-6 text-center">
        <h1 class="text-2xl font-extrabold text-gray-900">{{ __('Create Account') }}</h1>
        <p class="text-sm text-gray-400 mt-1">নতুন অ্যাকাউন্ট তৈরি করুন</p>
    </div>

    <form method="POST" action="{{ route('register') }}" id="reg-form" class="space-y-4">
        @csrf

        {{-- Name --}}
        <div>
            <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">
                <i class="fa-regular fa-user mr-1 text-gray-400"></i>{{ __('Name') }}
            </label>
            <input
                id="name"
                type="text"
                name="name"
                value="{{ old('name') }}"
                required
                autofocus
                autocomplete="name"
                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-shadow @error('name') border-red-400 ring-1 ring-red-400 @enderror"
                placeholder="{{ __('Full name') }}"
            >
        </div>

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
                autocomplete="username"
                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-shadow @error('email') border-red-400 ring-1 ring-red-400 @enderror"
                placeholder="you@example.com"
            >
        </div>

        {{-- Password --}}
        <div>
            <label for="password" class="block text-sm font-semibold text-gray-700 mb-1">
                <i class="fa-solid fa-lock mr-1 text-gray-400"></i>{{ __('Password') }}
            </label>
            <div class="relative">
                <input
                    id="password"
                    type="password"
                    name="password"
                    required
                    autocomplete="new-password"
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-shadow pr-10 @error('password') border-red-400 ring-1 ring-red-400 @enderror"
                    placeholder="কমপক্ষে ৮ অক্ষর"
                >
                <button type="button" onclick="togglePwd('password','eye1')" tabindex="-1"
                    class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors">
                    <i class="fa-regular fa-eye" id="eye1"></i>
                </button>
            </div>
        </div>

        {{-- Confirm Password --}}
        <div>
            <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-1">
                <i class="fa-solid fa-lock-open mr-1 text-gray-400"></i>{{ __('Confirm Password') }}
            </label>
            <div class="relative">
                <input
                    id="password_confirmation"
                    type="password"
                    name="password_confirmation"
                    required
                    autocomplete="new-password"
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-shadow pr-10"
                    placeholder="পাসওয়ার্ড পুনরায় দিন"
                >
                <button type="button" onclick="togglePwd('password_confirmation','eye2')" tabindex="-1"
                    class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors">
                    <i class="fa-regular fa-eye" id="eye2"></i>
                </button>
            </div>
        </div>

        {{-- Submit --}}
        <button type="submit" id="reg-btn"
            class="w-full bg-gradient-to-r from-blue-600 to-violet-600 hover:from-blue-700 hover:to-violet-700 text-white font-bold py-2.5 rounded-xl text-sm transition-all shadow-md hover:shadow-lg active:scale-[.98] flex items-center justify-center gap-2">
            <i class="fa-solid fa-user-plus" id="reg-icon"></i>
            <span id="reg-btn-text">{{ __('Register') }}</span>
        </button>

        {{-- Login link --}}
        <p class="text-center text-sm text-gray-400 pt-1">
            {{ __('Already registered?') }}
            <a href="{{ route('login') }}" class="text-blue-600 font-semibold hover:underline">
                {{ __('Log in') }}
            </a>
        </p>
    </form>

    <script>
    function togglePwd(inputId, eyeId) {
        const inp = document.getElementById(inputId);
        const eye = document.getElementById(eyeId);
        if (inp.type === 'password') {
            inp.type = 'text';
            eye.className = 'fa-regular fa-eye-slash';
        } else {
            inp.type = 'password';
            eye.className = 'fa-regular fa-eye';
        }
    }

    document.getElementById('reg-form').addEventListener('submit', function () {
        const btn  = document.getElementById('reg-btn');
        const text = document.getElementById('reg-btn-text');
        const icon = document.getElementById('reg-icon');
        btn.disabled = true;
        icon.className = 'fa-solid fa-spinner fa-spin';
        text.textContent = 'তৈরি হচ্ছে…';
    });

    @if($errors->any())
    document.addEventListener('DOMContentLoaded', function () {
        window.toast.error('{{ $errors->first() }}', { duration: 6000 });
    });
    @endif
    </script>
</x-guest-layout>

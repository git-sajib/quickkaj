@props([
    'url' => url()->current(),
    'title' => '',
])

<div class="mt-8 pt-6 border-t border-gray-100">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-gradient-to-r from-blue-50/50 via-white to-violet-50/50 p-4 rounded-2xl border border-gray-100 shadow-xs">
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 rounded-xl bg-blue-600 text-white flex items-center justify-center text-sm shadow-sm">
                <i class="fa-solid fa-share-nodes"></i>
            </div>
            <div>
                <p class="text-sm font-bold text-gray-900">{{ app()->getLocale() === 'bn' ? 'শেয়ার করুন' : 'Share this' }}</p>
                <p class="text-[11px] text-gray-400">{{ app()->getLocale() === 'bn' ? 'বন্ধুদের সাথে তথ্যটি শেয়ার করুন' : 'Spread the word with friends' }}</p>
            </div>
        </div>

        <div class="flex items-center gap-2 flex-wrap">
            {{-- Facebook --}}
            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($url) }}"
               target="_blank" rel="noopener noreferrer"
               class="w-9 h-9 rounded-xl bg-[#1877F2]/10 text-[#1877F2] hover:bg-[#1877F2] hover:text-white flex items-center justify-center transition-all duration-200 active:scale-95 shadow-xs"
               title="Facebook">
                <i class="fa-brands fa-facebook-f text-sm"></i>
            </a>

            {{-- WhatsApp --}}
            <a href="https://api.whatsapp.com/send?text={{ urlencode($title . ' ' . $url) }}"
               target="_blank" rel="noopener noreferrer"
               class="w-9 h-9 rounded-xl bg-[#25D366]/10 text-[#25D366] hover:bg-[#25D366] hover:text-white flex items-center justify-center transition-all duration-200 active:scale-95 shadow-xs"
               title="WhatsApp">
                <i class="fa-brands fa-whatsapp text-base"></i>
            </a>

            {{-- Messenger (Mobile / Web) --}}
            <a href="fb-messenger://share/?link={{ urlencode($url) }}"
               target="_blank" rel="noopener noreferrer"
               class="w-9 h-9 rounded-xl bg-[#00B2FF]/10 text-[#00B2FF] hover:bg-[#00B2FF] hover:text-white flex items-center justify-center transition-all duration-200 active:scale-95 shadow-xs"
               title="Messenger">
                <i class="fa-brands fa-facebook-messenger text-sm"></i>
            </a>

            {{-- Telegram --}}
            <a href="https://t.me/share/url?url={{ urlencode($url) }}&text={{ urlencode($title) }}"
               target="_blank" rel="noopener noreferrer"
               class="w-9 h-9 rounded-xl bg-[#229ED9]/10 text-[#229ED9] hover:bg-[#229ED9] hover:text-white flex items-center justify-center transition-all duration-200 active:scale-95 shadow-xs"
               title="Telegram">
                <i class="fa-brands fa-telegram text-base"></i>
            </a>

            {{-- X (Twitter) --}}
            <a href="https://twitter.com/intent/tweet?url={{ urlencode($url) }}&text={{ urlencode($title) }}"
               target="_blank" rel="noopener noreferrer"
               class="w-9 h-9 rounded-xl bg-gray-900/10 text-gray-900 hover:bg-gray-900 hover:text-white flex items-center justify-center transition-all duration-200 active:scale-95 shadow-xs"
               title="X (Twitter)">
                <i class="fa-brands fa-x-twitter text-sm"></i>
            </a>

            {{-- LinkedIn --}}
            <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode($url) }}"
               target="_blank" rel="noopener noreferrer"
               class="w-9 h-9 rounded-xl bg-[#0A66C2]/10 text-[#0A66C2] hover:bg-[#0A66C2] hover:text-white flex items-center justify-center transition-all duration-200 active:scale-95 shadow-xs"
               title="LinkedIn">
                <i class="fa-brands fa-linkedin-in text-sm"></i>
            </a>

            {{-- Copy Link Button (Works for Instagram, TikTok, etc.) --}}
            <button type="button"
                    onclick="copyShareUrl('{{ $url }}')"
                    class="h-9 px-3.5 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold flex items-center gap-1.5 transition-all duration-200 active:scale-95 shadow-xs"
                    title="{{ app()->getLocale() === 'bn' ? 'লিংক কপি করুন (Instagram, TikTok ইত্যাদির জন্য)' : 'Copy link (for Instagram, TikTok, etc.)' }}">
                <i class="fa-solid fa-link text-xs"></i>
                <span id="copy-btn-text">{{ app()->getLocale() === 'bn' ? 'লিংক কপি' : 'Copy' }}</span>
            </button>
        </div>
    </div>
</div>

<script>
function copyShareUrl(url) {
    if (navigator.clipboard && window.isSecureContext) {
        navigator.clipboard.writeText(url).then(onCopySuccess);
    } else {
        const input = document.createElement('textarea');
        input.value = url;
        document.body.appendChild(input);
        input.select();
        document.execCommand('copy');
        document.body.removeChild(input);
        onCopySuccess();
    }
}

function onCopySuccess() {
    const textEl = document.getElementById('copy-btn-text');
    if (textEl) {
        const originalText = textEl.textContent;
        textEl.textContent = '{{ app()->getLocale() === "bn" ? "কপি হয়েছে!" : "Copied!" }}';
        textEl.parentElement.classList.add('bg-emerald-100', 'text-emerald-700');
        setTimeout(() => {
            textEl.textContent = originalText;
            textEl.parentElement.classList.remove('bg-emerald-100', 'text-emerald-700');
        }, 2000);
    }
    if (window.toast && typeof window.toast.success === 'function') {
        window.toast.success('{{ app()->getLocale() === "bn" ? "লিংক ক্লিপবোর্ডে কপি করা হয়েছে!" : "Link copied to clipboard!" }}');
    }
}
</script>

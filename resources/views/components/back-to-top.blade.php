@php
    $isBn = app()->getLocale() === 'bn';
@endphp

<button
    id="back-to-top-btn"
    type="button"
    aria-label="{{ $isBn ? 'পৃষ্ঠার শুরুতে যান' : 'Back to Top' }}"
    title="{{ $isBn ? 'পৃষ্ঠার শুরুতে যান' : 'Back to Top' }}"
    onclick="scrollToTop()"
    class="fixed bottom-6 right-5 sm:right-6 z-40 w-12 h-12 rounded-full flex items-center justify-center
           bg-white/95 backdrop-blur-md text-blue-600 border border-blue-100 shadow-xl shadow-blue-500/15
           hover:bg-gradient-to-br hover:from-blue-600 hover:to-indigo-600 hover:text-white hover:border-transparent
           hover:shadow-blue-500/30 hover:-translate-y-1 active:translate-y-0 active:scale-95
           transition-all duration-300 ease-out group opacity-0 translate-y-6 pointer-events-none scale-90 print:hidden cursor-pointer">

    {{-- Circular Scroll Progress Indicator (SVG) --}}
    <svg class="absolute inset-0 w-full h-full -rotate-90 pointer-events-none" viewBox="0 0 44 44">
        {{-- Track --}}
        <circle
            cx="22" cy="22" r="18"
            class="text-blue-100/60 group-hover:text-white/20 transition-colors"
            stroke="currentColor" stroke-width="2.5" fill="none" />
        {{-- Progress Fill --}}
        <circle
            id="back-to-top-progress"
            cx="22" cy="22" r="18"
            class="text-blue-600 group-hover:text-white transition-colors duration-150"
            stroke="currentColor" stroke-width="2.5" stroke-linecap="round" fill="none"
            stroke-dasharray="113.1" stroke-dashoffset="113.1" />
    </svg>

    {{-- Center Arrow Icon --}}
    <i class="fa-solid fa-arrow-up text-sm sm:text-base relative z-10 transition-transform duration-200 group-hover:-translate-y-0.5"></i>
</button>

<script>
(function() {
    const btn = document.getElementById('back-to-top-btn');
    const progress = document.getElementById('back-to-top-progress');
    if (!btn || !progress) return;

    const circumference = 113.1; // 2 * PI * 18
    let isTicking = false;

    function updateScroll() {
        const scrollTop = window.scrollY || document.documentElement.scrollTop;
        const docHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;

        // Toggle visibility with smooth threshold (280px)
        if (scrollTop > 280) {
            btn.classList.remove('opacity-0', 'translate-y-6', 'pointer-events-none', 'scale-90');
            btn.classList.add('opacity-100', 'translate-y-0', 'pointer-events-auto', 'scale-100');
        } else {
            btn.classList.add('opacity-0', 'translate-y-6', 'pointer-events-none', 'scale-90');
            btn.classList.remove('opacity-100', 'translate-y-0', 'pointer-events-auto', 'scale-100');
        }

        // Calculate progress percentage
        if (docHeight > 0) {
            const scrollPercent = Math.min(Math.max(scrollTop / docHeight, 0), 1);
            const offset = circumference - (scrollPercent * circumference);
            progress.style.strokeDashoffset = offset;
        }

        isTicking = false;
    }

    window.addEventListener('scroll', function() {
        if (!isTicking) {
            window.requestAnimationFrame(updateScroll);
            isTicking = true;
        }
    }, { passive: true });

    // Initial check
    updateScroll();

    window.scrollToTop = function() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    };
})();
</script>

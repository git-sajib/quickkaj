@php
    $isBn = app()->getLocale() === 'bn';
@endphp

<button
    id="back-to-top-btn"
    type="button"
    aria-label="{{ $isBn ? 'পৃষ্ঠার শুরুতে যান' : 'Back to Top' }}"
    title="{{ $isBn ? 'পৃষ্ঠার শুরুতে যান' : 'Back to Top' }}"
    onclick="scrollToTop()"
    class="fixed z-40 w-12 h-12 rounded-full flex items-center justify-center
           bg-white text-blue-600 shadow-xl shadow-blue-900/15 border border-slate-200/90
           hover:bg-blue-600 hover:text-white hover:border-transparent hover:shadow-blue-500/30
           hover:-translate-y-1 active:translate-y-0 active:scale-95
           transition-all duration-300 ease-out group opacity-0 translate-y-6 pointer-events-none scale-90 print:hidden cursor-pointer"
    style="bottom: calc(1.25rem + env(safe-area-inset-bottom, 0px)); right: calc(1rem + env(safe-area-inset-right, 0px));">

    {{-- Circular Scroll Progress Indicator (SVG) --}}
    <svg class="absolute inset-0 w-full h-full -rotate-90 pointer-events-none" viewBox="0 0 46 46">
        {{-- Track Ring (Visible subtle background) --}}
        <circle
            cx="23" cy="23" r="19"
            class="text-slate-200 group-hover:text-white/30 transition-colors"
            stroke="currentColor" stroke-width="3" fill="none" />
        {{-- Active Progress Ring (Vibrant blue filling) --}}
        <circle
            id="back-to-top-progress"
            cx="23" cy="23" r="19"
            class="text-blue-600 group-hover:text-white transition-colors"
            stroke="currentColor" stroke-width="3" stroke-linecap="round" fill="none"
            stroke-dasharray="119.38" stroke-dashoffset="119.38"
            style="transition: stroke-dashoffset 0.06s linear;" />
    </svg>

    {{-- Center Arrow Icon --}}
    <i class="fa-solid fa-arrow-up text-sm sm:text-base relative z-10 transition-transform duration-200 group-hover:-translate-y-0.5"></i>
</button>

<script>
(function() {
    const btn = document.getElementById('back-to-top-btn');
    const progress = document.getElementById('back-to-top-progress');
    if (!btn || !progress) return;

    const circumference = 119.38; // 2 * Math.PI * 19
    let isTicking = false;

    function updateScrollProgress() {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop || 0;
        const scrollHeight = Math.max(
            document.body.scrollHeight,
            document.documentElement.scrollHeight,
            document.body.offsetHeight,
            document.documentElement.offsetHeight
        );
        const clientHeight = window.innerHeight || document.documentElement.clientHeight || 0;
        const maxScroll = Math.max(scrollHeight - clientHeight, 1);

        // Visibility Threshold (Show after scrolling 200px)
        if (scrollTop > 200) {
            btn.classList.remove('opacity-0', 'translate-y-6', 'pointer-events-none', 'scale-90');
            btn.classList.add('opacity-100', 'translate-y-0', 'pointer-events-auto', 'scale-100');
        } else {
            btn.classList.add('opacity-0', 'translate-y-6', 'pointer-events-none', 'scale-90');
            btn.classList.remove('opacity-100', 'translate-y-0', 'pointer-events-auto', 'scale-100');
        }

        // Calculate progress ratio (0 to 1)
        const scrollRatio = Math.min(Math.max(scrollTop / maxScroll, 0), 1);
        const offset = circumference * (1 - scrollRatio);

        // Apply via both attribute and style for 100% cross-browser reliability
        progress.setAttribute('stroke-dashoffset', offset.toFixed(2));
        progress.style.strokeDashoffset = offset.toFixed(2) + 'px';

        isTicking = false;
    }

    function onScroll() {
        if (!isTicking) {
            window.requestAnimationFrame(updateScrollProgress);
            isTicking = true;
        }
    }

    window.addEventListener('scroll', onScroll, { passive: true });
    window.addEventListener('resize', onScroll, { passive: true });

    // Initial check on load
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', updateScrollProgress);
    } else {
        updateScrollProgress();
    }

    window.scrollToTop = function() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    };
})();
</script>

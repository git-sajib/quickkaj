/**
 * Quickkaj Toast System — Sonner-inspired
 * Pure vanilla JS, no dependencies.
 * Usage:
 *   window.toast.success('সফল হয়েছে!')
 *   window.toast.error('ত্রুটি হয়েছে!')
 *   window.toast.info('তথ্য')
 *   window.toast.warning('সতর্কতা')
 *   window.toast.loading('লোড হচ্ছে...')
 *   window.toast.promise(fetchPromise, { loading:'লোড...', success:'সফল', error:'ব্যর্থ' })
 */
(function () {
    'use strict';

    // ── Container ────────────────────────────────────────────────────────────
    function getContainer() {
        let c = document.getElementById('pl-toast-container');
        if (!c) {
            c = document.createElement('div');
            c.id = 'pl-toast-container';
            c.setAttribute('aria-live', 'polite');
            c.setAttribute('aria-atomic', 'false');
            c.style.cssText = [
                'position:fixed', 'bottom:1.25rem', 'right:1.25rem',
                'z-index:99999', 'display:flex', 'flex-direction:column-reverse',
                'gap:0.5rem', 'pointer-events:none', 'max-width:360px', 'width:90vw',
            ].join(';');
            document.body.appendChild(c);
        }
        return c;
    }

    // ── Config ───────────────────────────────────────────────────────────────
    const CONFIGS = {
        success: {
            bg:     '#ecfdf5',
            border: '#6ee7b7',
            icon:   '✓',
            iconBg: '#10b981',
            text:   '#065f46',
        },
        error: {
            bg:     '#fef2f2',
            border: '#fca5a5',
            icon:   '✕',
            iconBg: '#ef4444',
            text:   '#7f1d1d',
        },
        warning: {
            bg:     '#fffbeb',
            border: '#fcd34d',
            icon:   '!',
            iconBg: '#f59e0b',
            text:   '#78350f',
        },
        info: {
            bg:     '#eff6ff',
            border: '#93c5fd',
            icon:   'i',
            iconBg: '#3b82f6',
            text:   '#1e3a8a',
        },
        loading: {
            bg:     '#f8fafc',
            border: '#cbd5e1',
            icon:   '↻',
            iconBg: '#6b7280',
            text:   '#1e293b',
        },
    };

    // ── Build a toast element ────────────────────────────────────────────────
    function buildToast(message, type, options = {}) {
        const cfg  = CONFIGS[type] || CONFIGS.info;
        const id   = 'pl-toast-' + Date.now() + Math.random();
        const wrap = document.createElement('div');

        wrap.id = id;
        wrap.setAttribute('role', 'alert');
        wrap.style.cssText = [
            `background:${cfg.bg}`,
            `border:1px solid ${cfg.border}`,
            `color:${cfg.text}`,
            'border-radius:0.875rem',
            'padding:0.75rem 1rem',
            'display:flex',
            'align-items:center',
            'gap:0.625rem',
            'font-family:var(--font-body,Inter,sans-serif)',
            'font-size:0.875rem',
            'font-weight:500',
            'line-height:1.4',
            'pointer-events:all',
            'box-shadow:0 4px 20px rgba(0,0,0,.08),0 1px 4px rgba(0,0,0,.06)',
            'cursor:default',
            'transition:opacity .25s,transform .25s',
            'opacity:0',
            'transform:translateY(10px) scale(.97)',
            'will-change:transform,opacity',
            'min-width:240px',
        ].join(';');

        // Icon badge
        const badge = document.createElement('span');
        badge.textContent = cfg.icon;
        badge.style.cssText = [
            `background:${cfg.iconBg}`,
            'color:#fff',
            'border-radius:50%',
            'width:1.5rem',
            'height:1.5rem',
            'display:inline-flex',
            'align-items:center',
            'justify-content:center',
            'font-size:.7rem',
            'font-weight:700',
            'flex-shrink:0',
            type === 'loading' ? 'animation:pl-spin 1s linear infinite' : '',
        ].join(';');

        // Message
        const msg = document.createElement('span');
        msg.style.cssText = 'flex:1;';
        msg.textContent = message;

        // Close button
        const close = document.createElement('button');
        close.innerHTML = '&times;';
        close.setAttribute('aria-label', 'Close');
        close.style.cssText = [
            'background:none', 'border:none', 'cursor:pointer',
            `color:${cfg.text}`, 'opacity:.5', 'font-size:1rem',
            'padding:0 0 0 0.25rem', 'line-height:1', 'flex-shrink:0',
        ].join(';');
        close.onmouseenter = () => { close.style.opacity = '1'; };
        close.onmouseleave = () => { close.style.opacity = '.5'; };
        close.onclick = () => dismiss(wrap);

        wrap.appendChild(badge);
        wrap.appendChild(msg);
        wrap.appendChild(close);

        return { el: wrap, id, badge, msg };
    }

    // ── Dismiss animation ────────────────────────────────────────────────────
    function dismiss(el) {
        el.style.opacity = '0';
        el.style.transform = 'translateY(10px) scale(.95)';
        setTimeout(() => el.remove(), 280);
    }

    // ── Show ─────────────────────────────────────────────────────────────────
    function show(message, type, options = {}) {
        const container = getContainer();
        const { el, id } = buildToast(message, type, options);
        container.appendChild(el);

        // Entrance animation
        requestAnimationFrame(() => {
            requestAnimationFrame(() => {
                el.style.opacity = '1';
                el.style.transform = 'translateY(0) scale(1)';
            });
        });

        // Auto-dismiss
        const duration = options.duration ?? (type === 'loading' ? 0 : 4500);
        let timer;
        if (duration > 0) {
            timer = setTimeout(() => dismiss(el), duration);
        }

        // Pause on hover
        if (duration > 0) {
            el.addEventListener('mouseenter', () => clearTimeout(timer));
            el.addEventListener('mouseleave', () => {
                timer = setTimeout(() => dismiss(el), 1500);
            });
        }

        return id;
    }

    // ── Promise helper ───────────────────────────────────────────────────────
    function toastPromise(promise, { loading = 'Loading...', success = 'Done!', error = 'Error!' } = {}) {
        const toastId = show(loading, 'loading', { duration: 0 });
        const el = document.getElementById(toastId);

        promise
            .then(result => {
                if (el) dismiss(el);
                show(typeof success === 'function' ? success(result) : success, 'success');
            })
            .catch(err => {
                if (el) dismiss(el);
                show(typeof error === 'function' ? error(err) : error, 'error');
            });

        return promise;
    }

    // ── Inject keyframe for loading spinner ─────────────────────────────────
    if (!document.getElementById('pl-toast-styles')) {
        const style = document.createElement('style');
        style.id = 'pl-toast-styles';
        style.textContent = '@keyframes pl-spin{to{transform:rotate(360deg)}}';
        document.head.appendChild(style);
    }

    // ── Public API ───────────────────────────────────────────────────────────
    window.toast = {
        success: (msg, opts) => show(msg, 'success', opts),
        error:   (msg, opts) => show(msg, 'error',   opts),
        warning: (msg, opts) => show(msg, 'warning', opts),
        info:    (msg, opts) => show(msg, 'info',    opts),
        loading: (msg, opts) => show(msg, 'loading', { ...opts, duration: 0 }),
        dismiss: (id)        => { const el = document.getElementById(id); if (el) dismiss(el); },
        promise: toastPromise,
    };

    // ── Auto-fire from Blade session flashes ─────────────────────────────────
    // Called by the layout after the DOM is ready.
    window.__plFlushSessionToasts = function (flashes) {
        if (!flashes) return;
        if (flashes.success) window.toast.success(flashes.success);
        if (flashes.error)   window.toast.error(flashes.error);
        if (flashes.warning) window.toast.warning(flashes.warning);
        if (flashes.info)    window.toast.info(flashes.info);
    };
})();

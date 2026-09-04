import '../css/core.scss';

const VERSION = '0.1.0';

function safeSetItem(key: string, value: string): void {
    try {
        localStorage.setItem(key, value);
    } catch {
        // localStorage can be unavailable (private mode, blocked cookies).
    }
}

// ui components attach to window.Pajak but most do not self-initialise; core owns the bootstrap.
function bootstrapUiComponents(root: ParentNode = document): void {
    const registry = window.Pajak;

    if (!registry) {
        return;
    }

    for (const component of Object.values(registry)) {
        if (typeof component?.initAll === 'function') {
            try {
                component.initAll(root);
            } catch {
                // A single failing component must not break the rest of the page.
            }
        }
    }
}

function initThemeToggles(): void {
    document.querySelectorAll<HTMLElement>('[data-pajak-core-theme-toggle]').forEach((toggle) => {
        toggle.addEventListener('click', () => {
            const isDark = document.documentElement.getAttribute('data-theme') === 'dark';

            if (isDark) {
                document.documentElement.removeAttribute('data-theme');
                safeSetItem('pajak-theme', 'light');
            } else {
                document.documentElement.setAttribute('data-theme', 'dark');
                safeSetItem('pajak-theme', 'dark');
            }
        });
    });
}

function renderFlashToasts(): void {
    document.querySelectorAll<HTMLElement>('[data-pajak-core-flash]').forEach((node) => {
        const raw = node.getAttribute('data-pajak-core-flash');
        node.remove();

        if (raw === null || raw === '') {
            return;
        }

        let payload: PajakToastPayload | null = null;

        try {
            payload = JSON.parse(raw) as PajakToastPayload;
        } catch {
            return;
        }

        if (payload === null || !payload.title) {
            return;
        }

        window.Pajak?.PajakToast?.show?.({
            type: payload.type ?? 'info',
            title: payload.title,
            message: payload.message,
        });
    });
}

function start(): void {
    bootstrapUiComponents();
    initThemeToggles();
    renderFlashToasts();
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', start);
} else {
    start();
}

window.PajakCore = { version: VERSION };

export const PAJAK_CORE_VERSION = VERSION;

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title !== '' ? $title . ' - ' : '' }}{{ $appName() }}</title>
    <script>
        try {
            if (localStorage.getItem('pajak-theme') === 'dark') {
                document.documentElement.setAttribute('data-theme', 'dark');
            }
        } catch (e) {}
    </script>

    @if($fontUrl() !== null)
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="{{ $fontUrl() }}" rel="stylesheet">
    @endif

    {!! $assetTags() !!}

    @stack('styles')
</head>
<body>
<div class="pajak-core-app">
    <x-pajak::sidebar id="pajak-core-sidebar">
        <x-slot:brand>
            <span class="pajak-core-brand">{{ $appName() }}</span>
            <button class="pajak-sb-rail-btn" type="button" data-pajak-sidebar-rail aria-label="{{ __('pajak-core::navigation.toggle_rail') }}">
                <x-heroicon-o-chevron-left width="18" height="18" aria-hidden="true" />
            </button>
        </x-slot:brand>

        <x-pajak-core::navigation />

        <x-slot:footer>
            <x-pajak-core::user-menu popover-id="pajak-core-user-menu" />
        </x-slot:footer>
    </x-pajak::sidebar>

    <dialog id="pajak-core-mobile-sidebar" data-pajak-sidebar>
        <x-pajak::sidebar>
            <x-slot:brand>
                <span class="pajak-core-brand">{{ $appName() }}</span>
            </x-slot:brand>

            <x-pajak-core::navigation />

            <x-slot:footer>
                <x-pajak-core::user-menu popover-id="pajak-core-user-menu-mobile" />
            </x-slot:footer>
        </x-pajak::sidebar>
    </dialog>

    <div class="pajak-core-main">
        <button
            class="pajak-sb-toggle pajak-core-mobile-trigger"
            type="button"
            data-pajak-sidebar-trigger="pajak-core-mobile-sidebar"
            aria-label="{{ __('pajak-core::navigation.open') }}"
        >
            <span class="pajak-sb-toggle__icon"><span></span><span></span><span></span></span>
        </button>

        <main class="pajak-core-content">
            {{ $slot }}
        </main>
    </div>

    <x-pajak-core::flash-toasts />
</div>

@stack('scripts')
</body>
</html>

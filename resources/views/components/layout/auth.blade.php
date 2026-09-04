<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title !== '' ? $title . ' — ' : '' }}{{ $appName() }}</title>
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
<div class="pajak-core-auth">
    <div class="pajak-core-auth__card">
        <div class="pajak-core-auth__brand">{{ $appName() }}</div>

        <x-pajak::card>
            {{ $slot }}
        </x-pajak::card>
    </div>
</div>

<x-pajak-core::flash-toasts />

@stack('scripts')
</body>
</html>

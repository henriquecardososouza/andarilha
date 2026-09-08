<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield("title", config('app.name', 'Andarilha'))</title>

    <meta name="robots" content="noindex, nofollow">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script>document.documentElement.classList.add('js')</script>

    <link rel="icon" type="image/png" href="{{ asset('assets/icon.png') }}">

    @fonts

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack("style")
</head>
<body class="min-h-screen bg-night-950 font-sans text-white antialiased">
    <div class="dot-grid" data-dot-grid aria-hidden="true">
        <div class="dot-grid__glow"></div>
    </div>

    @include("admin.partials.navbar")

    <main class="relative mx-auto max-w-[1400px] px-6 py-10 lg:py-14">
        @yield("content")
    </main>

    <x-admin::confirm-modal />

    @include("partials.toast")

    @stack("script")
</body>
</html>

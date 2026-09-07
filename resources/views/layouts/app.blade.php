<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield("title", config('app.name', 'Andarilha'))</title>

    <meta name="description" content="@yield('description')">

    <script>document.documentElement.classList.add('js')</script>

    <link rel="icon" type="image/png" href="{{ asset('assets/icon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/icon.png') }}">

    @fonts

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack("style")
</head>
<body class="min-h-screen bg-night-800 font-sans text-white antialiased">
    <div class="dot-grid" data-dot-grid aria-hidden="true">
        <div class="dot-grid__glow"></div>
    </div>

    @include("partials.header")

    <main>
        @yield("content")
    </main>

    @include("partials.footer")
    @include("partials.back-to-top")
    @include("partials.toast")

    @stack("script")
</body>
</html>

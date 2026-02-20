<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>

    @hasSection('meta')
        @yield('meta')
    @else
        {{-- Default Meta Tags --}}
        <meta name="description" content="{{ __('pages.hero_subtitle') }}">
        <meta property="og:site_name" content="{{ config('app.name', 'Laravel') }}">
        <meta property="og:title" content="{{ config('app.name', 'Laravel') }}">
        <meta property="og:description" content="{{ __('pages.hero_subtitle') }}">
        <meta property="og:image" content="{{ asset('img/avatar.jpg') }}">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:type" content="website">

        {{-- Default Twitter Card --}}
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="{{ config('app.name', 'Laravel') }}">
        <meta name="twitter:description" content="{{ __('pages.hero_subtitle') }}">
        <meta name="twitter:image" content="{{ asset('img/avatar.jpg') }}">
    @endif
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
<script defer src="https://stats.posesoart.ro/script.js" data-website-id="8119a26e-b8bb-409e-8c74-46a74a188299"></script>

</head>
<body>
    @include('partials.navbar')
    
    <main>
        @yield('content')
    </main>
    
    <!-- Footer inclus aici -->
    @include('partials.footer')
    
    <!-- Linia de mai jos a fost eliminata pentru ca este incorecta si redundanta -->
    <!-- @vite9('resources/css/app.css') -->
</body>
</html>

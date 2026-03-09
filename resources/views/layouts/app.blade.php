<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@yield('og:description', __('pages.hero_subtitle'))">
    <title>{{ config('app.name', 'Laravel') }}</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Instrument+Sans:ital,wght@0,400..700;1,400..700&display=swap">
<link rel="stylesheet" media="print" onload="this.onload=null;this.removeAttribute('media');" href="https://fonts.googleapis.com/css2?family=Instrument+Sans:ital,wght@0,400..700;1,400..700&display=swap">
<noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Instrument+Sans:ital,wght@0,400..700;1,400..700&display=swap"></noscript>
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="@yield('og:type', 'website')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('og:title', config('app.name', 'Laravel'))">
    <meta property="og:description" content="@yield('og:description', __('pages.hero_subtitle'))">
    <meta property="og:image" content="@yield('og:image', asset('img/avatar.jpg'))">
    <meta property="og:site_name" content="{{ config('app.name', 'Laravel') }}">
    <meta property="og:locale" content="{{ str_replace('_', '-', app()->getLocale()) }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="@yield('og:title', config('app.name', 'Laravel'))">
    <meta property="twitter:description" content="@yield('og:description', __('pages.hero_subtitle'))">
    <meta property="twitter:image" content="@yield('og:image', asset('img/avatar.jpg'))">

    @yield('meta')

   @vite(['resources/css/app.css'])
<link rel="preload" as="image" href="{{ asset('img/avatar-400.jpg') }}" fetchpriority="high">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" media="print" onload="this.media='all'">
<noscript><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"></noscript>
<script>
    // Amânăm încărcarea scriptului de analytics pentru a proteja scorul PageSpeed
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            var script = document.createElement('script');
            script.defer = true;
            script.src = "https://stats.posesoart.ro/script.js";
            script.setAttribute('data-website-id', '8119a26e-b8bb-409e-8c74-46a74a188299');
            document.head.appendChild(script);
        }, 3500); // Se va încărca complet în fundal după 3.5 secunde
    });
</script>
</head>
<body>
    @include('partials.navbar')
    
    <main>
        @yield('content')
    </main>
    
    <!-- Footer inclus aici -->
    @include('partials.footer')
    
    @include('partials.floating-contacts')
    @vite(['resources/js/app.js'])
</body>
</html>

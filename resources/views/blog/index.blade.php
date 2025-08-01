<!-- resources\views\blog\index.blade.php -->
@extends('layouts.app')
@section('content')
<section class="py-20 bg-black relative overflow-hidden">
    <!-- Background Elements (opțional, poți copia unele din home) -->
    <div class="absolute inset-0 z-0">
        <div class="absolute top-20 left-10 w-72 h-72 bg-purple-600/10 rounded-full blur-[100px] animate-pulse"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 bg-blue-600/10 rounded-full blur-[120px] animate-pulse delay-700"></div>
        <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" xmlns="http://www.w3.org/2000/svg"%3E%3Cdefs%3E%3Cpattern id="grid" width="60" height="60" patternUnits="userSpaceOnUse"%3E%3Cpath d="M 60 0 L 0 0 0 60" fill="none" stroke="rgba(255,255,255,0.03)" stroke-width="1"/%3E%3C/pattern%3E%3C/defs%3E%3Crect width="100%25" height="100%25" fill="url(%23grid)"/%3E%3C/svg%3E')] opacity-50"></div>
    </div>
    <div class="container relative z-10">
        <header class="mb-16 text-center">
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6">
                <span class="bg-gradient-to-r from-purple-400 via-blue-400 to-cyan-400 bg-clip-text text-transparent animate-gradient-x bg-[length:200%_auto]">
                    {{ __('blog.title') }}
                </span>
            </h1>
            <p class="text-lg md:text-xl text-gray-400 max-w-3xl mx-auto">
                {{ __('blog.subtitle') }}
            </p>
        </header>
        @if($posts->count() > 0)
            <!-- Grid Container pentru articole -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                @foreach($posts as $post)
                    <article class="group relative bg-white/5 backdrop-blur-xl border border-white/10 rounded-3xl overflow-hidden hover:bg-white/10 hover:border-white/20 transition-all duration-500 hover:shadow-[0_20px_60px_rgba(0,0,0,0.5)] transform hover:-translate-y-2">
                        <!-- Imagine Featured -->
                        @if($post->featured_image)
                            <div class="aspect-video overflow-hidden">
                                <img src="{{ $post->image_url }}"
                                     alt="{{ $post->getLocalizedTitle() }}" {{-- Actualizat --}}
                                     class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            </div>
                        @endif
                        <!-- Conținut Card -->
                        <div class="p-6">
                            <!-- Meta Informații -->
                            <div class="flex flex-wrap items-center text-gray-400 text-xs mb-4 gap-2">
                                <span class="px-2 py-1 bg-purple-500/20 text-purple-300 rounded-full">
                                    {{ $post->user->name }}
                                </span>
                                <span>•</span>
                                <time datetime="{{ $post->published_at->toDateString() }}">
                                    {{ $post->published_at->format('M d, Y') }}
                                </time>
                                @if($post->reading_time)
                                    <span>•</span>
                                    <span>{{ $post->reading_time }} min</span>
                                @endif
                            </div>
                            <!-- Titlu -->
                            <h2 class="text-xl font-bold text-white mb-3 group-hover:text-purple-400 transition-colors duration-300 line-clamp-2">
                                <a href="{{ route('blog.show', ['locale' => app()->getLocale(), 'slug' => $post->getLocalizedSlug()]) }}"> {{-- Actualizat --}}
                                    {{ $post->getLocalizedTitle() }} {{-- Actualizat --}}
                                </a>
                            </h2>
                            <!-- Excerpt -->
                            @if($post->getTranslation('excerpt', app()->getLocale()))
                                <p class="text-gray-300 text-sm mb-4 line-clamp-3">
                                    {{ $post->getTranslation('excerpt', app()->getLocale()) }}
                                </p>
                            @endif
                            <!-- Meta Keywords (opțional, mai compact) -->
                            @if($post->meta_keywords && is_array($post->meta_keywords))
                                <div class="flex flex-wrap gap-1 mb-4">
                                    @foreach(array_slice($post->meta_keywords, 0, 3) as $keyword) {{-- Limităm la 3 --}}
                                        <span class="px-2 py-1 bg-white/10 text-gray-400 rounded-full text-xs">
                                            {{ $keyword }}
                                        </span>
                                    @endforeach
                                    @if(count($post->meta_keywords) > 3)
                                        <span class="px-2 py-1 bg-white/10 text-gray-400 rounded-full text-xs">
                                            +{{ count($post->meta_keywords) - 3 }}
                                        </span>
                                    @endif
                                </div>
                            @endif
                            <!-- Link Citește Mai Mult -->
                            <a href="{{ route('blog.show', ['locale' => app()->getLocale(), 'slug' => $post->getLocalizedSlug()]) }}" {{-- CORECTAT AICI --}}
                               class="inline-flex items-center text-purple-400 hover:text-purple-300 font-medium text-sm group-hover:translate-x-1 transition-transform duration-300">
                                {{ __('blog.read_more') }}
                                <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>
            <!-- Paginare -->
            <div class="mt-16 flex justify-center">
                {{ $posts->links() }} {{-- Afișează linkurile de paginare --}}
            </div>
        @else
            <div class="text-center py-20">
                <div class="w-24 h-24 bg-gradient-to-br from-purple-600/20 to-blue-600/20 rounded-full flex items-center justify-center mx-auto mb-6 border border-white/10">
                    <i class="fas fa-newspaper text-4xl text-purple-400/50"></i>
                </div>
                <h2 class="text-2xl md:text-3xl font-semibold text-white mb-4">{{ __('blog.no_posts') }}</h2>
                <p class="text-gray-400 max-w-xl mx-auto">{{ __('blog.no_posts_message') }}</p>
            </div>
        @endif
    </div>
</section>
<!-- CSS Suplimentar pentru animații (opțional, dacă nu sunt definite global) -->
<style>
/* Dacă nu sunt deja definite în layout sau home, adaugă-le aici */
@keyframes gradient-x {
  0%, 100% {
    background-position: 0% 50%;
  }
  50% {
    background-position: 100% 50%;
  }
}
.animate-gradient-x {
  animation: gradient-x 3s ease infinite;
  background-size: 200% auto;
}
/* Clamp lines */
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endsection
<!-- resources\views\blog\show.blade.php -->
@extends('layouts.app')

@section('content')
<!-- Hero Section cu fundal animat pentru articol -->
<section class="relative py-20 md:py-32 bg-black overflow-hidden">
    <!-- Background Elements (copiate și adaptate din home) -->
    <div class="absolute inset-0 z-0">
        <div class="absolute top-20 left-10 w-72 h-72 bg-purple-600/10 rounded-full blur-[100px] animate-pulse"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 bg-blue-600/10 rounded-full blur-[120px] animate-pulse delay-700"></div>
        <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" xmlns="http://www.w3.org/2000/svg"%3E%3Cdefs%3E%3Cpattern id="grid" width="60" height="60" patternUnits="userSpaceOnUse"%3E%3Cpath d="M 60 0 L 0 0 0 60" fill="none" stroke="rgba(255,255,255,0.03)" stroke-width="1"/%3E%3C/pattern%3E%3C/defs%3E%3Crect width="100%25" height="100%25" fill="url(%23grid)"/%3E%3C/svg%3E')] opacity-50"></div>
    </div>

    <div class="container relative z-10 max-w-4xl">
        <article>
            <!-- Imagine Featured cu efecte -->
            @if($post->featured_image)
                <div class="aspect-video rounded-3xl overflow-hidden mb-10 shadow-2xl border border-white/10 transform transition-all duration-700 hover:shadow-[0_20px_60px_rgba(0,0,0,0.5)]">
                    <img src="{{ $post->image_url }}"
                         alt="{{ $post->getTranslation('title', app()->getLocale()) }}" {{-- Alt text tradus --}}
                         class="w-full h-full object-cover transition-transform duration-1000 hover:scale-105">
                </div>
            @endif

            <!-- Header Articol -->
            <header class="mb-10">
                <!-- Meta Informații -->
                <div class="flex flex-wrap items-center text-gray-400 text-sm mb-6 gap-3">
                    <!-- Autor -->
                    <div class="flex items-center space-x-2">
                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-purple-500 to-blue-500 flex items-center justify-center text-white text-xs font-bold">
                            {{ strtoupper(substr($post->user->name, 0, 1)) }}
                        </div>
                        <span class="font-medium">{{ $post->user->name }}</span>
                    </div>
                    <span class="hidden md:block">•</span>
                    <!-- Dată Publicare -->
                    <time datetime="{{ $post->published_at->toDateString() }}" class="flex items-center">
                        <i class="far fa-calendar-alt mr-2 text-purple-400"></i>
                        {{ $post->published_at->format('M d, Y') }}
                    </time>
                    <span class="hidden md:block">•</span>
                    <!-- Timp de Citire -->
                    @if($post->reading_time)
                        <span class="flex items-center">
                            <i class="far fa-clock mr-2 text-blue-400"></i>
                            {{ $post->reading_time }} {{ __('blog.reading_time') }}
                        </span>
                    @endif
                </div>

                <!-- Titlu -->
                <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-6 leading-tight">
                    <span class="bg-gradient-to-r from-purple-400 via-blue-400 to-cyan-400 bg-clip-text text-transparent animate-gradient-x bg-[length:200%_auto]">
                        {{ $post->getTranslation('title', app()->getLocale()) }} {{-- Titlu tradus --}}
                    </span>
                </h1>

                <!-- Meta Keywords -->
                @if($post->meta_keywords && is_array($post->meta_keywords))
                    <div class="flex flex-wrap gap-2">
                        @foreach($post->meta_keywords as $keyword)
                            <span class="px-3 py-1.5 bg-gradient-to-r from-purple-600/30 to-blue-600/30 text-purple-300 border border-purple-500/30 rounded-full text-xs font-medium backdrop-blur-sm">
                                <i class="fas fa-tag mr-1"></i> {{ $keyword }}
                            </span>
                        @endforeach
                    </div>
                @endif
            </header>

            <!-- Conținut Articol -->
            <div class="prose prose-invert prose-lg max-w-none
                        prose-headings:text-white prose-h1:text-3xl prose-h2:text-2xl prose-h3:text-xl
                        prose-p:text-gray-300 prose-a:text-purple-400 hover:prose-a:text-purple-300
                        prose-strong:text-white prose-em:text-gray-200
                        prose-blockquote:border-l-purple-500 prose-blockquote:text-gray-300
                        prose-li:text-gray-300 prose-li:marker:text-purple-400
                        prose-code:bg-black/50 prose-code:text-purple-300 prose-code:px-1.5 prose-code:py-0.5 prose-code:rounded
                        prose-pre:bg-black/50 prose-pre:border prose-pre:border-white/10
                        prose-img:rounded-2xl prose-img:shadow-lg
                        prose-table:text-gray-300 prose-th:bg-white/5 prose-th:border prose-th:border-white/10 prose-td:border prose-td:border-white/10">
                {!! $post->getTranslation('content', app()->getLocale()) !!} {{-- Conținut tradus --}}
            </div>
        </article>

        <!-- Articole Recente -->
        @if($recentPosts->count() > 0)
            <section class="mt-24 pt-12 border-t border-white/10">
                <div class="flex items-center justify-between mb-10">
                    <h2 class="text-2xl md:text-3xl font-bold text-white">
                        <span class="bg-gradient-to-r from-purple-400 via-blue-400 to-cyan-400 bg-clip-text text-transparent">
                            {{ __('blog.recent_posts') }}
                        </span>
                    </h2>
                    <a href="{{ route('blog.index', app()->getLocale()) }}" class="text-purple-400 hover:text-purple-300 text-sm font-medium flex items-center group">
                        {{ __('blog.view_all') }}
                        <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform duration-300"></i>
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach($recentPosts as $recentPost)
                        <article class="group bg-white/5 backdrop-blur-xl border border-white/10 rounded-3xl overflow-hidden hover:bg-white/10 hover:border-white/20 transition-all duration-500 hover:shadow-[0_10px_40px_rgba(0,0,0,0.3)]">
                            @if($recentPost->featured_image)
                                <div class="aspect-video overflow-hidden">
                                    <img src="{{ $recentPost->image_url }}"
                                         alt="{{ $recentPost->getTranslation('title', app()->getLocale()) }}" {{-- Alt text tradus --}}
                                         class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                </div>
                            @endif
                            <div class="p-6">
                                <h3 class="text-lg font-bold text-white mb-3 group-hover:text-purple-400 transition-colors duration-300 line-clamp-2">
                                    <a href="{{ route('blog.show', ['locale' => app()->getLocale(), 'slug' => $recentPost->getTranslation('slug', app()->getLocale())]) }}"> {{-- Slug tradus --}}
                                        {{ $recentPost->getTranslation('title', app()->getLocale()) }} {{-- Titlu tradus --}}
                                    </a>
                                </h3>
                                <div class="flex items-center text-gray-400 text-xs">
                                    <time datetime="{{ $recentPost->published_at->toDateString() }}">
                                        {{ $recentPost->published_at->format('M d') }}
                                    </time>
                                    @if($recentPost->reading_time)
                                        <span class="mx-2">•</span>
                                        <span>{{ $recentPost->reading_time }} min</span>
                                    @endif
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </section>
        @endif
    </div>
</section>

<!-- CSS Suplimentar (dacă nu sunt definite global) -->
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
</style>
@endsection
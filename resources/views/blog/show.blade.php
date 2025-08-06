@extends('layouts.app')

@section('content')
<!-- Hero Section pentru articol cu design premium -->
<section class="relative py-20 md:py-32 bg-black overflow-hidden">
    <!-- Background Elements cu efecte animate -->
    <div class="absolute inset-0 z-0">
        <div class="absolute top-20 left-10 w-72 h-72 bg-purple-600/10 rounded-full blur-[100px] animate-pulse"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 bg-blue-600/10 rounded-full blur-[120px] animate-pulse delay-700"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-cyan-600/5 rounded-full blur-[150px] animate-pulse delay-1000"></div>
        
        <!-- Animated Grid -->
        <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" xmlns="http://www.w3.org/2000/svg"%3E%3Cdefs%3E%3Cpattern id="grid" width="60" height="60" patternUnits="userSpaceOnUse"%3E%3Cpath d="M 60 0 L 0 0 0 60" fill="none" stroke="rgba(255,255,255,0.03)" stroke-width="1"/%3E%3C/pattern%3E%3C/defs%3E%3Crect width="100%25" height="100%25" fill="url(%23grid)"/%3E%3C/svg%3E')] opacity-50"></div>
        
        <!-- Floating Elements -->
        <div class="absolute top-1/4 left-1/4 w-2 h-2 bg-purple-400 rounded-full animate-ping"></div>
        <div class="absolute top-3/4 right-1/3 w-3 h-3 bg-blue-400 rounded-full animate-ping delay-500"></div>
        <div class="absolute bottom-1/4 left-1/3 w-2 h-2 bg-cyan-400 rounded-full animate-ping delay-1000"></div>
    </div>
    
    <div class="container relative z-10 max-w-4xl">
        <article>
            <!-- Breadcrumb Navigation -->
            <nav class="mb-8 text-sm">
                <ol class="flex items-center space-x-2 text-gray-400">
                    <li>
                        <a href="{{ route('home', app()->getLocale()) }}" class="hover:text-white transition-colors">
                            <i class="fas fa-home mr-1"></i> Home
                        </a>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-chevron-right mx-2 text-xs"></i>
                        <a href="{{ route('blog.index', app()->getLocale()) }}" class="hover:text-white transition-colors">
                            Blog
                        </a>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-chevron-right mx-2 text-xs"></i>
                        <span class="text-gray-300 truncate max-w-xs">{{ $post->getLocalizedTitle() }}</span>
                    </li>
                </ol>
            </nav>
            
            <!-- Imagine Featured cu efecte 3D -->
            @if($post->featured_image)
                <div class="relative group perspective-1000 mb-12">
                    <!-- Decorative Elements -->
                    <div class="absolute -top-6 -left-6 w-24 h-24 bg-gradient-to-br from-purple-600 to-blue-600 rounded-3xl opacity-20 blur-xl animate-pulse"></div>
                    <div class="absolute -bottom-6 -right-6 w-32 h-32 bg-gradient-to-br from-blue-600 to-cyan-600 rounded-3xl opacity-20 blur-xl animate-pulse delay-500"></div>
                    
                    <!-- Image Frame cu 3D tilt -->
                    <div class="relative rounded-3xl overflow-hidden transform-gpu transition-all duration-700 group-hover:rotate-y-6 shadow-2xl border border-white/10">
                        <div class="absolute inset-0 bg-gradient-to-br from-purple-600/20 via-transparent to-blue-600/20 z-10 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        <img src="{{ $post->image_url }}"
                             alt="{{ $post->getLocalizedTitle() }}"
                             class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-1000">
                    </div>
                </div>
            @endif
            
            <!-- Header Articol cu efecte vizuale -->
            <header class="mb-12 relative">
                <!-- Meta Informații cu card design -->
                <div class="inline-flex flex-wrap items-center bg-black/40 backdrop-blur-sm border border-white/10 rounded-full px-6 py-3 mb-8">
                    <!-- Autor cu avatar -->
                    <div class="flex items-center space-x-3 mr-6 pr-6 border-r border-white/10">
                        <div class="relative">
                            <div class="absolute -inset-1 bg-gradient-to-r from-purple-600 to-blue-600 rounded-full opacity-70 blur-sm"></div>
                            <div class="relative w-10 h-10 rounded-full bg-black flex items-center justify-center text-white font-bold text-sm">
                                {{ strtoupper(substr($post->user->name, 0, 1)) }}
                            </div>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400">Author</p>
                            <p class="text-white font-medium">{{ $post->user->name }}</p>
                        </div>
                    </div>
                    
                    <!-- Dată Publicare -->
                    <div class="flex items-center space-x-2 mr-6 pr-6 border-r border-white/10">
                        <div class="w-8 h-8 rounded-full bg-purple-500/20 flex items-center justify-center">
                            <i class="far fa-calendar-alt text-purple-400 text-sm"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400">Published</p>
                            <time datetime="{{ $post->published_at->toDateString() }}" class="text-white">
                                {{ $post->published_at->format('M d, Y') }}
                            </time>
                        </div>
                    </div>
                    
                    <!-- Timp de Citire -->
                    @if($post->reading_time)
                        <div class="flex items-center space-x-2">
                            <div class="w-8 h-8 rounded-full bg-blue-500/20 flex items-center justify-center">
                                <i class="far fa-clock text-blue-400 text-sm"></i>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400">Reading Time</p>
                                <p class="text-white">{{ $post->reading_time }} min</p>
                            </div>
                        </div>
                    @endif
                </div>
                
                <!-- Titlu cu efecte de lumina -->
                <div class="relative mb-8">
                    <div class="absolute -inset-1 bg-gradient-to-r from-purple-600 to-blue-600 rounded-2xl opacity-30 blur-lg"></div>
                    <div class="relative bg-black/80 backdrop-blur-sm rounded-2xl p-1">
                        <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-6 leading-tight px-4 py-2">
                            <span class="bg-gradient-to-r from-purple-400 via-blue-400 to-cyan-400 bg-clip-text text-transparent animate-gradient-x bg-[length:200%_auto]">
                                {{ $post->getLocalizedTitle() }}
                            </span>
                        </h1>
                    </div>
                </div>
                
                <!-- Meta Keywords cu design îmbunătățit -->
                @if($post->meta_keywords && is_array($post->meta_keywords))
                    <div class="flex flex-wrap gap-2">
                        @foreach($post->meta_keywords as $keyword)
                            <span class="group relative px-4 py-2 bg-gradient-to-r from-purple-600/30 to-blue-600/30 text-purple-300 border border-purple-500/30 rounded-full text-xs font-medium backdrop-blur-sm hover:from-purple-600/50 hover:to-blue-600/50 transition-all duration-300">
                                <i class="fas fa-tag mr-1.5"></i> {{ $keyword }}
                                <span class="absolute inset-0 rounded-full bg-white/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></span>
                            </span>
                        @endforeach
                    </div>
                @endif
            </header>
            
            <!-- Conținut Articol cu design premium -->
            <div class="relative">
                <!-- Decorative corner elements -->
                <div class="absolute -top-6 -left-6 w-16 h-16 bg-gradient-to-br from-purple-600 to-blue-600 rounded-2xl opacity-20 blur-xl"></div>
                <div class="absolute -bottom-6 -right-6 w-16 h-16 bg-gradient-to-br from-blue-600 to-cyan-600 rounded-2xl opacity-20 blur-xl"></div>
                
               <div class="relative bg-black/40 backdrop-blur-sm border border-white/10 rounded-3xl p-8 md:p-12 prose prose-invert prose-xl max-w-none
            prose-headings:text-white prose-h1:text-3xl prose-h2:text-2xl prose-h3:text-xl
            prose-p:text-white prose-a:text-purple-400 hover:prose-a:text-purple-300
            prose-strong:text-white prose-em:text-gray-200
            prose-blockquote:border-l-purple-500 prose-blockquote:text-gray-300 prose-blockquote:bg-purple-900/10 prose-blockquote:px-6 prose-blockquote:py-4 prose-blockquote:rounded-r-2xl
            prose-li:text-gray-300 prose-li:marker:text-purple-400
            prose-code:bg-black/50 prose-code:text-purple-300 prose-code:px-1.5 prose-code:py-0.5 prose-code:rounded prose-code:border prose-code:border-purple-500/30
            prose-pre:bg-black/50 prose-pre:border prose-pre:border-white/10 prose-pre:rounded-xl prose-pre:overflow-hidden
            prose-img:rounded-2xl prose-img:shadow-lg prose-img:border prose-img:border-white/10
            prose-table:text-gray-300 prose-th:bg-white/5 prose-th:border prose-th:border-white/10 prose-td:border prose-td:border-white/10 prose-table:rounded-xl prose-table:overflow-hidden
            article-content-bright">
    {!! $post->getTranslation('content', app()->getLocale()) !!}
</div>
            </div>
            
            <!-- Share Buttons -->
            <!-- Share Buttons -->
<div class="mt-12 pt-8 border-t border-white/10">
    <h3 class="text-lg font-semibold text-white mb-4">Share this article</h3>
    <div class="flex space-x-4">
        <!-- Twitter -->
        <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($post->getLocalizedTitle()) }}"
           target="_blank"
           class="w-12 h-12 rounded-full bg-gradient-to-br from-purple-600 to-blue-600 flex items-center justify-center text-white hover:scale-110 transition-transform duration-300 shadow-lg"
           aria-label="Share on Twitter">
            <i class="fab fa-twitter"></i>
        </a>

        <!-- LinkedIn -->
        <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}"
           target="_blank"
           class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-600 to-cyan-600 flex items-center justify-center text-white hover:scale-110 transition-transform duration-300 shadow-lg"
           aria-label="Share on LinkedIn">
            <i class="fab fa-linkedin"></i>
        </a>

        <!-- Facebook -->
        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
           target="_blank"
           class="w-12 h-12 rounded-full bg-gradient-to-br from-pink-600 to-purple-600 flex items-center justify-center text-white hover:scale-110 transition-transform duration-300 shadow-lg"
           aria-label="Share on Facebook">
            <i class="fab fa-facebook"></i>
        </a>

        <!-- WhatsApp -->
        <a href="https://wa.me/?text={{ urlencode($post->getLocalizedTitle() . ' ' . url()->current()) }}"
           target="_blank"
           class="w-12 h-12 rounded-full bg-gradient-to-br from-green-600 to-emerald-600 flex items-center justify-center text-white hover:scale-110 transition-transform duration-300 shadow-lg"
           aria-label="Share on WhatsApp">
            <i class="fab fa-whatsapp"></i>
        </a>
    </div>
</div>
        </article>
        
        <!-- Articole Recente cu design îmbunătățit -->
        @if($recentPosts->count() > 0)
            <section class="mt-24 pt-16 border-t border-white/10 relative">
                <!-- Section Header -->
                <div class="flex items-center justify-between mb-12">
                    <div>
                        <span class="text-purple-400 tracking-wider uppercase text-sm flex items-center gap-2">
                            <span class="w-8 h-[2px] bg-purple-400"></span>
                            {{ __('blog.recent_posts') }}
                        </span>
                        <h2 class="text-2xl md:text-3xl font-bold text-white mt-2">
                            <span class="bg-gradient-to-r from-purple-400 via-blue-400 to-cyan-400 bg-clip-text text-transparent">
                                You might also like
                            </span>
                        </h2>
                    </div>
                    <a href="{{ route('blog.index', app()->getLocale()) }}" class="group relative inline-flex items-center space-x-2">
                        <div class="absolute -inset-2 bg-gradient-to-r from-purple-600 to-blue-600 rounded-full opacity-0 blur group-hover:opacity-60 transition duration-300"></div>
                        <span class="relative px-6 py-2 bg-black border border-white/10 rounded-full text-gray-300 group-hover:text-white group-hover:border-white/20 font-medium transition-all duration-300">
                            {{ __('blog.view_all') }}
                            <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform duration-300"></i>
                        </span>
                    </a>
                </div>
                
                <!-- Recent Posts Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach($recentPosts as $recentPost)
                        <article class="group relative transform hover:-translate-y-2 transition-all duration-500">
                            <!-- Glow Effect on Hover -->
                            <div class="absolute inset-0 bg-gradient-to-r from-purple-600/20 to-blue-600/20 rounded-3xl blur-xl opacity-0 group-hover:opacity-100 group-hover:shadow-[0_0_25px_rgba(139,92,246,0.3)] transition-all duration-500"></div>
                            
                            <!-- Card Content -->
                            <div class="relative bg-white/5 backdrop-blur-xl border border-white/10 rounded-3xl overflow-hidden hover:bg-white/10 hover:border-white/20 transition-all duration-300 hover:shadow-[0_20px_60px_rgba(0,0,0,0.5)] h-full flex flex-col">
                                <!-- Featured Image -->
                                @if($recentPost->featured_image)
                                    <div class="aspect-video overflow-hidden">
                                        <img src="{{ $recentPost->image_url }}"
                                             alt="{{ $recentPost->getLocalizedTitle() }}"
                                             class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                    </div>
                                @endif
                                
                                <!-- Content -->
                                <div class="p-6 flex flex-col flex-grow">
                                    <!-- Meta Information -->
                                    <div class="flex items-center text-gray-400 text-xs mb-4">
                                        <time datetime="{{ $recentPost->published_at->toDateString() }}" class="flex items-center">
                                            <i class="far fa-calendar mr-1.5"></i>
                                            {{ $recentPost->published_at->format('M d, Y') }}
                                        </time>
                                        @if($recentPost->reading_time)
                                            <span class="mx-2">•</span>
                                            <span class="flex items-center">
                                                <i class="far fa-clock mr-1.5"></i>
                                                {{ $recentPost->reading_time }} min
                                            </span>
                                        @endif
                                    </div>
                                    
                                    <!-- Title -->
                                    <h3 class="text-lg font-bold text-white mb-3 group-hover:text-purple-400 transition-colors duration-300 line-clamp-2">
                                        <a href="{{ route('blog.show', ['locale' => app()->getLocale(), 'slug' => $recentPost->getLocalizedSlug()]) }}">
                                            {{ $recentPost->getLocalizedTitle() }}
                                        </a>
                                    </h3>
                                    
                                    <!-- Excerpt -->
                                    @if($recentPost->getTranslation('excerpt', app()->getLocale()))
                                        <p class="text-gray-400 text-sm mb-4 line-clamp-2 flex-grow">
                                            {{ $recentPost->getTranslation('excerpt', app()->getLocale()) }}
                                        </p>
                                    @endif
                                    
                                    <!-- Read More Button -->
                                    <div class="mt-auto">
                                        <a href="{{ route('blog.show', ['locale' => app()->getLocale(), 'slug' => $recentPost->getLocalizedSlug()]) }}"
                                           class="inline-flex items-center text-purple-400 hover:text-purple-300 text-sm font-medium group/btn">
                                            Read Article
                                            <svg class="w-4 h-4 ml-2 group-hover/btn:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </section>
        @endif
    </div>
</section>


<!-- CSS Suplimentar -->
<style>
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

.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.perspective-1000 {
  perspective: 1000px;
}

.rotate-y-6 {
  transform: rotateY(6deg);
}
<style>
/* ... regulile tale existente ... */

/* Stiluri pentru text luminos în conținutul articolului */
.article-content-bright {
    color: #ffffff; /* Alb pur */
}
.article-content-bright p,
.article-content-bright li,
.article-content-bright td,
.article-content-bright span,
.article-content-bright div:not(.hljs) { /* Excludem highlight.js dacă este folosit */
    color: #ffffff !important; /* Forțează alb pentru elementele comune */
}
/* Asigură-te că linkurile rămân vizibile */
.article-content-bright a {
    color: #c084fc; /* Ex: purple-400 */
}
.article-content-bright a:hover {
    color: #d8b4fe; /* Ex: purple-300 */
}
</style>
</style>
@endsection
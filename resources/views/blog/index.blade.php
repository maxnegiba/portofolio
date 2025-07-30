<!-- resources\views\blog\index.blade.php -->

@extends('layouts.app')

@section('content')
<section class="py-20 bg-black">
    <div class="container max-w-4xl">
        <header class="mb-12 text-center">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">{{ __('blog.title') }}</h1>
            <p class="text-gray-400 max-w-2xl mx-auto">{{ __('blog.subtitle') }}</p>
        </header>

        @if($posts->count() > 0)
            <div class="space-y-16">
                @foreach($posts as $post) {{-- Iterăm prin $posts --}}
                <article class="border-b border-white/10 pb-16 last:border-0 last:pb-0">
                    @if($post->featured_image)
                        <div class="aspect-video rounded-2xl overflow-hidden mb-8">
                            <img src="{{ $post->image_url }}" 
                                 alt="{{ $post->title }}" {{-- Title tradus automat --}}
                                 class="w-full h-full object-cover">
                        </div>
                    @endif
                    
                    <header class="mb-6">
                        <div class="flex flex-wrap items-center text-gray-400 text-sm mb-4 gap-2">
                            <span>{{ $post->user->name }}</span>
                            <span>•</span>
                            <time datetime="{{ $post->published_at->toDateString() }}">
                                {{ $post->published_at->format('M d, Y') }}
                            </time>
                            @if($post->reading_time)
                                <span>•</span>
                                <span>{{ $post->reading_time }} {{ __('blog.reading_time') }}</span>
                            @endif
                        </div>
                        
                        <h2 class="text-3xl font-bold text-white mb-4 hover:text-purple-400 transition-colors">
                            <a href="{{ route('blog.show', ['locale' => app()->getLocale(), 'slug' => $post->slug]) }}">
                                {{ $post->title }} {{-- Title tradus automat --}}
                            </a>
                        </h2>

                        @if($post->getTranslation('excerpt', app()->getLocale())) {{-- Excerpt tradus --}}
                            <p class="text-gray-300 mb-6">
                                {{ $post->getTranslation('excerpt', app()->getLocale()) }}
                            </p>
                        @endif

                        @if($post->meta_keywords && is_array($post->meta_keywords))
                            <div class="flex flex-wrap gap-2 mb-6">
                                @foreach($post->meta_keywords as $keyword)
                                    <span class="px-3 py-1 bg-purple-500/20 text-purple-300 rounded-full text-xs">
                                        {{ $keyword }}
                                    </span>
                                @endforeach
                            </div>
                        @endif

                        <a href="{{ route('blog.show', ['locale' => app()->getLocale(), 'slug' => $post->slug]) }}" 
                           class="inline-flex items-center text-purple-400 hover:text-purple-300 font-medium">
                            {{ __('blog.read_more') }}
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </header>
                </article>
                @endforeach
            </div>

            <!-- Paginare -->
            <div class="mt-16">
                {{ $posts->links() }} {{-- Afișează linkurile de paginare --}}
            </div>
        @else
            <div class="text-center py-20">
                <h2 class="text-2xl font-semibold text-white mb-4">{{ __('blog.no_posts') }}</h2>
                <p class="text-gray-400">{{ __('blog.no_posts_message') }}</p>
            </div>
        @endif
    </div>
</section>
@endsection
@extends('layouts.app')

@section('content')
<section class="py-20 bg-black">
    <div class="container max-w-4xl">
        <article>
            @if($post->featured_image)
                <div class="aspect-video rounded-2xl overflow-hidden mb-8">
                    <img src="{{ $post->image_url }}" 
                         alt="{{ $post->title }}"
                         class="w-full h-full object-cover">
                </div>
            @endif
            
            <header class="mb-8">
                <div class="flex items-center text-gray-400 mb-4">
                    <span>{{ $post->user->name }}</span>
                    <span class="mx-2">•</span>
                    <time>{{ $post->published_at->format('M d, Y') }}</time>
                    <span class="mx-2">•</span>
                    <span>{{ $post->reading_time }} {{ __('blog.reading_time') }}</span>
                </div>
                
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">{{ $post->title }}</h1>
                
                @if($post->meta_keywords)
                    <div class="flex flex-wrap gap-2">
                        @foreach($post->meta_keywords as $keyword)
                            <span class="px-3 py-1 bg-purple-500/20 text-purple-300 rounded-full text-sm">
                                {{ $keyword }}
                            </span>
                        @endforeach
                    </div>
                @endif
            </header>
            
            <div class="prose prose-invert prose-lg max-w-none">
                {!! $post->content !!}
            </div>
        </article>

        @if($recentPosts->count() > 0)
            <section class="mt-16 pt-16 border-t border-white/10">
                <h2 class="text-2xl font-bold text-white mb-8">{{ __('blog.recent_posts') }}</h2>
                <div class="grid md:grid-cols-3 gap-6">
                    @foreach($recentPosts as $recentPost)
                        <article class="group">
                            @if($recentPost->featured_image)
                                <div class="aspect-video rounded-xl overflow-hidden mb-4">
                                    <img src="{{ $recentPost->image_url }}" 
                                         alt="{{ $recentPost->title }}"
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform">
                                </div>
                            @endif
                            
                            <h3 class="text-lg font-semibold text-white group-hover:text-purple-400">
                                <a href="{{ route('blog.show', $recentPost->slug) }}">{{ $recentPost->title }}</a>
                            </h3>
                        </article>
                    @endforeach
                </div>
            </section>
        @endif
    </div>
</section>
@endsection
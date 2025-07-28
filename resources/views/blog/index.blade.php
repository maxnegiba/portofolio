@extends('layouts.app')

@section('content')
<section class="py-20 bg-black">
    <div class="container">
        <div class="text-center mb-16">
            <h1 class="text-4xl md:text-6xl font-bold bg-gradient-to-r from-purple-400 via-blue-400 to-cyan-400 bg-clip-text text-transparent">
                Blog
            </h1>
            <p class="text-gray-400 mt-4 text-lg">Latest insights and articles</p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($posts as $post)
                <article class="group bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl overflow-hidden hover:border-white/20 transition-all duration-300 hover:-translate-y-2">
                    @if($post->featured_image)
                        <div class="aspect-video overflow-hidden">
                            <img src="{{ $post->image_url }}" 
                                 alt="{{ $post->title }}"
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                        </div>
                    @endif
                    
                    <div class="p-6">
                        <div class="flex items-center text-sm text-gray-400 mb-3">
                            <span>{{ $post->user->name }}</span>
                            <span class="mx-2">•</span>
                            <time>{{ $post->published_at->format('M d, Y') }}</time>
                            <span class="mx-2">•</span>
                            <span>{{ $post->reading_time }} min read</span>
                        </div>
                        
                        <h2 class="text-xl font-bold text-white mb-3 group-hover:text-purple-400 transition-colors">
                            <a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a>
                        </h2>
                        
                        <p class="text-gray-400 line-clamp-3">{{ $post->excerpt }}</p>
                        
                        <a href="{{ route('blog.show', $post->slug) }}" 
                           class="inline-flex items-center text-purple-400 mt-4 group-hover:text-purple-300">
                            Read more
                            <i class="fas fa-arrow-right ml-2 transition-transform group-hover:translate-x-1"></i>
                        </a>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="mt-12">
            {{ $posts->links() }}
        </div>
    </div>
</section>
@endsection
@extends('layouts.app')

@section('content')
<!-- Blog Section cu design premium -->
<section class="py-32 relative bg-black overflow-hidden">
  <!-- Background Elements -->
  <div class="absolute inset-0">
    <div class="absolute top-0 left-1/4 w-96 h-96 bg-purple-600/10 rounded-full blur-[100px] animate-float-slow"></div>
    <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-blue-600/10 rounded-full blur-[100px] animate-float-slow delay-1000"></div>
    <!-- Mesh gradient -->
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,_var(--tw-gradient-stops))] from-purple-900/10 via-transparent to-transparent"></div>
  </div>
  
  <div class="container relative z-10">
    <!-- Section Header -->
    <header class="text-center mb-20">
      <span class="text-purple-400 tracking-wider uppercase text-sm inline-flex items-center gap-2">
        <span class="w-8 h-[2px] bg-purple-400"></span>
        {{ __('blog.title') }}
        <span class="w-8 h-[2px] bg-purple-400"></span>
      </span>
      <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mt-4 mb-6">
        <span class="bg-gradient-to-r from-purple-400 via-blue-400 to-cyan-400 bg-clip-text text-transparent animate-gradient-x bg-[length:200%_auto]">
          {{ __('blog.title') }}
        </span>
      </h1>
      <p class="text-xl text-gray-400 max-w-3xl mx-auto">{{ __('blog.subtitle') }}</p>
    </header>
    
    @if($posts->count() > 0)
      <!-- Blog Grid -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($posts as $post)
          <article class="group relative transform hover:-translate-y-2 transition-all duration-500">
            <!-- Glow Effect on Hover -->
            <div class="absolute inset-0 bg-gradient-to-r from-purple-600/20 to-blue-600/20 rounded-3xl blur-xl opacity-0 group-hover:opacity-100 group-hover:shadow-[0_0_25px_rgba(139,92,246,0.3)] transition-all duration-500"></div>
            
            <!-- Card Content -->
            <div class="relative bg-white/5 backdrop-blur-xl border border-white/10 rounded-3xl overflow-hidden hover:bg-white/10 hover:border-white/20 transition-all duration-300 hover:shadow-[0_20px_60px_rgba(0,0,0,0.5)] h-full flex flex-col">
              <!-- Featured Image -->
              @if($post->featured_image)
                <div class="aspect-video overflow-hidden">
                  <img src="{{ $post->image_url }}" 
                       alt="{{ $post->title }}"
                       class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                  <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                </div>
              @endif
              
              <!-- Content -->
              <div class="p-6 flex flex-col flex-grow">
                <!-- Meta Information -->
                <div class="flex flex-wrap items-center text-gray-400 text-sm mb-4 gap-2">
                  <span class="flex items-center">
                    <i class="far fa-user mr-1"></i>
                    {{ $post->user->name }}
                  </span>
                  <span>•</span>
                  <time datetime="{{ $post->published_at->toDateString() }}" class="flex items-center">
                    <i class="far fa-calendar mr-1"></i>
                    {{ $post->published_at->format('M d, Y') }}
                  </time>
                  @if($post->reading_time)
                    <span>•</span>
                    <span class="flex items-center">
                      <i class="far fa-clock mr-1"></i>
                      {{ $post->reading_time }} {{ __('blog.reading_time') }}
                    </span>
                  @endif
                </div>
                
                <!-- Title -->
                <h2 class="text-2xl font-bold text-white mb-3 group-hover:text-purple-400 transition-colors">
                  <a href="{{ route('blog.show', [app()->getLocale(), $post->slug]) }}">
                    {{ $post->title }}
                  </a>
                </h2>
                
                <!-- Excerpt -->
                @if($post->getTranslation('excerpt', app()->getLocale()))
                  <p class="text-gray-300 mb-4 flex-grow">
                    {{ $post->getTranslation('excerpt', app()->getLocale()) }}
                  </p>
                @endif
                
                <!-- Tags -->
                @if($post->meta_keywords && is_array($post->meta_keywords))
                  <div class="flex flex-wrap gap-2 mb-4">
                    @foreach(array_slice($post->meta_keywords, 0, 3) as $keyword)
                      <span class="px-3 py-1 bg-purple-500/20 text-purple-300 rounded-full text-xs">
                        {{ $keyword }}
                      </span>
                    @endforeach
                    @if(count($post->meta_keywords) > 3)
                      <span class="px-3 py-1 bg-white/10 text-gray-400 rounded-full text-xs">
                        +{{ count($post->meta_keywords) - 3 }}
                      </span>
                    @endif
                  </div>
                @endif
                
                <!-- Read More Button -->
                <div class="mt-auto">
                  <a href="{{ route('blog.show', [app()->getLocale(), $post->slug]) }}" 
                     class="inline-flex items-center text-purple-400 hover:text-purple-300 font-medium group/btn">
                    {{ __('blog.read_more') }}
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
      
      <!-- Pagination -->
      <div class="mt-16 flex justify-center">
        <div class="inline-flex space-x-2">
          {{ $posts->links('pagination::tailwind') }}
        </div>
      </div>
    @else
      <!-- No Posts Message -->
      <div class="text-center py-20 bg-white/5 backdrop-blur-sm border border-white/10 rounded-3xl max-w-2xl mx-auto">
        <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-purple-500 to-blue-500 rounded-2xl mb-6">
          <i class="fas fa-file-alt text-white text-xl"></i>
        </div>
        <h2 class="text-2xl font-semibold text-white mb-4">{{ __('blog.no_posts') }}</h2>
        <p class="text-gray-400">{{ __('blog.no_posts_message') }}</p>
      </div>
    @endif
  </div>
</section>

<!-- Additional Styles for Blog Grid -->
<style>
  /* Custom pagination styling */
  .pagination {
    @apply flex space-x-1;
  }
  
  .pagination .page-item {
    @apply inline-block;
  }
  
  .pagination .page-link {
    @apply flex items-center justify-center px-4 h-10 ms-0 leading-tight text-gray-400 bg-white/5 border border-white/10 rounded-lg hover:bg-purple-500/20 hover:text-white hover:border-purple-500 transition-colors duration-300;
  }
  
  .pagination .page-item.active .page-link {
    @apply text-white bg-gradient-to-r from-purple-600 to-blue-600 border-purple-600;
  }
  
  .pagination .page-item.disabled .page-link {
    @apply opacity-50 cursor-not-allowed;
  }
</style>
@endsection
@extends('layouts.app')

@php
    $thumbnail = $project->thumbnail_url;
    if ($thumbnail && !Str::startsWith($thumbnail, ['http://', 'https://'])) {
        $thumbnail = asset($thumbnail);
    }
    $thumbnail = $thumbnail ?? asset('img/default-thumbnail.jpg');
@endphp

@section('og:title', $project->getLocalizedTitle())
@section('og:description', Str::limit(strip_tags($project->getLocalizedDescription()), 160))
@section('og:image', $thumbnail)

@section('content')
<div x-data="projectGallery()" class="contents">
<!-- Project Detail Hero Section -->
<section class="relative py-20 bg-black overflow-hidden">
  <!-- Animated Background -->
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
  
  <div class="container relative z-10">
    <!-- Back Button -->
    <div class="mb-8">
      <a href="{{ route('projects') }}" class="group inline-flex items-center text-gray-400 hover:text-white transition-colors duration-300">
        <i class="fas fa-arrow-left mr-2 group-hover:-translate-x-1 transition-transform duration-300"></i>
        {{ __('pages.back') }}
      </a>
    </div>
    
    <!-- Project Header -->
    <div class="grid lg:grid-cols-3 gap-12 items-start">
      <!-- Content Column -->
      <div class="lg:col-span-2 space-y-8">
        <!-- Title and Description -->
        <div>
          <div class="relative inline-block mb-6">
            <div class="absolute -inset-1 bg-gradient-to-r from-purple-600 to-blue-600 rounded-2xl opacity-30 blur-lg"></div>
            <h1 class="relative text-4xl md:text-5xl lg:text-6xl font-bold text-white">
              {{ $project->getLocalizedTitle() }}
            </h1>
          </div>
          <p class="text-xl text-gray-300 leading-relaxed">
            {{ $project->getLocalizedDescription() }}
          </p>
        </div>
        
        <!-- Tech Stack -->
        <div>
          <h3 class="text-2xl font-bold text-white mb-6 flex items-center">
            <span class="w-8 h-[2px] bg-purple-400 mr-3"></span>
            Tech Stack
          </h3>
          <div class="flex flex-wrap gap-3">
            @foreach($project->tech as $tech)
              <span class="px-4 py-2 bg-gradient-to-r from-purple-600/20 to-blue-600/20 text-purple-300 border border-purple-500/30 rounded-full text-sm font-medium backdrop-blur-sm hover:from-purple-600/30 hover:to-blue-600/30 transition-all duration-300">
                <i class="fas fa-tag mr-1.5"></i> {{ $tech }}
              </span>
            @endforeach
          </div>
        </div>
        
        <!-- Action Buttons -->
        <div class="flex flex-wrap gap-4 pt-4">
          @if($project->live_url)
            <a href="{{ $project->live_url }}" target="_blank" class="group relative">
              <div class="absolute -inset-1 bg-gradient-to-r from-purple-600 to-blue-600 rounded-full opacity-70 blur group-hover:opacity-100 transition duration-300"></div>
              <button class="relative px-8 py-4 bg-black rounded-full text-white font-medium flex items-center space-x-3 group-hover:scale-105 transition-transform duration-300 shadow-2xl">
                <i class="fas fa-external-link-alt"></i>
                <span>Live Demo</span>
              </button>
            </a>
          @endif
          
          @if($project->github_url)
            <a href="{{ $project->github_url }}" target="_blank" class="group relative">
              <div class="absolute -inset-1 bg-gradient-to-r from-gray-700 to-gray-900 rounded-full opacity-70 blur group-hover:opacity-100 transition duration-300"></div>
              <button class="relative px-8 py-4 bg-black rounded-full text-white font-medium flex items-center space-x-3 group-hover:scale-105 transition-transform duration-300 shadow-2xl">
                <i class="fab fa-github"></i>
                <span>GitHub</span>
              </button>
            </a>
          @endif
        </div>
      </div>
      
      <!-- Image Column -->
      <div class="lg:col-span-1">
        <div class="relative group perspective-1000">
          <!-- Decorative Elements -->
          <div class="absolute -top-6 -left-6 w-24 h-24 bg-gradient-to-br from-purple-600 to-blue-600 rounded-3xl opacity-20 blur-xl animate-pulse"></div>
          <div class="absolute -bottom-6 -right-6 w-32 h-32 bg-gradient-to-br from-blue-600 to-cyan-600 rounded-3xl opacity-20 blur-xl animate-pulse delay-500"></div>
          
          <!-- Image Frame with 3D tilt -->
          <div class="relative rounded-3xl overflow-hidden transform-gpu transition-all duration-700 group-hover:rotate-y-12 shadow-2xl border border-white/10">
            <div class="absolute inset-0 bg-gradient-to-br from-purple-600/20 via-transparent to-blue-600/20 z-10"></div>
            @if($project->thumbnail)
                <x-responsive-image :path="$project->thumbnail" :alt="$project->getLocalizedTitle()" sizes="(max-width: 768px) 100vw, (max-width: 1200px) 50vw, 33vw" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700" />
            @else
                <img src="{{ asset('img/default-thumbnail.jpg') }}" alt="{{ $project->getLocalizedTitle() }}" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Project Gallery Section -->
@if(count($project->image_urls) > 0)
<section class="py-20 relative bg-black">
  <!-- Background Elements -->
  <div class="absolute inset-0">
    <div class="absolute top-0 left-1/4 w-96 h-96 bg-purple-600/10 rounded-full blur-[100px] animate-float-slow"></div>
    <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-blue-600/10 rounded-full blur-[100px] animate-float-slow delay-1000"></div>
  </div>
  
  <div class="container relative z-10">
    <!-- Section Header -->
    <div class="text-center mb-16">
      <span class="text-purple-400 tracking-wider uppercase text-sm inline-flex items-center gap-2">
        <span class="w-8 h-[2px] bg-purple-400"></span>
        Project Gallery
        <span class="w-8 h-[2px] bg-purple-400"></span>
      </span>
      <h2 class="text-4xl md:text-5xl font-bold mt-4 mb-6">
        <span class="bg-gradient-to-r from-purple-400 via-blue-400 to-cyan-400 bg-clip-text text-transparent animate-gradient-x bg-[length:200%_auto]">
          Project Screenshots
        </span>
      </h2>
      <p class="text-xl text-gray-400 max-w-3xl mx-auto">
        Explore the visual aspects of this project
      </p>
    </div>
    
    <!-- Gallery Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      @foreach($project->image_urls as $index => $imageUrl)
        <div class="group relative transform hover:-translate-y-2 transition-all duration-500 cursor-pointer" @click="openGallery({{ json_encode($project->image_urls) }}, '{{ addslashes($project->getLocalizedTitle()) }}', {{ $index }})">
          <!-- Glow Effect on Hover -->
          <div class="absolute inset-0 bg-gradient-to-r from-purple-600/20 to-blue-600/20 rounded-3xl blur-xl opacity-0 group-hover:opacity-100 group-hover:shadow-[0_0_25px_rgba(139,92,246,0.3)] transition-all duration-500"></div>
          
          <!-- Image Card -->
          <div class="relative bg-white/5 backdrop-blur-xl border border-white/10 rounded-3xl overflow-hidden hover:bg-white/10 hover:border-white/20 transition-all duration-300 hover:shadow-[0_20px_60px_rgba(0,0,0,0.5)]">
            <div class="aspect-video overflow-hidden">
              <img src="{{ $imageUrl }}" 
                   alt="Project Image {{ $index + 1 }}"
                   class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
              <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
              
              <!-- View Button Overlay -->
              <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                <div class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center transform scale-90 group-hover:scale-100 transition-transform duration-300">
                  <i class="fas fa-expand text-white text-xl"></i>
                </div>
              </div>
            </div>
            
            <!-- Image Number -->
            <div class="absolute top-4 right-4 z-20">
              <span class="px-3 py-1 bg-black/50 backdrop-blur-sm rounded-full text-xs font-medium text-white">
                {{ $index + 1 }} / {{ count($project->image_urls) }}
              </span>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>
@endif

<!-- Gallery Modal -->
<div x-show="isOpen"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     @click.self="closeGallery()"
     @keydown.escape.window="closeGallery()"
     class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/90 backdrop-blur-md"
     style="display: none;">
  <div class="relative w-full max-w-6xl h-[90vh] flex flex-col">
    <!-- Modal Header -->
    <div class="flex justify-between items-center mb-4 px-2">
      <h3 x-text="title" class="text-2xl font-bold text-white truncate"></h3>
      <button @click="closeGallery()" class="text-gray-400 hover:text-white text-2xl p-2 rounded-full hover:bg-white/10 transition-colors">
        <i class="fas fa-times"></i>
      </button>
    </div>
    
    <!-- Modal Body - Image Carousel -->
    <div class="relative flex-1 overflow-hidden rounded-2xl border border-white/10 group">
      <!-- Carousel Container -->
      <div class="relative w-full h-full">
         <template x-if="images.length > 0">
             <img :src="images[currentIndex]" :alt="`Image ${currentIndex + 1}`" class="w-full h-full object-contain">
         </template>
      </div>
      
      <!-- Navigation Arrows -->
      <button @click="changeImage(-1)" x-show="images.length > 1" class="absolute left-4 top-1/2 -translate-y-1/2 bg-black/50 hover:bg-black/70 text-white p-3 rounded-full opacity-0 group-hover:opacity-100 transition-opacity">
        <i class="fas fa-chevron-left"></i>
      </button>
      <button @click="changeImage(1)" x-show="images.length > 1" class="absolute right-4 top-1/2 -translate-y-1/2 bg-black/50 hover:bg-black/70 text-white p-3 rounded-full opacity-0 group-hover:opacity-100 transition-opacity">
        <i class="fas fa-chevron-right"></i>
      </button>
    </div>
    
    <!-- Modal Footer - Image Counter -->
    <div class="flex justify-center items-center mt-4 text-gray-400">
      <span x-text="`${currentIndex + 1} / ${images.length}`"></span>
    </div>
  </div>
</div>
</div>

<style nonce="{{ app('csp-nonce') }}">
@keyframes float-slow {
  0%, 100% { transform: translateY(0px); }
  50% { transform: translateY(-20px); }
}

@keyframes gradient-x {
  0%, 100% {
    background-position: 0% 50%;
  }
  50% {
    background-position: 100% 50%;
  }
}

.animate-float-slow {
  animation: float-slow 6s ease-in-out infinite;
}

.animate-gradient-x {
  animation: gradient-x 3s ease infinite;
  background-size: 200% auto;
}

/* 3D perspective */
.perspective-1000 {
  perspective: 1000px;
}

.rotate-y-12 {
  transform: rotateY(12deg);
}

/* Custom scrollbar */
::-webkit-scrollbar {
  width: 10px;
}

::-webkit-scrollbar-track {
  background: #0a0a0a;
}

::-webkit-scrollbar-thumb {
  background: linear-gradient(to bottom, #9333ea, #3b82f6);
  border-radius: 5px;
}

::-webkit-scrollbar-thumb:hover {
  background: linear-gradient(to bottom, #a855f7, #60a5fa);
}
</style>

<script nonce="{{ app('csp-nonce') }}">
document.addEventListener('alpine:init', () => {
    Alpine.data('projectGallery', () => ({
        isOpen: false,
        images: [],
        currentIndex: 0,
        title: '',

        openGallery(imageUrls, projectTitle, startIndex = 0) {
            if (!imageUrls || imageUrls.length === 0) return;
            this.images = imageUrls;
            this.currentIndex = startIndex;
            this.title = projectTitle;
            this.isOpen = true;
            document.body.style.overflow = 'hidden';
        },

        closeGallery() {
            this.isOpen = false;
            document.body.style.overflow = '';
        },

        changeImage(direction) {
            this.currentIndex += direction;
            if (this.currentIndex < 0) {
                this.currentIndex = this.images.length - 1;
            } else if (this.currentIndex >= this.images.length) {
                this.currentIndex = 0;
            }
        }
    }));
});
</script>
@endsection
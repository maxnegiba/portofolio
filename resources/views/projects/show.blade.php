@extends('layouts.app')

@section('content')
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
      <a href="{{ route('projects', app()->getLocale()) }}" class="group inline-flex items-center text-gray-400 hover:text-white transition-colors duration-300">
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
              {{ $project->getTitleAttribute() }}
            </h1>
          </div>
          <p class="text-xl text-gray-300 leading-relaxed">
            {{ $project->getDescriptionAttribute() }}
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
            <img src="{{ $project->thumbnail_url ?? asset('img/default-thumbnail.jpg') }}" 
                 alt="{{ $project->getTitleAttribute() }}" 
                 class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
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
        <div class="group relative transform hover:-translate-y-2 transition-all duration-500 cursor-pointer" onclick="openGalleryModal({{ json_encode($project->image_urls) }}, {{ $index }}, '{{ addslashes($project->getTitleAttribute()) }}')">
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

<!-- Related Projects Section -->
@if(isset($relatedProjects) && $relatedProjects->count() > 0)
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
        More Projects
        <span class="w-8 h-[2px] bg-purple-400"></span>
      </span>
      <h2 class="text-4xl md:text-5xl font-bold mt-4 mb-6">
        <span class="bg-gradient-to-r from-purple-400 via-blue-400 to-cyan-400 bg-clip-text text-transparent animate-gradient-x bg-[length:200%_auto]">
          You Might Also Like
        </span>
      </h2>
    </div>
    
    <!-- Projects Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
      @foreach($relatedProjects as $relatedProject)
        <article class="group relative transform hover:-translate-y-2 transition-all duration-500">
          <!-- Glow Effect on Hover -->
          <div class="absolute inset-0 bg-gradient-to-r from-purple-600/20 to-blue-600/20 rounded-3xl blur-xl opacity-0 group-hover:opacity-100 group-hover:shadow-[0_0_25px_rgba(139,92,246,0.3)] transition-all duration-500"></div>
          
          <!-- Card Content -->
          <div class="relative bg-white/5 backdrop-blur-xl border border-white/10 rounded-3xl overflow-hidden hover:bg-white/10 hover:border-white/20 transition-all duration-300 hover:shadow-[0_20px_60px_rgba(0,0,0,0.5)] h-full flex flex-col">
            <!-- Featured Image -->
            <div class="aspect-video overflow-hidden">
              <img src="{{ $relatedProject->thumbnail_url ?? asset('img/default-thumbnail.jpg') }}" 
                   alt="{{ $relatedProject->getTitleAttribute() }}"
                   class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
              <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            </div>
            
            <!-- Content -->
            <div class="p-6 flex flex-col flex-grow">
              <!-- Title -->
              <h3 class="text-xl font-bold text-white mb-3 group-hover:text-purple-400 transition-colors">
                <a href="{{ route('project', [app()->getLocale(), $relatedProject]) }}">
                  {{ $relatedProject->getTitleAttribute() }}
                </a>
              </h3>
              
              <!-- Description -->
              <p class="text-gray-400 text-sm mb-4 line-clamp-2 flex-grow">
                {{ $relatedProject->getDescriptionAttribute() }}
              </p>
              
              <!-- Tech Stack Preview -->
              <div class="flex flex-wrap gap-1 mb-4">
                @foreach(array_slice($relatedProject->tech ?? [], 0, 3) as $tech)
                  <span class="px-2 py-1 bg-purple-500/20 text-purple-300 rounded-full text-xs">
                    {{ $tech }}
                  </span>
                @endforeach
              </div>
              
              <!-- View Button -->
              <div class="mt-auto">
                <a href="{{ route('project', [app()->getLocale(), $relatedProject]) }}" 
                   class="inline-flex items-center text-purple-400 hover:text-purple-300 text-sm font-medium group/btn">
                  View Project
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
  </div>
</section>
@endif

<!-- Gallery Modal -->
<div id="galleryModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-black/90 backdrop-blur-md">
  <div class="relative w-full max-w-6xl h-[90vh] flex flex-col">
    <!-- Modal Header -->
    <div class="flex justify-between items-center mb-4 px-2">
      <h3 id="modalProjectTitle" class="text-2xl font-bold text-white truncate"></h3>
      <button onclick="closeGalleryModal()" class="text-gray-400 hover:text-white text-2xl p-2 rounded-full hover:bg-white/10 transition-colors">
        <i class="fas fa-times"></i>
      </button>
    </div>
    
    <!-- Modal Body - Image Carousel -->
    <div class="relative flex-1 overflow-hidden rounded-2xl border border-white/10">
      <!-- Carousel Container -->
      <div id="galleryCarousel" class="relative w-full h-full">
         <!-- Images will be injected here by JS -->
      </div>
      
      <!-- Navigation Arrows -->
      <button id="prevGalleryBtn" onclick="changeGalleryImage(-1)" class="absolute left-4 top-1/2 -translate-y-1/2 bg-black/50 hover:bg-black/70 text-white p-3 rounded-full transition-opacity">
        <i class="fas fa-chevron-left"></i>
      </button>
      <button id="nextGalleryBtn" onclick="changeGalleryImage(1)" class="absolute right-4 top-1/2 -translate-y-1/2 bg-black/50 hover:bg-black/70 text-white p-3 rounded-full transition-opacity">
        <i class="fas fa-chevron-right"></i>
      </button>
    </div>
    
    <!-- Modal Footer - Image Counter -->
    <div class="flex justify-center items-center mt-4 text-gray-400">
      <span id="galleryImageCounter">1 / 1</span>
    </div>
  </div>
</div>

<style>
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

/* Modal Styles */
#galleryModal {
    display: none; /* Hidden by default */
    opacity: 0;
    transition: opacity 0.3s ease;
}

#galleryModal.active {
    display: flex;
    opacity: 1;
}

/* Ensure image fills container while maintaining aspect ratio */
#galleryCarousel img {
    width: 100%;
    height: 100%;
    object-fit: contain;
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

<script>
// Gallery Modal JavaScript
let galleryImages = [];
let galleryIndex = 0;
let galleryModal = document.getElementById('galleryModal');
let galleryCarousel = document.getElementById('galleryCarousel');
let galleryCounter = document.getElementById('galleryImageCounter');
let galleryTitle = document.getElementById('modalProjectTitle');
let prevBtn = document.getElementById('prevGalleryBtn');
let nextBtn = document.getElementById('nextGalleryBtn');

function openGalleryModal(imageUrls, startIndex, projectTitle) {
    if (!imageUrls || imageUrls.length === 0) return;
    galleryImages = imageUrls;
    galleryIndex = startIndex;
    galleryTitle.textContent = projectTitle;
    updateGalleryCarousel();
    galleryModal.classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeGalleryModal() {
    galleryModal.classList.remove('active');
    galleryCarousel.innerHTML = '';
    document.body.style.overflow = '';
}

function changeGalleryImage(direction) {
    galleryIndex += direction;
    if (galleryIndex < 0) {
        galleryIndex = galleryImages.length - 1;
    } else if (galleryIndex >= galleryImages.length) {
        galleryIndex = 0;
    }
    updateGalleryCarousel();
}

function updateGalleryCarousel() {
    if (galleryImages.length === 0) return;
    galleryCounter.textContent = `${galleryIndex + 1} / ${galleryImages.length}`;
    
    let imgElement = galleryCarousel.querySelector('img');
    if (!imgElement) {
        imgElement = document.createElement('img');
        imgElement.className = 'w-full h-full object-contain';
        galleryCarousel.appendChild(imgElement);
    }
    imgElement.src = galleryImages[galleryIndex];
    imgElement.alt = `Image ${galleryIndex + 1}`;
    
    prevBtn.style.display = galleryImages.length > 1 ? 'block' : 'none';
    nextBtn.style.display = galleryImages.length > 1 ? 'block' : 'none';
}

// Close modal if clicked outside
galleryModal?.addEventListener('click', function(event) {
    if (event.target === galleryModal) {
        closeGalleryModal();
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === "Escape" && galleryModal?.classList.contains('active')) {
        closeGalleryModal();
    }
});
</script>
@endsection
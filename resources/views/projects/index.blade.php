<!-- resources/views/projects/index.blade.php -->
@extends('layouts.app')

@section('content')
<!-- Projects Hero Section -->
<section class="relative py-20 bg-black overflow-hidden">
  <!-- Animated Background -->
  <div class="absolute inset-0">
    <div class="absolute top-0 left-1/4 w-96 h-96 bg-purple-600/20 rounded-full blur-[120px] animate-pulse"></div>
    <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-blue-600/20 rounded-full blur-[120px] animate-pulse delay-700"></div>
  </div>
  <!-- Grid Pattern -->
  <div class="absolute inset-0 bg-[url('image/svg+xml,%3Csvg width="60" height="60" xmlns="http://www.w3.org/2000/svg"%3E%3Cdefs%3E%3Cpattern id="grid" width="60" height="60" patternUnits="userSpaceOnUse"%3E%3Cpath d="M 60 0 L 0 0 0 60" fill="none" stroke="rgba(255,255,255,0.03)" stroke-width="1"/%3E%3C/pattern%3E%3C/defs%3E%3Crect width="100%25" height="100%25" fill="url(%23grid)"/%3E%3C/svg%3E')] opacity-50"></div>
  <div class="container relative z-10">
    <!-- Page Header -->
    <div class="text-center mb-16">
      <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold mb-6 animate-fade-in-down">
        <span class="bg-gradient-to-r from-purple-400 via-blue-400 to-cyan-400 bg-clip-text text-transparent">
          {{ __('pages.projects_h1') }}
        </span>
      </h1>
      <p class="text-xl text-gray-400 max-w-3xl mx-auto animate-fade-in-up delay-200">
        Explore my portfolio of web applications, each crafted with passion and attention to detail
      </p>
    </div>
    <!-- Filter Tags (Optional) -->
    <div class="flex flex-wrap justify-center gap-3 mb-12 animate-fade-in-up delay-400">
      <button class="px-6 py-2 rounded-full bg-gradient-to-r from-purple-600 to-blue-600 text-white font-medium transition-all duration-300 hover:scale-105">
        All Projects
      </button>
      <button class="px-6 py-2 rounded-full bg-white/5 border border-white/10 text-gray-300 font-medium hover:bg-white/10 hover:border-white/20 transition-all duration-300">
        Laravel
      </button>
      <button class="px-6 py-2 rounded-full bg-white/5 border border-white/10 text-gray-300 font-medium hover:bg-white/10 hover:border-white/20 transition-all duration-300">
        Vue.js
      </button>
      <button class="px-6 py-2 rounded-full bg-white/5 border border-white/10 text-gray-300 font-medium hover:bg-white/10 hover:border-white/20 transition-all duration-300">
        Full Stack
      </button>
    </div>
  </div>
</section>

 <!-- Projects Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($projects as $project)
        <div class="group relative animate-fade-in-up" style="animation-delay: {{ $loop->index * 100 }}ms">
            <!-- Project Card -->
            <div class="relative bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl overflow-hidden hover:bg-white/10 hover:border-white/20 transition-all duration-500 h-full">
                <!-- Glow Effect -->
                <div class="absolute -inset-1 bg-gradient-to-r from-purple-600 to-blue-600 rounded-2xl opacity-0 group-hover:opacity-20 blur-xl transition-opacity duration-500"></div>
                <!-- Card Content -->
                <div class="relative h-full flex flex-col">
                    <!-- Image Container -->
                    <div class="relative overflow-hidden aspect-video">
                        <!-- Gradient Overlay -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent z-10 opacity-60 group-hover:opacity-40 transition-opacity duration-500"></div>
                        <!-- Project Number -->
                        <div class="absolute top-4 left-4 z-20">
                            <span class="text-6xl font-bold text-white/10 group-hover:text-white/20 transition-colors duration-500">
                                {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                            </span>
                        </div>
                      <!-- Tech Stack Icons -->
<div class="absolute top-4 right-4 z-20 flex gap-2">
    @php
        $techIcons = [
            'Laravel' => 'fab fa-laravel text-red-400',
            'Vue.js' => 'fab fa-vuejs text-green-400',
            'JavaScript' => 'fab fa-js text-yellow-400',
            'PHP' => 'fab fa-php text-purple-400',
            'MySQL' => 'fas fa-database text-blue-400',
            'PostgreSQL' => 'fas fa-database text-blue-300',
            'Tailwind' => 'fas fa-wind text-cyan-400',
            'Bootstrap' => 'fab fa-bootstrap text-purple-500'
        ];
        // Verificare defensivă pentru $project->tech
        $safeProjectTech = is_array($project->tech ?? null) ? $project->tech : [];
    @endphp
    @foreach(array_slice($safeProjectTech, 0, 3) as $tech)
        @if(isset($techIcons[$tech]))
        <div class="w-8 h-8 bg-black/50 backdrop-blur-sm rounded-lg flex items-center justify-center">
            <i class="{{ $techIcons[$tech] }} text-sm"></i>
        </div>
        @endif
    @endforeach
</div>
</div><!-- Tech Tags -->
                        <!-- Image -->
                        <img src="{{ $project->thumbnail_url ?? asset('img/default-thumbnail.jpg') }}" {{-- Folosim accessorul --}}
                            alt="{{ $project->getTitleAttribute() }}" {{-- Folosim accessorul --}}
                            class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                    </div>
                    <!-- Content -->
                    <div class="p-6 flex-1 flex flex-col">
                        <!-- Title -->
                        <h3
                            class="text-2xl font-bold text-white mb-3 group-hover:text-transparent group-hover:bg-gradient-to-r group-hover:from-purple-400 group-hover:to-blue-400 group-hover:bg-clip-text transition-all duration-300">
                            {{ $project->getTitleAttribute() }} {{-- Folosim accessorul --}}
                        </h3>
                        <!-- Description -->
                        <p
                            class="text-gray-400 mb-4 flex-1 line-clamp-3 group-hover:text-gray-300 transition-colors duration-300">
                            {{ $project->getDescriptionAttribute() }} {{-- Folosim accessorul --}}
                        </p>
                       <!-- Tech Tags -->
 <div class="flex flex-wrap gap-2 mb-4">
     @foreach($safeProjectTech as $tech)
     <span class="px-3 py-1 text-xs font-medium bg-white/5 border border-white/10 rounded-full text-gray-400 group-hover:border-white/20 group-hover:text-gray-300 transition-all duration-300">
         {{ $tech }}
     </span>
     @endforeach
 </div>
                        <!-- === NEW: Indicators for Additional Images === -->
                        @if($project->image_urls && count($project->image_urls) > 0)
                        <div class="flex items-center text-gray-500 text-sm mb-4">
                            <i class="fas fa-images mr-2 text-purple-400"></i>
                            <span>{{ count($project->image_urls) }} {{ str_plural('image', count($project->image_urls)) }}</span>
                            <!-- Optional: View Images Button -->
                            <button type="button"
                                class="ml-auto text-purple-400 hover:text-purple-300 text-xs font-medium flex items-center group/view"
                                onclick="openImageModal({{ json_encode($project->image_urls) }}, '{{ addslashes($project->getTitleAttribute()) }}', {{ $loop->parent->index ?? 0 }})">
                                View <i class="fas fa-expand ml-1 group-hover/view:scale-110 transition-transform"></i>
                            </button>
                        </div>
                        @endif
                        <!-- ============================================== -->
                        <!-- Actions -->
                        <div class="flex items-center gap-3 mt-auto">
                            <!-- View Details -->
                            <a href="{{ route('project', [app()->getLocale(), $project]) }}" {{-- Route model binding --}}
                                class="group/btn relative flex-1">
                                <div
                                    class="absolute -inset-1 bg-gradient-to-r from-purple-600 to-blue-600 rounded-xl opacity-0 group-hover/btn:opacity-70 blur transition-opacity duration-300">
                                </div>
                                <div
                                    class="relative px-4 py-2.5 bg-black rounded-xl text-white text-center font-medium group-hover/btn:scale-105 transition-transform duration-300">
                                    <span class="flex items-center justify-center gap-2">
                                        View Details
                                        <i
                                            class="fas fa-arrow-right text-sm group-hover/btn:translate-x-1 transition-transform duration-300"></i>
                                    </span>
                                </div>
                            </a>
                            <!-- Live Demo -->
                            @if($project->live_url)
                            <a href="{{ $project->live_url }}" target="_blank"
                                class="group/btn relative"
                                aria-label="Live Demo for {{ $project->getTitleAttribute() }}">
                                <div
                                    class="relative w-12 h-12 bg-white/5 border border-white/10 rounded-xl flex items-center justify-center group-hover/btn:bg-white/10 group-hover/btn:border-white/20 transition-all duration-300">
                                    <i
                                        class="fas fa-external-link-alt text-gray-400 group-hover/btn:text-white transition-colors duration-300"></i>
                                </div>
                            </a>
                            @endif
                            <!-- GitHub -->
                            @if($project->github_url ?? false)
                            <a href="{{ $project->github_url }}" target="_blank"
                                class="group/btn relative"
                                aria-label="GitHub repository for {{ $project->getTitleAttribute() }}">
                                <div
                                    class="relative w-12 h-12 bg-white/5 border border-white/10 rounded-xl flex items-center justify-center group-hover/btn:bg-white/10 group-hover/btn:border-white/20 transition-all duration-300">
                                    <i
                                        class="fab fa-github text-gray-400 group-hover/btn:text-white transition-colors duration-300"></i>
                                </div>
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-20">
            <h2 class="text-2xl font-semibold text-white mb-4">No Projects Found</h2>
            <p class="text-gray-400">Check back later for new projects.</p>
        </div>
        @endforelse
    </div>
    <!-- Load More / Pagination -->
    @if($projects->hasPages())
    <div class="mt-16 flex justify-center">
        {{ $projects->links() }}
    </div>
    @endif
  </div>
</section>

<!-- === NEW: Modal for Additional Images === -->
<div id="projectImageModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-black/90 backdrop-blur-md">
  <div class="relative w-full max-w-6xl h-[90vh] flex flex-col">
    <!-- Modal Header -->
    <div class="flex justify-between items-center mb-4 px-2">
      <h3 id="modalProjectTitle" class="text-2xl font-bold text-white truncate"></h3>
      <button onclick="closeImageModal()" class="text-gray-400 hover:text-white text-2xl p-2 rounded-full hover:bg-white/10 transition-colors">
        <i class="fas fa-times"></i>
      </button>
    </div>

    <!-- Modal Body - Image Carousel -->
    <div class="relative flex-1 overflow-hidden rounded-2xl border border-white/10">
      <!-- Carousel Container -->
      <div id="imageCarousel" class="relative w-full h-full">
         <!-- Images will be injected here by JS -->
      </div>

      <!-- Navigation Arrows -->
      <button id="prevImageBtn" onclick="changeImage(-1)" class="absolute left-4 top-1/2 -translate-y-1/2 bg-black/50 hover:bg-black/70 text-white p-3 rounded-full opacity-0 group-hover:opacity-100 transition-opacity">
        <i class="fas fa-chevron-left"></i>
      </button>
      <button id="nextImageBtn" onclick="changeImage(1)" class="absolute right-4 top-1/2 -translate-y-1/2 bg-black/50 hover:bg-black/70 text-white p-3 rounded-full opacity-0 group-hover:opacity-100 transition-opacity">
        <i class="fas fa-chevron-right"></i>
      </button>
    </div>

    <!-- Modal Footer - Image Counter -->
    <div class="flex justify-center items-center mt-4 text-gray-400">
      <span id="imageCounter">1 / 1</span>
    </div>
  </div>
</div>
<!-- ======================================== -->

<!-- CTA Section -->
<section class="py-20 bg-black relative overflow-hidden">
  <div class="absolute inset-0">
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-gradient-to-r from-purple-600/20 to-blue-600/20 rounded-full blur-[150px]"></div>
  </div>
  <div class="container relative z-10 text-center">
    <h2 class="text-4xl md:text-5xl font-bold mb-6">
      <span class="bg-gradient-to-r from-purple-400 to-blue-400 bg-clip-text text-transparent">
        Have a Project in Mind?
      </span>
    </h2>
    <p class="text-xl text-gray-400 mb-8 max-w-2xl mx-auto">
      Let's work together to bring your ideas to life
    </p>
    <a href="{{ route('contact', app()->getLocale()) }}" class="group relative inline-block">
      <div class="absolute -inset-2 bg-gradient-to-r from-purple-600 to-blue-600 rounded-full opacity-70 blur group-hover:opacity-100 transition duration-300"></div>
      <button class="relative px-8 py-4 bg-black rounded-full text-white font-medium flex items-center space-x-3 group-hover:scale-105 transition-transform duration-300">
        <span>Start a Conversation</span>
        <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform duration-300"></i>
      </button>
    </a>
  </div>
</section>

<style>
@keyframes fade-in-up {
  from {
    opacity: 0;
    transform: translateY(30px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
@keyframes fade-in-down {
  from {
    opacity: 0;
    transform: translateY(-30px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
.animate-fade-in-up {
  animation: fade-in-up 0.6s ease-out forwards;
  opacity: 0;
}
.animate-fade-in-down {
  animation: fade-in-down 0.6s ease-out forwards;
  opacity: 0;
}
.delay-200 { animation-delay: 200ms; }
.delay-400 { animation-delay: 400ms; }

/* Modal Styles */
#projectImageModal {
    /* Use flexbox for centering */
    display: none; /* Hidden by default */
    opacity: 0;
    transition: opacity 0.3s ease;
}
#projectImageModal.active {
    display: flex;
    opacity: 1;
}
/* Ensure image fills container while maintaining aspect ratio */
#imageCarousel img {
    width: 100%;
    height: 100%;
    object-fit: contain; /* Shows full image, adds black bars if needed */
    /* object-fit: cover; */ /* Alternative: Crops to fill */
}
/* Custom scrollbar for the page */
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
// === NEW: JavaScript for Image Modal ===
let currentImages = [];
let currentIndex = 0;
let modalElement = document.getElementById('projectImageModal');
let carouselElement = document.getElementById('imageCarousel');
let counterElement = document.getElementById('imageCounter');
let titleElement = document.getElementById('modalProjectTitle');
let prevBtn = document.getElementById('prevImageBtn');
let nextBtn = document.getElementById('nextImageBtn');

function openImageModal(imageUrls, projectTitle, projectIndex) {
    if (!imageUrls || imageUrls.length === 0) return;

    currentImages = imageUrls;
    currentIndex = 0; // Reset to first image
    titleElement.textContent = projectTitle;

    updateCarousel();
    modalElement.classList.add('active'); // Add class for fade-in
    document.body.style.overflow = 'hidden'; // Prevent background scrolling
}

function closeImageModal() {
    modalElement.classList.remove('active');
    // Clear carousel content
    carouselElement.innerHTML = '';
    document.body.style.overflow = ''; // Restore background scrolling
}

function changeImage(direction) {
    currentIndex += direction;
    // Handle boundaries
    if (currentIndex < 0) {
        currentIndex = currentImages.length - 1;
    } else if (currentIndex >= currentImages.length) {
        currentIndex = 0;
    }
    updateCarousel();
}

function updateCarousel() {
    if (currentImages.length === 0) return;

    // Update counter
    counterElement.textContent = `${currentIndex + 1} / ${currentImages.length}`;

    // Update image source
    // Simple approach: replace the image source
    // More robust: pre-load images or use a proper carousel library
    let imgElement = carouselElement.querySelector('img');
    if (!imgElement) {
        imgElement = document.createElement('img');
        imgElement.className = 'w-full h-full object-contain'; // Apply styles directly if needed
        carouselElement.appendChild(imgElement);
    }
    imgElement.src = currentImages[currentIndex];
    imgElement.alt = `Image ${currentIndex + 1} for project`;

    // Update button visibility
    prevBtn.style.display = currentImages.length > 1 ? 'block' : 'none';
    nextBtn.style.display = currentImages.length > 1 ? 'block' : 'none';
}

// Close modal if clicked outside the content
modalElement?.addEventListener('click', function(event) {
    if (event.target === modalElement) {
        closeImageModal();
    }
});
// ======================================

// Optional: Close modal with Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === "Escape" && modalElement?.classList.contains('active')) {
        closeImageModal();
    }
});
</script>
@endsection
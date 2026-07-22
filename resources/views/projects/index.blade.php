@extends('layouts.app')
@section('content')
<div x-data="projectGallery()" class="contents">
<!-- Projects Hero Section -->
<section class="relative py-20 bg-black overflow-hidden">
  <!-- Animated Background -->
  <div class="absolute inset-0">
    <div class="absolute top-0 left-1/4 w-96 h-96 bg-purple-600/20 rounded-full blur-[120px] animate-pulse"></div>
    <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-blue-600/20 rounded-full blur-[120px] animate-pulse delay-700"></div>
  </div>
  <!-- Grid Pattern -->
  <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" xmlns="http://www.w3.org/2000/svg"%3E%3Cdefs%3E%3Cpattern id="grid" width="60" height="60" patternUnits="userSpaceOnUse"%3E%3Cpath d="M 60 0 L 0 0 0 60" fill="none" stroke="rgba(255,255,255,0.03)" stroke-width="1"/%3E%3C/pattern%3E%3C/defs%3E%3Crect width="100%25" height="100%25" fill="url(%23grid)"/%3E%3C/svg%3E')] opacity-50"></div>
  <div class="container relative z-10">
    <!-- Page Header -->
    <div class="text-center mb-16">
      <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold mb-6 animate-fade-in-down">
        <span class="bg-gradient-to-r from-purple-400 via-blue-400 to-cyan-400 bg-clip-text text-transparent">
          {{ __('pages.projects_h1') }}
        </span>
      </h1>
      <p class="text-xl text-gray-400 max-w-3xl mx-auto animate-fade-in-up delay-200">
        {{ __('pages.projects_subtitle') }}
      </p>
    </div>
<!-- Projects Grid Section -->
<section class="py-16 relative bg-black">
  <div class="container relative z-10">
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
                  $projectTech = is_array($project->tech ?? null) ? $project->tech : [];

                  // IMPORTANT: slug trebuie să fie scalar (string). Dacă e gol, facem fallback pe id.
                  $projectSlug = trim((string)($project->slug ?? ''));

                  if ($projectSlug === '') {
                      $projectSlug = (string)($project->id ?? '');
                  }

                  // Dacă nici id nu există (nu ar trebui), dezactivăm linkul.
                  $canGenerateProjectUrl = $projectSlug !== '';
                @endphp

                @foreach(array_slice($projectTech, 0, 3) as $tech)
                  @if(isset($techIcons[$tech]))
                  <div class="w-8 h-8 bg-black/50 backdrop-blur-sm rounded-lg flex items-center justify-center">
                    <i class="{{ $techIcons[$tech] }} text-sm"></i>
                  </div>
                  @endif
                @endforeach
              </div>
              <!-- Image -->
              @if($project->thumbnail)
                  <x-responsive-image :path="$project->thumbnail" :alt="$project->getLocalizedTitle()" sizes="(max-width: 768px) 100vw, (max-width: 1200px) 50vw, 33vw" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700" />
              @else
                  <img src="{{ asset('img/default-thumbnail.jpg') }}" alt="{{ $project->getLocalizedTitle() }}" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
              @endif
            </div>
            <!-- Content -->
            <div class="p-6 flex-1 flex flex-col">
              <!-- Title -->
              @if(!empty($project->getLocalizedTitle()))
              <h3 class="text-2xl font-bold text-white mb-3 group-hover:text-transparent group-hover:bg-gradient-to-r group-hover:from-purple-400 group-hover:to-blue-400 group-hover:bg-clip-text transition-all duration-300">
                {{ $project->getLocalizedTitle() }}
              </h3>
              @else
              <div class="text-2xl font-bold text-white mb-3 group-hover:text-transparent group-hover:bg-gradient-to-r group-hover:from-purple-400 group-hover:to-blue-400 group-hover:bg-clip-text transition-all duration-300"></div>
              @endif
              <!-- Description -->
              <p class="text-gray-400 mb-4 flex-1 line-clamp-3 group-hover:text-gray-300 transition-colors duration-300">
                {{ $project->getLocalizedDescription() }}
              </p>
              <!-- Tech Tags -->
              <div class="flex flex-wrap gap-2 mb-4">
                @foreach($projectTech as $tech)
                <span class="px-3 py-1 text-xs font-medium bg-white/5 border border-white/10 rounded-full text-gray-400 group-hover:border-white/20 group-hover:text-gray-300 transition-all duration-300">
                  {{ $tech }}
                </span>
                @endforeach
              </div>
              <!-- Indicators for Additional Images -->
              @if($project->image_urls && count($project->image_urls) > 0)
              <div class="flex items-center text-gray-500 text-sm mb-4">
                <i class="fas fa-images mr-2 text-purple-400"></i>
                <span>{{ count($project->image_urls) }} {{ count($project->image_urls) == 1 ? __('pages.projects_image') : __('pages.projects_images') }}</span>
                <!-- View Images Button -->
                <button type="button"
                  class="ml-auto text-purple-400 hover:text-purple-300 text-xs font-medium flex items-center group/view"
                  @click="openGallery({{ json_encode($project->image_urls) }}, '{{ addslashes($project->getLocalizedTitle()) }}')">
                  {{ __('pages.projects_view_images') }} <i class="fas fa-expand ml-1 group-hover/view:scale-110 transition-transform"></i>
                </button>
              </div>
              @endif
              <!-- Actions -->
              <div class="flex items-center gap-3 mt-auto">
                <!-- View Details -->
                @if($canGenerateProjectUrl)
                <a href="{{ route('project', $project) }}"
                  class="group/btn relative flex-1">
                  <div class="absolute -inset-1 bg-gradient-to-r from-purple-600 to-blue-600 rounded-xl opacity-0 group-hover/btn:opacity-70 blur transition-opacity duration-300">
                  </div>
                  <div class="relative px-4 py-2.5 bg-black rounded-xl text-white text-center font-medium group-hover/btn:scale-105 transition-transform duration-300">
                    <span class="flex items-center justify-center gap-2">
                      {{ __('pages.projects_view_details') }}
                      <span class="sr-only"> about {{ $project->getLocalizedTitle() }}</span>
                      <i class="fas fa-arrow-right text-sm group-hover/btn:translate-x-1 transition-transform duration-300"></i>
                    </span>
                  </div>
                </a>
                @else
                <div class="flex-1 px-4 py-2.5 bg-black/40 rounded-xl text-gray-400 text-center text-sm">
                  {{ __('pages.projects_view_details') }}
                </div>
                @endif

                <!-- Live Demo -->
                @if($project->live_url)
                <a href="{{ $project->live_url }}" target="_blank"
                  class="group/btn relative"
                  aria-label="{{ __('pages.projects_live_demo') }} for {{ $project->getLocalizedTitle() }}">
                  <div class="relative w-12 h-12 bg-white/5 border border-white/10 rounded-xl flex items-center justify-center group-hover/btn:bg-white/10 group-hover/btn:border-white/20 transition-all duration-300">
                    <i class="fas fa-external-link-alt text-gray-400 group-hover/btn:text-white transition-colors duration-300"></i>
                  </div>
                </a>
                @endif
                <!-- GitHub -->
                @if($project->github_url ?? false)
                <a href="{{ $project->github_url }}" target="_blank"
                  class="group/btn relative"
                  aria-label="{{ __('pages.projects_github') }} repository for {{ $project->getLocalizedTitle() }}">
                  <div class="relative w-12 h-12 bg-white/5 border border-white/10 rounded-xl flex items-center justify-center group-hover/btn:bg-white/10 group-hover/btn:border-white/20 transition-all duration-300">
                    <i class="fab fa-github text-gray-400 group-hover/btn:text-white transition-colors duration-300"></i>
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
        <h2 class="text-2xl font-semibold text-white mb-4">{{ __('pages.projects_no_projects') }}</h2>
        <p class="text-gray-400">{{ __('pages.projects_check_back') }}</p>
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
<!-- CTA Section -->
<section class="py-20 bg-black relative overflow-hidden">
  <div class="absolute inset-0">
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-gradient-to-r from-purple-600/20 to-blue-600/20 rounded-full blur-[150px]"></div>
  </div>
  <div class="container relative z-10 text-center">
    <h2 class="text-4xl md:text-5xl font-bold mb-6">
      <span class="bg-gradient-to-r from-purple-400 to-blue-400 bg-clip-text text-transparent">
        {{ __('pages.projects_cta_title') }}
      </span>
    </h2>
    <p class="text-xl text-gray-400 mb-8 max-w-2xl mx-auto">
      {{ __('pages.projects_cta_subtitle') }}
    </p>
    <a href="{{ route('contact') }}" class="group relative inline-block">
      <div class="absolute -inset-2 bg-gradient-to-r from-purple-600 to-blue-600 rounded-full opacity-70 blur group-hover:opacity-100 transition duration-300"></div>
      <button class="relative px-8 py-4 bg-black rounded-full text-white font-medium flex items-center space-x-3 group-hover:scale-105 transition-transform duration-300">
        <span>{{ __('pages.projects_cta_button') }}</span>
        <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform duration-300"></i>
      </button>
    </a>
  </div>
</section>
<!-- Modal for Additional Images -->
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
      <<div class="relative w-full h-full">
         <template x-if="images.length > 0">
             <img :src="images[currentIndex].includes('/') ? images[currentIndex] : '/storage/projects/thumbnails/' + images[currentIndex]" :alt="`Image ${currentIndex + 1} for project`" class="w-full h-full object-contain">
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
<script nonce="{{ app('csp-nonce') }}">
document.addEventListener('alpine:init', () => {
    Alpine.data('projectGallery', () => ({
        isOpen: false,
        images: [],
        currentIndex: 0,
        title: '',

        openGallery(imageUrls, projectTitle) {
            if (!imageUrls || imageUrls.length === 0) return;
            this.images = imageUrls;
            this.currentIndex = 0;
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

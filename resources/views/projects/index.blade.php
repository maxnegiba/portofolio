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
<section class="py-20 bg-gradient-to-b from-black via-gray-900/30 to-black">
  <div class="container">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
      @foreach($projects as $project)
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
                    'Tailwind' => 'fas fa-wind text-cyan-400',
                    'Bootstrap' => 'fab fa-bootstrap text-purple-500'
                  ];
                @endphp
                @foreach(array_slice($project->tech, 0, 3) as $tech)
                  @if(isset($techIcons[$tech]))
                    <div class="w-8 h-8 bg-black/50 backdrop-blur-sm rounded-lg flex items-center justify-center">
                      <i class="{{ $techIcons[$tech] }} text-sm"></i>
                    </div>
                  @endif
                @endforeach
              </div>
              
              <!-- Image -->
              <img src="{{ asset($project->thumbnail) }}" 
                   alt="{{ $project->title[app()->getLocale()] }}"
                   class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
            </div>
            
            <!-- Content -->
            <div class="p-6 flex-1 flex flex-col">
              <!-- Title -->
              <h3 class="text-2xl font-bold text-white mb-3 group-hover:text-transparent group-hover:bg-gradient-to-r group-hover:from-purple-400 group-hover:to-blue-400 group-hover:bg-clip-text transition-all duration-300">
                {{ $project->title[app()->getLocale()] }}
              </h3>
              
              <!-- Description -->
              <p class="text-gray-400 mb-4 flex-1 line-clamp-3 group-hover:text-gray-300 transition-colors duration-300">
                {{ $project->description[app()->getLocale()] }}
              </p>
              
              <!-- Tech Tags -->
              <div class="flex flex-wrap gap-2 mb-6">
                @foreach($project->tech as $tech)
                <span class="px-3 py-1 text-xs font-medium bg-white/5 border border-white/10 rounded-full text-gray-400 group-hover:border-white/20 group-hover:text-gray-300 transition-all duration-300">
                  {{ $tech }}
                </span>
                @endforeach
              </div>
              
              <!-- Actions -->
              <div class="flex items-center gap-3">
                <!-- View Details -->
                <a href="{{ route('project', [app()->getLocale(), $project->slug]) }}" 
                   class="group/btn relative flex-1">
                  <div class="absolute -inset-1 bg-gradient-to-r from-purple-600 to-blue-600 rounded-xl opacity-0 group-hover/btn:opacity-70 blur transition-opacity duration-300"></div>
                  <div class="relative px-4 py-2.5 bg-black rounded-xl text-white text-center font-medium group-hover/btn:scale-105 transition-transform duration-300">
                    <span class="flex items-center justify-center gap-2">
                      View Details
                      <i class="fas fa-arrow-right text-sm group-hover/btn:translate-x-1 transition-transform duration-300"></i>
                    </span>
                  </div>
                </a>
                
                <!-- Live Demo -->
                @if($project->live_url)
                <a href="{{ $project->live_url }}" 
                   target="_blank"
                   class="group/btn relative">
                  <div class="relative w-12 h-12 bg-white/5 border border-white/10 rounded-xl flex items-center justify-center group-hover/btn:bg-white/10 group-hover/btn:border-white/20 transition-all duration-300">
                    <i class="fas fa-external-link-alt text-gray-400 group-hover/btn:text-white transition-colors duration-300"></i>
                  </div>
                </a>
                @endif
                
                <!-- GitHub -->
                @if($project->github_url ?? false)
                <a href="{{ $project->github_url }}" 
                   target="_blank"
                   class="group/btn relative">
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
      @endforeach
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
@endsection
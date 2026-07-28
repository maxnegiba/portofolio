@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="relative pt-32 pb-20 overflow-hidden bg-black min-h-[40vh] flex items-center">
  <div class="absolute inset-0">
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-purple-600/20 rounded-full blur-[120px]"></div>
    <div class="absolute bottom-0 w-full h-px bg-gradient-to-r from-transparent via-white/10 to-transparent"></div>
  </div>

  <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
    <div class="w-full max-w-4xl mx-auto px-4 sm:px-6 text-center">
      <h1 class="text-5xl md:text-7xl font-bold mb-6 tracking-tight text-white animate-fade-in-up">
        B2B <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-cyan-400">{{ __('pages.projects_case_studies') }}</span>
      </h1>
      <p class="text-xl md:text-2xl text-gray-400 font-light leading-relaxed animate-fade-in-up delay-200">
        {{ __('pages.projects_intro') }}
      </p>
    </div>
  </div>
</section>

<!-- Portfolio Grid Section -->
<section class="py-16 lg:py-24 bg-black relative" id="portfolio">
  <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" x-data="{ activeTab: 'web_platform' }">
    <!-- Category Navigation -->
    <div class="flex flex-col md:flex-row justify-center items-center gap-4 mb-20 animate-fade-in-up delay-400">
        <button @click="activeTab = 'web_platform'"
                :class="activeTab === 'web_platform' ? 'bg-white/10 border-purple-500 text-white shadow-[0_0_20px_rgba(168,85,247,0.2)]' : 'bg-transparent border-white/10 text-gray-400 hover:text-white hover:border-white/30'"
                class="px-8 py-4 rounded-xl font-medium border transition-all duration-300 w-full md:w-auto text-lg flex items-center justify-center gap-3">
            <i class="fas fa-layer-group"></i>
            {{ __('pages.projects_web_apps') }}
        </button>
        <button @click="activeTab = 'automation'"
                :class="activeTab === 'automation' ? 'bg-white/10 border-cyan-500 text-white shadow-[0_0_20px_rgba(34,211,238,0.2)]' : 'bg-transparent border-white/10 text-gray-400 hover:text-white hover:border-white/30'"
                class="px-8 py-4 rounded-xl font-medium border transition-all duration-300 w-full md:w-auto text-lg flex items-center justify-center gap-3">
            <i class="fas fa-robot"></i>
            {{ __('pages.projects_automations') }}
        </button>
    </div>

    <!-- Web Platforms Grid -->
    <div x-show="activeTab === 'web_platform'" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 items-stretch">
        @forelse($projects->get('web_platform', []) as $project)
            @include('components.project-card', ['project' => $project])
        @empty
            <div class="col-span-full text-center py-20 border border-dashed border-white/10 rounded-2xl">
                <i class="fas fa-folder-open text-4xl text-gray-600 mb-4"></i>
                <h3 class="text-xl text-gray-400">{{ __('pages.projects_no_web_apps') }}</h3>
            </div>
        @endforelse
    </div>

    <!-- Automations Grid -->
    <div x-show="activeTab === 'automation'" style="display: none;" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 items-stretch">
        @forelse($projects->get('automation', []) as $project)
            @include('components.project-card', ['project' => $project])
        @empty
            <div class="col-span-full text-center py-20 border border-dashed border-white/10 rounded-2xl">
                <i class="fas fa-folder-open text-4xl text-gray-600 mb-4"></i>
                <h3 class="text-xl text-gray-400">{{ __('pages.projects_no_automations') }}</h3>
            </div>
        @endforelse
    </div>
  </div>
</section>

<style nonce="{{ app('csp-nonce') }}">
@keyframes fade-in-up {
  from { opacity: 0; transform: translateY(30px); }
  to { opacity: 1; transform: translateY(0); }
}
.animate-fade-in-up {
  animation: fade-in-up 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
  opacity: 0;
}
.delay-200 { animation-delay: 200ms; }
.delay-400 { animation-delay: 400ms; }
</style>
@endsection

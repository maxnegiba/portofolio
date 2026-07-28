@extends('layouts.app')



@section('content')
<!-- Hero Section -->
<section class="relative pt-32 pb-20 overflow-hidden bg-black min-h-[50vh] flex items-center">
  <div class="absolute inset-0">
    @if($project->thumbnail_url)
      <div class="absolute inset-0 bg-cover bg-center bg-no-repeat opacity-20" style="background-image: url('{{ $project->thumbnail_url }}'); filter: blur(20px) brightness(0.5);"></div>
    @endif
    <div class="absolute inset-0 bg-gradient-to-t from-black via-black/80 to-black/50"></div>
  </div>
  
  <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
    <div class="w-full max-w-4xl mx-auto px-4 sm:px-6 text-center">
      <!-- Category Badge -->
      <span class="inline-block px-4 py-1.5 bg-white/10 backdrop-blur-md border border-white/20 rounded-full text-sm font-medium text-purple-400 mb-8 animate-fade-in-up">
        {{ $project->category === 'automation' ? __('pages.project_category_automation') : __('pages.project_category_web_app') }}
      </span>

      <h1 class="text-4xl md:text-6xl font-bold mb-6 tracking-tight text-white animate-fade-in-up delay-200">
        {{ $project->getLocalizedTitle() }}
      </h1>

      <!-- Tech Stack -->
      @if($project->tech && count($project->tech) > 0)
        <div class="flex flex-wrap justify-center gap-3 animate-fade-in-up delay-400">
          @foreach($project->tech as $tech)
            <span class="px-4 py-2 bg-white/5 border border-white/10 rounded-xl text-sm font-medium text-gray-300">
              {{ $tech }}
            </span>
          @endforeach
        </div>
      @endif
    </div>
  </div>
</section>

<!-- Content Section -->
<section class="py-16 lg:py-24 bg-black text-gray-300">
  <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-4xl mx-auto px-4 sm:px-6">
      
      <!-- Actions -->
      <div class="flex flex-wrap items-center gap-4 mb-16 pb-8 border-b border-white/10">
        @if($project->live_url)
          <a href="{{ $project->live_url }}" target="_blank" rel="noopener noreferrer" class="px-8 py-4 bg-purple-600 hover:bg-purple-500 rounded-xl text-white font-semibold transition-colors flex items-center gap-3">
            <i class="fas fa-external-link-alt"></i>
            {{ __('pages.project_visit_live') }}
          </a>
        @endif
        @if($project->github_url)
          <a href="{{ $project->github_url }}" target="_blank" rel="noopener noreferrer" class="px-8 py-4 bg-white/10 hover:bg-white/20 rounded-xl text-white font-semibold transition-colors flex items-center gap-3">
            <i class="fab fa-github"></i>
            {{ __('pages.project_view_source') }}
          </a>
        @endif
        <a href="{{ route('projects') }}" class="px-8 py-4 bg-transparent border border-white/10 hover:border-white/30 rounded-xl text-gray-400 hover:text-white font-semibold transition-colors flex items-center gap-3 ml-auto">
          <i class="fas fa-arrow-left"></i>
          {{ __('pages.project_back') }}
        </a>
      </div>

      <!-- General Overview -->
      <div class="prose prose-invert prose-lg max-w-none mb-20 prose-a:text-purple-400 hover:prose-a:text-purple-300">
        {!! $project->getLocalizedDescription() !!}
      </div>

      <!-- CASE STUDY NARRATIVE -->
      <div class="space-y-24">

        @if($project->getLocalizedProblem())
          <section class="relative">
            <div class="absolute -left-8 top-0 w-1 h-full bg-gradient-to-b from-red-500/50 to-transparent rounded-full hidden md:block"></div>
            <h3 class="text-3xl font-bold text-white mb-6 flex items-center gap-4">
              <span class="w-12 h-12 rounded-xl bg-red-500/10 text-red-400 flex items-center justify-center text-xl">01</span>
              {{ __('pages.project_challenge') }}
            </h3>
            <div class="prose prose-invert prose-lg max-w-none bg-white/[0.02] border border-white/5 p-8 rounded-2xl">
              {!! $project->getLocalizedProblem() !!}
            </div>
          </section>
        @endif

        @if($project->getLocalizedSolution())
          <section class="relative">
            <div class="absolute -left-8 top-0 w-1 h-full bg-gradient-to-b from-cyan-500/50 to-transparent rounded-full hidden md:block"></div>
            <h3 class="text-3xl font-bold text-white mb-6 flex items-center gap-4">
              <span class="w-12 h-12 rounded-xl bg-cyan-500/10 text-cyan-400 flex items-center justify-center text-xl">02</span>
              {{ __('pages.project_solution') }}
            </h3>
            <div class="prose prose-invert prose-lg max-w-none bg-white/[0.02] border border-white/5 p-8 rounded-2xl">
              {!! $project->getLocalizedSolution() !!}
            </div>
          </section>
        @endif

        @if($project->getLocalizedBusinessResult())
          <section class="relative">
            <div class="absolute -left-8 top-0 w-1 h-full bg-gradient-to-b from-purple-500/50 to-transparent rounded-full hidden md:block"></div>
            <h3 class="text-3xl font-bold text-white mb-6 flex items-center gap-4">
              <span class="w-12 h-12 rounded-xl bg-purple-500/10 text-purple-400 flex items-center justify-center text-xl">03</span>
              {{ __('pages.project_business_impact') }}
            </h3>
            <div class="prose prose-invert prose-lg max-w-none bg-purple-900/10 border border-purple-500/20 p-8 rounded-2xl">
              {!! $project->getLocalizedBusinessResult() !!}
            </div>
          </section>
        @endif

      </div>

    </div>

    <!-- Gallery outside max-w-4xl but inside max-w-7xl -->
    @php
      $galleryImages = $project->image_urls ?? [];
      $galleryCount = count($galleryImages);
    @endphp
    @if($galleryCount > 0)
      <div class="mt-24 pt-16 border-t border-white/10">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-8">
          <div>
            <span class="text-purple-400 text-sm font-semibold uppercase tracking-[0.2em]">{{ __('pages.project_gallery_eyebrow') }}</span>
            <h3 class="text-3xl md:text-4xl font-bold text-white mt-2">{{ __('pages.project_gallery') }}</h3>
          </div>
          <p class="text-sm text-gray-400">{{ __('pages.project_gallery_hint') }}</p>
        </div>

        <div
          class="project-gallery relative overflow-hidden rounded-3xl border border-white/10 bg-zinc-950 shadow-[0_30px_80px_rgba(0,0,0,0.45)] focus:outline-none focus:ring-2 focus:ring-purple-400/80"
          data-project-gallery
          role="region"
          aria-roledescription="carousel"
          aria-label="{{ __('pages.project_gallery_label', ['project' => $project->getLocalizedTitle()]) }}"
          data-gallery-counter-template="{{ __('pages.project_image_count', ['current' => '__CURRENT__', 'total' => '__TOTAL__']) }}"
          tabindex="0"
        >
          <div class="overflow-hidden">
            <div class="flex transition-transform duration-500 ease-out will-change-transform" data-gallery-track>
              @foreach($galleryImages as $imgUrl)
                <figure
                  class="relative min-w-full aspect-[16/10] md:aspect-video bg-black"
                  data-gallery-slide
                  aria-hidden="{{ $loop->first ? 'false' : 'true' }}"
                >
                  <a
                    href="{{ $imgUrl }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="block h-full focus:outline-none focus-visible:ring-4 focus-visible:ring-inset focus-visible:ring-purple-400"
                    aria-label="{{ __('pages.project_open_image', ['current' => $loop->iteration, 'total' => $galleryCount]) }}"
                    tabindex="{{ $loop->first ? '0' : '-1' }}"
                  >
                    <img
                      src="{{ $imgUrl }}"
                      alt="{{ __('pages.project_gallery_image_alt', ['project' => $project->getLocalizedTitle(), 'current' => $loop->iteration, 'total' => $galleryCount]) }}"
                      class="h-full w-full object-contain"
                      loading="{{ $loop->first ? 'eager' : 'lazy' }}"
                    >
                  </a>
                  <div class="pointer-events-none absolute inset-x-0 bottom-0 h-28 bg-gradient-to-t from-black/80 to-transparent"></div>
                </figure>
              @endforeach
            </div>
          </div>

          @if($galleryCount > 1)
            <button
              type="button"
              class="absolute left-3 sm:left-6 top-1/2 -translate-y-1/2 z-10 w-11 h-11 sm:w-12 sm:h-12 rounded-full border border-white/15 bg-black/60 backdrop-blur-md text-white hover:bg-purple-600 hover:border-purple-400 focus:outline-none focus:ring-2 focus:ring-white transition-all"
              data-gallery-previous
              aria-label="{{ __('pages.project_previous_image') }}"
            >
              <i class="fas fa-chevron-left" aria-hidden="true"></i>
            </button>
            <button
              type="button"
              class="absolute right-3 sm:right-6 top-1/2 -translate-y-1/2 z-10 w-11 h-11 sm:w-12 sm:h-12 rounded-full border border-white/15 bg-black/60 backdrop-blur-md text-white hover:bg-purple-600 hover:border-purple-400 focus:outline-none focus:ring-2 focus:ring-white transition-all"
              data-gallery-next
              aria-label="{{ __('pages.project_next_image') }}"
            >
              <i class="fas fa-chevron-right" aria-hidden="true"></i>
            </button>

            <div class="absolute inset-x-0 bottom-5 z-10 flex items-center justify-center gap-2" role="group" aria-label="{{ __('pages.project_gallery_navigation') }}">
              @foreach($galleryImages as $imgUrl)
                <button
                  type="button"
                  class="h-2.5 rounded-full bg-white/35 hover:bg-white/70 focus:outline-none focus:ring-2 focus:ring-white transition-all duration-300"
                  data-gallery-dot
                  aria-label="{{ __('pages.project_go_to_image', ['current' => $loop->iteration, 'total' => $galleryCount]) }}"
                  aria-current="{{ $loop->first ? 'true' : 'false' }}"
                ></button>
              @endforeach
            </div>
          @endif

          <div class="absolute top-4 right-4 z-10 rounded-full border border-white/10 bg-black/60 px-3 py-1.5 text-xs font-semibold text-white backdrop-blur-md" data-gallery-counter aria-live="polite">
            {{ __('pages.project_image_count', ['current' => 1, 'total' => $galleryCount]) }}
          </div>
        </div>
      </div>
    @endif
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
[data-gallery-dot] { width: 0.625rem; }
[data-gallery-dot][aria-current="true"] {
  width: 2rem;
  background-color: rgb(255 255 255 / 0.95);
}
</style>
@endsection

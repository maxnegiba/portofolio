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
  
  <div class="container relative z-10">
    <div class="max-w-4xl mx-auto text-center">
      <!-- Category Badge -->
      <span class="inline-block px-4 py-1.5 bg-white/10 backdrop-blur-md border border-white/20 rounded-full text-sm font-medium text-purple-400 mb-8 animate-fade-in-up">
        {{ $project->category === 'automation' ? 'Workflow Automation' : 'Enterprise Web App' }}
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
  <div class="container max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
      
      <!-- Actions -->
      <div class="flex flex-wrap items-center gap-4 mb-16 pb-8 border-b border-white/10">
        @if($project->live_url)
          <a href="{{ $project->live_url }}" target="_blank" class="px-8 py-4 bg-purple-600 hover:bg-purple-500 rounded-xl text-white font-semibold transition-colors flex items-center gap-3">
            <i class="fas fa-external-link-alt"></i>
            Visit Live Project
          </a>
        @endif
        @if($project->github_url)
          <a href="{{ $project->github_url }}" target="_blank" class="px-8 py-4 bg-white/10 hover:bg-white/20 rounded-xl text-white font-semibold transition-colors flex items-center gap-3">
            <i class="fab fa-github"></i>
            View Source Code
          </a>
        @endif
        <a href="{{ route('projects') }}" class="px-8 py-4 bg-transparent border border-white/10 hover:border-white/30 rounded-xl text-gray-400 hover:text-white font-semibold transition-colors flex items-center gap-3 ml-auto">
          <i class="fas fa-arrow-left"></i>
          Back to Projects
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
              The Challenge
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
              The Solution
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
              Business Impact
            </h3>
            <div class="prose prose-invert prose-lg max-w-none bg-purple-900/10 border border-purple-500/20 p-8 rounded-2xl">
              {!! $project->getLocalizedBusinessResult() !!}
            </div>
          </section>
        @endif

      </div>

    </div>

    <!-- Gallery outside max-w-4xl but inside max-w-7xl -->
    @if($project->image_urls && count($project->image_urls) > 0)
      <div class="mt-24 pt-16 border-t border-white/10">
        <h3 class="text-2xl font-bold text-white mb-8 text-center">Project Gallery</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          @foreach($project->image_urls as $imgUrl)
            <a href="{{ $imgUrl }}" target="_blank" class="block rounded-3xl overflow-hidden border border-white/10 hover:border-white/30 transition-colors shadow-2xl bg-white/5 group">
              <img src="{{ $imgUrl }}" alt="Gallery Image" class="w-full aspect-video object-cover transform group-hover:scale-105 transition-transform duration-500">
            </a>
          @endforeach
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
</style>
@endsection

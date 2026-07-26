@extends('layouts.app')

@section('content')
<!-- Progress Bar -->
<div class="fixed top-0 left-0 h-1 bg-gradient-to-r from-purple-500 via-blue-500 to-cyan-500 z-[60] transition-all duration-150 ease-out shadow-[0_0_10px_rgba(59,130,246,0.5)]" id="scroll-progress" style="width: 0%"></div>

<!-- HERO SECTION -->
<section class="hero min-h-screen flex items-center relative overflow-hidden bg-black">
  <div class="absolute inset-0 z-0 pointer-events-none">
    <div class="hidden md:block absolute top-20 left-10 w-72 h-72 bg-purple-600/30 rounded-full blur-[100px] animate-pulse"></div>
    <div class="hidden md:block absolute bottom-20 right-10 w-96 h-96 bg-blue-600/30 rounded-full blur-[120px] animate-pulse delay-700"></div>
    <div class="hidden md:block absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-cyan-600/20 rounded-full blur-[150px] animate-pulse delay-1000"></div>
    <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cdefs%3E%3Cpattern id=\"grid\" width=\"60\" height=\"60\" patternUnits=\"userSpaceOnUse\"%3E%3Cpath d=\"M 60 0 L 0 0 0 60\" fill=\"none\" stroke=\"rgba(255,255,255,0.03)\" stroke-width=\"1\"/%3E%3C/pattern%3E%3C/defs%3E%3Crect width=\"100%25\" height=\"100%25\" fill=\"url(%23grid)\"/%3E%3C/svg%3E')] opacity-50"></div>
    <div class="particles absolute inset-0 hidden md:block"></div>
    <div class="hidden md:block absolute top-1/4 left-1/4 w-2 h-2 bg-purple-400 rounded-full animate-ping"></div>
    <div class="hidden md:block absolute top-3/4 right-1/3 w-3 h-3 bg-blue-400 rounded-full animate-ping delay-500"></div>
    <div class="hidden md:block absolute bottom-1/4 left-1/3 w-2 h-2 bg-cyan-400 rounded-full animate-ping delay-1000"></div>
  </div>
  
  <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
    <div class="max-w-4xl mx-auto mt-12 md:mt-0">
      <!-- Avatar -->
      <div class="flex justify-center mb-10">
        <div class="relative group cursor-pointer">
          <div class="hidden md:block absolute -inset-4 bg-gradient-to-r from-purple-600 via-blue-600 to-cyan-600 rounded-full opacity-75 blur-lg group-hover:opacity-100 animate-spin-slow transition-opacity duration-500"></div>
          <div class="hidden md:block absolute -inset-6 bg-gradient-to-r from-cyan-600 via-purple-600 to-blue-600 rounded-full opacity-50 blur-xl animate-spin-reverse transition-opacity duration-500"></div>
          
          <div class="relative w-40 h-40 md:w-48 md:h-48">
            <div class="hidden md:block absolute inset-0 bg-gradient-to-r from-purple-600 via-blue-600 to-cyan-600 rounded-full animate-spin-slow"></div>
            <div class="hidden md:block absolute inset-1 bg-black rounded-full"></div>
            
            <x-responsive-image path="img/avatar.webp" alt="avatar" fetchpriority="high" loading="eager" width="400" height="400" sizes="(max-width: 768px) 160px, 192px" class="absolute inset-0 md:inset-2 w-full h-full object-cover rounded-full border-2 border-black md:transform md:group-hover:scale-105 md:transition-transform md:duration-500" />
            
            <!-- Availability Badge -->
            <div class="absolute bottom-0 right-0 md:bottom-2 md:right-2 flex items-center space-x-2 bg-black/90 backdrop-blur-md px-3 md:px-4 py-1.5 rounded-full border border-green-500/50 shadow-[0_0_20px_rgba(34,197,94,0.4)]">
              <div class="w-2.5 h-2.5 bg-green-500 rounded-full md:animate-pulse shadow-[0_0_10px_rgba(34,197,94,0.8)]"></div>
              <span class="text-xs text-green-400 font-semibold tracking-wide hidden md:inline-block uppercase">{{ __('pages.available_status') }}</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Hero Typography -->
      <div class="text-center space-y-8">
        <div class="space-y-4">
          <h1 class="text-4xl md:text-6xl lg:text-7xl font-bold max-md:font-sans">
            <span class="block text-gray-400 md:animate-fade-in-down">{{ __('pages.hero_hi') }}</span>
            <span class="block mt-2 relative inline-block">
              <span class="bg-gradient-to-r from-purple-400 via-blue-400 to-cyan-400 bg-clip-text text-transparent md:animate-gradient-x md:animate-fade-in-up md:delay-200 md:bg-[length:200%_auto]">
                Max
              </span>
              <span class="hidden md:block absolute -right-8 top-1/2 -translate-y-1/2 w-1 h-12 bg-cyan-400 animate-blink shadow-[0_0_10px_rgba(34,211,238,0.8)]"></span>
            </span>
          </h1>
          <div class="h-8 md:h-10 relative overflow-hidden max-md:font-sans">
            <div class="md:animate-text-slide">
              <p class="text-xl md:text-2xl text-gray-300 h-8 md:h-10 flex items-center justify-center font-medium">{{ __('pages.role_1') }}</p>
              <p class="text-xl md:text-2xl text-gray-300 h-8 md:h-10 hidden md:flex items-center justify-center font-medium">{{ __('pages.role_2') }}</p>
              <p class="text-xl md:text-2xl text-gray-300 h-8 md:h-10 hidden md:flex items-center justify-center font-medium">{{ __('pages.role_3') }}</p>
              <p class="text-xl md:text-2xl text-gray-300 h-8 md:h-10 hidden md:flex items-center justify-center font-medium">{{ __('pages.role_4') }}</p>
            </div>
          </div>
        </div>
        
        <p class="text-lg md:text-xl text-gray-400 max-w-2xl mx-auto leading-relaxed md:animate-fade-in md:delay-400 max-md:font-sans">
          {{ __('pages.hero_subtitle') }}
        </p>

        <!-- CTA Buttons -->
        <div class="flex flex-col sm:flex-row justify-center gap-4 md:gap-6 md:animate-fade-in-up md:delay-600 pt-4">
          <a href="{{ route('projects') }}" class="group relative w-full sm:w-auto">
            <div class="hidden md:block absolute -inset-1 bg-gradient-to-r from-purple-600 to-blue-600 rounded-full opacity-70 blur group-hover:opacity-100 transition duration-300"></div>
            <button class="relative w-full px-8 py-4 bg-white md:bg-black rounded-full text-black md:text-white font-bold flex items-center justify-center space-x-3 md:group-hover:scale-105 transition-all duration-300 shadow-2xl hover:shadow-[0_0_30px_rgba(59,130,246,0.5)]">
              <span>{{ __('pages.see_work') }}</span>
              <i class="fas fa-arrow-right md:group-hover:translate-x-1 transition-transform duration-300"></i>
            </button>
          </a>
          <a href="{{ route('contact') }}" class="group w-full sm:w-auto px-8 py-4 rounded-full border-2 border-gray-700 text-gray-300 font-medium flex items-center justify-center space-x-3 hover:border-blue-500 hover:text-white hover:bg-white/5 transition-all duration-300">
            <i class="far fa-envelope text-blue-400 group-hover:text-white transition-colors duration-300"></i>
            <span>{{ __('pages.hire_me') }}</span>
          </a>
        </div>
        
        <!-- Social -->
        <div class="flex justify-center space-x-6 md:animate-fade-in md:delay-800 pt-4">
          <a href="https://www.facebook.com/profile.php?id=100001274142909" target="_blank" aria-label="Facebook" class="group relative md:transform md:hover:-translate-y-2 transition-all duration-300">
            <div class="hidden md:block absolute -inset-2 bg-gradient-to-r from-purple-600 to-blue-600 rounded-lg opacity-0 blur group-hover:opacity-60 transition duration-300"></div>
            <div class="relative w-12 h-12 bg-white/5 backdrop-blur-sm border border-white/10 rounded-lg flex items-center justify-center md:group-hover:bg-white/10 md:group-hover:border-white/20 transition-all duration-300 md:group-hover:shadow-[0_10px_40px_rgba(0,0,0,0.3)]">
              <i class="fab fa-facebook-f text-gray-400 group-hover:text-white transition-colors duration-300 text-lg"></i>
            </div>
          </a>
        </div>
      </div>
      
      <!-- Scroll Indicator -->
      <div class="absolute bottom-8 left-1/2 -translate-x-1/2 md:animate-bounce hidden sm:block">
        <a href="#about" aria-label="{{ __('pages.scroll_text') ?: 'Scroll down' }}" class="flex flex-col items-center text-gray-500 hover:text-white transition-colors duration-300 group">
          <span class="text-[10px] uppercase tracking-widest mb-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">{{ __('pages.scroll_text') }}</span>
          <div class="w-6 h-10 border-2 border-gray-600 rounded-full p-1 group-hover:border-white transition-colors duration-300">
            <div class="w-1 h-2 bg-gray-600 rounded-full mx-auto md:animate-scroll group-hover:bg-white transition-colors duration-300"></div>
          </div>
        </a>
      </div>
    </div>
  </div>
</section>

<!-- ABOUT SECTION -->
<section id="about" class="py-24 md:py-32 relative bg-black overflow-hidden">
  <div class="absolute inset-0 pointer-events-none">
    <div class="hidden md:block absolute top-0 left-1/4 w-96 h-96 bg-purple-600/10 rounded-full blur-[100px] animate-float-slow"></div>
    <div class="hidden md:block absolute bottom-0 right-1/4 w-96 h-96 bg-blue-600/10 rounded-full blur-[100px] animate-float-slow delay-1000"></div>
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,_var(--tw-gradient-stops))] from-purple-900/10 via-transparent to-transparent"></div>
  </div>
  
  <!-- Updated Grid Container -->
  <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
    <div class="grid lg:grid-cols-2 gap-16 lg:gap-24 items-center">
      <div class="relative order-2 lg:order-1">
        <div class="relative group perspective-1000">
          <div class="hidden md:block absolute -top-6 -left-6 w-24 h-24 bg-gradient-to-br from-purple-600 to-blue-600 rounded-3xl opacity-20 blur-xl animate-pulse"></div>
          <div class="hidden md:block absolute -bottom-6 -right-6 w-32 h-32 bg-gradient-to-br from-blue-600 to-cyan-600 rounded-3xl opacity-20 blur-xl animate-pulse delay-500"></div>
          <div class="relative rounded-3xl overflow-hidden transform-gpu transition-all duration-700 md:group-hover:rotate-y-6 md:group-hover:shadow-[0_20px_50px_rgba(147,51,234,0.2)]">
            <div class="absolute inset-0 bg-gradient-to-br from-purple-600/20 via-transparent to-blue-600/20 z-10 pointer-events-none"></div>
            <x-responsive-image path="img/avatar.webp" alt="About" width="800" height="800" sizes="(max-width: 1024px) 100vw, 50vw" class="w-full h-auto object-cover md:transform md:group-hover:scale-105 transition-transform duration-700" />
          </div>
          <div class="absolute -bottom-8 -right-8 md:-bottom-8 md:-right-8 right-4 bottom-[-1rem] bg-black/80 md:bg-black/60 backdrop-blur-2xl border border-white/10 rounded-2xl p-4 md:p-6 shadow-2xl md:transform md:hover:scale-105 transition-all duration-300 z-20">
            <div class="flex items-center space-x-4">
              <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-green-500 to-emerald-500 rounded-xl flex items-center justify-center shadow-[0_0_30px_rgba(34,197,94,0.5)]">
                <i class="fas fa-code text-white text-sm md:text-base"></i>
              </div>
              <div>
                <p class="text-xl md:text-2xl font-bold text-white">3+</p>
                <p class="text-xs md:text-sm text-gray-400">{{ __('pages.years_experience') }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <div class="space-y-8 order-1 lg:order-2">
        <div>
          <span class="text-purple-400 font-semibold tracking-widest uppercase text-sm flex items-center gap-4">
            <span class="w-12 h-[2px] bg-purple-500"></span>
            {{ __('pages.get_to_know_me') }}
          </span>
          <h2 class="text-4xl md:text-5xl lg:text-6xl font-bold mt-4 leading-tight">
            <span class="bg-gradient-to-r from-purple-400 via-blue-400 to-cyan-400 bg-clip-text text-transparent md:animate-gradient-x md:bg-[length:200%_auto]">
              {{ __('pages.about_h1') }}
            </span>
          </h2>
        </div>
        <div class="space-y-4 text-gray-300 text-lg leading-relaxed">
          <p class="hover:text-white transition-colors duration-300">{{ __('pages.about_text') }}</p>
          <p class="hover:text-white transition-colors duration-300">{{ __('pages.about_text_extra') }}</p>
        </div>
        
        <div class="grid grid-cols-2 gap-4 pt-2">
          @foreach([
            ['pages.skill_frontend', 'fas fa-laptop-code', 'from-blue-500 to-cyan-500'],
            ['pages.skill_backend', 'fas fa-server', 'from-purple-500 to-pink-500'],
            ['pages.skill_database', 'fas fa-database', 'from-green-500 to-emerald-500'],
            ['pages.skill_api', 'fas fa-plug', 'from-orange-500 to-red-500']
          ] as $skill)
          <div class="group bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-4 hover:bg-white/10 hover:border-white/20 transition-all duration-300 hover:shadow-[0_8px_32px_rgba(0,0,0,0.3)] md:hover:-translate-y-1">
            <div class="flex items-center space-x-3">
              <div class="w-10 h-10 bg-gradient-to-br {{ $skill[2] }} rounded-xl flex items-center justify-center md:group-hover:scale-110 transition-transform duration-300 shadow-lg">
                <i class="{{ $skill[1] }} text-white text-sm"></i>
              </div>
              <span class="text-gray-300 font-medium group-hover:text-white transition-colors duration-300">{{ __($skill[0]) }}</span>
            </div>
          </div>
          @endforeach
        </div>
        
        <div class="flex flex-wrap items-center gap-6 pt-6">
          <a href="{{ route('contact') }}" class="group relative inline-flex items-center space-x-2">
            <div class="hidden md:block absolute -inset-2 bg-gradient-to-r from-purple-600 to-blue-600 rounded-full opacity-0 blur group-hover:opacity-60 transition duration-300"></div>
            <span class="relative px-8 py-3.5 bg-gradient-to-r from-purple-600 to-blue-600 rounded-full text-white font-bold md:group-hover:scale-105 transition-transform duration-300 shadow-[0_4px_20px_rgba(147,51,234,0.4)]">
              {{ __('pages.work_together') }}
            </span>
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- PROJECTS SECTION -->
<section id="projects" class="py-24 bg-black relative overflow-hidden">
  <!-- Updated Grid Container -->
  <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
    <div class="text-center mb-16">
      <span class="text-purple-400 font-semibold tracking-widest uppercase text-sm inline-flex items-center gap-4">
        <span class="w-12 h-[2px] bg-purple-500"></span>
        {{ __('pages.latest_projects_title') }}
        <span class="w-12 h-[2px] bg-purple-500"></span>
      </span>
      <h2 class="text-3xl md:text-5xl font-bold mt-4 mb-4 text-white">
        {{ __('pages.latest_projects_subtitle') }}
      </h2>
    </div>
    
    <!-- Fix: Added items-stretch to grid so cards take full height -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 items-stretch">
      @foreach($projects as $project)
      <!-- Fix: Added flex flex-col h-full for perfect vertical alignment -->
      <a href="{{ route('project', $project) }}" class="group flex flex-col h-full bg-white/5 border border-white/10 rounded-2xl overflow-hidden hover:border-purple-500/50 transition-all duration-500 hover:shadow-[0_10px_40px_rgba(147,51,234,0.15)] md:hover:-translate-y-1">
        <div class="aspect-video relative overflow-hidden shrink-0">
          @if($project->thumbnail)
            <x-responsive-image :path="$project->thumbnail" :alt="$project->title" loading="lazy" sizes="(max-width: 768px) 100vw, (max-width: 1200px) 50vw, 33vw" class="w-full h-full object-cover md:transform md:group-hover:scale-110 transition-transform duration-700" />
          @else
          <div class="w-full h-full bg-gray-800 flex items-center justify-center">
            <i class="fas fa-laptop-code text-4xl text-gray-600"></i>
          </div>
          @endif
          <div class="absolute inset-0 bg-black/60 opacity-0 md:group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
            <span class="px-6 py-2.5 bg-purple-600 rounded-full text-white text-sm font-semibold transform md:translate-y-4 md:group-hover:translate-y-0 transition-transform duration-300">
              {{ __('pages.projects_view_details') }}
              <span class="sr-only"> about {{ $project->title }}</span>
            </span>
          </div>
        </div>
        
        <!-- Fix: flex-1 ensures the content area stretches, pushing tags to the bottom -->
        <div class="p-6 flex flex-col flex-1">
          @if(!empty($project->title))
          <h3 class="text-xl font-bold text-white mb-3 group-hover:text-purple-400 transition-colors">{{ $project->title }}</h3>
          @endif
          <p class="text-gray-400 text-sm line-clamp-3 mb-6 flex-1">{{ \Illuminate\Support\Str::limit(strip_tags($project->description), 120) }}</p>
          
          <div class="flex flex-wrap gap-2 mt-auto">
            @foreach(array_slice($project->tech ?? [], 0, 3) as $tech)
               <span class="px-2.5 py-1 bg-white/10 rounded-md text-xs font-medium text-gray-300 border border-white/5">{{ $tech }}</span>
            @endforeach
             @if(count($project->tech ?? []) > 3)
               <span class="px-2.5 py-1 bg-white/10 rounded-md text-xs font-medium text-gray-300 border border-white/5">+{{ count($project->tech) - 3 }}</span>
            @endif
          </div>
        </div>
      </a>
      @endforeach
    </div>
    
    <div class="text-center mt-16">
      <a href="{{ route('projects') }}" aria-label="{{ __('pages.see_work') }} - {{ __('pages.latest_projects_title') }}" class="inline-flex items-center space-x-3 px-8 py-3.5 border-2 border-purple-500/50 rounded-full text-purple-400 font-semibold hover:bg-purple-500 hover:text-white transition-all duration-300">
        <span>{{ __('pages.see_work') }}</span>
        <i class="fas fa-arrow-right"></i>
      </a>
    </div>
  </div>
</section>

<!-- BLOG SECTION -->
<section id="blog" class="py-24 bg-gradient-to-b from-black to-gray-900 relative">
  <!-- Updated Grid Container -->
  <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
    <div class="text-center mb-16">
      <span class="text-blue-400 font-semibold tracking-widest uppercase text-sm inline-flex items-center gap-4">
        <span class="w-12 h-[2px] bg-blue-500"></span>
        {{ __('pages.recent_articles_title') }}
        <span class="w-12 h-[2px] bg-blue-500"></span>
      </span>
      <h2 class="text-3xl md:text-5xl font-bold mt-4 mb-4 text-white">
        {{ __('pages.recent_articles_subtitle') }}
      </h2>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 items-stretch">
      @if(isset($blogPosts))
      @foreach($blogPosts as $post)
      <a href="{{ route('blog.show', $post->slug) }}" class="group flex flex-col h-full bg-white/5 border border-white/10 rounded-2xl overflow-hidden hover:border-blue-500/50 transition-all duration-500 hover:shadow-[0_10px_40px_rgba(59,130,246,0.15)] md:hover:-translate-y-1">
        <div class="aspect-video relative overflow-hidden shrink-0">
          @if($post->featured_image)
          <x-responsive-image :path="$post->featured_image" :alt="$post->title" loading="lazy" sizes="(max-width: 768px) 100vw, (max-width: 1200px) 50vw, 33vw" class="w-full h-full object-cover md:transform md:group-hover:scale-110 transition-transform duration-700" />
          @else
          <div class="w-full h-full bg-gray-800 flex items-center justify-center">
            <i class="fas fa-newspaper text-4xl text-gray-600"></i>
          </div>
          @endif
          <div class="absolute top-4 left-4 flex space-x-2">
            <span class="px-3 py-1 bg-black/70 backdrop-blur-md rounded-full text-xs font-medium text-white border border-white/10">
              {{ $post->published_at->format('M d, Y') }}
            </span>
            <span class="px-3 py-1 bg-black/70 backdrop-blur-md rounded-full text-xs font-medium text-white border border-white/10 flex items-center space-x-1">
               <i class="far fa-clock text-[10px]"></i>
               <span>{{ $post->reading_time }}</span>
            </span>
          </div>
        </div>
        <div class="p-6 flex flex-col flex-1">
          @if(!empty($post->title))
          <h3 class="text-xl font-bold text-white mb-3 group-hover:text-blue-400 transition-colors line-clamp-2">{{ $post->title }}</h3>
          @endif
          <p class="text-gray-400 text-sm line-clamp-3 mb-4 flex-1">{{ \Illuminate\Support\Str::limit(strip_tags($post->excerpt), 120) }}</p>
          <div class="mt-auto text-blue-400 text-sm font-semibold group-hover:text-blue-300 inline-flex items-center space-x-1">
            <span>{{ __('pages.blog.read_more') }}</span>
            <i class="fas fa-long-arrow-alt-right transform group-hover:translate-x-1 transition-transform"></i>
          </div>
        </div>
      </a>
      @endforeach
      @endif
    </div>
    
    <div class="text-center mt-16">
      <a href="{{ route('blog.index') }}" aria-label="{{ __('pages.blog.read_more') }} {{ __('pages.recent_articles_title') }}" class="inline-flex items-center space-x-3 px-8 py-3.5 border-2 border-blue-500/50 rounded-full text-blue-400 font-semibold hover:bg-blue-500 hover:text-white transition-all duration-300">
        <span>{{ __('pages.blog.read_more') }}</span>
        <i class="fas fa-arrow-right"></i>
      </a>
    </div>
  </div>
</section>

<!-- TESTIMONIALS SECTION -->
<section id="testimonials" class="py-24 bg-black relative overflow-hidden">
  <!-- Updated Grid Container -->
  <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
    <div class="text-center mb-16">
      <span class="text-green-400 font-semibold tracking-widest uppercase text-sm inline-flex items-center gap-4">
        <span class="w-12 h-[2px] bg-green-500"></span>
        {{ __('pages.testimonials_title') }}
        <span class="w-12 h-[2px] bg-green-500"></span>
      </span>
      <h2 class="text-3xl md:text-5xl font-bold mt-4 mb-4 text-white">
        {{ __('pages.testimonials_subtitle') }}
      </h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-24">
      @if(isset($testimonials))
      @forelse($testimonials as $testimonial)
      <div class="bg-white/5 border border-white/10 rounded-2xl p-8 relative hover:bg-white/10 transition-colors duration-300">
        <div class="flex text-yellow-400 mb-6">
          @for($i = 0; $i < $testimonial->rating; $i++)
          <i class="fas fa-star text-sm mr-1"></i>
          @endfor
        </div>
        <p class="text-gray-300 mb-8 italic text-lg leading-relaxed">"{{ $testimonial->content }}"</p>
        <div class="flex items-center">
          <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-500 rounded-full flex items-center justify-center font-bold text-white text-lg shadow-lg">
            {{ substr($testimonial->name, 0, 1) }}
          </div>
          <div class="ml-4">
            <h3 class="text-white font-bold text-lg">{{ $testimonial->name }}</h3>
            @if($testimonial->role)
            <p class="text-gray-400 text-sm">{{ $testimonial->role }}</p>
            @endif
          </div>
        </div>
      </div>
      @empty
      <div class="col-span-full text-center text-gray-500 bg-white/5 rounded-2xl p-12 border border-white/5">
        <i class="far fa-comment-dots text-4xl mb-4 text-gray-600"></i>
        <p>{{ __('pages.no_active_testimonials') }}</p>
      </div>
      @endforelse
      @endif
    </div>

    <!-- Review Form -->
    <div class="max-w-2xl mx-auto bg-gradient-to-b from-white/10 to-white/5 backdrop-blur-xl border border-white/10 rounded-3xl p-8 md:p-10 relative overflow-hidden shadow-2xl">
      <div class="absolute -top-24 -right-24 w-48 h-48 bg-green-500/20 rounded-full blur-[80px] pointer-events-none"></div>

      <div class="relative z-10">
        <h3 class="text-2xl font-bold text-white mb-8 text-center">{{ __('pages.testimonial_form_title') }}</h3>

        @if(session('success'))
        <div class="mb-8 p-4 bg-green-500/20 border border-green-500/50 rounded-xl text-green-300 text-center font-medium">
          {{ session('success') }}
        </div>
        @endif

        @if($errors->any())
        <div class="mb-8 p-4 bg-red-500/20 border border-red-500/50 rounded-xl text-red-300 text-center">
          <ul class="list-disc list-inside">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
        @endif

        <form action="{{ route('testimonials.store') }}" method="POST" class="space-y-6">
          @csrf
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <label for="testimonial_name" class="block text-gray-300 font-medium text-sm mb-2">{{ __('pages.testimonial_form_name') }}</label>
              <input type="text" id="testimonial_name" name="name" required class="w-full bg-black/50 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-green-500/50 focus:border-green-500 transition-all">
            </div>
            <div>
              <label for="testimonial_role" class="block text-gray-300 font-medium text-sm mb-2">{{ __('pages.testimonial_form_role') }}</label>
              <input type="text" id="testimonial_role" name="role" class="w-full bg-black/50 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-green-500/50 focus:border-green-500 transition-all">
            </div>
          </div>
          <div>
            <label class="block text-gray-300 font-medium text-sm mb-3">{{ __('pages.testimonial_form_rating') }}</label>
            <div class="flex space-x-4 bg-black/30 p-3 rounded-xl inline-flex border border-white/5">
              @foreach([5, 4, 3, 2, 1] as $rating)
              <label class="cursor-pointer flex items-center space-x-2 hover:scale-110 transition-transform">
                <input type="radio" name="rating" value="{{ $rating }}" {{ $loop->first ? 'checked' : '' }} class="form-radio text-green-500 bg-transparent border-white/20 focus:ring-green-500 focus:ring-offset-0">
                <span class="sr-only">{{ $rating }} Stars</span>
                <span class="text-yellow-400 flex" aria-hidden="true">
                  @for($i = 0; $i < $rating; $i++) <i class="fas fa-star text-sm"></i> @endfor
                </span>
              </label>
              @endforeach
            </div>
          </div>
          <div>
            <label for="testimonial_content" class="block text-gray-300 font-medium text-sm mb-2">{{ __('pages.testimonial_form_content') }}</label>
            <textarea id="testimonial_content" name="content" rows="4" required class="w-full bg-black/50 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-green-500/50 focus:border-green-500 transition-all resize-none"></textarea>
          </div>
          <button type="submit" class="w-full bg-gradient-to-r from-green-600 to-emerald-600 text-white font-bold py-4 rounded-xl hover:shadow-[0_0_25px_rgba(16,185,129,0.4)] transition-all duration-300">
            {{ __('pages.testimonial_form_submit') }}
          </button>
        </form>
      </div>
    </div>
  </div>
</section>

<!-- STACK SECTION -->
<section id="stack" class="py-32 bg-gradient-to-b from-black via-gray-900/50 to-black overflow-hidden relative">
  <div class="absolute inset-0 pointer-events-none">
    <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg%20width%3D%22100%22%20height%3D%22100%22%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%3E%3Cdefs%3E%3Cpattern%20id%3D%22tech-grid%22%20width%3D%22100%22%20height%3D%22100%22%20patternUnits%3D%22userSpaceOnUse%22%3E%3Ccircle%20cx%3D%2250%22%20cy%3D%2250%22%20r%3D%221%22%20fill%3D%22rgba%28255%2C255%2C255%2C0.05%29%22/%3E%3C/pattern%3E%3C/defs%3E%3Crect%20width%3D%22100%25%22%20height%3D%22100%25%22%20fill%3D%22url%28%23tech-grid%29%22/%3E%3C/svg%3E')]"></div>
    <div class="floating-icon top-20 left-10 text-purple-400/10 text-6xl animate-float-slow"><i class="fab fa-python"></i></div>
    <div class="floating-icon top-40 right-20 text-blue-400/10 text-5xl animate-float-slow delay-1000"><i class="fas fa-robot"></i></div>
    <div class="floating-icon bottom-20 left-1/4 text-green-400/10 text-7xl animate-float-slow delay-500"><i class="fas fa-search"></i></div>
    <div class="floating-icon bottom-40 right-1/3 text-yellow-400/10 text-6xl animate-float-slow delay-1500"><i class="fas fa-cloud"></i></div>
    <div class="absolute top-0 left-1/2 w-px h-full bg-gradient-to-b from-transparent via-purple-500/10 to-transparent"></div>
    <div class="absolute top-1/2 left-0 w-full h-px bg-gradient-to-r from-transparent via-blue-500/10 to-transparent"></div>
  </div>
  
  <!-- Updated Grid Container -->
  <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
    <div class="text-center mb-20">
      <span class="text-purple-400 font-semibold tracking-widest uppercase text-sm inline-flex items-center gap-4">
        <span class="w-12 h-[2px] bg-purple-500"></span>
        {{ __('pages.my_arsenal') }}
        <span class="w-12 h-[2px] bg-purple-500"></span>
      </span>
      <h2 class="text-4xl md:text-5xl lg:text-6xl font-bold mt-4 mb-6">
        <span class="bg-gradient-to-r from-purple-400 via-blue-400 to-cyan-400 bg-clip-text text-transparent md:animate-gradient-x md:bg-[length:200%_auto]">
          {{ __('pages.stack_h1') }}
        </span>
      </h2>
      <p class="text-lg md:text-xl text-gray-400 max-w-3xl mx-auto leading-relaxed">
        {{ __('pages.stack_subtitle') }}
      </p>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-24 items-stretch">
      <!-- Frontend -->
      <div class="group relative md:transform transition-all duration-500 h-full flex flex-col">
        <div class="absolute inset-0 bg-gradient-to-r from-blue-600/20 to-cyan-600/20 rounded-3xl blur-xl opacity-0 md:group-hover:opacity-100 md:group-hover:shadow-[0_0_25px_rgba(6,182,212,0.3)] transition-all duration-500 pointer-events-none"></div>
        <div class="relative flex-1 bg-white/5 backdrop-blur-xl border border-white/10 rounded-3xl p-8 hover:bg-white/10 hover:border-white/20 transition-all duration-300 md:hover:-translate-y-2 hover:shadow-[0_20px_60px_rgba(0,0,0,0.4)]">
          <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-2xl flex items-center justify-center mb-6 shadow-[0_8px_30px_rgba(0,0,0,0.3)]">
            <i class="fas fa-code text-2xl text-white"></i>
          </div>
          <h3 class="text-2xl font-bold text-white mb-6">{{ __('pages.frontend_title') }}</h3>
          <ul class="space-y-4 text-sm font-medium text-gray-300">
            <li class="flex items-center space-x-3 hover:text-white transition-colors duration-300"><i class="fab fa-html5 text-orange-400 text-lg w-5"></i><span>{{ __('pages.tech_html_css') }}</span></li>
            <li class="flex items-center space-x-3 hover:text-white transition-colors duration-300"><i class="fab fa-js text-yellow-400 text-lg w-5"></i><span>{{ __('pages.tech_js') }}</span></li>
            <li class="flex items-center space-x-3 hover:text-white transition-colors duration-300"><i class="fab fa-vuejs text-green-400 text-lg w-5"></i><span>{{ __('pages.tech_vue') }}</span></li>
            <li class="flex items-center space-x-3 hover:text-white transition-colors duration-300"><i class="fas fa-wind text-cyan-400 text-lg w-5"></i><span>{{ __('pages.tech_tailwind') }}</span></li>
            <li class="flex items-center space-x-3 hover:text-white transition-colors duration-300"><i class="fab fa-bootstrap text-purple-400 text-lg w-5"></i><span>{{ __('pages.tech_bootstrap') }}</span></li>
          </ul>
        </div>
      </div>
      <!-- Backend -->
      <div class="group relative md:transform transition-all duration-500 h-full flex flex-col">
        <div class="absolute inset-0 bg-gradient-to-r from-purple-600/20 to-pink-600/20 rounded-3xl blur-xl opacity-0 md:group-hover:opacity-100 md:group-hover:shadow-[0_0_25px_rgba(219,39,119,0.3)] transition-all duration-500 pointer-events-none"></div>
        <div class="relative flex-1 bg-white/5 backdrop-blur-xl border border-white/10 rounded-3xl p-8 hover:bg-white/10 hover:border-white/20 transition-all duration-300 md:hover:-translate-y-2 hover:shadow-[0_20px_60px_rgba(0,0,0,0.4)]">
          <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-pink-500 rounded-2xl flex items-center justify-center mb-6 shadow-[0_8px_30px_rgba(0,0,0,0.3)]">
            <i class="fas fa-server text-2xl text-white"></i>
          </div>
          <h3 class="text-2xl font-bold text-white mb-6">{{ __('pages.backend_title') }}</h3>
          <ul class="space-y-4 text-sm font-medium text-gray-300">
            <li class="flex items-center space-x-3 hover:text-white transition-colors duration-300"><i class="fab fa-php text-purple-400 text-lg w-5"></i><span>{{ __('pages.tech_php') }}</span></li>
            <li class="flex items-center space-x-3 hover:text-white transition-colors duration-300"><i class="fab fa-laravel text-red-400 text-lg w-5"></i><span>{{ __('pages.tech_laravel') }}</span></li>
            <li class="flex items-center space-x-3 hover:text-white transition-colors duration-300"><i class="fab fa-node-js text-green-400 text-lg w-5"></i><span>{{ __('pages.tech_node') }}</span></li>
            <li class="flex items-center space-x-3 hover:text-white transition-colors duration-300"><i class="fas fa-plug text-blue-400 text-lg w-5"></i><span>{{ __('pages.tech_rest') }}</span></li>
            <li class="flex items-center space-x-3 hover:text-white transition-colors duration-300"><i class="fas fa-project-diagram text-pink-400 text-lg w-5"></i><span>{{ __('pages.tech_graphql') }}</span></li>
          </ul>
        </div>
      </div>
      <!-- Database -->
      <div class="group relative md:transform transition-all duration-500 h-full flex flex-col">
        <div class="absolute inset-0 bg-gradient-to-r from-green-600/20 to-emerald-600/20 rounded-3xl blur-xl opacity-0 md:group-hover:opacity-100 md:group-hover:shadow-[0_0_25px_rgba(16,185,129,0.3)] transition-all duration-500 pointer-events-none"></div>
        <div class="relative flex-1 bg-white/5 backdrop-blur-xl border border-white/10 rounded-3xl p-8 hover:bg-white/10 hover:border-white/20 transition-all duration-300 md:hover:-translate-y-2 hover:shadow-[0_20px_60px_rgba(0,0,0,0.4)]">
          <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-500 rounded-2xl flex items-center justify-center mb-6 shadow-[0_8px_30px_rgba(0,0,0,0.3)]">
            <i class="fas fa-database text-2xl text-white"></i>
          </div>
          <h3 class="text-2xl font-bold text-white mb-6">{{ __('pages.database_title') }}</h3>
          <ul class="space-y-4 text-sm font-medium text-gray-300">
            <li class="flex items-center space-x-3 hover:text-white transition-colors duration-300"><i class="fas fa-database text-blue-400 text-lg w-5"></i><span>{{ __('pages.tech_mysql') }}</span></li>
            <li class="flex items-center space-x-3 hover:text-white transition-colors duration-300"><i class="fas fa-database text-blue-300 text-lg w-5"></i><span>{{ __('pages.tech_postgresql') }}</span></li>
            <li class="flex items-center space-x-3 hover:text-white transition-colors duration-300"><i class="fas fa-memory text-red-400 text-lg w-5"></i><span>{{ __('pages.tech_redis') }}</span></li>
            <li class="flex items-center space-x-3 hover:text-white transition-colors duration-300"><i class="fab fa-docker text-blue-400 text-lg w-5"></i><span>{{ __('pages.tech_docker') }}</span></li>
            <li class="flex items-center space-x-3 hover:text-white transition-colors duration-300"><i class="fab fa-git-alt text-orange-400 text-lg w-5"></i><span>{{ __('pages.tech_git') }}</span></li>
          </ul>
        </div>
      </div>
      <!-- Python & Data -->
      <div class="group relative md:transform transition-all duration-500 h-full flex flex-col">
        <div class="absolute inset-0 bg-gradient-to-r from-yellow-600/20 to-amber-600/20 rounded-3xl blur-xl opacity-0 md:group-hover:opacity-100 md:group-hover:shadow-[0_0_25px_rgba(245,158,11,0.3)] transition-all duration-500 pointer-events-none"></div>
        <div class="relative flex-1 bg-white/5 backdrop-blur-xl border border-white/10 rounded-3xl p-8 hover:bg-white/10 hover:border-white/20 transition-all duration-300 md:hover:-translate-y-2 hover:shadow-[0_20px_60px_rgba(0,0,0,0.4)]">
          <div class="w-16 h-16 bg-gradient-to-br from-yellow-500 to-amber-500 rounded-2xl flex items-center justify-center mb-6 shadow-[0_8px_30px_rgba(0,0,0,0.3)]">
            <i class="fab fa-python text-2xl text-white"></i>
          </div>
          <h3 class="text-2xl font-bold text-white mb-6">{{ __('pages.python_title') }}</h3>
          <ul class="space-y-4 text-sm font-medium text-gray-300">
            <li class="flex items-center space-x-3 hover:text-white transition-colors duration-300"><i class="fab fa-python text-yellow-400 text-lg w-5"></i><span>{{ __('pages.tech_python_web') }}</span></li>
            <li class="flex items-center space-x-3 hover:text-white transition-colors duration-300"><i class="fas fa-robot text-cyan-400 text-lg w-5"></i><span>{{ __('pages.tech_rpa') }}</span></li>
            <li class="flex items-center space-x-3 hover:text-white transition-colors duration-300"><i class="fas fa-chart-bar text-green-400 text-lg w-5"></i><span>{{ __('pages.tech_data_science') }}</span></li>
            <li class="flex items-center space-x-3 hover:text-white transition-colors duration-300"><i class="fas fa-microchip text-red-400 text-lg w-5"></i><span>{{ __('pages.tech_python_api') }}</span></li>
          </ul>
        </div>
      </div>
      <!-- Automation -->
      <div class="group relative md:transform transition-all duration-500 h-full flex flex-col">
        <div class="absolute inset-0 bg-gradient-to-r from-pink-600/20 to-rose-600/20 rounded-3xl blur-xl opacity-0 md:group-hover:opacity-100 md:group-hover:shadow-[0_0_25px_rgba(244,114,182,0.3)] transition-all duration-500 pointer-events-none"></div>
        <div class="relative flex-1 bg-white/5 backdrop-blur-xl border border-white/10 rounded-3xl p-8 hover:bg-white/10 hover:border-white/20 transition-all duration-300 md:hover:-translate-y-2 hover:shadow-[0_20px_60px_rgba(0,0,0,0.4)]">
          <div class="w-16 h-16 bg-gradient-to-br from-pink-500 to-rose-500 rounded-2xl flex items-center justify-center mb-6 shadow-[0_8px_30px_rgba(0,0,0,0.3)]">
            <i class="fas fa-project-diagram text-2xl text-white"></i>
          </div>
          <h3 class="text-2xl font-bold text-white mb-6">{{ __('pages.nocode_title') }}</h3>
          <ul class="space-y-4 text-sm font-medium text-gray-300">
            <li class="flex items-center space-x-3 hover:text-white transition-colors duration-300"><i class="fas fa-cogs text-purple-400 text-lg w-5"></i><span>{{ __('pages.tech_n8n_make') }}</span></li>
            <li class="flex items-center space-x-3 hover:text-white transition-colors duration-300"><i class="fas fa-bolt text-yellow-400 text-lg w-5"></i><span>{{ __('pages.tech_zapier') }}</span></li>
            <li class="flex items-center space-x-3 hover:text-white transition-colors duration-300"><i class="fas fa-cloud text-blue-400 text-lg w-5"></i><span>{{ __('pages.tech_octabase') }}</span></li>
            <li class="flex items-center space-x-3 hover:text-white transition-colors duration-300"><i class="fas fa-link text-green-400 text-lg w-5"></i><span>{{ __('pages.tech_webhooks') }}</span></li>
          </ul>
        </div>
      </div>
      <!-- SEO & Growth -->
      <div class="group relative md:transform transition-all duration-500 h-full flex flex-col">
        <div class="absolute inset-0 bg-gradient-to-r from-orange-600/20 to-red-600/20 rounded-3xl blur-xl opacity-0 md:group-hover:opacity-100 md:group-hover:shadow-[0_0_25px_rgba(239,68,68,0.3)] transition-all duration-500 pointer-events-none"></div>
        <div class="relative flex-1 bg-white/5 backdrop-blur-xl border border-white/10 rounded-3xl p-8 hover:bg-white/10 hover:border-white/20 transition-all duration-300 md:hover:-translate-y-2 hover:shadow-[0_20px_60px_rgba(0,0,0,0.4)]">
          <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-red-500 rounded-2xl flex items-center justify-center mb-6 shadow-[0_8px_30px_rgba(0,0,0,0.3)]">
            <i class="fas fa-search text-2xl text-white"></i>
          </div>
          <h3 class="text-2xl font-bold text-white mb-6">{{ __('pages.seo_title') }}</h3>
          <ul class="space-y-4 text-sm font-medium text-gray-300">
            <li class="flex items-center space-x-3 hover:text-white transition-colors duration-300"><i class="fas fa-chart-line text-green-400 text-lg w-5"></i><span>{{ __('pages.tech_seo') }}</span></li>
            <li class="flex items-center space-x-3 hover:text-white transition-colors duration-300"><i class="fab fa-google text-blue-400 text-lg w-5"></i><span>{{ __('pages.tech_search_console') }}</span></li>
            <li class="flex items-center space-x-3 hover:text-white transition-colors duration-300"><i class="fas fa-tachometer-alt text-purple-400 text-lg w-5"></i><span>{{ __('pages.tech_pagespeed') }}</span></li>
            <li class="flex items-center space-x-3 hover:text-white transition-colors duration-300"><i class="fas fa-share-alt text-cyan-400 text-lg w-5"></i><span>{{ __('pages.tech_schema') }}</span></li>
          </ul>
        </div>
      </div>
    </div>
    
    <!-- Skills Progress Bars -->
    <div class="max-w-4xl mx-auto bg-white/5 backdrop-blur-md rounded-3xl p-8 md:p-12 border border-white/10">
      <h3 class="text-2xl font-bold text-center text-white mb-10">{{ __('pages.proficiency_title') }}</h3>
      <div class="space-y-8">
        @foreach([
          ['pages.skill_laravel', 95, 'from-red-500 to-pink-500'],
          ['pages.skill_frontend_dev', 90, 'from-blue-500 to-cyan-500'],
          ['pages.skill_database_design', 85, 'from-green-500 to-emerald-500'],
          ['pages.skill_api_dev', 92, 'from-purple-500 to-indigo-500'],
          ['pages.skill_python_automation', 88, 'from-yellow-500 to-amber-500'],
          ['pages.skill_devops', 80, 'from-orange-500 to-yellow-500'],
          ['pages.skill_seo_growth', 85, 'from-pink-500 to-purple-500']
        ] as $skill)
        <div class="group">
          <div class="flex justify-between items-center mb-3">
            <span class="text-gray-200 font-semibold tracking-wide uppercase text-xs group-hover:text-white transition-colors duration-300">{{ __($skill[0]) }}</span>
            <span class="text-gray-400 font-bold text-sm">{{ $skill[1] }}%</span>
          </div>
          <div class="h-2.5 bg-black/50 rounded-full overflow-hidden backdrop-blur-sm border border-white/5">
            <div class="h-full bg-gradient-to-r {{ $skill[2] }} rounded-full relative overflow-hidden transition-all duration-1000 ease-out shadow-[0_0_10px_rgba(255,255,255,0.2)]" style="width: 0%" data-width="{{ $skill[1] }}%">
              <div class="absolute inset-0 bg-white/20 animate-shimmer"></div>
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</section>

<!-- STYLES -->
<style nonce="{{ app('csp-nonce') }}">
@keyframes float-slow {
  0%, 100% { transform: translateY(0px); }
  50% { transform: translateY(-20px); }
}
@keyframes spin-slow {
  from { transform: rotate(0deg); }
  to { transform: rotate(360deg); }
}
@keyframes spin-reverse {
  from { transform: rotate(360deg); }
  to { transform: rotate(0deg); }
}
@keyframes gradient-x {
  0%, 100% { background-position: 0% 50%; }
  50% { background-position: 100% 50%; }
}
@keyframes shimmer {
  0% { transform: translateX(-100%); }
  100% { transform: translateX(100%); }
}
@keyframes blink {
  0%, 50%, 100% { opacity: 1; }
  25%, 75% { opacity: 0; }
}
@keyframes text-slide {
  0%, 18%   { transform: translateY(0); }
  20%, 38%  { transform: translateY(-100%); }
  40%, 58%  { transform: translateY(-200%); }
  60%, 78%  { transform: translateY(-300%); }
  80%, 100% { transform: translateY(-400%); }
}
@keyframes scroll {
  0% { transform: translateY(0); opacity: 0; }
  50% { opacity: 1; }
  100% { transform: translateY(8px); opacity: 0; }
}
@keyframes fade-in-down {
  from { opacity: 0; transform: translateY(-20px); }
  to { opacity: 1; transform: translateY(0); }
}
@keyframes fade-in-up {
  from { opacity: 0; transform: translateY(20px); }
  to { opacity: 1; transform: translateY(0); }
}
@keyframes fade-in {
  from { opacity: 0; }
  to { opacity: 1; }
}
@keyframes float {
  0%, 100% { transform: translateY(0) rotate(0deg); }
  33% { transform: translateY(-10px) rotate(-5deg); }
  66% { transform: translateY(5px) rotate(5deg); }
}
.animate-float-slow { animation: float-slow 6s ease-in-out infinite; }
.animate-spin-slow { animation: spin-slow 20s linear infinite; }
.animate-spin-reverse { animation: spin-reverse 25s linear infinite; }
.animate-gradient-x { animation: gradient-x 3s ease infinite; }
.animate-shimmer { animation: shimmer 2s infinite; }
.animate-blink { animation: blink 1s infinite; }
.animate-text-slide { animation: text-slide 40s ease-in-out infinite; }
.animate-fade-in-down { animation: fade-in-down 0.8s ease-out backwards; }
.animate-fade-in-up { animation: fade-in-up 0.8s ease-out backwards; }
.animate-fade-in { animation: fade-in 0.8s ease-out backwards; }
.animate-float { animation: float 3s ease-in-out infinite; }

/* Delay classes */
.delay-200 { animation-delay: 200ms; }
.delay-400 { animation-delay: 400ms; }
.delay-500 { animation-delay: 500ms; }
.delay-600 { animation-delay: 600ms; }
.delay-700 { animation-delay: 700ms; }
.delay-800 { animation-delay: 800ms; }
.delay-1000 { animation-delay: 1000ms; }
.delay-1500 { animation-delay: 1500ms; }

.perspective-1000 { perspective: 1000px; }
.rotate-y-6 { transform: rotateY(6deg); }

.floating-icon {
  position: absolute;
  pointer-events: none;
  animation: float-slow 8s ease-in-out infinite;
}
::-webkit-scrollbar { width: 10px; }
::-webkit-scrollbar-track { background: #050505; }
::-webkit-scrollbar-thumb {
  background: linear-gradient(to bottom, #8b5cf6, #3b82f6);
  border-radius: 5px;
}
::-webkit-scrollbar-thumb:hover { background: linear-gradient(to bottom, #a78bfa, #60a5fa); }
</style>

<!-- SCRIPTS -->
<script nonce="{{ app('csp-nonce') }}">
document.addEventListener('DOMContentLoaded', function() {
  const isDesktop = window.innerWidth >= 768;

  // Intersection Observer for Animations
  const observerOptions = { threshold: 0.1, rootMargin: '0px 0px -50px 0px' };
  const observer = new IntersectionObserver(function(entries) {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        if (isDesktop) {
          entry.target.classList.add('animate-fade-in-up');
        } else {
          entry.target.style.opacity = 1;
          entry.target.style.transform = 'none';
        }
        if (entry.target.id === 'stack') animateProgressBars();
        observer.unobserve(entry.target);
      }
    });
  }, observerOptions);

  document.querySelectorAll('section').forEach(section => observer.observe(section));

  // Scroll Progress (Throttled for Performance)
  let ticking = false;
  window.addEventListener('scroll', () => {
    if (!ticking) {
      window.requestAnimationFrame(() => {
        const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
        const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        const progressBar = document.getElementById('scroll-progress');
        if (progressBar) progressBar.style.width = (winScroll / height) * 100 + "%";
        ticking = false;
      });
      ticking = true;
    }
  });

  // Progress Bars Animation
  function animateProgressBars() {
    document.querySelectorAll('[data-width]').forEach((bar, index) => {
      setTimeout(() => { bar.style.width = bar.getAttribute('data-width'); }, index * 150);
    });
  }

  // Desktop Only Effects (CPU/GPU optimizations)
  if (isDesktop) {
    let mouseTicking = false;
    document.addEventListener('mousemove', (e) => {
      if (!mouseTicking) {
        window.requestAnimationFrame(() => {
          const mouseX = e.clientX / window.innerWidth;
          const mouseY = e.clientY / window.innerHeight;
          document.querySelectorAll('.floating-icon').forEach((icon, index) => {
            const speed = (index + 1) * 0.5;
            icon.style.transform = `translate(${(mouseX - 0.5) * speed * 50}px, ${(mouseY - 0.5) * speed * 50}px)`;
          });
          mouseTicking = false;
        });
        mouseTicking = true;
      }
    });

    // 3D Card Effect (Using requestAnimationFrame)
    const cards = document.querySelectorAll('.perspective-1000');
    cards.forEach(card => {
      let cardTicking = false;
      card.addEventListener('mousemove', (e) => {
        if (!cardTicking) {
          window.requestAnimationFrame(() => {
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            const centerX = rect.width / 2;
            const centerY = rect.height / 2;
            // Redus gradul de rotatie la 20 pentru un efect mai fin, B2B
            card.style.transform = `rotateX(${(centerY - y) / 20}deg) rotateY(${(x - centerX) / 20}deg) translateZ(10px)`;
            cardTicking = false;
          });
          cardTicking = true;
        }
      });
      card.addEventListener('mouseleave', () => {
        card.style.transform = 'rotateX(0) rotateY(0) translateZ(0)';
      });
    });

    // Particles System
    function createParticle() {
      const particle = document.createElement('div');
      particle.className = 'particle';
      particle.style.cssText = `
        position: absolute; width: 3px; height: 3px;
        background: rgba(255, 255, 255, 0.4); pointer-events: none; border-radius: 50%;
        left: ${Math.random() * 100}%; top: ${Math.random() * 100}%;
        animation: particle-float ${6 + Math.random() * 12}s linear infinite;
        box-shadow: 0 0 10px rgba(255,255,255,0.8);
      `;
      const container = document.querySelector('.particles');
      if (container) {
        container.appendChild(particle);
        setTimeout(() => particle.remove(), 15000);
      }
    }
    // Redus generarea la 500ms pentru a salva memorie
    setInterval(createParticle, 500);
  }

  // Smooth scroll
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
      e.preventDefault();
      const target = document.querySelector(this.getAttribute('href'));
      if (target) target.scrollIntoView({ behavior: 'smooth', block: 'start' });
    });
  });
});

// Particle Float Style Injection
const style = document.createElement('style');
style.setAttribute('nonce', '{{ app('csp-nonce') }}');
style.textContent = `@keyframes particle-float { 0% { transform: translateY(100vh) rotate(0deg) scale(1); opacity: 0; } 10% { opacity: 1; } 90% { opacity: 1; } 100% { transform: translateY(-100vh) rotate(360deg) scale(0.5); opacity: 0; } }`;
document.head.appendChild(style);
</script>
@endsection
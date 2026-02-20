@extends('layouts.app')
@section('content')
<section class="hero min-h-screen flex items-center relative overflow-hidden bg-black">
  <div class="absolute inset-0 z-0">
    <div class="absolute top-20 left-10 w-72 h-72 bg-purple-600/30 rounded-full blur-[100px] animate-pulse"></div>
    <div class="absolute bottom-20 right-10 w-96 h-96 bg-blue-600/30 rounded-full blur-[120px] animate-pulse delay-700"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-cyan-600/20 rounded-full blur-[150px] animate-pulse delay-1000"></div>
    <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" xmlns="http://www.w3.org/2000/svg"%3E%3Cdefs%3E%3Cpattern id="grid" width="60" height="60" patternUnits="userSpaceOnUse"%3E%3Cpath d="M 60 0 L 0 0 0 60" fill="none" stroke="rgba(255,255,255,0.03)" stroke-width="1"/%3E%3C/pattern%3E%3C/defs%3E%3Crect width="100%25" height="100%25" fill="url(%23grid)"/%3E%3C/svg%3E')] opacity-50"></div>
    <div class="particles absolute inset-0"></div>
    <div class="absolute top-1/4 left-1/4 w-2 h-2 bg-purple-400 rounded-full animate-ping"></div>
    <div class="absolute top-3/4 right-1/3 w-3 h-3 bg-blue-400 rounded-full animate-ping delay-500"></div>
    <div class="absolute bottom-1/4 left-1/3 w-2 h-2 bg-cyan-400 rounded-full animate-ping delay-1000"></div>
  </div>
  
  <div class="container mx-auto px-4 relative z-10">
    <div class="max-w-5xl mx-auto">
      <div class="flex justify-center mb-10">
        <div class="relative group">
          <div class="absolute -inset-4 bg-gradient-to-r from-purple-600 via-blue-600 to-cyan-600 rounded-full opacity-75 blur-lg group-hover:opacity-100 animate-spin-slow"></div>
          <div class="absolute -inset-6 bg-gradient-to-r from-cyan-600 via-purple-600 to-blue-600 rounded-full opacity-50 blur-xl animate-spin-reverse"></div>
          <div class="relative w-40 h-40 md:w-48 md:h-48">
            <div class="absolute inset-0 bg-gradient-to-r from-purple-600 via-blue-600 to-cyan-600 rounded-full animate-spin-slow"></div>
            <div class="absolute inset-1 bg-black rounded-full"></div>
            <img src="{{ asset('img/avatar.webp') }}" alt="avatar" fetchpriority="high" width="400" height="400" class="absolute inset-2 w-full h-full object-cover rounded-full border-2 border-black transform group-hover:scale-105 transition-transform duration-500">
            <div class="absolute bottom-2 right-2 flex items-center space-x-1 bg-black/80 backdrop-blur-sm px-3 py-1 rounded-full border border-green-500/50 shadow-[0_0_20px_rgba(34,197,94,0.5)]">
              <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse shadow-[0_0_10px_rgba(34,197,94,0.8)]"></div>
              <span class="text-xs text-green-400 font-medium">{{ __('pages.available_status') }}</span>
            </div>
          </div>
        </div>
      </div>
      <div class="text-center space-y-8">
        <div class="space-y-4">
          <h1 class="text-4xl md:text-6xl lg:text-7xl font-bold">
            <span class="block text-gray-400 animate-fade-in-down">{{ __('pages.hero_hi') }}</span>
            <span class="block mt-2 relative">
              <span class="bg-gradient-to-r from-purple-400 via-blue-400 to-cyan-400 bg-clip-text text-transparent animate-gradient-x animate-fade-in-up delay-200 bg-[length:200%_auto]">
                Max
              </span>
              <span class="absolute -right-8 top-1/2 -translate-y-1/2 w-1 h-12 bg-cyan-400 animate-blink shadow-[0_0_10px_rgba(34,211,238,0.8)]"></span>
            </span>
          </h1>
          <div class="h-8 md:h-10 relative overflow-hidden">
            <div class="animate-text-slide">
              <p class="text-xl md:text-2xl text-gray-300 h-8 md:h-10 flex items-center justify-center">{{ __('pages.role_1') }}</p>
              <p class="text-xl md:text-2xl text-gray-300 h-8 md:h-10 flex items-center justify-center">{{ __('pages.role_2') }}</p>
              <p class="text-xl md:text-2xl text-gray-300 h-8 md:h-10 flex items-center justify-center">{{ __('pages.role_3') }}</p>
              <p class="text-xl md:text-2xl text-gray-300 h-8 md:h-10 flex items-center justify-center">{{ __('pages.role_4') }}</p>
            </div>
          </div>
        </div>
        <p class="text-lg md:text-xl text-gray-400 max-w-3xl mx-auto leading-relaxed animate-fade-in delay-400">
          {{ __('pages.hero_subtitle') }}
        </p>
        <div class="flex flex-wrap justify-center gap-4 md:gap-6 animate-fade-in-up delay-600">
          <a href="{{ route('projects', app()->getLocale()) }}" class="group relative">
            <div class="absolute -inset-1 bg-gradient-to-r from-purple-600 to-blue-600 rounded-full opacity-70 blur group-hover:opacity-100 transition duration-300"></div>
            <button class="relative px-8 py-4 bg-black rounded-full text-white font-medium flex items-center space-x-3 group-hover:scale-105 transition-all duration-300 shadow-2xl">
              <span>{{ __('pages.see_work') }}</span>
              <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform duration-300"></i>
            </button>
          </a>
          <a href="{{ route('contact', app()->getLocale()) }}" class="group px-8 py-4 rounded-full border-2 border-gray-700 text-gray-300 font-medium flex items-center space-x-3 hover:border-gray-500 hover:text-white hover:bg-white/5 transition-all duration-300 hover:shadow-[0_0_30px_rgba(255,255,255,0.1)]">
            <i class="far fa-envelope"></i>
            <span>{{ __('pages.hire_me') }}</span>
          </a>
        </div>
        <div class="flex justify-center space-x-6 animate-fade-in delay-800">
          <a href="https://www.facebook.com/profile.php?id=100001274142909" target="_blank" aria-label="Facebook" class="group relative transform hover:-translate-y-2 transition-all duration-300">
            <div class="absolute -inset-2 bg-gradient-to-r from-purple-600 to-blue-600 rounded-lg opacity-0 blur group-hover:opacity-60 transition duration-300"></div>
            <div class="relative w-12 h-12 bg-white/5 backdrop-blur-sm border border-white/10 rounded-lg flex items-center justify-center group-hover:bg-white/10 group-hover:border-white/20 transition-all duration-300 group-hover:shadow-[0_10px_40px_rgba(0,0,0,0.3)]">
              <i class="fab fa-facebook text-gray-400 group-hover:text-white transition-colors duration-300"></i>
            </div>
          </a>
        </div>
      </div>
      <div class="absolute bottom-10 left-1/2 -translate-x-1/2 animate-bounce">
        <a href="#about" class="flex flex-col items-center text-gray-400 hover:text-white transition-colors duration-300 group">
          <span class="text-xs uppercase tracking-wider mb-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">{{ __('pages.scroll_text') }}</span>
          <div class="w-6 h-10 border-2 border-gray-600 rounded-full p-1 group-hover:border-white transition-colors duration-300 group-hover:shadow-[0_0_20px_rgba(255,255,255,0.3)]">
            <div class="w-1 h-2 bg-gray-600 rounded-full mx-auto animate-scroll group-hover:bg-white transition-colors duration-300"></div>
          </div>
        </a>
      </div>
    </div>
  </div>
</section>

<section id="about" class="py-32 relative bg-black overflow-hidden">
  <div class="absolute inset-0">
    <div class="absolute top-0 left-1/4 w-96 h-96 bg-purple-600/10 rounded-full blur-[100px] animate-float-slow"></div>
    <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-blue-600/10 rounded-full blur-[100px] animate-float-slow delay-1000"></div>
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,_var(--tw-gradient-stops))] from-purple-900/10 via-transparent to-transparent"></div>
  </div>
  
  <div class="container mx-auto px-4 relative z-10">
    <div class="grid lg:grid-cols-2 gap-16 lg:gap-24 items-center">
      <div class="relative order-2 lg:order-1">
        <div class="relative group perspective-1000">
          <div class="absolute -top-6 -left-6 w-24 h-24 bg-gradient-to-br from-purple-600 to-blue-600 rounded-3xl opacity-20 blur-xl animate-pulse"></div>
          <div class="absolute -bottom-6 -right-6 w-32 h-32 bg-gradient-to-br from-blue-600 to-cyan-600 rounded-3xl opacity-20 blur-xl animate-pulse delay-500"></div>
          <div class="relative rounded-3xl overflow-hidden transform-gpu transition-all duration-700 group-hover:rotate-y-12">
            <div class="absolute inset-0 bg-gradient-to-br from-purple-600/20 via-transparent to-blue-600/20 z-10"></div>
            <img src="{{ asset('img/avatar.webp') }}" alt="About" width="800" height="800" class="w-full h-auto object-cover transform group-hover:scale-110 transition-transform duration-700">
          </div>
          <div class="absolute -bottom-8 -right-8 bg-black/60 backdrop-blur-2xl border border-white/10 rounded-2xl p-6 shadow-2xl transform hover:scale-105 transition-all duration-300">
            <div class="flex items-center space-x-4">
              <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-500 rounded-xl flex items-center justify-center shadow-[0_0_30px_rgba(34,197,94,0.5)]">
                <i class="fas fa-code text-white"></i>
              </div>
              <div>
                <p class="text-2xl font-bold text-white">3+</p>
                <p class="text-sm text-gray-400">{{ __('pages.years_experience') }}</p>
              </div>
            </div>
          </div>
          <div class="absolute -top-4 -right-4 bg-gradient-to-br from-purple-500 to-pink-500 w-20 h-20 rounded-2xl flex items-center justify-center text-white font-bold text-xl shadow-2xl animate-float">
            <i class="fas fa-star"></i>
          </div>
        </div>
      </div>
      <div class="space-y-8 order-1 lg:order-2">
        <div>
          <span class="text-purple-400 font-medium tracking-wider uppercase text-sm flex items-center gap-2">
            <span class="w-8 h-[2px] bg-purple-400"></span>
            {{ __('pages.get_to_know_me') }}
          </span>
          <h2 class="text-4xl md:text-5xl lg:text-6xl font-bold mt-4">
            <span class="bg-gradient-to-r from-purple-400 via-blue-400 to-cyan-400 bg-clip-text text-transparent animate-gradient-x bg-[length:200%_auto]">
              {{ __('pages.about_h1') }}
            </span>
          </h2>
        </div>
        <div class="space-y-4 text-gray-300 text-lg leading-relaxed">
          <p class="hover:text-gray-100 transition-colors duration-300">{{ __('pages.about_text') }}</p>
          <p class="hover:text-gray-100 transition-colors duration-300">{{ __('pages.about_text_extra') }}</p>
        </div>
        <div class="grid grid-cols-2 gap-4">
          @foreach([
            ['pages.skill_frontend', 'fas fa-laptop-code', 'from-blue-500 to-cyan-500'],
            ['pages.skill_backend', 'fas fa-server', 'from-purple-500 to-pink-500'],
            ['pages.skill_database', 'fas fa-database', 'from-green-500 to-emerald-500'],
            ['pages.skill_api', 'fas fa-plug', 'from-orange-500 to-red-500']
          ] as $skill)
          <div class="group bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-4 hover:bg-white/10 hover:border-white/20 transition-all duration-300 hover:shadow-[0_8px_32px_rgba(0,0,0,0.3)] hover:-translate-y-1">
            <div class="flex items-center space-x-3">
              <div class="w-10 h-10 bg-gradient-to-br {{ $skill[2] }} rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300 shadow-lg">
                <i class="{{ $skill[1] }} text-white text-sm"></i>
              </div>
              <span class="text-gray-300 font-medium group-hover:text-white transition-colors duration-300">{{ __($skill[0]) }}</span>
            </div>
          </div>
          @endforeach
        </div>
        <div class="flex items-center space-x-6 pt-4">
          <a href="{{ route('contact', app()->getLocale()) }}" class="group relative inline-flex items-center space-x-2">
            <div class="absolute -inset-2 bg-gradient-to-r from-purple-600 to-blue-600 rounded-full opacity-0 blur group-hover:opacity-60 transition duration-300"></div>
            <span class="relative px-8 py-3 bg-gradient-to-r from-purple-600 to-blue-600 rounded-full text-white font-medium group-hover:scale-105 transition-transform duration-300 shadow-[0_4px_20px_rgba(147,51,234,0.5)]">
              {{ __('pages.work_together') }}
            </span>
          </a>
          <a href="#" class="text-gray-400 hover:text-white transition-colors duration-300 flex items-center space-x-2 group">
            <span>{{ __('pages.download_cv') }}</span>
            <i class="fas fa-download group-hover:translate-y-1 transition-transform duration-300"></i>
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

<section id="projects" class="py-20 bg-black relative overflow-hidden">
  <div class="container mx-auto px-4 relative z-10">
    <div class="text-center mb-16">
      <span class="text-purple-400 tracking-wider uppercase text-sm inline-flex items-center gap-2">
        <span class="w-8 h-[2px] bg-purple-400"></span>
        {{ __('pages.latest_projects_title') }}
        <span class="w-8 h-[2px] bg-purple-400"></span>
      </span>
      <h2 class="text-3xl md:text-5xl font-bold mt-4 mb-4 text-white">
        {{ __('pages.latest_projects_subtitle') }}
      </h2>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
      @foreach($projects as $project)
      <a href="{{ route('project', ['locale' => app()->getLocale(), 'project' => $project]) }}" class="group block bg-white/5 border border-white/10 rounded-2xl overflow-hidden hover:border-purple-500/50 transition-all duration-500">
        <div class="aspect-video relative overflow-hidden">
          @if($project->thumbnail_url)
          <img src="{{ $project->thumbnail_url }}" alt="{{ $project->title }}" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
          @else
          <div class="w-full h-full bg-gray-800 flex items-center justify-center">
            <i class="fas fa-code text-4xl text-gray-600"></i>
          </div>
          @endif
          <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
            <span class="px-6 py-2 bg-purple-600 rounded-full text-white text-sm font-medium transform translate-y-4 group-hover:translate-y-0 transition-transform duration-300">
              {{ __('pages.projects_view_details') }}
            </span>
          </div>
        </div>
        <div class="p-6">
          <h3 class="text-xl font-bold text-white mb-2 group-hover:text-purple-400 transition-colors">{{ $project->title }}</h3>
          <p class="text-gray-400 text-sm line-clamp-2">{{ Str::limit(strip_tags($project->description), 100) }}</p>
        </div>
      </a>
      @endforeach
    </div>
    <div class="text-center mt-12">
      <a href="{{ route('projects', app()->getLocale()) }}" class="inline-flex items-center space-x-2 text-purple-400 hover:text-white transition-colors">
        <span>{{ __('pages.see_work') }}</span>
        <i class="fas fa-arrow-right"></i>
      </a>
    </div>
  </div>
</section>

<section id="blog" class="py-20 bg-gradient-to-b from-black to-gray-900 relative">
  <div class="container mx-auto px-4 relative z-10">
    <div class="text-center mb-16">
      <span class="text-blue-400 tracking-wider uppercase text-sm inline-flex items-center gap-2">
        <span class="w-8 h-[2px] bg-blue-400"></span>
        {{ __('pages.recent_articles_title') }}
        <span class="w-8 h-[2px] bg-blue-400"></span>
      </span>
      <h2 class="text-3xl md:text-5xl font-bold mt-4 mb-4 text-white">
        {{ __('pages.recent_articles_subtitle') }}
      </h2>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
      @foreach($blogPosts as $post)
      <a href="{{ route('blog.show', ['locale' => app()->getLocale(), 'slug' => $post->slug]) }}" class="group block bg-white/5 border border-white/10 rounded-2xl overflow-hidden hover:border-blue-500/50 transition-all duration-500">
        <div class="aspect-video relative overflow-hidden">
          @if($post->image_url)
          <img src="{{ $post->image_url }}" alt="{{ $post->title }}" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
          @else
          <div class="w-full h-full bg-gray-800 flex items-center justify-center">
            <i class="fas fa-newspaper text-4xl text-gray-600"></i>
          </div>
          @endif
          <div class="absolute top-4 left-4">
            <span class="px-3 py-1 bg-black/60 backdrop-blur-md rounded-full text-xs text-white border border-white/10">
              {{ $post->published_at->format('M d, Y') }}
            </span>
          </div>
        </div>
        <div class="p-6">
          <h3 class="text-xl font-bold text-white mb-2 group-hover:text-blue-400 transition-colors">{{ $post->title }}</h3>
          <p class="text-gray-400 text-sm line-clamp-3">{{ Str::limit(strip_tags($post->excerpt), 120) }}</p>
        </div>
      </a>
      @endforeach
    </div>
    <div class="text-center mt-12">
      <a href="{{ route('blog.index', app()->getLocale()) }}" class="inline-flex items-center space-x-2 text-blue-400 hover:text-white transition-colors">
        <span>{{ __('pages.blog.read_more') }}</span>
        <i class="fas fa-arrow-right"></i>
      </a>
    </div>
  </div>
</section>

<section id="testimonials" class="py-20 bg-black relative overflow-hidden">
  <div class="container mx-auto px-4 relative z-10">
    <div class="text-center mb-16">
      <span class="text-green-400 tracking-wider uppercase text-sm inline-flex items-center gap-2">
        <span class="w-8 h-[2px] bg-green-400"></span>
        {{ __('pages.testimonials_title') }}
        <span class="w-8 h-[2px] bg-green-400"></span>
      </span>
      <h2 class="text-3xl md:text-5xl font-bold mt-4 mb-4 text-white">
        {{ __('pages.testimonials_subtitle') }}
      </h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-20">
      @forelse($testimonials as $testimonial)
      <div class="bg-white/5 border border-white/10 rounded-2xl p-8 relative">
        <div class="flex text-yellow-400 mb-4">
          @for($i = 0; $i < $testimonial->rating; $i++)
          <i class="fas fa-star text-sm"></i>
          @endfor
        </div>
        <p class="text-gray-300 mb-6 italic">"{{ $testimonial->content }}"</p>
        <div class="flex items-center">
          <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-500 rounded-full flex items-center justify-center font-bold text-white">
            {{ substr($testimonial->name, 0, 1) }}
          </div>
          <div class="ml-3">
            <h4 class="text-white font-bold">{{ $testimonial->name }}</h4>
            @if($testimonial->role)
            <p class="text-gray-400 text-sm">{{ $testimonial->role }}</p>
            @endif
          </div>
        </div>
      </div>
      @empty
      <div class="col-span-full text-center text-gray-400">
        {{ __('pages.no_active_testimonials') }}
      </div>
      @endforelse
    </div>

    <div class="max-w-2xl mx-auto bg-white/5 border border-white/10 rounded-3xl p-8 md:p-10 relative overflow-hidden">
      <div class="absolute -top-24 -right-24 w-48 h-48 bg-green-500/20 rounded-full blur-[80px]"></div>

      <div class="relative z-10">
        <h3 class="text-2xl font-bold text-white mb-6 text-center">{{ __('pages.testimonial_form_title') }}</h3>

        @if(session('success'))
        <div class="mb-6 p-4 bg-green-500/20 border border-green-500/50 rounded-xl text-green-300 text-center">
          {{ session('success') }}
        </div>
        @endif

        @if($errors->any())
        <div class="mb-6 p-4 bg-red-500/20 border border-red-500/50 rounded-xl text-red-300 text-center">
          <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
        @endif

        <form action="{{ route('testimonials.store', app()->getLocale()) }}" method="POST" class="space-y-6">
          @csrf
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <label class="block text-gray-400 text-sm mb-2">{{ __('pages.testimonial_form_name') }}</label>
              <input type="text" name="name" required class="w-full bg-black/50 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-green-500 transition-colors">
            </div>
            <div>
              <label class="block text-gray-400 text-sm mb-2">{{ __('pages.testimonial_form_role') }}</label>
              <input type="text" name="role" class="w-full bg-black/50 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-green-500 transition-colors">
            </div>
          </div>
          <div>
            <label class="block text-gray-400 text-sm mb-2">{{ __('pages.testimonial_form_rating') }}</label>
            <div class="flex space-x-4">
              @foreach([5, 4, 3, 2, 1] as $rating)
              <label class="cursor-pointer flex items-center space-x-2">
                <input type="radio" name="rating" value="{{ $rating }}" {{ $loop->first ? 'checked' : '' }} class="form-radio text-green-500 bg-transparent border-white/20 focus:ring-0">
                <span class="text-yellow-400 flex">
                  @for($i = 0; $i < $rating; $i++) <i class="fas fa-star text-xs"></i> @endfor
                </span>
              </label>
              @endforeach
            </div>
          </div>
          <div>
            <label class="block text-gray-400 text-sm mb-2">{{ __('pages.testimonial_form_content') }}</label>
            <textarea name="content" rows="4" required class="w-full bg-black/50 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-green-500 transition-colors"></textarea>
          </div>
          <button type="submit" class="w-full bg-gradient-to-r from-green-600 to-emerald-600 text-white font-bold py-4 rounded-xl hover:scale-[1.02] transition-transform duration-300 shadow-[0_0_20px_rgba(16,185,129,0.3)]">
            {{ __('pages.testimonial_form_submit') }}
          </button>
        </form>
      </div>
    </div>
  </div>
</section>

<section id="stack" class="py-32 bg-gradient-to-b from-black via-gray-900/50 to-black overflow-hidden relative">
  <div class="absolute inset-0">
    <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg%20width%3D%22100%22%20height%3D%22100%22%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%3E%3Cdefs%3E%3Cpattern%20id%3D%22tech-grid%22%20width%3D%22100%22%20height%3D%22100%22%20patternUnits%3D%22userSpaceOnUse%22%3E%3Ccircle%20cx%3D%2250%22%20cy%3D%2250%22%20r%3D%221%22%20fill%3D%22rgba%28255%2C255%2C255%2C0.1%29%22/%3E%3C/pattern%3E%3C/defs%3E%3Crect%20width%3D%22100%25%22%20height%3D%22100%25%22%20fill%3D%22url%28%23tech-grid%29%22/%3E%3C/svg%3E')]"></div>
    <div class="floating-icon top-20 left-10 text-purple-400/20 text-6xl animate-float-slow"><i class="fab fa-python"></i></div>
    <div class="floating-icon top-40 right-20 text-blue-400/20 text-5xl animate-float-slow delay-1000"><i class="fas fa-robot"></i></div>
    <div class="floating-icon bottom-20 left-1/4 text-green-400/20 text-7xl animate-float-slow delay-500"><i class="fas fa-search"></i></div>
    <div class="floating-icon bottom-40 right-1/3 text-yellow-400/20 text-6xl animate-float-slow delay-1500"><i class="fas fa-cloud"></i></div>
    <div class="absolute top-0 left-1/2 w-px h-full bg-gradient-to-b from-transparent via-purple-500/20 to-transparent"></div>
    <div class="absolute top-1/2 left-0 w-full h-px bg-gradient-to-r from-transparent via-blue-500/20 to-transparent"></div>
  </div>
  
  <div class="container mx-auto px-4 relative z-10">
    <div class="text-center mb-20">
      <span class="text-purple-400 tracking-wider uppercase text-sm inline-flex items-center gap-2">
        <span class="w-8 h-[2px] bg-purple-400"></span>
        {{ __('pages.my_arsenal') }}
        <span class="w-8 h-[2px] bg-purple-400"></span>
      </span>
      <h2 class="text-4xl md:text-5xl lg:text-6xl font-bold mt-4 mb-6">
        <span class="bg-gradient-to-r from-purple-400 via-blue-400 to-cyan-400 bg-clip-text text-transparent animate-gradient-x bg-[length:200%_auto]">
          {{ __('pages.stack_h1') }}
        </span>
      </h2>
      <p class="text-xl text-gray-400 max-w-3xl mx-auto">
        {{ __('pages.stack_subtitle') }}
      </p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-20">
      <div class="group relative transform hover:-translate-y-2 transition-all duration-500">
        <div class="absolute inset-0 bg-gradient-to-r from-blue-600/20 to-cyan-600/20 rounded-3xl blur-xl opacity-0 group-hover:opacity-100 group-hover:shadow-[0_0_25px_rgba(6,182,212,0.3)] transition-all duration-500"></div>
        <div class="relative bg-white/5 backdrop-blur-xl border border-white/10 rounded-3xl p-8 hover:bg-white/10 hover:border-white/20 transition-all duration-300 hover:shadow-[0_20px_60px_rgba(0,0,0,0.5)]">
          <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300 shadow-[0_8px_30px_rgba(0,0,0,0.3)]">
            <i class="fas fa-code text-2xl text-white"></i>
          </div>
          <h3 class="text-2xl font-bold text-white mb-4">{{ __('pages.frontend_title') }}</h3>
          <ul class="space-y-3 text-sm text-gray-300">
            <li class="flex items-center space-x-2 hover:text-white transition-colors duration-300">
              <i class="fab fa-html5 text-orange-400"></i>
              <span>{{ __('pages.tech_html_css') }}</span>
            </li>
            <li class="flex items-center space-x-2 hover:text-white transition-colors duration-300">
              <i class="fab fa-js text-yellow-400"></i>
              <span>{{ __('pages.tech_js') }}</span>
            </li>
            <li class="flex items-center space-x-2 hover:text-white transition-colors duration-300">
              <i class="fab fa-vuejs text-green-400"></i>
              <span>{{ __('pages.tech_vue') }}</span>
            </li>
            <li class="flex items-center space-x-2 hover:text-white transition-colors duration-300">
              <i class="fas fa-wind text-cyan-400"></i>
              <span>{{ __('pages.tech_tailwind') }}</span>
            </li>
            <li class="flex items-center space-x-2 hover:text-white transition-colors duration-300">
              <i class="fab fa-bootstrap text-purple-400"></i>
              <span>{{ __('pages.tech_bootstrap') }}</span>
            </li>
          </ul>
        </div>
      </div>
      <div class="group relative transform hover:-translate-y-2 transition-all duration-500">
        <div class="absolute inset-0 bg-gradient-to-r from-purple-600/20 to-pink-600/20 rounded-3xl blur-xl opacity-0 group-hover:opacity-100 group-hover:shadow-[0_0_25px_rgba(219,39,119,0.3)] transition-all duration-500"></div>
        <div class="relative bg-white/5 backdrop-blur-xl border border-white/10 rounded-3xl p-8 hover:bg-white/10 hover:border-white/20 transition-all duration-300 hover:shadow-[0_20px_60px_rgba(0,0,0,0.5)]">
          <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-pink-500 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300 shadow-[0_8px_30px_rgba(0,0,0,0.3)]">
            <i class="fas fa-server text-2xl text-white"></i>
          </div>
          <h3 class="text-2xl font-bold text-white mb-4">{{ __('pages.backend_title') }}</h3>
          <ul class="space-y-3 text-sm text-gray-300">
            <li class="flex items-center space-x-2 hover:text-white transition-colors duration-300">
              <i class="fab fa-php text-purple-400"></i>
              <span>{{ __('pages.tech_php') }}</span>
            </li>
            <li class="flex items-center space-x-2 hover:text-white transition-colors duration-300">
              <i class="fab fa-laravel text-red-400"></i>
              <span>{{ __('pages.tech_laravel') }}</span>
            </li>
            <li class="flex items-center space-x-2 hover:text-white transition-colors duration-300">
              <i class="fab fa-node-js text-green-400"></i>
              <span>{{ __('pages.tech_node') }}</span>
            </li>
            <li class="flex items-center space-x-2 hover:text-white transition-colors duration-300">
              <i class="fas fa-plug text-blue-400"></i>
              <span>{{ __('pages.tech_rest') }}</span>
            </li>
            <li class="flex items-center space-x-2 hover:text-white transition-colors duration-300">
              <i class="fas fa-project-diagram text-pink-400"></i>
              <span>{{ __('pages.tech_graphql') }}</span>
            </li>
          </ul>
        </div>
      </div>
      <div class="group relative transform hover:-translate-y-2 transition-all duration-500">
        <div class="absolute inset-0 bg-gradient-to-r from-green-600/20 to-emerald-600/20 rounded-3xl blur-xl opacity-0 group-hover:opacity-100 group-hover:shadow-[0_0_25px_rgba(16,185,129,0.3)] transition-all duration-500"></div>
        <div class="relative bg-white/5 backdrop-blur-xl border border-white/10 rounded-3xl p-8 hover:bg-white/10 hover:border-white/20 transition-all duration-300 hover:shadow-[0_20px_60px_rgba(0,0,0,0.5)]">
          <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-500 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300 shadow-[0_8px_30px_rgba(0,0,0,0.3)]">
            <i class="fas fa-database text-2xl text-white"></i>
          </div>
          <h3 class="text-2xl font-bold text-white mb-4">{{ __('pages.database_title') }}</h3>
          <ul class="space-y-3 text-sm text-gray-300">
            <li class="flex items-center space-x-2 hover:text-white transition-colors duration-300">
              <i class="fas fa-database text-blue-400"></i>
              <span>{{ __('pages.tech_mysql') }}</span>
            </li>
            <li class="flex items-center space-x-2 hover:text-white transition-colors duration-300">
              <i class="fas fa-database text-blue-300"></i>
              <span>{{ __('pages.tech_postgresql') }}</span>
            </li>
            <li class="flex items-center space-x-2 hover:text-white transition-colors duration-300">
              <i class="fas fa-memory text-red-400"></i>
              <span>{{ __('pages.tech_redis') }}</span>
            </li>
            <li class="flex items-center space-x-2 hover:text-white transition-colors duration-300">
              <i class="fab fa-docker text-blue-400"></i>
              <span>{{ __('pages.tech_docker') }}</span>
            </li>
            <li class="flex items-center space-x-2 hover:text-white transition-colors duration-300">
              <i class="fab fa-git-alt text-orange-400"></i>
              <span>{{ __('pages.tech_git') }}</span>
            </li>
          </ul>
        </div>
      </div>
      <div class="group relative transform hover:-translate-y-2 transition-all duration-500">
        <div class="absolute inset-0 bg-gradient-to-r from-yellow-600/20 to-amber-600/20 rounded-3xl blur-xl opacity-0 group-hover:opacity-100 group-hover:shadow-[0_0_25px_rgba(245,158,11,0.3)] transition-all duration-500"></div>
        <div class="relative bg-white/5 backdrop-blur-xl border border-white/10 rounded-3xl p-8 hover:bg-white/10 hover:border-white/20 transition-all duration-300 hover:shadow-[0_20px_60px_rgba(0,0,0,0.5)]">
          <div class="w-16 h-16 bg-gradient-to-br from-yellow-500 to-amber-500 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300 shadow-[0_8px_30px_rgba(0,0,0,0.3)]">
            <i class="fab fa-python text-2xl text-white"></i>
          </div>
          <h3 class="text-2xl font-bold text-white mb-4">{{ __('pages.python_title') }}</h3>
          <ul class="space-y-3 text-sm text-gray-300">
            <li class="flex items-center space-x-2 hover:text-white transition-colors duration-300">
              <i class="fab fa-python text-yellow-400"></i>
              <span>{{ __('pages.tech_python_web') }}</span>
            </li>
            <li class="flex items-center space-x-2 hover:text-white transition-colors duration-300">
              <i class="fas fa-robot text-cyan-400"></i>
              <span>{{ __('pages.tech_rpa') }}</span>
            </li>
            <li class="flex items-center space-x-2 hover:text-white transition-colors duration-300">
              <i class="fas fa-chart-bar text-green-400"></i>
              <span>{{ __('pages.tech_data_science') }}</span>
            </li>
            <li class="flex items-center space-x-2 hover:text-white transition-colors duration-300">
              <i class="fas fa-microchip text-red-400"></i>
              <span>{{ __('pages.tech_python_api') }}</span>
            </li>
          </ul>
        </div>
      </div>
      <div class="group relative transform hover:-translate-y-2 transition-all duration-500">
        <div class="absolute inset-0 bg-gradient-to-r from-pink-600/20 to-rose-600/20 rounded-3xl blur-xl opacity-0 group-hover:opacity-100 group-hover:shadow-[0_0_25px_rgba(244,114,182,0.3)] transition-all duration-500"></div>
        <div class="relative bg-white/5 backdrop-blur-xl border border-white/10 rounded-3xl p-8 hover:bg-white/10 hover:border-white/20 transition-all duration-300 hover:shadow-[0_20px_60px_rgba(0,0,0,0.5)]">
          <div class="w-16 h-16 bg-gradient-to-br from-pink-500 to-rose-500 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300 shadow-[0_8px_30px_rgba(0,0,0,0.3)]">
            <i class="fas fa-project-diagram text-2xl text-white"></i>
          </div>
          <h3 class="text-2xl font-bold text-white mb-4">{{ __('pages.nocode_title') }}</h3>
          <ul class="space-y-3 text-sm text-gray-300">
            <li class="flex items-center space-x-2 hover:text-white transition-colors duration-300">
              <i class="fas fa-cogs text-purple-400"></i>
              <span>{{ __('pages.tech_n8n_make') }}</span>
            </li>
            <li class="flex items-center space-x-2 hover:text-white transition-colors duration-300">
              <i class="fas fa-bolt text-yellow-400"></i>
              <span>{{ __('pages.tech_zapier') }}</span>
            </li>
            <li class="flex items-center space-x-2 hover:text-white transition-colors duration-300">
              <i class="fas fa-cloud text-blue-400"></i>
              <span>{{ __('pages.tech_octabase') }}</span>
            </li>
            <li class="flex items-center space-x-2 hover:text-white transition-colors duration-300">
              <i class="fas fa-link text-green-400"></i>
              <span>{{ __('pages.tech_webhooks') }}</span>
            </li>
          </ul>
        </div>
      </div>
      <div class="group relative transform hover:-translate-y-2 transition-all duration-500">
        <div class="absolute inset-0 bg-gradient-to-r from-orange-600/20 to-red-600/20 rounded-3xl blur-xl opacity-0 group-hover:opacity-100 group-hover:shadow-[0_0_25px_rgba(239,68,68,0.3)] transition-all duration-500"></div>
        <div class="relative bg-white/5 backdrop-blur-xl border border-white/10 rounded-3xl p-8 hover:bg-white/10 hover:border-white/20 transition-all duration-300 hover:shadow-[0_20px_60px_rgba(0,0,0,0.5)]">
          <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-red-500 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300 shadow-[0_8px_30px_rgba(0,0,0,0.3)]">
            <i class="fas fa-search text-2xl text-white"></i>
          </div>
          <h3 class="text-2xl font-bold text-white mb-4">{{ __('pages.seo_title') }}</h3>
          <ul class="space-y-3 text-sm text-gray-300">
            <li class="flex items-center space-x-2 hover:text-white transition-colors duration-300">
              <i class="fas fa-chart-line text-green-400"></i>
              <span>{{ __('pages.tech_seo') }}</span>
            </li>
            <li class="flex items-center space-x-2 hover:text-white transition-colors duration-300">
              <i class="fab fa-google text-blue-400"></i>
              <span>{{ __('pages.tech_search_console') }}</span>
            </li>
            <li class="flex items-center space-x-2 hover:text-white transition-colors duration-300">
              <i class="fas fa-tachometer-alt text-purple-400"></i>
              <span>{{ __('pages.tech_pagespeed') }}</span>
            </li>
            <li class="flex items-center space-x-2 hover:text-white transition-colors duration-300">
              <i class="fas fa-share-alt text-cyan-400"></i>
              <span>{{ __('pages.tech_schema') }}</span>
            </li>
          </ul>
        </div>
      </div>
      <div class="group relative transform hover:-translate-y-2 transition-all duration-500">
        <div class="absolute inset-0 bg-gradient-to-r from-indigo-600/20 to-purple-600/20 rounded-3xl blur-xl opacity-0 group-hover:opacity-100 group-hover:shadow-[0_0_25px_rgba(129,140,248,0.3)] transition-all duration-500"></div>
        <div class="relative bg-white/5 backdrop-blur-xl border border-white/10 rounded-3xl p-8 hover:bg-white/10 hover:border-white/20 transition-all duration-300 hover:shadow-[0_20px_60px_rgba(0,0,0,0.5)]">
          <div class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300 shadow-[0_8px_30px_rgba(0,0,0,0.3)]">
            <i class="fas fa-pen-fancy text-2xl text-white"></i> </div>
          <h3 class="text-2xl font-bold text-white mb-4">{{ __('pages.copywriting_title') }}</h3>
          <ul class="space-y-3 text-sm text-gray-300">
            <li class="flex items-center space-x-2 hover:text-white transition-colors duration-300">
              <i class="fas fa-bullhorn text-blue-400"></i> <span>{{ __('pages.copywriting_brand_voice') }}</span>
            </li>
            <li class="flex items-center space-x-2 hover:text-white transition-colors duration-300">
              <i class="fas fa-ad text-green-400"></i> <span>{{ __('pages.copywriting_ads') }}</span>
            </li>
            <li class="flex items-center space-x-2 hover:text-white transition-colors duration-300">
              <i class="fas fa-file-alt text-yellow-400"></i> <span>{{ __('pages.copywriting_content') }}</span>
            </li>
            <li class="flex items-center space-x-2 hover:text-white transition-colors duration-300">
              <i class="fas fa-envelope-open-text text-purple-400"></i> <span>{{ __('pages.copywriting_email') }}</span>
            </li>
            <li class="flex items-center space-x-2 hover:text-white transition-colors duration-300">
              <i class="fas fa-user-edit text-pink-400"></i> <span>{{ __('pages.copywriting_storytelling') }}</span>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <div class="max-w-4xl mx-auto">
      <h3 class="text-2xl font-bold text-center text-white mb-12">{{ __('pages.proficiency_title') }}</h3>
      <div class="space-y-6">
        @foreach([
          ['pages.skill_laravel', 95, 'from-red-500 to-pink-500'],
          ['pages.skill_frontend_dev', 90, 'from-blue-500 to-cyan-500'],
          ['pages.skill_database_design', 85, 'from-green-500 to-emerald-500'],
          ['pages.skill_api_dev', 92, 'from-purple-500 to-indigo-500'],
          ['pages.skill_devops', 80, 'from-orange-500 to-yellow-500'],
          ['pages.skill_python_automation', 88, 'from-yellow-500 to-green-500'],
          ['pages.skill_seo_growth', 85, 'from-pink-500 to-purple-500']
        ] as $skill)
        <div class="group">
          <div class="flex justify-between items-center mb-2">
            <span class="text-gray-300 font-medium group-hover:text-white transition-colors duration-300">{{ __($skill[0]) }}</span>
            <span class="text-gray-400 text-sm">{{ $skill[1] }}%</span>
          </div>
          <div class="h-3 bg-white/10 rounded-full overflow-hidden backdrop-blur-sm">
            <div class="h-full bg-gradient-to-r {{ $skill[2] }} rounded-full relative overflow-hidden transition-all duration-1000 ease-out" style="width: 0%" data-width="{{ $skill[1] }}%">
              <div class="absolute inset-0 bg-white/20 animate-shimmer"></div>
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</section>

<style>
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
  0%, 100% {
    background-position: 0% 50%;
  }
  50% {
    background-position: 100% 50%;
  }
}
@keyframes shimmer {
  0% {
    transform: translateX(-100%);
  }
  100% {
    transform: translateX(100%);
  }
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
  from {
    opacity: 0;
    transform: translateY(-20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
@keyframes fade-in-up {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
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
.animate-float-slow {
  animation: float-slow 6s ease-in-out infinite;
}
.animate-spin-slow {
  animation: spin-slow 20s linear infinite;
}
.animate-spin-reverse {
  animation: spin-reverse 25s linear infinite;
}
.animate-gradient-x {
  animation: gradient-x 3s ease infinite;
}
.animate-shimmer {
  animation: shimmer 2s infinite;
}
.animate-blink {
  animation: blink 1s infinite;
}
.animate-text-slide {
  animation: text-slide 40s ease-in-out infinite;
}
.animate-fade-in-down {
  animation: fade-in-down 0.8s ease-out;
}
.animate-fade-in-up {
  animation: fade-in-up 0.8s ease-out;
}
.animate-fade-in {
  animation: fade-in 0.8s ease-out;
}
.animate-float {
  animation: float 3s ease-in-out infinite;
}
/* Delay classes */
.delay-200 { animation-delay: 200ms; }
.delay-400 { animation-delay: 400ms; }
.delay-500 { animation-delay: 500ms; }
.delay-600 { animation-delay: 600ms; }
.delay-700 { animation-delay: 700ms; }
.delay-800 { animation-delay: 800ms; }
.delay-1000 { animation-delay: 1000ms; }
.delay-1500 { animation-delay: 1500ms; }
/* 3D perspective */
.perspective-1000 {
  perspective: 1000px;
}
.rotate-y-12 {
  transform: rotateY(12deg);
}
/* Floating icons */
.floating-icon {
  position: absolute;
  opacity: 0.1;
  animation: float-slow 8s ease-in-out infinite;
}
/* Custom scrollbar */
::-webkit-scrollbar {
  width: 10px;
}
::-webkit-scrollbar-track {
  background: #000;
}
::-webkit-scrollbar-thumb {
  background: linear-gradient(to bottom, #8b5cf6, #3b82f6);
  border-radius: 5px;
}
::-webkit-scrollbar-thumb:hover {
  background: linear-gradient(to bottom, #a78bfa, #60a5fa);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
  // Smooth reveal animations on scroll
  const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -100px 0px'
  };
  const observer = new IntersectionObserver(function(entries) {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('animate-fade-in-up');
        // Animate progress bars when in view
        if (entry.target.id === 'stack') {
          animateProgressBars();
        }
        observer.unobserve(entry.target);
      }
    });
  }, observerOptions);
  // Observe all sections
  document.querySelectorAll('section').forEach(section => {
    observer.observe(section);
  });
  // Animate progress bars
  function animateProgressBars() {
    const progressBars = document.querySelectorAll('[data-width]');
    progressBars.forEach((bar, index) => {
      setTimeout(() => {
        bar.style.width = bar.getAttribute('data-width');
      }, index * 100);
    });
  }
  // Parallax effect on mouse move
  document.addEventListener('mousemove', (e) => {
    const mouseX = e.clientX / window.innerWidth;
    const mouseY = e.clientY / window.innerHeight;
    document.querySelectorAll('.floating-icon').forEach((icon, index) => {
      const speed = (index + 1) * 0.5;
      const x = (mouseX - 0.5) * speed * 50;
      const y = (mouseY - 0.5) * speed * 50;
      icon.style.transform = `translate(${x}px, ${y}px)`;
    });
  });
  // Smooth scroll for anchor links
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
      e.preventDefault();
      const target = document.querySelector(this.getAttribute('href'));
      if (target) {
        target.scrollIntoView({
          behavior: 'smooth',
          block: 'start'
        });
      }
    });
  });
  // Add particle effect
  function createParticle() {
    const particle = document.createElement('div');
    particle.className = 'particle';
    particle.style.cssText = `
      position: absolute;
      width: 2px;
      height: 2px;
      background: rgba(255, 255, 255, 0.5);
      pointer-events: none;
      border-radius: 50%;
      left: ${Math.random() * 100}%;
      top: ${Math.random() * 100}%;
      animation: particle-float ${5 + Math.random() * 10}s linear infinite;
    `;
    const particlesContainer = document.querySelector('.particles');
    if (particlesContainer) {
      particlesContainer.appendChild(particle);
      setTimeout(() => {
        particle.remove();
      }, 15000);
    }
  }
  // Create particles periodically
  setInterval(createParticle, 300);
  // Add hover tilt effect to cards
  const cards = document.querySelectorAll('.group');
  cards.forEach(card => {
    card.addEventListener('mousemove', (e) => {
      const rect = card.getBoundingClientRect();
      const x = e.clientX - rect.left;
      const y = e.clientY - rect.top;
      const centerX = rect.width / 2;
      const centerY = rect.height / 2;
      const rotateX = (y - centerY) / 10;
      const rotateY = (centerX - x) / 10;
      card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) translateZ(10px)`;
    });
    card.addEventListener('mouseleave', () => {
      card.style.transform = 'perspective(1000px) rotateX(0) rotateY(0) translateZ(0)';
    });
  });
});
// Add particle float animation
const style = document.createElement('style');
style.textContent = `
  @keyframes particle-float {
    0% {
      transform: translateY(100vh) rotate(0deg);
      opacity: 0;
    }
    10% {
      opacity: 1;
    }
    90% {
      opacity: 1;
    }
    100% {
      transform: translateY(-100vh) rotate(360deg);
      opacity: 0;
    }
  }
`;
document.head.appendChild(style);
</script>
@endsection
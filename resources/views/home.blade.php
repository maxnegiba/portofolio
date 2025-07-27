@extends('layouts.app')

@section('content')
<!-- Hero Section cu design ultra-modern -->
<section class="hero min-h-screen flex items-center relative overflow-hidden bg-black">
  <!-- Animated Background -->
  <div class="absolute inset-0 z-0">
    <!-- Gradient Orbs -->
    <div class="absolute top-20 left-10 w-72 h-72 bg-purple-600/30 rounded-full blur-[100px] animate-pulse"></div>
    <div class="absolute bottom-20 right-10 w-96 h-96 bg-blue-600/30 rounded-full blur-[120px] animate-pulse delay-700"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-cyan-600/20 rounded-full blur-[150px] animate-pulse delay-1000"></div>
    
    <!-- Animated Grid -->
    <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" xmlns="http://www.w3.org/2000/svg"%3E%3Cdefs%3E%3Cpattern id="grid" width="60" height="60" patternUnits="userSpaceOnUse"%3E%3Cpath d="M 60 0 L 0 0 0 60" fill="none" stroke="rgba(255,255,255,0.03)" stroke-width="1"/%3E%3C/pattern%3E%3C/defs%3E%3Crect width="100%25" height="100%25" fill="url(%23grid)"/%3E%3C/svg%3E')] opacity-50"></div>
    
    <!-- Particles -->
    <div class="particles absolute inset-0"></div>
  </div>
  
  <div class="container relative z-10">
    <div class="max-w-5xl mx-auto">
      <!-- Avatar Section -->
      <div class="flex justify-center mb-10">
        <div class="relative group">
          <!-- Rotating Border -->
          <div class="absolute -inset-4 bg-gradient-to-r from-purple-600 via-blue-600 to-cyan-600 rounded-full opacity-75 blur-lg group-hover:opacity-100 animate-spin-slow"></div>
          
          <!-- Avatar Container -->
          <div class="relative w-40 h-40 md:w-48 md:h-48">
            <div class="absolute inset-0 bg-gradient-to-r from-purple-600 via-blue-600 to-cyan-600 rounded-full animate-spin-slow"></div>
            <div class="absolute inset-1 bg-black rounded-full"></div>
            <img src="{{ asset('img/avatar.jpg') }}" alt="avatar" class="absolute inset-2 w-full h-full object-cover rounded-full border-2 border-black">
            
            <!-- Status Badge -->
            <div class="absolute bottom-2 right-2 flex items-center space-x-1 bg-black/80 backdrop-blur-sm px-3 py-1 rounded-full border border-green-500/50">
              <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
              <span class="text-xs text-green-400 font-medium">Available</span>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Hero Content -->
      <div class="text-center space-y-8">
        <!-- Animated Text -->
        <div class="space-y-4">
          <h1 class="text-4xl md:text-6xl lg:text-7xl font-bold">
            <span class="block text-gray-400 animate-fade-in-down">{{ __('pages.hero_hi') }}</span>
            <span class="block mt-2 relative">
              <span class="bg-gradient-to-r from-purple-400 via-blue-400 to-cyan-400 bg-clip-text text-transparent animate-gradient-x animate-fade-in-up delay-200">
                [Your Name]
              </span>
              <!-- Typing Cursor -->
              <span class="absolute -right-8 top-1/2 -translate-y-1/2 w-1 h-12 bg-cyan-400 animate-blink"></span>
            </span>
          </h1>
          
          <!-- Dynamic Role Text -->
          <div class="h-8 md:h-10 relative overflow-hidden">
            <div class="animate-text-slide">
              <p class="text-xl md:text-2xl text-gray-300 h-8 md:h-10 flex items-center justify-center">Full Stack Developer</p>
              <p class="text-xl md:text-2xl text-gray-300 h-8 md:h-10 flex items-center justify-center">Laravel Expert</p>
              <p class="text-xl md:text-2xl text-gray-300 h-8 md:h-10 flex items-center justify-center">UI/UX Enthusiast</p>
              <p class="text-xl md:text-2xl text-gray-300 h-8 md:h-10 flex items-center justify-center">Problem Solver</p>
            </div>
          </div>
        </div>
        
        <!-- Bio Text -->
        <p class="text-lg md:text-xl text-gray-400 max-w-3xl mx-auto leading-relaxed animate-fade-in delay-400">
          {{ __('pages.hero_subtitle') }}
        </p>
        
        <!-- CTA Buttons -->
        <div class="flex flex-wrap justify-center gap-4 md:gap-6 animate-fade-in-up delay-600">
          <!-- Primary CTA -->
          <a href="{{ route('projects', app()->getLocale()) }}" class="group relative">
            <div class="absolute -inset-1 bg-gradient-to-r from-purple-600 to-blue-600 rounded-full opacity-70 blur group-hover:opacity-100 transition duration-300"></div>
            <button class="relative px-8 py-4 bg-black rounded-full text-white font-medium flex items-center space-x-3 group-hover:scale-105 transition-transform duration-300">
              <span>{{ __('pages.see_work') }}</span>
              <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform duration-300"></i>
            </button>
          </a>
          
          <!-- Secondary CTA -->
          <a href="{{ route('contact', app()->getLocale()) }}" class="group px-8 py-4 rounded-full border-2 border-gray-700 text-gray-300 font-medium flex items-center space-x-3 hover:border-gray-500 hover:text-white hover:bg-white/5 transition-all duration-300">
            <i class="far fa-envelope"></i>
            <span>{{ __('pages.hire_me') }}</span>
          </a>
        </div>
        
        <!-- Social Links -->
        <div class="flex justify-center space-x-6 animate-fade-in delay-800">
          @foreach([
            ['github', 'fab fa-github'],
            ['linkedin', 'fab fa-linkedin'],
            ['twitter', 'fab fa-twitter'],
            ['instagram', 'fab fa-instagram']
          ] as $social)
          <a href="#" class="group relative">
            <div class="absolute -inset-2 bg-gradient-to-r from-purple-600 to-blue-600 rounded-lg opacity-0 blur group-hover:opacity-60 transition duration-300"></div>
            <div class="relative w-12 h-12 bg-white/5 backdrop-blur-sm border border-white/10 rounded-lg flex items-center justify-center group-hover:bg-white/10 group-hover:border-white/20 transition-all duration-300">
              <i class="{{ $social[1] }} text-gray-400 group-hover:text-white transition-colors duration-300"></i>
            </div>
          </a>
          @endforeach
        </div>
      </div>
      
      <!-- Scroll Indicator -->
      <div class="absolute bottom-10 left-1/2 -translate-x-1/2 animate-bounce">
        <a href="#about" class="flex flex-col items-center text-gray-500 hover:text-white transition-colors duration-300 group">
          <span class="text-xs uppercase tracking-wider mb-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">Scroll</span>
          <div class="w-6 h-10 border-2 border-gray-600 rounded-full p-1 group-hover:border-white transition-colors duration-300">
            <div class="w-1 h-2 bg-gray-600 rounded-full mx-auto animate-scroll group-hover:bg-white transition-colors duration-300"></div>
          </div>
        </a>
      </div>
    </div>
  </div>
</section>

<!-- About Section cu design premium -->
<section id="about" class="py-32 relative bg-black overflow-hidden">
  <!-- Background Elements -->
  <div class="absolute inset-0">
    <div class="absolute top-0 left-1/4 w-96 h-96 bg-purple-600/10 rounded-full blur-[100px]"></div>
    <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-blue-600/10 rounded-full blur-[100px]"></div>
  </div>
  
  <div class="container relative z-10">
    <div class="grid lg:grid-cols-2 gap-16 lg:gap-24 items-center">
      <!-- Image Side -->
      <div class="relative order-2 lg:order-1">
        <!-- Main Image Container -->
        <div class="relative group">
          <!-- Decorative Elements -->
          <div class="absolute -top-6 -left-6 w-24 h-24 bg-gradient-to-br from-purple-600 to-blue-600 rounded-3xl opacity-20 blur-xl"></div>
          <div class="absolute -bottom-6 -right-6 w-32 h-32 bg-gradient-to-br from-blue-600 to-cyan-600 rounded-3xl opacity-20 blur-xl"></div>
          
          <!-- Image Frame -->
          <div class="relative rounded-3xl overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-purple-600/20 via-transparent to-blue-600/20 z-10"></div>
            <img src="{{ asset('img/avatar.jpg') }}" alt="About" class="w-full h-auto object-cover transform group-hover:scale-105 transition-transform duration-700">
          </div>
          
          <!-- Floating Card -->
          <div class="absolute -bottom-8 -right-8 bg-black/80 backdrop-blur-xl border border-white/10 rounded-2xl p-6 shadow-2xl">
            <div class="flex items-center space-x-4">
              <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-500 rounded-xl flex items-center justify-center">
                <i class="fas fa-code text-white"></i>
              </div>
              <div>
                <p class="text-2xl font-bold text-white">3+</p>
                <p class="text-sm text-gray-400">Years Experience</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Content Side -->
      <div class="space-y-8 order-1 lg:order-2">
        <!-- Section Title -->
        <div>
          <span class="text-purple-400 font-medium tracking-wider uppercase text-sm">Get to know me</span>
          <h2 class="text-4xl md:text-5xl lg:text-6xl font-bold mt-4">
            <span class="bg-gradient-to-r from-purple-400 via-blue-400 to-cyan-400 bg-clip-text text-transparent">
              {{ __('pages.about_h1') }}
            </span>
          </h2>
        </div>
        
        <!-- Description -->
        <div class="space-y-4 text-gray-300 text-lg leading-relaxed">
          <p>{{ __('pages.about_text') }}</p>
          <p>I specialize in creating robust, scalable applications that not only meet technical requirements but also provide exceptional user experiences.</p>
        </div>
        
        <!-- Skills Grid -->
        <div class="grid grid-cols-2 gap-4">
          @foreach([
            ['Frontend Development', 'fas fa-laptop-code', 'from-blue-500 to-cyan-500'],
            ['Backend Development', 'fas fa-server', 'from-purple-500 to-pink-500'],
            ['Database Design', 'fas fa-database', 'from-green-500 to-emerald-500'],
            ['API Development', 'fas fa-plug', 'from-orange-500 to-red-500']
          ] as $skill)
          <div class="group bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-4 hover:bg-white/10 hover:border-white/20 transition-all duration-300">
            <div class="flex items-center space-x-3">
              <div class="w-10 h-10 bg-gradient-to-br {{ $skill[2] }} rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                <i class="{{ $skill[1] }} text-white text-sm"></i>
              </div>
              <span class="text-gray-300 font-medium">{{ $skill[0] }}</span>
            </div>
          </div>
          @endforeach
        </div>
        
        <!-- CTA -->
        <div class="flex items-center space-x-6 pt-4">
          <a href="{{ route('contact', app()->getLocale()) }}" class="group relative inline-flex items-center space-x-2">
            <div class="absolute -inset-2 bg-gradient-to-r from-purple-600 to-blue-600 rounded-full opacity-0 blur group-hover:opacity-60 transition duration-300"></div>
            <span class="relative px-8 py-3 bg-gradient-to-r from-purple-600 to-blue-600 rounded-full text-white font-medium group-hover:scale-105 transition-transform duration-300">
              Let's Work Together
            </span>
          </a>
          
          <a href="#" class="text-gray-400 hover:text-white transition-colors duration-300 flex items-center space-x-2 group">
            <span>Download CV</span>
            <i class="fas fa-download group-hover:translate-y-1 transition-transform duration-300"></i>
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

<!--  Tech Stack with Automation & Growth  -->
<section id="stack" class="py-32 bg-gradient-to-b from-black via-gray-900/50 to-black overflow-hidden">
  <!--  Background magic (unchanged)  -->
  <div class="absolute inset-0">
    <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg%20width%3D%22100%22%20height%3D%22100%22%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%3E%3Cdefs%3E%3Cpattern%20id%3D%22tech-grid%22%20width%3D%22100%22%20height%3D%22100%22%20patternUnits%3D%22userSpaceOnUse%22%3E%3Ccircle%20cx%3D%2250%22%20cy%3D%2250%22%20r%3D%221%22%20fill%3D%22rgba%28255%2C255%2C255%2C0.1%29%22/%3E%3C/pattern%3E%3C/defs%3E%3Crect%20width%3D%22100%25%22%20height%3D%22100%25%22%20fill%3D%22url%28%23tech-grid%29%22/%3E%3C/svg%3E')]"></div>
    <div class="floating-icon top-20 left-10 text-purple-400/20 text-6xl animate-float-slow"><i class="fab fa-python"></i></div>
    <div class="floating-icon top-40 right-20 text-blue-400/20 text-5xl animate-float-slow delay-1000"><i class="fas fa-robot"></i></div>
    <div class="floating-icon bottom-20 left-1/4 text-green-400/20 text-7xl animate-float-slow delay-500"><i class="fas fa-search"></i></div>
    <div class="floating-icon bottom-40 right-1/3 text-yellow-400/20 text-6xl animate-float-slow delay-1500"><i class="fas fa-cloud"></i></div>
  </div>

  <div class="container relative z-10">
    <!-- Heading -->
    <div class="text-center mb-20">
      <span class="text-purple-400 tracking-wider uppercase text-sm">My Arsenal</span>
      <h2 class="text-4xl md:text-5xl lg:text-6xl font-bold mt-4 mb-6">
        <span class="bg-gradient-to-r from-purple-400 via-blue-400 to-cyan-400 bg-clip-text text-transparent">
          {{ __('pages.stack_h1') }}
        </span>
      </h2>
      <p class="text-xl text-gray-400 max-w-3xl mx-auto">
        From pixel-perfect front-ends to hyper-automated back-ends, SEO & growth stacks
      </p>
    </div>

    <!--  NEW 4-COLUMN GRID  -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-20">

      <!-- 1. Frontend Technologies (original) -->
  <div class="group relative">
    <div class="absolute inset-0 bg-gradient-to-r from-blue-600/20 to-cyan-600/20 rounded-3xl blur-xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
    <div class="relative bg-white/5 backdrop-blur-xl border border-white/10 rounded-3xl p-8 hover:bg-white/10 hover:border-white/20 transition-all">
      <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110">
        <i class="fas fa-code text-2xl text-white"></i>
      </div>
      <h3 class="text-2xl font-bold text-white mb-4">Frontend</h3>
      <ul class="space-y-3 text-sm text-gray-300">
        <li><i class="fab fa-html5 text-orange-400 mr-2"></i>HTML5 & CSS3</li>
        <li><i class="fab fa-js text-yellow-400 mr-2"></i>JavaScript ES6+</li>
        <li><i class="fab fa-vuejs text-green-400 mr-2"></i>Vue.js 3</li>
        <li><i class="fas fa-wind text-cyan-400 mr-2"></i>Tailwind CSS</li>
        <li><i class="fab fa-bootstrap text-purple-400 mr-2"></i>Bootstrap 5</li>
      </ul>
    </div>
  </div>

  <!-- 2. Backend Technologies (original) -->
  <div class="group relative">
    <div class="absolute inset-0 bg-gradient-to-r from-purple-600/20 to-pink-600/20 rounded-3xl blur-xl opacity-0 group-hover:opacity-100"></div>
    <div class="relative bg-white/5 backdrop-blur-xl border border-white/10 rounded-3xl p-8 hover:bg-white/10 hover:border-white/20 transition-all">
      <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-pink-500 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110">
        <i class="fas fa-server text-2xl text-white"></i>
      </div>
      <h3 class="text-2xl font-bold text-white mb-4">Backend</h3>
      <ul class="space-y-3 text-sm text-gray-300">
        <li><i class="fab fa-php text-purple-400 mr-2"></i>PHP 8+</li>
        <li><i class="fab fa-laravel text-red-400 mr-2"></i>Laravel 10</li>
        <li><i class="fab fa-node-js text-green-400 mr-2"></i>Node.js</li>
        <li><i class="fas fa-plug text-blue-400 mr-2"></i>REST APIs</li>
        <li><i class="fas fa-project-diagram text-pink-400 mr-2"></i>GraphQL</li>
      </ul>
    </div>
  </div>

  <!-- 3. Database & Tools (original) -->
  <div class="group relative">
    <div class="absolute inset-0 bg-gradient-to-r from-green-600/20 to-emerald-600/20 rounded-3xl blur-xl opacity-0 group-hover:opacity-100"></div>
    <div class="relative bg-white/5 backdrop-blur-xl border border-white/10 rounded-3xl p-8 hover:bg-white/10 hover:border-white/20 transition-all">
      <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-500 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110">
        <i class="fas fa-database text-2xl text-white"></i>
      </div>
      <h3 class="text-2xl font-bold text-white mb-4">Database & DevOps</h3>
      <ul class="space-y-3 text-sm text-gray-300">
        <li><i class="fas fa-database text-blue-400 mr-2"></i>MySQL</li>
        <li><i class="fas fa-database text-blue-300 mr-2"></i>PostgreSQL</li>
        <li><i class="fas fa-memory text-red-400 mr-2"></i>Redis</li>
        <li><i class="fab fa-docker text-blue-400 mr-2"></i>Docker</li>
        <li><i class="fab fa-git-alt text-orange-400 mr-2"></i>Git & GitHub</li>
      </ul>
    </div>
  </div>

  <!-- 4. Python & RPA (card nou) -->
  <div class="group relative">
    <div class="absolute inset-0 bg-gradient-to-r from-yellow-600/20 to-amber-600/20 rounded-3xl blur-xl opacity-0 group-hover:opacity-100"></div>
    <div class="relative bg-white/5 backdrop-blur-xl border border-white/10 rounded-3xl p-8 hover:bg-white/10 hover:border-white/20 transition-all">
      <div class="w-16 h-16 bg-gradient-to-br from-yellow-500 to-amber-500 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110">
        <i class="fab fa-python text-2xl text-white"></i>
      </div>
      <h3 class="text-2xl font-bold text-white mb-4">Python & RPA</h3>
      <ul class="space-y-3 text-sm text-gray-300">
        <li><i class="fab fa-python text-yellow-400 mr-2"></i>Scrapy / Selenium</li>
        <li><i class="fas fa-robot text-cyan-400 mr-2"></i>PyAutoGUI / RPA</li>
        <li><i class="fas fa-chart-bar text-green-400 mr-2"></i>Pandas / NumPy</li>
        <li><i class="fas fa-microchip text-red-400 mr-2"></i>FastAPI / Django REST</li>
      </ul>
    </div>
  </div>

  <!-- 5. No-Code Orchestration (card nou) -->
  <div class="group relative">
    <div class="absolute inset-0 bg-gradient-to-r from-pink-600/20 to-rose-600/20 rounded-3xl blur-xl opacity-0 group-hover:opacity-100"></div>
    <div class="relative bg-white/5 backdrop-blur-xl border border-white/10 rounded-3xl p-8 hover:bg-white/10 hover:border-white/20 transition-all">
      <div class="w-16 h-16 bg-gradient-to-br from-pink-500 to-rose-500 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110">
        <i class="fas fa-project-diagram text-2xl text-white"></i>
      </div>
      <h3 class="text-2xl font-bold text-white mb-4">No-Code Orchestration</h3>
      <ul class="space-y-3 text-sm text-gray-300">
        <li><i class="fas fa-cogs text-purple-400 mr-2"></i>n8n / Make.com</li>
        <li><i class="fas fa-bolt text-yellow-400 mr-2"></i>Zapier / Integrately</li>
        <li><i class="fas fa-cloud text-blue-400 mr-2"></i>OctaBase / n8n-Cloud</li>
        <li><i class="fas fa-link text-green-400 mr-2"></i>Webhook bridges</li>
      </ul>
    </div>
  </div>

  <!-- 6. SEO & Growth (card nou) -->
  <div class="group relative">
    <div class="absolute inset-0 bg-gradient-to-r from-orange-600/20 to-red-600/20 rounded-3xl blur-xl opacity-0 group-hover:opacity-100"></div>
    <div class="relative bg-white/5 backdrop-blur-xl border border-white/10 rounded-3xl p-8 hover:bg-white/10 hover:border-white/20 transition-all">
      <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-red-500 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110">
        <i class="fas fa-search text-2xl text-white"></i>
      </div>
      <h3 class="text-2xl font-bold text-white mb-4">SEO & Growth</h3>
      <ul class="space-y-3 text-sm text-gray-300">
        <li><i class="fas fa-chart-line text-green-400 mr-2"></i>Technical SEO</li>
        <li><i class="fab fa-google text-blue-400 mr-2"></i>Search Console / GA4</li>
        <li><i class="fas fa-tachometer-alt text-purple-400 mr-2"></i>PageSpeed & Lighthouse</li>
        <li><i class="fas fa-share-alt text-cyan-400 mr-2"></i>Schema & SERP automation</li>
      </ul>
    </div>
  </div>

</div>
<!--  Progress Bars (rămân identice)  -->
<div class="max-w-4xl mx-auto">
  <h3 class="text-2xl font-bold text-center text-white mb-12">Proficiency Levels</h3>
  <div class="space-y-6">
    @foreach([
      ['Laravel Development', 95, 'from-red-500 to-pink-500'],
      ['Frontend Development', 90, 'from-blue-500 to-cyan-500'],
      ['Database Design', 85, 'from-green-500 to-emerald-500'],
      ['API Development', 92, 'from-purple-500 to-indigo-500'],
      ['DevOps', 80, 'from-orange-500 to-yellow-500'],
      ['Python Automation', 88, 'from-yellow-500 to-green-500'],
      ['SEO & Growth', 85, 'from-pink-500 to-purple-500']
    ] as $skill)
    <div class="group">
      <div class="flex justify-between items-center mb-2">
        <span class="text-gray-300 font-medium group-hover:text-white">{{ $skill[0] }}</span>
        <span class="text-gray-400 text-sm">{{ $skill[1] }}%</span>
      </div>
      <div class="h-3 bg-white/10 rounded-full overflow-hidden">
        <div class="h-full bg-gradient-to-r {{ $skill[2] }} rounded-full" style="width: {{ $skill[1] }}%"></div>
      </div>
    </div>
    @endforeach
  </div>
</div>

<!-- Add particles.js or custom particle script -->
<script>
// Add smooth reveal animations on scroll
document.addEventListener('DOMContentLoaded', function() {
  const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -100px 0px'
  };
  
  const observer = new IntersectionObserver(function(entries) {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('animate-fade-in-up');
        observer.unobserve(entry.target);
      }
    });
  }, observerOptions);
  
  // Observe all sections
  document.querySelectorAll('section').forEach(section => {
    observer.observe(section);
  });
});
</script>

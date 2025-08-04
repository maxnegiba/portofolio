<!-- resources/views/partials/footer.blade.php -->
<footer class="relative bg-black border-t border-white/10 overflow-hidden">
  <!-- Background ornaments -->
  <div class="absolute inset-0 pointer-events-none">
    <!-- Floating gradient orbs -->
    <div class="absolute top-0 left-1/4 w-80 h-80 bg-purple-600/20 rounded-full blur-[120px] animate-float-slow"></div>
    <div class="absolute bottom-0 right-1/4 w-64 h-64 bg-blue-600/20 rounded-full blur-[100px] animate-float-slow delay-1000"></div>
    <!-- Grid overlay -->
    <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" xmlns="http://www.w3.org/2000/svg"%3E%3Cdefs%3E%3Cpattern id="footer-grid" width="60" height="60" patternUnits="userSpaceOnUse"%3E%3Cpath d="M 60 0 L 0 0 0 60" fill="none" stroke="rgba(255,255,255,0.03)" stroke-width="1"/%3E%3C/pattern%3E%3C/defs%3E%3Crect width="100%25" height="100%25" fill="url(%23footer-grid)"/%3E%3C/svg%3E')] opacity-50"></div>
  </div>

  <div class="container relative z-10">
    <!-- Main footer grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 py-16">
      
      <!-- 1. Brand column -->
      <div class="flex flex-col space-y-6">
        <a href="{{ route('home', app()->getLocale()) }}" class="flex items-center space-x-3">
          <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-purple-600 via-blue-600 to-cyan-500 p-[2px]">
            <div class="w-full h-full rounded-2xl bg-black flex items-center justify-center">
              <span class="text-white font-bold text-xl bg-gradient-to-r from-purple-400 to-cyan-400 bg-clip-text text-transparent">N</span>
            </div>
          </div>
          <span class="text-2xl font-bold">
            <span class="bg-gradient-to-r from-purple-400 to-cyan-400 bg-clip-text text-transparent">Doctor It</span>
          </span>
        </a>
        <p class="text-gray-400 leading-relaxed max-w-xs">
          {{ __('pages.footer_brand_subtitle') }}
        </p>
        <div class="flex space-x-4 pt-2">
          @foreach([
            ['github', 'fab fa-github', 'https://github.com/yourusername'],
            ['linkedin', 'fab fa-linkedin', 'https://linkedin.com/in/yourusername'],
            ['twitter', 'fab fa-twitter', 'https://twitter.com/yourusername'],
            ['instagram', 'fab fa-instagram', 'https://instagram.com/yourusername']
          ] as $social)
          <a href="{{ $social[2] }}" target="_blank" class="group relative">
            <div class="absolute -inset-2 bg-gradient-to-r from-purple-600 to-blue-600 rounded-lg opacity-0 blur group-hover:opacity-40 transition duration-300"></div>
            <div class="relative w-10 h-10 bg-white/5 backdrop-blur-sm border border-white/10 rounded-lg flex items-center justify-center group-hover:bg-white/10 group-hover:border-white/20 transition-all duration-300">
              <i class="{{ $social[1] }} text-gray-400 group-hover:text-white transition-colors duration-300"></i>
            </div>
          </a>
          @endforeach
        </div>
      </div>

      <!-- 2. Quick Links -->
      <div>
        <h4 class="text-white font-semibold mb-6 text-lg">{{ __('pages.footer_quick_links') }}</h4>
        <ul class="space-y-3">
          <li>
            <a href="{{ route('home', app()->getLocale()) }}#about" 
               class="group flex items-center space-x-2 text-gray-400 hover:text-white transition-colors duration-300">
              <i class="fas fa-chevron-right text-xs opacity-0 group-hover:opacity-100 transition-opacity duration-300"></i>
              <span>{{ __('pages.about_h1') }}</span>
            </a>
          </li>
          <li>
            <a href="{{ route('projects', app()->getLocale()) }}" 
               class="group flex items-center space-x-2 text-gray-400 hover:text-white transition-colors duration-300">
              <i class="fas fa-chevron-right text-xs opacity-0 group-hover:opacity-100 transition-opacity duration-300"></i>
              <span>{{ __('pages.projects_h1') }}</span>
            </a>
          </li>
          <li>
            <a href="{{ route('contact', app()->getLocale()) }}" 
               class="group flex items-center space-x-2 text-gray-400 hover:text-white transition-colors duration-300">
              <i class="fas fa-chevron-right text-xs opacity-0 group-hover:opacity-100 transition-opacity duration-300"></i>
              <span>{{ __('pages.contact_h1') }}</span>
            </a>
          </li>
        </ul>
      </div>

      <!-- 3. Technologies -->
      <div>
        <h4 class="text-white font-semibold mb-6 text-lg">{{ __('pages.footer_technologies') }}</h4>
        <ul class="space-y-3 text-gray-400">
          <li class="flex items-center space-x-2"><i class="fab fa-laravel text-red-500"></i><span>Laravel</span></li>
          <li class="flex items-center space-x-2"><i class="fab fa-vuejs text-green-500"></i><span>Vue.js</span></li>
          <li class="flex items-center space-x-2"><i class="fab fa-python text-yellow-500"></i><span>Python & RPA</span></li>
          <li class="flex items-center space-x-2"><i class="fas fa-robot text-cyan-500"></i><span>No-Code Automation</span></li>
          <li class="flex items-center space-x-2"><i class="fas fa-search text-orange-500"></i><span>SEO & Growth</span></li>
        </ul>
      </div>

      <!-- 4. Contact / CTA -->
      <div>
        <h4 class="text-white font-semibold mb-6 text-lg">{{ __('pages.footer_connect') }}</h4>
        <p class="text-gray-400 mb-4">{{ __('pages.footer_connect_text') }}</p>
        <a href="{{ route('contact', app()->getLocale()) }}" 
           class="group relative inline-flex items-center space-x-2 w-full justify-center mb-4">
          <div class="absolute -inset-1 bg-gradient-to-r from-purple-600 to-blue-600 rounded-xl opacity-70 blur group-hover:opacity-100 transition duration-300"></div>
          <button class="relative px-6 py-3 bg-black rounded-xl text-white font-medium w-full">
            <span class="flex items-center justify-center space-x-2">
              <i class="fas fa-envelope"></i>
              <span>{{ __('pages.footer_get_in_touch') }}</span>
            </span>
          </button>
        </a>
        <p class="text-sm text-gray-500 text-center">
          {{ __('pages.footer_email') }}
        </p>
      </div>
    </div>

    <!-- Divider -->
    <div class="border-t border-white/10"></div>

    <!-- Bottom bar -->
    <div class="flex flex-col md:flex-row justify-between items-center py-6 text-sm text-gray-500">
      <p>&copy; {{ date('Y') }} {{ __('pages.footer_copyright') }}</p>
      <p class="flex items-center space-x-2">
        <span>{{ __('pages.footer_made_with') }}</span>
        <i class="fas fa-heart text-red-500 animate-pulse"></i>
        <span>{{ __('pages.footer_in_bucharest') }}</span>
      </p>
    </div>
  </div>
</footer>

<!-- CSS Animations -->
<style>
@keyframes float-slow {
  0%, 100% { transform: translateY(0px) scale(1); }
  50% { transform: translateY(-20px) scale(1.05); }
}

.animate-float-slow {
  animation: float-slow 8s ease-in-out infinite;
}

.delay-1000 {
  animation-delay: 1s;
}
</style>
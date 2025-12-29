@php
    $localeInfo = [
        'en' => ['icon' => 'fas fa-globe-americas', 'label' => 'EN', 'full_label' => 'English'],
        'ro' => ['icon' => 'fas fa-globe-europe', 'label' => 'RO', 'full_label' => 'Română'],
        'vi' => ['icon' => 'fas fa-globe-asia', 'label' => 'VI', 'full_label' => 'Tiếng Việt'],
    ];

    $currentRouteName = Route::currentRouteName();
    $safeRoutes = ['home', 'projects', 'blog.index', 'contact'];

    // Ensure alternateUrls is defined to avoid undefined variable errors
    // and allow it to be passed into the closure scope.
    $alternateUrls = isset($alternateUrls) ? $alternateUrls : [];

    // Helper to get the correct URL for the target locale
    // Uses $alternateUrls if available (for dynamic pages like blog posts),
    // otherwise falls back to standard routing logic.
    // ADDED: $alternateUrls to the use() clause
    $getSwitchUrl = function($targetLocale) use ($currentRouteName, $safeRoutes, $alternateUrls) {
        // Check if alternateUrls is passed from the controller (e.g. BlogController)
        if (array_key_exists($targetLocale, $alternateUrls)) {
            return $alternateUrls[$targetLocale];
        }

        if (in_array($currentRouteName, $safeRoutes)) {
             // If we are on a page that doesn't depend on content slugs, stay on the page
             return route($currentRouteName, ['locale' => $targetLocale]);
        }

        // Fallback to home for dynamic pages (posts, projects) to avoid 404s due to untranslated slugs
        // if no alternateUrl is provided.
        return route('home', ['locale' => $targetLocale]);
    };
@endphp

<nav class="fixed top-0 left-0 right-0 z-50 py-3 bg-black/80 backdrop-blur-xl border-b border-white/10 transition-all duration-500" id="navbar">
  <div class="container mx-auto px-4 flex justify-between items-center">
    <!-- Logo cu animație și gradient -->
    <a href="{{ route('home', app()->getLocale()) }}" class="group flex items-center space-x-3 relative">
      <!-- Glow effect behind logo -->
      <div class="absolute -inset-2 bg-gradient-to-r from-purple-600/20 to-blue-600/20 rounded-2xl blur-xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
      
      <!-- Container logo imagine - MAI MARE -->
      <div class="relative w-16 h-16 rounded-2xl bg-gradient-to-br from-purple-600 via-blue-600 to-cyan-500 p-[3px] shadow-lg group-hover:shadow-purple-500/25 transition-all duration-300 group-hover:scale-110">
        <div class="w-full h-full rounded-2xl bg-black flex items-center justify-center overflow-hidden">
          <!-- Înlocuiește 'images/logo.png' cu calea reală către logo-ul tău -->
          <img src="{{ asset('img/logo.png') }}" alt="Doctor It Logo" class="w-full h-full object-contain">
        </div>
      </div>
      
      <span class="relative text-3xl font-bold"> <!-- Text mai mare -->
        <span class="bg-gradient-to-r from-purple-400 via-blue-400 to-cyan-400 bg-clip-text text-transparent group-hover:from-purple-300 group-hover:to-cyan-300 transition-all duration-300">
          Doctor It
        </span>
        <!-- Underline animation -->
        <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-gradient-to-r from-purple-400 to-cyan-400 group-hover:w-full transition-all duration-300"></span>
      </span>
    </a>

    <!-- Desktop Navigation -->
    <div class="hidden md:flex items-center space-x-2 lg:space-x-6">
      <!-- Nav Links with modern hover effects -->
      <a href="{{ route('home', app()->getLocale()) }}#about" class="nav-link group relative px-4 py-2 overflow-hidden rounded-xl transition-all duration-300">
        <span class="relative z-10 text-gray-300 group-hover:text-white transition-colors duration-300 font-medium">
          {{ __('pages.about_h1') }}
        </span>
        <!-- Gradient hover background -->
        <div class="absolute inset-0 bg-gradient-to-r from-purple-600/10 to-blue-600/10 translate-y-full group-hover:translate-y-0 transition-transform duration-300"></div>
        <!-- Bottom line indicator -->
        <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-0 h-0.5 bg-gradient-to-r from-purple-400 to-blue-400 group-hover:w-3/4 transition-all duration-300"></div>
      </a>
      <a href="{{ route('projects', app()->getLocale()) }}" class="nav-link group relative px-4 py-2 overflow-hidden rounded-xl transition-all duration-300">
        <span class="relative z-10 text-gray-300 group-hover:text-white transition-colors duration-300 font-medium">
          {{ __('pages.projects_h1') }}
        </span>
        <div class="absolute inset-0 bg-gradient-to-r from-purple-600/10 to-blue-600/10 translate-y-full group-hover:translate-y-0 transition-transform duration-300"></div>
        <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-0 h-0.5 bg-gradient-to-r from-purple-400 to-blue-400 group-hover:w-3/4 transition-all duration-300"></div>
      </a>
      <!-- Link către blog -->
      <a href="{{ route('blog.index', ['locale' => app()->getLocale()]) }}" class="nav-link group relative px-4 py-2 overflow-hidden rounded-xl transition-all duration-300">
        <span class="relative z-10 text-gray-300 group-hover:text-white transition-colors duration-300 font-medium">
          Blog
        </span>
        <div class="absolute inset-0 bg-gradient-to-r from-purple-600/10 to-blue-600/10 translate-y-full group-hover:translate-y-0 transition-transform duration-300"></div>
        <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-0 h-0.5 bg-gradient-to-r from-purple-400 to-blue-400 group-hover:w-3/4 transition-all duration-300"></div>
      </a>
      <a href="{{ route('contact', app()->getLocale()) }}" class="nav-link group relative px-4 py-2 overflow-hidden rounded-xl transition-all duration-300">
        <span class="relative z-10 text-gray-300 group-hover:text-white transition-colors duration-300 font-medium">
          {{ __('pages.contact_h1') }}
        </span>
        <div class="absolute inset-0 bg-gradient-to-r from-purple-600/10 to-blue-600/10 translate-y-full group-hover:translate-y-0 transition-transform duration-300"></div>
        <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-0 h-0.5 bg-gradient-to-r from-purple-400 to-blue-400 group-hover:w-3/4 transition-all duration-300"></div>
      </a>

      <!-- Separator -->
      <div class="w-px h-6 bg-gradient-to-b from-transparent via-gray-600 to-transparent"></div>

      <!-- Language Selector cu design modern -->
      <div class="relative group language-selector-group">
        <button class="lang-toggle flex items-center space-x-2 px-4 py-2 rounded-xl bg-white/5 border border-white/10 text-gray-300 hover:text-white hover:bg-white/10 hover:border-white/20 transition-all duration-300">
          <i class="fas fa-language text-sm"></i>
          <span class="font-medium lang-display">{{ strtoupper(app()->getLocale()) }}</span>
          <i class="fas fa-chevron-down text-xs transition-transform duration-300 group-hover:rotate-180"></i>
        </button>
        <!-- Dropdown cu animație smooth -->
        <div class="lang-dropdown absolute top-full right-0 mt-2 w-40 bg-black/90 backdrop-blur-xl rounded-xl shadow-2xl shadow-black/50 border border-white/10 py-1 opacity-0 invisible scale-95 transform origin-top-right transition-all duration-300 group-hover:opacity-100 group-hover:visible group-hover:scale-100">
            @foreach(['en', 'ro', 'vi'] as $locale)
                @php
                    $info = $localeInfo[$locale] ?? ['icon' => 'fas fa-globe', 'label' => strtoupper($locale)];
                    $isActive = app()->getLocale() === $locale;
                @endphp
                <a href="{{ $getSwitchUrl($locale) }}" 
                   data-locale="{{ $locale }}"
                   class="lang-option flex items-center space-x-3 px-4 py-2.5 hover:bg-white/10 transition-all duration-200 {{ $isActive ? 'text-white bg-white/5' : 'text-gray-400' }}">
                    <i class="{{ $info['icon'] }} text-lg w-6 text-center"></i>
                    <span class="font-medium">{{ $info['label'] }}</span>
                    @if($isActive)
                        <i class="fas fa-check text-xs ml-auto text-purple-400 lang-check"></i>
                    @endif
                </a>
            @endforeach
        </div>
      </div>

      <!-- CTA Button (opțional) -->
      <a href="{{ route('contact', app()->getLocale()) }}" class="ml-4 px-6 py-2.5 rounded-xl bg-gradient-to-r from-purple-600 to-blue-600 text-white font-medium shadow-lg shadow-purple-500/25 hover:shadow-purple-500/40 hover:scale-105 transition-all duration-300">
        Hire Me
      </a>
    </div>

    <!-- Mobile Menu Button cu animație -->
    <button class="md:hidden relative w-10 h-10 rounded-xl bg-white/5 border border-white/10 text-gray-300 hover:text-white hover:bg-white/10 transition-all duration-300 group" id="mobile-menu-btn">
      <span class="sr-only">Toggle menu</span>
      <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-5 h-4 flex flex-col justify-between">
        <span class="block h-0.5 bg-current transform transition-all duration-300 origin-left" id="line1"></span>
        <span class="block h-0.5 bg-current transition-all duration-300" id="line2"></span>
        <span class="block h-0.5 bg-current transform transition-all duration-300 origin-left" id="line3"></span>
      </div>
    </button>
  </div>

  <!-- Mobile Menu cu design modern -->
  <div class="md:hidden absolute top-full left-0 right-0 bg-black/95 backdrop-blur-xl border-b border-white/10 opacity-0 invisible transform -translate-y-4 transition-all duration-300" id="mobile-menu">
    <div class="container mx-auto px-4 py-6 space-y-2">
      <a href="{{ route('home', app()->getLocale()) }}#about" class="mobile-link flex items-center space-x-3 py-3 px-4 rounded-xl text-gray-300 hover:text-white hover:bg-white/5 transition-all duration-300 group">
        <div class="w-1 h-6 bg-gradient-to-b from-purple-400 to-blue-400 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
        <span class="font-medium">{{ __('pages.about_h1') }}</span>
      </a>
      <a href="{{ route('projects', app()->getLocale()) }}" class="mobile-link flex items-center space-x-3 py-3 px-4 rounded-xl text-gray-300 hover:text-white hover:bg-white/5 transition-all duration-300 group">
        <div class="w-1 h-6 bg-gradient-to-b from-purple-400 to-blue-400 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
        <span class="font-medium">{{ __('pages.projects_h1') }}</span>
      </a>
      <!-- Link către blog în meniul mobil -->
      <a href="{{ route('blog.index', ['locale' => app()->getLocale()]) }}" class="mobile-link flex items-center space-x-3 py-3 px-4 rounded-xl text-gray-300 hover:text-white hover:bg-white/5 transition-all duration-300 group">
        <div class="w-1 h-6 bg-gradient-to-b from-purple-400 to-blue-400 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
        <span class="font-medium">Blog</span>
      </a>
      <a href="{{ route('contact', app()->getLocale()) }}" class="mobile-link flex items-center space-x-3 py-3 px-4 rounded-xl text-gray-300 hover:text-white hover:bg-white/5 transition-all duration-300 group">
        <div class="w-1 h-6 bg-gradient-to-b from-purple-400 to-blue-400 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
        <span class="font-medium">{{ __('pages.contact_h1') }}</span>
      </a>

      <!-- Language selector pentru mobile -->
      <div class="pt-4 mt-4 border-t border-white/10">
        <p class="text-xs text-gray-500 uppercase tracking-wider mb-3 px-4">Language</p>
        <div class="grid grid-cols-3 gap-2">
            @foreach(['en', 'ro', 'vi'] as $locale)
                @php
                    $info = $localeInfo[$locale] ?? ['icon' => 'fas fa-globe', 'label' => strtoupper($locale)];
                    $isActive = app()->getLocale() === $locale;
                @endphp
                <a href="{{ $getSwitchUrl($locale) }}" 
                   data-locale="{{ $locale }}"
                   class="lang-option-mobile flex items-center justify-center space-x-2 py-3 rounded-xl bg-white/5 border {{ $isActive ? 'border-purple-500/50 text-white bg-purple-500/10' : 'border-white/10 text-gray-400' }} transition-all duration-300">
                    <i class="{{ $info['icon'] }}"></i>
                    <span class="font-medium">{{ $info['label'] }}</span>
                </a>
            @endforeach
        </div>
      </div>

      <!-- Mobile CTA -->
      <div class="pt-4">
        <a href="{{ route('contact', app()->getLocale()) }}" class="block w-full py-3 rounded-xl bg-gradient-to-r from-purple-600 to-blue-600 text-white text-center font-medium shadow-lg shadow-purple-500/25">
          Hire Me
        </a>
      </div>
    </div>
  </div>
</nav>

<!-- Script complet pentru funcționalitate -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    const navbar = document.getElementById('navbar');
    let isMenuOpen = false;

    // Verificare suplimentară pentru a preveni erorile dacă elementele nu sunt găsite
    if (!mobileMenuBtn || !mobileMenu || !navbar) {
        console.error("Unul sau mai multe elemente esențiale ale navbar-ului nu au fost găsite.");
        return; // Oprește execuția scriptului dacă elementele lipsesc
    }

    // Mobile menu toggle cu animație hamburger
    mobileMenuBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        isMenuOpen = !isMenuOpen;
        if (isMenuOpen) {
            mobileMenu.classList.remove('opacity-0', 'invisible', '-translate-y-4');
            mobileMenu.classList.add('opacity-100', 'visible', 'translate-y-0');
            // Animație hamburger to X
            const line1 = document.getElementById('line1');
            const line2 = document.getElementById('line2');
            const line3 = document.getElementById('line3');
            if (line1 && line2 && line3) {
                line1.classList.add('rotate-45', 'translate-y-[7px]', 'w-full');
                line2.classList.add('opacity-0');
                line3.classList.add('-rotate-45', '-translate-y-[7px]', 'w-full');
            }
        } else {
            mobileMenu.classList.add('opacity-0', 'invisible', '-translate-y-4');
            mobileMenu.classList.remove('opacity-100', 'visible', 'translate-y-0');
            // Revert animation
            const line1 = document.getElementById('line1');
            const line2 = document.getElementById('line2');
            const line3 = document.getElementById('line3');
            if (line1 && line2 && line3) {
                line1.classList.remove('rotate-45', 'translate-y-[7px]', 'w-full');
                line2.classList.remove('opacity-0');
                line3.classList.remove('-rotate-45', '-translate-y-[7px]', 'w-full');
            }
        }
    });

    // Close mobile menu when clicking links
    document.querySelectorAll('.mobile-link').forEach(link => {
        link.addEventListener('click', () => {
            isMenuOpen = false;
            mobileMenu.classList.add('opacity-0', 'invisible', '-translate-y-4');
            mobileMenu.classList.remove('opacity-100', 'visible', 'translate-y-0');
            // Revert animation for hamburger icon
            const line1 = document.getElementById('line1');
            const line2 = document.getElementById('line2');
            const line3 = document.getElementById('line3');
            if (line1 && line2 && line3) {
                 line1.classList.remove('rotate-45', 'translate-y-[7px]', 'w-full');
                line2.classList.remove('opacity-0');
                line3.classList.remove('-rotate-45', '-translate-y-[7px]', 'w-full');
            }
        });
    });

    // Close mobile menu when clicking outside
    document.addEventListener('click', (e) => {
        if (!mobileMenu.contains(e.target) && !mobileMenuBtn.contains(e.target) && isMenuOpen) {
            isMenuOpen = false;
            mobileMenu.classList.add('opacity-0', 'invisible', '-translate-y-4');
            mobileMenu.classList.remove('opacity-100', 'visible', 'translate-y-0');
            // Revert animation for hamburger icon
            const line1 = document.getElementById('line1');
            const line2 = document.getElementById('line2');
            const line3 = document.getElementById('line3');
            if (line1 && line2 && line3) {
                 line1.classList.remove('rotate-45', 'translate-y-[7px]', 'w-full');
                line2.classList.remove('opacity-0');
                line3.classList.remove('-rotate-45', '-translate-y-[7px]', 'w-full');
            }
        }
    });

    // Language dropdown functionality
    const langSelectorGroup = document.querySelector('.language-selector-group');
    if (langSelectorGroup) {
        const langToggle = langSelectorGroup.querySelector('.lang-toggle');
        const langDropdown = langSelectorGroup.querySelector('.lang-dropdown');
        const langDisplay = langSelectorGroup.querySelector('.lang-display');
        const langOptions = document.querySelectorAll('.lang-option');
        
        // Toggle dropdown
        langToggle.addEventListener('click', (e) => {
            e.stopPropagation();
            const isOpen = langDropdown.classList.contains('opacity-100');
            if (isOpen) {
                langDropdown.classList.remove('opacity-100', 'visible', 'scale-100');
                langDropdown.classList.add('opacity-0', 'invisible', 'scale-95');
            } else {
                langDropdown.classList.add('opacity-100', 'visible', 'scale-100');
                langDropdown.classList.remove('opacity-0', 'invisible', 'scale-95');
            }
        });
        
        // Handle language selection
        langOptions.forEach(option => {
            option.addEventListener('click', (e) => {
                const locale = option.dataset.locale;
                // Update display immediately (optimistic update)
                langDisplay.textContent = locale.toUpperCase();
                // Update active state
                langOptions.forEach(opt => {
                    opt.classList.remove('text-white', 'bg-white/5');
                    opt.classList.add('text-gray-400');
                    const checkIcon = opt.querySelector('.lang-check');
                    if (checkIcon) checkIcon.remove();
                });
                option.classList.add('text-white', 'bg-white/5');
                const checkIcon = document.createElement('i');
                checkIcon.className = 'fas fa-check text-xs ml-auto text-purple-400 lang-check';
                option.appendChild(checkIcon);
                // Close dropdown
                langDropdown.classList.remove('opacity-100', 'visible', 'scale-100');
                langDropdown.classList.add('opacity-0', 'invisible', 'scale-95');
            });
        });
    }

    // Close dropdowns when clicking outside
    document.addEventListener('click', (e) => {
        const langDropdown = document.querySelector('.lang-dropdown');
        const langSelectorGroup = document.querySelector('.language-selector-group');
        if (langDropdown && langSelectorGroup && !langSelectorGroup.contains(e.target)) {
            langDropdown.classList.remove('opacity-100', 'visible', 'scale-100');
            langDropdown.classList.add('opacity-0', 'invisible', 'scale-95');
        }
    });

    // Navbar scroll effect
    let lastScroll = 0;
    window.addEventListener('scroll', () => {
        const currentScroll = window.pageYOffset;
        if (currentScroll > 100) {
            navbar.classList.add('py-2', 'bg-black/90');
            navbar.classList.remove('py-3', 'bg-black/80');
        } else {
            navbar.classList.add('py-3', 'bg-black/80');
            navbar.classList.remove('py-2', 'bg-black/90');
        }
        lastScroll = currentScroll;
    });
});
</script>

<nav class="fixed top-0 left-0 right-0 z-50 py-3 bg-black/80 backdrop-blur-xl border-b border-white/10 transition-all duration-500" id="navbar">
  <div class="container mx-auto px-4 flex justify-between items-center">
    <!-- Logo cu animație și gradient -->
    <a href="{{ route('home', app()->getLocale()) }}" class="group flex items-center space-x-3 relative">
      <!-- Glow effect behind logo -->
      <div class="absolute -inset-2 bg-gradient-to-r from-purple-600/20 to-blue-600/20 rounded-2xl blur-xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
      
      <div class="relative w-12 h-12 rounded-2xl bg-gradient-to-br from-purple-600 via-blue-600 to-cyan-500 p-[2px] shadow-lg group-hover:shadow-purple-500/25 transition-all duration-300 group-hover:scale-110">
        <div class="w-full h-full rounded-2xl bg-black flex items-center justify-center">
          <span class="text-white font-bold text-xl bg-gradient-to-r from-purple-400 to-cyan-400 bg-clip-text text-transparent">N</span>
        </div>
      </div>
      
      <span class="relative text-2xl font-bold">
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
      <a href="#about" class="nav-link group relative px-4 py-2 overflow-hidden rounded-xl transition-all duration-300">
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
      <div class="relative group">
        <button class="flex items-center space-x-2 px-4 py-2 rounded-xl bg-white/5 border border-white/10 text-gray-300 hover:text-white hover:bg-white/10 hover:border-white/20 transition-all duration-300 group">
          <i class="fas fa-globe text-sm"></i>
          <span class="font-medium">{{ strtoupper(app()->getLocale()) }}</span>
          <i class="fas fa-chevron-down text-xs transition-transform duration-300 group-hover:rotate-180"></i>
        </button>
        
        <!-- Dropdown cu animație smooth -->
        <div class="absolute top-full right-0 mt-2 w-32 bg-black/90 backdrop-blur-xl rounded-xl shadow-2xl shadow-black/50 border border-white/10 py-1 opacity-0 invisible scale-95 transform origin-top-right transition-all duration-300 group-hover:opacity-100 group-hover:visible group-hover:scale-100">
          <a href="{{ route('home', 'en') }}" class="flex items-center space-x-3 px-4 py-2.5 hover:bg-white/10 transition-all duration-200 {{ app()->getLocale() === 'en' ? 'text-white bg-white/5' : 'text-gray-400' }}">
            <span class="text-lg">🇬🇧</span>
            <span class="font-medium">English</span>
          </a>
          <a href="{{ route('home', 'ro') }}" class="flex items-center space-x-3 px-4 py-2.5 hover:bg-white/10 transition-all duration-200 {{ app()->getLocale() === 'ro' ? 'text-white bg-white/5' : 'text-gray-400' }}">
            <span class="text-lg">🇷🇴</span>
            <span class="font-medium">Română</span>
          </a>
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
      <a href="#about" class="mobile-link flex items-center space-x-3 py-3 px-4 rounded-xl text-gray-300 hover:text-white hover:bg-white/5 transition-all duration-300 group">
        <div class="w-1 h-6 bg-gradient-to-b from-purple-400 to-blue-400 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
        <span class="font-medium">{{ __('pages.about_h1') }}</span>
      </a>
      
      <a href="{{ route('projects', app()->getLocale()) }}" class="mobile-link flex items-center space-x-3 py-3 px-4 rounded-xl text-gray-300 hover:text-white hover:bg-white/5 transition-all duration-300 group">
        <div class="w-1 h-6 bg-gradient-to-b from-purple-400 to-blue-400 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
        <span class="font-medium">{{ __('pages.projects_h1') }}</span>
      </a>
      
      <a href="{{ route('contact', app()->getLocale()) }}" class="mobile-link flex items-center space-x-3 py-3 px-4 rounded-xl text-gray-300 hover:text-white hover:bg-white/5 transition-all duration-300 group">
        <div class="w-1 h-6 bg-gradient-to-b from-purple-400 to-blue-400 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
        <span class="font-medium">{{ __('pages.contact_h1') }}</span>
      </a>
      
      <!-- Language selector pentru mobile -->
      <div class="pt-4 mt-4 border-t border-white/10">
        <p class="text-xs text-gray-500 uppercase tracking-wider mb-3 px-4">Language</p>
        <div class="grid grid-cols-2 gap-2">
          <a href="{{ route('home', 'en') }}" class="flex items-center justify-center space-x-2 py-3 rounded-xl bg-white/5 border {{ app()->getLocale() === 'en' ? 'border-purple-500/50 text-white bg-purple-500/10' : 'border-white/10 text-gray-400' }} transition-all duration-300">
            <span>🇬🇧</span>
            <span class="font-medium">EN</span>
          </a>
          <a href="{{ route('home', 'ro') }}" class="flex items-center justify-center space-x-2 py-3 rounded-xl bg-white/5 border {{ app()->getLocale() === 'ro' ? 'border-purple-500/50 text-white bg-purple-500/10' : 'border-white/10 text-gray-400' }} transition-all duration-300">
            <span>🇷🇴</span>
            <span class="font-medium">RO</span>
          </a>
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
    
    // Mobile menu toggle cu animație hamburger
    mobileMenuBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        isMenuOpen = !isMenuOpen;
        
        if (isMenuOpen) {
            mobileMenu.classList.remove('opacity-0', 'invisible', '-translate-y-4');
            mobileMenu.classList.add('opacity-100', 'visible', 'translate-y-0');
            
            // Animație hamburger to X
            document.getElementById('line1').classList.add('rotate-45', 'translate-y-[7px]', 'w-full');
            document.getElementById('line2').classList.add('opacity-0');
            document.getElementById('line3').classList.add('-rotate-45', '-translate-y-[7px]', 'w-full');
        } else {
            mobileMenu.classList.add('opacity-0', 'invisible', '-translate-y-4');
            mobileMenu.classList.remove('opacity-100', 'visible', 'translate-y-0');
            
            // Revert animation
            document.getElementById('line1').classList.remove('rotate-45', 'translate-y-[7px]', 'w-full');
            document.getElementById('line2').classList.remove('opacity-0');
            document.getElementById('line3').classList.remove('-rotate-45', '-translate-y-[7px]', 'w-full');
        }
    });
    
    // Close mobile menu when clicking links
    document.querySelectorAll('.mobile-link').forEach(link => {
        link.addEventListener('click', () => {
            isMenuOpen = false;
            mobileMenu.classList.add('opacity-0', 'invisible', '-translate-y-4');
            mobileMenu.classList.remove('opacity-100', 'visible', 'translate-y-0');
            
            document.getElementById('line1').classList.remove('rotate-45', 'translate-y-[7px]', 'w-full');
            document.getElementById('line2').classList.remove('opacity-0');
            document.getElementById('line3').classList.remove('-rotate-45', '-translate-y-[7px]', 'w-full');
        });
    });
    
    // Close mobile menu when clicking outside
    document.addEventListener('click', (e) => {
        if (!mobileMenu.contains(e.target) && !mobileMenuBtn.contains(e.target) && isMenuOpen) {
            isMenuOpen = false;
            mobileMenu.classList.add('opacity-0', 'invisible', '-translate-y-4');
            mobileMenu.classList.remove('opacity-100', 'visible', 'translate-y-0');
            
            document.getElementById('line1').classList.remove('rotate-45', 'translate-y-[7px]', 'w-full');
            document.getElementById('line2').classList.remove('opacity-0');
            document.getElementById('line3').classList.remove('-rotate-45', '-translate-y-[7px]', 'w-full');
        }
    });
    
    // Language dropdown functionality
    document.querySelectorAll('.group').forEach(group => {
        const button = group.querySelector('button');
        const dropdown = group.querySelector('.absolute');
        
        if (button && dropdown) {
            button.addEventListener('click', (e) => {
                e.stopPropagation();
                const isOpen = dropdown.classList.contains('opacity-100');
                
                // Close all other dropdowns
                document.querySelectorAll('.absolute.opacity-100').forEach(openDropdown => {
                    if (openDropdown !== dropdown) {
                        openDropdown.classList.remove('opacity-100', 'visible', 'scale-100');
                        openDropdown.classList.add('opacity-0', 'invisible', 'scale-95');
                    }
                });
                
                // Toggle current dropdown
                if (isOpen) {
                    dropdown.classList.remove('opacity-100', 'visible', 'scale-100');
                    dropdown.classList.add('opacity-0', 'invisible', 'scale-95');
                } else {
                    dropdown.classList.add('opacity-100', 'visible', 'scale-100');
                    dropdown.classList.remove('opacity-0', 'invisible', 'scale-95');
                }
            });
        }
    });
    
    // Close dropdowns when clicking outside
    document.addEventListener('click', (e) => {
        if (!e.target.closest('.group')) {
            document.querySelectorAll('.absolute.opacity-100').forEach(dropdown => {
                dropdown.classList.remove('opacity-100', 'visible', 'scale-100');
                dropdown.classList.add('opacity-0', 'invisible', 'scale-95');
            });
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
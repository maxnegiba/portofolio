@extends('layouts.app')

@section('content')
<!-- Contact Section cu design modern și animații -->
<section id="contact" class="py-32 relative bg-black overflow-hidden min-h-screen flex items-center">
  <!-- Background Effects -->
  <div class="absolute inset-0 z-0">
    <!-- Gradient Orbs -->
    <div class="absolute top-20 left-1/4 w-96 h-96 bg-purple-600/20 rounded-full blur-[120px] animate-pulse-slow"></div>
    <div class="absolute bottom-20 right-1/4 w-80 h-80 bg-blue-600/20 rounded-full blur-[100px] animate-pulse-slow delay-1000"></div>
    
    <!-- Subtle Pattern -->
    <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="100" height="100" xmlns="http://www.w3.org/2000/svg"%3E%3Cdefs%3E%3Cpattern id="dot" width="100" height="100" patternUnits="userSpaceOnUse"%3E%3Ccircle cx="50" cy="50" r="1" fill="rgba(255,255,255,0.05)"/%3E%3C/pattern%3E%3C/defs%3E%3Crect width="100%25" height="100%25" fill="url(%23dot)"/%3E%3C/svg%3E')] opacity-100"></div>
  </div>
  
  <div class="container relative z-10">
    <div class="grid lg:grid-cols-2 gap-16 items-center">
      <!-- Contact Info Side -->
      <div class="space-y-8 animate-fade-in-left">
        <!-- Header -->
        <div>
          <span class="text-purple-400 font-medium tracking-wider uppercase text-sm block mb-4">{{ __('pages.contact_h1') }}</span>
          <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold">
            <span class="bg-gradient-to-r from-purple-400 via-blue-400 to-cyan-400 bg-clip-text text-transparent animate-gradient-x">
              {{ __('pages.contact_h1') }}
            </span>
          </h1>
          <p class="text-xl text-gray-400 mt-6">
            {{ __('pages.contact_subtitle') }}
          </p>
        </div>
        
                <!-- Contact Details -->
        <div class="space-y-6">
          <div class="group flex items-center space-x-4">
            <div class="w-12 h-12 bg-gradient-to-br from-purple-600 to-blue-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
              <i class="fas fa-envelope text-white"></i>
            </div>
            <div>
              <span class="text-gray-400 text-sm">{{ __('pages.contact_email_label') }}</span>
              <!-- Link către clientul de email -->
              <a href="mailto:{{ __('pages.contact_email') }}" class="text-white font-medium hover:text-purple-400 transition-colors duration-300">
                 {{ __('pages.contact_email') }}
              </a>
            </div>
          </div>
          <div class="group flex items-center space-x-4">
            <div class="w-12 h-12 bg-gradient-to-br from-blue-600 to-cyan-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
              <i class="fas fa-phone-alt text-white"></i>
            </div>
            <div>
              <span class="text-gray-400 text-sm">{{ __('pages.contact_phone_label') }}</span>
              <!-- Link pentru apel telefonic -->
              <a href="tel:{{ __('pages.contact_phone') }}" class="text-white font-medium hover:text-cyan-400 transition-colors duration-300">
                {{ __('pages.contact_phone') }}
              </a>
            </div>
          </div>
          <div class="group flex items-center space-x-4">
            <div class="w-12 h-12 bg-gradient-to-br from-cyan-600 to-purple-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
              <i class="fas fa-map-marker-alt text-white"></i>
            </div>
            <div>
              <span class="text-gray-400 text-sm">{{ __('pages.contact_location_label') }}</span>
              <p class="text-white font-medium">{{ __('pages.contact_location') }}</p>
            </div>
          </div>
        </div>
        
        <!-- Social Links -->
        <div>
          <p class="text-gray-400 text-sm mb-3">{{ __('pages.contact_social_title') }}</p>
          <div class="flex space-x-4">
            @foreach([
              ['github', 'fab fa-github', 'https://github.com/yourusername'],
              ['linkedin', 'fab fa-linkedin', 'https://linkedin.com/in/yourusername'],
              ['twitter', 'fab fa-twitter', 'https://twitter.com/yourusername'],
              ['instagram', 'fab fa-instagram', 'https://instagram.com/yourusername']
            ] as $social)
            <a href="{{ $social[2] }}" target="_blank" class="group relative" aria-label="{{ $social[0] }}">
              <div class="absolute -inset-1 bg-gradient-to-r from-purple-600 to-blue-600 rounded-lg opacity-0 blur group-hover:opacity-60 transition duration-300"></div>
              <div class="relative w-12 h-12 bg-white/5 backdrop-blur-sm border border-white/10 rounded-lg flex items-center justify-center group-hover:bg-white/10 group-hover:border-white/20 transition-all duration-300">
                <i class="{{ $social[1] }} text-gray-400 group-hover:text-white transition-colors duration-300"></i>
              </div>
            </a>
            @endforeach
          </div>
        </div>
      </div>
      
      <!-- Contact Form Side -->
      <div class="relative animate-fade-in-right delay-200">
        <!-- Form Card -->
        <div class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-3xl p-8 shadow-lg shadow-purple-500/10">
          <form action="{{ route('contact.submit', app()->getLocale()) }}" method="POST" class="space-y-6">
            @csrf
            
            <!-- Name Input -->
            <div class="relative group">
              <label for="name" class="absolute -top-2 left-4 bg-black px-2 text-sm text-gray-400 group-focus-within:text-purple-400 transition-colors duration-300">{{ __('pages.contact_form_name') }}</label>
              <input type="text" id="name" name="name" required class="w-full px-4 py-3 bg-white/5 border {{ $errors->has('name') ? 'border-red-500' : 'border-white/10' }} rounded-xl text-white focus:border-purple-500 focus:bg-white/10 transition-all duration-300 outline-none">
              @error('name')
                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
              @enderror
            </div>
            
            <!-- Email Input -->
            <div class="relative group">
              <label for="email" class="absolute -top-2 left-4 bg-black px-2 text-sm text-gray-400 group-focus-within:text-purple-400 transition-colors duration-300">{{ __('pages.contact_form_email') }}</label>
              <input type="email" id="email" name="email" required class="w-full px-4 py-3 bg-white/5 border {{ $errors->has('email') ? 'border-red-500' : 'border-white/10' }} rounded-xl text-white focus:border-purple-500 focus:bg-white/10 transition-all duration-300 outline-none">
              @error('email')
                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
              @enderror
            </div>
                        <!-- Subject Input -->
            <div class="relative group">
              <label for="subject" class="absolute -top-2 left-4 bg-black px-2 text-sm text-gray-400 group-focus-within:text-purple-400 transition-colors duration-300">{{ __('pages.contact_form_subject') }}</label>
              <input type="text" id="subject" name="subject" required class="w-full px-4 py-3 bg-white/5 border {{ $errors->has('subject') ? 'border-red-500' : 'border-white/10' }} rounded-xl text-white focus:border-purple-500 focus:bg-white/10 transition-all duration-300 outline-none">
              @error('subject')
                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
              @enderror
            </div>
            <!-- Message Input -->
            <div class="relative group">
              <label for="message" class="absolute -top-2 left-4 bg-black px-2 text-sm text-gray-400 group-focus-within:text-purple-400 transition-colors duration-300">{{ __('pages.contact_form_message') }}</label>
              <textarea id="message" name="message" rows="5" required class="w-full px-4 py-3 bg-white/5 border {{ $errors->has('message') ? 'border-red-500' : 'border-white/10' }} rounded-xl text-white focus:border-purple-500 focus:bg-white/10 transition-all duration-300 outline-none resize-none"></textarea>
              @error('message')
                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
              @enderror
            </div>
            
            <!-- Submit Button -->
            <button type="submit" class="w-full px-6 py-3 rounded-xl bg-gradient-to-r from-purple-600 to-blue-600 text-white font-medium shadow-lg shadow-purple-500/25 hover:shadow-purple-500/40 hover:scale-105 transition-all duration-300">
              {{ __('pages.contact_form_submit') }}
              <i class="fas fa-paper-plane ml-2"></i>
            </button>
          </form>
        </div>
        
        <!-- Success/Error Messages -->
        @if(session('success'))
        <div class="mt-4 p-4 rounded-xl bg-green-500/10 border border-green-500 text-green-400 text-center">
          {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div class="mt-4 p-4 rounded-xl bg-red-500/10 border border-red-500 text-red-400 text-center">
          {{ session('error') }}
        </div>
        @endif
      </div>
    </div>
  </div>
</section>
@endsection

<!-- Adaugă stiluri custom pentru animații -->
<style>
@keyframes pulse-slow {
  0%, 100% { transform: scale(1); }
  50% { transform: scale(1.05); }
}

@keyframes gradient-x {
  0%, 100% { background-position: 0% 50%; }
  50% { background-position: 100% 50%; }
}

.animate-pulse-slow {
  animation: pulse-slow 6s ease-in-out infinite;
}

.animate-gradient-x {
  background-size: 200% 200%;
  animation: gradient-x 3s ease infinite;
}

.animate-fade-in-left {
  animation: fade-in-left 0.8s ease-out forwards;
}

.animate-fade-in-right {
  animation: fade-in-right 0.8s ease-out forwards;
}

@keyframes fade-in-left {
  from { opacity: 0; transform: translateX(-50px); }
  to { opacity: 1; transform: translateX(0); }
}

@keyframes fade-in-right {
  from { opacity: 0; transform: translateX(50px); }
  to { opacity: 1; transform: translateX(0); }
}
</style>
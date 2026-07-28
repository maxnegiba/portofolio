import './floating-contacts.js';

function initializeProjectGalleries() {
  document.querySelectorAll('[data-project-gallery]').forEach((gallery) => {
    if (gallery.dataset.galleryInitialized === 'true') {
      return;
    }

    const track = gallery.querySelector('[data-gallery-track]');
    const slides = Array.from(gallery.querySelectorAll('[data-gallery-slide]'));
    const dots = Array.from(gallery.querySelectorAll('[data-gallery-dot]'));
    const previousButton = gallery.querySelector('[data-gallery-previous]');
    const nextButton = gallery.querySelector('[data-gallery-next]');
    const counter = gallery.querySelector('[data-gallery-counter]');

    if (!track || slides.length === 0) {
      return;
    }

    gallery.dataset.galleryInitialized = 'true';
    let activeIndex = 0;
    let pointerStartX = null;

    const updateGallery = (nextIndex) => {
      activeIndex = (nextIndex + slides.length) % slides.length;
      track.style.transform = `translateX(-${activeIndex * 100}%)`;

      slides.forEach((slide, index) => {
        const isActive = index === activeIndex;
        slide.setAttribute('aria-hidden', String(!isActive));
        slide.querySelector('a')?.setAttribute('tabindex', isActive ? '0' : '-1');
      });

      dots.forEach((dot, index) => {
        dot.setAttribute('aria-current', String(index === activeIndex));
      });

      if (counter) {
        const template = gallery.dataset.galleryCounterTemplate || '__CURRENT__ / __TOTAL__';
        counter.textContent = template
          .replace('__CURRENT__', String(activeIndex + 1))
          .replace('__TOTAL__', String(slides.length));
      }
    };

    previousButton?.addEventListener('click', () => updateGallery(activeIndex - 1));
    nextButton?.addEventListener('click', () => updateGallery(activeIndex + 1));
    dots.forEach((dot, index) => {
      dot.addEventListener('click', () => updateGallery(index));
    });

    gallery.addEventListener('keydown', (event) => {
      if (event.key === 'ArrowLeft') {
        event.preventDefault();
        updateGallery(activeIndex - 1);
      } else if (event.key === 'ArrowRight') {
        event.preventDefault();
        updateGallery(activeIndex + 1);
      } else if (event.key === 'Home') {
        event.preventDefault();
        updateGallery(0);
      } else if (event.key === 'End') {
        event.preventDefault();
        updateGallery(slides.length - 1);
      }
    });

    gallery.addEventListener('pointerdown', (event) => {
      if (event.pointerType === 'touch' || event.pointerType === 'pen') {
        pointerStartX = event.clientX;
      }
    });

    gallery.addEventListener('pointerup', (event) => {
      if (pointerStartX === null) {
        return;
      }

      const distance = event.clientX - pointerStartX;
      pointerStartX = null;

      if (Math.abs(distance) < 50) {
        return;
      }

      updateGallery(distance > 0 ? activeIndex - 1 : activeIndex + 1);
    });

    gallery.addEventListener('pointercancel', () => {
      pointerStartX = null;
    });

    updateGallery(0);
  });
}

// Parallax effect
document.addEventListener('DOMContentLoaded', () => {
  initializeProjectGalleries();

  
  window.addEventListener('scroll', () => {
    const scrollY = window.scrollY;
    document.querySelectorAll('.parallax-layer').forEach(layer => {
      const depth = layer.dataset.depth || 1;
      const movement = -(scrollY * depth * 0.1);
      layer.style.transform = `translateY(${movement}px)`;
    });
  });
  
  // 3D hover effect for project cards
  document.querySelectorAll('.project-card').forEach(card => {
    card.addEventListener('mousemove', (e) => {
      const rect = card.getBoundingClientRect();
      const x = e.clientX - rect.left;
      const y = e.clientY - rect.top;
      
      const centerX = rect.width / 2;
      const centerY = rect.height / 2;
      
      const rotateY = (x - centerX) / 20;
      const rotateX = (centerY - y) / 20;
      
      card.style.transform = `rotateX(${rotateX}deg) rotateY(${rotateY}deg) translateZ(10px)`;
    });
    
    card.addEventListener('mouseleave', () => {
      card.style.transform = 'rotateX(0) rotateY(0) translateZ(0)';
    });
  });
});

// Mobile menu toggle
const mobileBtn = document.getElementById('mobile-menu-btn');
const mobileMenu = document.getElementById('mobile-menu');
if (mobileBtn && mobileMenu) {
  mobileBtn.addEventListener('click', () => {
    mobileMenu.classList.toggle('max-h-0');
    mobileMenu.classList.toggle('max-h-screen');
    const icon = mobileBtn.querySelector('i');
    if (icon) {
      icon.classList.toggle('fa-bars');
      icon.classList.toggle('fa-times');
    }
  });
}

// Fade-in on scroll
const sections = document.querySelectorAll('.animate-fadeIn');
const observer = new IntersectionObserver(entries => {
  entries.forEach(entry => {
    if (entry.isIntersecting) entry.target.classList.add('opacity-100');
  });
}, { threshold: 0.1 });

sections.forEach(section => {
  section.classList.add('opacity-0');
  observer.observe(section);
});

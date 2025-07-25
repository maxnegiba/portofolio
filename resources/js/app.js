import * as bootstrap from 'bootstrap';
import '@fortawesome/fontawesome-free/js/all.min';

// Initialize Bootstrap tooltips
document.addEventListener('DOMContentLoaded', () => {
  const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
  tooltipTriggerList.map(trigger => new bootstrap.Tooltip(trigger));
  
  // Parallax effect
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
mobileBtn.addEventListener('click', () => {
  mobileMenu.classList.toggle('max-h-0');
  mobileMenu.classList.toggle('max-h-screen');
  const icon = mobileBtn.querySelector('i');
  icon.classList.toggle('fa-bars');
  icon.classList.toggle('fa-times');
});

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
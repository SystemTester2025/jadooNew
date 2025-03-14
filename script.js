
// Initialize Vue app
const { createApp } = Vue;

const app = createApp({
  data() {
    return {
      currentPage: window.location.pathname,
      currentHash: window.location.hash,
      pageContent: '',
      isLoading: false,
      loadedPages: {}
    };
  },
  methods: {
    // Navigation without page refresh
    async navigateTo(url) {
      this.isLoading = true;
      
      // Check if it's a hash navigation on the same page
      if (url.startsWith('#') && window.location.pathname === '/index.html') {
        this.currentHash = url;
        this.scrollToElement(url);
        this.isLoading = false;
        return;
      }
      
      if (url === '#') {
        url = 'index.html';
      }

      // Update URL in browser history without refreshing
      window.history.pushState({ path: url }, '', url);
      this.currentPage = url;
      
      // If it's a service page or other external page, load it dynamically
      if (url.includes('.html') && !url.includes('#')) {
        // Check if page content is already cached
        if (this.loadedPages[url]) {
          this.pageContent = this.loadedPages[url];
          this.isLoading = false;
          this.setupPageEffects();
          return;
        }
        
        try {
          const response = await fetch(url);
          const html = await response.text();
          
          // Extract only the content we need from the page
          const parser = new DOMParser();
          const doc = parser.parseFromString(html, 'text/html');
          const content = doc.querySelector('.service-detail') ? 
            doc.querySelector('.service-detail').outerHTML : 
            doc.body.innerHTML;
          
          this.pageContent = content;
          this.loadedPages[url] = content; // Cache the page content
          this.isLoading = false;
          this.setupPageEffects();
        } catch (error) {
          console.error('Error loading page:', error);
          this.isLoading = false;
        }
      } else {
        this.isLoading = false;
      }
    },
    
    // Scroll to element with ID
    scrollToElement(id) {
      const element = document.querySelector(id);
      if (element) {
        window.scrollTo({
          top: element.offsetTop - 80,
          behavior: 'smooth'
        });
      }
    },
    
    // Setup page effects and animations
    setupPageEffects() {
      // Ensure this runs after DOM updates
      this.$nextTick(() => {
        // Initialize any page-specific animations
        this.initAnimations();
        
        // Trigger scroll effects
        window.dispatchEvent(new Event('scroll'));
      });
    },
    
    // Initialize animations
    initAnimations() {
      // Add animated class to nav links with delay
      $('.nav-links li').each(function(index) {
        const $this = $(this);
        setTimeout(function() {
          $this.addClass('animated');
        }, 100 * index);
      });
    }
  },
  
  // Vue lifecycle hook - when app is mounted
  mounted() {
    // Handle browser back/forward navigation
    window.addEventListener('popstate', (event) => {
      this.currentPage = window.location.pathname;
      this.currentHash = window.location.hash;
      
      if (this.currentHash) {
        this.scrollToElement(this.currentHash);
      }
    });
    
    // Initialize page effects
    this.setupPageEffects();
  }
});

// Mount Vue app
window.onload = function() {
  app.mount('#app');
};

// jQuery initialization when document is ready
$(document).ready(function() {
  // Check for responsive layouts on window resize
  $(window).resize(function() {
    // Trigger scroll events to update parallax elements
    $(window).trigger('scroll');
  });

  // Mobile menu toggle
  $('.hamburger').click(function() {
    $('.nav-links').toggleClass('active');
    $(this).toggleClass('active');
  });

  // Close mobile menu when clicking a link
  $('.nav-links a').click(function() {
    $('.nav-links').removeClass('active');
    $('.hamburger').removeClass('active');
  });

  // Add button click animation
  $('body').on('click', '.cta-button', function(e) {
    const x = e.pageX - $(this).offset().left;
    const y = e.pageY - $(this).offset().top;

    const ripple = $('<span class="ripple"></span>');
    ripple.css({
      top: y + 'px',
      left: x + 'px'
    });

    $(this).append(ripple);

    setTimeout(() => {
      ripple.remove();
    }, 600);
  });

  // Animate feature items on scroll
  $(window).on('scroll', function() {
    $('.feature-card, .about-content, .services-content').each(function() {
      const elementPosition = $(this).offset() ? $(this).offset().top : 0;
      const windowHeight = $(window).height();
      const scrollPosition = $(window).scrollTop();

      if (scrollPosition > elementPosition - windowHeight + 100) {
        $(this).addClass('visible');
      }
    });
  });

  // Trigger once on page load
  setTimeout(function() {
    $(window).trigger('scroll');
  }, 500);

  // Parallax effect for About section background text
  $(window).on('scroll', function() {
    const scrollPosition = $(window).scrollTop();
    const aboutSection = $('.about');
    const servicesSection = $('.services-section');

    // About section parallax
    if (aboutSection.length > 0 && $('.about-bg-text').length > 0 && aboutSection.offset()) {
      const aboutSectionTop = aboutSection.offset().top;
      const aboutSectionHeight = aboutSection.outerHeight();

      if (scrollPosition > aboutSectionTop - window.innerHeight && 
          scrollPosition < aboutSectionTop + aboutSectionHeight) {
        const parallaxValue = (scrollPosition - aboutSectionTop) * 0.3;
        $('.about-bg-text').css('transform', `translateX(${parallaxValue}px)`);
      }
    }
    
    // Services section parallax and animations
    if (servicesSection.length > 0 && $('.services-bg-text').length > 0 && servicesSection.offset()) {
      const servicesSectionTop = servicesSection.offset().top;
      const servicesSectionHeight = servicesSection.outerHeight();

      if (scrollPosition > servicesSectionTop - window.innerHeight && 
          scrollPosition < servicesSectionTop + servicesSectionHeight) {
        const parallaxValue = (scrollPosition - servicesSectionTop) * 0.2;
        $('.services-bg-text').css('transform', `translateY(${parallaxValue}px)`);
      }
    }
  });
  
  // Add hover effect for service items
  $('body').on('mouseenter', '.service-item', function() {
    $(this).find('.service-content').css('background-color', '#f9f9f9');
  }).on('mouseleave', '.service-item', function() {
    $(this).find('.service-content').css('background-color', 'white');
  });
  
  // Add hover animation for the learn more button in services
  $('body').on('mouseenter', '.learn-more', function() {
    $(this).find('.arrow-icon').css('transform', 'translateX(5px)');
  }).on('mouseleave', '.learn-more', function() {
    $(this).find('.arrow-icon').css('transform', 'translateX(0)');
  });
});

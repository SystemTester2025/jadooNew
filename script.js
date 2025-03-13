$(document).ready(function() {
  // Add animated class to nav links with delay
  setTimeout(function() {
    $('.nav-links li').each(function(index) {
      const $this = $(this);
      setTimeout(function() {
        $this.addClass('animated');
      }, 100 * index);
    });
  }, 500);
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

  // Add smooth scrolling to nav links
  $('a[href^="#"]').on('click', function(e) {
    e.preventDefault();

    const target = this.hash;

    // Only attempt to scroll if the target exists
    if(target && target !== '#') {
      const $target = $(target);

      if($target.length) {
        $('html, body').animate({
          'scrollTop': $target.offset().top - 80
        }, 800, 'swing');
      }
    }
  });

  // Add button click animation
  $('.cta-button').on('click', function(e) {
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
    $('.feature-item').each(function() {
      const featurePosition = $(this).offset().top;
      const windowHeight = $(window).height();
      const scrollPosition = $(window).scrollTop();

      if (scrollPosition > featurePosition - windowHeight + 100) {
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
    if (aboutSection.length && $('.about-bg-text').length) {
      const aboutSectionTop = aboutSection.offset().top;
      const aboutSectionHeight = aboutSection.outerHeight();

      if (scrollPosition > aboutSectionTop - window.innerHeight && 
          scrollPosition < aboutSectionTop + aboutSectionHeight) {
        const parallaxValue = (scrollPosition - aboutSectionTop) * 0.3;
        $('.about-bg-text').css('transform', `translateX(${parallaxValue}px)`);
      }
    }
    
    // Services section parallax and animations
    if (servicesSection.length && $('.services-bg-text').length) {
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
  $('.service-item').hover(
    function() {
      $(this).find('.service-content').css('background-color', '#f9f9f9');
    },
    function() {
      $(this).find('.service-content').css('background-color', 'white');
    }
  );
  
  // Carousel functionality
  let currentSlide = 0;
  const totalSlides = $('.service-item').length;
  
  function updateCarousel() {
    // Hide all slides
    $('.service-item').removeClass('active');
    // Show current slide
    $(`.service-item:eq(${currentSlide})`).addClass('active');
    
    // Update indicators
    $('.indicator').removeClass('active');
    $(`.indicator[data-index="${currentSlide}"]`).addClass('active');
    
    // Update content display
    const title = $(`.service-item:eq(${currentSlide})`).data('title');
    const description = $(`.service-item:eq(${currentSlide})`).data('description');
    
    $('#service-title').text(title);
    $('#service-description').text(description);
  }
  
  $('.next').click(function() {
    currentSlide = (currentSlide + 1) % totalSlides;
    updateCarousel();
  });
  
  $('.prev').click(function() {
    currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
    updateCarousel();
  });
  
  $('.indicator').click(function() {
    currentSlide = parseInt($(this).data('index'));
    updateCarousel();
  });
  
  // Auto slide the carousel every 5 seconds
  let carouselInterval = setInterval(function() {
    currentSlide = (currentSlide + 1) % totalSlides;
    updateCarousel();
  }, 5000);
  
  // Pause auto sliding when hovering over the carousel
  $('.services-carousel-container').hover(
    function() {
      clearInterval(carouselInterval);
    },
    function() {
      carouselInterval = setInterval(function() {
        currentSlide = (currentSlide + 1) % totalSlides;
        updateCarousel();
      }, 5000);
    }
  );
  
  // Touch swipe support for mobile devices
  let touchStartX = 0;
  let touchEndX = 0;
  
  $('.services-carousel').on('touchstart', function(e) {
    touchStartX = e.originalEvent.touches[0].clientX;
  });
  
  $('.services-carousel').on('touchend', function(e) {
    touchEndX = e.originalEvent.changedTouches[0].clientX;
    handleSwipe();
  });
  
  function handleSwipe() {
    if (touchStartX - touchEndX > 50) {
      // Swipe left - next slide
      currentSlide = (currentSlide + 1) % totalSlides;
    } else if (touchEndX - touchStartX > 50) {
      // Swipe right - previous slide
      currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
    }
    updateCarousel();
  }
  
  // Initialize carousel
  updateCarousel();
});
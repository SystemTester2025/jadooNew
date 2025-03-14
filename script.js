$(document).ready(function() {
  // Check for responsive layouts on window resize
  $(window).resize(function() {
    // Trigger scroll events to update parallax elements
    $(window).trigger('scroll');
  });
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

  // Add smooth scrolling to "Let's Talk" link in navbar
  $('.cta-button').on('click', function(e) {
    e.preventDefault();
    $('html, body').animate({
      scrollTop: $('.contact-section').offset().top - 80
    }, 800, 'swing');
  });

  // Add smooth scrolling to "HOME" link in navbar
  $('.nav-links a[href="#"]').on('click', function(e) {
    e.preventDefault();
    $('html, body').animate({
      scrollTop: 0
    }, 800, 'swing');
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
    const scholarshipSection = $('.scholarship-section');

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
    
    // Scholarship section parallax and animations
    if (scholarshipSection.length > 0 && $('.scholarship-bg-text').length > 0 && scholarshipSection.offset()) {
      const scholarshipSectionTop = scholarshipSection.offset().top;
      const scholarshipSectionHeight = scholarshipSection.outerHeight();

      if (scrollPosition > scholarshipSectionTop - window.innerHeight && 
          scrollPosition < scholarshipSectionTop + scholarshipSectionHeight) {
        const parallaxValue = (scrollPosition - scholarshipSectionTop) * 0.2;
        const rotateValue = -10 + (parallaxValue * 0.02);
        $('.scholarship-bg-text').css('transform', `rotate(${rotateValue}deg) translateY(${parallaxValue}px)`);
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
  
  // Add hover animation for the learn more button in services
  $('.learn-more').hover(
    function() {
      $(this).find('.arrow-icon').css('transform', 'translateX(5px)');
    },
    function() {
      $(this).find('.arrow-icon').css('transform', 'translateX(0)');
    }
  );

  // Add animation for contact section logo when hovering over the entire contact section
  $('.contact-section').hover(
    function() {
      // When mouse enters the contact section
      $('.contact-info .logo').addClass('animated');
    },
    function() {
      // When mouse leaves the contact section
      $('.contact-info .logo').removeClass('animated');
    }
  );
});
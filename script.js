$(document).ready(function() {
  // Mobile menu toggle
  $('.hamburger').on('click', function() {
    $('.nav-links').toggleClass('active');
    $(this).toggleClass('active');
  });

  // Button ripple effect
  $('.cta-button').on('click', function(e) {
    const x = e.pageX - $(this).offset().left;
    const y = e.pageY - $(this).offset().top;

    const ripple = $('<span class="ripple"></span>');
    ripple.css({
      top: y + 'px',
      left: x + 'px'
    });

    $(this).append(ripple);

    setTimeout(function() {
      ripple.remove();
    }, 600);
  });

  // Animate feature items on scroll
  $(window).on('scroll', function() {
    $('.feature-item').each(function() {
      if ($(this).offset()) {
        const featurePosition = $(this).offset().top;
        const windowHeight = $(window).height();
        const scrollPosition = $(window).scrollTop();

        if (scrollPosition > featurePosition - windowHeight + 100) {
          $(this).addClass('visible');
        }
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

    if (aboutSection.length && aboutSection.offset()) {
      const aboutSectionTop = aboutSection.offset().top;
      const aboutSectionHeight = aboutSection.outerHeight();

      if (scrollPosition > aboutSectionTop - window.innerHeight && 
          scrollPosition < aboutSectionTop + aboutSectionHeight) {
        const parallaxValue = (scrollPosition - aboutSectionTop) * 0.3; // Added missing parallaxValue
        $('.about-bg-text').css('transform', `translateX(${parallaxValue}px)`);
      }
    }
  });

  // Make sure all sections are responsive
  function updateLayout() {
    const windowWidth = $(window).width();

    // Adjust font sizes based on viewport width
    if (windowWidth < 768) {
      $('h1').css('font-size', '7vw');
    } else {
      $('h1').css('font-size', '3.5vw');
    }

    // Make sure content fits within viewport
    $('.container').css('max-width', windowWidth + 'px');
  }

  // Run on load and resize
  $(window).on('resize', updateLayout);
  updateLayout();
});
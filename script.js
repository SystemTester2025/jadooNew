$(document).ready(function() {
  // Check for responsive layouts on window resize

  var elem = document.getElementById('header');
var show = document.getElementById('hero');



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

  // Specific handlers for each navigation link
  // HOME link - always scroll to top
  $('.nav-links a[href="#"]').on('click', function(e) {
    e.preventDefault();

    // Update active state immediately
    $('.nav-links a').removeClass('active');
    $(this).addClass('active');

    // Always scroll to the very top (0)
    $('html, body').animate({
      scrollTop: 0
    }, 800, 'swing', function() {
      // Make sure home is still active after animation
      $('.nav-links a[href="#"]').addClass('active');
    });
  });

  // ABOUT link - scroll to about section
  $('.nav-links a[href="#about"]').on('click', function(e) {
    e.preventDefault();

    // Update active state immediately
    $('.nav-links a').removeClass('active');
    $(this).addClass('active');

    // Scroll to about section with offset
    const aboutOffset = $('#about').offset().top - $('header').outerHeight() - 20;
    $('html, body').animate({
      scrollTop: aboutOffset
    }, 800, 'swing', function() {
      // Make sure about is still active after animation
      $('.nav-links a[href="#about"]').addClass('active');
    });
  });

  // Generic handler for other section links
  $('.nav-links a[href^="#"]:not([href="#"]):not([href="#about"])').on('click', function(e) {
    e.preventDefault();

    const target = this.hash;

    // Update active class immediately on click
    $('.nav-links a').removeClass('active');
    $(this).addClass('active');

    // Only attempt to scroll if the target exists
    if (target) {
      const $target = $(target);

      if ($target.length) {
        $('html, body').animate({
          'scrollTop': $target.offset().top - 80
        }, 800, 'swing', function() {
          // Update active section after animation completes
          updateActiveSection();
        });
      }
    }
  });

  // Dedicated handler for the "Let's Talk" button in navbar
  $('.nav-cta').off('click').on('click', function(e) {
    e.preventDefault();

    // Update active state immediately
    $('.nav-links a').removeClass('active');
    $(this).addClass('active');

    // Calculate the exact position of the contact section
    const contactOffset = $('.contact-section').offset().top - $('header').outerHeight() - 20;

    // Scroll to the contact section with animation
    $('html, body').animate({
      scrollTop: contactOffset
    }, 800, 'swing', function() {
      // Make sure contact link is still active after animation
      $('.nav-cta').addClass('active');
      updateActiveSection();
    });

    // Return false to prevent any other click handlers from executing
    return false;
  });

  // Add ripple effect for hero CTA button
  $('.hero-cta').on('click', function(e) {
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

  // Update active section on window resize
  $(window).on('resize', function() {
    updateActiveSection();
  });

  // Initialize active section on page load
  updateActiveSection();
});

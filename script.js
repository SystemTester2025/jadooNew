
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
    const $target = $(target);
    
    $('html, body').animate({
      'scrollTop': $target.offset().top - 80
    }, 800, 'swing');
  });

  // Add button click animation
  $('.cta-button').on('click', function(e) {
    const $button = $(this);
    
    // Create ripple effect
    const $ripple = $('<span class="ripple"></span>');
    $button.append($ripple);
    
    const buttonPos = $button.offset();
    const xPos = e.pageX - buttonPos.left;
    const yPos = e.pageY - buttonPos.top;
    
    $ripple.css({
      top: yPos,
      left: xPos
    });
    
    setTimeout(function() {
      $ripple.remove();
    }, 600);
  });
});

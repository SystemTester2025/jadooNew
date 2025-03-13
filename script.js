
$(document).ready(function() {
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

  // Add animation to service items on hover
  $('.service-list li').hover(
    function() {
      $(this).find('.arrow').css('transform', 'translateX(5px)');
    },
    function() {
      $(this).find('.arrow').css('transform', 'translateX(0)');
    }
  );
});

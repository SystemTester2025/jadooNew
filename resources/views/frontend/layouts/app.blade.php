<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, maximum-scale=1.0, user-scalable=no">
  <title>{{ $settings['site_title'] ?? 'JADOO' }} - @yield('title', 'From Education and Training to Innovation')</title>
  
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link href="{{ asset('packages/font-awesome/css/all.min.css') }}" rel="stylesheet">
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css" />
  
  <!-- Dynamic CSS from settings -->
  <style>
    :root {
      --primary-color: {{ $settings['primary_color'] ?? '#6b5ce7' }};
      --secondary-color: {{ $settings['secondary_color'] ?? '#0099ff' }};
      --text-color: {{ $settings['text_color'] ?? '#333333' }};
      --background-color: {{ $settings['background_color'] ?? '#ffffff' }};
    }
  </style>
  
  @yield('styles')
</head>

<body class="loading">
  <!-- Preloader -->
  <div class="preloader">
    <div class="loader">
      <div class="loader-circle"></div>
      <div class="loader-circle"></div>
      <div class="loader-circle"></div>
      <div class="loader-circle"></div>
      <div class="loader-logo">J</div>
    </div>
  </div>

  <header id="header" class="static-header">
    <div class="container d-flex justify-content-between align-items-center">
      <div class="logo">
        <img src="{{ asset($settings['logo'] ?? 'images/logo/logo-black.png') }}" alt="{{ $settings['site_title'] ?? 'JADOO' }}" style="height: 50px;">
      </div>
      <nav class="d-none d-md-block">
        <ul class="nav-links d-flex">
          <li><a href="{{ route('home') }}" class="nav-link home-link {{ request()->routeIs('home') ? 'active' : '' }}">HOME</a></li>
          <li><a href="{{ route('about') }}" class="nav-link about-link {{ request()->routeIs('about') ? 'active' : '' }}">ABOUT</a></li>
          <li><a href="#contact" class="cta-button nav-cta contact-link">Let's Talk</a></li>
        </ul>
      </nav>
      <div class="hamburger d-md-none">
        <span></span>
        <span></span>
        <span></span>
      </div>
    </div>
    <nav class="d-md-none">
      <ul class="nav-links flex-column">
        <li><a href="{{ route('home') }}" class="nav-link home-link {{ request()->routeIs('home') ? 'active' : '' }}">HOME</a></li>
        <li><a href="{{ route('about') }}" class="nav-link about-link {{ request()->routeIs('about') ? 'active' : '' }}">ABOUT</a></li>
        <li><a href="#contact" class="cta-button nav-cta contact-link">Let's Talk</a></li>
      </ul>
    </nav>
  </header>

  @yield('content')
  
  <footer>
    <div class="container">
      <div class="footer-content">
        <div class="footer-logo">
          <img src="{{ asset($settings['logo'] ?? 'images/logo/logo-black.png') }}" alt="{{ $settings['site_title'] ?? 'JADOO' }}">
        </div>
        <div class="footer-social">
          <a href="{{ $settings['youtube_url'] ?? '#' }}"><i class="fab fa-youtube"></i><p>Youtube</p></a>
          <a href="{{ $settings['linkedin_url'] ?? '#' }}"><i class="fab fa-linkedin-in"></i><p>LinkedIn</p></a>
        </div>
        <div class="footer-bottom">
          <p>&copy; {{ date('Y') }} {{ $settings['site_title'] ?? 'JADOO' }}. All rights reserved.</p>
        </div>
      </div>
    </div>
  </footer>

  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
  <script src="{{ asset('js/script.js') }}"></script>
  @yield('scripts')
</body>
</html> 
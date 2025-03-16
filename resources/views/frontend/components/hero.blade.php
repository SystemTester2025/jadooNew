<section class="hero" id="hero">
  <div class="container">
    <div class="top-section">
      <div class="row align-items-center">
        <div class="col-md-6 hero-content">
          <h1>FROM EDUCATION <br>AND TRAINING <br>TO INNOVATION</h1>
          <p class="hero-desc">{{ $settings['site_description'] ?? 'JADOO brings innovative solutions to education and technology, transforming the way we learn and interact with the digital world.' }}</p>
          <a href="#" class="cta-button hero-cta">Discover More</a>
        </div>
        <div class="col-md-6 services">
          <h2>SERVICES</h2>
          <ul class="service-list">
            @foreach($services->take(4) as $service)
              <li>
                <a href="{{ route('service', $service->slug) }}">
                  <span>{{ $service->title }}</span>
                  <span class="arrow">→</span>
                </a>
              </li>
            @endforeach
          </ul>
        </div>
      </div>
    </div>
  </div>
</section> 
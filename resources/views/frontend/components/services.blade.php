<section class="services-section" id="services">
  <div class="container">
    <div class="services-wrapper">
      <div class="services-header">
        <h2 class="services-title">SERVICES</h2>
        <div class="services-number">02</div>
      </div>
      
      <div id="servicesCarousel" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
          @foreach($services as $index => $service)
            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
              <div class="services-layout">
                <div class="services-image">
                  <img src="{{ asset($service->image) }}" alt="{{ $service->title }}" class="img-fluid">
                </div>
                <div class="services-content">
                  <h3>{{ $service->title }}</h3>
                  <p>{{ $service->short_description }}</p>
                  <a href="{{ route('service', $service->slug) }}" class="learn-more">Learn More <span class="arrow-icon">→</span></a>
                </div>
              </div>
            </div>
          @endforeach
        </div>
        <a class="carousel-control-prev" href="#servicesCarousel" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#servicesCarousel" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>
    </div>
  </div>
  <div class="services-bg-text">02</div>
</section> 
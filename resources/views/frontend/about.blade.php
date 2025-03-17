@extends('frontend.layouts.app')

@section('title', 'About JADOO')

@section('content')
<section class="about-hero" id="about-hero">
  <div class="container">
    <div class="about-hero-title">ABOUT US</div>
    <div class="about-hero-subtitle">Learn more about our mission and vision</div>
  </div>
</section>

<section class="about-main">
  <div class="container">
    <div class="row">
      <div class="col-md-6 about-image">
        <img src="{{ asset('images/about/about-main.jpg') }}" alt="About {{ $settings['site_title'] ?? 'JADOO' }}" class="img-fluid">
      </div>
      <div class="col-md-6">
        @if($page)
          {!! $page->content !!}
        @else
          <p class="about-main-desc">
            After more than 20 years of experience in the Saudi Arabia's Human Capital Development market, JAD Consulting (JADCO) was established to continue supporting the industry with a new inspired vision by the great Saudi Vision 2030.
          </p>
          <p>
            JADCO and its highly ranked international partners of Companies, Universities and SMEs are forming together an exclusive and innovative consortium to serve and be part of the revolution and development and support the transformation for the next levels.
          </p>
          <p>
            JADCO in collaboration with the best partners in the globe, customize and Tailor projects to bridge the gap and providing the latest technologies to ensure the max level of quality of deliverables, support local content and transform knowledge to meet the objectives of our clients.
          </p>
        @endif
      </div>
    </div>
  </div>
</section>

@include('frontend.components.contact')
@endsection 
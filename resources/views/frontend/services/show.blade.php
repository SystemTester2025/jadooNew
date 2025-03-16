@extends('frontend.layouts.app')

@section('title', $service->title)

@section('content')
<section class="service-detail">
  <div class="container">
    <h1>{{ $service->title }}</h1>
    
    <div class="service-detail-content">
      <div class="service-detail-image">
        <img src="{{ asset($service->image) }}" alt="{{ $service->title }}" class="img-fluid">
      </div>
      <div class="service-detail-text">
        {!! $service->content !!}
        
        <a href="{{ route('home') }}" class="back-button">Back to Home</a>
      </div>
    </div>
  </div>
</section>

@include('frontend.components.contact')
@endsection 
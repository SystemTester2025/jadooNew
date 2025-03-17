@extends('frontend.layouts.app')

@section('title', $page->meta_title ?? $page->title)

@section('content')
<section class="service-detail">
  <div class="container">
    <h1>{{ $page->title }}</h1>
    
    <div class="service-detail-content">
      <div class="service-detail-text">
        {!! $page->content !!}
      </div>
    </div>
  </div>
</section>

@include('frontend.components.contact')
@endsection 
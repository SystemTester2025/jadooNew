@extends('frontend.layouts.app')

@section('title', 'From Education and Training to Innovation')

@section('content')
  @include('frontend.components.hero')
  @include('frontend.components.about')
  @include('frontend.components.services')
  @include('frontend.components.scholarship')
  @include('frontend.components.statistics')
  @include('frontend.components.contact')
@endsection 
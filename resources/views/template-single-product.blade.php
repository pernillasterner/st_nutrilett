{{--
  Template Name: Single Product Page Template
--}}

@extends('layouts.app')
@section('content')
  @include('sections.section-single-product-static')
  @include('sections.section-popular-products-static')
  @include('sections.section-reviews-static')
  @include('sections.section-newsletter-small-static')
  @include('partials.content-page')
@endsection

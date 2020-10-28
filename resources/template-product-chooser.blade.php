{{--
  Template Name: Product Chooser Static Page Template
--}}

@extends('layouts.app')

@section('content')
{{-- @while(have_posts()) @php the_post() @endphp --}}
{{-- @include('partials.page-header') --}}

@include('sections.section-product-chooser-static')
@include('sections.section-popular-products-static')
@include('sections.section-product-bundles-static')
@include('sections.section-articles-static')
@include('sections.section-newsletter-small-static')

@include('partials.content-page')
{{-- @endwhile --}}
@endsection

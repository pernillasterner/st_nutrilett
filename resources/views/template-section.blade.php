{{--
  Template Name: Section Template
--}}

@extends('layouts.app')

@section('content')
@while(have_posts()) @php the_post() @endphp
@include('partials.page-header')

  <div class="container">
    <div class="h2">Newsletter 1</div>
  </div>
  <!-- Newsletter -->
  @include('sections.section-newsletter')

  <section class="section">
    <div class="container">
      <!-- Button trigger modal -->
      <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#modalNewsletter">
        Launch newsletter modal
      </button>
    </div>
  </section>

  <!-- 50/50 layout -->
  <div class="container">
    <div class="h2">50/50 layout</div>
  </div>
  @include('sections.section-fifty-fifthy')

  <!-- Promo box -->
  <div class="container">
    <div class="h2">Promo boxes</div>
  </div>
  @include('sections.section-promo-box')


@include('partials.content-page')
@endwhile
@endsection

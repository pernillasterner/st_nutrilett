@extends('layouts.app')
@section('content')
  {{-- @while(have_posts()) @php the_post() @endphp
    @include('partials.page-header')
    @include('partials.content-page')
  @endwhile --}}

  {{-- @if ($breadcrumbs)
    <section class="section breadcrumb-vertical no-mb d-none d-lg-block">
      {!! $breadcrumbs !!}
    </section>
  @endif --}}

  @include('partials.sections')

  {{-- @include('partials.page-header') --}}
  {{-- @debug --}}
@endsection

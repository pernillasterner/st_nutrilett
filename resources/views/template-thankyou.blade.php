{{--
  Template Name: Thank You Template
--}}
@extends('layouts.app')

@section('content')
    
@if ( isset( $page_info->info['order'] ) )
    @include( 'sections.section-thankyou', [
        'receipt_info' => $page_info->info,
        'sectionClass' => empty($content) ? 'no-mb' : '',
        'translation' => $site_translate->selections
    ])
@endif

{{ $clear_session }}

@include( 'partials.sections' )

@endsection

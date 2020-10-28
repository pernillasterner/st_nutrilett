@extends('layouts.app')

@section('content')

<section class="section has-breadcrumbs {{ (!empty(get_the_post_thumbnail($post->id))) ? 'has-image' : '' }} section-article-page">
    <div class="container article-hero">
        <div class="article-image">
            {{-- article image / banner --}}
            @if(!empty(get_the_post_thumbnail($post->id)))
                <figure>
                    {!! get_the_post_thumbnail( null, 'article-image' ) !!}
                </figure>
            @endif
        </div>
    </div>

    <div class="container">
        <div class="row justify-content-center">
        <div class="col-lg-8">
            {{-- section title --}}
            <h1 class="h1">{!! the_title() !!}</h1>

            {{-- lead text  --}}
            @if( $preamble )
                <div class="lead">{!! $preamble !!}</div>
            @endif

            {{-- editor output  --}}
            <div class="editor-output">{!! apply_filters( 'the_content', $post->post_content ) !!}</div>
        </div>
        </div>
    </div>
</section>

{{-- Sections  --}}
@include( 'partials.sections' )

@endsection
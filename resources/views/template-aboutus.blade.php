{{--
  Template Name: About Us Sub Template
--}}

@extends('layouts.app')

@section('content')

    <section class="section has-breadcrumbs is-small-bottom section-half-text">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-6">
                    <h2 class="h2">{!! get_the_title() !!}</h2>

                    @if($preamble->text)
                        <div class="lead">{{ $preamble->text }}</div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <section class="section is-small address-sidebar">
        <div class="container js-as-container">
            <div class="row">
                <div class="col-md-7 col-lg-6">
                    @if($post_content)
                        <div class="info">
                            {!! apply_filters( 'the_content',  $post_content) !!}
                        </div>
                    @endif
                </div>
                <div class="col-md-4 offset-md-1 col-lg-4 offset-lg-2">
                    <div class="js-sticky-sidebar">
                        <div class="fixed-address">
                            <div class="address">
                                @if($floating_content->title)
                                    <h4 class="h4">{{ $floating_content->title }}</h4>
                                @endif

                                @if($floating_content->text)
                                    {!! apply_filters( 'the_content', $floating_content->text ) !!}
                                @endif

                                @if($floating_content->link)
                                    <a href="{{ (isset($floating_content->link['url'])) ? $floating_content->link['url'] : '' }}" {{ (isset($floating_content->link['target'])) ? 'target="_blank"' : '' }}>
                                        {{ (!empty($floating_content->link['text'])) ? $floating_content->link['text'] : 'Åpne i Google Maps' }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div id="sectionIsIncluded"></div>
    @include('partials.sections')

@endsection
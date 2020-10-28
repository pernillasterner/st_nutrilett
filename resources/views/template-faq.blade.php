{{--
  Template Name: FAQ Page Template
--}}

@extends('layouts.app')

@section('content')

    <section class="section has-default section-faq">
        <div class="container">
        <h1 class="h1 mb-5">{!! get_the_title() !!}</h1>
            <div id="accordion" class="accordion">
                @if($faq_list)
                    @foreach($faq_list as $item)
                        <div id="faq{{ $item->ID }}" class="card mb-0">
                            <div class="card-header collapsed" data-toggle="collapse" href="#faq-{{ $item->ID }}">
                                <a class="card-title">
                                    {{ $item->post_title }}
                                    <div class="plus-minus-toggle"></div>
                                </a>
                            </div>
                            <div id="faq-{{ $item->ID }}" class="card-body collapse" data-parent="#accordion">
                                <div class="editor-output">
                                    {!! get_field( 'content', $item->ID ); !!}
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </section>

    <div id="sectionIsIncluded"></div>
    @include('partials.sections')

@endsection

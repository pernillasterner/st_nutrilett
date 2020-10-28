{{--
  Template Name: Product Chooser Page Template
--}}

@extends('layouts.app')

@section('content')

    @if( isset($_GET['result']))
        <section id="section-1" class="hero has-breadcrumbs">
            <div class="section has-hero bg-secondary">
                <div class="container info-image d-flex">
                    <div class="row info-wrap align-self-center">
                        <div class="col-md-8 col-lg-7 col-xl-6">
                            <div class="info">
                                <div class="small pre-title">
                                    @if($hero_data->small_title)
                                        {{ $hero_data->small_title }}
                                    @endif
                                </div>

                                <h1 class='h1'>{!! $hero_data->big_title !!}</h1>

                                <div class="description">
                                    @if(isset($hero_data->text))
                                    <p>{!! $hero_data->text !!}</p>
                                    @endif
                                </div>

                                @if($hero_data->bullet_list)
                                <ul class="info-list">
                                    @foreach($hero_data->bullet_list as $item)
                                    <li>
                                        <div class="icon">@include('icons.check')</div>
                                        <small class="detail">{!! $item['item'] !!}</small>
                                    </li>
                                    @endforeach
                                </ul>
                                @endif
                            </div>
                        </div>
                    </div>
                    @if(isset($hero_data->image))
                        {!! $hero_data->image !!}
                    @endif
                </div>
            </div>
        </section>

        @if( $has_result )
            <section class="section is-small-bottom section-half-text">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            @if(isset($text))
                                <div class="lead">{!! $text !!}</div>
                            @endif
                        </div>
                    </div>
                </div>
            </section>

            @if( $products )
                @include( 'partials.popular-products', [
                    'products' => $products,
                    'title' => $product_results->title,
                    'link' => (array) $product_results->link,
                    'mobile_link_text' => $product_results->mobile_link_text,
                ] )
            @endif

            @if( $bundles )
                @include( 'partials.popular-product-bundles', [
                    'products' => $bundles,
                    'title' => $product_bundle_results->title,
                    'link' => (array) $product_bundle_results->link,
                    'mobile_link_text' => $product_bundle_results->mobile_link_text,
                ] )
            @endif

            @if( $articles_data )
                @include( 'sections.section-article_promo', [ 'section' => $articles_data ] )
            @endif
        @endif
    @else
        @include('sections.section-product_chooser', ['section' => (object)[
            'id' => 1,
            'classes' => 'has-breadcrumbs is-small-bottom'
        ]])

        @if ($start_screen->lead_text)
            <section class="section is-small-top section-half-text is-product-chooser">
                <div class="container">
                    <div class="row">
                        <div class="offset-lg-1 col-lg-10">                        
                            <div class="lead">{!! $start_screen->lead_text !!}</div>
                        </div>
                    </div>
                </div>
            </section>
        @endif
    @endif

    @include( 'partials.sections' )
@endsection
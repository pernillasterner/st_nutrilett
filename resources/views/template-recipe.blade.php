<?php
/**
 * Template Name: Recipe Template
 * Template Post Type: post
 */
?>

@extends('layouts.app')

@section('content')

@php
$schemaData = array(
    "@context" => "http://schema.org",
    "@type" => "Recipe",
    "url" => get_permalink(),
    "headline" => get_the_title(),
    "description" => get_the_excerpt() ?: $preamble,
    "author" => get_bloginfo( 'name' ),
    "cookTime" => TemplateRecipe::format_time_to_pt( $cook_time ),
    "datePublished" => get_the_date( 'Y-m-d' ),
    "image" => get_the_post_thumbnail_url(),
    "recipeIngredient" => $recipe_ingredients ? array_map( function ( $item ) {
        return $item->ingredient;
    }, $recipe_ingredients[ 0 ]->ingredient ) : array(),
    "name" => get_the_title(),
    "nutrition" => array(
        "@type" => "NutritionInformation",
        "calories" => str_replace( ',', '.', $nutrition_calories )
    ),
    "prepTime" => TemplateRecipe::format_time_to_pt( $preparation_time ),
    "recipeInstructions" => $recipe_instructions ? array_map( function ( $item ) {
        return array(
            '@type' => 'HowToStep',
            'text' => $item->instruction
        );
    }, $recipe_instructions[ 0 ]->instruction ) : array(),
    "recipeYield" => $yield,
    "recipeCategory" => $recipe_category,
    "recipeCuisine" => $recipe_cuisine
);
@endphp

<script type="application/ld+json">{!! json_encode( $schemaData ) !!}</script>

{{-- section for the product slider --}}
<section class="section section-article-page has-breadcrumbs {{ $image ? 'has-image ' : '' }}">
    @if( $image )
        <div class="container article-hero">
            <div class="article-image">
                {{-- article image / banner --}}
                <figure>{!! $image !!}</figure>
            </div>
        </div>
    @endif
    <div class="container">
        <div class="row justify-content-center">
        <div class="col-lg-8">
            {{-- section title --}}
            <h1 class="h1">{!! the_title() !!}</h1>

            {{-- lead text  --}}
            @if( $preamble )
                <div class="lead">{!! $preamble !!}</div>
            @endif

            {{-- add is-first to this first info list element only in order to add the margin bottom differently --}}
            <div class="info-list is-first">
                <div class="info-bar">
                    @if( $yield )
                        <div class="info-bar-item">
                            {{ $site_translate->recipe['yield'] }}: {{ $yield }}
                        </div>
                    @endif

                    @if( $cook_time )
                        <div class="info-bar-item">
                            {{ $site_translate->recipe['cooking_time'] }}: {{ $cook_time }}
                        </div>
                    @endif

                    @if( $nutrition_calories )
                        <div class="info-bar-item">
                            {{ $site_translate->recipe['calories'] }}: {{ $nutrition_calories }}
                        </div>
                    @endif
                </div>
                </div>

                {{-- editor-output  --}}
                <div class="editor-output">
                    @if( $recipe_ingredients )
                        @foreach( $recipe_ingredients as $recipeIngredientsChild )
                            @php
                                $subheader = $recipeIngredientsChild->ingredients_sub_header;
                                $list = $recipeIngredientsChild->ingredient;
                            @endphp

                            @if( $list )
                                <h3>{!! $subheader !!}</h3>
                                <div class="info-list">
                                    <ul>
                                        @foreach ( $list as $item )
                                            <li>{!! $item->ingredient !!}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        @endforeach
                    @endif

                    @if ( $recipe_instructions )
                        @foreach ( $recipe_instructions as $recipeInstructionsChild )
                            @php
                                $subheader = $recipeInstructionsChild->instructions_sub_header;
                                $list = $recipeInstructionsChild->instruction;
                            @endphp

                            @if( $list )
                                <h3>{!! $subheader !!}</h3>
                                <div class="info-list">
                                    <ol>
                                        @foreach ( $list as $item )
                                            <li>{!! $item->instruction !!}</li>
                                        @endforeach
                                    </ol>
                                </div>
                            @endif
                        @endforeach
                    @endif

                    @if( $recipe_nutrition )
                        <h3>{!! $site_translate->recipe['nutritional_content'] !!}</h3>                        
                        <div class="info-list">
                            <div class="tabulation"> {{-- container --}}
                                @foreach( $recipe_nutrition as $item )
                                    <div class="tabulation-row"> {{-- row --}}
                                        <div class="tabulation-header">{!! $item->label !!}:</div> {{-- header --}}
                                        <div class="tabulation-info">{{ $item->value }}</div> {{-- info --}}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif                    
                </div>
            </div>
        </div>
    </div>
</section>

@include( 'partials.sections' )

@endsection
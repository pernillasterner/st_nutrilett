@php( $productsData = TaxonomySilk_category::getProducts() )
@php( $bundlesData = TaxonomySilk_category::getBundles() )

@if( $productsData->productsSlider )
    <section class="section has-breadcrumbs section-product-lists js-product-listing-page-items is-small is-small-top is-small-bottom">
        <div class="container">
            <div class="title-header d-flex justify-content-between">
                <h2 class="h2 is-small-mob align-self-center">{!! $productsData->title !!}</h2>
            </div>
        </div>
        <div class="container js-product-mobile">
            <div id="js-products-container" class="product-lists">
                @foreach( $productsData->productsSlider as $index => $product )
                    <div class="product-lists-item" 
                        data-tags="{{ $product->tags }}"
                        data-name="{{ $product->name }}"
                        data-index="{{ $index ?? 0 }}"
                        data-price="{!! (isset($product->display_price->price_as_number)) ? $product->display_price->price_as_number : '' !!}">
                        @include( 'partials.product-item', [ 'product' => $product, 'product_class' => new App\Classes\Product( $product->id ) ] )
                    </div>
                @endforeach
            </div>
            <div class="text-center load-more show-mobile">
                <a href="#" class="btn btn-secondary js-show-items">{!! $site_translate->product_listing['load_more'] !!}</a>
            </div>
        </div>
    </section>
@endif

@if( $bundlesData->productsSlider )
    <section class="section section-product-lists js-product-listing-page-items is-small is-small-top is-small-bottom {{ $productsData->productsSlider ? '' : 'has-breadcrumbs' }}">
        <div class="container">
            <div class="title-header d-flex justify-content-between">
                <h2 class="h2 is-small-mob align-self-center">{!! $bundlesData->title !!}</h2>
            </div>
        </div>

        <div class="container">
            <div id="js-bundles-container" class="product-lists">
                @foreach( $bundlesData->productsSlider as $index => $product )
                    <div class="product-lists-item is-bundle"
                        data-tags="{{ $product->tags }}"
                        data-name="{{ $product->name }}"
                        data-index="{{ $index ?? 0 }}"
                        data-price="{!! (isset($product->display_price->price_as_number)) ? $product->display_price->price_as_number : '' !!}">
                        @include( 'partials.product-bundle-item', [ 'product' => $product, 'product_class' => new App\Classes\Product( $product->id ) ] )
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif

<div id="sectionIsIncluded"></div>
@include('partials.sections')
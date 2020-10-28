<section id="section-{{ $section->id }}" class="section section-product-lists {{ isset( $section->classes ) ? $section->classes : '' }}">
    <div class="container">
        <div class="title-header d-flex justify-content-between">
            @if( isset( $title ) )
                <h2 class="h2 is-small-mob align-self-center">{!! $title !!}</h2>
            @endif

            @if( isset( $link ) && $link['url'] && $link['title'] )
                <div class="link-block align-self-center">
                    <a href="{{ $link['url'] }}" class="link-text has-icon" target="{{ $link['target'] }}">
                        <div class="d-none d-md-block">{!! $link['title'] !!}</div>
                        <div class="d-block d-md-none">{!! $mobile_link_text ?? $link['title'] !!}</div>
                    </a>
                </div>
            @endif
        </div>
    </div>
  
    <div class="container">
        <div class="product-lists js-product-carousel">
            @foreach( $products as $product )
                <div class="product-lists-item is-bundle carousel-cell">
                    @include( 'partials.product-bundle-item', [ 'product' => $product, 'product_class' => new App\Classes\Product( $product->id ) ] )
                </div>
            @endforeach
        </div>
    </div>
</section>
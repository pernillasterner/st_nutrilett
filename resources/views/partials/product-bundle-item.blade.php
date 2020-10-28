@php( $addtocart_button = App\Controllers\SingleSilk_products::getAddToCartButton( $product->id ) )

<script class="js-tracking-data" type="application/json">{!! json_encode( App\Classes\Helper::get_tracking_data( $product ) ) !!}</script>

<div class="prod-item is-bundle" data-type="{{ $product->type }}">
    @php ($product_class->renderStartPurchaseForm())

    <div class="feature">    
        @if( isset($product->display_price->is_sale) && $product->display_price->is_sale )
			<div class="sale">{{ $product->display_price->discount_percent }}%</div>
        @endif
        
        @if( isset( $product->meta->media[0]['sources']['bundle']['url'] ) )
            <a href="{{ get_permalink( $product->id ) }}">
                <img src="{{ $product->meta->media[0]['sources']['bundle']['url'] }}" alt="" class="img-bundle">
            </a>
        @else
            <a href="{{ get_permalink( $product->id ) }}">
                <img src="{{ $product->image }}" alt="" class="img-bundle">
            </a>
        @endif

        <input type="hidden" name="esc_amount" value="1">
    </div>
    <div class="name-price">
        <div class="name">
            <h4 class="h5"><a href="{{ get_permalink( $product->id ) }}">{!! $product->name !!}</a></h4>
        </div>
        <div class="rate-price d-flex justify-content-between align-items-center">
            <div class="rate">
                @include( 'partials.star-rating', [ 'rating' => SingleSilk_products::getProductRating( $product->id ) ] )
            </div>
            <div class="h5 price">
                @if( $product->display_price->is_sale )
                    <span class="old-price">{!! $product->display_price->price_before !!}</span>
                @endif
                {!! $product->display_price->price !!}
            </div>
        </div>
    </div>

    <button type="submit" class="btn btn-secondary has-icon" {!! $addtocart_button->attr !!}>{!! $addtocart_button->text ?? 'Add to cart' !!}</button>
    @php ($product_class->renderEndForm())
</div>
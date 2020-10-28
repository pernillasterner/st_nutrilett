@php( $addtocart_button = App\Controllers\SingleSilk_products::getAddToCartButton( $product->id ) )

<script class="js-tracking-data" type="application/json">{!! json_encode( App\Classes\Helper::get_tracking_data( $product ) ) !!}</script>

<div class="prod-item" data-type="{{ $product->type }}">
	@php ($product_class->renderStartPurchaseForm())

	<div class="feature">
		@if( (isset($product->display_price->is_sale) && $product->display_price->is_sale) || $product->type === 'Special' )
			<div class="sale">{!! (isset($product->display_price->discount_percent)) ? $product->display_price->discount_percent : '' !!}%</div>
		@endif
		<div class="image-block">
			<a href="{{ get_permalink( $product->id ) }}" class="image">
				<img class="img-product" src="{{ $product->image }}" alt="">
			</a>
		</div>
		<!-- Pernilla -->
		@if( $product->type === 'Special' && $product->bundles )
			<div class="bundle">
				<div class="bundle-list">
					@php($isFirst = true)
					@foreach( $product->bundles as $key => $item )
						<div class="bundle-item">
							<input class="js-selected-bundle" type="radio" name="bundle" id="d-{{ $product->id }}-{{ $key }}"
								value="{{ $item['post']->product_post->ID }}"
								data-price="{!! (isset($item['price']->price)) ? $item['price']->price : '' !!}"
								data-price-before-discount="{!! (isset($item['price']->price_before)) ? $item['price']->price_before : '' !!}"
								data-product-item="{{ $item['product_item'] }}"
								data-discount="{!! (isset($item['price']->discount_percent)) ? $item['price']->discount_percent : '' !!}"
								{{ $isFirst ? 'checked' : '' }}/>
								<label for="d-{{ $product->id }}-{{ $key }}">{{ $key }}</label>
						</div>
						@php($isFirst = false)
					@endforeach
				</div>
				<div class="bundle-title">{!! $site_translate->product_listing['select_the_quantity'] !!}</div>
			</div>
		@elseif( $product->type === 'Single' )
			<div class="bundle">
				<div class="bundle-list">
					@if(isset($product->display_price->quantityPrice))
						@foreach( $product->display_price->quantityPrice as $key => $item )
							<div class="bundle-item">
								<input class="js-selected-bundle" type="radio" name="esc_amount" id="b-{{ $product->id }}{{ $key }}"
									value="{{ $key }}"
									{{ $key === 1 ? 'checked' : '' }}
									data-price="{{ $item['price'] }}"
									data-price-before-discount="{{ $item['price_before_discount'] }}"
									data-discount="{{ $product->display_price->discount_percent }}"/>
								<label for="b-{{ $product->id }}{{ $key }}">{{ $key }}</label>
							</div>
						@endforeach
					@endif
				</div>
				<div class="bundle-title">{!! $site_translate->product_listing['select_the_quantity'] !!}</div>
			</div>
		@else
			<input type="hidden" name="esc_amount" value="1">
		@endif
	</div>
	<!-- Pernilla -->
	<div class="name-price">
		<div class="name">
			<h4 class="h5"><a href="{{ get_permalink( $product->id ) }}">{!! $product->name !!}</a></h4>	
		</div>
		<div class="rate-price d-flex justify-content-between align-items-center">
			<div class="rate">
				@include( 'partials.star-rating', [ 'rating' => SingleSilk_products::getProductRating( $product->id ) ] )
			</div>
			<div class="h5 price">
				@if( isset($product->display_price->is_sale) && $product->display_price->is_sale && $product->display_price->price_before )
					<span class="old-price">{!! $product->display_price->price_before !!}</span>
				@endif

				@if(isset($product->display_price->price))
					{!! $product->display_price->price !!}
				@endif
			</div>
		</div>
	</div>
			
	<button type="submit" class="btn btn-secondary has-icon" {!! $addtocart_button->attr !!}>{!! $addtocart_button->text ?? 'Add to cart' !!}</button>
	@php ($product_class->renderEndForm())
</div>
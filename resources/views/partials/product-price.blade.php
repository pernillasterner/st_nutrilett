@if (empty($isSelectedProduct))
	<div class="product-price">
		@if (!empty($priceInfo->is_sale))
			<span>{{ $priceInfo->price_before ?? '' }}</span>
			{{ $priceInfo->price ?? '' }}
		@else 
			<span>{{ $priceInfo->price ?? '' }}</span>
		@endif
	</div>

@else
	<div class="price">
		@if (!empty($priceInfo->is_sale))
			<span><del>{{ $priceInfo->price_before ?? '' }}</del></span>
			<span class="text-red">{{ $priceInfo->price ?? '' }}</span>
		@else 
			<span>{{ $priceInfo->price ?? '' }}</span>
		@endif
	</div>

@endif
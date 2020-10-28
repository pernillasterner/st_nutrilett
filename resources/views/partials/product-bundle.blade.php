@if ($bundle['products'])
	<h2>Product Bundle content</h2>
	<ul>
	@foreach($bundle['products'] as $product)
		<li><a href="/product/{{ $product['product_meta']['uri'] }}">{{ $product['product_meta']['name'] }}</a></li>
	@endforeach
	</ul>
@endif
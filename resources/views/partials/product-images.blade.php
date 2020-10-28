@if (!empty($images[$size]))
	@foreach($images[$size] as $image)
	    @if ($loop->index >= $limit)
	        @break
		@endif
		
		@php($srcset = '')
	    @if ($images['standard'][0]['url'])
			@php($srcset = $images['standard'][0]['url'].' 720w, ')
			@php($srcset .= $images['standard'][0]['url'].' 1440w, ')
		@endif
		@if ($images['full'][0]['url'])
			@php($srcset .= $images['full'][0]['url'].' 2880w')
		@endif
		
		<img class="{{ ($loop->index+1 === $img_pos_to_add_class) ? $class.' lazy' : 'lazy' }}" data-src="{{ $image['url'] }}" data-srcset="{{ $srcset }}" alt="" />
	@endforeach
@endif
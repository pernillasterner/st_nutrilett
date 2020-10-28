
@if ($image)

    @if (!empty($isMobile))

        <a href="{{ $image->link }}" class="col" target="_blank" rel="nofollow noreferrer">
            <figure class="tile">
                <img class="lazy" data-src="{!! !empty($isLarge) ? $image->image_large : $image->image_small !!}" alt="">
            </figure>
        </a>

    @else

        <a href="{{ $image->link }}" class="tile {{ $tileClass ?? '' }}" target="_blank" rel="nofollow noreferrer">
            <img class="lazy" data-src="{!! !empty($isLarge) ? $image->image_large : $image->image_small !!}" alt="">
        </a>

    @endif
@endif
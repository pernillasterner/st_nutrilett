<div class="card-item" style="{{ $masonryStyle ?? '' }}">
    <div class="card-block">
        <a href="{{ $item['cat_url'] }}" class="category">{!! $item['cat_name'] !!}</a>
        <a href="{{ get_permalink($item['id']) }}" class="card-info">
        <div class="image {{ (empty(get_the_post_thumbnail($item['id']))) ? 'no-image' : '' }}">
            {!! get_the_post_thumbnail($item['id'], 'article-listing', array( 'class' => '' )) !!}
            </div>
            <h3 class="h3">{!! get_the_title($item['id']) !!}</h3>
            <div class="link-text has-icon">{!! $site_translate->articles['read_more'] ?? 'Les mer' !!}</div>
        </a>
    </div>
</div>
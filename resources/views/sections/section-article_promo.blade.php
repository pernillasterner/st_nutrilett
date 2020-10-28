<!-- /flickity articles-->
@php
    $classes = [];
    
    if( isset($section->text) ) {
        $classes[] = 'has-info';
    }

    if( $section->link && $section->link['title'] && $section->link['url'] ) {
        $classes[] = 'has-link';
    }

    $classes = implode( ' ', $classes );
@endphp

<section id="section-{{ $section->id ?? '' }}" class="section section-articles {{ isset( $section->classes ) ? $section->classes : '' }}">
    <div class="container">
        <div class="title-header d-flex justify-content-between {{ $classes ?? '' }}">
            <div class="title align-self-center align-self-md-start">
                @if( isset($section->title) )                
                    <h2 class="h2 is-small-mob">{!! $section->title !!}</h2>
                @endif

                @if( isset($section->text) )
                    <p class="hide-mobile">{!! $section->text !!}</p>
                @endif
            </div>

            @if( $section->link && $section->link['title'] && $section->link['url'] )
                <div class="link-block align-self-center align-self-md-start">
                    <a href="{{ $section->link['url'] }}" class="link-text has-icon" target="{{ $section->link['target'] }}">
                        <div class="d-none d-md-block">{!! $section->link['title'] !!}</div>
                        <div class="d-block d-md-none">{!! $section->mobile_link_text ?? $section->link['title'] !!}</div>
                    </a>
                </div>
            @endif
        </div>
    </div>

    @if( $section->articles ) 
        <div class="container">
            <div class="card-lists js-articles-flickity">
                @foreach( $section->articles as $key => $item )
                    @php $link = get_permalink( $item ) @endphp
                    @php $categories = $section->show === 'handpicked' ? wp_get_post_terms( $item->ID, 'category' ) : [$section->category] @endphp
                    <div class="card-item carousel-cell">
                        <div class="card-block">
                            @if( $categories )
                                @php $category = end( $categories ) @endphp
                                <a href="{{ get_term_link( $category ) }}" class="category">{!! $category->name !!}</a>
                            @endif
                            <a href="{{ $link }}" class="card-info">
                                <div class="image {{ (empty(get_the_post_thumbnail($item->ID))) ? 'no-image' : '' }}">
                                    {!! get_the_post_thumbnail( $item->ID, 'article-listing', [ 'class' => 'img-card' ] ) !!}
                                </div>

                                <h3 class="h3">{!! $item->post_title !!}</h3>
                                <div class="link-text has-icon">{!! $site_translate->articles['read_more'] ?? 'Les mer' !!}</div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</section>
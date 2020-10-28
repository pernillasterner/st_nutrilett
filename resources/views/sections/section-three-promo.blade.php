@if ($section->title || $section->items)
    <section id="section-{{ $section->id }}" class="section three-promo  {{ $section->classes ?? '' }}">
        @if ( $section->title )
            <div class="container text-center title">
                @if($section->is_h1)
                    <h1 class="h2">{!! $section->title !!}</h1>
                @else
                    <h2 class="h2">{!! $section->title !!}</h2>
                @endif                 
            </div>
        @endif

        @if ( $section->items )
            <div class="container">
                <div class="row justify-content-md-center">
                    @foreach( $section->items as $item ) 
                        <div class="col-md-4">
                            <a href="{{ $item->link->url }}" class="card-block is-inline js-section-link" target="{{ $item->link->target }}">
                                <div class="image">
                                    <figure>
                                        {!! $item->image !!}
                                    </figure>
                                </div>

                                <div class="info">
                                    <h3 class="h4">{!! $item->title !!}</h3>
                                    <p>{!! $item->text !!}</p>
                                </div>

                                @if ($item->link->title)
                                    <div class="btn btn-primary text-uppercase">{!! $item->link->title !!}</div>
                                @endif
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </section>
@endif
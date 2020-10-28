@if( $section->hasContent )
    <section id="section-{{ $section->id }}" class="section section-half-text {{ $section->classes }}">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-6">
                    @if( $section->title )
                        <h2 class="h2">{!! $section->title !!}</h2>
                    @endif

                    <div class="lead">{!! apply_filters( 'the_content', $section->content ) !!}</div>
                </div>
            </div>
        </div>
    </section>
@endif
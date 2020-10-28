
{{-- Featured Article section --}}
{{-- figure and content-info are interchangeable whether its left or right --}}
{{-- if the image was on right side, kindly add order-lg-0 to the text container and add order-lg-1 for image container. --}}

<section id="section-{{ $section->id }}" class="section section-featured-article {{ $section->classes }}">
  <div class="container">
    <div class="row no-gutters">
      <div class="col-lg-6 is-column {{ $section->image_position === 'right' ? 'order-lg-1' : '' }}">
        @if( $section->mobile_top_text )
          <p class="d-block d-lg-none text-uppercase mb-4"><small class="font-weight-bold">{!! $section->mobile_top_text !!}</small></p>
        @endif
        <a href="{{ $section->link }}">
          <figure class="article-item">
              @if($section->image)
                {!! $section->image !!}
              @endif
          </figure>
        </a>
      </div>
      <div class="col-lg-6 is-column {{ $section->image_position === 'right' ? 'order-lg-0' : '' }}">
        <div class="content-info d-flex justify-content-center flex-column">
          <div class="h1 headtext">
            <a href="{{ $section->link }}">
                {!! $section->title !!}
            </a>
          </div>
          <div>
            <a href="{{ $section->link }}" class="link-text has-icon">{!! $section->link_text !!}</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

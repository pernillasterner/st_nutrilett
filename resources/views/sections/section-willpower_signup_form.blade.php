{{-- section willpower --}}
{{-- there must be an image for desktop and mobile --}}
{{-- sample below if there's no image on mobile, kindly add d-none d-lg-block --}}
<section id="section-{{ $section->id }}" class="section section-fifty-fifty section-willpower {{ isset( $section->classes ) ? $section->classes : '' }}">
    <div class="container">
      <div class="row no-gutters bg-white">
        <div class="col-lg-6 is-column {{ $section->has_image_in_mobile ? '' : 'd-none d-lg-block' }}">
            @if($section->image)                            
                <figure>
                    {!! $section->image !!}
                </figure>
            @endif
        </div>
  
        <div class="col-lg-6 is-column">
            <div class="content-info d-flex justify-content-start flex-column">
                @if( $section->title )
                    <div class="h1 headtext">{!! $section->title !!}</div>
                @endif
    
                <div class="identifier">
                    {!! $section->form !!}
                </div>
            </div>
        </div>
      </div>
  
    </div>
</section>
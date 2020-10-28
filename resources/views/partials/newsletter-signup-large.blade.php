{{-- newsletter large section --}}
{{-- figure and content-info are interchangeable whether its left or right --}}
{{-- if the image was on right side, kindly add order-lg-0 to the text container and add order-lg-1 for image container. See the example below --}}
<section id="section-{{ $section->id }}" class="section section-newsletter section-newsletter-large {{ $section->classes }}">
    <div class="container bg-white-xs">
        <div class="row no-gutters bg-white">
    
        {{-- newsletter large section  column --}}
        <div class="col-lg-6 is-column order-lg-{{ $section->image_position === 'right' ? '1' : '0' }}">
            @if( $section->image )
                <figure>
                    {!! $section->image !!}
                </figure>
            @endif
        </div>
        {{-- newsletter large section  column --}}
    
        {{-- newsletter large section  column --}}
        <div class="col-lg-6 is-column order-lg-{{ $section->image_position === 'right' ? '0' : '1' }}">
            <div class="content-info d-flex justify-content-center flex-column">
            @if( $section->title )
                <div class="h1">
                    {!! $section->title !!}
                </div>
            @endif
    
            <div class="widget-script">
                {!! $section->form_shortcode !!}
    
                <div>
                    <a href="#" class="link-text has-icon">{!! $newsletter_info->info_title !!}</a>
                    <p class="smaller">{!! $newsletter_info->info_content !!}</p>
                </div>
            </div>
            </div>
        </div>
        {{-- newsletter large section  column --}}
        </div>
    
    </div>
</section>
{{-- newsletter large section  section --}}
              
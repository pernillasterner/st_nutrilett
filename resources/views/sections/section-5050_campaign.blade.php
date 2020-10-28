@if ($section->hasContent)
    {{-- 50 - 50 section --}}
    {{-- figure and content-info are interchangeable whether its left or right --}}
    {{-- if the image was on right side, kindly add order-lg-0 to the text container and add order-lg-1 for image container. See the example below --}}
    <section id="section-{{ $section->id }}" class="section section-fifty-fifty {{ $section->classes }}">
        <div class="container bg-white-xs">
            <div class="row no-gutters bg-white">
        
                {{-- 50 - 50 column --}}
                <div class="col-lg-6 is-column {{ $section->image_position === 'right' ? 'order-lg-1' : '' }}">                    
                    <figure>                            
                        @if( $section->video_url )
                            <video playsinline="1" autoplay="1" muted="1" controls="1" loop="1"><source src="{{ $section->video_url }}" type="video/mp4">Your browser does not support the video tag.</video>
                        @elseif( $section->image )
                            {!! $section->image !!}
                        @endif
                    </figure>                    
                </div>
                {{-- 50 - 50 column --}}
        
                {{-- 50 - 50 column --}}
                <div class="col-lg-6 is-column {{ $section->image_position === 'right' ? 'order-lg-0' : '' }}">
                <div class="content-info d-flex justify-content-start flex-column">
                    @if ($section->title)
                        @if($section->is_h1)
                            <h1 class="h1 headtext">{!! $section->title !!}</h1>
                        @else
                            <h2 class="h1 headtext">{!! $section->title !!}</h2>
                        @endif                         
                    @endif

                    @if ($section->text)
                        <div class="h4 subtext">{!! $section->text !!}</div>
                    @endif
                     
                    @if ($section->link)
                        <div class="btn-container">
                            <a href="{{ $section->link->url ?? null }}" target="{{ $section->link->target ?? null }}">
                                <button type="button" class="btn btn-primary has-icon">{!! $section->link->title ?? null !!}</button>
                            </a>
                        </div>
                    @endif                    
                </div>
                </div>
                {{-- 50 - 50 column --}}
            </div>
        
        </div>
    </section>
    {{-- 50 - 50 section --}}
@endif

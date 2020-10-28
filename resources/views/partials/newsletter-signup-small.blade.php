<section id="section-{{ $section->id }}" class="section section-newsletter section-newsletter-small {{ $section->classes }}">
    <div class="container bg-white-xs">
        <div class="padding-ton bg-white">
            <div class="row no-gutters">
    
            {{-- newsletter h1 and small --}}
            <div class="col-lg-6">
                <div class="d-flex flex-column identifier justify-content-center">
                    {{-- newsletter h1 --}}
                    @if( $section->title )
                        <div class="h1">
                            {!! $section->title !!}
                        </div>
                    @endif
                {{-- newsletter h1 --}}
                {{-- newsletter small --}}
                <div class="d-lg-block d-none">
                    <a href="{{ $newsletter_info->info_link }}" target="_blank" rel="noreferrer nofollow" class="link-text has-icon">{!! $newsletter_info->info_title !!}</a>
                </div>
                {{-- newsletter small --}}
                </div>
            </div>
            {{-- newsletter --}}
    
            <div class="col-lg-6">
                <div class="widget-script">
                {{-- newsletter form --}}
                {!! $section->form_shortcode !!}
                {{-- newsletter form --}}
                {{-- newsletter small --}}
                <div class="d-lg-none d-block">
                    {{-- newsletter small --}}
                    <div class="d-lg-none d-block">
                    <a href="{{ $newsletter_info->info_link }}" target="_blank" rel="noreferrer nofollow" class="link-text has-icon">{!! $newsletter_info->info_title !!}</a>
                    </div>
                    {{-- newsletter small --}}
                </div>
                </div>
            </div>
            </div>
            {{-- newsletter small --}}
        </div>
    </div>
</section>
  
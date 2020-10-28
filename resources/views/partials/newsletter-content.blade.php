<div class="{{ $contentClass }}">
    {{-- Form content --}}
    <div class="newsletter-inner js-newsletter-content">
        @if ($section->title)
            @if(!empty($section->is_h1))
                <h1 class="newsletter-title h3 mb-0">{!! $section->title !!}</h1>
            @else
                <div class="newsletter-title">{!! $section->title !!}</div>
            @endif
        @endif

        @if ($section->text)
            <div class="newsletter-body">
                {!! $section->text !!}
            </div>
        @endif

        {{-- Newsletter form --}}
        @include( 'partials.newsletter-form')
    </div>

    {{-- Success --}}
    {{-- NOTE: This will only display if form data-success_type is set to "success-message" --}}
    <div class="newsletter-inner d-none js-newsletter-success">
        @if ($newsletter_data->form_settings->success_title)
            <div class="newsletter-title">{!! $newsletter_data->form_settings->success_title !!}</div>
        @endif

        @if ($newsletter_data->form_settings->success_content)
            <div class="newsletter-body">
                {!! $newsletter_data->form_settings->success_content !!}
            </div>
        @endif
    </div>
</div>

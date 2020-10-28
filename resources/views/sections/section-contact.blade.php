@if(($section->title && $section->show_section_title) || $section->text)
    <section class="section is-small-bottom section-half-text">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-6">
                    @if($section->title && $section->show_section_title)
                        <h2>{{ $section->title }}</h2>
                    @endif

                    @if($section->text)
                        <div class="lead">{{ $section->text }}</div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endif

<section class="section is-small-top section-triple-text">
  <div class="container">
    <div class="row">
      <div class="col-12 col-lg-3 triple-item">
        @if($section->first_number_title)
            <p class="title"><small>{{ $section->first_number_title }}</small></p>
        @endif

        @if($section->first_number)
            <h3 class="h1 m-0">{{ $section->first_number }}</h3>
        @endif

        @if($section->first_small_number)
            <small class="subtitle">{{ $section->first_small_number }}</small>
        @endif

        @if($section->first_email_title)
            <p class="mb-0">{{ $section->first_email_title }}</p>
        @endif

        @if($section->first_email)
            <p class="mb-0"><a class="mail" href="mailto:{{ $section->first_email }}" target="_top">{{ $section->first_email }}</a></p>
        @endif
      </div>
      <div class="col-12 col-lg-3 triple-item">
        @if($section->second_number_title)
            <p class="title"><small>{{ $section->second_number_title }}</small></p>
        @endif

        @if($section->second_number)
            <h3 class="h1 m-0">{{ $section->second_number }}</h3>
        @endif

        @if($section->second_small_number)
            <small class="subtitle">{{ $section->second_small_number }}</small>
        @endif

        @if($section->second_email_title)
            <p class="mb-0">{{ $section->second_email_title }}</p>
        @endif

        @if($section->second_field_type == 'link')
            @if($section->second_link)
                <p class="mb-0">
                    <a class="mail" href="{{ $section->second_link['url'] }}" target="{{ ($section->second_link['target'] == '_blank') ? '_blank' : '_top' }}">
                        {{ (!empty($section->second_link['title'])) ? $section->second_link['title'] : $section->second_link['url'] }}
                    </a>
                </p>
            @endif
        @else
            @if($section->second_email)
                <p class="mb-0"><a class="mail" href="mailto:{{ $section->second_email }}" target="_top">{{ $section->second_email }}</a></p>
            @endif
        @endif
      </div>
      <div class="col-12 col-lg-6 triple-item">
        @if($section->third_title)
            <p class="title"><small>{{ $section->third_title }}</small></p>
        @endif

        @if($section->third_text)
            <p class="description">{{ $section->third_text }}</p>
        @endif

        @if($section->button_text)
            <button type="button" class="btn btn-secondary has-icon js-show-contact">{!! $section->button_text !!}</button>
        @endif
      </div>
    </div>
  </div>
</section>

@if( $section->form_shortcode )
    {{-- Contact Form 7--}}
    <section class="section section-contact is-small-top">
        <div class="container">
            {!! do_shortcode( $section->form_shortcode ) !!}
        </div>
    </section>
@endif
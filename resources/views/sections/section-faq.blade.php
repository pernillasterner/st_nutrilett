{{-- figure and content-info are interchangeable whether its left or right --}}
<section id="section-{{ $section->id }}" class="section section-fifty-fifty section-faq-module {{ $section->classes }}">
  <div class="container bg-white-xs">
    <div class="row no-gutters bg-white">
      <div class="col-lg-6 is-column d-none d-lg-block">
        @if($section->image)
          <figure>
            {!! $section->image !!}
          </figure>
        @endif
      </div>

      <div class="col-lg-6 is-column">
        <div class="content-info d-flex justify-content-start flex-column">
          @if($section->title && $section->show_section_title)
            <h2 class="h1 headtext">{{ $section->title }}</h2>
          @endif

          <div class="accordion panel">
            @if($section->faqs)
              @foreach($section->faqs as $item)
                @if(isset($item['list']->ID) && isset($item['list']->post_title))
                  <div class="accordion-item">
                    <div class="accordion-item-header">
                      <a href="{{ $section->faq_page }}#faq{{ $item['list']->ID }}" class="link-text has-icon">{{ $item['list']->post_title }}</a>
                    </div>
                  </div>
                @endif
              @endforeach
            @endif
          </div>
          <div class="btn-container">
            <a href="{{ $section->faq_page }}">
              <button type="button" class="btn btn-primary has-icon d-none d-lg-inline">{!! $section->link_text !!}</button>
            </a>
            <a href="{{ $section->faq_page }}" class="link-text has-icon d-block d-lg-none">{!! $section->mobile_link_text ?: $section->link_text !!}</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section id="section-{{ $section->id }}" class="hero fifty-fifty {{ $section->classes ?? '' }}">
  <div class="section bg-tertiary">
    <div class="container info-image d-flex">
      <div class="row info-wrap align-self-center">
        <div class="col-md-12 col-lg-6 col-xl-6">
          <div class="info">
            <h2 class="h4">
                @if($section->show_title)
                    {{ $section->title }}
                @endif
            </h2>

            <div class="description">
                @if($section->text)
                    <p>{!! $section->text !!}</p>
                @endif
              <p></p>
            </div>
          </div>
        </div>
        <div class="col-md-12 col-lg-6 col-xl-6">
          <figure>
            {!! $section->image !!}
          </figure>
        </div>
      </div>
    </div>
  </div>
</section>

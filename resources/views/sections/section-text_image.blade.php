{{-- Add .has-icon-menu in <section> if icon menu is present --}}
<section id="section-{{ $section->id }}" class="hero {{ $section->classes ?? '' }}">
    <div class="section {{ ($section->id == 1) ? 'has-hero' : '' }} bg-secondary">
        <div class="container info-image d-flex">
            <div class="row info-wrap align-self-center">
                <div class="col-md-8 col-lg-7 col-xl-6">
                    <div class="info">
                        <div class="small pre-title">
                          @if($section->show_title)
                            {{ $section->title }}
                          @endif
                        </div>

                        @if($section->is_h1)
                          <h1 class='h1'>{!! $section->big_title !!}</h1>
                        @else
                          <h2 class='h1'>{!! $section->big_title !!}</h2>
                        @endif

                        <div class="description">
                            @if($section->text)
                              <p>{!! $section->text !!}</p>
                            @endif
                        </div>

                        @if($section->bullet_list)
                        <ul class="info-list">
                            @foreach($section->bullet_list as $item)
                              <li>
                                  <div class="icon">@include('icons.check')</div>
                                  <small class="detail">{!! $item['item'] !!}</small>
                              </li>
                            @endforeach
                        </ul>
                        @endif

                        @if($section->link)
                          <a href="{{ $section->link->url }}" target="{{ $section->link->target }}" class="link-text has-icon">{!! $section->link->title !!}</a>
                        @endif
                    </div>
                </div>
            </div>
            {!! $section->image !!}
        </div>
    </div>
</section>
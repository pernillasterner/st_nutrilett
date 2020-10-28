 <!-- add class .has-icon-menu if there is a partials icon-menu -->
<section id="section-{{ $section->id }}" class="hero has-icon-menu {{ $section->classes ?? '' }}">
    <div class="section {{ ($section->id == 1) ? 'has-hero' : '' }}  bg-secondary">
        <div class="container info-image d-flex">
            <div class="row info-wrap align-self-center">
                <div class="col-md-8 col-lg-7 col-xl-6">
                    <div class="info">
                        {{-- Title --}}
                        @if($section->show_title)
                            @if($section->is_h1)
                                <h1 class='h1 hero-title'>{!! $section->title !!}</h1>
                            @else
                                <h2 class='h1 hero-title'>{!! $section->title !!}</h2>
                            @endif
                        @endif
                        <div class="info-btns">
                            {{-- Scroll to section link --}}
                            @if($section->section_link)
                              <div class="info-btn">
                                  <a href="#" class="btn btn-outline-primary has-icon js-scroll-to" data-target="{{ $section->section_link['target'] }}">{!! $section->section_link['text'] !!}</a>
                              </div>
                            @endif
                            {{-- Link to other page --}}
                            @if($section->link)
                            <div class="info-btn">
                                <a href="{{ $section->link->url }}" target="{{ $section->link->target }}" class="link-text has-icon js-section-link">{!! $section->link->title !!}</a>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            {!! $section->image !!}
            {{-- <img class="image d-none d-md-block" src="@asset('images/temp/block_hero_1.png')" alt=""> --}}
        </div>
    </div>
    @if($section->icon_links)
    <div class="icon-menu">
      <div class="container">
        <ul class="list-unstyled mb-0">
            @foreach($section->icon_links as $item)
                <li class="item">
                    <a href="{{ $item['url'] }}" class="link-text has-icon">
                        <div class="icon">
                            {{-- Normal icon --}}
                            {!! $item['icon'] !!}
                            {{-- Hover icon --}}
                            {!! $item['hover_state_icon'] !!}
                            {{-- <img class="default-image" src="@asset('images/icon/white/chocolate-white.svg')">
                            <img class="hover-image" src="@asset('images/icon/black/chocolate-black.svg')"> --}}
                          </div>
                          {{-- Link name --}}
                          <p class="label"><small>{!! $item['text'] !!}</small></p>
                    </a>
                </li>
            @endforeach
        </ul>
      </div>
    </div>
    @endif
</section>

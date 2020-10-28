{{-- @if ($footer_breadcrumbs)
<section class="section d-lg-none d-inline-block mb-0 w-100">
  <div class="container">
    <div class="row">
      <div class="col-12">
        {!! $footer_breadcrumbs !!}
      </div>
    </div>
  </div>
</section>
@endif --}}

<footer class="footer-info">

  <div class="container">
    <div class="row">
      <div class="col-lg-6 order-1 order-lg-0">

        @if($footer_data->newsletter_title)
          <div class="form-title small">{!! $footer_data->newsletter_title !!}</div>
        @endif

        {{-- CONTACT FORM TEMPLATE
        <div class="form-group">
            <div class="input-group mb-3">
                <!--input type="text" class="form-control" placeholder="Din e-post" aria-label="Din e-post" aria-describedby="basic-addon2"-->
                [email* email-741 class:form-control placeholder "Din e-post"]
                <div class="input-group-append">
                    <!--button class="btn btn-primary" type="button">send</button-->
                    [submit class:btn class:btn-primary]
                </div>
            </div>
            <a href="#" class="link-text is-small has-icon is-white">Om Orklas behandling av personopplysninger</a>
        </div>
        --}}

        @if($footer_data->newsletter_shortcode)
          {!! $footer_data->newsletter_shortcode !!}
        @endif

        <a href="{{ $newsletter_info->info_link }}" target="_blank" rel="nofollow noreferrer" class="link-text is-small has-icon is-white">{!! $newsletter_info->info_title !!}</a>
      </div>
      <div class="col-lg-6 order-0 order-lg-1 mb-lg-0 mb-4">
        <div class="row">

          @if($desktop_footer_menu)
            @foreach($desktop_footer_menu as $key => $menu)
              <div class="col-md-4">
                <div class="menu-title">
                  <a {{ $menu->isLink ? 'href=' . $menu->url : '' }}>{!! $menu->title !!}</a>
                </div>
                <div class="menu-list d-none d-md-block">
                  <ul class="small">
                    @foreach($menu->children as $childMenu)
                      <li><a {{ $childMenu->isLink ? 'href=' . $childMenu->url : '' }}>{!! $childMenu->title !!}</a></li>
                    @endforeach
                    
                    {{-- static klarna image --}}
                    @if(empty($key))
                      <li>
                        <img src="https://x.klarnacdn.net/payment-method/assets/badges/generic/white/klarna.svg" alt="">
                      </li>
                    @endif
                    {{-- static klarna image --}}
                  </ul>
                </div>
              </div>
            @endforeach
          @endif

        </div>
      </div>
    </div>

    {{-- footer logo --}}
    @if($logo->light)
      <a href="{{ $home_url }}" class="footer-logo">{!! $logo->light !!}</a>
    @endif
    {{-- footer logo --}}

  </div>
</footer>

@include('partials.cookies')
@include('partials.newsletter-modal')

{{-- Footer Script from sitewide global --}}
{!! $scripts->footer_script ?? null !!}

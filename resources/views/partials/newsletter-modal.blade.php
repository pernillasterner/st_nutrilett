@if ($newsletter_data->form_shortcode)
    <div class="modal fade newsletter-popup" id="js-newsletter-popup" tabindex="-1" role="dialog" aria-labelledby="newsletter-popup" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    {{-- newsletter large section --}}
                    {{-- figure and content-info are interchangeable whether its left or right --}}
                    {{-- if the image was on right side, kindly add order-lg-0 to
                        the text container and add order-lg-1 for image container. See the example below --}}
                    <div class="section-newsletter section-newsletter-large section-newsletter-large-popup">
                    <div class="container">
                        <div class="row no-gutters bg-white">

                        {{-- newsletter large section  column --}}
                        <div class="col-lg-6 is-column order-lg-{{ $newsletter_data->image_position === 'right' ? '1' : '0' }}">
                            {{-- <div class="modal-close close" data-dismiss="modal">
                            @include('icons.cross')
                            </div> --}}
                            @if( $newsletter_data->image )
                                <figure>
                                    {!! $newsletter_data->image !!}
                                </figure>
                            @endif
                        </div>
                        {{-- newsletter large section  column --}}

                        {{-- newsletter large section  column --}}
                        <div class="col-lg-6 is-column order-lg-{{ $newsletter_data->image_position === 'right' ? '0' : '1' }}">
                          <div class="modal-close" data-dismiss="modal">@include('icons.cross')</div>
                            <div class="content-info d-flex justify-content-center flex-column">
                                @if( $newsletter_data->title )
                                    <div class="h1">
                                        {!! $newsletter_data->title !!}
                                    </div>
                                @endif

                                <div class="widget-script">
                                    {!! $newsletter_data->form_shortcode !!}

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
                    </div>
                    {{-- newsletter large section  section --}}
                </div>
            </div>
        </div>
    </div>
@endif


{{-- product status show static --}}
<div class="modal fade product-status show" id="js-product-status-popup" tabindex="-1" role="dialog" aria-labelledby="product-status-popup" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
          <div class="modal-body">
            {{-- add class modifier to product-status-container class like .success for sucess and .error for error --}}
            <div class="product-status-container success">
              <div class="modal-close" data-dismiss="modal">
                @include('icons.cross')
              </div>
              {{-- icon for success --}}
              <img class="product-status-icon-success" src="@asset('images/icon/success.svg')" alt="">
              {{-- icon for error --}}
              <img class="product-status-icon-error" src="@asset('images/icon/error.svg')" alt="">
              <div class="product-content">
                {{-- text for success --}}
                <p class="h2 mb-0 mt-0 p-success">Lagt til i handlekurven</p>
                {{-- text for error --}}
                <p class="h2 mb-0 mt-0 p-error">Lagt til i handlekurven</p>
              </div>
            </div>
          </div>
      </div>
  </div>
</div>
{{-- product status show static --}}

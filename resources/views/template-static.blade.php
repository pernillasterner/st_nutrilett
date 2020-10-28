{{--
   Template Name: Static Template
--}}

@extends('layouts.app')

@section('content')

{{-- fifty fifty --}}
@include('sections.section-fifty-fifty-static')

{{-- newsletter --}}
@include('sections.section-newsletter-small-static')

{{-- newsletter large --}}
@include('sections.section-newsletter-large-static')

{{-- featured article --}}
@include('sections.section-featured-article-static')

{{-- will power --}}
@include('sections.section-willpower-static')

{{-- this is only a sample section in order to show the modal --}}
<section class="section text-center">
  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#newsletter-popup">
    Launch demo modal
  </button>
  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#js-product-status-popup">
    Launch product status modal
  </button>
</section>

<!-- Modal -->
<div class="modal fade newsletter-popup" id="newsletter-popup" tabindex="-1" role="dialog"
  aria-labelledby="newsletter-popup" aria-hidden="true">
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
              <div class="col-lg-6 is-column order-lg-1">
                {{-- <div class="modal-close close" data-dismiss="modal">
                  @include('icons.cross')
                </div> --}}
                <figure>
                  <img src="@asset('images/temp/50_50_2.jpg')" alt="">
                </figure>
              </div>
              {{-- newsletter large section  column --}}

              {{-- newsletter large section  column --}}
              <div class="col-lg-6 is-column order-lg-0">
                <div class="content-info d-flex justify-content-center flex-column">
                  <div class="h1">
                    Meld deg på i dag – få tilbudet først
                  </div>

                  <div class="identifier">
                    <?php echo do_shortcode('[contact-form-7 id="1005" title="newsletter-popup"]'); ?>

                    <div>
                      <a href="#" class="link-text has-icon">Om Orklas behandling av personopplysninger</a>
                      <p class="smaller">
                        Jeg aksepterer herved at Nutrilett kan sende meg relevante tilbud og informasjon – også i
                        andre kanaler enn Nutriletts egne, og at e-postadressen jeg har oppgitt er min.
                        Opplysningene jeg gir vil ikke bli brukt til annet formål eller utlevert til andre selskap.
                        Jeg kan når som helst avregistrere meg.
                      </p>
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

{{-- <div class="modal fade review-modal" id="review-modal" tabindex="-1" role="dialog" aria-labelledby="review-modal"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="container">
          <div class="row no-gutters bg-white position-relative">
            <div class="modal-close" data-dismiss="modal">@include('icons.cross')</div>
            <div class="col-lg-6 review-image">
              <figure class="mb-0">
                <img class="img-fluid"
                  src="https://nutrilett.stokmedia.se/wp-content/uploads/2019/10/352795_352795_product-600x490.png"
                  alt="">
              </figure>
            </div>
            <div class="col-lg-12">
              <form id="js-review-form" class="rating-form">
                <h2 class="h2">NUTRILETT SALT CARAMEL CRUNCH 4-PACK X 10 - BUNDLE</h2>
                <div class="rating-content d-flex mb-3">
                  <span>Jag ska ge det</span>
                  <div class="rate mb-0 ml-3 js-rating-radio">
                    <div class="star-item d-inline-block">@include('icons.star')</div>
                    <div class="star-item d-inline-block">@include('icons.star')</div>
                    <div class="star-item d-inline-block">@include('icons.star')</div>
                    <div class="star-item d-inline-block">@include('icons.star')</div>
                    <div class="star-item d-inline-block">@include('icons.star')</div>
                  </div>
                </div>
                <div class="custom-control custom-checkbox mb-3">
                  <input type="checkbox" class="custom-control-input" name="recommend" id="recommended" value="1">
                  <label class="custom-control-label" for="recommended">Jag rekommenderar den här produkten</label>
                </div>
                <div class="row">
                  <div class="col-12 col-md-6">
                    <div class="form-group">
                      <input type="text" class="form-control" name="name" placeholder="Namn">
                    </div>
                  </div>
                  <div class="col-12 col-md-6">
                    <div class="form-group">
                      <input type="email" class="form-control" name="email" placeholder="Epost">
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="form-group">
                      <input type="text" class="form-control" name="title" placeholder="Title">
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="form-group">
                      <textarea class="form-control" name="review" cols="30" rows="7" placeholder="Recension"
                        spellcheck="false"></textarea>
                    </div>
                  </div>
                </div>
                <div class="custom-control custom-checkbox mb-5">
                  <input type="checkbox" class="custom-control-input" name="accept_terms" id="recommended2" value="1">
                  <label class="custom-control-label" for="recommended2">Du kan få e-post angående din inskickade
                    recension. All e-post innehåller möjligheten att välja bort framtida kommunikation.</label>
                </div>
                <button type="sybmit" class="btn btn-primary">Skicka</button>
                <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Avbryt</button>
                <input type="hidden" name="sku" value="">
                <input type="hidden" name="id" value="">
                <p id="js-message"></p>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div> --}}

{{-- faq module --}}
{{-- @include('sections.section-faq-module-static') --}}

{{-- Text + Image  --}}
{{-- @include('sections.section-text-image-static') --}}

{{-- Product Chooser --}}
@include('sections.section-product-chooser-static')

{{-- Half Text Component --}}
@include('partials.half-text-static')

{{-- Triple Text --}}
@include('sections.section-triple-text-static')

{{-- Contact --}}
@include('sections.section-contact-form7-static')

{{-- FAQ --}}
@include('sections.section-faq-static')

{{-- Popular Products --}}
@include('sections.section-popular-products-static')

{{-- Product Item --}}
@include('partials.product-item-static')

{{-- Product Page --}}
@include('sections.section-single-product-static')

{{-- Reviews --}}
@include('sections.section-reviews-static')

{{-- Icon --}}
@include('partials.icon-menu')

{{-- Cart --}}
@include('sections.section-cart-static')

@endsection

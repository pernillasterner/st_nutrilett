{{-- newsletter large section --}}
{{-- figure and content-info are interchangeable whether its left or right --}}
{{-- if the image was on right side, kindly add order-lg-0 to
            the text container and add order-lg-1 for image container. See the example below --}}
<section class="section section-newsletter section-newsletter-large">
  <div class="container bg-white-xs">
    <div class="row no-gutters bg-white">

      {{-- newsletter large section  column --}}
      <div class="col-lg-6 is-column order-lg-1">
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
            <?php echo do_shortcode('[contact-form-7 id="998" title="newsletter-large"]'); ?>

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
</section>
{{-- newsletter large section  section --}}

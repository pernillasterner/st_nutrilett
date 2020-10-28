{{--
  Template Name: Bootstrap Styleguide Template
--}}

@extends('layouts.app')

@section('content')
@while(have_posts()) @php the_post() @endphp
{{-- @include('partials.page-header') --}}

<div class="container">
  <h2>Typography</h2>
  <h6 class="h6">current font is nunito sans</h6>
  <hr>
  <h2 class="hero-title">.hero-title Nutrilett - smarte, lette måltider.</h2>
  <h2 class="section-title">.section-title Nutrilett - smarte, lette måltider.</h2>
  <hr>
  <h1 class="h1">h1 Nutrilett - smarte, lette måltider.</h1>
  <h2 class="h2">h2 Nutrilett - smarte, lette måltider.</h2>
  <h3 class="h3">h3 Nutrilett - smarte, lette måltider.</h3>
  <h4 class="h4">h4 Nutrilett - smarte, lette måltider.</h4>
  <h5 class="h5">h5 Nutrilett - smarte, lette måltider.</h5>
  <h6 class="h6">h6 Nutrilett - smarte, lette måltider.</h6>
  <hr>
  <div class="lead">Det er stadig flere som bytter over til et vegetarisk kosthold, men vet du hva alle de forskjellige benevnelsene betyr og hva som er forskjell på vegetarianere og veganere? Her kan du lese mer om de ulike typene innen vegetarisme, og hva man kan spise – samt tips til gode og inspirerende oppskrifter.</div>
  <p>Veganere sitt kosthold eksluderer alle animalske produkter, som kjøtt, fisk, skalldyr, egg, melk og honning, i tillegg kan veganisme sees på som en etisk livsstil hvor man utelater animalske produkter fra livet sitt så godt det lar seg gjøre. Det finnes flere grunner til at man velger å bli veganer, slik som for eksempel miljø, helse, religion, etikk, moral og økonomiske grunner – og alle disse begrunnelsene gjelder for alle de ulike typene du kan lese mer om nedenfor.</p>
  <p><small>Veganere sitt kosthold eksluderer alle animalske produkter, som kjøtt, fisk, skalldyr, egg, melk og honning, i tillegg kan veganisme sees på som en etisk livsstil hvor man utelater animalske produkter fra livet sitt så godt det lar seg gjøre. Det finnes flere grunner til at man velger å bli veganer, slik som for eksempel miljø, helse, religion, etikk, moral og økonomiske grunner – og alle disse begrunnelsene gjelder for alle de ulike typene du kan lese mer om nedenfor.</small></p>
  <h2>Buttons</h2>
  <hr>
  <button type="button" class="btn btn-primary">legg i handlekurv</button>
  <button type="button" class="btn btn-secondary">legg i handlekurv</button>
  <button type="button" class="btn btn-outline-primary">legg i handlekurv</button>
  <hr>
  <button type="button" class="btn btn-primary has-icon">legg i handlekurv</button>
  <button type="button" class="btn btn-secondary has-icon">legg i handlekurv</button>
  <button type="button" class="btn btn-outline-primary has-icon">legg i handlekurv</button>
  <hr>
  <button type="button" class="btn btn-primary has-icon left-icon">legg i handlekurv</button>
  <button type="button" class="btn btn-secondary has-icon left-icon">legg i handlekurv</button>
  <button type="button" class="btn btn-outline-primary has-icon left-icon">legg i handlekurv</button>
  <hr>
  <button type="button" class="btn btn-primary has-icon icon-check">legg i handlekurv</button>
  <button type="button" class="btn btn-secondary has-icon icon-check">legg i handlekurv</button>
  <button type="button" class="btn btn-outline-primary has-icon icon-check">legg i handlekurv</button>
  <hr>
  <button type="button" class="btn btn-primary has-icon icon-cross">legg i handlekurv</button>
  <button type="button" class="btn btn-secondary has-icon icon-cross">legg i handlekurv</button>
  <button type="button" class="btn btn-outline-primary has-icon icon-cross">legg i handlekurv</button>
  <hr>
  <button type="button" class="btn btn-primary has-icon icon-wand">legg i handlekurv</button>
  <button type="button" class="btn btn-secondary has-icon icon-wand">legg i handlekurv</button>
  <button type="button" class="btn btn-outline-primary has-icon icon-wand">legg i handlekurv</button>
  <hr>
  <a href="#" class="link-text has-icon">legg i handlekurv</a>
  <br/>
  <a href="#" class="link-text is-small has-icon">legg i handlekurv</a>
  <div style="padding: 20px; background-color: green">
    <a href="#" class="link-text is-small has-icon is-white">legg i handlekurv</a>
  </div>
  <hr>
  <h2>Buttons</h2>
  <div class="row">
    <div class="col-md-4">
      <div class="mb-3">
        <input type="text" class="form-control" placeholder="Din e-post">
      </div>
      <div class="input-group mb-3">
        <input type="text" class="form-control" placeholder="Recipient's username" aria-label="Recipient's username" aria-describedby="basic-addon2">
        <div class="input-group-append">
          <button class="btn btn-primary" type="button">send</button>
        </div>
      </div>
    </div>
  </div>
  <h2>Contact 7</h2>
  <?php echo do_shortcode('[contact-form-7 id="991" title="Contact form 1"]'); ?>
  <?php echo do_shortcode('[contact-form-7 id="997" title="contact form inline"]'); ?>


  <div class="custom-control custom-checkbox">
    <input type="checkbox" class="custom-control-input" id="aaa">
    <label class="custom-control-label" for="aaa">Normal</label>
  </div>
  <div class="custom-control custom-checkbox">
    <input type="checkbox" class="custom-control-input" id="asdf" checked>
    <label class="custom-control-label" for="asdf">Selected</label>
  </div>

  <div class="custom-control custom-radio custom-control-inline">
    <input type="radio" class="custom-control-input" id="customRadio" name="example" value="customEx">
    <label class="custom-control-label" for="customRadio">Kvinne</label>
  </div>
  <div class="custom-control custom-radio custom-control-inline">
    <input type="radio" class="custom-control-input" id="customRadio1" name="example" value="customEx">
    <label class="custom-control-label" for="customRadio1">Kvinne</label>
  </div>
  <select name="cars" class="custom-select">
    <option selected>Custom Select Menu</option>
    <option value="volvo">Volvo</option>
    <option value="fiat">Fiat</option>
    <option value="audi">Audi</option>
  </select>
</div>

@include('partials.content-page')
@endwhile
@endsection

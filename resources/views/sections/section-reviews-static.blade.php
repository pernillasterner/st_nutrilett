{{-- Reviews  --}}
<section class="section section-reviews">
  <div class="review-content">
    <div class="container">
      <div class="review-head">
        <div class="row align-items-baseline">
          <div class="col-sm-6 d-flex align-items-baseline justify-content-between justify-content-sm-start">
            <h2 class="h1 mb-0 review-label">Reviews</h2>
            <div class="h6 mb-0 review-count">(11 reviews)</div>
          </div>
          <div class="col-sm-6 text-sm-right">
            <a href="#" class="link-text js-toggle-review-form toggle-review-form">Skriv en anmeldelse</a>
          </div>
        </div>
      </div>
      <div class="review-form">
        <form id="js-review-form" class="rating-form">
          <div class="rating-content d-flex mb-4 align-items-center justify-content-between">
            <div class="d-flex align-items-center">
              <span class="rating-title">Din vurdering</span>
              <div class="rate mb-0 ml-3 js-rating-radio">
                <div class="star-item d-inline-block">@include('icons.star')</div>
                <div class="star-item d-inline-block">@include('icons.star')</div>
                <div class="star-item d-inline-block">@include('icons.star')</div>
                <div class="star-item d-inline-block">@include('icons.star')</div>
                <div class="star-item d-inline-block">@include('icons.star')</div>
                <div class="radio-stars d-none">
                    <input type="radio" name="rating" value="1">
                    <input type="radio" name="rating" value="2">
                    <input type="radio" name="rating" value="3">
                    <input type="radio" name="rating" value="4">
                    <input type="radio" name="rating" value="5">
                </div>
              </div>
            </div>
            <div>
              <a href="#" class="link-text js-toggle-review-form toggle-review-form">Avbryt</a>
            </div>
          </div>
          <div class="custom-control custom-checkbox mb-4">
            <input type="checkbox" class="custom-control-input" name="recommend" id="recommended" value="1">
            <label class="custom-control-label custom-control-recommended" for="recommended">Ville du ha anbefalt dette
              produktet til en venn? </label>
          </div>
          <div class="row">
            <div class="col-12 col-md-6">
              <div class="form-group">
                <input type="text" class="form-control" name="Tittel" placeholder="Tittel">
              </div>
            </div>
            <div class="col-12 col-md-6">
              <div class="form-group">
                <input type="email" class="form-control" name="email" placeholder="E-post">
              </div>
            </div>
            <div class="col-12">
              <div class="form-group text-area-form">
                <textarea class="form-control" name="review" cols="30" rows="7" placeholder="Produktanmeldelser*"
                  spellcheck="false"></textarea>
              </div>
            </div>
          </div>
          <div class="custom-control custom-checkbox mb-5">
            <input type="checkbox" class="custom-control-input" name="accept_terms" id="recommended2" value="1">
            <label class="custom-control-label" for="recommended2">Du vil kunne motta e-poster i forbindelse med denne
              anmeldelsen (f.eks. om andre kommenterer din anmeldelse). Alle e-poster inneholder mulighet for avmelding.
              Nutrilett kan bruke teksten og stjernerangeringen fra anmeldelsen din i øvrig markedsføring.</label>
          </div>
          <button type="submit" class="btn btn-secondary has-icon text-center">Send vurdering</button>
        </form>
      </div>
      <div class="review-items">
        <div class="review-item">
          <div class="review-header">
            <div class="review-meta">
              <div class="review-person">
                <div class="name small">Erling A Erling A Erling A Erling A</div>
                {{-- <small class="location">Oslo, NO </small> --}}
              </div>
              <div class="review-rate">
                <div class="icon-fill">@include('icons.star')</div>
                <div class="icon-fill">@include('icons.star')</div>
                @include('icons.star')
                @include('icons.star')
                @include('icons.star')
              </div>
            </div>
            <div class="review-recommended">
              <div class="icon">@include('icons.check')</div>
              <small class="detail">ANbefales</small>
            </div>
          </div>
          <p class="description">Kan inneholde spor av hvete, egg, nøtter (val-, cashew-, pecan-, para-, macadamia-,
            hassel-, pistasjenøtt
            og mandel), peanøtter og sesamfrø.</p>
          <p class="help">Var dette til hjelp?</p>
          <button type="button" class="btn btn-secondary has-icon icon-check">JA (9)</button>
          <button type="button" class="btn btn-secondary has-icon icon-cross">NEI (2)</button>
        </div>
        <div class="review-item">
          <div class="review-header">
            <div class="review-meta">
              <div class="review-person">
                <div class="name small">Erling A.</div>
                {{-- <small class="location">Oslo, NO </small> --}}
              </div>
              <div class="review-rate">
                <div class="icon-fill">@include('icons.star')</div>
                <div class="icon-fill">@include('icons.star')</div>
                <div class="icon-fill">@include('icons.star')</div>
                <div class="icon-fill">@include('icons.star')</div>
                <div class="icon-fill">@include('icons.star')</div>
              </div>
            </div>
            <div class="review-recommended">
              <div class="icon">@include('icons.check')</div>
              <small class="detail">ANbefales</small>
            </div>
          </div>
          <p class="description">Kan inneholde spor av hvete, egg, nøtter (val-, cashew-, pecan-, para-, macadamia-,
            hassel-, pistasjenøtt
            og mandel), peanøtter og sesamfrø.</p>
          <p class="help">Var dette til hjelp?</p>
          <button type="button" class="btn btn-secondary has-icon icon-check">JA (9)</button>
          <button type="button" class="btn btn-secondary has-icon icon-cross">NEI (2)</button>
        </div>
        <div class="review-item">
          <div class="review-header">
            <div class="review-meta">
              <div class="review-person">
                <div class="name small">Erling A.</div>
                {{-- <small class="location">Oslo, NO </small> --}}
              </div>
              <div class="review-rate">
                <div class="icon-fill">@include('icons.star')</div>
                <div class="icon-fill">@include('icons.star')</div>
                <div class="icon-fill">@include('icons.star')</div>
                @include('icons.star')
                @include('icons.star')
              </div>
            </div>
            <div class="review-recommended">
              <div class="icon">@include('icons.check')</div>
              <small class="detail">ANbefales</small>
            </div>
          </div>
          <p class="description">Kan inneholde spor av hvete, egg, nøtter (val-, cashew-, pecan-, para-, macadamia-,
            hassel-, pistasjenøtt
            og mandel), peanøtter og sesamfrø.</p>
          <p class="help">Var dette til hjelp?</p>
          <button type="button" class="btn btn-secondary has-icon icon-check">JA (9)</button>
          <button type="button" class="btn btn-secondary has-icon icon-cross">NEI (2)</button>
        </div>
      </div>
    </div>
  </div>
</section>

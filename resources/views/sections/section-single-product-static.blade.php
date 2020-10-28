<section class="section section-product-page has-breadcrumbs">
  <div class="container js-container-product">
    <div class="row">
      <div class="col-lg-5">
        {{-- MOBILE --}}
        <div class="prod-item d-block d-lg-none">
          <div class="js-product-slider product-slider">
            @for ($i = 0; $i <= 3; $i++) <div class="carousel-cell mobile-product-item">
              <div class="feature">
                <div class="sale">99%</div>
                <div class="image-block">
                  <a href="#" class="image">
                    <img class="img-product" src="@asset('images/temp/product_sample_6.png')" alt="">
                  </a>
                </div>
                <div class="bundle">
                  <div class="bundle-list">
                    <div class="bundle-item">
                      <input type="radio" name="bundle" id="b-01" value="4" />
                      <label for="b-01">4</label>
                    </div>
                    <div class="bundle-item">
                      <input type="radio" name="bundle" id="b-02" value="12" checked />
                      <label for="b-02">12</label>
                    </div>
                    <div class="bundle-item">
                      <input type="radio" name="bundle" id="b-03" value="24" />
                      <label for="b-03">24</label>
                    </div>
                    <div class="bundle-item">
                      <input type="radio" name="bundle" id="b-04" value="40" />
                      <label for="b-04">40</label>
                    </div>
                  </div>
                  <div class="bundle-title">Velg antall</div>
                </div>
              </div>
          </div>
          @endfor
        </div>
        <p class="text-center js-carousel-status carousel-status"></p>
      </div>
      {{-- DESKTOP --}}
      <div class="d-none d-lg-block" id="js-product-sidebar">
        <div class="product-sidebar bg-white">
          <div class="js-product-slider product-slider">
            @for ($i = 0; $i <= 3; $i++) <div class="carousel-cell product-image">
              <div class="wrapper">
                <div class="sale">99%</div>
                <div class="image-block">
                  <div class="image">
                    <img class="img-product" src="@asset('images/temp/product_slider_1.png')" alt="">
                  </div>
                </div>
              </div>
          </div>
          @endfor
        </div>
        <p class="text-center js-carousel-status carousel-status"></p>
      </div>
    </div>
  </div>
  <div class="col-lg-7 product-details">
    <div class="d-flex justify-content-between align-items-center">
      <div class="rating-info">
        <div class="rate mb-3">
            <div class="icon-fill">@include('icons.star')</div>
            <div class="icon-fill">@include('icons.star')</div>
            <div class="icon-fill">@include('icons.star')</div>
            <div class="d-inline-block">@include('icons.star')</div>
            <div class="d-inline-block">@include('icons.star')</div>
          </div>
        {{-- <p class="mb-0"> 0 av 5</p> --}}
      </div>
      {{-- <div class="text-right">
        <a href="#" class="link-text has-icon d-block mb-3">0 röster</a>
        <a href="#" class="link-text has-icon d-block" data-toggle="modal" data-target="#review-modal">Write a review</a>
      </div> --}}
    </div>
    <div class="product-title d-flex justify-content-between">
      {{-- Add discount price --}}
      <h1 class="h1">Toffie Fudge</h1>
      <div class="price">
        <div class="old-price h4">kr 219</div>
        <div class="h1 d-inline-block">kr 229</div>
      </div>
    </div>
    <div class="description">
      <p>Nutrilett Toffee Fudge har en deilig smak av karamell og er perfekt om du har lyst på noe
        godt. Toffee Fudge
        er en sjokoladebar som kan brukes til å erstatte små mellommåltider, samtidig som den har lavt sukkerinnhold.
      </p>
    </div>
    <div class="row product-meta">
      <div class="col-lg-6 d-none d-lg-block">
        <p class="product-option">Hvor mange bars?</p>
        <div class="bundle">
          <div class="bundle-list">
            <div class="bundle-item">
              <input type="radio" name="bundle" id="b-01" value="8">
              <label for="b-01">8</label>
            </div>
            <div class="bundle-item">
              <input type="radio" name="bundle" id="b-02" value="12" checked="">
              <label for="b-02">12</label>
            </div>
            <div class="bundle-item">
              <input type="radio" name="bundle" id="b-03" value="24">
              <label for="b-03">24</label>
            </div>
            <div class="bundle-item">
              <input type="radio" name="bundle" id="b-04" value="40">
              <label for="b-04">40</label>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <p class="product-option">Whats your flava?</p>
        <select name="flava" class="custom-select">
          <option selected="">Toffie Fudge</option>
          <option value="">Toffie Fudge</option>
          <option value="">Toffie Fudge</option>
          <option value="">Toffie Fudge</option>
        </select>
      </div>
    </div>
    <button type="button" class="btn btn-secondary has-icon">legg i handlekurv</button>
    <div id="product-accordion" class="accordion">
      <div class="card mb-0">
        <div class="card-header collapsed" data-toggle="collapse" href="#innhold" aria-expanded="false">
          <a class="card-title text-uppercase">
            Innhold
            <div class="arrow">
              <span class="arrow-icon"></span>
            </div>
          </a>
        </div>
        <div id="innhold" class="card-body collapse" data-parent="#product-accordion">
          <div class="editor-output">
            <p><small>Kan inneholde spor av hvete, egg, nøtter (val-, cashew-, pecan-, para-, macadamia-, hassel-,
                pistasjenøtt og mandel), peanøtter og sesamfrø.</small></p>
          </div>
        </div>
      </div>
      <div class="card mb-0">
        <div class="card-header collapsed" data-toggle="collapse" href="#næringsinnhold" aria-expanded="false">
          <a class="card-title text-uppercase">
            næringsinnhold
            <div class="arrow">
              <span class="arrow-icon"></span>
            </div>
          </a>
        </div>
        <div id="næringsinnhold" class="card-body collapse" data-parent="#product-accordion">
          <div class="editor-output">
            <div class="info-list">
              <div class="tabulation">
                <div class="tabulation-row">
                  <div class="tabulation-header">Næringsinnhold</div>
                  <div class="tabulation-info">40 gram pr stk.</div>
                </div>
                <div class="tabulation-row">
                  <div class="tabulation-header">Energi</div>
                  <div class="tabulation-info">520 kJ/125 kcal</div>
                </div>
                <div class="tabulation-row">
                  <div class="tabulation-header">Fett</div>
                  <div class="tabulation-info">4,5 gram</div>
                </div>
                <div class="tabulation-row">
                  <div class="tabulation-header">herav</div>
                  <div class="tabulation-info"></div>
                </div>
                <div class="tabulation-row">
                  <div class="tabulation-header">Mettet fett</div>
                  <div class="tabulation-info">2,4 gram</div>
                </div>
                <div class="tabulation-row">
                  <div class="tabulation-header">Karbohydrater</div>
                  <div class="tabulation-info">12,4 gram</div>
                </div>
                <div class="tabulation-row">
                  <div class="tabulation-header">herav</div>
                  <div class="tabulation-info"></div>
                </div>
                <div class="tabulation-row">
                  <div class="tabulation-header">Sukkerarter</div>
                  <div class="tabulation-info">1,8 gram</div>
                </div>
                <div class="tabulation-row">
                  <div class="tabulation-header">Fiber</div>
                  <div class="tabulation-info">8,4 gram</div>
                </div>
                <div class="tabulation-row">
                  <div class="tabulation-header">Protein</div>
                  <div class="tabulation-info">9,2 gram</div>
                </div>
                <div class="tabulation-row">
                  <div class="tabulation-header">Salt</div>
                  <div class="tabulation-info">0,31 gram</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="card mb-0">
        <div class="card-header collapsed" data-toggle="collapse" href="#Ingredienser" aria-expanded="false">
          <a class="card-title text-uppercase">
            Ingredienser
            <div class="arrow">
              <span class="arrow-icon"></span>
            </div>
          </a>
        </div>
        <div id="Ingredienser" class="card-body collapse" data-parent="#product-accordion">
          <div class="editor-output">
            <p><small>Melkesjokolade - og karamellbar. 40 g. Inneholder søtningsmiddel. Overdrevet inntak kan ha
                avførende effekt. Mjelkesjokolade med søtningsmiddel (22,5 %) (søtningsmiddel (maltitol), kakaosmør,
                helmelk/melkepulver, kakaomasse, emulgeringsmiddel (sojalecitin) arom(a)er), karamell (22,5%)
                (fyllmiddel (polydextros), sojaolje, skummet melk/ melkepulver, søtningsmiddel (xylitol), arom(a)er,
                emulgeringsmedel (sojalecitin), salt, søtningsmiddel (sukralos)), melkeprotein, fuktighetsbevarende
                middel (glycerol), fyllmiddel (polydextros), gelatinhydrolysat, søtningsmiddel (erytritol),
                fettredusert kakao (1,3%), sojaprotein, kakaomasse, salt, arom(a)er, søtningsmiddel (sukralos). Kan
                inneholde spor av hvete, egg, peanøtter, nøtter (val-, cashew-, pecan-, hassel-, macadamia-, para-,
                pistasjenøtt og, mandel) og sesamfrø. </small></p>
          </div>
        </div>
      </div>
      <div class="card mb-0">
        <div class="card-header collapsed" data-toggle="collapse" href="#downloads" aria-expanded="false">
          <a class="card-title text-uppercase">
            downloads
            <div class="arrow">
              <span class="arrow-icon"></span>
            </div>
          </a>
        </div>
        <div id="downloads" class="card-body collapse" data-parent="#product-accordion">
          <ul class="list-unstyled download-items">
            <li class="download-item">
              <p class="mb-0">
                <a href="#"> <span class="icon">@include('icons.download')</span>Nutrienter.pdf</a>
              </p>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  </div>
  </div>
</section>

<section class="section section-cart">
  <div class="container">
    <h2 class="h2">1. Se over din bestilling </h2>
    <div class="cart bg-white">
      <div class="cart-group">
        <div class="cart-list">
          {{-- HEADER --}}
          <div class="cart-item cart-item-header d-none d-lg-flex justify-content-between">
            <div class="cart-start d-md-flex justify-content-between">
              <div class="cart-header">Produktnavn</div>
              <div class="cart-header quantity">Antall </div>
            </div>
            <div class="cart-end d-flex flex-md-row justify-content-end">
              <div class="price">
                <div class="cart-header cart-header-sum">Sum</div>
              </div>
            </div>
          </div>
        @for ($i = 0; $i <= 2; $i++)
          <div class="cart-item d-flex justify-content-between">
            <div class="cart-start d-md-flex">
              <a href="#" class="align-self-center">
                <figure class="image d-none d-lg-block">
                  <img src="@asset('images/temp/cart/cart-01.jpg')" alt="" />
                </figure>
              </a>
              <div class="info align-self-center">
                <div class="rate">
                  <div class="icon-fill">@include('icons.star')</div>
                  <div class="icon-fill">@include('icons.star')</div>
                  <div class="icon-fill">@include('icons.star')</div>
                  @include('icons.star')
                  @include('icons.star')
                </div>
                <a href="#" class="name">Toffie Fudge {{$i}}</a>
              </div>
              <div class="quantity d-flex align-self-center align-items-center ml-auto">
                <button class="q-control">-</button>
                <input type="text" class="form-control" placeholder="1">
                <button class="q-control">+</button>
              </div>
            </div>
            <div
              class="cart-end d-flex flex-column flex-md-row align-self-md-center align-items-end align-items-md-center justify-content-md-end">
              <div class="price">kr 179</div>
              <button class="delete-btn d-flex align-items-center">
                <div class="close-text small">Fjern</div>
                @include('icons.cross')
              </button>
            </div>
          </div>
        @endfor
        <div class="cart-item d-flex justify-content-between">
          <div class="cart-start d-md-flex">
            <a href="#" class="align-self-center">
              <figure class="image d-none d-lg-block">
                <img src="@asset('images/temp/cart/cart-01.jpg')" alt="" />
              </figure>
            </a>
            <div class="info align-self-center">
              <div class="rate">
                <div class="icon-fill">@include('icons.star')</div>
                <div class="icon-fill">@include('icons.star')</div>
                <div class="icon-fill">@include('icons.star')</div>
                @include('icons.star')
                @include('icons.star')
              </div>
              <a href="#" class="name">Chocolate berry</a>
            </div>
            <div class="quantity d-flex align-self-center align-items-center ml-auto">
              <button class="q-control">-</button>
              <input type="text" class="form-control" placeholder="1">
              <button class="q-control">+</button>
            </div>
          </div>
          <div
            class="cart-end d-flex flex-column flex-md-row align-self-md-center align-items-end align-items-md-center justify-content-md-end">
            <div class="price">
              <div class="old-price">kr 1279 </div>
              <span class="original-price">kr 1179</span>
            </div>
            <button class="delete-btn d-flex align-items-center">
              <div class="close-text small">Fjern</div>
              @include('icons.cross')
            </button>
          </div>
        </div>
      </div>
      <div class="cart-meta">
        <div class="amount">
          <div class="cart-meta-item d-flex justify-content-between align-items-center">
            {{-- add class .with-postnord to .guide-text --}}
            <div class="guide-text with-postnord">
              <p class="mb-0">Frakt (Norge)</p>
              {{-- <div class="postnord">
                <img src="@asset('images/icon/logo/pn_color_rgb.png')" alt="">
                <p>3-4 virkedager</p>
              </div> --}}
              <img src="@asset('images/icon/logo/pn_color_rgb.png')" alt="">
              <p class="postnord-text">3-4 virkedager</p>
            </div>
            {{-- add class .with-postnord to .guide-text --}}
            <div class="lead mb-0">kr 0</div>
          </div>
          <div class="cart-meta-item d-flex justify-content-between align-items-center">
            <div class="guide-text">
              <p class="mb-0">Moms (MVA)</p>
            </div>
            <div class="lead mb-0">kr 375</div>
          </div>
          <div class="cart-meta-item d-flex justify-content-between align-items-center">
            <div class="guide-text">
              <p class="mb-0">Å betale (inkl moms & levering)</p>
            </div>
            <div class="lead mb-0">kr 1500</div>
          </div>
        </div>
        <div class="row align-items-center">
          <div class="col-lg-6">
            <div class="custom-control custom-checkbox first-checkbox">
                  <input type="checkbox" class="custom-control-input" id="voucher">
                  <label class="custom-control-label" for="voucher">Jeg har en rabattkode</label>
                </div>
            </div>
          <div class="col-lg-6">
            <div class="input-group js-vouher-input mb-3 d-none">
                <input type="text" class="form-control" placeholder="">
                <div class="input-group-append">
                  <button class="btn btn-primary" type="button">Lägg till</button>
                </div>
              </div>
          </div>
        </div>
        <div class="custom-control custom-checkbox second-checkbox">
          <input type="checkbox" class="custom-control-input" id="test2">
          <label class="custom-control-label" for="test2">Nyhetsbrev: Ønsker du å få eksklusive tilbud og informasjon om
            produkter fra Orkla? Meld deg på nyhetsbrevet vårt, så er du blant de første som får tilsendt dette. <a
              href="#">Mer informasjon finner du her.</a></label>
        </div>
      </div>
    </div>
    {{-- NO CART ITEM --}}
    <div class="text-center p-5">
      <h2 class="h2">No Item(s) Added</h2>
      <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
    </div>
  </div>
  </div>
</section>

<section class="section">
    <div class="container">
      <h2 class="h2">2. Fullfør kjøpet raskt og smidig </h2>
      <div class="bg-white" style="height: 100vh;"></div>
    </div>
  </section>

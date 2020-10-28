<section class="section section-product-lists">
  <div class="container">
    <div class="title-header d-flex justify-content-between">
      <h2 class="h2 is-small-mob align-self-center">Produkter for dine behov</h2>
      <div class="link-block align-self-center">
        <a href="#" class="link-text has-icon">
          <div class="d-none d-md-block">Se alle produkter</div>
          <div class="d-block d-md-none">Se alle</div>
        </a>
      </div>
    </div>
  </div>

  <div class="container">
    <div class="product-lists js-product-carousel">
      @for ($i = 0; $i < 3; $i++)
      <div class="product-lists-item is-bundle carousel-cell">
          @include('partials.product-bundle-static')
      </div>
      @endfor
    </div>
  </div>
</section>


<section class="section bg-white section-product-lists">
  <div class="container">
    <div class="title-header d-flex justify-content-between">
      <h2 class="h2 is-small-mob align-self-center">Produkter for dine behov</h2>
      <div class="link-block align-self-center">
        <a href="#" class="link-text has-icon">
          <div class="d-none d-md-block">Se alle produkter</div>
          <div class="d-block d-md-none">Se alle</div>
        </a>
      </div>
    </div>
  </div>

  <div class="container">
    <div class="product-lists">
      @for ($i = 0; $i < 3; $i++)
      <div class="product-lists-item is-bundle">
          @include('partials.product-bundle-static')
      </div>
      @endfor
    </div>
  </div>
</section>
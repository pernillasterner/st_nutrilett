<section class="bg-white product-filter">
  <div class="container">
    <div class="row">
      <div class="col-lg-10 col-md-9 col">
        <div class="filter-category filter-category-desktop d-none d-lg-flex">
          <a href="">
            <div class="filter-category-item">Alle</div>
          </a>
          <a href="">
            <div class="filter-category-item is-active">Barer</div>
          </a>
          <a href="">
            <div class="filter-category-item">Smoothies</div>
          </a>
          <a href="">
            <div class="filter-category-item">Shakes</div>
          </a>
          <a href="">
            <div class="filter-category-item">Supper</div>
          </a>
          <a href="">
            <div class="filter-category-item">Pakker</div>
          </a>
          <a href="">
            <div class="filter-category-item">Shaker</div>
          </a>
          <a href="">
            <div class="filter-category-item">Grot</div>
          </a>
        </div>
        <div class="filter-category-mobile d-block d-lg-none">
          <a href="">
            <div class="filter-category-item d-flex align-items-center">
              <div>Shop</div> @include('icons.right-arrow')<div>Barer</div>
            </div>
          </a>
        </div>
      </div>
      <div class="col-lg-2 col-md-3 col">
        <a href="#" class="js-open-filter">
          <div class="filter-icon d-flex align-items-center justify-content-end">
            @include('icons.wand')
            <span class="filter-icon-label">Filter</span>
          </div>
        </a>
      </div>
    </div>
    <div class="row">
      {{-- Product Category Menu - Single Product Page  NO FILTER --}}
      {{-- <div class="col-lg-12 col-md-12 col">
        <div class="filter-category-mobile">
          <a href="#">
            <div class="filter-category-item d-flex align-items-center">
              <div>Shop</div> @include('icons.right-arrow')<div>Chocolate</div>
            </div>
          </a>
        </div>
      </div> --}}
    </div>
  </div>

  <div class="product-filter-wrapper is-filter-close">
    <div class="product-filter-wrapper-button-container">
      <div class="container">
        <div class="row">
          <div class="col-6">
            <div class="filter-btn icon-delete">
              @include('icons.trash-can')
              <span class="text-uppercase">tøm filter</span>
            </div>
          </div>
          <div class="col-6">
            <div class="filter-btn icon-fill text-right js-close-filter close-svg">@include('icons.i-delete') <span
                class="text-uppercase">Lukk Filter</span></div>
          </div>
        </div>
      </div>
    </div>
    <div class="container product-filter-wrapper-panel">
      <div class="row">
        <div class="col-lg-6">
          <div class="h2 filter-title">Produkter</div>
          <div class="filter-attribute">
            <div class="filter-attribute-wrap">
              <div class="filter-attribute-wrap-item">
                <a href="">
                  <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="aaa">
                    <label class="custom-control-label" for="aaa">Lactose free</label>
                  </div>
                </a>
              </div>
              <div class="filter-attribute-wrap-item">
                <a href="">
                  <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="bbb">
                    <label class="custom-control-label" for="bbb">Vegan</label>
                  </div>
                </a>
              </div>
              <div class="filter-attribute-wrap-item">
                <a href="">
                  <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="ccc">
                    <label class="custom-control-label" for="ccc">Gluten free</label>
                  </div>
                </a>
              </div>
            </div>
            <div class="filter-attribute-wrap">

              <div class="filter-attribute-wrap-item">
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" id="ddd">
                  <label class="custom-control-label" for="ddd">Lactose free</label>
                </div>
              </div>

              <div class="filter-attribute-wrap-item">
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" id="eee">
                  <label class="custom-control-label" for="eee">Vegan</label>
                </div>
              </div>

              <div class="filter-attribute-wrap-item">
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" id="fff">
                  <label class="custom-control-label" for="fff">Gluten free</label>
                </div>
              </div>

            </div>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="h2 filter-title">
            Sorter
          </div>
          <div class="filter-attribute">
            <div class="filter-attribute-wrap">
              <div class="filter-attribute-wrap-item">
                <span class="small">ALLE</span>
                <div class="icon-fill no-stroke svg-gallery">@include('icons.gallery-layout')</div>
              </div>
              <div class="filter-attribute-wrap-item">
                <span class="small">Mest populære</span>
                <div class="sorter-svg">@include('icons.crisp-arrow-bottom')</div>
              </div>
              <div class="filter-attribute-wrap-item">
                <span class="small">Pris</span>
                <div class="sorter-svg">@include('icons.crisp-arrow-bottom')</div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-12 text-center filter-btn-wrapper">
          <button type="button" class="btn btn-secondary">legg i handlekurv</button>
        </div>
      </div>
    </div>
  </div>
</section>

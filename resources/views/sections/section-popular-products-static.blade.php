<section class="section has-breadcrumbs section-product-lists">
    <div class="container">
        <div class="title-header d-flex justify-content-between">
            <h2 class="h2 is-small-mob align-self-center">Våre bestselgere</h2>
            <div class="link-block align-self-center">
                <a href="#" class="link-text has-icon">
                    <div class="d-none d-md-block">Se alle produkter</div>
                    <div class="d-block d-md-none">Se alle</div>
                </a>
            </div>
        </div>
    </div>
    <div class="container js-product-mobile">
        <div class="product-lists" data-item-mobile="4">
            @for ($i = 0; $i < 8; $i++)
            <div class="product-lists-item">
                @include('partials.product-item-static')
            </div>
            @endfor
        </div>
        <div class="text-center load-more show-mobile">
            <a href="#" class="btn btn-secondary js-show-items">Last inn flere</a>
        </div>
    </div>
</section>

<section class="section bg-white section-product-lists">
    <div class="container">
        <div class="title-header d-flex justify-content-between">
            <h2 class="h2 is-small-mob align-self-center">Andre produkter</h2>
            <div class="link-block align-self-center">
                <a href="#" class="link-text has-icon">
                    <div class="d-none d-md-block">Se alle produkter</div>
                    <div class="d-block d-md-none">Se alle</div>
                </a>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="product-lists js-product-carousel"><!-- /.js-product-carousel to be a swipe-->
            @for ($i = 0; $i < 8; $i++)
            <div class="product-lists-item carousel-cell">
                @include('partials.product-item-static')
            </div>
            @endfor
        </div>
    </div>
</section>
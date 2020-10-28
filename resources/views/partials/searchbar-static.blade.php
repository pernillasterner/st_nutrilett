<div class="search-bar js-search-bar">
    <div class="search-wrap">
        <div class="search-fixed">
            <div class="container">
                <form class="search-form">
                    <input type="text" name="" id="" class="search-input" placeholder="Hva leter du etter?">
                    <div class="search-btn is-open">
                        @include('icons.zoom')
                    </div>
                    <div class="search-close">
                        @include('icons.cross')
                    </div>
                </form>
            </div>
            <div class="search-result no-result d-none">
                <div class="container">
                    <p>Du har ikke søkt etter noe enda</p>
                </div>
            </div>
            <div class="search-result">
                <div class="container key-tips">
                    <div class="row">
                        <div class="col-xl-6 col-lg-5 col-md-5">
                            <div class="keyword">Ditt søkeord <strong>barer</strong> ga 33 treff</div>
                        </div>
                        <div class="col-xl-6 col-lg-7 col-md-7">
                            <div class="tips"><strong>Tips:</strong> Får du ingen gode søkeresultater, forsøk å omformulere søket ditt</div>
                        </div>
                    </div>
                </div>

                <section class="section is-small section-product-lists">
                    <div class="container">
                        <div class="title-header d-flex justify-content-between">
                            <h2 class="h4 is-small-mob align-self-center">Produkter (7)</h2>
                        </div>
                    </div>
                    <div class="container">
                        <div class="product-lists ">
                            @for ($i = 0; $i < 8; $i++)
                            <div class="product-lists-item">
                                @include('partials.product-item-static')
                            </div>
                            @endfor
                        </div>
                    </div>
                </section>

                <section class="section is-small section-product-lists">
                    <div class="container">
                        <div class="title-header d-flex justify-content-between">
                            <h2 class="h4 is-small-mob align-self-center">Produkter for dine behov</h2>
                        </div>
                    </div>

                    <div class="container">
                        <div class="product-lists">
                        @for ($i = 0; $i < 2; $i++)
                        <div class="product-lists-item is-bundle">
                            @include('partials.product-bundle-static')
                        </div>
                        @endfor
                        </div>
                    </div>
                </section>

                <section class="section is-small-top section-articles">
                    <div class="container">
                        <div class="title-header d-flex justify-content-between has-info">
                            <div class="title align-self-center align-self-md-start">
                                <h2 class="h4 is-small-mob">Trening & Mosjon</h2>                            </div>
                        </div>
                    </div>
                    <div class="container">
                        <div class="card-lists js-articles-masonry">

                            <div class="card-item">
                                <div class="card-block">
                                    <a href="#" class="category">aktiv livsstil</a>
                                    <a href="#" class="card-info">
                                        <div class="image">
                                            <img class="img-card" src="@asset('images/temp/inspiration_product_1.jpg')" alt="">
                                        </div>
                                        <h3 class="h3">Veganer og vegetarianer – hva er forskjellen?</h3>
                                        <div class="link-text has-icon">Les mer</div>
                                    </a>
                                </div>
                            </div>
                            <div class="card-item">
                                <div class="card-block">
                                    <a href="#" class="category">kosthold</a>
                                    <a href="#" class="card-info">
                                        <div class="image is-big">
                                            <img class="img-card" src="@asset('images/temp/inspiration_product_2.jpg')" alt="">
                                        </div>
                                        <h3 class="h3">Derfor bør du spise frokost</h3>
                                        <div class="link-text has-icon">Les mer</div>
                                    </a>
                                </div>
                            </div>
                            <div class="card-item">
                                <div class="card-block">
                                    <a href="#" class="category">kosthold</a>
                                    <a href="#" class="card-info">
                                        <div class="image is-small">
                                            <img class="img-card" src="@asset('images/temp/inspiration_product_3.jpg')" alt="">
                                        </div>
                                        <h3 class="h3">Slik velger du riktig smart living by nutrilett produkt</h3>
                                        <div class="link-text has-icon">Les mer</div>
                                    </a>
                                </div>
                            </div>

                            <div class="card-item">
                                <div class="card-block">
                                    <a href="#" class="category">kosthold</a>
                                    <a href="#" class="card-info">
                                        <div class="image is-big">
                                            <img class="img-card" src="@asset('images/temp/inspiration_product_2.jpg')" alt="">
                                        </div>
                                        <h3 class="h3">Derfor bør du spise frokost</h3>
                                        <div class="link-text has-icon">Les mer</div>
                                    </a>
                                </div>
                            </div>
                            <div class="card-item">
                                <div class="card-block">
                                    <a href="#" class="category">kosthold</a>
                                    <a href="#" class="card-info">
                                        <div class="image is-small">
                                            <img class="img-card" src="@asset('images/temp/inspiration_product_3.jpg')" alt="">
                                        </div>
                                        <h3 class="h3">Slik velger du riktig smart living by nutrilett produkt</h3>
                                        <div class="link-text has-icon">Les mer</div>
                                    </a>
                                </div>
                            </div>
                            <div class="card-item">
                                <div class="card-block">
                                    <a href="#" class="category">aktiv livsstil</a>
                                    <a href="#" class="card-info">
                                        <div class="image">
                                            <img class="img-card" src="@asset('images/temp/inspiration_product_1.jpg')" alt="">
                                        </div>
                                        <h3 class="h3">Veganer og vegetarianer – hva er forskjellen?</h3>
                                        <div class="link-text has-icon">Les mer</div>
                                    </a>
                                </div>
                            </div>

                        </div><!-- /.card-lists -->
                        <div class="load-more text-center">
                            <div class="spinner-border d-none" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                            <a href="#" class="btn btn-secondary">Last inn flere</a>
                        </div>
                    </div>
                </section>




            </div>
        </div>
    </div>
</div>
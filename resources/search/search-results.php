<?php
if( !$items && !$exactMatch ) {
    return;
}

global $settings;

$productCPT = isset( $settings['ProductCPT'] ) ? $settings['ProductCPT'] : 'silk_products';
$products = [];
$articles = [];

foreach( $items as $item ) {
    if( $item->post_type === $productCPT && $item->post_content !== "" ) {
        $products[] = $item;
    } else {
        $articles[] = $item;
    }
}

$productsSlider = App\Classes\SectionHelper::get_products_slider( (object)[
    'show' => 'handpicked',
    'products' => $products,
] );
?>

<?php if( $products ): ?>
    <section class="section is-small section-product-lists js-gtm-search">
        <div class="container">
            <div class="title-header d-flex justify-content-between">
                <h2 class="h4 is-small-mob align-self-center">Produkter (<?= count( $products ) ?>)</h2>
            </div>
        </div>
        <div class="container">
            <div class="product-lists">
                <?php foreach( $productsSlider as $product ): ?>
                    <div class="product-lists-item">
                        <?php echo \App\template( 'partials.product-item', [ 'product' => $product, 'product_class' => new App\Classes\Product( $product->id ) ] ); ?>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
    </section>
<?php endif ?>

<?php if( $articles ): ?>
    <section class="section is-small-top section-articles">
        <div class="container">
            <div class="title-header has-info d-flex justify-content-between">
                <div class="title align-self-center align-self-md-start">
                    <h2 class="h4 is-small-mob">Inlegg (<?= count( $articles ) ?>)</h2>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="card-lists js-articles-masonry">
                <?php
                foreach( $articles as $key => $item ):
                    $link = get_permalink( $item );
                    $categories = wp_get_post_terms( $item->ID, 'category' );
                ?>                    
                    <div class="card-item" <?= $key > 5 ? 'style="display:none"' : '' ?>>
                        <div class="card-block">
                            <?php if( $categories ): ?>
                                <?php $category = end( $categories ) ?>
                                <a class="category" href="<?= get_term_link( $category ) ?>" class="category"><?= $category->name ?></a>
                            <?php endif ?>
                            <a href="<?= $link ?>" class="card-info">
                                <div class="image <?= empty( get_the_post_thumbnail( $item->ID ) ) ? 'no-image' : '' ?>">
                                    <?= get_the_post_thumbnail( $item->ID, 'article-listing', [ 'class' => 'img-card lazy' ] ) ?>
                                </div>

                                <h3 class="h3"><?= $item->post_title ?></h3>
                                <div class="link-text has-icon"><?= $site_translate->articles['read_more'] ?? 'Les mer' ?></div>
                            </a>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>

            <?php if( count( $articles ) > 6 ): ?>
                <div class="load-more text-center">
                    <button type="button" class="btn btn-secondary js-show-all-articles"><?= $settings['LoadMoreButtonText'] ?></button>
                </div>
            <?php endif; ?>
        </div>
    </section>
<?php endif;
<?php
use App\Controllers\TaxonomySilk_category;
use App\Controllers\SingleSilk_products;
use App\Classes\Helper;
use App\Controllers\App;

$translations = App::getSiteTranslations()->selections;
$currencyReplacement = Helper::get_currency_replacement();

if( isset( $isReceipt ) ) {
    $postID = $item->product_post->ID;
    $price = $item->product_data['totalPriceAsNumber'];
} else {
    $postID = $item['post_id'];
    $price = $item['totalPriceAsNumber'];
}

$mainPostID = $postID;
$productPost = get_post( $postID );
$product = TaxonomySilk_category::get_product( $postID );
$productImage = !empty($product->images['standard']['0']) ? $product->images['standard']['0']['url'] : '';
$price = str_replace( "&nbsp;", ' ', htmlentities( number_format( $price, 2 ), null, 'utf-8' ) ) . ' ' . $currencyReplacement;

// If it is a draft product (special product bundle), get the link of the main product
if( $productPost->post_status === 'draft' ) {    
    $mainPostID = Helper::get_main_product( $postID );
    $mainProduct = TaxonomySilk_category::get_product( $mainPostID );
    $productImage = !empty($mainProduct->images['standard']['0']) ? $mainProduct->images['standard']['0']['url'] : '';
}

$productLink = get_permalink( $mainPostID );
?>

<?php if( isset( $isCheckoutPage ) || isset( $_REQUEST['is_checkout'] ) ): ?>
    <div class="cart-item d-flex justify-content-between">
        <div class="cart-start d-md-flex">
            <a href="<?= $productLink ?>" class="align-self-center">
                <figure class="image d-none d-lg-block">
                    <img src="<?php echo $productImage ?>" alt="">
                </figure>
            </a>
            <div class="info align-self-center">
                <div class="rate">
                    <?= \App\template( 'partials.star-rating', [ 'rating' => SingleSilk_products::getProductRating( $mainPostID ) ] ) ?>
                </div>
                <a href="<?= $productLink ?>" class="name"><?= $item['productName'] ?></a>
            </div>
            <div class="quantity d-flex align-self-center align-items-center ml-auto">
                <button class="q-control js-edit-item js-subtract" data-href="<?= EscGeneral::getQueryRemoveProduct( $item ) . '&is_checkout=1'; ?>">-</button>
                <input type="text" class="form-control js-qty" value="<?= $item['quantity'] ?>" data-value="<?= $item['quantity'] ?>" readonly>
                <button class="q-control js-edit-item js-add" data-href="<?= EscGeneral::getQueryAddProduct( $item ) . '&is_checkout=1'; ?>">+</button>
            </div>
        </div>
        <div class="cart-end d-flex flex-column flex-md-row align-self-md-center align-items-end align-items-md-center justify-content-md-end">
            <div class="price"><?= $price ?></div>
            <button class="delete-btn d-flex align-items-center js-edit-item" data-href="<?= EscGeneral::getQueryRemoveProduct( $item, -100 ); ?>&is_checkout=1">
                <div class="close-text small"><?= $translations['remove'] ?: 'Remove' ?></div>
                <?php include( locate_template( 'views/icons/cross.blade.php' ) ) ?>
            </button>
        </div>
    </div>
<?php elseif( isset( $isReceipt ) ): ?>
    <div class="cart-item d-flex justify-content-between">
        <div class="cart-start d-md-flex">
            <a href="<?= $productLink ?>" class="align-self-center">
                <figure class="image d-none d-lg-block">
                    <img src="<?php echo $productImage ?>" alt="">
                </figure>
            </a>
            <div class="info align-self-center">
                <div class="rate">
                    <?= \App\template( 'partials.star-rating', [ 'rating' => SingleSilk_products::getProductRating( $mainPostID ) ] ) ?>
                </div>
                <a href="<?= $productLink ?>" class="name"><?= $item->product_post->post_title ?></a>
            </div>
            <div class="quantity d-flex align-self-center align-items-center">
                <div class="show-mobile mr-4"><?= $translations['quantity'] ?: 'Quantity' ?></div>
                <?= $item->product_data['quantity'] ?>
            </div>
        </div>
        <div class="cart-end d-flex flex-column flex-md-row align-self-md-center align-items-end align-items-md-center justify-content-md-end">
            <div class="price"><?= $price ?></div>
        </div>
    </div>
<?php else: ?>
    <div class="cart-item d-flex justify-content-between">
        <div class="cart-start d-md-flex">
            <a href="<?= $productLink ?>" class="align-self-center">
                <figure class="image">
                    <img src="<?php echo $productImage ?>" alt="">
                </figure>
            </a>
            <div class="info align-self-center">
                <div class="rate">
                    <?= \App\template( 'partials.star-rating', [ 'rating' => SingleSilk_products::getProductRating( $mainPostID ) ] ) ?>
                </div>
                <a href="<?= $productLink ?>" class="name"><?= $item['productName'] ?></a>
            </div>
            <div class="quantity d-flex align-self-center align-items-center">
                <button class="q-control js-cart-edit-item js-subtract" data-href="<?= EscGeneral::getQueryRemoveProduct( $item ); ?>">-</button>
                <input type="text" class="form-control js-qty" value="<?= $item['quantity'] ?>" data-value="<?= $item['quantity'] ?>" readonly>
                <button class="q-control js-cart-edit-item js-add" data-href="<?= EscGeneral::getQueryAddProduct( $item ); ?>">+</button>
            </div>
        </div>
        <div class="cart-end d-flex flex-column flex-md-row align-self-md-center align-items-end align-items-md-center justify-content-md-end">
            <div class="price"><?= $price ?></div>
            <button class="delete-btn d-flex align-items-center js-cart-edit-item" data-href="<?= EscGeneral::getQueryRemoveProduct( $item, -100 ); ?>">
                <div class="close-text small"><?= $translations['remove'] ?: 'Remove' ?></div>
                <?php include( locate_template( 'views/icons/cross.blade.php' ) ) ?>
            </button>
        </div>
    </div>
<?php endif ?>
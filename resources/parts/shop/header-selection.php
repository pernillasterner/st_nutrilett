<?php

use App\Controllers\App;
use App\Classes\Helper;

if (isset($_REQUEST['is_checkout'])) {
    include(locate_template('parts/shop/checkout-selection.php'));
    return;
}

$translations = App::getSiteTranslations()->selections;
$selection = \EscGeneral::getSelection();
$checkoutLink = get_permalink(Helper::get_silk_architecture_page('selection'));
$isHeaderCart = true;
?>

<a href="<?= $checkoutLink ?>" class="navbar-button cart-btn">
    <div class="cart-count"><?= $selection['total_items'] ?></div>
    <?php include(locate_template('views/icons/shopping-bag.blade.php')) ?>
</a>

<div class="cart">
    <div class="cart-group">
        <div class="cart-list <?= $selection['total_items'] === 0 ? 'no-item' : '' ?>">
            <?php if ($selection['total_items'] > 0) : ?>
                <?php foreach ($selection['items'] as $item) : ?>
                    <?php include(locate_template('parts/shop/selection-item.php')) ?>
                <?php endforeach ?>
            <?php else : ?>
                <?= $translations['no_items_added'] ?>
            <?php endif ?>
        </div>

        <?php if($selection['total_items'] !== 0) : ?>
            <div class="cart-total">
                <div class="delivery"><?= $translations['free_shipping_text'] ?></div>
                <div class="shipping d-flex justify-content-between">
                    <div class="title"><?= $translations['shipping'] ?></div>
                    <div class="price"><?= number_format( $selection['totals']['shippingPriceAsNumber'], 2 ) . ' ' . $currencyReplacement ?></div>
                </div>
                <div class="total d-flex justify-content-between">
                    <div class="title"><?= $translations['total'] ?></div>
                    <div class="price"><?= number_format( $selection['totals']['grandTotalPriceAsNumber'], 2 ) . ' ' . $currencyReplacement ?></div>
                </div>
                <div class="go-checkout">
                    <a href="<?= $checkoutLink ?>" class="btn btn-secondary has-icon"><?= $translations['go_to_checkout'] ?></a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
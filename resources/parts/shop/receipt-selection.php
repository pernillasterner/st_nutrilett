<?php
use App\Controllers\App;

$translations = App::getSiteTranslations()->selections;
$selection = EscGeneral::getSelection();
?>

<div class="cart-item cart-item-header d-none d-lg-flex justify-content-between">
    <div class="cart-start d-md-flex justify-content-between">
        <div class="cart-header"><?= $translations['product_name'] ?: 'Product name' ?></div>
        <div class="cart-header quantity"><?= $translations['quantity'] ?: 'Quantity' ?></div>
    </div>
    <div class="cart-end d-flex flex-md-row justify-content-end">
        <div class="price">
            <div class="cart-header cart-header-sum"><?= $translations['sum']  ?: 'Sum' ?></div>
        </div>
    </div>
</div>

<?php
foreach( $receipt_info['receipt_items'] as $key => $item ) {
    include( locate_template( 'parts/shop/selection-item.php' ) );
}
?>
<?php
use App\Controllers\App;
use App\Classes\Helper;

// Translations
$translations = App::getSiteTranslations()->selections;
$currencyReplacement = Helper::get_currency_replacement();
$totals = isset( $isReceipt ) ? $receipt_info : $selection;

$contents = [
    'shipping' => [
        'label' => $translations['shipping'] ?: 'Shipping',
        'value' => number_format( $totals['totals']['shippingPriceAsNumber'], 2 ) . ' ' . $currencyReplacement,
        'style' => '',
        'show' => true,
        'additional_text' => $translations['delivery_time'],
        'additional_text_class' => 'with-postnord'
    ],
    'tax' => [
        'label' => $translations['tax'] ?: 'VAT',
        'value' => number_format( $totals['totals']['grandTotalPriceTaxAsNumber'], 2 ) . ' ' . $currencyReplacement,
        'style' => '',
        'show' => true,
        'additional_text' => '',
        'additional_text_class' => ''
    ],
    'discount' => [
        'label' => $translations['discount'] ?: 'Discount',
        'value' => number_format( $totals['totals']['totalDiscountPriceAsNumber'], 2 ) . ' ' . $currencyReplacement,
        'style' => 'style="color:#F75050"',
        'show' => $totals['totals']['totalDiscountPriceAsNumber'] !== false && abs( $totals['totals']['totalDiscountPriceAsNumber'] ) > 0,
        'additional_text' => '',
        'additional_text_class' => ''
    ],
    'total' => [
        'label' => $translations['total'] ?: 'Total',
        'value' => number_format( $totals['totals']['grandTotalPriceAsNumber'], 2 ) . ' ' . $currencyReplacement,
        'style' => '',
        'show' => true,
        'additional_text' => '',
        'additional_text_class' => ''
    ],            
];

foreach( $contents as $key => $value ):    
    if( !$value['show'] ) {
        continue;
    }
?>
    <div class="cart-meta-item d-flex justify-content-between align-items-center">
        <div class="guide-text <?php echo (!empty($value['additional_text'])) ? $value['additional_text_class'] : ''; ?>">
            <p class="mb-0" <?= $value['style'] ?>><?= $value['label'] ?></p>

            <?php if(!empty($value['additional_text']) && $value['additional_text_class'] == 'with-postnord'): ?>
                <img src="<?php echo get_theme_file_uri(); ?>/dist/images/icon/logo/pn_color_rgb.png" alt="" />
                <p class="postnord-text"><?= $value['additional_text'] ?></p>
            <?php endif; ?>
        </div>
        <div class="lead mb-0" <?= $value['style'] ?>><?= $value['value'] ?></div>
    </div>
<?php
endforeach;
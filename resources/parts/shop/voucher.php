<?php
include_once(Esc::directory() . '/modules/selection.php');

// Translations
$page_content   = TemplateCheckout::getPageContent();
$addVoucherBtn 	= $page_content->order['add_voucher'] ?: 'Add voucher';
$discountCodeText = $page_content->order['i_have_a_discount_code'] ?: 'I have a discount code';
$voucher = isset( $_REQUEST['voucher'] ) ? $_REQUEST['voucher'] : '';

if (class_exists('EscSelection')) :

    $selection = new EscSelection();
    $selection->submitFieldTemplate( '<button class="btn btn-sm btn-primary" type="button" name="{name}" value="{value}">{content}</button>' );
    $selection->inputFieldTemplate( '<input id="{id}" type="{type}" name="{name}" class="form-control form-control-md {class_0}" placeholder="" value="' . $voucher . '">' );
    $hasError = isset($_SESSION['esc_store']['voucher']) && !$_SESSION['esc_store']['voucher']['success'];
    $vouchers = EscSelection::getVouchers();
    $inputClass = $hasError ? 'is-invalid' : '';
?>
    <?php if ( count( $vouchers ) < 2 ): ?>
        <div class="col-lg-6">
            <div class="custom-control custom-checkbox first-checkbox">
                <input type="checkbox" class="custom-control-input" id="voucher-checkbox" <?=  $hasError ? 'checked' : '' ?>>
                <label class="custom-control-label" for="voucher-checkbox"><?= $discountCodeText ?></label>
                <?php EscGeneral::renderVoucherErrors('<div class="invalid-feedback">{content}</div>'); ?>
            </div>
        </div>
        <div class="col-lg-12">

            <?php
            if( EscSelection::isVoucherSet() ) {
                echo '<ul class="list-unstyled mt-3">';
            }

            foreach ($vouchers as $voucher) :
                if( strpos($voucher['voucher'], 'drkn-unlock:') !== false ) { continue; }

                $selection->submitFieldTemplate( '<button class="close" type="button" name="{name}" value="{value}">&times;</button>' );
                ?>
                    <li class="d-flex justify-content-between py-1">
                        <span><div class="voucher-fields-code"><strong><?php echo $voucherTitle; ?></strong> <?php echo $voucher['voucher']; ?></div></span>
                        <?php $selection->renderField( 'remove_voucher_' . $voucher['voucher'], $removeVoucher, false, array()); ?>
                    </li>
                <?php

            endforeach;

            if( EscSelection::isVoucherSet() ) {
                echo '</ul>';
            }
            ?>

            <div class="input-group js-vouher-input mt-3 mb-4 <?= $hasError ? '' : 'd-none' ?>">
                <?php $selection->renderField( 'voucher', '', false, array( $inputClass ) ); ?>
                <div class="input-group-append">
                    <?php
                    $selection->submitFieldTemplate( '<button class="btn btn-primary" type="button" name="{name}" value="{value}">{content}</button>' );
                    $selection->renderField( 'submit_voucher', $addVoucherBtn, false, array() );
                    ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

<?php
endif;

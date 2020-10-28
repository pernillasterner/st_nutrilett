<?php
$selection = new EscSelection();
$selection->paymentFieldTemplate('
    <div class="item">
        <div class="custom-control custom-control-lg  custom-radio">
            <input id="{id}" type="{type}" name="{name}" value="{value}" class="custom-control-input" {checked}>
            <label class="custom-control-label" for="{id}">
                <span>{label}</span>
            </label>
        </div>
    </div>
');

if( isset( $_SESSION['payment_method'] ) ) {
	$selection->renderPaymentLoop( $_SESSION['payment_method'] ); 
} else {
	$selection->renderPaymentLoop(); 
}
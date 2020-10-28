<?php

	include_once( Esc::directory() . '/includes/connect.php');
	include_once( Esc::directory() . '/includes/controller.php');
	include_once( Esc::directory() . '/modules/selection.php' );

	use App\Classes\Helper;

	$country 			= $_SESSION['esc_store']['country'];
	$internalComment 	= ( isset($_SESSION['internalComment']) ) ? $_SESSION['internalComment'] : 0;
	$newsletter 		= ( isset($_SESSION['newsletter']) ) ? $_SESSION['newsletter'] : 0;
	$state 				= ( !empty($_SESSION['state']) ) ? $_SESSION['state'] : 0;

	$successPage = Helper::get_silk_architecture_page( 'success' );
	$failPage = Helper::get_silk_architecture_page( 'fail' );

	$payment_methods = array(
		'SE' => 'klarna',
		'NO' => 'klarna-no',
		'FI' => 'klarna-fi',
		'DK' => 'klarna-dk',
		'DE' => 'klarna-de',
		'AT' => 'klarna-at',
		'NL' => 'klarna-nl',
		'GB' => 'klarna-uk',
		'US' => 'klarna-us',
	);

	if (!isset($_SESSION['payment_method'])) {
		$payment_method = isset( $payment_methods[ $country ] ) ? $payment_methods[ $country ] : 'klarna';

		$_SESSION['payment_method'] = $payment_method;	
	} else {
		$payment_method = $_SESSION['payment_method'];
	}

	$states = EscSelection::getSelectStates($country,true);

	if( empty($state) && $states ) {
		reset($states);
		$state = key($states);
		$_SESSION['state'] = $state;
	} else if(empty($states)) {
		$_SESSION['state'] = '';
		$state = 0;
	}

	if( strstr( $payment_method, 'klarna' ) ) :

		// Centra set english as default
		$language = '';

		if( function_exists('pll_current_language') && pll_current_language() != 'en' ) {
			$language = pll_current_language();
		}
  		
		$payment_parameters = array(
			'selection' 			=> $_SESSION['esc_store']['selection_id'],
			'paymentMethod' 		=> $payment_method,			
			'paymentReturnPage' 	=> isset( $successPage ) ? get_permalink( $successPage ) : get_bloginfo('url'),
			'paymentFailedPage' 	=> isset( $failPage ) ? get_permalink( $failPage ) : get_bloginfo('url'),
			'termsAndConditions' 	=> true,
			'address'				=> array(
				'country' 			=> $country,
			),
			'ipAddress' 			=> $_SERVER['REMOTE_ADDR'],
			'internalComment'		=> $internalComment,
			'language'				=> $language
		);

		if( isset( $_SESSION['OocdConsents'] ) ) {
			$payment_parameters['consents'] = $_SESSION['OocdConsents'];
		}

		if( $newsletter == 1 ) {
			$payment_parameters['address']['newsletter'] = 1;
		}

		if(!empty($state)) {
			$payment_parameters['address']['state'] = $state;
		}

		$esc_init 		= EscConnect::init('selections/' . $_SESSION['esc_store']['selection_id'] . '/payment');
		$esc_selection 	= $esc_init->post($payment_parameters);

		if( $esc_init->httpCode() != 200 ) {
			//Errors posted on checkout page.
			return @$esc_selection['errors'];
		} else {
			switch(@$esc_selection['action']) {
				case 'form':
					if(strstr($payment_parameters['paymentMethod'], 'klarna' )) {
						echo $esc_selection['formHtml'];
					} else {
						echo '<!DOCTYPE><html><head><meta http-equiv="content-type" content="text/html; charset=utf-8"/></head><body>';
						echo $esc_selection['formHtml'];
						echo '</body></html>';
					}
					break;
				case 'redirect':
					wp_redirect($esc_selection['url']);
					break;
				case 'success':
					wp_redirect($payment_parameters['paymentReturnPage']);
					break;
				case 'failed':
					wp_redirect($payment_parameters['paymentFailedPage']);
					break;
			}
		}

    else :
		$selection = new EscSelection();
		$selection->inputFieldTemplate('<div class="input-field{classes}"><input id="{id}" type="{type}" name="{name}" value="{value}" placeholder="{content}"></div>');
		$selection->selectFieldTemplate('<div class="input-field{classes}"><select id="{id}" name="{name}" value="{value}">{options}</select></div>');
		$selection->checkFieldTemplate('<label class="form-checkbox"><input id="{id}" type="{type}" name="{name}" value="{value}" class="visually-hidden" {checked}><div class="check" aria-hidden="true"></div><p class="label">{content}</p></label>');
		$selection->submitFieldTemplate('<button class="u-mainButton{class_0}" type="{type}" name="{name}" value="{value}"><span>{content}</span></button>');
		$selection->paymentFieldTemplate('<label class="form-radiobutton"><input id="{id}" type="{type}" name="{name}" value="{value}" class="visually-hidden" checked=""><div class="check" aria-hidden="true"></div><p class="label">{value}</p></label>');
		$step4 = $helper->get_translated_text( 'co_step_4' );
		?>

		<div class="form-fields form-fields--double clearfix">

			<div class="errorContainer has-error">
				<?php EscSelection::renderPossibleErrors('address.'); ?>
			</div>


			<div id="js-selectedTerms" class="form-group checkout-check-box-btn">
				<?php $selection->renderField('country', 'Country:'); ?>

				<div id="js-stateCont" class="<?php echo (EscSelection::showStates() ? '' : ' is-hidden') ?>">
					<?php $selection->renderField('state', 'State:'); ?>
				</div>

				<?php $selection->renderField('termsAndConditions', !empty( $step2['terms_conditions'] ) ? strip_tags($step2['terms_conditions'], '<a>') : null ) ; ?>
				<br>
			</div>

		</div>

		<?php if (!empty($step4['button_text'])) : ?>
            <div class="form-checkout__btn">
                <button class="button-buy">
                    <span class="button-wrapper" role="text">
                        <span class="button-col"><?php echo $step4['button_text']; ?></span>
                    </span>
                </button>		
            </div>
        <?php endif; ?>
        
    <?php endif;
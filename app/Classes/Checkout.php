<?php

namespace App\Classes;

if( !file_exists( ABSPATH . 'wp-content/plugins/oocd/ConsentApi.php' ) ) {
    return;
}

require_once ABSPATH . 'wp-content/plugins/oocd/ConsentApi.php';

use OOCD\ConsentApi;

/**
 * Description of Checkout
 *
 * @package package
 * @version $id: Checkout.php $
 * 
 Request:
{
    "paymentMethod": "klarna-checkout",
    "paymentReturnPage": "http://dev.www.nutrilett.no/kassa/",
    "paymentFailedPage": "http://dev.www.nutrilett.no/kassa/?status=failed",
    "address": {
        "country": "NO",
        "newsletter": 1
    },
    "termsAndConditions": true,
    "consents": [
        {
            "key": "0",
            "consented": true,
            "language": "nb_NO",
            "name": "6c62ab51-47eb-e911-a812-000d3a25ba2d"
        },
        {
            "key": "1",
            "consented": false,
            "language": "nb_NO",
            "name": "b4dba75d-47eb-e911-a812-000d3a25ba2d"
        },
        {
            "key": "2",
            "consented": true,
            "language": "nb_NO",
            "name": "ae84c163-47eb-e911-a812-000d3a25ba2d"
        },
        {
            "key": "2",
            "consented": false,
            "language": "nb_NO",
            "name": "1bfc1747-2e96-e811-a962-000d3a38c0ab"
        }
    ]
}
 */

class Checkout {

	private $isOocdActive;
	
	public function __construct() {
		$oocdData = json_decode( get_option( 'oocd_data' ), true );
		$consents = array();
		$consentsTemp = array();
		$data = array();
		$this->isOocdActive = ( in_array( 'oocd/oocd.php', get_option( 'active_plugins' ) ) ) ? true : false;

		if( !$oocdData ) {
			return;
		}
		
		foreach( $oocdData as $value ) {
			if( !isset( $value[ 'ConsentTypeCode' ] ) || !isset( $value[ 'MarketingListId' ] ) ) {
				continue;
			}

			$consent = array(
				'key' => $value[ 'ConsentTypeCode' ],
				'consented' => false,
				'language' => get_locale(),
				'name' => $value[ 'MarketingListId' ],
			);
			
			$consents[] = $consent;
			$consentsTemp[] = $consent;
		}
		
		if( !isset( $_SESSION[ 'OocdConsents' ] ) ) {
			$_SESSION[ 'OocdConsents' ] = $consents;
			$_SESSION[ 'OocdConsentsCT' ] = $consentsTemp;
		}

		add_action( 'init', array( $this, 'setOOCDDataFromPost' ) );
	}

	public function setOOCDDataFromPost()
	{	
        if ( isset( $_POST[ 'OocdData' ] ) && $this->isOocdActive ) {
            $this->setOocdSession( $_POST[ 'OocdData' ] );
        }
	}
	
	public function setOocdSession( $data = null ) {
		$consents = array();
		$consentsTemp = array();
		
		if( $data ) {
			$this->setConsents( $data, $consents, $consentsTemp );
		}

		$_SESSION[ 'OocdConsents' ] = $consents;
		$_SESSION[ 'OocdConsentsCT' ] = $consentsTemp;
	}
	
	private function setConsents( $data, &$consents, &$consentsTemp ) {
		if( !$data ) {
			return;
		}
		
		foreach( $data as $item ) {
			$consent = array(
				'key' => $item[ 'ConsentTypeCode' ],
				'consented' => ( $item[ 'IsConsented' ] ) ? true : false,
				'language' => get_locale(),
				'name' => $item[ 'MarketingListId' ]
			);
			
			$consents[] = $consent;
			$consentsTemp[] = $consent;
		}
	}
}

$checkout = new Checkout();
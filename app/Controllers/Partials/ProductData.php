<?php

namespace App\Controllers\Partials;

use App\Classes\Product;
use App\Controllers\TemplateThankyou;
use App\Classes\Helper;

trait ProductData
{
	public static function get_product( $postID=null )
	{
		if (empty($postID)) {
			$postID = get_post()->ID;
		}

		$product = new Product( $postID );    	
    	$data = (object) [];
    	$data->images = $product->getAllProductImages();
		$data->is_bundle = $product->isBundle();
		$data->sizes_available = $product->sizesAvailable();
		$data->product_meta = (object) $product->product_meta;
		$data->display_price = self::get_display_price( $product->getPrice() );
		$data->is_sold_out = self::is_sold_out( $postID ) || $data->sizes_available === 0;
		$data->product_item = reset( $product->product_meta['items'] )['item'];		

		// Get related bundles and flava		
		$data->bundles = [];
		$data->flavas = [];
		$flavas = $product->getProductColors( 'standard' );
		$bundles = $product->getProductColors( 'size' );
		$labels = [4,12,24,40];
		$labelIndex = 0;

		if( $bundles ) {
			foreach( $bundles as $key => $item ) {
				if( isset( $item['bundle'] ) && $item['bundle'] ) {
					$item['price'] = self::get_display_price( \EscGeneral::getPrice( $item ) );
					$item['post'] = TemplateThankyou::getReceiptItems( [$item] )[0];
					$item['product_item'] = reset( $item['items'] )['item'];					
					$data->bundles[$item['bundle']['measureQuantity']['minimum']] = $item;
				}
			}

			ksort( $data->bundles );

			// Update labels
			$newBundles = [];

			foreach( $data->bundles as $item ) {
				$index = isset( $labels[$labelIndex] ) ? $labels[$labelIndex++] : '';
				$newBundles[$index] = $item;
			}

			$data->bundles = $newBundles;
		}
		
		if( $flavas ) {
			foreach( $flavas as $item ) {
				$data->flavas[] = $item;				
			}
		}

    	return $data;
	}

	public static function get_display_price( $priceInfo )
	{
		// Pernilla 
		if( empty( $priceInfo) || !is_array( $priceInfo ) || !isset( $priceInfo['info'] ) ) {
			return;
		}

		$currencyReplacement = Helper::get_currency_replacement();
		$data = new \stdClass();
		$data->is_sale = $priceInfo['info']['showAsOnSale'];
		$data->price = number_format( $priceInfo['info']['priceAsNumber'], 2 ) . ' ' . $currencyReplacement;
		$data->price_before = number_format( $priceInfo['info']['priceBeforeDiscountAsNumber'], 2 ) . ' ' . $currencyReplacement;
		$data->discount_percent = $priceInfo['info']['discountPercent'];
		$data->price_as_number = number_format( $priceInfo['info']['priceAsNumber'], 2 );
		$data->price_before_as_number = number_format( $priceInfo['info']['priceBeforeDiscountAsNumber'], 2 );
		$data->quantityPrice = [];

		for( $i=1; $i<=4; $i++ ) {
			$data->quantityPrice[$i] = [
				'price_before_discount' => number_format( $i * $priceInfo['info']['priceBeforeDiscountAsNumber'], 2 ) . ' ' . $currencyReplacement,
				'price' => number_format( $i * $priceInfo['info']['priceAsNumber'], 2 ) . ' ' . $currencyReplacement,
			];			
		}

		return $data;
	}

	public static function is_sold_out( $postID )
	{	
		$isAvailable = \EscGeneral::isAvailable( $postID );

		return !empty($isAvailable[ 'info' ]) ? ($isAvailable[ 'info' ][ 'stockOfAllItems' ] === 0) : false;
	}

}
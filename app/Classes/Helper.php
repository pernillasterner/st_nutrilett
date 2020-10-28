<?php

namespace App\Classes;

class Helper {

    /**
     * Gets the term id value to be pass as $post_id
     * parameter to ACF. Will only return a value if
     * current page is a category page.
     *
     * @return string
     */
    public static function get_acf_term_id() {
        if( !is_tax() && !is_category() ) {
            return null;
        }

        return get_queried_object()->taxonomy . '_' . get_queried_object()->term_id;
    }

    /**
     * Gets the image alt text.
     * Default: Site title
     *
     * @return string
     */
    public static function get_image_alt( $imageID ) {
        $alt = get_post_meta( $imageID, '_wp_attachment_image_alt', true);

        return (!$alt) ? get_bloginfo( 'name' ) : $alt;
    }

    /**
     * Get current language
     *
     * @param $value string
     * @return string
     */
    public static function current_lang( $value='slug' ) {
        $defaultValue = $value == 'locale' ? 'en_GB' : 'en';

		return function_exists('pll_current_language') ? pll_current_language( $value ) : $defaultValue;
    }

    /**
     * Get translated sitewide field value
     *
     * @param $fieldName string
     * @return string
     */
    public static function localize( $fieldName ) {
		return get_field( $fieldName, self::current_lang() );
    }

    /**
     * Gets the translated page of saved architecture pages in Silk settings
     *
     * @return int
     */
    public static function get_silk_architecture_page( $type = null ) {
        $architecturePages = get_option('esc_architecture_options');
        $pageId = $architecturePages['esc_'. $type .'_page'];

        return $pageId;
    }


    /**
     * Replace shortcode from text.
     * This will replace the shortcode (array key) with the array value
     *
     * @param $replaces array, $template text
     * @return text
     */
    public static function sp_render_text( $replaces, $template ) {
        if (!$replaces && !$template) {
            return;
        }

        $str = preg_replace_callback( '/\[(.+?)\]/', function ( $matches ) use ( $replaces ) {
            return isset($replaces[ $matches[1] ]) ? $replaces[ $matches[1] ] : '';
        }, $template );

        return $str;
    }

    /**
     * Get array value by index
     *
     * @param $arr array, $pos number
     * @return array
     */
    public static function get_array_value_by_index( $arr, $pos ) {
        if( empty($arr[ $pos ]) ) {
            return;
        }

        return $arr[ $pos ];
    }

    /**
     * Explode string to array 
     * Allowed functionName value is explode and preg_split only
     * 
     * @param $delimeter string, $text string, $functionName string
     * @return array
     */
    public static function sp_split_string( $delimeter, $text, $functionName='explode' ) {
        return array_map( function($item) {
            return trim($item);
        }, $functionName( $delimeter, $text) );
    }

    public static function sp_parse_product_details( $subject ) {
        if( empty($subject) ) {
            return [];
        }

    	$details = array();

    	// This regexp is a bit more felxible with withspace etc
        $pattern = '/##(.*)##(<br \\/>|\s)([^#]*)/';
		
		//$pattern = '/###(.*)###(\\n|<br \\/>)\\n([^#]*)/';
		$matches = array();
		$result = preg_match_all($pattern, $subject, $matches);

		if ($result) {

			for( $i=0; $i < $result; $i++ ) { 
				$key = $matches[ 1 ][ $i ];
                $val = $matches[ 3 ][ $i ];
                
				$details[ strtolower($key) ] = [
					'label' => $key,
					'content' => self::sp_render_list($val)
				];
            }
            
		} else {

			$details['description'] = [
				'label' => '',
				'content' => self::sp_render_list($subject)
            ];
            
		}

		return $details;
    }
    
    public static function sp_render_list( $text ) 
    {
        if( empty($text)) {
            return '';
        }
                                
        $string = preg_replace( "/\*+(.*)?/i", "<ul><li>$1</li></ul>", strip_tags($text) );
        $string = preg_replace( "/(\<\/ul\>\n(.*)\<ul\>*)+/", "", $string );

        return $string;
    }

    public static function get_unique_post_meta_value( $postType, $key )
    {   
        global $wpdb;

        $query = "
        SELECT DISTINCT pm.meta_value FROM {$wpdb->postmeta} pm
        LEFT JOIN {$wpdb->posts} p ON p.ID = pm.post_id
        WHERE p.post_status = 'publish'";
    
        if (!empty($postType)) {
            $cond = $wpdb->prepare(' AND p.post_type = %s', $postType);
            $query .= $cond;
        }
    
        if (!empty($key)) {
            $cond = $wpdb->prepare(' AND pm.meta_key = %s', $key);
            $query .= $cond;
        } 
    
        $result = $wpdb->get_col( $query );

        return $result;
    }

    public static function get_category( $postID, $taxonomy )
    {
        $categories = wp_get_post_terms( $postID, $taxonomy );

        if ( !$categories ) {
            return null;
        }

        return end( $categories );
    }

     /**
     * Append an array in a specific index within an array.
     *
     * @param $array array, $index int, $insert array
     * @return array
     */
    public static function sp_array_insert( $array, $index, $insert )
    {
        return array_slice( $array, 0, $index, true ) + $insert +
        array_slice( $array, $index, count( $array ) - $index, true );
    }

    /**
     * Get main product of special product bundle item
     *
     * @param [int] $postID
     * @return void
     */
    public static function get_main_product( $postID )
    {
        $specialProductsMapping = get_option( 'special_products_mapping' );

        foreach( $specialProductsMapping as $key => $values ) {
            if( in_array( $postID, $values ) ) {
                return $key;
            }
        }
    }

    public static function get_currency_replacement()
    {
        $currencyReplacements = ['NOK' => 'kr', 'SEK' => 'kr'];
        $currencyReplacement = isset( $currencyReplacements[\EscGeneral::getCurrentPricelistName()] ) ? $currencyReplacements[\EscGeneral::getCurrentPricelistName()] : '';
        
        return $currencyReplacement;
    }

    public static function process_special_product( $specialProductPost, $product )
    {
        if( $specialProductPost->post_status === 'draft' ) {
            wp_update_post( array(
                'ID' => $specialProductPost->ID,
                'post_status' => 'publish',
            ) );
        }
                    
        $currentRelatedProducts = [];

        $relatedProductsIDs = array_values( array_map( function( $item ) {
            return $item['product'];
        }, array_filter( $product['relatedProducts'], function( $item ) {
            return $item['relation'] === 'size';
        } ) ) );

        if( $relatedProductsIDs ) {
            $relatedProducts = get_posts( [
                'post_type' => 'silk_products',                        
                'numberposts' => -1,
                'post_status' => 'publish,draft',
                'meta_query' => [
                    [
                        'key' => 'product_id',
                        'value' =>  $relatedProductsIDs,
                        'compare' => 'IN',
                    ]
                ]
            ] );

            foreach( $relatedProducts as $relatedProductPost ) {
                if( $relatedProductPost && isset( $relatedProductPost->ID ) ) {
                    $currentRelatedProducts[] = $relatedProductPost->ID;
                }
            }
        }

        return $currentRelatedProducts;
    }

    public static function process_bundle( $bundlePost, $product )
    {
        if( $bundlePost->post_status === 'draft' ) {
            wp_update_post( array(
                'ID' => $bundlePost->ID,
                'post_status' => 'publish',
            ) );
        }

        $currentBundledProducts = [];

        $bundleItemsIDs = array_map( function( $item ) {
            return $item['product'];
        }, $product['bundle']['products'] );

        $bundledProducts = get_posts( [
            'post_type' => 'silk_products',                        
            'numberposts' => -1,
            'post_status' => 'publish,draft',
            'meta_query' => [
                [
                    'key' => 'product_id',
                    'value' =>  $bundleItemsIDs,
                    'compare' => 'IN',
                ]
            ]
        ] );

        $isBundleAvailable = true;

        foreach( $bundledProducts as $item ) {
            if( \App\Controllers\SingleSilk_products::is_sold_out( $item->ID ) ) {
                $isBundleAvailable = false;
            }

            $currentBundledProducts[] = $item->ID;
        }

        update_post_meta( $bundlePost->ID, 'is_bundle_available', $isBundleAvailable ? 1 : 0 );        

        return $currentBundledProducts;
    }

    public static function get_tracking_data( $product )
    {
        $price = 0;
        $productCategory = self::get_category( $product->id, 'silk_category' );
        if(isset($product->display_price->price_as_number)) {
            $price = $product->display_price->price_as_number;
        }

        if(isset($product->display_price->price_before_as_number)) {
            $priceBefore = $product->display_price->price_before_as_number;
        }

        if( $product->type === 'Special' ) {
            $firstBundle = reset( $product->bundles );
            if(isset($firstBundle['price']->price_as_number)) {
                $price = $firstBundle['price']->price_as_number;
            }

            if(isset($firstBundle['price']->price_before_as_number)) {
                $priceBefore = $firstBundle['price']->price_before_as_number;
            }
        }

        $productTrackingData = [
            'name' => $product->name,
            'id' => $product->meta->sku,
            'price' => $price,
            'brand' => get_bloginfo( 'name' ),
            'category' => $productCategory ? $productCategory->name : '',
            'currency' => \EscGeneral::getCurrentPricelistName(),
            'dimension3' => (isset($product->is_sold_out) && $product->is_sold_out) ? 'Out of Stock' : 'In Stock',
            'dimension4' => $priceBefore,
            'dimension5' => $price,
            'dimension6' => (isset($product->display_price->discount_percent)) ? $product->display_price->discount_percent : 0,
        ];

        return $productTrackingData;
    }

    public static function get_dimensions( $productData )
    {
        $price = $productData->display_price->price_as_number;
        $priceBefore = $productData->display_price->price_before_as_number;
        $discountPercent = $productData->display_price->discount_percent;

        if( $productData->product_meta->product_type === 'Special' ) {
            $firstBundle = reset( $productData->bundles );
            $price = $firstBundle['price']->price_as_number;
            $priceBefore = $firstBundle['price']->price_before_as_number;
            $discountPercent = $firstBundle['price']->discount_percent;
        }        

        return (object) compact( 'price', 'priceBefore', 'discountPercent' );
    }
}
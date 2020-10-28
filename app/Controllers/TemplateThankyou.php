<?php

namespace App\Controllers;

use Sober\Controller\Controller;

if( class_exists('\Esc') ) {
    include_once( \Esc::directory() . '/modules/success.php' );
}

class TemplateThankyou extends Controller
{

    public function content()
    {
        return App::get_content( get_post()->ID, 1 );
    }
    
    public function pageInfo()
    {
        $success = new \EscSuccess();
        $receiptInfo = $success->getReceiptInfo();   
        
        if( isset($receiptInfo['code']) && $receiptInfo['code'] === 'COUNTRY_MISMATCH' ) {
            $content = get_field( 'country_mismatch' );

        } elseif( isset($receiptInfo['errors']) ) {
            $content = get_field( 'error_has_occurred' );
            
        } elseif( isset($receiptInfo['order']) ) {
            $content = get_field( 'successful_checkout' );
            
        }

        if (isset($receiptInfo['items'])) {
            $receiptInfo['receipt_items'] = self::getReceiptItems( $receiptInfo['items'] );
        }

        $receiptBg = '';
        if (get_field( 'receipt_bg_image' )) {
            $receiptBg = wp_get_attachment_image_url( get_field( 'receipt_bg_image' )['ID'], 'newsletter-bg' );
        }

        $content = empty($content) ? [] : $content;
        
        return (object) [
            'header' => $content,
            'has_header' => !empty(array_filter($content)),
            'info' => $receiptInfo
        ];
    }

    public static function getReceiptItems( $items ) 
    {
        if( empty($items) ) { return false; }
        
        $products = [];

        foreach ($items as $item) {
            $args = array(
                'post_type' => 'silk_products',
                'meta_key' => 'product_id',
                'meta_value' =>  $item['product'],
                'post_status' => 'publish,draft',
            );
    
            $wpQuery = new \WP_Query( $args );
    
            if( empty($wpQuery->posts) ) {
                continue;
            }

            $products[] = (object) [
                'product_post' => $wpQuery->posts[0],
                'product_data' => $item,
            ];
        }

        return $products;

    }
    
    public function clearSession() 
    {
        if( isset($_SESSION['esc_store']['selection_id']) ) {
            setcookie('esc_id', $_SESSION['esc_store']['selection_id'], time()+(3600*3), '/', $_SERVER['SERVER_NAME'] );
        }

        \EscSuccess::clearSession();
    }    
}

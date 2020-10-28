<?php

namespace App\Controllers;

use Sober\Controller\Controller;
use App\Classes\Product;
use App\Classes\Breadcrumbs;
use App\Classes\Helper;
use App\Classes\SectionHelper;
use App\Controllers\App;

class TaxonomySilk_category extends Controller
{
    use Partials\ProductData;

    public static function categoryMenu()
    {
        $rows = array();
        $currentCategory = get_queried_object();
        $rows['isActive'] = (isset($currentCategory->term_id)) ? $currentCategory->term_id : 'shop';
        $rows['shop'] = get_field( 'shop_link', 'global' );
        $rows['shop_text'] = get_field( 'product_listing_shop_all', 'global' );
        $categoryMenu = get_field( 'product_listing_category_menu', 'global' );
        if(isset($categoryMenu['icon_links'])) {
            foreach($categoryMenu['icon_links'] as $item) {
                $iconLinks[] = array_merge( SectionHelper::get_link( (object)$item ), [
                    'icon' => wp_get_attachment_image( $item['icon'], 'thumbnail', true, [ 'class' => 'default-image' ] ),
                    'hover_state_icon' => wp_get_attachment_image( $item['hover_state_icon'], 'thumbnail', true, [ 'class' => 'hover-image' ] ),
                    'term_id' => $item['link_product_category']->term_id    
                ] );
            }

            $rows['icon_links'] = $iconLinks;
        }

        return $rows;
    }

    public static function getProducts()
    {
        $data = new \stdClass();

        if( is_tax( 'silk_category' ) ) {
            $currentCategory = get_queried_object();                        
            $data->productsSlider = SectionHelper::get_products_slider( (object)[
                'show' => 'category',
                'products' => null,
                'product_category_product_count' => -1,
                'product_category' => $currentCategory->term_id
            ] );
        
            $data->title = $currentCategory->name;
        } else {
            $shopLink = get_field( 'shop_link', 'global' );
            $products = get_posts( array(
                'post_type' => 'silk_products',
                'numberposts' => -1,
                'post_status' => 'publish',
                'orderby' => 'post_title',
                'order' => 'ASC',
                'meta_query' => array(
                    'relation' => 'AND',
                    array(
                        'key' => 'product_type',
                        'value' => ['Single', 'Special'],
                        'compare' => 'IN',
                    ),
                    array(
                        'meta_key' => 'product_type',
                        'compare' => 'EXISTS',
                    )
                )
            ) );
            $data->productsSlider = SectionHelper::get_products_slider( (object)[
                'show' => 'handpicked',
                'products' => $products,
                'product_category_product_count' => -1,
                'product_category' => null
            ] );
        
            $data->title = $shopLink['title'];
        }        

        return $data;
    }

    public static function getBundles()
    {
        $data = new \stdClass();

        if( is_tax( 'silk_category' ) ) {
            $currentCategory = get_queried_object();                        
            $data->productsSlider = SectionHelper::get_products_slider( (object)[
                'show' => 'category',
                'products' => null,
                'product_category_product_count' => -1,
                'product_category' => $currentCategory->term_id
            ], ['Bundle'] );        
        } else {
            $products = get_posts( array(
                'post_type' => 'silk_products',
                'numberposts' => -1,
                'post_status' => 'publish',
                'meta_query' => array(
                    'relation' => 'AND',
                    array(
                        'key' => 'product_type',
                        'value' => 'Bundle',
                    ),
                    array(
                        'meta_key' => 'product_type',
                        'compare' => 'EXISTS',
                    )
                )
            ) );
            $data->productsSlider = SectionHelper::get_products_slider( (object)[
                'show' => 'handpicked',
                'products' => $products,
                'product_category_product_count' => -1,
                'product_category' => null
            ] );                    
        }

        $translations = App::getSiteTranslations()->product_listing;

        $data->title =  $translations['bundles'] ?: 'Bundles';

        return $data;
    }
}
<?php

namespace App\Controllers;

use Sober\Controller\Controller;
use App\Classes\SectionHelper;

class TemplateProductChooser extends Controller
{
    private $selectedGroup = false;
    private $products;

    public function __construct()
    {
        if( isset( $_GET['result'] ) ) {
            $this->selectedGroup = intval( $_GET['result'] );
            $this->products = get_field( 'products', $this->selectedGroup );
        }
    }

    public function content()
    {
        if( isset( $_GET['result'] ) ) {
            return App::get_content();
        } else {
            return App::get_content('acf-options-product-chooser-settings', 1);
        }
    }

    public function startScreen()
    {
        $rows = get_fields( 'product_chooser_settings' )['start_screen'];
        return (object)$rows;
    }

    public function hasResult()
    {
        return $this->selectedGroup;
    }

    public function products()
    {
        if (is_array($this->products)) {
            $products = array_filter( $this->products, function( $item ) {
                $productType = get_field( 'product_type', $item->ID );

                return in_array( $productType, ['Single', 'Special'] );
            } );

            return SectionHelper::get_products_slider( (object)[
                'show' => 'handpicked',
                'products' => $products
            ] );
        }
    }

    public function bundles()
    {
        if (is_array($this->products)) {
            $bundles = array_filter( $this->products, function( $item ) {
                $productType = get_field( 'product_type', $item->ID );

                return $productType === 'Bundle';
            } );

            return SectionHelper::get_products_slider( (object)[
                'show' => 'handpicked',
                'products' => $bundles
            ] );
        }
    }

    public function articlesData()
    {
        $data = get_field( 'article_results' );
        $data['show'] = 'handpicked';
        $data['articles'] = get_field( 'articles', $this->selectedGroup );
        $data['classes'] = 'bg-white';

        return (object) $data;
    }

    public function text()
    {
        return get_field( 'text', $this->selectedGroup );
    }

    public function heroData()
    {
        $rows['small_title'] = get_field( 'small_title', $this->selectedGroup );
        $rows['big_title'] = get_field( 'big_title', $this->selectedGroup );
        $rows['bullet_list'] = get_field( 'bullet_list', $this->selectedGroup );

        $imageDesktop = get_field( 'image_desktop', $this->selectedGroup );
        if ( $imageDesktop ) {
            $imgAttr[ 'class' ] = 'image d-none d-sm-none d-md-block';
            $rows['image'] = wp_get_attachment_image( $imageDesktop['ID'], 'hero-banner', false, $imgAttr );
        }
        
        return (object)$rows;
    }
}
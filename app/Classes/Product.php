<?php
namespace App\Classes;

if( class_exists('\Esc') ) {
    include_once( \Esc::directory() . '/modules/product.php' );
    include_once( \Esc::directory() . '/modules/general.php' );
}

class Product extends \EscProduct
{
    public function getPrice()
    {
        return \EscGeneral::getPrice( $this->product_post->ID );
    }

    // TODO: Bundles should maybe be its own CPT
    public function isBundle()
    {
        return isset( $this->product_meta['bundle'] );
    }

    // TODO: Bundles should maybe be its own CPT
    public function getBundle()
    {
        return \EscGeneral::getBundleData( $this->product_meta['bundle'] );
    }

    public function getAllProductImages() {

        $productImages = array();

        $images = isset( $this->product_meta['media'] ) ? $this->product_meta['media'] : array();

        foreach ($images as $image_key => $image) {

            if ( $image['type'] != 'image' ) {
                continue;
            }

            foreach ($image['sources'] as $size => $source) {
                if( !isset( $productImages[ $size ][ $image_key ] ) ) {
                    $productImages[ $size ][ $image_key ] = $source;
                }
            }
        }

        return $productImages;
    }

    public function renderSizesLoop( $template ) {

        //Get selected on second pass.
        $sizes    = $this->product_meta['items'];
        $replaces = array();
        $market   = \EscGeneral::getCurrentMarket();
        $selected = ( count( $sizes ) === 1 ? ' checked="checked" ' : '' );
        $str      = '';
        $measures = !empty($this->product_meta['measurementChartRows']['mm']) ? $this->product_meta['measurementChartRows']['mm'] : false;

        //if( $this->product_meta['measurementChart'] === '1' && count($measures) == count($sizes) ) {
            foreach ( $sizes as $size_key => $size ) {
                $sizes[$size_key]['size'] = isset( $measures[ $size['name'] ] ) ? $measures[ $size['name'] ] . 'mm' : $size['name'];
            }
        //}

        foreach ( $sizes as $size_key => $size ) {
            $has_stock                 = !empty($size['stockByMarket'][ $market ]) && ( (int) $size['stockByMarket'][ $market ] > 0 || $size['stockByMarket'][ $market ] === 'infinite' );
            $replaces['value']         = $size['item'];
            $replaces['name']          = $size['name'];
            $replaces['size']          = $size['size'];
            $replaces['selector']      = 'esc_product_item';
            $replaces['selected']      = $selected;
            $replaces['selectedClass'] = '';
            $replaces['disabled']      = $has_stock ? '' : ' disabled="disabled" ';
            $replaces['disabledClass'] = $has_stock ? '' : ' disabled ';
            $replaces['id']            = 'select_size_' . $size['item'];
            $replaces['oneSizeHide']   = ( count( $sizes ) === 1 ? ' style="display:none;" ' : '' );
            $replaces['oneSizeClass']  = ( str_replace(' ', '', strtolower($size['name']))  == 'onesize' ) ? 'one-size' : null; 

            $str .= preg_replace_callback( '/\s?\{(.+?)\}\s?/', function ( $matches ) use ( $replaces ) {
                return $replaces[ $matches[1] ];
            }, $template );

        }
        echo $str;
    }

    public function sizesAvailable( $sizesAvailable = 0 ){
        $market = \EscGeneral::getCurrentMarket();
        $sizes  = $this->product_meta['items'];

        foreach ( $sizes as $size_key => $size ) {
            $has_stock      = (int) !empty($size['stockByMarket'][ $market ]) && ( $size['stockByMarket'][ $market ] > 0  || $size['stockByMarket'][ $market ] === 'infinite' );
            $sizesAvailable += ( $has_stock == true ) ? 1 : 0;
        }

        return $sizesAvailable;
    }

    public function renderStartPurchaseForm( $class='' ) {
        $post = $this->product_post;
        $item = reset( $this->product_meta['items'] );

        echo '<form id="js-selectProduct" class="js-selectProductSingle '. $class .'" data-name="' . $this->product_meta['name'] . '" data-sku="' . $this->product_meta['sku'] . '" method="POST">';
        echo '<input type="hidden" name="esc_action" value="esc_select_product">';
        echo '<input type="hidden" name="esc_post" value="' . $post->ID . '">';            
        echo '<input type="hidden" name="esc_product_item" value="' . $item['item'] . '">';
        wp_nonce_field( 'add_' . $post->ID . '_to_selection' );
    }

    public function renderAddToCartButton( $buttonTextTranslation = null, $buttonClass = 'button-buy' ) {
        $priceInfo = \EscGeneral::getPrice( $this->product_post->ID );
        $sizesAvailable = $this->sizesAvailable();  

        // $buttonClass = null;
        $buttonAttr = null;
        $buttonText = $buttonTextTranslation['buy_button'];

        $isAvailable = \EscGeneral::isAvailable( $this->product_post->ID );
        
        $priceAsNumber = !empty( $priceInfo['info']['price'] ) ? $priceInfo['info']['price'] : '';
        $priceBeforeAsNumber = !empty( $priceInfo['info']['priceBeforeDiscount'] ) ? $priceInfo['info']['priceBeforeDiscount'] : '';

        //$priceAsNumber = $priceInfo['info']['price'];
        //$priceBeforeAsNumber = $priceInfo['info']['priceBeforeDiscount'];     

        if( $sizesAvailable === 0  || empty( $isAvailable['info'] ) || $isAvailable['info']['stockOfAllItems'] === 0 ) {
            $buttonClass .= ' is-sold-out';
            $buttonAttr = 'disabled';
            $buttonText = $buttonTextTranslation['product_states']['sold_out'];
        } /*elseif( !empty($priceInfo['info']) && ($priceInfo['info']['showAsOnSale'] || ($priceBeforeAsNumber && $priceBeforeAsNumber > $priceAsNumber ) ) ) {
            $buttonClass .= ' is-lower-price';
        }*/

        $buttonContentOrder = array( 0 => 'button', 1=>'price' );
        if( $buttonClass == 'button-buy-sticky' ) {
            krsort( $buttonContentOrder );      
        }
        ?>

        <button class="<?php echo $buttonClass; ?>" <?php echo $buttonAttr; ?>>
            <span class="button-wrapper" role="text">
                <?php
                 
                foreach( $buttonContentOrder as $item ) : 
                    if( $item === 'button' ) :
                    ?>
                    <span class="button-col"><?php echo $buttonText; ?></span>

                    <?php else : ?>
                        <?php if( $priceInfo['success'] ) : ?>
                        <span class="button-col">
                            <?php

                            if( $priceInfo['info']['showAsOnSale'] || ($priceBeforeAsNumber && $priceBeforeAsNumber > $priceAsNumber ) ) { // On Sale
                                echo '<strong class="price is-sale">'. $priceAsNumber .'</strong>';
                                echo '<span class="old-price">'. $priceBeforeAsNumber.'</span>'; // Original Price
                            } else {
                                echo '<span class="price">'. $priceAsNumber .'</span>';
                            }
                            ?>
                        </span>
                        <?php endif; ?>

                    <?php endif; ?>
                <?php endforeach; ?>
            </span>
        </button>

        <?php
    }

    public function renderProductImages( $imageSize = 'thumb', $showOnlyFirst = true ) {

        $figureClass = 'product-thumb-image';
        $imageAttr = array();   

        if( !$showOnlyFirst ) {
            $imageSize = 'big';
            $figureClass .= ' item';
            $imageAttr = array( 'onload' => 'this.className += \' loaded\';' );         
        }

        $images = $this->getProductImages( $imageSize, $imageAttr );

        echo ( !$showOnlyFirst && count($images) > 1 ) ? '<div class="product-thumb-slider js-slider has-autoplay">' : null;

        if( $images ) {
            foreach( $images as $key => $item ) {
                if( $showOnlyFirst && $key > 0 ) { continue; }
                echo '<figure class="'. $figureClass .'">'. $item .'</figure>';
            }
        } else {
            echo '<figure class="'. $figureClass .'" aria-hidden="true"></figure>';
        }

        echo ( !$showOnlyFirst && count($images) > 1 ) ? '</div>' : null;
    }   

}


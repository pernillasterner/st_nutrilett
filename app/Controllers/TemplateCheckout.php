<?php

namespace App\Controllers;

use Sober\Controller\Controller;

class TemplateCheckout extends Controller
{
    private $isOocdActive;

    public function __construct()
    {
        $this->isOocdActive = ( in_array( 'oocd/oocd.php', get_option( 'active_plugins' ) ) ) ? true : false;
    }

    public function oocd_field()
    {
        if ( get_option( 'oocd_data' ) && $this->isOocdActive ) {
            $atts = '';

            if ( isset( $_SESSION[ 'OocdConsentsCT' ] ) && $_SESSION[ 'OocdConsentsCT' ] ) {
                $checksData = array();

                foreach ( $_SESSION[ 'OocdConsentsCT' ] as $key => $item ) {
                    $value = ( $item[ 'consented' ] ) ? 'true' : 'false';
                    $checksData[] = $key . '|' . $value;
                }

                $atts = 'checks="' . implode( ',', $checksData ) . '"';
            }

            return do_shortcode( '[oocd_consent ' . $atts . ']' );
        }

        return null;
    }
    
    public function content()
    {
        return App::get_content( get_post()->ID, 1 );
    }

    public function checkoutHeader()
    {   
        $translations = App::getSiteTranslations()->selections;

        return (object) [
            'title' => get_post()->post_title,
            'shop_link' => $translations['shop_link'] ?? [] 
        ];
    }
    
    public function noSelectedItemContent()
    {   
        $content = get_field( 'no_items_content' );

        return (object) [
            'title' => !empty($content['title']) ? $content['title'] : '',
            'text' => !empty($content['text']) ? $content['text'] : '',
        ];
    }

    public function pageContent()
    {   
        return self::getPageContent();
    }    
    
    public function selection()
    {
        return self::selectionInit();
    }

    public function noItems()
    {
        $selectedData = \EscGeneral::getSelection();
        $selectedItems = (int) $selectedData['total_items'];

        return ( !\EscSelection::hasSelection() || $selectedItems === 0 );
    }

    public static function getPageContent()
    {
        $translations = App::getSiteTranslations()->selections;
        return (object) [
            'additional_options' => get_field( 'options_content' ),
            'order' => get_field( 'order_content' ),
            'payment' => get_field( 'payment_content' ),
            'delivery' => get_field( 'delivery_content' ),
            'success_add_to_cart' => $translations['success_add_to_cart'],
            'failed_add_to_cart' => $translations['failed_add_to_cart']
        ];
    }

    public static function selectionInit()
    {
        return new \EscSelection();
    }    

    public static function newsletterField()
    {
        $selection = self::selectionInit();
        $translation = self::getPageContent();
        $text = $translation->additional_options['signup_for_newsletter'] ?? 'I agree to subscribe to the newsletter.';

        $selection->checkFieldTemplate('
        <input type="{type}" class="custom-control-input" id="{id}" name="{name}" value="{value}" {checked}>
        <label class="custom-control-label" for="{id}">{content}</a></label>
        ');

        return $selection->renderField( 'newsletter', $text );
    }

    public static function startSelectionForm()
    {
        return self::selectionInit()->renderStartSelectionForm();
    }

    public static function endSelectionForm()
    {
        return self::selectionInit()->renderEndSelectionForm();
    }    

}
<?php

namespace App\Controllers\Partials;

use App\Classes\Helper;

trait General
{
    // public static function siteTranslate( $fieldName )
    // {
    //     return get_field( $fieldName, Helper::current_lang() );
    // }
    
    public static function renderTitle( $title, $class='', $isH1=false )
    {
        if ($isH1) {
            return '<h1 class="'.$class.'">'.$title.'</h1>';
        } else {
            return '<h2 class="'.$class.'">'.$title.'</h2>';
        }
    }

    public static function getSizeGuideData()
    {
        return (object) [
            'image' => wp_get_attachment_image_url( get_field( 'size_guide_image', Helper::current_lang() ), 'full' ),
            'chart' => self::getSizeGuideChart()
        ];
    }
    
    public static function getDefaultUsp()
    {
        $defaultUsp = get_field( 'default_usp', Helper::current_lang() );
        $list = $defaultUsp['usp'] ?? []; 

        return $list;
    }

    public static function getResellerLists()
    {
        $posts = get_posts([
            'post_type' => 'reseller',
            'posts_per_page'=> -1,
            'meta_key' => 'city',
            'orderby' => 'meta_value',
            'order' => 'ASC'
        ]);
    
        return array_map( function ($post) {
            $url = get_field( 'website', $post->ID );

            $link = [
                'url' => $url,
                'title' => preg_replace( "(^https?://)", "", $url ),
                'target' => '_blank',
            ];

            return [
                'title' => $post->post_title,
                'country' => get_field( 'country', $post->ID ),
                'city' => get_field( 'city', $post->ID ),
                'link' => $link,
                'is_agent' => get_field( 'is_agent', $post->ID ),
            ];
        }, $posts );
    }

    public static function getSiteTranslations()
    {
        return (object) [
            'articles' => get_field( 'translate_articles', 'global' ),
            'recipe' => get_field( 'translate_recipe', 'global' ),
            'selected_product' => get_field( 'translate_selected_product', 'global' ),
            'general' => get_field( 'translate_general', 'global' ),
            'product_listing' => get_field( 'translate_product_listing', 'global' ),
            'review' => get_field( 'translate_review', 'global' ),
            'selections' => get_field( 'translate_selections', 'global' ),
        ];
    }    

    public static function getSocialLinks()
    {
        return get_field( 'links', 'global' );
    }

    public static function title()
    {
        if ( is_home() ) {
            if ( $home = get_option( 'page_for_posts', true ) ) {
                return get_the_title( $home );
            }
            return __( 'Latest Posts', 'sage' );
        }
        if ( is_archive() ) {
            return get_the_archive_title();
        }
        if ( is_search() ) {
            return sprintf( __( 'Search Results for %s', 'sage' ), get_search_query() );
        }
        if ( is_404() ) {
            return __( 'Not Found', 'sage' );
        }
        return get_the_title();
    }
    
    public static function getSizeGuideChart()
    {   
        $sizeGuideContent = get_field( 'size_guide_chart_content', Helper::current_lang() );
        $chartX = !empty($sizeGuideContent['chart_x']) ? $sizeGuideContent['chart_x'] : '';
        $chartY = !empty($sizeGuideContent['chart_y']) ? $sizeGuideContent['chart_y'] : '';
        $content = !empty($sizeGuideContent['content']) ? $sizeGuideContent['content'] : '';

        // Parse header X to array
        $headerX = Helper::sp_split_string( ';', $chartX );
 
        // Parse header Y to array
        $headerY = Helper::sp_split_string( ';', $chartY );

        // Parse content value to array
        $contentRow = Helper::sp_split_string( '/<br[^>]*>/i', $content, 'preg_split' );

        // Return no content
        if (empty($headerY) || empty($contentRow)) {
            return false;
        }

        $contentArr = [];

        foreach ($headerY as $key=>$val) {
            $tempRowValue = [];

            if (!empty($contentRow[ $key ])) {

                $contentColumn = Helper::sp_split_string( '|', $contentRow[ $key ] );

                foreach ($headerX as $i=>$col) {
                    if (empty($contentColumn[ $i ])) { continue; }
                    $tempRowValue[ $col ] = Helper::sp_split_string( ',', $contentColumn[ $i ] );
                }

            }

            $contentArr[ $val ] = $tempRowValue;
        }

        return (object) [
            'header_x' => $headerX,
            'header_y' => $headerY,
            'content' => $contentArr,
            'has_content' => (array_filter($headerX) || array_filter($headerY) || array_filter($contentArr))
        ];
    }
}
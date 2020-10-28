<?php

namespace App\Controllers\Partials;


use App\Classes\VideoHelper;
use App\Classes\Helper;
use App\Classes\SectionHelper;

trait Content
{
    public function content()
    {
        return self::get_content();
    }

    public static function get_sections($postID = '')
    {
        $flexibleContent = [];

        if( is_singular( 'silk_products' ) ) {
            $flexibleContent = get_field( 'selected_product_fields', 'global' )['sections'];
        } else if($postID == 'acf-options-product-chooser-settings') {
            $flexibleContent = get_fields( 'product_chooser_settings' )['sections'];
        } else {
            if( is_home() ) {
                $postID = get_option( 'page_for_posts' );
                $sectionID = 1;
            } elseif( is_tax( 'silk_category' ) || is_category() ) {
                $postID = Helper::get_acf_term_id();
            } elseif( is_singular() ){
                $postID = get_post()->ID;
            }
    
            if( !$postID ) {
                return $data;
            }
    
            $flexibleContent = get_field( 'sections', $postID );
        }

        return $flexibleContent;
    }

    /**
     * Get page sections
     *
     * @param $postID int - ID where to get the sections
     * @param $sectionID int - Section starting value
     * @return object 
     */
    public static function get_content( $postID=null, $sectionID=0 )
    {
        $data = [];
        $flexibleContent = self::get_sections($postID);

        if ( !$flexibleContent ) {
            return $data;
        }

        // Set initial section id
        $id = $sectionID;

        foreach ( $flexibleContent as $key => $content ) {
            $functionName = 'cms_' . str_replace( '-', '_', $content[ 'acf_fc_layout' ] );

            if ( method_exists( __CLASS__, $functionName ) ) {
                $id++;
                $content['id'] = $id;
                $thisContent = (object) self::$functionName( $content );

                if ( !empty( $thisContent ) ) {
                    $thisContent->id = $id;
                    $thisContent->is_h1 = $id === 1;
                    $thisContent->classes = SectionHelper::section_layout_classes( 
                        $thisContent, 
                        $key, 
                        $flexibleContent,
                        count($flexibleContent) + $sectionID
                    );                    

                    array_push( $data, $thisContent );
                }
            }
        }

        return $data;
    }

    public static function cms_text_image( $data )
    {
        $newData = (object)$data;
        $lazyClass = '';

        if ($newData->id != 1) {
            $lazyClass = ' lazy';
        }

        $image = null;
        $imageMobile = null;
        $imgAttr = [
            'class' => 'image' . $lazyClass,
            'width' => null,
            'height' => null
        ];

        $title = SectionHelper::has_title( $newData ) ? $newData->section_title : '';

        if ( $newData->image_desktop ) {
            $imgAttr[ 'class' ] = 'image d-none d-sm-none d-md-block';
            $image = wp_get_attachment_image( $newData->image_desktop, 'hero-banner', false, $imgAttr );
        }

        return (object)[
            'acf_fc_layout' => $newData->acf_fc_layout,
            'title' => $title,
            'show_title' => $newData->show_section_title,
            'text' => $newData->text ?? '',
            'link' => is_array( $newData->link ) ? (object)$newData->link : false,
            'image' => $image,            
            'bullet_list' => $newData->bullet_list,
            'big_title' => $newData->big_title,
        ];
    }

    public static function cms_text_image_fifty_fifty( $data )
    {
        $newData = (object)$data;
        $lazyClass = '';

        if ($newData->id != 1) {
            $lazyClass = ' lazy';
        }

        $image = null;
        $imageMobile = null;
        $imgAttr = [
            'class' => 'image' . $lazyClass,
            'width' => null,
            'height' => null
        ];

        $title = SectionHelper::has_title( $newData ) ? $newData->section_title : '';

        if ( $newData->image_desktop ) {
            $imgAttr[ 'class' ] = 'image d-none d-sm-none d-md-block';
            $image = wp_get_attachment_image( $newData->image_desktop, 'hero-banner', false, $imgAttr );
        }

        return (object)[
            'acf_fc_layout' => $newData->acf_fc_layout,
            'title' => $title,
            'show_title' => $newData->show_section_title,
            'text' => $newData->text ?? '',
            'image' => $image
        ];
    }

    public static function cms_text_image_with_categories( $data )
    {
        $newData = (object)$data;
        $lazyClass = '';

        if ($newData->id != 1) {
            $lazyClass = ' lazy';
        }

        $image = null;
        $imageMobile = null;
        $imgAttr = [
            'class' => 'image'.$lazyClass,
            'width' => null,
            'height' => null
        ];

        $title = SectionHelper::has_title( $newData ) ? $newData->section_title : '';

        if ( $newData->image_desktop ) {
            $imgAttr[ 'class' ] = 'image d-none d-sm-none d-md-block';
            $image = wp_get_attachment_image( $newData->image_desktop, 'hero-banner', false, $imgAttr );
        }

        $sectionLink = null;

        if( $newData->link_to_section_id ) {
            $sectionLink = [
                'target' => '#section-' . $newData->link_to_section_id,
                'text' => $newData->link_to_section_link_text
            ];
        }

        $iconLinks = null;

        if( $newData->icon_links ) {
            foreach( $newData->icon_links as $item ) {
                $iconLinks[] = array_merge( SectionHelper::get_link( (object)$item ), [
                    'icon' => wp_get_attachment_image( $item['icon'], 'thumbnail', true, [ 'class' => 'default-image' ] ),
                    'hover_state_icon' => wp_get_attachment_image( $item['hover_state_icon'], 'thumbnail', true, [ 'class' => 'hover-image' ] ),
                ] );
            }
        }

        return (object)[
            'acf_fc_layout' => $newData->acf_fc_layout,
            'title' => $title,
            'show_title' => $newData->show_section_title,
            'text' => $newData->text ?? '',
            'link' => is_array( $newData->link ) ? (object)$newData->link : false,
            'section_link' => $sectionLink,
            'image' => $image,
            'icon_links' => $iconLinks,
        ];
    }

    public static function cms_instagram_grid( $data )
    {
        $defaultInstagram = get_field( 'default_instagram', Helper::current_lang() );

        // Get data from sitewide
        if (empty($data['override_sitewide_content']) && !empty($defaultInstagram)) {
            foreach ($defaultInstagram as $key=>$item) {
                $data[ $key ] = $item; 
            }
        }

        $data = (object) $data;
        $imageCount = 13;
        $taxQuery = [];

        if ( $hashtags = $data->filter_by_hashtag ) {
            $taxQuery = [
                'taxonomy' => 'hashtag',
                'field' => 'term_id',
                'terms' => $hashtags,
            ];
        }

        $original = SectionHelper::get_instagram_data( [
            'posts_per_page' => $imageCount,
            'ignore_sticky_posts' => 1,
            'tax_query' => !empty($taxQuery) ? [ $taxQuery ]: []
        ] );

        // Add filler if original images is less than the $imageCount value
        if ( count( $original ) < $imageCount ) {
            $fill = SectionHelper::get_instagram_data( [
                'posts_per_page' => $imageCount - count( $original ),
                'ignore_sticky_posts' => 1,
                'post__not_in' => $original,
                'tax_query' => !empty($taxQuery) ? [ $taxQuery ]: []
            ] );
        }

        $allIDs = array_merge( $original, ( $fill ?? [ ]) );
        $instaImages = array_map( function ( $id ) {
            return (object)[
                'image_small' => wp_get_attachment_image_url( get_post_thumbnail_id( $id ), 'square-small lazy' ),
                'image_large' => wp_get_attachment_image_url( get_post_thumbnail_id( $id ), 'large lazy' ),
                'link' => get_post_meta( $id, 'instagram_link', true )
            ];
        }, $allIDs );

        $instagramLinkIndex = array_search( 'instagram', array_column( self::getSocialLinks(), 'media' ) );
        $instagramLink = [];
        if ( $instagramLinkIndex !== false ) {
            $instagramLink = [
                'title' => self::getSiteTranslations()->general['follow_us'] ?? '',
                'url' => self::getSocialLinks()[ $instagramLinkIndex ]['url'],
                'target' => '_blank'
            ];
        }

        return (object)[
            'acf_fc_layout' => $data->acf_fc_layout,
            'instagram_images' => $instaImages,
            'instagram_link' => (object) $instagramLink,
            'title' => SectionHelper::has_title( $data ) ? $data->section_title : '',
            'text' => $data->text,
            'image' => $data->image ? wp_get_attachment_image_url( $data->image[ 'ID' ], 'instagram-bg' ) : '',
        ];
    }

    public static function cms_newsletter_signup( $data )
    {
        $data = (object)$data;
        $newData = $data;

        if( $newData->use_newsletter_defaults ) {
            $defaults = get_field( 'newsletter_' . $data->layout . '_defaults', 'global' );
            $newData = (object)$defaults;
            $newData->acf_fc_layout = $data->acf_fc_layout;
            $newData->layout = $data->layout;
        } else {
            $newData->title = SectionHelper::has_title( $newData ) ? $newData->section_title : '';
        }
        
        if( isset( $newData->image ) ) {
            $newData->image = $newData->image ? wp_get_attachment_image( $newData->image , 'medium' ) : null;
        }        

        return $newData;
    }

    public static function cms_popular_products( $data )
    {
        $newData = (object) $data;
        $newData->productsSlider = SectionHelper::get_products_slider( (object)[
			'show' => $newData->show,
			'products' => $newData->products,
			'product_category_product_count' => $newData->product_count,
			'product_category' => $newData->category
        ] );
    
        $newData->title = SectionHelper::has_title( $newData ) ? $newData->section_title : '';

        return $newData;
    }

    public static function cms_popular_product_bundles( $data )
    {
        $newData = (object) $data;
        $newData->productsSlider = SectionHelper::get_products_slider( (object)[
			'show' => $newData->show,
			'products' => $newData->products,
			'product_category_product_count' => $newData->product_count,
			'product_category' => $newData->category
        ], ['Bundle'] );
    
        $newData->title = SectionHelper::has_title( $newData ) ? $newData->section_title : '';

        return $newData;
    }

    public static function cms_promo_boxes( $data )
    {
        $newData = (object)$data;

        $items = SectionHelper::get_promo_data( $newData );

        // Add lazy load class
        foreach ($items as $key => $item) {
            $items[$key]->image = str_replace(array('class="', 'src="'), array('class="lazy ', 'data-src="'), $item->image);
        }

        return (object)[
            'acf_fc_layout' => $newData->acf_fc_layout,
            'items' => $items
        ];
    }

    public static function cms_5050_campaign( $data )
    {
        $newData = (object)$data;
        $hasContent = ( SectionHelper::has_title( $newData )
            || $newData->text
            || $newData->link
            || $newData->image
        );

        $newData->hasContent = $hasContent;
        $newData->title = SectionHelper::has_title( $newData ) ? $newData->section_title : '';
        $newData->link = is_array( $newData->link ) ? (object)$newData->link : false;
        $newData->image = $newData->image ? wp_get_attachment_image( $newData->image, 'medium' ) : '';

        return $newData;
    }

    public static function cms_text_with_button( $data )
    {
        $data = (object)$data;
        $data->title = SectionHelper::has_title( $data ) ? $data->section_title : '';
        $data->link = $data->link ? (object)$data->link : $data->link;
        $data->has_content = ( $data->title || $data->preamble || $data->content || $data->link );
        $data->content = Helper::sp_render_text( [
            'size_guide' => \App\template( 'partials.size-guide', [ 'size_guide' => self::getSizeGuideData() ] )
        ], $data->content );

        return $data;
    }

    public static function cms_three_promo( $data )
    {
        $newData = (object)$data;

        $items = SectionHelper::get_promo_data( $newData );

        return (object)[
            'acf_fc_layout' => $newData->acf_fc_layout,
            'title' => SectionHelper::has_title( $newData ) ? $newData->section_title : '',
            'items' => $items
        ];
    }

    public static function cms_usp( $data )
    {
        // Get Default USP from sitewide
        if ( empty( $data[ 'usp' ] ) ) {
            $data[ 'usp' ] = self::getDefaultUsp();
        }

        // Convert USP items to object
        if ( !empty($data[ 'usp' ]) ) {
            $data[ 'usp' ] = array_map( function ( $item ) {
                return (object)$item;
            }, $data[ 'usp' ] );
        }

        return $data;
    }

    public static function cms_resellers( $data )
    {
        $newData = (object) $data;

        // Get reseller lists
        $resellers = self::getResellerLists();

        // Add items to $newData
        if ( $resellers ) {
            $newData->content[ 0 ] = (object)array(
                'label' => $newData->sweden_label,
                'posts' => (object)array_filter( array_map( function ( $post ) {
                    return ( strtolower( $post[ 'country' ] ) === 'sweden' ) ? $post : null;
                }, $resellers ) )
            );

            // Global
            // $newData->content[ 1 ] = (object)array(
            //     'label' => $newData->global_label,
            //     'posts' => (object)array_filter( array_map( function ( $post ) {
            //         return ( strtolower( $post[ 'country' ] ) !== 'sweden' ) ? $post : null;
            //     }, $resellers ) )
            // );

            $newData->content[ 2 ] = (object)array(
                'label' => $newData->agent_and_distributor_label,
                'posts' => (object)array_filter( array_map( function ( $post ) {
                    return ( !empty( $post[ 'is_agent' ] ) ) ? $post : null;
                }, $resellers ) )
            );
        }

        return (object)[
            'acf_fc_layout' => $newData->acf_fc_layout,
            'title' => SectionHelper::has_title( $newData ) ? $newData->section_title : '',
            'preamble' => $newData->preamble,
            'items' => $newData->content,
            'count' => $newData->count,
            'view_all_btn' => self::getSiteTranslations()->general['view_all'] ?? ''
        ];
    }

    public static function cms_featured_article( $data )
    {
        $newData = (object) $data;
        $newData->title = $newData->article->post_title;
        $newData->link = get_permalink( $newData->article );
        $newData->image = has_post_thumbnail( $newData->article ) ? get_the_post_thumbnail( $newData->article, 'featured-article-image' ) : false;

        return $newData;
    }

    public static function cms_willpower_signup_form( $data )
    {
        $newData = (object) $data;
        $newData->image = $newData->image ? wp_get_attachment_image( $newData->image, 'medium' ) : false;
        $newData->form = do_shortcode( $newData->form_shortcode );
        $newData->title = SectionHelper::has_title( $newData ) ? $newData->section_title : '';

        return $newData;
    }

    public static function cms_article_promo( $data ) 
    {
        $newData = (object) $data;

        if( $newData->show === 'category' ) {
            $newData->title = $newData->category->name;
            $newData->text = $newData->text ?: $newData->category->description;
            $newData->link = [
                'title' => $newData->link_text,
                'url' => get_term_link( $newData->category ),
                'target' => '',
            ];
        } else {
            $newData->title = SectionHelper::has_title( $newData ) ? $newData->section_title : '';
        }
        
        if( $newData->show === 'category' ) {
            $newData->articles = get_posts([
                'post_type' => 'post',
                'post_status' => 'publish',
                'numberposts' => $newData->article_count,
                'cat' => $newData->category->term_id
            ]);
        }

        return $newData;
    }

    public static function cms_faq( $data ) 
    {
        $newData = (object) $data;
        $newData->title = SectionHelper::has_title( $newData ) ? $newData->section_title : '';
        $newData->image = $newData->image ? wp_get_attachment_image( $newData->image, 'medium' ) : '';
        $newData->faq_page = get_permalink($newData->faq_page);

        return $newData;
    }

    public static function cms_contact( $data ) 
    {
        $newData = (object) $data;
        $newData->title = SectionHelper::has_title( $newData ) ? $newData->section_title : '';

        return $newData;
    }

    public static function cms_product_chooser( $data )
    {
        return (object) $data;
    }

    public static function cms_text( $data )
    {
        return (object) $data;
    }

    public static function cms_half_text( $data )
    {
        $newData = (object) $data;
        $newData->title = SectionHelper::has_title( $newData ) ? $newData->section_title : '';
        $newData->hasContent = $newData->content && $newData->title;

        return $newData;
    }
}
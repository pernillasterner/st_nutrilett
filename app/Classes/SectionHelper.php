<?php

namespace App\Classes;

use App\Controllers\SingleSilk_products;
use App\Controllers\App;

class SectionHelper
{

    public static function has_title( $data )
    {
        return ( !empty($data->section_title) && !empty($data->show_section_title) );
    }    

    public static function get_promo_data( $data )
    {
        $items = [ ];

        if ( empty( $data->items ) ) {
            return $items;
        }

        foreach ( $data->items as $item ) {
            $item = (object)$item;

            $cardImageSize = 'medium';
            $postImage = null;
            $postTitle = null;
            $postText = null;
            $postPreHeader = null;
            $postLink = (object)[
                'url' => null,
                'title' => $data->item_link_text ?? '',
                'target' => '',
            ];

            if ( $item->get_content_from === 'category' && $item->category ) {
                $categoryImage = get_field( 'featured_image', $item->category->taxonomy . '_' . $item->category->term_id );
                $postImage = $categoryImage ? wp_get_attachment_image( $categoryImage[ 'ID' ], $cardImageSize ) : null;
                $postTitle = $item->category->name;
                $postText = $item->category->description;
                $postLink->url = get_term_link( $item->category, $item->category->taxonomy );


            } elseif ( $item->get_content_from === 'post' && $item->post ) {
                $postImage = has_post_thumbnail( $item->post ) ? get_the_post_thumbnail( $item->post->ID, $cardImageSize ) : null;
                $postTitle = $item->post->post_title;
                $postText = $item->post->post_content;
                $postLink->url = get_permalink( $item->post->ID );

                if ( $data->acf_fc_layout === 'promo-boxes' && get_post_type( $item->post ) === 'post' ) {
                    $categoryNames = wp_list_pluck( get_the_category( $item->post->ID ), 'name' );
                    $postPreHeader = !empty( $categoryNames ) ? $categoryNames[ 0 ] : null;
                }

                $postPreHeader = null;
            }

            $itemLink = !empty( $item->link ) ? (object)$item->link : $postLink;

            if ( empty( $itemLink->title ) ) {
                $itemLink->title = $data->item_link_text ?? '';
            }

            $newItem = [
                'image' => !empty( $item->image ) ? wp_get_attachment_image( $item->image[ 'ID' ], $cardImageSize ) : $postImage,
                'title' => !empty( $item->title ) ? $item->title : $postTitle,
                'text' => !empty( $item->text ) ? $item->text : wp_trim_words( $postText, 50 ),
                'link' => $itemLink,
            ];

            if ( $data->acf_fc_layout === 'promo-boxes' ) {
                $newItem[ 'pre_header' ] = !empty( $item->pre_header ) ? $item->pre_header : $postPreHeader;
            }

            if ( empty( array_filter( $newItem ) ) ) {
                continue;
            }

            array_push( $items, (object)$newItem );
        }

        return $items;
    }    

    public static function get_instagram_data( $options = [] )
    {
        $args = array(
            'post_status' => 'publish',
            'post_type' => 'instagram',
            'orderby' => 'date',
            'order' => 'DESC',
        );

        if ( $options ) {
            foreach ( $options as $key => $item ) {
                if (empty($item)) continue;

                $args[ $key ] = $item;
            }
        }

        $data = get_posts( $args );

        return wp_list_pluck( $data, 'ID' );
    }    

    public static function section_layout_classes( $currentSection, $pos, $sections, $count )
    {
        $classes = [];
        $sectionLists = wp_list_pluck( $sections, 'acf_fc_layout' );
        $previousSection = $pos === 0 ? null : $sectionLists[ $pos - 1 ];

        $sectionsWithNoBgWhite = [
            'text_image_with_categories',
            'text_image',
            '5050_campaign',
            'newsletter_signup',
            'faq'
        ];

        if( !in_array( $currentSection->acf_fc_layout, $sectionsWithNoBgWhite ) ) {
            $classes[] = $pos % 2 === 0 ? ' bg-white' : '';
        }

        if( $pos === 0
            && App::is_breadcrumbs_shown()
            && !is_singular( 'post' )
            && !is_singular( 'silk_products' )
            && !is_tax( 'silk_category' )
            && get_page_template_slug() !== 'views/template-product-listing.blade.php' ) {
            $classes[] = 'has-breadcrumbs';
            $classes[] = 'has-default';
        }

        if( $previousSection && $previousSection === 'text_image_with_categories' ) {
            $classes[] = 'is-small-top';
            $classes[] = 'is-small';
        }

        return implode( ' ', $classes );
    }

    public static function get_link( $data )
	{
		$link = array( 'text' => '', 'attr' => '' );

		switch ( $data->link_type ) {
            case 'post':
                if( isset( $data->link_post ) ) {
                    $link['url'] = get_permalink( $data->link_post );
                    $link['text'] = $data->link_post->post_title;
                }                

                break;
            case 'category':
                if( $data->link_category ) {
                    $link['url'] = get_term_link( $data->link_category );
                    $link['text'] = $data->link_category->name;
                }

                break;
            case 'product-category':
                if( $data->link_product_category ) {
                    $link['url'] = get_term_link( $data->link_product_category );
                    $link['text'] = $data->link_product_category->name;
                }				

				break;
			default:
				return null;
		}

		return $link;
    }
    
    public static function get_products_slider( $data, $productTypes = ['Single', 'Special'] )
	{
		$output = array();

		switch ( $data->show ) {
            case 'handpicked':
                if (is_array($data->products)) {
                    foreach ( $data->products as $product ) {
                        $productData = SingleSilk_products::get_product( $product->ID );
                        $currentProduct = array();
                        $currentProduct[ 'id' ] = $product->ID;
                        $currentProduct[ 'name' ] = $product->post_title;
                        $currentProduct[ 'image' ] = $productData->images[ 'standard' ][ 0 ][ 'url' ] ?? '';
                        $currentProduct[ 'display_price' ] = $productData->display_price;
                        $currentProduct[ 'link' ] = get_permalink( $product->ID );
                        $currentProduct[ 'type' ] = (isset($productData->product_meta->product_type)) ? $productData->product_meta->product_type : '';
                        $currentProduct[ 'tags' ] = isset( $productData->product_meta->product_tags ) ? implode( '|', $productData->product_meta->product_tags ) : '';
                        $currentProduct[ 'bundles' ] = $productData->bundles;
                        $currentProduct[ 'product_item' ] = $productData->product_item;
                        $currentProduct[ 'meta' ] = $productData->product_meta;
                        $currentProduct[ 'post' ] = $product;
                        $output[ ] = (object)$currentProduct;
                    }
                }

				break;
			case 'category':
				$products = get_posts( array(
					'post_type' => 'silk_products',
					'numberposts' => isset( $data->product_category_product_count ) ? $data->product_category_product_count : -1,
					'post_status' => 'publish',
					// 'post__not_in' => [ get_the_ID() ],
					'tax_query' => array(
						array(
							'taxonomy' => 'silk_category',
							'terms' => $data->product_category,
						)
                    ),
                    'meta_query' => array(
                        'relation' => 'AND',
                        array(
                            'key' => 'product_type',
                            'value' =>  $productTypes,
                            'compare' => 'IN',
                        ),
                        array(
                            'meta_key' => 'product_type',
                            'compare' => 'EXISTS',
                        )
                    )
                ) );

				foreach ( $products as $product ) {
					$productData = SingleSilk_products::get_product( $product->ID );
					$currentProduct = array();
					$currentProduct[ 'id' ] = $product->ID;
					$currentProduct[ 'name' ] = $product->post_title;
                    $currentProduct[ 'image' ] = $productData->images[ 'standard' ][ 0 ][ 'url' ] ?? '';
                    $currentProduct[ 'display_price' ] = $productData->display_price;
                    $currentProduct[ 'link' ] = get_permalink( $product->ID );
                    $currentProduct[ 'type' ] = $productData->product_meta->product_type;
                    $currentProduct[ 'tags' ] = isset( $productData->product_meta->product_tags ) ? implode( '|', $productData->product_meta->product_tags ) : '';
                    $currentProduct[ 'bundles' ] = $productData->bundles;
                    $currentProduct[ 'product_item' ] = $productData->product_item;
                    $currentProduct[ 'meta' ] = $productData->product_meta;
                    $currentProduct[ 'post' ] = $product;
					$output[ ] = (object)$currentProduct;
				}

				break;
        }

		return $output;
	}
}
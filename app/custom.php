<?php

namespace App;

use App\Classes\Product;
use App\Classes\Helper;
use App\Controllers\SingleSilk_products;

// Disable search page
add_action( 'parse_query', function( $query, $error = true ) {
    if ( is_search() && !is_admin() ) {
        $query->is_search = false;
        $query->query_vars['s'] = false;
        $query->query['s'] = false;

        if ( $error == true )
            $query->is_404 = true;
    }
} );

add_filter( 'get_search_form', function ( $a ) {
    return null;
} );

// Unregister Search widget
add_action( 'widgets_init', function() {
    unregister_widget( 'WP_Widget_Search' );
} );

// Make flexible content layout title dynamic
add_filter( 'acf/fields/flexible_content/layout_title/name=sections', function( $title, $field, $layout, $i ) {
    return ( get_sub_field( 'section_title' ) ) ? get_sub_field( 'section_title' ) . ' - ' . $title : $title;
}, 10, 4);

// Update Product Acf Result
function updateProductAcfResult( $title, $post, $field, $post_id ) {
	if( !class_exists( 'Esc' ) ) {
		return $title;
	}

	// add post type to each result
	$product = new Product( $post->ID );
	$variantName = !empty( $product->product_meta[ 'variantName' ] ) ? $product->product_meta[ 'variantName' ] : '';

	if( !empty( $variantName ) ) {
		$title .= ' ' . $variantName;
	}

	return $title;
}

add_filter( 'acf/fields/post_object/result/name=product', __NAMESPACE__ . '\\updateProductAcfResult', 10, 4 );
add_filter( 'acf/fields/relationship/result/name=handpicked_products', __NAMESPACE__ . '\\updateProductAcfResult', 10, 4 );

// Map section to specific template that they should appear.
// If layout does not exists in the mapping, then the layout will always appear in the section
add_filter( 'acf/prepare_field/name=sections', function( $field ) {
    global $post;

    $mapping =  array( 
        'resellers' => array( 'views/template-resellers.blade.php' ) 
    );

    $layouts = $field['layouts'];
    $field['layouts'] = [];

    foreach ($layouts as $layout) {

        $key = $layout['name'];

        // if the layout name isn't in our mapping array
        if ( ! array_key_exists($key, $mapping)) {
            $field['layouts'][] = $layout;
            continue;
        }
        
        if( in_array( get_page_template_slug($post), $mapping[$key] ) ) {
            $field['layouts'][] = $layout;
        }
    }

    return $field;
});

// Register Format dropdown
add_filter( 'mce_buttons_2', function( $buttons ) {
	array_unshift( $buttons, 'styleselect' );
	return $buttons;
} );

// Attach callback to 'tiny_mce_before_init' 
add_filter( 'tiny_mce_before_init', function( $initArray ) {
    // Add style format 
	$styleFormats = array(  
		array(  
			'title' => 'Indent',  
			'block' => 'p',  
			'classes' => 'has-padding',
			'wrapper' => false,
			
		),  
    );  
    
    $initArray['style_formats'] = wp_json_encode( $styleFormats );  
    
    // Update Indent Format style
    $styles = 'p.has-padding { padding-left: 4.875rem; }';
    if ( isset( $initArray['content_style'] ) ) {
        $initArray['content_style'] .= ' ' . $styles . ' ';
    } else {
        $initArray['content_style'] = $styles . ' ';
    }
	
	return $initArray;
  
}  );


// // Add data-src to Images with lazy load
// add_filter( 'wp_get_attachment_image_attributes', function ( $attr ) {
//     if( is_admin() ) {
//         return $attr;
//     }

//     $existingClasses = isset($attr['class']) ? explode( ' ', $attr['class'] ) : [];

//     if ( !in_array( 'lazy', $existingClasses ) ) {
//         $existingClasses[] = 'lazy';
//     }    

//     if (isset( $attr['class'] ) && in_array( 'lazy', $existingClasses )) {
//         $attr['data-src'] = isset($attr['src']) ? $attr['src'] : '';
//         unset($attr['src']);

//         $attr['data-srcset'] = isset($attr['srcset']) ? $attr['srcset'] : '';
//         unset($attr['srcset']);
//     }

//     $attr['class'] = implode(' ', $existingClasses);    
 
//     return $attr;
// } );

// Added plugin dependency check 
add_action( 'after_setup_theme', function() {

    $plugins = array(
        'ecommerce-silk-connection/ecommerce-silk-connection.php',
        'advanced-custom-fields-pro/acf.php'
    );

    foreach ($plugins as $plugin) {
     if(!is_admin() && ! in_array( $plugin, (array) get_option( 'active_plugins', array() ) ) ) {

        wp_die( 'The following plugin is needed: ' . $plugin, 'Plugin Dependency Error' );

     }   
    }
});

// Update product category slug to avoid conflict on saving category with duplicated slug
add_filter( 'wp_unique_term_slug', function ( $slug, $term, $original_slug ) {
	if( $term->taxonomy === 'silk_category' ) {
		return $original_slug;
	}

	return $slug;
}, 10, 3 );

/**
 * Image sizes
 */
add_action( 'after_setup_theme', function() {
    add_image_size( 'hero-banner', 615, 555, false );
    add_image_size( 'article-listing', 400, 300, true );
    add_image_size( 'article-image', 1280, 640, true );
    add_image_size( 'featured-article-image', 615, 461, true );
    update_option( 'large_size_w', 1200 );
    update_option( 'large_size_h', 1200 );
    update_option( 'large_crop', 0 );
    update_option( 'medium_size_w', 640 );
    update_option( 'medium_size_h', 640 );
    update_option( 'medium_crop', 1 );
    update_option( 'large_crop', 0 );
} );

/**
 * Disable srcset because it interferes with lazy load
 */
add_filter( 'max_srcset_image_width', function () {
	return 1;
} );

/**
 * Modify post types than can be linked in insert/edit link popup
 */
add_filter( 'wp_link_query_args', function( $query ) {
    $query['post_type'] = ['post', 'page', 'silk_products'];

    return $query;
} );

/**
 * Include post and product categories to insert/edit link popup
 */
add_filter( 'wp_link_query', function( $results, $query ) {
    if( $query['offset'] !== 0 ) {
        return $results;
    }
    
    $args = ['taxonomy' => ['category', 'silk_category']];

    if( isset( $query['s'] ) ) {
        $args['search'] = $query['s'];
    }

    $categories = get_terms( $args );

    foreach( $categories as $item ) {
        $results[] = [
            'ID' => $item->term_id,
		    'title' => $item->name,
		    'permalink' => get_term_link( $item ),
		    'info' => strtoupper( $item->taxonomy )
        ];
    }
    
    return $results;
}, 10, 2 );

/**
 * Allow order by menu order in REST API
 */
add_filter( 'rest_post_collection_params', function ( $params ) {
    $params['orderby']['enum'][] = 'menu_order';

    return $params;
}, 10, 1 );

/**
 * Do drafting of special product bundles
 */
add_action( 'owc_products_saved', function( $products ) {
    $postIdsToDraft = [];
    $specialProductsMapping = [];
    $bundleProductMapping = [];

    foreach( $products as $product ) {
        if( !isset( $product['product_type'] ) ) {
            continue;
        }

        if( $product['product_type'] === 'Special' && isset( $product['relatedProducts'] ) ) {
            $currentRelatedProducts = [];
            $specialProductPost = get_posts( [
                'post_type' => 'silk_products',
                'meta_key' => 'product_id',
                'meta_value' =>  $product['product'],
                'numberposts' => 1,
                'post_status' => 'publish,draft',
            ] );

            if( !$specialProductPost || !isset( $specialProductPost[0]->ID ) ) {
                continue;
            }

            $specialProductPost = $specialProductPost[0];
            $specialProductsMapping[$specialProductPost->ID] = Helper::process_special_product( $specialProductPost, $product );
            $postIdsToDraft = array_merge( $postIdsToDraft, $specialProductsMapping[$specialProductPost->ID] );
        } else if( $product['product_type'] === 'Bundle' && isset( $product['bundle'] ) && isset( $product['bundle']['products'] ) ) {
            $bundlePost = get_posts( [
                'post_type' => 'silk_products',
                'meta_key' => 'product_id',
                'meta_value' =>  $product['product'],
                'numberposts' => 1,
                'post_status' => 'publish,draft',
            ] );

            if( !$bundlePost || !isset( $bundlePost[0]->ID ) ) {
                continue;
            }

            $bundlePost = $bundlePost[0];

            $bundleProductMapping[$bundlePost->ID] =  Helper::process_bundle( $bundlePost, $product );
        }
    }    
        
    $postIdsToDraft = array_values( array_unique( $postIdsToDraft ) );

    if( $postIdsToDraft ) {
        foreach( $postIdsToDraft as $item ) {
            wp_update_post( array(
                'ID' => $item,
                'post_status' => 'draft',
            ) );
        }
    }

    update_option( 'special_products_mapping', $specialProductsMapping );
    update_option( 'bundle_products_mapping', $bundleProductMapping );
} );

/**
 * Relationship fields query updates
 */
add_filter( 'acf/fields/relationship/query', function ( $args, $field, $post_id ) {	
    // Hide drafts from relationship field
    $args['post_status'] = 'publish';

    // For popular product bundles relationship field, filter non-bundle products
    if( $field['key'] === 'field_5dd770fbe25af' ) {
        $args['meta_query'] = [
            'relation' => 'AND',
            [
                'key' => 'product_type',
                'value' => 'Bundle',
            ],
            [
                'meta_key' => 'product_type',
                'compare' => 'EXISTS',
            ]
        ];
    }
	
    return $args;    
}, 10, 3);

/**
 * Create product type column
 */
add_filter( 'manage_edit-silk_products_columns', function ( $columns ) {
    return Helper::sp_array_insert( $columns, 2, [
        'product_type' => 'Product Type'
    ] );
}, 10, 1 );

add_action( 'manage_silk_products_posts_custom_column', function ( $columnName, $postID ) {
	if( $columnName === 'product_type' ) {
        echo get_post_meta( $postID, 'product_type', true );
    }
}, 10, 2 );

add_filter( 'ois_search_result_template', function() {
    return get_stylesheet_directory() . '/search/search-results.php';
} );

/**
 * Modify GTM data
 */
add_filter( 'stoked_gtm_data', function( $productSchema, $products ) {
    if( isset( $productSchema['ecommerce']['detail'] ) ) {        
        $productData = SingleSilk_products::get_product( $products[0]->ID );
        $dimensions = Helper::get_dimensions( $productData );
        $productSchema['event'] = 'ee.product detail impressions';
        $productSchema['ecommerce']['detail']['products'][0]['price'] = $dimensions->price;
        $productSchema['ecommerce']['detail']['products'][0]['dimension3'] = $productData->is_sold_out ? 'Out of Stock' : 'In Stock';
        $productSchema['ecommerce']['detail']['products'][0]['dimension4'] = $dimensions->priceBefore;
        $productSchema['ecommerce']['detail']['products'][0]['dimension5'] = $dimensions->price;
        $productSchema['ecommerce']['detail']['products'][0]['dimension6'] = $dimensions->discountPercent ?: 0;
    } elseif( isset( $productSchema['ecommerce']['purchase'] ) ) {
        if( !isset( $_SESSION[ 'esc_selection' ] ) ) {
            return $productSchema;
        }

        $market = $_SESSION[ 'esc_selection' ]['market'];

        for( $i=0; $i < count( $productSchema['ecommerce']['purchase']['products'] ); $i++ ) {            
            $productData = SingleSilk_products::get_product( $products[$i]->ID );

            if( !isset( $productData->product_meta->markets[$market] ) || !isset( $productData->product_meta->markets[$market]['stockOfAllItems'] ) ) {
                break;
            }
            
            // If it is a draft product (special product bundle), get the category of the main product
            if( $products[$i]->post_status === 'draft' ) {    
                $mainPostID = Helper::get_main_product( $products[$i]->ID );
                $category = Helper::get_category( $mainPostID, 'silk_category' );
                $productSchema['ecommerce']['purchase']['products'][$i]['category'] = $category->name;
            }
            
            $dimensions = Helper::get_dimensions( $productData );
            $productSchema['ecommerce']['purchase']['products'][$i]['price'] = $dimensions->price;
            $productSchema['ecommerce']['purchase']['products'][$i]['dimension3'] = $productData->is_sold_out ? 'Out of Stock' : 'In Stock';
            $productSchema['ecommerce']['purchase']['products'][$i]['dimension4'] = $dimensions->priceBefore;
            $productSchema['ecommerce']['purchase']['products'][$i]['dimension5'] = $dimensions->price;
            $productSchema['ecommerce']['purchase']['products'][$i]['dimension6'] = $dimensions->discountPercent ?: 0;
            $productSchema['ecommerce']['purchase']['products'][$i]['metric4'] = $productData->product_meta->markets[$market]['stockOfAllItems'];
            $productSchema['ecommerce']['purchase']['products'][$i]['metric5'] = $dimensions->priceBefore;
            $productSchema['ecommerce']['purchase']['products'][$i]['metric6'] = $dimensions->price;
        }

        $productSchema['event'] = 'ee.purchases';
    } elseif( isset( $productSchema['event'] ) ) {
        if( $productSchema['event'] === 'addToCart' ) {
            for( $i=0; $i < count( $productSchema['ecommerce']['add']['products'] ); $i++ ) {
                $productData = SingleSilk_products::get_product( $products[$i]->ID );
                $dimensions = Helper::get_dimensions( $productData );
                $productSchema['ecommerce']['add']['products'][$i]['price'] = $dimensions->price;
                $productSchema['ecommerce']['add']['products'][$i]['dimension3'] = $productData->is_sold_out ? 'Out of Stock' : 'In Stock';
                $productSchema['ecommerce']['add']['products'][$i]['dimension4'] = $dimensions->priceBefore;
                $productSchema['ecommerce']['add']['products'][$i]['dimension5'] = $dimensions->price;
                $productSchema['ecommerce']['add']['products'][$i]['dimension6'] = $dimensions->discountPercent ?: 0;
            }

            $productSchema['event'] = 'ee.addToCart';
        } elseif( $productSchema['event'] === 'removeFromCart' ) {
            for( $i=0; $i < count( $productSchema['ecommerce']['remove']['products'] ); $i++ ) {
                $productData = SingleSilk_products::get_product( $products[$i]->ID );
                $dimensions = Helper::get_dimensions( $productData );
                $productSchema['ecommerce']['remove']['products'][$i]['price'] = $dimensions->price;
                $productSchema['ecommerce']['remove']['products'][$i]['dimension3'] = $productData->is_sold_out ? 'Out of Stock' : 'In Stock';
                $productSchema['ecommerce']['remove']['products'][$i]['dimension4'] = $dimensions->priceBefore;
                $productSchema['ecommerce']['remove']['products'][$i]['dimension5'] = $dimensions->price;
                $productSchema['ecommerce']['remove']['products'][$i]['dimension6'] = $dimensions->discountPercent ?: 0;
            }

            $productSchema['event'] = 'ee.removeFromCart';
        } elseif( $productSchema['event'] === 'checkout' ) {
            for( $i=0; $i < count( $productSchema['ecommerce']['checkout']['products'] ); $i++ ) {
                // If it is a draft product (special product bundle), get the category of the main product
                if( $products[$i]->post_status === 'draft' ) {    
                    $mainPostID = Helper::get_main_product( $products[$i]->ID );
                    $category = Helper::get_category( $mainPostID, 'silk_category' );
                    $productSchema['ecommerce']['checkout']['products'][$i]['category'] = $category->name;
                }

                $productData = SingleSilk_products::get_product( $products[$i]->ID );
                $dimensions = Helper::get_dimensions( $productData );
                $productSchema['ecommerce']['checkout']['products'][$i]['price'] = $dimensions->price;
                $productSchema['ecommerce']['checkout']['products'][$i]['dimension3'] = $productData->is_sold_out ? 'Out of Stock' : 'In Stock';
                $productSchema['ecommerce']['checkout']['products'][$i]['dimension4'] = $dimensions->priceBefore;
                $productSchema['ecommerce']['checkout']['products'][$i]['dimension5'] = $dimensions->price;
                $productSchema['ecommerce']['checkout']['products'][$i]['dimension6'] = $dimensions->discountPercent ?: 0;
            }

            $productSchema['event'] = 'ee.checkout';
        }        
    }

    return $productSchema;
}, 10, 2 );

/**
 * Product update for payload
 */
add_action( 'owc_silk_update_product', function( $postID, $product ) {
    $productPost = get_post( $postID );

    if( !isset( $product['product_type'] ) ) {
        return;
    }

    if( $product['product_type'] === 'Special' && isset( $product['relatedProducts'] ) ) {
        Helper::process_special_product( $productPost, $product );
    } else if( $product['product_type'] === 'Bundle' && isset( $product['bundle'] ) && isset( $product['bundle']['products'] ) ) {
        Helper::process_bundle( $productPost, $product );
    }

    // Update also the main products (if the product is a bundle product)
    $bundleProductsMapping = get_option( 'bundle_products_mapping' );

    foreach( $bundleProductsMapping as $key => $values ) {
        if( in_array( $postID, $values ) ) {
            $currentBundlePost = get_post( $key );
            $currentBundleProductData = get_post_meta( $key, 'product_data', true );

            Helper::process_bundle( $currentBundlePost, $currentBundleProductData );
        }
    }
}, 10 ,2 );

/**
 * Keep custom post meta fields for product
 */
add_filter( 'silk_filter_add_custom_post_meta', function( $postMeta, $postId ) {
    $postMeta[$postId]['is_bundle_available'] = get_post_meta( $postId, 'is_bundle_available', true );

    return $postMeta;
}, 10, 2 );

add_action( 'wp_head', function(){
    echo "<script>window.dataLayer = window.dataLayer || [];</script>\r\n";
} );
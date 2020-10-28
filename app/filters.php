<?php

namespace App;

/**
 * Add <body> classes
 */
add_filter('body_class', function (array $classes) {
    /** Add page slug if it doesn't exist */
    if (is_single() || is_page() && !is_front_page()) {
        if (!in_array(basename(get_permalink()), $classes)) {
            $classes[] = basename(get_permalink());
        }
    }

    /** Add class if sidebar is active */
    if (display_sidebar()) {
        $classes[] = 'sidebar-primary';
    }

    /** Clean up class names for custom templates */
    $classes = array_map(function ($class) {
        return preg_replace(['/-blade(-php)?$/', '/^page-template-views/'], '', $class);
    }, $classes);

    return array_filter($classes);
});

/**
 * Add "… Continued" to the excerpt
 */
add_filter('excerpt_more', function () {
    return ' &hellip; <a href="' . get_permalink() . '">' . __('Continued', 'sage') . '</a>';
});

/**
 * Template Hierarchy should search for .blade.php files
 */
collect([
    'index', '404', 'archive', 'author', 'category', 'tag', 'taxonomy', 'date', 'home',
    'frontpage', 'page', 'paged', 'search', 'single', 'singular', 'attachment', 'embed'
])->map(function ($type) {
    add_filter("{$type}_template_hierarchy", __NAMESPACE__.'\\filter_templates');
});

/**
 * Render page using Blade
 */
add_filter('template_include', function ($template) {
    collect(['get_header', 'wp_head'])->each(function ($tag) {
        ob_start();
        do_action($tag);
        $output = ob_get_clean();
        remove_all_actions($tag);
        add_action($tag, function () use ($output) {
            echo $output;
        });
    });
    $data = collect(get_body_class())->reduce(function ($data, $class) use ($template) {
        return apply_filters("sage/template/{$class}/data", $data, $template);
    }, []);
    if ($template) {
        echo template($template, $data);
        return get_stylesheet_directory().'/index.php';
    }
    return $template;
}, PHP_INT_MAX);

/**
 * Render comments.blade.php
 */
add_filter('comments_template', function ($comments_template) {
    $comments_template = str_replace(
        [get_stylesheet_directory(), get_template_directory()],
        '',
        $comments_template
    );

    $data = collect(get_body_class())->reduce(function ($data, $class) use ($comments_template) {
        return apply_filters("sage/template/{$class}/data", $data, $comments_template);
    }, []);

    $theme_template = locate_template(["views/{$comments_template}", $comments_template]);

    if ($theme_template) {
        echo template($theme_template, $data);
        return get_stylesheet_directory().'/index.php';
    }

    return $comments_template;
}, 100);

/**
 * ACF save json folder
 */
add_filter( 'acf/settings/save_json', function ( $path ) {
    return get_stylesheet_directory() . '/acf-json';
});

/**
 * ACF load json folder
 */
add_filter( 'acf/settings/load_json', function ( $paths ) {
    $paths[] = get_stylesheet_directory() . '/acf-json';
    return $paths;
});


// TODO: Maybe move all of the following Centra related filters to the Esc Plugin instead

/**
 * Add filters to query_vars
 */
// add_filter( 'query_vars', function ( $vars ) {
//     $vars[] = "filters";
//     return $vars;
// });

/**
 * Order Centra Products for Category
 */
add_filter( 'pre_get_posts', function ( $query ) {

    // End process if wp admin
    if( is_admin() ) { return; }

    $taxonomy = 'silk_category';
    if ( isset( $query->query[ $taxonomy ] ) && $query->is_main_query() ) {

        $productListingCount = get_field('settings_product_listing_count', 'global');
        $productListingCount = (!empty($productListingCount)) ? $productListingCount : '-1';
        $query->set( 'posts_per_page', $productListingCount );

        // Category filter from Centra
        $filter_query = silk_product_filter();
        // If no filter is selected default category to current one
        // This will prevent inconsitency with Rest API
        if (!is_array($filter_query) && isset(get_queried_object()->slug)) {
            $filter_query = array(
                array(
                    'taxonomy'     => 'silk_category',
                    'field'     => 'slug',
                    'terms'     => array(get_queried_object()->slug)
                )
            );
        }
        $query->set( 'tax_query', $filter_query );

        // Category sort from Centra
        if (isset(get_queried_object()->term_id)) {
            $_GET['termid'] = get_queried_object()->term_id;
            $orderby = silk_product_orderby();
            if (is_array($orderby)) {
                $query->set( 'orderby', $orderby['orderby'] );
                $query->set( 'order', $orderby['order'] );   
                if (isset($orderby['meta_key'])) {
                    $query->set( 'meta_key', $orderby['meta_key'] );
                }
            }
        }
    }
});

/**
 * Add REST API support to an already registered post type.
 */
add_filter( 'register_post_type_args', function ( $args, $post_type ) {
 
    if ( 'silk_products' === $post_type ) {

        $args['show_in_rest'] = true;
 
        // Optionally customize the rest_base or rest_controller_class
        $args['rest_base']             = 'products';
        $args['rest_controller_class'] = 'App\Classes\Silk_Product_REST_Controller';
    }

    if ( 'post' === $post_type ) {

        $args['show_in_rest'] = true;
 
        // Optionally customize the rest_base or rest_controller_class
        $args['rest_base']             = 'articles';
        $args['rest_controller_class'] = 'App\Classes\Article_REST_Controller';
    }
 
    return $args;
}, 10, 2 );

// /**
//  * Add REST API support to poly lang language.
//  */
// add_action( 'rest_api_init', function() {
//     global $polylang;

//     $default = pll_default_language();
//     $langs = pll_languages_list();

//     $curLang = !empty($_GET['lang']) ? $_GET['lang'] : '';

//     if (!in_array($curLang, $langs)) {
//         $curLang = $default;
//     }

//     $polylang->curlang = $polylang->model->get_language( $curLang );

//     $GLOBALS['text_direction'] = $polylang->curlang->is_rtl ? 'rtl' : 'ltr';
// });

/**
 * Add REST API support to an already registered taxonomy.
 */
add_filter( 'register_taxonomy_args', function ( $args, $taxonomy ) {
 
    if ( 'silk_category' === $taxonomy ) {

        $args['show_in_rest'] = true;
        $args['query_var'] = true;
    }
 
    return $args;
}, 10, 2 );

/**
 * Check the orderby param for the particular REST API for hte custom post type. 
 */
add_filter( 'rest_silk_products_collection_params', function ( $params ) {

    $params['orderby']['enum'][] = 'price_low';
    
    return $params;
}, 10, 1 );

add_filter( 'rest_query_vars', function ( $valid_vars ) {
    return array_merge( $valid_vars, array( 'meta_query', 'tax_query' ) );
} );

/**
 * Check the orderby param for the particular REST API for hte custom post type. 
 */
add_filter( 'rest_silk_products_query', function ( $query_vars, $request ) {

    // Category filter from Centra
    $filter_query = silk_product_filter();
    if (is_array($filter_query)) {
        $query_vars = array_merge($query_vars, $filter_query);
    }

    // Category sort from Centra
    $orderby = silk_product_orderby();
    if (is_array($orderby)) {
        $query_vars = array_merge($query_vars, $orderby);
    }

    return $query_vars;

}, 10, 2);







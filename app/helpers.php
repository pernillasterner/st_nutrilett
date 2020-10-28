<?php

namespace App;

use Roots\Sage\Container;
use App\Classes\Helper;

/**
 * Get the sage container.
 *
 * @param string $abstract
 * @param array  $parameters
 * @param Container $container
 * @return Container|mixed
 */
function sage($abstract = null, $parameters = [], Container $container = null)
{
    $container = $container ?: Container::getInstance();
    if (!$abstract) {
        return $container;
    }
    return $container->bound($abstract)
        ? $container->makeWith($abstract, $parameters)
        : $container->makeWith("sage.{$abstract}", $parameters);
}

/**
 * Get / set the specified configuration value.
 *
 * If an array is passed as the key, we will assume you want to set an array of values.
 *
 * @param array|string $key
 * @param mixed $default
 * @return mixed|\Roots\Sage\Config
 * @copyright Taylor Otwell
 * @link https://github.com/laravel/framework/blob/c0970285/src/Illuminate/Foundation/helpers.php#L254-L265
 */
function config($key = null, $default = null)
{
    if (is_null($key)) {
        return sage('config');
    }
    if (is_array($key)) {
        return sage('config')->set($key);
    }
    return sage('config')->get($key, $default);
}

/**
 * @param string $file
 * @param array $data
 * @return string
 */
function template($file, $data = [])
{
    return sage('blade')->render($file, $data);
}

/**
 * Retrieve path to a compiled blade view
 * @param $file
 * @param array $data
 * @return string
 */
function template_path($file, $data = [])
{
    return sage('blade')->compiledPath($file, $data);
}

/**
 * @param $asset
 * @return string
 */
function asset_path($asset)
{
    return sage('assets')->getUri($asset);
}

/**
 * @param string|string[] $templates Possible template files
 * @return array
 */
function filter_templates($templates)
{
    $paths = apply_filters('sage/filter_templates/paths', [
        'views',
        'resources/views'
    ]);
    $paths_pattern = "#^(" . implode('|', $paths) . ")/#";

    return collect($templates)
        ->map(function ($template) use ($paths_pattern) {
            /** Remove .blade.php/.blade/.php from template names */
            $template = preg_replace('#\.(blade\.?)?(php)?$#', '', ltrim($template));

            /** Remove partial $paths from the beginning of template names */
            if (strpos($template, '/')) {
                $template = preg_replace($paths_pattern, '', $template);
            }

            return $template;
        })
        ->flatMap(function ($template) use ($paths) {
            return collect($paths)
                ->flatMap(function ($path) use ($template) {
                    return [
                        "{$path}/{$template}.blade.php",
                        "{$path}/{$template}.php",
                    ];
                })
                ->concat([
                    "{$template}.blade.php",
                    "{$template}.php",
                ]);
        })
        ->filter()
        ->unique()
        ->all();
}

/**
 * @param string|string[] $templates Relative path to possible template files
 * @return string Location of the template
 */
function locate_template($templates)
{
    return \locate_template(filter_templates($templates));
}

/**
 * Determine whether to show the sidebar
 * @return bool
 */
function display_sidebar()
{
    static $display;
    isset($display) || $display = apply_filters('sage/display_sidebar', false);
    return $display;
}

/**
 * Generate meta_query
 * @return array
 */
function silk_product_filter() {
    if( is_admin() ) return;

    $meta = array();
    $filters = array();
    $market = $_SESSION['esc_store']['market'];
    $priceList = $_SESSION['esc_store']['pricelist'];

    // Set Filter for Size
    // if (isset($_GET['size']) && !empty($_GET['size'])) {
    //     $sizes = explode(',', $_GET['size']);
    //     foreach ($sizes as $val) {
    //         $meta[] = array(
    //             'key' => 'in_stock_' . $market . '_' . strtolower($val),
    //             'value' => 1,
    //             'compare' => '='
    //         );
    //     }
    // }

    // Set Filter for Size
    if (isset($_GET['size']) && !empty($_GET['size'])) {
        $sizes = explode(',', $_GET['size']);
        $sizeQuery = array( 'relation' => 'or' );

		foreach( $sizes as $val ) {
			$sizeQuery[] = array(
                'key' => 'in_stock_' . $market . '_' . strtolower($val),
                'value' => 1,
                'compare' => '='
			);			
        }
        
        $meta[] = $sizeQuery;
    }    

    // Set Filter for Color
    if (isset($_GET['color']) && !empty($_GET['color'])) {
        $color = array();
        $colorTmp = explode(',', $_GET['color']);
        foreach($colorTmp as $key => $val) {
            $color[$key] = ucwords(str_replace('-', ' ', $val));
        }

        $meta[] = array(
            'key' => 'product_color',
            'value' => $color,
            'compare' => 'IN'
        );
    }

    // Set Filter for Category
    if (isset($_GET['category']) && !empty($_GET['category'])) {
        // $meta[] = array(
        //     'key' => 'canonical_category',
        //     'value' => $_GET['category'],
        //     'compare' => 'IN'
        // );
        $categoryList = explode(',', $_GET['category']);
        $filters['tax_query'] = array(
            array(
                'taxonomy'     => 'silk_category',
                'field'     => 'slug',
                'terms'     => $categoryList
            )
        );
    }

    if (sizeof($meta) > 0) {
        $filters['meta_query'] = $meta;
    }

    if (sizeof($filters) > 0) {
        return $filters;
    }

    return false;
}

function get_parent_slug($term) {
    if (empty($term) || $term->parent === 0) { 
        return ''; 
    }

    $term = get_term_by( 'id', $term->parent, $term->taxonomy );
    return $term->slug;
}

function get_term_slug_hierarchy($term, $reverseOrder=true) {
    if (empty($term)) { return ''; }
        
    if ($reverseOrder) {
        $categories = get_ancestors($term->term_id, $term->taxonomy);

        krsort( $categories );

        $categories[] = $term->term_id;

    } else {
        $categories = [ $term->term_id ];

        $parents = get_ancestors($term->term_id, $term->taxonomy);

        $categories = array_merge( $categories, $parents );
    }

    return $categories;
} 

/**
 * Generate order by
 * @return array
 */
 function silk_product_orderby() {
    if( is_admin() ) return;

    $orderby = array();
    /** The taxonomy we want to parse */
    $taxonomy = "silk_category";
    $market = $_SESSION['esc_store']['market'];
    $priceList = $_SESSION['esc_store']['pricelist'];

    /** Get current terms detail */
    if (isset($_GET['termid']) && !empty($_GET['termid'])) {
        $term = get_term_by('id', $_GET['termid'], $taxonomy);
        if(!empty($term)) {
            /** Get terms that have children */
            // $hierarchy = _get_term_hierarchy($taxonomy);

            // $termSlug = $term->slug;
            // while( !empty($term->parent) ) {
            //     $term = get_term_by('id', $term->parent, $taxonomy);
            //     $termSlug =  $term->slug . '/' . $termSlug;
            // }

            // // This will be the default sort or pop_asc is selected
            // $orderby['meta_key'] = 'category_order_' . $termSlug;
            // $orderby['orderby'] = 'meta_value';
            // $orderby['order'] = 'asc';

            $parents = get_term_slug_hierarchy( $term );

            $currentTermSlug = [];         
            $termSlugs = array_map( function($id) use ($taxonomy, &$currentTermSlug){
                $term = get_term_by( 'id', $id, $taxonomy );
                $termSlug = $term->slug;
                $tempSlug = !empty($currentTermSlug) ? implode('/', $currentTermSlug).'/'.$termSlug : $termSlug;

                // Removed appended parent slug from termSlug if post_meta for the current termSlug does not exists
                // Reason for this: Wordpress automatically appends the parent slug for terms with duplicated slug
                $termSlugValue = Helper::get_unique_post_meta_value( 'silk_products', 'category_order_'. $tempSlug );
                if (empty($termSlugValue)) {
                    $toRemoveSlug = get_parent_slug( $term );
                    $termSlug = str_replace_last( '-'.$toRemoveSlug, '', $term->slug );
                }

                $currentTermSlug[] = $termSlug;
                return $termSlug;
            }, $parents );

            $termSlug = implode( '/', $termSlugs );

            // Check if current term has category order post meta
            $postMetaExists = Helper::get_unique_post_meta_value( 'silk_products', 'category_order_'. $termSlug );
            
            if ($taxonomy == 'silk_category' && $postMetaExists) {
                // This will be the default sort or pop_asc is selected
                $orderby['meta_key'] = 'category_order_' . $termSlug;
                $orderby['orderby'] = 'meta_value_num';
                $orderby['order'] = 'asc';
            }

        }
    }

    // Sort Products by Price, Title or ID
    if (isset($_GET['orderBy']) && !empty($_GET['orderBy'])) {
        switch ( $_GET['orderBy'] ) {
            case 'price_desc':
                $orderby['meta_key'] = 'price_' . $market . '_' . $priceList;
                $orderby['orderby'] = 'meta_value_num';
                $orderby['order'] = 'desc';
                break;
            case 'price_asc':
                $orderby['meta_key'] = 'price_' . $market . '_' . $priceList;
                $orderby['orderby'] = 'meta_value_num';
                $orderby['order'] = 'asc';
                break;
            case 'title_desc':
                $orderby['orderby'] = 'title';
                $orderby['order'] = 'desc';
                break;
            case 'title_asc':
                $orderby['orderby'] = 'title';
                $orderby['order'] = 'asc';
                break;
        }
    }

    if (sizeof($orderby) > 0) {
        return $orderby;
    }

    return false;
 }

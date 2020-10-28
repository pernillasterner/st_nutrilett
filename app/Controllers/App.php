<?php

namespace App\Controllers;

use Sober\Controller\Controller;
use App\Classes\Navigation;
use App\Classes\Helper;
use App\Classes\Breadcrumbs;
use App\Classes\SectionHelper;

class App extends Controller
{
    use Partials\General;
    use Partials\Content;

    protected $acf = true;  

    public function socialLinks()
    {
        return self::getSocialLinks();
    }

    public function desktopMenu()
    {
        return Navigation::desktopMenu();
    }

    public function mobileMenu()
    {
        return Navigation::mobileMenu();
    }

    public function desktopFooterMenu()
    {
        return Navigation::desktopFooterMenu();
    }

    public function logo()
    {
        $output = [];
        $input = [
            'light' => get_field( 'logo_light', 'global' ),
            'dark' => get_field( 'logo_dark', 'global' ),
        ];

        foreach( $input as $key => $item ) {
            $output[$key] = sprintf( '<img class="" src="%s" alt="%s" height="%s" width="%s">',
                $item['logo']['url'],
                $item['logo']['alt'],
                $item['width'] ?? $item['logo']['width'],
                $item['height'] ?? $item['logo']['height'] );
        }

        return (object)$output;
    }

    public function homeUrl()
    {
        return esc_url(home_url('/'));
    }

    public function siteName()
    {
        return get_bloginfo( 'name' );
    }

    public function siteTranslate()
    {
        return self::getSiteTranslations();
    }

    public function defaultUsp()
    {
        return self::getDefaultUsp();
    }

    public function cookieData()
    {
        return (object) get_field( 'cookies', Helper::current_lang() ) ?? [];
    }

    public function checkoutLink()
    {
        $checkoutPage = Helper::get_silk_architecture_page( 'selection' );
        return $checkoutPage ? get_permalink( $checkoutPage ) : '';
    }

    public function checkoutLinkArray()
    {
        return (object) [
            'title' => $this->siteTranslate()->selections['go_to_checkout'] ?? '',
            'url' => $this->checkoutLink()
        ];
    }

    public function displayFooter()
    {
        return (get_page_template_slug() !== 'views/template-checkout.blade.php');
    }

    public function newsletterData()
    {
        $newsletterModal = get_field( 'newsletter_modal', 'global' );
        $data = (object)$newsletterModal;

        if( $data->use_newsletter_large_defaults ) {
            $bigDefaults = get_field( 'newsletter_large_defaults', 'global' );
            $data = (object)$bigDefaults;
        }
        
        $data->title = $data->title ?? '';
        $data->image = isset( $data->image ) && $data->image ? wp_get_attachment_image( $data->image , 'medium' ) : null;

        return $data;
    }

    public function sizeGuideData()
    {
        return self::getSizeGuideData();
    }

    public function resellerLists()
    {
        return self::getResellerLists();
    }
    
    public function breadcrumbs()
    {
        // Do not display breadcrumbs on index pages
        if (is_front_page() || is_404()) {
            return false;
        }

        $breadcrumbs = new Breadcrumbs();

        return $breadcrumbs->render_breadcumbs( [
            'container_tag'     => 'div',
            'container_class'   => 'breadcrumb is-vertical d-inline-block',
            'template'          => '<a class="breadcrumb-item" href="{link}">{title}</a>',
            'template_active'   => '<span class="breadcrumb-item active">{title}</span>',
        ]);
    }

    public function footerBreadcrumbs()
    {
        // Do not display breadcrumbs on index pages
        if (is_front_page()) {
            return false;
        }

        $breadcrumbs = new Breadcrumbs();     

        return $breadcrumbs->render_breadcumbs( [
            'container_tag'     => 'div',
            'container_class'   => 'breadcrumb bg-white mb-0 justify-content-center',
            'template'          => '<a class="breadcrumb-item" href="{link}">{title}</a>',
            'template_active'   => '<span class="breadcrumb-item active">{title}</span>',
        ]);
    }    

    public function selection()
    {
        return \EscGeneral::getSelection();
    }

    public function scripts()
    {
        return (object) [
            'header_script' => get_field( 'header_scripts', 'global'),
            'footer_script' => get_field( 'footer_scripts', 'global'),
        ];
    }

    public function footerData()
    {
        return (object)[
            'newsletter_title' => get_field( 'footer_newsletter_title', 'global' ),
            'newsletter_shortcode' => get_field( 'footer_newsletter_shortcode', 'global' ),
        ];
    }

    public function notificationBar() {
        return (object)[
            'texts' => get_field( 'notification_texts', 'global' )
        ];
    }

    public function newsletterInfo() {
        return (object) get_field( 'newsletter_signup', 'global' );
    }

    // This is used with Article Ajax Load More
    public function childrenCategoryId() {
        if( !isset( get_queried_object()->term_id ) ) {
            return [];
        }
        
        $child_arg = array( 'hide_empty' => false, 'parent' => get_queried_object()->term_id );
        $child_cat = get_terms( 'category', $child_arg );

        $termIds = '';
        if (is_array($child_cat) && sizeof($child_cat) > 0) {
            foreach ($child_cat as $val) {
                $comma = (!empty($termIds)) ? ',' : '';
                $termIds .= $comma.$val->term_id;
            }
        }

        return $termIds;
    }

    // public static function apply_flickity_lazy_load( $imageTag )
    // {
    //     return str_replace( 'data-src', 'data-flickity-lazyload', str_replace( 'lazy', '', $imageTag ) );
    // }
    
    public static function is_breadcrumbs_shown()
    {
        $show = is_tax( 'silk_category' ) || is_category();
        $sections = self::get_sections();

        if( is_singular() ) {
            $show = true;

            if( in_array( get_page_template_slug(), [
                'views/template-checkout.blade.php',
                'views/template-thankyou.blade.php',
                'views/template-faq.blade.php',
                ] ) ) {
                $show = false;
            }

            if( is_front_page() ) {
                $show = false;
            }

            if( isset( $sections[0] ) && in_array( $sections[0]['acf_fc_layout'], ['text_image_with_categories', 'text_image'] ) ) {
                $show = false;
            }
        }

        return $show;
    }

    public function showProductFilter()
    {
        return self::is_breadcrumbs_shown();
    }

    public function showFilterSort()
    {
        $show = !is_singular();

        if( in_array( get_page_template_slug(), [ 'views/template-product-listing.blade.php' ] ) ) {
            $show = true;
        }

        return $show;
    }

    public function filterSortLinks()
    {
        $links = [];

        if( is_category() ) {
            $postsPage = get_option( 'page_for_posts' );
            $all = get_field( 'translate_articles', 'global' )['all'];

            if( $postsPage ) {
                $postsPage = get_post( $postsPage );                
                $links[] = [
                    'text' => $postsPage->post_title,
                    'has_arrow' => true,
                    'url' => get_permalink( $postsPage ),
                    'classes' => '',
                ];              
            }

            $parentCategories = get_terms( [
                'taxonomy' => 'category',
                'parent' => 0,
            ] );

            if( $parentCategories ) {
                $currentCategory = get_queried_object();
                
                foreach( $parentCategories as $item ) {
                    $isActive = isset( $currentCategory->term_id ) && $currentCategory->term_id === $item->term_id;

                    $links[] = [
                        'text' => $item->name,
                        'url' => get_term_link( $item ),
                        'classes' => $isActive ? 'is-active' : '',
                    ];
                }
            }
        } elseif( is_tax( 'silk_category' ) ) {
            $all = get_field( 'translate_articles', 'global' )['all'];
            $shopLink = get_field( 'shop_link', 'global' );
            $links[] = [
                'text' => $shopLink['title'],
                'url' => $shopLink['url'],
                'classes' => '',
            ];

            $categories = get_terms( [
                'taxonomy'      => 'silk_category',
                'meta_key'      => 'category_order',
                'meta_compare'  => 'NUMERIC',
                'orderby'       => 'meta_value_num',
                'order'         => 'ASC',
            ] );

            if( $categories ) {
                $currentCategory = get_queried_object();

                foreach( $categories as $item ) {
                    $isActive = isset( $currentCategory->term_id ) && $currentCategory->term_id === $item->term_id;

                    $links[] = [
                        'text' => $item->name,
                        'url' => get_term_link( $item ),
                        'classes' => $isActive ? 'is-active' : '',
                    ];
                }                
            }                
        } elseif( is_singular() ) {
            global $post;

            if( get_page_template_slug() === 'views/template-product-chooser.blade.php' ) {
                $shopLink = get_field( 'shop_link', 'global' );
                $links[] = [
                    'text' => $shopLink['title'],
                    'has_arrow' => true,
                    'url' => $shopLink['url'],
                    'classes' => '',
                ];
    
                $links[] = [
                    'text' => $post->post_title,
                    'url' => get_permalink( $post ),
                    'classes' => '',
                ];
            } elseif( get_page_template_slug() === 'views/template-product-listing.blade.php' ) {
                $all = get_field( 'translate_articles', 'global' )['all'];
                $shopLink = get_field( 'shop_link', 'global' );
                $links[] = [
                    'text' => $shopLink['title'],
                    'url' => $shopLink['url'],
                    'classes' => 'is-active',
                ];
    
                $categories = get_terms( [
                    'taxonomy'      => 'silk_category',
                    'meta_key'      => 'category_order',
                    'meta_compare'  => 'NUMERIC',
                    'orderby'       => 'meta_value_num',
                    'order'         => 'ASC',
                ] );

                if( $categories ) {
                    foreach( $categories as $item ) {
                        $links[] = [
                            'text' => $item->name,
                            'url' => get_term_link( $item ),
                            'classes' => '',
                        ];
                    }                
                }
            } elseif( get_page_template_slug() === 'views/template-aboutus.blade.php' ) {
                global $post;

                if( $post->post_parent !== 0 ) {
                    $parentPost = get_post( $post->post_parent );

                    $links[] = [
                        'text' => $parentPost->post_title,
                        'has_arrow' => true,
                        'url' => get_permalink( $parentPost ),
                        'classes' => '',
                    ];

                    $childPosts = get_posts( [
                        'post_type' => 'page',
                        'post_status' => 'publish',
                        'numberposts' => -1,
                        'post_parent' => $parentPost->ID,
                    ] );

                    foreach( $childPosts as $item ) {
                        $links[] = [
                            'text' => $item->post_title,
                            'url' => get_term_link( $item ),
                            'classes' => $item->ID === $post->ID ? 'is-active' : '',
                        ];
                    }
                }
            } else {
                $taxonomy = [ 'post' => 'category', 'silk_products' => 'silk_category', ];
                if (isset($taxonomy[ $post->post_type ])) {
                    $category = Helper::get_category( get_the_ID(), $taxonomy[ $post->post_type ] );
        
                    $links[] = [
                        'text' => $category->name,
                        'has_arrow' => true,
                        'url' => get_term_link( $category ),
                        'classes' => '',
                    ];
                }
    
                $links[] = [
                    'text' => $post->post_title,
                    'url' => get_permalink( $post ),
                    'classes' => '',
                ];
            }            
        }

        return $links;
    }
    
    public function mobileFilterSortLinks()
    {
        $links = [];

        if( is_category() ) {
            $currentCategory = get_queried_object();

            $links[] = [
                'text' => '',
                'has_arrow' => true,
            ];
            
            $links[] = [
                'text' => $currentCategory->name,
                'url' => get_term_link( $currentCategory )
            ];
        } elseif( is_tax( 'silk_category' ) ) {
            $shopLink = get_field( 'shop_link', 'global' );
            $links[] = [
                'text' => $shopLink['title'],
                'url' => $shopLink['url'],
                'classes' => '',
                'has_arrow' => true,
            ];
            $currentCategory = get_queried_object();

            $links[] = [
                'text' => $currentCategory->name,
                'url' => get_term_link( $currentCategory )
            ];                                
        } elseif( is_singular() ) {
            global $post;

            if( get_page_template_slug() === 'views/template-product-chooser.blade.php' ) {
                $shopLink = get_field( 'shop_link', 'global' );
                $links[] = [
                    'text' => '',
                    'has_arrow' => true,
                    'url' => '',
                    'classes' => '',
                ];
    
                $links[] = [
                    'text' => 'Tilbake',
                    'url' => $shopLink['url'],
                    'classes' => '',
                ];
            } else {
                $taxonomy = [ 'post' => 'category', 'silk_products' => 'silk_category', ];
                if (isset($taxonomy[ $post->post_type ])) {
                    $category = Helper::get_category( get_the_ID(), $taxonomy[ $post->post_type ] );
        
                    $links[] = [
                        'text' => $post->post_type === 'post' ? null : $category->name,
                        'has_arrow' => true,
                        'url' => get_term_link( $category ),
                        'classes' => '',
                    ];
                }
    
                $links[] = [
                    'text' => $post->post_title,
                    'url' => get_permalink( $post ),
                    'classes' => '',
                ];
            }            
        }

        return $links;
    }

    public function filterCategoriesTitle()
    {
        if( is_home() || is_category() ) {
            return $this->siteTranslate()->articles['categories'];
        } else {
            return $this->siteTranslate()->product_listing['products'];
        }
    }

    // Filter categories for products will be populated by JS
    public function filterCategories()
    {
        $categories = [];

        if( is_category() ) {
            $currentCategory = get_queried_object();

            $categories = get_terms( [
                'taxonomy' => 'category',
                'parent' => $currentCategory->term_id,
            ] );
        }

        // Divide to two arrays        
        $col1 = [];
        $col2 = [];

        if( $categories ) {
            list( $col1, $col2 ) = array_chunk( $categories, ceil( count( $categories ) / 2 ) );
        }        

        return [
            'column-1' => $col1,
            'column-2' => $col2
        ];
    }

    public function wasThisHelpfulData()
    {
        $wthpOption = unserialize( get_option( 'wthp_option_settings' ) );
		$title = $wthpOption[ 'hlp_title_text' ] ? $wthpOption[ 'hlp_title_text' ] : __( 'Was this Helpful?', 'wthp' );
		$textYes = $wthpOption[ 'hlp_text_yes' ] ? $wthpOption[ 'hlp_text_yes' ] : __( 'Yes', 'wthp' );
        $textNo = $wthpOption[ 'hlp_text_no' ] ? $wthpOption[ 'hlp_text_no' ] : __( 'No', 'wthp' );
        
        return compact( 'title', 'textYes', 'textNo' );
    }

    public function showMenu()
    {        
        $checkoutPage = Helper::get_silk_architecture_page( 'selection' );
        $receiptPage = Helper::get_silk_architecture_page( 'success' );

        return !in_array( get_queried_object_id(), [$checkoutPage, $receiptPage] );
    }
}
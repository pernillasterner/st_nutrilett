<?php

namespace App\Classes;

class Breadcrumbs
{
	private $links = array();

    public function __construct($postId=null)
    {
        $this->bc_get_start_page();

        if ($postId) {
            $id = $postId;
        } elseif( is_home() ) {
            $id = get_option( 'page_for_posts' );
        } else {
            $id = !empty(get_post()) ? get_post()->ID : null;
        }

        $type = $this->get_breadcrumb_type( $postId );

		switch( $type ) {
			case 'page':
				$this->bc_get_pages( $id );
                break;

			case 'category':
				$this->bc_get_categories();
                break;

            case 'post':
				$this->bc_get_single( $id, 'category' );
                break;

            case 'silk_products':
				$this->bc_get_single( $id, 'silk_category' );
                break;

			case 'search':
				$this->bc_get_search_page();
				break;
        }
    }

    public function get_breadcrumb_type($postId)
    {
        if ($postId) {
            return get_post_type( $postId );

        } if (is_tax() || is_category()) {
            return 'category';

        } elseif( is_search() ) {
            return 'search';

        } else {
            return get_post_type();

        }
    }

    public function bs_set_link( $text, $url )
    {
		$this->links[] = array(
			'text' => $text,
			'url' => $url
		);
	}

    public function get_links()
    {
		return $this->links;
	}

    public function bc_get_search_page()
    {
        if( function_exists( 'pll_current_language' ) ) {
            $this->bs_set_link( get_field( 'search_title', pll_current_language() ), null );
        }		
	}

    public function bc_get_start_page()
    {
        if (function_exists( 'pll_home_url' )) {
            $homeUrl = pll_home_url( pll_current_language( 'slug' ) );
        } else {
            $homeUrl = esc_url(home_url('/'));
        }

		$this->bs_set_link( 'Start', $homeUrl );
	}

    public function bc_get_pages( $postId )
    {
		if( !$postId || is_front_page() ) { return; }

		$ancestors = get_post_ancestors( $postId );

		if( $ancestors ) {

            // Reverse parent categories ordering
			krsort( $ancestors );

			foreach( $ancestors as $key => $page ) {
				$this->bs_set_link( get_the_title( $page ), get_permalink( $page ) );
            }

		}

		// Set Link for main page
		$this->bs_set_link( get_the_title( $postId ), null );
	}

    public function bc_get_categories( $category = null )
    {
		if( empty( $category ) ) {
			$currentCategory = get_queried_object();
		} else {
			$currentCategory = $category;
		}

		if( !$currentCategory ) {
            return;
        }

		// Get category page
		$parents = get_ancestors( $currentCategory->term_id, $currentCategory->taxonomy );

		// Parent categories
		if( $parents ) {

            // Reverse parent categories ordering
            krsort( $parents );

			foreach( $parents as $key => $cat ) {
				$tax = get_term_by( 'id', $cat, $currentCategory->taxonomy );
				$this->bs_set_link( $tax->name, get_term_link( $tax->term_id ) );
			}

		}

		// Main category
        $termLink = ( $category ) ? get_term_link( $category ) : null;

		$this->bs_set_link( $currentCategory->name, $termLink );
	}

    public function bc_get_single( $postId, $taxonomy )
    {
		if( !$postId || !$taxonomy ) {
            return;
        }

		$category = get_the_terms( $postId, $taxonomy );
		$mainCategory = null;

		if( get_post_type() === 'silk_products' ) {

			$urlParts = array_filter( explode( '/', $_SERVER['REQUEST_URI'] ) );
			$urlParts = array_reverse( $urlParts );

			if( $urlParts ) {

				foreach($urlParts as $part) {
					$pos = array_search( $part, wp_list_pluck( $category, 'slug' ) );

					if( $pos !== false && empty($mainCategory) ) {
						$mainCategory = $category[ $pos ];
					}
				}
            }

		}

		// Set last category as main category
		if( empty( $mainCategory ) && $category ) {
			$mainCategory = $category[count($category)-1];
		}

		if( $mainCategory ) {
			$this->bc_get_categories( $mainCategory );
		}

		$this->bs_set_link( get_the_title( $postId ), null );
    }

    public function render_breadcumbs( $options=[] )
    {
        $config = [
            'container_tag'     => 'ul',
            'container_class'   => '',
            'container_id'      => '',
            'template'          => '<li><a href="{link}">{title}</a></li>',
            'template_active'   => '<li>{title}</li>'
        ];

        if ($options) {
            foreach ($options as $key=>$item) {
                $config[ $key ] = $item;
            }
        }

        $items = '';
        foreach ($this->links as $key=>$item ) {
            $replaces['title'] = $item['text'];
            $replaces['link'] = $item['url'];
            $template = $key + 1 === count($this->links) ? $config['template_active'] : $config['template'];

            $items .= preg_replace_callback( '/\s?\{(.+?)\}\s?/', function ( $matches ) use ( $replaces ) {
                return !empty($replaces[ $matches[1] ]) ? $replaces[ $matches[1] ] : '';
            }, $template );

        }

        $containerTag = $config['container_tag'];
        $containerClass = $config['container_class'];
        $containerID = $config['container_id'];
        $html = "<$containerTag id='$containerID' class='$containerClass'>$items</$containerTag>";

        return $html;
	}

}
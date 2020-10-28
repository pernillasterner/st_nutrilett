<?php
namespace App\Classes;

if( !class_exists('Esc') ) {  
	return;
}

use App\Classes\Helper;
use App\Controllers\App;

class Article_REST_Controller extends \WP_REST_Posts_Controller {

	/**
	 * Get a collection of items
	 *
	 * @param WP_REST_Request $request Full data about the request.
	 * @return WP_Error|WP_REST_Response
	 */
	// public function get_items( $request ) {
	// 	//var_dump($request);
	// 	$items = parent::get_items( $request );

	// 	$data = array();

	// 	foreach( $items as $item ) {
	// 		$itemdata = $this->prepare_item_for_response( $item, $request );
	// 		$data[] = $this->prepare_response_for_collection( $itemdata );
	// 	}

	// 	return new \WP_REST_Response( $data, 200 );
	// }

	/**
	 * Prepare the item for the REST response
	 *
	 * @param mixed $item WordPress representation of the item.
	 * @param WP_REST_Request $request Request object.
	 * @return mixed
	 */
	public function prepare_item_for_response( $item, $request ) {
	    $response = parent::prepare_item_for_response( $item, $request );
		$data     = $response->get_data();

		$categoriesInFilter = explode(',', $_GET['categories']);
		$categories = get_the_category($data['id']);
		$currentPostCategoryIds = array_map(function($item){
			return $item->term_id;
		}, $categories);
		$sameCategories = array_values( array_intersect($categoriesInFilter, $currentPostCategoryIds) );

		$site_translate = App::getSiteTranslations();
		$category = get_term($sameCategories[0]);
        $data['cat_url'] = get_term_link( $category );
        $data['cat_name'] = $category->name;
		$tpl['article_item'] = \App\template( 'partials.article-item', ['item' => $data, 'site_translate' => $site_translate, 'masonryStyle' => 'opacity:0;'] );
		
		return $tpl;
	}
}
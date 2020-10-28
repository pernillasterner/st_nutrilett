<?php
namespace App\Classes;

if( !class_exists('Esc') ) {  
	return;
}

use App\Classes\Helper;
use App\Controllers\TaxonomySilk_category;

if( class_exists('\Esc') ) {
	include_once( \Esc::directory() . '/modules/product.php' );
}

// TODO: Maybe move this class to the Esc Plugin insead
class Silk_Product_REST_Controller extends \WP_REST_Posts_Controller {

	
	/**
	 * Get a collection of items
	 *
	 * @param WP_REST_Request $request Full data about the request.
	 * @return WP_Error|WP_REST_Response
	 */

/*
	public function get_items( $request ) {
		//var_dump($request);
		$items = parent::get_items( $request );

		$data = array();

		foreach( $items as $item ) {
			$itemdata = $this->prepare_item_for_response( $item, $request );
			$data[] = $this->prepare_response_for_collection( $itemdata );
		}

		return new \WP_REST_Response( $data, 200 );

	}
*/

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
		$tpl['product_item'] = \App\template( 'partials.product-item', ['product' => TaxonomySilk_category::get_product($data['id'])] );
		return $tpl;
	}

	/**
	 * Register the routes for the objects of the controller.
	 */


/*
	public function register_routes() {
		$namespace = 'stokpress';
		$base = 'products';
		register_rest_route( $namespace, '/' . $base, array(
			array(
				'methods'         => WP_REST_Server::READABLE,
				'callback'        => array( $this, 'get_items' ),
				'permission_callback' => array( $this, 'get_items_permissions_check' ),
				'args'            => array( $this->get_collection_params() ),
			),
			array(
				'methods'         => WP_REST_Server::CREATABLE,
				'callback'        => array( $this, 'create_item' ),
				'permission_callback' => array( $this, 'create_item_permissions_check' ),
				'args'            => $this->get_endpoint_args_for_item_schema( true ),
			),
		) );
		register_rest_route( $namespace, '/' . $base . '/(?P<id>[\d]+)', array(
			array(
				'methods'         => WP_REST_Server::READABLE,
				'callback'        => array( $this, 'get_item' ),
				'permission_callback' => array( $this, 'get_item_permissions_check' ),
				'args'            => array(
					'context'          => array(
						'default'      => 'view',
						'required'     => true,
					),
					'params' => array(
						'required'     => false,
						'team_id' => array(
							'description'        => 'The id(s) for the team(s) in the search.',
							'type'               => 'integer',
							'default'            => 1,
							'sanitize_callback'  => 'absint',
						),
					),
					$this->get_collection_params()
				),
			),
			
			array(
				'methods'         => WP_REST_Server::EDITABLE,
				'callback'        => array( $this, 'update_item' ),
				'permission_callback' => array( $this, 'update_item_permissions_check' ),
				'args'            => $this->get_endpoint_args_for_item_schema( false ),
			),
			array(
				'methods'  => WP_REST_Server::DELETABLE,
				'callback' => array( $this, 'delete_item' ),
				'permission_callback' => array( $this, 'delete_item_permissions_check' ),
				'args'     => array(
					'force'    => array(
						'default'      => false,
					),
				),
			),
		) );
		register_rest_route( $namespace, '/' . $base . '/schema', array(
			'methods'         => WP_REST_Server::READABLE,
			'callback'        => array( $this, 'get_public_item_schema' ),
		) );
		//print_r( $this->get_collection_params() );
	}
*/
}
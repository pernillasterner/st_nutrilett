<?php

namespace App\PostTypes;

use App\Classes\CPT;

class Reseller 
{
    function __construct() 
    {
		$instance = new CPT( array(

			'post_type_name' => 'reseller',
			'singular' => 'Reseller',
			'plural' => 'Resellers',
            'slug' => 'reseller'
            
		), array(

			'supports' => array( 'title' ),
			'menu_icon' => 'dashicons-store',

		) );

		// Add Admin custom columns
		$instance->columns(array(
			'cb' => '<input type="checkbox" />',
			'title' => __('Title'),
			'country' => __('Country'),
			'city' => __('City'),
			'website' => __('Website'),
			'is_agent' => __('Is Agent or Distributor?'),
			'date' => __('Date')
		));	
		
		// Populate custom columns
		foreach( array( 'country', 'city', 'website', 'is_agent' ) as $item ) {

			$instance->populate_column( $item, function($column, $post) use ($item) {	
				if( $item==='is_agent' && get_field( $item ) === true) {					
					echo '<input type="checkbox" checked onclick="return false;"/>';
				} else {
					echo get_field( $item );
				}
			});	

		}	
        		
	}
}

new Reseller();
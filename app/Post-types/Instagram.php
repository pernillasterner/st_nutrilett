<?php

namespace App\PostTypes;

use App\Classes\CPT;

class Instagram 
{
    function __construct() 
    { 
		$instance = new CPT( array(

			'post_type_name' => 'instagram',
			'singular' => 'Instagram',
			'plural' => 'Instagram',
            'slug' => 'instagram'
            
		), array(

			'supports' => array( 'title', 'thumbnail', 'editor' ),
			'menu_icon' => 'dashicons-camera'
            
		) );
		
		$instance->register_taxonomy( array(

			'taxonomy_name' => 'hashtag',
			'singular' => 'Hashtag',
			'plural' => 'Hashtags',
            'slug' => 'hashtag'
            
		) );
    }
    
}

new Instagram();
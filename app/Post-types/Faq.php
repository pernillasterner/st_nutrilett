<?php

namespace App\PostTypes;

use App\Classes\CPT;

class Faq 
{
    function __construct() 
    {
		$instance = new CPT( array(

			'post_type_name' => 'faq',
			'singular' => 'Faq',
			'plural' => 'FAQ',
            'slug' => 'Faq'
            
		), array(

			'supports' => array( 'title' ),
			'menu_icon' => 'dashicons-editor-help',

		) );
	}
}

new Faq();
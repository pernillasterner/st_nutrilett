<?php

namespace App\Controllers;

use Sober\Controller\Controller;

class TemplateRecipe extends Controller
{
    public function content()
    {
        return App::get_content();
    }

    public function image()
    {
        if( !has_post_thumbnail() ) {
            return false;
        }

        return get_the_post_thumbnail( null, 'article-image' );
    }

    public static function format_time_to_pt( $time ) {
	
        $timearr = explode( ':', $time );
        
        $hour 	= isset($timearr[0]) ? $timearr[0] . 'H' : '';
        $min 	= isset($timearr[1]) ? $timearr[1] . 'M' : '';
        $sec 	= isset($timearr[2]) ? $timearr[2] . 'S' : '';
        
        $coded_time = 'PT' . $hour . $min . $sec;
        
        return $coded_time;
    }
}
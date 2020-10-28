<?php

namespace App\Controllers;

use Sober\Controller\Controller;

class TemplateAboutus extends Controller
{
    public function content()
    {
        return App::get_content( get_post()->ID, 1 );
    }

    public function postContent()
    {
        return get_the_content('', false, get_post()->ID);
    }

    public function preamble()
    {   
        $content = get_field( 'preamble' );

        return (object) [
            'text' => !empty($content['text']) ? $content['text'] : ''
        ];
    }
    
    public function floatingContent()
    {   
        $content = get_field( 'floating_content' );

        return (object) [
            'title' => !empty($content['title']) ? $content['title'] : '',
            'text' => !empty($content['text']) ? $content['text'] : '',
            'link' => !empty($content['link']) ? $content['link'] : '',
        ];
    }
}
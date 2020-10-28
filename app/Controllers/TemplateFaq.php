<?php

namespace App\Controllers;

use Sober\Controller\Controller;

class TemplateFaq extends Controller
{
    public function content()
    {
        return App::get_content();
    }

    public function faqList()
    {
        $listType = get_field('list_type');
        if($listType == 'selected') {
            $data = get_field('selected_faq');
        }

        if($listType == 'all' || empty($listType)) {
            $args = array(
                'numberposts' => -1,
                'post_type' => 'faq',
                'order' => 'asc',
                'orderby' => 'post_title'
            );
            $data = get_posts($args);
        }

        return $data;
    }
}
<?php

namespace App\PostTypes;

use App\Classes\CPT;

class Review
{
    function __construct()
    {
        $instance = new CPT( array(
            'post_type_name' => 'review',
            'singular' => 'Review',
            'plural' => 'Reviews',
            'slug' => 'review'
        ), array(
            'supports' => array( 'title', 'editor' ),
            'publicly_queryable' => false
        ) );

        $instance->columns( array(
            'cb' => '<input type="checkbox" />',
            'title' => __( 'Title' ),
            'rating' => __( 'Rating' ),
            'product' => __( 'Product' ),
            'sku' => __( 'SKU' ),
            'date' => __( 'Date' )
        ) );

        $instance->populate_column( 'rating', function ( $column, $post ) {
            echo get_post_meta( $post->ID, 'rating', true );
        } );

        $instance->populate_column( 'product', function ( $column, $post ) {
            $postID = get_post_meta( $post->ID, 'id', true );

            if ( $postID ) {
                $product = get_post( $postID );
                echo '<a target="_blank" href="' . get_permalink( $product ) . '">' . $product->post_title . '</a>';
            }
        } );

        $instance->populate_column( 'sku', function ( $column, $post ) {
            echo get_post_meta( $post->ID, 'sku', true );
        } );
    }
}

new Review();
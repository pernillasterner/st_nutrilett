<?php
namespace App\Classes;

class ReviewProcessor
{
    public function __construct()
    {
        add_action( 'wp_ajax_process_review', array( $this, 'processReview' ) );
        add_action( 'wp_ajax_nopriv_process_review', array( $this, 'processReview' ) );
        add_action( 'save_post', array( $this, 'updateProductScore' ), 10, 1 );
        add_action( 'before_delete_post', array( $this, 'updateProductScore' ), 10, 1 );
        add_action( 'pre_get_posts', array( $this, 'combineSimilarProducts' ) );
    }

    function combineSimilarProducts( $query )
    {
        if ( $query->get( 'post_type' ) !== 'review' ) {
            return;
        }

        $metaQuery = $query->get( 'meta_query' );

        if ( !$metaQuery ) {
            return;
        }

        $currentSKU = $metaQuery[ 0 ][ 'value' ];
        $currentSKUSingle = $currentSKU;

        // Check if SKU is a bundle
        if ( substr( $currentSKU, -1, 1 ) === 'S' ) {
            $currentSKUSingle = substr( $currentSKU, 0, strlen( $currentSKU ) - 1 );
        } else {
            $currentSKU .= 'S';
        }

        $query->set( 'meta_query', array(
            'relation' => 'OR',
            array(
                'key' => 'sku',
                'value' => $currentSKU
            ),
            array(
                'key' => 'sku',
                'value' => $currentSKUSingle
            )
        ) );
    }

    /**
     * Process review form submission
     */
    function processReview()
    {
        // Check if form data is existing
        if ( !isset( $_POST[ 'form' ] ) ) {
            wp_send_json_error( array(
                'message' => 'Form data not found'
            ) );

            wp_die();
        }

        $generalSettings = get_field( 'review_general', 'global' );

        // Flatten the data
        $formData = array();

        foreach ( $_POST[ 'form' ] as $item ) {
            $formData[ $item[ 'name' ] ] = $item[ 'value' ];
        }

        // Validate field data
        $errors = array();
        $requiredFields = array( 'rating', 'sku', 'id', 'title', 'email', 'accept_terms', 'review', 'title' );

        foreach ( $requiredFields as $field ) {
            if ( !isset( $formData[ $field ] ) ) {
                $errors[ ] = $field;
                continue;
            }

            if ( empty( $formData[ $field ] ) ) {
                $errors[ ] = $field;
                continue;
            }

            if ( $field === 'email' && !is_email( $formData[ $field ] ) ) {
                $errors[ ] = $field;
                continue;
            }
        }

        if ( !empty( $errors ) ) {
            wp_send_json_error( array(
                'errorFields' => $errors,
                'message' => $generalSettings[ 'review_form_error_message' ]
            ) );

            wp_die();
        }

        // Assign default values, convert to proper data type, clean data
        $formData[ 'rating' ] = intval( $formData[ 'rating' ] );
        $formData[ 'recommend' ] = isset( $formData[ 'recommend' ] ) ? $formData[ 'recommend' ] : 0;
        $formData[ 'review' ] = strip_tags( $formData[ 'review' ], '<h1><h2><h3><h4><h5><h6><h7><br><p><strong><em><underline>' );

        // Save to new review post as draft
        $postID = wp_insert_post( array(
            'post_title' => $formData[ 'title' ],
            'post_type' => 'review',
            'post_status' => 'draft',
            'post_content' => $formData[ 'review' ]
        ) );

        // Save custom fields
        update_post_meta( $postID, 'rating', $formData[ 'rating' ] );
        update_post_meta( $postID, 'recommends_product', $formData[ 'recommend' ] );
        update_post_meta( $postID, 'sku', $formData[ 'sku' ] );
        update_post_meta( $postID, 'id', $formData[ 'id' ] );
        update_post_meta( $postID, 'email', $formData[ 'email' ] );
        update_post_meta( $postID, 'accept_terms', $formData[ 'accept_terms' ] );

        // Send mail
        $email = $generalSettings[ 'email' ];
        $emailSubject = $generalSettings[ 'email_subject' ];
        $emailMessage = $generalSettings[ 'email_message' ];

        if ( $email ) {
            $emailMessage = str_replace( '[title]', $formData[ 'title' ], $emailMessage );
            $emailMessage = str_replace( '[review]', $formData[ 'review' ], $emailMessage );
            $emailMessage = str_replace( '[rating]', $formData[ 'rating' ], $emailMessage );
            $emailMessage = str_replace( '[product_name]', get_post( $formData[ 'id' ] )->post_title, $emailMessage );
            $emailMessage = str_replace( '[sku]', $formData[ 'sku' ], $emailMessage );

            $headers = "From: " . get_bloginfo( 'admin_email' ) . "\r\n" .
                "Content-Type: text/html";

            mail( $email, $emailSubject, $emailMessage, $headers );
        }

        wp_send_json_success( array(
            'message' => $generalSettings[ 'review_form_success_message' ]
        ) );

        wp_die();
    }

    function updateProductScore( $postID )
    {
        $reviewPost = get_post( $postID );

        // Set default score to silk-product if there is no score yet
        if ( $reviewPost->post_type === 'silk-products' ) {
            $score = get_post_meta( $postID, 'rating_score', true );

            if ( $score === '' ) {
                update_post_meta( $postID, 'rating_score', 0 );
            }
        }

        if ( $reviewPost->post_type !== 'review' ) {
            return;
        }

        $currentSKU = get_post_meta( $postID, 'sku', true );

        // Get all reviews for the current SKU
        $reviews = get_posts( array(
            'post_type' => 'review',
            'posts_per_page' => -1,
            'post_status' => 'publish',
            'meta_query' => array(
                array(
                    'key' => 'sku',
                    'value' => $currentSKU
                )
            )
        ) );

        if ( !$reviews ) {
            return;
        }

        $ratingsCounter = array();
        $productsIDs = array();

        foreach ( $reviews as $review ) {
            $rating = get_post_meta( $review->ID, 'rating', true );

            if ( !isset( $ratingsCounter[ $rating ] ) ) {
                $ratingsCounter[ $rating ] = 0;
            }

            $ratingsCounter[ $rating ]++;
            $productsIDs[ ] = get_post_meta( $review->ID, 'id', true );
        }

        // Do weighted average computation
        // Example: (5*252 + 4*124 + 3*40 + 2*29 + 1*33) / (252+124+40+29+33) = 4.11 and change
        $dividend = 0;
        $divisor = 0;

        foreach ( $ratingsCounter as $key => $value ) {
            $dividend += intval( $key ) * $value;
            $divisor += $value;
        }

        $score = round( $dividend / $divisor, 1 );

        // Store rating to similar products
        $productsIDs = array_unique( $productsIDs );

        foreach ( $productsIDs as $currentProductID ) {
            update_post_meta( $currentProductID, 'rating_score', $score );
        }
    }
}

new ReviewProcessor();
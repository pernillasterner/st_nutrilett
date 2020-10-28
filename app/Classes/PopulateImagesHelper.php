<?php

namespace App\Classes;

/**
 * Populate Images Helper Class
 *
 * Used to help to get images from a specific asset source if the image 
 * does not exist in your local setup.
 *
 */
class PopulateImagesHelper
{

    /**
     * Holds the local environment path.
     *
     * @var string $local_path.
     */    
    public $local_path = 'http://localhost:8080';

    /**
     * Holds the src environment path where to get the images.
     *
     * @var string $src_path.
     */     
    public $src_path = 'http://skhoop.stage.stokmedia.eu/';


    function __construct()
    {
        /* End process if WP_DEBUG is not defined or set to false */
        if (WP_DEBUG !== true) {
            return;
        }

        /* End process if variable local_path and src_path is not defined */
        if (empty($this->local_path) && empty($this->src_path)) {
            return;
        }

        add_filter( 'wp_get_attachment_image_src', [$this, 'get_image_src_from_path'], 10, 3 );
    }

    public function get_image_src_from_path( $image, $attachment_id, $size ) 
    {
    
        $paths = [
            'local' => $this->local_path,
            'src' => $this->src_path,
        ];
    
        /* Get uploads directory */
        $uploads_dir = wp_upload_dir();
    
        /* Gets the complete file path */
        $file = $uploads_dir['basedir'] . str_replace( $uploads_dir['baseurl'], '', $image[0] );
    
        /** 
         * End process if:
         * 1. File already exists in your local
         * 2. Local path is not set; or
         * 3. Src path is not set
         */
        if ( file_exists( $file ) || !isset($paths['local']) || !isset($paths['src'] ) ) {
            return $image;
        } 
    
        /* For thumbnails */
        if ( $size ) {
            switch ( $size ) {
                case 'thumbnail':
                case 'medium':
                case 'medium-large':
                case 'large':
                    $image[0] = str_replace( $paths['local'], $paths['src'], $image[0] );
                    break;
                default:
                    $image[0] = str_replace( $paths['local'], $paths['src'], $image[0] );
                    break;
            }
        } else {
            $image[0] = str_replace( $paths['local'], $paths['src'], $image[0] );
        }
    
        return $image;
    }
}

//new PopulateImagesHelper();
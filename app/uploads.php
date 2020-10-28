<?php

namespace App;

add_action( 'init', __NAMESPACE__ . '\\replaceImageUrls' );

function replaceImageUrls() {
   if( defined( 'WP_SITEURL' ) && defined( 'UPLOADS_SITEURL' ) ) {
      if( WP_SITEURL != UPLOADS_SITEURL ) {
         add_filter( 'wp_get_attachment_url', __NAMESPACE__ . '\\getAttachmentUrl', 10, 2 );
      }
   }
}

function getAttachmentUrl( $url, $post_id ) {
   $file = get_post_meta( $post_id, '_wp_attached_file', true );
   
   if( $file ) {
      $uploads = wp_upload_dir();
      
      if( $uploads && false === $uploads[ 'error' ] && file_exists( $uploads[ 'basedir' ] . '/' . $file ) ) {
         return $url;
      }
   }
   
   if( strpos( $url, WP_SITEURL ) === false ) {
      return UPLOADS_SITEURL . $url;
   }
   
   return str_replace( WP_SITEURL, UPLOADS_SITEURL, $url );

}
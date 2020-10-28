<?php

namespace App\Controllers;

use Sober\Controller\Controller;
use App\Classes\Product;
use App\Classes\Helper;
use App\Classes\Breadcrumbs;
use App\Classes\SectionHelper;

class SingleSilk_products extends Controller
{
	use Partials\ProductData;

	public function __construct()
	{
		add_filter( 'stoked_product_schema_data', [$this, 'schemaData'], 10, 1 );
	}

    public function content()
    {
        // Get selected product page
        $postID = get_field( 'settings_selected_product', Helper::current_lang() );

        return App::get_content( $postID, 1 );
	} 
	
	public function breadcrumbs()
	{
        $breadcrumbs = new Breadcrumbs();

        return $breadcrumbs->render_breadcumbs( [
            'container_tag'     => 'div',
            'container_class'   => 'breadcrumb bg-white d-lg-inline-block d-none mb-0 ',
            'template'          => '<a class="breadcrumb-item" href="{link}">{title}</a>',
            'template_active'   => '<span class="breadcrumb-item active">{title}</span>',
		]);
	}

	public function productClass()
	{
		return new Product( get_post()->ID );
	}

	public function productBackgroundImage()
	{	
		$backgroundImage = Helper::localize( 'product_background_image' );

		return $backgroundImage ? wp_get_attachment_image_url( $backgroundImage['ID'], 'medium' ) : '';
	}

	public function productTranslations()
	{
		return !empty(App::getSiteTranslations()->selected_product) ? App::getSiteTranslations()->selected_product : [];
	}

	public function addtocartButton()
	{	
		return self::getAddToCartButton();
	}

	public static function getAddToCartButton( $id = null )
	{
		$product = self::get_product( $id );
		$translations = !empty(App::getSiteTranslations()->selected_product) ? App::getSiteTranslations()->selected_product : [];
		$buttonAttr = [];
		$isSoldOut = $product->is_sold_out;

		if( $product->product_meta->product_type === 'Bundle' ) {
			if( !$id ) {
				$id = get_the_ID();
			}

			$isSoldOut = intval( get_post_meta( $id, 'is_bundle_available', true ) ) === 0;
		}
		
		// Soldout product
		if( $isSoldOut ) {
			$buttonText = !empty($translations['product_states']['out_of_stock']) ? $translations['product_states']['out_of_stock'] : 'Out of stock';
			array_push( $buttonAttr, 'disabled' );
		
		// Add to cart
		} else {
			$buttonText = !empty($translations['buy_button']) ? $translations['buy_button'] : 'Add to cart';
		}

		return (object) [
			'text' => $buttonText,
			'attr' => implode( ' ', $buttonAttr )
		];
	}

	public function bundleContent()
	{
		$productMeta = get_post_meta( get_the_ID(), 'product_data', true );

		if( $productMeta['product_type'] !== 'Bundle' ) {
			return null;
		}		

		$output = '';

		foreach ( $productMeta['bundle']['products'] as $bundleProduct ) {
			$productPost = get_posts( [
				'post_type' => 'silk_products',                        
                'numberposts' => 1,
				'post_status' => 'publish,draft',				
				'meta_key' => 'product_id',
				'meta_value' =>  $bundleProduct['product'],
			] );

			$quantity = ( $bundleProduct[ 'quantity' ][ 'maximum' ] == $bundleProduct[ 'quantity' ][ 'minimum' ] ) ?
				$bundleProduct[ 'quantity' ][ 'maximum' ] :
				$bundleProduct[ 'quantity' ][ 'minimum' ] . '-' . $bundleProduct[ 'quantity' ][ 'maximum' ];

			$output .= $quantity . ' x ' . $productPost[0]->post_title . '<br>';
		}

		return $output . '<br>';
	}

	public function productInformation()
	{
		$product = $this->productClass();
		$labels = $this->productTranslations();
		$infos = [];

		// Set default
		$defaultLabels = [
			'contents' => 'Contents',
			'nutritional_content' => 'Nutritional Content',
			'ingredients' => 'Ingredients',
			'downloads' => 'Downloads',
		];
		
		// Get tab contents
		if( isset( $product->product_meta['description'] ) && $product->product_meta['description'] ) {
			$infos['contents'] = [
				'label' => $labels['contents'] ?? $defaultLabels['contents'],
				'content' => $product->product_meta['description'],
			];
		}

		if( isset( $product->product_meta['nutrilettContents'] ) && $product->product_meta['nutrilettContents'] ) {
			$infos['ingredients'] = [
				'label' => $labels['ingredients'] ?? $defaultLabels['ingredients'],
				'content' => $product->product_meta['nutrilettContents'],
			];
		}
		// Pernilla
		if( isset( $product->product_meta['nutrilettNutritionInformation'] ) && $product->product_meta['nutrilettNutritionInformation'] ) {
			// Split content
			$content = explode( "\r\n", $product->product_meta['nutrilettNutritionInformation']['text'] );
			$newContent = [];

			foreach( $content as $item ) {
				if( empty( $item ) ) {
					continue;
				}

				$currentItem = explode( "\t", $item );

				if( count( $currentItem ) < 2 ) {
					continue;
				}

				$newContent[] = $currentItem;
			}

			$infos['nutritional_content'] = [
				'label' => $labels['nutritional_content'] ?? $defaultLabels['nutritional_content'],
				'content' => $newContent,
			];

			if( isset( $product->product_meta['nutrilettNutritionInformation']['file'] ) && $product->product_meta['nutrilettNutritionInformation']['file'] ) {
				$infos['downloads'] = [
					'label' => $labels['downloads'] ?? $defaultLabels['downloads'],
					'name' => basename( $product->product_meta['nutrilettNutritionInformation']['file']['url'] ),
					'url' => $product->product_meta['nutrilettNutritionInformation']['file']['url'],
				];
			}
		}

		return array_map( function ( $info ) {
            return is_array($info) ? (object) $info : $info;
        }, $infos );
	}

	public function productCategories()
	{
		$product = $this->productClass();
		$categories = wp_list_pluck( wp_get_post_terms( get_post()->ID, 'silk_category' ), 'name' );
		$categories = array_slice( $categories, 0, 2 );

		if ($product->product_meta['variantName']) {
			array_push( $categories, $product->product_meta['variantName'] );
		}

		return implode( '  |  ', $categories );
	}

	public function productCategory()
	{
		return Helper::get_category( get_the_ID(), 'silk_category' );
	}

	public function relatedProducts()
	{
		$productSliderContent = SectionHelper::get_products_slider( (object)[
			'show' => 'category',
			'products' => null,
			'product_category_product_count' => 4,
			'product_category' => $this->productCategory()->term_id
		] );

		return $productSliderContent;
	}

	public function reviews()
	{		
		return self::getReviews( $this->productClass()->product_meta['sku'] );
	}

	public function productRating()
	{
		return self::getProductRating( get_the_ID() );
	}

	public static function getProductRating( $id )
	{
		return floatval( get_post_meta( $id, 'rating_score', true ) );
	}

	public static function getReviews( $sku )
	{
		// Get all reviews for the current SKU
		$reviews = get_posts( array(
			'post_type' => 'review',
			'posts_per_page' => -1,
			'post_status' => 'publish',
			'meta_query' => array(
				array(
					'key' => 'sku',
					'value' => $sku
				)
			)
		) );
		
		return $reviews;
	}

	public function schemaData()
	{
		$ratingScore = floatval( get_post_meta( get_the_ID(), 'rating_score', true ) );
		$product = self::get_product( get_the_ID() );
		$stock = self::is_sold_out( get_the_ID() ) ? 'https://schema.org/OutOfStock' : 'https://schema.org/InStock';

		// Get all reviews for the current SKU
		$reviews = get_posts( array(
			'post_type' => 'review',
			'posts_per_page' => -1,
			'post_status' => 'publish',
			'meta_query' => array(
				array(
					'key' => 'sku',
					'value' => $product->product_meta->sku
				)
			)
		) );

		$ratingCount = count( $reviews );

		$productSchema = array(
			"@context" => "https://schema.org/",
			"@type" => "Product",
			"name" => wp_get_theme()->name . ' ' . get_the_title(),
			"image" => $product->images['standard'][0]['url'],
			"sku" => $product->product_meta->sku,
			"description" => get_the_content(),
			"brand" => array(
				"@type" => "Thing",
				"name" => wp_get_theme()->name
			),
			"offers" => array(
				"@type" => "Offer",
				"price" => $product->display_price->price_as_number,
				"priceCurrency" => \EscGeneral::getCurrentPricelistName(),
				"availability" => $stock,
				"url" => get_permalink()
			),
			"aggregateRating" => array(
				"@type" => "AggregateRating",
				"ratingValue" => $ratingScore,
				"reviewCount" => $ratingCount,
				"bestRating" => "5",
				"worstRating" => "1"
			)
		);

		$reviewsData = array();

		foreach ( $reviews as $review ) {
			$reviewsData[ ] = array(
				"@type" => "Review",
				"author" => $review->post_title,
				"datePublished" => get_the_date( 'Y-m-d', $review->ID ),
				"description" => $review->post_content,
				"name" => $review->post_title,
				"reviewRating" => array(
					"@type" => "Rating",
					"bestRating" => "5",
					"ratingValue" => get_post_meta( $review->ID, 'rating', true ),
					"worstRating" => "1"
				)
			);
		}

		$productSchema[ 'review' ] = $reviewsData;

		return $productSchema;
	}
}
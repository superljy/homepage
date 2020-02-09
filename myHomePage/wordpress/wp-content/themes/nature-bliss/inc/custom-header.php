<?php
/**
 * Custom Header feature.
 *
 * @link http://codex.wordpress.org/Custom_Headers
 *
 * @package Nature_Bliss
 */

/**
 * Set up the WordPress core custom header feature.
 *
 * @since 1.0.0
 */
function nature_bliss_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'nature_bliss_custom_header_args', array(
			'default-image' => get_template_directory_uri() . '/images/header-banner.jpg',
			'width'         => 1920,
			'height'        => 500,
			'flex-height'   => true,
			'header-text'   => false,
	) ) );

	// Register default headers.
	register_default_headers( array(
		'nature-jot' => array(
			'url'           => '%s/images/header-banner.jpg',
			'thumbnail_url' => '%s/images/header-banner.jpg',
			'description'   => _x( 'Nature Joy', 'header image description', 'nature-bliss' ),
		),

	) );
}

add_action( 'after_setup_theme', 'nature_bliss_custom_header_setup' );

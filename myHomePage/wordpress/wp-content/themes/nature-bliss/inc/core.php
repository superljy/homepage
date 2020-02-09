<?php
/**
 * Core functions.
 *
 * @package Nature_Bliss
 */

if ( ! function_exists( 'nature_bliss_get_option' ) ) :

	/**
	 * Get theme option.
	 *
	 * @since 1.0.0
	 *
	 * @param string $key Option key.
	 * @return mixed Option value.
	 */
	function nature_bliss_get_option( $key = '' ) {

		$default_options = nature_bliss_get_default_theme_options();

		if ( empty( $key ) ) {
			return;
		}

		$theme_options = (array)get_theme_mod( 'theme_options' );
		$theme_options = wp_parse_args( $theme_options, $default_options );

		$value = null;

		if ( isset( $theme_options[ $key ] ) ) {
			$value = $theme_options[ $key ];
		}

		return $value;

	}

endif;

if( ! function_exists( 'nature_bliss_exclude_category_in_blog_page' ) ) :

	/**
     * Exclude category in blog page.
     *
     * @since 1.0
     */
	function nature_bliss_exclude_category_in_blog_page( $query ) {

		if( $query->is_home() && $query->is_main_query()   ) {
			$exclude_categories = nature_bliss_get_option( 'exclude_categories' );
			if ( ! empty( $exclude_categories ) ) {
				$cats = explode( ',', $exclude_categories );
				$cats = array_filter( $cats, 'is_numeric' );
				$string_exclude = '';
				if ( ! empty( $cats ) ) {
					$string_exclude = '-' . implode( ',-', $cats);
					$query->set( 'cat', $string_exclude );
				}
			}
		}
		return $query;
	}

endif;

add_filter( 'pre_get_posts', 'nature_bliss_exclude_category_in_blog_page' );

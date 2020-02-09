<?php
/**
 * Recommended plugins.
 *
 * @package Nature_Bliss
 */

if ( ! function_exists( 'nature_bliss_recommended_plugins' ) ) :

	/**
	 * Recommend plugins.
	 *
	 * @since 1.0.0
	 */
	function nature_bliss_recommended_plugins() {

		$plugins = array(
			array(
				'name'     => esc_html__( 'Team View', 'nature-bliss' ),
				'slug'     => 'team-view',
				'required' => false,
			),
		);

		$config = array();

		tgmpa( $plugins, $config );

	}

endif;

add_filter( 'tgmpa_register', 'nature_bliss_recommended_plugins' );

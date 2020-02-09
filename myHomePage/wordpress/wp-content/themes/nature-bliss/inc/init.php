<?php
/**
 * Load files.
 *
 * @package Nature_Bliss
 */

/**
 * Include default theme options.
 */
require_once get_template_directory() . '/inc/customizer/default.php';

/**
 * Load helpers.
 */
require_once get_template_directory() . '/inc/helper/common.php';
require_once get_template_directory() . '/inc/helper/options.php';

/**
 * Load theme core functions.
 */
require_once get_template_directory() . '/inc/core.php';

/**
 * Load libraries.
 */
if ( ! class_exists( 'TGM_Plugin_Activation' ) ) {
	require_once trailingslashit( get_template_directory() ) . 'lib/tgm/class-tgm-plugin-activation.php';
}

/**
 * Load hooks.
 */
require_once get_template_directory() . '/inc/hook/structure.php';
require_once get_template_directory() . '/inc/hook/basic.php';
require_once get_template_directory() . '/inc/hook/custom.php';
require_once get_template_directory() . '/inc/hook/slider.php';
require_once get_template_directory() . '/inc/hook/tgm.php';

/**
 * Load metabox.
 */
require_once get_template_directory() . '/inc/metabox.php';

/**
 * Include Widgets.
 */
require_once get_template_directory() . '/inc/widgets.php';

/**
 * Implement the Custom Header feature.
 */
require_once get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require_once get_template_directory() . '/inc/template-tags.php';

/**
 * Customizer additions.
 */
require_once get_template_directory() . '/inc/customizer.php';

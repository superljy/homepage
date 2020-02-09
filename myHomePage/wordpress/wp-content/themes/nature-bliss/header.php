<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Nature_Bliss
 */

?><?php
	/**
	 * Hook - nature_bliss_action_doctype.
	 *
	 * @hooked nature_bliss_doctype -  10
	 */
	do_action( 'nature_bliss_action_doctype' );
?>
<head>
	<?php
	/**
	 * Hook - nature_bliss_action_head.
	 *
	 * @hooked nature_bliss_head -  10
	 */
	do_action( 'nature_bliss_action_head' );
	?>

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<?php
	/**
	 * Hook - nature_bliss_action_before.
	 *
	 * @hooked nature_bliss_page_start - 10
	 * @hooked nature_bliss_skip_to_content - 15
	 */
	do_action( 'nature_bliss_action_before' );
	?>

    <?php
	  /**
	   * Hook - nature_bliss_action_before_header.
	   *
	   * @hooked nature_bliss_header_top_content - 5
	   * @hooked nature_bliss_header_start - 10
	   */
	  do_action( 'nature_bliss_action_before_header' );
	?>
		<?php
		/**
		 * Hook - nature_bliss_action_header.
		 *
		 * @hooked nature_bliss_site_branding - 10
		 */
		do_action( 'nature_bliss_action_header' );
		?>
	<?php
	  /**
	   * Hook - nature_bliss_action_after_header.
	   *
	   * @hooked nature_bliss_header_end - 10
	   */
	  do_action( 'nature_bliss_action_after_header' );
	?>

	<?php
	/**
	 * Hook - nature_bliss_action_before_content.
	 *
	 * @hooked nature_bliss_content_start - 10
	 */
	do_action( 'nature_bliss_action_before_content' );
	?>
    <?php
	  /**
	   * Hook - nature_bliss_action_content.
	   */
	  do_action( 'nature_bliss_action_content' );
	?>

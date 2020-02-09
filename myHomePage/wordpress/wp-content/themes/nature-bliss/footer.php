<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Nature_Bliss
 */

	/**
	 * Hook - nature_bliss_action_after_content.
	 *
	 * @hooked nature_bliss_content_end - 10
	 */
	do_action( 'nature_bliss_action_after_content' );
?>

	<?php
	/**
	 * Hook - nature_bliss_action_before_footer.
	 *
	 * @hooked nature_bliss_footer_start - 10
	 */
	do_action( 'nature_bliss_action_before_footer' );
	?>
    <?php
	  /**
	   * Hook - nature_bliss_action_footer.
	   *
	   * @hooked nature_bliss_footer_copyright - 10
	   */
	  do_action( 'nature_bliss_action_footer' );
	?>
	<?php
	/**
	 * Hook - nature_bliss_action_after_footer.
	 *
	 * @hooked nature_bliss_footer_end - 10
	 */
	do_action( 'nature_bliss_action_after_footer' );
	?>

<?php
	/**
	 * Hook - nature_bliss_action_after.
	 *
	 * @hooked nature_bliss_page_end - 10
	 * @hooked nature_bliss_footer_goto_top - 20
	 */
	do_action( 'nature_bliss_action_after' );
?>

<?php wp_footer(); ?>
</body>
</html>

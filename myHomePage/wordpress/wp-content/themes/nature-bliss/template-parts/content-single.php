<?php
/**
 * Template part for displaying single posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Nature_Bliss
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php
	  /**
	   * Hook - nature_bliss_single_image.
	   *
	   * @hooked nature_bliss_add_image_in_single_display - 10
	   */
	  do_action( 'nature_bliss_single_image' );
	?>

	<?php if ( 'post' === get_post_type() ) : ?>
		<div class="entry-meta">
			<?php nature_bliss_posted_on(); ?>
		</div><!-- .entry-meta -->
	<?php endif; ?>

	<div class="entry-content-wrapper">
		<div class="entry-content">
			<?php the_content(); ?>
			<?php
				wp_link_pages( array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'nature-bliss' ),
					'after'  => '</div>',
				) );
			?>
		</div><!-- .entry-content -->
	</div><!-- .entry-content-wrapper -->

	<footer class="entry-footer">
		<?php nature_bliss_entry_footer(); ?>
	</footer><!-- .entry-footer -->

</article><!-- #post-## -->

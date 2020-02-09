<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Nature_Bliss
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php
	$archive_layout          = nature_bliss_get_option( 'archive_layout' );
	$archive_image           = nature_bliss_get_option( 'archive_image' );
	$archive_image_alignment = nature_bliss_get_option( 'archive_image_alignment' );
	?>
	<div class="entry-content-outer alignment-<?php echo esc_attr( $archive_image_alignment ) ; ?>">
		<?php if ( has_post_thumbnail() ) : ?>
			<?php if ( 'disable' !== $archive_image ) : ?>
				<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( esc_attr( $archive_image ), array( 'class' => 'align'. esc_attr( $archive_image_alignment ) ) ); ?></a>
			<?php endif; ?>
		<?php endif; ?>

		<div class="entry-content-wrapper">
			<header class="entry-header">
				<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
			</header><!-- .entry-header -->

			<?php if ( 'post' === get_post_type() ) : ?>
				<div class="entry-meta">
					<?php nature_bliss_posted_on(); ?>
				</div><!-- .entry-meta -->
			<?php endif; ?>

			<div class="entry-content">

				<?php if ( 'full' === $archive_layout ) : ?>
					<?php
					the_content( sprintf(
						/* translators: %s: Name of current post. */
						wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'nature-bliss' ), array( 'span' => array( 'class' => array() ) ) ),
						the_title( '<span class="screen-reader-text">"', '"</span>', false )
					) );
					?>
					<?php
						wp_link_pages( array(
							'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'nature-bliss' ),
							'after'  => '</div>',
						) );
					?>
			    <?php else : ?>
					<?php the_excerpt(); ?>
			    <?php endif; ?>

			</div><!-- .entry-content -->
			<footer class="entry-footer">
				<?php nature_bliss_entry_footer(); ?>
			</footer><!-- .entry-footer -->
		</div><!-- .entry-content-wrapper -->

		
	</div><!-- .entry-content-outer -->
</article><!-- #post-## -->

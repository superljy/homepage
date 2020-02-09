<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Newfangled
 */
?>
		</div> <!-- .container -->
	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
	<?php 
		$footer_widgets = get_theme_mod( 'footer_widgets',true );
		if( $footer_widgets && ( is_active_sidebar('footer') ||is_active_sidebar('footer-2') ||is_active_sidebar('footer-3') ||is_active_sidebar('footer-4') ) ) : ?>
		<div class="footer-widgets">
			<div class="container">
				<?php get_template_part('footer','widgets'); ?>
			</div>
		</div>
	<?php endif; ?>
		<div class="site-info">
			<div class="container">
				<div class="copyright eight columns">     
				<?php if( get_theme_mod('copyright') ) : ?>
							<p><?php echo newfangled_footer_copyright(get_theme_mod('copyright')); ?></p>
						<?php else : 
								printf( __('<p>Powered by <a href="%1$s" target="_blank">WordPress</a>', 'newfangled'), esc_url( 'http://wordpress.org/') );
								printf( '<span class="sep"> .</span>' );
								printf( __( 'Theme: Newfangled by <a href="%1$s" target="_blank" rel="designer">Joyousthemes</a></p>', 'newfangled' ), esc_url('http://www.wordpress.org/') );
					 endif;  ?>
				</div>
				<div class="left-sidebar eight columns">
					<?php dynamic_sidebar( 'footer-nav' ); ?> 
				</div>
			</div>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>

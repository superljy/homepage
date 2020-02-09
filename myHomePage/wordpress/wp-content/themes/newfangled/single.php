<?php
/**
 * The template for displaying all single posts.
 *
 * @package Newfangled
 */
get_header();
get_template_part( 'template-parts/breadcrumb' );  ?>

<div id="content" class="site-content">  	
		<div class="container">

        <?php   $sidebar_position = get_theme_mod( 'sidebar_position', 'right' ); 
				 if( 'left' == $sidebar_position ) :
					 get_sidebar('left'); 
				 endif;  ?>

    <div id="primary" class="content-area <?php newfangled_layout_class(); ?>  columns">


		<main id="main" class="site-main" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'template-parts/content', 'single' ); ?>

			<?php do_action('newfangled_after_single_content'); ?>

				<?php if( get_theme_mod ('author_bio_box')): ?>
				<section class="author-bio clearfix">
					<div class="author-info">
						<div class="avatar">
							<?php echo get_avatar( get_the_author_meta( 'email' ), '72' ); ?>
						</div>
						<div class="description">
							<h4><?php echo __( 'About Author:', 'newfangled' ); ?> <?php the_author_posts_link(); ?></h4>
							<?php the_author_meta('description');?>
						</div>
					</div>
				</section>
				<?php endif; ?>

			<?php if( get_theme_mod('related_posts') && function_exists( 'newfangled_related_posts' ) ) : ?>
				<section class="related-posts clearfix">
					<?php newfangled_related_posts(); ?>
				</section>
			<?php endif;  ?>

			<?php
					if( get_theme_mod ('comments',true) ) :
						// If comments are open or we have at least one comment, load up the comment template
						if ( comments_open() || '0' != get_comments_number() ) :
							comments_template();
						endif;
					endif;
				?>

		<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

   <?php   $sidebar_position = get_theme_mod( 'sidebar_position', 'right' ); 
				 if( 'right' == $sidebar_position ) :
					 get_sidebar(); 
				 endif;  
 get_footer(); ?>
	
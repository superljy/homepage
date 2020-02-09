<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package Newfangled
 */
get_header(); 
   
get_template_part( 'template-parts/breadcrumb' ); ?>
	
<div id="content" class="site-content">
		<div class="container">
		
		<?php $sidebar_position = get_theme_mod( 'sidebar_position', 'right' ); ?>
		<?php if( 'left' == $sidebar_position ) :?>
			<?php get_sidebar('left'); ?>
		<?php endif; ?> 

		<div id="primary" class="content-area <?php newfangled_layout_class(); ?>  columns">
			<main id="main" class="site-main" role="main"> 

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'template-parts/content', 'page' ); ?>

					<?php
						// If comments are open or we have at least one comment, load up the comment template
						if ( comments_open() || get_comments_number() ) :
							comments_template();
						endif;
					?>

				<?php endwhile; // end of the loop. ?>

			</main><!-- #main -->
		</div><!-- #primary -->

        <?php if( 'right' == $sidebar_position ) : ?>
			<?php get_sidebar(); ?>
		<?php endif; ?>

<?php get_footer(); ?>

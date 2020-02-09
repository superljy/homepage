<?php
/**
 * The template for displaying archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Newfangled
 */
  
get_header(); 
get_template_part( 'template-parts/breadcrumb' ); ?>

<div id="content" class="site-content">  
	<div class="container">
        <?php $sidebar_position = get_theme_mod( 'sidebar_position', 'right' ); ?>
		<?php if( 'left' == $sidebar_position ) :?>
			<?php get_sidebar(); ?>
		<?php endif; ?> 
		
		
	<div id="primary" class="content-area <?php newfangled_layout_class(); ?>  columns">
		<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<?php
					the_archive_title( '<h1 class="page-title">', '</h1>' );
					the_archive_description( '<div class="taxonomy-description">', '</div>' );
				?>
			</header><!-- .page-header -->

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php
					/* Include the Post-Format-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */
					get_template_part( 'template-parts/content', get_post_format() );
				?>

			<?php endwhile; ?>

			<?php 
				if(  get_theme_mod ('numeric_pagination',true) ) : 
						the_posts_pagination();
					else :
						the_posts_navigation( array(
						    'prev_text' => __(' &larr; Previous Post','newfangled'),
						    'next_text' => __('Next Post &rarr;','newfangled'),
						 ) );      
					endif; 
			?>

		<?php else : ?>

			<?php get_template_part( 'content', 'none' ); ?>

		<?php endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

	<?php if( 'right' == $sidebar_position ) :?>
			<?php get_sidebar(); ?>
	<?php endif; ?>
	
<?php get_footer(); ?>

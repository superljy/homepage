<?php
/**
 * The template for displaying search results pages.
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
		
	<section id="primary" class="content-area <?php newfangled_layout_class(); ?>  columns">
		<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'newfangled' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
			</header><!-- .page-header -->

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php
				/**
				 * Run the loop for the search to output the results.
				 * If you want to overload this in a child theme then include a file
				 * called content-search.php and that will be used instead.
				 */
				get_template_part( 'template-parts/content', 'search' );
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

			<?php get_template_part( 'template-parts/content', 'none' ); ?>

		<?php endif; ?>

		</main><!-- #main -->
	</section><!-- #primary -->

      <?php if( 'right' == $sidebar_position ) :?>
			<?php get_sidebar(); ?>
		<?php endif; ?>
<?php get_footer(); ?>

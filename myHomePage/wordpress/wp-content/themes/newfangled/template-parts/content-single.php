<?php
/**
 * @package Newfangled
 */  
?>     

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<?php
	$single_featured_image = get_theme_mod( 'single_featured_image',false );
	$single_featured_image_size = get_theme_mod ('single_featured_image_size','1');
	if ( $single_featured_image &&  has_post_thumbnail() ) :
	    if ( $single_featured_image_size == '1' ) :?>
	 		<div class="post-thumb"><?php  
		 	    if( has_post_thumbnail() && ! post_password_required() ) :   
					the_post_thumbnail('newfangled-blog-large-width'); 		
				endif;?>
			</div><?php
		else: ?>
		 	<div class="post-thumb"><?php
			 	if( has_post_thumbnail() && ! post_password_required() ) :   
						the_post_thumbnail('newfangled-small-featured-image-width');
				endif;?>
			</div><?php
	    endif; 
	endif ?>

	<header class="entry-header"> 
		<?php the_title( '<h3 class="entry-title">', '</h3>' ); ?>
		    <?php  newfangled_top_meta(); ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
	</div><!-- .entry-content -->
	
    <?php
		wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages: ', 'newfangled' ),
			'after'  => '</div>',
		) );
	?>


	<?php newfangled_post_nav(); ?>
</article><!-- #post-## -->

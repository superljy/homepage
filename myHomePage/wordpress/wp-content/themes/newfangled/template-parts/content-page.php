<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package Newfangled
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>


	<div class="entry-content">    
	 <?php  if( has_post_thumbnail() && ! post_password_required() ) :   
				the_post_thumbnail('newfangled-blog-large-width'); 		
			endif;
         $breadcrumb_section = get_theme_mod( 'breadcrumb_section',true );
	     if(!$breadcrumb_section) {
	     	 the_title('<h2>','</h2>'); 
	     }
         the_content(); ?>  
		
	</div><!-- .entry-content -->

	   <?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'newfangled' ),
				'after'  => '</div>',
			) );
		?>

	
	<?php edit_post_link( __( 'Edit', 'newfangled' ), '<footer class="entry-footer"><span class="edit-link"><i class="fa fa-pencil"></i>', '</span></footer>' ); ?>


</article><!-- #post-## -->

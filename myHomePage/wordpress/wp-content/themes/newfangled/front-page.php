<?php
/**
 * The front page template file.
 *
 *
 * @package Newfangled
 */
 
if ( 'posts' == get_option( 'show_on_front' ) ) { 
	get_template_part('index');
} else {
	 
    get_header(); 

	$slider_cat = get_theme_mod( 'slider_cat', '' );
	$slider_count = get_theme_mod( 'slider_count', 5 );   
	$slider_posts = array(   
		'cat' => absint($slider_cat),
		'posts_per_page' => intval($slider_count)              
	);

	$home_slider = get_theme_mod('slider_field',true); 
	if( $home_slider ):
		if ( $slider_cat ) {		
			$query = new WP_Query($slider_posts);        
			if( $query->have_posts()) : ?>
				<div class="flexslider free-flex">  
					<ul class="slides">
						<?php while($query->have_posts()) :
								$query->the_post();
								if( has_post_thumbnail() ) : ?>
								    <li>
								    	<div class="flex-image">
								    	    <div class="slider-overlay"></div>
								    		<?php the_post_thumbnail('full'); ?>
								    	</div><?php
								    	$content = get_the_content();
								    	if( !empty($content) ) : ?>
									    	<div class="flex-caption">
									    		<?php the_content(); 
													wp_link_pages( array(
														'before' => '<div class="page-links">' . esc_html__( 'Pages: ', 'newfangled' ),
														'after'  => '</div>',
													) );
												?>
									    	</div>
								        <?php endif; ?>
								    </li>
							    <?php endif;?>			   
						<?php endwhile; ?>
					</ul>
				</div>
		
			<?php endif; ?>
		   <?php  
			$query = null;
			wp_reset_postdata(); 
			
		} 
    endif; 

    if( get_theme_mod('service_field',true) ) {
       do_action('service_content_before');
      
		$service_page1 = intval(get_theme_mod('service_1'));
		$service_page2 = intval(get_theme_mod('service_2'));
		$service_page3 = intval(get_theme_mod('service_3'));
		$service_title = get_theme_mod('service_title','Our Services');
		$service_section_icon_1 = esc_attr(get_theme_mod('service_section_icon_1'));
		$service_section_icon_2 = esc_attr(get_theme_mod('service_section_icon_2'));
		$service_section_icon_3 = esc_attr(get_theme_mod('service_section_icon_3'));

		if( $service_page1 || $service_page2 || $service_page3 ) { ?>
			<div class="services-wrapper">
			    <div class="container"><?php  
					$service_pages = array($service_page1,$service_page2,$service_page3);
					$args = array(
						'post_type' => 'page',
						'post__in' => $service_pages,
						'posts_per_page' => 3,
						'orderby' => 'post__in'
					);
					$query = new WP_Query($args);
					if( $query->have_posts()) : ?>	
					   
							<?php do_action('newfangled_service_title');
							 $i = 1; 
							 if($service_title): ?>
							     <h1 class="title-divider center"><?php echo $service_title; ?></h1><?php
							 endif;
							while($query->have_posts()) :
								$query->the_post(); 

								      if($i == 1):
						    	      $icon_url =  $service_section_icon_1;
						    	      elseif($i == 2):
						    	       $icon_url =  $service_section_icon_2;
						    	      elseif($i == 3):
						    	       	$icon_url =  $service_section_icon_3;
						    	      endif; ?>

							    <div class="service-section one-third column">
							    	<?php if($icon_url): ?>
					    	           <div class="service-image"><i class="fa <?php echo $icon_url; ?>"></i></div><?php 
					    	        elseif( has_post_thumbnail() ) : ?>
							    		 <div class="service-image"><a href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark"><?php the_post_thumbnail('newfangled-service-img'); ?></a></div>
							    	<?php endif; ?>
							    	<div class="service-content">
							    	    <?php the_title( sprintf( '<h3 class="service-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' ); ?>
								    	<?php the_content(); wp_link_pages( array(
												'before' => '<div class="page-links">' . esc_html__( 'Pages: ', 'newfangled' ),
												'after'  => '</div>',
											) );
										?>
							    	</div>
							    </div>
							<?php $i++;
							endwhile; 
						endif; 
					$query = null;
					$args = null;
					wp_reset_postdata(); ?>

				</div>
			</div><?php
		} 	
 
		do_action('service_content_after'); 

	}	
	 do_action( 'newfangled_after_slider_part' );
    if( get_theme_mod('enable_recent_post_service',true) ) :
	   	do_action('newfangled_recent_post_before');  
		newfangled_recent_posts();  
	    do_action('newfangled_recent_post_after');
    endif;


	    if( get_theme_mod('enable_home_default_content',false ) ) {   ?>
			<div id="content" class="site-content">
				<div class="container">
					<main id="main" class="site-main" role="main"><?php
						while ( have_posts() ) : the_post();       
							the_content();
							wp_link_pages( array(
								'before' => '<div class="page-links">' . esc_html__( 'Pages: ', 'newfangled' ),
								'after'  => '</div>',
							) );
						
						endwhile; ?>
				    </main><!-- #main -->
			    </div><!-- #primary -->  
			</div>
    <?php }
    get_footer();

}

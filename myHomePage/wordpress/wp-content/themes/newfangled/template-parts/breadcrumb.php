<?php
/**
 * The template used for displaying page breadcrumb
 *
 * @package Newfangled
 */ 

$breadcrumb = get_theme_mod( 'breadcrumb',true ); 
$breadcrumb_section = get_theme_mod( 'breadcrumb_section',true );

if( $breadcrumb_section ) {
	if( !is_front_page() ) { ?>
		<div class="breadcrumb" style="background-image: url('<?php echo newfangled_featured_header(); ?>');"> 
			<div class="container"><?php
			    if( !is_search() && !is_archive() && !is_404() ) : ?>
					<div class="breadcrumb-left sixteen columns">
						<?php the_title('<h2>','</h2>');?>			
					</div><?php
				endif; ?>
				<?php if( $breadcrumb ) : ?>
					<div class="breadcrumb-right sixteen columns">
						<?php newfangled_breadcrumbs(); ?>
					</div>
				<?php endif; ?>  
			</div>
		</div><?php 
	} elseif ( is_home() ) { ?>
		<div class="breadcrumb blog" style="background-image: url('<?php echo newfangled_featured_header(); ?>');"> 
		</div>
	<?php } 
}

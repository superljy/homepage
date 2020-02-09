<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Newfangled
 */
?><!DOCTYPE html> 
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11"><?php
if ( is_singular() && pings_open() ) { ?>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>"><?php
} ?>
<?php wp_head(); ?>  
</head>
  
<body <?php body_class(); ?>>  
<div id="page" class="hfeed site">
	<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'newfangled' ); ?></a>
	<?php do_action('newfangled_before_header'); ?>
	<header id="masthead" class="site-header" role="banner">   
		<?php if( is_active_sidebar( 'top-left' )  || is_active_sidebar( 'top-right' ) ): ?>
			<div class="top-nav">
				<div class="container">		
					<div class="eight columns">
						<div class="cart-left">
							<?php dynamic_sidebar('top-left' ); ?>
						</div>
					</div>

					<div class="eight columns">
						<div class="cart-right">
							<?php dynamic_sidebar('top-right' ); ?>  
						</div>  
					</div>
				</div>
			</div> <!-- .top-nav -->
		<?php endif;?>

		<div class="branding header-image">
	       <div class="container">
				<div class="eight columns">
					<div class="site-branding">
						<?php     
							$logo_title = get_theme_mod( 'logo_title' );   
							$tagline = get_theme_mod( 'tagline',false);
							if( $logo_title && function_exists( 'the_custom_logo' ) ) :
                                the_custom_logo();     
                            else : ?>
								<h2 class="site-title"><a style="color: #<?php header_textcolor(); ?>" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h2>
						<?php endif; ?>
						<?php if( $tagline ) : ?>
								<p class="site-description"><?php bloginfo( 'description' ); ?></p>
						<?php endif; ?>
					</div><!-- .site-branding -->
				</div>
				<div class="eight columns"><?php
				   if( is_active_sidebar( 'header-top-right' ) ) : ?> 
						<div class="header-top-right">
						    <?php dynamic_sidebar('header-top-right' ); ?>  
					    </div>
					<?php endif; ?>
				</div>
		   </div>
	    </div>
	
		<div class="nav-wrap">
			<div class="container">
				<div class="sixteen columns">
					<nav id="site-navigation" class="main-navigation clearfix" role="navigation">
						<button class="menu-toggle" aria-controls="menu" aria-expanded="false"><i class="fa fa-align-justify fa-2x" aria-hidden="true"></i></button>
						<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
					</nav><!-- #site-navigation -->
				</div>
			</div>
		</div>
	     


	</header><!-- #masthead --> 

	<?php if ( function_exists( 'is_woocommerce' ) ) :
	 if ( is_woocommerce()  ) { 
	  $breadcrumb = get_theme_mod( 'breadcrumb',true ); 
	  $breadcrumb_section = get_theme_mod( 'breadcrumb_section',true );
	    if( $breadcrumb_section ) { ?>    
		   <div class="breadcrumb" style="background-image: url('<?php echo newfangled_featured_header(); ?>');"> 
				<div class="container"><?php
				   if( !is_search() && !is_archive() && !is_404() ) : ?>
						<div class="breadcrumb-left eight columns">
							<h4><?php woocommerce_page_title(); ?></h4>   			
						</div><?php
					endif; ?>
					<?php if( $breadcrumb ) : ?>  
						<div class="breadcrumb-right eight columns">
							<?php woocommerce_breadcrumb(); ?>
						</div>
					<?php endif; ?>
				</div>
			</div><?php 
		} 
    }
	endif; ?>

	



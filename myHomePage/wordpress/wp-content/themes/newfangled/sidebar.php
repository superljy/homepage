<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package Newfangled
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>

<div id="secondary" class="widget-area five columns" role="complementary">
	<div class="left-sidebar">
<?php if( is_page() ) : 
		if(function_exists('generated_dynamic_sidebar') ){ 
			 generated_dynamic_sidebar();
		 }
		else { 
			dynamic_sidebar( 'sidebar-1' ); 
		}
	else:
		dynamic_sidebar( 'sidebar-1' ); 
	endif; ?>

	</div>
</div><!-- #secondary -->


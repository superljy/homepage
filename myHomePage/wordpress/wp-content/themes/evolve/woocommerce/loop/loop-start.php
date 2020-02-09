<?php
/**
 * Displayed when no products are found matching the current query.
 *
 * Override this template by copying it to yourtheme/woocommerce/loop/no-products-found.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly
global $woocommerce_loop, $post; 
// Store column count for displaying the grid
if (empty($woocommerce_loop['columns'])) {
    $woocommerce_loop['columns'] = apply_filters('loop_shop_columns', 1);
}

// Reset to 4 on following conditions ..
if (is_shop() || is_product_category() || is_product_tag()) {
    if (is_shop()) {
        $pageID = get_option('woocommerce_shop_page_id');
    } else {
        $pageID = $post->ID;
    }

    $custom_fields = get_post_custom_values('_wp_page_template', $pageID);
    if (is_array($custom_fields) &&
            !empty($custom_fields)
    ) {
        $page_template = $custom_fields[0];
    } else {
        $page_template = '';
    }

    $evolve_layout = evolve_get_option('evl_layout', '2cl');

    if ($evolve_layout == "1c") {
        $woocommerce_loop['columns'] = 4;
    } else {
        $woocommerce_loop['columns'] = 3;
    }
} else {

    $evolve_layout = evolve_get_option('evl_layout', '2cl');
    $evolve_opt1_width_content = evolve_get_option('evl_opt1_width_content', '8');
    $evolve_opt2_width_content = evolve_get_option('evl_opt2_width_content', '6');

    if ( $evolve_layout == "1c" ) {
        $woocommerce_loop['columns'] = 4;
    } else {
        if ( $evolve_opt1_width_content <= "6" || $evolve_opt2_width_content <= "6" ) {
            $woocommerce_loop['columns'] = 2;
        } elseif ( $evolve_opt1_width_content > "6" || $evolve_opt2_width_content > "6" ) {
            $woocommerce_loop['columns'] = 3;
        }
    }

}
?> 
<ul class="products clearfix products-<?php echo $woocommerce_loop['columns']; ?>">
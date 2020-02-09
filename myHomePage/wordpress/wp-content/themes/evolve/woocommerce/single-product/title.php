<?php
/**
 * Single Product title
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

$evolve_pagetitlebar_layout = evolve_get_option('evl_pagetitlebar_layout', '0');
if ($evolve_pagetitlebar_layout == '0') {
?>
        <h2 itemprop="name" class="product_title entry-title"><?php the_title(); ?></h2>
<?php
}
?>
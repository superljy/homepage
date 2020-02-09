<?php
/**
 * My Account page
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.6.0
 */
if (!defined('ABSPATH')) {
    exit;
}

wc_print_notices();
?>

<div class="woocommerce-MyAccount-content">
    <?php
    /**
     * My Account content.
     * @since 2.6.0
     */
    do_action('woocommerce_account_content');
    ?>
</div>

<?php
/*
 * 
 * Template: Sidebar.php
 *
 */
$evolve_sidebar_css = '';
if (class_exists('Woocommerce')) {
    if (is_cart() || is_checkout() || is_account_page() || (get_option('woocommerce_thanks_page_id') && is_page(get_option('woocommerce_thanks_page_id')))) {
        $evolve_sidebar_css = 'display:none';
    }
}
?>
<!--BEGIN #secondary .aside-->
<div id="secondary" class="aside <?php evolve_sidebar_class(); ?>"
        <?php
                if (class_exists('Woocommerce')):
                        echo 'style="' . $evolve_sidebar_css . '"';
                endif;
        ?>
    >
    <?php
    /* Widgetized Area */
    if (!dynamic_sidebar('sidebar-1')) :
    endif; /* (!function_exists('dynamic_sidebar') */
    ?>
</div><!--END #secondary .aside-->
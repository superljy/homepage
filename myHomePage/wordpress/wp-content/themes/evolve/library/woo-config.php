<?php
/**
 * Theme4Press Framework
 *
 * WARNING: This file is part of the Theme4Press Core Framework.
 * Do not edit the core files.
 * Add any modifications necessary under a child theme.
 *
 * @package  Theme4Press/Template
 * @author   Theme4Press
 * @link     http://theme4press.com
 */
// Exit if accessed directly
if (!defined('ABSPATH')) {
    die;
}

if(session_id() == '' || !isset($_SESSION))
    session_start();

add_action('init', 'woocommerce_evolve_ordering');

function woocommerce_evolve_ordering() {
    $woocommerce_evolve_ordering = evolve_get_option('evl_woocommerce_evolve_ordering', '0');

    /* remove default shorting option */
    remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);
    if (!$woocommerce_evolve_ordering) {
        add_action('woocommerce_before_shop_loop', 'evolve_woocommerce_catalog_ordering', 30);
        add_action('woocommerce_get_catalog_ordering_args', 'evolve_woocommerce_get_catalog_ordering_args', 20);
    }
}

// Don't duplicate me!
if (!class_exists('t4pTemplateWoo')) {

    /**
     * Class to apply woocommerce templates
     *
     * @since 4.0.0
     */
    class t4pTemplateWoo {

        function __construct() {

            add_filter('woocommerce_show_page_title', array($this, 'shop_title'), 10);

            add_action('woocommerce_before_main_content', array($this, 'add_sidebar_2'), 10);

            remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
            remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
            remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);
            add_action('woocommerce_before_main_content', array($this, 'before_container'), 10);
            add_action('woocommerce_after_main_content', array($this, 'after_container'), 10);
            add_action('woocommerce_before_main_content', array($this, 'shop_breadcrumb'), 20, 0);

            remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);
            add_action('woocommerce_sidebar', array($this, 'add_sidebar'), 10);

            /**
             * Products Loop
             */
            add_action('woocommerce_after_shop_loop_item', array($this, 'before_shop_item_buttons'), 9);
            add_action('woocommerce_after_shop_loop_item', array($this, 'after_shop_item_buttons'), 11);

            /**
             * Single Product Page
             */
            add_action('woocommerce_single_product_summary', array($this, 'add_product_border'), 19);
            remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);
            remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
            add_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
            add_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 11);

            /**
             * WooCommerce 2.3 Remove extra checkout button
             */
            remove_action('woocommerce_proceed_to_checkout', 'woocommerce_button_proceed_to_checkout', 10);
            // Backwards compatability to 2.2
            add_filter('woocommerce_template_path', array($this, 'backwards_compatability'));
        }

// end __construct();

        /**
         * Filter method to modify path to WooCommerce files if WooCommerce is a version less than 2.3
         *
         * @since 3.7.2
         * @return relative path of WooCommerce template files within the theme
         */
        function backwards_compatability($path) {
            if (!self::is_wc_version_gte_2_3()) {
                $path = "woocommerce/compatability/2.2/";
            }
            return $path;
        }

        /**
         * Helper method to get the version of the currently installed WooCommerce
         *
         * @since 3.7.2
         * @return string woocommerce version number or null
         */
        private static function get_wc_version() {
            return defined('WC_VERSION') && WC_VERSION ? WC_VERSION : null;
        }

        /**
         * Returns true if the installed version of WooCommerce is 2.3 or greater
         *
         * @since 3.7.2
         * @return boolean true if the installed version of WooCommerce is 2.3 or greater
         */
        public static function is_wc_version_gte_2_3() {
            return self::get_wc_version() && version_compare(self::get_wc_version(), '2.3', '>=');
        }

        function before_container() {
            global $post;
            global $wp_query;

            if (is_shop()) {
                $pageID = get_option('woocommerce_shop_page_id');
            } elseif (class_exists('Woocommerce') && (is_product_category() || is_product_tag())) {
                $pageID = '';
            } else {
                $pageID = $post->ID;
            }

            $custom_fields = get_post_custom_values('_wp_page_template', $pageID);
            if (is_array($custom_fields) && !empty($custom_fields)) {
                $page_template = $custom_fields[0];
            } else {
                $page_template = '';
            }

            $evolve_layout = evolve_get_option('evl_layout', '2cl');
            $evolve_post_layout = evolve_get_option('evl_post_layout', 'two');
            $evolve_opt1_width_content = evolve_get_option('evl_opt1_width_content', '8');
            $evolve_opt2_width_content = evolve_get_option('evl_opt2_width_content', '6');

            $layout_css = '';
            echo'<div id="primary" class="';

            if ($evolve_layout == "1c") {
                $layout_css.= ' col-md-12';
            } else {

                if (($evolve_layout == "2cr" && ($evolve_post_layout == "two") || $evolve_layout == "2cl" && ($evolve_post_layout == "two"))) {
                    $layout_css.= 'col-md-12 col-sm-' . $evolve_opt1_width_content . ' col-md-' . $evolve_opt1_width_content . '';
                }

                if (($evolve_layout == "3cm" || $evolve_layout == "3cl" || $evolve_layout == "3cr")) {
                    $layout_css.= 'col-md-12 col-sm-' . $evolve_opt2_width_content . ' col-md-' . $evolve_opt2_width_content . '';
                } else {
                    $layout_css.= 'col-md-12 col-sm-' . $evolve_opt1_width_content . ' col-md-' . $evolve_opt1_width_content . '';
                }

                if (is_single() || is_page()) {
                    $layout_css.= ' col-single';
                }
            }

            echo $layout_css;
            echo '">';
        }

        function shop_title() {
            return false;
        }

        function after_container() {
            echo '</div>';
        }

        function add_sidebar_2() {
            global $wp_query, $post;

            if (is_shop()) {
                $pageID = get_option('woocommerce_shop_page_id');
            } elseif (class_exists('Woocommerce') && (is_product_category() || is_product_tag())) {
                $pageID = '';
            } else {
                $pageID = $post->ID;
            }

            $get_sidebar = false;

            $evolve_layout = evolve_get_option('evl_layout', '2cl');
            $evolve_opt2_width_sidebar2 = evolve_get_option('evl_opt2_width_sidebar2', '3');

            if ($evolve_layout == "3cm" || $evolve_layout == "3cl" || $evolve_layout == "3cr") {
                $get_sidebar = true;
            }

            $sidebar_css = '';

            if ($get_sidebar) {
                //get_sidebar('2');
                if (class_exists('Woocommerce')) {
                    if (is_cart() || is_checkout() || is_account_page() || (get_option('woocommerce_thanks_page_id') && is_page(get_option('woocommerce_thanks_page_id')))) {
                        $sidebar_css = '';
                    }
                }

                echo '<div id="secondary-2" class="aside ';

                //use PHP switch statement, is easier to understand.
                switch ($evolve_layout):
                    case "1c":
                        //do nothing
                        break;
                    case "2cl":
                        //do nothing
                        break;
                    case "2cr":
                        //do nothing
                        break;
                    case "3cm":
                        $sidebar_css = 'col-xs-12 col-sm-' . $evolve_opt2_width_sidebar2 . ' col-md-' . $evolve_opt2_width_sidebar2 . '';
                        break;
                    case "3cl":
                        $sidebar_css = 'col-xs-12 col-sm-' . $evolve_opt2_width_sidebar2 . ' col-md-' . $evolve_opt2_width_sidebar2 . '';
                        break;
                    case "3cr":
                        $sidebar_css = 'col-xs-12 col-sm-' . $evolve_opt2_width_sidebar2 . ' col-md-' . $evolve_opt2_width_sidebar2 . '';
                        break;
                endswitch;

                echo $sidebar_css.'"';

                echo '>';

                wp_reset_query();

                if (dynamic_sidebar('sidebar-2')) :
                endif;

                echo '</div>';
            }
        }

        function add_sidebar() {
            global $post;

            if (is_shop()) {
                $pageID = get_option('woocommerce_shop_page_id');
            } elseif (class_exists('Woocommerce') && (is_product_category() || is_product_tag())) {
                $pageID = '';
            } else {
                $pageID = $post->ID;
            }

            $evolve_layout = evolve_get_option('evl_layout', '2cl');
            $evolve_opt1_width_sidebar1 = evolve_get_option('evl_opt1_width_sidebar1', '4');
            $evolve_opt2_width_sidebar1 = evolve_get_option('evl_opt2_width_sidebar1', '3');

            $sidebar_css = '';

            if (class_exists('Woocommerce')) {
                if (is_cart() || is_checkout() || is_account_page() || (get_option('woocommerce_thanks_page_id') && is_page(get_option('woocommerce_thanks_page_id')))) {
                    $sidebar_css = '';
                }
            }

            echo '<div id="secondary" class="aside ';

            //use PHP switch statement, is easier to understand.
            switch ($evolve_layout):
                case "1c":
                    $sidebar_css = '';
                        echo '"';
                        echo "style='display:none;'";
                    break;
                case "2cl":
                    $sidebar_css = 'col-sm-' . $evolve_opt1_width_sidebar1 . ' col-md-' . $evolve_opt1_width_sidebar1 . '';
                    break;
                case "2cr":
                    $sidebar_css = 'col-sm-' . $evolve_opt1_width_sidebar1 . ' col-md-' . $evolve_opt1_width_sidebar1 . '';
                    break;
                case "3cm":
                    $sidebar_css = 'col-xs-12 col-sm-' . $evolve_opt2_width_sidebar1 . ' col-md-' . $evolve_opt2_width_sidebar1 . '';
                    break;
                case "3cl":
                    $sidebar_css = 'col-xs-12 col-sm-' . $evolve_opt2_width_sidebar1 . ' col-md-' . $evolve_opt2_width_sidebar1 . '';
                    break;
                case "3cr":
                    $sidebar_css = 'col-xs-12 col-sm-' . $evolve_opt2_width_sidebar1 . ' col-md-' . $evolve_opt2_width_sidebar1 . '';
                    break;
            endswitch;

            if ($evolve_layout != '1c') {
                echo $sidebar_css.'"';
            }
            echo '>';

            wp_reset_query();

            if (!dynamic_sidebar('sidebar-1')) :
            endif;

            echo '</div>';
        }

        function before_shop_item_buttons() {
            echo '<div class="product-buttons"><div class="product-buttons-container clearfix">';
        }

        function after_shop_item_buttons() {
            echo '</div></div>';
        }

        function add_product_border() {
            echo '<div class="clear"></div><div class="product-border"></div>';
        }

        function shop_breadcrumb() {
            $evolve_breadcrumbs = evolve_get_option('evl_breadcrumbs', '1');
            $evolve_pagetitlebar_layout = evolve_get_option('evl_pagetitlebar_layout', '0');
            if ($evolve_breadcrumbs == "1" && $evolve_pagetitlebar_layout == '0'):
                woocommerce_breadcrumb();
            endif;
        }

    }

    // end t4pTemplateWoo() class
    new t4pTemplateWoo();
}

add_filter('get_product_search_form', 'evolve_product_search_form');

function evolve_product_search_form($form) {
    $form = '<form role="search" method="get" id="searchform" action="' . esc_url(home_url('/')) . '">
	<div>
	<input type="text" value="' . get_search_query() . '" name="s" id="s" placeholder="' . __('Search...', 'evolve') . '" />
	<input type="hidden" name="post_type" value="product" />
	</div>
	</form>';

    return $form;
}

remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);

/*
 * Category page show shorting order
 */

function evolve_woocommerce_catalog_ordering() {

    $woo_items = evolve_get_option('evl_woo_items', '12');

    if (isset($_SERVER['QUERY_STRING'])) {

        parse_str($_SERVER['QUERY_STRING'], $params);

        $query_string = '?' . $_SERVER['QUERY_STRING'];
    } else {
        $query_string = '';
    }

    // replace it with theme option
    if ($woo_items) {
        $per_page = $woo_items;
    } else {
        $per_page = 12;
    }

    $pob = !empty($params['product_orderby']) ? $params['product_orderby'] : 'default';
    $po = !empty($params['product_order']) ? $params['product_order'] : 'asc';
    $pc = !empty($params['product_count']) ? $params['product_count'] : $per_page;

    $html = '';
    $html .= '<div class="catalog-ordering clearfix">';

    $html .= '<div class="orderby-order-container">';

    $html .= '<ul class="orderby order-dropdown">';
    $html .= '<li>';
    $html .= '<span class="current-li"><span class="current-li-content"><a>' . __('Sort by', 'evolve') . ' <strong>' . __('Default Order', 'evolve') . '</strong></a></span></span>';
    $html .= '<ul>';
    $html .= '<li class="' . (($pob == 'default') ? 'current' : '') . '"><a href="' . t4p_addURLParameter($query_string, 'product_orderby', 'default') . '">' . __('Sort by', 'evolve') . ' <strong>' . __('Default Order', 'evolve') . '</strong></a></li>';
    $html .= '<li class="' . (($pob == 'name') ? 'current' : '') . '"><a href="' . t4p_addURLParameter($query_string, 'product_orderby', 'name') . '">' . __('Sort by', 'evolve') . ' <strong>' . __('Name', 'evolve') . '</strong></a></li>';
    $html .= '<li class="' . (($pob == 'price') ? 'current' : '') . '"><a href="' . t4p_addURLParameter($query_string, 'product_orderby', 'price') . '">' . __('Sort by', 'evolve') . ' <strong>' . __('Price', 'evolve') . '</strong></a></li>';
    $html .= '<li class="' . (($pob == 'date') ? 'current' : '') . '"><a href="' . t4p_addURLParameter($query_string, 'product_orderby', 'date') . '">' . __('Sort by', 'evolve') . ' <strong>' . __('Date', 'evolve') . '</strong></a></li>';
    $html .= '<li class="' . (($pob == 'popularity') ? 'current' : '') . '"><a href="' . t4p_addURLParameter($query_string, 'product_orderby', 'popularity') . '">' . __('Sort by', 'evolve') . ' <strong>' . __('Popularity', 'evolve') . '</strong></a></li>';
    $html .= '<li class="' . (($pob == 'rating') ? 'current' : '') . '"><a href="' . t4p_addURLParameter($query_string, 'product_orderby', 'rating') . '">' . __('Sort by', 'evolve') . ' <strong>' . __('Rating', 'evolve') . '</strong></a></li>';
    $html .= '</ul>';
    $html .= '</li>';
    $html .= '</ul>';


    $html .= '<ul class="order">';
    if ($po == 'desc'):
        $html .= '<li class="desc"><a href="' . t4p_addURLParameter($query_string, 'product_order', 'asc') . '"><i class="t4p-icon t4p-icon-chevron-up"></i></a></li>';
    endif;
    if ($po == 'asc'):
        $html .= '<li class="asc"><a href="' . t4p_addURLParameter($query_string, 'product_order', 'desc') . '"><i class="t4p-icon t4p-icon-chevron-down"></i></a></li>';
    endif;
    $html .= '</ul>';

    $html .= '</div>';

    $html .= '<ul class="sort-count order-dropdown">';
    $html .= '<li>';
    $html .= '<span class="current-li"><a>' . __('Show', 'evolve') . ' <strong>' . $per_page . ' ' . __(' Products', 'evolve') . '</strong></a></span>';
    $html .= '<ul>';
    $html .= '<li class="' . (($pc == $per_page) ? 'current' : '') . '"><a href="' . t4p_addURLParameter($query_string, 'product_count', $per_page) . '">' . __('Show', 'evolve') . ' <strong>' . $per_page . ' ' . __('Products', 'evolve') . '</strong></a></li>';
    $html .= '<li class="' . (($pc == $per_page * 2) ? 'current' : '') . '"><a href="' . t4p_addURLParameter($query_string, 'product_count', $per_page * 2) . '">' . __('Show', 'evolve') . ' <strong>' . ($per_page * 2) . ' ' . __('Products', 'evolve') . '</strong></a></li>';
    $html .= '<li class="' . (($pc == $per_page * 3) ? 'current' : '') . '"><a href="' . t4p_addURLParameter($query_string, 'product_count', $per_page * 3) . '">' . __('Show', 'evolve') . ' <strong>' . ($per_page * 3) . ' ' . __('Products', 'evolve') . '</strong></a></li>';
    $html .= '</ul>';
    $html .= '</li>';
    $html .= '</ul>';
    $html .= '</div>';

    echo $html;
}

function evolve_woocommerce_get_catalog_ordering_args($args) {
    global $woocommerce;

    if (isset($_SERVER['QUERY_STRING'])) {

        parse_str($_SERVER['QUERY_STRING'], $params);
    }

    $pob = !empty($params['product_orderby']) ? $params['product_orderby'] : 'default';
    $po = !empty($params['product_order']) ? $params['product_order'] : 'asc';

    switch ($pob) {
        case 'date':
            $orderby = 'date';
            $order = 'asc';
            $meta_key = '';
            break;
        case 'price':
            $orderby = 'meta_value_num';
            $order = 'asc';
            $meta_key = '_price';
            break;
        case 'popularity':
            $orderby = 'meta_value_num';
            $order = 'asc';
            $meta_key = 'total_sales';
            break;
        case 'rating':
            $orderby = 'meta_value_num';
            $order = 'asc';
            $meta_key = 'average_rating';
            break;
        case 'name':
            $orderby = 'title';
            $order = 'asc';
            $meta_key = '';
            break;
        case 'default':
            return $args;
            break;
    }

    switch ($po) {
        case 'desc':
            $order = 'desc';
            break;
        case 'asc':
            $order = 'asc';
            break;
        default:
            $order = 'asc';
            break;
    }

    $args['orderby'] = $orderby;
    $args['order'] = $order;
    $args['meta_key'] = $meta_key;

    if ($pob == 'rating') {
        $args['orderby'] = 'menu_order title';
        $args['order'] = $po == 'desc' ? 'desc' : 'asc';
        $args['order'] = strtoupper($args['order']);
        $args['meta_key'] = '';

        add_filter('posts_clauses', 't4p_order_by_rating_post_clauses');
    }

    return $args;
}

/**
 * t4p_order_by_rating_post_clauses function.
 *
 * @access public
 * @param array $args
 * @return array
 */
function t4p_order_by_rating_post_clauses($args) {
    global $wpdb;

    $args['fields'] .= ", AVG( $wpdb->commentmeta.meta_value ) as average_rating ";

    $args['where'] .= " AND ( $wpdb->commentmeta.meta_key = 'rating' OR $wpdb->commentmeta.meta_key IS null ) ";

    $args['join'] .= "
		LEFT OUTER JOIN $wpdb->comments ON($wpdb->posts.ID = $wpdb->comments.comment_post_ID)
		LEFT JOIN $wpdb->commentmeta ON($wpdb->comments.comment_ID = $wpdb->commentmeta.comment_id)
	";

    if (isset($_SERVER['QUERY_STRING'])) {
        parse_str($_SERVER['QUERY_STRING'], $params);
    }

    $order = !empty($params['product_order']) ? $params['product_order'] : 'desc';
    $order = strtoupper($order);

    $args['orderby'] = "sum_of_comments_approved DESC, average_rating {$order}, $wpdb->posts.post_date DESC";

    $args['groupby'] = "$wpdb->posts.ID";

    return $args;
}

add_filter('loop_shop_per_page', 'evolve_loop_shop_per_page');

function evolve_loop_shop_per_page() {

    $woo_items = evolve_get_option('evl_woo_items', '12');

    if (isset($_SERVER['QUERY_STRING'])) {
        parse_str($_SERVER['QUERY_STRING'], $params);
    }

    if ($woo_items) {
        $per_page = $woo_items;
    } else {
        $per_page = 12;
    }

    $pc = !empty($params['product_count']) ? $params['product_count'] : $per_page;

    return $pc;
}

add_action('woocommerce_before_shop_loop_item_title', 'evolve_woocommerce_thumbnail', 10);
remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);

function evolve_woocommerce_thumbnail() {
    global $product, $woocommerce;

    $items_in_cart = array();

    if ($woocommerce->cart->get_cart() && is_array($woocommerce->cart->get_cart())) {
        foreach ($woocommerce->cart->get_cart() as $cart) {
            $items_in_cart[] = $cart['product_id'];
        }
    }

    $id = get_the_ID();
    $in_cart = in_array($id, $items_in_cart);
    $size = 'shop_catalog';

    $gallery = get_post_meta($id, '_product_image_gallery', true);
    $attachment_image = '';
    if (!empty($gallery)) {
        $gallery = explode(',', $gallery);
        $first_image_id = $gallery[0];
        $attachment_image = wp_get_attachment_image($first_image_id, $size, false, array('class' => 'hover-image'));
    }
    $thumb_image = get_the_post_thumbnail($id, $size);

    if ($attachment_image) {
        $classes = 'crossfade-images';
    } else {
        $classes = '';
    }

    echo '<span class="' . $classes . '">';
    echo $attachment_image;
    echo $thumb_image;
    if ($in_cart) {
        echo '<span class="cart-loading"><i class="t4p-icon t4p-icon-ok"></i></span>';
    } else {
        echo '<span class="cart-loading"><i class="t4p-icon t4p-icon-repeat"></i></span>';
    }
    echo '<span class="show_details_button">' . __('Show details', 'evolve') . '</span>';
    echo '</span>';
}

add_filter('add_to_cart_fragments', 'evolve_woocommerce_header_add_to_cart_fragment');

function evolve_woocommerce_header_add_to_cart_fragment($fragments) {
    global $woocommerce;

    ob_start();

    $evolve_header_type = evolve_get_option('evl_header_type', 'none');
    if ($evolve_header_type == 'h1') {
        ?>
        <li class="cart header-cart">
            <?php if (!$woocommerce->cart->cart_contents_count): ?>
                <a class="empty-cart" href="<?php echo get_permalink(get_option('woocommerce_cart_page_id')); ?>">
                    <?php echo wc_price($woocommerce->cart->cart_contents_total); ?>
                </a>
                <div class="cart-contents">
                    <div class="cart-content" style="width:180px!important;">
                        <strong style="padding:7px 10px;line-height:35px;">
                            <?php _e('Your cart is currently empty.', 'evolve'); ?>
                        </strong>
                    </div>
                </div>

            <?php else: ?>
                <a class="my-cart-link my-cart-link-active" href="<?php echo get_permalink(get_option('woocommerce_cart_page_id')); ?>">
                    <?php echo wc_price($woocommerce->cart->cart_contents_total); ?>
                </a>
                <div class="cart-contents">
                    <?php foreach ($woocommerce->cart->cart_contents as $cart_item): //var_dump($cart_item);     ?>
                        <div class="cart-content">
                            <a href="<?php echo get_permalink($cart_item['product_id']); ?>">
                                <?php
                                $thumbnail_id = ($cart_item['variation_id']) ? $cart_item['variation_id'] : $cart_item['product_id'];
                                echo get_the_post_thumbnail($thumbnail_id, 'recent-works-thumbnail');
                                ?>
                                <div class="cart-desc">
                                    <span class="cart-title"><?php echo $cart_item['data']->post->post_title; ?></span>
                                    <span class="product-quantity">
                                        <?php echo $cart_item['quantity']; ?> x <?php echo $woocommerce->cart->get_product_subtotal($cart_item['data'], $cart_item['quantity']); ?>
                                    </span>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                    <div class="cart-checkout">
                        <div class="cart-link">
                            <a href="<?php echo get_permalink(get_option('woocommerce_cart_page_id')); ?>"><?php _e('View Cart', 'evolve'); ?></a>
                        </div>
                        <div class="checkout-link">
                            <a href="<?php echo get_permalink(get_option('woocommerce_checkout_page_id')); ?>"><?php _e('Checkout', 'evolve'); ?></a>
                        </div>
                    </div>
                </div><!-- /.cart-contents -->
            <?php endif; //if(!$woocommerce->cart->cart_contents_count):         ?>
        </li><!-- /li.cart -->
        <?php
        $fragments['.cart.header-cart'] = ob_get_clean();
    }
    else if ($evolve_header_type == 'h2') {
        ?>
        <li class="cart header-cart">
            <?php if (!$woocommerce->cart->cart_contents_count): ?>
                <a class="empty-cart" href="<?php echo get_permalink(get_option('woocommerce_cart_page_id')); ?>">
                    <?php echo wc_price($woocommerce->cart->cart_contents_total); ?>
                </a>
                <div class="cart-contents">
                    <div class="cart-content" style="width:180px!important;">
                        <strong style="padding:7px 10px;line-height:35px;">
                            <?php _e('Your cart is currently empty.', 'evolve'); ?>
                        </strong>
                    </div>
                </div>

            <?php else: ?>
                <a class="my-cart-link my-cart-link-active" href="<?php echo get_permalink(get_option('woocommerce_cart_page_id')); ?>">
                    <?php //echo wc_price($woocommerce->cart->cart_contents_total);    ?>
                </a>
                <div class="cart-contents">
                    <?php foreach ($woocommerce->cart->cart_contents as $cart_item): //var_dump($cart_item);      ?>
                        <div class="cart-content">
                            <a href="<?php echo get_permalink($cart_item['product_id']); ?>">
                                <?php
                                $thumbnail_id = ($cart_item['variation_id']) ? $cart_item['variation_id'] : $cart_item['product_id'];
                                echo get_the_post_thumbnail($thumbnail_id, 'recent-works-thumbnail');
                                ?>
                                <div class="cart-desc">
                                    <span class="cart-title"><?php echo $cart_item['data']->post->post_title; ?></span>
                                    <span class="product-quantity">
                                        <?php echo $cart_item['quantity']; ?> x <?php echo $woocommerce->cart->get_product_subtotal($cart_item['data'], $cart_item['quantity']); ?>
                                    </span>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                    <div class="cart-checkout">
                        <div class="cart-link">
                            <a href="<?php echo get_permalink(get_option('woocommerce_cart_page_id')); ?>"><?php _e('View Cart', 'evolve'); ?></a>
                        </div>
                        <div class="checkout-link">
                            <a href="<?php echo get_permalink(get_option('woocommerce_checkout_page_id')); ?>"><?php _e('Checkout', 'evolve'); ?></a>
                        </div>
                    </div>
                </div><!-- /.cart-contents -->
            <?php endif; //if(!$woocommerce->cart->cart_contents_count):         ?>
        </li><!-- /li.cart -->
        <?php
        $fragments['.cart.header-cart'] = ob_get_clean();
    }
    else if ($evolve_header_type == 'h3') {
        ?>
        <li class="cart header-cart">
            <?php if (!$woocommerce->cart->cart_contents_count): ?>
                <a class="empty-cart" href="<?php echo get_permalink(get_option('woocommerce_cart_page_id')); ?>">
                    <?php echo wc_price($woocommerce->cart->cart_contents_total); ?>
                </a>
                <div class="cart-contents">
                    <div class="cart-content" style="width:180px!important;">

                        <strong style="padding:7px 10px;line-height:35px;">
                            <?php _e('Your cart is currently empty.', 'evolve'); ?>
                        </strong>
                    </div>
                </div>

            <?php else: ?>
                <a class="my-cart-link my-cart-link-active" href="<?php echo get_permalink(get_option('woocommerce_cart_page_id')); ?>">
                    <span><?php echo $woocommerce->cart->cart_contents_count; ?> item(s)</span>
                </a>
                <div class="cart-contents">
                    <?php foreach ($woocommerce->cart->cart_contents as $cart_item): //var_dump($cart_item);         ?>
                        <div class="cart-content">
                            <a href="<?php echo get_permalink($cart_item['product_id']); ?>">
                                <?php
                                $thumbnail_id = ($cart_item['variation_id']) ? $cart_item['variation_id'] : $cart_item['product_id'];
                                echo get_the_post_thumbnail($thumbnail_id, 'recent-works-thumbnail');
                                ?>
                                <div class="cart-desc">
                                    <span class="cart-title"><?php echo $cart_item['data']->post->post_title; ?></span>
                                    <span class="product-quantity">
                                        <?php echo $cart_item['quantity']; ?> x <?php echo $woocommerce->cart->get_product_subtotal($cart_item['data'], $cart_item['quantity']); ?>
                                    </span>
                                </div>
                            </a>
                        </div>

                    <?php endforeach; ?>
                    <div class="cart-checkout">
                        <div class="cart-link">
                            <a href="<?php echo get_permalink(get_option('woocommerce_cart_page_id')); ?>"><?php _e('View Cart', 'evolve'); ?></a>
                        </div>
                        <div class="checkout-link">
                            <a href="<?php echo get_permalink(get_option('woocommerce_checkout_page_id')); ?>"><?php _e('Checkout', 'evolve'); ?></a>
                        </div>
                    </div>
                </div><!-- /.cart-contents -->
            <?php endif; //if(!$woocommerce->cart->cart_contents_count):           ?>
        </li><!-- /li.cart -->
        <?php
        $fragments['.cart.header-cart'] = ob_get_clean();
    }else {
        ?>
        <li class="cart">
            <?php if (!$woocommerce->cart->cart_contents_count): ?>
                <a href="<?php echo get_permalink(get_option('woocommerce_cart_page_id')); ?>"><?php _e('0 Item(s)', 'evolve'); ?></a>
                <div class="cart-contents">
                    <div class="cart-content" style="width:180px!important;">
                        <strong style="padding:7px 10px;line-height:35px;">
                            <?php _e('Your cart is currently empty.', 'evolve'); ?>
                        </strong>
                    </div></div>
            <?php else: ?>
                <a href="<?php echo get_permalink(get_option('woocommerce_cart_page_id')); ?>"><?php echo $woocommerce->cart->cart_contents_count; ?> <?php _e('Item(s)', 'evolve'); ?> - <?php echo wc_price($woocommerce->cart->subtotal); ?></a>
                <div class="cart-contents">
                    <?php foreach ($woocommerce->cart->cart_contents as $cart_item): ?>
                        <div class="cart-content">
                            <a href="<?php echo get_permalink($cart_item['product_id']); ?>">
                                <?php
                                $thumbnail_id = ($cart_item['variation_id']) ? $cart_item['variation_id'] : $cart_item['product_id'];
                                echo get_the_post_thumbnail($thumbnail_id, 'recent-works-thumbnail');
                                ?>
                                <div class="cart-desc">
                                    <span class="cart-title"><?php echo $cart_item['data']->post->post_title; ?></span>
                                    <span class="product-quantity"><?php echo $cart_item['quantity']; ?> x <?php echo $woocommerce->cart->get_product_subtotal($cart_item['data'], 1); ?></span>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                    <div class="cart-checkout">
                        <div class="cart-link"><a href="<?php echo get_permalink(get_option('woocommerce_cart_page_id')); ?>"><?php _e('View Cart', 'evolve'); ?></a></div>
                        <div class="checkout-link"><a href="<?php echo get_permalink(get_option('woocommerce_checkout_page_id')); ?>"><?php _e('Checkout', 'evolve'); ?></a></div>
                    </div>
                </div>
            <?php endif; ?>
        </li>
        <?php
        $fragments['.header .cart'] = ob_get_clean();
    }

    ob_start();

    return $fragments;
}

add_action('woocommerce_after_single_product_summary', 'evolve_woocommerce_after_single_product_summary', 15);

function evolve_woocommerce_after_single_product_summary() {

    $woocommerce_social_links = evolve_get_option('evl_woocommerce_social_links', '1');
    $nofollow_social_links = evolve_get_option('evl_nofollow_social_links', '0');
    $social = '';
    $nofollow = '';
    if ($nofollow_social_links) {
        $nofollow = ' rel="nofollow"';
    }
    if ($woocommerce_social_links):

        $social .= '<ul class="social-share">
	<li class="facebook">
		<a target="_blank" class="tipsytext" title="' . __('Share On', 'evolve') . ' Facebook" href="http://www.facebook.com/sharer.php?m2w&s=100&p&#91;url&#93;=' . get_permalink() . '&p&#91;title&#93;=' . wp_strip_all_tags(get_the_title(), true) . '" target="_blank"' . $nofollow . '>
			<i class="t4p-icon-social-facebook"></i>  			
		</a>
	</li>
	<li class="twitter">
		<a target="_blank" class="tipsytext" title="' . __('Share On', 'evolve') . ' Twitter" href="https://twitter.com/share?text=' . wp_strip_all_tags(get_the_title(), true) . ' ' . get_permalink() . '" target="_blank"' . $nofollow . '>
			<i class="t4p-icon-social-twitter"></i>   
    </a>
	</li>
	<li class="pinterest">';
        $full_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
        $social .= '<a target="_blank" class="tipsytext" title="' . __('Pin to', 'evolve') . ' Pinterest" href="http://pinterest.com/pin/create/button/?url=' . urlencode(wp_strip_all_tags(get_the_title(), true)) . '&amp;description=' . urlencode(get_the_title()) . '&amp;media=' . urlencode($full_image[0]) . '" target="_blank"' . $nofollow . '>
			<i class="t4p-icon-social-pinterest"></i>      			
		</a>
	</li>
	<li class="email">
		<a target="_blank" class="tipsytext" title="' . __('Email to a Friend', 'evolve') . '" href="mailto:?subject=' . wp_strip_all_tags(get_the_title(), true) . '&amp;body=' . get_permalink() . '">
			<i class="t4p-icon-social-envelope-o"></i>    			
		</a>
	</li>
</ul>';
    endif;
    $social .= '<div style="clear:both;"></div>';

    echo $social;
}

remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
add_action('woocommerce_after_single_product_summary', 'evolve_woocommerce_output_related_products', 15);

function evolve_woocommerce_output_related_products() {
    $args = array(
        'posts_per_page' => 4,
        'columns' => 4,
        'orderby' => 'rand'
    );

    woocommerce_related_products(apply_filters('woocommerce_output_related_products_args', $args));
}

/* variations hooks */


/* end variations hooks */

/* cart hooks */
add_action('woocommerce_before_cart_table', 'evolve_woocommerce_before_cart_table', 20);

function evolve_woocommerce_before_cart_table($args) {
    global $woocommerce;

    $html = '<div class="woocommerce-content-box full-width clearfix">';

    $html .= '<h2>' . sprintf(__('You Have %d Items In Your Cart', 'evolve'), $woocommerce->cart->cart_contents_count) . '</h2>';

    echo $html;
}

add_action('woocommerce_after_cart_table', 'evolve_woocommerce_after_cart_table', 20);

function evolve_woocommerce_after_cart_table($args) {
    $html = '</div>';

    echo $html;
}

function woocommerce_cross_sell_display($posts_per_page = 3, $columns = 3, $orderby = 'rand') {
    wc_get_template('cart/cross-sells.php', array(
        'posts_per_page' => $posts_per_page,
        'orderby' => $orderby,
        'columns' => $columns
    ));
}

function cart_shipping_calc() {
    global $woocommerce;

    if (get_option('woocommerce_enable_shipping_calc') === 'no' || !WC()->cart->needs_shipping()) {
        return;
    }

    do_action('woocommerce_before_shipping_calculator');
    ?>

    <div class="shipping_calculator" action="<?php echo esc_url(WC()->cart->get_cart_url()); ?>" method="post">

        <h2><?php _e('Calculate Shipping', 'evolve'); ?></h2>

        <div class="evolve-shipping-calculator-form">

            <p class="form-row form-row-wide">
                <select name="calc_shipping_country" id="calc_shipping_country" class="country_to_state" rel="calc_shipping_state">
                    <option value=""><?php _e('Select a country&hellip;', 'evolve'); ?></option>
                    <?php
                    foreach (WC()->countries->get_shipping_countries() as $key => $value)
                        echo '<option value="' . esc_attr($key) . '"' . selected(WC()->customer->get_shipping_country(), esc_attr($key), false) . '>' . esc_html($value) . '</option>';
                    ?>
                </select>
            </p>

            <p class="form-row form-row-wide">
                <?php
                $current_cc = WC()->customer->get_shipping_country();
                $current_r = WC()->customer->get_shipping_state();
                $states = WC()->countries->get_states($current_cc);

                // Hidden Input
                if (is_array($states) && empty($states)) {
                    ?><input type="hidden" name="calc_shipping_state" id="calc_shipping_state" placeholder="<?php _e('State / county', 'evolve'); ?>" /><?php
                    // Dropdown Input
                } elseif (is_array($states)) {
                    ?><span>
                        <select name="calc_shipping_state" id="calc_shipping_state" placeholder="<?php _e('State / county', 'evolve'); ?>">
                            <option value=""><?php _e('Select a state&hellip;', 'evolve'); ?></option>
                            <?php
                            foreach ($states as $ckey => $cvalue)
                                echo '<option value="' . esc_attr($ckey) . '" ' . selected($current_r, $ckey, false) . '>' . esc_html( $cvalue ) . '</option>';
                            ?>
                        </select>
                    </span><?php
                    // Standard Input
                } else {
                    ?><input type="text" class="input-text" value="<?php echo esc_attr($current_r); ?>" placeholder="<?php _e('State / county', 'evolve'); ?>" name="calc_shipping_state" id="calc_shipping_state" /><?php
                }
                ?>
            </p>

            <?php if (apply_filters('woocommerce_shipping_calculator_enable_city', false)) : ?>

                <p class="form-row form-row-wide">
                    <input type="text" class="input-text" value="<?php echo esc_attr(WC()->customer->get_shipping_city()); ?>" placeholder="<?php _e('City', 'evolve'); ?>" name="calc_shipping_city" id="calc_shipping_city" />
                </p>

                <?php
            endif;

            if (apply_filters('woocommerce_shipping_calculator_enable_postcode', true)) :
                ?>

                <p class="form-row form-row-wide">
                    <input type="text" class="input-text" value="<?php echo esc_attr(WC()->customer->get_shipping_postcode()); ?>" placeholder="<?php _e('Postcode / Zip', 'evolve'); ?>" name="calc_shipping_postcode" id="calc_shipping_postcode" />
                </p>

            <?php endif; ?>

            <p><button type="submit" name="calc_shipping" value="1" class="button"><?php _e('Update Totals', 'evolve'); ?></button></p>

            <?php wp_nonce_field('woocommerce-cart'); ?>
        </div>
    </div>

    <?php
    do_action('woocommerce_after_shipping_calculator');
}

add_action('woocommerce_cart_collaterals', 'evolve_woocommerce_cart_collaterals');

function evolve_woocommerce_cart_collaterals($args) {
    global $woocommerce;
    ?>

    <div class="shipping-coupon">

        <?php
        echo cart_shipping_calc();

        if (WC()->cart->coupons_enabled()) {
            ?>
            <div class="coupon">

                <h2><?php _e('Have A Promotional Code?', 'evolve'); ?></h2>

                <input name="coupon_code" type="text" class="input-text" id="coupon_code" value="" placeholder="<?php _e('Coupon code', 'evolve'); ?>" />
                <input type="submit" class="button medium default" name="apply_coupon" value="<?php _e('Apply', 'evolve'); ?>" />

                <?php do_action('woocommerce_cart_coupon'); ?>

            </div>
            <?php
        }
        ?>
    </div>
    <?php
}

add_action('woocommerce_before_cart_totals', 'evolve_woocommerce_before_cart_totals', 20);

function evolve_woocommerce_before_cart_totals($args) {
    global $woocommerce;
    ?>

    <form action="<?php echo esc_url(WC()->cart->get_cart_url()); ?>" method="post">

        <?php
    }

    add_action('woocommerce_after_cart', 'evolve_woocommerce_after_cart');

    function evolve_woocommerce_after_cart($args) {
        ?>

    </form>

    <?php
}

remove_action('woocommerce_cart_collaterals', 'woocommerce_cross_sell_display');
add_action('woocommerce_cart_collaterals', 'evolve_woocommerce_cross_sell_display', 5);

function evolve_woocommerce_cross_sell_display() {
    global $product, $woocommerce_loop, $post, $smof_data;

    $crosssells = WC()->cart->get_cross_sells();

    if (sizeof($crosssells) == 0)
        return;

    $number_of_columns = 4;

    woocommerce_cross_sell_display(apply_filters('woocommerce_cross_sells_total', -1), $number_of_columns);
}

/* end cart hooks */

/* begin checkout hooks */
remove_action('woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10);
add_action('woocommerce_before_checkout_form', 'evolve_woocommerce_checkout_coupon_form', 10);

function evolve_woocommerce_checkout_coupon_form($args) {
    global $woocommerce;

    if (!WC()->cart->coupons_enabled())
        return;
    ?>

    <form class="woocommerce-content-box full-width checkout_coupon" method="post">

        <h2 class="promo-code-heading alignleft"><?php _e('Have A Promotional Code?', 'evolve'); ?></h2>

        <div class="coupon-contents alignright">
            <div class="form-row form-row-first alignleft coupon-input">
                <input type="text" name="coupon_code" class="input-text" placeholder="<?php _e('Coupon code', 'evolve'); ?>" id="coupon_code" value="" />
            </div>

            <div class="form-row form-row-last alignleft coupon-button">
                <input type="submit" class="button" name="apply_coupon" value="<?php _e('Apply Coupon', 'evolve'); ?>" />
            </div>

            <div class="clear"></div>
        </div>
    </form>
    <?php
}

$evolve_woocommerce_option = get_option('evl_options');
$woocommerce_one_page_checkout = isset($evolve_woocommerce_option['evl_woocommerce_one_page_checkout']) ? $evolve_woocommerce_option['evl_woocommerce_one_page_checkout'] : '';

if ($woocommerce_one_page_checkout != '1') {
    add_action('woocommerce_before_checkout_form', 'evolve_woocommerce_before_checkout_form');
}

function evolve_woocommerce_before_checkout_form($args) {
    global $woocommerce;
    ?>

    <ul class="woocommerce-side-nav woocommerce-checkout-nav">
        <li class="active">
            <a data-name="col-1" href="#">
                <?php _e('Billing Address', 'evolve'); ?>
            </a>
        </li>
        <?php if (WC()->cart->needs_shipping() && !WC()->cart->ship_to_billing_address_only()) : ?>
            <li>
                <a data-name="col-2" href="#">
                    <?php _e('Shipping Address', 'evolve'); ?>
                </a>
            </li>
            <?php
        elseif (apply_filters('woocommerce_enable_order_notes_field', get_option('woocommerce_enable_order_comments', 'yes') === 'yes')) :

            if (!WC()->cart->needs_shipping() || WC()->cart->ship_to_billing_address_only()) :
                ?>

                <li>
                    <a data-name="col-2" href="#">
                        <?php _e('Additional Information', 'evolve'); ?>
                    </a>
                </li>
                <?php
            endif;
        endif;
        ?>

        <li>
            <a data-name="#order_review" href="#">
                <?php _e('Review &amp; Payment', 'evolve'); ?>
            </a>
        </li>
    </ul>

    <div class="woocommerce-content-box evolve-checkout">

        <?php
    }

    if (!$woocommerce_one_page_checkout) {
        add_action('woocommerce_after_checkout_form', 'evolve_woocommerce_after_checkout_form');
    }

    function evolve_woocommerce_after_checkout_form($args) {
        ?>

    </div>

    <?php
}

if ($woocommerce_one_page_checkout) {
    add_action('woocommerce_checkout_before_customer_details', 'evolve_woocommerce_checkout_before_customer_details');
}

function evolve_woocommerce_checkout_before_customer_details($args) {
    global $woocommerce;

    if (WC()->cart->needs_shipping() && !WC()->cart->ship_to_billing_address_only() ||
            apply_filters('woocommerce_enable_order_notes_field', get_option('woocommerce_enable_order_comments', 'yes') === 'yes') && (!WC()->cart->needs_shipping() || WC()->cart->ship_to_billing_address_only() )
    ) {
        return;
    } else {
        ?>

        <div class="evolve-checkout-no-shipping">

            <?php
        }
    }

    if ($woocommerce_one_page_checkout) {
        add_action('woocommerce_checkout_after_customer_details', 'evolve_woocommerce_checkout_after_customer_details');
    }

    function evolve_woocommerce_checkout_after_customer_details($args) {
        global $woocommerce;

        if (WC()->cart->needs_shipping() && !WC()->cart->ship_to_billing_address_only() ||
                apply_filters('woocommerce_enable_order_notes_field', get_option('woocommerce_enable_order_comments', 'yes') === 'yes') && (!WC()->cart->needs_shipping() || WC()->cart->ship_to_billing_address_only() )
        ) {
            ?>

            <div class="clearboth"></div>

        <?php } else { ?>

            <div class="clearboth"></div>
        </div>

    <?php } ?>

    <div class="woocommerce-content-box full-width clearfix">

        <?php
    }

    add_action('woocommerce_checkout_billing', 'evolve_woocommerce_checkout_billing', 20);

    function evolve_woocommerce_checkout_billing($args) {
        global $woocommerce;

        if (WC()->cart->needs_shipping() && !WC()->cart->ship_to_billing_address_only() ||
                apply_filters('woocommerce_enable_order_notes_field', get_option('woocommerce_enable_order_comments', 'yes') === 'yes') && (!WC()->cart->needs_shipping() || WC()->cart->ship_to_billing_address_only() )
        ) {
            $data_name = 'col-2';
        } else {
            $data_name = '#order_review';
        }
        $evolve_woocommerce_option = get_option('evl_options');
        $woocommerce_one_page_checkout = $evolve_woocommerce_option['evl_woocommerce_one_page_checkout'];
        if (!$woocommerce_one_page_checkout) {
            ?>

            <a data-name="<?php echo $data_name; ?>" href="#" class="button default medium submit t4p-button-default continue-checkout"><?php _e('Continue', 'evolve'); ?></a>
            <div class="clearboth"></div>

            <?php
        }
    }

    add_action('woocommerce_checkout_shipping', 'evolve_woocommerce_checkout_shipping', 20);

    function evolve_woocommerce_checkout_shipping($args) {

        $evolve_woocommerce_option = get_option('evl_options');
        $woocommerce_one_page_checkout = $evolve_woocommerce_option['evl_woocommerce_one_page_checkout'];

        if (!$woocommerce_one_page_checkout) {
            ?>

            <a data-name="#order_review" href="#" class="button default medium submit t4p-button-default continue-checkout"><?php _e('Continue', 'evolve'); ?></a>
            <div class="clearboth"></div>

            <?php
        }
    }

    add_filter('woocommerce_enable_order_notes_field', 'evolve_enable_order_notes_field');

    function evolve_enable_order_notes_field() {

        $woocommerce_enable_order_notes = evolve_get_option('evl_woocommerce_enable_order_notes', '0');

        if (!$woocommerce_enable_order_notes) {
            return 0;
        }

        return 1;
    }

    //function under order hooks
    remove_action('woocommerce_thankyou', 'woocommerce_order_details_table', 10);
    add_action('woocommerce_thankyou', 'evolve_woocommerce_view_order', 10);
    /* end checkout hooks */

    /* begin my-account hooks */

    add_action('woocommerce_before_customer_login_form', 'evolve_woocommerce_before_customer_login_form');

    function evolve_woocommerce_before_customer_login_form() {

        global $woocommerce;

        if (get_option('woocommerce_enable_myaccount_registration') !== 'yes') :
            ?>

            <div id="customer_login" class="woocommerce-content-box full-width">

                <?php
            endif;
        }

        add_action('woocommerce_after_customer_login_form', 'evolve_woocommerce_after_customer_login_form');

        function evolve_woocommerce_after_customer_login_form() {

            global $woocommerce;

            if (get_option('woocommerce_enable_myaccount_registration') !== 'yes') :
                ?>

            </div>

            <?php
        endif;
    }

    add_action('woocommerce_account_dashboard', 'evolve_woocommerce_account_dashboard');

    function evolve_woocommerce_account_dashboard() {

        global $woocommerce, $current_user;
        $woo_acc_msg_1 = evolve_get_option('evl_woo_acc_msg_1', 'Call us - <i class="t4p-icon-phone"></i> 7438 882 764');
        $woo_acc_msg_2 = evolve_get_option('evl_woo_acc_msg_2', 'Email us - <i class="t4p-icon-envelope-o"></i> contact@example.com');
        ?>

        <p class="evolve_myaccount_user">
            <span class="myaccount_user_container">
                <span class="username">
                    <?php
                    printf(
                            __('Hello, %s', 'evolve'), $current_user->display_name
                    );
                    ?>
                </span>
                <?php if ($woo_acc_msg_1): ?>
                    <span class="msg">
                        <?php echo $woo_acc_msg_1; ?>
                    </span>
                    <?php
                endif;
                if ($woo_acc_msg_2):
                    ?>
                    <span class="msg">
                        <?php echo $woo_acc_msg_2; ?>
                    </span>
                <?php endif; ?>
                <span class="view-cart">
                    <a class="button default medium submit t4p-button-default" href="<?php echo get_permalink(get_option('woocommerce_cart_page_id')); ?>"><?php _e('View Cart', 'evolve'); ?></a>
                </span>
            </span>
        </p>
        <div class="woocommerce-side-nav">
            <ul class="woocommerce-side-nav-ul evolve-myaccount-nav">
                <li <?php
                if (isset($_SESSION['formvalue'])):
                else:
                    echo 'class="active"';
                endif;
                ?>
                    >
                    <a class="dashboard" href="#">
                        <?php _e('Dashboard', 'evolve'); ?>
                    </a>
                </li>

                <li>
                    <a class="downloads" href="#">
                        <?php _e('View Downloads', 'evolve'); ?>
                    </a>
                </li>

                <li>
                    <a class="orders" href="#">
                        <?php _e('View Orders', 'evolve'); ?>
                    </a>
                </li>

                <li <?php
                if (isset($_SESSION['formvalue'])) {
                    echo 'class="active"';
                }
                ?>
                    >
                    <a class="address" href="#">
                        <?php _e('Change Address', 'evolve'); ?>
                    </a>
                </li>

                <li>
                    <a class="account" href="#">
                        <?php _e('Edit Account', 'evolve'); ?>
                    </a>
                </li>

            </ul>
            <ul class="woocommerce-side-nav-ul woocommerce-side-nav-logout">
                <li>
                    <a class="logout" href="<?php echo esc_url(wc_get_endpoint_url('customer-logout', '', wc_get_page_permalink('myaccount'))); ?>">
                        <?php _e('Logout', 'evolve'); ?>
                    </a>
                </li>
            </ul>
        </div>
        <div class="woocommerce-content-box evolve-myaccount-data">

            <?php
        }

        add_action('woocommerce_view_dashboard', 'evolve_woocommerce_view_dashboard');

        function evolve_woocommerce_view_dashboard($args) {
            global $woocommerce, $current_user;
            $woo_acc_msg_1 = evolve_get_option('evl_woo_acc_msg_1', 'Call us - <i class="t4p-icon-phone"></i> 7438 882 764');
            $woo_acc_msg_2 = evolve_get_option('evl_woo_acc_msg_2', 'Email us - <i class="t4p-icon-envelope-o"></i> contact@example.com');
            ?>
            <div class="view_dashboard" <?php
            if (isset($_SESSION['formvalue'])) {
                echo 'style="display:none"';
            }
            ?> >
                <p>
                    <?php
                    echo sprintf(esc_attr__('Hello %s%s%s (not %2$s? %sSign out%s)', 'evolve'), '<strong>', esc_html($current_user->display_name), '</strong>', '<a href="' . esc_url(wc_get_endpoint_url('customer-logout', '', wc_get_page_permalink('myaccount'))) . '">', '</a>');
                    ?>
                </p>

                <p>
                    <?php
                    echo sprintf(esc_attr__('From your account dashboard you can view your %1$srecent orders%2$s, manage your %3$sshipping and billing addresses%2$s and %4$sedit your password and account details%2$s.', 'evolve'), '<a href="' . esc_url(wc_get_endpoint_url('orders')) . '">', '</a>', '<a href="' . esc_url(wc_get_endpoint_url('edit-address')) . '">', '<a href="' . esc_url(wc_get_endpoint_url('edit-account')) . '">');
                    ?>
                </p>
            </div>
            <?php
        }

        add_action('woocommerce_account_orders', 'evolve_woocommerce_before_account_orders');

        function evolve_woocommerce_before_account_orders($args) {
            $order_count = "";
            $my_orders_columns = apply_filters('woocommerce_my_account_my_orders_columns', array(
                'order-number' => __('Order', 'evolve'),
                'order-date' => __('Date', 'evolve'),
                'order-status' => __('Status', 'evolve'),
                'order-total' => __('Total', 'evolve'),
                'order-actions' => '&nbsp;',
            ));

            $customer_orders = get_posts(apply_filters('woocommerce_my_account_my_orders_query', array(
                'numberposts' => $order_count,
                'meta_key' => '_customer_user',
                'meta_value' => get_current_user_id(),
                'post_type' => wc_get_order_types('view-orders'),
                'post_status' => array_keys(wc_get_order_statuses())
            )));

            if ($customer_orders) :
                ?>

                <h2><?php echo apply_filters('woocommerce_my_account_my_orders_title', __('Recent Orders', 'evolve')); ?></h2>

                <table class="shop_table shop_table_responsive my_account_orders">

                    <thead>
                        <tr>
                            <?php foreach ($my_orders_columns as $column_id => $column_name) : ?>
                                <th class="<?php echo esc_attr($column_id); ?>"><span class="nobr"><?php echo esc_html($column_name); ?></span></th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        foreach ($customer_orders as $customer_order) :
                            $order = wc_get_order($customer_order);
                            $item_count = $order->get_item_count();
                            ?>
                            <tr class="order">
                                <?php foreach ($my_orders_columns as $column_id => $column_name) : ?>
                                    <td class="<?php echo esc_attr($column_id); ?>" data-title="<?php echo esc_attr($column_name); ?>">
                                        <?php if (has_action('woocommerce_my_account_my_orders_column_' . $column_id)) : ?>
                                            <?php do_action('woocommerce_my_account_my_orders_column_' . $column_id, $order); ?>

                                        <?php elseif ('order-number' === $column_id) : ?>
                                            <a href="<?php echo esc_url($order->get_view_order_url()); ?>">
                                                <?php echo _x('#', 'hash before order number', 'evolve') . $order->get_order_number(); ?>
                                            </a>

                                        <?php elseif ('order-date' === $column_id) : ?>
                                            <?php echo wc_format_datetime( $order->get_date_created() ); ?>

                                        <?php elseif ('order-status' === $column_id) : ?>
                                            <?php echo wc_get_order_status_name($order->get_status()); ?>

                                        <?php elseif ('order-total' === $column_id) : ?>
                                            <?php echo sprintf(_n('%s for %s item', '%s for %s items', $item_count, 'evolve'), $order->get_formatted_order_total(), $item_count); ?>

                                        <?php elseif ('order-actions' === $column_id) : ?>
                                            <?php
                                            $actions = array(
                                                'pay' => array(
                                                    'url' => $order->get_checkout_payment_url(),
                                                    'name' => __('Pay', 'evolve')
                                                ),
                                                'view' => array(
                                                    'url' => $order->get_view_order_url(),
                                                    'name' => __('View', 'evolve')
                                                ),
                                                'cancel' => array(
                                                    'url' => $order->get_cancel_order_url(wc_get_page_permalink('myaccount')),
                                                    'name' => __('Cancel', 'evolve')
                                                )
                                            );

                                            if (!$order->needs_payment()) {
                                                unset($actions['pay']);
                                            }

                                            if (!in_array($order->get_status(), apply_filters('woocommerce_valid_order_statuses_for_cancel', array('pending', 'failed'), $order))) {
                                                unset($actions['cancel']);
                                            }

                                            if ($actions = apply_filters('woocommerce_my_account_my_orders_actions', $actions, $order)) {
                                                foreach ($actions as $key => $action) {
                                                    echo '<a href="' . esc_url($action['url']) . '" class="button ' . sanitize_html_class($key) . '">' . esc_html($action['name']) . '</a>';
                                                }
                                            }
                                            ?>
                                        <?php endif; ?>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else : ?>
                <div class="woocommerce-Message woocommerce-Message--info woocommerce-info my_account_orders">
                    <a class="woocommerce-Button button" href="<?php echo esc_url(apply_filters('woocommerce_return_to_shop_redirect', wc_get_page_permalink('shop'))); ?>">
                        <?php _e('Go Shop', 'evolve') ?>
                    </a>
                    <?php _e('No order has been made yet.', 'evolve'); ?>
                </div>
            <?php
            endif;
        }

        add_action('woocommerce_account_downloads', 'evolve_woocommerce_before_account_downloads');

        function evolve_woocommerce_before_account_downloads($args) {
            if ($downloads = WC()->customer->get_downloadable_products()) :

                do_action('woocommerce_before_available_downloads');
                ?>

                <h2><?php echo apply_filters('woocommerce_my_account_my_downloads_title', __('Available Downloads', 'evolve')); ?></h2>

                <ul class="woocommerce-Downloads digital-downloads">
                    <?php foreach ($downloads as $download) : ?>
                        <li>
                            <?php
                            do_action('woocommerce_available_download_start', $download);

                            if (is_numeric($download['downloads_remaining'])) {
                                $downloads_remaining = $download['downloads_remaining'];
                                echo apply_filters('woocommerce_available_download_count', '<span class="woocommerce-Count count">' . sprintf( _n( '%s download remaining', '%s downloads remaining', $downloads_remaining, 'evolve' ), $download['downloads_remaining'] ) . '</span> ', $download);
                            }

                            echo apply_filters('woocommerce_available_download_link', '<a href="' . esc_url($download['download_url']) . '">' . $download['download_name'] . '</a>', $download);

                            do_action('woocommerce_available_download_end', $download);
                            ?>
                        </li>
                    <?php endforeach; ?>
                </ul>

                <?php
                do_action('woocommerce_after_available_downloads');
            else :
                ?>
                <div class="woocommerce-Message woocommerce-Message--info woocommerce-info digital-downloads">
                    <a class="woocommerce-Button button" href="<?php echo esc_url(apply_filters('woocommerce_return_to_shop_redirect', wc_get_page_permalink('shop'))); ?>">
                        <?php esc_html_e('Go Shop', 'evolve') ?>
                    </a>
                    <?php esc_html_e('No downloads available yet.', 'evolve'); ?>
                </div>
            <?php
            endif;
        }

        add_action('woocommerce_account_address', 'evolve_woocommerce_before_my_account');

        function evolve_woocommerce_before_my_account($args) {
            $address_session = '';
            if (isset($_SESSION['formvalue'])) {
                $address_session = 'style="display:block"';
            }
            ?>
            <div class="myaccount_address" id="change_address" <?php echo $address_session; ?>>
                <h2 class="edit_address_heading" <?php echo $address_session; ?>><?php echo apply_filters('woocommerce_my_account_edit_address_title', 'My Address'); ?></h2>
                <?php
                $customer_id = get_current_user_id();

                if (!wc_ship_to_billing_address_only() && wc_shipping_enabled()) {
                    $get_addresses = apply_filters('woocommerce_my_account_get_addresses', array(
                        'billing' => __('Billing Address', 'evolve'),
                        'shipping' => __('Shipping Address', 'evolve')
                            ), $customer_id);
                } else {
                    $get_addresses = apply_filters('woocommerce_my_account_get_addresses', array(
                        'billing' => __('Billing Address', 'evolve')
                            ), $customer_id);
                }

                $oldcol = 1;
                $col = 1;
                ?>

                <p>
                    <?php echo apply_filters('woocommerce_my_account_my_address_description', __('The following addresses will be used on the checkout page by default.', 'evolve')); ?>
                </p>

                <?php
                if (!wc_ship_to_billing_address_only() && wc_shipping_enabled())
                    echo '<div class="u-columns woocommerce-Addresses col2-set">';

                foreach ($get_addresses as $name => $title) :
                    ?>

                    <div class="u-column<?php echo ( ( $col = $col * -1 ) < 0 ) ? 1 : 2; ?> col-<?php echo ( ( $oldcol = $oldcol * -1 ) < 0 ) ? 1 : 2; ?> woocommerce-Address">
                        <header class="woocommerce-Address-title title">
                            <h3><?php echo $title; ?></h3>
                            <a href="#" data-name="<?php echo $name; ?>" id="editaddress_<?php echo $name; ?>" class="edit woo_editaddress"><?php _e('Edit', 'evolve'); ?></a>
                        </header>
                        <address>
                            <?php
                            $address = apply_filters('woocommerce_my_account_my_address_formatted_address', array(
                                'first_name' => get_user_meta($customer_id, $name . '_first_name', true),
                                'last_name' => get_user_meta($customer_id, $name . '_last_name', true),
                                'company' => get_user_meta($customer_id, $name . '_company', true),
                                'address_1' => get_user_meta($customer_id, $name . '_address_1', true),
                                'address_2' => get_user_meta($customer_id, $name . '_address_2', true),
                                'city' => get_user_meta($customer_id, $name . '_city', true),
                                'state' => get_user_meta($customer_id, $name . '_state', true),
                                'postcode' => get_user_meta($customer_id, $name . '_postcode', true),
                                'country' => get_user_meta($customer_id, $name . '_country', true)
                                    ), $customer_id, $name);

                            $formatted_address = WC()->countries->get_formatted_address($address);

                            if (!$formatted_address)
                                _e('You have not set up this type of address yet.', 'evolve');
                            else
                                echo $formatted_address;
                            ?>
                        </address>
                    </div>

                    <?php
                endforeach;

                if (!wc_ship_to_billing_address_only() && wc_shipping_enabled())
                    echo '<div class="clear"></div></div>';

                $load_address = 'billing';
                $current_user = wp_get_current_user();
                $address = WC()->countries->get_address_fields(get_user_meta(get_current_user_id(), $load_address . '_country', true), $load_address . '_');
                // Prepare values
                foreach ($address as $key => $field) {
                    $value = get_user_meta(get_current_user_id(), $key, true);

                    if (!$value) {
                        switch ($key) {
                            case 'billing_email' :
                            case 'shipping_email' :
                                $value = $current_user->user_email;
                                break;
                            case 'billing_country' :
                            case 'shipping_country' :
                                $value = WC()->countries->get_base_country();
                                break;
                            case 'billing_state' :
                            case 'shipping_state' :
                                $value = WC()->countries->get_base_state();
                                break;
                        }
                    }

                    $address[$key]['value'] = apply_filters('woocommerce_my_account_edit_address_field_value', $value, $key, $load_address);

                    $addressform_session = '';
                    if (isset($_SESSION['formvalue']) && !empty($field['required']) && isset($_POST[$key])) {
                        $addressform_session = 'style=display:block';
                    } elseif (isset($_SESSION['formvalue'])) {
                        $addressform_session = 'style=display:none';
                    }
                }
                ?>
                <h3 class="editaddress_billing" <?php echo $addressform_session; ?>><?php _e('Billing Address', 'evolve'); ?></h3>
                <div class="editaddress_billing" <?php echo $addressform_session; ?>>
                    <form method="post">

                        <?php
                        foreach ($address as $key => $field) :

                            woocommerce_form_field($key, $field, !empty($_POST[$key]) ? wc_clean($_POST[$key]) : $field['value'] );

                        endforeach;
                        ?>

                        <p>
                            <input type="submit" class="button small default alignright" id="saveaddress" name="save_address" value="<?php _e('Save Address', 'evolve'); ?>" />
                            <?php wp_nonce_field('woocommerce-edit_address'); ?>
                            <input type="hidden" name="action" value="edit_address" />
                            <input type="hidden" name="formvalue" value="billing" />
                        <div class="clearboth"></div>
                        </p>

                    </form>
                </div>

                <?php
                $load_address = 'shipping';
                $current_user = wp_get_current_user();
                $address = WC()->countries->get_address_fields(get_user_meta(get_current_user_id(), $load_address . '_country', true), $load_address . '_');
                // Prepare values
                foreach ($address as $key => $field) {

                    $value = get_user_meta(get_current_user_id(), $key, true);

                    if (!$value) {
                        switch ($key) {
                            case 'billing_email' :
                            case 'shipping_email' :
                                $value = $current_user->user_email;
                                break;
                            case 'billing_country' :
                            case 'shipping_country' :
                                $value = WC()->countries->get_base_country();
                                break;
                            case 'billing_state' :
                            case 'shipping_state' :
                                $value = WC()->countries->get_base_state();
                                break;
                        }
                    }

                    $address[$key]['value'] = apply_filters('woocommerce_my_account_edit_address_field_value', $value, $key, $load_address);

                    $addressform_session = '';
                    if (isset($_SESSION['formvalue']) && !empty($field['required']) && isset($_POST[$key])) {
                        $addressform_session = 'style=display:block';
                    } elseif (isset($_SESSION['formvalue'])) {
                        $addressform_session = 'style=display:none';
                    }
                }
                ?>
                <h3 class="editaddress_shipping" <?php echo $addressform_session; ?>><?php _e('Shipping Address', 'evolve'); ?></h3>
                <div class="editaddress_shipping" <?php echo $addressform_session; ?>>
                    <form method="post">

                        <?php
                        foreach ($address as $key => $field) :

                            woocommerce_form_field($key, $field, !empty($_POST[$key]) ? wc_clean($_POST[$key]) : $field['value'] );

                        endforeach;
                        ?>

                        <p>
                            <input type="submit" class="button small default alignright" id="saveaddress" name="save_address" value="<?php _e('Save Address', 'evolve'); ?>" />
                            <?php wp_nonce_field('woocommerce-edit_address'); ?>
                            <input type="hidden" name="action" value="edit_address" />
                            <input type="hidden" name="formvalue" value="shipping" />
                        <div class="clearboth"></div>
                        </p>

                    </form>
                </div>
            </div>
            <?php
            unset($_SESSION['formvalue']);
        }

        class evolve_WC_Form_Handler extends WC_Form_Handler {

            public static function init() {
                remove_action('template_redirect', array('WC_Form_Handler', 'save_address'));
                add_action('template_redirect', array(__CLASS__, 'evolve_save_address'));
            }

            public static function evolve_save_address() {
                global $wp;

                $formvalue = '';
                if ( isset($_POST['formvalue']) ) {
                    $formvalue = $_POST['formvalue'];
                    $_SESSION['formvalue'] = $_POST['formvalue'];
                }

                if( isset($_POST['_wp_http_referer']) && strpos($_POST['_wp_http_referer'], '/shipping' ) !== false ) {
                    $formvalue = 'shipping';
                    $_SESSION['formvalue'] = 'shipping';
                } elseif ( isset($_POST['_wp_http_referer']) && strpos($_POST['_wp_http_referer'], '/billing' ) !== false ) {
                    $formvalue = 'billing';
                    $_SESSION['formvalue'] = 'billing';
                }

                if ('POST' !== strtoupper($_SERVER['REQUEST_METHOD'])) {
                    return;
                }

                if (empty($_POST['action']) || 'edit_address' !== $_POST['action'] || empty($_POST['_wpnonce']) || !wp_verify_nonce($_POST['_wpnonce'], 'woocommerce-edit_address')) {
                    return;
                }

                $user_id = get_current_user_id();

                if ($user_id <= 0) {
                    return;
                }

                $load_address = ( $formvalue == 'shipping' ) ? 'shipping' : 'billing';

                $address = WC()->countries->get_address_fields(esc_attr($_POST[$load_address . '_country']), $load_address . '_');

                foreach ($address as $key => $field) {
                    if (!isset($field['type'])) {
                        $field['type'] = 'text';
                    }

                    // Get Value.
                    switch ($field['type']) {
                        case 'checkbox' :
                            $_POST[$key] = isset($_POST[$key]) ? 1 : 0;
                            break;
                        default :
                            $_POST[$key] = isset($_POST[$key]) ? wc_clean($_POST[$key]) : '';
                            break;
                    }

                    // Hook to allow modification of value.
                    $_POST[$key] = apply_filters('woocommerce_process_myaccount_field_' . $key, $_POST[$key]);

                    // Validation: Required fields.
                    if (!empty($field['required']) && empty($_POST[$key])) {
                        wc_add_notice($field['label'] . ' ' . __('is a required field.', 'evolve'), 'error');
                    }

                    if (!empty($_POST[$key])) {

                        // Validation rules
                        if (!empty($field['validate']) && is_array($field['validate'])) {
                            foreach ($field['validate'] as $rule) {
                                switch ($rule) {
                                    case 'postcode' :
                                        $_POST[$key] = strtoupper(str_replace(' ', '', $_POST[$key]));

                                        if (!WC_Validation::is_postcode($_POST[$key], $_POST[$load_address . '_country'])) {
                                            wc_add_notice(__('Please enter a valid postcode/ZIP.', 'evolve'), 'error');
                                        } else {
                                            $_POST[$key] = wc_format_postcode($_POST[$key], $_POST[$load_address . '_country']);
                                        }
                                        break;
                                    case 'phone' :
                                        $_POST[$key] = wc_format_phone_number($_POST[$key]);

                                        if (!WC_Validation::is_phone($_POST[$key])) {
                                            wc_add_notice('<strong>' . $field['label'] . '</strong> ' . __('is not a valid phone number.', 'evolve'), 'error');
                                        }
                                        break;
                                    case 'email' :
                                        $_POST[$key] = strtolower($_POST[$key]);

                                        if (!is_email($_POST[$key])) {
                                            wc_add_notice('<strong>' . $field['label'] . '</strong> ' . __('is not a valid email address.', 'evolve'), 'error');
                                        }
                                        break;
                                }
                            }
                        }
                    }
                }

                if (wc_notice_count('error') == 0) {

                    foreach ($address as $key => $field) {
                        update_user_meta($user_id, $key, $_POST[$key]);
                    }

                    wc_add_notice(__('Address changed successfully.', 'evolve'));

                    do_action('woocommerce_customer_save_address', $user_id, $load_address);

                    wp_safe_redirect(wc_get_page_permalink('myaccount'));
                    exit;
                }
            }

        }

        evolve_WC_Form_Handler::init();

        add_action('woocommerce_account_editaccount', 'evolve_woocommerce_after_my_account');

        function evolve_woocommerce_after_my_account($args) {
            global $woocommerce, $wp;

            $user = wp_get_current_user();
            ?>

            <h2 class="edit-account-heading"><?php _e('Edit Account', 'evolve'); ?></h2>

            <form class="edit-account-form" action="" method="post">
                <p class="form-row form-row-first">
                    <label for="account_first_name"><?php _e('First name', 'evolve'); ?> <span class="required">*</span></label>
                    <input type="text" class="input-text" name="account_first_name" id="account_first_name" value="<?php esc_attr($user->first_name); ?>" />
                </p>
                <p class="form-row form-row-last">
                    <label for="account_last_name"><?php _e('Last name', 'evolve'); ?> <span class="required">*</span></label>
                    <input type="text" class="input-text" name="account_last_name" id="account_last_name" value="<?php esc_attr($user->last_name); ?>" />
                </p>
                <p class="form-row form-row-wide">
                    <label for="account_email"><?php _e('Email address', 'evolve'); ?> <span class="required">*</span></label>
                    <input type="email" class="input-text" name="account_email" id="account_email" value="<?php esc_attr($user->user_email); ?>" />
                </p>
                <fieldset>
                    <legend><?php _e('Password Change', 'evolve'); ?></legend>

                    <p class="form-row form-row-wide">
                        <label for="password_current"><?php _e('Current Password (leave blank to leave unchanged)', 'evolve'); ?></label>
                        <input type="password" class="input-text" name="password_current" id="password_current" />
                    </p>
                    <p class="form-row form-row-wide">
                        <label for="password_1"><?php _e('New Password (leave blank to leave unchanged)', 'evolve'); ?></label>
                        <input type="password" class="input-text" name="password_1" id="password_1" />
                    </p>
                    <p class="form-row form-row-wide">
                        <label for="password_2"><?php _e('Confirm New Password', 'evolve'); ?></label>
                        <input type="password" class="input-text" name="password_2" id="password_2" />
                    </p>
                </fieldset>
                <div class="clear"></div>

                <p><input type="submit" class="button small default alignright" name="save_account_details" value="<?php _e('Save changes', 'evolve'); ?>" /></p>

                <?php wp_nonce_field('save_account_details'); ?>
                <input type="hidden" name="action" value="save_account_details" />
                <div class="clearboth"></div>
            </form>

        </div>

        <?php
    }

    /* end my-account hooks */

    /* begin order hooks */
    remove_action('woocommerce_view_order', 'woocommerce_order_details_table', 10);
    add_action('woocommerce_view_order', 'evolve_woocommerce_view_order', 10);

    function evolve_woocommerce_view_order($order_id) {
        global $woocommerce;

        $order = wc_get_order( $order_id );
        $order_item_product = new WC_Order_Item_Product();
        ?>
        <div class="evolve-order-details woocommerce-content-box full-width">
            <h2><?php _e('Order Details', 'evolve'); ?></h2>
            <table class="shop_table order_details">
                <thead>
                    <tr>
                        <th class="product-name"><?php _e('Product', 'evolve'); ?></th>
                        <th class="product-quantity"><?php _e('Quantity', 'evolve'); ?></th>
                        <th class="product-total"><?php _e('Total', 'evolve'); ?></th>
                    </tr>
                </thead>
                <tfoot>
                    <?php
                    if ($totals = $order->get_order_item_totals())
                        foreach ($totals as $total) :
                            ?>
                            <tr>
                                <td class="filler-td">&nbsp;</td>
                                <th scope="row"><?php echo $total['label']; ?></th>
                                <td class="product-total"><?php echo $total['value']; ?></td>
                            </tr>
                            <?php
                        endforeach;
                    ?>
                </tfoot>
                <tbody>
                    <?php
                    if (sizeof($order->get_items()) > 0) {

                        foreach ($order->get_items() as $item) {
                            $_product = apply_filters('woocommerce_order_item_product', $order->get_product_from_item($item), $item);
                            $product =  apply_filters( 'woocommerce_order_item_product', $item->get_product(), $item );
                            ?>
                            <tr class="<?php echo esc_attr(apply_filters('woocommerce_order_item_class', 'order_item', $item, $order)); ?>">
                                <td class="product-name">
                                    <span class="product-thumbnail">
                                        <?php
                                        $cart_item = '';
                                        $cart_item_key = '';
                                        $thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key);

                                        if (!$_product->is_visible())
                                            echo $thumbnail;
                                        else
                                            printf('<a href="%s">%s</a>', $_product->get_permalink(), $thumbnail);
                                        ?>
                                    </span>
                                    <div class="product-info">
                                        <?php
                                        if ($_product && !$_product->is_visible())
                                            echo apply_filters('woocommerce_order_item_name', $item['name'], $item);
                                        else
                                            echo apply_filters('woocommerce_order_item_name', sprintf('<a href="%s">%s</a>', get_permalink($item['product_id']), $item['name']), $item);

                                        wc_display_item_meta($item);

                                        if ($_product && $_product->exists() && $_product->is_downloadable() && $order->is_download_permitted()) {

                                            $download_files = $order_item_product->get_item_downloads();
                                            $i = 0;
                                            $links = array();

                                            foreach ($download_files as $download_id => $file) {
                                                $i++;

                                                $links[] = '<small><a href="' . esc_url($file['download_url']) . '">' . sprintf(__('Download file%s', 'evolve'), ( count($download_files) > 1 ? ' ' . $i . ': ' : ': ')) . esc_html($file['name']) . '</a></small>';
                                            }

                                            echo '<br/>' . implode('<br/>', $links);
                                        }
                                        ?>
                                    </div>
                                </td>
                                <td class="product-quantity">
                                    <?php echo apply_filters('woocommerce_order_item_quantity_html', $item['qty'], $item); ?>
                                </td>
                                <td class="product-total">
                                    <?php echo $order->get_formatted_line_subtotal($item); ?>
                                </td>
                            </tr>
                            <?php
                            $show_purchase_note = $order->has_status( apply_filters( 'woocommerce_purchase_note_order_statuses', array( 'completed', 'processing' ) ) );
                            $purchase_note = $product ? $product->get_purchase_note() : '';
                            if ( $show_purchase_note && $purchase_note ) {
                                ?>
                                <tr class="product-purchase-note">
                                    <td colspan="3"><?php echo wpautop( do_shortcode( wp_kses_post( $purchase_note ) ) ); ?></td>
                                </tr>
                                <?php
                            }
                        }

                    }

                    do_action('woocommerce_order_items_table', $order);
                    ?>
                </tbody>
            </table>
            
            <?php  do_action('woocommerce_order_details_after_order_table', $order); ?>
        </div>

        <div class="evolve-customer-details woocommerce-content-box full-width">
            <header>
                <h2><?php _e('Customer details', 'evolve'); ?></h2>
            </header>
            <dl class="customer_details">
                <?php
                if ($order->get_customer_note())
                    echo '<dt>' . __('Note:', 'evolve') . '</dt> <dd>' . $order->get_customer_note() . '</dd>';
                if ($order->get_billing_email())
                    echo '<dt>' . __('Email:', 'evolve') . '</dt> <dd>' . $order->get_billing_email() . '</dd>';
                if ($order->get_billing_phone())
                    echo '<dt>' . __('Telephone:', 'evolve') . '</dt> <dd>' . $order->get_billing_phone() . '</dd>';

                // Additional customer details hook
                do_action('woocommerce_order_details_after_customer_details', $order);
                ?>
            </dl>

            <?php if (get_option('woocommerce_ship_to_billing_address_only') === 'no' && get_option('woocommerce_calc_shipping') !== 'no') : ?>

                <div class="col2-set addresses">

                    <div class="col-1">

                    <?php endif; ?>

                    <header class="title">
                        <h3><?php _e('Billing Address', 'evolve'); ?></h3>
                    </header>
                    <address><p>
                            <?php
                            if (!$order->get_formatted_billing_address())
                                _e('N/A', 'evolve');
                            else
                                echo $order->get_formatted_billing_address();
                            ?>
                        </p></address>

                    <?php if (get_option('woocommerce_ship_to_billing_address_only') === 'no' && get_option('woocommerce_calc_shipping') !== 'no') : ?>

                    </div><!-- /.col-1 -->

                    <div class="col-2">

                        <header class="title">
                            <h3><?php _e('Shipping Address', 'evolve'); ?></h3>
                        </header>
                        <address><p>
                                <?php
                                if (!$order->get_formatted_shipping_address())
                                    _e('N/A', 'evolve');
                                else
                                    echo $order->get_formatted_shipping_address();
                                ?>
                            </p></address>

                    </div><!-- /.col-2 -->

                </div><!-- /.col2-set -->

            <?php endif; ?>

            <div class="clear"></div>

        </div>

        <?php
    }

    /* end order hooks */

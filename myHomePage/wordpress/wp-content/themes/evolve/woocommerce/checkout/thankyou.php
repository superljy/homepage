<?php
/**
 * Thankyou page
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

if ($order) :

    if ( $order->has_status( 'failed' ) ) :
        ?>

        <p><?php _e('Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction.', 'evolve'); ?></p>

        <p><?php
            if (is_user_logged_in())
                _e('Please attempt your purchase again or go to your account page.', 'evolve');
            else
                _e('Please attempt your purchase again.', 'evolve');
            ?></p>

        <p>
            <a href="<?php echo esc_url($order->get_checkout_payment_url()); ?>" class="button pay"><?php _e('Pay', 'evolve') ?></a>
            <?php if (is_user_logged_in()) : ?>
                <a href="<?php echo esc_url(get_permalink(wc_get_page_id('myaccount'))); ?>" class="button pay"><?php _e('My Account', 'evolve'); ?></a>
            <?php endif; ?>
        </p>

    <?php else : ?>

        <p><?php echo apply_filters('woocommerce_thankyou_order_received_text', __('Thank you. Your order has been received.', 'evolve'), $order); ?></p>

        <ul class="order_details">
            <li class="order">
                <?php _e('Order:', 'evolve'); ?>
                <strong><?php echo $order->get_order_number(); ?></strong>
            </li>
            <li class="date">
                <?php _e('Date:', 'evolve'); ?>
                <strong><?php echo wc_format_datetime( $order->get_date_created() ); ?></strong>
            </li>
            <li class="total">
                <?php _e('Total:', 'evolve'); ?>
                <strong><?php echo $order->get_formatted_order_total(); ?></strong>
            </li>
            <?php if ( $order->get_payment_method_title() ) : ?>
                <li class="method">
                    <?php _e('Payment method:', 'evolve'); ?>
                    <strong><?php echo wp_kses_post( $order->get_payment_method_title() ); ?></strong>
                </li>
            <?php endif; ?>
        </ul>
        <div class="clear"></div>

    <?php
    endif;

    do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() );
    do_action( 'woocommerce_thankyou', $order->get_id() );

else :
    ?>

    <p><?php echo apply_filters('woocommerce_thankyou_order_received_text', __('Thank you. Your order has been received.', 'evolve'), null); ?></p>

<?php endif;
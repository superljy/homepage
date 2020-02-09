<?php
/**
 * Single Product Image
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
global $post, $woocommerce, $product;
?>
<div class="images">

    <div id="slider" class="flexslider">
        <ul class="slides">
            <?php
            if (has_post_thumbnail()) {

                $image_title = esc_attr(get_the_title(get_post_thumbnail_id()));
                $image_link = wp_get_attachment_url(get_post_thumbnail_id());
                $image = get_the_post_thumbnail($post->ID, apply_filters('single_product_large_thumbnail_size', 'shop_single'), array(
                    'title' => $image_title
                ));
                $attachment_count = count($product->get_gallery_image_ids());

                if ($attachment_count > 0) {
                    $gallery = '[product-gallery]';
                } else {
                    $gallery = '';
                }

                echo apply_filters('woocommerce_single_product_image_html', sprintf('<li><a href="%s" itemprop="image" class="woocommerce-main-image zoom" title="%s" data-rel="prettyPhoto' . $gallery . '" rel="prettyPhoto">%s</a></li>', $image_link, $image_title, $image), $post->ID);


                /**
                 * From product-thumbnails.php
                 */
                $attachment_ids = $product->get_gallery_image_ids();

                $loop = 0;
                //$columns = apply_filters( 'woocommerce_product_thumbnails_columns', 3 );

                foreach ($attachment_ids as $attachment_id) {

                    /*
                      $classes = array( 'zoom' );

                      if ( $loop == 0 || $loop % $columns == 0 )
                      $classes[] = 'first';

                      if ( ( $loop + 1 ) % $columns == 0 )
                      $classes[] = 'last';
                     */
                    $classes[] = 'image-' . $attachment_id;

                    $image_link = wp_get_attachment_url($attachment_id);

                    if (!$image_link)
                        continue;

                    // modified image size to shop_single from thumbnail
                    $image = wp_get_attachment_image($attachment_id, apply_filters('single_product_small_thumbnail_size', 'shop_single'));
                    $image_class = esc_attr(implode(' ', $classes));
                    $image_title = esc_attr(get_the_title($attachment_id));

                    echo apply_filters('woocommerce_single_product_image_html', sprintf('<li><a href="%s" itemprop="image" class="woocommerce-main-image zoom" title="%s" data-rel="prettyPhoto' . $gallery . '" rel="prettyPhoto">%s</a></li>', $image_link, $image_title, $image), $attachment_id, $post->ID, $image_class);
                    //echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', sprintf( '<a href="%s" class="%s" title="%s" data-rel="prettyPhoto[product-gallery]">%s</a>', $image_link, $image_class, $image_title, $image ), $attachment_id, $post->ID, $image_class );

                    $loop++;
                }
            } else {

                echo apply_filters('woocommerce_single_product_image_html', sprintf('<li><img src="%s" alt="Placeholder" /></li>', wc_placeholder_img_src()), $post->ID);
            }
            ?>
        </ul>
    </div>

    <?php do_action('woocommerce_product_thumbnails'); ?>

</div>

<?php
/**
 * Functions.php
 *
 * @package  Theme_Customisations
 * @author   WooThemes
 * @since    1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
//add css hook tùy biến  và  function chill
add_action( 'wp_enqueue_scripts', 'wp_enqueue_woocommerce_style' );

function wp_enqueue_woocommerce_style(){
	wp_register_style( 'mytheme-woocommerce', get_stylesheet_directory_uri() . '/css/style-single.css' );
	
	if ( class_exists( 'woocommerce' ) ) {
		wp_enqueue_style( 'mytheme-woocommerce' );
	}
}
/**
 * functions.php
 * Add PHP snippets here
 */
/*
 * Thay đổi nội dung nút Add to Cart
*/
add_filter('woocommerce_product_single_add_to_cart_text', 'woo_custom_cart_button_text');
  
function woo_custom_cart_button_text() {
return __('Thêm vào giỏ hàng', 'woocommerce');}

//Hiện thị sao đối với các sản phẩm chưa có đánh giá
add_filter( 'woocommerce_product_get_rating_html', 'show_rating', 100, 3 );
function show_rating( $rating_html, $rating, $count ) {
    $rating_html  = '<div class="star-rating">';
    $rating_html .= wc_get_star_rating_html( $rating, $count );
    $rating_html .= '</div>';

    return $rating_html;
};  

// Đổi tên tab product single
add_filter( 'woocommerce_product_tabs', 'wpb_rename_tabs', 98 );
function wpb_rename_tabs( $tabs ) {
    $tabs['description']['title']               = __( 'Thông tin sản phẩm', 'text-domain' );       
    $tabs['reviews']['title']                   = __( 'Đánh giá', 'text-domain' );               
    return $tabs;
}


/*Hiện thị tiết kiệm tiêu dùng*/
function saving_money_html($product, $is_variation = false){
    ob_start();
    if($product->is_on_sale() && ($product->is_type( 'simple' ) || $product->is_type( 'external' ) || $is_variation) ) {
        $sale_price = $product->get_sale_price();
        $regular_price = $product->get_regular_price();
        if($regular_price) {
            $sale = round(((floatval($regular_price) - floatval($sale_price)) / floatval($regular_price)) * 100);
            $sale_amout = $regular_price - $sale_price;
            ?>
<style>
.saving_money_single {
    background-color: #d9e4f5;
    background-image: linear-gradient(315deg, #d9e4f5 0%, #f5e3e6 74%);
    border: 1px dashed #199bc4;
    padding: 10px;
    border-radius: 3px;
    -moz-border-radius: 3px;
    -webkit-border-radius: 3px;
    margin: 0 0 10px;
    color: #000;
}

.saving_money_single span.label {
    color: #333;
    font-weight: 400;
    font-size: 14px;
    padding: 0;
    margin: 0;
    float: left;
    width: 82px;
    text-align: left;
    line-height: 18px;
}

.saving_money_single span.saving_money .amount {
    font-size: 14px;
    font-weight: 700;
    color: #ff3a3a;
}

.saving_money_single span.saving_money del .amount,
.saving_money_single span.saving_money del {
    font-size: 14px;
    color: #333;
    font-weight: 400;
}
</style>
<div class="saving_money_single">
    <div>
        <span class="label">Giá:</span>
        <span class="saving_money"><?php echo wc_price($sale_price); ?></span>
    </div>
    <div>
        <span class="label">Thị trường:</span>
        <span class="saving_money"><del><?php echo wc_price($regular_price); ?></del></span>
    </div>
    <div>
        <span class="label">Tiết kiệm:</span>
        <span class="saving_money sale_amount"> <?php echo wc_price($sale_amout); ?> (<?php echo $sale; ?>%)</span>
    </div>
</div>
<?php
        }
    }else{
        ?>
<p class="<?php echo esc_attr( apply_filters( 'woocommerce_product_price_class', 'price' ) );?>">
    <?php echo $product->get_price_html(); ?></p>
<?php
    }
    return ob_get_clean();
}
function woocommerce_template_single_price(){
    global $product;
    echo saving_money_html($product);
}
  
add_filter('woocommerce_available_variation','save_money_woocommerce_available_variation', 10, 3);
function save_money_woocommerce_available_variation($args, $thisC, $variation){
    $old_price_html = $args['price_html'];
    if($old_price_html){
        $args['price_html'] = saving_money_html($variation, true);
    }
    return $args;
}

?>
<?php
/*
 * Tạo nut mua ngay bên cạnh giỏ hàng
 */
add_action('woocommerce_after_add_to_cart_button','auto_right_after_addtocart_button');
function auto_right_after_addtocart_button(){
    global $product;
    ?>
<button type="submit" name="add-to-cart" value="<?php echo esc_attr($product->get_id()); ?>"
    class="single_add_to_cart_button button alt" id="buy_now_button">
    <?php _e('Mua ngay pro', 'devvn'); ?>
</button>
<input type="hidden" name="is_buy_now" id="is_buy_now" value="0" />
<script>
jQuery(document).ready(function() {
    jQuery('body').on('click', '#buy_now_button', function() {
        if (jQuery(this).hasClass('disabled')) return;
        var thisParent = jQuery(this).closest('form.cart');
        jQuery('#is_buy_now', thisParent).val('1');
        thisParent.submit();
    });
});
</script>
<?php
}
add_filter('woocommerce_add_to_cart_redirect', 'redirect_to_checkout');
function redirect_to_checkout($redirect_url) {
    if (isset($_REQUEST['is_buy_now']) && $_REQUEST['is_buy_now']) {
        $redirect_url = wc_get_checkout_url();
    }
    return $redirect_url;
}
?>

<?php
/**
 * Tạo nút xem thêm + thu gọn
 */
add_action('wp_footer','click_readmore_information');
function click_readmore_information(){
    ?>
<style>
.single-product div#tab-description {
    overflow: hidden;
    position: relative;
    padding-bottom: 25px;
}

.single-product .tab-panels div#tab-description.panel:not(.active) {
    height: 0 !important;
}

.click_readmore_information {
    text-align: center;
    cursor: pointer;
    position: absolute;
    z-index: 10;
    bottom: 0;
    width: 100%;
    background: #fff;
}

.click_readmore_information:before {
    height: 55px;
    margin-top: -45px;
    content: -webkit-gradient(linear, 0% 100%, 0% 0%, from(#fff), color-stop(.2, #fff), to(rgba(255, 255, 255, 0)));
    display: block;
}

.click_readmore_information a {
    color: #318A00;
    display: block;
}

.click_readmore_information a:after {
    content: '';
    width: 0;
    right: 0;
    border-top: 6px solid #318A00;
    border-left: 6px solid transparent;
    border-right: 6px solid transparent;
    display: inline-block;
    vertical-align: middle;
    margin: -2px 0 0 5px;
}

.click_readmore_information_less a:after {
    border-top: 0;
    border-left: 6px solid transparent;
    border-right: 6px solid transparent;
    border-bottom: 6px solid #318A00;
}

.click_readmore_information_less:before {
    display: none;
}
</style>
<script>
(function($) {
    $(document).ready(function() {
        $(window).load(function() {
            if ($('.single-product div#tab-description').length > 0) {
                var wrap = $('.single-product div#tab-description');
                var current_height = wrap.height();
                var your_height = 300;
                if (current_height > your_height) {
                    wrap.css('height', your_height + 'px');
                    wrap.append(function() {
                        return '<div class="click_readmore_information click_readmore_information_more"><a title="Xem thêm" href="javascript:void(0);">Đọc thêm</a></div>';
                    });
                    wrap.append(function() {
                        return '<div class="click_readmore_information click_readmore_information_less" style="display: none;"><a title="Xem thêm" href="javascript:void(0);">Thu gọn</a></div>';
                    });
                    $('body').on('click', '.click_readmore_information_more', function() {
                        wrap.removeAttr('style');
                        $('body .click_readmore_information_more').hide();
                        $('body .click_readmore_information_less').show();
                    });
                    $('body').on('click', '.click_readmore_information_less', function() {
                        wrap.css('height', your_height + 'px');
                        $('body .click_readmore_information_less').hide();
                        $('body .click_readmore_information_more').show();
                    });
                }
            }
        });
    })
})(jQuery)
</script>
<?php
}
?>

<?php
// // xóa hình ảnh trùng lặp ngay trong giao diện hiện thị hình ảnh sản phẩm nổi bật
// add_filter( 'woocommerce_single_product_image_thumbnail_html', 'display_woocommerce_remove_featured_image', 10, 2 );

// 	function display_woocommerce_remove_featured_image( $html, $attachment_id ) {
// 		global $post, $product;

// 		// Get the IDs.

// 		$attachment_ids = $product->get_gallery_image_ids();

// 		// If there are none, go ahead and return early - with the featured image included in the gallery.

// 		if ( ! $attachment_ids ) {

// 					return $html;

// 		}

// 		// Look for the featured image.

// 		$featured_image = get_post_thumbnail_id( $post->ID );

// 		// If there is one, exclude it from the gallery.

// 		if ( is_product() && $attachment_id === $featured_image ) {

// 					$html = '';

// 		}

// 		return $html;

// }
?>
<style>
    .hktt{
        width: 300px;
    height: 300px;
    margin-top: 12%;
    margin-left: 34%;
}
.ktimthay{
    margin-top: 12%;
    margin-left: 20%;
    font-size: 30px;
    font-weight: 700;
}
</style>
<?php
/**
 * Displayed when no products are found matching the current query
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/no-products-found.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 2.0.0
 */

defined( 'ABSPATH' ) || exit;

?>
<p><img class="hktt" src="http://wordpress.local/wp-content/uploads/2021/12/264358245_220581750115314_4500392256993698191_n.png" alt=""></p> 
<p class="ktimthay"><?php esc_html_e('Không thể tìm thấy sản phẩm bạn mong muốn'); ?></p>



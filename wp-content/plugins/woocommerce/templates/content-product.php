<?php

/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined('ABSPATH') || exit;

global $product;

// Ensure visibility.
if (empty($product) || !$product->is_visible()) {
	return;
}
$productImage = $product->get_image();
$productName = mb_strtoupper($product->name);
$isSale = $product->regular_price != $product->price;
?>
<div class="col-md-4 module-6">
	<div class="col-md-12 module-6-item">
		<!-- Product Image -->
		<div class="product-image">
			<?= $productImage ?>
		</div>
		<!-- Product Name -->
		<div class="product-name">
			<h2><?= $productName ?></h2>
		</div>
		<!-- Product Sale (Show only for product sale) -->
		<div class="product-sale">
			<?php if ($isSale) { ?>
				<h5>Sale</h5>
			<?php } ?>
		</div>
		<!-- Product Price -->
		<div class="product-price">
			<h5>
				<?php if ($isSale) { ?>
					<span class="regular_price"><?= number_format($product->regular_price) ?> <u>đ</u></span> ->
				<?php } ?>
				<span class="actual_price"><?= number_format($product->price) ?></span>
				<u>đ</u>
			</h5>
		</div>
		<!-- Add to cart btn -->
		<div class="module-6-product-add-to-cart-btn">
			<a href="?add-to-cart=<?= $product->id ?>" data-quantity="1" 
			class="button product_type_simple add_to_cart_button ajax_add_to_cart" 
			data-product_id="<?= $product->id ?>" data-product_sku="" 
			aria-label="Add “<?= $product->name ?>” to your cart" rel="nofollow">ĐẶT MUA</a>
		</div>
	</div>
</div>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package storefront
 */

get_header(); ?>
<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
		<div class="row">
  <div class="col-sm-8">
  <div class="storefront-sorting"><div class="woocommerce-notices-wrapper"></div><form class="woocommerce-ordering" method="get">
	<select name="orderby" class="orderby" aria-label="Shop order">
					<option value="menu_order" selected="selected">Default sorting</option>
					<option value="popularity">Sort by popularity</option>
					<option value="rating">Sort by average rating</option>
					<option value="date">Sort by latest</option>
					<option value="price">Sort by price: low to high</option>
					<option value="price-desc">Sort by price: high to low</option>
			</select>
	<input type="hidden" name="paged" value="1">
	</form>
<p class="woocommerce-result-count">
	Showing 1–4 of 8 results</p>
<nav class="woocommerce-pagination">
	<ul class="page-numbers">
	<li><span aria-current="page" class="page-numbers current">1</span></li>
	<li><a class="page-numbers" href="http://wordpress.local/shop/page/2/">2</a></li>
	<li><a class="next page-numbers" href="http://wordpress.local/shop/page/2/">→</a></li>
</ul>
</nav>
</div>
		<ul class="products columns-2">
<li class="product type-product post-94 status-publish first instock product_cat-do-an-vat has-post-thumbnail sale shipping-taxable purchasable product-type-simple">
	<a href="http://wordpress.local/product/ga-ran/" class="woocommerce-LoopProduct-link woocommerce-loop-product__link"><img width="241" height="174" src="http://wordpress.local/wp-content/uploads/2021/12/garan-241x174.jpg" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="" loading="lazy"><h2 class="woocommerce-loop-product__title">Gà Rán</h2>
	<span class="onsale">Sale!</span>
	
	<span class="price"><del aria-hidden="true"><span class="woocommerce-Price-amount amount"><bdi>35.000&nbsp;<span class="woocommerce-Price-currencySymbol">₫</span></bdi></span></del> <ins><span class="woocommerce-Price-amount amount"><bdi>33.999&nbsp;<span class="woocommerce-Price-currencySymbol">₫</span></bdi></span></ins></span>
</a><a href="?add-to-cart=94" data-quantity="1" class="button product_type_simple add_to_cart_button ajax_add_to_cart" data-product_id="94" data-product_sku="" aria-label="Add “Gà Rán” to your cart" rel="nofollow">Add to cart</a></li>
<li class="product type-product post-92 status-publish last instock product_cat-do-an-vat has-post-thumbnail sale shipping-taxable purchasable product-type-simple">
	<a href="http://wordpress.local/product/hamberger/" class="woocommerce-LoopProduct-link woocommerce-loop-product__link"><img width="241" height="170" src="http://wordpress.local/wp-content/uploads/2021/12/hambergerr-241x170.jpg" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="" loading="lazy"><h2 class="woocommerce-loop-product__title">Hamberger</h2>
	<span class="onsale">Sale!</span>
	
	<span class="price"><del aria-hidden="true"><span class="woocommerce-Price-amount amount"><bdi>30.000&nbsp;<span class="woocommerce-Price-currencySymbol">₫</span></bdi></span></del> <ins><span class="woocommerce-Price-amount amount"><bdi>27.000&nbsp;<span class="woocommerce-Price-currencySymbol">₫</span></bdi></span></ins></span>
</a><a href="?add-to-cart=92" data-quantity="1" class="button product_type_simple add_to_cart_button ajax_add_to_cart" data-product_id="92" data-product_sku="" aria-label="Add “Hamberger” to your cart" rel="nofollow">Add to cart</a></li>
<li class="product type-product post-90 status-publish first instock product_cat-thuc-uong has-post-thumbnail sale shipping-taxable purchasable product-type-simple">
	<a href="http://wordpress.local/product/mirinda-huong-cam/" class="woocommerce-LoopProduct-link woocommerce-loop-product__link"><img width="241" height="241" src="http://wordpress.local/wp-content/uploads/2021/12/mirida-241x241.png" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="" loading="lazy" srcset="http://wordpress.local/wp-content/uploads/2021/12/mirida-241x241.png 241w, http://wordpress.local/wp-content/uploads/2021/12/mirida-150x150.png 150w, http://wordpress.local/wp-content/uploads/2021/12/mirida-100x100.png 100w" sizes="(max-width: 241px) 100vw, 241px"><h2 class="woocommerce-loop-product__title">Mirinda Hương Cam</h2>
	<span class="onsale">Sale!</span>
	
	<span class="price"><del aria-hidden="true"><span class="woocommerce-Price-amount amount"><bdi>10.000&nbsp;<span class="woocommerce-Price-currencySymbol">₫</span></bdi></span></del> <ins><span class="woocommerce-Price-amount amount"><bdi>9.999&nbsp;<span class="woocommerce-Price-currencySymbol">₫</span></bdi></span></ins></span>
</a><a href="?add-to-cart=90" data-quantity="1" class="button product_type_simple add_to_cart_button ajax_add_to_cart" data-product_id="90" data-product_sku="" aria-label="Add “Mirinda Hương Cam” to your cart" rel="nofollow">Add to cart</a></li>
<li class="product type-product post-88 status-publish last instock product_cat-thuc-uong has-post-thumbnail sale shipping-taxable purchasable product-type-simple">
	<a href="http://wordpress.local/product/number-one/" class="woocommerce-LoopProduct-link woocommerce-loop-product__link"><img width="241" height="241" src="http://wordpress.local/wp-content/uploads/2021/12/nambq-241x241.jpg" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="" loading="lazy" srcset="http://wordpress.local/wp-content/uploads/2021/12/nambq-241x241.jpg 241w, http://wordpress.local/wp-content/uploads/2021/12/nambq-150x150.jpg 150w, http://wordpress.local/wp-content/uploads/2021/12/nambq-100x100.jpg 100w" sizes="(max-width: 241px) 100vw, 241px"><h2 class="woocommerce-loop-product__title">Number One</h2>
	<span class="onsale">Sale!</span>
	
	<span class="price"><del aria-hidden="true"><span class="woocommerce-Price-amount amount"><bdi>10.000&nbsp;<span class="woocommerce-Price-currencySymbol">₫</span></bdi></span></del> <ins><span class="woocommerce-Price-amount amount"><bdi>9.999&nbsp;<span class="woocommerce-Price-currencySymbol">₫</span></bdi></span></ins></span>
</a><a href="?add-to-cart=88" data-quantity="1" class="button product_type_simple add_to_cart_button ajax_add_to_cart" data-product_id="88" data-product_sku="" aria-label="Add “Number One” to your cart" rel="nofollow">Add to cart</a></li>
</ul>
  </div>
  <div class="col-sm-4">
  <h2 class="h3index">Bài viết</h2>
				<?php
		if ( have_posts() ) :

			get_template_part('loop' );

		else :

			get_template_part( 'content', 'none' );

		endif;
		?>
  </div>
</div>
	

				


		

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
do_action( 'storefront_sidebar' );
get_footer();

<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package storefront
 */
$args = array(
    'type'                     => 'post',
    'child_of'                 => 0,
    'parent'                   => '',
    'orderby'                  => 'name',
    'order'                    => 'ASC',
    'hide_empty'               => 1,
    'hierarchical'             => 1,
    'exclude'                  => '',
    'include'                  => '',
    'number'                   => '',
    'taxonomy'                 => 'category',
    'pad_counts'               => false );
 
$product_categories = get_categories( $args );
 


?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
	<meta
		charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback"
		href="<?php bloginfo('pingback_url'); ?>">
	<link rel="stylesheet"
		href="<?php echo get_template_directory_uri() ?>/style-module-9.css"
		type="text/css" media="screen" />
	<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<?php wp_body_open(); ?>

	<?php do_action('storefront_before_site'); ?>

	<div id="page" class="hfeed site">
		<?php do_action('storefront_before_header'); ?>

		<header id="masthead" class="site-header-custom" role="banner">

			<?php
        /**
         * Functions hooked into storefront_header action
         *
         * @hooked storefront_header_container                 - 0
         * @hooked storefront_skip_links                       - 5
         * @hooked storefront_social_icons                     - 10
         * @hooked storefront_site_branding                    - 20
         * @hooked storefront_secondary_navigation             - 30
         * @hooked storefront_product_search                   - 40
         * @hooked storefront_header_container_close           - 41
         * @hooked storefront_primary_navigation_wrapper       - 42
         * @hooked storefront_primary_navigation               - 50
         * @hooked storefront_header_cart                      - 60
         * @hooked storefront_primary_navigation_wrapper_close - 68
         */
        // do_action( 'storefront_header' );
        ?>
		
			<section id="pre-header" class="pre-header">
				<div class="container">
					<div class="row">
						<div class="col-12 pre-header-content">
							<div class="email-owner">
								<span class="email-owner-title">
									<a href="#"><?php echo wp_get_current_user()->user_login; ?></a>
								</span>
							</div>
							<div class="slogan">
								<span class="slogan-title">
									Free ship cho tất cả đơn hàng trên 5 triệu đồng
								</span>
							</div>
							<div class="information-site">
								<div class="information-site-menu">
									<nav class="menu-site">
										<ul class="menu-list">
											<li class="menu-item"><a href="#">About</a></li>
											<li class="menu-item"><a href="#">FAQ</a></li>
											<li class="menu-item"><a href="#">My account</a></li>
											<li class="menu-item"><a href="#">Blog</a></li>
										</ul>
									</nav>
								</div>
							</div>
						</div>
					</div>
			</section>
			<section id="back-header" class="back-header">
				<div class="container">
					<div class="row">
						<div class="col-md-2">
							<div class="wishlist">
								<a href="#">
									<span class="wishlist-icon">
										<ion-icon name="heart-outline"></ion-icon>
									</span>
									<span class="wishlist-title">Wishlist</span>
								</a>
							</div>
						</div>
						<div class="col-md-8">
							<div class="nav-logo">
								<nav class="menu-site">
									<ul class="menu-list">
										<li class="menu-item active"><a href="<?php echo get_home_url(); ?>">Home</a></li>
										<li class="menu-item  cate"> <a href="#">Categories</a>
										<ul class="cate-list dropdown-menu">
										<?php 
										if( !empty($product_categories) ){
											foreach ($product_categories as $key => $category) {
												echo '<li>';
												echo '<a href="'.get_term_link($category).'" >';
												echo $category->name;
												echo '</a>';
												echo '</li>';
											}
										}
										?>
										</ul>
									</li>
									</ul>
								</nav>
								<div class="logo">
									<a
										href="<?php echo get_home_url(); ?>"><span
											class="logo-title"><?php echo get_bloginfo('name'); ?></span></a>
								</div>
								<nav class="menu-site">
									<ul class="menu-list">
										<li class="menu-item"> <a href="<?= get_permalink( wc_get_page_id( 'shop' ) );?>">Shop</a></li>
										<li class="menu-item"> <a href="#">Contact</a></li>
									</ul>
								</nav>
							</div>
						</div>
						<div class="col-md-2">
							<div class="right-navigation">
								<div class="search-section">
									<a href="#">
									<span class="search-icon">
										<ion-icon name="search-outline"></ion-icon>
									</span>
									</a>
								</div>
								<div class="cart-section">
									<a href="<?= get_permalink( wc_get_page_id( 'cart' ) );?>">
										<span class="cart-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24"
												height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
												stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
												class="feather feather-shopping-bag">
												<path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
												<line x1="3" y1="6" x2="21" y2="6"></line>
												<path d="M16 10a4 4 0 0 1-8 0"></path>
											</svg>
										</span>
										<span class="cart-number">0</span>
									</a>
									<!-- <div class="cart-list">
										<p>No Product in cart</p>
									</div> -->
								</div>
							</div>

						</div>
					</div>
				</div>
			</section>
	</div>

	</header><!-- #masthead -->

	<?php
    /**
     * Functions hooked in to storefront_before_content
     *
     * @hooked storefront_header_widget_region - 10
     * @hooked woocommerce_breadcrumb - 10
     */
    do_action('storefront_before_content');
    ?>

	<div id="content" class="site-content" tabindex="-1">
		<div class="col-full">

			<?php
        do_action('storefront_content_top');

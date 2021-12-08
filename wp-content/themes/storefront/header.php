<?php

/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package storefront
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
	<link rel="stylesheet" href="<?php echo get_template_directory_uri() ?>/owl.carousel.min.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="<?php echo get_template_directory_uri() ?>/modulelam.css" type="text/css" media="screen" />
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<?php wp_body_open(); ?>

	<?php do_action('storefront_before_site'); ?>

	<?php
		$home = '';
		if (is_front_page()) {
			$home = 'trang-chu';
		}
		?>
	<div id="page" <?php post_class($home); ?> class="hfeed site">
		<?php do_action('storefront_before_header'); ?>

		<header id="masthead" class="site-header" role="banner" style="<?php storefront_header_styles(); ?>">

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
			do_action('storefront_header');
			?>

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

		<!-- Banner start -->
		<div id="banner">
			<img src="https://i2.wp.com/d9n64ieh9hz8y.cloudfront.net/wp-content/uploads/20191106225001/asus-zenbook-seminar-trai-nghiem-laptop-hai-man-hinh-3-1140x760.jpg?resize=1140%2C760&ssl=1" alt="img-fluid">
			<div class="container">
				<div class="title-banner">Welcome to shop by group C</div>
				<div class="des-banner">Read more</div>
			</div>
		</div>
		<!-- Banner end -->
		<div id="content" <?php post_class($home); ?> class="site-content" tabindex="-1">

			<div class="col-full">
				

				<!-- Terminal start -->
				<!-- Feature Start -->
				<section class="ftco-section testimony-section bg-light">
					<div class="container">
						<div class="row justify-content-center mb-5">
							<div class="col-md-7 text-center heading-section ftco-animate">
								<h2 class="mb-3">Testimonial</h2>
							</div>
						</div>
						<div class="row ftco-animate">
							<div class="col-md-12">
								<div class="carousel-testimony owl-carousel ftco-owl">
									<div class="item">
										<div class="text-center">
											<div class="text pt-4">
												<img src="https://toplap.vn/storage/img/FYWJoqkuYl5rUdhcJGmEnSFgme6vMWPpzKMOy02E.jpeg" class="img-fluid" style="border-radius: 10px;" alt="">
											</div>
										</div>
									</div>
									<div class="item">
										<div class="rounded text-center">
											<div class="text pt-4">
												<img src="https://toplap.vn/storage/img/FYWJoqkuYl5rUdhcJGmEnSFgme6vMWPpzKMOy02E.jpeg" class="img-fluid" style="border-radius: 10px;" alt="">
											</div>
										</div>
									</div>
									<div class="item">
										<div class="rounded text-center">
											<div class="text pt-4">
												<img src="https://toplap.vn/storage/img/FYWJoqkuYl5rUdhcJGmEnSFgme6vMWPpzKMOy02E.jpeg" class="img-fluid" style="border-radius: 10px;" alt="">
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>
				
				<!-- Feature End -->
				<!-- Terminal start -->
				<?php
				do_action('storefront_content_top');

<?php

/**
 * Header file for the Twenty Twenty WordPress default theme.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */

?>
<!DOCTYPE html>

<html class="no-js" <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="<?php echo get_template_directory_uri() ?>/module1.css">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>

	<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>

	<?php
	wp_body_open();
	?>
	<!-- Người thực hiện Nguyễn Đình Khánh Vi -->
	<!--Tạo container fluid và chia lại cột-->
	<header id="site-header" class="header-footer-group" role="banner">
		<div class="container-fuild">
			<div class="header-inner section-inner">

				<div class="header-titles-wrapper">
					<!-- group name, home, form search -->
					<div class="row">
						<!-- group name, home-->
						<div class="col-md-5 co4">
							<div class="header-titles">
								<div class="row chinhlogo">
									<div class="col-md-8 logo">
										<?php
										// Site title or logo.
										twentytwenty_site_logo(); ?>
									</div>
									<div class="col-md-4 nenxam">
										<?php // Site description.
										twentytwenty_site_description(); ?>
									</div>
								</div>
							</div><!-- .header-titles -->

						</div>
						<div class="col-md-7 co7">
							<!-- form search -->
							<div class="tim">
								<form role="search" class="navbar-form navbar-left" <?php echo $twentytwenty_aria_label; ?> method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
									<div class="form-group">
										<input type="search" id="<?php echo esc_attr($twentytwenty_unique_id); ?>" class="search-field" placeholder="<?php echo esc_attr_x('Search &hellip;', 'placeholder', 'twentytwenty'); ?>" value="<?php echo get_search_query(); ?>" name="s" />
									</div>
									<button type="submit" class="search-sub" value="<?php echo esc_attr_x('Search', 'submit button', 'twentytwenty'); ?>">Submit</button>
								</form>
							</div>
							</li>
						</div>
					</div>
				</div>

				<!-- Horizontal -->
				<div class="header-navigation-wrapper">

					<?php
					if (has_nav_menu('primary') || !has_nav_menu('expanded')) {
					?>

						<nav class="primary-menu-wrapper" aria-label="<?php echo esc_attr_x('Horizontal', 'menu', 'twentytwenty'); ?>" role="navigation">

							<ul class="primary-menu reset-list-style">

								<?php
								if (has_nav_menu('primary')) {

									wp_nav_menu(
										array(
											'container'  => '',
											'items_wrap' => '%3$s',
											'theme_location' => 'primary',
										)
									);
								} elseif (!has_nav_menu('expanded')) {

									wp_list_pages(
										array(
											'match_menu_classes' => true,
											'show_sub_menu_icons' => true,
											'title_li' => false,
											'walker'   => new TwentyTwenty_Walker_Page(),
										)
									);
								}
								?>

							</ul>

						</nav><!-- .primary-menu-wrapper -->

					<?php
					}

					?>
					<div class="menu1">
						<?php
						if (true === $enable_header_search || has_nav_menu('expanded')) {
						?>

							<!-- menu-modal -->
							<div class="header-toggles hide-no-js">

								<?php
								if (has_nav_menu('expanded')) {
								?>

									<div class="toggle-wrapper nav-toggle-wrapper has-expanded-menu">

										<button class="toggle nav-toggle desktop-nav-toggle" data-toggle-target=".menu-modal" data-toggle-body-class="showing-menu-modal" aria-expanded="false" data-set-focus=".close-nav-toggle">
											<span class="toggle-inner">
												<span class="toggle-text"><?php _e('Menu', 'twentytwenty'); ?></span>
												<span class="toggle-icon">
													<?php twentytwenty_the_theme_svg('ellipsis'); ?>
												</span>
											</span>
										</button><!-- .nav-toggle -->

									</div><!-- .nav-toggle-wrapper -->

								<?php
								}

								if (true === $enable_header_search) {
								?>

									<div class="toggle-wrapper search-toggle-wrapper">

										<button class="toggle search-toggle desktop-search-toggle" data-toggle-target=".search-modal" data-toggle-body-class="showing-search-modal" data-set-focus=".search-modal .search-field" aria-expanded="false">
											<span class="toggle-inner">
												<?php twentytwenty_the_theme_svg('search'); ?>
												<span class="toggle-text"><?php _ex('Search', 'toggle text', 'twentytwenty'); ?></span>
											</span>
										</button><!-- .search-toggle -->

									</div>

								<?php
								}
								?>

							</div><!-- .header-toggles -->
						<?php
						}
						?>
					</div>
				</div><!-- .header-navigation-wrapper -->
				<!--Tạo icon search-->
				<div class="row">
					<div class="col-md-3">
						<div class="kinhlup">
							<a href=""><i class="fa fa-search" aria-hidden="true"></i>
								<p>search</p>
							</a>

						</div>
					</div>
					<!-- Tạo khung account -->
					<div class="col-md-9">
						<div class="account">
							<div class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
									<i class="fa fa-user-circle-o"></i>
									Account
								</a>
							
								<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">					
									<?php 
									if ( is_home()) { ?>
										<a class="dropdown-item" href="http://wordpress.local/logout">Logout</a>
									<?php } else { ?>
										<a class="dropdown-item" href="http://wordpress.local">Login</a>
									<?php } ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- .header-titles-wrapper -->


			<!-- search -->



		</div><!-- .header-inner -->

		<?php
		// Output the search modal (if it is activated in the customizer).
		if (true === $enable_header_search) {
			get_template_part('template-parts/modal-search');
		}
		?>


	</header><!-- #site-header -->

	<?php
	// Output the menu modal.
	get_template_part('template-parts/modal-menu');

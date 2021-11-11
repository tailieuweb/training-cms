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
//chung 

?>
<!DOCTYPE html>

<html class="no-js" <?php language_attributes(); ?>>

<head>

	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="profile" href="https://gmpg.org/xfn/11">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">


	<?php wp_head(); ?>

	<!-- test !-->
</head>



<body <?php body_class(); ?>>
	<?php
	wp_body_open();
	?>
	<nav class="navbar navbar-expand-sm navbar-dark" style="background-color: #dce2e4b0;"><!-- thay đổi background !-->
		<div class="logo-header"><!-- hiện header (hết thẻ div) !-->
			<?php
			// Site title or logo.
			twentytwenty_site_logo();
			?>
		</div>
		<div class="collapse navbar-collapse" id="collapsibleNavId"> <!-- navbar kế bên logo-header !-->
			<ul class="navbar-nav mr-auto mt-2 mt-lg-0 ml-0">   
				<li class="nav-item active pr-5"> 
					<a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
				</li>
				<form method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="form-inline my-2 my-lg-0"> <!-- form search !-->
					<input value="<?php echo get_search_query(); ?>" name="s"  class="form-control mr-sm-2" type="text" placeholder="Search">
					<button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
				</form>
			</ul>
		</div>
		<div class="header-navigation-wrapper">

			<?php
			if (has_nav_menu('primary') || !has_nav_menu('expanded')) {
			?>

				<nav class="primary-menu-wrapper" aria-label="<?php echo esc_attr_x('Horizontal', 'menu', 'twentytwenty'); ?>" role="navigation">

					<ul class="primary-menu reset-list-style header-categories">

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

			if (true === $enable_header_search || has_nav_menu('expanded')) {
			?>

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
					<div class="dropdown">
						<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<a href="#">
								<i class="fa fa-user-circle"></i>
								<p>Account</p>
							</a>

						</button>

						<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
							<a class="dropdown-item" href="<?= wp_login_url() ?>">Login</a>
							<a class="dropdown-item" href="<?= wp_logout_url() ?>">Logout</a>

						</div>
					</div>

				</div><!-- .header-toggles -->
			<?php
			}
			?>

		</div><!-- .header-navigation-wrapper -->
	</nav>



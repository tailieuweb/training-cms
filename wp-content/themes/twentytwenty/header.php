<style>
	@import url("//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css");

	.search-sub {
		/* padding: 0 !important; */
		font-size: 70% !important;
		background-color: white !important;
		color: black !important;
		width: 35% !important;
		height: 15%;
		border-radius: 7px !important;
		border-color: black !important;
		border-style: solid !important;
		border-width: 1px !important;
		/* margin-left: 7% !important ; */

	}

	.navbar-left {
		display: flex;
	}

	.search-field {
		font-size: 50%;
		width: 95% !important;
		height: 70% !important;
		border-radius: 7px !important;
		/* margin-right: 10% !important; */

	}

	.li {
		list-style-type: none !important;
	}


	.fa {
		width: auto;
		padding-left: 30% !important;
		padding-bottom: 10% !important;
	} 
	 a{
		text-decoration: none !important;
	}


</style>
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

	<link rel="profile" href="https://gmpg.org/xfn/11">

	<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>

	<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>

	<?php
	wp_body_open();
	?>

	<header id="site-header" class="header-footer-group" role="banner">

		<div class="header-inner section-inner">

			<div class="header-titles-wrapper">
				<div class="row">
					<div class="col-md-4">
						<?php

						// Check whether the header search is activated in the customizer.
						$enable_header_search = get_theme_mod('enable_header_search', true);

						if (true === $enable_header_search) {

						?>

							<button class="toggle search-toggle mobile-search-toggle" data-toggle-target=".search-modal" data-toggle-body-class="showing-search-modal" data-set-focus=".search-modal .search-field" aria-expanded="false">
								<span class="toggle-inner">
									<span class="toggle-icon">
										<?php twentytwenty_the_theme_svg('search'); ?>
									</span>
									<span class="toggle-text"><?php _ex('Search', 'toggle text', 'twentytwenty'); ?></span>
								</span>
							</button><!-- .search-toggle -->

						<?php } ?>

						<div class="header-titles">

							<?php
							// Site title or logo.
							twentytwenty_site_logo();

							// Site description.
							twentytwenty_site_description();
							?>

						</div><!-- .header-titles -->

						<button class="toggle nav-toggle mobile-nav-toggle" data-toggle-target=".menu-modal" data-toggle-body-class="showing-menu-modal" aria-expanded="false" data-set-focus=".close-nav-toggle">
							<span class="toggle-inner">
								<span class="toggle-icon">
									<?php twentytwenty_the_theme_svg('ellipsis'); ?>
								</span>
								<span class="toggle-text"><?php _e('Menu', 'twentytwenty'); ?></span>
							</span>
						</button><!-- .nav-toggle -->
					</div>
					<div class="col-md-8">

						<form role="search" class="navbar-form navbar-left" <?php echo $twentytwenty_aria_label; ?> method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
							<div class="form-group">
								<input type="search" id="<?php echo esc_attr($twentytwenty_unique_id); ?>" class="search-field" placeholder="<?php echo esc_attr_x('Search &hellip;', 'placeholder', 'twentytwenty'); ?>" value="<?php echo get_search_query(); ?>" name="s" />
							</div>
							<button type="submit" class="search-sub" value="<?php echo esc_attr_x('Search', 'submit button', 'twentytwenty'); ?>">Submit</button>
						</form>
						</li>
					</div>
				</div>



			</div><!-- .header-titles-wrapper -->

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

					</div><!-- .header-toggles -->
				<?php
				}
				?>

			</div><!-- .header-navigation-wrapper -->

			<div class="account">
				<div class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
						<i class="fa fa-user-circle-o"></i>
						Account
					</a>
					<ul class="dropdown-menu">
						<li><a href="<?php header("location:..tranning-cms\wp-includes\wp-login.php"); ?>">Login</a></li>
						<li><a href="#">Loguot</a></li>
					</ul>
				</div>
			</div>




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

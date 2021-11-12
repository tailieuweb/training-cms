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
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!-- header cua tam-->
    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>

    <?php
	wp_body_open();
	?>

    <header id="site-header" class="header-footer-group" role="banner">

        <div class="header-inner section-inner">

            <div class="header-titles-wrapper">

                <?php

				// Check whether the header search is activated in the customizer.
				$enable_header_search = get_theme_mod('enable_header_search', true);

				if (true === $enable_header_search) {

				?>

                <button class="toggle search-toggle mobile-search-toggle" data-toggle-target=".search-modal"
                    data-toggle-body-class="showing-search-modal" data-set-focus=".search-modal .search-field"
                    aria-expanded="false">
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
					
					
					?>
                    <div class="description-html">
                        <?php
							// Site description.
							twentytwenty_site_description();
						?>
                    </div>
                    <div class="search-are-html">
                        <input type="text" name="keyword" class="input-class" id="exampleInputPassword1"
                            placeholder="Search">
                        <button type="button" class="btn btn-outline-secondary">Submit</button>
                    </div>

                </div><!-- .header-titles -->

                <button class="toggle nav-toggle mobile-nav-toggle" data-toggle-target=".menu-modal"
                    data-toggle-body-class="showing-menu-modal" aria-expanded="false"
                    data-set-focus=".close-nav-toggle">
                    <span class="toggle-inner">
                        <span class="toggle-icon">
                            <?php twentytwenty_the_theme_svg('ellipsis'); ?>
                        </span>
                        <span class="toggle-text"><?php _e('Menu', 'twentytwenty'); ?></span>
                    </span>
                </button><!-- .nav-toggle -->

            </div><!-- .header-titles-wrapper -->

            <div class="header-navigation-wrapper">

                <?php
				if (has_nav_menu('primary') || !has_nav_menu('expanded')) {
				?>

                <nav class="primary-menu-wrapper"
                    aria-label="<?php echo esc_attr_x('Horizontal', 'menu', 'twentytwenty'); ?>" role="navigation">

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

                        <button class="toggle nav-toggle desktop-nav-toggle" data-toggle-target=".menu-modal"
                            data-toggle-body-class="showing-menu-modal" aria-expanded="false"
                            data-set-focus=".close-nav-toggle">
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

                        <button class="toggle search-toggle desktop-search-toggle" data-toggle-target=".search-modal"
                            data-toggle-body-class="showing-search-modal" data-set-focus=".search-modal .search-field"
                            aria-expanded="false">
                            <span class="toggle-inner">
                                <?php twentytwenty_the_theme_svg('search'); ?>
                                <span class="toggle-text"><?php _ex('Search', 'toggle text', 'twentytwenty'); ?></span>
                            </span>
                        </button><!-- .search-toggle -->

                    </div>

                    <?php
						}
						?>
                    <div class="toggle-wrapper search-toggle-wrapper">

                        <div class="dropdown">
                            <i class="fa fa-user-circle-o" aria-hidden="true"></i>
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Account
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <li><a class="dropdown-item"
                                        href="<?php esc_url( get_permalink()); ?>/wp-admin">Admin</a>
                                </li>
                                <li><a class="dropdown-item" href="#">Another action</a></li>
                                <li><a class="dropdown-item" href="#">Something else here</a></li>
                            </ul>
                        </div>

                    </div>
                </div><!-- .header-toggles -->


                <?php
				}
				?>

            </div><!-- .header-navigation-wrapper -->

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
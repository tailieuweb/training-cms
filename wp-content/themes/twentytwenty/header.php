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

    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="profile" href="https://gmpg.org/xfn/11">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
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
					$enable_header_search = get_theme_mod( 'enable_header_search', true );

					if ( true === $enable_header_search ) {

						?>

                <button class="toggle search-toggle mobile-search-toggle" data-toggle-target=".search-modal"
                    data-toggle-body-class="showing-search-modal" data-set-focus=".search-modal .search-field"
                    aria-expanded="false">
                    <span class="toggle-inner">
                        <span class="toggle-icon">
                            <?php twentytwenty_the_theme_svg( 'search' ); ?>
                        </span>
                        <span class="toggle-text"><?php _ex( 'Search', 'toggle text', 'twentytwenty' ); ?></span>
                    </span>
                </button><!-- .search-toggle -->

                <?php } ?>

                <div class="header-titles">

                    <?php
							// Site description.
							twentytwenty_site_description();
							
							// Site title or logo.
							twentytwenty_site_logo();

							
						?>




                </div><!-- .header-titles -->


                <button class="toggle nav-toggle mobile-nav-toggle" data-toggle-target=".menu-modal"
                    data-toggle-body-class="showing-menu-modal" aria-expanded="false"
                    data-set-focus=".close-nav-toggle">
                    <span class="toggle-inner">
                        <span class="toggle-icon">
                            <?php twentytwenty_the_theme_svg( 'ellipsis' ); ?>
                        </span>
                        <span class="toggle-text"><?php _e( 'Menu', 'twentytwenty' ); ?></span>
                    </span>
                </button><!-- .nav-toggle -->
                <div class="no-search-results-form section-inner thin">

                    <?php
					get_search_form(
					array(
					'aria_label' => __( 'search again', 'twentytwenty' ),
					)
					);
					?>

                </div><!-- .no-search-results -->


            </div><!-- .header-titles-wrapper -->

            <div class="header-navigation-wrapper">

                <?php
					if ( has_nav_menu( 'primary' ) || ! has_nav_menu( 'expanded' ) ) {
						?>

                <nav class="primary-menu-wrapper"
                    aria-label="<?php echo esc_attr_x( 'Horizontal', 'menu', 'twentytwenty' ); ?>" role="navigation">

                    <ul class="primary-menu reset-list-style">

                        <?php
								if ( has_nav_menu( 'primary' ) ) {

									wp_nav_menu(
										array(
											'container'  => '',
											'items_wrap' => '%3$s',
											'theme_location' => 'primary',
										)
									);

								} elseif ( ! has_nav_menu( 'expanded' ) ) {

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

					if ( true === $enable_header_search || has_nav_menu( 'expanded' ) ) {
						?>

                <div class="header-toggles hide-no-js">

                    <?php
						if ( has_nav_menu( 'expanded' ) ) {
							?>

                    <div class="toggle-wrapper nav-toggle-wrapper has-expanded-menu">

                        <button class="toggle nav-toggle desktop-nav-toggle" data-toggle-target=".menu-modal"
                            data-toggle-body-class="showing-menu-modal" aria-expanded="false"
                            data-set-focus=".close-nav-toggle">
                            <span class="toggle-inner">
                                <span class="toggle-text"><?php _e( 'Menu', 'twentytwenty' ); ?></span>
                                <span class="toggle-icon">
                                    <?php twentytwenty_the_theme_svg( 'ellipsis' ); ?>
                                </span>
                            </span>
                        </button><!-- .nav-toggle -->

                    </div><!-- .nav-toggle-wrapper -->

                    <?php
						}

						if ( true === $enable_header_search ) {
							?>

                    <div class="toggle-wrapper search-toggle-wrapper">

                        <button class="toggle search-toggle desktop-search-toggle" data-toggle-target=".search-modal"
                            data-toggle-body-class="showing-search-modal" data-set-focus=".search-modal .search-field"
                            aria-expanded="false">
                            <span class="toggle-inner">
                                <?php twentytwenty_the_theme_svg( 'search' ); ?>
                                <span
                                    class="toggle-text"><?php _ex( 'Search', 'toggle text', 'twentytwenty' ); ?></span>
                            </span>
                        </button><!-- .search-toggle -->

                    </div>


                    <?php
						}
						?>
                    <div class=" toggle-wrapper account-toggle-wrapper">
                        <i class="fa fa-user-circle-o" aria-hidden="true"></i>
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Account
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="#">Login</a>
                                <a class="dropdown-item" href="./wp-login.php?action=logout&_wpnonce=d9bcd7100e">Logout</a>
                            </div>
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
			if ( true === $enable_header_search ) {
				get_template_part( 'template-parts/modal-search' );
			}
			?>

    </header><!-- #site-header -->

    <?php
		// Output the menu modal.
		get_template_part( 'template-parts/modal-menu' );
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
        integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
        integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous">
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="profile" href="https://gmpg.org/xfn/11">

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
                // Site title or logo.
                twentytwenty_site_logo();
                // Site description.
                twentytwenty_site_description();
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
                    <div class="toggle-wrapper search-toggle-wrapper">
                      <!-- .account -->
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle" type="button" id="about-us"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Account
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="about-us">
                                <li><a href="/wp-admin">Login</a></li>
                                <li><a href="/wp-admin">Logout</a></li>
                            </ul>
                        </div>
                    </div>
                    <?php
                    }
                    ?>
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
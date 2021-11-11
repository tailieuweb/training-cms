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

?><!DOCTYPE html>

<html class="no-js" <?php language_attributes(); ?>>

<head>

	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="profile" href="https://gmpg.org/xfn/11">
	<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="<?php echo get_template_directory_uri() ?>/style-module6.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="<?php echo get_template_directory_uri() ?>/style.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="profile" href="https://gmpg.org/xfn/11">

    <?php wp_head(); ?>

</head>


<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>

    <nav class="navbar navbar-expand-sm navbar-dark py-0 border" style="background-color:#f1f2f6;padding-right: 5em;">
        <div class="mx-2 header-titles-adjust">
            <?php
            // Site title or logo.
            twentytwenty_site_logo();
            ?>
        </div><!-- .header-titles -->
        <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId" aria-expanded="false" aria-label="Toggle navigation"><i class="fa fa-bars"></i></button>
        <div class="collapse navbar-collapse header-inner" id="collapsibleNavId">
            <ul class="navbar-nav ml-0  mt-2 mt-lg-0 navbar-adjust">
                <li class="mx-2 nav-item active">
                    <a class="navbar-brand " href="http://cms.local/">Home <span class="sr-only">(current)</span></a>
                </li>
            </ul>
            <form class="mx-1 form-inline mr-auto">
                <input class="form-control mr-sm-2 rounded" type="text" placeholder="Search">
                <button class="btn my-2 my-sm-0 border btn-submit-header" type="submit">Submit</button>
            </form>

            <div class="header-navigation-wrapper">
                <?php
                $enable_header_search = get_theme_mod('enable_header_search', true);
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
                            <!-- <div class="toggle-wrapper nav-toggle-wrapper has-expanded-menu"> -->
                            <button class="toggle nav-toggle desktop-nav-toggle" data-toggle-target=".menu-modal" data-toggle-body-class="showing-menu-modal" aria-expanded="false" data-set-focus=".close-nav-toggle">
                                <span class="toggle-inner">
                                    <span class="toggle-text"><?php _e('Menu', 'twentytwenty'); ?></span>
                                    <span class="toggle-icon">
                                        <?php twentytwenty_the_theme_svg('ellipsis'); ?>
                                    </span>
                                </span>
                            </button><!-- .nav-toggle -->
                            <!-- </div> -->
                            <!-- .nav-toggle-wrapper -->
                        <?php
                        }

                        if (true === $enable_header_search) {
                        ?>

                            <!-- <div class="toggle-wrapper search-toggle-wrapper"> -->

                            <button class="toggle search-toggle desktop-search-toggle" data-toggle-target=".search-modal" data-toggle-body-class="showing-search-modal" data-set-focus=".search-modal .search-field" aria-expanded="false">
                                <span class="toggle-inner">
                                    <?php twentytwenty_the_theme_svg('search'); ?>
                                    <span class="toggle-text"><?php _ex('Search', 'toggle text', 'twentytwenty'); ?></span>
                                </span>
                            </button><!-- .search-toggle -->
                            <!-- </div> -->
                        <?php
                        }
                        ?>
                        <div class="dropdown show">
                            <a class="btn btn-secondary dropdown-toggle d-block" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-user-circle-o fa-header" aria-hidden="true"></i>
                                <p class="account-text-header">Account<span class="caret"></span></p>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item" href="<?= wp_login_url() ?>">Login</a>
                                <a class="dropdown-item" href="<?= wp_logout_url() ?>">Logout</a>
                            </div>
                        </div>
                    </div><!-- .header-toggles -->
                <?php
                }
                ?>
            </div><!-- .header-navigation-wrapper -->

            <?php
            // Output the search modal (if it is activated in the customizer).
            if (true === $enable_header_search) {
                get_template_part('template-parts/modal-search');
            }
            ?>
            <?php
            // Output the menu modal.
            get_template_part('template-parts/modal-menu');
            ?>
        </div>
    </nav>

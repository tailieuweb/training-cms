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

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

    <link rel="profile" href="https://gmpg.org/xfn/11">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri() ?>/cssnhomj/module_1.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="<?php echo get_template_directory_uri() ?>/cssnhomj/module_2.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="<?php echo get_template_directory_uri() ?>/cssnhomj/module_4.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="<?php echo get_template_directory_uri() ?>/cssnhomj/module_5.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="<?php echo get_template_directory_uri() ?>/cssnhomj/module_6.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="<?php echo get_template_directory_uri() ?>/cssnhomj/module_8.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="<?php echo get_template_directory_uri() ?>/cssnhomj/module_9.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="<?php echo get_template_directory_uri() ?>/cssnhomj/module_7.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="<?php echo get_template_directory_uri() ?>/cssnhomj/module_10.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="<?php echo get_template_directory_uri() ?>/cssnhomj/module_post.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="<?php echo get_template_directory_uri() ?>/cssnhomj/module_banner.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="<?php echo get_template_directory_uri() ?>/cssnhomj/module_contact.css" type="text/css" media="screen" />
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
                    <form role="search" aria-label="Search for:" method="get" class="search-form-header" action="http://wordpress.local/">
                        <label for="search-form-1">
                            <span class="screen-reader-text">Search for:</span>
                            <input type="search" id="search-form-1" class="search-field" placeholder="Search" value="" name="s">
                        </label>
                        <input type="submit" class="search-submit" value="Submit">
                    </form>

                </div><!-- .header-titles -->

                <button class="toggle nav-toggle mobile-nav-toggle" data-toggle-target=".menu-modal" data-toggle-body-class="showing-menu-modal" aria-expanded="false" data-set-focus=".close-nav-toggle">
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

                            <div class="dropdown">
                                <div class="dropbtn">
                                    <div class="icon">
                                        <i class="fa fa-user-circle-o"></i>
                                    </div>
                                    <div class="text">
                                        <p>Account <span class="caret"></span></p>
                                    </div>
                                </div>
                                <div class="dropdown-content">
                                    <a href="http://wordpress.local/admin">Admin</a>
                                    <a href="http://wordpress.local/">Home</a>
                                    <a href="http://wordpress.local/wp-login.php?action=logout&amp;_wpnonce=30b03db75e">Logout</a>
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
        if (true === $enable_header_search) {
            get_template_part('template-parts/modal-search');
        }
        ?>
        <!--Image slider start-->
        <div class="container">
            <div class="banner">
                <div class="slider">
                    <div class="sliders">
                        <!--Radio button start-->
                        <input type="radio" name="radio-btn" id="radio1">
                        <input type="radio" name="radio-btn" id="radio2">
                        <input type="radio" name="radio-btn" id="radio3">
                        <input type="radio" name="radio-btn" id="radio4">
                        <!--Radio button end-->
                        <!--Image slide start-->
                        <div class="slide first">
                            <img src="http://wordpress.local/wp-content/uploads/2021/09/Pin-ran-7204-1632994229-150x150.jpg" alt="">
                            <a href="http://wordpress.local/2021/09/30/pin-co-the-uon-va-co-gian-nhu-ran/" class="link">Pin có thể uốn và co giãn như rắn</a>
                        </div>
                        <div class="slide">
                            <img src="http://wordpress.local/wp-content/uploads/2021/09/BT-Dat-2430-1632996417-150x150.jpg" alt="">
                            <a href="http://wordpress.local/2021/09/30/tim-nguoi-gioi-cho-nhung-nghien-cuu-hang-dau-tai-vkist/" class="link">Tìm người giỏi cho những nghiên cứu hàng đầu tại VKIST</a>
                        </div>
                        <div class="slide">
                            <img src="http://wordpress.local/wp-content/uploads/2021/09/AP-jpeg-8023-1633017280-150x150.jpg" alt="">
                            <a href="http://wordpress.local/2021/09/30/usyk-khong-muon-knock-out-joshua/" class="link">Usyk không muốn knock-out Joshua</a>
                        </div>
                        <div class="slide">
                            <img src="http://wordpress.local/wp-content/uploads/2021/09/gettyimages-1344118969-2048x20-7575-9489-1633032281-150x150.jpg" alt="">
                            <a href="http://wordpress.local/2021/09/30/bo-dao-nha-vao-chung-ket-futsal-world-cup/" class="link">Bồ Đào Nha vào chung kết futsal World Cup</a>
                        </div>
                        <!--Image slide end-->
                        <!--Automatic navigation start-->
                        <div class="navigation-auto">
                            <div class="auto-btn1"></div>
                            <div class="auto-btn2"></div>
                            <div class="auto-btn3"></div>
                            <div class="auto-btn4"></div>
                        </div>
                        <!--Automatic navigation end-->
                    </div>
                    <!--Manual navigation start-->
                    <div class="navigation-manual">
                        <label for="radio1" class="manual-btn"></label>
                        <label for="radio2" class="manual-btn"></label>
                        <label for="radio3" class="manual-btn"></label>
                        <label for="radio4" class="manual-btn"></label>
                    </div>
                    <!--Manual navigation end-->
                </div>
            </div>
        </div>
        <!--Image slider end-->
        <script type="text/javascript">
            var counter = 1;
            setInterval(function() {
                document.getElementById('radio' + counter).checked = true;
                counter++;
                if (counter > 4) {
                    counter = 1;
                }
            }, 4000);
        </script>
    </header><!-- #site-header -->

    <?php
    // Output the menu modal.
    get_template_part('template-parts/modal-menu');

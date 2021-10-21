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

        <!--Important link from source https://bootsnipp.com/snippets/rlXdE-->

        <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet"
              id="bootstrap-css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <!--	<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>-->
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <!------ Include the above in your HEAD tag ---------->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css"
              integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt"
              crossorigin="anonymous">
        <style>

            .list_new_view {
                font-size: 0.9em;
                padding: 15px;
            }

            .list_new_view .topnewstime > span.topnewsdate {
                font-family: 'Prata', serif;
                font-size: 3.1em;
                line-height: 1em;
                margin-left: 15px;
            }

            .list_new_view .topnewstime > span.topnewsmonth {
                text-transform: uppercase;
                font-size: 0.9em;
                margin-left: 15px;
            }

            .list_new_view a {
                color: #428bca;
                text-decoration: none;
            }

            .list_new_view .shortdesc {
                border-left: 1px solid #666;
            }

            .list_new_view .shortdesc h4 {
                padding-top: 0;
                margin-top: 0;
            }

            .list_new_view .row .top_news_block_desc {
                background: #fff;
                -webkit-box-shadow: 0px 0px 5px 0px rgb(0 0 calc(0 / 20%));
                -moz-box-shadow: 0px 0px 5px 0px rgba(0, 0, 0, 0.2);
                box-shadow: 0px 0px 5px 0px rgb(0 0 calc(0 / 20%));
                padding: 15px;
            }

            .list_new_view {
                margin-bottom: 15px;
            }

            #site-content {
                margin-left: 20px;
            }

            /*    search */
            #search-form-2-label::before{
                transform: translateX(40px) translateY(20%);
                content: "\f002";
                font-weight: 900;
                font-size: 2rem;
                font-family: "Font Awesome 5 Free";
                -moz-osx-font-smoothing: grayscale;
                -webkit-font-smoothing: antialiased;
            }
            #search-form-2 {
                padding-left: 40px;
            }
        </style>
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

                    // Site description.
                    twentytwenty_site_description();
                    ?>

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
                                        'container' => '',
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
                                        'walker' => new TwentyTwenty_Walker_Page(),
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

                                <button class="toggle search-toggle desktop-search-toggle"
                                        data-toggle-target=".search-modal" data-toggle-body-class="showing-search-modal"
                                        data-set-focus=".search-modal .search-field" aria-expanded="false">
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

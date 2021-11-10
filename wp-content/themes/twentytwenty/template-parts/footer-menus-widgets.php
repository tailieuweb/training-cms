<?php
/**
 * Displays the menus and widgets at the end of the main element.
 * Visually, this output is presented as part of the footer element.
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */

$has_footer_menu = has_nav_menu('footer');
$has_social_menu = has_nav_menu('social');

$has_sidebar_1 = is_active_sidebar('sidebar-1');
$has_sidebar_2 = is_active_sidebar('sidebar-2');
$has_custom_sidebar = is_active_sidebar('custom-widget-footer');
$has_custom_sidebar_second_col = is_active_sidebar('custom-widget-footer-second-col');
$has_custom_sidebar_last_col = is_active_sidebar('custom-widget-footer-last-col');

// Only output the container if there are elements to display.
if ($has_footer_menu || $has_social_menu || $has_sidebar_1 || $has_sidebar_2) {
    ?>

    <div class="footer-nav-widgets-wrapper header-footer-group">

            <?php

            $footer_top_classes = '';

            $footer_top_classes .= $has_footer_menu ? ' has-footer-menu' : '';
            $footer_top_classes .= $has_social_menu ? ' has-social-menu' : '';

            if ($has_footer_menu || $has_social_menu) {
                ?>
            <?php } ?>

            <?php if ($has_custom_sidebar) { ?>

                <section class="custom-module3-section" id="footer">
                    <div class="container">
                        <div class="row text-center text-xs-center text-sm-left text-md-left">
                            <?php if ($has_custom_sidebar) { ?>
                                <div class="col-xs-12 col-sm-4 col-md-4 custom-widget-layout">
                                    <?php dynamic_sidebar('custom-widget-footer'); ?>
                                </div>
                            <?php } ?>

                            <?php if ($has_custom_sidebar_second_col) { ?>
                                <div class="col-xs-12 col-sm-4 col-md-4 custom-widget-layout">
                                    <?php dynamic_sidebar('custom-widget-footer-second-col'); ?>
                                </div>
                            <?php } ?>

                            <?php if ($has_custom_sidebar_last_col) { ?>
                                <div class="col-xs-12 col-sm-4 col-md-4 custom-widget-layout">
                                    <?php dynamic_sidebar('custom-widget-footer-last-col'); ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div><!-- .footer-widgets-wrapper -->

                </section><!-- .footer-widgets-outer-wrapper -->

            <?php } ?>

    </div><!-- .footer-nav-widgets-wrapper -->

<?php } ?>

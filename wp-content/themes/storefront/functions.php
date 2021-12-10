<?php

/**
 * Storefront engine room
 *
 * @package storefront
 */

/**
 * Assign the Storefront version to a var
 */
$theme              = wp_get_theme('storefront');
$storefront_version = $theme['Version'];

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if (!isset($content_width)) {
    $content_width = 980; /* pixels */
}

$storefront = (object) array(
    'version'    => $storefront_version,

    /**
     * Initialize all the things.
     */
    'main'       => require 'inc/class-storefront.php',
    'customizer' => require 'inc/customizer/class-storefront-customizer.php',
);

require 'inc/storefront-functions.php';
require 'inc/storefront-template-hooks.php';
require 'inc/storefront-template-functions.php';
require 'inc/wordpress-shims.php';

if (class_exists('Jetpack')) {
    $storefront->jetpack = require 'inc/jetpack/class-storefront-jetpack.php';
}

if (storefront_is_woocommerce_activated()) {
    $storefront->woocommerce            = require 'inc/woocommerce/class-storefront-woocommerce.php';
    $storefront->woocommerce_customizer = require 'inc/woocommerce/class-storefront-woocommerce-customizer.php';

    require 'inc/woocommerce/class-storefront-woocommerce-adjacent-products.php';

    require 'inc/woocommerce/storefront-woocommerce-template-hooks.php';
    require 'inc/woocommerce/storefront-woocommerce-template-functions.php';
    require 'inc/woocommerce/storefront-woocommerce-functions.php';
}

if (is_admin()) {
    $storefront->admin = require 'inc/admin/class-storefront-admin.php';

    require 'inc/admin/class-storefront-plugin-install.php';
}

/**
 * NUX
 * Only load if wp version is 4.7.3 or above because of this issue;
 * https://core.trac.wordpress.org/ticket/39610?cversion=1&cnum_hist=2
 */
if (version_compare(get_bloginfo('version'), '4.7.3', '>=') && (is_admin() || is_customize_preview())) {
    require 'inc/nux/class-storefront-nux-admin.php';
    require 'inc/nux/class-storefront-nux-guided-tour.php';
    require 'inc/nux/class-storefront-nux-starter-content.php';
}
add_action('wp_footer', 'vinh_readmore_flatsome');
function vinh_readmore_flatsome()
{
?>
    <style>
        .single-product div#tab-description {
            overflow: hidden;
            position: relative;
            padding-bottom: 25px;
        }

        .single-product .tab-panels div#tab-description.panel:not(.active) {
            height: 0 !important;
        }

        .hoangweb_readmore_flatsome {
            text-align: center;
            cursor: pointer;
            position: absolute;
            z-index: 10;
            bottom: 0;
            width: 100%;
            background: #fff;
        }

        .hoangweb_readmore_flatsome:before {
            height: 55px;
            margin-top: -45px;
            content: -webkit-gradient(linear, 0% 100%, 0% 0%, from(#fff), color-stop(.2, #fff), to(rgba(255, 255, 255, 0)));
            display: block;
        }

        .hoangweb_readmore_flatsome a {
            color: #318A00;
            display: block;
        }

        .hoangweb_readmore_flatsome a:after {
            content: '';
            width: 0;
            right: 0;
            border-top: 6px solid #318A00;
            border-left: 6px solid transparent;
            border-right: 6px solid transparent;
            display: inline-block;
            vertical-align: middle;
            margin: -2px 0 0 5px;
        }

        .hoangweb_readmore_flatsome_less a:after {
            border-top: 0;
            border-left: 6px solid transparent;
            border-right: 6px solid transparent;
            border-bottom: 6px solid #318A00;
        }

        .hoangweb_readmore_flatsome_less:before {
            display: none;
        }
    </style>
    <script>
        (function($) {
            $(document).ready(function() {
                $(window).load(function() {
                    if ($('.single-product div#tab-description').length > 0) {
                        var wrap = $('.single-product div#tab-description');
                        var current_height = wrap.height();
                        var your_height = 300;
                        if (current_height > your_height) {
                            wrap.css('height', your_height + 'px');
                            wrap.append(function() {
                                return '<div class="hoangweb_readmore_flatsome hoangweb_readmore_flatsome_more"><a title="Xem thêm" href="javascript:void(0);">Xem thêm</a></div>';
                            });
                            wrap.append(function() {
                                return '<div class="hoangweb_readmore_flatsome hoangweb_readmore_flatsome_less" style="display: none;"><a title="Xem thêm" href="javascript:void(0);">Thu gọn</a></div>';
                            });
                            $('body').on('click', '.hoangweb_readmore_flatsome_more', function() {
                                wrap.removeAttr('style');
                                $('body .hoangweb_readmore_flatsome_more').hide();
                                $('body .hoangweb_readmore_flatsome_less').show();
                            });
                            $('body').on('click', '.hoangweb_readmore_flatsome_less', function() {
                                wrap.css('height', your_height + 'px');
                                $('body .hoangweb_readmore_flatsome_less').hide();
                                $('body .hoangweb_readmore_flatsome_more').show();
                            });
                        }
                    }
                });
            })
        })(jQuery)
    </script>
<?php
}
function catch_that_image()
{
    global $post, $posts;
    $first_img = '';
    ob_start();
    ob_end_clean();
    $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
    $first_img = $matches[1][0];

    if (empty($first_img)) { //Defines a default image
        $first_img = "/images/default.jpg"; //Duong dan anh mac dinh khi khong tim duoc anh dai dien
    }
    return $first_img;
}

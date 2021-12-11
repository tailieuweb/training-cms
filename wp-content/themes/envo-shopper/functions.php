<?php
/**
 * The current version of the theme.
 */
$the_theme = wp_get_theme();
define('ENVO_SHOPPER_VERSION', $the_theme->get('Version'));

add_action('after_setup_theme', 'envo_shopper_setup');

if (!function_exists('envo_shopper_setup')) :

    /**
     * Global functions
     */
    function envo_shopper_setup() {

        // Theme lang.
        load_theme_textdomain('envo-shopper', get_template_directory() . '/languages');

        // Add Title Tag Support.
        add_theme_support('title-tag');
        $menus = array('main_menu' => esc_html__('Main Menu', 'envo-shopper'));
        if (class_exists('WooCommerce')) {
            $woo_menus = array(
                'main_menu_right' => esc_html__('Menu Right', 'envo-shopper'),
                'main_menu_cats' => esc_html__('Categories Menu', 'envo-shopper'),
            );
        } else {
            $woo_menus = array(); // not displayed if Woo not installed
        }
        $all_menus = array_merge($menus, $woo_menus);

        // Register Menus.
        register_nav_menus($all_menus);

        add_theme_support('post-thumbnails');
        set_post_thumbnail_size(300, 300, true);
        add_image_size('envo-shopper-single', 1140, 641, true);
        add_image_size('envo-shopper-med', 720, 405, true);

        // Add Custom Background Support.
        $args = array(
            'default-color' => 'ffffff',
        );
        add_theme_support('custom-background', $args);

        add_theme_support('custom-logo', array(
            'height' => 60,
            'width' => 200,
            'flex-height' => true,
            'flex-width' => true,
            'header-text' => array('site-title', 'site-description'),
        ));

        // Adds RSS feed links to for posts and comments.
        add_theme_support('automatic-feed-links');

        /*
         * Let WordPress manage the document title.
         */
        add_theme_support('title-tag');

        // Set the default content width.
        $GLOBALS['content_width'] = 1140;

        add_theme_support('custom-header', apply_filters('envo_shopper_custom_header_args', array(
            'width' => 2000,
            'height' => 200,
            'default-text-color' => '',
            'wp-head-callback' => 'envo_shopper_header_style',
        )));

        // WooCommerce support.
        add_theme_support('woocommerce');
        add_theme_support('wc-product-gallery-zoom');
        add_theme_support('wc-product-gallery-lightbox');
        add_theme_support('wc-product-gallery-slider');
        add_theme_support('html5', array('search-form'));
        /*
         * This theme styles the visual editor to resemble the theme style,
         * specifically font, colors, icons, and column width.
         */
        add_editor_style(array('css/bootstrap.css', envo_shopper_fonts_url(), 'css/editor-style.css'));

        // Recommend plugins.
        add_theme_support('recommend-plugins', array(
            'envothemes-demo-import' => array(
                'name' => 'EnvoThemes Demo Import',
                'active_filename' => 'envothemes-demo-import/envothemes-demo-import.php',
                'description' => esc_html__('Save time by importing our demo data: your website will be set up and ready to be customized in minutes.', 'envo-shopper'),
            ),
            'woocommerce' => array(
                'name' => 'WooCommerce',
                'active_filename' => 'woocommerce/woocommerce.php',
                /* translators: %s plugin name string */
                'description' => sprintf(esc_attr__('To enable shop features, please install and activate the %s plugin.', 'envo-shopper'), '<strong>WooCommerce</strong>'),
            ),
            'elementor' => array(
                'name' => 'Elementor',
                'active_filename' => 'elementor/elementor.php',
                /* translators: %s plugin name string */
                'description' => sprintf(esc_attr__('The most advanced frontend drag & drop page builder.', 'envo-shopper'), '<strong>Elementor</strong>'),
            ),
        ));
    }

endif;

if (!function_exists('envo_shopper_header_style')) :

    /**
     * Styles the header image and text displayed on the blog.
     */
    function envo_shopper_header_style() {
        $header_image = get_header_image();
        $header_text_color = get_header_textcolor();
        if (get_theme_support('custom-header', 'default-text-color') !== $header_text_color || !empty($header_image)) {
            ?>
            <style type="text/css" id="envo-shopper-header-css">
            <?php
// Has a Custom Header been added?
            if (!empty($header_image)) :
                ?>
                    .site-header {
                        background-image: url(<?php header_image(); ?>);
                        background-repeat: no-repeat;
                        background-position: 50% 50%;
                        -webkit-background-size: cover;
                        -moz-background-size:    cover;
                        -o-background-size:      cover;
                        background-size:         cover;
                    }
            <?php endif; ?>	
            <?php
// Has the text been hidden?
            if ('blank' === $header_text_color) :
                ?>
                    .site-title,
                    .site-description {
                        position: absolute;
                        clip: rect(1px, 1px, 1px, 1px);
                    }
            <?php elseif ('' !== $header_text_color) : ?>
                    .site-title a, 
                    .site-title, 
                    .site-description {
                        color: #<?php echo esc_attr($header_text_color); ?>;
                    }
            <?php endif; ?>	
            </style>
            <?php
        }
    }

endif; // envo_shopper_header_style

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function envo_shopper_pingback_header() {
    if (is_singular() && pings_open()) {
        printf('<link rel="pingback" href="%s">' . "\n", esc_url(get_bloginfo('pingback_url')));
    }
}

add_action('wp_head', 'envo_shopper_pingback_header');

/**
 * Set Content Width
 */
function envo_shopper_content_width() {

    $content_width = $GLOBALS['content_width'];

    if (is_active_sidebar('envo-shopper-right-sidebar')) {
        $content_width = 847;
    } else {
        $content_width = 1140;
    }

    /**
     * Filter content width of the theme.
     */
    $GLOBALS['content_width'] = apply_filters('envo_shopper_content_width', $content_width);
}

add_action('template_redirect', 'envo_shopper_content_width', 0);

/**
 * Register custom fonts.
 */
function envo_shopper_fonts_url() {
    $fonts_url = '';

    /**
     * Translators: If there are characters in your language that are not
     * supported by Roboto Condensed, translate this to 'off'. Do not translate
     * into your own language.
     */
    $font = _x('on', 'Roboto Condensed font: on or off', 'envo-shopper');

    if ('off' !== $font) {
        $font_families = array();

        $font_families[] = 'Roboto Condensed:300,500,700';

        $query_args = array(
            'family' => urlencode(implode('|', $font_families)),
            'subset' => urlencode('cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese'),
        );

        $fonts_url = add_query_arg($query_args, 'https://fonts.googleapis.com/css');
    }

    return esc_url_raw($fonts_url);
}

/**
 * Add preconnect for Google Fonts.
 */
function envo_shopper_resource_hints($urls, $relation_type) {
    if (wp_style_is('envo-shopper-fonts', 'queue') && 'preconnect' === $relation_type) {
        $urls[] = array(
            'href' => 'https://fonts.gstatic.com',
            'crossorigin',
        );
    }

    return $urls;
}

add_filter('wp_resource_hints', 'envo_shopper_resource_hints', 10, 2);

/**
 * Enqueue Styles (normal style.css and bootstrap.css)
 */
function envo_shopper_theme_stylesheets() {
    // Add custom fonts, used in the main stylesheet.
    wp_enqueue_style('envo-shopper-fonts', envo_shopper_fonts_url(), array(), null);
    wp_enqueue_style('bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.css', array(), '3.3.7');
    wp_enqueue_style('mmenu-light', get_template_directory_uri() . '/assets/css/mmenu-light.min.css', array(), ENVO_SHOPPER_VERSION);
    // Theme stylesheet.
    wp_enqueue_style('envo-shopper-stylesheet', get_stylesheet_uri(), array('bootstrap'), ENVO_SHOPPER_VERSION);
    // WooCommerce stylesheet.
    if (class_exists('WooCommerce')) {
        wp_enqueue_style('envo-shopper-woo-stylesheet', get_template_directory_uri() . '/assets/css/woocommerce.css', array('envo-shopper-stylesheet'), ENVO_SHOPPER_VERSION);
    }
    // Load Line Awesome css.
    wp_enqueue_style('line-awesome', get_template_directory_uri() . '/assets/css/line-awesome.min.css', array(), '1.3.0');
}

add_action('wp_enqueue_scripts', 'envo_shopper_theme_stylesheets');

/**
 * Register jquery
 */
function envo_shopper_theme_js() {
    wp_enqueue_script('bootstrap', get_template_directory_uri() . '/assets/js/bootstrap.min.js', array('jquery'), '3.3.7', true);
    wp_enqueue_script('envo-shopper-theme-js', get_template_directory_uri() . '/assets/js/customscript.js', array('jquery'), ENVO_SHOPPER_VERSION, true);
    wp_enqueue_script('mmenu', get_template_directory_uri() . '/assets/js/mmenu-light.min.js', array('jquery'), ENVO_SHOPPER_VERSION, true);
}

add_action('wp_enqueue_scripts', 'envo_shopper_theme_js');

if (!function_exists('envo_shopper_is_pro_activated')) {

    /**
     * Query Envo Shopper activation
     */
    function envo_shopper_is_pro_activated() {
        return defined('ENVO_SHOPPER_PRO_CURRENT_VERSION') ? true : false;
    }

}

add_action('widgets_init', 'envo_shopper_widgets_init');

/**
 * Register the Sidebar(s)
 */
function envo_shopper_widgets_init() {
    register_sidebar(
            array(
                'name' => esc_html__('Sidebar', 'envo-shopper'),
                'id' => 'envo-shopper-right-sidebar',
                'before_widget' => '<div id="%1$s" class="widget %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<div class="widget-title"><h3>',
                'after_title' => '</h3></div>',
            )
    );
    register_sidebar(
            array(
                'name' => esc_html__('Top Bar Section', 'envo-shopper'),
                'id' => 'envo-shopper-top-bar-area',
                'before_widget' => '<div id="%1$s" class="widget %2$s col-sm-4">',
                'after_widget' => '</div>',
                'before_title' => '<div class="widget-title"><h3>',
                'after_title' => '</h3></div>',
            )
    );
    register_sidebar(
            array(
                'name' => esc_html__('Header Section', 'envo-shopper'),
                'id' => 'envo-shopper-header-area',
                'before_widget' => '<div id="%1$s" class="widget %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<div class="widget-title"><h3>',
                'after_title' => '</h3></div>',
            )
    );
    register_sidebar(
            array(
                'name' => esc_html__('Footer Section', 'envo-shopper'),
                'id' => 'envo-shopper-footer-area',
                'before_widget' => '<div id="%1$s" class="widget %2$s col-md-3">',
                'after_widget' => '</div>',
                'before_title' => '<div class="widget-title"><h3>',
                'after_title' => '</h3></div>',
            )
    );
}

/**
 * Register Custom Navigation Walker include custom menu widget to use walkerclass
 */
require_once( trailingslashit(get_template_directory()) . 'inc/wp_bootstrap_navwalker.php' );

/**
 * Extra theme functions
 */
require_once( trailingslashit(get_template_directory()) . 'inc/extras.php' );

if (class_exists('WooCommerce')) {

    /**
     * WooCommerce options
     */
    require_once( trailingslashit(get_template_directory()) . 'inc/woocommerce.php' );
}

/**
 * Register Theme Info Page
 */
require_once( trailingslashit(get_template_directory()) . 'inc/dashboard.php' );
/**
 * Customizer options
 */
require_once( trailingslashit(get_template_directory()) . 'inc/customizer.php' );

/**
 * Set the content width based on enabled sidebar
 */
function envo_shopper_main_content_width_columns() {

    $columns = '12';

    if (is_active_sidebar('envo-shopper-right-sidebar')) {
        $columns = $columns - 3;
    }

    echo absint($columns);
}

if (!function_exists('envo_shopper_excerpt_length')) :

    /**
     * Excerpt limit.
     */
    function envo_shopper_excerpt_length($length) {
        return 45;
    }

    add_filter('excerpt_length', 'envo_shopper_excerpt_length', 999);

endif;

if (!function_exists('envo_shopper_excerpt_more')) :

    /**
     * Excerpt more.
     */
    function envo_shopper_excerpt_more($more) {
        return '&hellip;';
    }

    add_filter('excerpt_more', 'envo_shopper_excerpt_more');

endif;

if (!function_exists('envo_shopper_title_logo')) {

    /**
     * Title, logo code
     */
    function envo_shopper_title_logo($h = 'h1') {
        ?>
        <div class="site-branding-logo">
            <?php the_custom_logo(); ?>
        </div>
        <div class="site-branding-text">
            <?php if (is_front_page()) : ?>
                <<?php echo esc_html($h) ?> class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php bloginfo('name'); ?></a></<?php echo esc_html($h) ?>>
            <?php else : ?>
                <p class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php bloginfo('name'); ?></a></p>
            <?php endif; ?>

            <?php
            $description = get_bloginfo('description', 'display');
            if ($description || is_customize_preview()) :
                ?>
                <p class="site-description">
                    <?php echo esc_html($description); ?>
                </p>
            <?php endif; ?>
        </div><!-- .site-branding-text -->
        <?php
    }

}

if (!function_exists('envo_shopper_thumb_img')) :

    /**
     * Returns widget thumbnail.
     */
    function envo_shopper_thumb_img($img = 'full', $col = '', $link = true, $single = false) {
        if (function_exists('envo_shopper_pro_thumb_img')) {
            envo_shopper_pro_thumb_img($img, $col, $link, $single);
        } elseif (( has_post_thumbnail() && $link == true)) {
            ?>
            <div class="news-thumb <?php echo esc_attr($col); ?>">
                <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                    <?php the_post_thumbnail($img); ?>
                </a>
            </div><!-- .news-thumb -->
        <?php } elseif (has_post_thumbnail()) { ?>
            <div class="news-thumb <?php echo esc_attr($col); ?>">
                <?php the_post_thumbnail($img); ?>
            </div><!-- .news-thumb -->	
            <?php
        }
    }

endif;

if (!function_exists('wp_body_open')) :

    /**
     * Fire the wp_body_open action.
     *
     * Added for backwards compatibility to support pre 5.2.0 WordPress versions.
     *
     */
    function wp_body_open() {
        /**
         * Triggered after the opening <body> tag.
         *
         */
        do_action('wp_body_open');
    }

endif;

/**
 * Skip to content link
 */
function envo_shopper_skip_link() {
    echo '<a class="skip-link screen-reader-text" href="#site-content">' . esc_html__('Skip to the content', 'envo-shopper') . '</a>';
}

add_action('wp_body_open', 'envo_shopper_skip_link', 5);

function envo_shopper_second_menu() {
    $class = '';
    if (class_exists('WooCommerce')) {
        $class .= 'search-on ';
    }
    if (has_nav_menu('main_menu_cats')) {
        $class .= 'menu-cats-on ';
    }
    if (has_nav_menu('main_menu_right')) {
        $class .= 'menu-right-on ';
    }
    echo esc_html($class);
}

add_filter('body_class', 'envo_shopper_body_class');

function envo_shopper_body_class($classes) {

    if (!class_exists('WooCommerce') && !is_active_sidebar('envo-shopper-header-area')) {
        $classes[] = 'woo-widgets-off';
    }

    return $classes;
}

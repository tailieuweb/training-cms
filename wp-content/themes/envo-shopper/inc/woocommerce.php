<!-- <link rel="stylesheet" href="<?php //echo get_template_directory_uri() ?>/header-home.css"> -->
<?php
if (!function_exists('envo_shopper_cart_link')) {

    function envo_shopper_cart_link() {
        ?>	
        <a class="cart-contents" href="<?php echo esc_url(wc_get_cart_url()); ?>" data-tooltip="<?php esc_attr_e('Cart', 'envo-shopper'); ?>" title="<?php esc_attr_e('Cart', 'envo-shopper'); ?>">
            <i class="la la-shopping-bag"><span class="count"><?php echo wp_kses_data(WC()->cart->get_cart_contents_count()); ?></span></i>
            <div class="amount-cart hidden-xs"><?php echo wp_kses_data(WC()->cart->get_cart_subtotal()); ?></div> 
        </a>
        <?php
    }

}

if (!function_exists('envo_shopper_header_cart')) {

    add_action('envo_shopper_header_right', 'envo_shopper_header_cart', 10);

    function envo_shopper_header_cart() {
        if (get_theme_mod('woo_header_cart', 1) == 1) {
            ?>
            <div class="header-cart">
                <div class="header-cart-block">
                    <div class="header-cart-inner">
                        <?php envo_shopper_cart_link(); ?>
                        <ul class="site-header-cart menu list-unstyled text-center">
                            <li>
                                <?php the_widget('WC_Widget_Cart', 'title='); ?>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <?php
        }
    }

}

if (!function_exists('envo_shopper_header_add_to_cart_fragment')) {
    add_filter('woocommerce_add_to_cart_fragments', 'envo_shopper_header_add_to_cart_fragment');

    function envo_shopper_header_add_to_cart_fragment($fragments) {
        ob_start();

        envo_shopper_cart_link();

        $fragments['a.cart-contents'] = ob_get_clean();

        return $fragments;
    }

}

if (!function_exists('envo_shopper_my_account')) {

    add_action('envo_shopper_header_right', 'envo_shopper_my_account', 20);

    function envo_shopper_my_account() {
        $login_link = get_permalink(get_option('woocommerce_myaccount_page_id'));
        ?>
        <div class="header-my-account">
            <div class="header-login"> 
                <a href="<?php echo esc_url($login_link); ?>" data-tooltip="<?php esc_attr_e('My Account', 'envo-shopper'); ?>" title="<?php esc_attr_e('My Account', 'envo-shopper'); ?>">
                    <i class="la la-user"></i>
                </a>
            </div>
        </div>
        <?php
    }

}

if (!function_exists('envo_shopper_head_wishlist')) {

    add_action('envo_shopper_header_right', 'envo_shopper_head_wishlist', 30);

    function envo_shopper_head_wishlist() {
        if (function_exists('YITH_WCWL')) {
            $wishlist_url = YITH_WCWL()->get_wishlist_url();
            ?>
            <div class="header-wishlist">
                <a href="<?php echo esc_url($wishlist_url); ?>" data-tooltip="<?php esc_attr_e('Wishlist', 'envo-shopper'); ?>" title="<?php esc_attr_e('Wishlist', 'envo-shopper'); ?>">
                    <i class="lar la-heart"></i>
                </a>
            </div>
            <?php
        }
    }

}

if (!function_exists('envo_shopper_head_compare')) {

    add_action('envo_shopper_header_right', 'envo_shopper_head_compare', 40);

    function envo_shopper_head_compare() {
        if (function_exists('yith_woocompare_constructor')) {
            global $yith_woocompare;
            ?>
            <div class="header-compare product">
                <a class="compare added" rel="nofollow" href="<?php echo esc_url($yith_woocompare->obj->view_table_url()); ?>" data-tooltip="<?php esc_attr_e('Compare', 'envo-shopper'); ?>" title="<?php esc_attr_e('Compare', 'envo-shopper'); ?>">
                    <i class="la la-sync"></i>
                </a>
            </div>
            <?php
        }
    }

}

if (!function_exists('envo_shopper_categories_menu')) {

    /**
     * Categories menu. Displayed only if exists.
     */
    add_action('envo_shopper_header_bar', 'envo_shopper_categories_menu', 10);

    function envo_shopper_categories_menu() {
        if (has_nav_menu('main_menu_cats')) {
            ?>
            <ul class="envo-categories-menu nav navbar-nav navbar-left">
                <li class="menu-item menu-item-has-children dropdown">
                    <a class="envo-categories-menu-first" href="#">
                        <?php esc_html_e('Loại sản phẩm', 'envo-shopper'); ?>
                    </a>
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'main_menu_cats',
                        'depth' => 5,
                        'container_id' => 'menu-right',
                        'container' => 'ul',
                        'container_class' => '',
                        'menu_class' => 'dropdown-menu',
                        'fallback_cb' => 'Envo_Shopper_WP_Bootstrap_Navwalker::fallback',
                        'walker' => new Envo_Shopper_WP_Bootstrap_Navwalker(),
                    ));
                    ?>
                </li>
            </ul>
            <?php
        } else {
            ?>
            <ul class="envo-categories-menu nav navbar-nav navbar-left">
                <li class="envo-categories-menu-item menu-item menu-item-has-children dropdown">
                    <a class="envo-categories-menu-first" href="#">
                        <?php esc_html_e('Categories', 'envo-shopper'); ?>
                    </a>
                    <ul id="menu-categories-menu" class="menu-categories-menu dropdown-menu">
                        <?php
                        $categories = get_categories('taxonomy=product_cat');
                        foreach ($categories as $category) {
                            $category_link = get_category_link($category->cat_ID);
                            $option = '<li class="menu-item ' . esc_attr($category->category_nicename) . '">';
                            $option .= '<a href="' . esc_url($category_link) . '" class="nav-link">';
                            $option .= esc_html($category->cat_name);
                            $option .= '</a>';
                            $option .= '</li>';
                            echo $option; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                        }
                        ?>
                    </ul>
                </li>
            </ul>
            <?php
        }
    }

}

if (!function_exists('envo_shopper_head_search_bar')) {

    add_action('envo_shopper_header_bar', 'envo_shopper_head_search_bar', 20);

    function envo_shopper_head_search_bar() {
        ?>
        <div class="header-search-form">
            <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
                <input type="hidden" name="post_type" value="product" />
                <input class="header-search-input" name="s" type="text" placeholder="<?php esc_attr_e('Nhập tên sản phẩm', 'envo-shopper'); ?>"/>
                <select class="header-search-select" name="product_cat">
                    <option value=""><?php esc_html_e('Tất cả loại sản phẩm', 'envo-shopper'); ?></option> 
                    <?php
                    $categories = get_categories('taxonomy=product_cat');
                    foreach ($categories as $category) {
                        $option = '<option value="' . esc_attr($category->category_nicename) . '">';
                        $option .= esc_html($category->cat_name);
                        $option .= ' <span>(' . absint($category->category_count) . ')</span>';
                        $option .= '</option>';
                        echo $option; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                    }
                    ?>
                </select>
                <button class="header-search-button" type="submit"><i class="la la-search" aria-hidden="true"></i></button>
            </form>
        </div>
        <?php
    }

}

if (!function_exists('envo_shopper_the_second_menu')) {

    add_action('envo_shopper_header_bar', 'envo_shopper_the_second_menu', 30);

    function envo_shopper_the_second_menu() {
        if (has_nav_menu('main_menu_right')) {
            wp_nav_menu(array(
                'theme_location' => 'main_menu_right',
                'depth' => 1,
                'container_id' => 'my-menu-right',
                'container' => 'div',
                'container_class' => 'menu-container',
                'menu_class' => 'nav navbar-nav navbar-right',
                'fallback_cb' => 'Envo_Shopper_WP_Bootstrap_Navwalker::fallback',
                'walker' => new Envo_Shopper_WP_Bootstrap_Navwalker(),
            ));
        }
    }

}

remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);

add_action('woocommerce_before_main_content', 'envo_shopper_wrapper_start', 10);
add_action('woocommerce_after_main_content', 'envo_shopper_wrapper_end', 10);

function envo_shopper_wrapper_start() {
    ?>
    <div class="row">
        <article class="col-md-<?php envo_shopper_main_content_width_columns(); ?>">
    <?php
}

function envo_shopper_wrapper_end() {
    ?>
        </article>       
        <?php get_sidebar('right'); ?>
    </div>
    <?php
}

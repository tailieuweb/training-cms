<?php

/**
 * Defines customizer options
 *
 * @package Customizer Library Overlay
 */
function woocustomizer_customizer_library_options()
{
    // Stores all the controls that will be added
    $options = array();
    // Stores all the sections to be added
    $sections = array();
    // Stores all the panels to be added
    $panels = array();
    // Adds the sections to the $options array
    $options['sections'] = $sections;
    
    if ( WooCustomizer::wcz_is_plugin_active( 'woocommerce.php' ) ) {
        // is WooCommerce Activated
        // ---------------- PANEL - Theme Settings
        $panel = 'wcz-panel-settings';
        $panels[] = array(
            'id'       => $panel,
            'title'    => __( 'StoreCustomizer', 'woocustomizer' ),
            'priority' => '10',
        );
        // --------------------------------------------------------------------------------------------------------------------------------- WC Panel
        // ----------------------------------------------------------------------------------------------- StoreCustomizer Main Panel
        $section = 'wcz-panel-woocustomizer';
        $sections[] = array(
            'id'       => $section,
            'title'    => __( 'StoreCustomizer', 'woocustomizer' ),
            'priority' => '10',
            'panel'    => $panel,
        );
        $options['wcz-wc-remove-breadcrumbs'] = array(
            'id'      => 'wcz-wc-remove-breadcrumbs',
            'label'   => __( 'Remove All WooCommerce Breadcrumbs', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        // Admin Only Settings
        $options['wcz-heading-wcc-admin'] = array(
            'id'      => 'wcz-heading-wcc-admin',
            'label'   => __( 'Admin Only Settings', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'url',
        );
        $options['wcz-admin-product-stats'] = array(
            'id'          => 'wcz-admin-product-stats',
            'label'       => __( 'Turn on Front-End Product Statistics', 'woocustomizer' ),
            'section'     => $section,
            'type'        => 'checkbox',
            'description' => __( 'Only admin users are able to view these statistics on the website front-end.<br />Site visitors will not see this.', 'woocustomizer' ),
            'default'     => 0,
        );
        // Login or Logout Menu Item Settings
        $options['wcz-heading-login-logout'] = array(
            'id'      => 'wcz-heading-login-logout',
            'label'   => __( 'Login / Logout Menu Item', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'url',
        );
        // Get Theme Menu Locations for Menu Cart
        $nav_choices = array(
            'none' => 'None',
        );
        $wcz_menus = get_registered_nav_menus();
        foreach ( $wcz_menus as $location => $description ) {
            $nav_choices[$location] = $description;
        }
        $wcz_allmenus = wp_get_nav_menus();
        foreach ( $wcz_allmenus as $wcz_allmenu ) {
            $nav_choices[$wcz_allmenu->slug] = $wcz_allmenu->name;
        }
        $options['wcz-login-logout-menu'] = array(
            'id'          => 'wcz-login-logout-menu',
            'label'       => __( 'Add Login / Logout to Navigation', 'woocustomizer' ),
            'section'     => $section,
            'type'        => 'select',
            'choices'     => array_unique( $nav_choices ),
            'description' => __( 'This will add a Login navigation item, and will change to Logout if the user is logged in.', 'woocustomizer' ),
            'default'     => 'none',
        );
        $options['wcz-login-text'] = array(
            'id'      => 'wcz-login-text',
            'label'   => __( 'Login Text', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'text',
            'default' => __( 'Login', 'woocustomizer' ),
        );
        $choices = array(
            'wplogin' => 'WordPress Login Page',
            'wclogin' => 'WooCommerce Account/Login Page',
            'custom'  => 'Custom Url',
        );
        $options['wcz-login-item-url'] = array(
            'id'      => 'wcz-login-item-url',
            'label'   => __( 'Menu item links to:', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'select',
            'choices' => $choices,
            'default' => 'wplogin',
        );
        $options['wcz-login-at-custom-url'] = array(
            'id'      => 'wcz-login-at-custom-url',
            'label'   => __( 'Custom Page Url', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'text',
        );
        $options['wcz-login-redirect-page'] = array(
            'id'          => 'wcz-login-redirect-page',
            'label'       => __( 'Login Redirect Page', 'woocustomizer' ),
            'section'     => $section,
            'type'        => 'dropdown-pages',
            'description' => __( 'Select which page to redirect the user to after LOGGING IN. Defaults to Home.', 'woocustomizer' ),
            'default'     => '',
        );
        $options['wcz-logout-text'] = array(
            'id'      => 'wcz-logout-text',
            'label'   => __( 'Logout Text', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'text',
            'default' => __( 'Logout', 'woocustomizer' ),
        );
        $options['wcz-logout-redirect-page'] = array(
            'id'          => 'wcz-logout-redirect-page',
            'label'       => __( 'Logout Redirect Page', 'woocustomizer' ),
            'section'     => $section,
            'type'        => 'dropdown-pages',
            'description' => __( 'Select which page to redirect the user to after LOGGING OUT. Defaults to Home.', 'woocustomizer' ),
            'default'     => '',
        );
        // Banner to WooCommerce Pages
        $options['wcz-heading-wcc-page-banner'] = array(
            'id'      => 'wcz-heading-wcc-page-banner',
            'label'   => __( 'WooCommerce Page/s Notice', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'url',
        );
        $options['wcz-wc-notice-banner'] = array(
            'id'          => 'wcz-wc-notice-banner',
            'label'       => __( 'Add a notice to WooCommerce pages', 'woocustomizer' ),
            'section'     => $section,
            'type'        => 'checkbox',
            'description' => __( 'Depending on your theme, the position of these hooks might change slightly', 'woocustomizer' ),
            'default'     => 0,
        );
        $options['wcz-wc-notice-title'] = array(
            'id'      => 'wcz-wc-notice-title',
            'label'   => __( 'Title', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'text',
            'default' => __( 'Please Note!', 'woocustomizer' ),
        );
        $options['wcz-wc-notice-text'] = array(
            'id'          => 'wcz-wc-notice-text',
            'label'       => __( 'Text', 'woocustomizer' ),
            'section'     => $section,
            'type'        => 'textarea',
            'description' => __( 'You can use styling tags and inline CSS to further style the text in the notice.', 'woocustomizer' ),
            'default'     => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc tincidunt nec diam eu convallis. Nullam quis ipsum volutpat, porta ex sit amet, posuere lorem.', 'woocustomizer' ),
        );
        $choices = array(
            'none'                            => 'Off',
            'woocommerce_before_main_content' => 'Top of Page',
            'woocommerce_before_shop_loop'    => 'Before Products',
            'woocommerce_after_shop_loop'     => 'After Products',
        );
        $options['wcz-wc-notice-banner-shop'] = array(
            'id'      => 'wcz-wc-notice-banner-shop',
            'label'   => __( 'Add to Shop & Archive pages', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'select',
            'choices' => $choices,
            'default' => 'none',
        );
        $options['wcz-wc-notice-banner-archives'] = array(
            'id'      => 'wcz-wc-notice-banner-archives',
            'label'   => __( 'Include Category & Archive pages', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $choices = array(
            'none'                                     => 'Off',
            'woocommerce_before_single_product'        => 'Top of Page',
            'woocommerce_single_product_summary'       => 'Above Product Summary',
            'woocommerce_before_add_to_cart_form'      => 'Before \'Add to Cart\'',
            'woocommerce_after_add_to_cart_form'       => 'After \'Add to Cart\'',
            'woocommerce_product_meta_end'             => 'After Product Meta',
            'woocommerce_after_single_product_summary' => 'After Single Product Summary',
            'woocommerce_after_single_product'         => 'Bottom of Page',
        );
        $options['wcz-wc-notice-banner-product'] = array(
            'id'      => 'wcz-wc-notice-banner-product',
            'label'   => __( 'Add to Product pages', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'select',
            'choices' => $choices,
            'default' => 'none',
        );
        $choices = array(
            'none'                            => 'Off',
            'woocommerce_before_cart'         => 'Above Cart',
            'woocommerce_after_cart_table'    => 'Below Cart',
            'woocommerce_proceed_to_checkout' => 'Before \'Proceed to Checkout\' button',
            'woocommerce_after_cart_totals'   => 'After \'Proceed to Checkout\' button',
            'woocommerce_after_cart'          => 'After Cart',
        );
        $options['wcz-wc-notice-banner-cart'] = array(
            'id'      => 'wcz-wc-notice-banner-cart',
            'label'   => __( 'Add to Cart page', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'select',
            'choices' => $choices,
            'default' => 'none',
        );
        $choices = array(
            'none'                                         => 'Off',
            'woocommerce_before_checkout_form'             => 'Top of Page',
            'woocommerce_checkout_before_customer_details' => 'Before Customer Details',
            'woocommerce_after_order_notes'                => 'After \'Order Notes\'',
            'woocommerce_checkout_after_customer_details'  => 'After Customer Details',
            'woocommerce_review_order_before_payment'      => 'Before Payment Options',
            'woocommerce_after_checkout_form'              => 'Bottom of Page',
        );
        $options['wcz-wc-notice-banner-checkout'] = array(
            'id'      => 'wcz-wc-notice-banner-checkout',
            'label'   => __( 'Add to Checkout page', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'select',
            'choices' => $choices,
            'default' => 'none',
        );
        $options['wcz-wc-notice-design'] = array(
            'id'      => 'wcz-wc-notice-design',
            'label'   => __( 'Edit Design', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $choices = array(
            'wcz-notice-one'   => 'Plain',
            'wcz-notice-two'   => 'Bordered',
            'wcz-notice-three' => 'Side Border',
            'wcz-notice-four'  => 'Solid Color',
        );
        $options['wcz-wc-notice-style'] = array(
            'id'      => 'wcz-wc-notice-style',
            'label'   => __( 'Design', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'select',
            'choices' => $choices,
            'default' => 'wcz-notice-one',
        );
        $wcz_rangeval = get_option( 'wcz-wc-notice-titlesize', 18 );
        $options['wcz-wc-notice-titlesize'] = array(
            'id'          => 'wcz-wc-notice-titlesize',
            'label'       => __( 'Title Size', 'woocustomizer' ),
            'section'     => $section,
            'type'        => 'range',
            'input_attrs' => array(
            'min'  => 12,
            'max'  => 34,
            'step' => 1,
        ),
            'description' => '<i>12</i> <span><b class="wcz-rangeval">' . esc_html( $wcz_rangeval ) . '</b>px</span> <i>34</i>',
            'default'     => 18,
        );
        $wcz_rangeval = get_option( 'wcz-wc-notice-textsize', 14 );
        $options['wcz-wc-notice-textsize'] = array(
            'id'          => 'wcz-wc-notice-textsize',
            'label'       => __( 'Text Size', 'woocustomizer' ),
            'section'     => $section,
            'type'        => 'range',
            'input_attrs' => array(
            'min'  => 11,
            'max'  => 26,
            'step' => 1,
        ),
            'description' => '<i>11</i> <span><b class="wcz-rangeval">' . esc_html( $wcz_rangeval ) . '</b>px</span> <i>26</i>',
            'default'     => 14,
        );
        $options['wcz-wc-notice-center'] = array(
            'id'      => 'wcz-wc-notice-center',
            'label'   => __( 'Center Align', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $options['wcz-wc-notice-color'] = array(
            'id'      => 'wcz-wc-notice-color',
            'label'   => __( 'Notice Color', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'color',
            'default' => '#2f79ff',
        );
        $wcz_rangeval = get_option( 'wcz-wc-notice-width', 100 );
        $options['wcz-wc-notice-width'] = array(
            'id'          => 'wcz-wc-notice-width',
            'label'       => __( 'Max Width', 'woocustomizer' ),
            'section'     => $section,
            'type'        => 'range',
            'input_attrs' => array(
            'min'  => 40,
            'max'  => 100,
            'step' => 1,
        ),
            'description' => '<i>30</i> <span><b class="wcz-rangeval">' . esc_html( $wcz_rangeval ) . '</b>%</span> <i>100</i>',
            'default'     => 100,
        );
        $wcz_rangeval = get_option( 'wcz-wc-notice-margin', 20 );
        $options['wcz-wc-notice-margin'] = array(
            'id'          => 'wcz-wc-notice-margin',
            'label'       => __( 'Bottom Margin', 'woocustomizer' ),
            'section'     => $section,
            'type'        => 'range',
            'input_attrs' => array(
            'min'  => 0,
            'max'  => 80,
            'step' => 1,
        ),
            'description' => '<i>0</i> <span><b class="wcz-rangeval">' . esc_html( $wcz_rangeval ) . '</b>px</span> <i>80</i>',
            'default'     => 20,
        );
        // ----------------------------------------------------------------------------------------------- StoreCustomizer Main Panel
        // ----------------------------------------------------------------------------------------------- WooCommerce Shop Page
        $section = 'wcz-panel-shop';
        $sections[] = array(
            'id'       => $section,
            'title'    => __( 'WooCommerce Shop Page', 'woocustomizer' ),
            'priority' => '10',
            'panel'    => $panel,
        );
        $options['wcz-shop-remove-breadcrumbs'] = array(
            'id'      => 'wcz-shop-remove-breadcrumbs',
            'label'   => __( 'Remove Shop Page Breadcrumbs', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $options['wcz-shop-remove-title'] = array(
            'id'      => 'wcz-shop-remove-title',
            'label'   => __( 'Remove Shop Title', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $options['wcz-shop-remove-sorting'] = array(
            'id'      => 'wcz-shop-remove-sorting',
            'label'   => __( 'Remove Shop Sorting Dropdown', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $options['wcz-shop-remove-result'] = array(
            'id'      => 'wcz-shop-remove-result',
            'label'   => __( 'Remove Shop Sorting Results', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $options['wcz-shop-edit-pp'] = array(
            'id'      => 'wcz-shop-edit-pp',
            'label'   => __( 'Turn off Editing Products per row/page', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $wcz_rangeval = get_option( 'wcz-shop-pppage', 12 );
        $options['wcz-shop-pppage'] = array(
            'id'          => 'wcz-shop-pppage',
            'label'       => __( 'Products Per Page', 'woocustomizer' ),
            'section'     => $section,
            'type'        => 'range',
            'input_attrs' => array(
            'min'  => 2,
            'max'  => 100,
            'step' => 1,
        ),
            'description' => '<i>2</i> <span><b class="wcz-rangeval">' . esc_html( $wcz_rangeval ) . '</b></span> <i>100</i>',
            'default'     => 12,
        );
        $options['wcz-shop-pprow'] = array(
            'id'          => 'wcz-shop-pprow',
            'label'       => __( 'Products Per Row', 'woocustomizer' ),
            'section'     => $section,
            'type'        => 'range',
            'input_attrs' => array(
            'min'  => 1,
            'max'  => 5,
            'step' => 1,
        ),
            'description' => __( '<i>1</i> <b>|</b> 2 <b>|</b> 3 <b>|</b> 4 <b>|</b> <i>5</i>', 'woocustomizer' ),
            'default'     => 4,
        );
        $options['wcz-shop-sale-txt'] = array(
            'id'      => 'wcz-shop-sale-txt',
            'label'   => __( 'Sale Banner Text', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'text',
            'default' => __( 'Sale!', 'woocustomizer' ),
        );
        $options['wcz-shop-add-soldout'] = array(
            'id'      => 'wcz-shop-add-soldout',
            'label'   => __( 'Add a banner to Sold Out products', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $choices = array(
            'wcz-soldout-style-plain' => 'Plain Text',
            'wcz-soldout-style-angle' => 'Angle Over Image',
        );
        $options['wcz-soldout-style'] = array(
            'id'      => 'wcz-soldout-style',
            'label'   => __( 'Sold Out Banner Style', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'select',
            'choices' => $choices,
            'default' => 'wcz-soldout-style-plain',
        );
        $options['wcz-shop-soldout-txt'] = array(
            'id'      => 'wcz-shop-soldout-txt',
            'label'   => __( 'Sold Out Banner Text', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'text',
            'default' => __( 'SOLD OUT', 'woocustomizer' ),
        );
        $options['wcz-shop-show-stock'] = array(
            'id'          => 'wcz-shop-show-stock',
            'label'       => __( 'Show stock amount for Users', 'woocustomizer' ),
            'section'     => $section,
            'type'        => 'checkbox',
            'description' => __( 'This uses the stock set at product level.<br /><br />Use "[no]" in the text to display the stock amount.', 'woocustomizer' ),
            'default'     => 0,
        );
        $options['wcz-shop-stock-lowamnt-txt'] = array(
            'id'          => 'wcz-shop-stock-lowamnt-txt',
            'label'       => __( 'Low Stock Amount Text', 'woocustomizer' ),
            'section'     => $section,
            'type'        => 'text',
            'description' => __( 'If the product stock is 3 or less', 'woocustomizer' ),
            'default'     => __( 'Only [no] left in stock!', 'woocustomizer' ),
        );
        $options['wcz-shop-stock-amnt-txt'] = array(
            'id'      => 'wcz-shop-stock-amnt-txt',
            'label'   => __( 'Stock Amount Text', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'text',
            'default' => __( '[no] left in stock!', 'woocustomizer' ),
        );
        $options['wcz-shop-edit-btns'] = array(
            'id'      => 'wcz-shop-edit-btns',
            'label'   => __( 'Edit Shop Button Texts', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $options['wcz-shoplist-button-txt-simple'] = array(
            'id'      => 'wcz-shoplist-button-txt-simple',
            'label'   => __( 'Simple Product Button Text', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'text',
            'default' => __( 'Add to cart', 'woocustomizer' ),
        );
        $options['wcz-shop-button-txt-variable'] = array(
            'id'      => 'wcz-shop-button-txt-variable',
            'label'   => __( 'Variable Product Button Text', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'text',
            'default' => __( 'Select Options', 'woocustomizer' ),
        );
        $options['wcz-shop-button-txt-grouped'] = array(
            'id'      => 'wcz-shop-button-txt-grouped',
            'label'   => __( 'Grouped Product Button Text', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'text',
            'default' => __( 'View products', 'woocustomizer' ),
        );
        // New badge for recent products
        $options['wcz-shop-new-badge'] = array(
            'id'      => 'wcz-shop-new-badge',
            'label'   => __( 'Add a "New" badge for recently added products', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $options['wcz-shop-new-product-days'] = array(
            'id'          => 'wcz-shop-new-product-days',
            'label'       => __( 'Days to determine if product is "New"', 'woocustomizer' ),
            'section'     => $section,
            'type'        => 'number',
            'description' => __( 'The "New" badge will only display on products where the "Published On" date is less that the number of days specified here.', 'woocustomizer' ),
            'default'     => 7,
        );
        $options['wcz-shop-new-product-badge-text'] = array(
            'id'      => 'wcz-shop-new-product-badge-text',
            'label'   => __( 'New Product Badge Text', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'text',
            'default' => __( 'New Product', 'woocustomizer' ),
        );
        $choices = array(
            'topleft'    => 'Top Left',
            'topright'   => 'Top Right',
            'abovetitle' => 'Above Product Title',
            'belowtitle' => 'Below Product Title',
        );
        $options['wcz-shop-new-badge-pos'] = array(
            'id'      => 'wcz-shop-new-badge-pos',
            'label'   => __( 'Badge Position', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'select',
            'choices' => $choices,
            'default' => 'topleft',
        );
        $options['wcz-shop-new-badge-color'] = array(
            'id'      => 'wcz-shop-new-badge-color',
            'label'   => __( 'Badge Color', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'color',
            'default' => '#2f79ff',
        );
        // Archives Settings
        $options['wcz-heading-archives'] = array(
            'id'      => 'wcz-heading-archives',
            'label'   => __( 'Shop Archive / Categories Pages', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'url',
        );
        $options['wcz-shop-remove-catcount'] = array(
            'id'      => 'wcz-shop-remove-catcount',
            'label'   => __( 'Remove Category Count', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $options['wcz-shop-archives-remove-breadcrumbs'] = array(
            'id'      => 'wcz-shop-archives-remove-breadcrumbs',
            'label'   => __( 'Remove Shop Archive Breadcrumbs', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $options['wcz-shop-archives-remove-title'] = array(
            'id'      => 'wcz-shop-archives-remove-title',
            'label'   => __( 'Remove Archives Title', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        // -------------------------------- Shop Design Settings
        $options['wcz-heading-wcc-btn'] = array(
            'id'          => 'wcz-heading-wcc-btn',
            'label'       => __( 'Design Elements', 'woocustomizer' ),
            'section'     => $section,
            'type'        => 'url',
            'description' => __( 'Depending on your theme, these design settings might not always work. If not, please contact us to help get these working with your theme.', 'woocustomizer' ),
        );
        // Customize - Button
        $options['wcz-wc-edit-btns'] = array(
            'id'      => 'wcz-wc-edit-btns',
            'label'   => __( 'Customize Store Button(s) Design', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $choices = array(
            'wcz-btn-style-default'  => 'Theme Style / Default',
            'wcz-btn-style-plain'    => 'Plain',
            'wcz-btn-style-detailed' => 'Detailed',
        );
        $options['wcz-btn-style'] = array(
            'id'      => 'wcz-btn-style',
            'label'   => __( 'Button Style', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'select',
            'choices' => $choices,
            'default' => 'wcz-btn-style-default',
        );
        $wcz_bfsval = get_option( 'wcz-btn-fsize', 16 );
        $options['wcz-btn-fsize'] = array(
            'id'          => 'wcz-btn-fsize',
            'label'       => __( 'Font Size', 'woocustomizer' ),
            'section'     => $section,
            'type'        => 'range',
            'input_attrs' => array(
            'min'  => 10,
            'max'  => 34,
            'step' => 1,
        ),
            'description' => '<i>10</i> <span><b class="wcz-rangeval">' . esc_html( $wcz_bfsval ) . '</b></span> <i>34</i>',
            'default'     => 16,
        );
        $options['wcz-btn-fweight'] = array(
            'id'      => 'wcz-btn-fweight',
            'label'   => __( 'Bold', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $options['wcz-btn-bgcolor'] = array(
            'id'      => 'wcz-btn-bgcolor',
            'label'   => __( 'Button Color', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'color',
            'default' => '#e8e8e8',
        );
        $options['wcz-btn-fontcolor'] = array(
            'id'      => 'wcz-btn-fontcolor',
            'label'   => __( 'Button Font Color', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'color',
            'default' => '#000',
        );
        $options['wcz-btn-hovercolor'] = array(
            'id'      => 'wcz-btn-hovercolor',
            'label'   => __( 'Button Hover Color', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'color',
            'default' => '#757575',
        );
        $options['wcz-btn-fonthovercolor'] = array(
            'id'      => 'wcz-btn-fonthovercolor',
            'label'   => __( 'Button Font Hover Color', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'color',
            'default' => '#000',
        );
        $wcz_bbrval = get_option( 'wcz-btn-br', 3 );
        $options['wcz-btn-br'] = array(
            'id'          => 'wcz-btn-br',
            'label'       => __( 'Border Radius', 'woocustomizer' ),
            'section'     => $section,
            'type'        => 'range',
            'input_attrs' => array(
            'min'  => 0,
            'max'  => 50,
            'step' => 1,
        ),
            'description' => '<i>0</i> <span><b class="wcz-rangeval">' . esc_html( $wcz_bbrval ) . '</b></span> <i>50</i>',
            'default'     => 3,
        );
        $wcz_bpval = get_option( 'wcz-btn-padding', 10 );
        $options['wcz-btn-padding'] = array(
            'id'          => 'wcz-btn-padding',
            'label'       => __( 'Padding', 'woocustomizer' ),
            'section'     => $section,
            'type'        => 'range',
            'input_attrs' => array(
            'min'  => 5,
            'max'  => 40,
            'step' => 1,
        ),
            'description' => '<i>5</i> <span><b class="wcz-rangeval">' . esc_html( $wcz_bpval ) . '</b></span> <i>40</i>',
            'default'     => 10,
        );
        // Customize - Sale Banner
        $options['wcz-wc-edit-sale'] = array(
            'id'      => 'wcz-wc-edit-sale',
            'label'   => __( 'Customize Sale Banner', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $wcz_sfsval = get_option( 'wcz-sale-fsize', 15 );
        $options['wcz-sale-fsize'] = array(
            'id'          => 'wcz-sale-fsize',
            'label'       => __( 'Font Size', 'woocustomizer' ),
            'section'     => $section,
            'type'        => 'range',
            'input_attrs' => array(
            'min'  => 10,
            'max'  => 32,
            'step' => 1,
        ),
            'description' => '<i>10</i> <span><b class="wcz-rangeval">' . esc_html( $wcz_sfsval ) . '</b></span> <i>32</i>',
            'default'     => 15,
        );
        $options['wcz-sale-fweight'] = array(
            'id'      => 'wcz-sale-fweight',
            'label'   => __( 'Bold', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $options['wcz-sale-bgcolor'] = array(
            'id'      => 'wcz-sale-bgcolor',
            'label'   => __( 'Sale Banner Color', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'color',
            'default' => '#e8e8e8',
        );
        $wcz_sbbrval = get_option( 'wcz-sale-br', 3 );
        $options['wcz-sale-br'] = array(
            'id'          => 'wcz-sale-br',
            'label'       => __( 'Border Radius', 'woocustomizer' ),
            'section'     => $section,
            'type'        => 'range',
            'input_attrs' => array(
            'min'  => 0,
            'max'  => 20,
            'step' => 1,
        ),
            'description' => '<i>0</i> <span><b class="wcz-rangeval">' . esc_html( $wcz_sbbrval ) . '</b></span> <i>20</i>',
            'default'     => 3,
        );
        $wcz_sbpval = get_option( 'wcz-sale-padding', 5 );
        $options['wcz-sale-padding'] = array(
            'id'          => 'wcz-sale-padding',
            'label'       => __( 'Padding', 'woocustomizer' ),
            'section'     => $section,
            'type'        => 'range',
            'input_attrs' => array(
            'min'  => 2,
            'max'  => 20,
            'step' => 1,
        ),
            'description' => '<i>2</i> <span><b class="wcz-rangeval">' . esc_html( $wcz_sbpval ) . '</b></span> <i>20</i>',
            'default'     => 5,
        );
        // Customize - Product Title
        $options['wcz-wc-edit-shop-title'] = array(
            'id'      => 'wcz-wc-edit-shop-title',
            'label'   => __( 'Customize Product Title', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $wcz_sfsval = get_option( 'wcz-shop-title-fsize', 16 );
        $options['wcz-shop-title-fsize'] = array(
            'id'          => 'wcz-shop-title-fsize',
            'label'       => __( 'Font Size', 'woocustomizer' ),
            'section'     => $section,
            'type'        => 'range',
            'input_attrs' => array(
            'min'  => 10,
            'max'  => 38,
            'step' => 1,
        ),
            'description' => '<i>10</i> <span><b class="wcz-rangeval">' . esc_html( $wcz_sfsval ) . '</b></span> <i>38</i>',
            'default'     => 16,
        );
        $options['wcz-shop-title-fcolor'] = array(
            'id'      => 'wcz-shop-title-fcolor',
            'label'   => __( 'Font Color', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'color',
            'default' => '#444',
        );
        // Customize - Product Price
        $options['wcz-wc-edit-shop-price'] = array(
            'id'      => 'wcz-wc-edit-shop-price',
            'label'   => __( 'Customize Product Price', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $wcz_sfsval = get_option( 'wcz-shop-price-fsize', 14 );
        $options['wcz-shop-price-fsize'] = array(
            'id'          => 'wcz-shop-price-fsize',
            'label'       => __( 'Font Size', 'woocustomizer' ),
            'section'     => $section,
            'type'        => 'range',
            'input_attrs' => array(
            'min'  => 10,
            'max'  => 34,
            'step' => 1,
        ),
            'description' => '<i>10</i> <span><b class="wcz-rangeval">' . esc_html( $wcz_sfsval ) . '</b></span> <i>34</i>',
            'default'     => 14,
        );
        $options['wcz-shop-price-fcolor'] = array(
            'id'      => 'wcz-shop-price-fcolor',
            'label'   => __( 'Font Color', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'color',
            'default' => '#222',
        );
        // -------------------------------- Shop Design Settings
        // Customize - Apply to Gutenberg Blocks
        $options['wcz-wc-edit-applyto-blocks'] = array(
            'id'      => 'wcz-wc-edit-applyto-blocks',
            'label'   => __( 'Apply these design settings to WooCommerce Blocks for Gutenberg', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        // ----------------------------------------------------------------------------------------------- WooCommerce Shop Page
        // ----------------------------------------------------------------------------------------------- WooCommerce Product Page
        $section = 'wcz-panel-product';
        $sections[] = array(
            'id'       => $section,
            'title'    => __( 'WooCommerce Product Page', 'woocustomizer' ),
            'priority' => '10',
            'panel'    => $panel,
        );
        $options['wcz-remove-product-breadcrumbs'] = array(
            'id'      => 'wcz-remove-product-breadcrumbs',
            'label'   => __( 'Remove Product Breadcrumbs', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $options['wcz-remove-product-zoom'] = array(
            'id'      => 'wcz-remove-product-zoom',
            'label'   => __( 'Remove Image Zoom', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $options['wcz-remove-product-lightbox'] = array(
            'id'      => 'wcz-remove-product-lightbox',
            'label'   => __( 'Remove Image Lightbox', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $options['wcz-remove-product-slider'] = array(
            'id'      => 'wcz-remove-product-slider',
            'label'   => __( 'Remove Image Slider', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $options['wcz-product-imggal-ppr'] = array(
            'id'          => 'wcz-product-imggal-ppr',
            'label'       => __( 'Product Image Thumbnails Per Row', 'woocustomizer' ),
            'section'     => $section,
            'type'        => 'range',
            'input_attrs' => array(
            'min'  => 2,
            'max'  => 5,
            'step' => 1,
        ),
            'description' => __( '<i>2</i> <b>|</b> 3 <b>|</b> 4 <b>|</b> <i>5</i>', 'woocustomizer' ),
            'default'     => 4,
        );
        $options['wcz-product-sale-txt'] = array(
            'id'      => 'wcz-product-sale-txt',
            'label'   => __( 'Sale Banner Text', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'text',
            'default' => __( 'Sale!', 'woocustomizer' ),
        );
        $options['wcz-remove-product-title'] = array(
            'id'      => 'wcz-remove-product-title',
            'label'   => __( 'Remove Product Title', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $options['wcz-add-price-prefix'] = array(
            'id'          => 'wcz-add-price-prefix',
            'label'       => __( 'Add a default Price Prefix', 'woocustomizer' ),
            'section'     => $section,
            'type'        => 'checkbox',
            'description' => __( 'Edit the prefix per product under Product Data -> StoreCustomizer on each product.<br /><br />To add a prefix to only certain products, simply add nothing here (and save), then edit the prefix setting on each product.', 'woocustomizer' ),
            'default'     => 0,
        );
        $options['wcz-add-price-prefix-txt'] = array(
            'id'      => 'wcz-add-price-prefix-txt',
            'label'   => __( 'Product Price Prefix Text', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'text',
            'default' => __( 'From:', 'woocustomizer' ),
        );
        $options['wcz-add-price-prefix-shop'] = array(
            'id'          => 'wcz-add-price-prefix-shop',
            'label'       => __( 'Add the prefix to Product Shop page', 'woocustomizer' ),
            'section'     => $section,
            'type'        => 'checkbox',
            'description' => __( 'Add the prefix to the product list and category pages too.', 'woocustomizer' ),
            'default'     => 0,
        );
        $options['wcz-add-price-suffix'] = array(
            'id'          => 'wcz-add-price-suffix',
            'label'       => __( 'Add a default Price Suffix', 'woocustomizer' ),
            'section'     => $section,
            'type'        => 'checkbox',
            'description' => __( 'Edit the suffix per product under Product Data -> StoreCustomizer on each product.<br /><br />To add a suffix to only certain products, simply add nothing here (and save), then edit the suffix setting on each product.', 'woocustomizer' ),
            'default'     => 0,
        );
        $options['wcz-add-price-suffix-txt'] = array(
            'id'      => 'wcz-add-price-suffix-txt',
            'label'   => __( 'Product Price Suffix Text', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'text',
            'default' => __( 'Incl. VAT', 'woocustomizer' ),
        );
        $options['wcz-add-price-suffix-shop'] = array(
            'id'          => 'wcz-add-price-suffix-shop',
            'label'       => __( 'Add the suffix to Product Shop page', 'woocustomizer' ),
            'section'     => $section,
            'type'        => 'checkbox',
            'description' => __( 'Add the suffix to the product list and category pages too.', 'woocustomizer' ),
            'default'     => 0,
        );
        $options['wcz-product-edit-btn'] = array(
            'id'      => 'wcz-product-edit-btn',
            'label'   => __( 'Edit Product Button Text', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $options['wcz-product-button-txt-simple'] = array(
            'id'      => 'wcz-product-button-txt-simple',
            'label'   => __( 'Product Button Text', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'text',
            'default' => __( 'Add to cart', 'woocustomizer' ),
        );
        $options['wcz-remove-product-sku'] = array(
            'id'      => 'wcz-remove-product-sku',
            'label'   => __( 'Remove SKU', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $options['wcz-remove-product-cats'] = array(
            'id'      => 'wcz-remove-product-cats',
            'label'   => __( 'Remove Product Categories', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $options['wcz-remove-product-tags'] = array(
            'id'      => 'wcz-remove-product-tags',
            'label'   => __( 'Remove Product Tags', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $options['wcz-product-show-unitsold'] = array(
            'id'      => 'wcz-product-show-unitsold',
            'label'   => __( 'Show Amount Sold', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $options['wcz-product-unitsold-txt'] = array(
            'id'          => 'wcz-product-unitsold-txt',
            'label'       => __( 'Amount Sold Text', 'woocustomizer' ),
            'section'     => $section,
            'type'        => 'text',
            'description' => __( 'Use "[no]" in the text to display the amount sold.', 'woocustomizer' ),
            'default'     => __( 'Items Sold: [no]', 'woocustomizer' ),
        );
        $options['wcz-add-shop-button'] = array(
            'id'      => 'wcz-add-shop-button',
            'label'   => __( 'Add button to \'Continue Shopping\'', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $options['wcz-add-shop-button-txt'] = array(
            'id'          => 'wcz-add-shop-button-txt',
            'label'       => __( 'Continue Shopping Text', 'woocustomizer' ),
            'section'     => $section,
            'type'        => 'text',
            'description' => __( 'You can set custom button text and urls per product under Edit Product-> Product Data-> StoreCustomizer', 'woocustomizer' ),
            'default'     => __( 'Continue Shopping', 'woocustomizer' ),
        );
        $options['wcz-add-shop-button-url'] = array(
            'id'          => 'wcz-add-shop-button-url',
            'label'       => __( 'Continue Shopping URL', 'woocustomizer' ),
            'section'     => $section,
            'type'        => 'url',
            'description' => __( 'If not set, this will default to the shop page.<br />Enter the full url, including \'https://\'', 'woocustomizer' ),
            'default'     => '',
        );
        $options['wcz-product-variable-ddo'] = array(
            'id'      => 'wcz-product-variable-ddo',
            'label'   => __( 'Edit Variable Product dropdown label', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $options['wcz-product-variable-ddo-txt'] = array(
            'id'      => 'wcz-product-variable-ddo-txt',
            'label'   => __( 'Default Label', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'text',
            'default' => __( 'Choose an option', 'woocustomizer' ),
        );
        // PRO VERSION ONLY
        $options['wcz-set-cart-increment-vals'] = array(
            'id'      => 'wcz-set-cart-increment-vals',
            'label'   => __( 'Set \'Add To Cart\' Increment values', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $options['wcz-set-cart-inc-min'] = array(
            'id'      => 'wcz-set-cart-inc-min',
            'label'   => __( 'Minimum Value Allowed', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'number',
            'default' => 3,
        );
        $options['wcz-set-cart-inc-max'] = array(
            'id'      => 'wcz-set-cart-inc-max',
            'label'   => __( 'Maximum Value Allowed', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'number',
            'default' => 10,
        );
        $options['wcz-set-cart-inc-by'] = array(
            'id'      => 'wcz-set-cart-inc-by',
            'label'   => __( 'Increment / Decrement By', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'number',
            'default' => 1,
        );
        // Adjust Simple Product Stock Status Text - Get Working with Variable Products !
        $options['wcz-edit-stockstatus'] = array(
            'id'          => 'wcz-edit-stockstatus',
            'label'       => __( 'Edit Stock Status Texts', 'woocustomizer' ),
            'section'     => $section,
            'type'        => 'checkbox',
            'description' => __( 'Currently only available for Simple Products.', 'woocustomizer' ),
            'default'     => 0,
        );
        $options['wcz-product-outofstock-txt'] = array(
            'id'      => 'wcz-product-outofstock-txt',
            'label'   => __( 'Out Of Stock Text', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'text',
            'default' => __( 'Out Of Stock', 'woocustomizer' ),
        );
        $options['wcz-product-instock-txt'] = array(
            'id'          => 'wcz-product-instock-txt',
            'label'       => __( 'In Stock Text', 'woocustomizer' ),
            'section'     => $section,
            'type'        => 'text',
            'description' => __( 'Managing stock at a product level, you can display the stock amount here by using "[no]" in the text to display the amount, or simply add your own text.', 'woocustomizer' ),
            'default'     => __( 'Stock Available', 'woocustomizer' ),
        );
        $options['wcz-product-onbackorder-txt'] = array(
            'id'      => 'wcz-product-onbackorder-txt',
            'label'   => __( 'On Back Order Text', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'text',
            'default' => __( 'On Back Order', 'woocustomizer' ),
        );
        $options['wcz-always-show-stockstatus'] = array(
            'id'      => 'wcz-always-show-stockstatus',
            'label'   => __( 'Always Show Stock Status Types', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $options['wcz-product-instock-deaf-txt'] = array(
            'id'          => 'wcz-product-instock-deaf-txt',
            'label'       => __( 'Stock Text', 'woocustomizer' ),
            'section'     => $section,
            'type'        => 'text',
            'description' => __( 'If not managing stock at a product level, by default nothing shows. Add default \'In Stock\' text if you want to show the product is in stock.', 'woocustomizer' ),
            'default'     => __( 'In Stock', 'woocustomizer' ),
        );
        // Sticky Add to Cart
        $options['wcz-heading-stickcart'] = array(
            'id'      => 'wcz-heading-stickcart',
            'label'   => __( 'Sticky \'Add to Cart\'', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'url',
        );
        $options['wcz-stickcart-free-note'] = array(
            'id'          => 'wcz-stickcart-free-note',
            'section'     => $section,
            'type'        => 'url',
            'description' => sprintf( __( '%1$s offers a sticky \'Add to Cart\' banner for the WooCommerce Product page.<br /><br />The Add to Cart banner slides into view once the standard add-to-cart button has scrolled out of view.', 'woocustomizer' ), '<a href="' . esc_url( admin_url( 'admin.php?billing_cycle=annual&page=wcz_settings-pricing' ) ) . '" target="_blank">StoreCustomizer Pro</a>' ),
        );
        // Product Settings - Tabs
        $options['wcz-heading-product-tabs'] = array(
            'id'      => 'wcz-heading-product-tabs',
            'label'   => __( 'Product Page Tabs', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'url',
        );
        $choices = array(
            'reset'                         => '',
            'wcz-wcproduct-desc-tab-edit'   => 'Edit Tab Text',
            'wcz-wcproduct-desc-tab-remove' => 'Remove Tab',
        );
        $options['wcz-wcproduct-desc-tab'] = array(
            'id'      => 'wcz-wcproduct-desc-tab',
            'label'   => __( 'Description Tab', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'radio',
            'choices' => $choices,
            'default' => '',
        );
        $options['wcz-wcproduct-desc-tab-title'] = array(
            'id'      => 'wcz-wcproduct-desc-tab-title',
            'label'   => __( 'Tab Title', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'text',
            'default' => __( 'Description', 'woocustomizer' ),
        );
        $options['wcz-wcproduct-desc-head'] = array(
            'id'      => 'wcz-wcproduct-desc-head',
            'label'   => __( 'Tab Heading', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'text',
            'default' => __( 'Description', 'woocustomizer' ),
        );
        // Edit/Remove Description Tab
        $choices = array(
            'reset'                            => '',
            'wcz-wcproduct-addinfo-tab-edit'   => 'Edit Tab Text',
            'wcz-wcproduct-addinfo-tab-remove' => 'Remove Tab',
        );
        $options['wcz-wcproduct-addinfo-tab'] = array(
            'id'      => 'wcz-wcproduct-addinfo-tab',
            'label'   => __( 'Additional Info Tab', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'radio',
            'choices' => $choices,
            'default' => '',
        );
        $options['wcz-wcproduct-addinfo-tab-title'] = array(
            'id'      => 'wcz-wcproduct-addinfo-tab-title',
            'label'   => __( 'Tab Title', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'text',
            'default' => __( 'Additional Information', 'woocustomizer' ),
        );
        $options['wcz-wcproduct-addinfo-head'] = array(
            'id'      => 'wcz-wcproduct-addinfo-head',
            'label'   => __( 'Tab Heading', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'text',
            'default' => __( 'Additional Information', 'woocustomizer' ),
        );
        // Edit/Remove Additional Info Tab
        $choices = array(
            'reset'                            => '',
            'wcz-wcproduct-reviews-tab-edit'   => 'Edit Tab Text',
            'wcz-wcproduct-reviews-tab-remove' => 'Remove Tab',
        );
        $options['wcz-wcproduct-reviews-tab'] = array(
            'id'      => 'wcz-wcproduct-reviews-tab',
            'label'   => __( 'Reviews Tab', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'radio',
            'choices' => $choices,
            'default' => '',
        );
        $options['wcz-wcproduct-reviews-tab-title'] = array(
            'id'      => 'wcz-wcproduct-reviews-tab-title',
            'label'   => __( 'Tab Title', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'text',
            'default' => __( 'Reviews', 'woocustomizer' ),
        );
        // Edit/Remove Reviews Tab
        // Move Product Description below tabs
        $options['wcz-add-product-long-desc'] = array(
            'id'      => 'wcz-add-product-long-desc',
            'label'   => __( 'Add Product Long Description after Tabs', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $choices = array(
            'none'  => 'None',
            'one'   => 'Solid Line',
            'two'   => 'Dashed Line',
            'three' => 'Short Line',
        );
        $options['wcz-longdesc-divider'] = array(
            'id'      => 'wcz-longdesc-divider',
            'label'   => __( 'Divider Style', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'select',
            'choices' => $choices,
            'default' => 'none',
        );
        $options['wcz-longdesc-maxwidth'] = array(
            'id'      => 'wcz-longdesc-maxwidth',
            'label'   => __( 'Max-Width for this section', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'number',
            'default' => '',
        );
        $options['wcz-longdesc-center'] = array(
            'id'      => 'wcz-longdesc-center',
            'label'   => __( 'Center Align Text', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $wcz_ldtsval = get_option( 'wcz-longdesc-top', 35 );
        $options['wcz-longdesc-top'] = array(
            'id'          => 'wcz-longdesc-top',
            'label'       => __( 'Top Spacing', 'woocustomizer' ),
            'section'     => $section,
            'type'        => 'range',
            'input_attrs' => array(
            'min'  => 10,
            'max'  => 200,
            'step' => 1,
        ),
            'description' => '<i>10</i> <span><b class="wcz-rangeval">' . esc_html( $wcz_ldtsval ) . '</b></span> <i>200</i>',
            'default'     => 35,
        );
        $wcz_ldbsval = get_option( 'wcz-longdesc-bottom', 35 );
        $options['wcz-longdesc-bottom'] = array(
            'id'          => 'wcz-longdesc-bottom',
            'label'       => __( 'Bottom Spacing', 'woocustomizer' ),
            'section'     => $section,
            'type'        => 'range',
            'input_attrs' => array(
            'min'  => 10,
            'max'  => 200,
            'step' => 1,
        ),
            'description' => '<i>10</i> <span><b class="wcz-rangeval">' . esc_html( $wcz_ldbsval ) . '</b></span> <i>200</i>',
            'default'     => 35,
        );
        $options['wcz-longdesc-botdiv'] = array(
            'id'      => 'wcz-longdesc-botdiv',
            'label'   => __( 'Add Bottom Divider', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        // Move Product Additional Info below tabs
        $options['wcz-add-product-addinfo'] = array(
            'id'      => 'wcz-add-product-addinfo',
            'label'   => __( 'Add Product Additional Info after Tabs', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $choices = array(
            'none'  => 'None',
            'one'   => 'Solid Line',
            'two'   => 'Dashed Line',
            'three' => 'Short Line',
        );
        $options['wcz-addinfo-divider'] = array(
            'id'      => 'wcz-addinfo-divider',
            'label'   => __( 'Divider Style', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'select',
            'choices' => $choices,
            'default' => 'none',
        );
        $options['wcz-addinfo-maxwidth'] = array(
            'id'      => 'wcz-addinfo-maxwidth',
            'label'   => __( 'Max-Width for this section', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'number',
            'default' => '',
        );
        $wcz_ldtsval = get_option( 'wcz-addinfo-top', 35 );
        $options['wcz-addinfo-top'] = array(
            'id'          => 'wcz-addinfo-top',
            'label'       => __( 'Top Spacing', 'woocustomizer' ),
            'section'     => $section,
            'type'        => 'range',
            'input_attrs' => array(
            'min'  => 10,
            'max'  => 200,
            'step' => 1,
        ),
            'description' => '<i>10</i> <span><b class="wcz-rangeval">' . esc_html( $wcz_ldtsval ) . '</b></span> <i>200</i>',
            'default'     => 35,
        );
        $wcz_ldbsval = get_option( 'wcz-addinfo-bottom', 35 );
        $options['wcz-addinfo-bottom'] = array(
            'id'          => 'wcz-addinfo-bottom',
            'label'       => __( 'Bottom Spacing', 'woocustomizer' ),
            'section'     => $section,
            'type'        => 'range',
            'input_attrs' => array(
            'min'  => 10,
            'max'  => 200,
            'step' => 1,
        ),
            'description' => '<i>10</i> <span><b class="wcz-rangeval">' . esc_html( $wcz_ldbsval ) . '</b></span> <i>200</i>',
            'default'     => 35,
        );
        $options['wcz-addinfo-botdiv'] = array(
            'id'      => 'wcz-addinfo-botdiv',
            'label'   => __( 'Add Bottom Divider', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        // Move Product Reviews below tabs
        $options['wcz-add-product-reviews'] = array(
            'id'      => 'wcz-add-product-reviews',
            'label'   => __( 'Add Product Reviews after Tabs', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $choices = array(
            'none'  => 'None',
            'one'   => 'Solid Line',
            'two'   => 'Dashed Line',
            'three' => 'Short Line',
        );
        $options['wcz-reviews-divider'] = array(
            'id'      => 'wcz-reviews-divider',
            'label'   => __( 'Divider Style', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'select',
            'choices' => $choices,
            'default' => 'none',
        );
        $options['wcz-reviews-maxwidth'] = array(
            'id'      => 'wcz-reviews-maxwidth',
            'label'   => __( 'Max-Width for this section', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'number',
            'default' => '',
        );
        $wcz_ldtsval = get_option( 'wcz-reviews-top', 35 );
        $options['wcz-reviews-top'] = array(
            'id'          => 'wcz-reviews-top',
            'label'       => __( 'Top Spacing', 'woocustomizer' ),
            'section'     => $section,
            'type'        => 'range',
            'input_attrs' => array(
            'min'  => 10,
            'max'  => 200,
            'step' => 1,
        ),
            'description' => '<i>10</i> <span><b class="wcz-rangeval">' . esc_html( $wcz_ldtsval ) . '</b></span> <i>200</i>',
            'default'     => 35,
        );
        $wcz_ldbsval = get_option( 'wcz-reviews-bottom', 35 );
        $options['wcz-reviews-bottom'] = array(
            'id'          => 'wcz-reviews-bottom',
            'label'       => __( 'Bottom Spacing', 'woocustomizer' ),
            'section'     => $section,
            'type'        => 'range',
            'input_attrs' => array(
            'min'  => 10,
            'max'  => 200,
            'step' => 1,
        ),
            'description' => '<i>10</i> <span><b class="wcz-rangeval">' . esc_html( $wcz_ldbsval ) . '</b></span> <i>200</i>',
            'default'     => 35,
        );
        $options['wcz-reviews-botdiv'] = array(
            'id'      => 'wcz-reviews-botdiv',
            'label'   => __( 'Add Bottom Divider', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        // Product Settings - Related & Recommended
        $options['wcz-heading-product-relrec'] = array(
            'id'      => 'wcz-heading-product-relrec',
            'label'   => __( 'Related & Recommended Products', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'url',
        );
        $choices = array(
            'reset'                       => '',
            'wcz-wcproduct-recomm-edit'   => 'Edit Title',
            'wcz-wcproduct-recomm-remove' => 'Remove Section',
        );
        $options['wcz-wcproduct-recomm'] = array(
            'id'      => 'wcz-wcproduct-recomm',
            'label'   => __( 'Product Recommendations', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'radio',
            'choices' => $choices,
            'default' => '',
        );
        $options['wcz-wcproduct-recomm-title'] = array(
            'id'      => 'wcz-wcproduct-recomm-title',
            'label'   => __( 'Recommendations Title', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'text',
            'default' => __( 'You may also like&hellip;', 'woocustomizer' ),
        );
        // Edit/Remove Product Recommedations
        $options['wcz-product-recomm-ppr'] = array(
            'id'          => 'wcz-product-recomm-ppr',
            'label'       => __( 'Products Per Row', 'woocustomizer' ),
            'section'     => $section,
            'type'        => 'range',
            'input_attrs' => array(
            'min'  => 2,
            'max'  => 5,
            'step' => 1,
        ),
            'description' => __( '<i>2</i> <b>|</b> 3 <b>|</b> 4 <b>|</b> <i>5</i>', 'woocustomizer' ),
            'default'     => 3,
        );
        $options['wcz-product-recomm-ppr-no'] = array(
            'id'      => 'wcz-product-recomm-ppr-no',
            'label'   => __( 'Amount of products to show', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'number',
            'default' => '',
        );
        $choices = array(
            'reset'                        => '',
            'wcz-wcproduct-related-edit'   => 'Edit Title',
            'wcz-wcproduct-related-remove' => 'Remove Section',
        );
        $options['wcz-wcproduct-related'] = array(
            'id'      => 'wcz-wcproduct-related',
            'label'   => __( 'Related Products', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'radio',
            'choices' => $choices,
            'default' => '',
        );
        $options['wcz-wcproduct-related-title'] = array(
            'id'      => 'wcz-wcproduct-related-title',
            'label'   => __( 'Related Products Title', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'text',
            'default' => __( 'Related products', 'woocustomizer' ),
        );
        // Edit/Remove Related Products
        $options['wcz-product-related-ppr'] = array(
            'id'          => 'wcz-product-related-ppr',
            'label'       => __( 'Products Per Row', 'woocustomizer' ),
            'section'     => $section,
            'type'        => 'range',
            'input_attrs' => array(
            'min'  => 2,
            'max'  => 5,
            'step' => 1,
        ),
            'description' => __( '<i>2</i> <b>|</b> 3 <b>|</b> 4 <b>|</b> <i>5</i>', 'woocustomizer' ),
            'default'     => 3,
        );
        $options['wcz-product-related-ppr-no'] = array(
            'id'      => 'wcz-product-related-ppr-no',
            'label'   => __( 'Amount of products to show', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'number',
            'default' => '',
        );
        // -------------------------------- Product Page Design Settings
        $options['wcz-heading-wcc-prod'] = array(
            'id'          => 'wcz-heading-wcc-prod',
            'label'       => __( 'Design Elements', 'woocustomizer' ),
            'section'     => $section,
            'type'        => 'url',
            'description' => __( 'Depending on your theme, these design settings might not always work. If not, please contact us to help get these working with your theme.', 'woocustomizer' ),
        );
        // Customize - Product Title
        $options['wcz-wc-edit-product-title'] = array(
            'id'      => 'wcz-wc-edit-product-title',
            'label'   => __( 'Customize Product Title', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $wcz_sfsval = get_option( 'wcz-product-title-fsize', 34 );
        $options['wcz-product-title-fsize'] = array(
            'id'          => 'wcz-product-title-fsize',
            'label'       => __( 'Font Size', 'woocustomizer' ),
            'section'     => $section,
            'type'        => 'range',
            'input_attrs' => array(
            'min'  => 12,
            'max'  => 48,
            'step' => 1,
        ),
            'description' => '<i>10</i> <span><b class="wcz-rangeval">' . esc_html( $wcz_sfsval ) . '</b></span> <i>48</i>',
            'default'     => 34,
        );
        $options['wcz-product-title-fcolor'] = array(
            'id'      => 'wcz-product-title-fcolor',
            'label'   => __( 'Font Color', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'color',
            'default' => '#444',
        );
        // Customize - Product Price
        $options['wcz-wc-edit-product-price'] = array(
            'id'      => 'wcz-wc-edit-product-price',
            'label'   => __( 'Customize Product Price', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $wcz_sfsval = get_option( 'wcz-product-price-fsize', 18 );
        $options['wcz-product-price-fsize'] = array(
            'id'          => 'wcz-product-price-fsize',
            'label'       => __( 'Font Size', 'woocustomizer' ),
            'section'     => $section,
            'type'        => 'range',
            'input_attrs' => array(
            'min'  => 11,
            'max'  => 44,
            'step' => 1,
        ),
            'description' => '<i>11</i> <span><b class="wcz-rangeval">' . esc_html( $wcz_sfsval ) . '</b></span> <i>44</i>',
            'default'     => 18,
        );
        $options['wcz-product-price-fcolor'] = array(
            'id'      => 'wcz-product-price-fcolor',
            'label'   => __( 'Font Color', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'color',
            'default' => '#222',
        );
        // Customize - Product Page Button
        $options['wcz-wc-edit-prodbtn-color'] = array(
            'id'      => 'wcz-wc-edit-prodbtn-color',
            'label'   => __( 'Customize Product Button Colors', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $options['wcz-prodbtn-bgcolor'] = array(
            'id'      => 'wcz-prodbtn-bgcolor',
            'label'   => __( 'Button Color', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'color',
            'default' => '#e8e8e8',
        );
        $options['wcz-prodbtn-fontcolor'] = array(
            'id'      => 'wcz-prodbtn-fontcolor',
            'label'   => __( 'Button Font Color', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'color',
            'default' => '#000',
        );
        $options['wcz-prodbtn-hovercolor'] = array(
            'id'      => 'wcz-prodbtn-hovercolor',
            'label'   => __( 'Button Hover Color', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'color',
            'default' => '#757575',
        );
        $options['wcz-prodbtn-fonthovercolor'] = array(
            'id'      => 'wcz-prodbtn-fonthovercolor',
            'label'   => __( 'Button Font Hover Color', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'color',
            'default' => '#000',
        );
        // Customize - Continue Shopping Button
        $options['wcz-wc-edit-contshop-btn'] = array(
            'id'      => 'wcz-wc-edit-contshop-btn',
            'label'   => __( 'Customize \'Continue Shopping\' Button', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $options['wcz-contshop-bgcolor'] = array(
            'id'      => 'wcz-contshop-bgcolor',
            'label'   => __( 'Button Color', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'color',
            'default' => '#ebe9eb',
        );
        $options['wcz-contshop-hovercolor'] = array(
            'id'      => 'wcz-contshop-hovercolor',
            'label'   => __( 'Button Hover Color', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'color',
            'default' => '#cccacc',
        );
        $wcz_cs_btn_fs = get_option( 'wcz-contshop-fsize', 18 );
        $options['wcz-contshop-fsize'] = array(
            'id'          => 'wcz-contshop-fsize',
            'label'       => __( 'Font Size', 'woocustomizer' ),
            'section'     => $section,
            'type'        => 'range',
            'input_attrs' => array(
            'min'  => 11,
            'max'  => 34,
            'step' => 1,
        ),
            'description' => '<i>11</i> <span><b class="wcz-rangeval">' . esc_html( $wcz_cs_btn_fs ) . '</b></span> <i>34</i>',
            'default'     => 18,
        );
        $wcz_cs_btn_pad = get_option( 'wcz-contshop-pad', 18 );
        $options['wcz-contshop-pad'] = array(
            'id'          => 'wcz-contshop-pad',
            'label'       => __( 'Button Padding', 'woocustomizer' ),
            'section'     => $section,
            'type'        => 'range',
            'input_attrs' => array(
            'min'  => 10,
            'max'  => 40,
            'step' => 1,
        ),
            'description' => '<i>10</i> <span><b class="wcz-rangeval">' . esc_html( $wcz_cs_btn_pad ) . '</b></span> <i>40</i>',
            'default'     => 18,
        );
        // -------------------------------- Product Page Design Settings
        // ----------------------------------------------------------------------------------------------- WooCommerce Product Page
        // ----------------------------------------------------------------------------------------------- WooCommerce Account Page
        $section = 'wcz-panel-account';
        $sections[] = array(
            'id'       => $section,
            'title'    => __( 'Account Page', 'woocustomizer' ),
            'priority' => '10',
            'panel'    => $panel,
        );
        $choices = array(
            'wcz-tabstyle-none'       => 'None',
            'wcz-tabstyle-side'       => 'Side Tab Styling',
            'wcz-tabstyle-horizontal' => 'Horizontal Styling',
        );
        $options['wcz-tab-style'] = array(
            'id'          => 'wcz-tab-style',
            'label'       => __( 'Account Tab Design', 'woocustomizer' ),
            'section'     => $section,
            'type'        => 'select',
            'choices'     => $choices,
            'description' => __( 'Account Tab Design is only for if your theme has not added custom styling to your WooCommerce Account Page.', 'woocustomizer' ),
            'default'     => 'wcz-tabstyle-none',
        );
        // Account Tabs
        $options['wcz-heading-account-tabs'] = array(
            'id'      => 'wcz-heading-account-tabs',
            'label'   => __( 'Account Tabs', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'url',
        );
        $choices = array(
            'reset'                        => '',
            'wcz-account-dashboard-edit'   => 'Edit Tab',
            'wcz-account-dashboard-remove' => 'Remove Tab',
        );
        $options['wcz-account-dashboard-tab'] = array(
            'id'      => 'wcz-account-dashboard-tab',
            'label'   => __( 'Account Dashboard Tab', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'radio',
            'choices' => $choices,
            'default' => '',
        );
        $options['wcz-account-tab-dash-tab'] = array(
            'id'      => 'wcz-account-tab-dash-tab',
            'label'   => __( 'Dashboard Tab Title', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'text',
            'default' => __( 'Dashboard', 'woocustomizer' ),
        );
        $choices = array(
            'default'                  => 'Default',
            'wcz-accdash-content-text' => 'Plain Text',
            'wcz-accdash-content-page' => 'Page Content',
        );
        $options['wcz-account-dashboard-content'] = array(
            'id'      => 'wcz-account-dashboard-content',
            'label'   => __( 'Dashboard Tab Content', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'select',
            'choices' => $choices,
            'default' => 'default',
        );
        $options['wcz-accdash-remdefault'] = array(
            'id'      => 'wcz-accdash-remdefault',
            'label'   => __( 'Remove default dashboard text', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $options['wcz-accdash-text'] = array(
            'id'      => 'wcz-accdash-text',
            'label'   => __( 'Text', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'textarea',
            'default' => '',
        );
        $options['wcz-account-dont-note'] = array(
            'id'          => 'wcz-account-dont-note',
            'section'     => $section,
            'type'        => 'url',
            'description' => __( 'Note: Please DO NOT set this to display the Account Page, this will create an infinite loop and cause a timeout issue.', 'woocustomizer' ),
        );
        $options['wcz-accdash-page'] = array(
            'id'          => 'wcz-accdash-page',
            'label'       => __( 'Select Page', 'woocustomizer' ),
            'section'     => $section,
            'type'        => 'dropdown-pages',
            'description' => __( 'Select the page you\'d like to display in the Dashboard tab.', 'woocustomizer' ),
            'default'     => '',
        );
        // Edit/Remove Dashboard Tab
        $choices = array(
            'reset'                     => '',
            'wcz-account-orders-edit'   => 'Edit Tab Text',
            'wcz-account-orders-remove' => 'Remove Tab',
        );
        $options['wcz-account-orders-tab'] = array(
            'id'      => 'wcz-account-orders-tab',
            'label'   => __( 'Orders Tab', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'radio',
            'choices' => $choices,
            'default' => '',
        );
        $options['wcz-account-tab-orders-tab'] = array(
            'id'      => 'wcz-account-tab-orders-tab',
            'label'   => __( 'Tab Title', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'text',
            'default' => __( 'Orders', 'woocustomizer' ),
        );
        $options['wcz-account-tab-orders-title'] = array(
            'id'      => 'wcz-account-tab-orders-title',
            'label'   => __( 'Page Title', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'text',
            'default' => __( 'Orders', 'woocustomizer' ),
        );
        // Edit/Remove Orders Tab
        $choices = array(
            'reset'                        => '',
            'wcz-account-downloads-edit'   => 'Edit Tab Text',
            'wcz-account-downloads-remove' => 'Remove Tab',
        );
        $options['wcz-account-downloads-tab'] = array(
            'id'      => 'wcz-account-downloads-tab',
            'label'   => __( 'Downloads Tab', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'radio',
            'choices' => $choices,
            'default' => '',
        );
        $options['wcz-account-tab-downloads-tab'] = array(
            'id'      => 'wcz-account-tab-downloads-tab',
            'label'   => __( 'Tab Title', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'text',
            'default' => __( 'Downloads', 'woocustomizer' ),
        );
        $options['wcz-account-tab-downloads-title'] = array(
            'id'      => 'wcz-account-tab-downloads-title',
            'label'   => __( 'Page Title', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'text',
            'default' => __( 'Downloads', 'woocustomizer' ),
        );
        // Edit/Remove Downloads Tab
        $choices = array(
            'reset'                      => '',
            'wcz-account-address-edit'   => 'Edit Tab Text',
            'wcz-account-address-remove' => 'Remove Tab',
        );
        $options['wcz-account-address-tab'] = array(
            'id'      => 'wcz-account-address-tab',
            'label'   => __( 'Address Tab', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'radio',
            'choices' => $choices,
            'default' => '',
        );
        $options['wcz-account-tab-address-tab'] = array(
            'id'      => 'wcz-account-tab-address-tab',
            'label'   => __( 'Tab Title', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'text',
            'default' => __( 'Addresses', 'woocustomizer' ),
        );
        $options['wcz-account-tab-address-title'] = array(
            'id'      => 'wcz-account-tab-address-title',
            'label'   => __( 'Page Title', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'text',
            'default' => __( 'Addresses', 'woocustomizer' ),
        );
        // Edit/Remove Addresses Tab
        $choices = array(
            'reset'                      => '',
            'wcz-account-details-edit'   => 'Edit Tab Text',
            'wcz-account-details-remove' => 'Remove Tab',
        );
        $options['wcz-account-details-tab'] = array(
            'id'      => 'wcz-account-details-tab',
            'label'   => __( 'Account Details Tab', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'radio',
            'choices' => $choices,
            'default' => '',
        );
        $options['wcz-account-tab-details-tab'] = array(
            'id'      => 'wcz-account-tab-details-tab',
            'label'   => __( 'Tab Title', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'text',
            'default' => __( 'Account Details', 'woocustomizer' ),
        );
        $options['wcz-account-tab-details-title'] = array(
            'id'      => 'wcz-account-tab-details-title',
            'label'   => __( 'Page Title', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'text',
            'default' => __( 'Account Details', 'woocustomizer' ),
        );
        // Edit/Remove Account Details Tab
        $choices = array(
            'reset'                     => '',
            'wcz-account-logout-edit'   => 'Edit Tab Text',
            'wcz-account-logout-remove' => 'Remove Tab',
        );
        $options['wcz-account-logout-tab'] = array(
            'id'      => 'wcz-account-logout-tab',
            'label'   => __( 'Logout Tab', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'radio',
            'choices' => $choices,
            'default' => '',
        );
        $options['wcz-account-tab-logout-tab'] = array(
            'id'      => 'wcz-account-tab-logout-tab',
            'label'   => __( 'Tab Title', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'text',
            'default' => __( 'Logout', 'woocustomizer' ),
        );
        // EXCLUDED FROM FREE VERSION -- This "if" block will be auto removed from the Free version.
        // ----------------------------------------------------------------------------------------------- WooCommerce Account Page
        // ----------------------------------------------------------------------------------------------- WooCommerce Cart Page
        $section = 'wcz-panel-cart';
        $sections[] = array(
            'id'       => $section,
            'title'    => __( 'Cart Page', 'woocustomizer' ),
            'priority' => '10',
            'panel'    => $panel,
        );
        $options['wcz-cart-remove-coupons'] = array(
            'id'      => 'wcz-cart-remove-coupons',
            'label'   => __( 'Remove Coupons form', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $options['wcz-cart-disable-cart-quantity'] = array(
            'id'          => 'wcz-cart-disable-cart-quantity',
            'label'       => __( 'Disable users adjusting the quantity ', 'woocustomizer' ),
            'section'     => $section,
            'type'        => 'checkbox',
            'description' => __( 'This will stop users being able to adjust the product amounts in the cart', 'woocustomizer' ),
            'default'     => 0,
        );
        $options['wcz-cart-ajax-update'] = array(
            'id'          => 'wcz-cart-ajax-update',
            'label'       => __( 'Auto Update Cart Amount', 'woocustomizer' ),
            'section'     => $section,
            'type'        => 'checkbox',
            'description' => __( 'Users will not need to click \'Update Cart\' anymore, this will remove the update button and will auto update the cart as users change the product amounts.', 'woocustomizer' ),
            'default'     => 0,
        );
        $options['wcz-cart-remove-links'] = array(
            'id'          => 'wcz-cart-remove-links',
            'label'       => __( 'Remove Product Links ', 'woocustomizer' ),
            'section'     => $section,
            'type'        => 'checkbox',
            'description' => __( 'This will remove the Product Links in the cart, depending on your theme, this might break the design.', 'woocustomizer' ),
            'default'     => 0,
        );
        $options['wcz-cart-add-product-info'] = array(
            'id'      => 'wcz-cart-add-product-info',
            'label'   => __( 'Add extra Product Information ', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $options['wcz-cart-add-productinfo-cats'] = array(
            'id'      => 'wcz-cart-add-productinfo-cats',
            'label'   => __( 'Show Product Categories ', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $options['wcz-cart-add-productinfo-atts'] = array(
            'id'          => 'wcz-cart-add-productinfo-atts',
            'label'       => __( 'Show the users selected variations', 'woocustomizer' ),
            'section'     => $section,
            'type'        => 'checkbox',
            'description' => __( 'To see this work, please save and hard refresh or open the site in a new tab.<br /><br />By default WooCommerce does this if the product has 4 variations or more, it it only has 2 then it adds the selected variations to the product title.<br /><br />This will always show the product variations that the user selected below the product title.', 'woocustomizer' ),
            'default'     => 0,
        );
        $options['wcz-cart-add-productinfo-stock'] = array(
            'id'      => 'wcz-cart-add-productinfo-stock',
            'label'   => __( 'Show Product Stock ', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $options['wcz-cart-bts-btn'] = array(
            'id'          => 'wcz-cart-bts-btn',
            'label'       => __( 'Add a \'Back To Shop\' button', 'woocustomizer' ),
            'section'     => $section,
            'type'        => 'checkbox',
            'description' => __( 'Add a button to the cart page for customers to return to the Shop instead of proceeding to checkout.', 'woocustomizer' ),
            'default'     => 0,
        );
        $choices = array(
            'woocommerce_before_cart_table' => 'Before Cart Table',
            'woocommerce_cart_coupon'       => 'Next to Cart Table Coupon',
            'woocommerce_after_cart_totals' => 'After Proceed to Checkout button',
        );
        $options['wcz-cart-bts-pos'] = array(
            'id'      => 'wcz-cart-bts-pos',
            'label'   => __( 'Button Position', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'select',
            'choices' => $choices,
            'default' => 'woocommerce_after_cart_totals',
        );
        $options['wcz-cart-bts-txt'] = array(
            'id'      => 'wcz-cart-bts-txt',
            'label'   => __( 'Button Text', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'text',
            'default' => __( 'Back to Shop', 'woocustomizer' ),
        );
        $choices = array(
            'custom' => 'Add custom URL',
            'back'   => 'Back Button (return to last url)',
        );
        $options['wcz-cart-bts-type'] = array(
            'id'      => 'wcz-cart-bts-type',
            'label'   => __( 'Button Type', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'select',
            'choices' => $choices,
            'default' => 'custom',
        );
        $options['wcz-cart-bts-url'] = array(
            'id'      => 'wcz-cart-bts-url',
            'label'   => __( 'Button Custom URL', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'text',
        );
        $options['wcz-cart-bts-color'] = array(
            'id'      => 'wcz-cart-bts-color',
            'label'   => __( 'Background Color', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'color',
            'default' => '#ebe9eb',
        );
        $options['wcz-cart-bts-fcolor'] = array(
            'id'      => 'wcz-cart-bts-fcolor',
            'label'   => __( 'Font Color', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'color',
            'default' => '#ebe9eb',
        );
        $options['wcz-cart-bts-hcolor'] = array(
            'id'      => 'wcz-cart-bts-hcolor',
            'label'   => __( 'Hover Color', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'color',
            'default' => '#d0d0d0',
        );
        $options['wcz-cart-bts-hfcolor'] = array(
            'id'      => 'wcz-cart-bts-hfcolor',
            'label'   => __( 'Font Hover Color', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'color',
            'default' => '#d0d0d0',
        );
        $choices = array(
            'left'   => 'Left Align',
            'center' => 'Center Align',
            'right'  => 'Right Align',
        );
        $options['wcz-cart-bts-align'] = array(
            'id'      => 'wcz-cart-bts-align',
            'label'   => __( 'Button Alignment', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'select',
            'choices' => $choices,
            'default' => 'left',
        );
        $options['wcz-cart-show-discamount'] = array(
            'id'          => 'wcz-cart-show-discamount',
            'label'       => __( 'Show Discount / Amount Saved', 'woocustomizer' ),
            'section'     => $section,
            'type'        => 'checkbox',
            'description' => __( 'This will display the total amount a user saves when purchasing products On Sale!', 'woocustomizer' ),
            'default'     => 0,
        );
        $options['wcz-cart-discamount-txt'] = array(
            'id'      => 'wcz-cart-discamount-txt',
            'label'   => __( 'Text', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'text',
            'default' => __( 'You Save!', 'woocustomizer' ),
        );
        $options['wcz-cart-discamount-bgcolor'] = array(
            'id'      => 'wcz-cart-discamount-bgcolor',
            'label'   => __( 'Background Color', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'color',
            'default' => '#f9f9f9',
        );
        $options['wcz-cart-discamount-color'] = array(
            'id'      => 'wcz-cart-discamount-color',
            'label'   => __( 'Font Color', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'color',
            'default' => '#333',
        );
        $options['wcz-heading-final'] = array(
            'id'      => 'wcz-heading-final',
            'label'   => __( 'Cross Sells & Cart Totals', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'url',
        );
        $options['wcz-cart-move-crollsells-below'] = array(
            'id'      => 'wcz-cart-move-crollsells-below',
            'label'   => __( 'Move Cross Sells to below Cart Totals', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $options['wcz-cart-remove-cross-sells'] = array(
            'id'      => 'wcz-cart-remove-cross-sells',
            'label'   => __( 'Remove Cross Sell Section', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $choices = array(
            'reset'                    => '',
            'wcz-wccart-recomm-edit'   => 'Edit Title',
            'wcz-wccart-recomm-remove' => 'Remove Title',
        );
        $options['wcz-wccart-recomm'] = array(
            'id'      => 'wcz-wccart-recomm',
            'label'   => __( 'Cross Sells Title', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'radio',
            'choices' => $choices,
            'default' => '',
        );
        $options['wcz-wccart-recomm-title'] = array(
            'id'      => 'wcz-wccart-recomm-title',
            'label'   => __( 'Cross Sells Title', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'text',
            'default' => __( 'You may be interested in&hellip;', 'woocustomizer' ),
        );
        // Edit/Remove Cart Cross Sells Title
        $options['wcz-cart-crosssells-ppr'] = array(
            'id'          => 'wcz-cart-crosssells-ppr',
            'label'       => __( 'Products Per Row', 'woocustomizer' ),
            'section'     => $section,
            'type'        => 'range',
            'input_attrs' => array(
            'min'  => 2,
            'max'  => 5,
            'step' => 1,
        ),
            'description' => __( '<i>2</i> <b>|</b> 3 <b>|</b> 4 <b>|</b> <i>5</i>', 'woocustomizer' ),
            'default'     => 2,
        );
        $options['wcz-cart-crosssells-ppr-no'] = array(
            'id'      => 'wcz-cart-crosssells-ppr-no',
            'label'   => __( 'Amount of Cross Sells to show', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'number',
            'default' => '',
        );
        $choices = array(
            'reset'                    => '',
            'wcz-wccart-totals-edit'   => 'Edit Title',
            'wcz-wccart-totals-remove' => 'Remove Title',
        );
        $options['wcz-wccart-totals'] = array(
            'id'      => 'wcz-wccart-totals',
            'label'   => __( 'Cart Totals Title', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'radio',
            'choices' => $choices,
            'default' => '',
        );
        $options['wcz-wccart-totals-title'] = array(
            'id'      => 'wcz-wccart-totals-title',
            'label'   => __( 'Cart Totals Title', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'text',
            'default' => __( 'Cart totals', 'woocustomizer' ),
        );
        // Edit/Remove Cart Totals Title
        // Empty Cart Page Settings
        $options['wcz-heading-emptycart'] = array(
            'id'          => 'wcz-heading-emptycart',
            'label'       => __( 'Empty Cart Page', 'woocustomizer' ),
            'section'     => $section,
            'description' => __( 'Remove all products from your cart when editing this section', 'woocustomizer' ),
            'type'        => 'url',
        );
        $options['wcz-cart-add-custom-text'] = array(
            'id'      => 'wcz-cart-add-custom-text',
            'label'   => __( 'Add Custom Text to Empty Cart Page', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $options['wcz-cart-empty-txt'] = array(
            'id'          => 'wcz-cart-empty-txt',
            'label'       => __( 'Page Text', 'woocustomizer' ),
            'section'     => $section,
            'type'        => 'textarea',
            'description' => __( 'This will only show on the Empty Cart Page', 'woocustomizer' ),
            'default'     => __( 'Some Extra Text', 'woocustomizer' ),
        );
        $options['wcz-cart-edit-rts'] = array(
            'id'      => 'wcz-cart-edit-rts',
            'label'   => __( 'Edit \'Return to Shop\' button', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $options['wcz-cart-edit-rts-text'] = array(
            'id'      => 'wcz-cart-edit-rts-text',
            'label'   => __( 'Text', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'text',
            'default' => __( 'Return to shop', 'woocustomizer' ),
        );
        $options['wcz-cart-edit-rts-page'] = array(
            'id'      => 'wcz-cart-edit-rts-page',
            'label'   => __( 'Select the page this button links to', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'dropdown-pages',
            'default' => '',
        );
        // Customize - Return To Cart button
        $options['wcz-cart-return-btn'] = array(
            'id'      => 'wcz-cart-return-btn',
            'label'   => __( '"Return To Shop" button design', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $options['wcz-cart-return-btn-align'] = array(
            'id'      => 'wcz-cart-return-btn-align',
            'label'   => __( 'Center Align', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $wcz_sfsval = get_option( 'wcz-cart-return-btn-fsize', 16 );
        $options['wcz-cart-return-btn-fsize'] = array(
            'id'          => 'wcz-cart-return-btn-fsize',
            'label'       => __( 'Font Size', 'woocustomizer' ),
            'section'     => $section,
            'type'        => 'range',
            'input_attrs' => array(
            'min'  => 11,
            'max'  => 38,
            'step' => 1,
        ),
            'description' => '<i>10</i> <span><b class="wcz-rangeval">' . esc_html( $wcz_sfsval ) . '</b></span> <i>44</i>',
            'default'     => 16,
        );
        $options['wcz-cart-return-btn-color'] = array(
            'id'      => 'wcz-cart-return-btn-color',
            'label'   => __( 'Background Color', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'color',
            'default' => '#222',
        );
        $options['wcz-cart-return-btn-fcolor'] = array(
            'id'      => 'wcz-cart-return-btn-fcolor',
            'label'   => __( 'Font Color', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'color',
            'default' => '#FFF',
        );
        $options['wcz-cart-return-btn-hcolor'] = array(
            'id'      => 'wcz-cart-return-btn-hcolor',
            'label'   => __( 'Hover Color', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'color',
            'default' => '#000',
        );
        $options['wcz-cart-return-btn-hfcolor'] = array(
            'id'      => 'wcz-cart-return-btn-hfcolor',
            'label'   => __( 'Hover Font Color', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'color',
            'default' => '#FFF',
        );
        $wcz_sfsval = get_option( 'wcz-cart-return-btn-pad', 10 );
        $options['wcz-cart-return-btn-pad'] = array(
            'id'          => 'wcz-cart-return-btn-pad',
            'label'       => __( 'Padding', 'woocustomizer' ),
            'section'     => $section,
            'type'        => 'range',
            'input_attrs' => array(
            'min'  => 10,
            'max'  => 60,
            'step' => 1,
        ),
            'description' => '<i>10</i> <span><b class="wcz-rangeval">' . esc_html( $wcz_sfsval ) . '</b></span> <i>60</i>',
            'default'     => 10,
        );
        $options['wcz-heading-cart-design'] = array(
            'id'          => 'wcz-heading-cart-design',
            'label'       => __( 'Design Elements', 'woocustomizer' ),
            'section'     => $section,
            'type'        => 'url',
            'description' => __( 'These buttons should be designed by the theme. We try offer extra customization for these elements. If these don\'t work, please get in contact for help.', 'woocustomizer' ),
        );
        // Customize - Cart Buttons
        $options['wcz-cart-table-btn'] = array(
            'id'      => 'wcz-cart-table-btn',
            'label'   => __( 'Customize cart table buttons', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $options['wcz-cart-table-btn-color'] = array(
            'id'      => 'wcz-cart-table-btn-color',
            'label'   => __( 'Background Color', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'color',
            'default' => '#EEE',
        );
        $options['wcz-cart-table-btn-fcolor'] = array(
            'id'      => 'wcz-cart-table-btn-fcolor',
            'label'   => __( 'Font Color', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'color',
            'default' => '#333',
        );
        $options['wcz-cart-table-btn-hcolor'] = array(
            'id'      => 'wcz-cart-table-btn-hcolor',
            'label'   => __( 'Hover Color', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'color',
            'default' => '#EEE',
        );
        $options['wcz-cart-table-btn-hfcolor'] = array(
            'id'      => 'wcz-cart-table-btn-hfcolor',
            'label'   => __( 'Hover Font Color', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'color',
            'default' => '#333',
        );
        // Customize - Proceed to Checkout button
        $options['wcz-cart-proceed-btn'] = array(
            'id'      => 'wcz-cart-proceed-btn',
            'label'   => __( 'Customize "Proceed To Checkout" button', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $options['wcz-cart-proceed-btn-txt'] = array(
            'id'      => 'wcz-cart-proceed-btn-txt',
            'label'   => __( 'Button Text', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'text',
            'default' => __( 'Proceed to checkout', 'woocustomizer' ),
        );
        $wcz_sfsval = get_option( 'wcz-cart-proceed-btn-fsize', 18 );
        $options['wcz-cart-proceed-btn-fsize'] = array(
            'id'          => 'wcz-cart-proceed-btn-fsize',
            'label'       => __( 'Font Size', 'woocustomizer' ),
            'section'     => $section,
            'type'        => 'range',
            'input_attrs' => array(
            'min'  => 11,
            'max'  => 44,
            'step' => 1,
        ),
            'description' => '<i>10</i> <span><b class="wcz-rangeval">' . esc_html( $wcz_sfsval ) . '</b></span> <i>44</i>',
            'default'     => 18,
        );
        $wcz_sfsval = get_option( 'wcz-cart-proceed-btn-pad', 20 );
        $options['wcz-cart-proceed-btn-pad'] = array(
            'id'          => 'wcz-cart-proceed-btn-pad',
            'label'       => __( 'Padding', 'woocustomizer' ),
            'section'     => $section,
            'type'        => 'range',
            'input_attrs' => array(
            'min'  => 10,
            'max'  => 80,
            'step' => 1,
        ),
            'description' => '<i>10</i> <span><b class="wcz-rangeval">' . esc_html( $wcz_sfsval ) . '</b></span> <i>80</i>',
            'default'     => 20,
        );
        $options['wcz-cart-proceed-btn-color'] = array(
            'id'      => 'wcz-cart-proceed-btn-color',
            'label'   => __( 'Background Color', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'color',
            'default' => '#EEE',
        );
        $options['wcz-cart-proceed-btn-fcolor'] = array(
            'id'      => 'wcz-cart-proceed-btn-fcolor',
            'label'   => __( 'Font Color', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'color',
            'default' => '#333',
        );
        $options['wcz-cart-proceed-btn-hcolor'] = array(
            'id'      => 'wcz-cart-proceed-btn-hcolor',
            'label'   => __( 'Hover Color', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'color',
            'default' => '#EEE',
        );
        $options['wcz-cart-proceed-btn-hfcolor'] = array(
            'id'      => 'wcz-cart-proceed-btn-hfcolor',
            'label'   => __( 'Hover Font Color', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'color',
            'default' => '#333',
        );
        // ----------------------------------------------------------------------------------------------- WooCommerce Cart Page
        // ----------------------------------------------------------------------------------------------- WooCommerce Checkout Page
        $section = 'wcz-panel-checkout';
        $sections[] = array(
            'id'       => $section,
            'title'    => __( 'Checkout Page', 'woocustomizer' ),
            'priority' => '10',
            'panel'    => $panel,
        );
        $options['wcz-heading-direct-checkout'] = array(
            'id'      => 'wcz-heading-direct-checkout',
            'label'   => __( 'Direct Checkout', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'url',
        );
        $options['wcz-directcheckout-free-note'] = array(
            'id'          => 'wcz-directcheckout-free-note',
            'section'     => $section,
            'type'        => 'url',
            'description' => sprintf( __( '%1$s offers extra functionlaity to direct users straight to the checkout page, add the cart table to the checkout page & more customization settings for this feature.', 'woocustomizer' ), '<a href="' . esc_url( admin_url( 'admin.php?billing_cycle=annual&page=wcz_settings-pricing' ) ) . '" target="_blank">StoreCustomizer Pro</a>' ),
        );
        $options['wcz-heading-checkout-page'] = array(
            'id'      => 'wcz-heading-checkout-page',
            'label'   => __( 'Checkout Page', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'url',
        );
        $options['wcz-checkout-edit-coupon-txt'] = array(
            'id'      => 'wcz-checkout-edit-coupon-txt',
            'label'   => __( 'Edit Coupon Section Text', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $options['wcz-checkout-coupon-text'] = array(
            'id'      => 'wcz-checkout-coupon-text',
            'label'   => __( 'Coupon Code Text', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'text',
            'default' => __( 'Have a coupon?', 'woocustomizer' ),
        );
        $options['wcz-checkout-coupon-link-text'] = array(
            'id'      => 'wcz-checkout-coupon-link-text',
            'label'   => __( 'Coupon Code Link Text', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'text',
            'default' => __( 'Click here to enter your code', 'woocustomizer' ),
        );
        $options['wcz-checkout-coupon-instruction-text'] = array(
            'id'      => 'wcz-checkout-coupon-instruction-text',
            'label'   => __( 'Coupon Text', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'text',
            'default' => __( 'If you have a coupon code, please apply it below.', 'woocustomizer' ),
        );
        $options['wcz-checkout-edit-ordernotes-txt'] = array(
            'id'      => 'wcz-checkout-edit-ordernotes-txt',
            'label'   => __( 'Edit Order Notes Text', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $options['wcz-checkout-ordernotes-label'] = array(
            'id'      => 'wcz-checkout-ordernotes-label',
            'label'   => __( 'Label Text', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'text',
            'default' => __( 'Order notes', 'woocustomizer' ),
        );
        $options['wcz-checkout-ordernotes-placeholder'] = array(
            'id'      => 'wcz-checkout-ordernotes-placeholder',
            'label'   => __( 'Placeholder Text', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'text',
            'default' => __( 'Notes about your order, e.g. special notes for delivery.', 'woocustomizer' ),
        );
        $options['wcz-checkout-add-img'] = array(
            'id'          => 'wcz-checkout-add-img',
            'label'       => __( 'Add Custom Image', 'woocustomizer' ),
            'section'     => $section,
            'type'        => 'checkbox',
            'description' => __( 'This can be used to ensure that the site is secure for your users.', 'woocustomizer' ),
            'default'     => 0,
        );
        $options['wcz-checkout-img'] = array(
            'id'          => 'wcz-checkout-img',
            'label'       => __( 'Upload Image', 'woocustomizer' ),
            'section'     => $section,
            'type'        => 'upload',
            'description' => __( 'Upload this image at the correct size.', 'woocustomizer' ),
            'default'     => '',
        );
        $options['wcz-checkout-img-center'] = array(
            'id'      => 'wcz-checkout-img-center',
            'label'   => __( 'Center Image', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $options['wcz-checkout-show-discamount'] = array(
            'id'          => 'wcz-checkout-show-discamount',
            'label'       => __( 'Show Discount / Amount Saved', 'woocustomizer' ),
            'section'     => $section,
            'type'        => 'checkbox',
            'description' => __( 'This will display the total amount a user saves when purchasing products On Sale!', 'woocustomizer' ),
            'default'     => 0,
        );
        $options['wcz-checkout-discamount-txt'] = array(
            'id'      => 'wcz-checkout-discamount-txt',
            'label'   => __( 'Text', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'text',
            'default' => __( 'You Save!', 'woocustomizer' ),
        );
        $options['wcz-checkout-discamount-bgcolor'] = array(
            'id'      => 'wcz-checkout-discamount-bgcolor',
            'label'   => __( 'Background Color', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'color',
            'default' => '#f9f9f9',
        );
        $options['wcz-checkout-discamount-color'] = array(
            'id'      => 'wcz-checkout-discamount-color',
            'label'   => __( 'Font Color', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'color',
            'default' => '#333',
        );
        $options['wcz-checkout-add-po-txt'] = array(
            'id'      => 'wcz-checkout-add-po-txt',
            'label'   => __( 'Add Text under Place Order button', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $options['wcz-checkout-po-txt'] = array(
            'id'          => 'wcz-checkout-po-txt',
            'label'       => __( 'Custom Text', 'woocustomizer' ),
            'section'     => $section,
            'type'        => 'textarea',
            'description' => __( 'This will only show up once you refresh and/or go to the Checkout page.', 'woocustomizer' ),
            'default'     => __( 'Your personal data will help us create your account and to support your user experience throughout this website. Please have a look at our Privacy Policy for more information on how we use your personal data', 'woocustomizer' ),
        );
        $options['wcz-heading-remove-checkout-fields'] = array(
            'id'          => 'wcz-heading-remove-checkout-fields',
            'label'       => __( 'Remove Checkout Fields', 'woocustomizer' ),
            'section'     => $section,
            'type'        => 'url',
            'description' => __( 'Depending on your theme, the removal of these settings might not work. Edit these settings and then check the site front-end to see if they work.', 'woocustomizer' ),
        );
        $options['wcz-checkout-remove-lastname'] = array(
            'id'      => 'wcz-checkout-remove-lastname',
            'label'   => __( 'Remove Last Name', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $options['wcz-checkout-remove-company'] = array(
            'id'      => 'wcz-checkout-remove-company',
            'label'   => __( 'Remove Company Name', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $options['wcz-checkout-remove-address'] = array(
            'id'      => 'wcz-checkout-remove-address',
            'label'   => __( 'Remove Address', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $options['wcz-checkout-remove-towncity'] = array(
            'id'      => 'wcz-checkout-remove-towncity',
            'label'   => __( 'Remove Town / City', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $options['wcz-checkout-remove-provstate'] = array(
            'id'      => 'wcz-checkout-remove-provstate',
            'label'   => __( 'Remove State / Province & Zip Code', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $options['wcz-checkout-remove-phone'] = array(
            'id'      => 'wcz-checkout-remove-phone',
            'label'   => __( 'Remove Phone Number', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $options['wcz-checkout-remove-order-notes'] = array(
            'id'          => 'wcz-checkout-remove-order-notes',
            'label'       => __( 'Remove Order Notes', 'woocustomizer' ),
            'section'     => $section,
            'type'        => 'checkbox',
            'description' => __( 'Edit <a href="' . esc_url( admin_url( 'admin.php?page=wc-settings&tab=shipping&section=options' ) ) . '" target="_blank">Shipping destination</a> to remove the Shipping Address details.', 'woocustomizer' ),
            'default'     => 0,
        );
        
        if ( 'yes' == get_option( 'woocommerce_enable_signup_and_login_from_checkout' ) ) {
            $options['wcz-checkout-edit-createaccount'] = array(
                'id'      => 'wcz-checkout-edit-createaccount',
                'label'   => __( 'Edit \'Create an account?\' Text', 'woocustomizer' ),
                'section' => $section,
                'type'    => 'checkbox',
                'default' => 0,
            );
            $options['wcz-checkout-createaccount-txt'] = array(
                'id'      => 'wcz-checkout-createaccount-txt',
                'section' => $section,
                'type'    => 'text',
                'default' => __( 'Create an account?', 'woocustomizer' ),
            );
        }
        
        $options['wcz-heading-checkout-design'] = array(
            'id'          => 'wcz-heading-checkout-design',
            'label'       => __( 'Design Elements', 'woocustomizer' ),
            'section'     => $section,
            'type'        => 'url',
            'description' => __( 'This button should be designed by the theme. We try offer extra customization for this button. If this doesn\'t work, please get in contact for help.', 'woocustomizer' ),
        );
        // Customize - Place Order button
        $options['wcz-checkout-placeorder-btn'] = array(
            'id'      => 'wcz-checkout-placeorder-btn',
            'label'   => __( 'Customize the "Place Order" button', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $options['wcz-checkout-placeorder-btn-txt'] = array(
            'id'      => 'wcz-checkout-placeorder-btn-txt',
            'label'   => __( 'Button Text', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'text',
            'default' => __( 'Place Order', 'woocustomizer' ),
        );
        $wcz_sfsval = get_option( 'wcz-checkout-placeorder-btn-fsize', 18 );
        $options['wcz-checkout-placeorder-btn-fsize'] = array(
            'id'          => 'wcz-checkout-placeorder-btn-fsize',
            'label'       => __( 'Font Size', 'woocustomizer' ),
            'section'     => $section,
            'type'        => 'range',
            'input_attrs' => array(
            'min'  => 11,
            'max'  => 44,
            'step' => 1,
        ),
            'description' => '<i>11</i> <span><b class="wcz-rangeval">' . esc_html( $wcz_sfsval ) . '</b></span> <i>44</i>',
            'default'     => 18,
        );
        $wcz_sfsval = get_option( 'wcz-checkout-placeorder-btn-pad', 20 );
        $options['wcz-checkout-placeorder-btn-pad'] = array(
            'id'          => 'wcz-checkout-placeorder-btn-pad',
            'label'       => __( 'Padding', 'woocustomizer' ),
            'section'     => $section,
            'type'        => 'range',
            'input_attrs' => array(
            'min'  => 10,
            'max'  => 80,
            'step' => 1,
        ),
            'description' => '<i>10</i> <span><b class="wcz-rangeval">' . esc_html( $wcz_sfsval ) . '</b></span> <i>80</i>',
            'default'     => 20,
        );
        $options['wcz-checkout-placeorder-btn-color'] = array(
            'id'      => 'wcz-checkout-placeorder-btn-color',
            'label'   => __( 'Background Color', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'color',
            'default' => '#EEE',
        );
        $options['wcz-checkout-placeorder-btn-fcolor'] = array(
            'id'      => 'wcz-checkout-placeorder-btn-fcolor',
            'label'   => __( 'Font Color', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'color',
            'default' => '#333',
        );
        $options['wcz-checkout-placeorder-btn-hcolor'] = array(
            'id'      => 'wcz-checkout-placeorder-btn-hcolor',
            'label'   => __( 'Hover Color', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'color',
            'default' => '#EEE',
        );
        $options['wcz-checkout-placeorder-btn-hfcolor'] = array(
            'id'      => 'wcz-checkout-placeorder-btn-hfcolor',
            'label'   => __( 'Hover Font Color', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'color',
            'default' => '#333',
        );
        // Customize - Checkout Headings
        $options['wcz-checkout-edit-headings'] = array(
            'id'      => 'wcz-checkout-edit-headings',
            'label'   => __( 'Customize checkout details headings', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $options['wcz-checkout-careful-note'] = array(
            'id'          => 'wcz-checkout-careful-note',
            'section'     => $section,
            'type'        => 'url',
            'description' => __( 'Note: These settings use more memory so we suggest only doing this if you need to.', 'woocustomizer' ),
        );
        $options['wcz-checkout-billing-head'] = array(
            'id'      => 'wcz-checkout-billing-head',
            'label'   => __( '\'Billing\' heading', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'text',
            'default' => __( 'Billing details', 'woocustomizer' ),
        );
        $options['wcz-checkout-addinfo-head'] = array(
            'id'      => 'wcz-checkout-addinfo-head',
            'label'   => __( '\'Additional information\' heading', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'text',
            'default' => __( 'Additional information', 'woocustomizer' ),
        );
        $options['wcz-checkout-shipping-head'] = array(
            'id'      => 'wcz-checkout-shipping-head',
            'label'   => __( '\'Shipping\' heading', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'text',
            'default' => __( 'Ship to a different address?', 'woocustomizer' ),
        );
        $options['wcz-checkout-order-head'] = array(
            'id'      => 'wcz-checkout-order-head',
            'label'   => __( '\'Your Order\' heading', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'text',
            'default' => __( 'Your Order', 'woocustomizer' ),
        );
        $wcz_sfsval = get_option( 'wcz-checkout-sechead-fsize', 20 );
        $options['wcz-checkout-sechead-fsize'] = array(
            'id'          => 'wcz-checkout-sechead-fsize',
            'label'       => __( 'Font Size', 'woocustomizer' ),
            'section'     => $section,
            'type'        => 'range',
            'input_attrs' => array(
            'min'  => 12,
            'max'  => 48,
            'step' => 1,
        ),
            'description' => '<i>11</i> <span><b class="wcz-rangeval">' . esc_html( $wcz_sfsval ) . '</b></span> <i>48</i>',
            'default'     => 20,
        );
        $options['wcz-checkout-sechead-color'] = array(
            'id'      => 'wcz-checkout-sechead-color',
            'label'   => __( 'Headings Color', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'color',
            'default' => '#222',
        );
        // EXCLUDED FROM FREE VERSION -- This "if" block will be auto removed from the Free version.
        // --------------------------------------------------------------------------------------------------------------------------------- WC Panel
    }
    
    // is WooCommerce Activated - end
    // Adds the sections to the $options array
    $options['sections'] = $sections;
    // Adds the panels to the $options array
    $options['panels'] = $panels;
    $customizer_library = WooCustomizer_Library::Instance();
    $customizer_library->add_options( $options );
    // To delete custom mods use: woocustomizer_library_remove_theme_mods();
}

add_action( 'init', 'woocustomizer_customizer_library_options' );
<?php

/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package storefront
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="profile" href="http://gmpg.org/xfn/11">
  <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.2/css/font-awesome.css" type="text/css" media="screen" /> -->

  <?php wp_head(); ?>

  <link rel="stylesheet" href="<?php echo get_template_directory_uri() ?>/module6.css" type="text/css" media="screen" />
<!--  <link rel="stylesheet" href="--><?php //echo get_template_directory_uri() ?><!--/module7.css" type="text/css" media="screen" />-->


  <link rel="stylesheet" href="<?php echo get_template_directory_uri() ?>/module-home-top.css" type="text/css" media="screen" />
  <link rel="stylesheet" href="<?php echo get_template_directory_uri() ?>/module-home-categoryMenu.css" type="text/css" media="screen" />
  <link rel="stylesheet" href="<?php echo get_template_directory_uri() ?>/module-home-banner.css" type="text/css" media="screen" />
  <link rel="stylesheet" href="<?php echo get_template_directory_uri() ?>/module-footer.css" type="text/css" media="screen" />


  <!-- HUNG's Module -->
  <link rel="stylesheet" href="<?php echo get_template_directory_uri() ?>/module-Hung-productList.css" type="text/css" media="screen" />
  <!--    FONT AWESOME-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.1.0/css/v4-shims.min.css"
        integrity="sha512-p++g4gkFY8DBqLItjIfuKJPFvTPqcg2FzOns2BNaltwoCOrXMqRIOqgWqWEvuqsj/3aVdgoEo2Y7X6SomTfUPA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Module 3 & 4 - Vũ: -->
    <link rel="stylesheet" href="<?php echo get_template_directory_uri() ?>/module3_module4.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="<?php echo get_template_directory_uri() ?>/module10.css" type="text/css" media="screen" />

</head>

<body <?php body_class(); ?>>

  <?php wp_body_open(); ?>

  <?php do_action('storefront_before_site'); ?>

  <div id="page" class="hfeed site">
    <?php do_action('storefront_before_header'); ?>

    <!-- ============================================== HEADER ============================================== -->
    <header class="header-style-1">

      <!-- ============================================== TOP MENU ============================================== -->
      <div class="top-bar animate-dropdown">
        <div class="container">
          <div class="header-top-inner">
            <div class="cnt-account">
              <ul class="list-unstyled">
                <?php storefront_primary_navigation(); ?>
              </ul>
            </div>
            <!-- /.cnt-account -->

            <div class="cnt-block">
              <ul class="list-unstyled list-inline">
                <li class="dropdown dropdown-small"> <a href="#" class="dropdown-toggle" data-hover="dropdown" data-toggle="dropdown"><span class="value">USD </span><b class="caret"></b></a>
                  <ul class="dropdown-menu">
                    <li><a href="#">USD</a></li>
                    <li><a href="#">INR</a></li>
                    <li><a href="#">GBP</a></li>
                  </ul>
                </li>
                <li class="dropdown dropdown-small lang"> <a href="#" class="dropdown-toggle" data-hover="dropdown" data-toggle="dropdown"><span class="value">English </span><b class="caret"></b></a>
                  <ul class="dropdown-menu">
                    <li><a href="#">English</a></li>
                    <li><a href="#">French</a></li>
                    <li><a href="#">German</a></li>
                  </ul>
                </li>
              </ul>
              <!-- /.list-unstyled -->
            </div>
            <!-- /.cnt-cart -->
            <div class="clearfix"></div>
          </div>
          <!-- /.header-top-inner -->
        </div>
        <!-- /.container -->
      </div>
      <!-- /.header-top -->
      <!-- ============================================== TOP MENU : END ============================================== -->
      <div class="main-header">
        <div class="container">
          <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-3 logo-holder">
              <!-- ============================================================= LOGO ============================================================= -->
              <div class="logo module7-logo">
                <a href="<?php echo esc_url(home_url('/')); ?>">
                  <?php echo esc_html(get_bloginfo('name')); ?>
                </a>
              </div>
              <!-- /.logo -->
              <!-- ============================================================= LOGO : END ============================================================= -->
            </div>
            <!-- /.logo-holder -->

            <div class="col-lg-7 col-md-6 col-sm-8 col-xs-12 top-search-holder">
              <!-- /.contact-row -->
              <!-- ============================================================= SEARCH AREA ============================================================= -->
              <div class="search-area">
                <form role="search" method="get" class="woocommerce-product-search" action="<?php echo esc_url(home_url('/')); ?>">
                  <div class="control-group">
                    <ul class="categories-filter animate-dropdown">
                      <li class="dropdown"> <a class="dropdown-toggle" data-toggle="dropdown" href="category.html">Categories <b class="caret"></b></a>
                        <ul class="dropdown-menu" role="menu">
                          <li class="menu-header">Computer</li>
                          <li role="presentation"><a role="menuitem" tabindex="-1" href="category.html">- Clothing</a></li>
                          <li role="presentation"><a role="menuitem" tabindex="-1" href="category.html">- Electronics</a></li>
                          <li role="presentation"><a role="menuitem" tabindex="-1" href="category.html">- Shoes</a></li>
                          <li role="presentation"><a role="menuitem" tabindex="-1" href="category.html">- Watches</a></li>
                        </ul>
                      </li>
                    </ul>
                    <label class="screen-reader-text" for="woocommerce-product-search-field-<?php echo isset($index) ? absint($index) : 0; ?>"><?php esc_html_e('Search for:', 'woocommerce'); ?></label>
                    <input type="search" id="woocommerce-product-search-field-<?php echo isset($index) ? absint($index) : 0; ?>" class="search-field" placeholder="<?php echo esc_attr__('Search here&hellip;', 'woocommerce'); ?>" value="<?php echo get_search_query(); ?>" name="s" />
                    <button class="search-button" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                    <input type="hidden" name="post_type" value="product" />
                  </div>
                </form>
              </div>
              <!-- /.search-area -->
              <!-- ============================================================= SEARCH AREA : END ============================================================= -->
            </div>
            <!-- /.top-search-holder -->

            <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12 animate-dropdown top-cart-row">
              <!-- ============================================================= SHOPPING CART DROPDOWN ============================================================= -->

              <div class="dropdown dropdown-cart"> <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="dropdown-toggle lnk-cart" data-toggle="dropdown">
                  <div class="items-cart-inner">
                    <div class="basket">
                      <div class="basket-item-count"><span class="count"><?php echo wp_kses_data(sprintf(_n('%d', '%d', WC()->cart->get_cart_contents_count(), 'storefront'), WC()->cart->get_cart_contents_count())); ?></span></div>
                      <div class="total-price-basket"> <span class="lbl">Shopping Cart</span> <span class="value"><?php echo wp_kses_post(WC()->cart->get_cart_subtotal()); ?></span> </div>
                    </div>
                  </div>
                </a>
                <ul class="dropdown-menu">
                  <li>
                    <div class="cart-item product-summary">
                      <div class="row">
                        <div class="col-xs-4">
                          <div class="image"> <a href="detail.html"><img src="assets/images/products/p4.jpg" alt=""></a> </div>
                        </div>
                        <div class="col-xs-7">
                          <h3 class="name"><a href="index8a95.html?page-detail">Simple Product</a></h3>
                          <div class="price">$600.00</div>
                        </div>
                        <div class="col-xs-1 action"> <a href="#"><i class="fa fa-trash"></i></a> </div>
                      </div>
                    </div>
                    <!-- /.cart-item -->
                    <div class="clearfix"></div>
                    <hr>
                    <div class="clearfix cart-total">
                      <div class="pull-right"> <span class="text">Sub Total :</span><span class='price'>$600.00</span> </div>
                      <div class="clearfix"></div>
                      <a href="checkout.html" class="btn btn-upper btn-primary btn-block m-t-20">Checkout</a>
                    </div>
                    <!-- /.cart-total-->

                  </li>
                </ul>
                <!-- /.dropdown-menu-->
              </div>
              <!-- /.dropdown-cart -->

              <!-- ============================================================= SHOPPING CART DROPDOWN : END============================================================= -->
            </div>
            <!-- /.top-cart-row -->
          </div>
          <!-- /.row -->

        </div>
        <!-- /.container -->

      </div>
      <!-- /.main-header -->

      <!-- ============================================== NAVBAR ============================================== -->
      <div class="header-nav animate-dropdown">
        <div class="container">
          <div class="yamm navbar navbar-default" role="navigation">
            <div class="navbar-header">
              <button data-target="#mc-horizontal-menu-collapse" data-toggle="collapse" class="navbar-toggle collapsed" type="button">
                <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
            </div>
            <div class="nav-bg-class">
              <div class="navbar-collapse collapse" id="mc-horizontal-menu-collapse">
                <div class="nav-outer">
                  <ul class="nav navbar-nav">
                    <li class="active dropdown"> <a href="/">Home</a> </li>

                    <li class="dropdown mega-menu">
                      <a href="#" data-hover="dropdown" class="dropdown-toggle" data-toggle="dropdown">Electronics <span class="menu-label hot-menu hidden-xs">hot</span> </a>
                    </li>
                    <li class="dropdown hidden-sm"> <a href="#">Health & Beauty <span class="menu-label new-menu hidden-xs">new</span> </a> </li>
                    <li class="dropdown hidden-sm"> <a href="#">Watches</a> </li>
                    <li class="dropdown"> <a href="#">Jewellery</a> </li>
                    <li class="dropdown"> <a href="#">Shoes</a> </li>
                    <li class="dropdown"> <a href="#">Kids & Girls</a> </li>
                    <li class="dropdown  navbar-right special-menu"> <a href="#">Get 30% off on selected items</a> </li>
                  </ul>
                  <!-- /.navbar-nav -->
                  <div class="clearfix"></div>
                </div>
                <!-- /.nav-outer -->
              </div>
              <!-- /.navbar-collapse -->

            </div>
            <!-- /.nav-bg-class -->
          </div>
          <!-- /.navbar-default -->
        </div>
        <!-- /.container-class -->

      </div>
      <!-- /.header-nav -->
      <!-- ============================================== NAVBAR : END ============================================== -->

    </header>

    <!-- ============================================== HEADER : END ============================================== -->

    <?php if (basename(get_permalink()) === 'cart') { ?>
      <div class="module6-page-header text-center">
        <h1 class="module6-page-title">Shopping Cart<span>Shop</span></h1>
      </div><!-- End .page-header -->
    <?php } ?>

    <?php
    /**
     * Functions hooked in to storefront_before_content
     *
     * @hooked storefront_header_widget_region - 10
     * @hooked woocommerce_breadcrumb - 10
     */
    do_action('storefront_before_content');
    ?>

    <div id="content" class="site-content" tabindex="-1">
      <div class="col-full">

        <?php
        do_action('storefront_content_top');

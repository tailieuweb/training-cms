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
  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.2/css/font-awesome.css" type="text/css" media="screen" /> -->

  <?php wp_head(); ?>

  <link rel="stylesheet" href="<?php echo get_template_directory_uri() ?>/module6.css" type="text/css" media="screen" />
 <link rel="stylesheet" href="<?php echo get_template_directory_uri() ?>/module7.css" type="text/css" media="screen" />


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
    <header class="module7-header-style-1 module7" > 
  
  <!-- ============================================== TOP MENU ============================================== -->
  <div class="module7-navigation module7-top-bar module7-animate-dropdown">
    <div class="col-full">
      <div class="module7-header-top-inner">
        <div class="module7-cnt-account">
          <ul class="module7-list-unstyled">
		  <?php storefront_primary_navigation(); ?> 
          </ul>
        </div>
        <!-- /.cnt-account -->
        
        <!-- /.cnt-cart -->
        <div class="module7-clearfix"></div>
      </div>
      <!-- /.header-top-inner --> 
    </div>
    <!-- /.container --> 
  </div>
  <!-- /.header-top --> 
  <!-- ============================================== TOP MENU : END ============================================== -->
  <div class="module7-main-header">
    <div class="col-full">
      <div class="module7-row">
        <div class="module7-col-xs-12 module7-col-sm-12 module7-col-md-3 logo-holder"> 
          <!-- ============================================================= LOGO ============================================================= -->
          <div class="module7-logo">
			  <a href="<?php echo esc_url( home_url( '/' )); ?>">
				  <?php echo esc_html( get_bloginfo( 'name' ) ); ?>
				</a> </div>
          <!-- /.logo --> 
          <!-- ============================================================= LOGO : END ============================================================= --> </div>
        <!-- /.logo-holder -->
        
        <div class="module7-col-lg-7 module7-col-md-6 module7-col-sm-8 module7-col-xs-12 module7-top-search-holder"> 
          <!-- /.contact-row --> 
          <!-- ============================================================= SEARCH AREA ============================================================= -->
          <div class="module7-search-area">
            <form  role="search" method="get" class="woocommerce-product-search" action="<?php echo esc_url( home_url( '/' ) ); ?>">
              <div class="module7-control-group">
                <ul class="categories-filter animate-dropdown">
                  <li class="module7-dropdown"> <a class="module7-dropdown-toggle"  data-toggle="module7-dropdown" href="#">Categories <b class="caret"></b></a>
                    <ul class="module7-dropdown-menu " role="menu" >
                      <li class="module7-menu-header">Computer</li>
                      <li role="presentation"><a role="menuitem" tabindex="-1" href="#">- Clothing</a></li>
                      <li role="presentation"><a role="menuitem" tabindex="-1" href="#">- Electronics</a></li>
                      <li role="presentation"><a role="menuitem" tabindex="-1" href="#">- Shoes</a></li>
                      <li role="presentation"><a role="menuitem" tabindex="-1" href="#">- Watches</a></li>
                    </ul>
                  </li>
                </ul>
                <label class="screen-reader-text" for="woocommerce-product-search-field-<?php echo isset( $index ) ? absint( $index ) : 0; ?>"><?php esc_html_e( 'Search for:', 'woocommerce' ); ?></label>
              <input type="search" id="woocommerce-product-search-field-<?php echo isset( $index ) ? absint( $index ) : 0; ?>" class="search-field" placeholder="<?php echo esc_attr__( 'Search here&hellip;', 'woocommerce' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
              <button class="search-button" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
              <input type="hidden" name="post_type" value="product" />
			        </div>
            </form>
          </div>
          <!-- /.search-area --> 
          <!-- ============================================================= SEARCH AREA : END ============================================================= --> </div>
        <!-- /.top-search-holder -->
        
        <div class="module7-col-lg-2 module7-col-md-3 module7-col-sm-4 module7-col-xs-12 animate-module7-dropdown top-cart-row"> 
          <!-- ============================================================= SHOPPING CART module7-dropdown ============================================================= -->
          
          <div class="module7-dropdown module7-dropdown-cart"> <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="dropdown-toggle lnk-cart" data-toggle="dropdown">
            <div class="module7-items-cart-inner">
              <div class="module7-basket" style="padding-right: 1.5em;">
              <div class="module7-basket-item-count"><span class="module7-count"><?php echo wp_kses_data( sprintf( _n( '%d', '%d', WC()->cart->get_cart_contents_count(), 'storefront' ), WC()->cart->get_cart_contents_count() ) ); ?></span></div>
              <div class="module7-total-price-basket"> <span class="module7-lbl">Shopping Cart</span> <span class="module7-value"><?php echo wp_kses_post( WC()->cart->get_cart_subtotal() ); ?></span> </div>
              </div>
            </div>
            </a>
            <!-- /.dropdown-menu--> 
          </div>
          <!-- /.dropdown-cart --> 
          
          <!-- ============================================================= SHOPPING CART module7-dropdown : END============================================================= --> </div>
        <!-- /.top-cart-row --> 
      </div>
      <!-- /.row --> 
      
    </div>
    <!-- /.container --> 
    
  </div>
  <!-- /.main-header --> 
  
  <!-- ============================================== NAVBAR ============================================== -->
  <div class="module7-header-nav module7-animate-dropdown">
    <div class="col-full">
      <div class="module7-yamm module7-navbar module7-navbar-default" role="navigation">
        <div class="module7-navbar-header">
       <button data-target="#mc-horizontal-menu-collapse" data-toggle="collapse" class="module7-navbar-toggle module7-collapsed" type="button"> 
       <span class="module7-sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
        </div>
        <div class="module7-qnav-bg-class">
          <div class="module7-navbar-collapse module7-collapse" id="mc-horizontal-menu-collapse">
            <div class="module7-nav-outer">
              <ul class="module7-nav module7-navbar-nav">
                <li class="module7-active module7-dropdown"> <a href="/">Home</a> </li>

                <li class="module7-dropdown module7-mega-menu"> 
                <a href="#"  data-hover="dropdown" class="dropdown-toggle" data-toggle="dropdown">Electronics <span class="menu-label hot-menu hidden-xs">hot</span> </a>
                </li>
                <li class="module7-dropdown module7-hidden-sm"> <a href="#">Health & Beauty <span class="menu-label new-menu hidden-xs">new</span> </a> </li>
                <li class="module7-dropdown module7-hidden-sm"> <a href="#">Watches</a> </li>
                <li class="module7-dropdown"> <a href="#">Jewellery</a> </li>
                <li class="module7-dropdown"> <a href="#">Shoes</a> </li>
                <li class="module7-dropdown"> <a href="#">Kids & Girls</a> </li>
                <li class="module7-dropdown  module7-navbar-right module7-special-menu"> <a href="#">Get 30% off on selected items</a> </li>
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

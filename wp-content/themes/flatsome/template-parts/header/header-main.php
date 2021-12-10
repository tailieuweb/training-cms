<div id="masthead" class="header-main <?php header_inner_class('main'); ?>">
      <div class="header-inner flex-row container <?php flatsome_logo_position(); ?>" role="navigation">

          <!-- Logo -->
          <div id="logo" class="flex-col logo">
            <?php get_template_part('template-parts/header/partials/element','logo'); ?>
          </div>

          <!-- Mobile Left Elements -->
          <div class="flex-col show-for-medium flex-left">
            <ul class="mobile-nav nav nav-left <?php flatsome_nav_classes('main-mobile'); ?>">
              <?php flatsome_header_elements('header_mobile_elements_left','mobile'); ?>
            </ul>
          </div>

          <!-- Left Elements -->
          <div class="flex-col hide-for-medium flex-left
            <?php if(get_theme_mod('logo_position', 'left') == 'left') echo 'flex-grow'; ?>">
            <ul class="header-nav header-nav-main nav nav-left <?php flatsome_nav_classes('main'); ?>" >
              <?php flatsome_header_elements('header_elements_left'); ?>
            </ul>
          </div>

          <!-- Right Elements -->
          <div class="flex-col hide-for-medium flex-right">
            <!-- <ul class="header-nav header-nav-main nav nav-right <?php flatsome_nav_classes('main'); ?>">
              <?php flatsome_header_elements('header_elements_right'); ?>
            </ul> -->
            <ul class="header-nav header-nav-main nav nav-right  nav-uppercase">
              <li class="html custom html_topbar_right">
                <div class="list-icon-text">
	                <div class="icon-box">
	                  <i class="fas fa-phone"></i>
	                </div>
                  <div class="text-box">
                    <span class="text-banhang" style="color:#1e428a">BÁN HÀNG</span><br>
                    <strong class="hotline" style="color:red">0986.777.888</strong>
                  </div>
                </div>
              </li>
              <li class="html custom html_top_right_text">
                <div class="list-icon-text">
                  <div class="icon-box">
                    <i class="fas fa-phone"></i>
                  </div>
                  <div class="text-box">
                    <span class="text-kythuat" style="color:#1e428a">KỸ THUẬT</span><br>
                    <strong class="hotline" style="color:red">0986.777.888</strong>
                  </div>
                </div>
              </li>
              <li class="html custom html_nav_position_text_top">
                <span class="text-giohang" style="color:#777"> GIỎ HÀNG </span>
                <li class="cart-item has-icon has-dropdown">
                  <a href="http://wordpress.local/?page_id=9" title="Cart" class="header-cart-link is-small">
                    <span class="cart-icon image-icon">
			                <strong>0</strong>
		                </span>
                  </a>
                  <ul class="nav-dropdown nav-dropdown-simple">
                    <li class="html widget_shopping_cart">
                      <div class="widget_shopping_cart_content">
                        <p class="woocommerce-mini-cart__empty-message">No products in the cart.</p>
                      </div>
                    </li>
                  </ul>
                </li>
            </ul>
          </div>

          <!-- Mobile Right Elements -->
          <div class="flex-col show-for-medium flex-right">
            <ul class="mobile-nav nav nav-right <?php flatsome_nav_classes('main-mobile'); ?>">
              <?php flatsome_header_elements('header_mobile_elements_right','mobile'); ?>
            </ul>
          </div>

      </div>
     
      <?php if(get_theme_mod('header_divider', 1)) { ?>
      <div class="container"><div class="top-divider full-width"></div></div>
      <?php }?>
</div>
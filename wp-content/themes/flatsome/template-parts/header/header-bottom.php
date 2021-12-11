<?php if(flatsome_has_bottom_bar()['large_or_mobile']) {
?>
<div id="wide-nav" class="header-bottom wide-nav <?php header_inner_class('bottom'); ?>">
    <div class="flex-row container">

            <?php if(get_theme_mod('header_elements_bottom_left') || get_theme_mod('header_elements_bottom_right')){ ?>
            <div class="flex-col hide-for-medium flex-left">
                <ul class="nav header-nav header-bottom-nav nav-left <?php flatsome_nav_classes('bottom'); ?>">
                    <?php flatsome_header_elements('header_elements_bottom_left','nav_position_text'); ?>
                </ul>
            </div>
            <?php } ?>

            <?php if(get_theme_mod('header_elements_bottom_center')){ ?>
            <div class="flex-col hide-for-medium flex-center">
                <!-- <ul class="nav header-nav header-bottom-nav nav-center <?php flatsome_nav_classes('bottom'); ?>">
                    <?php flatsome_header_elements('header_elements_bottom_center','nav_position_text'); ?>
                </ul> -->
                <ul class="nav header-nav header-bottom-nav nav-center  nav-box nav-uppercase">
                    <li id="menu-item-435" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-435 menu-item-design-default has-dropdown">
                        <a href="http://wordpress.local/?page_id=428" class="nav-top-link">
                            <i class="fas fa-bars"></i> Danh mục sản phẩm
                        </a>
                        <ul class="sub-menu nav-dropdown nav-dropdown-simple">
                            <li id="menu-item-436" class="menu-item menu-item-type-taxonomy menu-item-object-product_cat menu-item-436">
                                <a href="http://wordpress.local/?product_cat=dieu-hoa">Điều hòa Funiki</a>
                            </li>
                            <li id="menu-item-437" class="menu-item menu-item-type-taxonomy menu-item-object-product_cat menu-item-437">
                                <a href="http://wordpress.local/?product_cat=tu-lanh">Tủ đông</a>
                            </li>
                            <li id="menu-item-439" class="menu-item menu-item-type-taxonomy menu-item-object-product_cat menu-item-439">
                                <a href="http://wordpress.local/?product_cat=san-pham-xem-nhieu">Sản phẩm xem nhiều</a>
                            </li>
                        </ul>
                    </li>
                    <li id="menu-item-429" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-home current-menu-item page_item page-item-65 current_page_item menu-item-429 active menu-item-design-default">
                        <a href="http://wordpress.local/" aria-current="page" class="nav-top-link">Trang chủ</a>
                    </li>
                    <li id="menu-item-430" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-430 menu-item-design-default">
                        <a href="http://wordpress.local/?page_id=367" class="nav-top-link">Giới thiệu</a>
                    </li>
                    <li id="menu-item-431" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-431 menu-item-design-default">
                        <a href="http://wordpress.local/?page_id=8" class="nav-top-link">Cửa hàng</a>
                    </li>
                    <li id="menu-item-432" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-432 menu-item-design-default">
                        <a href="http://wordpress.local/?page_id=377" class="nav-top-link">Bảo hành</a>
                    </li>
                    <li id="menu-item-433" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-433 menu-item-design-default">
                        <a href="http://wordpress.local/?page_id=369" class="nav-top-link">Tin tức</a>
                    </li>
                    <li id="menu-item-434" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-434 menu-item-design-default">
                        <a href="http://wordpress.local/?page_id=373" class="nav-top-link">Liên hệ</a>
                    </li>
                    <!-- <li class="html custom html_nav_position_text"><a href="#">KHUYẾN MÃI GIỜ VÀNG</a></li> -->
                </ul>
            </div>
            <?php } ?>

            <?php if(get_theme_mod('header_elements_bottom_right') || get_theme_mod('header_elements_bottom_left')){ ?>
            <div class="flex-col hide-for-medium flex-right flex-grow">
              <ul class="nav header-nav header-bottom-nav nav-right <?php flatsome_nav_classes('bottom'); ?>">
                   <?php flatsome_header_elements('header_elements_bottom_right','nav_position_text'); ?>
              </ul>
            </div>
            <?php } ?>

            <?php if(get_theme_mod('header_mobile_elements_bottom')) { ?>
              <div class="flex-col show-for-medium flex-grow">
                  <ul class="nav header-bottom-nav nav-center mobile-nav <?php flatsome_nav_classes('bottom'); ?>">
                      <?php flatsome_header_elements('header_mobile_elements_bottom'); ?>
                  </ul>
              </div>
            <?php } ?>

    </div>
</div>
<?php } ?>

<?php do_action('flatsome_after_header_bottom'); ?>

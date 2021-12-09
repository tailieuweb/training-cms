<?php if(flatsome_has_bottom_bar()['large_or_mobile']) {
?>
<div id="wide-nav" class="header-bottom wide-nav <?php header_inner_class('bottom'); ?>">
    <div class="flex-row container">

            <?php if(get_theme_mod('header_elements_bottom_left') || get_theme_mod('header_elements_bottom_right')){ ?>
            <div class="flex-col hide-for-medium flex-left">
                <ul class="nav header-nav header-bottom-nav nav-left <?php flatsome_nav_classes('bottom'); ?>">
                    <?php flatsome_header_elements('header_elements_bottom_left','nav_position_text'); ?>
                </ul>
                <!-- <div class="row">
                    <div class="col-md-2">
                        <a href="" style = "color: white"> <div id="mega-menu-title"> <i class="icon-menu" style = "margin-right : 10px"></i>DANH MỤC SẢN PHẨM</div></a>
                    </div>
                    <div class="col-md-9">
                        <a href="" aria-current="page" class="nav-top-link">Trang chủ</a>
                        <a href="" aria-current="page" class="nav-top-link">Giới thiệu</a>
                        <a href="" aria-current="page" class="nav-top-link">Cửa hàng</a>
                        <a href="" aria-current="page" class="nav-top-link">Bảo hành</a>
                        <a href="" aria-current="page" class="nav-top-link">Tin tức</a>
                        <a href="" aria-current="page" class="nav-top-link">Liên hệ</a>
                    </div>
                    <div class="col-md-1">
                    <a href="" aria-current="page" class="nav-top-link" id= "khuyenmai">Khuyến mãi giờ vàng</a>
                    </div>
                </div> -->
            </div>
            <?php } ?>

            <?php if(get_theme_mod('header_elements_bottom_center')){ ?>
            <div class="flex-col hide-for-medium flex-center">
                <ul class="nav header-nav header-bottom-nav nav-center <?php flatsome_nav_classes('bottom'); ?>">
                    <?php flatsome_header_elements('header_elements_bottom_center','nav_position_text'); ?>
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
            <?php } ?> -->

    </div>
</div>
<?php } ?>

<?php do_action('flatsome_after_header_bottom'); ?>

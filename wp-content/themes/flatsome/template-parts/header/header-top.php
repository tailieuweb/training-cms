<?php if(flatsome_has_top_bar()['large_or_mobile']){ ?>
<div id="top-bar" class="header-top <?php header_inner_class('top'); ?>">
    <div class="flex-row container">
      <div class="flex-col hide-for-medium flex-left">
          <!-- <ul class="nav nav-left medium-nav-center nav-small <?php flatsome_nav_classes('top'); ?>">
              <?php flatsome_header_elements('topbar_elements_left'); ?>
          </ul> -->
          <strong class="text-congty" style = "color:#1e428a ; font-size:14px">TỔNG ĐẠI LÝ PHÂN PHỐI CẤP 1 ĐIỆN LẠNH HÒA PHÁT - FUNIKI</strong>
      </div>

      <div class="flex-col hide-for-medium flex-center">
          <ul class="nav nav-center nav-small <?php flatsome_nav_classes('top'); ?>">
              <?php flatsome_header_elements('topbar_elements_center'); ?>
          </ul>
      </div>

      <div class="flex-col hide-for-medium flex-right">
         <!-- <ul class="nav top-bar-nav nav-right nav-small <?php flatsome_nav_classes('top'); ?>">
              <?php flatsome_header_elements('topbar_elements_right'); ?>
          </ul> -->
        <ul class="nav top-bar-nav nav-right nav-small  nav-divided">
            <li class="header-contact-wrapper">
		        <ul id="header-contact" class="nav nav-divided nav-uppercase header-contact">
		            <li class="">
			            <a href="mailto:youremail@gmail.com" class="tooltip tooltipstered">
				            <span>Tài khoản</span>
			            </a>
			        </li>
				    <li class="">
			            <a href="tel:Liên hệ" class="tooltip tooltipstered">
			                <span>Liên hệ</span>
			            </a>
			        </li>
				</ul>
            </li>
            <li class="html header-social-icons ml-0">
                <div class="social-icons follow-icons"><a href="http://url" target="_blank" data-label="Facebook" rel="noopener noreferrer nofollow" class="icon plain facebook tooltip tooltipstered" aria-label="Follow on Facebook"><i class="icon-facebook"></i></a><a href="http://url" target="_blank" rel="noopener noreferrer nofollow" data-label="Instagram" class="icon plain instagram tooltip tooltipstered" aria-label="Follow on Instagram"><i class="icon-instagram"></i></a><a href="http://url" target="_blank" data-label="Twitter" rel="noopener noreferrer nofollow" class="icon plain twitter tooltip tooltipstered" aria-label="Follow on Twitter"><i class="icon-twitter"></i></a><a href="mailto:your@email" data-label="E-mail" rel="nofollow" class="icon plain email tooltip tooltipstered" aria-label="Send us an email"><i class="icon-envelop"></i></a></div></li>
            <li class="html header-social-icons ml-0">
                <div class="social-icons follow-icons"><a href="http://url" target="_blank" data-label="Facebook" rel="noopener noreferrer nofollow" class="icon plain facebook tooltip tooltipstered" aria-label="Follow on Facebook"><i class="icon-facebook"></i></a><a href="http://url" target="_blank" rel="noopener noreferrer nofollow" data-label="Instagram" class="icon plain instagram tooltip tooltipstered" aria-label="Follow on Instagram"><i class="icon-instagram"></i></a><a href="http://url" target="_blank" data-label="Twitter" rel="noopener noreferrer nofollow" class="icon plain twitter tooltip tooltipstered" aria-label="Follow on Twitter"><i class="icon-twitter"></i></a><a href="mailto:your@email" data-label="E-mail" rel="nofollow" class="icon plain email tooltip tooltipstered" aria-label="Send us an email"><i class="icon-envelop"></i></a></div></li>          
        </ul>
      </div>

      <?php if(get_theme_mod('header_mobile_elements_top')) { ?>
      <div class="flex-col show-for-medium flex-grow">
          <ul class="nav nav-center nav-small mobile-nav <?php flatsome_nav_classes('top'); ?>">
              <?php flatsome_header_elements('header_mobile_elements_top'); ?>
          </ul>
      </div>
      <?php } ?>

    </div>
</div>
<?php } ?>

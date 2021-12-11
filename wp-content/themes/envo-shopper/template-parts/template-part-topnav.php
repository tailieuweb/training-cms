<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- link add file css và file php -->
<link rel="stylesheet" href="<?php echo get_template_directory_uri() ?>/header.css">  
 <!-- css sidebar -->
 <link rel="stylesheet" href="<?php echo get_template_directory_uri() ?>/sidebar.css" type="text/css" media="screen" />
    <!-- css footer ne -->
    <link rel="stylesheet" href="<?php echo get_template_directory_uri() ?>/footer.css" type="text/css" media="screen" />

    <!-- Fontawsome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Document</title>
</head>
<body>
    
</body>
</html>
<?php do_action('envo_shopper_construct_top_bar'); ?>
<div class="site-header container-fluid">
    <div class="<?php echo esc_attr(get_theme_mod('header_content_width', 'container')); ?>" >
        <div class="heading-row row" >
            <div class="site-heading hidden-xs <?php echo esc_attr(is_active_sidebar('envo-shopper-header-area') == true ? 'col-md-3' : 'col-md-8' ); ?>" >
                <?php envo_shopper_title_logo(); ?>
            </div>
            <div class="heading-widget-area">    
                <?php if (is_active_sidebar('envo-shopper-header-area')) { ?>
                    
                <?php } ?>
            </div>
            <div class="site-heading mobile-heading visible-xs" >
                <?php envo_shopper_title_logo('div'); ?>
            </div>
            <?php if (class_exists('WooCommerce')) { ?>
                <div class="header-right col-md-3" >
                    <?php do_action('envo_shopper_header_right'); ?>
                </div>
            <?php } ?>
            <div class="header-right menu-button visible-xs" >
                <div class="navbar-header">
                    <?php if (function_exists('max_mega_menu_is_enabled') && max_mega_menu_is_enabled('main_menu')) : // phpcs:ignore Generic.CodeAnalysis.EmptyStatement.DetectedIf
                        // do nothing 
                    else : ?>
                        <span class="navbar-brand brand-absolute visible-xs"><?php esc_html_e('Menu', 'envo-shopper'); ?></span>
                        <a href="#" id="main-menu-panel" class="open-panel" data-panel="main-menu-panel">
                            <span></span>
                            <span></span>
                            <span></span>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="site-menu-bar container-fluid">
    <div class="<?php echo esc_attr(get_theme_mod('header_content_width', 'container')); ?>" >
        <div class="menu-row row" >
            <div class="menu-heading">
                <nav id="site-navigation" class="navbar navbar-default">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'main_menu',
                        'depth' => 5,
                        'container_id' => 'my-menu',
                        'container' => 'div',
                        'container_class' => 'menu-container',
                        'menu_class' => 'nav navbar-nav navbar-center',
                        'fallback_cb' => 'Envo_Shopper_WP_Bootstrap_Navwalker::fallback',
                        'walker' => new Envo_Shopper_WP_Bootstrap_Navwalker(),
                    ));
                    ?>
                </nav>    
            </div>
        </div>
    </div>
</div>
<?php 
do_action('envo_shopper_before_second_menu'); 
if (class_exists('WooCommerce')) { 
?>
    <div class="main-menu">
        <nav id="second-site-navigation" class="navbar navbar-default <?php envo_shopper_second_menu(); ?>">
            <div class="container">   
                <?php do_action('envo_shopper_header_bar'); ?>
            </div>
        </nav> 
    </div>
<?php 
do_action('envo_shopper_after_second_menu');
}

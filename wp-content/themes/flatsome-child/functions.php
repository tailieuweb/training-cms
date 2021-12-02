<?php
// Add custom Theme Functions here
add_action('wp_enqueue_scripts', 'enqueue_my_styles');
function enqueue_my_styles()
{
  wp_enqueue_style('my-theme-ie', get_stylesheet_directory_uri() . "/css/module5.css");
}
add_filter('woocommerce_show_page_title', '__return_false');
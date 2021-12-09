<?php
// Add custom Theme Functions here
function simplexml_basic_theme_load_scripts()
{
  wp_enqueue_style('module5', get_stylesheet_directory_uri() . "/css/module5.css", array(), '1.0', 'all');
  wp_enqueue_style('module4', get_stylesheet_directory_uri() . "/css/module4.css", array(), '1.0', 'all');
  wp_enqueue_style('module3', get_stylesheet_directory_uri() . "/css/module3.css", array(), '1.0', 'all');
  wp_enqueue_style('module2', get_stylesheet_directory_uri() . "/css/module2.css", array(), '1.0', 'all');
  wp_enqueue_style('module1', get_stylesheet_directory_uri() . "/css/module1.css", array(), '1.0', 'all');
}
add_action('wp_enqueue_scripts', 'simplexml_basic_theme_load_scripts');

<?php
/**
 * Flatsome functions and definitions
 *
 * @package flatsome
 */

require get_template_directory() . '/inc/init.php';

/**
 * Note: It's not recommended to add any custom code here. Please use a child theme so that your customizations aren't lost during updates.
 * Learn more here: http://codex.wordpress.org/Child_Themes
 */

function module_3_latestnews()
{
    wp_register_style( 'module-3', get_template_directory_uri() . '/assets/css/module-3-latestnews.css', 'all' );
    wp_enqueue_style( 'module-3' );
}
add_action( 'wp_enqueue_scripts', 'module_3_latestnews' );

function module_8_card()
{
    wp_register_style( 'module-8', get_template_directory_uri() . '/assets/css/module-8-card.css', 'all' );
    wp_enqueue_style( 'module-8' );
}
add_action( 'wp_enqueue_scripts', 'module_8_card' );


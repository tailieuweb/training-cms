<?php
/**
 * Envo Shopper Theme Customizer
 *
 * @package Envo Shopper
 */

$envo_shopper_sections = array( 'info', 'demo' );

foreach( $envo_shopper_sections as $section ){
    require get_template_directory() . '/inc/customizer/' . $section . '.php'; // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound
}

function envo_shopper_customizer_scripts() {
    wp_enqueue_style( 'envo-shopper-customize',get_template_directory_uri().'/inc/customizer/css/customize.css', '', 'screen' );
    wp_enqueue_script( 'envo-shopper-customize', get_template_directory_uri() . '/inc/customizer/js/customize.js', array( 'jquery' ), '20170404', true );
}
add_action( 'customize_controls_enqueue_scripts', 'envo_shopper_customizer_scripts' );

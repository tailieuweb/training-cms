<?php

defined( 'ABSPATH' ) || exit;

/**
 * Porto Theme Options
 */

require_once( PORTO_ADMIN . '/functions.php' );

// include redux framework core functions
require_once( PORTO_ADMIN . '/ReduxCore/framework.php' );
// porto theme settings options
require_once( PORTO_ADMIN . '/theme_options/settings.php' );

require_once( PORTO_ADMIN . '/theme_options/save_settings.php' );

if ( ! get_theme_mod( 'theme_options_saved', false ) ) {
	// set search layout and minicart type for old versions
	porto_restore_default_options_for_old_versions();

	porto_check_theme_options();
}

// regenerate default css, skin css files after update theme
if ( ! porto_is_ajax() ) {
	$porto_cur_version = get_option( 'porto_version', '1.0' );
	if ( version_compare( PORTO_VERSION, $porto_cur_version, '!=' ) ) {

		// set search layout and minicart type for old versions
		porto_restore_default_options_for_old_versions( true );

		// regenerate skin css
		porto_save_theme_settings();

		// regenerate default css
		if ( is_rtl() ) {
			porto_compile_css( 'bootstrap_rtl' );
		} else {
			porto_compile_css( 'bootstrap' );
		}

		// regenerate shortcodes css
		if ( '1.0' != $porto_cur_version ) {
			porto_compile_css( 'shortcodes' );
		}

		// clear transient
		delete_site_transient( 'porto_plugins' );

		if ( version_compare( $porto_cur_version, '6.1.0', '<' ) ) {
			global $porto_settings, $reduxPortoSettings;
			$sticky_default_toggle = array(
				'regular' => '',
				'hover'   => '',
			);
			$changed               = false;
			if ( ! empty( $porto_settings['sticky-searchform-toggle-text-color'] ) ) {
				$sticky_default_toggle['regular'] = $porto_settings['sticky-searchform-toggle-text-color'];
				$changed                          = true;
			}
			if ( ! empty( $porto_settings['sticky-searchform-toggle-hover-color'] ) ) {
				$sticky_default_toggle['hover'] = $porto_settings['sticky-searchform-toggle-hover-color'];
				$changed                        = true;
			}
			if ( $changed && isset( $reduxPortoSettings->ReduxFramework ) ) {
				$reduxPortoSettings->ReduxFramework->set( 'sticky-searchform-toggle-color', $sticky_default_toggle );
			}
		}

		add_action(
			'init',
			function() use ( $porto_cur_version ) {
				/* Update product_layout to porto_builder for old version */
				if ( version_compare( $porto_cur_version, '6.0.1', '<' ) ) {
					$updated_types = array(
						'block'          => 'block',
						'product_layout' => 'product',
					);

					foreach ( $updated_types as $old => $type ) {
						$post_query = new WP_Query(
							array(
								'post_type'      => $old,
								'posts_per_page' => -1,
							)
						);
						if ( $post_query->have_posts() ) {
							$posts = $post_query->get_posts();
							foreach ( $posts as $p ) {
								$p->post_type = 'porto_builder';
								wp_update_post( $p );
								add_post_meta( $p->ID, 'porto_builder_type', $type );
								wp_set_post_terms( $p->ID, $type, 'porto_builder_type' );
							}
						}
					}
				}

				if ( version_compare( $porto_cur_version, '6.0.4', '<' ) && taxonomy_exists( 'porto_builder_type' ) ) {
					$post_query = new WP_Query(
						array(
							'post_type'      => 'porto_builder',
							'posts_per_page' => -1,
						)
					);
					if ( $post_query->have_posts() ) {
						$posts = $post_query->get_posts();
						foreach ( $posts as $p ) {
							$builder_type = get_post_meta( $p->ID, 'porto_builder_type', true );
							$term_type    = wp_get_post_terms( $p->ID, 'porto_builder_type', array( 'fields' => 'names' ) );
							if ( $builder_type && empty( $term_type ) ) {
								wp_set_post_terms( $p->ID, $builder_type, 'porto_builder_type' );
							}
						}
					}
				}

				if ( version_compare( $porto_cur_version, '6.1.0', '<' ) ) {
					if ( ! class_exists( 'Porto_Admin_Tools' ) ) {
						require_once PORTO_ADMIN . '/admin_pages/class-tools.php';
					}
					$admin_tools = new Porto_Admin_Tools();
					$admin_tools->refresh_blocks();
					remove_theme_mod( 'elementor_sidebars' );
					remove_theme_mod( 'elementor_edited' );
					remove_theme_mod( 'elementor_blog_edited' );
					remove_theme_mod( '_vc_blocks_header' );
					remove_theme_mod( '_vc_blocks' );
					remove_theme_mod( '_vc_blocks_blog' );
					remove_theme_mod( '_vc_blocks_sidebar' );
					remove_theme_mod( '_vc_blocks_menu' );
				}

				update_option( 'porto_version', PORTO_VERSION );
			},
			20
		);
	}
}

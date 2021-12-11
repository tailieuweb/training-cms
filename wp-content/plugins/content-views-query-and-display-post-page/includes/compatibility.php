<?php
/**
 * Resolved conflict with other plugins
 *
 * @package   PT_Content_Views
 * @author    PT Guy <http://www.contentviewspro.com/>
 * @license   GPL-2.0+
 * @link      http://www.contentviewspro.com/
 * @copyright 2016 PT Guy
 */
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Check if a plugin is active
 * @since 1.9.9.3
 */
$cv_active_plugins_list = array();
function cv_is_active_plugin( $plugin ) {
	global $cv_active_plugins_list;
	if ( empty( $cv_active_plugins_list ) ) {
		// get blog active plugins
		$plugins = apply_filters( 'active_plugins', get_option( 'active_plugins' ) );

		if ( is_multisite() ) {
			// get active plugins for the network
			$network_plugins = get_site_option( 'active_sitewide_plugins' );
			if ( $network_plugins ) {
				$network_plugins = array_keys( $network_plugins );
				$plugins		 = array_merge( $plugins, $network_plugins );
			}
		}

		if ( is_array( $plugins ) ) {
			foreach ( $plugins as $string ) {
				$parts = explode( '/', $string );
				if ( !empty( $parts[ 0 ] ) ) {
					$cv_active_plugins_list[] = $parts[ 0 ];
				}
			}
		}
	}

	return is_array( $cv_active_plugins_list ) ? in_array( $plugin, $cv_active_plugins_list ) : false;
}

/**
 * Autoptimize
 * Disable "Force JavaScript in <head>"
 *
 * @since 1.8.6
 */
add_filter( 'autoptimize_filter_js_defer', 'cv_comp_plugin_autoptimize', 10, 1 );
function cv_comp_plugin_autoptimize( $defer ) {
	$defer = "defer ";
	return $defer;
}

/** Prevent text of other plugins in generated excerpt
 * @since 2.3.3.1
 */
add_filter( 'pt_cv_field_content_excerpt', 'cv_comp_clean_excerpt', 1, 3 );
function cv_comp_clean_excerpt( $content, $fargs, $this_post ) {
	// Remove text of "AddToAny Share Buttons" at top
	if ( function_exists( 'A2A_SHARE_SAVE_add_to_content' ) ) {
		remove_filter( 'the_content', 'A2A_SHARE_SAVE_add_to_content', 98 );
	}

	return $content;
}

/** Get full content in some cases
 * @since 2.3.2
 */
add_filter( 'pt_cv_field_content_excerpt', 'cv_comp_get_full_content', 9, 3 );
function cv_comp_get_full_content( $content, $fargs, $this_post ) {
	/** Get content of current language
	 * qTranslate-X (and qTranslate, mqTranslate)
	 * @since 1.7.8
	 */
	/** Page Builder by SiteOrigin
	 * Excerpt is incorrect (not updated)
	 * @update 1.9.9 Apply the "the_content" to work with any verion of that plugin
	 * @since 1.8.8
	 */
	/**
	 * Cornerstone Page Builder
	 * Excerpt/thumbnal is incorrect (can't get)
	 * @since 2.0
	 */
	if ( function_exists( 'qtranxf_use' ) || defined( 'SITEORIGIN_PANELS_VERSION' ) || cv_is_active_plugin( 'cornerstone' ) ) {
		if ( !isset( $this_post->cv_full_content ) ) {
			ob_start();
			the_content();
			$this_post->cv_full_content = ob_get_clean();
		}

		$content = $this_post->cv_full_content;
	}

	return $content;
}

// Prevent error "The preview was unresponsive after loading"
add_action( 'cornerstone_load_builder', 'cv_comp_plugin_cornerstone_builder' );
add_action( 'cornerstone_before_boot_app', 'cv_comp_plugin_cornerstone_builder' );
add_action( 'cornerstone_before_ajax', 'cv_comp_plugin_cornerstone_builder' );
add_action( 'cornerstone_before_load_preview', 'cv_comp_plugin_cornerstone_builder' );
function cv_comp_plugin_cornerstone_builder() {
	if ( defined( 'PT_CV_POST_TYPE' ) ) {
		remove_shortcode( PT_CV_POST_TYPE );
	}
}

/** Beaver Builder plugin (tested with version 2.1.7.2): style of full content is not applied in View
 * @since 2.1.3
 */
add_filter( 'pt_cv_field_content_full', 'cv_comp_plugin_beaverbuilder', 9, 3 );
function cv_comp_plugin_beaverbuilder( $content, $fargs, $post ) {
	if ( class_exists( 'FLBuilderModel' ) && method_exists( 'FLBuilderModel', 'is_builder_enabled' ) ) {
		$enabled = FLBuilderModel::is_builder_enabled( $post->ID );
		if ( $enabled ) {
			if ( class_exists( 'FLBuilder' ) && method_exists( 'FLBuilder', 'render_content_by_id' ) ) {
				ob_start();
				FLBuilder::render_content_by_id( $post->ID );
				$content = ob_get_clean();
			}
		}
	}

	return $content;
}

/**
 * FacetWP
 * Missing posts in output when access page with parameters 'fwp_*' of FacetWP plugin
 *
 * @since 1.9.3
 */
add_filter( 'facetwp_is_main_query', 'cv_comp_plugin_facetwp', 999, 2 );
function cv_comp_plugin_facetwp( $is_main_query, $query ) {
	if ( $query->get( 'cv_get_view' ) || $query->get( 'by_contentviews' ) ) {
		$is_main_query = false;
	}

	return $is_main_query;
}

# "View maybe not exist" error, caused by custom filter hook (which modifies `post_type` in WordPress query) of another plugin
add_action( 'pre_get_posts', 'cv_comp_no_view_found', 999 );
function cv_comp_no_view_found( $query ) {
	if ( $query->get( 'cv_get_view' ) ) {
		$query->set( 'post_type', PT_CV_POST_TYPE );
	}

	return $query;
}

/**
 * Divi theme
 * Remove line break holder of Divi theme from excerpt
 *
 * @since 1.9.5
 */
add_filter( 'pt_cv_before_generate_excerpt', 'cv_comp_theme_divi_linebreak' );
function cv_comp_theme_divi_linebreak( $args ) {
	if ( defined( 'ET_CORE_VERSION' ) ) {
		$args = str_replace( array( '<!-- [et_pb_line_break_holder] -->', '&lt;!-- [et_pb_line_break_holder] --&gt;' ), '', $args );
	}

	return $args;
}

/**
 * Divi theme
 * Collapsible doesn't toggle on click heading, Scrollable doesn't slide on click next/prev button
 *
 * @since 1.9.7.1
 */
add_filter( PT_CV_PREFIX_ . 'wrapper_class', 'cv_comp_theme_divi_scroll' );
function cv_comp_theme_divi_scroll( $args ) {
	if ( defined( 'ET_CORE_VERSION' ) ) {
		$args .= ' ' . 'et_smooth_scroll_disabled';
	}

	/** Enfold theme
	 * Hover effect causes content below thumbnail jumps
	 * @since 2.4.0
	 */
	if ( strtolower( get_template() ) === 'enfold' ) {
		$args .= ' noLightbox';
	}

	return $args;
}

/**
 * Visual Composer
 * Shortcode is visible in content, when do Ajax pagination
 *
 * @since 1.9.6
 */
add_action( 'pt_cv_before_content', 'cv_comp_plugin_visualcomposer', 9 );
function cv_comp_plugin_visualcomposer() {
	if ( (defined( 'PT_CV_DOING_PAGINATION' ) || defined( 'PT_CV_DOING_PREVIEW' )) && class_exists( 'WPBMap' ) && method_exists( 'WPBMap', 'addAllMappedShortcodes' ) ) {
		WPBMap::addAllMappedShortcodes();
	}
}

// Fix: Sort by doesn't work
add_action( 'pre_get_posts', 'cv_comp_wrong_sortby', 9 );
function cv_comp_wrong_sortby( $query ) {
	if ( $query->get( 'by_contentviews' ) ) {
		/**
		 * "Post Types Order" plugin
		 * @since 1.9.6
		 */
		if ( cv_is_active_plugin( 'post-types-order' ) ) {
			$query->set( 'ignore_custom_sort', true );
		}

		/**
		 * "Simple Custom Post Order" plugin
		 * @since 1.9.8
		 */
		if ( cv_is_active_plugin( 'simple-custom-post-order' ) ) {
			add_filter( 'option_scporder_options', '__return_false', 10, 2 );
		}

		/**
		 * "Intuitive Custom Post Order" plugin
		 * @since 1.9.9.3
		 */
		if ( cv_is_active_plugin( 'intuitive-custom-post-order' ) ) {
			add_filter( 'option_hicpo_options', '__return_false', 10, 2 );
		}
	}

	return $query;
}

/**
 * OptimizePress plugin
 * Content Views style & script were not loaded in page created by OptimizePress plugin
 * @since 1.9.8, update 2.3.2
 */
if ( cv_is_active_plugin( 'optimizePressPlugin' ) ) {
	add_action( 'wp_print_styles', 'cv_comp_plugin_optimize', 9 );
	function cv_comp_plugin_optimize() {
		$oep = get_option( 'opd_external_plugins', array() );
		foreach ( array( 'css', 'js' ) as $key ) {
			if ( !isset( $oep[ $key ] ) ) {
				$oep[ $key ] = array();
			}
			$oep[ $key ][]	 = 'content-views-query-and-display-post-page';
			$oep[ $key ][]	 = 'pt-content-views-pro';
		}
		update_option( 'opd_external_plugins', $oep );
	}

}

add_action( PT_CV_PREFIX_ . 'before_query', 'cv_comp_action_before_query' );
function cv_comp_action_before_query() {
	/** Fix problem with Paid Membership Pro plugin
	 * It resets (instead of append) "post__not_in" parameter of WP query which makes:
	 * - exclude function doesn't work
	 * - output in Preview panel is different from output in front-end
	 * @since 1.7.3
	 */
	if ( function_exists( 'pmpro_search_filter' ) ) {
		remove_filter( 'pre_get_posts', 'pmpro_search_filter' );
	}

	/* Fix: Posts don't appear in View output, when excludes categories by "Ultimate category excluder" plugin
	 * @since 1.9.9
	 */
	if ( function_exists( 'ksuce_exclude_categories' ) ) {
		remove_filter( 'pre_get_posts', 'ksuce_exclude_categories' );
	}

	/** Fix: woo-event-manager plugin sets DESC order for all Views query
	 * @since 2.0.3
	 */
	if ( function_exists( 'rc_modify_query_get_posts_by_date' ) ) {
		remove_action( 'pre_get_posts', 'rc_modify_query_get_posts_by_date' );
	}

	/* Theme GeoPress360 shows only post and its post type on all pages
	 * @since 2.3.0
	 */
	remove_filter( 'pre_get_posts', 'aplotis_custom_posts_in_archive' );
	remove_filter( 'pre_get_posts', 'aplotis_panoramas_in_home_loop' );
}

/**
 * Backup & restore View settings for pagination
 * @param string $action
 * @param array $view_settings
 */
function cv_comp_pagination_settings( $action, $view_settings ) {
	global $cv_unique_id;
	$cv_unique_id = ''; // reset to prevent using existing value of previous views
	if ( $action === 'set' ) {
		$key	 = $case	 = '';

		if ( defined( 'PT_CV_DOING_PREVIEW' ) ) {
			$key	 = 'preview';
			$case	 = 'preview';
		} elseif ( isset( $view_settings[ PT_CV_PREFIX . 'rebuild' ] ) ) {
			global $wp_query;
			$key	 = $wp_query->query_vars_hash;
			$case	 = 'rebuild';
		} else if ( defined( 'PT_CV_VIEW_REUSE' ) || PT_CV_Functions::get_global_variable( 'reused_view' ) ) {
			$key	 = md5( serialize( $view_settings[ PT_CV_PREFIX . 'shortcode_atts' ] ) );
			$case	 = 'reuse';
		}

		if ( !empty( $key ) && !empty( $case ) ) {
			$cv_unique_id = $key;

			// Simplify the array
			foreach ( $view_settings as $key => $value ) {
				if ( strpos( $key, PT_CV_PREFIX . 'font-' ) === 0 ) {
					unset( $view_settings[ $key ] );
				}
			}

			/** Some characters (quotes backslash : ;) cause maybe_unserialize (get_transient) to return false => can't get saved settings
			 * Also, increase the transient time, so users have more time to browser the pages
			 * @since 2.3.3
			 */
			$view_settings = base64_encode( serialize( $view_settings ) );
			set_transient( PT_CV_PREFIX . 'view-settings-' . $cv_unique_id, $view_settings, ($key === 'preview') ? HOUR_IN_SECONDS : 8 * HOUR_IN_SECONDS  );
		}
	} else if ( $action === 'get' ) {
		$cv_unique_id	 = cv_sanitize_vid( $_POST[ 'unid' ] );
		$data			 = get_transient( PT_CV_PREFIX . 'view-settings-' . $cv_unique_id );
		return unserialize( base64_decode( $data ) );
	}
}

/**
 * https://wordpress.org/plugins/lazy-load/ causes pagination loading icon is broken
 * @since 1.9.9.2
 */
add_action( 'pt_cv_add_global_variables', 'cv_comp_plugin_lazyload_break_loading' );
function cv_comp_plugin_lazyload_break_loading() {
	if ( cv_is_active_plugin( 'lazy-load' ) ) {
		remove_filter( 'the_content', array( 'LazyLoad_Images', 'add_image_placeholders' ), 99 );
	}
}

/**
 * Post content begins with a slider shortcode
 * Issue: slider number shows at beginning of generated excerpt
 */
add_filter( 'pt_cv_before_generate_excerpt', 'cv_comp_common_slider_number_in_excerpt' );
function cv_comp_common_slider_number_in_excerpt( $args ) {
	$args	 = preg_replace( '/<a[^>]*>(\d+)<\/a>/', '', $args );
	$args	 = preg_replace( '/<li[^>]*>(\d+)<\/li>/', '', $args );
	return $args;
}

/** Fix error "View * may not exist" caused by the "Shortcodes Anywhere or Everywhere" plugin
 * @since 2.0
 */
add_action( 'pt_cv_get_view_settings', 'cv_comp_plugin_saoe' );
function cv_comp_plugin_saoe() {
	remove_filter( 'get_post_metadata', 'jr_saoe_get_post_metadata', 10 );
}

/** Compatible with Timeline layout which uses old param
 * @since 2.0
 */
add_action( PT_CV_PREFIX_ . 'view_process_start', 'cv_comp_pro_timeline_pagination' );
function cv_comp_pro_timeline_pagination() {
	$pagenum = PT_CV_Functions::get_pagination_number();
	if ( !empty( $pagenum ) ) {
		$_GET[ 'vpage' ] = $pagenum;
	}
}

/** Redirect to new url if using old pagination link
  /pages/N
  ?pages=N
  &pages=N
 * @since 2.3.0
 */
add_action( 'template_redirect', 'cv_comp_pagination_redirect' );
function cv_comp_pagination_redirect() {
	$matches = array();
	$pattern = '@([/?&]pages[/=])([0-9]+)@i';
	$request = html_entity_decode( get_pagenum_link() );
	preg_match( $pattern, $request, $matches );

	if ( !empty( $matches[ 2 ] ) ) {
		$new_url_raw = PT_CV_Functions::get_pagination_url( $matches[ 2 ] );
		$new_url	 = preg_replace( $pattern, '', html_entity_decode( $new_url_raw ) );
		if ( !headers_sent() && wp_http_validate_url( $new_url ) ) {
			wp_safe_redirect( $new_url, 301 );
			exit();
		} else {
			return $new_url;
		}
	}
}

/** Prevent issue caused by other plugins */
add_action( PT_CV_PREFIX_ . 'view_process_start', 'cv_comp_ps_prevent_other_plugins' );
function cv_comp_ps_prevent_other_plugins() {
	// title-remover plugin: cause (no title)
	remove_filter( 'the_title', 'wptr_supress_title', 10, 2 );

	// Easy Custom Auto Excerpt: cause no featured image found
	if ( isset( $GLOBALS[ 'ECAE_The_Post' ] ) ) {
		remove_filter( 'get_post_metadata', array( $GLOBALS[ 'ECAE_The_Post' ], 'get_post_metadata' ), 10, 4 );
	}
}

/** Prevent output of Easy Footnotes plugin from showing in View (which shows Full Content of post) 
 * @since 2.3.0
 */
add_action( 'pt_cv_view_process_start', 'cvp_comp_plugin_easyfootnotes' );
function cvp_comp_plugin_easyfootnotes() {
	global $easyFootnotes;
	if ( isset( $easyFootnotes ) ) {
		$is_start	 = current_filter() === 'pt_cv_view_process_start';
		$func		 = $is_start ? 'remove_filter' : 'add_filter';

		$func( 'the_content', array( $easyFootnotes, 'easy_footnote_after_content' ), 20 );
		$func( 'the_content', array( $easyFootnotes, 'easy_footnote_reset' ), 999 );

		if ( $is_start ) {
			add_action( 'pt_cv_view_process_end', 'cvp_comp_plugin_easyfootnotes' );
		}
	}
}

/** Prevent "whp-hide-posts" from causing multiple views on same page show same output
 * @since 2.3.1
 */
add_action( 'pre_get_posts', 'cv_comp_plugin_wph', 1 );
function cv_comp_plugin_wph( $query ) {
	$hook		 = 'pre_get_posts';
	$class		 = 'WHP_Post_Hide';
	$priority	 = 10;
	if ( $query->get( 'cv_get_view' ) && class_exists( $class ) && !empty( $GLOBALS[ 'wp_filter' ][ $hook ][ $priority ] ) ) {
		$arr = (array) $GLOBALS[ 'wp_filter' ][ $hook ][ $priority ];
		foreach ( array_keys( $arr ) as $filter ) {
            if ( strpos( $filter, 'exclude_posts' ) !== false ) {
                if ( !empty( $arr[ $filter ][ 'function' ][ 0 ] ) && is_a( $arr[ $filter ][ 'function' ][ 0 ], $class ) ) {
					remove_filter( $hook, $filter, $priority );
				}
			}
        }
    }
	return $query;
}
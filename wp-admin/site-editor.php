<?php
/**
 * Site Editor administration screen.
 *
 * @package WordPress
 * @subpackage Administration
 */

global $post, $editor_styles;

/** WordPress Administration Bootstrap */
require_once __DIR__ . '/admin.php';

if ( ! current_user_can( 'edit_theme_options' ) ) {
	wp_die(
		'<h1>' . __( 'You need a higher level of permission.' ) . '</h1>' .
		'<p>' . __( 'Sorry, you are not allowed to edit theme options on this site.' ) . '</p>',
		403
	);
}

if ( ! wp_is_block_template_theme() ) {
	wp_die( __( 'The theme you are currently using is not compatible with Full Site Editing.' ) );
}

$parent_file = 'themes.php';

// Flag that we're loading the block editor.
$current_screen = get_current_screen();
$current_screen->is_block_editor( true );

// Default to is-fullscreen-mode to avoid jumps in the UI.
add_filter(
	'admin_body_class',
	static function( $classes ) {
		return "$classes is-fullscreen-mode";
	}
);

$block_editor_context = new WP_Block_Editor_Context();
$custom_settings      = array(
	'siteUrl'                              => site_url(),
	'postsPerPage'                         => get_option( 'posts_per_page' ),
	'styles'                               => get_block_editor_theme_styles(),
	'defaultTemplateTypes'                 => get_default_block_template_types(),
	'defaultTemplatePartAreas'             => get_allowed_block_template_part_areas(),
	'__experimentalBlockPatterns'          => WP_Block_Patterns_Registry::get_instance()->get_all_registered(),
	'__experimentalBlockPatternCategories' => WP_Block_Pattern_Categories_Registry::get_instance()->get_all_registered(),
);
$editor_settings      = get_block_editor_settings( $custom_settings, $block_editor_context );

if ( isset( $_GET['postType'] ) && ! isset( $_GET['postId'] ) ) {

	$post_type = get_post_type_object( $_GET['postType'] );

	if ( ! $post_type ) {
		wp_die( __( 'Invalid post type.' ) );
	}

	// Used in the HTML title tag.
	$title = $post_type->labels->name;

	$preload_paths = array(
		'/',
		'/wp/v2/types/' . $post_type->name . '?context=edit',
		'/wp/v2/types?context=edit',
		add_query_arg( 'context', 'edit', rest_get_route_for_post_type_items( $post_type ) ),
	);

	block_editor_rest_api_preload( $preload_paths, $block_editor_context );

	wp_add_inline_script(
		'wp-edit-site',
		sprintf(
			'wp.domReady( function() {
				wp.editSite.initializeList( "site-editor", "%s", %s );
			} );',
			$post_type->name,
			wp_json_encode( $editor_settings )
		)
	);

} else {

	// Used in the HTML title tag.
	$title = __( 'Editor (beta)' );

	$active_global_styles_id = WP_Theme_JSON_Resolver::get_user_custom_post_type_id();
	$active_theme            = wp_get_theme()->get_stylesheet();
	$preload_paths           = array(
		array( rest_get_route_for_post_type_items( 'attachment' ), 'OPTIONS' ),
		'/',
		'/wp/v2/types?context=edit',
		'/wp/v2/taxonomies?context=edit',
		add_query_arg( 'context', 'edit', rest_get_route_for_post_type_items( 'page' ) ),
		add_query_arg( 'context', 'edit', rest_get_route_for_post_type_items( 'post' ) ),
		add_query_arg( 'context', 'edit', rest_get_route_for_taxonomy_items( 'category' ) ),
		add_query_arg( 'context', 'edit', rest_get_route_for_taxonomy_items( 'post_tag' ) ),
		add_query_arg( 'context', 'edit', rest_get_route_for_post_type_items( 'wp_template' ) ),
		add_query_arg( 'context', 'edit', rest_get_route_for_post_type_items( 'wp_template_part' ) ),
		'/wp/v2/settings',
		'/wp/v2/themes?context=edit&status=active',
		'/wp/v2/global-styles/' . $active_global_styles_id . '?context=edit',
		'/wp/v2/global-styles/' . $active_global_styles_id,
		'/wp/v2/themes/' . $active_theme . '/global-styles',
	);

	block_editor_rest_api_preload( $preload_paths, $block_editor_context );

	wp_add_inline_script(
		'wp-edit-site',
		sprintf(
			'wp.domReady( function() {
				wp.editSite.initializeEditor( "site-editor", %s );
			} );',
			wp_json_encode( $editor_settings )
		)
	);

}

// Preload server-registered block schemas.
wp_add_inline_script(
	'wp-blocks',
	'wp.blocks.unstable__bootstrapServerSideBlockDefinitions(' . wp_json_encode( get_block_editor_server_block_settings() ) . ');'
);

wp_add_inline_script(
	'wp-blocks',
	sprintf( 'wp.blocks.setCategories( %s );', wp_json_encode( get_block_categories( $post ) ) ),
	'after'
);

wp_enqueue_script( 'wp-edit-site' );
wp_enqueue_script( 'wp-format-library' );
wp_enqueue_style( 'wp-edit-site' );
wp_enqueue_style( 'wp-format-library' );
wp_enqueue_media();

if (
	current_theme_supports( 'wp-block-styles' ) ||
	( ! is_array( $editor_styles ) || count( $editor_styles ) === 0 )
) {
	wp_enqueue_style( 'wp-block-library-theme' );
}

/** This action is documented in wp-admin/edit-form-blocks.php */
do_action( 'enqueue_block_editor_assets' );

require_once ABSPATH . 'wp-admin/admin-header.php';
?>

<div id="site-editor" class="edit-site"></div>

<?php

require_once ABSPATH . 'wp-admin/admin-footer.php';

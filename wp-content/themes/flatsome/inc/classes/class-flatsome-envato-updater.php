<?php
/**
 * Flatsome_Envato_Updater class.
 *
 * @package Flatsome
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * .
 */
final class Flatsome_Envato_Updater {

	/**
	 * The single class instance.
	 *
	 * @var object
	 */
	private static $instance = null;

	/**
	 * Main Flatsome_Envato_Updater instance
	 *
	 * @return Flatsome_Envato_Updater.
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Setup instance properties.
	 */
	private function __construct() {}

	/**
	 * Register actions and filters.
	 */
	public function init() {
		add_filter( 'pre_set_site_transient_update_themes', array( $this, 'get_update_info' ), 1, 99999 );
		add_filter( 'pre_set_transient_update_themes', array( $this, 'get_update_info' ), 1, 99999 );
		add_action( 'upgrader_package_options', array( $this, 'get_package_options' ), 9 );
	}

	/**
	 * Inject update data for Flatsome to `_site_transient_update_themes`.
	 * The `package` property is a temporary URL which will be replaced with
	 * an actual URL to a zip file in the `get_package_options` method when
	 * WordPress runs the upgrader.
	 *
	 * @param array $transient The pre-saved value of the `update_themes` site transient.
	 * @return array
	 */
	public function get_update_info( $transient ) {
		if ( ! isset( $transient->checked ) ) {
			return $transient;
		}

		$theme    = wp_get_theme( get_template() );
		$template = $theme->get_template();
		$version  = $theme->get( 'Version' );
		$flatsome = flatsome_envato()->api()->get_flatsome();

		if ( is_wp_error( $flatsome ) || $template !== 'flatsome' ) {
			return $transient;
		}

		if ( version_compare( $version, $flatsome['version'], '<' ) ) {
			$transient->response[ $template ] = array(
				'theme'       => $template,
				'new_version' => $flatsome['version'],
				'url'         => add_query_arg(
					array(
						'url'     => $flatsome['url'],
						'version' => $flatsome['version'],
					),
					esc_url( admin_url( 'admin.php?page=flatsome-version-info' ) )
				),
				'package'     => add_query_arg(
					array(
						'flatsome_envato_download' => true,
						'flatsome_envato_item_id'  => $flatsome['id'],
					),
					esc_url( admin_url( 'admin.php?page=flatsome-panel' ) )
				),
			);
		}

		return $transient;
	}

	/**
	 * Get a fresh package URL from Envato before running the WordPress upgrader.
	 *
	 * @param array $options Options used by the upgrader.
	 * @return array
	 */
	public function get_package_options( $options ) {
		$package = $options['package'];

		if ( false !== strrpos( $package, 'flatsome_envato_download' ) ) {
			parse_str( wp_parse_url( $package, PHP_URL_QUERY ), $vars );
			if ( $vars['flatsome_envato_item_id'] ) {
				$item_id            = $vars['flatsome_envato_item_id'];
				$options['package'] = flatsome_envato()->api()->get_package_url( $item_id );
			}
		}

		return $options;
	}
}

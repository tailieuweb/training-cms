<?php
/**
 * Flatsome_Envato_Admin class.
 *
 * @package Flatsome
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * The Flatsome Envato.
 */
final class Flatsome_Envato_Admin {

	/**
	 * The single class instance.
	 *
	 * @var object
	 */
	private static $instance = null;

	/**
	 * Main Flatsome_Envato_Admin instance
	 *
	 * @return Flatsome_Envato_Admin.
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
		add_action( 'admin_menu', array( $this, 'add_pages' ) );
		add_action( 'current_screen', array( $this, 'render_version_info_iframe' ) );
		add_action( 'admin_post_flatsome_envato_migrate', array( $this, 'ajax_delete_purchase_code' ) );
		add_action( 'admin_post_flatsome_envato_register', array( $this, 'ajax_save_registration_form' ) );
	}

	/**
	 * Add necessary admin pages.
	 */
	public function add_pages() {
		add_submenu_page( null, '', '', 'manage_options', 'flatsome-version-info', '__return_empty_string' );
	}

	/**
	 * Renders the update modal iframe.
	 *
	 * @param WP_Screen $screen WordPress admin screen.
	 */
	public function render_version_info_iframe( $screen ) {
		if ( $screen->base === 'admin_page_flatsome-version-info' ) {
			$url     = isset( $_GET['url'] ) ? wp_unslash( $_GET['url'] ) : '';
			$version = isset( $_GET['version'] ) ? wp_unslash( $_GET['version'] ) : '';
			include get_template_directory() . '/template-parts/admin/envato/version-info-iframe.php';
			die;
		}
	}

	/**
	 * Renders a message for sites with a purchase code.
	 *
	 * @return string
	 */
	public function render_message_form() {
		ob_start();
		include get_template_directory() . '/template-parts/admin/envato/message-form.php';
		return ob_get_clean();
	}

	/**
	 * Clears the purchase code and errors.
	 */
	public function ajax_delete_purchase_code() {
		check_admin_referer( 'flatsome_envato_migrate', 'flatsome_envato_migrate_nonce' );

		$referer = wp_unslash( $_POST['_wp_http_referer'] );

		$this->delete_wupdates_data();

		wp_safe_redirect( $referer );
		exit;
	}

	/**
	 * Renders a warning about unusual theme directory name.
	 *
	 * @return string
	 */
	public function render_directory_warning() {
		$template = get_template();

		ob_start();
		include get_template_directory() . '/template-parts/admin/envato/directory-warning.php';
		return ob_get_clean();
	}

	/**
	 * Renders the theme registration form.
	 *
	 * @param string $args Visibility options.
	 * @return string
	 */
	public function render_registration_form( $args = array() ) {
		$token         = flatsome_envato()->get_option( 'token' );
		$is_confirmed  = flatsome_envato()->get_option( 'confirmed' );
		$is_registered = flatsome_envato()->is_registered();
		$errors        = flatsome_envato()->get_errors();
		$args          = wp_parse_args( $args, array(
			'show_intro'  => true,
			'show_terms'  => true,
			'show_submit' => true,
		) );

		if ( $is_registered ) {
			$token = flatsome_hide_chars( $token );
		}

		ob_start();
		include get_template_directory() . '/template-parts/admin/envato/register-form.php';
		return ob_get_clean();
	}

	/**
	 * Saves the theme registration form.
	 */
	public function ajax_save_registration_form() {
		check_admin_referer( 'flatsome_envato_register', 'flatsome_envato_register_nonce' );

		$token     = isset( $_POST['flatsome_envato_token'] ) ? wp_unslash( $_POST['flatsome_envato_token'] ) : '';
		$confirmed = (bool) wp_unslash( $_POST['flatsome_envato_terms'] );
		$referer   = wp_unslash( $_POST['_wp_http_referer'] );

		if ( ! empty( $token ) ) {
			$this->update_token( $token, $confirmed );
		} else {
			// Unregister theme if no token was provided.
			flatsome_envato()->delete_options();
			flatsome_envato()->set_errors( array() );
		}

		wp_safe_redirect( $referer );
		exit;
	}

	/**
	 * Updates the token in the options.
	 *
	 * @param string $token     The new token.
	 * @param bool   $confirmed Whether the user has confirmed the Envato License Terms.
	 * @return void
	 */
	public function update_token( $token, $confirmed = false ) {
		flatsome_envato()->set_option( 'token', $token );
		flatsome_envato()->set_option( 'confirmed', (bool) $confirmed );

		$result = flatsome_envato()->api()->whoami();
		$theme  = flatsome_envato()->api()->get_flatsome();
		$errors = array();

		if ( ! $confirmed ) {
			$errors[] = __( 'You must confirm the Envato License Terms.', 'flatsome' );
		}

		if ( strlen( $token ) === 36 && substr_count( $token, '-' ) === 4 ) {
			$errors[] = sprintf(
				/* translators: 1: Create token URL */
				__( 'The provided value seems to be a purchase code. An Envato token is required to register. <a href="%s" target="_blank">Generate a token here</a>.', 'flatsome' ),
				esc_url( flatsome_envato()->get_create_token_url() )
			);
		} elseif ( is_wp_error( $result ) ) {
			// Fail if the token was invalid or an HTTP error occurred.
			$errors[] = $result->get_error_message();
		} elseif ( is_wp_error( $theme ) ) {
			// Fail if the token dosn't have Flatsome as one if it's purchased items.
			$errors[] = $theme->get_error_message();
		}

		if ( empty( $errors ) ) {
			// Delete all WP Updates data if the token is valid.
			$this->delete_wupdates_data();
		}

		flatsome_envato()->set_option( 'is_valid', empty( $errors ) );
		flatsome_envato()->set_errors( $errors );
	}

	/**
	 * Delete data associated with WP Updates.
	 *
	 * @return void
	 */
	protected function delete_wupdates_data() {
		$slug = flatsome_theme_key();

		delete_option( $slug . '_wup_buyer' );
		delete_option( $slug . '_wup_sold_at' );
		delete_option( $slug . '_wup_purchase_code' );
		delete_option( $slug . '_wup_supported_until' );
		delete_option( $slug . '_wup_errors' );

		// Delete `update_themes` transients in case
		// there are pending updates from wupdates.
		delete_site_transient( 'update_themes' );
		delete_transient( 'update_themes' );
	}
}

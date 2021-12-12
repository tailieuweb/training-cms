<?php
/**
 * Flatsome_Envato class.
 *
 * @package Flatsome
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * The Flatsome Envato.
 */
final class Flatsome_Envato {

	/**
	 * The single class instance.
	 *
	 * @var object
	 */
	private static $instance = null;

	/**
	 * The setting option name.
	 *
	 * @var string
	 */
	private $option_name;

	/**
	 * Main Flatsome_Envato instance
	 *
	 * @return Flatsome_Envato.
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
	private function __construct() {
		$this->slug        = 'flatsome-envato';
		$this->option_name = self::sanitize_key( $this->slug );
	}

	/**
	 * Initialize classes.
	 */
	public function init() {
		$this->admin()->init();
		$this->updater()->init();
	}

	/**
	 * The Flatsome_Envato_Admin class.
	 */
	public function admin() {
		return Flatsome_Envato_Admin::instance();
	}

	/**
	 * The Flatsome_Envato_API class.
	 */
	public function api() {
		return Flatsome_Envato_API::instance();
	}

	/**
	 * The Flatsome_Envato_Updater class.
	 */
	public function updater() {
		return Flatsome_Envato_Updater::instance();
	}

	/**
	 * Checks whether Flatsome is registered or not.
	 *
	 * @return boolean
	 */
	public function is_registered() {
		return (
			$this->get_option( 'token' ) !== '' &&
			$this->get_option( 'is_valid' )
		);
	}

	/**
	 * Set option value.
	 *
	 * @param string $name Option name.
	 * @param mixed  $option Option data.
	 */
	public function set_option( $name, $option ) {
		$options          = self::get_options();
		$name             = self::sanitize_key( $name );
		$options[ $name ] = esc_html( $option );

		$this->set_options( $options );

		if ( $name === 'token' ) {
			$this->api()->token = $option;
		}
	}

	/**
	 * Set options.
	 *
	 * @param mixed $options Option data.
	 */
	public function set_options( $options ) {
		update_option( $this->option_name, $options );
	}

	/**
	 * Return the options array.
	 */
	public function get_options() {
		return get_option( $this->option_name, array() );
	}

	/**
	 * Delete options.
	 */
	public function delete_options() {
		delete_option( $this->option_name );
	}

	/**
	 * Set or delete Envato errors.
	 *
	 * @param string[] $errors The error messages.
	 * @return void
	 */
	public function set_errors( array $errors ) {
		if ( count( $errors ) ) {
			update_option( 'flatsome_envato_errors', $errors );
		} else {
			delete_option( 'flatsome_envato_errors' );
		}
	}

	/**
	 * Get Envato errors.
	 *
	 * @return string[]
	 */
	public function get_errors() {
		return get_option( 'flatsome_envato_errors', array() );
	}

	/**
	 * Return a value from the option settings array.
	 *
	 * @param string $name Option name.
	 * @param mixed  $default The default value if nothing is set.
	 * @return mixed
	 */
	public function get_option( $name, $default = '' ) {
		$options = self::get_options();
		$name    = self::sanitize_key( $name );
		return isset( $options[ $name ] ) ? $options[ $name ] : $default;
	}

	/**
	 * Get a URL with token permissions prefilled.
	 *
	 * @return string
	 */
	public function get_create_token_url() {
		$permissions = $this->api()->get_required_permissions();
		$token_url   = 'https://build.envato.com/create-token/';

		foreach ( $permissions as $key => $value ) {
			if ( $key !== 'default' ) {
				$token_url = add_query_arg( $key, 't', $token_url );
			}
		}

		return $token_url;
	}

	/**
	 * Sanitize data key.
	 *
	 * @param string $key An alpha numeric string to sanitize.
	 * @return string
	 */
	private function sanitize_key( $key ) {
		return preg_replace( '/[^A-Za-z0-9\_]/i', '', str_replace( array( '-', ':' ), '_', $key ) );
	}
}

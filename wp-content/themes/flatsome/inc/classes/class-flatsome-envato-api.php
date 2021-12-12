<?php
/**
 * Flatsome_Envato_API class.
 *
 * @package Flatsome
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Creates the Envato API connection.
 */
class Flatsome_Envato_API {

	/**
	 * The single class instance.
	 *
	 * @var object
	 */
	private static $instance = null;

	/**
	 * Purchased themes.
	 *
	 * @var array|null
	 */
	private static $themes = null;

	/**
	 * The Envato API personal token.
	 *
	 * @var string
	 */
	public $token;

	/**
	 * The Flatsome version.
	 *
	 * @var string
	 */
	public $version;

	/**
	 * Main Flatsome_Envato_API instance
	 *
	 * @return object The Flatsome_Envato_API instance.
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
		$theme = wp_get_theme( get_template() );

		$this->token   = flatsome_envato()->get_option( 'token' );
		$this->version = $theme->get( 'Version' );
	}

	/**
	 * Get the required API permissions.
	 *
	 * @return array
	 */
	public function get_required_permissions() {
		return array(
			'default'           => 'View and search Envato sites',
			'user:username'     => 'View the your Envato Account username',
			'purchase:download' => 'Download your purchased items',
			'purchase:list'     => 'List purchases you\'ve made',
			'purchase:verify'   => 'Verify purchases you\'ve made',
		);
	}

	/**
	 * Query the Envato API.
	 *
	 * @uses wp_remote_get() To perform an HTTP request.
	 *
	 * @since 1.0.0
	 *
	 * @param  string $url  API request URL, including the request method, parameters, & file type.
	 * @param  array  $args The arguments passed to `wp_remote_get`.
	 * @return array|WP_Error  The HTTP response.
	 */
	public function request( $url, $args = array() ) {
		$defaults = array(
			'headers' => array(
				'Authorization' => 'Bearer ' . $this->token,
				'User-Agent'    => 'WordPress - Flatsome ' . $this->version,
			),
			'timeout' => 14,
		);

		$args  = wp_parse_args( $args, $defaults );
		$token = trim( str_replace( 'Bearer', '', $args['headers']['Authorization'] ) );

		if ( empty( $token ) ) {
			return new WP_Error( 'api_token_error', __( 'An API token is required.', 'flatsome' ) );
		}

		$debugging_information = [
			'request_url' => $url,
		];

		// Make an API request.
		$response = wp_remote_get( esc_url_raw( $url ), $args );

		// Check the response code.
		$response_code    = wp_remote_retrieve_response_code( $response );
		$response_message = wp_remote_retrieve_response_message( $response );

		$debugging_information['response_code']   = $response_code;
		$debugging_information['response_cf_ray'] = wp_remote_retrieve_header( $response, 'cf-ray' );
		$debugging_information['response_server'] = wp_remote_retrieve_header( $response, 'server' );

		if ( ! empty( $response->errors ) && isset( $response->errors['http_request_failed'] ) ) {
			return new WP_Error( 'http_error', esc_html( current( $response->errors['http_request_failed'] ) ), $debugging_information );
		}

		if ( 200 !== $response_code && ! empty( $response_message ) ) {
			return new WP_Error( $response_code, $response_message, $debugging_information );
		} elseif ( 200 !== $response_code ) {
			return new WP_Error( $response_code, __( 'An unknown API error occurred.', 'flatsome' ), $debugging_information );
		} else {
			$return = json_decode( wp_remote_retrieve_body( $response ), true );
			if ( null === $return ) {
				return new WP_Error( 'api_error', __( 'An unknown API error occurred.', 'flatsome' ), $debugging_information );
			}
			return $return;
		}
	}

	/**
	 * Validate the current token.
	 *
	 * @return bool|WP_Error
	 */
	public function whoami() {
		$response = $this->request( 'https://api.envato.com/whoami' );

		if ( is_wp_error( $response ) ) {
			if ( is_string( $response->get_error_code() ) ) {
				return $response;
			}

			return new WP_Error(
				'token_error',
				sprintf(
					/* translators: 1: Create token URL */
					__( 'Missing or invalid token. Double-check your token or try to <a href="%s" target="_blank">create a new one</a>.', 'flatsome' ),
					esc_url( flatsome_envato()->get_create_token_url() )
				)
			);
		} else {
			$required_permissions = $this->get_required_permissions();
			$missing_permissions  = array();

			foreach ( $required_permissions as $required_scope => $required_scope_name ) {
				if ( ! in_array( $required_scope, $response['scopes'], true ) ) {
					$missing_permissions[] = $required_scope_name;
				}
			}

			if ( count( $missing_permissions ) ) {
				$list_items = array_reduce( $missing_permissions, function ( $res, $name ) {
					return $res . "<li>{$name}</li>";
				}, '');
				$list_html  = "<ul class=\"ul-disc\">{$list_items}</ul>";
				/* translators: 1: Permissions list. */
				$error_message = __( 'The token is missing the following permissions: %s', 'flatsome' );
				return new WP_Error( 'permissions_error', sprintf( $error_message, $list_html ) );
			}
		}

		return true;
	}

	/**
	 * Get item download URL.
	 *
	 * @param  int   $id The item ID.
	 * @param  array $args The arguments passed to `wp_remote_get`.
	 * @return bool|array The theme info.
	 */
	public function get_package_url( $id, $args = array() ) {
		$url      = 'https://api.envato.com/v2/market/buyer/download?item_id=' . $id . '&shorten_url=true';
		$response = $this->request( $url, $args );

		if (
			is_wp_error( $response ) ||
			empty( $response ) ||
			! empty( $response['error'] ) ||
			empty( $response['wordpress_theme'] )
		) {
			return false;
		}

		return $response['wordpress_theme'];
	}

	/**
	 * Get Flatsome theme data info from Envato.
	 *
	 * @return array|WP_Error The theme info.
	 */
	public function get_flatsome() {
		if ( is_null( self::$themes ) ) {
			self::$themes = $this->get_themes();
		}

		$return = new WP_Error( 'not_found', __( "The token is valid, but the Envato user associated with it doesn't seem to have purchased Flatsome. Double-check that you were logged in with the same user that bought Flatsome when you created the token.", 'flatsome' ) );

		if ( empty( self::$themes ) ) {
			return $return;
		}

		foreach ( self::$themes as $theme ) {
			if ( isset( $theme['name'] ) && strtolower( $theme['name'] ) === 'flatsome' ) {
				$return = $theme;
				break;
			}
		}

		return $return;
	}

	/**
	 * Get the list of available themes.
	 *
	 * @param  array $args The arguments passed to `wp_remote_get`.
	 * @param  int   $page The page to fetch.
	 * @return array Normalized theme items.
	 */
	private function get_themes( $args = array(), $page = null ) {
		$url      = 'https://api.envato.com/v2/market/buyer/list-purchases?filter_by=wordpress-themes';
		$url     .= $page ? '&page=' . $page : '';
		$response = $this->request( $url, $args );
		$themes   = array();

		if ( is_wp_error( $response ) || empty( $response ) || empty( $response['results'] ) ) {
			return $themes;
		}

		foreach ( $response['results'] as $theme ) {
			$themes[] = $this->normalize_theme( $theme['item'] );
		}

		if ( count( $themes ) === 100 ) {
			$next_page = $page ? $page + 1 : 2;
			if ( $next_page <= 5 ) {
				$more_themes = $this->get_themes( $args, $next_page );
				$themes      = array_merge( $themes, $more_themes );
			}
		}

		return $themes;
	}

	/**
	 * Normalize result from the Envato API.
	 *
	 * @param  array $theme An array of API request values.
	 * @return array Normalized theme data.
	 */
	private function normalize_theme( $theme ) {
		return array(
			'id'      => $theme['id'],
			'name'    => ! empty( $theme['wordpress_theme_metadata']['theme_name'] ) ? $theme['wordpress_theme_metadata']['theme_name'] : '',
			'version' => ! empty( $theme['wordpress_theme_metadata']['version'] ) ? $theme['wordpress_theme_metadata']['version'] : '',
			'url'     => ! empty( $theme['url'] ) ? $theme['url'] : '',
		);
	}

	/**
	 * Remove all non unicode characters in a string.
	 *
	 * @param string $retval The string to fix.
	 * @return string
	 */
	private static function remove_non_unicode( $retval ) {
		return preg_replace( '/[\x00-\x1F\x80-\xFF]/', '', $retval );
	}
}

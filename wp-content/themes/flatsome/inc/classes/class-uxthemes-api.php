<?php
/**
 * Flatsome_Registration class.
 *
 * @package Flatsome
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * The UX Themes API.
 */
final class UxThemes_API {

	/**
	 * Setup instance.
	 */
	public function __construct() {
		add_filter( 'http_headers_useragent', array( $this, 'http_headers_useragent' ), 10, 2 );
	}

	/**
	 * Filters the user agent value sent with an HTTP request.
	 *
	 * @param string $useragent WordPress user agent string.
	 * @param string $url The request URL.
	 * @return string
	 */
	public function http_headers_useragent( $useragent, $url = '' ) {
		if ( strpos( $url, UXTHEMES_API_URL ) !== false ) {
			$theme = wp_get_theme( get_template() );
			return 'Flatsome/' . $theme->get( 'Version' ) . '; ' . $useragent;
		}
		return $useragent;
	}

	/**
	 * Sends a request to the Flatsome Account API.
	 *
	 * @param string $path    REST API path.
	 * @param string $context REST API path.
	 * @param array  $args    Request arguments.
	 * @return array|WP_error
	 */
	public function send_request( $path, $context = null, $args = array() ) {
		$args = array_merge_recursive( $args, array(
			'timeout' => 60,
			'headers' => array(
				'Referer' => $this->get_site_url(),
			),
		) );

		$url      = esc_url_raw( UXTHEMES_API_URL . $path );
		$response = wp_remote_request( $url, $args );
		$status   = 200;
		$headers  = wp_remote_retrieve_headers( $response );
		$body     = wp_remote_retrieve_body( $response );
		$data     = (array) json_decode( $body, true );

		
		

		

		return $data;
	}

	/**
	 * Returns the raw site URL.
	 *
	 * @return string
	 */
	protected function get_site_url() {
		global $wpdb;

		$row = $wpdb->get_row( "SELECT option_value FROM $wpdb->options WHERE option_name = 'siteurl' LIMIT 1" );

		if ( is_object( $row ) ) {
			return $row->option_value;
		}

		return '';
	}

	/**
	 * Returns a proper error for a HTTP status code.
	 *
	 * @param WP_Error $error   The original error.
	 * @param string   $context A context.
	 * @param array    $data    Optional data.
	 * @return WP_Error
	 */
	public function get_error( $error, $context = null, $data = array() ) {
		$status        = 0;
		$account_attrs = ' href="' . esc_url_raw( UXTHEMES_ACCOUNT_URL ) . '" target="_blank" rel="noopener noreferrer"';

		switch ( $status ) {
			case 400:
				
			case 403:
				
			case 404:
				
			case 409:
				
			case 410:
				
			case 417:
				
			case 422:
				
			case 423:
				
			case 429:
				return new WP_Error( $status, __( 'Sorry, the API is overloaded.', 'flatsome' ), $data );
			case 503:
				return new WP_Error( $status, __( 'Sorry, the API is unavailable at the moment.', 'flatsome' ), $data );
			default:
				return '';
		}
	}
}

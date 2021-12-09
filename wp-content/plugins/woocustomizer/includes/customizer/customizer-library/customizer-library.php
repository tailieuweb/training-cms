<?php
/**
 * Customizer Library
 *
 * @package        WooCustomizer_Library
 * @author         Devin Price, The Theme Foundry
 * @license        GPL-2.0+
 * @version        1.3.0
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Continue if the WooCustomizer_Library isn't already in use.
if ( ! class_exists( 'WooCustomizer_Library' ) ) : // Helper functions to output the customizer controls.
	//require plugin_dir_path( __FILE__ ) . 'extensions/interface.php';
	require_once 'extensions/interface.php';

	// Helper functions for customizer sanitization.
	require_once 'extensions/sanitization.php';

	// Helper functions to build the inline CSS.
	require_once 'extensions/style-builder.php';

	// Utility functions for the customizer.
	require_once 'extensions/utilities.php';

	/**
	 * Class wrapper with useful methods for interacting with the theme customizer.
	 */
	class WooCustomizer_Library {

		/**
		 * The one instance of WooCustomizer_Library.
		 *
		 * @since 1.0.0.
		 *
		 * @var   WooCustomizer_Library_Styles    The one instance for the singleton.
		 */
		private static $instance;

		/**
		 * The array for storing $options.
		 *
		 * @since 1.0.0.
		 *
		 * @var   array    Holds the options array.
		 */

		public $options = array();

		/**
		 * Instantiate or return the one WooCustomizer_Library instance.
		 *
		 * @since  1.0.0.
		 *
		 * @return WooCustomizer_Library
		 */
		public static function instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		public function add_options( $options = array() ) {
			$this->options = array_merge( $options, $this->options );
		}

		public function get_options() {
			return $this->options;
		}

}

endif;

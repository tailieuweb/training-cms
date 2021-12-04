<?php
class DispatcherWpf {
	protected static $_pref = 'wpf_';

	public static function addAction( $tag, $function_to_add, $priority = 10, $accepted_args = 1 ) {
		if (strpos($tag, 'wpf_') === false) {
			$tag = self::$_pref . $tag;
		}
		return add_action( $tag, $function_to_add, $priority, $accepted_args );
	}
	public static function doAction( $tag ) {
		$t = $tag;
		if (strpos($t, 'wpf_') === false) {
			$t = self::$_pref . $t;
		}
		$numArgs = func_num_args();
		if ($numArgs > 1) {
			$args = array( $t );
			for ($i = 1; $i < $numArgs; $i++) {
				$args[] = func_get_arg($i);
			}
			return call_user_func_array('do_action', $args);
		}
		return do_action($t);
	}
	public static function addFilter( $tag, $function_to_add, $priority = 10, $accepted_args = 1 ) {
		$t = $tag;
		if (strpos($t, 'wpf_') === false) {
			$t = self::$_pref . $t;
		}
		return add_filter( $t, $function_to_add, $priority, $accepted_args );
	}
	public static function applyFilters( $tag, $value ) {
		$t = $tag;
		if (strpos($t, 'wpf_') === false) {
			$t = self::$_pref . $t;
		}
		if (func_num_args() > 2) {
			$args = array($t);
			for ($i = 1; $i < func_num_args(); $i++) {
				$args[] = func_get_arg($i);
			}
			return call_user_func_array('apply_filters', $args);
		} else {
			return apply_filters( $t, $value );
		}
	}
}

<?php
namespace ETWWElementor\Modules\FlipBox;

use ETWWElementor\Base\Module_Base;

if(! defined('ABSPATH')) exit; // Exit if accessed directly

class Module extends Module_Base {

	public function get_widgets() {
		return [
			'FlipBox',
		];
	}

	public function get_name() {
		return 'etww-flip-box';
	}
}

<?php
namespace ETWWElementor\Modules\QueryPost;

use ETWWElementor\Base\Module_Base;
use ETWWElementor\Modules\QueryPost\Controls\Query;

if(! defined('ABSPATH')) exit; // Exit if accessed directly

class Module extends Module_Base {

	const QUERY_CONTROL_ID = 'etww-query-posts';

	public function __construct() {
		parent::__construct();

		$this->add_actions();
	}

	public function get_name() {
		return 'query-control';
	}

	public function register_controls() {
		$controls_manager = \Elementor\Plugin::$instance->controls_manager;
		$controls_manager->register_control(self::QUERY_CONTROL_ID, new Query());
	}

	public function get_posts_title_by_id() {

		$ids = isset($_POST['id']) ? sanitize_text_field( wp_unslash($_POST['id'])) : array();

		$results = [];

		$query = new \WP_Query(
			[
				'post_type'      => 'any',
				'post__in'       => $ids,
				'posts_per_page' => -1,
			]
		);

		foreach($query->posts as $post) {
			$results[ $post->ID ] = $post->post_title;
		}

		// return the results in json.
		wp_send_json($results);
	}

	public function get_posts_by_query() {

		$search_string = isset($_POST['q']) ? sanitize_text_field( wp_unslash($_POST['q'])) : '';
		$req_post_type = isset($_POST['post_type']) ? sanitize_text_field( wp_unslash($_POST['post_type'])) : 'all';

		$data   = array();
		$result = array();

		$args = array(
			'public'   => true,
			'_builtin' => false,
		);

		$output   = 'names'; // names or objects, note names is the default.
		$operator = 'and'; // also supports 'or'.

		if('all' === $req_post_type) {
			$post_types = get_post_types($args, $output, $operator);

			$post_types['Posts'] = 'post';
			$post_types['Pages'] = 'page';
		} else {
			$post_types[ $req_post_type ] = $req_post_type;
		}

		foreach($post_types as $key => $post_type) {

			$data = array();

			add_filter('posts_search', array($this, 'search_only_titles'), 10, 2);

			$query = new \WP_Query(
				array(
					's'              => $search_string,
					'post_type'      => $post_type,
					'posts_per_page' => - 1,
				)
			);

			if($query->have_posts()) {
				while($query->have_posts()) {
					$query->the_post();
					$title  = get_the_title();
					$title .= (0 != $query->post->post_parent) ? ' (' . get_the_title($query->post->post_parent) . ')' : '';
					$id     = get_the_id();
					$data[] = array(
						'id'   => $id,
						'text' => $title,
					);
				}
			}

			if(is_array($data) && ! empty($data)) {
				$result[] = array(
					'text'     => $key,
					'children' => $data,
				);
			}
		}

		$data = array();

		wp_reset_postdata();

		// return the result in json.
		wp_send_json($result);
	}

	public function search_only_titles($search, $wp_query) {
		if(! empty($search) && ! empty($wp_query->query_vars['search_terms'])) {
			global $wpdb;

			$q = $wp_query->query_vars;
			$n = ! empty($q['exact']) ? '' : '%';

			$search = array();

			foreach((array) $q['search_terms'] as $term) {
				$search[] = $wpdb->prepare("$wpdb->posts.post_title LIKE %s", $n . $wpdb->esc_like($term) . $n);
			}

			if(! is_user_logged_in()) {
				$search[] = "$wpdb->posts.post_password = ''";
			}

			$search = ' AND ' . implode(' AND ', $search);
		}

		return $search;
	}

	protected function add_actions() {
		add_action('wp_ajax_etww_get_posts_by_query', array($this, 'get_posts_by_query'));
		add_action('wp_ajax_etww_get_posts_title_by_id', array($this, 'get_posts_title_by_id'));
		add_action('elementor/controls/controls_registered', [ $this, 'register_controls' ]);
	}
}


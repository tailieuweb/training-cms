<?php

/**
 * Get posts and terms in editor
 *
 * @since 6.1.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Porto_Elementor_Ajax_Select2_Api {

	public function action( $request ) {
		if ( isset( $request['method'] ) && in_array( $request['method'], array( 'page', 'post', 'product', 'portfolio', 'member', 'porto_builder', 'faq' ) ) ) {
			return $this->get_posts( $request );
		} elseif ( isset( $request['method'] ) && in_array( $request['method'], array( 'product_cat', 'category', 'portfolio_cat', 'member_cat', 'faq_cat', 'nav_menu' ) ) ) {
			return $this->get_terms( $request );
		}
	}

	public function get_posts( $request ) {
		$query_args = [
			'post_type'      => sanitize_text_field( $request['method'] ),
			'post_status'    => 'publish',
			'posts_per_page' => 15,
		];

		if ( isset( $request['ids'] ) ) {
			if ( empty( $request['ids'] ) ) {
				return [ 'results' => [] ];
			}
			$query_args['post__in'] = explode( ',', sanitize_text_field( $request['ids'] ) );
			$query_args['orderby']  = 'post__in';
			$query_args['order']    = 'ASC';
		}
		if ( isset( $request['s'] ) ) {
			$query_args['s'] = sanitize_text_field( $request['s'] );
		}
		if ( 'porto_builder' == $request['method'] ) {
			$query_args['tax_query'] = [
				[
					'taxonomy' => PortoBuilders::BUILDER_TAXONOMY_SLUG,
					'field'    => 'name',
					'terms'    => [ 'block' ],
				],
			];
		}

		$query   = new WP_Query( $query_args );
		$options = [];
		if ( $query->have_posts() ) :
			if ( isset( $request['add_default'] ) ) {
				$options[] = array(
					'id'   => '',
					'text' => __( 'None', 'porto-functionality' ),
				);
			}
			$posts = $query->get_posts();
			foreach ( $posts as $p ) {
				$options[] = [
					'id'   => (int) $p->ID,
					'text' => str_replace( array( '&amp;', '&#039;' ), array( '&', '\'' ), esc_html( $p->post_title ) ),
				];
			}
		endif;
		return [ 'results' => $options ];
	}

	public function get_terms( $request ) {
		if ( ! taxonomy_exists( sanitize_text_field( $request['method'] ) ) ) {
			return [ 'results' => [] ];
		}
		$query_args = [
			'taxonomy'   => sanitize_text_field( $request['method'] ), // taxonomy name
			'hide_empty' => false,
		];

		if ( isset( $request['ids'] ) ) {
			if ( empty( $request['ids'] ) ) {
				return [ 'results' => [] ];
			}
			$query_args['include'] = explode( ',', sanitize_text_field( $request['ids'] ) );
			$query_args['orderby'] = 'include';
			$query_args['order']   = 'ASC';
		}
		if ( isset( $request['s'] ) ) {
			$query_args['name__like'] = sanitize_text_field( $request['s'] );
		}

		$terms   = get_terms( $query_args );
		$options = [];
		if ( count( $terms ) ) :
			if ( isset( $request['add_default'] ) ) {
				$options[] = array(
					'id'   => '',
					'text' => __( 'Default', 'porto-functionality' ),
				);
			}
			foreach ( $terms as $term ) {
				$options[] = [
					'id'   => (int) $term->term_id,
					'text' => str_replace( array( '&amp;', '&#039;' ), array( '&', '\'' ), esc_html( $term->name ) ),
				];
			}
		endif;
		return [ 'results' => $options ];
	}
}

function porto_elementor_ajax_select2_api( WP_REST_Request $request ) {
	$class = new Porto_Elementor_Ajax_Select2_Api();
	return $class->action( $request );
}

add_action(
	'rest_api_init',
	function () {
		register_rest_route(
			'ajaxselect2/v1',
			'/(?P<method>\w+)/',
			array(
				'methods'             => 'GET',
				'callback'            => 'porto_elementor_ajax_select2_api',
				'permission_callback' => '__return_true',
			)
		);
	}
);

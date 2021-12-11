<?php

use Elementor\Group_Control_Typography;
use Elementor\Plugin;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes;

/**
 * Elementor Items (Elements)
 *
 * @since   0.1.0
 * @package AnWP_Post_Grid
 */

class AnWP_Post_Grid_Elements {

	/**
	 * Parent plugin class.
	 *
	 * @var AnWP_Post_Grid
	 * @since  0.1.0
	 */
	protected $plugin = null;

	/**
	 * Parent plugin class.
	 *
	 * @since  0.5.1
	 */
	public $published_posts = 0;

	/**
	 * Parent plugin class.
	 *
	 * @since  0.5.1
	 */
	public $published_posts_limit = 150;

	/**
	 * Constructor.
	 *
	 * @param AnWP_Post_Grid $plugin Main plugin object.
	 *
	 * @since  0.1.0
	 *
	 */
	public function __construct( $plugin ) {

		$this->plugin = $plugin;

		// Get number of published posts
		$counted_posts = wp_count_posts();

		if ( ! empty( $counted_posts->publish ) ) {
			$this->published_posts = $counted_posts->publish;
		}

		// Init Hooks
		$this->hooks();
	}

	/**
	 * Initiate our hooks.
	 *
	 * @since 0.1.0
	 */
	public function hooks() {

		// Controls
		add_action( 'elementor/controls/controls_registered', [ $this, 'register_controls' ] );
		add_action( 'wp_ajax_anwp_pg_selector_data', [ $this, 'get_selector_data' ] );
		add_action( 'wp_ajax_anwp_pg_selector_initial', [ $this, 'get_selector_initial' ] );

		// Add Plugin actions
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'init_widgets' ] );
		add_filter( 'elementor/editor/localize_settings', [ $this, 'promote_premium_widgets' ] );

		add_action( 'wp_ajax_nopriv_anwp_pg_load_more_posts', [ $this, 'ajax_load_more' ] );
		add_action( 'wp_ajax_anwp_pg_load_more_posts', [ $this, 'ajax_load_more' ] );

		add_action( 'wp_ajax_nopriv_anwp_pg_ajax_pagination_load', [ $this, 'ajax_pagination_load' ] );
		add_action( 'wp_ajax_anwp_pg_ajax_pagination_load', [ $this, 'ajax_pagination_load' ] );

		// Add premium prove at the end of all pages
		add_action( 'anwp-pg-el/element/before_controls_end', [ $this, 'load_promo_tab' ] );

		// Load sections
		add_action( 'anwp-pg-el/general/section_query', [ $this, 'load_query_section' ] );
		add_action( 'anwp-pg-el/general/section_header', [ $this, 'load_header_section' ] );
	}

	/**
	 * Register plugin controls.
	 *
	 * @since 0.8.3
	 */
	public function register_controls() {

		$controls_manager = Plugin::$instance->controls_manager;
		$controls_manager->register_control( 'anwp-id-selector', new AnWP_Post_Grid_Control_Id_Selector() );
	}

	/**
	 * Get Instance Selector Data
	 *
	 * @since 0.8.3
	 */
	public function get_selector_data() {

		// Check if our nonce is set.
		if ( ! isset( $_POST['nonce'] ) ) {
			wp_send_json_error( 'Error : Unauthorized action' );
		}

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $_POST['nonce'], 'ajax_anwp_pg_nonce' ) ) {
			wp_send_json_error( 'Error : Unauthorized action' );
		}

		// Check the user's permissions.
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( 'Error : Unauthorized action' );
		}

		// Get POST search data
		$search_data = [
			'context' => $_POST['context'] ? sanitize_text_field( $_POST['context'] ) : '',
			's'       => isset( $_POST['s'] ) ? sanitize_text_field( $_POST['s'] ) : '',
		];

		if ( ! in_array( $search_data['context'], [ 'tags', 'categories', 'posts', 'authors' ], true ) ) {
			wp_send_json_error();
		}

		$html_output = '';

		switch ( $search_data['context'] ) {
			case 'tags':
				$html_output = $this->get_selector_tags_data( $search_data );
				break;

			case 'categories':
				$html_output = $this->get_selector_categories_data( $search_data );
				break;

			case 'authors':
				$html_output = $this->get_selector_authors_data( $search_data );
				break;

			case 'posts':
				$html_output = $this->get_selector_posts_data( $search_data );
				break;
		}

		wp_send_json_success( [ 'html' => $html_output ] );
	}

	/**
	 * Get Instance Selector Data
	 *
	 * @since 0.8.3
	 */
	public function get_selector_initial() {

		// Check if our nonce is set.
		if ( ! isset( $_POST['nonce'] ) ) {
			wp_send_json_error( 'Error : Unauthorized action' );
		}

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $_POST['nonce'], 'ajax_anwp_pg_nonce' ) ) {
			wp_send_json_error( 'Error : Unauthorized action' );
		}

		// Check the user's permissions.
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( 'Error : Unauthorized action' );
		}

		// Get context
		$data_context = isset( $_POST['data_context'] ) ? sanitize_text_field( $_POST['data_context'] ) : '';

		if ( ! in_array( $data_context, [ 'tags', 'categories', 'posts', 'authors' ], true ) ) {
			wp_send_json_error();
		}

		// Initial
		$data_initial = isset( $_POST['initial'] ) ? wp_parse_id_list( $_POST['initial'] ) : [];

		if ( empty( $data_initial ) ) {
			wp_send_json_error();
		}

		$output = '';

		switch ( $data_context ) {
			case 'tags':
				$output = $this->get_selector_tags_initial( $data_initial );
				break;

			case 'categories':
				$output = $this->get_selector_categories_initial( $data_initial );
				break;

			case 'authors':
				$output = $this->get_selector_authors_initial( $data_initial );
				break;

			case 'posts':
				$output = $this->get_selector_posts_initial( $data_initial );
				break;
		}

		wp_send_json_success( [ 'items' => $output ] );
	}

	/**
	 * Get selector Tags data.
	 *
	 * @param array $search_data
	 *
	 * @return false|string
	 * @since 0.8.3
	 */
	private function get_selector_tags_data( $search_data ) {

		$output_data = [];
		$all_terms   = get_terms(
			[
				'number'                 => 50,
				'search'                 => $search_data['s'],
				'orderby'                => 'name',
				'taxonomy'               => 'post_tag',
				'hide_empty'             => false,
				'update_term_meta_cache' => false,
			]
		);

		/** @var WP_Term $term_obj */
		foreach ( $all_terms as $term_obj ) {
			$output_data[] = (object) [
				'id'   => $term_obj->term_id,
				'name' => $term_obj->name,
			];
		}

		ob_start();

		if ( ! empty( $output_data ) ) :
			?>
			<table class="anwp-pg-selector-table">
				<thead>
				<tr>
					<td class="manage-column check-column"></td>
					<td class="manage-column"><?php echo esc_html__( 'Post Tag', 'anwp-post-grid' ); ?></td>
					<td class="manage-column"><?php echo esc_html__( 'ID', 'anwp-post-grid' ); ?></td>
				</tr>
				</thead>

				<tbody>
				<?php foreach ( $output_data as $term_obj ) : ?>
					<tr data-id="<?php echo absint( $term_obj->id ); ?>" data-name="<?php echo esc_html( $term_obj->name ); ?>">
						<td>
							<button type="button" class="anwp-g-button anwp-pg-selector-action">
								<span class="dashicons dashicons-plus"></span>
							</button>
						</td>
						<td><?php echo esc_html( $term_obj->name ); ?></td>
						<td><?php echo esc_html( $term_obj->id ); ?></td>
					</tr>
				<?php endforeach; ?>
				</tbody>

				<tfoot>
				<tr>
					<td class="manage-column check-column"></td>
					<td class="manage-column"><?php echo esc_html__( 'Post Tag', 'anwp-post-grid' ); ?></td>
					<td class="manage-column"><?php echo esc_html__( 'ID', 'anwp-post-grid' ); ?></td>
				</tr>
				</tfoot>
			</table>
		<?php else : ?>
			<div class="anwp-alert-warning">- <?php echo esc_html__( 'nothing found', 'anwp-post-grid' ); ?> -</div>
			<?php
		endif;

		return ob_get_clean();
	}

	/**
	 * Get selector Posts data.
	 *
	 * @param array $search_data
	 *
	 * @return false|string
	 * @since 0.8.3
	 */
	private function get_selector_posts_data( $search_data ) {

		$output_data = [];
		$query_args  = [
			'posts_per_page' => 30,
			's'              => $search_data['s'],
			'cache_results'  => false,
		];

		/** @var WP_Post $post_obj */
		foreach ( get_posts( $query_args ) as $post_obj ) {
			$output_data[] = (object) [
				'id'        => $post_obj->ID,
				'name'      => $post_obj->post_title,
				'published' => $post_obj->post_date,
			];
		}

		ob_start();

		if ( ! empty( $output_data ) ) :
			?>
			<table class="anwp-pg-selector-table">
				<thead>
				<tr>
					<td class="manage-column check-column"></td>
					<td class="manage-column"><?php echo esc_html__( 'Post Title', 'anwp-post-grid' ); ?></td>
					<td class="manage-column"><?php echo esc_html__( 'ID', 'anwp-post-grid' ); ?></td>
					<td class="manage-column"><?php echo esc_html__( 'Published', 'anwp-post-grid' ); ?></td>
				</tr>
				</thead>

				<tbody>
				<?php foreach ( $output_data as $post_obj ) : ?>
					<tr data-id="<?php echo absint( $post_obj->id ); ?>" data-name="<?php echo esc_html( $post_obj->name ); ?>">
						<td>
							<button type="button" class="anwp-g-button anwp-pg-selector-action">
								<span class="dashicons dashicons-plus"></span>
							</button>
						</td>
						<td><?php echo esc_html( $post_obj->name ); ?></td>
						<td><?php echo esc_html( $post_obj->id ); ?></td>
						<td><?php echo esc_html( $post_obj->published ); ?></td>
					</tr>
				<?php endforeach; ?>
				</tbody>

				<tfoot>
				<tr>
					<td class="manage-column check-column"></td>
					<td class="manage-column"><?php echo esc_html__( 'Post Title', 'anwp-post-grid' ); ?></td>
					<td class="manage-column"><?php echo esc_html__( 'ID', 'anwp-post-grid' ); ?></td>
					<td class="manage-column"><?php echo esc_html__( 'Published', 'anwp-post-grid' ); ?></td>
				</tr>
				</tfoot>
			</table>
		<?php else : ?>
			<div class="anwp-alert-warning">- <?php echo esc_html__( 'nothing found', 'anwp-post-grid' ); ?> -</div>
			<?php
		endif;

		return ob_get_clean();
	}

	/**
	 * Get selector Categories data.
	 *
	 * @param array $search_data
	 *
	 * @return false|string
	 * @since 0.8.3
	 */
	private function get_selector_categories_data( $search_data ) {

		$output_data = [];
		$all_terms   = get_terms(
			[
				'number'                 => 50,
				'search'                 => $search_data['s'],
				'orderby'                => 'name',
				'taxonomy'               => 'category',
				'hide_empty'             => false,
				'update_term_meta_cache' => false,
			]
		);

		/** @var WP_Term $term_obj */
		foreach ( $all_terms as $term_obj ) {
			$output_data[] = (object) [
				'id'   => $term_obj->term_id,
				'name' => $term_obj->name,
			];
		}

		ob_start();

		if ( ! empty( $output_data ) ) :
			?>
			<table class="anwp-pg-selector-table">
				<thead>
				<tr>
					<td class="manage-column check-column"></td>
					<td class="manage-column"><?php echo esc_html__( 'Category', 'anwp-post-grid' ); ?></td>
					<td class="manage-column"><?php echo esc_html__( 'ID', 'anwp-post-grid' ); ?></td>
				</tr>
				</thead>

				<tbody>
				<?php foreach ( $output_data as $term_obj ) : ?>
					<tr data-id="<?php echo absint( $term_obj->id ); ?>" data-name="<?php echo esc_html( $term_obj->name ); ?>">
						<td>
							<button type="button" class="anwp-g-button anwp-pg-selector-action">
								<span class="dashicons dashicons-plus"></span>
							</button>
						</td>
						<td><?php echo esc_html( $term_obj->name ); ?></td>
						<td><?php echo esc_html( $term_obj->id ); ?></td>
					</tr>
				<?php endforeach; ?>
				</tbody>

				<tfoot>
				<tr>
					<td class="manage-column check-column"></td>
					<td class="manage-column"><?php echo esc_html__( 'Category', 'anwp-post-grid' ); ?></td>
					<td class="manage-column"><?php echo esc_html__( 'ID', 'anwp-post-grid' ); ?></td>
				</tr>
				</tfoot>
			</table>
		<?php else : ?>
			<div class="anwp-alert-warning">- <?php echo esc_html__( 'nothing found', 'anwp-post-grid' ); ?> -</div>
			<?php
		endif;

		return ob_get_clean();
	}

	/**
	 * Get selector Authors data.
	 *
	 * @param array $search_data
	 *
	 * @return false|string
	 * @since 0.8.3
	 */
	private function get_selector_authors_data( $search_data ) {

		$output_data  = [];
		$post_authors = get_users(
			[
				'has_published_posts' => true,
				'who'                 => 'authors',
				'orderby'             => 'display_name',
				'search'              => $search_data['s'] ? '*' . $search_data['s'] . '*' : '',
				'search_columns'      => [ 'ID', 'user_login', 'user_email', 'user_url', 'user_nicename', 'display_name' ],
				'fields'              => [ 'ID', 'display_name' ],
				'number'              => 50,
			]
		);

		/** @var WP_User $post_author */
		foreach ( $post_authors as $post_author ) {

			$output_data[] = (object) [
				'id'   => $post_author->ID,
				'name' => $post_author->display_name,
			];
		}

		ob_start();

		if ( ! empty( $output_data ) ) :
			?>
			<table class="anwp-pg-selector-table">
				<thead>
				<tr>
					<td class="manage-column check-column"></td>
					<td class="manage-column"><?php echo esc_html__( 'Author', 'anwp-post-grid' ); ?></td>
					<td class="manage-column"><?php echo esc_html__( 'ID', 'anwp-post-grid' ); ?></td>
				</tr>
				</thead>

				<tbody>
				<?php foreach ( $output_data as $user_obj ) : ?>
					<tr data-id="<?php echo absint( $user_obj->id ); ?>" data-name="<?php echo esc_html( $user_obj->name ); ?>">
						<td>
							<button type="button" class="anwp-g-button anwp-pg-selector-action">
								<span class="dashicons dashicons-plus"></span>
							</button>
						</td>
						<td><?php echo esc_html( $user_obj->name ); ?></td>
						<td><?php echo esc_html( $user_obj->id ); ?></td>
					</tr>
				<?php endforeach; ?>
				</tbody>

				<tfoot>
				<tr>
					<td class="manage-column check-column"></td>
					<td class="manage-column"><?php echo esc_html__( 'Author', 'anwp-post-grid' ); ?></td>
					<td class="manage-column"><?php echo esc_html__( 'ID', 'anwp-post-grid' ); ?></td>
				</tr>
				</tfoot>
			</table>
		<?php else : ?>
			<div class="anwp-alert-warning">- <?php echo esc_html__( 'nothing found', 'anwp-post-grid' ); ?> -</div>
			<?php
		endif;

		return ob_get_clean();
	}

	/**
	 * Get selector Tags initial data.
	 *
	 * @param array $data_initial
	 *
	 * @return array
	 * @since 0.8.3
	 */
	private function get_selector_tags_initial( $data_initial ) {

		$query_args = [
			'number'                 => 50,
			'include'                => $data_initial,
			'orderby'                => 'name',
			'taxonomy'               => 'post_tag',
			'hide_empty'             => false,
			'update_term_meta_cache' => false,
		];

		$results = get_terms( $query_args );

		if ( empty( $results ) || ! is_array( $results ) ) {
			return [];
		}

		$output = [];

		foreach ( $results as $term_obj ) {
			$output[] = [
				'id'   => $term_obj->term_id,
				'name' => $term_obj->name,
			];
		}

		return $output;
	}

	/**
	 * Get selector Categories initial data.
	 *
	 * @param array $data_initial
	 *
	 * @return array
	 * @since 0.8.3
	 */
	private function get_selector_categories_initial( $data_initial ) {

		$query_args = [
			'number'                 => 50,
			'include'                => $data_initial,
			'orderby'                => 'name',
			'taxonomy'               => 'category',
			'hide_empty'             => false,
			'update_term_meta_cache' => false,
		];

		$results = get_terms( $query_args );

		if ( empty( $results ) || ! is_array( $results ) ) {
			return [];
		}

		$output = [];

		foreach ( $results as $term_obj ) {
			$output[] = [
				'id'   => $term_obj->term_id,
				'name' => $term_obj->name,
			];
		}

		return $output;
	}

	/**
	 * Get selector Posts initial data.
	 *
	 * @param array $data_initial
	 *
	 * @return array
	 * @since 0.8.3
	 */
	private function get_selector_posts_initial( $data_initial ) {

		$results = get_posts(
			[
				'posts_per_page' => 30,
				'include'        => $data_initial,
			]
		);

		if ( empty( $results ) || ! is_array( $results ) ) {
			return [];
		}

		$output = [];

		/** @var WP_Post $post_obj */
		foreach ( $results as $post_obj ) {
			$output[] = [
				'id'   => $post_obj->ID,
				'name' => $post_obj->post_title,
			];
		}

		return $output;
	}

	/**
	 * Get selector Authors initial data.
	 *
	 * @param array $data_initial
	 *
	 * @return array
	 * @since 0.8.3
	 */
	private function get_selector_authors_initial( $data_initial ) {

		$results = get_users(
			[
				'has_published_posts' => true,
				'who'                 => 'authors',
				'orderby'             => 'display_name',
				'fields'              => [ 'ID', 'display_name' ],
				'number'              => 50,
				'include'             => $data_initial,
			]
		);

		if ( empty( $results ) || ! is_array( $results ) ) {
			return [];
		}

		$output = [];

		/** @var WP_User $post_author */
		foreach ( $results as $post_author ) {
			$output[] = [
				'id'   => $post_author->ID,
				'name' => $post_author->display_name,
			];
		}

		return $output;
	}

	/**
	 * Load promo tab
	 *
	 * @param Widget_Base $element
	 *
	 * @since 0.1.0
	 */
	public function load_promo_tab( $element ) {

		if ( AnWP_Post_Grid::is_premium_active() ) {
			return;
		}

		$element->start_controls_section(
			'section_anwp_pro_promo_tab',
			[
				'label' => __( 'Premium Features', 'anwp-post-grid' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$element->add_control(
			'pro_tab_promo',
			[
				'type' => 'raw_html',
				'raw'  => $this->get_pro_tab_template(),
			]
		);

		$element->end_controls_section();
	}

	public function get_pro_tab_template() {
		ob_start();
		?>
		<div class="elementor-nerd-box">
			<div class="elementor-nerd-box-title" style="margin-top: 0 !important;">Premium Features</div>
			<ul style="margin-top: 15px;">
				<li>News Ticker Widget</li>
				<li>Hero Slider</li>
				<li>Mosaic Slider</li>
				<li>Card Slider</li>
				<li>Advanced Pagination</li>
				<li>Taxonomy Redirects</li>
				<li>Header Category Filter</li>
				<li>Widget Blocks</li>
			</ul>
			<a class="elementor-nerd-box-link elementor-button elementor-button-default elementor-button-go-pro" href="https://grid.anwp.pro/premium-demo/" target="_blank">
				<?php echo esc_html__( 'Premium Demo', 'anwp-post-grid' ); ?>
			</a>
		</div>
		<?php
		return ob_get_clean();
	}

	/**
	 * Promote Premium Widgets
	 *
	 * @param array $config
	 *
	 * @return array
	 * @since 0.6.2
	 */
	public function promote_premium_widgets( $config ) {

		if ( AnWP_Post_Grid::is_premium_active() ) {
			return $config;
		}

		if ( ! isset( $config['promotionWidgets'] ) || ! is_array( $config['promotionWidgets'] ) ) {
			$config['promotionWidgets'] = [];
		}

		$premium_widgets = [
			[
				'name'       => 'anwp-pg-pro-news-ticker',
				'title'      => __( 'News Ticker', 'anwp-post-grid' ) . ' [anwp]',
				'icon'       => 'anwp-pg-pro-promotion-icon anwp-pg-pro-news-ticker__admin-icon',
				'categories' => '[ "anwp-pg", "anwp" ]',
			],
			[
				'name'       => 'anwp-pg-pro-hero-slider',
				'title'      => __( 'Hero Slider', 'anwp-post-grid' ) . ' [anwp]',
				'icon'       => 'anwp-pg-pro-promotion-icon anwp-pg-simple-slider__admin-icon',
				'categories' => '[ "anwp-pg", "anwp" ]',
			],
			[
				'name'       => 'anwp-pg-pro-mosaic-slider',
				'title'      => __( 'Mosaic Slider', 'anwp-post-grid' ) . ' [anwp]',
				'icon'       => 'anwp-pg-pro-promotion-icon anwp-pg-simple-slider__admin-icon',
				'categories' => '[ "anwp-pg", "anwp" ]',
			],
			[
				'name'       => 'anwp-pg-pro-card-slider',
				'title'      => __( 'Card Slider', 'anwp-post-grid' ) . ' [anwp]',
				'icon'       => 'anwp-pg-pro-promotion-icon anwp-pg-simple-slider__admin-icon',
				'categories' => '[ "anwp-pg", "anwp" ]',
			],
		];

		$config['promotionWidgets'] = array_merge( $config['promotionWidgets'], $premium_widgets );

		return $config;
	}

	/**
	 * Init Widgets
	 * Include widgets files and register them
	 *
	 * @throws Exception
	 * @since 0.1.0
	 */
	public function init_widgets() {

		/*
		|--------------------------------------------------------------------
		| > Simple Grid
		| @since 0.1.0
		|--------------------------------------------------------------------
		*/
		Plugin::instance()->widgets_manager->register_widget_type( new AnWP_Post_Grid_Element_Simple_Grid() );

		/*
		|--------------------------------------------------------------------
		| > Light Grid
		| @since 0.1.0
		|--------------------------------------------------------------------
		*/
		Plugin::instance()->widgets_manager->register_widget_type( new AnWP_Post_Grid_Element_Light_Grid() );

		/*
		|--------------------------------------------------------------------
		| > Classic Grid
		| @since 0.1.0
		|--------------------------------------------------------------------
		*/
		Plugin::instance()->widgets_manager->register_widget_type( new AnWP_Post_Grid_Element_Classic_Grid() );

		/*
		|--------------------------------------------------------------------
		| > Simple Slider
		| @since 0.6.0
		|--------------------------------------------------------------------
		*/
		Plugin::instance()->widgets_manager->register_widget_type( new AnWP_Post_Grid_Element_Simple_Slider() );

		/*
		|--------------------------------------------------------------------
		| > Classic Slider
		| @since 0.6.0
		|--------------------------------------------------------------------
		*/
		Plugin::instance()->widgets_manager->register_widget_type( new AnWP_Post_Grid_Element_Classic_Slider() );

		/*
		|--------------------------------------------------------------------
		| > Hero Block
		| @since 0.6.1
		|--------------------------------------------------------------------
		*/
		Plugin::instance()->widgets_manager->register_widget_type( new AnWP_Post_Grid_Element_Hero_Block() );

		/*
		|--------------------------------------------------------------------
		| > Classic Blog
		| @since 0.6.2
		|--------------------------------------------------------------------
		*/
		Plugin::instance()->widgets_manager->register_widget_type( new AnWP_Post_Grid_Element_Classic_Blog() );
	}

	/**
	 * Get All available posts show options.
	 *
	 * @return array
	 * @since 0.1.0
	 */
	public function get_posts_to_show_options() {

		$options = [
			'latest'        => __( 'Latest', 'anwp-post-grid' ),
			'oldest'        => __( 'Oldest', 'anwp-post-grid' ),
			'comment_count' => __( 'Most commented', 'anwp-post-grid' ),
			'custom'        => __( 'Custom', 'anwp-post-grid' ),
		];

		if ( AnWP_Post_Grid::is_pvc_active() ) {
			$options['post_views'] = esc_html__( 'Most viewed', 'anwp-post-grid' );
		}

		return $options;
	}

	/**
	 * Get All available sources.
	 *
	 * @return array
	 * @since 0.8.4
	 */
	public function get_source_options() {
		return [
			'posts'   => __( 'Posts', 'anwp-post-grid' ),
			'related' => __( 'Related', 'anwp-post-grid' ),
		];
	}

	/**
	 * Get available related order options.
	 *
	 * @return array
	 * @since 0.8.4
	 */
	public function get_related_order_options() {

		$options = [
			'latest'        => __( 'Latest', 'anwp-post-grid' ),
			'oldest'        => __( 'Oldest', 'anwp-post-grid' ),
			'comment_count' => __( 'Most commented', 'anwp-post-grid' ),
		];

		if ( AnWP_Post_Grid::is_pvc_active() ) {
			$options['post_views'] = esc_html__( 'Most viewed', 'anwp-post-grid' );
		}

		return $options;
	}

	/**
	 * Get Post Categories
	 *
	 * @return array|null
	 * @since 0.1.0
	 *
	 * @deprecated Will be removed in v1.0
	 */
	public function get_category_options() {

		static $options = null;

		if ( null === $options ) {
			$options = get_categories(
				[
					'hide_empty' => false,
					'fields'     => 'id=>name',
				]
			);
		}

		return $options;
	}

	/**
	 * Get Post Tags
	 *
	 * @return array|null
	 * @since 0.1.0
	 *
	 * @deprecated Will be removed in v1.0
	 */
	public function get_tag_options() {

		static $options = null;

		if ( null === $options ) {
			$options = get_tags(
				[
					'hide_empty' => false,
					'fields'     => 'id=>name',
				]
			);
		}

		return $options;
	}

	/**
	 * Get Post Formats
	 *
	 * @return array|null
	 * @since 0.1.0
	 */
	public function get_post_format_options() {

		static $options = null;

		if ( null === $options ) {

			$options = $this->get_post_format_term();

			if ( ! empty( $options ) ) {
				$options = array_map(
					function ( $el ) {
						return ltrim( $el, 'post-format-' );
					},
					$options
				);

				$options = array_combine( $options, $options );
				$options = array_map( 'ucfirst', $options );
			}

			$options = array_merge(
				[
					'all'      => __( 'All Formats', 'anwp-post-grid' ),
					'standard' => __( 'Standard', 'anwp-post-grid' ),
				],
				$options
			);
		}

		return $options;
	}

	/**
	 * Get Post Formats Term
	 *
	 * @return array|null
	 * @since 0.1.0
	 */
	public function get_post_format_term() {

		static $options = null;

		if ( null === $options ) {

			$options = get_terms(
				[
					'taxonomy'   => 'post_format',
					'hide_empty' => false,
					'fields'     => 'slugs',
				]
			);

			if ( empty( $options ) || is_wp_error( $options ) ) {
				$options = [];
			}
		}

		return $options;
	}

	/**
	 * Get Post Authors
	 *
	 * @return array|null
	 * @since 0.1.0
	 *
	 * @deprecated Will be removed in v1.0
	 */
	public function get_author_options() {

		static $options = null;

		if ( null === $options ) {
			$post_authors = get_users(
				[
					'has_published_posts' => true,
					'who'                 => 'authors',
					'fields'              => [ 'ID', 'display_name' ],
				]
			);

			foreach ( $post_authors as $post_author ) {
				$options[ $post_author->ID ] = $post_author->display_name;
			}
		}

		return $options;
	}

	/**
	 * Get All Posts
	 *
	 * @return array|null
	 * @since 0.1.0
	 *
	 * @deprecated Will be removed in v1.0
	 */
	public function get_posts_all_options() {

		static $options = null;

		if ( null === $options ) {

			global $wpdb;

			// Get all raw logos
			$all_posts = $wpdb->get_results(
				$wpdb->prepare(
					"
					SELECT ID, post_title
					FROM $wpdb->posts
					WHERE post_status = 'publish' AND post_type = 'post'
					ORDER BY post_date DESC
					LIMIT %d
					",
					$this->published_posts_limit
				)
			);

			/** @var WP_Post $all_post */
			foreach ( $all_posts as $all_post ) {
				$options[ $all_post->ID ] = $all_post->post_title;
			}
		}

		return $options;
	}

	/**
	 * Get grid posts.
	 *
	 * @param $options
	 * @param $output
	 *
	 * @return array
	 */
	public function get_grid_posts( $options, $output = '' ) {

		/*
		|--------------------------------------------------------------------
		| Merge options into defaults array.
		|--------------------------------------------------------------------
		*/
		$options = (object) wp_parse_args(
			$options,
			[
				'posts_to_show'          => 'latest',
				'include_ids'            => '',
				'exclude_ids'            => '',
				'exclude_by_category'    => '',
				'exclude_by_author'      => '',
				'filter_by_category'     => '',
				'filter_by_tag'          => '',
				'filter_by_post_format'  => '',
				'filter_by_author'       => '',
				'published_in_last_days' => 0,
				'limit'                  => 3,
				'offset'                 => 0,
				'query_source'           => '',
				'related_posts'          => '',
				'related_posts_order'    => '',
			]
		);

		/*
		|--------------------------------------------------------------------
		| Init query args
		|--------------------------------------------------------------------
		*/
		$args = [
			'ignore_sticky_posts' => true,
			'suppress_filters'    => false,
		];

		if ( 'related' === $options->query_source ) {

			$current_post = get_post( ! empty( $options->related_post_id ) ? $options->related_post_id : '' );

			// Hide current post
			$args['post__not_in'] = [ $current_post->ID ];

			// Limit
			$args['numberposts'] = 'ids' === $output ? - 1 : intval( $options->limit );

			if ( absint( $options->offset ) ) {
				$args['offset'] = absint( $options->offset );
			}

			if ( 'related_category' === $options->related_posts ) {

				$categories = get_the_category( $current_post->ID );

				if ( ! empty( $categories ) && is_array( $categories ) ) {

					$category_ids = [];

					foreach ( $categories as $individual_category ) {
						$category_ids[] = $individual_category->term_id;
					}

					$args['category__in'] = $category_ids;
				} else {
					return [];
				}
			} elseif ( 'related_tag' === $options->related_posts ) {

				$tags = get_the_tags( $current_post->ID );

				if ( ! empty( $tags ) && is_array( $tags ) ) {

					$tags_ids = [];

					foreach ( $tags as $individual_tag ) {
						$tags_ids[] = $individual_tag->term_id;
					}

					$args['tag__in'] = $tags_ids;
				} else {
					return [];
				}
			} elseif ( 'related_author' === $options->related_posts ) {
				$args['author'] = $current_post->post_author;
			}

			// OrderBy
			if ( 'post_views' === $options->related_posts_order && ! AnWP_Post_Grid::is_pvc_active() ) {
				$options->related_posts_order = '';
			}

			if ( ! empty( $options->related_posts_order ) ) {

				switch ( $options->related_posts_order ) {
					case 'comment_count':
					case 'post_views':
						$args['orderby'] = $options->related_posts_order;
						break;

					case 'oldest':
						$args['order'] = 'ASC';
						break;
				}
			}
		} else {
			if ( 'custom' === $options->posts_to_show ) {

				$args['include'] = $options->include_ids;

			} else {

				// Limit
				$args['numberposts'] = 'ids' === $output ? - 1 : intval( $options->limit );

				// OrderBy
				if ( 'post_views' === $options->posts_to_show && ! AnWP_Post_Grid::is_pvc_active() ) {
					$options->posts_to_show = '';
				}

				if ( ! empty( $options->posts_to_show ) ) {

					switch ( $options->posts_to_show ) {
						case 'comment_count':
						case 'post_views':
							$args['orderby'] = $options->posts_to_show;
							break;

						case 'oldest':
							$args['order'] = 'ASC';
							break;
					}
				}

				// Category
				if ( ! empty( $options->filter_by_category ) ) {
					$args['category__in'] = wp_parse_id_list( $options->filter_by_category );
				}

				// Tag
				if ( ! empty( $options->filter_by_tag ) ) {
					$args['tag__in'] = wp_parse_id_list( $options->filter_by_tag );
				}

				// Post Formats
				if ( $options->filter_by_post_format && 'standard' !== $options->filter_by_post_format && 'all' !== $options->filter_by_post_format ) {
					$args['tax_query'] = [
						[
							'taxonomy' => 'post_format',
							'field'    => 'slug',
							'terms'    => 'post-format-' . sanitize_key( $options->filter_by_post_format ),
						],
					];
				} elseif ( 'standard' === $options->filter_by_post_format && ! empty( $this->get_post_format_term() ) ) {
					$args['tax_query'] = [
						[
							'taxonomy' => 'post_format',
							'field'    => 'slug',
							'terms'    => $this->get_post_format_term(),
							'operator' => 'NOT IN',
						],
					];
				}

				// filter_by_author
				if ( ! empty( $options->filter_by_author ) ) {
					$args['author__in'] = wp_parse_id_list( $options->filter_by_author );
				}

				// exclude_ids
				if ( ! empty( $options->exclude_ids ) ) {
					$args['exclude'] = $options->exclude_ids;
				}

				// exclude_by_category
				if ( ! empty( $options->exclude_by_category ) ) {
					$args['category__not_in'] = wp_parse_id_list( $options->exclude_by_category );
				}

				// exclude_by_author
				if ( ! empty( $options->exclude_by_author ) ) {
					$args['author__not_in'] = wp_parse_id_list( $options->exclude_by_author );
				}

				// offset
				if ( absint( $options->offset ) ) {
					$args['offset'] = absint( $options->offset );
				}

				// published_in_last_days
				if ( $options->published_in_last_days > 0 && in_array( $options->posts_to_show, [ 'comment_count', 'post_views', 'oldest' ], true ) ) {
					$args['date_query'] = [ 'after' => absint( $options->published_in_last_days ) . ' days ago' ];
				}
			}
		}

		if ( 'ids' === $output ) {
			$args['fields'] = 'ids';
		}

		return get_posts( $args );
	}

	/**
	 * Return an image URI.
	 *
	 * @param string   $size The image size you want to return.
	 * @param bool     $allow_placeholder
	 * @param int|null $pre_post_id
	 *
	 * @return string         The image URI.
	 * @since 0.1.0
	 */
	public function get_post_image_uri( $size = 'full', $allow_placeholder = true, $pre_post_id = null ) {

		$media_url = '';

		$post_id = $pre_post_id ? $pre_post_id : get_the_ID();

		// If featured image is present, use that.
		if ( has_post_thumbnail( $post_id ) ) {

			$featured_image_id = get_post_thumbnail_id( $post_id );
			$media_url         = wp_get_attachment_image_url( $featured_image_id, sanitize_key( $size ) );

			if ( $media_url ) {
				return $media_url;
			}
		}

		/*
		|--------------------------------------------------------------------
		| Video Post Format
		|--------------------------------------------------------------------
		*/
		// Get image for video post format
		if ( 'video' === get_post_format( $post_id ) ) {

			$video_data = array(
				'source' => get_post_meta( $post_id, '_anwp_extras_video_source', true ), // site, youtube or vimeo
				'url'    => get_post_meta( $post_id, '_anwp_extras_video_id', true ),
			);

			// Check youtube id
			if ( 'youtube' === $video_data['source'] || empty( $video_data['source'] ) ) {

				// Try to get video ID
				$video_id = $this->get_youtube_id( $video_data['url'] );

				if ( $video_id ) {
					return esc_url( sprintf( 'http://img.youtube.com/vi/%s/maxresdefault.jpg', $video_id ) );
				}
			}
		}

		/*
		|--------------------------------------------------------------------
		| Gallery Post Format
		|--------------------------------------------------------------------
		*/
		// Get image for gallery post type
		if ( 'gallery' === get_post_format( $post_id ) ) {

			$gallery_images = get_post_meta( $post_id, '_anwp_extras_gallery_images', true );

			if ( ! empty( $gallery_images ) && is_array( $gallery_images ) ) {

				reset( $gallery_images );
				$gallery_image_id = key( $gallery_images );

				$media_url = wp_get_attachment_image_url( $gallery_image_id, sanitize_key( $size ) );

				if ( $media_url ) {
					return $media_url;
				}
			}
		}

		if ( 'post' === get_post_type( $post_id ) && 'video' !== get_post_format( $post_id ) ) {
			// Check for any attached image.
			$media = get_attached_media( 'image', $post_id );

			// If an image is present, then use it.
			if ( is_array( $media ) && 0 < count( $media ) ) {
				$media     = current( $media );
				$media_url = wp_get_attachment_image_url( $media->ID, sanitize_key( $size ) );
			}
		}

		// Set up default image path.
		if ( empty( $media_url ) && $allow_placeholder ) {

			// Set default image
			$media_url = AnWP_Post_Grid::url( 'public/img/empty_image.jpg' );

			// Get default image from plugin options
			$attachment_id = AnWP_Post_Grid_Settings::get_value( 'default_featured_image' );

			if ( absint( $attachment_id ) ) {
				$default_featured_image_url = wp_get_attachment_image_url( $attachment_id, 'full' );

				if ( $default_featured_image_url ) {
					$media_url = $default_featured_image_url;
				}
			}
		}

		return $media_url;
	}

	/**
	 * Get Youtube ID from url
	 *
	 * @param $url
	 *
	 * @return string Youtube ID or empty string
	 */
	public function get_youtube_id( $url ) {

		if ( mb_strlen( $url ) <= 11 ) {
			return $url;
		}

		preg_match( "/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $url, $matches );

		return isset( $matches[1] ) ? $matches[1] : '';
	}

	/**
	 * Render category block/badge
	 *
	 * @param WP_Term $term_obj
	 * @param string  $class
	 */
	public function render_post_category_link_filled( $term_obj, $class = '' ) {

		$theme_slug = get_option( 'template' );

		// Try to get theme category color
		switch ( $theme_slug ) {
			case 'aneto':
				$category_color = get_metadata( 'term', $term_obj->term_id, '_anwp_extras_category_color', true );
				break;

			case 'colormag':
				if ( function_exists( 'colormag_category_color' ) ) {
					$category_color = colormag_category_color( $term_obj->term_id );
				}
				break;
		}

		if ( empty( $category_color ) && 'no' !== AnWP_Post_Grid_Settings::get_value( 'show_category_color' ) ) {
			$color          = get_term_meta( $term_obj->term_id, '_anwp_pg_category_color', true );
			$category_color = empty( $color ) ? '#1565C0' : "#{$color}";
		} else {
			$category_color = empty( $category_color ) ? '#1565C0' : $category_color;
		}

		echo '<div class="anwp-pg-category__wrapper-filled px-2 d-flex align-items-center ' . esc_attr( $class ) . ' anwp-pg-category-parent-' . esc_attr( $term_obj->parent ) . '" style="background-color: ' . esc_attr( $category_color ) . '">';
		echo '<span>' . esc_html( $term_obj->name ) . '</span>';
		echo '</div>';
	}

	/**
	 * Render category block/badge
	 *
	 * @param WP_Term $term_obj
	 * @param string  $class
	 */
	public function render_post_category_link( $term_obj, $class = '' ) {

		$theme_slug = get_option( 'template' );

		// Try to get theme category color
		switch ( $theme_slug ) {
			case 'aneto':
				$category_color = get_metadata( 'term', $term_obj->term_id, '_anwp_extras_category_color', true );
				break;

			case 'colormag':
				if ( function_exists( 'colormag_category_color' ) ) {
					$category_color = colormag_category_color( $term_obj->term_id );
				}
				break;
		}

		if ( empty( $category_color ) && 'no' !== AnWP_Post_Grid_Settings::get_value( 'show_category_color' ) ) {
			$color          = get_term_meta( $term_obj->term_id, '_anwp_pg_category_color', true );
			$category_color = empty( $color ) ? '#1565C0' : "#{$color}";
		} else {
			$category_color = empty( $category_color ) ? '#1565C0' : $category_color;
		}

		$category_color = empty( $category_color ) ? '#1565C0' : $category_color;

		echo '<div class="anwp-pg-category__wrapper d-flex align-items-center ' . esc_attr( $class ) . ' anwp-pg-category-parent-' . esc_attr( $term_obj->parent ) . '" style="color: ' . esc_attr( $category_color ) . '">';
		echo esc_html( $term_obj->name );
		echo '</div>';
	}

	/**
	 * Render post date
	 *
	 * @param int $post_id
	 *
	 * @return string
	 * @since 0.1.0
	 */
	public function get_post_date( $post_id ) {

		$time_string = '<time class="anwp-pg-published anwp-pg-updated" datetime="%1$s">%2$s</time>';

		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="anwp-pg-published" datetime="%1$s">%2$s</time><time class="anwp-pg-updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf(
			$time_string,
			get_the_date( DATE_W3C, $post_id ),
			get_the_date( '', $post_id ),
			get_the_modified_date( DATE_W3C, $post_id ),
			get_the_modified_date( '', $post_id )
		);

		// Wrap the time string in a link, and preface it with 'Posted on'.
		return '<span class="screen-reader-text">' . esc_html_x( 'Posted on', 'post date', 'anwp-post-grid' ) . '</span>' . $time_string;
	}

	/**
	 * Get teaser grid classes
	 *
	 * @param object $data
	 * @param int    $default_desktop
	 * @param int    $default_tablet
	 * @param int    $default_mobile
	 *
	 * @return string
	 * @since 0.1.0
	 */
	public function get_teaser_grid_classes( $data, $default_desktop = 3, $default_tablet = 2, $default_mobile = 1 ) {

		$data = (object) wp_parse_args(
			$data,
			[
				'grid_cols'        => $default_desktop,
				'grid_cols_tablet' => $default_tablet,
				'grid_cols_mobile' => $default_mobile,
			]
		);

		$classes = [];

		// Desktop
		$grid_cols = ( $data->grid_cols >= 1 && $data->grid_cols <= 4 ) ? absint( $data->grid_cols ) : absint( $default_desktop );
		$classes[] = 'anwp-col-lg-' . 12 / $grid_cols;

		// Tablet
		$grid_cols_tablet = ( $data->grid_cols_tablet >= 1 && $data->grid_cols_tablet <= 4 ) ? absint( $data->grid_cols_tablet ) : absint( $default_tablet );
		$classes[]        = 'anwp-col-sm-' . 12 / $grid_cols_tablet;

		// Mobile
		$grid_cols_mobile = ( $data->grid_cols_mobile >= 1 && $data->grid_cols_mobile <= 4 ) ? absint( $data->grid_cols_mobile ) : absint( $default_mobile );
		$classes[]        = 'anwp-col-' . 12 / $grid_cols_mobile;

		return implode( ' ', $classes );
	}

	/**
	 * Get "load more" data
	 *
	 * @param $data
	 * @param $template
	 *
	 * @return string
	 * @since 0.5.2
	 */
	public function get_serialized_load_more_data( $data, $template = '' ) {

		if ( isset( $data->grid_posts ) ) {
			unset( $data->grid_posts );
		}

		$default_data = [
			'posts_to_show'          => 'latest',
			'include_ids'            => '',
			'exclude_ids'            => '',
			'exclude_by_category'    => '',
			'filter_by_category'     => '',
			'filter_by_tag'          => '',
			'filter_by_post_format'  => '',
			'filter_by_author'       => '',
			'published_in_last_days' => 0,
			'limit'                  => 3,
			'offset'                 => 0,
			'grid_cols'              => 3,
			'grid_cols_tablet'       => 2,
			'grid_cols_mobile'       => 1,
			'grid_thumbnail_size'    => 'large',
			'show_category'          => 'yes',
			'category_limit'         => 1,
			'show_date'              => 'yes',
			'show_author'            => 'yes',
			'show_comments'          => 'yes',
			'card_height'            => '180',
			'show_excerpt'           => 'yes',
			'excerpt_num_words'      => '',
			'excerpt_source'         => '',
			'excerpt_html'           => '',
			'layout'                 => '',
			'show_read_more'         => '',
			'read_more_label'        => '',
			'read_more_class'        => '',
			'post_image_width'       => '1_3',
			'show_post_icon'         => 'yes',
			'query_source'           => '',
			'related_posts'          => '',
			'related_posts_order'    => '',
			'card_height_mobile'     => '',
			'card_height_tablet'     => '',
		];

		$options = wp_parse_args( $data, $default_data );

		$output = array_intersect_key( $options, $default_data );

		if ( 'related' === $output['query_source'] ) {
			$output['related_post_id'] = get_post()->ID;
		}

		// Replace null with empty string
		$output = array_map(
			function ( $e ) {
				return is_null( $e ) ? '' : $e;
			},
			$output
		);

		return wp_json_encode( $output );
	}

	/**
	 * Handle ajax request and provide posts to load.
	 *
	 * @since 0.5.2
	 */
	public function ajax_load_more() {

		// Activate referer check with hook (optional)
		if ( apply_filters( 'anwp-pg-el/config/check_public_nonce', false ) ) {
			check_ajax_referer( 'anwp-pg-public-nonce' );
		}

		$post_loaded = absint( $_POST['loaded'] );
		$post_qty    = absint( $_POST['qty'] );

		// Parse with default values
		$args = wp_parse_args(
			wp_unslash( $_POST['args'] ),
			[
				'layout'                 => '',
				'posts_to_show'          => 'latest',
				'include_ids'            => '',
				'exclude_ids'            => '',
				'exclude_by_category'    => '',
				'filter_by_category'     => '',
				'filter_by_tag'          => '',
				'filter_by_post_format'  => '',
				'filter_by_author'       => '',
				'published_in_last_days' => 0,
				'limit'                  => 3,
				'offset'                 => 0,
				'grid_cols'              => 3,
				'grid_cols_tablet'       => 2,
				'grid_cols_mobile'       => 1,
				'category_limit'         => 1,
				'grid_thumbnail_size'    => 'large',
				'show_category'          => 'yes',
				'show_date'              => 'yes',
				'show_comments'          => 'yes',
				'card_height'            => '180',
				'show_excerpt'           => 'yes',
				'excerpt_num_words'      => '',
				'excerpt_source'         => '',
				'excerpt_html'           => '',
				'post_image_width'       => '1_3',
				'show_post_icon'         => 'yes',
				'grid_post'              => (object) [],
				'query_source'           => '',
				'related_posts'          => '',
				'related_posts_order'    => '',
				'related_post_id'        => '',
				'card_height_mobile'     => '',
				'card_height_tablet'     => '',
			]
		);

		// Sanitize and validate
		$data = [
			'posts_to_show'          => sanitize_text_field( $args['posts_to_show'] ),
			'include_ids'            => wp_parse_id_list( $args['include_ids'] ),
			'exclude_ids'            => wp_parse_id_list( $args['exclude_ids'] ),
			'filter_by_category'     => wp_parse_id_list( $args['filter_by_category'] ),
			'exclude_by_category'    => wp_parse_id_list( $args['exclude_by_category'] ),
			'filter_by_tag'          => wp_parse_id_list( $args['filter_by_tag'] ),
			'filter_by_post_format'  => sanitize_text_field( $args['filter_by_post_format'] ),
			'filter_by_author'       => wp_parse_id_list( $args['filter_by_author'] ),
			'published_in_last_days' => absint( $args['published_in_last_days'] ),
			'limit'                  => absint( $args['limit'] ),
			'category_limit'         => absint( $args['category_limit'] ),
			'offset'                 => absint( $args['offset'] ),
			'grid_cols'              => absint( $args['grid_cols'] ),
			'grid_cols_tablet'       => absint( $args['grid_cols_tablet'] ),
			'grid_cols_mobile'       => absint( $args['grid_cols_mobile'] ),
			'grid_thumbnail_size'    => sanitize_text_field( $args['grid_thumbnail_size'] ),
			'show_category'          => sanitize_text_field( $args['show_category'] ),
			'show_date'              => sanitize_text_field( $args['show_date'] ),
			'show_comments'          => sanitize_text_field( $args['show_comments'] ),
			'card_height'            => is_array( $args['card_height'] ) ? array_map( 'sanitize_text_field', $args['card_height'] ) : '',
			'card_height_mobile'     => is_array( $args['card_height_mobile'] ) ? array_map( 'sanitize_text_field', $args['card_height_mobile'] ) : '',
			'card_height_tablet'     => is_array( $args['card_height_tablet'] ) ? array_map( 'sanitize_text_field', $args['card_height_tablet'] ) : '',
			'show_excerpt'           => sanitize_text_field( $args['show_excerpt'] ),
			'excerpt_num_words'      => sanitize_text_field( $args['excerpt_num_words'] ),
			'excerpt_html'           => sanitize_text_field( $args['excerpt_html'] ),
			'excerpt_source'         => sanitize_text_field( $args['excerpt_source'] ),
			'post_image_width'       => sanitize_text_field( $args['post_image_width'] ),
			'layout'                 => sanitize_text_field( $args['layout'] ),
			'show_author'            => sanitize_text_field( $args['show_author'] ),
			'show_read_more'         => sanitize_text_field( $args['show_read_more'] ),
			'read_more_label'        => sanitize_text_field( $args['read_more_label'] ),
			'read_more_class'        => sanitize_text_field( $args['read_more_class'] ),
			'show_post_icon'         => sanitize_text_field( $args['show_post_icon'] ),
			'query_source'           => sanitize_text_field( $args['query_source'] ),
			'related_posts'          => sanitize_text_field( $args['related_posts'] ),
			'related_posts_order'    => sanitize_text_field( $args['related_posts_order'] ),
			'related_post_id'        => sanitize_text_field( $args['related_post_id'] ),
		];

		$data['limit']  = $post_qty + 1;
		$data['offset'] = $post_loaded;

		/**
		 * Filter load more arguments.
		 *
		 * @since 0.8.2
		 *
		 * @param array Array of arguments
		 */
		$data = apply_filters( 'anwp-pg-el/admin/elements_load_more_args', $data, $_POST );

		$grid_posts = $this->get_grid_posts( $data );

		// Check next time "load more"
		$next_load = count( $grid_posts ) > $post_qty;

		if ( $next_load ) {
			array_pop( $grid_posts );
		}

		// Start output
		ob_start();

		foreach ( $grid_posts as $grid_post ) {
			$data['grid_post'] = $grid_post;

			if ( 'classic' === $data['layout'] ) {
				anwp_post_grid()->load_partial( $data, 'teaser/classic' );
			} else {
				anwp_post_grid()->load_partial( $data, 'teaser/teaser', sanitize_key( $data['layout'] ) );
			}
		}

		$html_output = ob_get_clean();

		wp_send_json_success(
			[
				'html'   => $html_output,
				'next'   => $next_load,
				'offset' => $post_loaded + count( $grid_posts ),
			]
		);
	}

	/**
	 * Handle ajax request and provide posts to load.
	 *
	 * @since 0.6.4
	 */
	public function ajax_pagination_load() {

		// Activate referer check with hook (optional)
		if ( apply_filters( 'anwp-pg-el/config/check_public_nonce', false ) ) {
			check_ajax_referer( 'anwp-pg-public-nonce' );
		}

		$current_page = absint( $_POST['page'] );

		if ( ! absint( $current_page ) ) {
			wp_send_json_error();
		}

		// Parse with default values
		$args = wp_parse_args(
			wp_unslash( $_POST['args'] ),
			[
				'layout'                 => '',
				'posts_to_show'          => 'latest',
				'include_ids'            => '',
				'exclude_ids'            => '',
				'exclude_by_category'    => '',
				'filter_by_category'     => '',
				'filter_by_tag'          => '',
				'filter_by_post_format'  => '',
				'filter_by_author'       => '',
				'published_in_last_days' => 0,
				'limit'                  => 3,
				'offset'                 => 0,
				'grid_cols'              => 3,
				'grid_cols_tablet'       => 2,
				'grid_cols_mobile'       => 1,
				'grid_thumbnail_size'    => 'large',
				'show_category'          => 'yes',
				'category_limit'         => 1,
				'show_date'              => 'yes',
				'show_comments'          => 'yes',
				'card_height'            => '180',
				'show_excerpt'           => 'yes',
				'excerpt_num_words'      => '',
				'excerpt_source'         => '',
				'excerpt_html'           => '',
				'post_image_width'       => '1_3',
				'show_post_icon'         => 'yes',
				'grid_post'              => (object) [],
				'query_source'           => '',
				'related_posts'          => '',
				'related_posts_order'    => '',
				'related_post_id'        => '',
				'card_height_mobile'     => '',
				'card_height_tablet'     => '',
			]
		);

		// Sanitize and validate
		$data = [
			'posts_to_show'          => sanitize_text_field( $args['posts_to_show'] ),
			'include_ids'            => wp_parse_id_list( $args['include_ids'] ),
			'exclude_ids'            => wp_parse_id_list( $args['exclude_ids'] ),
			'filter_by_category'     => wp_parse_id_list( $args['filter_by_category'] ),
			'exclude_by_category'    => wp_parse_id_list( $args['exclude_by_category'] ),
			'filter_by_tag'          => wp_parse_id_list( $args['filter_by_tag'] ),
			'filter_by_post_format'  => sanitize_text_field( $args['filter_by_post_format'] ),
			'filter_by_author'       => wp_parse_id_list( $args['filter_by_author'] ),
			'published_in_last_days' => absint( $args['published_in_last_days'] ),
			'limit'                  => absint( $args['limit'] ),
			'category_limit'         => absint( $args['category_limit'] ),
			'offset'                 => absint( $args['offset'] ),
			'grid_cols'              => absint( $args['grid_cols'] ),
			'grid_cols_tablet'       => absint( $args['grid_cols_tablet'] ),
			'grid_cols_mobile'       => absint( $args['grid_cols_mobile'] ),
			'grid_thumbnail_size'    => sanitize_text_field( $args['grid_thumbnail_size'] ),
			'show_category'          => sanitize_text_field( $args['show_category'] ),
			'show_date'              => sanitize_text_field( $args['show_date'] ),
			'show_comments'          => sanitize_text_field( $args['show_comments'] ),
			'card_height'            => is_array( $args['card_height'] ) ? array_map( 'sanitize_text_field', $args['card_height'] ) : '',
			'card_height_mobile'     => is_array( $args['card_height_mobile'] ) ? array_map( 'sanitize_text_field', $args['card_height_mobile'] ) : '',
			'card_height_tablet'     => is_array( $args['card_height_tablet'] ) ? array_map( 'sanitize_text_field', $args['card_height_tablet'] ) : '',
			'show_excerpt'           => sanitize_text_field( $args['show_excerpt'] ),
			'excerpt_num_words'      => sanitize_text_field( $args['excerpt_num_words'] ),
			'excerpt_html'           => sanitize_text_field( $args['excerpt_html'] ),
			'excerpt_source'         => sanitize_text_field( $args['excerpt_source'] ),
			'post_image_width'       => sanitize_text_field( $args['post_image_width'] ),
			'layout'                 => sanitize_text_field( $args['layout'] ),
			'show_author'            => sanitize_text_field( $args['show_author'] ),
			'show_read_more'         => sanitize_text_field( $args['show_read_more'] ),
			'read_more_label'        => sanitize_text_field( $args['read_more_label'] ),
			'read_more_class'        => sanitize_text_field( $args['read_more_class'] ),
			'show_post_icon'         => sanitize_text_field( $args['show_post_icon'] ),
			'query_source'           => sanitize_text_field( $args['query_source'] ),
			'related_posts'          => sanitize_text_field( $args['related_posts'] ),
			'related_posts_order'    => sanitize_text_field( $args['related_posts_order'] ),
			'related_post_id'        => sanitize_text_field( $args['related_post_id'] ),
		];

		$data['offset'] = $data['offset'] + ( $data['limit'] * ( $current_page - 1 ) );

		/**
		 * Filter pagination arguments.
		 *
		 * @param array Array of arguments
		 *
		 * @since 0.8.2
		 */
		$data = apply_filters( 'anwp-pg-el/admin/elements_pagination_args', $data, $_POST );

		$grid_posts = $this->get_grid_posts( $data );

		// Start output
		ob_start();

		foreach ( $grid_posts as $grid_post ) {
			$data['grid_post'] = $grid_post;

			if ( 'classic' === $data['layout'] ) {
				anwp_post_grid()->load_partial( $data, 'teaser/classic' );
			} else {
				anwp_post_grid()->load_partial( $data, 'teaser/teaser', sanitize_key( $data['layout'] ) );
			}
		}

		$html_output = ob_get_clean();

		wp_send_json_success(
			[
				'html' => $html_output,
			]
		);
	}

	/**
	 * Load Query section
	 *
	 * @param Widget_Base $element
	 *
	 * @since 0.8.3
	 */
	public function load_query_section( $element ) {

		$element_name = $element->get_name();

		/*
		|--------------------------------------------------------------------
		| Prepare widget dependent options
		|--------------------------------------------------------------------
		*/
		switch ( $element_name ) {
			case 'anwp-pg-classic-slider':
			case 'anwp-pg-simple-slider':
				$default_posts_limits = 6;
				break;

			case 'anwp-pg-pro-card-slider':
			case 'anwp-pg-pro-hero-slider':
				$default_posts_limits = 5;
				break;

			case 'anwp-pg-pro-mosaic-slider':
				$default_posts_limits = 12;
				break;

			case 'anwp-pg-pro-news-ticker':
				$default_posts_limits = 10;
				break;

			default:
				$default_posts_limits = 3;
		}

		/*
		|--------------------------------------------------------------------
		| Query Section
		|--------------------------------------------------------------------
		*/
		$element->start_controls_section(
			'section_anwp_grid_options',
			[
				'label' => __( 'Query', 'anwp-post-grid' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$element->add_control(
			'query_source',
			[
				'label'       => __( 'Source', 'anwp-post-grid' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'posts',
				'options'     => anwp_post_grid()->elements->get_source_options(),
				'label_block' => true,
			]
		);

		$element->add_control(
			'posts_to_show',
			[
				'label'       => __( 'Posts to Show', 'anwp-post-grid' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'latest',
				'options'     => anwp_post_grid()->elements->get_posts_to_show_options(),
				'label_block' => true,
				'condition'   => [
					'query_source' => 'posts',
				],
			]
		);

		$element->add_control(
			'hr',
			[
				'type'         => Controls_Manager::DIVIDER,
				'query_source' => 'posts',
			]
		);

		$element->add_control(
			'include_ids',
			[
				'label'       => __( 'Selected Posts', 'anwp-post-grid' ),
				'type'        => 'anwp-id-selector',
				'description' => __( 'Comma-separated Post IDs. Click on magnifying glass to open search panel.', 'anwp-post-grid' ),
				'label_block' => true,
				'context'     => 'posts',
				'condition'   => [
					'posts_to_show' => 'custom',
					'query_source'  => 'posts',
				],
			]
		);

		$element->add_control(
			'filter_by_category',
			[
				'label'       => __( 'Filter by Category', 'anwp-post-grid' ),
				'type'        => 'anwp-id-selector',
				'description' => __( 'Comma-separated Category IDs. Click on magnifying glass to open search panel.', 'anwp-post-grid' ),
				'label_block' => true,
				'context'     => 'categories',
				'condition'   => [
					'posts_to_show!' => 'custom',
					'query_source'   => 'posts',
				],
			]
		);

		$element->add_control(
			'filter_by_tag',
			[
				'label'       => __( 'Filter by Tag', 'anwp-post-grid' ),
				'type'        => 'anwp-id-selector',
				'description' => __( 'Comma-separated Tag IDs. Click on magnifying glass to open search panel.', 'anwp-post-grid' ),
				'label_block' => true,
				'context'     => 'tags',
				'condition'   => [
					'posts_to_show!' => 'custom',
					'query_source'   => 'posts',
				],
			]
		);

		$element->add_control(
			'filter_by_post_format',
			[
				'label'       => __( 'Filter by Post Format', 'anwp-post-grid' ),
				'type'        => Controls_Manager::SELECT,
				'multiple'    => true,
				'label_block' => true,
				'default'     => 'all',
				'options'     => anwp_post_grid()->elements->get_post_format_options(),
				'condition'   => [
					'posts_to_show!' => 'custom',
					'query_source'   => 'posts',
				],
			]
		);

		$element->add_control(
			'filter_by_author',
			[
				'label'       => __( 'Filter by Author', 'anwp-post-grid' ),
				'label_block' => true,
				'type'        => 'anwp-id-selector',
				'description' => __( 'Comma-separated User IDs. Click on magnifying glass to open search panel.', 'anwp-post-grid' ),
				'context'     => 'authors',
				'condition'   => [
					'posts_to_show!' => 'custom',
					'query_source'   => 'posts',
				],
			]
		);

		$element->add_control(
			'hr2',
			[
				'type'      => Controls_Manager::DIVIDER,
				'condition' => [
					'posts_to_show!' => 'custom',
					'query_source'   => 'posts',
				],
			]
		);

		/*
		|--------------------------------------------------------------------
		| Hide Limit Section in Hero Block
		|--------------------------------------------------------------------
		*/
		if ( ! in_array( $element_name, [ 'anwp-pg-hero-block' ], true ) ) {
			$element->add_control(
				'limit',
				[
					'label'       => __( 'Posts Limit', 'anwp-post-grid' ),
					'label_block' => false,
					'description' => __( 'Set post limit. Use "-1" to show all.', 'anwp-post-grid' ),
					'type'        => Controls_Manager::NUMBER,
					'min'         => - 1,
					'step'        => 1,
					'default'     => $default_posts_limits,
					'condition'   => [
						'posts_to_show!' => 'custom',
					],
				]
			);

			$element->add_control(
				'hr3',
				[
					'type'      => Controls_Manager::DIVIDER,
					'condition' => [
						'posts_to_show!' => 'custom',
					],
				]
			);
		}

		/*
		|--------------------------------------------------------------------
		| Hero Block - Fallback
		|--------------------------------------------------------------------
		*/
		if ( 'anwp-pg-hero-block' === $element_name ) {
			$element->add_control(
				'hero_fallback_notice',
				[
					'label'     => '',
					'type'      => Controls_Manager::RAW_HTML,
					'raw'       => __( 'Set fallback of what to show if relevant results are less than 5.', 'anwp-post-grid' ),
					'condition' => [
						'posts_to_show!' => 'custom',
						'query_source'   => 'posts',
					],
				]
			);

			$element->add_control(
				'hero_fallback_option',
				[
					'label'       => __( 'Fallback Options', 'anwp-post-grid' ),
					'type'        => Controls_Manager::SELECT,
					'options'     => [
						'hide'          => __( 'hide widget', 'anwp-post-grid' ),
						'latest'        => __( 'Latest', 'anwp-post-grid' ),
						'oldest'        => __( 'Oldest', 'anwp-post-grid' ),
						'comment_count' => __( 'Most commented', 'anwp-post-grid' ),
					],
					'default'     => 'hide',
					'condition'   => [
						'posts_to_show!' => 'custom',
						'query_source'   => 'posts',
					],
					'label_block' => true,
				]
			);

			$element->add_control(
				'hr3_hero',
				[
					'type'      => Controls_Manager::DIVIDER,
					'condition' => [
						'posts_to_show!' => 'custom',
						'query_source'   => 'posts',
					],
				]
			);
		}

		$element->add_control(
			'exclude_ids',
			[
				'label'       => __( 'Exclude Posts', 'anwp-post-grid' ),
				'type'        => 'anwp-id-selector',
				'description' => __( 'Comma-separated Post IDs. Click on magnifying glass to open search panel.', 'anwp-post-grid' ),
				'label_block' => true,
				'context'     => 'posts',
				'condition'   => [
					'posts_to_show!' => 'custom',
					'query_source'   => 'posts',
				],
			]
		);

		$element->add_control(
			'exclude_by_category',
			[
				'label'       => __( 'Exclude by Category', 'anwp-post-grid' ),
				'label_block' => true,
				'type'        => 'anwp-id-selector',
				'description' => __( 'Comma-separated Category IDs. Click on magnifying glass to open search panel.', 'anwp-post-grid' ),
				'context'     => 'categories',
				'condition'   => [
					'posts_to_show!' => 'custom',
					'query_source'   => 'posts',
				],
			]
		);

		$element->add_control(
			'exclude_by_author',
			[
				'label'       => __( 'Exclude by Author', 'anwp-post-grid' ),
				'label_block' => true,
				'type'        => 'anwp-id-selector',
				'description' => __( 'Comma-separated User IDs. Click on magnifying glass to open search panel.', 'anwp-post-grid' ),
				'context'     => 'authors',
				'condition'   => [
					'posts_to_show!' => 'custom',
					'query_source'   => 'posts',
				],
			]
		);

		$element->add_control(
			'hr4',
			[
				'type'      => Controls_Manager::DIVIDER,
				'condition' => [
					'posts_to_show!' => 'custom',
					'query_source'   => 'posts',
				],
			]
		);

		$element->add_control(
			'offset',
			[
				'label'       => __( 'Posts Offset', 'anwp-post-grid' ),
				'description' => __( 'number of post to pass over', 'anwp-post-grid' ),
				'label_block' => false,
				'type'        => Controls_Manager::NUMBER,
				'min'         => 0,
				'step'        => 1,
				'default'     => 0,
				'condition'   => [
					'posts_to_show!' => 'custom',
					'query_source'   => 'posts',
				],
			]
		);

		$element->add_control(
			'hr5',
			[
				'type'      => Controls_Manager::DIVIDER,
				'condition' => [
					'posts_to_show!' => 'custom',
					'query_source'   => 'posts',
				],
			]
		);

		$element->add_control(
			'published_in_last_days',
			[
				'label'       => __( 'Published in Last days', 'anwp-post-grid' ),
				'label_block' => false,
				'type'        => Controls_Manager::NUMBER,
				'min'         => 0,
				'default'     => 0,
				'condition'   => [
					'posts_to_show!' => 'custom',
					'query_source'   => 'posts',
				],
			]
		);

		$element->add_control(
			'related_posts',
			[
				'label'       => __( 'Show Related posts', 'anwp-post-grid' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => [
					'related_category' => __( 'with the same category', 'anwp-post-grid' ),
					'related_tag'      => __( 'with the same tag', 'anwp-post-grid' ),
					'related_author'   => __( 'from the same author', 'anwp-post-grid' ),
				],
				'default'     => 'related_category',
				'condition'   => [
					'query_source' => 'related',
				],
				'label_block' => true,
			]
		);

		$element->add_control(
			'related_posts_order',
			[
				'label'     => __( 'Related posts order', 'anwp-post-grid' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => anwp_post_grid()->elements->get_related_order_options(),
				'default'   => 'latest',
				'condition' => [
					'query_source' => 'related',
				],
			]
		);

		$element->end_controls_section();
	}

	/**
	 * Load Header section
	 *
	 * @param Widget_Base $element
	 *
	 * @since 0.8.3
	 */
	public function load_header_section( $element ) {

		/*
		|--------------------------------------------------------------------
		| Header
		|--------------------------------------------------------------------
		*/
		$element->start_controls_section(
			'section_anwp_grid_header',
			[
				'label' => __( 'Widget Header', 'anwp-post-grid' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$element->add_control(
			'grid_widget_title',
			[
				'label'       => __( 'Title', 'anwp-post-grid' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => __( 'Enter your title', 'anwp-post-grid' ),
			]
		);

		$element->add_control(
			'header_style',
			[
				'label'        => __( 'Header Style', 'anwp-post-grid' ),
				'type'         => Controls_Manager::SELECT,
				'options'      => [
					'a' => __( 'Style A', 'anwp-post-grid' ),
					'b' => __( 'Style B', 'anwp-post-grid' ),
					'c' => __( 'Style C', 'anwp-post-grid' ),
					'd' => __( 'Style D', 'anwp-post-grid' ),
					'e' => __( 'Style E', 'anwp-post-grid' ),
					'f' => __( 'Style F', 'anwp-post-grid' ),
					'g' => __( 'Style G', 'anwp-post-grid' ),
				],
				'default'      => 'b',
				'prefix_class' => 'anwp-pg-widget-header-style--',
			]
		);

		$element->add_control(
			'header_size',
			[
				'label'   => __( 'Header Text HTML Tag', 'anwp-post-grid' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'h1'   => 'H1',
					'h2'   => 'H2',
					'h3'   => 'H3',
					'h4'   => 'H4',
					'h5'   => 'H5',
					'h6'   => 'H6',
					'div'  => 'div',
					'span' => 'span',
					'p'    => 'p',
				],
				'default' => 'h3',
			]
		);

		$element->add_control(
			'title_color',
			[
				'label'     => __( 'Header Text Color', 'anwp-post-grid' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .anwp-pg-widget-header__title' => 'color: {{VALUE}};',
				],
			]
		);

		$element->add_control(
			'header_icon',
			[
				'label' => __( 'Header Icon', 'anwp-post-grid' ),
				'type'  => Controls_Manager::ICONS,
			]
		);

		$element->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'typography',
				'scheme'   => Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .anwp-pg-widget-header__title',
			]
		);

		$element->add_control(
			'secondary_color',
			[
				'label'     => __( 'Secondary Color', 'anwp-post-grid' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#61CE70',
				'selectors' => [
					'{{WRAPPER}} .anwp-pg-widget-header__secondary-line'                       => 'background-color: {{VALUE}};',
					'{{WRAPPER}}.anwp-pg-widget-header-style--b .anwp-pg-widget-header__title' => 'background-color: {{VALUE}};',
					'{{WRAPPER}}.anwp-pg-widget-header-style--c .anwp-pg-widget-header__title' => 'background-color: {{VALUE}};',
				],
			]
		);

		$element->add_control(
			'header_margin_bottom',
			[
				'label'      => __( 'Bottom Margin', 'anwp-post-grid' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 50,
						'step' => 1,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 15,
				],
				'selectors'  => [
					'{{WRAPPER}} .anwp-pg-widget-header' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$element->add_control(
			'secondary_line_size',
			[
				'label'      => __( 'Secondary Line Size', 'anwp-post-grid' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 50,
						'step' => 1,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 2,
				],
				'selectors'  => [
					'{{WRAPPER}}.anwp-pg-widget-header-style--b .anwp-pg-widget-header__secondary-line' => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.anwp-pg-widget-header-style--c .anwp-pg-widget-header__secondary-line' => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.anwp-pg-widget-header-style--d .anwp-pg-widget-header__secondary-line' => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.anwp-pg-widget-header-style--e .anwp-pg-widget-header__secondary-line' => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.anwp-pg-widget-header-style--f .anwp-pg-widget-header__secondary-line' => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.anwp-pg-widget-header-style--g .anwp-pg-widget-header__secondary-line' => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.anwp-pg-widget-header-style--g .anwp-pg-widget-header__title' => 'margin-left: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$element->end_controls_section();

	}

	/**
	 * Get Post card height
	 *
	 * @param object $args
	 *
	 * @return string
	 * @since 0.8.3
	 */
	public function get_post_card_height( $args, $default_size = 180 ) {

		$args = (object) wp_parse_args(
			$args,
			[
				'card_height'        => $default_size,
				'card_height_mobile' => '',
				'card_height_tablet' => '',
			]
		);

		if ( empty( $args->card_height_mobile['size'] ) && empty( $args->card_height_tablet['size'] ) ) {
			$card_height = ( ! empty( $args->card_height['size'] ) && $args->card_height['size'] >= 150 ) ? absint( $args->card_height['size'] ) : $default_size;

			return 'anwp-pg-height-' . $card_height;
		}

		// Card Height
		$card_height_classes = [];

		// Mobile height (0 - 576px)
		if ( empty( $args->card_height_mobile['size'] ) ) {
			$card_height           = ( ! empty( $args->card_height['size'] ) && $args->card_height['size'] >= 150 ) ? absint( $args->card_height['size'] ) : $default_size;
			$card_height_classes[] = 'anwp-pg-height-' . $card_height;
		} else {
			$card_height           = ( ! empty( $args->card_height_mobile['size'] ) && $args->card_height_mobile['size'] >= 150 ) ? absint( $args->card_height_mobile['size'] ) : $default_size;
			$card_height_classes[] = 'anwp-pg-height-' . $card_height;
		}

		// Tablet height (device width:  576px - 992px)
		if ( empty( $args->card_height_tablet['size'] ) ) {
			$card_height           = ( ! empty( $args->card_height['size'] ) && $args->card_height['size'] >= 150 ) ? absint( $args->card_height['size'] ) : $default_size;
			$card_height_classes[] = 'anwp-pg-sm-height-' . $card_height;
		} else {
			$card_height           = ( ! empty( $args->card_height_tablet['size'] ) && $args->card_height_tablet['size'] >= 150 ) ? absint( $args->card_height_tablet['size'] ) : $default_size;
			$card_height_classes[] = 'anwp-pg-sm-height-' . $card_height;
		}

		// Desktop height (device width:  992px and up)
		$card_height           = ( ! empty( $args->card_height['size'] ) && $args->card_height['size'] >= 150 ) ? absint( $args->card_height['size'] ) : $default_size;
		$card_height_classes[] = 'anwp-pg-lg-height-' . $card_height;

		return implode( ' ', $card_height_classes );
	}

	/**
	 * Get Post categories
	 *
	 * @param int $post_id
	 *
	 * @return array
	 * @since 0.8.5
	 */
	public function get_post_categories( $post_id ) {

		$output = get_the_category( $post_id );

		if ( empty( $output ) ) {
			return [];
		}

		/*
		|--------------------------------------------------------------------
		| Order
		|--------------------------------------------------------------------
		*/
		$category_order = AnWP_Post_Grid_Settings::get_value( 'category_ordering' );

		if ( ! empty( $category_order ) ) {

			$output = array_map(
				function ( $arr ) {
					$arr->anwp_pg_parent = absint( $arr->parent ) ? 1 : 0;

					return $arr;
				},
				$output
			);

			if ( 'parent_children' === $category_order ) {
				$output = wp_list_sort( $output, [ 'anwp_pg_parent' => 'ASC' ] );

			} elseif ( 'children_parent' === $category_order ) {
				$output = wp_list_sort( $output, [ 'anwp_pg_parent' => 'DESC' ] );
			}
		}

		/*
		|--------------------------------------------------------------------
		| Filter by Level
		|--------------------------------------------------------------------
		*/



		return $output;
	}
}


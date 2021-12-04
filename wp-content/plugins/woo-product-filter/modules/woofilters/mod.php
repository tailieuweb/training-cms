<?php
class WoofiltersWpf extends ModuleWpf {
	public $mainWCQuery = '';
	public $mainWCQueryFiltered = '';
	public $shortcodeWCQuery = array();
	public $shortcodeWCQueryFiltered = array();
	public $shortcodeFilterKey = 'wpf-filter-';
	public $currentFilterId = null;
	public $currentFilterWidget = true;
	public $renderModes = array();
	public $preselects = array();
	public $preFilters = array();
	public $displayMode = null;
	private $wcAttributes = null;
	public static $loadShortcode = array();
	public static $currentElementorClass = '';
	public $clauses = array();
	public $clausesLight = array();
	public $hookedClauses = false;
	public $isLightMode = false;
	public $tempFilterTable = 'wpf_temp_table';
	public $tempVarTable = 'wpf_temp_var_table';
	public $tempTables = array();
	public $metaKeys = null;

	public function init() {
		DispatcherWpf::addFilter('mainAdminTabs', array($this, 'addAdminTab'));
		add_shortcode(WPF_SHORTCODE, array($this, 'render'));
		add_shortcode(WPF_SHORTCODE_PRODUCTS, array($this, 'renderProductsList'));
		add_shortcode(WPF_SHORTCODE_SELECTED_FILTERS, array($this, 'renderSelectedFilters'));

		if ( is_admin() ) {
			add_action( 'admin_notices', array( $this, 'showAdminErrors' ) );
		} elseif ( '1' !== ReqWpf::getVar( 'wpf_skip' ) ) {
			if ( ! class_exists( 'Popup_Maker' ) ) {
				add_action( 'wp_enqueue_scripts', array( $this, 'addScriptsLisener' ), 999 );
			}
			add_filter( 'yith_wapo_disable_jqueryui', function ( $d ) {
				return true;
			}, 999 );
		} else {
			add_filter( 'woocommerce_redirect_single_search_result', function () {
				return false;
			} );
		}

		FrameWpf::_()->addScript('jquery-ui-autocomplete', '', array('jquery'), false, true);

		add_action('woocommerce_product_query', array($this, 'loadProductsFilter'));
		add_action('woocommerce_shortcode_products_query', array($this, 'loadShortcodeProductsFilter'), 999, 3);
		//add_filter('woocommerce_product_query_tax_query', array($this, 'customProductQueryTaxQuery'), 10, 1);

		add_action('woocommerce_shortcode_before_products_loop', array($this, 'addWoocommerceShortcodeQuerySettings'));
		add_action('woocommerce_shortcode_before_sale_products_loop', array($this, 'addWoocommerceShortcodeQuerySettings'));

		trait_exists('\Essential_Addons_Elementor\Template\Content\Product_Grid') && add_action('pre_get_posts', array($this, 'loadProductsFilterForProductGrid'), 999);

		add_filter('loop_shop_per_page', array($this, 'newLoopShopPerPage'), 99999 );

		class_exists( 'WC_pif' ) && add_filter( 'post_class', array( $this, 'WC_pif_product_has_gallery' ) );
		add_filter('yith_woocompare_actions_to_check_frontend', array($this, 'addAjaxFilterForYithWoocompare'), 20 );

		// removing action for theme Themify Ultra
		add_action( 'wp_loaded', function () {
			remove_action('pre_get_posts', 'Tbp_Public::set_archive_per_page');
		} );

		add_filter('woocommerce_shortcode_products_query_results', array($this, 'queryResults'));
		add_action('elementor/widget/before_render_content', array($this, 'getElementorClass'));
		add_action('woocommerce_is_filtered', array($this, 'isFiltered'));
		add_action('shortcode_atts_products', array($this, 'shortcodeAttsProducts'), 999, 3);
		$this->setFilterClauses();
		if ( ! function_exists( 'is_plugin_active' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}
		if ( is_plugin_active( 'divi-bodycommerce/divi-bodyshop-woocommerce.php' ) ) {
			add_filter( 'db_archive_module_args', array( $this, 'replaceArgsIfBuilderUsed' ) );
		}
		if ( is_plugin_active( 'fusion-builder/fusion-builder.php' ) ) {
			add_filter( 'fusion_post_cards_shortcode_query_args', array( $this, 'replaceArgsIfBuilderUsed' ) );
		}
		if ( is_plugin_active( 'show-products-by-attributes-variations/addify_show_variation_single_product.php' ) ) {
			remove_all_actions( 'woocommerce_product_query', 100 );
		}

		add_action( 'pre_get_posts', array( $this, 'forceProductFilter' ), 9999 );
		add_filter( 'woocommerce_blocks_product_grid_is_cacheable', function () {
			return false;
		} );
	}

	public function forceProductFilter( $query ) {

		if ( function_exists( 'debug_backtrace' ) ) {
			$backtrace = debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS, 6 );
			if ( is_array( $backtrace ) && isset( $backtrace[5]['class'] ) && 'Automattic\WooCommerce\Blocks\BlockTypes\AbstractProductGrid' === $backtrace[5]['class'] ) {
				$this->loadProductsFilter( $query );
			}
		}

		return $query;
	}

	public function replaceArgsIfBuilderUsed( $args ) {
		if ( isset( $this->mainWCQueryFiltered ) && ! empty( $this->mainWCQueryFiltered ) ) {
			$args = $this->mainWCQueryFiltered;
		}

		return $args;
	}

	public function getTempTable( $table ) {
		return empty($this->tempTables[$table]) ? false : $this->tempTables[$table];
	}

	public function addFilterClauses( $clauses, $isLight = false ) {
		if (empty($clauses)) {
			return;
		}
		$saved = $isLight ? $this->clausesLight : $this->clauses;
		$lastI = 0;
		if (empty($saved)) {
			$saved = array('join' => array(), 'where' => array());
		} else {		
			foreach ($saved as $key => $arr) {
				foreach ($arr as $i => $str) {
					if ($i > $lastI) {
						$lastI = $i;
					}
				}
			}
		}

		if (!empty($clauses['join'])) {

			foreach ($clauses['join'] as $i => $str) {
				if (!empty($str)) {
					$where = isset($clauses['where'][$i]) ? $clauses['where'][$i] : '';
					$jw = $str . $where;
					$found = false;
					foreach ($saved['join'] as $e => $s) {
						if ( $s . ( isset($saved['where'][$e]) ? $saved['where'][$e] : '' ) == $jw ) {
							$found = true;
							break;
						}
					}
					if (!$found) {
						$lastI++;
						$saved['join'][$lastI] = $str;
						if (!empty($where)) {
							$saved['where'][$lastI] = $where;
							unset($clauses['where'][$i]);
						}
					}
				}
			}
			unset($clauses['join']);
		}
		foreach ($clauses as $key => $arr) {
			foreach ($arr as $i => $str) {
				if (!isset($saved[$key])) {
					$saved[$key] = array();
				} 
				if (!in_array($str, $saved[$key])) {
					$lastI++;
					$saved[$key][$lastI] = $str;
				}
			}
		}

		if ($isLight) {
			$this->clausesLight = $saved;
		} else {
			$this->clauses = $saved;
		}
	}

	public function setFilterClauses() {
		if (!$this->hookedClauses) {
			add_filter( 'posts_clauses_request', array( $this, 'addFilterClausesRequest' ), 10, 2 );
			$this->hookedClauses = true;
		}
	}

	public function addFilterClausesRequest( $clauses, $wp_query ) {
		if ( ( ! empty( $wp_query->query_vars['wpf_query'] ) && $this->validPostType( $wp_query ) ) || ( $wp_query->is_main_query() && isset( $wp_query->query_vars['wc_query'] ) && ! empty( $wp_query->query_vars['wc_query'] ) && 'product_query' === $wp_query->query_vars['wc_query'] ) ) {
			$filterClauses = $this->isLightMode ? $this->clausesLight : $this->clauses;

			global $wpdb;
			foreach ( $filterClauses as $key => $data ) {
				foreach ( $data as $i => $str ) {
					if ( 'limits' === $key && '' === $str ) {
						$clauses[ $key ] = '';
					} elseif ( ! empty( $str ) ) {
						$sql = str_replace( '__#i', '_' . $i, $str );
						if ( false === strpos( $clauses[ $key ], $sql ) ) {
							$clauses[ $key ]    .= " $sql";
							$clauses['groupby'] = "{$wpdb->posts}.ID";
						}
					}
				}
			}
		}

		return $clauses;
	}

	public function validPostType( $wp_query ) {

		if ( ! isset( $wp_query->query_vars['post_type'] ) ) {
			return false;
		}

		if ( ! in_array( 'product', (array) $wp_query->query_vars['post_type'] ) ) {
			return false;
		}

		return true;
	}

	public function getMetaKeyId( $key, $field = 'id' ) {
		$key = strtolower($key);
		if (is_null($this->metaKeys)) {
			$this->metaKeys = FrameWpf::_()->getModule('meta')->getModel('meta_keys')->getKeysWithCalcControl();
		}
		return isset($this->metaKeys[$key]) && ( 1 == $this->metaKeys[$key]['status'] ) ? $this->metaKeys[$key][$field] : false;
	}
	public function resetMetaKeys() {
		$this->metaKeys = null;
	}

	public function isFiltered( $filtered ) {
		if ( ! $filtered ) {
			$filtered = count(ReqWpf::get( 'get' )) > 0;
		}

		return $filtered;
	}

	public function newLoopShopPerPage( $count ) {
		$options = FrameWpf::_()->getModule('options')->getModel('options')->getAll();
		if ( isset($options['count_product_shop']) && isset($options['count_product_shop']['value']) && !empty($options['count_product_shop']['value']) ) {
			$count  = $options['count_product_shop']['value'];
		}
		return $count ;
	}

	public function addWooOptions( $args ) {
		if (get_option('woocommerce_hide_out_of_stock_items') == 'yes') {
			$args['meta_query'][] = array(
					'key'     => '_stock_status',
					'value'   => 'outofstock',
					'compare' => '!='
			);
		}

		$options = FrameWpf::_()->getModule( 'options' )->getModel( 'options' )->getAll();
		if ( isset($options['hide_without_price']) && '1' === $options['hide_without_price']['value'] ) {
			$args['meta_query'][] = array(
					'key'     => '_price',
					'value'   => array('', 0),
					'compare' => 'NOT IN'
			);
		}

		return $args;
	}

	public function addScriptsLisener() {
		$js = 'var v = jQuery.fn.jquery;
			if (v && parseInt(v) >= 3 && window.self === window.top) {
				var readyList=[];
				window.originalReadyMethod = jQuery.fn.ready;
				jQuery.fn.ready = function(){
					if(arguments.length && arguments.length > 0 && typeof arguments[0] === "function") {
						readyList.push({"c": this, "a": arguments});
					}
					return window.originalReadyMethod.apply( this, arguments );
				};
				window.wpfReadyList = readyList;
			}';
		wp_add_inline_script('jquery', $js, 'after');
	}

	public function setCurrentFilter( $id, $isWidget ) {
		$this->currentFilterId = $id;
		$this->currentFilterWidget = $isWidget;
	}

	public function getPreselectedValue( $val = '' ) {
		if (empty($val)) {
			return $this->preselects;
		}
		return isset($this->preselects[$val]) ? $this->preselects[$val] : null;
	}
	public function addPreselectedParams() {
		if (!is_admin()) {
			if (is_null($this->currentFilterId)) {
				global $wp_registered_widgets;
				$filterWidget = 'wpfwoofilterswidget';

				$widgetOpions = get_option('widget_' . $filterWidget);
				$sidebarsWidgets = wp_get_sidebars_widgets();
				$preselects = array();
				$filters = array();
				
				if ( is_array($sidebarsWidgets) && !empty($widgetOpions) ) {
					foreach ($sidebarsWidgets as $sidebar => $widgets) {
						if ( ( 'wp_inactive_widgets' === $sidebar || 'orphaned_widgets' === substr($sidebar, 0, 16) ) ) {
							continue;
						}
						if (is_array($widgets)) {
							foreach ($widgets as $widget) {
								$ids = explode('-', $widget);

								// if the filter is added using the Legacy Widget
								if ( count($ids) == 2 && $ids[0] == $filterWidget ) {
									if ( isset($widgetOpions[$ids[1]]) && isset($widgetOpions[$ids[1]]['id']) ) {
										$filterId = $widgetOpions[$ids[1]]['id'];

										if (!isset($filters[$filterId])) {
											$preselects = array_merge($preselects, $this->getPreselectedParamsForFilter($filterId));
											$filters[$filterId] = 1;
										}
									}
								} elseif ( isset( $wp_registered_widgets[ $widget ] ) ) {
								// trying to find the filter shortcode in the text widget
									$opts    = $wp_registered_widgets[ $widget ];
									$id_base = is_array( $opts['callback'] ) ? $opts['callback'][0]->id_base : $opts['callback'];

									if ( ! $id_base ) {
										continue;
									}

									$instance = get_option( 'widget_' . $id_base );

									if ( ! $instance || ! is_array( $instance ) ) {
										continue;
									}

									foreach ( $instance as $item ) {
										$content = '';

										if ( isset( $item['text'] ) ) {
											$content = $item['text'];
										} elseif ( isset( $item['content'] ) ) {
											$content = $item['content'];
										}

										if ( '' !== $content ) {
											preg_match( '/\[wpf-filters\s+id="?(\d)+"?\]/', $content, $matches );
											if ( isset( $matches[1] ) ) {
												$filterId             = $matches[1];
												$preselects           = array_merge( $preselects, $this->getPreselectedParamsForFilter( $filterId ) );
												$filters[ $filterId ] = 1;
											}
										}
									}
								}
							}
						}
					}
				}
			} else {
				$preselects = $this->getPreselectedParamsForFilter($this->currentFilterId);
			}

			$this->preselects = array();
			foreach ($preselects as $value) {
				if (!empty($value)) {
					$paar = explode('=', $value);
					if (count($paar) == 2) {
						$name = $paar[0];
						$var = $paar[1];
						if ( 'min_price' == $name || 'max_price' == $name ) {
							$var = $this->getCurrencyPrice($var);
						}

						$this->preselects[$name] = $var;
					}
				}
			}
		}
	}
	public function getPreselectedParamsForFilter( $filterId ) {
		if (!isset($this->preFilters[$filterId])) {
			$preselects = array();
			$filter = $this->getModel('woofilters')->getById($filterId);
			if ($filter) {
				$settings = unserialize($filter['setting_data']);
				$preselect = !empty($settings['settings']['filters']['preselect']) ? $settings['settings']['filters']['preselect'] : '';
				if (!empty($preselect)) {
					$mode = $this->getRenderMode($filterId, $settings);
					if ($mode > 0) {
						$preselects = explode(';', $preselect);
					}
				}
				if ( defined('WPF_FREE_REQUIRES') && version_compare( '1.4.9', WPF_FREE_REQUIRES, '==' ) ) {
					$preselects = DispatcherWpf::applyFilters( 'addDefaultFilterData', $preselects, $filterId, $settings );
				} else {
					DispatcherWpf::doAction( 'addDefaultFilterData', $filterId, $settings );
				}
			}
			$this->preFilters[$filterId] = $preselects;
		}
		return $this->preFilters[$filterId];
	}

	public function searchValueQuery( $arrQuery, $key, $value, $delete = false ) {
		if ( ! empty( $arrQuery ) ) {
			foreach ( $arrQuery as $i => $q ) {
				if ( is_array( $q ) && isset( $q[ $key ] ) && $value == $q[ $key ] ) {
					if ( $delete ) {
						unset( $arrQuery[ $i ] );
					} else {
						return $i;
					}
				}
			}
		}

		return $arrQuery;
	}

	public function addCustomFieldsQuery( $data, $mode ) {
		$fields = array();
		if (count($data) == 0) {
			return $fields;
		}

		if (!empty($data['pr_onsale'])) {
			$fields['post__in'] = array_merge(array(0), wc_get_product_ids_on_sale());
		}
		if (!empty($data['pr_author'])) {
			$slugs = explode('|', $data['pr_author']);

			$userIds = array();
			foreach ( $slugs as $userSlug ) {
				$userObj = get_user_by( 'slug', $userSlug );
				if ( isset( $userObj->ID ) ) {
					$userIds[] = $userObj->ID;
				}
			}

			if ( ! empty( $userIds ) ) {
				$fields['author__in'] = $userIds;
			}
		}
		if (!empty($data['vendors'])) {
			$userObj = get_user_by('slug', ReqWpf::getVar('vendors'));
			if (isset($userObj->ID)) {
				$fields['author'] = $userObj->ID;
			}
		}
		if (!empty($data['wpf_count'])) {
			$fields['posts_per_page'] = $data['wpf_count'];
		}

		$fields = DispatcherWpf::applyFilters('addCustomFieldsQueryPro', $fields, $data, $mode);
		return $fields;
	}

	public function addCustomMetaQuery( $metaQuery, $data, $mode ) {
		if (!is_array($metaQuery)) {
			$metaQuery = array();
		}
		
		if (count($data) == 0) {
			return $metaQuery;
		}
		
		$minPrice = ( isset($data['min_price']) ) ? $data['min_price'] : null;
		$maxPrice = ( isset($data['max_price']) ) ? $data['max_price'] : null;
		$price = $this->preparePriceFilter($minPrice, $maxPrice);
		
		if (false != $price) {
			$metaQuery = array_merge($metaQuery, $price);
			remove_filter('posts_clauses', array(WC()->query, 'price_filter_post_clauses' ), 10, 2);
		}
		if (!empty($data['pr_stock'])) {
			$slugs = explode('|', $data['pr_stock']);
			if ($slugs) {
				$metaQuery = $this->searchValueQuery($metaQuery, 'key', '_stock_status', true);
				$metaKeyId = $this->getMetaKeyId('_stock_status');
				if ($metaKeyId) {
					$values = FrameWpf::_()->getModule('meta')->getModel('meta_values')->getMetaValueIds($metaKeyId, $slugs);
					$this->addWpfMetaClauses(array('keyId' => $metaKeyId, 'isAnd' => false, 'values' => $values, 'field' => 'id', 'isLight' => 'preselect' == $mode));
				} else {
					$metaQuery[] = array(
						'key' => '_stock_status',
						'value' => $slugs,
						'compare' => 'IN'
					);
				}
			}			
		}
		if (!empty($data['pr_rating'])) {
			$ratingRange = $data['pr_rating'];
			$range = strpos($ratingRange, '-') !== false ? explode('-', $ratingRange) : array(intval($ratingRange));
			if (isset($range[1]) && intval($range[1]) !== 5) {
				$range[1] = $range[1] - 0.001;
			}
			if ($range[0]) {
				$metaQuery = $this->searchValueQuery($metaQuery, 'key', '_wc_average_rating', true);
				$isBetween = isset($range[1]) && $range[1];
				$metaKeyId = $this->getMetaKeyId('_wc_average_rating');
				if ($metaKeyId) {
					$this->addWpfMetaClauses(array('keyId' => $metaKeyId, 'isAnd' => ( $isBetween ? 'BETWEEN' : false ), 'values' => $range, 'field' => 'int', 'isLight' => 'preselect' == $mode));
				} else {
					if ($isBetween) {
						$metaQuery[] = array(
							'key' => '_wc_average_rating',
							'value' => array($range[0], $range[1]),
							'type' => 'DECIMAL',
							'compare' => 'BETWEEN'
						);
					} else {
						$metaQuery[] = array(
							'key' => '_wc_average_rating',
							'value' => $range[0],
							'type' => 'DECIMAL',
							'compare' => '='
						);
					}
				}
			}
		}
		$metaQuery = DispatcherWpf::applyFilters('addCustomMetaQueryPro', $metaQuery, $data, $mode);
		return $metaQuery;
	}

	public function addCustomTaxQuery( $taxQuery, $data, $mode ) {

		if (!is_array($taxQuery)) {
			$taxQuery = array();
		}
		
		$isSlugs = ( 'url' == $mode );
		$isPreselect = ( 'preselect' == $mode );
		// custom tahonomy attr block
		if (!empty($taxQuery)) {
			foreach ($taxQuery as $i => $tax) {
				if (is_array($tax) && isset($tax['field']) && 'slug' == $tax['field']) {
					$name = str_replace('pa_', 'filter_', $tax['taxonomy']);
					if ($isPreselect && ReqWpf::getVar($name)) {
						unset($taxQuery[$i]);
						continue;
					}
					if (!empty($data[$name])) {
						$param = $data[$name];
						$slugs = explode('|', $param);
						if (count($slugs) > 1) {
							$taxQuery[$i]['terms'] = $slugs;
							$taxQuery[$i]['operator'] = 'IN';
						}
					}
				}
			}
		}

		if (count($data) == 0) {
			return $taxQuery;
		}
		
		foreach ($data as $key => $param) {
			if ( is_string( $param ) ) {
				$isNot = ( substr( $param, 0, 1 ) === '!' );
				if ( $isNot ) {
					$param = substr( $param, 1 );
				}
				if ( strpos( $key, 'filter_cat_list' ) !== false ) {
					if ( ! empty( $param ) ) {
						$idsAnd     = explode( ',', $param );
						$idsOr      = explode( '|', $param );
						$isAnd      = count( $idsAnd ) > count( $idsOr );
						$taxQuery[] = array(
							'taxonomy'         => 'product_cat',
							'field'            => ( substr( $key, - 1 ) == 's' ? 'slug' : 'term_id' ),
							'terms'            => $isAnd ? $idsAnd : $idsOr,
							'operator'         => $isNot ? 'NOT IN' : ( $isAnd ? 'AND' : 'IN' ),
							'include_children' => false,
						);
					}
				} else if ( strpos( $key, 'filter_cat_' ) !== false || ( 'filter_cat' == $key ) ) {
					if ( ! empty( $param ) ) {
						$idsAnd     = explode( ',', $param );
						$idsOr      = explode( '|', $param );
						$isAnd      = count( $idsAnd ) > count( $idsOr );
						$taxQuery[] = array(
							'taxonomy'         => 'product_cat',
							'field'            => ( substr( $key, - 1 ) == 's' ? 'slug' : 'term_id' ),
							'terms'            => $isAnd ? $idsAnd : $idsOr,
							'operator'         => $isNot ? 'NOT IN' : ( $isAnd ? 'AND' : 'IN' ),
							'include_children' => true,
						);
					}
				} else if ( strpos( $key, 'product_tag' ) === 0 ) {
					if ( ! empty( $param ) ) {
						$idsAnd     = explode( ',', $param );
						$idsOr      = explode( '|', $param );
						$isAnd      = count( $idsAnd ) > count( $idsOr );
						$taxQuery[] = array(
							'taxonomy'         => 'product_tag',
							'field'            => $isSlugs ? 'slug' : 'id',
							'terms'            => $isAnd ? $idsAnd : $idsOr,
							'operator'         => $isNot ? 'NOT IN' : ( $isAnd ? 'AND' : 'IN' ),
							'include_children' => true,
						);
					}
				} else if ( strpos( $key, 'product_brand' ) === 0 ) {
					if ( ! empty( $param ) ) {
						$idsOr      = explode( ',', $param );
						$idsAnd     = explode( '|', $param );
						$isAnd      = count( $idsAnd ) > count( $idsOr );
						$taxQuery[] = array(
							'taxonomy'         => 'product_brand',
							'field'            => $isSlugs ? 'slug' : 'id',
							'terms'            => $isAnd ? $idsAnd : $idsOr,
							'operator'         => $isNot ? 'NOT IN' : ( $isAnd ? 'AND' : 'IN' ),
							'include_children' => true,
						);
					}
				} else if ( strpos( $key, 'filter_pwb_list' ) !== false ) {
					if ( ! empty( $param ) ) {
						$idsAnd     = explode( ',', $param );
						$idsOr      = explode( '|', $param );
						$isAnd      = count( $idsAnd ) > count( $idsOr );
						$taxQuery[] = array(
							'taxonomy'         => 'pwb-brand',
							'field'            => 'term_id',
							'terms'            => $isAnd ? $idsAnd : $idsOr,
							'operator'         => $isNot ? 'NOT IN' : ( $isAnd ? 'AND' : 'IN' ),
							'include_children' => false,
						);
					}
				} elseif ( strpos( $key, 'filter_pwb' ) !== false ) {
					if ( ! empty( $param ) ) {
						$idsAnd     = explode( ',', $param );
						$idsOr      = explode( '|', $param );
						$isAnd      = count( $idsAnd ) > count( $idsOr );
						$taxQuery[] = array(
							'taxonomy'         => 'pwb-brand',
							'field'            => 'term_id',
							'terms'            => $isAnd ? $idsAnd : $idsOr,
							'operator'         => $isNot ? 'NOT IN' : ( $isAnd ? 'AND' : 'IN' ),
							'include_children' => true,
						);
					}
				} elseif ( strpos( $key, 'pr_filter' ) !== false ) {
					if ( ! empty( $param ) ) {
						$exeptionalLogic = 'not_in';
						$logic           = $this->getAttrFilterLogic();
						if ( ! empty( $logic['delimetr'][ $exeptionalLogic ] ) ) {
							$ids        = explode( $logic['delimetr'][ $exeptionalLogic ], $param );
							$taxonomy   = str_replace( 'pr_filter_', 'pa_', $key );
							$taxonomy  = preg_replace( '/_\d{1,}/', '', $taxonomy );
							$taxQuery[] = array(
								'taxonomy' => $taxonomy,
								'field'    => 'slug',
								'terms'    => $ids,
								'operator' => $logic['loop'][ $exeptionalLogic ],
							);
						}
					}
				} else if ( strpos( $key, 'filter_' ) === 0 ) {
					if ( ! empty( $param ) ) {
						$idsAnd    = explode( ',', $param );
						$idsOr     = explode( '|', $param );
						$isAnd     = count( $idsAnd ) > count( $idsOr );
						$attrIds   = $isAnd ? $idsAnd : $idsOr;
						$taxExists = false;
						if ( $isSlugs ) {
							$taxonomy  = str_replace( 'filter_', '', $key );
							$taxonomy  = preg_replace( '/_\d{1,}/', '', $taxonomy );
							$taxExists = taxonomy_exists( $taxonomy );
							if ( ! $taxExists ) {
								$taxonomy  = 'pa_' . $taxonomy;
								$taxExists = taxonomy_exists( $taxonomy );
							}
						} else {
							$taxonomy = '';
							foreach ( $attrIds as $attr ) {
								$term = get_term( $attr );
								if ( $term ) {
									$taxonomy  = $term->taxonomy;
									$taxExists = true;
									break;
								}
							}
						}
						if ( $taxExists ) {
							$taxQuery[] = array(
								'taxonomy' => $taxonomy,
								'field'    => $isSlugs ? 'slug' : 'id',
								'terms'    => $attrIds,
								'operator' => $isNot ? 'NOT IN' : ( $isAnd ? 'AND' : 'IN' )
							);
						}
					}
				}
			}
		}

		if (!empty($data['pr_featured'])) {
			$taxQuery = $this->searchValueQuery($taxQuery, 'taxonomy', 'product_visibility', true);
			$taxQuery[] = array(
				'taxonomy' => 'product_visibility',
				'field'    => 'name',
				'terms'    => 'featured'
			);
		}
		$taxQuery = DispatcherWpf::applyFilters('addCustomTaxQueryPro', $taxQuery, $data, $mode);

		return $taxQuery;
	}

	public function loadProductsFilter( $q ) {
		$this->addPreselectedParams();

		if (ReqWpf::getVar('all_products_filtering')) {
			$exclude = array('paged', 'posts_per_page', 'post_type', 'wc_query', 'orderby', 'order', 'fields');
			foreach ($q->query as $queryVarKey => $queryVarValue) {
				if (!in_array($queryVarKey, $exclude)) {
					if (is_string($queryVarValue)) {
						$q->set($queryVarKey, '');
					}
					if (is_array($queryVarValue)) {
						$q->set($queryVarKey, array());
					}
				}
			}
		} else {
			$search = ReqWpf::getVar('s');
			if ( ! is_admin() && ! is_null( $search ) && ! empty( $search ) ) {
				$q->set( 's', $search );
			}
		}

		$metaQuery = $q->get('meta_query');
		$taxQuery = $q->get('tax_query');

		// set preselects
		$mode = 'preselect';
		$preselects = $this->getPreselectedValue();
		$fields = $this->addCustomFieldsQuery($preselects, $mode);
		$metaQuery = $this->addCustomMetaQuery($metaQuery, $preselects, $mode);
		$taxQuery = $this->addCustomTaxQuery($taxQuery, $preselects, $mode);

		$q->set('meta_query', $metaQuery);
		$q->set('tax_query', $this->groupTaxQueryArgs($taxQuery));
		foreach ($fields as $key => $value) {
			$q->set($key, $value);
		}

		// added an additional check, since meta_query can be added by other plugins and, as a result, the request crashed
		if ( empty( $q->get( 'meta_query' ) ) || 'product_query' === $q->get( 'wc_query' ) ) {
			$q->set( 'post_type', 'product' );
		}
		$q->set('wpf_query', 1);
		$this->mainWCQuery = $q->query_vars;

		$this->fields    = array();
		$args = $this->getQueryVars( $this->mainWCQuery );

		if ( $this->mainWCQuery!==$args ) {

			$q->set( 'meta_query', $args['meta_query'] );
			$q->set( 'tax_query', $args['tax_query'] );
			foreach ( $this->fields as $key => $value ) {
				$q->set( $key, $value );
			}
		}

		if (ReqWpf::getVar('wpf_order')) {
			add_filter( 'posts_clauses', array($this, 'addClausesTitleOrder'));
		}
		if (FrameWpf::_()->proVersionCompare('1.4.8')) {
			$filterSettings = array();
			$params = array();
			if (ReqWpf::getVar('wpf_fbv')) {
				$filterSettings['filtering_by_variations'] = 1;
				$params = ReqWpf::get('get');
			}
			if ( ReqWpf::getVar( 'wpf_dpv' ) ) {
				$filterSettings['display_product_variations'] = 1;
			}
			$args = array(
				'tax_query'  => $q->get('tax_query'),
				'meta_query' => $q->get('meta_query'),
				'post__in'   => $q->get('post__in'),
			);
			$args = $this->addBeforeFiltersFrontendArgs($args, $filterSettings, $params);
			$q->set('post__in', $args['post__in']);
			$q->set('tax_query', $args['tax_query']);
		}
		
		$q = DispatcherWpf::applyFilters('loadProductsFilterPro', $q);
		if ( $this->mainWCQuery !== $q->query_vars ) {
			$this->mainWCQueryFiltered = $q->query_vars;
		}
		// removes hooks that could potentially override filter settings
		remove_all_filters('wpv_action_apply_archive_query_settings');

		// allow show subcategories only if nothing is selected
		$params = ReqWpf::get( 'get' );
		if ( ! empty( $params ) ) {
			$unsetParam = array( 'wpf_count', 'wpf_fbv', 'wpf_dpv', 'wpf_skip', '_' );
			foreach ( $params as $param=>$value ) {
				if ( in_array( $param, $unsetParam, true ) ) {
					unset( $params[ $param ] );
				}
			}
			if ( ! empty( $params ) ) {
				remove_filter( 'woocommerce_product_loop_start', 'woocommerce_maybe_show_product_subcategories' );
			}
		}
	}


	public function getQueryVars( $args, $exludeParam = array() ) {
		// set url params
		$mode   = 'url';
		$params = ReqWpf::get( 'get' );

		if ( ! empty( $exludeParam ) && isset( $params[ $exludeParam ] ) ) {
			unset( $params[ $exludeParam ] );
		}

		if ( count( $params ) === 0 ) {
			$mode   = 'default';
			$params = DispatcherWpf::applyFilters( 'getDefaultFilterParams', $params );
		}
		
		if ( ! isset( $args['tax_query'] ) ) {
			$args['tax_query'] = array();
		}

		if ( ! isset( $args['meta_query'] ) ) {
			$args['meta_query'] = array();
		}

		if ( count( $params ) > 0 ) {
			$taxQuery     = $this->addCustomTaxQuery( $args['tax_query'], $params, $mode );
			$params       = array_merge( $this->preselects, $params );
			$this->fields = $this->addCustomFieldsQuery( $params, $mode );
			$metaQuery    = $this->addCustomMetaQuery( $args['meta_query'], $params, $mode );
			
			$args['meta_query'] = $metaQuery;
			$args['tax_query']  = $this->groupTaxQueryArgs( $taxQuery );
			foreach ( $this->fields as $key => $value ) {
				$args[ $key ] = $value;
			}
			if ( empty( $args['post_type'] ) ) {
				$args['post_type'] = 'product';
			}
		}

		return $args;
	}
	
	public function loadProductsFilterForProductGrid( $q ) {
		if ( 'product' == $q->get( 'post_type' ) ) {
			global $paged;
			remove_filter( 'pre_get_posts', array( $this, 'loadProductsFilterForProductGrid' ), 999 );
			if ( '' !== $this->mainWCQueryFiltered ) {
				$q->query_vars = $this->mainWCQueryFiltered;
			} else {
				$this->loadProductsFilter( $q );
			}
			if ( $paged && $paged > 1 ) {
				$q->set( 'paginate', true );
				$q->set( 'paged', $paged );
			}
		}
	}

	public function loadShortcodeProductsFilter( $args, $attributes, $type ) {
		$hash      = md5( serialize( $args ) . serialize( $attributes ) );
		$filterKey = ( empty( $attributes['class'] ) ) ? ( ( empty( self::$currentElementorClass ) ) ? '-' : self::$currentElementorClass ) : $attributes['class'];

		if ( ! key_exists( $hash, self::$loadShortcode ) || 'products' !== $type ) {
			$filterId = null;
			if ( '-' !== $filterKey ) {
				preg_match( '/wpf-filter-(\d+)/', $filterKey, $matches );
				if ( isset( $matches[1] ) ) {
					$filterId = $matches[1];
					$filterKey = "wpf-filter-{$filterId}";
				} else {
					$filterKey = '-';
				}
			}
			$isClassFilterId = ! is_null( $filterId );
			if ($isClassFilterId) {
				$this->setCurrentFilter($filterId, false);
			}

			$this->addPreselectedParams();

			$metaQuery = isset( $args['meta_query'] ) ? $args['meta_query'] : array();
			$taxQuery  = isset( $args['tax_query'] ) ? $args['tax_query'] : array();

			// set preselects
			$mode       = 'preselect';
			$preselects = $this->getPreselectedValue();

			if ( ! isset( $preselects['pr_onsale'] ) && isset( $attributes['on_sale'] ) && 'true' === $attributes['on_sale'] ) {
				$preselects['pr_onsale'] = 1;
			}
			$fields     = $this->addCustomFieldsQuery( $preselects, $mode );
			$metaQuery  = $this->addCustomMetaQuery( $metaQuery, $preselects, $mode );
			$taxQuery   = $this->addCustomTaxQuery( $taxQuery, $preselects, $mode );

			$args['meta_query'] = $metaQuery;
			$args['tax_query']  = $this->groupTaxQueryArgs( $taxQuery );
			foreach ( $fields as $key => $value ) {
				$args[ $key ] = $value;
			}
			if ( empty( $args['post_type'] ) ) {
				$args['post_type'] = 'product';
			}
			
			$args['wpf_query'] = 1;

			$this->shortcodeWCQuery[ $filterKey ] = $args;

			$params = ReqWpf::get( 'get' );
			if ( ! $isClassFilterId || ( isset( $params['wpf_id'] ) && $filterId === $params['wpf_id'] ) ) {
				$args = $this->getQueryVars( $args );

				if ( ReqWpf::getVar( 'wpf_order' ) ) {
					$args['order']   = $this->getWpfOrderParam( ReqWpf::getVar( 'wpf_order' ) );
					$args['orderby'] = 'title';
				}
				$filterSettings = array();
				if ( ReqWpf::getVar( 'wpf_fbv' ) ) {
					$filterSettings['filtering_by_variations'] = 1;
				}
				if ( ReqWpf::getVar( 'wpf_dpv' ) ) {
					$filterSettings['display_product_variations'] = 1;
				}
				if ( FrameWpf::_()->proVersionCompare( '1.4.8' ) ) {
					$args = $this->addBeforeFiltersFrontendArgs( $args, $filterSettings, $params );
				} else {
					$args = DispatcherWpf::applyFilters( 'checkBeforeFiltersFrontendArgs', $args, $filterSettings, $params );
				}
				if ( $this->shortcodeWCQuery[ $filterKey ] !== $args ) {
					$this->shortcodeWCQueryFiltered[ $filterKey ] = $args;
				}
			}
			$args = DispatcherWpf::applyFilters('loadShortcodeProductsFilterPro', $args);
			self::$loadShortcode[ $hash ] = $args;
		} else {
			$args = self::$loadShortcode[ $hash ];
		}
		return $args;

	}

	public function addBeforeFiltersFrontendArgs( $args, $filterSettings = array(), $urlQuery = array() ) {
		if (!empty($args)) {
			global $wpdb;
			$args['post_type'] = array( 'product' );
			$settingsFilteringByVariations = ! empty( $filterSettings ) && isset( $filterSettings['filtering_by_variations'] ) ? $filterSettings['filtering_by_variations'] : false;

			if ( $settingsFilteringByVariations && ! isset( $args['variations'] ) ) {
				$join = '';
				$where = '';
				$having = '';
				$whereNot = '';
				$i = 0;
				$categories = array();
				$whAnd = ' AND ';
				$modelMetaValues = FrameWpf::_()->getModule('meta')->getModel('meta_values');
				if ( isset( $args['tax_query'] ) && ! empty( $args['tax_query'] ) ) {
					$metaDataTable = DbWpf::getTableName('meta_data');
					$metaDataValues = DbWpf::getTableName('meta_values');
					foreach ( $args['tax_query'] as $keyTax => &$tax_query ) {
						if ( ! is_array( $tax_query ) ) {
							continue;
						}
						$logic = isset( $tax_query['relation'] ) ? $tax_query['relation'] : 'OR';

						if ( isset( $tax_query['taxonomy'] ) ) {
							$tax_query = array( $tax_query );
						}

						$countTerm = 0;
						$deleteTerm = 0;
						$whAnd = ( 'AND' === $logic ? ' AND ' : ' OR ' );
						foreach ( $tax_query as $k => $tax_item ) {

							if ( ! is_array( $tax_item ) || empty( $tax_item['taxonomy'] ) ) {
								continue;
							}

							$countTerm ++;

							$taxonomy = $tax_item['taxonomy'];
							/*if ('product_cat' == $taxonomy) {
								$categories[] = $tax_item;
								continue;
							}*/
							$metaKeyId = $this->getMetaKeyId('attribute_' . $taxonomy);

							if ($metaKeyId) {
								$isSlug = ( isset($tax_item['field']) && 'slug' === $tax_item['field'] );
								$values = $isSlug ? $tax_item['terms'] : get_terms($taxonomy, array('include' => $tax_item['terms'], 'taxonomy' => $taxonomy, 'fields' => 'id=>slug'));

								if (!empty($values)) {
									$isAnd = isset( $tax_item['operator'] ) && 'AND' === $tax_item['operator'];
									$isNot = !$isAnd && isset( $tax_item['operator'] ) && 'NOT IN' === $tax_item['operator'];
									$valueIds = $modelMetaValues->getMetaValueIds($metaKeyId, $values);
									if (!empty($valueIds)) {
										$leerId = $modelMetaValues->getMetaValueId($metaKeyId, '');

										$w = '';
										$i++;
										if ($isAnd) {
											$join .= ' LEFT JOIN ' . $metaDataTable . ' md' . $i . ' ON (md' . $i . '.product_id=p.ID AND md' . $i . '.key_id=' . $metaKeyId . ' AND md' . $i . '.val_id=' . $leerId . ')';
											$having .= ( empty($having) ? '' : $whAnd ) . ' (count(DISTINCT md' . $i . '.val_id)>0';

											$i++;
											$join .= ' LEFT JOIN ' . $metaDataTable . ' md' . $i . ' ON (md' . $i . '.product_id=p.ID AND md' . $i . '.key_id=' . $metaKeyId . ' AND md' . $i . '.val_id IN (' . implode(',', $valueIds) . '))';
											$having .= ' OR count(DISTINCT md' . $i . '.val_id)>=' . count($valueIds) . ')';

										} else {
											$valueIds[] = $leerId;
											$join .= ' LEFT JOIN ' . $metaDataTable . ' md' . $i . ' ON (md' . $i . '.product_id=p.ID AND md' . $i . '.key_id=' . $metaKeyId . ')';
											$w .= ( empty($w) ? '' : ' AND ' ) . ' md' . $i . '.val_id' . ( $isNot ? ' NOT' : '' ) . ' IN (' . implode(',', $valueIds) . ')';
										}
									}

									if (!empty($w)) {
										$where .= ( empty($where) ? '' : $whAnd ) . '(' . $w . ')';
									}
									if ($isNot) {
										$termIds = $tax_item['terms'];
										if ($isSlug) {
											$termIds = array();
											$allTerms = get_terms($taxonomy, array('taxonomy' => $taxonomy, 'fields' => 'id=>slug'));
											if (is_array($allTerms)) {
												foreach ($allTerms as $id => $slug) {
													if (in_array($slug, $tax_item['terms'])) {
														$termIds[] = $id;
													}
												}
											}
										} 
										if (!empty($termIds)) {
											$whereNot .= ( empty($whereNot) ? '' : $whAnd ) . $wpdb->posts . '.ID NOT IN (SELECT object_id FROM wp_term_relationships WHERE term_taxonomy_id IN (' . implode(',', $termIds) . '))';
										}
										unset($tax_query[$k]);
									}
								}	
							}
						}							
					}
				}
					
				$clauses = DispatcherWpf::applyFilters('addVariationQueryPro', array('join' => $join, 'where' => $where, 'having' => $having, 'whereNot' => $whereNot, 'i' => $i, 'whAnd' => $whAnd, ), $urlQuery); 
				if (!empty($clauses['join'])) {
					$i = $clauses['i'];
					$metaKeyId = $this->getMetaKeyId('_stock_status');
					if ($metaKeyId) {
						$i++;
						$valueId = $modelMetaValues->getMetaValueId($metaKeyId, 'outofstock');
						$clauses['join'] .= ' INNER JOIN ' . $metaDataTable . ' md' . $i . ' ON (md' . $i . '.product_id=p.ID AND md' . $i . '.key_id=' . $metaKeyId . ' AND md' . $i . '.val_id!=' . $valueId . ')';
					}
					$options = FrameWpf::_()->getModule( 'options' )->getModel( 'options' )->getAll();
					if ( isset($options['hide_without_price']) &&  '1' === $options['hide_without_price']['value'] ) {
						$metaKeyId = $this->getMetaKeyId('_price');
						if ($metaKeyId) {
							$i++;
							$clauses['join'] .= ' INNER JOIN ' . $metaDataTable . ' md' . $i . ' ON (md' . $i . '.product_id=p.ID AND md' . $i . '.key_id=' . $metaKeyId . ' AND md' . $i . '.val_dec>0)';
						}
					}
					/*foreach ( $categories as $k => $tax_item ) {
						$i++;
						$isSlug = ( isset($tax_item['field']) && 'slug' === $tax_item['field'] );
						$clauses['join'] .= ' INNER JOIN ' . $wpdb->posts . ' pp' . $i . ' ON (pp' . $i . '.id=p.post_parent)' .
							' INNER JOIN ' . $wpdb->term_relationships . ' wr' . $i . ' ON (wr' . $i . '.object_id=pp' . $i . '.ID) ';
						if ($isSlug) {
							$clauses['join'] .= ' INNER JOIN ' . $wpdb->terms . ' wt' . $i . ' ON (wt' . $i . '.term_id=wr' . $i . '.term_taxonomy_id) ';
							$clauses['where'] .= ( empty($clauses['where']) ? '' : ' AND ' ) . ' wt' . $i . '.slug IN (' . $tax_item['terms'] . ')';
						} else {
							$clauses['where'] .= ( empty($clauses['where']) ? '' : ' AND ' ) . ' wr' . $i . '.term_taxonomy_id IN (' . $tax_item['terms'] . ')';
						}
					}*/
					$displayVariation = isset( $filterSettings['display_product_variations'] ) ? $filterSettings['display_product_variations'] : false;
					$isGroupBy = $displayVariation || !empty($clauses['having']);

					$query = 'SELECT ' . ( $isGroupBy ? '' : 'DISTINCT' ) . ' p.post_parent as id' . ( $displayVariation ? ', min(p.id) as var_id, count(DISTINCT p.id) as var_cnt' : '' ) .
						' FROM ' . $wpdb->posts . ' AS p' . $clauses['join'] . " WHERE p.post_type='product_variation'";
					if (!empty($clauses['where'])) {
						$query .= ' AND ' . $clauses['where'];
					}
					if ($isGroupBy) {
						$query .= ' GROUP BY p.post_parent';
					}
					if (!empty($clauses['having'])) {
						$query .= ' HAVING ' . $clauses['having'];
					}

					$varTable = $this->createTemporaryTable($this->tempVarTable, $query);
					if (!empty($varTable)) {
						$metaKeyId = $this->getMetaKeyId('_wpf_product_type');
						if ($metaKeyId) {

							$metaValueId = FrameWpf::_()->getModule('meta')->getModel('meta_values')->getMetaValueId($metaKeyId, 'variable');
							if ($metaValueId) {
								$whereNot = empty($clauses['whereNot']) ? '' : ' AND ' . $clauses['whereNot'];
								$clauses = array(
									'join' => array(' LEFT JOIN ' . $varTable . ' as wpf_var_temp ON (wpf_var_temp.id=' . $wpdb->posts . '.ID) LEFT JOIN ' . $metaDataTable . ' as wpf_pr_type__#i ON (wpf_pr_type__#i.product_id=' . $wpdb->posts . '.ID AND wpf_pr_type__#i.key_id=' . $metaKeyId . ')'),
									'where' => array(' AND ((wpf_pr_type__#i.val_id!=' . $metaValueId . $whereNot . ') OR wpf_var_temp.id is not null)')
									);
								$this->addFilterClauses($clauses, false);
							}
						}
					}

				}
			}
		}
		$args = DispatcherWpf::applyFilters( 'checkBeforeFiltersFrontendArgs', $args, $filterSettings, $urlQuery );
		
		return $args;
	}

	public function getWcAttributeTaxonomies() {
		if (is_null($this->wcAttributes)) {
			$allAttributes = wc_get_attribute_taxonomies();
			if (!empty($allAttributes)) {
				$allAttributes = array_column($allAttributes, 'attribute_name');
				$allAttributes = array_map(function ( $attribute ) {
					return 'pa_' . $attribute;
				}, $allAttributes);
			} else {
				$allAttributes = array();
			}
			$this->wcAttributes = $allAttributes;
		}
		return $this->wcAttributes;
	}

	public function getRenderMode( $id, $settings, $isWidget = true ) {
		if (!isset($this->renderModes[$id])) {
			if ( isset( $settings['settings'] ) ) {
				$settings = $settings['settings'];
			}
			$displayOnPageShortcode = $this->getFilterSetting( $settings, 'display_on_page_shortcode', false );
			$displayShop            = ( $displayOnPageShortcode ) ? false : ! $isWidget;
			$displayCategory        = false;
			$displayTag             = false;
			$displayAttribute       = false;
			$displayMobile          = true;
			$displayProduct         = false;
			$displayBrand           = false;

			if (is_admin()) {
				$displayShop = true;
			} else {
				$displayOnPage = empty($settings['display_on_page']) ? 'shop' : $settings['display_on_page'];

				if ('specific' === $displayOnPage) {
					$pageList = empty($settings['display_page_list']) ? '' : $settings['display_page_list'];
					if (is_array($pageList)) {
						$pageList = isset($pageList[0]) ? $pageList[0] : '';
					}
					$pages = explode(',', $pageList);
					$pageId = $this->getView()->wpfGetPageId();
					if (in_array($pageId, $pages)) {
						$displayShop = true;
						$displayCategory = true;
						$displayTag = true;
					}
				} elseif ('custom_cats' === $displayOnPage) {
					$catList = empty($settings['display_cat_list']) ? '' : $settings['display_cat_list'];
					if (is_array($catList)) {
						$catList = isset($catList[0]) ? $catList[0] : '';
					}

					$cats      = explode(',', $catList);

					$displayChildCat = $this->getFilterSetting($settings, 'display_child_cat', false);
					if ($displayChildCat) {
						$catChild = array();
						foreach ($cats as $cat) {
							$catChild = array_merge($catChild, get_term_children( $cat, 'product_cat' ));
						}
						$cats = array_merge($cats, $catChild);
					}

					$parent_id = get_queried_object_id();
					if (in_array($parent_id, $cats)) {
						$displayCategory = true;
					}
				} elseif ( is_shop() || is_product_category() || is_product_tag() || is_customize_preview() ) {
					if ( 'shop' === $displayOnPage || 'both' === $displayOnPage ) {
						$displayShop = true;
					}
					if ( 'category' === $displayOnPage || 'both' === $displayOnPage ) {
						$displayCategory = true;
					}
					if ( 'tag' === $displayOnPage || 'both' === $displayOnPage ) {
						$displayTag = true;
					}
				} elseif ( is_tax() && ( 'both' === $displayOnPage || 'shop' === $displayOnPage ) ) {
					$displayAttribute = true;
				} elseif ('product' === $displayOnPage) {
					$displayProduct = true;
				} elseif ( 'brand' === $displayOnPage ) {
					$displayBrand = true;
				}

				$displayFor = empty($settings['display_for']) ? '' : $settings['display_for'];

				$mobileBreakpointWidth = $this->getView()->getMobileBreakpointValue($settings);
				if ($mobileBreakpointWidth) {
					$displayFor = 'both';
				}
				if ('mobile' === $displayFor) {
					$displayMobile = UtilsWpf::isMobile();
				} else if ('both' === $displayFor) {
					$displayMobile = true;
				} else if ('desktop' === $displayFor) {
					$displayMobile = !UtilsWpf::isMobile();
				}
			}
			$hideWithoutProducts = !empty($settings['hide_without_products']) && $settings['hide_without_products'];
			$displayMode = $this->getDisplayMode();
			$mode = 0;

			if ( !$hideWithoutProducts || 'subcategories' != $displayMode || is_search()) {
				if ( is_product_category() && $displayCategory && $displayMobile ) {
					$mode = 1;
				} else if ( $this->isVendor() && $displayShop && $displayMobile ) {
					$mode = 7;
				} else if ( is_shop() && $displayShop && $displayMobile ) {
					$mode = 2;
				} else if ( is_product_tag() && $displayTag && $displayMobile ) {
					$mode = 3;
				} else if ( is_tax('product_brand') && $displayShop && $displayMobile ) {
					$mode = 4;
				} else if ( is_tax('pwb-brand') && $displayShop && $displayMobile ) {
					$mode = 5;
				} else if ( $displayAttribute && $displayMobile ) {
					$mode = 6;
				} else if ( $displayShop && $displayMobile && !is_product_category() && !is_product_tag() ) {
					$mode = 10;
				} else if ( is_product() && $displayProduct && $displayMobile) {
					$mode = 8;
				} else if (
					FrameWpf::_()->isPro() &&
					( is_tax('pwb-brand') || is_tax('product_brand') ) &&
					$displayBrand &&
					$displayMobile
				) {
					$mode = 11;
				}

			}
			$this->renderModes[$id] = $mode;
		}
		return $this->renderModes[$id];
	}

	private function isVendor() {

		if ($this->isWcVendorsPluginActivated() && WCV_Vendors::is_vendor_page()) {
			return true;
		}

		if ( is_plugin_active( 'dokan-lite/dokan.php' ) && function_exists( 'dokan_is_store_page' ) ) {
			return dokan_is_store_page();
		}

		return false;
	}

	private function wpf_get_loop_prop( $prop ) {
		return isset( $GLOBALS['woocommerce_loop'], $GLOBALS['woocommerce_loop'][ $prop ] ) ? $GLOBALS['woocommerce_loop'][ $prop ] : '';
	}

	public function getDisplayMode() {
		if (is_null($this->displayMode)) {
			$mode = '';
			if ( $this->wpf_get_loop_prop('is_search') || $this->wpf_get_loop_prop('is_filtered') ) {
				$display_type = 'products';
			} else {
				$parent_id    = 0;
				$display_type = '';
				if ( is_shop() ) {
					$display_type = get_option('woocommerce_shop_page_display', '');
				} elseif ( is_product_category() ) {
					$parent_id    = get_queried_object_id();
					$display_type = get_term_meta( $parent_id, 'display_type', true );
					$display_type = '' === $display_type ? get_option('woocommerce_category_archive_display', '') : $display_type;
				}

				if ( ( !is_shop() || 'subcategories' !== $display_type ) && 1 < $this->wpf_get_loop_prop('current_page') ) {
					$display_type = 'products';
				}
			}

			if ( '' === $display_type || ! in_array($display_type, array('products', 'subcategories', 'both'), true) ) {
				$display_type = 'products';
			}

			if ( in_array( $display_type, array('subcategories', 'both'), true) ) {
				$subcategories = woocommerce_get_product_subcategories( $parent_id );

				if (empty($subcategories)) {
					$display_type = 'products';
				}
			}
			$this->displayMode = $display_type;
		}
		return $this->displayMode;
	}

	public function addClausesTitleOrder( $args ) {
		global $wpdb;
		$posId = strpos($args['orderby'], '.product_id');
		if (false !== $posId) {
			$idBegin = strrpos( $args['orderby'], ',', ( strlen($args['orderby']) - $posId ) * ( -1 ) );
			if ($idBegin) {
				$args['orderby'] = substr($args['orderby'], 0, $idBegin);
			}
		} else {
			$posId = strpos($args['orderby'], $wpdb->posts . '.ID');
			if (false !== $posId) {
				$idBegin = strrpos($args['orderby'], ',', ( strlen($args['orderby']) - $posId ) * ( -1 ) );
				if ($idBegin) {
					$args['orderby'] = substr($args['orderby'], 0, $idBegin);
				}
			}
		}

		$order = $this->getWpfOrderParam(ReqWpf::getVar('wpf_order'));
		$orderByTitle = "$wpdb->posts.post_title $order";
		$args['orderby'] = ( empty($args['orderby']) ? $orderByTitle : $orderByTitle . ', ' . $args['orderby'] );
		remove_filter('posts_clauses', array($this, 'addClausesTitleOrder'));
		return $args;
	}

	public function addCustomOrder( $args, $customOrder = 'title' ) {
		if (empty($args['orderby'])) {
			$args['orderby'] = $customOrder;
			$args['order'] = 'ASC';
		} else if ($args['orderby'] != $customOrder) {
			if (is_array($args['orderby'])) {
				reset($args['orderby']);
				$key = key($args['orderby']);
				$args['orderby'] = array($key => $args['orderby'][$key]);
			} else {
				$args['orderby'] = array($args['orderby'] => empty($args['order']) ? 'ASC' : $args['order']);
			}
			$args['orderby'][$customOrder] = 'ASC';
			$args['order'] = '';
		}
		return $args;
	}

	private function getWpfOrderParam( $wpfOrder ) {
		$order = 'ASC';
		if ('titled' == $wpfOrder) {
			$order = 'DESC';
		}

		return $order;
	}

	/**
	 * Group together wp_query taxonomies params args with the same taxonomy name
	 *
	 * @param array $taxQuery
	 *
	 * @return array
	 */
	public function groupTaxQueryArgs( $taxQuery ) {
		if ( empty($taxQuery) || !is_array($taxQuery) ) {
			return $taxQuery;
		}

		$taxGroupedList = array(
			'product_cat',
			'product_tag'
		);

		$attributesTax = array_keys(wp_list_pluck(wc_get_attribute_taxonomies(), 'attribute_label', 'attribute_name'));

		if ($attributesTax) {
			$attributesTax = array_map(
				function( $tax) {
					return 'pa_' . $tax;
				},
				$attributesTax
			);

			$taxGroupedList = array_merge($taxGroupedList, $attributesTax);
		}

		$groupedTaxQueryVal = array();
		$taxQueryFormat = array();
		$uniq = array();
		foreach ($taxQuery as $taxQueryIndex => $taxQueryValue) {
			if (!empty($taxQueryValue['taxonomy']) && in_array($taxQueryValue['taxonomy'], $taxGroupedList)) {
				$group = $taxQueryValue['taxonomy'];
				if ( 'product_cat' != $group && 'product_tag' != $group ) {
					$group = 'product_att';
				}
				$groupedTaxQueryVal[$group][] = $taxQueryValue;
			} else if (!empty($taxQueryValue['wpf_group'])) {
				$group = $taxQueryValue['wpf_group'];
				foreach ($taxQueryValue as $wpfIndex => $wpfValue) {
					if (is_int($wpfIndex)) {
						$groupedTaxQueryVal[$group][] = $wpfValue;
					}
				}
			} else {
				$json = json_encode($taxQueryValue);
				if (!in_array($json, $uniq)) {
					if (is_int($taxQueryIndex)) {
						$taxQueryFormat[] = $taxQueryValue;
					} else {
						$taxQueryFormat[$taxQueryIndex] = $taxQueryValue;
					}
					$uniq[] = $json;
				}
			}
		}
		if ($groupedTaxQueryVal) {
			$logic = ReqWpf::getVar('filter_tax_block_logic');
			$logic = is_null($logic) ? 'AND' : strtoupper($logic);
			foreach ($groupedTaxQueryVal as $group => $values) {
				if (count($values) > 1) {
					$uniq = array();
					$vals = array();
					foreach ($values as $i => $v) {
						$json = json_encode($v);
						if (!in_array($json, $uniq)) {
							$vals[] = $v;
							$uniq[] = $json;
						}
					}
					$values = $vals;
				}
				$values['wpf_group'] = $group;
				$values['relation'] = $logic;
				$taxQueryFormat[] = $values;
			}
		}
		return $taxQueryFormat;
	}

	public function addAdminTab( $tabs ) {
		$tabs[ $this->getCode() . '#wpfadd' ] = array(
			'label' => esc_html__('Add New Filter', 'woo-product-filter'), 'callback' => array($this, 'getTabContent'), 'fa_icon' => 'fa-plus-circle', 'sort_order' => 10, 'add_bread' => $this->getCode(),
		);
		$tabs[ $this->getCode() . '_edit' ] = array(
			'label' => esc_html__('Edit', 'woo-product-filter'), 'callback' => array($this, 'getEditTabContent'), 'sort_order' => 20, 'child_of' => $this->getCode(), 'hidden' => 1, 'add_bread' => $this->getCode(),
		);
		$tabs[ $this->getCode() ] = array(
			'label' => esc_html__('Show All Filters', 'woo-product-filter'), 'callback' => array($this, 'getTabContent'), 'fa_icon' => 'fa-list', 'sort_order' => 20, //'is_main' => true,
		);
		return $tabs;
	}
	public function getCurrencyPrice( $raw_price, $dec = false ) {
		if (function_exists( 'alg_wc_currency_switcher_plugin' )) {
			$price = alg_wc_currency_switcher_plugin()->core->change_price_by_currency($raw_price);
		} else {

			$price = apply_filters( 'raw_woocommerce_price', $raw_price );

			// some plugin uses a different hook, use it if the standard one did not change the price
			if ( $price === $raw_price && ( is_plugin_active( 'woocommerce-currency-switcher/index.php' ) || is_plugin_active( 'woocommerce-multicurrency/woocommerce-multicurrency.php' ) ) ) {
				$price = apply_filters( 'woocommerce_product_get_regular_price', $raw_price, null );
			}
		}

		return ( false === $dec ? $price : round($price, $dec) );
	}
	public function preparePriceFilter( $minPrice = null, $maxPrice = null, $rate = null ) {
		if ( !is_null($minPrice) ) {
			$minPrice = str_replace(',', '.', $minPrice);
			if ( !is_numeric($minPrice) ) {
				$minPrice = null;
			}
		}
		if ( !is_null($maxPrice) ) {
			$maxPrice = str_replace(',', '.', $maxPrice);
			if ( !is_numeric($maxPrice) ) {
				$maxPrice = null;
			}
		}
		
		if ( is_null($minPrice) && is_null($maxPrice) ) {
			return false;
		}
		
		$metaQuery = array('key' => '_price', 'price_filter' => true, 'type' => 'DECIMAL(20,3)');
		list( $minPrice, $maxPrice ) = DispatcherWpf::applyFilters( 'priceTax', array(
			$minPrice,
			$maxPrice
		), 'subtract' );

		if (is_null($rate)) {
			$rate = $this->getCurrentRate();
		}
		
		if (is_null($minPrice)) {
			$metaQuery['compare'] = '<=';
			$metaQuery['value'] = $maxPrice / $rate;
		} elseif (is_null($maxPrice)) {
			$metaQuery['compare'] = '>=';
			$metaQuery['value'] = $minPrice / $rate;
		} else {
			$metaQuery['compare'] = 'BETWEEN';
			$metaQuery['value'] = array($minPrice / $rate, $maxPrice / $rate);
		}
		add_filter('posts_where', array($this, 'controlDecimalType'), 9999, 2);

		return array('price_filter' => $metaQuery);
	}
	public function controlDecimalType( $where ) {
		return preg_replace('/DECIMAL\([\d]*,[\d]*\)\(20,3\)/', 'DECIMAL(20,3)', $where);
	}

	public function getCurrentRate() {
		$price = 1000;
		$newPrice = $this->getCurrencyPrice($price);
		return $newPrice / $price;
	}
	public function addHiddenFilterQuery( $query ) {
		$hidden_term = get_term_by('name', 'exclude-from-catalog', 'product_visibility');
		if ($hidden_term) {
			$query[] = array(
				'taxonomy' => 'product_visibility',
				'field' => 'term_taxonomy_id',
				'terms' => array($hidden_term->term_taxonomy_id),
				'operator' => 'NOT IN'
			);
		}
		return $query;
	}
	public function getTabContent() {
		return $this->getView()->getTabContent();
	}
	public function getEditTabContent() {
		$id = ReqWpf::getVar('id', 'get');
		return $this->getView()->getEditTabContent( $id );
	}
	public function getEditLink( $id, $tableTab = '' ) {
		$link = FrameWpf::_()->getModule('options')->getTabUrl( $this->getCode() . '_edit' );
		$link .= '&id=' . $id;
		if (!empty($tableTab)) {
			$link .= '#' . $tableTab;
		}
		return $link;
	}
	public function render( $params ) {
		return $this->getView()->renderHtml($params);
	}
	public function renderProductsList( $params ) {
		return $this->getView()->renderProductsListHtml($params);
	}
	public function renderSelectedFilters( $params ) {
		return FrameWpf::_()->isPro() ? $this->getView()->renderSelectedFiltersHtml($params) : '';
	}
	public function showAdminErrors() {
		// check WooCommerce is installed and activated
		if (!$this->isWooCommercePluginActivated()) {
			// WooCommerce install url
			$wooCommerceInstallUrl = add_query_arg(
				array(
					's' => 'WooCommerce',
					'tab' => 'search',
					'type' => 'term',
				),
				admin_url( 'plugin-install.php' )
			);
			$tableView = $this->getView();
			$tableView->assign('errorMsg',
				$this->translate('For work with "')	. WPF_WP_PLUGIN_NAME . $this->translate('" plugin, You need to install and activate WooCommerce plugin.')
			);
			// check current module
			if (ReqWpf::getVar('page') == WPF_SHORTCODE) {
				// show message
				HtmlWpf::echoEscapedHtml($tableView->getContent('showAdminNotice'));
			}
		}
	}
	public function isWooCommercePluginActivated() {
		return class_exists('WooCommerce');
	}

	public function WC_pif_product_has_gallery( $classes ) {
		global $product;

		$post_type = get_post_type( get_the_ID() );

		if ( wp_doing_ajax() ) {

			if ( 'product' == $post_type ) {

				if ( is_callable( 'WC_Product::get_gallery_image_ids' ) ) {
					$attachment_ids = $product->get_gallery_image_ids();
				} else {
					$attachment_ids = $product->get_gallery_attachment_ids();
				}

				if ( $attachment_ids ) {
					$classes[] = 'pif-has-gallery';
				}
			}
		}

		return $classes;
	}

	public function YITH_hide_add_to_cart_loop( $link, $product ) {

		if ( wp_doing_ajax() ) {

			if ( get_option( 'ywraq_hide_add_to_cart' ) == 'yes' ) {
				return call_user_func_array(array('YITH_YWRAQ_Frontend', 'hide_add_to_cart_loop'), array($link, $product));
			}
		}

		return $link;
	}

	/**
	 * Add plugin compatibility wp_query filtering results args
	 *
	 * @link https://iconicwp.com/products/woocommerce-show-single-variations
	 *
	 * @param array $args query args
	 *
	 * @return array
	 */
	public function Iconic_Wssv_Query_Args( $args ) {
		$args = Iconic_WSSV_Query::add_variations_to_shortcode_query($args, array());

		return $args;
	}

	public function getAttributeTerms( $slug ) {
		$terms = array();
		if (empty($slug)) {
			return $terms;
		}
		$args = array('hide_empty' => false);
		if (is_numeric($slug)) {
			$values = get_terms(wc_attribute_taxonomy_name_by_id((int) $slug), $args);
		} else {
			$values = DispatcherWpf::applyFilters('getCustomTerms', array(), $slug, $args);
		}

		if ($values) {
			foreach ($values as $value ) {
				if (!empty($value->term_id)) {
					$terms[$value->term_id] = $value->name;
				}
			}
		}

		return $terms;
	}

	public function getFilterTaxonomies( $settings, $calcCategories = false, $filterSettings = array(), $ajax = false ) {
		$taxonomies           = array();
		$forCount             = array();
		$forCountWithChildren = array();
		$other                = array();

		if ( $calcCategories ) {
			$taxonomies[] = 'product_cat';
		}
		$key = 0;
		foreach ( $settings as $filter ) {
			if ( empty( $filter['settings']['f_enable'] ) ) {
				continue;
			}

			$taxonomy = '';
			switch ( $filter['id'] ) {
				case 'wpfCategory':
					$taxonomy = 'product_cat';
					break;
				case 'wpfTags':
					$taxonomy = 'product_tag';
					break;
				case 'wpfAttribute':
					if ( ! empty( $filter['settings']['f_list'] ) ) {
						$slug = $filter['settings']['f_list'];
						$taxonomy = ( is_numeric( $slug ) )
							? wc_attribute_taxonomy_name_by_id( (int) $slug )
							: DispatcherWpf::applyFilters( 'getCustomAttributeName', $slug, $filter );
					}
					break;
				case 'wpfBrand':
					$taxonomy = 'product_brand';
					break;
				case 'wpfPerfectBrand':
					$taxonomy = 'pwb-brand';
					break;
				case 'wpfPrice':
				case 'wpfPriceRange':
					if ( ! $ajax || ( isset( $filterSettings['filter_recount_price'] ) && $filterSettings['filter_recount_price'] ) ) {
						$other[] = $filter['id'];
					}
					break;
				case 'wpfAuthor':
				case 'wpfVendors':
				case 'wpfRating':
					$other[] = $filter['id'];
					break;
				default:
					break;
			}

			if ( ! empty( $taxonomy ) ) {
				$taxonomies[ $key ] = $taxonomy;
				if ( ! empty( $filter['settings']['f_show_count'] ) ) {
					$forCount[] = $taxonomy;
					if ( ! empty( $filter['settings']['f_show_count_parent_with_children'] ) ) {
						$forCountWithChildren[] = $taxonomy;
					}
				}
			}
			$key ++;

		}

		$getNames = ( ! $ajax && $this->getFilterSetting( $filterSettings['settings'], 'check_get_names', 0 ) )
			? $this->checkGetNames( $taxonomies, $other )
			: array();

		return array(
			'names'               => array_unique( $taxonomies ),
			'count'               => array_unique( $forCount ),
			'count_with_children' => array_unique( $forCountWithChildren ),
			'other_names'         => $other,
			'get_names'           => $getNames,
		);
	}

	/**
	 * Forms an array with names from the address bar
	 *
	 * @param $taxonomies
	 *
	 * @return array
	 */
	public function checkGetNames( &$taxonomies, &$other ) {
		$blocks   = array();
		$getNames = array();
		foreach ( $taxonomies as $index => $taxonomy ) {
			switch ( $taxonomy ) {
				case 'product_cat':
					$blocks[ $taxonomy ][] = 'filter_cat.*?_' . $index;
					break;
				case 'product_tag':
					$blocks[ $taxonomy ][] = 'product_tag_' . $index;
					break;
				case 'pwb-brand':
					$blocks[ $taxonomy ][] = 'filter_pwb.*?_' . $index;
					break;
				default:
					if ( strpos( $taxonomy, 'pa_' ) === 0 ) {
						$blocks[ $taxonomy ][] = 'filter_' . substr( $taxonomy, 3 );
					} else {
						$blocks[ $taxonomy ][] = 'filter_' . $taxonomy;
					}
					break;
			}
		}

		foreach ( $other as $index => $taxonomy ) {
			switch ( $taxonomy ) {
				case 'wpfRating':
					$blocks[ $taxonomy ][] = 'pr_rating';
					break;
			}
		}

		if ( ! empty( $blocks ) ) {
			$getGet = ReqWpf::get( 'get' );
			foreach ( $getGet as $param => $value ) {
				foreach ( $blocks as $taxanomy => $patterns ) {
					foreach ( $patterns as $pattern ) {
						preg_match( '/' . $pattern . '/', $param, $matches );
						if ( isset( $matches[0] ) ) {
							$getNames[ $taxanomy ][] = $param;
							$index                   = array_search( $taxanomy, $taxonomies, true );
							if ( is_numeric( $index ) ) {
								unset( $taxonomies[ $index ] );
							} else {
								$index = array_search( $taxanomy, $other, true );
								if ( is_numeric( $index ) ) {
									unset( $other[ $index ] );
								}
							}
						}
					}
				}
			}
		}

		return $getNames;

	}

	public function createTemporaryTable( $table, $sql ) {
		$resultTable = $table;
		if (!DbWpf::query('DROP TEMPORARY TABLE IF EXISTS ' . $table )) {
			return false;
		}
		$sql = str_replace('SQL_CALC_FOUND_ROWS', '', $sql);
		$orderPos = strpos($sql, 'ORDER');
		if ($orderPos) {
			$sql = substr($sql, 0, $orderPos);
		} else {
			$limitPos = strpos($sql, 'LIMIT');
			if ($limitPos) {
				$sql = substr($sql, 0, $limitPos);
			}
		}
		if (DbWpf::query('CREATE TEMPORARY TABLE ' . $table . ' (index my_pkey (id)) AS ' . $sql, true) === false ) {
			$resultTable = '(' . $sql . ')';
		}

		$this->tempTables[$table] = $resultTable;

		return $resultTable;
	}


	/**
	 * Get filter existing individual filters items
	 *
	 * @param int | null $args wp_query args
	 * @param array $taxonomies
	 * @param int | null $calcCategory
	 * @param int | bool $prodCatId
	 * @param array $generalSettings
	 * @param bool $ajax
	 * @param array $currentSettings
	 *
	 * @return mixed
	 */
	public function getFilterExistsItems( $args, $taxonomies, $calcCategory = null, $prodCatId = false, $generalSettings = array(), $ajax = false, $currentSettings = array(), $settings = array() ) {

		if ( empty( $taxonomies['names'] ) && empty( $taxonomies['other_names'] ) && empty( $taxonomies['get_names'] ) ) {
			return false;
		}

		$calc       = array();
		$isGetNames = ! empty( $taxonomies['get_names'] );

		if ( ! empty( $taxonomies['names'] ) || ! empty( $taxonomies['other_names'] ) ) {
			list($args, $argsFiltered) = $this->getArgsWCQuery( $args, $currentSettings );
			if ( $isGetNames ) {
				$calc = array( 'full' => $argsFiltered );
			} else {
				$calc = ( empty( $argsFiltered ) ) ? array( 'full' => $args ) : array( 'full' => $argsFiltered, 'light' => $args );
			}
		}

		if ( ! empty( $taxonomies['get_names'] ) ) {
			foreach ( $taxonomies['get_names'] as $taxonomy => $params ) {
				foreach ( $params as $param ) {
					$argsFiltered   = $this->getQueryVars( $args, $param );
					$calc[ $param ] = array( 'args' => $argsFiltered, 'taxonomy' => $taxonomy );
				}
			}
		}

		$result = array( 'exists' => array() );
		$tempTable = $this->tempFilterTable;

		foreach ( $calc as $mode => $args ) {

			if ( isset( $args['args'] ) ) {
				$taxonomy = [ $args['taxonomy'] ];
				$args     = $args['args'];
			} else {
				$taxonomy = $taxonomies['names'];
			}

			$param = array(
				'ajax'            => $ajax,
				'prodCatId'       => $prodCatId,
				'generalSettings' => $generalSettings,
				'currentSettings' => $currentSettings,
			);
			$args  = $this->addArgs( $args, $param );

			$isCalcCategory = ! is_null( $calcCategory );

			$param = array(
				'isCalcCategory'       => $isCalcCategory,
				'calcCategory'         => $calcCategory,
				'taxonomy'             => $taxonomy,
				'generalSettings'      => $generalSettings,
				'mode'                 => $mode,
				'forCount'             => $taxonomies['count'],
				'forCountWithChildren' => $taxonomies['count_with_children'],
				'withCount'            => ( ! empty( $taxonomies['count'] ) || $isCalcCategory ),
				'isInStockOnly'        => ( get_option( 'woocommerce_hide_out_of_stock_items', 'no' ) === 'yes' ),
				'currentSettings'      => $currentSettings,
				'ajax'                 => $ajax,
			);

			// the search-everything plugin contains an error while adding the arguments
			if ( is_plugin_active( 'search-everything/search-everything.php' ) ) {
				remove_all_filters( 'posts_search' );
			}

			$existTerms = $result['exists'];
			$calcCategories = array();
			$this->isLightMode = 'full' !== $mode;
			$args['orderby'] = 'ID';
			if (!empty($args['meta_key']) && empty($args['meta_value']) && empty($args['meta_value_num'])) {
				$args['meta_key'] = '';
			}

			$filterLoop = new WP_Query( $args );
			$this->isLightMode = false;
			$listTable = '';

			$havePosts = $filterLoop->have_posts();
			if ( $havePosts ) {
				$listTable = $this->createTemporaryTable($tempTable, $filterLoop->request);
				if (!empty($listTable)) {
					list( $existTerms, $calcCategories ) = $this->getTerms( $listTable, $param, $result['exists'] );
				}
			}

			switch ( $mode ) {
				case 'full':
					$result['exists']     = $existTerms;
					$result['categories'] = $calcCategories;
					break;
				case 'light':
					$result['all'] = $existTerms;
					break;
				default:
					if ( ! empty( $existTerms ) ) {
						$result['exists'] = array_merge( $result['exists'], $existTerms );
					}
					break;
			}

			if ( ( 'full' === $mode && ! key_exists( 'light', $calc ) ) || 'light' === $mode ) {
				$param  = array(
					'listTable'		  => $listTable,
					'havePosts'		  => $havePosts,
					'generalSettings' => $generalSettings,
					'taxonomies'      => $taxonomies,
					'ajax'            => $ajax
				);
				$result = array_merge( $result, $this->getExistsMore( $args, $param ) );
			}
		}

		$this->isLightMode = false;

		if ( '1' === ReqWpf::getVar( 'wpf_skip' ) ) {
			$recalculateFilters = $this->getFilterSetting( $settings, 'recalculate_filters', false );
			if ( $recalculateFilters ) {
				$result['existsTermsJS'] = '<div class="wpfExistsTermsJS"><script type="text/javascript">wpfShowHideFiltersAtts(' . wp_json_encode( $result['exists'] ) . ', ' . wp_json_encode( $result['existsUsers'] ) . ');</script><script type="text/javascript">wpfChangeFiltersCount(' . wp_json_encode( $result['exists'] ) . ');</script></div>';
			}
		}

		return $result;
	}

	/**
	 * Returns previously stored arguments in an object
	 *
	 * @param $args
	 *
	 * @return array
	 */
	public function getArgsWCQuery( $args, $currentSettings ) {
		$argsFiltered      = '';
		$postType          = '';
		$doNotUseShortcode = $this->getFilterSetting( $currentSettings, 'do_not_use_shortcut', false );

		if ( is_null( $args ) ) {
			$filterId  = $this->currentFilterId;
			$filterKey = $this->shortcodeFilterKey . $filterId;
			$existSC   = ( count( $this->shortcodeWCQuery ) > 0 );
			if ( ! $doNotUseShortcode && ! isset( $this->shortcodeWCQuery[ $filterKey ] ) ) {
				$filterKey = '-';
			}
			if ( $existSC && isset( $this->shortcodeWCQuery[ $filterKey ] ) ) {
				$args         = $this->shortcodeWCQuery[ $filterKey ];
				$argsFiltered = isset( $this->shortcodeWCQueryFiltered[ $filterKey ] ) ? $this->shortcodeWCQueryFiltered[ $filterKey ] : '';
				$postType     = isset( $args['post_type'] ) ? $args['post_type'] : '';
			}
			if ( 'product' != $postType && ( ! is_array( $postType ) || ! in_array( 'product', $postType ) ) ) {
				$args         = $this->mainWCQuery;
				$argsFiltered = $this->mainWCQueryFiltered;
				$postType     = isset( $args['post_type'] ) ? $args['post_type'] : '';
				if ( 'product' !== $postType && ( ! is_array( $postType ) || ! in_array( 'product', $postType, true ) ) ) {
					if ( $existSC ) {
						$args         = reset( $this->shortcodeWCQuery );
						$argsFiltered = reset( $this->shortcodeWCQueryFiltered );
						$postType     = isset( $args['post_type'] ) ? $args['post_type'] : '';
					}
				}
			}
			if ( 'product' !== $postType && ( ! is_array( $postType ) || ! in_array( 'product', $postType, true ) ) ) {
				$q = new WP_Query( DispatcherWpf::applyFilters( 'beforeFilterExistsTermsWithEmptyArgs', array( 'post_type'  => 'product', 'meta_query' => array(), 'tax_query' => array() ) ) );
				$this->loadProductsFilter( $q );
				$args         = $this->mainWCQuery;
				$argsFiltered = $this->mainWCQueryFiltered;
			}

			if ( $doNotUseShortcode && 'product' !== $postType && ( ! is_array( $postType ) || ! in_array( 'product', $postType, true ) ) ) {
				$filterKey = '-';
				if ( $existSC && isset( $this->shortcodeWCQuery[ $filterKey ] ) ) {
					$args         = $this->shortcodeWCQuery[ $filterKey ];
					$argsFiltered = isset( $this->shortcodeWCQueryFiltered[ $filterKey ] ) ? $this->shortcodeWCQueryFiltered[ $filterKey ] : '';
				}
			}
		}

		return array($args, $argsFiltered);
	}

	/**
	 * Adds arguments to $args array
	 *
	 * @param $args
	 * @param $param
	 *
	 * @return array
	 */
	public function addArgs( $args, $param ) {
		if ( isset( $args['taxonomy'] ) ) {
			unset( $args['taxonomy'], $args['term'] );
		}

		if ( is_null( $args ) || empty( $args ) || 'product' !== $args['post_type'] && ( is_array( $args['post_type'] ) && ! in_array( 'product', $args['post_type'], true ) ) ) {
			$args = array(
				'post_status'         => 'publish',
				'post_type'           => 'product',
				'ignore_sticky_posts' => true,
				'tax_query'           => array(),
			);
		}

		$addEFC = true;
		if (isset($args['tax_query'])) {
			$i = $this->searchValueQuery($args['tax_query'], 'taxonomy', 'product_visibility', false);
			$taxQ = ( is_numeric($i) && isset($args['tax_query'][$i]) ? $args['tax_query'][$i] : false );

			if (!$taxQ && is_array($args['tax_query'])) {
				foreach ($args['tax_query'] as $k => $tax) {
					if (is_array($tax)) {
						$i = $this->searchValueQuery($tax, 'taxonomy', 'product_visibility', false);
						if (is_numeric($i) && isset($tax[$i])) {
							$taxQ = $tax[$i];
							break;
						}
					}
				}
			}	
			if ($taxQ) {
				if (isset($taxQ['operator']) && ( 'NOT IN' == $taxQ['operator'] ) && isset($taxQ['field']) && isset($taxQ['terms'])) {
					$exludeTerm = get_term_by('name', 'exclude-from-catalog', 'product_visibility', ARRAY_A);
					if ($exludeTerm && isset($exludeTerm[$taxQ['field']]) && is_array($taxQ['terms']) && in_array($exludeTerm[$taxQ['field']], $taxQ['terms'])) {
						$addEFC = false;
					}
				}
			}
		}

		if ($addEFC) {
			$args['tax_query'][] = array(
				'taxonomy' => 'product_visibility',
				'field'    => 'name',
				'terms'    => 'exclude-from-catalog',
				'operator' => 'NOT IN',
			);
		}

		if ( $param['prodCatId'] ) {
			$args['tax_query'][] = array(
				'taxonomy' => 'product_cat',
				'field'    => 'term_id',
				'terms'    => $param['prodCatId'],
			);
		}

		/*$args['nopaging']       = true;
		$args['posts_per_page'] = - 1;*/
		$args['nopaging'] = false;
		$args['posts_per_page'] = 1;
		$args['hide_empty']     = 1;
		$args['fields']         = 'ids';

		if ( class_exists( 'Iconic_WSSV_Query' ) ) {
			$args = $this->Iconic_Wssv_Query_Args( $args );
		}

		//Integration with AJAX Search for WooCommerce

		/*
		* Plugin URL: https://wordpress.org/plugins/ajax-search-for-woocommerce/
		* Author: Damian Góra
		*/
		if ( class_exists( 'DGWT_WC_Ajax_Search' ) ) {
			$searchIds = apply_filters( 'dgwt/wcas/search_page/result_post_ids', array() );
			if ( $searchIds && is_array($searchIds) ) {
				$postIds = isset($args['post__in']) ? $args['post__in'] : '';
				if ( is_array($postIds) && !empty($postIds) ) {
					if ( 1 !== count($postIds) || 0 !== $postIds[0] ) {
						$args['post__in'] = array_intersect($postIds, $searchIds);
					}
				} else {
					$args['post__in'] = $searchIds;
				}
				$args['s'] = '';
			}
		}

		if ( ! empty( $args['post__in'] ) && ( 'product' === $args['post_type'] ) ) {
			$args['post_type'] = array( 'product', 'product_variation' );
		}

		$args = $this->addWooOptions($args);

		foreach ( $param['generalSettings'] as $filter ) {
			$settings = ( isset($filter['settings']) ) ? $filter['settings'] : [];
			$hiddens  = array( 'f_hidden_brands', 'f_hidden_categories', 'f_hidden_attributes', 'f_hidden_tags' );
			$replace  = false;
			foreach ( $hiddens as $hidden ) {
				if ( $this->getFilterSetting( $settings, $hidden ) ) {
					$replace = true;
				}
			}
			if ( $replace ) {
				foreach ( $args['tax_query'] as &$tax ) {
					if ( isset ( $tax['wpf_group'] ) && $tax['wpf_group'] === $filter['name'] && isset( $tax[0]['terms'] ) ) {
						$tax[0]['terms'] = $settings['f_mlist[]'];
					}
				}
			}
		}

		return DispatcherWpf::applyFilters( 'addFilterExistsItemsArgs', $args );
	}

	/**
	 * Returns items in filter blocks
	 *
	 * @param $filterLoop
	 * @param $param
	 *
	 * @return array
	 */
	public function getTerms( $listTable, $param, $existTerms ) {
		$calcCategories = array();
		$childs         = array();
		$names          = array();

		$customPrefixes = DispatcherWpf::applyFilters('getCustomPrefixes', array(), false);
		if (empty($customPrefixes)) {
			$taxonomyList = "'" . implode( "','", $param['taxonomy'] ) . "'";
		} else {
			$taxonomyList = '';
			foreach ($param['taxonomy'] as $i => $tax) {		
				$pos = strpos($tax, '-');
				if (!$pos || !in_array( substr($tax, 0, $pos + 1), $customPrefixes )) {
					$taxonomyList .= "'" . $tax . "',";
				}
			}
			$taxonomyList = substr($taxonomyList, 0, -1);
		}
			
		global $wpdb;
		$sql = '';
		if (!empty($taxonomyList)) {
			$sql = 'SELECT ' . ( $param['withCount'] ? '' : 'DISTINCT ' ) . 'tr.term_taxonomy_id, tt.term_id, tt.taxonomy, tt.parent' . ( $param['withCount'] ? ', COUNT(*) as cnt' : '' ) .
				' FROM ' . $listTable . ' AS wpf_temp ' .
				' INNER JOIN ' . $wpdb->term_relationships . ' tr ON (tr.object_id=wpf_temp.ID) ' .
				' INNER JOIN ' . $wpdb->term_taxonomy . ' tt ON (tt.term_taxonomy_id=tr.term_taxonomy_id) ';
			if ($param['withCount'] && $param['isInStockOnly']) {
				$metaKeyId = $this->getMetaKeyId('_stock_status');
				if ($metaKeyId) {
					$valueId = FrameWpf::_()->getModule('meta')->getModel('meta_values')->getMetaValueId($metaKeyId, 'outofstock');
					$sql .= ' INNER JOIN @__meta_data pm ON (pm.product_id=wpf_temp.ID AND pm.key_id=' . $metaKeyId . ' AND pm.val_id!=' . $valueId . ')';
				} else {
					$sql .= ' INNER JOIN ' . $wpdb->postmeta . " pm ON (pm.post_id=wpf_temp.ID) AND pm.meta_key='_stock_status' AND pm.meta_value!='outofstock')";
				}
			}
			$sql .= ' WHERE tt.taxonomy IN (' . $taxonomyList . ')';
			if ( $param['withCount'] ) {
				$sql .= ' GROUP BY tr.term_taxonomy_id';
			}
		}

		if (FrameWpf::_()->proVersionCompare(WPF_PRO_REQUIRES, '>=')) {
			//$termProducts = DbWpf::get( $sql );
			$termProducts = empty($sql) ? array() : DbWpf::get( $sql );
			if (false === $termProducts) {
				$termProducts = array();
			}
			$termProducts = DispatcherWpf::applyFilters( 'addCustomAttributesSql', $termProducts, array(
				'taxonomies'      => $param['taxonomy'],
				'withCount'       => $param['withCount'],
				'listTable'		  => $listTable,
				'generalSettings' => $param['generalSettings'],
				'currentSettings' => $param['currentSettings']
			) );
		} else {
			$sql = DispatcherWpf::applyFilters( 'addCustomAttributesSql', $sql, array(
				'taxonomies'      => $param['taxonomy'],
				'withCount'       => $param['withCount'],
				'productList'     => '(select id from ' . $listTable . ')',
				'generalSettings' => $param['generalSettings'],
				'currentSettings' => $param['currentSettings']
			) );
			$wpdb->wpf_prepared_query = $sql;
			$termProducts = $wpdb->get_results( $wpdb->wpf_prepared_query );
		}

		foreach ( $termProducts as $term ) {
			$taxonomy = $term['taxonomy'];
			$isCat    = 'product_cat' === $taxonomy;
			$name           = urldecode( $taxonomy );
			$names[ $name ] = $taxonomy;
			if ( ! isset( $existTerms[ $name ] ) ) {
				$existTerms[ $name ] = array();
			}

			$termId = $term['term_id'];
			$cnt = $param['withCount'] ? intval( $term['cnt'] ) : 0;
			$existTerms[ $name ][ $termId ] = $cnt;

			$parent = ( isset( $term['parent'] ) ) ? (int) $term['parent'] : 0;
			if ( $isCat && $param['isCalcCategory'] && $param['calcCategory'] === $parent ) {
				$calcCategories[ $termId ] = $cnt;
			}

			if ( 0 !== $parent ) {
				$children = array( $termId );
				do {
					if ( ! isset( $existTerms[ $name ][ $parent ] ) ) {
						$existTerms[ $name ][ $parent ] = 0;
					}
					if ( isset( $childs[ $parent ] ) ) {
						array_merge( $childs[ $parent ], $children );
					} else {
						$childs[ $parent ] = $children;
					}
					$parentTerm = get_term( $parent, $taxonomy );
					$children[] = $parent;
					if ( $parentTerm && isset( $parentTerm->parent ) ) {
						$parent = $parentTerm->parent;
						if ( $isCat && $param['isCalcCategory'] && $param['calcCategory'] === $parent ) {
							$calcCategories[ $parentTerm->term_id ] = 0;
						}
					} else {
						$parent = 0;
					}
				} while ( 0 !== $parent );
			}
		}

		if ( 'full' === $param['mode'] && $param['withCount'] ) {
			foreach ( $existTerms as $taxonomy => $terms ) {
				$allCalc          = in_array( $taxonomy, $param['forCount'], true );
				$calcWithChildren = in_array( $taxonomy, $param['forCountWithChildren'], true );
				if ( ! ( $allCalc || ( $param['isCalcCategory'] && 'product_cat' === $taxonomy ) || $calcWithChildren ) ) {
					continue;
				}
					
				foreach ( $terms as $termId => $cnt ) {
					if ( $calcWithChildren ) {
						$termIds = get_term_children($termId, $names[$taxonomy]);
					} else {
						if ( isset( $childs[ $termId ] ) && ( $allCalc || isset( $calcCategories[ $termId ] ) ) ) {
							$termIds = $childs[ $termId ];
						} else {
							continue;
						}
					}
					$termIds[] = $termId; 

					$sql = 'SELECT count(DISTINCT tr.object_id) FROM ' . $listTable . ' AS wpf_temp ' .
						' INNER JOIN ' . $wpdb->term_relationships . ' tr ON (tr.object_id=wpf_temp.ID) ' .
						' WHERE tr.term_taxonomy_id IN (' . implode(',', $termIds) . ')';
					$cnt = intval( DbWpf::get($sql, 'one') );
					$existTerms[ $taxonomy ][ $termId ] = $cnt;
					if ( isset( $calcCategories[ $termId ] ) ) {
						$calcCategories[ $termId ] = $cnt;
					}
				}
			}
		}
		$existTerms = DispatcherWpf::applyFilters( 'getColorParents', $existTerms, $param['generalSettings'] );

		return array( $existTerms, $calcCategories );
	}

	/**
	 * Returns additional data on minimum and maximum prices and users
	 *
	 * @param $args
	 * @param $param
	 *
	 * @return mixed
	 */
	public function getExistsMore( $args, $param ) {
		global $wpdb;
		$result['existsPrices']              = new stdClass();
		$result['existsPrices']->wpfMinPrice = 1000000000;
		$result['existsPrices']->wpfMaxPrice = 0;
		$result['existsPrices']->decimal     = 0;
		$result['existsPrices']->dataStep    = '1';
		$result['existsUsers']               = array();
		$listTable = $param['listTable'];

		if ( $param['havePosts'] && ! empty ( $param['taxonomies']['other_names'] ) ) {
			foreach ( $param['generalSettings'] as $setting ) {
				if (!isset($setting['id'])) {
					continue;
				}
				if ( in_array( $setting['id'], $param['taxonomies']['other_names'], true ) ) {
					switch ( $setting['id'] ) {
						case 'wpfPrice':
						case 'wpfPriceRange':
							$listTableForPrice = $listTable;
							if ( isset( $args['meta_query'] ) && is_array( $args['meta_query'] ) ) {
								$issetArgsPrice = false;
								foreach ( $args['meta_query'] as $key => $row ) {
									if ( isset( $row['price_filter'] ) ) {
										$issetArgsPrice = true;
										unset ( $args['meta_query'][ $key ] );
									}
								}
								if ( $issetArgsPrice ) {
									$filterLoop = new WP_Query( $args );
									if ( $filterLoop->have_posts() ) {
										$listTableForPrice = $this->createTemporaryTable($this->tempFilterTable . '_price', $filterLoop->request);
									}
								}
							}
							if ( 'wpfPriceRange' === $setting['id'] ) {
								list( $result['existsPrices']->decimal, $result['existsPrices']->dataStep ) = DispatcherWpf::applyFilters( 'getDecimal', array(
									0,
									1
								), $setting['settings'] );
								$price = $this->getView()->wpfGetFilteredPriceFromProductList( $setting['settings'], $listTableForPrice, false, $result['existsPrices']->decimal );
							} else {
								$price = $this->getView()->wpfGetFilteredPriceFromProductList( $setting['settings'], $listTableForPrice, true );
							}
							if ( is_object( $price ) ) {
								$result['existsPrices']->wpfMinPrice = $price->wpfMinPrice;
								$result['existsPrices']->wpfMaxPrice = $price->wpfMaxPrice;
								if ( isset( $price->tax ) ) {
									$result['existsPrices']->tax = $price->tax;
								}
							}
							break;

						case 'wpfAuthor':
						case 'wpfVendors':
							if ( empty( $result['existsUsers'] ) ) {
								$query = 'SELECT DISTINCT ' . $wpdb->users . '.ID' .
								' FROM ' . $listTable . ' AS wpf_temp' .
								' INNER JOIN ' . $wpdb->posts . ' p ON (p.ID=wpf_temp.ID)' .
								' JOIN ' . $wpdb->users . ' ON p.post_author = ' . $wpdb->users . '.ID';

								$result['existsUsers'] = dbWpf::get($query);
							}
							break;

					}
				}
			}
		}

		return $result;
	}

	public function addAjaxFilterForYithWoocompare( $actions ) {
		return array_merge($actions, array('filtersFrontend'));
	}
	public function getAllPages() {
		global $wpdb;
		$allPages = dbWpf::get("SELECT ID, post_title FROM $wpdb->posts WHERE post_type = 'page' AND post_status IN ('publish','draft') ORDER BY post_title");
		$pages = array();
		if (!empty($allPages)) {
			foreach ($allPages as $p) {
				$pages[ $p['ID'] ] = $p['post_title'];
			}
		}
		return $pages;
	}
	
	public function isWcVendorsPluginActivated() {
		return class_exists('WC_Vendors');
	}

	/**
	 * Get logic for filtering.
	 *
	 * @return array
	 */
	public function getAttrFilterLogic( $mode = '' ) {
		$logic = array (
			'display' => array(
				'and' => 'And',
				'or'  => 'Or',
			),
			'loop' => array(
				'and' => 'AND',
				'or'  => 'IN',
			),
			'delimetr' => array(
				'and' => ',',
				'or'  => '|',
			)
		);

		$logic = DispatcherWpf::applyFilters( 'getAttrFilterLogic', $logic );
		return empty($mode) ? $logic : ( isset($logic[$mode]) ? $logic[$mode] : array() );
	}
	
	public function getFilterTagsList() {
		return array( 0 => 'Default', 1 => 'h1', 2 => 'h2', 3 => 'h3', 4 => 'h4', 5 => 'h5' );
	}
	
	public function getCategoriesDisplay() {
		$catArgs = array(
			'orderby' => 'name',
			'order' => 'asc',
			'hide_empty' => false,
		);
		
		$productCategories = get_terms( 'product_cat', $catArgs );
		$categoryDisplay = array();
		$parentCategories = array();
		foreach ($productCategories as $c) {
			if (0 == $c->parent) {
				array_push($parentCategories, $c->term_id);
			}
			$categoryDisplay[$c->term_id] = '[' . $c->term_id . '] ' . $c->name;
		}
		
		return array( $categoryDisplay, $parentCategories );
	}
	
	public function getTagsDisplay() {
		$tagArgs = array(
			'orderby' => 'name',
			'order' => 'asc',
			'hide_empty' => false,
			'parent' => 0
		);
		
		$productTags = get_terms('product_tag', $tagArgs);
		$tagsDisplay = array();
		foreach ($productTags as $t) {
			$tagsDisplay[$t->term_id] = $t->name;
		}
		
		return array( $tagsDisplay );
	}
	
	public function getAttributesDisplay() {
		$productAttr = DispatcherWpf::applyFilters('addCustomAttributes', wc_get_attribute_taxonomies());
		
		$attrDisplay = array(0 => esc_html__('Select...', 'woo-product-filter'));
		$attrTypes = array();
		$attrNames = array();
		foreach ($productAttr as $attr) {
			$attrId = (int) $attr->attribute_id;
			$slug = empty($attrId) ? $attr->attribute_slug : $attrId;
			$attrDisplay[$slug] = $attr->attribute_label;
			$attrTypes[$slug] = isset($attr->custom_type) ? $attr->custom_type : '';
			$attrNames[$slug] = isset($attr->filter_name) ? $attr->filter_name : 'filter_' . $attr->attribute_name;
		}
		
		return array( $attrDisplay, $attrTypes, $attrNames );
	}
	
	public function getRolesDisplay() {
		if (!function_exists('get_editable_roles')) {
			require_once(ABSPATH . '/wp-admin/includes/user.php');
		}
		$rolesMain = get_editable_roles();
		$roles = array();
		
		foreach ($rolesMain as $key => $r) {
			$roles[$key] = $r['name'];
		}
		
		return array( $roles );
	}

	/**
	 * Exlude parent terms from term list
	 *
	 * @param array $termList
	 * @param string $taxonomy
	 *
	 * @return array
	 */
	public function exludeParentTems( $termList, $taxonomy ) {
		foreach ($termList as $key => $termId) {
			$parents = get_ancestors( $termId, $taxonomy, 'taxonomy' );

			if (is_array($parents)) {
				// remove all parent termsId from main parent list
				foreach ($parents as $parentId) {
					if (array_search($parentId, $termList) !== false) {
						$keyParent = array_search($parentId, $termList);
						unset($termList[$keyParent]);
					}
				}
			}
		}

		return $termList;
	}

	/**
	 * Exlude parent terms from term list
	 *
	 * @param array $termList
	 * @param string $taxonomy
	 *
	 * @return array
	 */
	public function exludeChildTems( $termList, $taxonomy ) {
		foreach ($termList as $key => $termId) {
			$children = get_term_children( $termId, $taxonomy );
			if (is_array($children)) {
				// remove all parent termsId from main parent list
				foreach ($children as $childId) {
					if (array_search($childId, $termList) !== false) {
						$keyParent = array_search($childId, $termList);
						unset($termList[$keyParent]);
					}
				}
			}
		}

		return $termList;
	}

	/**
	 * Add shortcode attributes to additional html data attributes
	 *
	 * @param array $attributes
	 */
	public function addWoocommerceShortcodeQuerySettings( $attributes ) {
		$shortcodeAttr = htmlentities(UtilsWpf::jsonEncode($attributes));

		echo '<span class="wpfHidden" data-shortcode-attribute="' . esc_html($shortcodeAttr) . '"></span>';
	}

	public static function getProductsShortcode( $content ) {
		$shortcode_tags = array(
			'products' => 'WC_Shortcodes::products',
			'sale_products' =>'WC_Shortcodes::sale_products',
		);

		if ( false === strpos( $content, '[' ) ) {
			return $content;
		}

		if ( empty( $shortcode_tags ) || ! is_array( $shortcode_tags ) ) {
			return $content;
		}

		preg_match_all( '@\[([^<>&/\[\]\x00-\x20=]++)@', $content, $matches );
		$tagnames = array_intersect( array_keys( $shortcode_tags ), $matches[1] );

		if ( empty( $tagnames ) ) {
			// some themes hide woocommerce shortcodes inside their shortcodes,
			// so there is nothing left to do but let them run for execution
			$theme = wp_get_theme();
			if ( $theme instanceof WP_Theme ) {
				$themeName = ( '' !== $theme['Parent Theme'] ) ? $theme['Parent Theme'] : $theme['Name'];
				if ( 'Divi' === $themeName ) {
					preg_match_all( '@(\[et_pb_shop.*?\/et_pb_shop\])@', $content, $diviShortCodes );
					if ( isset( $diviShortCodes[1] ) ) {
						foreach ( $diviShortCodes[1] as $diviShortCode ) {
							do_shortcode( $diviShortCode );
						}
					}
				}
			}
			return $content;
		}

		$pattern = get_shortcode_regex( $tagnames );
		preg_match_all( "/$pattern/", $content, $matches );
		if ( count( $matches ) > 3 ) {
			foreach ( (array) $matches[3] as $key => $m ) {
				if ( 'sale_products' === $matches[2][ $key ] ) {
					$m .= ' on_sale="true"';
				}
				new WC_Shortcode_Products( shortcode_parse_atts( $m ), 'products' );
			}
		}

		return $content;
	}

	public function queryResults( $result ) {
		if ( 0 === $result->total ) {
			$options = FrameWpf::_()->getModule('options')->getModel('options')->getAll();
			if ( isset( $options['not_found_products_message'] ) && '1' === $options['not_found_products_message']['value'] ) {
				echo '<p class="woocommerce-info">' . esc_html__( 'No products were found matching your selection.', 'woocommerce' ) . '</p>';
			}
		}

		return $result;
	}

	public function getElementorClass( $data ) {
		$rawData = $data->get_raw_data();
		if ( isset( $rawData['settings']['_css_classes'] ) && '' !== $rawData['settings']['_css_classes'] ) {
			self::$currentElementorClass = $rawData['settings']['_css_classes'];
		}
	}

	public function shortcodeAttsProducts( $out, $pairs, $atts ) {
		if ( isset( $atts['on_sale'] ) && ! isset( $out['on_sale'] ) ) {
			$out['on_sale'] = $atts['on_sale'];
		}
		$out['cache'] = false;

		return $out;
	}

	public function addWpfMetaClauses( $params ) {
		if (empty($params['values'] || $params['keyId'])) {
			return;
		}
		global $wpdb;
		$isLight = empty($params['isLight']) ? false : $params['isLight'];
		$isAnd = isset($params['isAnd']) && true === $params['isAnd'];
		$isBetween = isset($params['isAnd']) && 'BETWEEN' === $params['isAnd'];
		$keyId = $params['keyId'];
		
		$field = empty($params['field']) ? 'id' : $params['field'];
		$values = UtilsWpf::controlNumericValues($params['values'], $field);

		$i = 0;
		$clauses = array('join' => array(), 'where' => array());

		foreach ($values as $val) { 
			$i++;
			$clauses['join'][$i] = ' INNER JOIN ' . DbWpf::getTableName('meta_data') . ' AS wpf_meta__#i ON (wpf_meta__#i.product_id=' . $wpdb->posts . '.ID AND wpf_meta__#i.key_id' . ( is_array($keyId) ? ' IN (' . implode(',', $keyId) . ')' : '=' . $keyId ) . ')';
			$clauses['where'][$i] = ' AND wpf_meta__#i.val_' . $field . 
				( $isAnd ? '=' . $val : ( $isBetween ? ' BETWEEN ' . ( empty($values[0]) ? 0 : $values[0] ) . ' AND ' . ( empty($values[1]) ? 0 : $values[1] ) : ' IN (' . implode(',', $values) . ')' ) );
			if (!$isAnd) {
				break;
			}
		}
		$this->addFilterClauses($clauses, $isLight);
		return;
	}
}

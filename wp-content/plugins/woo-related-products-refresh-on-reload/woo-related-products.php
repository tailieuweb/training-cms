<?php
/**
 *
 * @link              https://peachpay.app
 * @since             1.0.0
 * @package           Woo_Related_Products
 *
 * @wordpress-plugin
 * Plugin Name:       Related Products for WooCommerce
 * Plugin URI:        http://woorelated.eboxnet.com
 * Description:       Display random related products in a slider based on product category, tag, or attribute on every product page.
 * Version:           3.3.11
 * Author:            PeachPay
 * Author URI:        https://peachpay.app/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * WC requires at least: 3.0
 * WC tested up to: 5.7
 * Text Domain:       woo-related-products
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-woo-related-products-activator.php
 */

function activate_woo_related_products() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-woo-related-products-activator.php';

	Woo_Related_Products_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-woo-related-products-deactivator.php
 */

function deactivate_woo_related_products() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-woo-related-products-deactivator.php';

	Woo_Related_Products_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_woo_related_products' );
register_deactivation_hook( __FILE__, 'deactivate_woo_related_products' );
/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-woo-related-products.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */

function run_woo_related_products() {
	$plugin = new Woo_Related_Products();
	$plugin->run();
}

function wrprr_admin_page() {   ?>
<div class="wrap">
<h2>Woo Related Products Settings Page</h2>
<form method="post" action="options.php">
	<?php
	settings_fields( 'woorelated-group' );
	?>
	<?php
	do_settings_sections( 'woorelated-group' );
	?>
	<?php
	$numbertodisplay = array(
		'0',
		'2',
		'3',
		'4',
		'6',
		'8',
		'10',
		'12',
		'14',
		'16',
		'18',
		'20',
		'99',
	);
	?>
	<table class="form-table">
		<tr valign="top">
		<th scope="row">Heading Text</th>
		  <td><input type="text" name="woorelated_wtitle" value="
		  <?php
			echo esc_attr( get_option( 'woorelated_wtitle' ) );
			?>
	" placeholder="Related Products" /></td>
		</tr>

		<tr valign="top">
		<th scope="row">Products to display</th>
		  <td>
			<select name="woorelated_nproducts">
			<?php
			if ( esc_attr( get_option( 'woorelated_nproducts' ) ) != '' ) {
				?>
			<option selected="
				<?php
				echo esc_attr( get_option( 'woorelated_nproducts' ) );
				?>
		">
				<?php
				echo esc_attr( get_option( 'woorelated_nproducts' ) );
				?>
		</option>
					<?php
			}
			?>
			<?php
			foreach ( $numbertodisplay as $numtodi ) {
				?>
			  <option value="
				<?php
				echo $numtodi;
				?>
		">
				<?php
				echo $numtodi;
				?>
		</option>
					<?php
			}
			?>
			</select>
</td>
		</tr>
		<tr valign="top">
		<th scope="row">Related by</th>
		<td>
		<?php
		$basedonarray = array(
			'product_cat' => 'Product Category',
			'product_tag' => 'Product TAG',
			'attribute'   => 'Product Attributes',
		);
		?>
		<select name="woorelated_basedon">
		   <?php
			if ( esc_attr( get_option( 'woorelated_basedon' ) ) != '' ) {
				?>
			<option selected="
				<?php
				echo esc_attr( get_option( 'woorelated_basedon' ) );
				?>
		">
				<?php
				echo esc_attr( get_option( 'woorelated_basedon' ) );
				?>
		</option>
					<?php
			}
			?>
			<?php
			foreach ( $basedonarray as $basedon_value => $basedon_label ) {
				?>
				<option value="
				<?php
				echo $basedon_value;
				?>
		">
				<?php
				echo $basedon_label;
				?>
		</option>
					<?php
			}
			?>
		</select>
		  </td>
		</tr>
		<tr valign="top">
		<th scope="row">Taxonomy IDs to exclude (comma separated)</th>
		  <td><input type="text" name="woorelated_exclude" value="
		  <?php
			echo esc_attr( get_option( 'woorelated_exclude' ) );
			?>
	" placeholder="ie 12,45,32 " /></td>
		</tr>
		<tr valign="top">
		<th scope="row">Slider (owl-carousel)</th>
		<td>
		<?php
		$slider = array(
			'Enabled'  => 'Enabled',
			'Disabled' => 'Disabled',
		);
		?>
		<select name="woorelated_slider">
		<?php
		if ( esc_attr( get_option( 'woorelated_slider' ) ) != '' ) {
			?>
			<option selected="
			<?php
			echo esc_attr( get_option( 'woorelated_slider' ) );
			?>
		">
			<?php
			echo esc_attr( get_option( 'woorelated_slider' ) );
			?>
		</option>
			<?php
		}
		?>
		<?php
		foreach ( $slider as $slider_value => $slider_label ) {
			?>
				<option value="
				<?php
				echo $slider_value;
				?>
		">
			<?php
			echo $slider_label;
			?>
		</option>
				<?php
		}
		?>
		</select>

		</td>
		</tr>
	</table>
	<?php
		submit_button();
	?>
</form>
<h2>If you like Woo Related Products please <a href="https://wordpress.org/plugins/woo-related-products-refresh-on-reload/" target="_blank">click here</a> to rate it.</h2>
</div>
	<?php
}

function wrprrdisplay( $atts ) {
	if ( get_option( 'woorelated_nproducts' ) == 0 ) {
		return false;
	}
	// needs improvement
	// will be removed later as it is used only to make easier the transition from 1.x to 2.x
	$basedonf = esc_attr( get_option( 'woorelated_basedon' ) );
	if ( $basedonf == 'category' ) {
		$basedonf = 'product_cat';
	}
	if ( $basedonf == 'tag' ) {
		$basedonf = 'product_tag';
	}
	if ( $basedonf == 'attribute' ) {
		wrprr_wc_taxonomy( $atts );
	} else {
		wrprr_wp_taxonomy( $basedonf, $atts );
	}
}
function wrprr_wp_taxonomy( $basedonf, $atts ) {
	global $post;
	$started = '';
	$sc      = '';
	$terms   = get_the_terms( $post->ID, $basedonf );
	if ( ! empty( $atts['id'] ) ) {
		$sc    = 'woo-related-shortcode';
		$terms = get_the_terms( $atts['id'], $basedonf );
	} else {
		$sc = '';
	}
	if ( ! empty( $atts['title'] ) ) {
		$no_title = $atts['title'] . '-title';
	} else {
		$no_title = ''; }
	if ( empty( $terms ) ) {
		return false;
	}

	foreach ( $terms as $term ) {
		$product_based_id[] = $term->term_id;
	}
	// exlude ids
	$exclude          = explode( ',', get_option( 'woorelated_exclude' ) );
	$product_based_id = array_diff( $product_based_id, $exclude );

	?>
	<div class="woo-related-products-container <?php echo $sc; ?>">
	<?php
	$h2title = get_option( 'woorelated_wtitle' );
	?>
<h2 class="woorelated-title <?php echo $no_title; ?>">
									<?php
									if ( strlen( $h2title ) === 0 ) {
										_e( 'Related Products', 'woo-related-products' );
									} else {
										echo get_option( 'woorelated_wtitle' );
									}
									?>
	</h2>
	<?php
	$products_number = get_option( 'woorelated_nproducts' );
	if ( ! empty( $atts['number'] ) ) {
		$products_number = $atts['number'];
	}
	if ( $sc != '' ) {
		woocommerce_product_loop_start();
		$started = 'yes';
	}
	if ( esc_attr( get_option( 'woorelated_slider' ) ) != 'Enabled' and $started != 'yes' ) {
		woocommerce_product_loop_start();
		$sc      = '';
		$started = 'yes';
	}
	if ( ! empty( $atts['id'] ) and $started != 'yes' ) {
		woocommerce_product_loop_start();
		$sc = '';
	}
	if ( esc_attr( get_option( 'woorelated_slider' ) ) == 'Enabled' and $sc != 'woo-related-shortcode' ) {
		// needs improvement asap
		// $products_number = -1;
		echo "<ul id='woorelatedproducts' class='products owl-carousel owl-theme $sc'>";
	}
	remove_all_filters( 'posts_orderby' );
	$args = array(
		'post_type'      => 'product',
		'post__not_in'   => array( $post->ID ),
		'tax_query'      => array(
			array(
				'taxonomy' => $basedonf,
				'field'    => 'id',
				'terms'    => $product_based_id,
			),
		),
		'posts_per_page' => $products_number,
		'orderby'        => 'rand',
		'meta_query'     => array(
			array(
				'key'   => '_stock_status',
				'value' => 'instock',
			),
		),
	);
	$loop = new WP_Query( $args );
	while ( $loop->have_posts() ) :
		$loop->the_post();
		if ( function_exists( 'wc_get_template_part' ) ) {
			wc_get_template_part( 'content', 'product' );
		} else {
			woocommerce_get_template_part( 'content', 'product' );
		}
	endwhile;
	if ( esc_attr( get_option( 'woorelated_slider' ) ) != 'Enabled' ) {
		woocommerce_product_loop_end();
	} else {
		echo '</ul>';
		echo '<div class="customNavigation">
		<a class="wprr btn prev">Previous</a> - <a class="wprr btn next">Next</a>
	</div>';
	}
	echo '</div>';

	wp_reset_query();
}

function wrprr_wc_taxonomy() {
	?>
	<div>
	<?php
	$h2title = get_option( 'woorelated_wtitle' );
	?>
<h2>
	<?php
	if ( strlen( $h2title ) === 0 ) {
		_e( 'Related Products', 'woo-related-products' );
	} else {
		echo get_option( 'woorelated_wtitle' );
	}
	?>
	</h2>
	<?php
	$products_number = get_option( 'woorelated_nproducts' );
	if ( esc_attr( get_option( 'woorelated_slider' ) ) != 'Enabled' ) {
		woocommerce_product_loop_start();
	} else {

		// needs improvement asap

		$products_number = - 1;
		echo "<ul id='woorelatedproducts' class='products owl-carousel owl-theme'>";
	}

	remove_all_filters( 'posts_orderby' );
	global $product,$post;
	$term_ids  = array();
	$term_idsa = array();
	$attr      = array();
	$getatt    = $product->get_attributes( $product->get_id() );
	if ( empty( $getatt ) ) {
		return false;
	}
	foreach ( $getatt as $attribute ) {
		$attr[] = $attribute['name'];
	}
	foreach ( $attr as $att ) {
		$current_term = get_the_terms( $product->get_id(), $att );
		if ( $current_term && ! is_wp_error( $current_term ) ) {
			$term_ids = array();
			foreach ( $current_term as $termid ) {
				$term_ids[] = $termid->term_id;
			}
		}

		$term_idsa[] = $term_ids;
	}
	$term_idsa       = call_user_func_array( 'array_merge', $term_idsa );
	$products_number = get_option( 'woorelated_nproducts' );
	$args            = array(
		'post_type'      => 'product',
		'post_status'    => 'publish',
		'post__not_in'   => array( $product->get_id() ),
		'posts_per_page' => -1,
		'tax_query'      => array( wrprrdtaxo( $attr, $term_idsa ) ),
		'posts_per_page' => $products_number,
		'orderby'        => 'rand',
		'meta_query'     => array(
			array(
				'key'   => '_stock_status',
				'value' => 'instock',
			),
		),
	);

	$loop = new WP_Query( $args );
	while ( $loop->have_posts() ) :
		$loop->the_post();
		if ( function_exists( 'wc_get_template_part' ) ) {
			wc_get_template_part( 'content', 'product' );
		} else {
			woocommerce_get_template_part( 'content', 'product' );
		}
	endwhile;
	if ( esc_attr( get_option( 'woorelated_slider' ) ) != 'Enabled' ) {
		woocommerce_product_loop_end();
	} else {
		echo '</ul>';
		echo '<div class="customNavigation">
		<a class="wprr btn prev">Previous</a> - <a class="wprr btn next">Next</a>
		</div>';
	}

	echo '</div>';
	wp_reset_query();
}

// Dynamic taxonomy Query build
function wrprrdtaxo( $attr, $term_idsa ) {
	$tax_query = array( 'relation' => 'OR' );
	foreach ( $attr as $attrk ) {
		$tax_query[] = array(
			'taxonomy'         => $attrk,
			'field'            => 'id',
			'terms'            => $term_idsa,
			'include_children' => false,
		);

	}
	return $tax_query;
}

// Shortcode output
function wrprr_shortcode_display( $atts ) {
	remove_action( 'woocommerce_after_single_product', 'wrprrdisplay' );
	ob_start();
	wrprrdisplay( $atts );
	$output = ob_get_contents();
	ob_end_clean();
	return $output;
}
// Shortcode registration
if ( ! shortcode_exists( 'woo-related' ) ) {
	add_shortcode( 'woo-related', 'wrprr_shortcode_display' );
}

/**
 * @param boolean $active records whether the plugin is active or not.
 * @param false|string $version_override is used to record the version number
 * after a plugin update because `upgrader_process_complete` runs on the
 * previous version of a plugin.
 */
function wrprr_record_analytics( $active, $version_override = false ) {
	$version = get_plugin_data( __FILE__ )['Version'];

	if ( $version_override ) {
		$version = $version_override;
	}

	$body = wp_json_encode( array(
		'site_url' => get_site_url(),
		'site_title' => get_bloginfo( 'name' ),
		'plugin_slug' => 'woo-related-products',
		'plugin_version' => $version,
		'plugin_active' => $active,
		'has_stripe' => wrprr_is_using_stripe_plugin()
	) );

	$args = array(
		'body'        => $body,
		'headers'     => array( 'Content-Type' => 'application/json' ),
		'httpversion' => '2.0',
		'blocking'    => false,
	);

	wp_remote_post(
		'https://itb2aqqh8g.execute-api.us-east-1.amazonaws.com/default/pluginAnalytics',
		$args
	);
}

add_action( 'upgrader_process_complete', 'wrprr_upgrader_process_complete', 10, 2 );

function wrprr_upgrader_process_complete( $upgrader_object, $options ) {
	$woo_related_products_updated = false;

	if ( isset( $options['plugins'] ) && is_array( $options['plugins'] ) ) {
		foreach ( $options['plugins'] as $index => $plugin ) {
			if ( plugin_basename( __FILE__ ) === $plugin ) {
				$woo_related_products_updated = true;
				break;
			}
		}
	}

	if ( ! $woo_related_products_updated ) {
		return;
	}

	wrprr_record_analytics( is_plugin_active( plugin_basename( __FILE__ ) ), wrprr_get_published_version() );
}

function wrprr_get_published_version() {
	$response = wp_remote_get('https://plugins.svn.wordpress.org/woo-related-products-refresh-on-reload/trunk/README.txt');
	$body = wp_remote_retrieve_body( $response );
	$result = array();
	preg_match('/Stable tag: (\d+\.\d+\.\d+)/', $body, $result);
	return $result[1];
}

run_woo_related_products();

add_action( 'woocommerce_after_single_product', 'wrprrdisplay' );
add_filter( 'widget_text', 'do_shortcode' ); // fix for themes without shortcode support on sidebar

function wrprr_peachpay_banner() {
	if ( wrprr_is_peachpay_banner_dismissed() ) {
		return;
	}
	wrprr_render_peachpay_banner();
}
add_action( 'admin_notices', 'wrprr_peachpay_banner' );

function wrprr_is_peachpay_banner_dismissed() {
	return get_user_meta( get_current_user_id(), 'wrprr_peachpay_banner_dismissed' );
}

function wrprr_is_using_stripe_plugin() {
	return is_plugin_active( 'woocommerce-gateway-stripe/woocommerce-gateway-stripe.php' )
		|| is_plugin_active( 'woo-stripe-payment/stripe-payments.php' )
		|| is_plugin_active( 'stripe-payments/accept-stripe-payments.php' )
		|| is_plugin_active( 'payment-gateway-stripe-and-woocommerce-integration/payment-gateway-stripe-and-woocommerce-integration.php' )
		|| is_plugin_active( 'stripe/stripe-checkout.php' );
}

function wrprr_render_peachpay_banner() {
	?>
	<div
		class="notice notice-info"
		style="padding: 0.5rem 2rem 0.5rem 0.5rem; display: flex; justify-content: space-between; align-items: center;"
	>
		<img
			src="<?php echo esc_url( plugins_url( 'admin/images/one-click-checkout.png', __FILE__ ) ); ?>"
			width="150"
			style="display: block;"
		>
		<p>
			Install PeachPay in minutes and let customers check out in seconds. Supercharge your checkout and kiss cart abandonment goodbye with this plugin. Developed by a world-class company officially backed by the WooCommerce team.
		</p>
		<div style="text-align: center">
			<a
				href="https://go.peachpay.app/?from=<?php echo get_site_url() ?>&to=<?php echo get_site_url() . "/wp-admin/plugin-install.php%3Ftab=plugin-information%26plugin=peachpay-for-woocommerce" ?>&id=<?php echo urlencode( wp_get_current_user()->user_email ) ?>&label=related-products-peachpay-banner&nonce=<?php echo time() ?>"
				class="button-primary"
				style="margin-bottom: 0.5rem;"
			>Get PeachPay for free</a>
			<br>
			<a href="?wrprr_peachpay_banner_dismissed">Don't show this again</a>
		</div>
	</div>
	<?php
}

function wrprr_handle_peachpay_banner_dismissed() {
	if ( isset( $_GET['wrprr_peachpay_banner_dismissed'] ) ) {
		add_user_meta( get_current_user_id(), 'wrprr_peachpay_banner_dismissed', 'true', true );
	}
}
add_action( 'admin_init', 'wrprr_handle_peachpay_banner_dismissed' );

<?php
/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    MWB_Product_Filter_For_Woocommerce
 * @subpackage MWB_Product_Filter_For_Woocommerce/public/partials
 */

$mwb_custom_filter_array = get_option( 'mwb_pff_custom_filters' );
$val = wc_get_page_permalink( 'shop' );
if ( '2' === get_option( 'mwb_pf_select_reset_button_pos' ) ) {
	?>
	<!-- This file should primarily consist of HTML with a little bit of PHP. -->
	<div class="pf-complete">
		<a href="<?php echo esc_html( $val ); ?>"><button type="submit" class="pf-reset_button"><?php esc_html_e( 'Reset Filters', 'mwb-product-filter-for-woocommerce' ); ?></button></a>
		<ul class="mwb_pf_separate_filter">

		</ul>
	</div>
<?php } ?>
<div class="pf-title_wrapper">
	<h3 class="pf-title">
		<?php esc_html_e( 'Product Filter', 'mwb-product-filter-for-woocommerce' ); ?>
	</h3>
	<img class="pf-main_icon" src="<?php echo esc_html( PRODUCT_FILTER_FOR_WOOCOMMERCE_DIR_URL . 'public/src/filter.svg' ); ?>" alt="product filter icon">
</div>
<div class="pf-complete mwb_pf_wrapper">
	<div class="wrapper">
		<div class="pf-cut"><span class="pf-cross">&#10005;</span></div>
	</div>
</div>
<div class="mwb_custom_meta_filter">
<div class="mwb-accordian">
		<?php
		if ( is_array( $mwb_custom_filter_array ) ) {
			foreach ( $mwb_custom_filter_array as $key => $value ) {
				if ( 'Dropdown' !== $value['type'] ) {
					?>
		<ul class="mwb-accordian__outer">
			<li class="mwb-accordian__inner">
				<label class="mwb-accordian__inner--label" for="mwb-accordian__inner"><?php echo esc_html( $value['title'] ); ?><span>+</span></label>
				<div class="mwb-accordian__inner--content">
				<div class="mwb-accordian__item ">
					<?php
					$mwb_meta_values = explode( ',', $value['meta_val'] );
					foreach ( $mwb_meta_values as $keys => $values ) {
						?>
					<a href="?mwb_filter_key=<?php echo esc_attr( $value['meta_key'] ) . '&mwb_filter_val=' . esc_attr( $values ) . '&mwb_filter_relation=' . esc_attr( $value['query'] ); ?>"><?php echo esc_html( $values ); ?></a>
						<?php
					}
					?>
				</div>
				</div>
			</li>
		</ul>
					<?php
				} elseif ( 'Dropdown' === $value['type'] ) {
					?>
				<ul class="mwb-accordian__outer">
					<li class="mwb-accordian__inner">
						<label class="mwb-accordian__inner--label" for="mwb-accordian__inner"><?php echo esc_html( $value['title'] ); ?><span>+</span></label>
						<div class="mwb-accordian__inner--content">
						<div>
						<select name="forma" onchange="location = this.value;">
						<?php
						$mwb_meta_values = explode( ',', $value['meta_val'] );
						foreach ( $mwb_meta_values as $keys => $values ) {
							?>
							<option value="?mwb_filter_key=<?php echo esc_attr( $value['meta_key'] ) . '&mwb_filter_val=' . esc_attr( $values ) . '&mwb_filter_relation=' . esc_attr( $value['query'] ); ?>"><?php echo esc_html( $values ); ?></option>
							<?php
						}
						?>
						</select>
						</div>
						</div>
					</li>
				</ul>
					<?php
				}
			}
		}
		?>
	</div>
</div>
<?php
if ( '3' === get_option( 'mwb_pf_select_reset_button_pos' ) ) {
	?>
	<!-- This file should primarily consist of HTML with a little bit of PHP. -->
	<div class="pf-complete">
	<ul class="mwb_pf_separate_filter">

		</ul>
		<a href="<?php echo esc_html( $val ); ?>"><button type="submit" class="pf-reset_button"><?php esc_html_e( 'Reset Filters', 'mwb-product-filter-for-woocommerce' ); ?></button></a>
	</div>
	<?php
}

?>

<div class="pf-complete-mobile mwb_pf_wrapper-mobile">
	<div class="wrapper-mobile">
		<div class="pf-cut"><span class="pf-cross">&#10005;</span></div>
	<p class="mwb_pf_procat"><?php esc_html_e( 'Product Category', 'mwb-product-filter-for-woocommerce' ); ?></p>
	<div class="mwb_pf_category_links">

	<?php
	$taxonomies = get_terms(
		array(
			'taxonomy' => 'product_cat',
			'hide_empty' => false,
		)
	);
	foreach ( $taxonomies as $key => $value ) {
		?>

		<a href="<?php echo esc_attr( get_term_link( $value->term_id, 'product_cat' ) ); ?>" class="mwb-icon-link"><span><?php echo esc_attr( $value->name ); ?></span><span>&#10095;</span></a>


		<?php
	}
	?>

	</div>

	<p class="mwb_pf_procat"><?php esc_html_e( 'Product Tags', 'mwb-product-filter-for-woocommerce' ); ?></p>
	<div class="mwb-sm__content">

	<?php
	$taxonomies = get_terms(
		array(
			'taxonomy'   => 'product_tag',
			'hide_empty' => false,
		)
	);
	foreach ( $taxonomies as $key => $value ) {
		?>
		<p><a href="<?php echo esc_attr( get_term_link( $value->term_id, 'product_tag' ) ); ?>"><?php echo esc_attr( $value->name ); ?> </a></p>
		<?php
	}
	?>
		<div class="mwb-sm__btn--wrap">
			<span class="mwb-sm__btn">See more...</span><span>&#10095;</span>
		</div>
	</div>

<?php
		$classes = get_option( 'pffw_classes_names' );
		$filter_value = empty( get_option( 'filter_data' ) ) ? '' : get_option( 'filter_data' );
if ( ! empty( $filter_value ) ) {
	$attribute_term = array();
	$attr_term = array();
	foreach ( $filter_value as $key => $value ) {
		if ( 'price_slider' === $value['attribute'] || 'rating' === $value['attribute'] ) {
			continue;
		}
		$attribute_term[ $key ] = get_terms( wc_attribute_taxonomy_name( $value['attribute'] ), 'orderby=name&hide_empty=0' );
		$taxonomy_terms[ $value['attribute'] ] = $attribute_term[ $key ];

		if ( ! in_array( $value['attribute'], $attr_term, true ) ) {
			$attr_term[ $value['attribute'] ] = get_terms( wc_attribute_taxonomy_name( $value['attribute'] ), 'orderby=name&hide_empty=0' );
			$taxonomy_terms[ $value['attribute'] ] = $attr_term[ $value['attribute'] ];
		}
	}
}
?>

<form id="mwb_pf_mob_view_form" action="" method="get">

	<div class="mwb-accordian">
		<ul class="mwb-accordian__outer">
			<li class="mwb-accordian__inner">
				<label class="mwb-accordian__inner--label" for="mwb-accordian__inner"><?php esc_html_e( 'Price filter', 'mwb-product-filter-for-woocommerce' ); ?> <span>+</span></label>
				<div class="mwb-accordian__inner--content">
				<div id="mwb-range-slider-mobile" class="mwb-rs"></div>
				<div class="mwb-rs__content">
					<label for="mwb-range-slider-mobile">Price range:</label>
					<input type="hidden" id="mwb_pf_min_price" name="min_price" value="">
					<input type="hidden" id="mwb_pf_max_price" name="max_price" value="">
					<input type="text" id="mwb-range-slider__input-mobile" readonly style="border:0; color:#f6931f; font-weight:bold;">
				<div>
				</div>
			</li>

			<?php
			foreach ( $taxonomy_terms as $key => $value ) {
				?>
			<li class="mwb-accordian__inner">
				<label class="mwb-accordian__inner--label" for="mwb-accordian__inner"><?php echo esc_html( $key ); ?><span>+</span></label>
				<div class="mwb-accordian__inner--content">
				<?php
				foreach ( $value as $mwb_key => $mwb_value ) {
					?>
					<div class="mwb-pfw__input-label--wrap">
						<input type="checkbox" name="<?php echo esc_attr( str_replace( 'pa_', 'filter_', $mwb_value->taxonomy ) ); ?>" value="<?php echo esc_attr( $mwb_value->name ); ?>"><label for="<?php echo esc_attr( $mwb_value->taxonomy ); ?>"><?php echo esc_html( $mwb_value->name ); ?></label>
					</div>
					<?php
				}
				?>
				</div>
			</li>
				<?php
			}
			?>
		</ul>
	</div>

<input type="submit">

</form>
	</div>
</div>

<?php

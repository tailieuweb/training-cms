<?php 
$str = esc_attr__('Show when user tries to exit from your site.', 'woo-product-filter') . '<a target="_blank" href="https://woobewoo.com/exit-popup/?utm_source=plugin&utm_medium=onexit&utm_campaign=popup">' . esc_attr__('Check example', 'woo-product-filter') . '.</a>'; 
?>

<label class="woobewoo-tooltip-right" title="<?php echo esc_attr($str); ?>">
	<a target="_blank" href="<?php echo esc_url($this->promoLink); ?>" class="sup-promolink-input">
		<?php 
			HtmlWpf::radiobutton('promo_show_on_opt', array(
				'value' => 'on_exit_promo',
				'checked' => false,
			));
			?>
		<?php esc_html_e('On Exit from Site', 'woo-product-filter'); ?>
	</a>
	<a target="_blank" href="<?php echo esc_url($this->promoLink); ?>"><?php esc_html_e('Available in PRO'); ?></a>
</label>

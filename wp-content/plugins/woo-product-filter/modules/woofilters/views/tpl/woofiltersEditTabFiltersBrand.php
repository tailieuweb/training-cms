<?php
if ($isPro) {
	DispatcherWpf::doAction('addEditTabFilters', 'partEditTabFiltersBrand');
} else { 
	?>
	<div class="row-settings-block col-md-12">
		<a href="https://woobewoo.com/plugins/woocommerce-filter/" target="_blank">
			<img class="wpfProAd" src="<?php echo esc_url($adPath . 'product_brands.png'); ?>">
		</a>
	</div>
<?php } ?>

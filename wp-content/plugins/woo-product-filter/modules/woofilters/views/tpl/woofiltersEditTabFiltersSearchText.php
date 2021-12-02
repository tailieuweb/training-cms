<?php
if ($isPro) {
	DispatcherWpf::doAction('addEditTabFilters', 'partEditTabFiltersSearchText');
} else {
	?>
	<div class="row-settings-block col-md-12">
		<a href="https://woobewoo.com/plugins/woocommerce-filter/" target="_blank">
			<img class="wpfProAd" src="<?php echo esc_url($adPath . 'search_text.png'); ?>">
		</a>
	</div>
<?php } ?>

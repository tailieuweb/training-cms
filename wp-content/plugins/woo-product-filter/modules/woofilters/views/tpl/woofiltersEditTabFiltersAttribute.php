<div class="row-settings-block">
	<div class="settings-block-label settings-w100 col-xs-4 col-sm-3">
		<?php esc_html_e('Select attribute', 'woo-product-filter'); ?>
		<i class="fa fa-question woobewoo-tooltip no-tooltip" title="<?php echo esc_attr(__('Select attribute to be displayed on site from the list.', 'woo-product-filter') . ' <a href="https://woobewoo.com/documentation/attribute-filter-settings/" target="_blank">' . __('Learn More', 'woo-product-filter') . '</a>.'); ?>"></i>
	</div>
	<div class="settings-block-values settings-w100 col-xs-8 col-sm-9">
		<div class="settings-value settings-w100">
			<?php
			$attrDisplay['custom_meta_field_check'] = 'Custom meta field' . $labelPro;
			//$attrDisplay['custom_local_attribute_check'] = 'Custom product attribute' . $labelPro;
			HtmlWpf::selectbox( 'f_list', array(
				'options' => $attrDisplay,
				'attrs'   => 'class="woobewoo-flat-input"'
			) );
			?>
		</div>
		<?php
		if ( $isPro ) {
			DispatcherWpf::doAction( 'addEditTabFilters', 'partEditTabFiltersCustomMetaField' );
		}
		?>
	</div>
</div>
<?php
ViewWpf::display('woofiltersEditTabCommonTitle');

$attributesTypes = array(
	'list' => esc_attr__( 'Checkbox list (multiple select)', 'woo-product-filter' ),
	'radio' => esc_attr__( 'Radiobuttons list (single select)', 'woo-product-filter' ),
	'dropdown' => esc_attr__( 'Dropdown', 'woo-product-filter' ),
	'mul_dropdown' => esc_attr__( 'Multiple Dropdown', 'woo-product-filter' ),
	'colors' => esc_attr__(  'Colors', 'woo-product-filter' ) . $labelPro,
	'buttons' => esc_attr__( 'Buttons', 'woo-product-filter' ) . $labelPro,
	'text' => esc_attr__( 'Text', 'woo-product-filter' ) . $labelPro,
	'switch' => esc_attr__( 'Switch', 'woo-product-filter' ) . $labelPro,
	'slider' => esc_attr__( 'Slider', 'woo-product-filter' ) . $labelPro,
);
?>
<div class="row-settings-block">
	<div class="settings-block-label settings-w100 col-xs-4 col-sm-3">
		<?php esc_html_e('Show on frontend as', 'woo-product-filter'); ?>
		<i class="fa fa-question woobewoo-tooltip no-tooltip" title="<?php echo esc_attr(__('Depending on whether you need one or several attributes to be available at the same time, show attributes list as checkbox or dropdown. <strong>Attention!</strong> Slider type work only with numeric titles of attributes.', 'woo-product-filter') . ' <a href="https://woobewoo.com/documentation/attribute-filter-settings/" target="_blank">' . __('Learn More', 'woo-product-filter') . '</a>.'); ?>"></i>
	</div>
	<div class="settings-block-values settings-w100 col-xs-8 col-sm-9">
		<div class="settings-value settings-w100">
			<?php 
				HtmlWpf::selectbox('f_frontend_type', array(
					'options' => $attributesTypes,
					'attrs' => 'class="woobewoo-flat-input' . ( $isPro ? '' : ' wpfWithProAd' ) . '"'
				));
				?>
		</div>
	</div>
</div>
<?php
if ($isPro) {
	DispatcherWpf::doAction( 'addEditTabFilters', 'partEditTabFiltersMultiSelect' );
	DispatcherWpf::doAction('addEditTabFilters', 'partEditTabFiltersAttributeColors');
} else {
	foreach ($attributesTypes as $key => $value) {
		if (strpos($value, $labelPro) && 'colors' === $key) {
			?>
			<div class="row-settings-block col-md-12 wpfFilterTypePro wpfHidden" data-type="<?php echo esc_attr($key); ?>">
				<a href="https://woobewoo.com/plugins/woocommerce-filter/" target="_blank">
					<img class="wpfProAd" src="<?php echo esc_url($adPath . 'attributes_' . $key . '.png'); ?>">
				</a>
			</div>
<?php }}} ?>
<?php
if ($isPro) {
	DispatcherWpf::doAction('addEditTabFilters', 'partEditTabFiltersAttributeSlider');
} else {
	?>
	<div class="row-settings-block col-md-12 wpfFilterTypePro wpfHidden" data-type="slider">
		<a href="https://woobewoo.com/plugins/woocommerce-filter/" target="_blank">
			<img class="wpfProAd" src="<?php echo esc_url($adPath . 'attributes_slider.png'); ?>">
		</a>
	</div>
<?php } ?>
<?php
ViewWpf::display('woofiltersEditTabCustomTags');
?>
<div class="row-settings-block wpfTypeSwitchable" data-type="dropdown mul_dropdown">
	<div class="settings-block-label settings-w100 col-xs-4 col-sm-3">
		<?php esc_html_e('Dropdown label', 'woo-product-filter'); ?>
		<i class="fa fa-question woobewoo-tooltip no-tooltip" title="<?php echo esc_attr__('Dropdown first option text.', 'woo-product-filter'); ?>"></i>
	</div>
	<div class="settings-block-values settings-w100 col-xs-8 col-sm-9">
		<div class="settings-value settings-w100">
			<?php HtmlWpf::text('f_dropdown_first_option_text', array('placeholder' => esc_attr__('Select all', 'woo-product-filter'), 'attrs' => 'class="woobewoo-flat-input"')); ?>
		</div>
	</div>
</div>
<div class="row-settings-block wpfTypeSwitchable" data-type="mul_dropdown">
	<div class="settings-block-label settings-w100 col-xs-4 col-sm-3">
		<?php esc_html_e('Show search for dropdown', 'woo-product-filter'); ?>
		<i class="fa fa-question woobewoo-tooltip no-tooltip" title="<?php echo esc_attr__('Show search field in multiple dropdown box', 'woo-product-filter'); ?>"></i>
	</div>
	<div class="settings-block-values settings-values-w100 col-xs-8 col-sm-9">
		<div class="settings-value settings-w100">
			<?php HtmlWpf::checkboxToggle('f_dropdown_search', array()); ?>
		</div>
		<div class="settings-value settings-w100" data-parent="f_dropdown_search">
			<?php HtmlWpf::text('f_dropdown_search_text', array('placeholder' => esc_attr__('Search', 'woo-product-filter'), 'attrs' => 'class="woobewoo-flat-input"')); ?>
		</div>
	</div>
</div>
<div class="row-settings-block" data-parent="f_list" data-no-values="custom_meta_field_check">
	<div class="settings-block-label col-xs-4 col-sm-3">
		<?php esc_html_e('Order by custom', 'woo-product-filter'); ?>
		<i class="fa fa-question woobewoo-tooltip no-tooltip" title="<?php echo esc_attr(__('Attributes are displayed according to the order of their selection in the input fields.', 'woo-product-filter') . ' <a href="https://woobewoo.com/documentation/attribute-filter-settings/" target="_blank">' . __('Learn More', 'woo-product-filter') . '</a>.'); ?>"></i>
	</div>
	<div class="settings-block-values col-xs-8 col-sm-9">
		<div class="settings-value settings-w100">
			<?php HtmlWpf::checkboxToggle('f_order_custom', array()); ?>
		</div>
	</div>
</div>
<div class="row-settings-block" data-parent="f_list" data-no-values="custom_meta_field_check">
	<div class="settings-block-label col-xs-4 col-sm-3">
		<?php esc_html_e('Hide attributes without products', 'woo-product-filter'); ?>
		<i class="fa fa-question woobewoo-tooltip no-tooltip" title="<?php echo esc_attr__('Hide attributes without products.', 'woo-product-filter'); ?>"></i>
	</div>
	<div class="settings-block-values col-xs-8 col-sm-9">
		<div class="settings-value settings-w100">
			<?php HtmlWpf::checkboxToggle('f_hide_empty', array()); ?>
		</div>
		<div class="settings-value settings-w100" data-parent="f_hide_empty">
			<div class="settings-value-label">
				<?php esc_html_e('Same behavior for active filter', 'woo-product-filter'); ?>
				<i class="fa fa-question woobewoo-tooltip no-tooltip" title="<?php echo esc_attr(__('By default if a value is selected in the filter, items without products will still be displayed (this was done on purpose so that you can quickly switch between items).If the option is enabled, empty elements will be hidden regardless of the filter activity (this also applies to loading via ajax and when reloading the page with the parameters specified in the url).', 'woo-product-filter')); ?>"></i>
			</div>
			<?php HtmlWpf::checkboxToggle('f_hide_empty_active', array()); ?>
		</div>
	</div>
</div>
<div class="row-settings-block wpfTypeSwitchable"  data-not-type="slider">
	<div class="settings-block-label col-xs-4 col-sm-3">
		<?php esc_html_e('Show count', 'woo-product-filter'); ?>
		<i class="fa fa-question woobewoo-tooltip no-tooltip" title="<?php echo esc_attr(__('Show count display the number of products that have the appropriate parameter.', 'woo-product-filter') . ' <a href="https://woobewoo.com/documentation/attribute-filter-settings/" target="_blank">' . __('Learn More', 'woo-product-filter') . '</a>.'); ?>"></i>
	</div>
	<div class="settings-block-values col-xs-8 col-sm-9">
		<div class="settings-value settings-w100">
			<?php HtmlWpf::checkboxToggle('f_show_count', array()); ?>
		</div>
	</div>
</div>
<div class="row-settings-block wpfHidden" data-parent="f_list" data-no-values="custom_meta_field_check">
	<div class="settings-block-label settings-w100 col-xs-4 col-sm-3">
		<?php esc_html_e('Attributes', 'woo-product-filter'); ?>
		<i class="fa fa-question woobewoo-tooltip no-tooltip" title="<?php echo esc_attr(__('Select attributes to be displayed on site from the list. If you want to select several attributes, hold the "Shift" button and click on names. Or you can hold "Ctrl" and click on names. Press "Ctrl" + "a" for checking all names.', 'woo-product-filter') . ' <a href="https://woobewoo.com/documentation/attribute-filter-settings/" target="_blank">' . __('Learn More', 'woo-product-filter') . '</a>.'); ?>"></i>
	</div>
	<div class="settings-block-values settings-w100 col-xs-8 col-sm-9">
		<div class="settings-value settings-w100 woobewoo-width-full">
			<?php 
				HtmlWpf::selectlist('f_mlist', array(
					'options' => array(),
				));
				?>
		</div>
	</div>
</div>
<div class="row-settings-block" data-parent="f_list" data-no-values="custom_meta_field_check">
	<div class="settings-block-label col-xs-4 col-sm-3">
		<?php esc_html_e('Make selected attributes as default', 'woo-product-filter'); ?>
		<i class="fa fa-question woobewoo-tooltip no-tooltip" title="<?php echo esc_attr(__('Selected attributes will be marked as default.', 'woo-product-filter') . ' <a href="https://woobewoo.com/documentation/attribute-filter-settings/" target="_blank">' . __('Learn More', 'woo-product-filter') . '</a>.'); ?>"></i>
	</div>
	<div class="settings-block-values col-xs-8 col-sm-9">
		<div class="settings-value settings-w100">
			<?php HtmlWpf::checkboxToggle('f_hidden_attributes', array('attrs' => 'data-preselect-flag="1"')); ?>
		</div>
	</div>
</div>
<div class="row-settings-block" data-parent="f_list" data-no-values="custom_meta_field_check">
	<div class="settings-block-label col-xs-4 col-sm-3">
		<?php esc_html_e('Logic', 'woo-product-filter'); ?>
	</div>
	<div class="settings-block-values col-xs-8 col-sm-9">
		<div class="settings-value settings-w100">
			<?php
				HtmlWpf::selectbox('f_query_logic', array(
					'options' => $this->getModule()->getAttrFilterLogic('display'),
					'value' => 'or',
					'attrs' => 'class="woobewoo-flat-input"'
				));
				?>
		</div>
	</div>
</div>
<div class="row-settings-block" data-parent="f_list" data-no-values="custom_meta_field_check">
	<div class="settings-block-label settings-w100 col-xs-4 col-sm-3">
		<?php esc_html_e('Sort by', 'woo-product-filter'); ?>
		<i class="fa fa-question woobewoo-tooltip no-tooltip" title="<?php echo esc_attr(__('Set attributes sorting by ascendance or descendance.', 'woo-product-filter') . ' <a href="https://woobewoo.com/documentation/attribute-filter-settings/" target="_blank">' . __('Learn More', 'woo-product-filter') . '</a>.'); ?>"></i>
	</div>
	<div class="settings-block-values settings-w100 col-xs-8 col-sm-9">
		<div class="settings-value settings-w100">
			<?php 
				HtmlWpf::selectbox('f_sort_by', array(
					'options' => array( 'default' => esc_attr__('Don\'t sort', 'woo-product-filter'), 'asc' => esc_attr__( 'ASC', 'woo-product-filter'), 'desc' => esc_attr__( 'DESC', 'woo-product-filter') ),
					'attrs' => 'class="woobewoo-flat-input"'
				));
				?>
		</div>
		<?php
		if ($isPro) {
			DispatcherWpf::doAction('addEditTabFilters', 'partEditTabFiltersSortAsNumbers');
		} else {
			?>
		<div class="row-settings-block" data-parent="f_sort_by" data-no-values="default">
			<div class="settings-block-label col-xs-8 col-sm-6" >
				<?php esc_html_e('Sort as numbers', 'woo-product-filter'); ?>
				<span class="wpfProLabel"><?php esc_html_e('PRO option', 'woo-product-filter'); ?></span>
			</div>
		</div>
		<?php } ?>
	</div>
</div>
<div class="row-settings-block wpfTypeSwitchable" data-type="list radio" data-parent="f_list" data-no-values="custom_meta_field_check">
	<div class="settings-block-label col-xs-4 col-sm-3">
		<?php esc_html_e('Show search', 'woo-product-filter'); ?>
		<i class="fa fa-question woobewoo-tooltip no-tooltip" title="<?php echo esc_attr__('Show search.', 'woo-product-filter'); ?>"></i>
	</div>
	<div class="settings-block-values settings-values-w100 col-xs-8 col-sm-9">
		<div class="settings-value settings-w100">
			<?php HtmlWpf::checkboxToggle('f_show_search_input', array()); ?>
		</div>
		<div class="settings-value settings-w100" data-parent="f_show_search_input">
			<?php
				$labels = $this->getModel('woofilters')->getFilterLabels('Attribute');
				HtmlWpf::text('f_search_label', array('placeholder' => esc_html($labels['search']), 'attrs' => 'class="woobewoo-flat-input woobewoo-width100"'));
			?>
		</div>
		<?php DispatcherWpf::doAction('addEditTabFilters', 'partEditTabFiltersSearchList'); ?>
	</div>
</div>
<div class="row-settings-block" data-parent="f_list" data-no-values="custom_meta_field_check">
	<div class="settings-block-label col-xs-4 col-sm-3">
		<?php esc_html_e('Always display all attributes', 'woo-product-filter'); ?>
		<i class="fa fa-question woobewoo-tooltip no-tooltip" title="<?php echo esc_attr(__('If checked, the entire list of attributes will always be visible, otherwise only available for filtered items.', 'woo-product-filter') . ' <a href="https://woobewoo.com/documentation/attribute-filter-settings/" target="_blank">' . __('Learn More', 'woo-product-filter') . '</a>.'); ?>"></i>
	</div>
	<div class="settings-block-values col-xs-8 col-sm-9">
		<div class="settings-value settings-w100">
			<?php HtmlWpf::checkboxToggle('f_show_all_attributes', array()); ?>
		</div>
	</div>
</div>
<div class="row-settings-block wpfTypeSwitchable" data-not-type="dropdown mul_dropdown colors slider">
	<div class="settings-block-label settings-w100 col-xs-4 col-sm-3">
		<?php esc_html_e('Layout', 'woo-product-filter'); ?>
		<i class="fa fa-question woobewoo-tooltip no-tooltip" title="<?php echo esc_attr(__('Select a vertical or horizontal layout and set the count of columns.', 'woo-product-filter') . ' <a href="https://woobewoo.com/documentation/attribute-filter-settings/" target="_blank">' . __('Learn More', 'woo-product-filter') . '</a>.'); ?>"></i>
	</div>
	<div class="settings-block-values settings-w100 col-xs-8 col-sm-9">
		<div class="settings-value settings-w100">
			<?php 
				HtmlWpf::selectbox('f_layout', array(
					'options' => array('ver' => esc_attr__('Vertical', 'woo-product-filter'), 'hor' => esc_attr__('Horizontal', 'woo-product-filter')),
					'attrs' => 'class="woobewoo-flat-input"'
				));
				?>
		</div>
		<div class="settings-value settings-w100" data-select="f_layout" data-select-value="ver">
			<div class="settings-value-label">
				<?php esc_html_e('Columns', 'woo-product-filter'); ?>
			</div>
			<?php HtmlWpf::text('f_ver_columns', array('value' => 1, 'attrs' => 'class="woobewoo-flat-input woobewoo-number woobewoo-width40"')); ?>
		</div>
	</div>
</div>
<div class="row-settings-block wpfTypeSwitchable" data-not-type="dropdown mul_dropdown">
	<div class="settings-block-label settings-w100 col-xs-4 col-sm-3">
		<?php esc_html_e('Maximum height in frontend', 'woo-product-filter'); ?>
		<i class="fa fa-question woobewoo-tooltip no-tooltip" title="<?php echo esc_attr(__('Set maximum displayed height in frontend.', 'woo-product-filter') . ' <a href="https://woobewoo.com/documentation/attribute-filter-settings/" target="_blank">' . __('Learn More', 'woo-product-filter') . '</a>.'); ?>"></i>
	</div>
	<div class="settings-block-values settings-w100 col-xs-8 col-sm-9">
		<div class="settings-value settings-w100">
			<?php HtmlWpf::text('f_max_height', array('value'=>'200', 'attrs' => 'class="woobewoo-flat-input woobewoo-number woobewoo-width60"')); ?> px
		</div>
	</div>
</div>

<?php
	ViewWpf::display('woofiltersEditTabCommonTitle');
?>
<div class="row-settings-block">
	<div class="settings-block-label settings-w100 col-xs-4 col-sm-3">
		<?php esc_html_e('Show on frontend as', 'woo-product-filter'); ?>
		<i class="fa fa-question woobewoo-tooltip no-tooltip" title="<?php echo esc_attr(__('Depending on whether you need one or several categories to be available at the same time, you may show your categories list as checkbox or dropdown.', 'woo-product-filter') . ' <a href="https://woobewoo.com/documentation/product-categories/" target="_blank">' . __('Learn More', 'woo-product-filter') . '</a>.'); ?>"></i>
	</div>
	<div class="settings-block-values settings-w100 col-xs-8 col-sm-9">
		<div class="settings-value settings-w100">
			<?php 
				HtmlWpf::selectbox('f_frontend_type', array(
					'options' => array(
						'list' => esc_attr__( 'Radiobuttons list (single select)', 'woo-product-filter' ),
						'dropdown' => esc_attr__( 'Dropdown (single select)', 'woo-product-filter' ),
						'mul_dropdown' => esc_attr__( 'Multiple Dropdown', 'woo-product-filter' ) . $labelPro,
						'multi' => esc_attr__( 'Checkbox list (multiple select)', 'woo-product-filter' ) . $labelPro,
						'buttons' => esc_attr__( 'Buttons', 'woo-product-filter' ) . $labelPro,
						'text' => esc_attr__( 'Text', 'woo-product-filter' ) . $labelPro
					),
					'attrs' => 'class="woobewoo-flat-input"'
				));
				?>
		</div>
	</div>
</div>
<?php
if ($isPro) {
	DispatcherWpf::doAction( 'addEditTabFilters', 'partEditTabFiltersSelectDefaultId');
	DispatcherWpf::doAction( 'addEditTabFilters', 'partEditTabFiltersMultiSelect');
}
?>
<div class="row-settings-block wpfTypeSwitchable" data-not-type="buttons">
	<div class="settings-block-label col-xs-4 col-sm-3">
		<?php esc_html_e('Show hierarchical', 'woo-product-filter'); ?>
		<i class="fa fa-question woobewoo-tooltip no-tooltip" title="<?php echo esc_attr(__('Show paternal and subsidiary categories (for checkbox list). If you display only some categories, make sure that the parent categories are selected.', 'woo-product-filter') . ' <a href="https://woobewoo.com/documentation/product-categories/" target="_blank">' . __('Learn More', 'woo-product-filter') . '</a>.'); ?>"></i>
	</div>
	<div class="sub-block-values col-xs-8 col-sm-9">
		<div class="settings-value settings-w100">
			<?php HtmlWpf::checkboxToggle('f_show_hierarchical', array()); ?>
		</div>
		<div class="settings-value" data-parent-switch="f_show_hierarchical">
			<div class="settings-value-label">
				<?php esc_html_e('Hide categories parent', 'woo-product-filter'); ?>
				<i class="fa fa-question woobewoo-tooltip no-tooltip" title="<?php echo esc_attr__('Show only categories children.', 'woo-product-filter'); ?>"></i>
			</div>
			<?php HtmlWpf::checkboxToggle('f_hide_parent', array()); ?>
		</div>
		<?php
		if ($isPro) {
			DispatcherWpf::doAction('addEditTabFilters', 'partEditTabFiltersHierarchicalOption');
		} else {
			?>
			<div class="settings-value wpfTypeSwitchable" data-type="multi list" data-parent-switch="f_show_hierarchical">
				<div class="settings-value-label">
					<?php esc_html_e('Collapsible', 'woo-product-filter'); ?>
					<i class="fa fa-question woobewoo-tooltip no-tooltip" title="<?php echo esc_attr__('If enabled, then show only parent elements, if there are children, they are minimized.', 'woo-product-filter'); ?>"></i>
				</div>
				<span class="wpfProLabel"><?php esc_html_e('PRO option', 'woo-product-filter'); ?></span>
			</div>
			<?php
		}
		?>
		<div class="settings-value wpfTypeSwitchable" data-not-type="buttons list dropdown" data-parent-switch="f_show_hierarchical">
			<div class="settings-value-label">
				<?php esc_html_e('Product selection hierarchically', 'woo-product-filter'); ?>
				<i class="fa fa-question woobewoo-tooltip no-tooltip" title="<?php echo esc_attr(__('Restrict filtering result only to child categories or only to parent if both of them selected in the same time.', 'woo-product-filter') . ' <a href="https://woobewoo.com/documentation/product-categories/" target="_blank">' . __('Learn More', 'woo-product-filter') . '</a>.'); ?>"></i>
			</div>
			<?php
				HtmlWpf::selectbox('f_multi_logic_hierarchical', array(
					'options' => array(
						'any'    => esc_attr__('Could be in both, child or parent', 'woo-product-filter'),
						'child'  => esc_attr__('Only in child', 'woo-product-filter'),
						'parent' => esc_attr__('Only in parent', 'woo-product-filter'),
					),
					'attrs' => 'class="woobewoo-flat-input"'
				));
				?>
		</div>
	</div>
</div>
<?php

if ( $isPro ) {
	DispatcherWpf::doAction('addEditTabFilters', 'partEditTabFiltersCollapseLevel');
} else {
	?>
	<div class="row-settings-block wpfTypeSwitchable" data-parent-switch="f_multi_collapsible" data-type="multi list">
		<div class="settings-block-label col-xs-4 col-sm-3" >
			<?php esc_html_e('Collapse level', 'woo-product-filter'); ?>
			<i class="fa fa-question woobewoo-tooltip no-tooltip" title="<?php echo esc_attr(__('The level of child categories from which to start collapsing', 'woo-product-filter')); ?>"></i>
		</div>
		<div class="sub-block-values settings-values-w100 col-xs-8 col-sm-9">
			<div class="settings-value settings-w100">
				<span class="wpfProLabel"><?php esc_html_e('PRO option', 'woo-product-filter'); ?></span>
			</div>
		</div>
	</div>
<?php } ?>

<div class="row-settings-block wpfTypeSwitchable" data-type="list dropdown">
	<div class="settings-value settings-w100">
		<div class="settings-block-label col-xs-4 col-sm-3">
			<?php esc_html_e('Filter with children', 'woo-product-filter'); ?>
			<i class="fa fa-question woobewoo-tooltip no-tooltip" title="<?php echo esc_attr(__('If parent filter category was selected then extend filter result to child categories.', 'woo-product-filter') . ' <a href="https://woobewoo.com/documentation/product-categories/" target="_blank">' . __('Learn More', 'woo-product-filter') . '</a>.'); ?>"></i>
		</div>
		<div class="settings-block-values col-xs-8 col-sm-9">
			<?php HtmlWpf::checkboxToggle('f_extend_parent_filtering', array('checked' => 1)); ?>
		</div>
	</div>
</div>
<?php 
if ($isPro) {
	DispatcherWpf::doAction('addEditTabFilters', 'partEditTabFiltersButtonsType');
	DispatcherWpf::doAction('addEditTabFilters', 'partEditTabFiltersCategoryMulti');
}
ViewWpf::display('woofiltersEditTabCustomTags');
?>
<div class="row-settings-block wpfTypeSwitchable" data-type="dropdown mul_dropdown">
	<div class="settings-block-label settings-w100 col-xs-4 col-sm-3">
		<?php esc_html_e('Dropdown label', 'woo-product-filter'); ?>
		<i class="fa fa-question woobewoo-tooltip no-tooltip" title="<?php echo esc_attr(__('Dropdown first option text.', 'woo-product-filter') . ' <a href="https://woobewoo.com/documentation/product-categories/" target="_blank">' . __('Learn More', 'woo-product-filter') . '</a>.'); ?>"></i>
	</div>
	<div class="settings-block-values settings-w100 col-xs-8 col-sm-9">
		<div class="settings-value settings-w100">
			<?php 
				HtmlWpf::text('f_dropdown_first_option_text', array(
					'placeholder' => esc_attr__('Select all', 'woo-product-filter'),
					'attrs' => 'class="woobewoo-flat-input"'
				));
				?>
		</div>
	</div>
</div>
<div class="row-settings-block">
	<div class="settings-block-label settings-w100 col-xs-4 col-sm-3">
		<?php esc_html_e('Sort by', 'woo-product-filter'); ?>
		<i class="fa fa-question woobewoo-tooltip no-tooltip" title="<?php echo esc_attr(__('Set categories sorting by ascendance or descendance.', 'woo-product-filter') . ' <a href="https://woobewoo.com/documentation/product-categories/" target="_blank">' . __('Learn More', 'woo-product-filter') . '</a>.'); ?>"></i>
	</div>
	<div class="settings-block-values settings-w100 col-xs-8 col-sm-9">
		<div class="settings-value settings-w100">
			<?php 
				HtmlWpf::selectbox('f_sort_by', array(
					'options' => array('asc' => 'ASC', 'desc' => 'DESC', 'default' => 'Default' . $labelPro),
					'attrs' => 'class="woobewoo-flat-input' . ( $isPro ? '' : ' wpfWithProAd' ) . '"'
				));
				?>
		</div>
		<?php
		if ($isPro) {
			DispatcherWpf::doAction('addEditTabFilters', 'partEditTabFiltersSortAsNumbers');
		} else {
			?>
		<div class="settings-value settings-w100" data-parent="f_sort_by" data-no-values="default">
			<div class="settings-value-label" >
				<?php esc_html_e('Sort as numbers', 'woo-product-filter'); ?>
				<span class="wpfProLabel"><?php esc_html_e('PRO option', 'woo-product-filter'); ?></span>
			</div>
		</div>
		<?php } ?>
	</div>
</div>
<div class="row-settings-block">
	<div class="settings-block-label col-xs-4 col-sm-3">
		<?php esc_html_e('Order by custom', 'woo-product-filter'); ?>
		<i class="fa fa-question woobewoo-tooltip no-tooltip" title="<?php echo esc_attr(__('Categories are displayed according to the order of their selection in the input fields.', 'woo-product-filter') . ' <a href="https://woobewoo.com/documentation/product-categories/" target="_blank">' . __('Learn More', 'woo-product-filter') . '</a>.'); ?>"></i>
	</div>
	<div class="settings-block-values col-xs-8 col-sm-9">
		<div class="settings-value settings-w100">
			<?php HtmlWpf::checkboxToggle('f_order_custom', array()); ?>
		</div>
	</div>
</div>
<div class="row-settings-block">
	<div class="settings-block-label col-xs-4 col-sm-3">
		<?php esc_html_e('Show count', 'woo-product-filter'); ?>
		<i class="fa fa-question woobewoo-tooltip no-tooltip" title="<?php echo esc_attr(__('Show count display the number of products that have the appropriate parameter (attribute, category, tag).', 'woo-product-filter') . ' <a href="https://woobewoo.com/documentation/show-count-option/" target="_blank">' . __('Learn More', 'woo-product-filter') . '</a>.'); ?>"></i>
	</div>
	<div class="settings-block-values col-xs-8 col-sm-9">
		<div class="settings-value settings-w100">
			<?php HtmlWpf::checkboxToggle('f_show_count', array()); ?>
		</div>
		<div class="settings-value settings-w100" data-parent="f_show_count">
			<div class="settings-value-label">
				<?php esc_html_e('Count parents with children', 'woo-product-filter'); ?>
				<i class="fa fa-question woobewoo-tooltip no-tooltip" title="<?php echo esc_attr(__('Count for parent category also her children count. <strong>Warning!</strong> If filtering will slow do uncheck this option.', 'woo-product-filter') . ' <a href="https://woobewoo.com/documentation/show-count-option/" target="_blank">' . __('Learn More', 'woo-product-filter') . '</a>.'); ?>"></i>
			</div>
			<?php HtmlWpf::checkboxToggle('f_show_count_parent_with_children', array()); ?>
		</div>
	</div>
</div>
<div class="row-settings-block">
	<div class="settings-block-label col-xs-4 col-sm-3">
		<?php esc_html_e('Hide categories without products', 'woo-product-filter'); ?>
		<i class="fa fa-question woobewoo-tooltip no-tooltip" title="<?php echo esc_attr(__('Hide categories without products.', 'woo-product-filter') . ' <a href="https://woobewoo.com/documentation/product-categories/" target="_blank">' . __('Learn More', 'woo-product-filter') . '</a>.'); ?>"></i>
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
<div class="row-settings-block">
	<div class="settings-block-label settings-w100 col-xs-4 col-sm-3">
		<?php esc_html_e('Product categories', 'woo-product-filter'); ?>
		<i class="fa fa-question woobewoo-tooltip no-tooltip" title="<?php echo esc_attr(__('Select product categories to be displayed on site from the list. If you want to select several categories, hold the "Shift" button and click on category names. Or you can hold "Ctrl" and click on category names. Press "Ctrl" + "a" for checking all categories.', 'woo-product-filter') . ' <a href="https://woobewoo.com/documentation/product-categories/" target="_blank">' . __('Learn More', 'woo-product-filter') . '</a>.'); ?>"></i>
	</div>
	<div class="settings-block-values settings-w100 col-xs-8 col-sm-9">
		<div class="settings-value woobewoo-width-full">
			<?php 
				HtmlWpf::selectlist('f_mlist', array(
					'options' => $categoryDisplay,
					'data-parents' => json_encode($parentCategories, JSON_HEX_QUOT | JSON_HEX_TAG)
				));
				?>
		</div>
		<div class="settings-value settings-w100">
			<div class="settings-value-label">
				<?php esc_html_e('Include children', 'woo-product-filter'); ?>
			</div>
			<?php HtmlWpf::checkboxToggle('f_mlist_with_children', array()); ?>
		</div>
	</div>
</div>
<div class="row-settings-block">
	<div class="settings-block-label col-xs-4 col-sm-3">
		<?php esc_html_e('Make selected categories as default', 'woo-product-filter'); ?>
		<i class="fa fa-question woobewoo-tooltip no-tooltip" title="<?php echo esc_attr(__('Selected categories will be marked as default and hidden on frontend.', 'woo-product-filter') . ' <a href="https://woobewoo.com/documentation/product-categories/" target="_blank">' . __('Learn More', 'woo-product-filter') . '</a>.'); ?>"></i>
	</div>
	<div class="settings-block-values col-xs-8 col-sm-9">
		<div class="settings-value settings-w100">
			<?php HtmlWpf::checkboxToggle('f_hidden_categories', array('attrs' => 'data-preselect-flag="1"')); ?>
		</div>
	</div>
</div>
<div class="row-settings-block">
	<div class="settings-block-label col-xs-4 col-sm-3">
		<?php esc_html_e('Restrict filtering results only to selected categories', 'woo-product-filter'); ?>
		<i class="fa fa-question woobewoo-tooltip no-tooltip" title="<?php echo esc_attr(__('When the filter is clear, he will be restrict filtered results only by selected items. Be careful when using with other filters in block!.', 'woo-product-filter') . ' <a href="https://woobewoo.com/documentation/product-categories/" target="_blank">' . __('Learn More', 'woo-product-filter') . '</a>.'); ?>"></i>
	</div>
	<div class="settings-block-values col-xs-8 col-sm-9">
		<div class="settings-value settings-w100">
			<?php HtmlWpf::checkboxToggle('f_filtered_by_selected', array()); ?>
		</div>
	</div>
</div>
<div class="row-settings-block">
	<div class="settings-block-label settings-w100 col-xs-4 col-sm-3">
		<?php esc_html_e('Exclude terms ids', 'woo-product-filter'); ?>
		<i class="fa fa-question woobewoo-tooltip no-tooltip" title="<?php echo esc_attr(__('Exclude category terms from filter by ids. Example input: 1,2,3.', 'woo-product-filter') . ' <a href="https://woobewoo.com/documentation/product-categories/" target="_blank">' . __('Learn More', 'woo-product-filter') . '</a>.'); ?>"></i>
	</div>
	<div class="settings-block-values settings-w100 col-xs-8 col-sm-9">
		<div class="settings-value settings-w100">
			<?php HtmlWpf::text('f_exclude_terms', array('attrs' => 'class="woobewoo-flat-input"')); ?>
		</div>
	</div>
</div>
<div class="row-settings-block wpfTypeSwitchable" data-type="list">
	<div class="settings-block-label col-xs-4 col-sm-3">
		<?php esc_html_e('Show search', 'woo-product-filter'); ?>
		<i class="fa fa-question woobewoo-tooltip no-tooltip" title="<?php echo esc_attr(__('Show search display the bar for searching by category name in the filter.', 'woo-product-filter') . ' <a href="https://woobewoo.com/documentation/product-categories/" target="_blank">' . __('Learn More', 'woo-product-filter') . '</a>.'); ?>"></i>
	</div>
	<div class="settings-block-values col-xs-8 col-sm-9">
		<div class="settings-value settings-w100">
			<?php HtmlWpf::checkboxToggle('f_show_search_input', array()); ?>
		</div>
		<div class="settings-value settings-w100" data-parent="f_show_search_input">
			<?php
			$labels = $this->getModel('woofilters')->getFilterLabels('Category');
			HtmlWpf::text('f_search_label', array('placeholder' => esc_html($labels['search']), 'attrs' => 'class="woobewoo-flat-input"'));
			?>
		</div>
	</div>
</div>
<div class="row-settings-block">
	<div class="settings-block-label col-xs-4 col-sm-3">
		<?php esc_html_e('Hide child', 'woo-product-filter'); ?>
		<i class="fa fa-question woobewoo-tooltip no-tooltip" title="<?php echo esc_attr__('Hide child taxonomy', 'woo-product-filter'); ?>"></i>
	</div>
	<div class="settings-block-values col-xs-8 col-sm-9">
		<div class="settings-value settings-w100">
			<?php HtmlWpf::checkboxToggle('f_hide_taxonomy', array()); ?>
		</div>
	</div>
</div>
<div class="row-settings-block">
	<div class="settings-block-label col-xs-4 col-sm-3">
		<?php esc_html_e('Always display all categories', 'woo-product-filter'); ?>
		<i class="fa fa-question woobewoo-tooltip no-tooltip" title="<?php echo esc_attr(__('If checked, the entire list of categories will always be visible, otherwise only available for filtered items.', 'woo-product-filter') . ' <a href="https://woobewoo.com/documentation/product-categories/" target="_blank">' . __('Learn More', 'woo-product-filter') . '</a>.'); ?>"></i>
	</div>
	<div class="settings-block-values col-xs-8 col-sm-9">
		<div class="settings-value settings-w100">
			<?php HtmlWpf::checkboxToggle('f_show_all_categories', array()); ?>
		</div>
	</div>
</div>
<div class="row-settings-block wpfTypeSwitchable" data-not-type="dropdown mul_dropdown">
	<div class="settings-block-label settings-w100 col-xs-4 col-sm-3">
		<?php esc_html_e('Layout', 'woo-product-filter'); ?>
		<i class="fa fa-question woobewoo-tooltip no-tooltip" title="<?php echo esc_attr(__('Select a vertical or horizontal layout and set the count of columns.', 'woo-product-filter') . ' <a href="https://woobewoo.com/documentation/product-categories/" target="_blank">' . __('Learn More', 'woo-product-filter') . '</a>.'); ?>"></i>
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
		<i class="fa fa-question woobewoo-tooltip no-tooltip" title="<?php echo esc_attr(__('Set maximum displayed height in frontend.', 'woo-product-filter') . ' <a href="https://woobewoo.com/documentation/product-categories/" target="_blank">' . __('Learn More', 'woo-product-filter') . '</a>.'); ?>"></i>
	</div>
	<div class="settings-block-values settings-w100 col-xs-8 col-sm-9">
		<div class="settings-value settings-w100">
			<?php HtmlWpf::text('f_max_height', array('value'=>'200', 'attrs' => 'class="woobewoo-flat-input woobewoo-number woobewoo-width60"')); ?> px
		</div>
	</div>
</div>
<?php DispatcherWpf::doAction('addEditTabFilters', 'partEditTabFiltersMaxShowMore'); ?>

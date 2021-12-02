<div class="row row-tab" id="row-tab-options">
	<div class="sub-tab woobewoo-input-group col-xs-12">
		<a href="#sub-tab-options-main" class="button"><?php esc_html_e('Main', 'woo-product-filter'); ?></a>
		<a href="#sub-tab-options-buttons" class="button disabled"><?php esc_html_e('Buttons', 'woo-product-filter'); ?></a>
		<a href="#sub-tab-options-content" class="button disabled"><?php esc_html_e('Content', 'woo-product-filter'); ?></a>
		<a href="#sub-tab-options-loader" class="button disabled"><?php esc_html_e('Loader', 'woo-product-filter'); ?></a>
	</div>
	<div class="col-xs-12 sub-tab-content" id="sub-tab-options-main" data-no-preview="1">
		<div class="settings-block-title">
			<?php esc_html_e('Main settings', 'woo-product-filter'); ?>
		</div>
		<?php
		$displayOnPage = ( isset($this->settings['settings']['display_on_page']) ? $this->settings['settings']['display_on_page'] : 'both' );
		$classHidden   = 'specific' != $displayOnPage ? 'wpfHidden' : '';
		?>
		<div class="row row-settings-block">
			<div class="settings-block-label col-xs-4 col-lg-3">
				<?php esc_html_e('Display on pages', 'woo-product-filter'); ?>
				<i class="fa fa-question woobewoo-tooltip" title="<?php echo esc_attr(__('Choose page for filter.', 'woo-product-filter') . ' <a href="https://woobewoo.com/documentation/display-only-on-page-wpf/" target="_blank">' . __('Learn More', 'woo-product-filter') . '</a>.'); ?>"></i>
			</div>
			<div class="settings-block-values settings-w100 col-xs-6 col-sm-8 col-lg-9">
				<div class="settings-value settings-w100">
					<?php
					$selectOptions = array(
						'shop'        => esc_attr__( 'Shop', 'woo-product-filter' ),
						'category'    => esc_attr__( 'Product Category', 'woo-product-filter' ),
						'tag'         => esc_attr__( 'Product Tag', 'woo-product-filter' ),
						'product'     => esc_attr__( 'Product Page', 'woo-product-filter' ),
						'both'        => esc_attr__( 'All Woocommerce Pages', 'woo-product-filter' ),
						'specific'    => esc_attr__( 'Specific', 'woo-product-filter' ) . $labelPro,
						'custom_cats' => esc_attr__( 'Specific category', 'woo-product-filter' ) . $labelPro
					);

					if ( taxonomy_exists( 'pwb-brand' ) || taxonomy_exists( 'product_brand' ) ) {
						$selectOptions['brand'] = esc_attr__( 'Brand Page', 'woo-product-filter' ) . $labelPro;
					}

					HtmlWpf::selectbox('settings[display_on_page]', array(
						'options' => $selectOptions,
						'value' => ( isset($this->settings['settings']['display_on_page']) ? $this->settings['settings']['display_on_page'] : 'both' ),
						'attrs' => 'class="woobewoo-flat-input"'
					));
					?>
				</div>
				<div class="settings-value settings-w100 <?php echo esc_attr($classHidden); ?>" data-select="settings[display_on_page]" data-select-value="specific">
					<?php 
					if ($isPro) {
						$pageList = $this->getFilterSetting($this->settings['settings'], 'display_page_list', '');
						if (is_array($pageList)) {
							$pageList = isset($pageList[0]) ? $pageList[0] : '';
						}
						HtmlWpf::selectlist('settings[display_page_list][]', array(
							'options' => FrameWpf::_()->getModule('woofilters')->getAllPages(),
							'value' => explode(',', $pageList),
						));
					} else {
						echo '<span class="wpfProLabel">' . esc_html__('PRO option', 'woo-product-filter') . '</span>';
					}
					?>
				</div>

				<?php $classHidden = 'custom_cats' != $displayOnPage ? 'wpfHidden' : ''; ?>
				<div class="settings-value settings-w100 <?php echo esc_attr($classHidden); ?>" data-select="settings[display_on_page]" data-select-value="custom_cats">
					<?php
					if ($isPro) {
						$catList               = $this->getFilterSetting($this->settings['settings'], 'display_cat_list', '');
						list($categoryDisplay) = FrameWpf::_()->getModule('woofilters')->getCategoriesDisplay();
						if (is_array($catList)) {
							$catList = isset($catList[0]) ? $catList[0] : '';
						}
						HtmlWpf::selectlist('settings[display_cat_list][]', array(
							'options' => $categoryDisplay,
							'value' => explode(',', $catList),
						));
					} else {
						echo '<span class="wpfProLabel">' . esc_html__('PRO option', 'woo-product-filter') . '</span>';
					}
					?>
				</div>

				<div class="settings-value settings-w100 <?php echo esc_attr( $classHidden ); ?>" data-select="settings[display_on_page]" data-select-value="custom_cats">
					<?php
					if ( $isPro ) {
						esc_html_e( 'Include child categories', 'woo-product-filter' );
						?>
						<i class="fa fa-question woobewoo-tooltip no-tooltip"
						   title="<?php echo esc_attr( __( 'The filter will be displayed on all child categories', 'woo-product-filter' ) ); ?>"></i>
						<?php
						HtmlWpf::checkboxToggle( 'settings[display_child_cat]', array(
							'checked' => $this->getFilterSetting($this->settings['settings'], 'display_child_cat', false)
						) );
					} else {
						echo '<span class="wpfProLabel">' . esc_html__( 'PRO option', 'woo-product-filter' ) . '</span>';
					}
					?>
				</div>

			</div>
		</div>

		<div class="row row-settings-block">
			<div class="settings-block-label col-xs-4 col-lg-3">
				<?php esc_html_e( 'Display on pages apply for shortcode', 'woo-product-filter' ); ?>
				<i class="fa fa-question woobewoo-tooltip" title="<?php echo esc_attr( __( 'By default, the filter added by the shortcode is displayed everywhere. This option allows you to restrict the display to only those selected in "Display on pages"', 'woo-product-filter' ) ); ?>"></i>
			</div>
			<div class="settings-block-values col-xs-8 col-lg-9">
				<div class="settings-value settings-w100">
					<?php
					HtmlWpf::checkboxToggle( 'settings[display_on_page_shortcode]', array(
						'checked' => $this->getFilterSetting( $this->settings['settings'], 'display_on_page_shortcode', false )
					) );
					?>
				</div>
			</div>
		</div>

		<?php
		if ($isPro) {
			DispatcherWpf::doAction('addEditTabDesign', 'partEditTabOptionsMain', $this->settings);
		} else {
			?>
		<div class="row row-settings-block">
			<div class="settings-block-label col-xs-4 col-lg-3">
				<?php esc_html_e('Redirect to url', 'woo-product-filter'); ?>
				<i class="fa fa-question woobewoo-tooltip" title="<?php echo esc_attr(__('You can select one of the available pages to redirect to it after selecting a filter', 'woo-product-filter')); ?>"></i>
			</div>
			<div class="settings-block-values col-xs-8 col-lg-9">
				<span class="settings-value wpfProLabel"><?php esc_html_e('PRO option', 'woo-product-filter'); ?></span>
			</div>
		</div>
		<?php } ?>

		<div class="row row-settings-block">
			<div class="settings-block-label col-xs-4 col-lg-3">
				<?php esc_html_e('Display filter on', 'woo-product-filter'); ?>
				<i class="fa fa-question woobewoo-tooltip" title="<?php echo esc_attr(__('Choose where display filter.', 'woo-product-filter') . ' <a href="https://woobewoo.com/documentation/options-main-tab/" target="_blank">' . __('Learn More', 'woo-product-filter') . '</a>.'); ?>"></i>
			</div>
			<div class="settings-block-values settings-w100 col-xs-8 col-lg-9">
				<div class="settings-value settings-w100">
					<?php
						HtmlWpf::selectbox('settings[display_for]', array(
							'options' => array('mobile' => 'Only for mobile', 'desktop' => 'Only for desktop', 'both' => 'For all device'),
							'value' => ( isset($this->settings['settings']['display_for']) ? $this->settings['settings']['display_for'] : 'both' ),
							'attrs' => 'class="woobewoo-flat-input"'
						));
						?>
				</div>
			</div>
		</div>
		<div class="row row-settings-block">
			<div class="settings-block-label col-xs-4 col-lg-3">
				<?php esc_html_e('Force show only current filter on page', 'woo-product-filter'); ?>
				<i class="fa fa-question woobewoo-tooltip" title="<?php echo esc_attr(__('Remove other woofilters on page except current filter.', 'woo-product-filter') . ' <a href="https://woobewoo.com/documentation/options-main-tab/" target="_blank">' . __('Learn More', 'woo-product-filter') . '</a>.'); ?>"></i>
			</div>
			<div class="settings-block-values col-xs-8 col-lg-9">
				<div class="settings-value settings-w100">
					<?php
					HtmlWpf::checkboxToggle('settings[force_show_current]', array(
						'checked' => ( isset($this->settings['settings']['force_show_current']) ? (int) $this->settings['settings']['force_show_current'] : '' )
					));
					?>
				</div>
			</div>
		</div>
		<?php
			$settingValue = ( isset($this->settings['settings']['desctop_mobile_breakpoint_switcher']) ? (int) $this->settings['settings']['desctop_mobile_breakpoint_switcher'] : '' );
			$hiddenStyle  = $settingValue ? '' : 'wpfHidden';
		?>
		<div class="row row-settings-block">
			<div class="settings-block-label col-xs-4 col-lg-3 pr-0">
				<?php esc_html_e('Set mobile/desktop breakpoint', 'woo-product-filter'); ?>
				<i class="fa fa-question woobewoo-tooltip" title="<?php echo esc_attr(__('Set breakpoint for all options that depend on a mobile/desktop view. "Show title label", "Display filter on" etc.', 'woo-product-filter') . ' <a href="https://woobewoo.com/documentation/options-main-tab/" target="_blank">' . __('Learn More', 'woo-product-filter') . '</a>.'); ?>"></i>
			</div>
			<div class="settings-block-values col-xs-8 col-lg-9">
				<div class="settings-value settings-w100">
					<?php 
						HtmlWpf::checkboxToggle('settings[desctop_mobile_breakpoint_switcher]', array(
							'checked' => ( isset($this->settings['settings']['desctop_mobile_breakpoint_switcher']) ? (int) $this->settings['settings']['desctop_mobile_breakpoint_switcher'] : '' )
						));
						?>
				</div>
				<div class="settings-value settings-w100 <?php echo esc_attr($hiddenStyle); ?>" data-parent="settings[desctop_mobile_breakpoint_switcher]">
					<?php
						HtmlWpf::text(
							'settings[desctop_mobile_breakpoint_width]',
							array(
								'value'=> ( isset($this->settings['settings']['desctop_mobile_breakpoint_width']) ? intval($this->settings['settings']['desctop_mobile_breakpoint_width']) : '' ),
								'attrs' => 'class="woobewoo-flat-input woobewoo-width60"'
							)
						);
						?>
					px
				</div>
			</div>
		</div>
		<div class="row row-settings-block">
			<div class="settings-block-label col-xs-4 col-lg-3">
				<?php esc_html_e('Hide filter on shop pages without products', 'woo-product-filter'); ?>
				<i class="fa fa-question woobewoo-tooltip" title="<?php echo esc_attr(__('Hide filter on shop and categories pages that displays only categories or subcategories without products.', 'woo-product-filter') . ' <a href="https://woobewoo.com/documentation/options-main-tab/" target="_blank">' . __('Learn More', 'woo-product-filter') . '</a>.'); ?>"></i>
			</div>
			<div class="settings-block-values col-xs-8 col-lg-9">
				<div class="settings-value settings-w100">
					<?php 
						HtmlWpf::checkboxToggle('settings[hide_without_products]', array(
							'checked' => ( isset($this->settings['settings']['hide_without_products']) ? (int) $this->settings['settings']['hide_without_products'] : '' )
						));
						?>
				</div>
			</div>
		</div>
		<div class="row row-settings-block">
			<div class="settings-block-label col-xs-4 col-lg-3">
				<?php esc_html_e('Set number of displayed products', 'woo-product-filter'); ?>
				<i class="fa fa-question woobewoo-tooltip" title="<?php echo esc_attr__('Set number of displayed products. This number will only be shown after filter is applied! You must set the same number as in the basic store settings or in the basic filter <a href="' . $this->linkSetting . '" target="_blank">settings</a>.', 'woo-product-filter'); ?>"></i>
			</div>
			<div class="settings-block-values col-xs-8 col-lg-9">
				<div class="settings-value settings-w100">
					<?php
						HtmlWpf::text('settings[count_product_shop]', array(
							'value' => ( isset($this->settings['settings']['count_product_shop']) ? intval($this->settings['settings']['count_product_shop']) : '' ),
							'attrs' => 'class="woobewoo-flat-input woobewoo-number woobewoo-width60"'
						));
						?>
				</div>
			</div>
		</div>
		<div class="row row-settings-block">
			<div class="settings-block-label col-xs-4 col-lg-3">
				<?php esc_html_e('Set number of products per row', 'woo-product-filter'); ?>
				<i class="fa fa-question woobewoo-tooltip" title="<?php echo esc_attr(__('Set number of products per row. This number will only be shown after filter is applied!', 'woo-product-filter') . ' <a href="https://woobewoo.com/documentation/options-main-tab/" target="_blank">' . __('Learn More', 'woo-product-filter') . '</a>.'); ?>"></i>
			</div>
			<div class="settings-block-values settings-w100 col-xs-8 col-lg-9">
				<div class="settings-value settings-w100">
					<?php
						HtmlWpf::text('settings[columns_product_shop]', array(
							'value' => ( isset($this->settings['settings']['columns_product_shop']) ? intval($this->settings['settings']['columns_product_shop']) : '' ),
							'attrs' => 'class="woobewoo-flat-input woobewoo-number woobewoo-width60"'
						));
						?>
				</div>
			</div>
		</div>
		<?php
			$settingValue = ( isset($this->settings['settings']['enable_ajax']) ? (int) $this->settings['settings']['enable_ajax'] : 1 );
			$hiddenStyle  = $settingValue ? '' : 'wpfHidden';
		?>
		<div class="row row-settings-block">
			<div class="settings-block-label col-xs-4 col-lg-3">
				<?php esc_html_e('Enable Ajax', 'woo-product-filter'); ?>
				<i class="fa fa-question woobewoo-tooltip" title="<?php echo esc_attr(__('This option enables Ajax search. Product filtering and displaying results in a browser will be run in the background without full page reload.', 'woo-product-filter') . ' <a href="https://woobewoo.com/documentation/enable-ajax/" target="_blank">' . __('Learn More', 'woo-product-filter') . '</a>.'); ?>"></i>
			</div>
			<div class="settings-block-values col-xs-6 col-sm-8 col-lg-9">
				<div class="settings-value settings-w100">
					<?php
						HtmlWpf::checkboxToggle('settings[enable_ajax]', array(
							'checked' => $settingValue
						));
						?>
				</div>
				<div class="settings-value settings-w100 <?php echo esc_attr($hiddenStyle); ?>" data-parent="settings[enable_ajax]">
					<div class="settings-value-label">
						<?php esc_html_e('Remove actions before filtering', 'woo-product-filter'); ?>
						<i class="fa fa-question woobewoo-tooltip" title="<?php echo esc_attr(__('Enable this option when ajax filtering does not work as expected. For example, sorting does not work. Removes filters such as posts_orderby and pre_get_posts.', 'woo-product-filter') . ' <a href="https://woobewoo.com/documentation/options-main-tab/" target="_blank">' . __('Learn More', 'woo-product-filter') . '</a>.'); ?>"></i>
					</div>
					<?php
						HtmlWpf::checkboxToggle('settings[remove_actions]', array(
							'checked' => ( isset($this->settings['settings']['remove_actions']) ? (int) $this->settings['settings']['remove_actions'] : '' )
						));
						?>
				</div>
			</div>
		</div>
		<div class="row row-settings-block <?php echo esc_attr($hiddenStyle); ?>" data-parent="settings[enable_ajax]">
			<div class="settings-block-label col-xs-4 col-lg-3">
				<?php esc_html_e('Product list / loader selector', 'woo-product-filter'); ?>
				<i class="fa fa-question woobewoo-tooltip" title="<?php echo esc_attr(__('Custom selector for loading a loader and updating the product list. The default product selector is `ul.products`. If the Filter after ajax filtering does not find the product block and cannot replace it with the filtered list of products, the page will reload. In this case, you need to specify the product block selector in this setting.', 'woo-product-filter')); ?>"></i>
			</div>
			<div class="settings-block-values col-xs-8 col-lg-9">
				<div class="settings-value">
					<?php
						HtmlWpf::input('settings[product_list_selector]', array(
							'value' => $this->getFilterSetting($this->settings['settings'], 'product_list_selector', ''),
							'attrs' => 'class="woobewoo-flat-input"'
						));
						?>
				</div>
			</div>
		</div>

		<div class="row row-settings-block <?php echo esc_attr($hiddenStyle); ?>" data-parent="settings[enable_ajax]">
			<div class="settings-block-label col-xs-4 col-lg-3">
				<?php esc_html_e('Product container selector', 'woo-product-filter'); ?>
				<i class="fa fa-question woobewoo-tooltip" title="<?php echo esc_attr(__('If there are several product shortcodes on the page, you can add a container selector that will limit the effect of this filter only inside it.', 'woo-product-filter')); ?>"></i>
			</div>
			<div class="settings-block-values col-xs-8 col-lg-9">
				<div class="settings-value">
					<?php
						HtmlWpf::input('settings[product_container_selector]', array(
							'value' => $this->getFilterSetting($this->settings['settings'], 'product_container_selector', ''),
							'attrs' => 'class="woobewoo-flat-input"'
						));
						?>
				</div>
			</div>
		</div>

		<div class="row row-settings-block <?php echo esc_attr($hiddenStyle); ?>" data-parent="settings[enable_ajax]">
			<div class="settings-block-label col-xs-4 col-lg-3">
				<?php esc_html_e('Force theme templates', 'woo-product-filter'); ?>
				<i class="fa fa-question woobewoo-tooltip" title="<?php echo esc_attr(__('If after ajax filtering there are differences in the styles of the list of products, pagination or count-block, then enable this option. Important: for correct operation, we recommend filling the Product container selector option.', 'woo-product-filter')); ?>"></i>
			</div>
			<div class="settings-block-values col-xs-8 col-lg-9">
				<div class="settings-value settings-w100">
					<?php 
						HtmlWpf::checkboxToggle('settings[force_theme_templates]', array(
							'checked' => ( isset($this->settings['settings']['force_theme_templates']) ? (int) $this->settings['settings']['force_theme_templates'] : '' )
						));
						?>
				</div>
				<?php
				$settingValue = $this->getFilterSetting( $this->settings['settings'], 'force_theme_templates', '' );
				?>
				<div class="settings-value settings-w100 <?php echo esc_attr( $settingValue ? '' : 'wpfHidden' ); ?>" data-parent="settings[force_theme_templates]" data-parent-switch="settings[force_theme_templates]">
					<div class="settings-value-label">
						<?php esc_html_e( 'Recalculate Filters', 'woo-product-filter' ); ?>
						<i class="fa fa-question woobewoo-tooltip" title="<?php echo esc_attr( __( 'This option recalculates all filters and can be slow if the product base is large', 'woo-product-filter' )); ?>"></i>
					</div>
					<?php
					HtmlWpf::checkboxToggle( 'settings[recalculate_filters]', array(
						'checked' => ( isset( $this->settings['settings']['recalculate_filters'] ) ? (int) $this->settings['settings']['recalculate_filters'] : '' )
					) );
					?>
				</div>
			</div>
		</div>
		<div class="row row-settings-block <?php echo esc_attr( $hiddenStyle ); ?>" data-parent="settings[enable_ajax]">
			<div class="settings-block-label col-xs-4 col-lg-3">
				<?php esc_html_e( 'Don\'t use shortcode settings', 'woo-product-filter' ); ?>
				<i class="fa fa-question woobewoo-tooltip" title="<?php echo esc_attr( __( 'Do not use shortcut settings on standard WooCommers pages' ) ); ?>"></i>
			</div>
			<div class="settings-block-values col-xs-8 col-lg-9">
				<div class="settings-value settings-w100">
					<?php
					HtmlWpf::checkboxToggle( 'settings[do_not_use_shortcut]', array(
						'checked' => ( isset( $this->settings['settings']['do_not_use_shortcut'] ) ? (int) $this->settings['settings']['do_not_use_shortcut'] : '' )
					) );
					?>
				</div>
			</div>
		</div>

	</div>
	<div class="col-xs-12 sub-tab-content" id="sub-tab-options-buttons">
		<div class="settings-block-title">
			<?php esc_html_e('Filter buttons', 'woo-product-filter'); ?>
		</div>
		<?php
			$settingValue = ( isset($this->settings['settings']['show_filtering_button']) ? (int) $this->settings['settings']['show_filtering_button'] : 1 );
			$hiddenStyle  = $settingValue ? '' : 'wpfHidden';
		?>
		<div class="row row-settings-block wpfTypeSwitchable">
			<div class="settings-block-label col-xs-4 col-lg-3">
				<?php esc_html_e('Filter activation type', 'woo-product-filter'); ?>
				<i class="fa fa-question woobewoo-tooltip" title="<?php echo esc_attr(__('If "Filtering button" option was selected, the "Filter" button appears at the page. It allows users to set all necessary filter parameters before starting the filtering. If "Auto filtering" option was selected, filtering starts as soon as filter elements change and the data reloads automatically.', 'woo-product-filter') . ' <a href="https://woobewoo.com/documentation/button-options/" target="_blank">' . __('Learn More', 'woo-product-filter') . '</a>.'); ?>"></i>
			</div>
			<div class="settings-block-values settings-w100 settings-w100 col-xs-8 col-lg-9">
				<div class="settings-value settings-w50">
					<?php
						HtmlWpf::selectbox('settings[show_filtering_button]', array(
							'options' => array(
								'0' => 'Auto filtering',
								'1' => 'Filtering button'
							),
							'value' => $settingValue,
							'attrs' => 'class="woobewoo-flat-input"'
						));
						?>
				</div>
				<div class="settings-value settings-w50 <?php echo esc_attr($hiddenStyle); ?>" data-select="settings[show_filtering_button]" data-select-value="1">
					<?php
						HtmlWpf::text('settings[filtering_button_word]', array(
							'value' => ( isset($this->settings['settings']['filtering_button_word']) ? $this->settings['settings']['filtering_button_word'] : esc_attr__('Filter', 'woo-product-filter') ),
							'attrs' => 'class="woobewoo-flat-input"'
						));
						?>
				</div>
				<?php
				$settingValue = ( isset( $this->settings['settings']['auto_update_filter'] ) ? (int) $this->settings['settings']['auto_update_filter'] : '' );
				?>


				<div class="settings-value settings-w50 <?php echo esc_attr( $hiddenStyle ); ?>" data-select="settings[show_filtering_button]" data-select-value="1" data-parent-switch="settings[show_filtering_button]">
					<?php esc_html_e( 'Automatically update the filter', 'woo-product-filter' ); ?>
					<i class="fa fa-question woobewoo-tooltip" title="<?php echo esc_attr( __( 'When you select one filter element, the rest of the elements will be updated based on its', 'woo-product-filter' ) ); ?>"></i>
					<?php
					HtmlWpf::checkboxToggle( 'settings[auto_update_filter]', array(
						'checked' => $settingValue
					) );
					?>
				</div>
			</div>
		</div>
		<?php
			$settingValue = ( isset($this->settings['settings']['show_clean_button']) ? (int) $this->settings['settings']['show_clean_button'] : '' );
			$hiddenStyle  = $settingValue ? '' : 'wpfHidden';
		?>
		<div class="row row-settings-block">
			<div class="settings-block-label col-xs-4 col-lg-3">
				<?php esc_html_e('Show Clear all button', 'woo-product-filter'); ?>
				<i class="fa fa-question woobewoo-tooltip" title="<?php echo esc_attr(__('If this option is enabled, the "Clear" button appears at the page. All filter presets will be removed after pressing the button.', 'woo-product-filter') . ' <a href="https://woobewoo.com/documentation/button-options/" target="_blank">' . __('Learn More', 'woo-product-filter') . '</a>.'); ?>"></i>
			</div>
			<div class="settings-block-values col-xs-8 col-lg-9">
				<div class="settings-value settings-w100">
					<?php 
						HtmlWpf::checkboxToggle('settings[show_clean_button]', array(
							'checked' => $settingValue
						));
						?>
				</div>
				<div class="settings-value settings-w100 <?php echo esc_attr($hiddenStyle); ?>" data-parent="settings[show_clean_button]">
					<?php 
						HtmlWpf::text('settings[show_clean_button_word]', array(
							'value' => ( isset($this->settings['settings']['show_clean_button_word']) ? $this->settings['settings']['show_clean_button_word'] : esc_attr__('Clear', 'woo-product-filter') ),
							'attrs' => 'class="woobewoo-flat-input"'
						));
						?>
				</div>
				<div class="settings-value settings-w100 <?php echo esc_attr($hiddenStyle); ?>" data-parent="settings[show_clean_button]">
					<div class="settings-value-label"><?php esc_html_e('Reset all filters on page', 'woo-product-filter'); ?></div>
					<?php
						HtmlWpf::checkboxToggle('settings[reset_all_filters]', array(
							'checked' => ( isset($this->settings['settings']['reset_all_filters']) ? (int) $this->settings['settings']['reset_all_filters'] : '' )
						));
						?>
				</div>
			</div>
		</div>
		<div class="row row-settings-block">
			<div class="settings-block-label col-xs-4 col-lg-3 pr-0">
				<?php esc_html_e('Select Filter Buttons Position', 'woo-product-filter'); ?>
				<i class="fa fa-question woobewoo-tooltip" title="<?php echo esc_attr(__('Select the position of filter buttons on the page.', 'woo-product-filter') . ' <a href="https://woobewoo.com/documentation/button-options/" target="_blank">' . __('Learn More', 'woo-product-filter') . '</a>.'); ?>"></i>
			</div>
			<div class="settings-block-values settings-w100 col-xs-8 col-lg-9">
				<div class="settings-value settings-w100">
					<?php 
						HtmlWpf::selectbox('settings[main_buttons_position]', array(
							'options' => array('top' => 'Top', 'bottom' => 'Bottom', 'both' => 'Both'),
							'value' => ( isset($this->settings['settings']['main_buttons_position']) ? $this->settings['settings']['main_buttons_position'] : 'bottom' ),
							'attrs' => 'class="woobewoo-flat-input"'
						));
						?>
				</div>
			</div>
		</div>
		<div class="row row-settings-block">
			<div class="settings-block-label col-xs-4 col-lg-3 pr-0">
				<?php esc_html_e('Select Filter Buttons Order', 'woo-product-filter'); ?>
				<i class="fa fa-question woobewoo-tooltip" title="<?php echo esc_attr(__('Change the order of filter buttons on the page.', 'woo-product-filter') . ' <a href="https://woobewoo.com/documentation/button-options/" target="_blank">' . __('Learn More', 'woo-product-filter') . '</a>.'); ?>"></i>
			</div>
			<div class="settings-block-values settings-w100 col-xs-8 col-lg-9">
				<div class="settings-value settings-w100">
					<?php
					HtmlWpf::selectbox('settings[main_buttons_order]', array(
						'options' => array('left' => 'Filter-Clear', 'right' => 'Clear-Filter'),
						'value' => ( isset($this->settings['settings']['main_buttons_order']) ? $this->settings['settings']['main_buttons_order'] : 'left' ),
						'attrs' => 'class="woobewoo-flat-input"'
					));
					?>
				</div>
			</div>
		</div>

		<?php 
		if ($isPro) {
			DispatcherWpf::doAction('addEditTabDesign', 'partEditTabOptionsButtons', $this->settings);
		} else { 
			?>
			<div class="row row-settings-block">
				<div class="settings-block-label col-xs-4 col-lg-3">
					<?php esc_html_e('Display Hide Filters button', 'woo-product-filter'); ?>
				</div>
				<div class="settings-block-values col-xs-8 col-lg-9">
					<span class="settings-value wpfProLabel"><?php esc_html_e('PRO option', 'woo-product-filter'); ?></span>
				</div>
			</div>
		<?php } ?>
	</div>
	<div class="col-xs-12 sub-tab-content" id="sub-tab-options-content">
		<div class="settings-block-title">
			<?php esc_html_e('Filter content', 'woo-product-filter'); ?>
		</div>
		<div class="row row-settings-block">
			<div class="settings-block-label col-xs-4 col-lg-3">
				<?php esc_html_e('Always filtering by all products', 'woo-product-filter'); ?>
				<i class="fa fa-question woobewoo-tooltip" title="<?php echo esc_attr(__('Search for a filtering results among all shop products on any shop pages.', 'woo-product-filter') . ' <a href="https://woobewoo.com/documentation/content-options/" target="_blank">' . __('Learn More', 'woo-product-filter') . '</a>.'); ?>"></i>
			</div>
			<div class="settings-block-values col-xs-6 col-sm-7 col-xl-8">
				<div class="settings-value settings-w100" data-no-preview="1">
					<?php
						HtmlWpf::checkboxToggle('settings[all_products_filtering]', array(
							'checked' => ( isset($this->settings['settings']['all_products_filtering']) ? (int) $this->settings['settings']['all_products_filtering'] : '' )
						));
						?>
				</div>
			</div>
		</div>
		<?php
			$settingValue = ( isset($this->settings['settings']['show_clean_block']) ? (int) $this->settings['settings']['show_clean_block'] : '' );
			$hiddenStyle  = $settingValue ? '' : 'wpfHidden';
		?>
		<div class="row row-settings-block">
			<div class="settings-block-label col-xs-4 col-lg-3">
				<?php esc_html_e('Show Clear block', 'woo-product-filter'); ?>
				<i class="fa fa-question woobewoo-tooltip" title="<?php echo esc_attr(__('If this option is enabled, the "< clear" links appears at the page next to the filter block titles. The presets of this filter block will be deleted after clicking on the link.', 'woo-product-filter') . ' <a href="https://woobewoo.com/documentation/content-options/" target="_blank">' . __('Learn More', 'woo-product-filter') . '</a>.'); ?>"></i>
			</div>
			<div class="settings-block-values col-xs-8 col-lg-9">
				<div class="settings-value settings-w100">
					<?php 
						HtmlWpf::checkboxToggle('settings[show_clean_block]', array(
							'checked' => $settingValue
						));
						?>
				</div>
				<div class="settings-value settings-w100 <?php echo esc_attr($hiddenStyle); ?>" data-parent="settings[show_clean_block]">
					<?php 
						HtmlWpf::text('settings[show_clean_block_word]', array(
							'value' => ( isset($this->settings['settings']['show_clean_block_word']) ? $this->settings['settings']['show_clean_block_word'] : esc_attr__('clear', 'woo-product-filter') ),
							'attrs' => 'class="woobewoo-flat-input"'
						));
						?>
				</div>
			</div>
		</div>
		<div class="row row-settings-block">
			<div class="settings-block-label col-xs-4 col-lg-3">
				<?php esc_html_e('Recount products by selected filter', 'woo-product-filter'); ?>
				<i class="fa fa-question woobewoo-tooltip" title="<?php echo esc_attr(__('Automatically recount product by selected filters (If product category loading slowly - Disable this function).', 'woo-product-filter') . ' <a href="https://woobewoo.com/documentation/content-options/" target="_blank">' . __('Learn More', 'woo-product-filter') . '</a>.'); ?>"></i>
			</div>
			<div class="settings-block-values col-xs-8 col-lg-9">
				<div class="settings-value settings-w100" data-no-preview="1">
					<?php 
						HtmlWpf::checkboxToggle('settings[filter_recount]', array(
							'checked' => ( isset($this->settings['settings']['filter_recount']) ? (int) $this->settings['settings']['filter_recount'] : '' )
						));
						?>
				</div>
			</div>
		</div>
		<div class="row row-settings-block">
			<div class="settings-block-label col-xs-4 col-lg-3">
				<?php esc_html_e('Recount min/max price by selected filter', 'woo-product-filter'); ?>
				<i class="fa fa-question woobewoo-tooltip" title="<?php echo esc_attr(__('Automatically change min/max price by selected filters (If product category loading slowly - Disable this function).', 'woo-product-filter') . ' <a href="https://woobewoo.com/documentation/content-options/" target="_blank">' . __('Learn More', 'woo-product-filter') . '</a>.'); ?>"></i>
			</div>
			<div class="settings-block-values col-xs-8 col-lg-9">
				<div class="settings-value settings-w100" data-no-preview="1">
					<?php
					HtmlWpf::checkboxToggle('settings[filter_recount_price]', array(
						'checked' => ( isset($this->settings['settings']['filter_recount_price']) ? (int) $this->settings['settings']['filter_recount_price'] : '' )
					));
					?>
				</div>
			</div>
		</div>
		<div class="row row-settings-block">
			<div class="settings-block-label col-xs-4 col-lg-3">
				<?php esc_html_e('Show parameters without products as disabled', 'woo-product-filter'); ?>
				<i class="fa fa-question woobewoo-tooltip" title="<?php echo esc_attr(__('Automatically disabled parameters without products. Works only when options Show count and Always display all... are enabled.', 'woo-product-filter') . ' <a href="https://woobewoo.com/documentation/content-options/" target="_blank">' . __('Learn More', 'woo-product-filter') . '</a>.'); ?>"></i>
			</div>
			<div class="settings-block-values col-xs-8 col-lg-9">
				<div class="settings-value settings-w100">
					<?php 
						HtmlWpf::checkboxToggle('settings[filter_null_disabled]', array(
							'checked' => ( isset($this->settings['settings']['filter_null_disabled']) ? (int) $this->settings['settings']['filter_null_disabled'] : '' )
						));
						?>
				</div>
			</div>
		</div>
		<div class="row row-settings-block">
			<div class="settings-block-label col-xs-4 col-lg-3">
				<?php esc_html_e('Sort by title after filtering', 'woo-product-filter'); ?>
				<i class="fa fa-question woobewoo-tooltip" title="<?php echo esc_attr__('This option disables any other sorting on the page.', 'woo-product-filter'); ?>"></i>
			</div>
			<div class="settings-block-values col-xs-8 col-lg-9">
				<div class="settings-value settings-w100" data-no-preview="1">
					<?php 
						HtmlWpf::checkboxToggle('settings[sort_by_title]', array(
							'checked' => ( isset($this->settings['settings']['sort_by_title']) ? (int) $this->settings['settings']['sort_by_title'] : '' )
						));
						?>
				</div>
			</div>
		</div>
		<div class="row row-settings-block">
			<div class="settings-block-label col-xs-4 col-lg-3">
				<?php esc_html_e('Checked items to the top', 'woo-product-filter'); ?>
				<i class="fa fa-question woobewoo-tooltip" title="<?php echo esc_attr(__('Lets checked terms will be on the top.', 'woo-product-filter') . ' <a href="https://woobewoo.com/documentation/content-options/" target="_blank">' . __('Learn More', 'woo-product-filter') . '</a>.'); ?>"></i>
			</div>
			<div class="settings-block-values col-xs-8 col-lg-9">
				<div class="settings-value settings-w100">
					<?php 
						HtmlWpf::checkboxToggle('settings[checked_items_top]', array(
							'checked' => ( isset($this->settings['settings']['checked_items_top']) ? (int) $this->settings['settings']['checked_items_top'] : '' )
						));
						?>
				</div>
			</div>
		</div>
		<div class="row row-settings-block">
			<div class="settings-block-label col-xs-4 col-lg-3">
				<?php esc_html_e('Set no products found text', 'woo-product-filter'); ?>
				<i class="fa fa-question woobewoo-tooltip" title="<?php echo esc_attr(__('Input "no products found" text for category.', 'woo-product-filter') . ' <a href="https://woobewoo.com/documentation/content-options/" target="_blank">' . __('Learn More', 'woo-product-filter') . '</a>.'); ?>"></i>
			</div>
			<div class="settings-block-values settings-w100 col-xs-8 col-lg-9">
				<div class="settings-value settings-w100" data-no-preview="1">
					<?php 
						HtmlWpf::text('settings[text_no_products]', array(
							'value' => ( isset($this->settings['settings']['text_no_products']) ? $this->settings['settings']['text_no_products'] : 'No products found' ),
							'attrs' => 'class="woobewoo-flat-input"'
						));
						?>
				</div>
			</div>
		</div>
		<?php 
		if (FrameWpf::_()->proVersionCompare('1.4.8')) {
			$settingValue = ( isset($this->settings['settings']['filtering_by_variations']) ? (int) $this->settings['settings']['filtering_by_variations'] : '' );
			$hiddenStyle  = $settingValue ? '' : 'wpfHidden';
			?>
			<div class="row row-settings-block">
				<div class="settings-block-label col-xs-4 col-sm-3">
					<?php esc_html_e('Filtering by variations attributes', 'woo-product-filter'); ?>
					<i class="fa fa-question woobewoo-tooltip" title="<?php echo esc_attr__('After filtration will be display products with variations, what have filtered attributes', 'woo-product-filter'); ?>"></i>
				</div>
				<div class="settings-block-values settings-values-w100 col-xs-8 col-sm-9">
					<div class="settings-value settings-w100">
						<?php
						HtmlWpf::checkboxToggle('settings[filtering_by_variations]', array(
							'checked' => $settingValue
						));
						?>
					</div>
					<?php if ($isPro) {	?>
						<div class="settings-value settings-w100 <?php echo esc_attr($hiddenStyle); ?>"  data-parent="settings[filtering_by_variations]">
							<div class="settings-value-label">
								<?php esc_html_e('Display variations instead of variable product', 'woo-product-filter'); ?>
								<i class="fa fa-question woobewoo-tooltip" title="<?php echo esc_attr__('After filtration by attributes will be displayed product variation instead of main variable product', 'woo-product-filter'); ?>"></i>
							</div>
							<?php
							HtmlWpf::checkboxToggle('settings[display_product_variations]', array(
								'checked' => ( isset($this->settings['settings']['display_product_variations']) ? (int) $this->settings['settings']['display_product_variations'] : '' )
							));
							?>
						</div>
					<?php } ?>
				</div>
			</div>
			<?php 
		}
		if ($isPro) {
			DispatcherWpf::doAction('addEditTabDesign', 'partEditTabOptionsContent', $this->settings, $this->filter['id']);
		} else { 
			?>
			<div class="row row-settings-block">
				<div class="settings-block-label col-xs-4 col-lg-3">
					<?php esc_html_e('Display "Show more"', 'woo-product-filter'); ?>
					<i class="fa fa-question woobewoo-tooltip" title="<?php echo esc_attr(__('For long vertical lists, "Show more" will be displayed.', 'woo-product-filter') . ' <a href="https://woobewoo.com/documentation/content-options/" target="_blank">' . __('Learn More', 'woo-product-filter') . '</a>.'); ?>"></i>
				</div>
				<div class="settings-block-values col-xs-8 col-lg-9">
					<span class="settings-value wpfProLabel"><?php esc_html_e('PRO option', 'woo-product-filter'); ?></span>
				</div>
			</div>
			<div class="row row-settings-block">
				<div class="settings-block-label col-xs-4 col-lg-3">
					<?php esc_html_e('Display selected parameters of filters', 'woo-product-filter'); ?>
					<i class="fa fa-question woobewoo-tooltip" title="<?php echo esc_attr('<div class="woobewoo-tooltips-wrapper"><div class="woobewoo-tooltips-text">' . __('Selected parameters will be displayed in the top/bottom of the filter .', 'woo-product-filter') . '</div><img src="' . esc_url($this->getModule()->getModPath() . 'img/display_selected_parameters_of_filters.png') . '" height="193"></div>'); ?>"></i>
				</div>
				<div class="settings-block-values col-xs-8 col-lg-9">
					<span class="settings-value wpfProLabel"><?php esc_html_e('PRO option', 'woo-product-filter'); ?></span>
				</div>
			</div>
			<div class="row row-settings-block">
				<div class="settings-block-label col-xs-4 col-lg-3">
					<?php esc_html_e( 'If one filter block is open, other blocks are closed', 'woo-product-filter' ); ?>
					<i class="fa fa-question woobewoo-tooltip" title="<?php echo esc_attr( __( 'When you click on the block open icon, all other open blocks will be automatically closed', 'woo-product-filter' ) . ' <a href="https://woobewoo.com/documentation/content-options/" target="_blank">' . __( 'Learn More', 'woo-product-filter' ) . '</a>.' ); ?>"></i>
				</div>
				<div class="settings-block-values col-xs-8 col-lg-9">
					<span class="settings-value wpfProLabel"><?php esc_html_e( 'PRO option', 'woo-product-filter' ); ?></span>
				</div>
			</div>
			<div class="row row-settings-block">
				<div class="settings-block-label col-xs-4 col-lg-3">
					<?php esc_html_e('Show category slugs in URL instead of IDs ', 'woo-product-filter'); ?>
					<i class="fa fa-question woobewoo-tooltip" title="<?php echo esc_attr(__('Turn on only when necessary. Please note that "slug" should only contain lowercase Latin letters, numbers and hyphens.', 'woo-product-filter') . ' <a href="https://woobewoo.com/documentation/content-options/" target="_blank">' . __('Learn More', 'woo-product-filter') . '</a>.'); ?>"></i>
				</div>
				<div class="settings-block-values col-xs-8 col-lg-9">
					<span class="settings-value wpfProLabel"><?php esc_html_e( 'PRO option', 'woo-product-filter' ); ?></span>
				</div>
			</div>
		<?php } ?>
		<div class="row row-settings-block">
			<div class="settings-block-label col-xs-4 col-lg-3">
				<?php esc_html_e('Hide filter by title click', 'woo-product-filter'); ?>
				<i class="fa fa-question woobewoo-tooltip" title="<?php echo esc_attr(__('Be careful when deactivate it with filter titles shown as close, In such case users do not see filter content.', 'woo-product-filter') . ' <a href="https://woobewoo.com/documentation/content-options/" target="_blank">' . __('Learn More', 'woo-product-filter') . '</a>.'); ?>"></i>
			</div>
			<div class="settings-block-values col-xs-8 col-lg-9">
				<div class="settings-value settings-w100">
					<?php 
						HtmlWpf::checkboxToggle('settings[hide_filter_icon]', array(
							'checked' => ( isset($this->settings['settings']['hide_filter_icon']) ? (int) $this->settings['settings']['hide_filter_icon'] : 1 )
						));
						?>
				</div>
			</div>
		</div>
		<div class="row row-settings-block">
			<div class="settings-block-label col-xs-4 col-lg-3">
				<?php esc_html_e('Use filter titles as slugs for the filter clear buttons', 'woo-product-filter'); ?>
			</div>
			<div class="settings-block-values col-xs-8 col-lg-9">
				<div class="settings-value settings-w100">
					<?php 
						HtmlWpf::checkboxToggle('settings[use_title_as_slug]', array(
							'checked' => ( isset($this->settings['settings']['use_title_as_slug']) ? (int) $this->settings['settings']['use_title_as_slug'] : 0 )
						));
						?>
				</div>
			</div>
		</div>
		<div class="row row-settings-block">
			<div class="settings-block-label col-xs-4 col-lg-3">
				<?php esc_html_e('Filtering of categories list', 'woo-product-filter'); ?>
				<i class="fa fa-question woobewoo-tooltip" title="<?php echo esc_attr(__('Filtering of categories list on filter process.', 'woo-product-filter') . ' <a href="https://woobewoo.com/documentation/content-options/" target="_blank">' . __('Learn More', 'woo-product-filter') . '</a>.'); ?>"></i>
			</div>
			<div class="settings-block-values col-xs-8 col-lg-9">
				<div class="settings-value settings-w100">
					<?php
					HtmlWpf::checkboxToggle('settings[use_category_filtration]', array(
						'checked' => ( isset($this->settings['settings']['use_category_filtration']) ? (int) $this->settings['settings']['use_category_filtration'] : 1 )
					));
					?>
				</div>
			</div>
		</div>
		<div class="row row-settings-block">
			<div class="settings-block-label col-xs-4 col-lg-3">
				<?php esc_html_e('Apply parameters from the address bar to display filter items', 'woo-product-filter'); ?>
				<i class="fa fa-question woobewoo-tooltip" title="<?php echo esc_attr(__('ATTENTION!!! This option can greatly slow down page loading if you have a lot of products.')); ?>"></i>
			</div>
			<div class="settings-block-values col-xs-8 col-lg-9">
				<div class="settings-value settings-w100">
					<?php
					HtmlWpf::checkboxToggle('settings[check_get_names]', array(
						'checked' => $this->getFilterSetting($this->settings['settings'], 'check_get_names', 0),
					));
					?>
				</div>
			</div>
		</div>
		<div class="row row-settings-block">
			<div class="settings-block-label col-xs-4 col-lg-3">
				<?php esc_html_e('Multiblock taxonomy logic', 'woo-product-filter'); ?>
				<i class="fa fa-question woobewoo-tooltip" title="<?php echo esc_attr(__('Filter products by different filter blocks of categories / tags / attributes by logic and / or.', 'woo-product-filter') . ' <a href="https://woobewoo.com/documentation/content-options/" target="_blank">' . __('Learn More', 'woo-product-filter') . '</a>.'); ?>"></i>
			</div>
			<div class="settings-block-values col-xs-8 col-lg-9">
				<div class="settings-value settings-w100">
					<?php
						HtmlWpf::selectbox('settings[f_multi_logic]', array(
							'options' => array('or' => esc_attr__('Or', 'woo-product-filter'), 'and' => esc_attr__('And', 'woo-product-filter')),
							'value' => ( isset($this->settings['settings']['f_multi_logic']) ? $this->settings['settings']['f_multi_logic'] : 'and' ),
							'attrs' => 'class="woobewoo-flat-input"'
						));
						?>
				</div>
			</div>
		</div>
	</div>
	<div class="col-xs-12 sub-tab-content" id="sub-tab-options-loader" data-no-preview="1">
		<div class="settings-block-title">
			<?php esc_html_e('Filter loader', 'woo-product-filter'); ?>
		</div>
		<div class="row row-settings-block">
			<div class="settings-block-label col-xs-4 col-lg-3">
				<?php esc_html_e('Enable filter icon on load', 'woo-product-filter'); ?>
				<i class="fa fa-question woobewoo-tooltip" title="<?php echo esc_attr(__('Enable filter icon while filtering results are loading.', 'woo-product-filter') . ' <a href="https://woobewoo.com/documentation/loader-options/" target="_blank">' . __('Learn More', 'woo-product-filter') . '</a>.'); ?>"></i>
			</div>
			<div class="settings-block-values col-xs-8 col-lg-9">
				<div class="settings-value settings-w100">
					<?php 
						HtmlWpf::checkboxToggle('settings[filter_loader_icon_onload_enable]', array(
							'checked' => ( isset($this->settings['settings']['filter_loader_icon_onload_enable']) ? (int) $this->settings['settings']['filter_loader_icon_onload_enable'] : 1 ),
							'attrs' => ' data-loader-settings="1"'
						));
						if ($isPro) {
							echo '</div><div class="settings-value"><div class="button button-mini woobewoo-tooltip applyLoaderIcon" title="' . esc_attr__('Apply loader settings to all filters.', 'woo-product-filter') . '"><i class="fa fa-share"></i></div>';
						}
						?>
				</div>
			</div>
		</div>
		<?php
		$iconName   = ( isset($this->settings['settings']['filter_loader_icon_name']) ? $this->settings['settings']['filter_loader_icon_name'] : 'default' );
		$iconNumber = ( isset($this->settings['settings']['filter_loader_icon_number']) ? $this->settings['settings']['filter_loader_icon_number'] : '0' );
		if (!$isPro) {
			$iconName = 'default';
		}
		if ('custom' === $iconName) {
			$htmlPreview = '<div class="woobewoo-filter-loader wpfCustomLoader"></div>';
		} elseif ('default' === $iconName || 'spinner' === $iconName) {
			$htmlPreview = '<div class="woobewoo-filter-loader spinner"></div>';
		} else {
			$htmlPreview = '<div class="woobewoo-filter-loader la-' . $iconName . ' la-2x">';
			for ($i = 1; $i <= $iconNumber; $i++) {
				$htmlPreview .= '<div></div>';
			}
			$htmlPreview .= '</div>';
		}
		?>
		<div class="row row-settings-block wpfLoader">
			<div class="settings-block-label col-xs-4 col-lg-3">
				<?php esc_html_e('Filter Loader Icon', 'woo-product-filter'); ?>
				<sup class="wpfProOption"><a href="<?php echo esc_url($this->proLink . '?utm_source=plugin&utm_medium=loader-logo&utm_campaign=woocommerce-filter'); ?>" tartget="_blank"><?php esc_html_e('PRO', 'woo-product-filter'); ?></a></sup>
				<i class="fa fa-question woobewoo-tooltip" title="<?php echo esc_attr__('Select the animated loader, which appears when filtering results are loading <a href="https://woobewoo.com/documentation/loader-options/" target="_blank">Learn More</a>.', 'woo-product-filter'); ?>"></i>
			</div>
			<div class="settings-block-values settings-w100 col-xs-8 col-lg-9">
				<div class="settings-value settings-w50">
					<div class="button button-mini chooseLoaderIcon"><?php esc_html_e('Choose Icon', 'woo-product-filter'); ?></div>
				</div>
				<div class="settings-value settings-w50">
					<?php 
						HtmlWpf::colorpicker('settings[filter_loader_icon_color]', array(
							'value' => ( isset($this->settings['settings']['filter_loader_icon_color']) ? $this->settings['settings']['filter_loader_icon_color'] : '#000000' ),
							'attrs' => 'data-loader-settings="1"'
						));
						?>
				</div>
				<?php 
				if ($isPro) {
					DispatcherWpf::doAction('addEditTabDesign', 'partEditTabOptionsLoader', $this->settings);
				}
				?>
				<div class="clear"></div>
				<div class="settings-value wpfIconPreview">
					<?php HtmlWpf::echoEscapedHtml($htmlPreview); ?>
				</div>
				<?php 
					HtmlWpf::hidden('settings[filter_loader_icon_name]', array(
						'value' => ( isset($this->settings['settings']['filter_loader_icon_name']) ? $this->settings['settings']['filter_loader_icon_name'] : 'default' ),
						'attrs' => ' data-loader-settings="1"'
					));
					HtmlWpf::hidden('settings[filter_loader_icon_number]', array(
						'value' => ( isset($this->settings['settings']['filter_loader_icon_number']) ? $this->settings['settings']['filter_loader_icon_number'] : '0' ),
						'attrs' => ' data-loader-settings="1"'
					));
					?>
			</div>
		</div>
		<?php
			$settingValue     = ( isset($this->settings['settings']['enable_overlay']) ? (int) $this->settings['settings']['enable_overlay'] : '' );
			$settingWordValue = ( isset($this->settings['settings']['enable_overlay_word']) ? (int) $this->settings['settings']['enable_overlay_word'] : '' );
			$hiddenStyle      = $settingValue ? '' : 'wpfHidden';
			$hiddenWordStyle  = $settingValue && $settingWordValue ? '' : 'wpfHidden';
		?>
		<div class="row row-settings-block">
			<div class="settings-block-label col-xs-4 col-lg-3">
				<?php esc_html_e('Enable overlay', 'woo-product-filter'); ?>
				<i class="fa fa-question woobewoo-tooltip" title="<?php echo esc_attr__('Enable overlay.', 'woo-product-filter'); ?>"></i>
			</div>
			<div class="settings-block-values col-xs-8 col-lg-9">
				<div class="settings-value settings-w100">
					<?php 
						HtmlWpf::checkboxToggle('settings[enable_overlay]', array(
							'checked' => $settingValue,
							'attrs' => ' data-loader-settings="1"'
						));
						?>
				</div>
				<div class="settings-value <?php echo esc_attr($hiddenStyle); ?>" data-parent="settings[enable_overlay]">
					<?php 
						HtmlWpf::colorpicker('settings[overlay_background]', array(
							'value' => ( isset($this->settings['settings']['overlay_background']) ? $this->settings['settings']['overlay_background'] : 'black' ),
							'attrs' => 'data-loader-settings="1"',
						));
						?>
				</div>
				<div class="clear"></div>
				<div class="settings-value <?php echo esc_attr($hiddenStyle); ?>" data-parent="settings[enable_overlay]">
					<div class="settings-value-label woobewoo-width100">
						<?php esc_html_e('loader icon', 'woo-product-filter'); ?>
					</div>
					<?php 
						HtmlWpf::checkboxToggle('settings[enable_overlay_icon]', array(
							'checked' => ( isset($this->settings['settings']['enable_overlay_icon']) ? (int) $this->settings['settings']['enable_overlay_icon'] : '' ),
							'attrs' => 'data-loader-settings="1"'
						));
						?>
				</div>
				<div class="clear"></div>
				<div class="settings-value <?php echo esc_attr($hiddenStyle); ?>" data-parent="settings[enable_overlay]">
					<div class="settings-value-label woobewoo-width100">
						<?php esc_html_e('loader word', 'woo-product-filter'); ?>
					</div>
					<?php 
						HtmlWpf::checkboxToggle('settings[enable_overlay_word]', array(
							'checked' => $settingWordValue,
							'attrs' => 'data-loader-settings="1"'
						));
						?>
				</div>
				<div class="settings-value <?php echo esc_attr($hiddenWordStyle); ?>" data-parent="settings[enable_overlay_word]">
					<?php 
						HtmlWpf::text('settings[overlay_word]', array(
							'value' => ( isset($this->settings['settings']['overlay_word']) ? $this->settings['settings']['overlay_word'] : 'WooBeWoo' ),
							'attrs' => 'data-loader-settings="1" class="woobewoo-flat-input"'
						));
						?>
				</div>
			</div>
		</div>		
	</div>
	<div class="wpfLoaderIconTemplate wpfHidden">
		<?php
			$loaderSkins = array(
				'timer' => 1, //number means count of div necessary to display loader
				'ball-beat' => 3,
				'ball-circus' => 5,
				'ball-atom' => 4,
				'ball-spin-clockwise-fade-rotating' => 8,
				'line-scale' => 5,
				'ball-climbing-dot' => 4,
				'square-jelly-box' => 2,
				'ball-rotate' => 1,
				'ball-clip-rotate-multiple' => 2,
				'cube-transition' => 2,
				'square-loader' => 1,
				'ball-8bits' => 16,
				'ball-newton-cradle' => 4,
				'ball-pulse-rise' => 5,
				'triangle-skew-spin' => 1,
				'fire' => 3,
				'ball-zig-zag-deflect' => 2
			);
			?>
		<div class="items items-list">
			<div class="item">
				<div class="item-inner">
					<div class="item-loader-container">
						<div class="preicon_img" data-name="spinner" data-items="0">
							<div class="woobewoo-filter-loader spinner"></div>
						</div>
					</div>
				</div>
				<div class="item-title">woobewoo</div>
			</div>
			<?php
			foreach ($loaderSkins as $name => $number) {
				?>
					<div class="item">
						<div class="item-inner">
							<div class="item-loader-container">
								<div class="woobewoo-filter-loader la-<?php echo esc_attr($name); ?> la-2x preicon_img" data-name="<?php echo esc_attr($name); ?>" data-items="<?php echo esc_attr($number); ?>">
								<?php
								for ($i = 0; $i < $number; $i++) {
									echo '<div></div>';
								}
								?>
								</div>
							</div>
						</div>
						<div class="item-title"><?php echo esc_html($name); ?></div>
					</div>
			<?php }	?>
		</div>
	</div>
</div>

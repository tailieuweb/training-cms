<style>
#wpfMailSettingsForm .form-table {max-width: 450px;}
</style>
<form id="wpfMailTestForm">
	<label>
		<?php esc_html_e('Send test email to'); ?>
		<?php HtmlWpf::text('test_email', array('value' => $this->testEmail)); ?>
	</label>
	<?php HtmlWpf::hidden('mod', array('value' => 'mail')); ?>
	<?php HtmlWpf::hidden('action', array('value' => 'testEmail')); ?>
	<button class="button button-primary">
		<i class="fa fa-paper-plane"></i>
		<?php esc_html_e('Send test', 'woo-product-filter'); ?>
	</button><br />
	<i><?php esc_html_e('This option allows you to check your server mail functionality', 'woo-product-filter'); ?></i>
</form>
<div id="wpfMailTestResShell" class="wpfHidden">
	<?php esc_html_e('Did you receive test email?', 'woo-product-filter'); ?><br />
	<button class="wpfMailTestResBtn button button-primary" data-res="1">
		<i class="fa fa-check-square-o"></i>
		<?php esc_html_e('Yes! It works!', 'woo-product-filter'); ?>
	</button>
	<button class="wpfMailTestResBtn button button-primary" data-res="0">
		<i class="fa fa-exclamation-triangle"></i>
		<?php esc_html_e('No, I need to contact my hosting provider with mail function issue.', 'woo-product-filter'); ?>
	</button>
</div>
<div id="wpfMailTestResSuccess" class="wpfHidden">
	<?php esc_html_e('Great! Mail function was tested and is working fine.', 'woo-product-filter'); ?>
</div>
<div id="wpfMailTestResFail" class="wpfHidden">
	<?php esc_html_e('Bad, please contact your hosting provider and ask them to setup mail functionality on your server.', 'woo-product-filter'); ?>
</div>
<div class="woobewoo-clear"></div>
<form id="wpfMailSettingsForm">
	<table class="form-table">
		<?php foreach ($this->options as $optKey => $opt) { ?>
			<?php
			$htmlType = isset($opt['html']) ? $opt['html'] : false;
			if (empty($htmlType)) {
				continue;
			}
			?>
			<tr>
				<th scope="row" class="col-w-30perc">
					<?php echo esc_html($opt['label']); ?>
					<?php if (!empty($opt['changed_on'])) { ?>
						<br />
						<span class="description">
							<?php 
							if ($opt['value']) {
								/* translators: %s: label */
								echo esc_html(sprintf(__('Turned On %s', 'woo-product-filter'), DateWpf::_($opt['changed_on'])));
							} else {
								/* translators: %s: label */
								echo esc_html(sprintf(__('Turned Off %s', 'woo-product-filter'), DateWpf::_($opt['changed_on'])));
							}
							?>
						</span>
					<?php } ?>
				</th>
				<td class="col-w-10perc">
					<i class="fa fa-question woobewoo-tooltip" title="<?php echo esc_attr($opt['desc']); ?>"></i>
				</td>
				<td class="col-w-1perc">
					<?php HtmlWpf::$htmlType('opt_values[' . $optKey . ']', array('value' => $opt['value'], 'attrs' => 'data-optkey="' . $optKey . '"')); ?>
				</td>
				<td class="col-w-50perc">
					<div id="wpfFormOptDetails_<?php echo esc_attr($optKey); ?>" class="wpfOptDetailsShell"></div>
				</td>
			</tr>
		<?php } ?>
	</table>
	<?php HtmlWpf::hidden('mod', array('value' => 'mail')); ?>
	<?php HtmlWpf::hidden('action', array('value' => 'saveOptions')); ?>
	<button class="button button-primary">
		<i class="fa fa-fw fa-save"></i>
		<?php esc_html_e('Save', 'woo-product-filter'); ?>
	</button>
</form>

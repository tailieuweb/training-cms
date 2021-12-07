<style type="text/css">
.woobewoo-main {
	display:none;
}
.woobewoo-plugin-loader {
	width: 100%;
	height: 100px;
	text-align: center;
}
.woobewoo-plugin-loader div {
	font-size: 30px;
	position: relation;
	margin-top: 40px;
}
</style>
<div class="wrap woobewoo-wrap">
	<div class="woobewoo-plugin woobewoo-main">
		<section class="woobewoo-content">
			<nav class="woobewoo-navigation woobewoo-sticky <?php DispatcherWpf::doAction('adminMainNavClassAdd'); ?>">
				<ul>
					<?php foreach ($this->tabs as $tabKey => $t) { ?>
						<?php 
						if (isset($t['hidden']) && $t['hidden']) {
							continue;
						}
						?>
						<li class="woobewoo-tab-<?php echo esc_attr($tabKey); ?> <?php echo ( ( $this->activeTab == $tabKey || in_array($tabKey, $this->activeParentTabs) ) ? 'active' : '' ); ?>">
							<a href="<?php echo esc_url($t['url']); ?>" title="<?php echo esc_attr($t['label']); ?>">
								<?php if (isset($t['fa_icon'])) { ?>
									<i class="fa <?php echo esc_attr($t['fa_icon']); ?>"></i>
								<?php } elseif (isset($t['wp_icon'])) { ?>
									<i class="dashicons-before <?php echo esc_attr($t['wp_icon']); ?>"></i>
								<?php } elseif (isset($t['icon'])) { ?>
									<i class="<?php echo esc_attr($t['icon']); ?>"></i>
								<?php } ?>
								<span class="sup-tab-label"><?php echo esc_html($t['label']); ?></span>
							</a>
						</li>
					<?php } ?>
				</ul>
			</nav>
			<div class="woobewoo-container woobewoo-<?php echo esc_attr($this->activeTab); ?>">
				<?php HtmlWpf::echoEscapedHtml($this->breadcrumbs); ?>
				<?php HtmlWpf::echoEscapedHtml($this->content); ?>
				<div class="clear"></div>
			</div>
		</section>
		<div id="wpfAddDialog" class="woobewoo-plugin woobewoo-hidden" title="<?php echo esc_attr__('Enter product filter name', 'woo-product-filter'); ?>">
			<div>
				<form id="tableForm">
					<input id="addDialog_title" class="woobewoo-text woobewoo-width-full" type="text"/>
					<input type="hidden" id="addDialog_duplicateid" class="woobewoo-text woobewoo-width-full"/>
				</form>
				<div id="formError" class="woobewoo-hidden">
					<p></p>
				</div>
			</div>
		</div>
	</div>
	<div class="woobewoo-plugin-loader">
		<div>Loading...<i class="fa fa-spinner fa-spin"></i></div>
	</div>
</div>

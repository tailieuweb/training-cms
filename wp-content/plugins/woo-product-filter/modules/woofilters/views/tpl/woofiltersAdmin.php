<section>
	<div class="woobewoo-item woobewoo-panel">
		<div id="containerWrapper">
			<ul id="wpfTableTblNavBtnsShell" class="woobewoo-bar-controls">
				<li title="<?php echo esc_attr__('Delete selected', 'woo-product-filter'); ?>">
					<button class="button button-small" id="wpfTableRemoveGroupBtn" disabled data-toolbar-button>
						<i class="fa fa-fw fa-trash-o"></i>
						<?php esc_html_e('Delete selected', 'woo-product-filter'); ?>
					</button>
				</li>
				<li title="<?php echo esc_attr__('Search', 'woo-product-filter'); ?>">
					<input id="wpfTableTblSearchTxt" type="text" name="tbl_search" placeholder="<?php echo esc_attr__('Search', 'woo-product-filter'); ?>">
				</li>
			</ul>
			<div id="wpfTableTblNavShell" class="woobewoo-tbl-pagination-shell"></div>
			<div class="woobewoo-clear"></div>
			<hr />
			<table id="wpfTableTbl"></table>
			<div id="wpfTableTblNav"></div>
			<div id="wpfTableTblEmptyMsg" class="woobewoo-hidden">
				<h3><?php echo esc_html__('You have no Filters for now.', 'woo-product-filter') . ' <a href="' . esc_url($this->addNewLink) . '">' . esc_html__('Create', 'woo-product-filter') . '</a> ' . esc_html__('your Filter', 'woo-product-filter') . '!'; ?></h3>
			</div>
		</div>
		<div class="woobewoo-clear"></div>
	</div>
</section>

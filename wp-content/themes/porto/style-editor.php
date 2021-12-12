<?php
/**
 * Porto: Gutenberg Editor Style
 *
 * @package porto
 * @since 5.0
 */

global $porto_settings;
$porto_settings_backup = $porto_settings;
$b                     = porto_check_theme_options();
$porto_settings        = $porto_settings_backup;
$porto_is_dark         = ( 'dark' == $b['css-type'] );
$dark                  = $porto_is_dark;

if ( is_rtl() ) {
	$left_escaped  = 'right';
	$right_escaped = 'left';
	$rtl_escaped   = true;
} else {
	$left_escaped  = 'left';
	$right_escaped = 'right';
	$rtl_escaped   = false;
}

if ( $dark ) {
	$color_dark = $b['color-dark'];
} else {
	$color_dark = $b['dark-color'];
}

$skin_color = $b['skin-color'];

require_once( PORTO_LIB . '/lib/color-lib.php' );
$porto_color_lib = PortoColorLib::getInstance();
?>
/* Generals */
body .editor-styles-wrapper {
	font-family: <?php echo sanitize_text_field( $b['body-font']['font-family'] ); ?>, sans-serif;
	<?php if ( $b['body-font']['font-weight'] ) : ?>
		font-weight: <?php echo esc_html( $b['body-font']['font-weight'] ); ?>;
	<?php endif; ?>
	<?php if ( $b['body-font']['font-size'] ) : ?>
		font-size: <?php echo esc_html( $b['body-font']['font-size'] ); ?>;
	<?php endif; ?>
	<?php if ( $b['body-font']['line-height'] ) : ?>
		line-height: <?php echo esc_html( $b['body-font']['line-height'] ); ?>;
	<?php endif; ?>
	<?php if ( $b['body-font']['letter-spacing'] ) : ?>
		letter-spacing: <?php echo esc_html( $b['body-font']['letter-spacing'] ); ?>;
	<?php endif; ?>
	<?php if ( $b['body-font']['color'] ) : ?>
		color: <?php echo esc_html( $b['body-font']['color'] ); ?>;
	<?php endif; ?>
	padding-left: 20px;
	padding-right: 20px;
}

body .editor-styles-wrapper h1, body .editor-styles-wrapper h2, body .editor-styles-wrapper h3, body .editor-styles-wrapper h4, body .editor-styles-wrapper h5, body .editor-styles-wrapper h6 { color: <?php echo ! $dark ? $color_dark : '#fff'; ?>; margin-top: 0; margin-bottom: 1rem }

body .editor-styles-wrapper h1 {
	<?php if ( $b['h1-font']['font-family'] ) : ?>
		font-family: <?php echo sanitize_text_field( $b['h1-font']['font-family'] ); ?>, sans-serif;
	<?php endif; ?>
	<?php if ( $b['h1-font']['font-weight'] ) : ?>
		font-weight: <?php echo esc_html( $b['h1-font']['font-weight'] ); ?>;
	<?php endif; ?>
	<?php if ( $b['h1-font']['font-size'] ) : ?>
		font-size: <?php echo esc_html( $b['h1-font']['font-size'] ); ?>;
	<?php endif; ?>
	<?php if ( $b['h1-font']['line-height'] ) : ?>
		line-height: <?php echo esc_html( $b['h1-font']['line-height'] ); ?>;
	<?php endif; ?>
	<?php if ( $b['h1-font']['letter-spacing'] ) : ?>
		letter-spacing: <?php echo esc_html( $b['h1-font']['letter-spacing'] ); ?>;
	<?php endif; ?>
	<?php if ( $b['h1-font']['color'] ) : ?>
		color: <?php echo esc_html( $b['h1-font']['color'] ); ?>;
	<?php endif; ?>
}
<?php for ( $i = 2; $i <= 6; $i++ ) { ?>
	body .editor-styles-wrapper h<?php echo (int) $i; ?> {
		<?php if ( $b[ 'h' . $i . '-font' ]['font-family'] ) : ?>
			font-family: <?php echo sanitize_text_field( $b[ 'h' . $i . '-font' ]['font-family'] ); ?>, sans-serif;
		<?php endif; ?>
		<?php if ( $b[ 'h' . $i . '-font' ]['font-weight'] ) : ?>
			font-weight: <?php echo esc_html( $b[ 'h' . $i . '-font' ]['font-weight'] ); ?>;
		<?php endif; ?>
		<?php if ( $b[ 'h' . $i . '-font' ]['font-size'] ) : ?>
			font-size: <?php echo esc_html( $b[ 'h' . $i . '-font' ]['font-size'] ); ?>;
		<?php endif; ?>
		<?php if ( $b[ 'h' . $i . '-font' ]['line-height'] ) : ?>
			line-height: <?php echo esc_html( $b[ 'h' . $i . '-font' ]['line-height'] ); ?>;
		<?php endif; ?>
		<?php if ( $b[ 'h' . $i . '-font' ]['letter-spacing'] ) : ?>
			letter-spacing: <?php echo esc_html( $b[ 'h' . $i . '-font' ]['letter-spacing'] ); ?>;
		<?php endif; ?>
		<?php if ( $b[ 'h' . $i . '-font' ]['color'] ) : ?>
			color: <?php echo esc_html( $b[ 'h' . $i . '-font' ]['color'] ); ?>;
		<?php endif; ?>
	}
<?php } ?>

body .editor-styles-wrapper p {
	font-size: 14px;
	<?php if ( ! empty( $b['paragraph-font']['font-family'] ) ) : ?>
		font-family: <?php echo sanitize_text_field( $b['paragraph-font']['font-family'] ); ?>;
	<?php endif; ?>
	<?php if ( ! empty( $b['paragraph-font']['letter-spacing'] ) ) : ?>
		letter-spacing: <?php echo esc_html( $b['paragraph-font']['letter-spacing'] ); ?>;
	<?php endif; ?>
	margin-top: 0;
	margin-bottom: 1em;
}

<?php if ( ! class_exists( 'Woocommerce' ) ) : ?>
	.editor-styles-wrapper h1, .editor-styles-wrapper h2, .editor-styles-wrapper h3, .editor-styles-wrapper h4, .editor-styles-wrapper h5, .editor-styles-wrapper h6 { letter-spacing: -0.05em; }
<?php endif; ?>

/* Layouts */
@media (min-width: <?php echo (int) ( $b['container-width'] + $b['grid-gutter-width'] ); ?>px) {
	.ccols-xl-2 > * {
		flex: 0 0 50%;
		max-width: 50%;
	}
	.ccols-xl-3 > * {
		flex: 0 0 33.3333%;
		max-width: 33.3333%;
	}
	.ccols-xl-4 > * {
		flex: 0 0 25%;
		max-width: 25%;
	}
	.ccols-xl-5 > * {
		flex: 0 0 20%;
		max-width: 20%;
	}
	.ccols-xl-6 > * {
		flex: 0 0 16.6666%;
		max-width: 16.6666%;
	}
	.ccols-xl-7 > * {
		flex: 0 0 14.2857%;
		max-width: 14.2857%;
	}
	.ccols-xl-8 > * {
		flex: 0 0 12.5%;
		max-width: 12.5%;
	}
	.ccols-xl-9 > * {
		flex: 0 0 11.1111%;
		max-width: 11.1111%;
	}
	.ccols-xl-10 > * {
		flex: 0 0 10%;
		max-width: 10%;
	}
	.shop_table.wishlist_table .add-links {
		flex-direction: row;
	}
	.shop_table.wishlist_table .quickview {
		margin-<?php echo porto_filter_output( $right_escaped ); ?>: 10px;
		margin-bottom: 0;
	}
}
@media (min-width: 768px) {
	.wp-block, .container { max-width: 800px }
	.wp-block[data-align=wide] { max-width: <?php echo (int) $b['container-width']; ?>px }
}

@media (min-width: 1600px) {
	.wp-block, .container { max-width: <?php echo (int) $b['container-width']; ?>px }
}
.wp-block .wp-block { width: 100%; }

.editor-styles-wrapper .wp-block-columns > .block-editor-inner-blocks > .block-editor-block-list__layout,
.editor-styles-wrapper .row { margin-left: -<?php echo (int) $b['grid-gutter-width'] / 2; ?>px; margin-right: -<?php echo (int) $b['grid-gutter-width'] / 2; ?>px }
.portfolio-carousel .portfolio-item { margin-left: <?php echo (int) $b['grid-gutter-width'] / 2; ?>px; margin-right: <?php echo (int) $b['grid-gutter-width'] / 2; ?>px }
.editor-styles-wrapper .wp-block-columns > .block-editor-inner-blocks > .block-editor-block-list__layout > [data-type="core/column"],
ul.products li.product-col,
.editor-styles-wrapper .row > [class*="col-"] { padding-left: <?php echo (int) $b['grid-gutter-width'] / 2; ?>px; padding-right: <?php echo (int) $b['grid-gutter-width'] / 2; ?>px; margin-left: 0; margin-right: 0 }
.products.grid-creative li.product-col { padding-bottom: <?php echo (int) $b['grid-gutter-width']; ?>px; margin-bottom: 0 }
.editor-styles-wrapper ul.products { width: calc(100% + <?php echo (int) $b['grid-gutter-width']; ?>px); margin-left: -<?php echo (int) $b['grid-gutter-width'] / 2; ?>px !important; margin-right: -<?php echo (int) $b['grid-gutter-width'] / 2; ?>px !important }
ul.grid.divider-line { width: auto; margin-left: 0 !important; margin-right: 0 !important }
.editor-styles-wrapper .posts-container[class*="columns-"] { grid-row-gap: <?php echo (int) $b['grid-gutter-width']; ?>px; grid-column-gap: <?php echo (int) $b['grid-gutter-width']; ?>px }
@media (min-width: 600px) {
	.editor-styles-wrapper .block-editor-block-list__block.wp-block-column:nth-child(even) {
		margin-left: <?php echo (int) $b['grid-gutter-width']; ?>px
	}
}

@media (min-width: 782px) {
	.editor-styles-wrapper .block-editor-block-list__block.wp-block-column:not(:first-child) {
		margin-left: <?php echo (int) $b['grid-gutter-width']; ?>px
	}
}

/* Theme Colors */
<?php
	$theme_colors = array(
		'primary'    => $skin_color,
		'secondary'  => $b['secondary-color'],
		'tertiary'   => $b['tertiary-color'],
		'quaternary' => $b['quaternary-color'],
		'dark'       => $b['dark-color'],
		'light'      => $b['light-color'],
	);
	foreach ( $theme_colors as $key => $theme_color ) {
		echo '.background-color-' . $key . '{background-color: ' . esc_html( $theme_color ) . ' !important }';
		echo '.text-color-' . $key . '{color: ' . esc_html( $theme_color ) . ' !important }';
	}
	?>
.editor-styles-wrapper a {
	color: <?php echo esc_html( $b['skin-color'] ); ?>; text-decoration: none; pointer-events: none;
}
.editor-styles-wrapper .wp-block-pullquote blockquote { border-<?php echo porto_filter_output( $left_escaped ); ?>-color: <?php echo esc_html( $b['skin-color'] ); ?>; text-align: <?php echo porto_filter_output( $left_escaped ); ?>; padding: 2em; }

article.post .post-date .month, article.post .post-date .format, .post-item .post-date .month, .post-item .post-date .format,
ul.list li.product .add_to_cart_button,
ul.list li.product .add_to_cart_read_more,
ul.products li.product-default:hover .add-links .add_to_cart_button,
.product-image .viewcart:hover,
li.product-outimage_aq_onimage .add-links .quickview,
li.product-onimage .product-content .quickview,
li.product-onimage2 .quickview,
li.product-wq_onimage .links-on-image .quickview,
.owl-carousel .owl-nav button.owl-prev,
.owl-carousel .owl-nav button.owl-next,
.thumb-info .thumb-info-type,
.sort-source-style-2 { background-color: <?php echo esc_html( $b['skin-color'] ); ?>; border-color: <?php echo esc_html( $b['skin-color'] ); ?> }
.products-slider.owl-carousel .owl-dot span { color: rgba(<?php echo esc_html( $porto_color_lib->hexToRGB( $porto_color_lib->darken( $skin_color, 20 ) ) ); ?>, .4) }
article.post .post-date .day,
.owl-carousel .owl-dots .owl-dot.active span,
.owl-carousel .owl-dots .owl-dot:hover span { color: <?php echo esc_html( $b['skin-color'] ); ?> }

.btn-borders.btn-primary { border-color: <?php echo esc_html( $b['skin-color'] ); ?>; color: <?php echo esc_html( $b['skin-color'] ); ?> }

.sort-source-style-2 > li.active > a:after { border-top-color: <?php echo esc_html( $b['skin-color'] ); ?>; }

ul.category-color-dark li.product-category .thumb-info-title,
ul.products li.cat-has-icon .thumb-info > i { color: <?php echo esc_html( $b['dark-color'] ); ?> }

/* Core Blocks */

/* Porto Blocks */
.wp-admin .btn-primary { color: <?php echo esc_html( $b['skin-color-inverse'] ); ?>; background-color: <?php echo esc_html( $b['skin-color'] ); ?>; border-color: <?php echo esc_html( $b['skin-color'] ); ?> <?php echo esc_html( $b['skin-color'] ); ?> <?php echo esc_html( $porto_color_lib->darken( $b['skin-color'], 10 ) ); ?>; outline: none }
.wp-admin .btn-primary:hover,
.wp-admin .btn-primary:focus,
.wp-admin .btn-primary:active {
	background-color: <?php echo esc_html( $porto_color_lib->darken( $b['skin-color'], 5 ) ); ?>;
	border-color: <?php echo esc_html( $b['skin-color'] ); ?> !important;
	color: <?php echo esc_html( $b['skin-color-inverse'] ); ?>;
}
article.post .post-date .day, .post-item .post-date .day, ul.comments .comment-block { background: #f4f4f4 }
.owl-carousel.show-dots-title-right .owl-dots { right: <?php echo (int) $b['grid-gutter-width'] / 2 - 2; ?>px; }
.blog-posts article, .member-row-advanced .member:not(:last-child) { border-bottom: 1px solid rgba(0,0,0,0.06); }
section.timeline .timeline-box { border: 1px solid #e5e5e5; background: #fff; border-radius: 4px }
section.timeline .timeline-box.left:after { background: #fff; border-<?php echo porto_filter_output( $right_escaped ); ?>: 1px solid #e5e5e5; border-top: 1px solid #e5e5e5; }
section.timeline .timeline-box.right:after { background: #fff; border-<?php echo porto_filter_output( $left_escaped ); ?>: 1px solid #e5e5e5; border-bottom: 1px solid #e5e5e5; }
section.timeline .timeline-box.left:before,
section.timeline .timeline-box.right:before {
	background: <?php echo esc_html( $skin_color ); ?>;
	box-shadow: 0 0 0 3px #ffffff, 0 0 0 6px <?php echo esc_html( $skin_color ); ?>;
}
.main-sidebar-menu .sidebar-menu > li.menu-item > a,
.main-sidebar-menu .sidebar-menu .menu-custom-block span,
.main-sidebar-menu .sidebar-menu .menu-custom-block a {
	<?php if ( $b['menu-side-font']['font-family'] ) : ?>
		font-family: <?php echo sanitize_text_field( $b['menu-side-font']['font-family'] ); ?>, sans-serif;
	<?php endif; ?>
	<?php if ( $b['menu-side-font']['font-size'] ) : ?>
		font-size: <?php echo esc_html( $b['menu-side-font']['font-size'] ); ?>;
	<?php endif; ?>
	<?php if ( $b['menu-side-font']['font-weight'] ) : ?>
		font-weight: <?php echo esc_html( $b['menu-side-font']['font-weight'] ); ?>;
	<?php endif; ?>
	<?php if ( $b['menu-side-font']['line-height'] ) : ?>
		line-height: <?php echo esc_html( $b['menu-side-font']['line-height'] ); ?>;
	<?php endif; ?>
	<?php if ( $b['menu-side-font']['letter-spacing'] ) : ?>
		letter-spacing: <?php echo esc_html( $b['menu-side-font']['letter-spacing'] ); ?>;
	<?php endif; ?>
}
<?php if ( ! $b['thumb-padding'] ) : ?>
	.thumb-info { border-width: 0 }
<?php endif; ?>
.portfolio-row { margin-left: -<?php echo esc_html( $b['grid-gutter-width'] / 2 ); ?>px; margin-right: -<?php echo esc_html( $b['grid-gutter-width'] / 2 ); ?>px; }
.portfolio-row .portfolio { padding-left: <?php echo esc_html( $b['grid-gutter-width'] / 2 ); ?>px; padding-right: <?php echo esc_html( $b['grid-gutter-width'] / 2 ); ?>px; padding-bottom: <?php echo (int) $b['grid-gutter-width']; ?>px; }
.member-row .member {
	padding: 0 <?php echo esc_html( $b['grid-gutter-width'] / 2 ); ?>px 1px;
	margin-bottom: <?php echo esc_html( $b['grid-gutter-width'] ); ?>px;
	width: 100%;
}
.member-row-advanced .member { padding: 0 }

/* Products */
.editor-styles-wrapper .add-links .add_to_cart_button,
.editor-styles-wrapper .add-links .add_to_cart_read_more,
.editor-styles-wrapper .add-links .quickview,
.editor-styles-wrapper .yith-wcwl-add-to-wishlist span { background-color: <?php echo esc_html( $b['shop-add-links-bg-color'] ); ?>; border: 1px solid <?php echo esc_html( $b['shop-add-links-border-color'] ); ?>; color: <?php echo esc_html( $b['shop-add-links-color'] ); ?>; border-radius: 0 }
.porto-products.title-border-bottom > .section-title { border-bottom: 1px solid rgba(0, 0, 0, .06); }
li.product-onimage .product-content { background: #fff; border-top: 1px solid rgba(0, 0, 0, .09) }

/* Templates builder */
.gutenberg-hb.editor-styles-wrapper { padding-left: 20px; padding-right: 20px }
.gutenberg-hb .block-editor-block-list__layout.is-root-container,
.gutenberg-hb .porto-section > .block-editor-inner-blocks > .block-editor-block-list__layout,
.gutenberg-hb .porto-section > .container > .block-editor-inner-blocks > .block-editor-block-list__layout {
	display: flex;
	align-items: center;
	flex-wrap: wrap;
}
.gutenberg-hb .wp-block:not([data-type="porto/porto-section"]) {
	width: auto;
	margin-left: 0;
	margin-<?php echo porto_filter_output( $right_escaped ); ?>: .875rem;
}
.gutenberg-hb .wp-block[data-type="porto/porto-section"] {
	flex: 0 0 100%;
	max-width: 100%;
}

<?php
/* logo */
$logo_width        = ( isset( $porto_settings['logo-width'] ) && (int) $porto_settings['logo-width'] ) ? (int) $porto_settings['logo-width'] : 170;
$logo_width_wide   = ( isset( $porto_settings['logo-width-wide'] ) && (int) $porto_settings['logo-width-wide'] ) ? (int) $porto_settings['logo-width-wide'] : 250;
$logo_width_tablet = ( isset( $porto_settings['logo-width-tablet'] ) && (int) $porto_settings['logo-width-tablet'] ) ? (int) $porto_settings['logo-width-tablet'] : 110;
$logo_width_mobile = ( isset( $porto_settings['logo-width-mobile'] ) && (int) $porto_settings['logo-width-mobile'] ) ? (int) $porto_settings['logo-width-mobile'] : 110;
$logo_width_sticky = ( isset( $porto_settings['logo-width-sticky'] ) && (int) $porto_settings['logo-width-sticky'] ) ? (int) $porto_settings['logo-width-sticky'] : 80;
?>
#header .logo,
.side-header-narrow-bar-logo { max-width: <?php echo esc_html( $logo_width ); ?>px; }
@media (min-width: <?php echo (int) $porto_settings['container-width'] + (int) $porto_settings['grid-gutter-width']; ?>px) {
	#header .logo { max-width: <?php echo esc_html( $logo_width_wide ); ?>px; }
}
@media (max-width: 991px) {
	#header .logo { max-width: <?php echo esc_html( $logo_width_tablet ); ?>px; }
}
@media (max-width: 767px) {
	#header .logo { max-width: <?php echo esc_html( $logo_width_mobile ); ?>px; }
}
<?php if ( ! empty( $porto_settings['change-header-logo'] ) ) : ?>
	#header.sticky-header .logo { max-width: <?php echo esc_html( $logo_width_sticky * 1.25 ); ?>px; }
	<?php
endif;

/* menu */
if ( ! empty( $b['header-text-color'] ) ) : ?>
	#header,
	#header .header-main .header-contact .nav-top > li > a,
	#header .top-links > li.menu-item:before { color: <?php echo esc_html( $b['header-text-color'] ); ?> }
<?php endif; ?>
<?php if ( $b['header-link-color']['regular'] ) : ?>
	.header-main .header-contact a,
	#header .tooltip-icon,
	#header .top-links > li.menu-item > a,
	#header .searchform-popup .search-toggle,
	.header-wrapper .custom-html a:not(.btn),
	#header .my-account,
	#header .my-wishlist,
	#header .yith-woocompare-open {
		color: <?php echo esc_html( $b['header-link-color']['regular'] ); ?>;
	}
	#header .tooltip-icon { border-color: <?php echo esc_html( $b['header-link-color']['regular'] ); ?>; }
<?php endif; ?>
<?php if ( ! empty( $b['header-top-text-color'] ) ) : ?>
	#header .header-top,
	.header-top .top-links > li.menu-item:after { color: <?php echo esc_html( $b['header-top-text-color'] ); ?> }
<?php endif; ?>
<?php if ( $b['header-top-link-color']['regular'] ) : ?>
	.header-top .header-contact a,
	.header-top .custom-html a:not(.btn),
	#header .header-top .top-links > li.menu-item > a,
	.header-top .welcome-msg a {
		color: <?php echo esc_html( $b['header-top-link-color']['regular'] ); ?>;
	}
<?php endif; ?>
<?php if ( ! empty( $b['header-bottom-text-color'] ) ) : ?>
	#header .header-bottom { color: <?php echo esc_html( $b['header-bottom-text-color'] ); ?> }
<?php endif; ?>
<?php if ( ! empty( $b['header-bottom-link-color']['regular'] ) ) : ?>
	#header .header-bottom a:not(.btn) { color: <?php echo esc_html( $b['header-bottom-link-color']['regular'] ); ?> }
<?php endif; ?>

#header .main-menu > li.menu-item > a {
	<?php if ( $b['menu-font']['font-family'] ) : ?>
		font-family: <?php echo sanitize_text_field( $b['menu-font']['font-family'] ); ?>, sans-serif;
	<?php endif; ?>
	<?php if ( $b['menu-font']['font-size'] ) : ?>
		font-size: <?php echo esc_html( $b['menu-font']['font-size'] ); ?>;
	<?php endif; ?>
	<?php if ( $b['menu-font']['font-weight'] ) : ?>
		font-weight: <?php echo esc_html( $b['menu-font']['font-weight'] ); ?>;
	<?php endif; ?>
	<?php if ( $b['menu-font']['line-height'] ) : ?>
		line-height: <?php echo esc_html( $b['menu-font']['line-height'] ); ?>;
	<?php endif; ?>
	<?php if ( $b['menu-font']['letter-spacing'] ) : ?>
		letter-spacing: <?php echo esc_html( $b['menu-font']['letter-spacing'] ); ?>;
	<?php endif; ?>
	<?php if ( $b['mainmenu-toplevel-link-color']['regular'] ) : ?>
		color: <?php echo esc_html( $b['mainmenu-toplevel-link-color']['regular'] ); ?>;
	<?php endif; ?>
	padding: <?php echo porto_config_value( $b['mainmenu-toplevel-padding1']['padding-top'], 'px' ); ?> <?php echo porto_config_value( $b['mainmenu-toplevel-padding1'][ 'padding-' . $right ], 'px' ); ?> <?php echo porto_config_value( $b['mainmenu-toplevel-padding1']['padding-bottom'], 'px' ); ?> <?php echo porto_config_value( $b['mainmenu-toplevel-padding1'][ 'padding-' . $left ], 'px' ); ?>;
}
<?php
	$main_menu_level1_abg_color    = $b['mainmenu-toplevel-config-active'] ? $b['mainmenu-toplevel-abg-color'] : $b['mainmenu-toplevel-hbg-color'];
	$main_menu_level1_active_color = $b['mainmenu-toplevel-config-active'] ? $b['mainmenu-toplevel-alink-color'] : $b['mainmenu-toplevel-link-color']['hover'];
?>
#header .main-menu > li.menu-item.active > a {
	<?php if ( $main_menu_level1_abg_color ) : ?>
		background-color: <?php echo esc_html( $main_menu_level1_abg_color ); ?>;
	<?php endif; ?>
	<?php if ( $main_menu_level1_active_color ) : ?>
		color: <?php echo esc_html( $main_menu_level1_active_color ); ?>;
	<?php endif; ?>
}
#header .main-menu > li.menu-item.active:hover > a,
#header .main-menu > li.menu-item:hover > a {
	<?php if ( $b['mainmenu-toplevel-hbg-color'] ) : ?>
		background-color: <?php echo esc_html( $b['mainmenu-toplevel-hbg-color'] ); ?>;
	<?php endif; ?>
	<?php if ( $b['mainmenu-toplevel-link-color']['hover'] ) : ?>
		color: <?php echo esc_html( $b['mainmenu-toplevel-link-color']['hover'] ); ?>;
	<?php endif; ?>
}

/* swticher */
<?php if ( $b['switcher-link-color']['regular'] ) : ?>
	#header .porto-view-switcher > li.menu-item:before,
	#header .porto-view-switcher > li.menu-item > a { color: <?php echo esc_html( $b['switcher-link-color']['regular'] ); ?>; }
<?php endif; ?>

<?php
	$header_type = porto_get_header_type();
?>

/* mini cart */
.cart-popup .quantity, .cart-popup .quantity .amount { color: #696969 !important; }
<?php if ( isset( $b['minicart-icon-font-size'] ) && $b['minicart-icon-font-size'] ) : ?>
	<?php
		$unit = trim( preg_replace( '/[0-9.]/', '', $b['minicart-icon-font-size'] ) );
	if ( ! $unit ) {
		$b['minicart-icon-font-size'] .= 'px';
	}
	?>
	#mini-cart .minicart-icon { font-size: <?php echo esc_html( $b['minicart-icon-font-size'] ); ?> }
<?php endif; ?>
<?php if ( isset( $b['minicart-popup-border-color'] ) && $b['minicart-popup-border-color'] ) : ?>
	#mini-cart .cart-icon:after { border-color: <?php echo esc_html( $b['minicart-popup-border-color'] ); ?>; }
<?php endif; ?>
<?php if ( isset( $b['minicart-bg-color'] ) && $b['minicart-bg-color'] ) : ?>
	#mini-cart {
		background: <?php echo esc_html( $b['minicart-bg-color'] ); ?>;
	<?php if ( $b['border-radius'] ) : ?>
		border-radius: 4px
	<?php endif; ?>
	}
<?php endif; ?>
<?php if ( ! empty( $b['minicart-icon-color'] ) ) : ?>
	#mini-cart .cart-subtotal, #mini-cart .minicart-icon { color: <?php echo esc_html( $b['minicart-icon-color'] ); ?> }
<?php endif; ?>
<?php if ( ! empty( $b['minicart-item-color'] ) ) : ?>
	#mini-cart .cart-items, #mini-cart .cart-items-text { color: <?php echo esc_html( $b['minicart-item-color'] ); ?> }
<?php endif; ?>

/* social icons */
<?php if ( ( (int) $header_type >= 10 && (int) $header_type <= 17 ) || empty( $header_type ) ) : ?>
	#header .share-links a { width: 30px; height: 30px; border-radius: 30px; margin: 0 1px; overflow: hidden; font-size: .8rem; }
	#header .share-links a:not(:hover) { background-color: #fff; color: #333; }
<?php endif; ?>

/* header vertical divider */
#header .separator { border-left: 1px solid <?php echo porto_filter_output( $porto_color_lib->isColorDark( $b['header-link-color']['regular'] ) ? 'rgba(0, 0, 0, .04)' : 'rgba(255, 255, 255, .09)' ); ?> }
#header .header-top .separator { border-left-color: <?php echo porto_filter_output( $porto_color_lib->isColorDark( $b['header-top-link-color']['regular'] ) ? 'rgba(0, 0, 0, .04)' : 'rgba(255, 255, 255, .09)' ); ?> }

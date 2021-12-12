<?php
global $porto_settings, $porto_layout;
?>

<header id="header" class="header-corporate header-11<?php echo ! $porto_settings['logo-overlay'] || ! $porto_settings['logo-overlay']['url'] ? '' : ' logo-overlay-header'; ?>">

	<?php if ( $porto_settings['show-header-top'] ) : ?>
		<div class="header-top">
			<div class="container">
				<div class="header-left">
					<?php
					// show currency and view switcher
					$currency_switcher = porto_currency_switcher();
					$view_switcher     = porto_view_switcher();

					if ( $currency_switcher || $view_switcher ) {
						echo '<div class="switcher-wrap">';
					}
					echo porto_filter_output( $view_switcher );
					if ( $currency_switcher && $view_switcher ) {
						echo '<span class="gap switcher-gap">|</span>';
					}
					echo porto_filter_output( $currency_switcher );
					if ( $currency_switcher || $view_switcher ) {
						echo '</div>';
					}
					?>
					<?php
					// show contact info and top navigation
					$contact_info = $porto_settings['header-contact-info'];

					if ( $contact_info ) {
						echo '<div class="block-inline"><div class="header-contact">' . do_shortcode( $contact_info ) . '</div></div>';
					}
					?>

				</div>

				<div class="header-right">
					<?php
					// show welcome message and top navigation
					$top_nav = porto_top_navigation();
					if ( $porto_settings['welcome-msg'] ) {
						echo '<span class="welcome-msg">' . do_shortcode( $porto_settings['welcome-msg'] ) . '</span>';
					}

					if ( $porto_settings['welcome-msg'] && $top_nav ) {
						echo '<span class="gap">|</span>';
					}

					echo porto_filter_output( $top_nav );
					?>
					<?php
					// show minicart
					$minicart = porto_minicart();

					if ( $minicart ) {
						echo '<div class="block-inline">' . $minicart . '</div>';
					}

					// show search form
					echo porto_search_form();
					?>
				</div>
			</div>
		</div>
	<?php endif; ?>

	<div class="header-main">
		<div class="container">
			<div class="header-left">
				<?php echo porto_logo(); ?>
			</div>

			<div class="header-right">
				<?php
				if ( $porto_settings['show-header-top'] ) {
					// show search form
					echo porto_search_form();
				}

				// show mobile toggle
				?>
				<div id="main-menu"
				<?php
				if ( $porto_settings['show-header-top'] ) {
					echo ' class="show-header-top"'; }
				?>
				>
				<?php
					// show main menu
					echo porto_main_menu();
				?>
				</div>
				<?php
				// show social links
				echo porto_header_socials();

				if ( $porto_settings['show-header-top'] ) {
					// show minicart
					echo porto_minicart();
				}
				?>

				<?php get_template_part( 'header/header_tooltip' ); ?>

				<a class="mobile-toggle<?php echo ( isset( $porto_settings['menu-toggle-bg-color'] ) && $porto_settings['menu-toggle-bg-color'] ) ? ' background-color-primary text-color-light' : ''; ?>"><i class="fas fa-bars"></i></a>
			</div>
		</div>
		<?php get_template_part( 'header/mobile_menu' ); ?>
	</div>
</header>

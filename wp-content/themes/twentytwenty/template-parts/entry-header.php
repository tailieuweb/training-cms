<?php

/**
 * Displays the post header
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */

$entry_header_classes = '';

if ( is_singular() ) {
	$entry_header_classes .= ' header-footer-group';
}

?>

<header class="module-6-header entry-header has-text-align-center<?php echo esc_attr($entry_header_classes); ?>">

	<div class="entry-header-inner section-inner medium">

		<?php
		/**
		 * Allow child themes and plugins to filter the display of the categories in the entry header.
		 *
		 * @since Twenty Twenty 1.0
		 *
		 * @param bool Whether to show the categories in header. Default true.
		 */
		$show_categories = apply_filters('twentytwenty_show_categories_in_entry_header', true);
        /* Module-6 */
		$day = $month = $year = 0;
		if (strtotime($post->post_date)) {
			$timestamp = strtotime($post->post_date);
			$day = date("d", $timestamp);
			$month = date("m", $timestamp);
			$year = date("y", $timestamp);
		}
		if (true === $show_categories && has_category()) {
		?>

			<div class="entry-categories">
				<span class="screen-reader-text"><?php _e('Categories', 'twentytwenty'); ?></span>
				<div class="entry-categories-inner">
					<?php the_category(' '); ?>
				</div><!-- .entry-categories-inner -->
			</div><!-- .entry-categories -->
			<div class="row title-detail">
				<div class="col-md-10 col-xs-9">
				<?php
			}

			if (is_singular()) {
				the_title('<h1 class="entry-title">', '</h1>');
			} else {
				the_title('<h2 class="entry-title heading-size-1"><a href="' . esc_url(get_permalink()) . '">', '</a></h2>');
			}

			$intro_text_width = '';

			if (is_singular()) {
				$intro_text_width = ' small';
			} else {
				$intro_text_width = ' thin module-6-thin'; // Module-6
			}
				?></div>
				<div class="col-md-2 col-xs-3">
					<div class="headlinesdate">
						<div class="headlinesdm">
							<div class="headlinesday"><?php echo $day ?></div>
							<div class="headlinesmonth"><?php echo $month ?></div>
						</div>
						<div class="headlinesyear"><?php echo "'" . $year ?></div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<div class="overviewline"></div>
				</div>
			</div>
			<?php
			if (has_excerpt() && is_singular()) {
			?>
				<div class="intro-text section-inner max-percentage<?php echo $intro_text_width; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static output 
																	?>">
					<?php the_excerpt(); ?>
				</div>

			<?php
			}

			// Default to displaying the post meta.
			?>

	</div><!-- .entry-header-inner -->

</header><!-- .entry-header -->
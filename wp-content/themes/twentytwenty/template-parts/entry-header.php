<?php

/**
 * Displays the post header
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */

$entry_header_classes = '';

if (is_singular()) {
	$entry_header_classes .= ' header-footer-group';
}
$class_Identify_column = "";
if (is_single()) {
	$class_Identify_column = "col-lg-10";
}
?>

<header class="entry-header has-text-align-center<?php echo esc_attr($entry_header_classes); ?>">
	<?php if (is_single()) { ?>
		<div class="row">
		<?php } ?>
		<div class="entry-header-inner section-inner medium <?= $class_Identify_column ?>">

			<?php
			/**
			 * Allow child themes and plugins to filter the display of the categories in the entry header.
			 *
			 * @since Twenty Twenty 1.0
			 *
			 * @param bool Whether to show the categories in header. Default true.
			 */
			$show_categories = apply_filters('twentytwenty_show_categories_in_entry_header', true);
			if(is_single()){
				if (true === $show_categories && has_category()) {
					?>
		
						<div class="entry-categories">
							<span class="screen-reader-text"><?php _e('Categories', 'twentytwenty'); ?></span>
							<div class="entry-categories-inner">
								<?php the_category(' '); ?>
							</div><!-- .entry-categories-inner -->
						</div><!-- .entry-categories -->
		
					<?php
			}
			
			}

			if (is_singular()) {
				if (is_single()) {
					the_title('<h1 class="entry-title entry-title-detail-page">', '</h1>');
				} else {
					the_title('<h1 class="entry-title ">', '</h1>');
				}
			} else {
				the_title('<h2 class="entry-title heading-size-1"><a href="' . esc_url(get_permalink()) . '">', '</a></h2>');
			}

			$intro_text_width = '';

			if (is_singular()) {
				$intro_text_width = ' small';
			} else {
				$intro_text_width = ' thin';
			}

			if (has_excerpt() && is_singular()) {
			?>

				<div class="intro-text section-inner max-percentage<?php echo $intro_text_width; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static output 
																														?>">
					<?php the_excerpt(); ?>
				</div>

			<?php
			}

			// Default to displaying the post meta.
			if(is_single()){
				twentytwenty_the_post_meta(get_the_ID(), 'single-top');
			}
			?>

		</div><!-- .entry-header-inner -->

		<?php if (is_single()) {
			$post = get_post();

			$month = date("m", strtotime($post->post_date));
			$day = date("d", strtotime($post->post_date));
			$year = date("y", strtotime($post->post_date));
		?>
			<div class="col-lg-2">
				<div class="headlinesdate">
					<div class="headlinesdm">
						<div class="headlinesday"><?= $day ?></div>
						<div class="headlinesmonth"><?= $month ?></div>
					</div>
					<div class="headlinesyear">'<?= $year ?></div>
				</div>
			</div>
		</div>
	<?php } ?>
	</div>
</header><!-- .entry-header -->
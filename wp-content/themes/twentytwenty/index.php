<?php

/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */

get_header();
?>
<?php
$class_custom_post = "";
if (!is_single()) {
	$class_custom_post = "content_custom_post";
}
?>

<main id="site-content" class="<?php echo $class_custom_post; ?>" role="main">

	<?php

	$archive_title    = '';
	$archive_subtitle = '';

	if (is_search()) {
		global $wp_query;

		$archive_title = sprintf(
			'%1$s %2$s',
			'<span class="color-accent">' . __('Search:', 'twentytwenty') . '</span>',
			'&ldquo;' . get_search_query() . '&rdquo;'
		);

		if ($wp_query->found_posts) {
			$archive_subtitle = sprintf(
				/* translators: %s: Number of search results. */
				_n(
					'We found %s result for your search.',
					'We found %s results for your search.',
					$wp_query->found_posts,
					'twentytwenty'
				),
				number_format_i18n($wp_query->found_posts)
			);
		} else {
			$archive_subtitle = __('We could not find any results for your search. You can give it another try through the search form below.', 'twentytwenty');
		}
	} elseif (is_archive() && !have_posts()) {
		$archive_title = __('Nothing Found', 'twentytwenty');
	} elseif (!is_home()) {
		$archive_title    = get_the_archive_title();
		$archive_subtitle = get_the_archive_description();
	}

	if ($archive_title || $archive_subtitle) {
	?>

		<header class="archive-header has-text-align-center header-footer-group">

			<div class="archive-header-inner section-inner medium">

				<?php if ($archive_title) { ?>
					<h1 class="archive-title"><?php echo wp_kses_post($archive_title); ?></h1>
				<?php } ?>

				<?php if ($archive_subtitle) { ?>
					<div class="archive-subtitle section-inner thin max-percentage intro-text"><?php echo wp_kses_post(wpautop($archive_subtitle)); ?></div>
				<?php } ?>

			</div><!-- .archive-header-inner -->

		</header><!-- .archive-header -->

	<?php
	}

	if (have_posts()) {

		$i = 0;

		while (have_posts()) {
			$i++;
			if ($i > 1) {
				if (is_search()) {
					echo '<div class="separator-post"></div>';
				} else {
					if(is_single()){
						echo '<hr class="post-separator styled-separator is-style-wide section-inner" aria-hidden="true" />';
					}
				}
			}
			the_post();

			get_template_part('template-parts/content', get_post_type());
		}
	} elseif (is_search()) {
	?>

		<div class="no-search-results-form section-inner thin">

			<?php
			$twentytwenty_unique_id = twentytwenty_unique_id('search-form-');

			$twentytwenty_aria_label = !empty($args['aria_label']) ? 'aria-label="' . esc_attr($args['aria_label']) . '"' : '';
			// Backward compatibility, in case a child theme template uses a `label` argument.
			if (empty($twentytwenty_aria_label) && !empty($args['label'])) {
				$twentytwenty_aria_label = 'aria-label="' . esc_attr($args['label']) . '"';
			}
			?>
			<form role="search" <?php echo $twentytwenty_aria_label; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped above. 
													?> method="get" class="search-form form-search-no-result" action="<?php echo esc_url(home_url('/')); ?>">
				<div class="row">
					<div class="col-auto">
						<div class="search-icon">
							<svg class="svg-icon" aria-hidden="true" role="img" focusable="false" xmlns="http://www.w3.org/2000/svg" width="23" height="23" viewBox="0 0 23 23">
								<path d="M38.710696,48.0601792 L43,52.3494831 L41.3494831,54 L37.0601792,49.710696 C35.2632422,51.1481185 32.9839107,52.0076499 30.5038249,52.0076499 C24.7027226,52.0076499 20,47.3049272 20,41.5038249 C20,35.7027226 24.7027226,31 30.5038249,31 C36.3049272,31 41.0076499,35.7027226 41.0076499,41.5038249 C41.0076499,43.9839107 40.1481185,46.2632422 38.710696,48.0601792 Z M36.3875844,47.1716785 C37.8030221,45.7026647 38.6734666,43.7048964 38.6734666,41.5038249 C38.6734666,36.9918565 35.0157934,33.3341833 30.5038249,33.3341833 C25.9918565,33.3341833 22.3341833,36.9918565 22.3341833,41.5038249 C22.3341833,46.0157934 25.9918565,49.6734666 30.5038249,49.6734666 C32.7048964,49.6734666 34.7026647,48.8030221 36.1716785,47.3875844 C36.2023931,47.347638 36.2360451,47.3092237 36.2726343,47.2726343 C36.3092237,47.2360451 36.347638,47.2023931 36.3875844,47.1716785 Z" transform="translate(-20 -31)"></path>
							</svg>
						</div>
					</div>
					<div class="col">
						<label for="<?php echo esc_attr($twentytwenty_unique_id); ?>">
							<span class="screen-reader-text"><?php _e('Search for:', 'twentytwenty'); // phpcs:ignore: WordPress.Security.EscapeOutput.UnsafePrintingFunction -- core trusts translations 
																								?>
							</span>
							<input type="search" id="<?php echo esc_attr($twentytwenty_unique_id); ?>" class="search-field search-filed-2" placeholder="<?php echo esc_attr_x('Search topics or keywords', 'placeholder', 'twentytwenty'); ?>" value="<?php echo get_search_query(); ?>" name="s" />
						</label>
					</div>
					<div class="col-auto">
						<input type="submit" class="search-submit" value="<?php echo esc_attr_x('Search', 'submit button', 'twentytwenty'); ?>" />
					</div>
				</div>
			</form>

			<?php

			?>

		</div><!-- .no-search-results -->

	<?php
	}
	?>

	<?php get_template_part('template-parts/pagination'); ?>

</main><!-- #site-content -->

<?php get_template_part('template-parts/footer-menus-widgets'); ?>

<?php
get_footer();

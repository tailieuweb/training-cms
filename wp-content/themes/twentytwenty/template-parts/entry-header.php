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
$type_post = '';
if (is_single()) {
	$type_post = 'single-top';
} else {
	$type_post = 'single-date';
}
?>

<header class="entry-header has-text-align-center<?php echo esc_attr($entry_header_classes); ?>">

	<div class="entry-header-inner section-inner medium">
		<?php
		// Default to displaying the post meta.
		twentytwenty_the_post_meta(get_the_ID(), $type_post);
		?>
		<div class="entry-header-inner section-inner-content">

			<?php
			/**
			 * Allow child themes and plugins to filter the display of the categories in the entry header.
			 *
			 * @since Twenty Twenty 1.0
			 *
			 * @param bool Whether to show the categories in header. Default true.
			 */
			$show_categories = apply_filters('twentytwenty_show_categories_in_entry_header', true);

			if (true === $show_categories && has_category() && $type_post === 'single-top') {
			?>

				<div class="entry-categories">
					<span class="screen-reader-text"><?php _e('Categories', 'twentytwenty'); ?></span>
					<div class="entry-categories-inner">
						<?php the_category(' '); ?>
					</div><!-- .entry-categories-inner -->
				</div><!-- .entry-categories -->

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
			if (!is_search()) {

			?>
				<div class="post-inner <?php echo is_page_template('templates/template-full-width.php') ? '' : 'thin'; ?> ">

					<div class="entry-content">

						<?php
						if (is_search() || !is_singular() && 'summary' === get_theme_mod('blog_content', 'full')) {
							the_excerpt();
						} else {
							if (is_single()) {
								the_content(__('Continue reading', 'twentytwenty'));
							} else {
								$post  = get_post();
								$content = $post->post_content;
								$str = preg_replace('/<figure.*?>.*?<\/figure>/', ' ', $content);
								echo substr($str, 0, 200);
							}
						}
						?>
					</div><!-- .entry-content -->

				</div><!-- .post-inner -->
			<?php
			}
			?>
		</div> <!-- .entry-header-inner-content -->

	</div><!-- .entry-header-inner -->

</header><!-- .entry-header -->
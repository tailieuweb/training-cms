<?php

/**
 * Displays the next and previous post navigation in single posts.
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */

$next_post = get_next_post();
$prev_post = get_previous_post();

if ($next_post || $prev_post) {

	$pagination_classes = '';

	if (!$next_post) {
		$pagination_classes = ' only-one only-prev';
	} elseif (!$prev_post) {
		$pagination_classes = ' only-one only-next';
	}

?>

	<nav class="pagination-single section-inner<?php echo esc_attr($pagination_classes); ?>" aria-label="<?php esc_attr_e('Post', 'twentytwenty'); ?>" role="navigation">

		<!-- <hr class="styled-separator is-style-wide" aria-hidden="true" /> -->

		<div class="container">
			<div class="pagination-single-inner">
				<div class="pagination-single-next post-prev-next">
					<?php if ($next_post) {
						twentytwenty_the_post_meta('single-top');
					?>

						<a class="next-post" href="<?php echo esc_url(get_permalink($next_post->ID)); ?>">
							<!-- <span class="arrow" aria-hidden="true">&rarr;</span> -->
							<span class="title"><span class="title-inner"><?php echo wp_kses_post(get_the_title($next_post->ID)); ?></span></span>
						</a>
					<?php
					}
					?>
				</div>
				<div class="pagination-single-prev post-prev-next">
					<?php
					if ($prev_post) {
						twentytwenty_the_post_meta('single-top');
					?>

						<a class="previous-post" href="<?php echo esc_url(get_permalink($prev_post->ID)); ?>">
							<!-- <span class="arrow" aria-hidden="true">&larr;</span> -->
							<span class="title"><span class="title-inner"><?php echo wp_kses_post(get_the_title($prev_post->ID)); ?></span></span>
						</a>

					<?php
					} ?>

				</div>
			</div><!-- .pagination-single-inner -->
		</div>

		<!-- <hr class="styled-separator is-style-wide" aria-hidden="true" /> -->

	</nav><!-- .pagination-single -->

<?php
}

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
    // Module-7
	<div class="col-md-8 module-7">
        // Module-6
	<div class="author-module-6"><?php	echo "(Theo ".get_the_author().")"; ?></div>
	<nav class="pagination-single section-inner<?php echo esc_attr($pagination_classes); ?>" aria-label="<?php esc_attr_e('Post', 'twentytwenty'); ?>" role="navigation">

		<!-- <hr class="styled-separator is-style-wide" aria-hidden="true" /> -->

		<div class="pagination-single-inner">

			<?php
			$day = $month = $year = 0;
			if (strtotime($post->post_date)) {
				$timestamp = strtotime($post->post_date);
				$day = date("d", $timestamp);
				$month = date("m", $timestamp);
				$year = date("y", $timestamp);
			}
			if ($prev_post) {
			?>
				<div class="row">
				<div class="headlinesdate">
						<div class="headlinesdm">
							<div class="headlinesday"><?php echo $day ?></div>
							<div class="headlinesmonth"><?php echo $month ?></div>
						</div>
						<div class="headlinesyear"><?php echo $year ?></div>
					</div>
					<a class="previous-post" href="<?php echo esc_url(get_permalink($prev_post->ID)); ?>">
						<!-- <span class="arrow" aria-hidden="true">&larr;</span> -->
						<span class="title"><span class="title-inner"><?php echo wp_kses_post(get_the_title($prev_post->ID)); ?></span></span>
					</a>
				</div>
			<?php
			}
			if ($next_post) {
			?>
				<div class="row">
					<div class="headlinesdate">
						<div class="headlinesdm">
							<div class="headlinesday"><?php echo $day ?></div>
							<div class="headlinesmonth"><?php echo $month ?></div>
						</div>
						<div class="headlinesyear"><?php echo $year ?></div>
					</div>
					<a class="previous-post" href="<?php echo esc_url(get_permalink($next_post->ID)); ?>">
						<!-- <span class="arrow" aria-hidden="true">&rarr;</span> -->
						<span class="title"><span class="title-inner"><?php echo wp_kses_post(get_the_title($next_post->ID)); ?></span></span>
					</a>
				</div>

			<?php
			}
			?>

		</div><!-- .pagination-single-inner -->

		<!-- <hr class="styled-separator is-style-wide" aria-hidden="true" /> -->

	</nav><!-- .pagination-single -->
	</div>
<?php
}

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
$post = get_post();
$date = $post->post_date;
$day = date("d", strtotime($date));
$month = date("m", strtotime($date));
$year = date("y", strtotime($date));
if ($next_post || $prev_post) {
	$pagination_classes = '';
	if (!$next_post) {
		$pagination_classes = ' only-one only-prev';
	} elseif (!$prev_post) {
		$pagination_classes = ' only-one only-next';
	}
?>
	<nav class="pagination-single section-inner<?php echo esc_attr($pagination_classes); ?>" aria-label="<?php esc_attr_e('Post', 'twentytwenty'); ?>" role="navigation">
		<div class="pagination-single-inner">
			<?php
			if ($prev_post) {
			?>
				<a class="previous-post" href="<?php echo esc_url(get_permalink($prev_post->ID)); ?>">
					<div class="time" style="
    font-size: 0.8em;
    width: 15%;
    min-width: 55px;
    display: flex;
    vertical-align: middle;
">
						<div class="day"><?php echo $day . "<br>" . $month ?></div>
						<div class="year" style="margin-top: 7%;margin-left: 5%;"><?php echo $year ?></div>
					</div>
					<span class="title"><span class="title-inner"><?php echo wp_kses_post(get_the_title($prev_post->ID)); ?></span></span>
				</a>
			<?php
			}
			if ($next_post) {
			?>
				<a class="next-post" href="<?php echo esc_url(get_permalink($next_post->ID)); ?>">
				<div class="time" style="
    font-size: 0.8em;
    width: 15%;
    min-width: 55px;
    display: flex;
    vertical-align: middle;
">
						<div class="day"><?php echo $day . "<br>" . $month ?></div>
						<div class="year" style="margin-top: 7%;margin-left: 5%;"><?php echo $year ?></div>
					</div>
					<span class="title"><span class="title-inner"><?php echo wp_kses_post(get_the_title($next_post->ID)); ?></span></span>
				</a>
			<?php
			}
			?>
		</div><!-- .pagination-single-inner -->
	</nav><!-- .pagination-single -->
<?php
}

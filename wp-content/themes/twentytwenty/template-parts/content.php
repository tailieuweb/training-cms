<?php

/**
 * The default template for displaying content
 *
 * Used for both singular and index.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */

?>

<?php

$class_custom_post = "";
if (!is_single()) {
	$class_custom_post = "custom_post";
}
?>


<article <?php post_class($class_custom_post); ?> id="post-<?php the_ID(); ?>">
	<?php
	$post = get_post();

	$month = date("m", strtotime($post->post_date));
	$day = date("d", strtotime($post->post_date));

	if (!is_single()) {
	?>
		<div class="content_left_custom">
			<div class="day"><?php echo $day ?></div>
			<div class="month">Tháng <?php echo $month ?></div>
		</div>

	<?php } ?>

	<div class="content_right_custom">
		<?php

		get_template_part('template-parts/entry-header');

		if (!is_search()) {
			get_template_part('template-parts/featured-image');
		}

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
						$post = get_post();
						$post_content =  $post->post_content;
						$date_post = $post->post_date;
						$subpost = substr($post_content, 0, 100);
						echo $subpost . '<a href="' . esc_url(get_permalink()) . '">[...]</a>';
					}
				}
				?>

			</div><!-- .entry-content -->

		</div><!-- .post-inner -->

		<div class="section-inner">
			<?php
			wp_link_pages(
				array(
					'before'      => '<nav class="post-nav-links bg-light-background" aria-label="' . esc_attr__('Page', 'twentytwenty') . '"><span class="label">' . __('Pages:', 'twentytwenty') . '</span>',
					'after'       => '</nav>',
					'link_before' => '<span class="page-number">',
					'link_after'  => '</span>',
				)
			);

			edit_post_link();

			// Single bottom post meta.
			twentytwenty_the_post_meta(get_the_ID(), 'single-bottom');

			if (post_type_supports(get_post_type(get_the_ID()), 'author') && is_single()) {

				get_template_part('template-parts/entry-author-bio');
			}
			?>

		</div><!-- .section-inner -->

		<?php

		if (is_single()) {

			get_template_part('template-parts/navigation');
		}

		/*
	 * Output comments wrapper if it's a post, or if comments are open,
	 * or if there's a comment number – and check for password.
	 */
		if ((is_single() || is_page()) && (comments_open() || get_comments_number()) && !post_password_required()) {
		?>

			<div class="comments-wrapper section-inner">

				<?php comments_template(); ?>

			</div><!-- .comments-wrapper -->

		<?php
		}
		?>
	</div>
</article><!-- .post -->
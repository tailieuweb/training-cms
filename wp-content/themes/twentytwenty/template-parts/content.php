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

$class = '';
if (!is_single()) {
	$class = 'danh-sach';
}
?>

<article <?php post_class($class); ?> id="post-<?php the_ID(); ?>">

	<?php
	if (is_single()) {
		get_template_part('template-parts/entry-header');
	}

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
                    ?>
                    <!-- Module-6 -->
                    <div class="detail-post-content"> <?php
					the_content(__('Continue reading', 'twentytwenty'));
                    ?></div> <?php
				} else {
					$post = get_post();
					$day = $month = $year = 0;
					if (strtotime($post->post_date)) {
						$timestamp = strtotime($post->post_date);
						$day = date("d", $timestamp);
						$month = date("m", $timestamp);
					}
					/** $content = preg_replace('/<figure.*?>.*?<\/figure>/', '', $post->post_content); */
					$content = findHTMLTag($post->post_content, 'p');
					$content = $content ? $content : 'This post hasn\'t description !!';
			?>
					<div class="list_new_view">
						<div class="row post-home-page top_news_block_desc">
							<div class="col-md-3 col-xs-3 topnewstime">
								<span class="topnewsdate"><?= strlen($day) > 1 ? $day : '0' . $day ?></span><br>
								<span class="topnewsmonth">Tháng <?= strlen($month) > 1 ? $month : '0' . $month ?></span><br>
							</div>
							<div class="col-md-9 col-xs-9 shortdesc">
								<p class="post-title">
									<a href="<?= $post->guid ?>"><?= $post->post_title ?></a>
								</p>
								<?= substr($content, 0, 150); ?><a href="<?= $post->guid ?>"> [...]</a>
							</div>
						</div>
					</div>
			<?php

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

</article><!-- .post -->
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

$post = get_post();
?>

<!-- Bootstrap CSS -->
<?php
if (!is_single()) :
?>
	<div class="col-md-6">
		<div class="list_new_view">
			<div class="row">
				<div class="col-md-7 top_news_block_desc">
					<div class="row">
						<div class="col-md-3 col-xs-3 topnewstime">
							<span class="topnewsdate"><?php echo date('d', strtotime($post->post_date)) ?></span><br>
							<span class="topnewsmonth">Tháng <?php echo date('m', strtotime($post->post_date)) ?></span><br>
						</div>
						<div class="col-md-9 col-xs-9 shortdesc">
							<?php the_title('<h4><a href="' . esc_url(get_permalink()) . '">', '</a></h4>'); ?>
							<p>
								<?php echo strip_tags(substr($post->post_content, 0, 300));	?>
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

<?php
else :
?>

	<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

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
						$port = get_post();
						echo substr($port->post_content, 0, 100);
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

<?php
endif;
?>
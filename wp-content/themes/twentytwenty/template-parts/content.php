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
?>
	<div class="container">
		
		<div class="row">
			<div class="col-md-2">
			</div>
			<div class="col-md-8" style="margin-top: 20px;">
				<article <?php post_class($class); ?> id="post-<?php the_ID(); ?>">
					<?php if (is_search()) { ?>
						<div class="row">
							<div class="col-md-3">
								<?php
								if (!empty(get_post())) {
									$post = get_post();
									$image = function () use ($post) {
										$sfigure = '<figure class="wp-block-image">';
										$efigure = '</figure>';
										//position figure in string.
										$start_position =  strpos($post->post_content, $sfigure);
										$length =  strpos($post->post_content, $efigure) +  strlen($efigure);
										$end_position = $length - $start_position;
										//substr figure in string.
										$figure =  substr($post->post_content, $start_position, $end_position);
										//image in string.
										$figure = substr($figure, strlen($sfigure));
										$end_position = strpos($figure, '>');
										$image = substr($figure, 0, $end_position);
										return $sfigure . $image . $efigure;
									};
									echo $image();
								}
								?>
							</div>
							<div class="col-md-2">
								<?php
								//
								twentytwenty_the_post_meta(get_the_ID(), 'single-top');
								?>
							</div>
							<div class="col-md-7 line-ver">
								<?php
								get_template_part('template-parts/entry-header');
								if (!is_search()) {
									get_template_part('template-parts/featured-image');
								}
								?>

								<div class="post-inner <?php echo is_page_template('templates/template-full-width.php') ? '' : 'thin'; ?> ">

									<div class="entry-content">
										<?php
										$post = get_post();
										if (is_search() || !is_singular() && 'summary' === get_theme_mod('blog_content', 'full')) {
											echo substr($post->post_content, 0, 100) . '<a style="color:blue;" href="' . esc_url(get_permalink()) . '">[..]</a>';
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
								if ((is_single() || is_page()) && (comments_open() || get_comments_number()) && !post_password_required()) {
								?>

									<div class="comments-wrapper section-inner">

										<?php comments_template(); ?>

									</div><!-- .comments-wrapper -->

								<?php
								}
								?>
							</div>
						</div>
					<?php } else { ?>
						<div class="row">
							<div class="col-md-3">
								<?php
								//
								twentytwenty_the_post_meta(get_the_ID(), 'single-top');
								?>
							</div>
							<div class="col-md-9 line-ver">
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
												echo substr($post->post_content, 0, 100) . '<a style="color:blue;" href="' . esc_url(get_permalink()) . '">[..]</a>';
												// $start_image =  strpos($post->post_content, '<figure class="wp-block-image">');
												// $end_image =  strpos($post->post_content, '</figure>') +  strlen('</figure>');
												// echo $start_image;
												// $end_image = $end_image - $start_image;
												// echo substr($post->post_content, $start_image, $end_image);
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
								if ((is_single() || is_page()) && (comments_open() || get_comments_number()) && !post_password_required()) {
								?>

									<div class="comments-wrapper section-inner">

										<?php comments_template(); ?>

									</div><!-- .comments-wrapper -->

								<?php
								}
								?>
							</div>
						</div>
					<?php } ?>
				</article><!-- .post -->
			</div>
			<div class="col-md-2"></div>
		</div>
	</div>
<?php } else { ?>
	<article <?php post_class($class); ?> id="post-<?php the_ID(); ?>">

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
						echo substr($post->post_content, 0, 100);
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
<?php } ?>
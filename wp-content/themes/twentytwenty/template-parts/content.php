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
if (is_search()) {
	$newClass = 'search-danh-sach';
}
if (is_single()) {
	$newClass = 'post-detail';
}
$has_sidebar_10 = is_active_sidebar('sidebar-10');
?>

<?php
if (!is_single() && !is_search()) { ?>
	<!-- Trang content !-->
	<article <?php post_class("home-page"); ?> id="post-<?php the_ID(); ?>">

		<?php

		#get_template_part('template-parts/entry-header');

		if (!is_search()) {
			get_template_part('template-parts/featured-image');
		}

		?>

		<div class="post-inner <?php echo is_page_template('templates/template-full-width.php') ? '' : 'thin'; ?> ">
			<div class="entry-content">
				<?php
				if (is_search() || !is_singular() && 'summary' === get_theme_mod('blog_content', 'full')) {
					the_excerpt();
				} else { ?>
					<div class="content-main">
						<div class="row">
							<div class="col-md-4 border-right border-dark">
								<div class="content-adjust-post-meta text-center">
									<?php
									format_post_time(get_the_ID());

									#twentytwenty_the_post_meta(get_the_ID(), 'single-top'); 
									?>
								</div>

							</div>
							<div class="col-md-6">
								<div class="content-adjust-post">
									<?php
									if (is_singular()) {
										the_title('<h1 class="entry-title">', '</h1>');
									} else {
										the_title('<h2 class="entry-title-adjust heading-size-1"><a href="' . esc_url(get_permalink()) . '">', '</a></h2>');
									}
									?>
									<?php
									$post = get_post();
									$content = $post->post_content;
									$content = preg_replace("/<\/?figure[^>]*\>/i", "", $content);
									$content = preg_replace("/<\/?img[^>]*\>/i", "", $content);
									$content = preg_replace("/<\/?figcaption[^>]*\>/i", "", $content);
									$content = substr($content, 0, 100);
									echo  $content . ' <a href= "' . esc_url(get_permalink()) . '" >[...]</a>';
									//echo  $content . printf('<a href="%s">%s</a>',esc_url(get_permalink()),'[...]');
									$post_date = $post->post_date;
									$post_date_day = date('d', strtotime($post_date));
									$post_date_month = date('m', strtotime($post_date));

									?>
								</div>
							</div>
						</div>
					</div>
				<?php } ?>

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

			<div class="comments-wrapper border-dark section-inner">

				<?php comments_template(); ?>

			</div><!-- .comments-wrapper -->

		<?php
		}
		?>

	</article><!-- .post -->
<?php } else { ?>
	<!-- Trang search !-->
	<article <?php post_class($newClass); ?> id="post-<?php the_ID(); ?>">

		<?php

		get_template_part('template-parts/entry-header');

		// Chèn thời gian
		if (is_single()) {
			echo '<div class="time-post">';
			$post_date = get_the_date('d', $post->ID);
			$post_month = get_the_date('m', $post->ID);
			$post_year = get_the_date('y', $post->ID);
			echo '<div class="box-date">';
			echo '<div class="head-dm">';
			echo '<div class="day">' . $post_date . '</div>';
			echo '<hr style="margin: 0;">';
			echo '<div class="month">' . $post_month . '</div>';
			echo '</div>';
			echo '<div class="year">' . $post_year . '</div>';
			echo '</div>';
			echo '</div>';
		}

		if (!is_search()) {
			get_template_part('template-parts/featured-image');
		}

		?>
		<div class="container-fluid">
		<div class="post-inner <?php echo is_page_template('templates/template-full-width.php') ? '' : 'thin'; ?> ">
			<div class="entry-content">
				<?php $has_sidebar_9 = is_active_sidebar('sidebar-9'); ?>
				<div class="row-adjust">
					<div class="col-sm-4">
						<div class="sidebar9">
							<?php if ($has_sidebar_9 == true) { ?>
								<div class="content-widgets-wrapper">
									<?php if ($has_sidebar_9 == true) { ?>
										<div class="content-widgets column-one grid-item">
											<?php dynamic_sidebar('sidebar-9'); ?>
										</div>
									<?php } ?>
								</div>
							<?php } ?>
						</div>
					</div>
					<div class="col-sm-4">
						<?php
						if (is_search() || !is_singular() && 'summary' === get_theme_mod('blog_content', 'full')) {
							the_excerpt();
						} else {
							// the_content( __( 'Continue reading', 'twentytwenty' ) );
							if (is_single()) {
								the_content(__('Continue reading', 'twentytwenty'));
							} else {
								$post = get_post();
								$content = $post->post_content;
								echo substr($content, 0, 120);
							}
						}
						?>
					</div>

					<div class="col-sm-4">
						<div class="sidebar10">
							<?php if ($has_sidebar_10  == true) { ?>
								<div class="content-widgets-wrapper">
									<?php if ($has_sidebar_10  == true) { ?>
										<div class="content-widgets column-one grid-item">
											<?php dynamic_sidebar('sidebar-10'); ?>
										</div>
									<?php } ?>
								</div>
							<?php } ?>
						</div>
					</div>
				</div>
			</div><!-- .entry-content -->

		</div><!-- .post-inner -->
		</div>
		

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
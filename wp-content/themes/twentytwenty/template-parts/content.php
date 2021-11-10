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
$class = "";
if (!is_single()) {
	$class = 'danh-sach';
}
?>
<?php if (is_single()) { ?>
	<div class="row">
		<div class="col-md-3">
			<div class="cate">
				<h2>Categories</h2>
				<div class="crossedbg-categories"></div>
				<div class="ul-cate">
					<ul>
						<?php $catID = get_terms('category');
						foreach ($catID as $key => $value) { ?>

							<li class="cate-name"><a href="<?= "http://" . $_SERVER["HTTP_HOST"]."/category/".$value->slug ?>"><?php echo $value->name ?></a></li>
						<?php } ?>
					</ul>
				</div>

			</div>
		</div>
		<div class="col-md-6">
			<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

				<?php

				get_template_part('template-parts/entry-header');

				if (!is_search()) {
					get_template_part('template-parts/featured-image');
				}

				?>

				<div class="post-inner <?php echo is_page_template('templates/template-full-width.php') ? '' : 'thin'; ?> ">
					<!-- overviewline -->
					<div class="overviewline"></div>
					<div class="entry-content-1">

						<?php
						if (is_search() || !is_singular() && 'summary' === get_theme_mod('blog_content', 'full')) {
							the_excerpt();
						} else {
							the_content(__('Continue reading', 'twentytwenty'));
						}
						?>

					</div><!-- .entry-content -->

				</div><!-- .post-inner -->

				<div class="section-inner-1">
					<?php
					wp_link_pages(
						array(
							'before'      => '<nav class="post-nav-links bg-light-background" aria-label="' . esc_attr__('Page', 'twentytwenty') . '"><span class="label">' . __('Pages:', 'twentytwenty') . '</span>',
							'after'       => '</nav>',
							'link_before' => '<span class="page-number">',
							'link_after'  => '</span>',
						)
					);

					edit_post_link(); // edit last


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

				?>

			</article><!-- .post -->
		</div>
		<div class="col-md-3">
			<div class="rp-box">
				<div class="crossedbg"></div>
				<?php dynamic_sidebar('sidebar-3'); ?>

			</div>
		</div>
	</div>
	<?php if ((is_single() || is_page()) && (comments_open() || get_comments_number()) && !post_password_required()) {
	?>

		<div class="comments-wrapper section-inner">

			<?php comments_template(); ?>

		</div><!-- .comments-wrapper -->

	<?php
	}
	?>
<?php } ?>

<!-- home -->
<?php if (!is_single()) { ?>

	<article <?php post_class($class); ?> id="post-<?php the_ID(); ?>">

<?php

if(is_single()){

	get_template_part('template-parts/entry-header');
}


if (!is_search()) {
	get_template_part('template-parts/featured-image');
}

?>

<div class="post-inner <?php echo is_page_template('templates/template-full-width.php') ? '' : 'thin'; ?> ">

	<div class="entry-content">

		<?php
		if (!is_singular() && 'summary' === get_theme_mod('blog_content', 'full')) {
			the_excerpt();
			
		} else {
			if (is_single()) {
				the_content(__('Continue reading', 'twentytwenty'));
			} else {
				$post = get_post();
				$date = date('d',strtotime($post->post_date));
				$month = date('m',strtotime($post->post_date));
				// // var_dump($date);
				// var_dump($post);
				//die();
		?>
				<div class="list_news">
					<div class="list_new_view">
						<div class="row">
							<?php if (is_search()){?>
								<div class="col-md-5">
									<div class="top_news_block_thumb">
										<img src="<?= get_the_post_thumbnail_url($post) ?>">
									</div>
								</div>
								<div class="col-md-7 top_news_block_desc">
								<div class="row">
									<div class="col-md-3 col-xs-3 topnewstime">
										<span class="topnewsdate"><?php echo $date ?></span><br>
										<span class="topnewsmonth">Thang <?php echo $month ?></span><br>
									</div>
									<div class="col-md-9 col-xs-9 shortdesc">
										<h4 class="entry-title">
											<a href="<?php echo esc_url(get_permalink()) ?>"><?php echo $post->post_title ?></a>
										</h4>
										<p><?php echo substr($post->post_content, 0, 100);  ?><a href="<?php echo esc_url(get_permalink()) ?>">[...]</a></p>
									</div>

								</div>
							</div>
							<?php } else {?>
							<div class="col-md-12 top_news_block_desc">
								<div class="row">
									<div class="col-md-3 col-xs-3 topnewstime">
										<span class="topnewsdate"><?php echo $date ?></span><br>
										<span class="topnewsmonth">Tháng <?php echo $month ?></span><br>
									</div>
									<div class="col-md-9 col-xs-9 shortdesc">
										<h4 class="entry-title">
											<a href="<?php echo esc_url(get_permalink()) ?>"><?php echo $post->post_title ?></a>
										</h4>
										<p><?php echo substr($post->post_content, 0, 100);  ?><a href="<?php echo esc_url(get_permalink()) ?>">[...]</a></p>
									</div>

								</div>
							</div>
							<?php } ?>
						</div>
					</div>
				</div>

		<?php }
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

</article>
<?php } ?>
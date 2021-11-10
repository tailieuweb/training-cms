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

$has_sidebar_9 = is_active_sidebar('module-9');
$class = '';
if (!is_single()) {
	$class = 'danh-sach';
}
?>
<?php
$post = get_post();
$day = $month = $year = 0;
if (strtotime($post->post_date)) {
	$timestamp = strtotime($post->post_date);
	$day = date("d", $timestamp);
	$month = date("m", $timestamp);
	$year = date("y", $timestamp);
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
					<div class="row rowContent">
						<!-- Module-9-->
						<div class="col-md-3">

							<div class="footer-widgets-wrapper">

								<div class="footer-widgets9 column-one grid-item ">
									<?php dynamic_sidebar('module-9'); ?>
								</div>

							</div>

						</div>
						<!-- Module-6 -->
						<div class="col-md-6">

							<div class="row">
								<div class="col-md-10 col-xs-9">
									<?php the_title('<h1 class="entry-title">', '</h1>'); ?>
								</div>
								<div class="col-md-2 col-xs-3">
									<div class="headlinesdate">
										<div class="headlinesdm">
											<div class="headlinesday"><?php echo $day ?></div>
											<div class="headlinesmonth"><?php echo $month ?></div>
										</div>
										<div class="headlinesyear"><?php echo "'" . $year ?></div>
									</div>
								</div>
							</div>


							<div class="row">
								<div class="col-md-12">
									<div class="overviewline"></div>
								</div>
							</div>





							<div class="detail-post-content">
								<?php
								the_content(__('Continue reading', 'twentytwenty'));
								?>
							</div>
							<div class="author-module-6"><?php echo "(Theo " . get_the_author() . ")"; ?></div>

						</div>
						<!-- Module-10 -->
						<div class="col-md-3">
							<div class="footer-widgets column-one grid-item rowRecent">
								<div class="widget widget_block">
									<div class="widget-content">
										<div class="wp-block-group">
											<div class="wp-block-group__inner-container">
												<h2 class="module-10-recent">Recent Posts</h2>
												<div class="bg_gray"></div>
												<div class="list-group">
													<ul class="wp-block-latest-posts__list wp-block-latest-posts">
														<li class="module-10-listLi"><a class="module-10-listA" href="http://wordpress.local:82/2021/09/30/pin-co-the-uon-va-co-gian-nhu-ran/">Pin có thể uốn và co giãn như rắn</a></li>
														<li class="module-10-listLi"><a class="module-10-listA" href="http://wordpress.local:82/2021/09/30/tim-nguoi-gioi-cho-nhung-nghien-cuu-hang-dau-tai-vkist/">Tìm người giỏi cho những nghiên cứu hàng đầu tại VKIST</a></li>
														<li class="module-10-listLi"><a class="module-10-listA" href="http://wordpress.local:82/2021/09/30/usyk-khong-muon-knock-out-joshua/">Usyk không muốn knock-out Joshua</a></li>
														<li class="module-10-listLi"><a class="module-10-listA" class="module-10-listA" href="http://wordpress.local:82/2021/09/30/bo-dao-nha-vao-chung-ket-futsal-world-cup/">Bồ Đào Nha vào chung kết futsal World Cup</a></li>
														<li class="module-10-listLi"><a class="module-10-listA" href="http://wordpress.local:82/2021/09/30/mourinho-cham-moc-200-tran-tai-cup-chau-au/">Mourinho chạm mốc 200 trận tại Cup châu Âu</a></li>
													</ul>
												</div>

											</div>
										</div>
									</div>
								</div>
								<div class="widget widget_block">
									<div class="widget-content">
										<div class="wp-block-group">
											<div class="wp-block-group__inner-container"></div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php
				} else {

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
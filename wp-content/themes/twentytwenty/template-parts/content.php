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
<!--content-->
<?php
$class = "";
if (is_single()) {
	$class = "chi-tiet";
} else if (is_search()) {
	$class = "tim-kiem";
} else {
	$class = "trang-chu";
}
?>
<?php
if (is_search()) {
?>
	<div class="ct">
		<div class="container">
			<div class="row">
				<div class="col-md-5 ct-img">
					<?php
					$post = get_post();
					$post_image = get_the_post_thumbnail($post->ID, 'thumbnail');

					echo $post_image;
					?>
				</div>
				<div class="col-md-2 col-xs-3 topnewstime">
					<span class="topnewsdate">30</span><br>
					<span class="topnewsmonth">Tháng 9</span><br>
				</div>
				<div class="col-md-5 content">
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
										echo substr($post->post_content, 0, 150) . "[...]";
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
				</div>
			</div>
		</div>
	</div>
	<hr class="hr">
<?php } else if (is_single()) {
?>

	<article <?php post_class($class); ?> id="post-<?php the_ID(); ?>">
		<div class="row">
			<div class="col-md-3">
				<div class="cate">
					<h2>Categories</h2>
					<div class="crossedbg-categories"></div>
					<div class="ul-cate">
						<ul>
							<?php $catID = get_terms('category');
							foreach ($catID as $key => $value) { ?>

								<li class="cate-name"><a href="<?= "http://" . $_SERVER["HTTP_HOST"] . "/category/" . $value->slug ?>"><?php echo $value->name ?></a></li>
							<?php } ?>
						</ul>
					</div>
				</div>
				<div class="cate">
					<h2>Post Effect</h2>
					<div class="crossedbg-categories"></div>
					<div class="widget html" style="margin-right: 40px; margin-top: -80px; margin-left: -10px;">
						<div class="holder">
							<div class="cube">
								<div class="face front" style="transform: translateZ(120px);">
									<a href="http://wordpress.local/2021/09/30/pin-co-the-uon-va-co-gian-nhu-ran/">
										<img src="http://wordpress.local/wp-content/uploads/2021/09/Pin-ran-7204-1632994229-150x150.jpg" alt="" class="cube-img">
									</a>
									<div class="txt" style="text-align: center; margin-top: 30px;">

										<div style="font-size: 20px; font-weight: bold; background-color: #0a5697; background-size: 100%; -webkit-background-clip: text; -moz-background-clip: text; -webkit-text-fill-color: transparent; -moz-text-fill-color: transparent; backface-visibility: hidden; transform: translateZ(30px)">
											PIN CÓ THỂ UỐN VÀ CO GIÃN NHƯ RẮN
										</div>
									</div>
								</div>
								<div class="face back" style="transform: rotateY(180deg) translateZ(120px);">
									<a href="http://wordpress.local/2021/09/30/tim-nguoi-gioi-cho-nhung-nghien-cuu-hang-dau-tai-vkist/">
										<img src="http://wordpress.local/wp-content/uploads/2021/09/BT-Dat-2430-1632996417-150x150.jpg" alt="" class="cube-img">
									</a>
									<div class="txt" style="text-align: center; margin-top: 30px;">

										<div style="font-size: 20px; font-weight: bold; background-color: #0a5697; background-size: 100%; -webkit-background-clip: text; -moz-background-clip: text; -webkit-text-fill-color: transparent; -moz-text-fill-color: transparent; backface-visibility: hidden; transform: translateZ(30px)">
											TÌM NGƯỜI GIỎI CHO NHỮNG NGHIÊN CỨU HÀNG ĐẦU TẠI VKIST
										</div>
									</div>
								</div>
								<div class="face left" style="transform: rotateY(-90deg) translateZ(120px);">
									<a href="http://wordpress.local/2021/09/30/usyk-khong-muon-knock-out-joshua/">
										<img src="http://wordpress.local/wp-content/uploads/2021/09/AP-jpeg-8023-1633017280-150x150.jpg" alt="" class="cube-img">
									</a>
									<div class="txt" style="text-align: center; margin-top: 30px;">

										<div style="font-size: 20px; font-weight: bold; background-color: #0a5697;  background-size: 100%; -webkit-background-clip: text; -moz-background-clip: text; -webkit-text-fill-color: transparent; -moz-text-fill-color: transparent; backface-visibility: hidden; transform: translateZ(30px)">
											USYK KHÔNG MUỐN KNOCK-OUT JOSHUA
										</div>
									</div>
								</div>
								<div class="face right" style="transform: rotateY(90deg) translateZ(120px);">
									<a href="http://wordpress.local/2021/09/30/bo-dao-nha-vao-chung-ket-futsal-world-cup/">
										<img src="http://wordpress.local/wp-content/uploads/2021/09/gettyimages-1344118969-2048x20-7575-9489-1633032281-150x150.jpg" alt="" class="cube-img">
									</a>
									<div class="txt" style="text-align: center; margin-top: 30px;">

										<div style="font-size: 20px; font-weight: bold; background-color: #0a5697; background-size: 100%; -webkit-background-clip: text; -moz-background-clip: text; -webkit-text-fill-color: transparent; -moz-text-fill-color: transparent; backface-visibility: hidden; transform: translateZ(30px)">
											BỒ ĐÀO NHA VÀO CHUNG KẾT FUTSAL WORLD CUP
										</div>
									</div>
								</div>
							</div>
						</div>
						</a>
						<script>
							w = document.querySelector('.holder').offsetWidth / 2;
							document.querySelector('.front').style.transform = `translateZ(${w}px)`;
							document.querySelector('.back').style.transform = `rotateY(180deg) translateZ(${w}px)`;
							document.querySelector('.left').style.transform = `rotateY(-90deg) translateZ(${w}px)`;
							document.querySelector('.right').style.transform = `rotateY(90deg) translateZ(${w}px)`;
						</script>
						<div class="divider"></div>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="header">
					<div class="row">
						<div class="col-md-8">
							<?php
							get_template_part('template-parts/entry-header');
							?>
						</div>
						<div class="col-md-2">
							<div class="headlinesdate">
								<div class="headlinesdm">
									<div class="headlinesday">30</div>
									<div class="headlinesmonth">09</div>
								</div>
								<div class="headlinesyear">'21</div>
							</div>
						</div>
					</div>
				</div>
				<?php
				if (!is_search()) {
					get_template_part('template-parts/featured-image');
				}

				?>
				<div class="gn">
					<div class="container">
						<div class="row">
							<div class="col-md-12">
								<div class="overviewline"></div>
							</div>
						</div>

						<br>
						<br>

						<div class="entry-content">

							<?php
							if (is_search() || !is_singular() && 'summary' === get_theme_mod('blog_content', 'full')) {
								the_excerpt();
							} else {
								if (is_single()) {
									the_content(__('Continue reading', 'twentytwenty'));
								} else {
									$post = get_post();
									echo substr($post->post_content, 0, 150) . "[...]";
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
				</div>
			</div>
			<div class="col-md-3">
				<div class="cate">
					<h2>Recent Post</h2>
					<div class="crossedbg-categories"></div>
					<div class="ul-cate">
						<ul>
							<?php $catID = get_terms('category'); ?>

							<li class="cate-name">
								<a href="http://wordpress.local/2021/09/30/pin-co-the-uon-va-co-gian-nhu-ran/">Pin có thể uốn và co giãn như rắn</a>
							</li>
							<li class="cate-name">
								<a href="http://wordpress.local/2021/09/30/tim-nguoi-gioi-cho-nhung-nghien-cuu-hang-dau-tai-vkist/">Tìm người giỏi cho những nghiên cứu hàng đầu tại VKIST</a>
							</li>
							<li class="cate-name">
								<a href="http://wordpress.local/2021/09/30/usyk-khong-muon-knock-out-joshua/">Usyk không muốn knock-out Joshua</a>
							</li>
							<li class="cate-name">
								<a href="http://wordpress.local/2021/09/30/bo-dao-nha-vao-chung-ket-futsal-world-cup/">Bồ Đào Nha vào chung kết futsal World Cup</a>
							</li>
							<li class="cate-name">
								<a href="http://wordpress.local/2021/09/30/mourinho-cham-moc-200-tran-tai-cup-chau-au/">Mourinho chạm mốc 200 trận tại Cup châu Âu</a>
							</li>
						</ul>
					</div>
				</div>
				<div class="cate">
					<h2>Related Post</h2>
					<div class="crossedbg-categories"></div>
					<div class="ul-cate">
						<ul>
							<?php
							$cate = get_term($post->ID);
							$args = array(
								'post_type' => 'post',
								'orderby' => 'rand',
								'post__not_in' => array($post->ID),
								'posts_per_page' => '3',
							);
							$other_post = new WP_Query($args);
							if ($other_post->have_posts()) :
								while ($other_post->have_posts()) : $other_post->the_post();
							?>
									<li class="cate-name">
										<a href="<?php the_permalink() ?>"><?php the_title() ?></a>
									</li>
							<?php
								endwhile;
							endif;
							?>
						</ul>
					</div>
				</div>
			</div>
	</article><!-- .post -->
	<div class="next">
		<?php

		if (is_single()) {

			get_template_part('template-parts/navigation');
		}
		?>
	</div>
	<?php

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
<?php } else { ?>
	<div class="ct">
		<div class="container">
			<article <?php post_class($class); ?> id="post-<?php the_ID(); ?>">
				<div class="row">
					<div class="col-md-3">
						<div class="cate">
							<h2>Menu</h2>
							<div class="crossedbg-categories"></div>
							<div class="ul-cate">
								<ul>
									<?php $catID = get_terms('category');
									foreach ($catID as $key => $value) { ?>

										<li class="cate-name"><a href="<?= "http://" . $_SERVER["HTTP_HOST"] . "/category/" . $value->slug ?>"><?php echo $value->name ?></a></li>
									<?php } ?>
								</ul>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="col-md-3 col-xs-3 topnewstime">
							<span class="topnewsdate">30</span><br>
							<span class="topnewsmonth">Tháng 9</span><br>
						</div>
						<div class="col-md-9">


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
											echo substr($post->post_content, 0, 150) . "[...]";
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
						</div>
					</div>
					<div class="col-md-3">
						<div class="rp-box">
							<h2>Comment</h2>						
							<div class="crossedbg"></div>
							<?php dynamic_sidebar('sidebar-4'); ?>
							<p>Hello</p>
							<p>asdada</p>
						</div>
					</div>
				</div>

			</article><!-- .post -->
		</div>
	</div>
	<?php

	if (is_single()) {

		get_template_part('template-parts/navigation');
	}

	/*
		* Output comments wrapper if it's a post, or if comments are open,
		* or if there's a comment number – and check for password.
		*/
	?>

	<?php
	if ((is_single() || is_page()) && (comments_open() || get_comments_number()) && !post_password_required()) {
	?>

		<div class="comments-wrapper section-inner">

			<?php comments_template(); ?>

		</div><!-- .comments-wrapper -->

	<?php
	}
	?>
	<hr class="hr">
<?php } ?>
<!-- link add file css và file php -->
<link rel="stylesheet" href="<?php echo get_template_directory_uri() ?>/modul5.css">
<?php

/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */
$post_meta = apply_filters(
	'twentytwenty_post_meta_location_single_top',
	array(
		'post-date',
	)
);

get_header();
//Ngọc Yến- module 12 
$has_sidebar_12 = is_active_sidebar('sidebar-12');
?>

<main id="site-content" role="main">
	<!-- chia cột để hiển thị module 12 -by Ngọc Yến --->
	<?php
	//header
	$archive_title    = '';
	$archive_subtitle = '';

	if (is_search()) {
		global $wp_query;

		$archive_title = sprintf(
			'%1$s %2$s',
			'<span class="color-accent">' . __('Search:', 'twentytwenty') . '</span>',
			'&ldquo;' . get_search_query() . '&rdquo;'
		);

		if ($wp_query->found_posts) {
			$archive_subtitle = sprintf(
				/* translators: %s: Number of search results. */
				_n(
					'We found %s result for your search.',
					'We found %s results for your search.',
					$wp_query->found_posts,
					'twentytwenty'
				),
				number_format_i18n($wp_query->found_posts)
			);
		} else {
			$archive_subtitle = __('We could not find any results for your search. You can give it another try through the search form below.', 'twentytwenty');
		}
	} elseif (is_archive() && !have_posts()) {
		$archive_title = __('Nothing Found', 'twentytwenty');
	} elseif (!is_home()) {
		$archive_title    = get_the_archive_title();
		$archive_subtitle = get_the_archive_description();
	}
	if ($archive_title || $archive_subtitle) {
	?>

		<header class="archive-header has-text-align-center header-footer-group">

			<div class="archive-header-inner section-inner medium">

				<?php if ($archive_title) { ?>
					<h1 class="archive-title"><?php echo wp_kses_post($archive_title); ?></h1>
				<?php } ?>

				<?php if ($archive_subtitle) { ?>
					<div class="archive-subtitle section-inner thin max-percentage intro-text"><?php echo wp_kses_post(wpautop($archive_subtitle)); ?></div>
				<?php } ?>

			</div><!-- .archive-header-inner -->

		</header><!-- .archive-header -->

	<?php
	}
	?>

	<!-- post -->
	<div class="row">

		<div class="col-md-9">
			<?php
			if (have_posts()) {
				//khi không ở trang chi tiết
				//By : Nguyễn Thị Thanh Thư
				// hàm tách lấy ảnh. m5
				function catch_that_image($input_post_content)
				{
					$first_img = '';
					ob_start();
					ob_end_clean();

					// regex
					$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $input_post_content, $matches);
					// danh sách kết quả match với chuỗi regex.
					$first_img = $matches[1][0];

					if (empty($first_img)) { //Defines a default image
						$first_img = "/images/default.jpg"; //Duong dan anh mac dinh khi khong tim duoc anh dai dien
					}

					return $first_img;
				}
				$i = 0;

				while (have_posts()) {
					$i++;
					//  khi không ở trang search
					// 	By : Nguyễn Thị Thanh Thư
					// 	chia cột và date. m2 
					if (!is_search()) {
						if ($i > 1) {
							echo "<div style='margin-top: 10px;'></div>";
						} ?>
						<div class="baro">
							<div class="row">
								<!-- khi không ở trang search
			 			By : Nguyễn Thị Thanh Thư
		 				date. m2  -->
								<div class="col-2 verticalLine">
									<?php
									// Post date.
									if (in_array('post-date', $post_meta, true)) {
										$has_meta = true;
									?>
										<div class="dinhDangDay">
											<p class="meta-day">
												<?php the_time("d"); ?>
											</p>
											<p class="meta-thang">
												<?php echo 'tháng ', the_time("m"); ?>
											</p>
										</div>
									<?php
									} ?>
								</div>
								<div class="col-10">
									<?php
									the_post();
									get_template_part('template-parts/content', get_post_type());
									?>
								</div>
							</div>
						</div>
					<?php

					}
					// khi ở trang search
					// 	By : Nguyễn Thị Thanh Thư
					// 	chia cột, date, gắn ảnh. m5
					elseif (is_search()) {

						if ($i > 1) {
							echo "<div style='margin-top: 10px;'></div>";
						} ?>
						<!-- khi ở trang search
				By : Nguyễn Thị Thanh Thư
		 		gắn ảnh. m5 -->
						<div class="baro">
							<div class="row">
								<div class="col-3">
									<?php the_post();

									// lấy bài post hiện tại tương ứng.
									$_post = get_post();
									// đường dẫn ảnh tìm thấy đầu tiên.
									$_image = catch_that_image($_post->post_content);
									// hiển thị ảnh.
									echo "<img src='$_image' />";
									?>
								</div>
								<div class="col-9">
									<div class="row">
										<!-- khi không ở trang search
			 					By : Nguyễn Thị Thanh Thư
		 						date. m5  -->
										<div class="col-2 verticalLine">
											<?php
											// Post date.
											if (in_array('post-date', $post_meta, true)) {
												$has_meta = true;
											?>
												<div class="dinhDangDay">
													<p class="meta-day">
														<?php the_time("d"); ?>
													</p>
													<p class="meta-thang">
														<?php echo 'tháng ', the_time("m"); ?>
													</p>
												</div>
											<?php
											} ?>
										</div>
										<div class="col-10 noidung">
											<?php
											the_post();
											get_template_part('template-parts/content', get_post_type());
											?>
										</div>
									</div>
								</div>
							</div>
						</div>

				<?php
					}
				}
			} elseif (is_search()) {
				?>
			<?php
			}
			?>

		</div><!-- .no-search-results -->

		<div class="col-md-3">
			<?php if ($has_sidebar_12) { ?>

				<div class="footer-widgets column-three grid-item" id="sidebar-right">
					<?php dynamic_sidebar('sidebar-12'); ?>
				</div>

			<?php } ?>
		</div>

		<?php get_template_part('template-parts/pagination'); ?>

	</div>
	<!-- đây là module 12  - by Ngọc Yến -->

	</div>
</main><!-- #site-content -->

<?php get_template_part('template-parts/footer-menus-widgets'); ?>

<?php
get_footer();
?>
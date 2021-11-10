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

get_header();
?>

<main id="site-content" role="main">

	<?php

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


	// ____________________________________________________________________________________________________
	// LIST OF POSTS DISPLAYED BY SEARCH RESULTS OR BY DEFAULT:
	if (have_posts()) {

		if (is_search()) {
			// Người làm : Nguyễn Phúc Linh
			// Module: 5
			// Công việc: Tùy chỉnh giao diện danh sách bài viết tại trang tìm kiếm.

			// var_dump('These are search results!');
			// var_dump(get_post());

			while (have_posts()) {
				the_post();
				
				// Get posts:
				$_post = get_post();

				// Get post title:
				$post_title = $post->post_title;

				// Get post content:
				$content = $post->post_content;
				// $strContent = preg_replace('/\<figure class=\"wp-block-image\"\>(.*?)\<\/figure\>/', '', $content);
				// $temp = str_replace('<p>', '', $strContent);
				// $strContent = str_replace('</p>', '', $temp);
				// $temp = mb_substr($strContent, 0, 200);
				// $temp = addslashes($temp);
				$temp = substr(
					$_post->post_content,
					strpos($_post->post_content, "<!-- wp:paragraph -->"),
					strpos($_post->post_content, "<!-- /wp:paragraph -->")
				);

				// Get post url:
				$post_url = get_permalink();

				// Get post image url:
				preg_match('/src="([^"]*)"/', $content, $matches);
				preg_match('/(?<!_)src=([\'"])?(.*?)\\1/', $content, $matches);
				$post_img_element = "";
				if (count($matches) != 0) {
					$post_img_element = "<img $matches[0]>";
				}

				// Get post creation date:
				$day = substr(get_post()->post_date, 8, 2);
				$month = substr(get_post()->post_date, 5, 2);
				$year = substr(get_post()->post_date, 0, 4);

				// Display:
				echo "
				<div class='module5-search-results'>
					<div class='row module5-card-wrapper'>
						<div class='col-md-7 module5-card'>
							<div class='row'>

								<div class='col-md-7 col-xs-7 left-section'>
									<div class='section-wrapper'>
										<div class='img-wrapper'>
											$post_img_element
										</div>
										<div class='creation-date-wrapper'>
											<div class='day'>$day</div>
											<div class='month'>Tháng $month</div><br>
										</div>
									</div>
								</div>
								<div class='col-md-5 col-xs-5 right-section'>
									<div class='content-wrapper'>
										<div class='post-title-wrapper'>
											<a class='post-title' href='$post_url'>$post_title</a>
										</div>
										$temp <a href='$post_url'>[...]</a>
									</div>
								</div>

							</div>
						</div>
					</div>
				</div>
            	";
			}
		} else {
			// $i = 0;

			while (have_posts()) {
				// Người làm : Lê Anh Vũ
				// Module: 2
				// Công việc: Tùy chỉnh giao diện danh sách bài viết tại trang chủ.

				// lấy bài viết.
				$_post = get_post();

				// lấy tiêu đề bài viết.
				$_new_string_title = $_post->post_title;

				// lấy ngày-tháng-năm của bài viết.
				$_new_post_date = $_post->post_date;
				$time = strtotime($_new_post_date);
				$new_format = date('Y-m-d', $time);
				$_explode = explode("-", $new_format);
				$_day = $_explode[2];
				$_month = $_explode[1];
				$_year = $_explode[0];

				// lấy nội dung chính bài viết.
				$_new_string_content = substr(
					$_post->post_content,
					strpos($_post->post_content, "<!-- wp:paragraph -->"),
					strpos($_post->post_content, "<!-- /wp:paragraph -->")
				);

				// lấy ảnh bài viết.
				$_new_string_image = substr(
					$_post->post_content,
					strpos($_post->post_content, "<!-- wp:image -->"),
					strpos($_post->post_content, "<!-- /wp:image -->")
				);

				// lấy đường dẫn đến trang chi tiết bài viết.
				// $_new_string_guid = $_post->guid;
				$_new_string_guid = get_permalink();

				// hiển thị nội dung chỉnh sửa theo yêu cầu.
				echo "
				<div class='list_new_view'>
					<div class='row vu-class-center'>
						<div class='col-md-7 top_news_block_desc'>
							<div class='row'>
								<div class='col-md-3 col-xs-3 topnewstime'>
									<span class='topnewsdate'>$_day</span><br>
									<span class='topnewsmonth'>Tháng $_month</span><br>
								</div>
								<div class='col-md-9 col-xs-9 shortdesc'>
									<h4>
										<a href='$_new_string_guid'>$_new_string_title</a>
									</h4>
									$_new_string_content <a href='$_new_string_guid'>[...]</a>
								</div>

							</div>
						</div>
					</div>
				</div>
                ";

				the_post();
			}
		}
	} elseif (is_search()) {
	?>

		<div class="no-search-results-form section-inner thin">

			<?php
			get_search_form(
				array(
					'aria_label' => __('search again', 'twentytwenty'),
				)
			);
			?>

		</div><!-- .no-search-results -->

	<?php
	}
	?>

	<?php get_template_part('template-parts/pagination'); ?>

</main><!-- #site-content -->

<?php get_template_part('template-parts/footer-menus-widgets'); ?>

<?php
get_footer();

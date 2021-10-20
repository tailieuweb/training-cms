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

	if (have_posts()) {

		$i = 0;

		while (have_posts()) {
			// $i++;
			// if ( $i > 1 ) {
			// 	echo '<hr class="post-separator styled-separator is-style-wide section-inner" aria-hidden="true" />';
			// }
			the_post();
			$post = get_post();
			//Lấy thông tin từ $post
			$post_title = $post->post_title;
			$post_date = get_the_date('d', $post->ID);
			$post_month = get_the_date('F', $post->ID);
			$post_content = substr(
				$post->post_content,
				strpos($post->post_content, "<!-- wp:paragraph -->"),
				strpos($post->post_content, "<!-- /wp:paragraph -->")
			);
			$post_image = get_the_post_thumbnail($post->ID, 'thumbnail');
			$post_guid = $post->guid;
			//var_dump($post);
			//get_template_part( 'template-parts/content', get_post_type() );

			// Xuất dữ liệu đã lấy
		?>
			<div class="list_new">
				<div class='list_new_view'>
					<div class='row'>
						<div class="col-md-2">
							<div class="top_news_block_thumb">
								<?= $post_image ?>
							</div>
						</div>
						<div class='col-md-10 top_news_block_desc'>
							<div class='row'>
								<div class='col-md-3 col-xs-3 topnewstime'>
									<span class='topnewsdate'><?= $post_date ?></span><br>
									<span class='topnewsmonth'><?= $post_month ?></span><br>
								</div>
								<div class='col-md-9 col-xs-9 shortdesc'>
									<h4>
										<a href='<?= $post_guid ?>'><?= $post_title ?></a>
									</h4>
									<?= $post_content ?> <a href='<?= $post_guid ?>'>[...]</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php
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

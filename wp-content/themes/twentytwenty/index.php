 <style>
 	.meta-day {
 		font-family: 'Prata', serif;
 		font-size: 3.1em;
 		line-height: 1em;
 		position: sticky !important;
 		margin-top: 20px;
 	}

 	.meta-thang {
 		text-transform: uppercase;
 		font-size: 0.9em;
 		position: sticky !important;
 		margin-top: -50px;
 		/* margin-left: 50px; */
 	}

 	.meta-month {
 		text-transform: uppercase;
 		font-size: 0.9em;
 		position: sticky !important;
 		margin-top: -10px;
 		/* margin-left: 50px; */

 	}

 	.dinhDangDay {
 		text-align: center !important;
 	}

 	.post-doithay {
 		padding-left: 20px !important;
 	}

 	.col-md-10:before {
 		content: "";
 		height: 250px;
 		display: table !important;
 		box-sizing: border-box !important;
 		background-color: black;
 		width: 1px;
 		margin-top: 10px;
 		position: absolute;
 	}
 </style>

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
	?>

 <main id="site-content" role="main">

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


		//post

		if (have_posts()) {

			$i = 0;

			while (have_posts()) {
				$i++;
				if ($i > 1) {
					echo '<hr class="post-separator styled-separator is-style-wide section-inner" aria-hidden="true" />';
				} ?>
 			<div class="row">
 				<div class="col-md-2">
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
 				<div class="col-md-10">
 					<div class="post-doithay">
 						<?php
							the_post();
							get_template_part('template-parts/content', get_post_type());
							?>
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

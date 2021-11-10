	<!-- link kêt nối file css vào php -->
	<link rel="stylesheet" href="<?php echo get_template_directory_uri() ?>./modul2.css">
	<?php
	/**
	 * Displays the post header
	 *
	 * @package WordPress
	 * @subpackage Twenty_Twenty
	 * @since Twenty Twenty 1.0
	 */

	$entry_header_classes = '';

	if (is_singular()) {
		$entry_header_classes .= ' header-footer-group';
	}

	?>

	<header class="entry-header has-text-align-center<?php echo esc_attr($entry_header_classes); ?>">

		<?php
		//khi không ở trang chi tiết
		//By : Nguyễn Thị Thanh Thư
		//Hiện thị đủ các category(thể loại), by admin(người viết), date(ngày tháng năm),cmt, tiêu đề màu đen
		if (is_single()) {
		?>
			<div class="entry-header-inner section-inner medium">

				<?php
				/**
				 * Allow child themes and plugins to filter the display of the categories in the entry header.
				 *
				 * @since Twenty Twenty 1.0
				 *
				 * @param bool Whether to show the categories in header. Default true.
				 */
				$show_categories = apply_filters('twentytwenty_show_categories_in_entry_header', true);

				if (true === $show_categories && has_category()) {
				?>

					<div class="entry-categories">
						<span class="screen-reader-text"><?php _e('Categories', 'twentytwenty'); ?></span>
						<div class="entry-categories-inner">
							<?php the_category(' '); ?>
						</div><!-- .entry-categories-inner -->
					</div><!-- .entry-categories -->

				<?php
				}

				if (is_singular()) {
					the_title('<h1 class="entry-title">', '</h1>');
				} else {
					the_title('<h2 class="entry-title heading-size-1"><a href="' . esc_url(get_permalink()) . '">', '</a></h2>');
				}

				$intro_text_width = '';

				if (is_singular()) {
					$intro_text_width = ' small';
				} else {
					$intro_text_width = ' thin';
				}

				if (has_excerpt() && is_singular()) {
				?>

					<div class="intro-text section-inner max-percentage<?php echo $intro_text_width; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static output 
																		?>">
						<?php the_excerpt(); ?>
					</div>

				<?php
				}

				// Default to displaying the post meta.
				twentytwenty_the_post_meta(get_the_ID(), 'single-top');
				?>

			</div><!-- .entry-header-inner -->
		<?php
		}
		//khi không ở trang chi tiết
		//By : Nguyễn Thị Thanh Thư
		//chỉ vòn tiêu đề màu xanh
		else { ?>
			<div class="hea-post">
				<?php
				?>

				<div class="entry-header-inner section-inner medium">

					<?php


					if (is_singular()) {
						the_title('<h1 class="entry-title">', '</h1>');
					} else {
						the_title('<h2 class="entry-title heading-size-1"><a class="title-blue" href="' . esc_url(get_permalink()) . '">', '</a></h2>');
					}

					$intro_text_width = '';

					if (is_singular()) {
						$intro_text_width = ' small';
					} else {
						$intro_text_width = ' thin';
					}

					if (has_excerpt() && is_singular()) {
					?>

						<div class="intro-text section-inner max-percentage<?php echo $intro_text_width; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static output 
																			?>">
							<?php the_excerpt(); ?>
						</div>

					<?php
					}

					// Default to displaying the post meta.
					twentytwenty_the_post_meta(get_the_ID(), 'single-top');
					?>

				</div><!-- .entry-header-inner -->

			</div>
		<?php
		}
		?>


	</header><!-- .entry-header -->
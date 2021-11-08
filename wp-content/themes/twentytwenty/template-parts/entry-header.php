<?php

/**
 * Displays the post header
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */
get_header();
$has_sidebar_9 = is_active_sidebar('sidebar-9');
$has_sidebar_10 = is_active_sidebar('sidebar-10');
$entry_header_classes = '';

if (is_singular()) {
	$entry_header_classes .= ' header-footer-group';
}
if (is_single()) {
	$class = 'footer-widgets-wrapper1';
}
$type_post = '';
if (is_single()) {
	$type_post = 'single-top';
} else {
	$type_post = 'single-date';
}
?>

<header class="entry-header has-text-align-center<?php echo esc_attr($entry_header_classes); ?>">
    <?php if (is_single()) { ?>
    <div class="row">
	<div class="col-md-3 module9"style="margin-top: -11px;">
            <?php } ?>
            <?php if ($has_sidebar_9 && is_single()) { ?>
            <div class="footer-widgets-wrapper9">
                <?php if ($has_sidebar_9 && is_single()) { ?>
                <div class="footer-widgets1 column-one grid-item">
                    <div class="categories_module9" style="background:white;">
					<?php dynamic_sidebar('sidebar-9'); ?>
					</div>
                    <?php } ?>
                </div>
            </div>
            <?php } ?>
            <?php if ($has_sidebar_9 && is_single()) { ?>

            <?php }
			if (is_single()) { ?>
        </div>
        <div class="col-md-6 content_module6" >
            <?php } ?>

            <div class="entry-header-inner section-inner medium">
                <?php
				if (!is_single()) {

					// Default to displaying the post meta.
					twentytwenty_the_post_meta(get_the_ID(), $type_post);
				}
				?>

                <div class="entry-header-inner section-inner-content">

                    <?php
					/**
					 * Allow child themes and plugins to filter the display of the categories in the entry header.
					 *
					 * @since Twenty Twenty 1.0
					 *
					 * @param bool Whether to show the categories in header. Default true.
					 */
					$show_categories = apply_filters('twentytwenty_show_categories_in_entry_header', true);

					if (true === $show_categories && has_category() && $type_post === 'single-top') {
					?>

                    <div class="entry-categories">
                        <span class="screen-reader-text"><?php _e('Categories', 'twentytwenty'); ?></span>
                    </div><!-- .entry-categories -->

                    <?php
					}

					if (is_singular()) {
						the_title('<h1 class="entry-title">', '</h1>');
					} else {
						the_title('<h2 class="entry-title heading-size-1"><a href="' . esc_url(get_permalink()) . '">', '</a></h2>');
					}
					?>

                    <?php if (is_single()) {
						$day = $month = $year = 0;
						if (strtotime($post->post_date)) {
							$timestamp = strtotime($post->post_date);
							$day = date("d", $timestamp);
							$month = date("m", $timestamp);
							$year = date("y", $timestamp);
						} ?>

                    <div class="headlinesdate-module-6">
                        <div class="headlinesdm">
                            <div class="headlinesday">
                                <?php echo $day ?>
                            </div>
                            <div class="headlinesmonth">
                                <?php echo $month ?>
                            </div>
                        </div>
                        <div class="headlinesyear">
                            <?php echo $year ?>
                        </div>
                    </div>
                    <?php } ?>
                    <hr width="100%" class="hr-detail" style="text-align: center;" />
                    <?php
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
					if (!is_search()) {
					?>
                    <div
                        class="post-inner <?php echo is_page_template('templates/template-full-width.php') ? '' : 'thin'; ?> ">

                        <div class="entry-content">

                            <?php
								if (is_search() || !is_singular() && 'summary' === get_theme_mod('blog_content', 'full')) {
									the_excerpt();
								} else {
									if (is_single()) {
										the_content(__('Continue reading', 'twentytwenty'));
									} else {
										the_excerpt();
									}
								}
								?>
                        </div><!-- .entry-content -->

                    </div><!-- .post-inner -->
                </div> <!-- .entry-header-inner-content -->
                <?php
					}
			?>

            </div><!-- .entry-header-inner -->
            <?php if (is_single()) { ?>
        </div>
        <div class="col-md-3 module10 " style="
    margin-top: -50px;">
            <?php } ?>
            <?php if ($has_sidebar_10 && is_single()) { ?>
            <div class="footer-widgets-wrapper1">
                <?php if ($has_sidebar_10 && is_single()) { ?>
                <div class="footer-widgets1 column-one grid-item">
                    <?php dynamic_sidebar('sidebar-10'); ?>
                    <?php } ?>
                </div>
                <?php } ?>


            </div>
        </div>




</header><!-- .entry-header -->
<?php
/**
 * Displays the next and previous post navigation in single posts.
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */

$next_post = get_next_post();
$prev_post = get_previous_post();

if ( $next_post || $prev_post ) {

    $pagination_classes = '';

    if ( ! $next_post) {
        $pagination_classes = ' only-one only-prev';
    } elseif ( ! $prev_post) {
        $pagination_classes = ' only-one only-next';
    }

    ?>

    <nav class="pagination-single section-inner<?php echo esc_attr($pagination_classes); ?>"
         aria-label="<?php esc_attr_e('Post', 'twentytwenty'); ?>"
         role="navigation">

        <hr class="styled-separator is-style-wide" aria-hidden="true"/>

        <div class="pagination-single-inner inner-edit">

            <?php
            if ($prev_post) {
                $pre_day = "pre-day";
                ?>
                <a class="previous-post" href="<?php echo esc_url(get_permalink($prev_post->ID)); ?>">
                    <div class="pre-inner">
                        <div class="inner-edit-time">
                            <span class="arrow <?php echo $pre_day ?>" aria-hidden="true"><?php the_time('d'); ?></span>
                            <span class="arrow" aria-hidden="true"><?php the_time('m'); ?></span>
                        </div>
                        <div class="prev-post-year">
                            <span class="arrow" aria-hidden="true"><?php the_time('y'); ?></span>
                            <span class="title"><span class="title-inner"><?php echo wp_kses_post(get_the_title($prev_post->ID)); ?></span></span>

                        </div>
                    </div>
                </a>

                <?php
            }

			if ( $next_post ) {
                $next_day = "next-day";
                ?>

                <a class="next-post" href="<?php echo esc_url(get_permalink($next_post->ID)); ?>">
                    <div class="next-inner">
                        <div class="inner-edit-time2">
                            <span class="arrow <?php echo $next_day ?>"
                                  aria-hidden="true"><?php the_time('d'); ?></span>
                            <span class="arrow" aria-hidden="true"><?php the_time('m'); ?></span>
                        </div>
                        <div class="next-post-year">
                            <span class="arrow" aria-hidden="true"><?php the_time('y'); ?></span>
                            <span class="title-inner"><?php echo wp_kses_post(get_the_title($next_post->ID)); ?></span>
                        </div>
                    </div>
                </a>
                <?php
            }
			?>

		</div><!-- .pagination-single-inner -->

		<hr class="styled-separator is-style-wide" aria-hidden="true" />

	</nav><!-- .pagination-single -->

	<?php
}

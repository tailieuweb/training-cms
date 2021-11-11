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

	if ( ! $next_post ) {
		$pagination_classes = ' only-one only-prev';
	} elseif ( ! $prev_post ) {
		$pagination_classes = ' only-one only-next';
	}

	?>

	<nav class="pagination-single section-inner<?php echo esc_attr( $pagination_classes ); ?>" aria-label="<?php esc_attr_e( 'Post', 'twentytwenty' ); ?>" role="navigation">

		<hr class="styled-separator is-style-wide" aria-hidden="true" />

        <div class="pagination-single-inner" id="another__post-wrapper">

            <?php
            if ( $prev_post ) {
                // lấy ngày-tháng-năm bài viết.
                $prev_post_new_post_date = $prev_post->post_date;
                $prev_post_time = strtotime($prev_post_new_post_date);
                $prev_post_newformat = date('y-m-d',$prev_post_time);
                $prev_post_expore = explode("-",$prev_post_newformat);
                $prev_post_day = $prev_post_expore[2];
                $prev_post_month = $prev_post_expore[1];
                $prev_post_year = $prev_post_expore[0];

                ?>
                <!-- Bài viết trước -->
                <div class="another__post">
                    <div class="headlinesdate">
                        <div class="headlinesdm">
                            <div class="headlinesday"><?php echo$prev_post_day; ?></div>
                            <div class="headlinesmonth"><?php echo$prev_post_month; ?></div>
                        </div>
                        <div class="headlinesyear"><?php echo$prev_post_year; ?></div>
                    </div>

                    <div class="headlinestitle">
                        <a href="<?php echo esc_url( get_permalink( $prev_post->ID ) ); ?>">
                            <?php echo wp_kses_post( get_the_title( $prev_post->ID ) ); ?>
                        </a>
                    </div>
                </div>
                <?php
            }

            if ( $next_post ) {
                // lấy ngày-tháng-năm bài viết.
                $next_post_new_post_date = $next_post->post_date;
                $next_post_time = strtotime($next_post_new_post_date);
                $next_post_newformat = date('y-m-d',$next_post_time);
                $next_post_expore = explode("-",$next_post_newformat);
                $next_post_day = $next_post_expore[2];
                $next_post_month = $next_post_expore[1];
                $next_post_year = $next_post_expore[0];
                ?>
                <!-- Bài viết tiếp theo -->
                <div class="another__post">
                    <div class="headlinesdate">
                        <div class="headlinesdm">
                            <div class="headlinesday"><?php echo $next_post_day; ?></div>
                            <div class="headlinesmonth"><?php echo $next_post_month; ?></div>
                        </div>
                        <div class="headlinesyear"><?php echo $next_post_year; ?></div>
                    </div>

                    <div class="headlinestitle">
                        <a href="<?php echo esc_url( get_permalink( $next_post->ID ) ); ?>">
                            <?php echo wp_kses_post( get_the_title( $next_post->ID ) ); ?>
                        </a>
                    </div>
                </div>
                <?php
            }
            ?>

        </div><!-- .pagination-single-inner -->

		<hr class="styled-separator is-style-wide" aria-hidden="true" />

	</nav><!-- .pagination-single -->

	<?php
}

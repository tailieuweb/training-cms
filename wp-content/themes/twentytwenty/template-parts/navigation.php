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
$post = get_post();
$date = $post->post_date;
$day = date("d", strtotime($date));
$month = date("m", strtotime($date));
$year = date("y", strtotime($date));


if ( $next_post || $prev_post ) {

	$pagination_classes = '';

	if ( ! $next_post ) {
		$pagination_classes = ' only-one only-prev';
	} elseif ( ! $prev_post ) {
		$pagination_classes = ' only-one only-next';
	}

	?>
	<div class="list_news <?php echo esc_attr( $pagination_classes ); ?>" aria-label="<?php esc_attr_e( 'Post', 'twentytwenty' ); ?>" role="navigation" >
    <div class="headlines">
        <ul>
                            <li>
                    <div class="headlinesdate">
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
                    <div class="headlinestitle">
					<a class="previous-post" href="<?php echo esc_url( get_permalink( $prev_post->ID ) ); ?>">
					
					<span class="title"><span class="title-inner"><?php echo wp_kses_post( get_the_title( $prev_post->ID ) ); ?></span></span>
				</a>
                    </div>
                </li>
				<li>
                    <div class="headlinesdate">
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
                    <div class="headlinestitle">
					<a class="next-post" href="<?php echo esc_url( get_permalink( $next_post->ID ) ); ?>">
					
						<span class="title"><span class="title-inner"><?php echo wp_kses_post( get_the_title( $next_post->ID ) ); ?></span></span>
				</a>
				
                    </div>
                </li>
                    </ul>
    </div>
</div>



	<?php
}

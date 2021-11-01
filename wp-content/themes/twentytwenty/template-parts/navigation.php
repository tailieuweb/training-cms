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

		<!-- <hr class="styled-separator is-style-wide" aria-hidden="true" /> -->

		<div class="pagination-single-inner">

			<?php
			if ( $prev_post ) {
				?>
				<div class="row">
				<div class="headlines">
        				<ul>
                            <li>
                    			<div class="headlinesdate">
                                    <div class="headlinesdm">
                            			<div class="headlinesday">03</div>
                            			<div class="headlinesmonth">08</div>
                        			</div>
                        			<div class="headlinesyear">18</div>
                    			</div>
                			</li>
                    	</ul>
    				</div>

				<a class="previous-post" href="<?php echo esc_url( get_permalink( $prev_post->ID ) ); ?>">
					<!-- <span class="arrow" aria-hidden="true">&larr;</span> -->
					<span class="title"><span class="title-inner" id = "text"><?php echo wp_kses_post( get_the_title( $prev_post->ID ) ); ?></span></span>
				</a>
				</div>
				

				<?php
			}

			if ( $next_post ) {
				?>

				<a class="next-post" href="<?php echo esc_url( get_permalink( $next_post->ID ) ); ?>">
						<!-- <span class="arrow" aria-hidden="true">&rarr;</span> -->
						<span class="title"><span class="title-inner"><?php echo wp_kses_post( get_the_title( $next_post->ID ) ); ?></span></span>
				</a>
				<?php
			}
			?>

		</div><!-- .pagination-single-inner -->

		<!-- <hr class="styled-separator is-style-wide" aria-hidden="true" /> -->

	</nav><!-- .pagination-single -->

	<?php
}

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

	<nav class="pagination-single section-inner justify-content-center<?php echo esc_attr( $pagination_classes ); ?>" aria-label="<?php esc_attr_e( 'Post', 'twentytwenty' ); ?>" role="navigation">

		<!--<hr class="styled-separator is-style-wide" aria-hidden="true" />-->
		
		<div class="pagination-single-inner">
			
			<?php
			
			
			if ( $prev_post ) {
				?>

				<a class="previous-post" href="<?php echo esc_url( get_permalink( $prev_post->ID ) );?>">
				<?php
						if (is_single()) {
							echo '<div class="date-time-post">';
							$post_date = get_the_date('d', $post->ID);
							$post_month = get_the_date('m', $post->ID);
							$post_year = get_the_date('y',$post->ID);
							echo '<div class="post-date">';
							echo '<div class="head-dm">';
							echo '<div class="day">' . $post_date . '</div>';
							echo '<hr style="margin: 0;">';
							echo '<div class="month">' . $post_month . '</div>';
							echo '</div>';
							echo '<div class="year">' . $post_year . '</div>';
							echo '</div>';
							echo '</div>';
						}
				?>
					<!-- <span class="arrow" aria-hidden="true">&larr;</span>-->
					<span class="title"><span class="title-inner"><?php
				
					echo wp_kses_post( get_the_title( $prev_post->ID ) ); ?></span></span>
				</a>

				<?php
				
			// }else{
			// 	$title = get_title();
			// 	$content = $title->title_content;
			// 	echo substr($content,0, 20);
			 }

			if ( $next_post ) {
				?>	

				<a class="next-post" href="<?php echo esc_url( get_permalink( $next_post->ID ) ); ?>">
				<?php
						if (is_single()) {
							echo '<div class="date-time-post">';
							$post_date = get_the_date('d', $post->ID);
							$post_month = get_the_date('m', $post->ID);
							$post_year = get_the_date('y',$post->ID);
							echo '<div class="post-date">';
							echo '<div class="head-dm">';
							echo '<div class="day">' . $post_date . '</div>';
							echo '<hr style="margin: 0;">';
							echo '<div class="month">' . $post_month . '</div>';
							echo '</div>';
							echo '<div class="year">' . $post_year . '</div>';
							echo '</div>';
							echo '</div>';
						}
				?>
					<!--<span class="arrow" aria-hidden="true">&rarr;</span> -->
						<span class="title"><span class="title-inner"><?php echo wp_kses_post( get_the_title( $next_post->ID ) ); ?></span></span>
				</a>
				<?php
			}
			?>

		</div><!-- .pagination-single-inner -->

		<!--<hr class="styled-separator is-style-wide" aria-hidden="true" />-->

	</nav><!-- .pagination-single -->

	<?php
}

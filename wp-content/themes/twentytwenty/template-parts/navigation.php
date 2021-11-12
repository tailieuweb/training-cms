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
		<div class="pagination-single-inner">

<?php
	if ( $prev_post ) {
		$prev_post_date = explode("-", explode(' ', $prev_post->post_modified_gmt)[0]);
		?>
	   <div style="display: flex;width: 45% " >
			<div style="display: flex;align-items: center;width: 16%" >
				<div style="margin-right: 6px" >
					<p style="font-size: 16px;margin: 0 ;border-bottom: 3px solid black"> <?php echo $prev_post_date[2]; ?> </p>
					<p style="font-size: 16px;" > <?php echo $prev_post_date[1]; ?> </p>

				</div>
				 <div>
					 <p style="font-size: 16px;" > <?php echo $prev_post_date[0]; ?> </p>

				 </div>
			</div>
		   <div >
			   <a class="previous-post" href="<?php echo esc_url( get_permalink( $prev_post->ID ) ); ?>">
				   <!-- <span class="arrow" aria-hidden="true">&larr;</span> -->
				   <span  class="title"><span class="title-inner"><?php echo wp_kses_post( get_the_title( $prev_post->ID ) ); ?></span></span>
			   </a>
		   </div>

	   </div>
		<?php
	}

	if ( $next_post ) {
		$next_post_date = explode("-", explode(' ', $next_post->post_modified_gmt)[0]);
		?>

	<div style="display: flex;width: 45% " >
	<div style="display: flex;align-items: center;width: 16%" >
			<div style="margin-right: 6px" >
				<p style="font-size: 16px;margin: 0 ;border-bottom: 3px solid black"> <?php echo $next_post_date[2]; ?> </p>
				<p style="font-size: 16px;" > <?php echo $next_post_date[1]; ?> </p>

			</div>
			<div>
				<p style="font-size: 16px;" > <?php echo $next_post_date[0]; ?> </p>

			</div>
		</div>

		<div >

				<a class="next-post" href="<?php echo esc_url( get_permalink( $next_post->ID ) ); ?>">
					<!-- <span class="arrow" aria-hidden="true">&rarr;</span> -->
					<span class="title"><span class="title-inner"><?php echo wp_kses_post( get_the_title( $next_post->ID ) ); ?></span></span>
				</a>

		</div>
	   

	</div>
		<?php
	}
	?>

</div><!-- .pagination-single-inner -->

	<?php
}

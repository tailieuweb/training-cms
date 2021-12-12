<?php
/**
 * Displays the post header
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */

$entry_header_classes = '';

if ( is_singular() ) {
	$entry_header_classes .= ' header-footer-group';
}

?>

<header class="entry-header has-text-align-center<?php echo esc_attr( $entry_header_classes ); ?>">

	<div class="entry-header-inner section-inner medium">

		<?php
		/**
		 * Allow child themes and plugins to filter the display of the categories in the entry header.
		 *
		 * @since Twenty Twenty 1.0
		 *
		 * @param bool Whether to show the categories in header. Default true.
		 */
		$show_categories = apply_filters( 'twentytwenty_show_categories_in_entry_header', true );

		if ( true === $show_categories && has_category() ) {
			?>
			<div class="entry-categories">
				<span class="screen-reader-text"><?php _e( 'Categories', 'twentytwenty' ); ?></span>
				<div class="entry-categories-inner">
					<?php the_category( ' ' ); ?>
				</div><!-- .entry-categories-inner -->
			</div><!-- .entry-categories -->
			<?php
		}

		if ( is_singular() ) {
			?>
			<!-- create row md the get date  -->
			<div class="row">
				<div class="col-md-10">
				<?php the_title( '<h1 class="entry-title">','</h1>');?>
				</div>
				<div class="col-md-2">
					<!-- print the get date in detail page -->
					<?php echo "<div class='detailpage'>"."<span class='detaildate'>". get_the_date('d', $post->ID)."</span>","<br>" ."<span class='detailmonth '>".get_the_date('m', $post->ID)."</span>"."<span class='detailyear'>'".get_the_date('y', $post->ID)."</span>","</div>"; ?>
				</div>
			</div>
			<?php
		} else {
			//tittle repair
			the_title( '<h2 class="entry-title heading-size-1"><a style="color: #428bca;margin:0;" href="' . esc_url( get_permalink() ) . '">', '</a></h2>' );
		}
		$intro_text_width = '';
		if ( is_singular() ) {
			$intro_text_width = ' small';
		} else {
			$intro_text_width = ' thin';
		}

		if ( has_excerpt() && is_singular() ) {
			?>

			<div class="intro-text section-inner max-percentage<?php echo $intro_text_width; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static output ?>">
				<?php the_excerpt(); ?>
			</div>

			<?php
		}
		?>
			<!--  -->

	</div><!-- .entry-header-inner -->

</header><!-- .entry-header -->

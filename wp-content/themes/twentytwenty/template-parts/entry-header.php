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
	$entry_header_classes .= ' container-fuild header-footer-group';
}

?>

<header class="entry-header has-text-align-center<?php echo esc_attr( $entry_header_classes ); ?>">
	<div class="row">
	<div class=" col-md-10 entry-header-inner section-inner medium">

<?php
/**
 * Allow child themes and plugins to filter the display of the categories in the entry header.
 *
 * @since Twenty Twenty 1.0
 *
 * @param bool Whether to show the categories in header. Default true.
 */


if ( is_singular() ) {
	the_title( '<h1 class="entry-title">', '</h1>' );
} else {
	the_title( '<h2 class="entry-title heading-size-1"><a href="' . esc_url( get_permalink() ) . '">', '</a></h2>' );
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

// Default to displaying the post meta.
twentytwenty_the_post_meta( get_the_ID(), 'single-top' );
?>

</div><!-- .entry-header-inner -->
<div class="col-md-2 dmy-border">
	<div class="day-month-year">
		<div class="day-month"style="float: left; margin-right: 10px;">
			<div class="day" style="border-bottom: solid 2px;">24</div>
			<div class="month"style="">06</div>
		</div>
		<div class="year" style="line-height: 3em; float: left;">18</div>
	</div>
	
				
	</div>
	
</div>
	

</header><!-- .entry-header -->

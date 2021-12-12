<?php
// Default checkout layout
get_header(); ?>

<?php while (have_posts()) : the_post(); ?>

	<?php
	wc_get_template('checkout/header.php');

	echo '<div class="cart-container container page-wrapper page-checkout">';
	wc_print_notices();
	the_content();
	echo '</div>';
	?>

<?php endwhile; // end of the loop. ?>

<div class="footer-widgets footer footer-selling">
	<div class="<?php echo flatsome_footer_row_style('footer-selling'); ?> mb-0">
		<?php dynamic_sidebar('sidebar-footer-selling'); ?>
	</div>
</div>
<div class="footer-widgets footer top-rating--block">
	<div class="<?php echo flatsome_footer_row_style('top-rating--wrapper'); ?> mb-0">
		<?php dynamic_sidebar('top-rating'); ?>
	</div>
</div>

<?php get_footer(); ?>

<?php

/**
 * The template for displaying the footer
 *
 * Contains the opening of the #site-footer div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 * @link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 * 
 */
$has_footer_menu = has_nav_menu('footer');
$has_social_menu = has_nav_menu('social');

$has_sidebar_1 = is_active_sidebar('sidebar-1');
$has_sidebar_2 = is_active_sidebar('sidebar-2');
$has_sidebar_3 = is_active_sidebar('sidebar-3');
?>


<section id="footer">
	<div class="container">
		<div class="row text-sm-left text-md-left">
			<div class="col-xs-12 col-sm-4 col-md-4">
				<?php if ($has_sidebar_1) { ?>

					<div class=" column-one grid-item">
						<?php dynamic_sidebar('sidebar-1'); ?>
					</div>

				<?php } ?>
			</div>
			<div class="col-xs-12 col-sm-4 col-md-4">
				<?php if ($has_sidebar_2) { ?>

					<div class=" column-two grid-item">
						<?php dynamic_sidebar('sidebar-2'); ?>
					</div>

				<?php } ?>
			</div>
			<div class="col-xs-12 col-sm-4 col-md-4">
				<?php if ($has_sidebar_3) { ?>

					<div class=" column-three grid-item">
						<?php dynamic_sidebar('sidebar-3'); ?>
					</div>

				<?php } ?>
			</div>
		</div>

		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 mt-2 mt-sm-2 text-center text-white">
				<p><u><a href="https://www.nationaltransaction.com/">National Transaction Corporation</a></u> is a Registered MSP/ISO of Elavon, Inc. Georgia [a wholly owned subsidiary of U.S. Bancorp, Minneapolis, MN]</p>
				<p class="h6">© All right Reversed.<a class="text-green ml-2" href="https://www.sunlimetech.com" target="_blank">Sunlimetech</a></p>
			</div>
			<hr>
		</div>
	</div>

</section>

<?php wp_footer(); ?>

</body>

</html>
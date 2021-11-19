<?php

/**
 * The template for displaying the footer
 *
 * Contains the opening of the #site-footer div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */

?>
<!-- <footer id="site-footer" role="contentinfo" class="header-footer-group">

	<div class="section-inner">

		<div class="footer-credits">

			<p class="footer-copyright">&copy; -->
<!-- </?php
				echo date_i18n(
					/* translators: Copyright date format, see https://www.php.net/manual/datetime.format.php */
					_x('Y', 'copyright date format', 'twentytwenty')
				);
				?> -->
<!-- <a href="</?php echo esc_url(home_url('/')); ?>"><?php bloginfo('name'); ?></a>
			</p> -->
<!-- .footer-copyright -->

<!-- <p class="powered-by-wordpress">
				<a href="</?php echo esc_url(__('https://wordpress.org/', 'twentytwenty')); ?>">
					</?php _e('Powered by WordPress', 'twentytwenty'); ?>
				</a>
			</p> -->
<!-- .powered-by-wordpress -->

<!-- </div> -->
<!-- .footer-credits -->

<!-- <a class="to-the-top" href="#site-header">
			<span class="to-the-top-long">
				</?php
				/* translators: %s: HTML character for up arrow. */
				printf(__('To the top %s', 'twentytwenty'), '<span class="arrow" aria-hidden="true">&uarr;</span>');
				?>
			</span> -->
<!-- .to-the-top-long -->
<!-- <span class="to-the-top-short">
				</?php
				/* translators: %s: HTML character for up arrow. */
				printf(__('Up %s', 'twentytwenty'), '<span class="arrow" aria-hidden="true">&uarr;</span>');
				?>
			</span> -->
<!-- .to-the-top-short -->
<!-- </a> -->
<!-- .to-the-top -->

<!-- </div> -->
<!-- .section-inner -->

<!-- </footer> -->
<!-- #site-footer -->

<footer id="site-footer" role="contentinfo" class="header-footer-group">
		<div class="container">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 mt-2 mt-sm-5">
					<ul class="list-unstyled list-inline social text-center">
						<li class="list-inline-item"><a href="https://www.fiverr.com/share/qb8D02"><i class="fa fa-facebook"></i></a></li>
						<li class="list-inline-item"><a href="https://www.fiverr.com/share/qb8D02"><i class="fa fa-twitter"></i></a></li>
						<li class="list-inline-item"><a href="https://www.fiverr.com/share/qb8D02"><i class="fa fa-instagram"></i></a></li>
						<li class="list-inline-item"><a href="https://www.fiverr.com/share/qb8D02"><i class="fa fa-google-plus"></i></a></li>
						<li class="list-inline-item"><a href="https://www.fiverr.com/share/qb8D02" target="_blank"><i class="fa fa-envelope"></i></a></li>
					</ul>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 mt-2 mt-sm-2 text">
					<p><u><a href="https://www.nationaltransaction.com/">National Transaction Corporation</a></u> is a Registered MSP/ISO of Elavon, Inc. Georgia [a wholly owned subsidiary of U.S. Bancorp, Minneapolis, MN]</p>
					<p class="h6" style="font-size: 1.5rem;">© All right Reversed.<a class="text-green ml-2" href="https://www.sunlimetech.com" target="_blank">Sunlimetech</a></p>
				</div>
			</div>
		</div>
</footer>
<?php wp_footer(); ?>

</body>

</html>
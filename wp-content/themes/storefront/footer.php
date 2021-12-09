<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package storefront
 */

?>

</div><!-- .col-full -->
</div><!-- #content -->

<?php do_action('storefront_before_footer'); ?>

<!-- <div>#module-footer is here!</div> -->
<footer id="colophon" class="site-footer module-footer" role="contentinfo">
    <!-- Not use col-full any more! -->
    <!-- <div class="col-full"> -->
    <div class="footer-wrapper">

        <?php
        /**
         * Functions hooked in to storefront_footer action
         *
         * @hooked storefront_footer_widgets - 10
         * @hooked storefront_credit         - 20
         */
        // do_action( 'storefront_footer' );
        storefront_footer_widgets();
        storefront_credit();
        ?>

    </div><!-- .footer-wrapper -->
</footer><!-- #colophon -->

<?php do_action('storefront_after_footer'); ?>

</div><!-- #page -->

<?php wp_footer(); ?>
<script src="<?php echo get_template_directory_uri() ?>/module3_module4.js"></script>
</body>
</html>

<?php
/**
 * Displays the post header
 *
 * @package    WordPress
 * @subpackage Twenty_Twenty
 * @since      Twenty Twenty 1.0
 */

$entry_header_classes = '';

if (is_singular()) {
    $entry_header_classes .= ' header-footer-group';
}

?>

<header class="entry-header has-text-align-center<?php echo esc_attr($entry_header_classes); ?>">

    <div class="entry-header-inner section-inner medium">
        <div class="header-edit-detail">
            <div class="row-edit-detail">
                <div class="col-md-10">
                    <?php
                    if (is_singular()) {
                        the_title('<h1 class="entry-title">', '</h1>');
                    } else {
                        the_title('<h2 class="entry-title heading-size-1"><a href="'.esc_url(get_permalink()).'">', '</a></h2>');
                    }
                    ?>
                </div>
                <div class="col-md-2">
                    <?php
                    $intro_text_width = '';
                    if (has_excerpt() && is_singular()) {
                        ?>
                        <div class="intro-text section-inner max-percentage<?php echo $intro_text_width; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static output ?>">
                            <?php the_excerpt(); ?>
                        </div>

                        <?php
                    }
                    // Default to displaying the post meta.
                    twentytwenty_the_post_meta(get_the_ID(), 'single-top');
                    ?>
                </div>
            </div>
        </div>
        <?php
        /**
         * Allow child themes and plugins to filter the display of the categories in the entry header.
         *
         * @param  bool Whether to show the categories in header. Default true.
         *
         * @since Twenty Twenty 1.0
         *
         */
        $show_categories = apply_filters('twentytwenty_show_categories_in_entry_header', true);

        if (true === $show_categories && has_category()) {
            ?>

            <div class="entry-categories">
                <span class="screen-reader-text"><?php _e('Categories', 'twentytwenty'); ?></span>
                <div class="entry-categories-inner">
                    <?php the_category(' '); ?>
                </div>
            </div>

            <?php
        }


        if (is_singular()) {
            $intro_text_width = ' small';
        } else {
            $intro_text_width = ' thin';
        }


        ?>

    </div><!-- .entry-header-inner -->
    <div class="row-strikethrough">
        <div class="col-md-12"><div class="overviewline"></div></div>
    </div>

</header><!-- .entry-header -->

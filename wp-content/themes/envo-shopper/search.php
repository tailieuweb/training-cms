<?php get_header(); ?>

<!-- start content container -->
<div class="row">
    <div class="col-md-<?php envo_shopper_main_content_width_columns(); ?>">
        <?php
        // if this was a search we display a page header with the results count. If there were no results we display the search form.
        if (is_search()) :
            /* translators: %s: search result string */
            echo "<h1 class='search-head text-center'>" . sprintf(esc_html__('Search Results for: %s', 'envo-shopper'), get_search_query()) . "</h1>";
        endif;
        do_action('envo_shopper_generate_the_content');
        ?>
    </div>
    <?php get_sidebar('right'); ?>
</div>
<!-- end content container -->
<?php 
get_footer();

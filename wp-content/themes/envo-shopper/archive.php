<?php get_header(); ?>

<!-- start content 404 container -->
<div class="row">
    <div class="col-md-<?php envo_shopper_main_content_width_columns(); ?>">
        <?php if (have_posts()) : ?>
            <header class="archive-page-header text-center">
                <?php
                the_archive_title('<h1 class="page-title">', '</h1>');
                the_archive_description('<div class="taxonomy-description">', '</div>');
                ?>
            </header><!-- .page-header -->
            <?php
        endif;
        do_action('envo_shopper_generate_the_content');
        ?>
    </div>
    <?php get_sidebar('right'); ?>
</div>
<!-- end content 404 container -->

<?php 
get_footer();

<?php get_header(); ?>

<!-- start content container -->
<div class="row">      
    <article class="col-md-<?php envo_shopper_main_content_width_columns(); ?>">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>                         
                <div <?php post_class(); ?>>
                    <div class="single-head <?php echo esc_attr(has_post_thumbnail() ? 'has-thumbnail' : 'no-thumbnail' ) ?>">
                        <?php the_title('<h1 class="single-title">', '</h1>'); ?>
                        <?php do_action('envo_shopper_after_title'); ?>
                    </div>
                    <?php envo_shopper_thumb_img('envo-shopper-single', '', false, true); ?>
                    <div class="single-content">
                        <?php do_action('envo_shopper_singular_content'); ?>
                        <?php wp_link_pages(); ?>
                        <?php do_action('envo_shopper_construct_entry_footer'); ?>
                    </div>
                    <?php envo_shopper_prev_next_links(); ?>
                    <?php do_action('envo_shopper_after_single_post'); ?>
                </div>        
            <?php endwhile; ?>        
        <?php else : ?>            
            <?php get_template_part('content', 'none'); ?>        
        <?php endif; ?>    
    </article> 
    <?php get_sidebar('right'); ?>
</div>
<!-- end content container -->

<?php 
get_footer();

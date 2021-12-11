<?php get_header(); ?>

<!-- start page content container -->
<div class="row">
    <article class="col-md-<?php envo_shopper_main_content_width_columns(); ?>">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>                          
                <div <?php post_class(); ?>>
                    <header class="single-head page-head <?php echo esc_attr(has_post_thumbnail() ? 'has-thumbnail' : 'no-thumbnail' ) ?>">                              
                        <?php the_title('<h1 class="single-title">', '</h1>'); ?>
                        <time class="posted-on published" datetime="<?php the_time('Y-m-d'); ?>"></time>                                                        
                    </header>
                    <?php envo_shopper_thumb_img('envo-shopper-single', '', false, true); ?>
                    <div class="main-content-page single-content">                            
                        <?php do_action('envo_shopper_singular_content'); ?>
                        <?php wp_link_pages(); ?>                                                                                     
                        <?php comments_template(); ?>
                    </div>
                </div>        
            <?php endwhile; ?>        
        <?php else : ?>            
            <?php get_template_part('content', 'none'); ?>        
        <?php endif; ?>    
    </article>       
    <?php get_sidebar('right'); ?>
</div>
<!-- end page content container -->

<?php 
get_footer();

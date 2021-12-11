<article class="content-article col-md-6">
    <div <?php post_class("news-item"); ?>>                    
        <?php envo_shopper_thumb_img('envo-shopper-med'); ?>
        <div class="news-text-wrap">
            <?php the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>'); ?>
            <?php do_action('envo_shopper_after_title'); ?>
            <div class="post-excerpt">
                <?php the_excerpt(); ?>
            </div><!-- .post-excerpt -->
        </div><!-- .news-text-wrap -->
    </div>
</article>

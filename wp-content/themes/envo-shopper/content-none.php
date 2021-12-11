<div class="error-template text-center no-content">
    <h1>
        <?php esc_html_e('Nothing Found', 'envo-shopper'); ?>
    </h1>
    <?php if (is_home() && current_user_can('publish_posts')) : ?>
        <p>
            <?php
            /* translators: %1$s: link to admin area */
            printf(wp_kses(__('Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'envo-shopper'), array('a' => array('href' => array()))), esc_url(admin_url('post-new.php')));
            ?>
        </p>
    <?php elseif (is_search()) : ?>
        <p>
            <?php esc_html_e('Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'envo-shopper'); ?>
        </p>
        <?php get_search_form(); ?>
    <?php else : ?>
        <p>
            <?php esc_html_e('It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'envo-shopper'); ?>
        </p>
        <?php get_search_form(); ?>
    <?php endif; ?>
</div>

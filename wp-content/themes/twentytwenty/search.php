<?php

/**
 * Search result page.
 */
get_header();
global $wp_query;

//echo '<pre/>';
//print_r($wp_query);
//wp_die();
?>
<div id="primary">
    <main id="main" class="site-main mt-5" role="main">
        <div class="container">
            <!-- Search bar -->
            <header class="mb-5 mt-5 text-center">
                <h3 class="text-danger m-0">
                    <?php _e('Search', 'locale'); ?>:
                    <span class="text-dark">
                        "<?php the_search_query(); ?>"
                    </span>
                </h3>
                <p class=" page-title search-result-found--custom mt-3"> <?php echo $wp_query->found_posts; ?>
                    <?php _e('Search Results Found For', 'locale'); ?>: "<?php the_search_query(); ?>"
                </p>
            </header>
            <div class="search-bar mb-5">
                <div class="row justify-content-center">
                    <div class="col-md-10 col-lg-12">
                        <form class="card card-sm" role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
                            <div class="card-body row no-gutters align-items-center p-4">
                                <div class="col-auto">
                                    <i class="fa fa-search" aria-hidden="true"></i>
                                </div>
                                <!--end of col-->
                                <div class="col">
                                    <input class="form-control form-control-lg 
                                    form-control-borderless search-field" id="<?php echo esc_attr($twentytwenty_unique_id); ?>" placeholder="<?php echo esc_attr_x('Search &hellip;', 'placeholder', 'twentytwenty'); ?>" value="<?php echo get_search_query(); ?>" name="s">
                                </div>
                                <!--end of col-->
                                <div class="col-auto">
                                    <button class="btn btn-lg btn-success search-submit" type="submit" class="search-submit" value="<?php echo esc_attr_x('Search', 'submit button', 'twentytwenty'); ?>">
                                        Search
                                    </button>
                                </div>
                                <!--end of col-->
                            </div>
                        </form>
                    </div>
                    <!--end of col-->
                </div>
            </div>

            <!-- Search result -->
            <?php if (have_posts()) { ?>
                <div>
                    <?php while (have_posts()) {
                        the_post();
                        //Get date of post
                        $post_date = get_the_date('d', $post->ID);
                        $post_month = get_the_date('m', $post->ID); ?>
                        <div class="card mb-5 pb-3 card--custom">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 col-lg-4">
                                        <!-- Post feature img -->
                                        <div class="cart-img">
                                            <?php $url = wp_get_attachment_url(get_post_thumbnail_id($post->ID), 'thumbnail'); ?>
                                            <img src="<?php echo $url ?>" />
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-2">
                                        <!-- Post date -->
                                        <div class="cart-post-date text-center">
                                            <div>
                                                <h2 class="p-0 m-0"><?= $post_date ?></h1>
                                            </div>
                                            <div>
                                                <p class="p-0 m-0">Tháng <?= $post_month ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <!-- Posts content -->
                                        <div class="search-card-container search-card--custom">
                                            <!-- Post title -->
                                            <h3 class="card-title">
                                                <a class="title-link--custom" href="<?php echo esc_url(get_the_permalink()); ?>">
                                                    <?php the_title(); ?>
                                                </a>
                                            </h3>
                                            <!-- Post content -->
                                            <div class="search-card-content">
                                                <?php echo the_excerpt() ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <?php get_template_part('template-parts/pagination'); ?>
            <?php } ?>
        </div>
    </main>
</div>
<?php get_footer(); ?>
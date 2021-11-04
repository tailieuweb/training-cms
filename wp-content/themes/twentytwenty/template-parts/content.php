<?php
/**
 * The default template for displaying content
 *
 * Used for both singular and index.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */

?>
<?php
// đặt trường hợp if truy vấn bài đăng có xuất hiện hay không
if (!is_single()) { ?>
<!-- Page content main !-->
<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

    <?php

		#get_template_part('template-parts/entry-header');

		if (!is_search()) {
			get_template_part('template-parts/featured-image');
		}

		?>

    <div class="post-inner <?php echo is_page_template('templates/template-full-width.php') ? '' : 'thin'; ?> ">
        <div class="entry-content">
            <?php
				if (is_search() || !is_singular() && 'summary' === get_theme_mod('blog_content', 'full')) {
					the_excerpt();
				} else { ?>
            <div class="content-main">
                <div class="row">
                    <div class="col-md-4 border-right border-dark">
                        <div class="content-adjust-post-meta text-center">

                            <?php 
										format_post_time(get_the_ID());
									
									 ?>
                        </div>

                    </div>
                    <div class="col-md-8">
                        <div class="content-adjust-post">
                            <?php
									if (is_singular()) {
										the_title('<h1 class="entry-title">', '</h1>');
									} else {
										the_title('<h2 class="entry-title-adjust heading-size-1"><a href="' . esc_url(get_permalink()) . '">', '</a></h2>');
									}
									?>
                            		<?php
										$post = get_post();
										$content = $post->post_content;
										//ham cat doan
										$content = preg_replace("/<\/?img[^>]*\>/i", " ", $content);
										$content = preg_replace("/<\/?figure[^>]*\>/i", " ", $content);
										$content = preg_replace("/<\/?figcaption[^>]*\>/i", " ", $content);
										//$content = preg_replace("<\/@?figcaption[^><]*\>/i", "", $content);
										$content = substr($content,0,150);
										//pemalink extend

										echo  $content . '<a href= "'.esc_url(get_permalink()).'"> [....] </a>';
										
										//get forma datetime line 
										$post_date = $post->post_date;
										$post_date_day = date('d',strtotime($post_date));
										$post_date_month = date('m',strtotime($post_date));
										
									?>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>

        </div><!-- .entry-content -->

    </div><!-- .post-inner -->

    <div class="section-inner">
        <?php
			wp_link_pages(
				array(
					'before'      => '<nav class="post-nav-links bg-light-background" aria-label="' . esc_attr__('Page', 'twentytwenty') . '"><span class="label">' . __('Pages:', 'twentytwenty') . '</span>',
					'after'       => '</nav>',
					'link_before' => '<span class="page-number">',
					'link_after'  => '</span>',
				)
			);

			edit_post_link();
			// Single bottom post meta.
			twentytwenty_the_post_meta(get_the_ID(), 'single-bottom');

			if (post_type_supports(get_post_type(get_the_ID()), 'author') && is_single()) {

				get_template_part('template-parts/entry-author-bio');
			}
			?>

    </div><!-- .section-inner -->

    <?php

		if (is_single()) {

			get_template_part('template-parts/navigation');
		}

		/*
		* Output comments wrapper if it's a post, or if comments are open,
		* or if there's a comment number – and check for password.
		*/
		if ((is_single() || is_page()) && (comments_open() || get_comments_number()) && !post_password_required()) {
		?>

    <div class="comments-wrapper section-inner">

        <?php comments_template(); ?>

    </div><!-- .comments-wrapper -->

    <?php
		}
		?>

</article><!-- .post -->
<!-- trường hợp else ngược lại -->
	<?php } 
		else { 
	?>

<!-- Page detail!-->
<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

    <?php

		get_template_part('template-parts/entry-header');

		if (!is_search()) {
			get_template_part('template-parts/featured-image');
		}

		?>

    <div class="post-inner <?php echo is_page_template('templates/template-full-width.php') ? '' : 'thin'; ?> ">

        <div class="entry-content">

            <?php
				if (is_search() || !is_singular() && 'summary' === get_theme_mod('blog_content', 'full')) {
					the_excerpt();
				} else {
					the_content(__('Continue reading', 'twentytwenty'));
				}
				?>
        </div><!-- .entry-content -->

    </div><!-- .post-inner -->

    <div class="section-inner">
        <?php
			wp_link_pages(
				array(
					'before'      => '<nav class="post-nav-links bg-light-background" aria-label="' . esc_attr__('Page', 'twentytwenty') . '"><span class="label">' . __('Pages:', 'twentytwenty') . '</span>',
					'after'       => '</nav>',
					'link_before' => '<span class="page-number">',
					'link_after'  => '</span>',
				)
			);

			edit_post_link();

			// Single bottom post meta.
			twentytwenty_the_post_meta(get_the_ID(), 'single-bottom');

			if (post_type_supports(get_post_type(get_the_ID()), 'author') && is_single()) {

				get_template_part('template-parts/entry-author-bio');
			}
			?>

    </div><!-- .section-inner -->

    <?php

		if (is_single()) {

			get_template_part('template-parts/navigation');
		}

			/*
			* Output comments wrapper if it's a post, or if comments are open,
			* or if there's a comment number – and check for password.
			*/
		if ((is_single() || is_page()) && (comments_open() || get_comments_number()) && !post_password_required()) {
		?>

    <div class="comments-wrapper section-inner">

        <?php comments_template(); ?>

    </div><!-- .comments-wrapper -->

    <?php
		}
		?>

</article><!-- .post -->


<?php 
	} 
	?>
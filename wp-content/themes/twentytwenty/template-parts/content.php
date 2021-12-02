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
<!--content-->
<?php
	$class="";
	if(!is_single()){
		$class = "trang-chu";
	}
	else{
		$class = "chi-tiet";
	}
?>
<?php
if(!is_single())
{
?>
<div class="ct">
<div class="container">
    <div class="row">
		<div class="col-md-3 col-xs-3 topnewstime">
			<span class="topnewsdate">30</span><br>
			<span class="topnewsmonth">Tháng 9</span><br>
		</div>
        <div class="col-md-9">
            <article <?php post_class($class); ?> id="post-<?php the_ID(); ?>">

                <?php

		get_template_part( 'template-parts/entry-header' );

		if ( ! is_search() ) {
			get_template_part( 'template-parts/featured-image' );
		}

		?>

                <div
                    class="post-inner <?php echo is_page_template( 'templates/template-full-width.php' ) ? '' : 'thin'; ?> ">

                    <div class="entry-content">

                        <?php
				if ( is_search() || ! is_singular() && 'summary' === get_theme_mod( 'blog_content', 'full' ) ) {
					the_excerpt();
				} else {
					if(is_single()){
						the_content( __( 'Continue reading', 'twentytwenty' ) );
					}
					else{
						$post = get_post();
						echo substr($post -> post_content, 0, 150) . "[...]";
					}
				}
				?>

                    </div><!-- .entry-content -->

                </div><!-- .post-inner -->

                <div class="section-inner">
                    <?php
			wp_link_pages(
				array(
					'before'      => '<nav class="post-nav-links bg-light-background" aria-label="' . esc_attr__( 'Page', 'twentytwenty' ) . '"><span class="label">' . __( 'Pages:', 'twentytwenty' ) . '</span>',
					'after'       => '</nav>',
					'link_before' => '<span class="page-number">',
					'link_after'  => '</span>',
				)
			);

			edit_post_link();

			// Single bottom post meta.
			twentytwenty_the_post_meta( get_the_ID(), 'single-bottom' );

			if ( post_type_supports( get_post_type( get_the_ID() ), 'author' ) && is_single() ) {

				get_template_part( 'template-parts/entry-author-bio' );

			}
			?>

                </div><!-- .section-inner -->

                <?php

		if ( is_single() ) {

			get_template_part( 'template-parts/navigation' );

		}

		/*
		* Output comments wrapper if it's a post, or if comments are open,
		* or if there's a comment number – and check for password.
		*/
		if ( ( is_single() || is_page() ) && ( comments_open() || get_comments_number() ) && ! post_password_required() ) {
			?>

                <div class="comments-wrapper section-inner">

                    <?php comments_template(); ?>

                </div><!-- .comments-wrapper -->

                <?php
		}
		?>

            </article><!-- .post -->
        </div>
    </div>
</div>
</div>
<hr class="hr">
<?php }
else{
?>

<article <?php post_class($class); ?> id="post-<?php the_ID(); ?>">
<div class="row">
	<div class="col-md-2">
	<div class="cate">
				<h2>Categories</h2>
				<div class="crossedbg-categories"></div>
				<div class="ul-cate">
					<ul>
						<?php $catID = get_terms('category');
						foreach ($catID as $key => $value) { ?>

							<li class="cate-name"><a href="<?= "http://" . $_SERVER["HTTP_HOST"]."/category/".$value->slug ?>"><?php echo $value->name ?></a></li>
						<?php } ?>
					</ul>
				</div>

			</div>
	</div>
	<div class="col-md-8">
		<div class="header">
				<div class="row">
					<div class="col-md-8">
						<?php

						get_template_part( 'template-parts/entry-header' );
						?>
					</div>
					<div class="col-md-2">
						<div class="headlinesdate">
							<div class="headlinesdm">
								<div class="headlinesday">30</div>
								<div class="headlinesmonth">09</div>
							</div>
							<div class="headlinesyear">'21</div>
						</div>
					</div>
				</div>
		</div>
			<?php
			if ( ! is_search() ) {
				get_template_part( 'template-parts/featured-image' );
			}

			?>
		<div class="gn">
			<div class="container">
			<div class="row">
				<div class="col-md-12"><div class="overviewline"></div></div>
		</div>
		
		<br>
		<br>

			<div class="entry-content">

				<?php
					if ( is_search() || ! is_singular() && 'summary' === get_theme_mod( 'blog_content', 'full' ) ) {
						the_excerpt();
					} else {
						if(is_single()){
							the_content( __( 'Continue reading', 'twentytwenty' ) );
						}
						else{
							$post = get_post();
							echo substr($post -> post_content, 0, 150) . "[...]";
						}
					}
					?>

			</div><!-- .entry-content -->

		</div><!-- .post-inner --> 

</article><!-- .post -->
		<div class="section-inner">
			<?php
				wp_link_pages(
					array(
						'before'      => '<nav class="post-nav-links bg-light-background" aria-label="' . esc_attr__( 'Page', 'twentytwenty' ) . '"><span class="label">' . __( 'Pages:', 'twentytwenty' ) . '</span>',
						'after'       => '</nav>',
						'link_before' => '<span class="page-number">',
						'link_after'  => '</span>',
					)
				);

				edit_post_link();

				// Single bottom post meta.
				twentytwenty_the_post_meta( get_the_ID(), 'single-bottom' );

				if ( post_type_supports( get_post_type( get_the_ID() ), 'author' ) && is_single() ) {

					get_template_part( 'template-parts/entry-author-bio' );

				}
				?>

		</div><!-- .section-inner -->
	</div>
</div>
<div class="next">
    <?php

		if ( is_single() ) {

			get_template_part( 'template-parts/navigation' );

		}
	?>
</div>
	<?php

		/*
		* Output comments wrapper if it's a post, or if comments are open,
		* or if there's a comment number – and check for password.
		*/
		if ( ( is_single() || is_page() ) && ( comments_open() || get_comments_number() ) && ! post_password_required() ) {
			?>

    <div class="comments-wrapper section-inner">

        <?php comments_template(); ?>

    </div><!-- .comments-wrapper -->

    <?php
		}
		?>
<?php }?>
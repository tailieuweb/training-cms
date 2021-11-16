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
if(!is_single()){
    ?>
}
    <article <?php post_class('danhsachs'); ?> id="post-<?php the_ID(); ?>" style="background: url(../assets/images/bg_pattern.png) repeat;">
	<?php

	get_template_part( 'template-parts/entry-header' );

	if ( ! is_search() ) {
		get_template_part( 'template-parts/featured-image' );
	}

	?>

	<div class="post-inner <?php echo is_page_template( 'templates/template-full-width.php' ) ? '' : 'thin'; ?> ">

		<div class="entry-content">

			<?php
			if ( is_search() || ! is_singular() && 'summary' === get_theme_mod( 'blog_content', 'full' ) ) {
				the_excerpt();
			} else {
				the_content( __( 'Continue reading', 'twentytwenty' ) );
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
<?php
}
else{
?>
    <article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
	<div class="row">
		<div class="col-md-3">
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
		<div class="col-md-6">
			<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

				<?php

				get_template_part('template-parts/entry-header');

				if (!is_search()) {
					get_template_part('template-parts/featured-image');
				}

				?>

				<div class="post-inner <?php echo is_page_template('templates/template-full-width.php') ? '' : 'thin'; ?> ">
					<!-- overviewline -->
					<div class="overviewline"></div>
					<div class="entry-content-1">

						<?php
						if (is_search() || !is_singular() && 'summary' === get_theme_mod('blog_content', 'full')) {
							the_excerpt();
						} else {
							the_content(__('Continue reading', 'twentytwenty'));
						}
						?>

					</div><!-- .entry-content -->

				</div><!-- .post-inner -->

				<div class="section-inner-1">
					<?php
					wp_link_pages(
						array(
							'before'      => '<nav class="post-nav-links bg-light-background" aria-label="' . esc_attr__('Page', 'twentytwenty') . '"><span class="label">' . __('Pages:', 'twentytwenty') . '</span>',
							'after'       => '</nav>',
							'link_before' => '<span class="page-number">',
							'link_after'  => '</span>',
						)
					);

					edit_post_link(); // edit last


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

				?>

			</article><!-- .post -->
		</div>
		<div class="col-md-3">
			<div class="cate">
				<h2>Recent Posts</h2>
				<div class="crossedbg-recentposts"></div>
				<div class="ul-cate">
					<ul>
					<li class="cate-name">
						<a href="http://wordpress.local/?p=18">Pin có thể uốn và co giãn như rắn</a>
					</li>
					<li class="cate-name">
						<a href="http://wordpress.local/?p=16">Tìm người giỏi cho những nghiên cứu hàng đầu tại VKIST</a>
					</li>
					<li class="cate-name">
						<a href="http://wordpress.local/?p=14">Usyk không muốn knock-out Joshua</a>
					</li>
					<li class="cate-name">
						<a href="http://wordpress.local/?p=12">Bồ Đào Nha vào chung kết futsal World Cup</a>
					</li>
					<li class="cate-name">
						<a href="http://wordpress.local/?p=10">Mourinho chạm mốc 200 trận tại Cup châu Âu</a>
					</li>
					</ul>
				</div>
			</div>
		</div>
	</div>

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
>



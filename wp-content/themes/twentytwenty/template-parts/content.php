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
        <div class="col-md-12">
            <div class="row title">
                <div class="col-md-10 col-xs-9">
                    <h1><?php

                        get_template_part( 'template-parts/entry-header' );

                        if ( ! is_search() ) {
                            get_template_part( 'template-parts/featured-image' );
                        }

                        ?></h1>
                </div>
                <div class="col-md-2 col-xs-3" >
                    <div class="headlinesdate">
                        <div class="headlinesdm">
                            <div class="headlinesday">24</div>
                            <div class="headlinesmonth">06</div>
                        </div>
                        <div class="headlinesyear">'18</div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12"><div class="overviewline"></div></div>
            </div>
            <div class="row overview">
                <div class="col-md-12">
                    <p>Theo khảo sát của VietnamWorks về ngành công nghệ thông tin (CNTT) ở Việt Nam, trong 3 năm qua, số lượng công việc ngành CNTT đã tăng trung bình 47%/năm.</p>

                </div>
            </div>
            <div class="row overview_thumb">
                <div class="col-md-12">
                </div>
            </div>
            <div class="row maincontent">
                <div class="col-md-12">
                    <p>
                        Tuy nhiên, số lượng nhân sự ngành này lại chỉ tăng ở mức trung bình 8% dẫn đến việc thiếu hụt nghiêm trọng nhân lực trong lĩnh vực này. Nguyên nhân chính được đưa ra là do số lượng doanh nghiệp tuyển dụng trong ngành CNTT đã tăng 69% từ năm 2012. Đặc biệt, số lượng công ty phần mềm đã tăng đến 124% chỉ trong vòng 4 năm. Khảo sát cũng cho thấy nếu cứ tiếp tục tăng trưởng nhân lực CNTT ở mức 8% như hiện nay, Việt Nam sẽ thiếu hụt khoảng 78.000 nhân lực CNTT mỗi năm và đến năm 2020 sẽ thiếu hơn 500.000 nhân lực CNTT.<br>
                        <br>
                        &ZeroWidthSpace;Dự báo trong 2 năm 2017 và 2018, các cơ sở đào tạo trong cả nước sẽ cho "ra lò" khoảng 80.000 nhân lực CNTT, so với nhu cầu tính đến cuối năm 2018, Việt Nam vẫn còn thiếu khoảng 70.000 nhân lực cho lĩnh vực này.
                    </p><div style="text-align: right;">&ZeroWidthSpace;(Theo Người Lao Động)</div>
                    <p></p>
                </div>
            </div>
        </div>

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
?>



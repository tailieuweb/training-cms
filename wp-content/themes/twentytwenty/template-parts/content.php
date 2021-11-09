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

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

	<?php
		if (is_single() == false) {
			echo '<div class="row card-item">';
		}
	?>


	<!-- LEFT: -->
	<?php
		if (is_single() == false) {
			echo '<div class="col-md-4 section-left">';
		}
	?>
	<!-- .entry-header -->
	<?php
	get_template_part( 'template-parts/entry-header' );

	if ( ! is_search() ) {
		get_template_part( 'template-parts/featured-image' );
	}
	?>
	<?php
		if (is_single() == false) {
			echo '</div>';
		}
	?>

	<!-- RIGHT: -->
	<?php
	if (is_single() == false) {
		echo '<div class="col-md-8 section-right">';
	}
	?>
	<div class="post-inner <?php echo is_page_template( 'templates/template-full-width.php' ) ? '' : 'thin'; ?> ">

		<div class="entry-content">

			<?php
			if ( is_search() || ! is_singular() && 'summary' === get_theme_mod( 'blog_content', 'full' ) ) {
				// the_excerpt();
				$a_post = get_post();

				// Post content:
				$content = $a_post->post_content;
				$strContent = preg_replace('/\<figure class=\"wp-block-image\"\>(.*?)\<\/figure\>/', '', $content);
				$temp = str_replace('<p>', '', $strContent);
				$strContent = str_replace('</p>', '', $temp);
				$temp = mb_substr($strContent, 0, 250);

				// Get image:
				preg_match('/src="([^"]*)"/', $content, $matches);
				preg_match('/(?<!_)src=([\'"])?(.*?)\\1/', $content, $matches);
				// echo '<p>Image URL: ' . var_dump($matches[0]) . '</p>';

				// Title:
				$title = $a_post->post_title;

				// Output:
				$readMoreBtn = '<a class="" href="' . get_permalink() . '">' . '[...]' . '</a>';
				echo '<a class="title-link" href="' . get_permalink() . '">' . $title . '</a>';
				echo '<p>' . mb_substr($strContent, 0, 300) . ' ' . $readMoreBtn . '</p>';

			} else {
				if (is_single() == true) {
					the_content( __( 'Continue reading', 'twentytwenty' ) );
				}
				else {
					// var_dump(get_post());
					$a_post = get_post();

					// Post content:
					$content = $a_post->post_content;
					$strContent = preg_replace('/\<figure class=\"wp-block-image\"\>(.*?)\<\/figure\>/', '', $content);
					$temp = str_replace('<p>', '', $strContent);
					$strContent = str_replace('</p>', '', $temp);
					$temp = mb_substr($strContent, 0, 250);

					// Title:
					$title = $a_post->post_title;

					// Output:
					$readMoreBtn = '<a class="" href="' . get_permalink() . '">' . '[...]' . '</a>';
					echo '<a class="title-link" href="' . get_permalink() . '">' . $title . '</a>';
					echo '<p>' . mb_substr($strContent, 0, 300) . ' ' . $readMoreBtn . '</p>';
					// echo '<p>' . mb_substr($strContent, 0, 250) . ' ' . $readMoreBtn . '</p>'; // This will show a bug in home page when you logged in!

					// Test:
					// var_dump($a_post->guid);
					// var_dump(get_post()->guid);
				}
			}
			?>

		</div>

	</div>
	<?php
	if (is_single() == false) {
		echo '</div>';
	}
	?>

	<!-- .section-inner -->
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

	</div><!-- /.section-inner -->

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

	<?php
		if (is_single() == false) {
			echo '</div>';
		}
	?>

</article><!-- .post -->

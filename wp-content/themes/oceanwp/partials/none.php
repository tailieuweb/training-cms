<?php
/**
 * The template for displaying a "No posts found" message.
 *
 * @package OceanWP WordPress theme
 */

?>

<div class="page-content">

	<?php if ( is_home() && current_user_can( 'publish_posts' ) ) { ?>

		<p>
			<?php
			/* translators: 1: Admin URL 2: </a> */
			echo sprintf( esc_html__( 'Ready to publish your first post? %1$sGet started here%2$s.', 'oceanwp' ), '<a href="' . esc_url( admin_url( 'post-new.php' ) ) . '" target="_blank">', '</a>' );
			?>
		</p>

	<?php } elseif ( is_search() ) { ?>

		<div class="error404-content clr">

			<h3 class="error-title-result"><?php esc_html_e( 'Không tìm thấy từ khóa', 'oceanwp' ); ?></h3>
			<p class="error-text-result"><?php esc_html_e( 'Xin vui lòng nhập lại từ khóa khác.', 'oceanwp' ); ?></p>
			<?php get_search_form(); ?>
			<a class="error-btn-result button" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Quay lại trang', 'oceanwp' ); ?></a>

		</div>

	<?php } elseif ( is_category() ) { ?>

		<p>
			<?php
			esc_html_e( 'There aren\'t any posts currently published in this category.', 'oceanwp' );
			?>
		</p>

	<?php } elseif ( is_tax() ) { ?>

		<p>
			<?php
			esc_html_e( 'There aren\'t any posts currently published under this taxonomy.', 'oceanwp' );
			?>
		</p>

	<?php } elseif ( is_tag() ) { ?>

		<p>
			<?php
			esc_html_e( 'There aren\'t any posts currently published under this tag.', 'oceanwp' );
			?>
		</p>

	<?php } else { ?>

		<p>
			<?php
			esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for.', 'oceanwp' );
			?>
		</p>

	<?php } ?>

</div><!-- .page-content -->

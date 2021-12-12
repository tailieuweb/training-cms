<?php get_header(); ?>

<?php

global $porto_settings, $porto_layout, $portfolio_num, $porto_portfolio_thumbs_html;

$portfolio_layout   = $porto_settings['portfolio-layout'];
$portfolio_infinite = $porto_settings['portfolio-infinite'];

$portfolio_columns = '';
$portfolio_view    = '';
if ( 'grid' == $portfolio_layout || 'masonry' == $portfolio_layout ) {
	$portfolio_columns = $porto_settings['portfolio-grid-columns'];
	$portfolio_view    = $porto_settings['portfolio-grid-view'];
}

$portfolio_columns = $portfolio_columns;

?>
<div id="content" role="main" class="<?php
if ( 'widewidth' === $porto_layout && ( 'grid' == $portfolio_layout || 'masonry' == $portfolio_layout ) && 'full' == $portfolio_view ) {
	if ( 'content' === $porto_settings['portfolio-cat-sort-pos'] ) {
		echo 'm-t-lg';
	}
}
?>">

	<?php if ( ! is_search() && 'content' == $porto_settings['portfolio-cat-sort-pos'] && $porto_settings['portfolio-title'] ) : ?>
		<?php
		if ( 'widewidth' === $porto_layout ) :
			?>
			<div class="container"><?php endif; ?>
		<h2 class="portfolio-archive-title"><?php echo porto_strip_script_tags( $porto_settings['portfolio-title'] ); ?></h2>
		<?php
		if ( 'widewidth' === $porto_layout ) :
			?>
			</div><?php endif; ?>
	<?php endif; ?>

	<?php if ( have_posts() ) : ?>

		<?php
		if ( $porto_settings['portfolio-archive-link-zoom'] ) :
			?>
			<div class="portfolios-lightbox<?php echo ! $porto_settings['portfolio-archive-img-lightbox-thumb'] ? '' : ' with-thumbs'; ?>"><?php endif; ?>

		<div class="page-portfolios portfolios-<?php echo esc_attr( $portfolio_layout ); ?> clearfix hubdata">

			<?php if ( $porto_settings['portfolio-archive-ajax'] && ! $porto_settings['portfolio-archive-ajax-modal'] ) : ?>
				<div id="portfolioAjaxBox" class="ajax-box">
					<div class="bounce-loader">
						<div class="bounce1"></div>
						<div class="bounce2"></div>
						<div class="bounce3"></div>
					</div>
					<div class="ajax-box-content" id="portfolioAjaxBoxContent"></div>
				</div>
			<?php endif; ?>

			<?php
			if ( 'hide' !== $porto_settings['portfolio-cat-sort-pos'] && ! is_search() ) {
				if ( 'sidebar' === $porto_settings['portfolio-cat-sort-pos'] && ! ( 'widewidth' == $porto_layout || 'fullwidth' == $porto_layout ) ) {
					add_action( 'porto_before_sidebar', 'porto_show_portfolio_archive_filter', 1 );
				} elseif ( 'content' === $porto_settings['portfolio-cat-sort-pos'] ) {
					$portfolio_taxs = array();

					$taxs = get_categories(
						array(
							'taxonomy' => 'portfolio_cat',
							'orderby'  => isset( $porto_settings['portfolio-cat-orderby'] ) ? $porto_settings['portfolio-cat-orderby'] : 'name',
							'order'    => isset( $porto_settings['portfolio-cat-order'] ) ? $porto_settings['portfolio-cat-order'] : 'asc',
						)
					);

					foreach ( $taxs as $tax ) {
						$portfolio_taxs[ urldecode( $tax->slug ) ] = $tax->name;
					}

					if ( ! $portfolio_infinite ) {
						global $wp_query;
						$posts_portfolio_taxs = array();
						if ( is_array( $wp_query->posts ) && ! empty( $wp_query->posts ) ) {
							foreach ( $wp_query->posts as $post ) {
								$post_taxs = wp_get_post_terms( $post->ID, 'portfolio_cat', array( 'fields' => 'all' ) );
								if ( is_array( $post_taxs ) && ! empty( $post_taxs ) ) {
									foreach ( $post_taxs as $post_tax ) {
										$posts_portfolio_taxs[ urldecode( $post_tax->slug ) ] = $post_tax->name;
									}
								}
							}
						}
						foreach ( $portfolio_taxs as $key => $value ) {
							if ( ! isset( $posts_portfolio_taxs[ $key ] ) ) {
								unset( $portfolio_taxs[ $key ] );
							}
						}
					}

					// Show Filters
					if ( is_array( $portfolio_taxs ) && ! empty( $portfolio_taxs ) ) :
						?>
						<?php
						if ( 'widewidth' === $porto_layout ) :
							?>
							<div class="container"><?php endif; ?>
						<ul class="portfolio-filter nav sort-source <?php echo isset( $porto_settings['portfolio-cat-sort-style'] ) && $porto_settings['portfolio-cat-sort-style'] ? 'sort-source-' . esc_attr( $porto_settings['portfolio-cat-sort-style'] ) : 'nav-pills'; ?>">
							<li class="active" data-filter="*"><a href="#"><?php esc_html_e( 'Show All', 'porto' ); ?></a></li>
							<?php foreach ( $portfolio_taxs as $portfolio_tax_slug => $portfolio_tax_name ) : ?>
								<li data-filter="<?php echo esc_attr( $portfolio_tax_slug ); ?>"><a href="#"><?php echo esc_html( $portfolio_tax_name ); ?></a></li>
							<?php endforeach; ?>
						</ul>
						<?php if ( isset( $porto_settings['portfolio-cat-sort-style'] ) && 'style-3' == $porto_settings['portfolio-cat-sort-style'] ) { ?>
						<?php } elseif ( 'grid' == $portfolio_layout || 'masonry' == $portfolio_layout ) { ?>
							<hr>
						<?php } elseif ( 'timeline' == $portfolio_layout ) { ?>
							<hr class="invisible">
						<?php } else { ?>
							<hr class="tall">
						<?php } ?>
						<?php
						if ( 'widewidth' === $porto_layout ) :
							?>
							</div><?php endif; ?>
						<?php
					endif;
				}
			}
			?>

			<?php
			if ( 'timeline' == $portfolio_layout ) :
				global $prev_post_year, $prev_post_month, $first_timeline_loop, $post_count;

				$prev_post_year      = null;
				$prev_post_month     = null;
				$first_timeline_loop = false;
				$post_count          = 1;
				?>

			<section class="timeline">

				<div class="timeline-body portfolios-container">

			<?php else : ?>

			<div class="clearfix portfolio-row portfolios-container<?php echo 'grid' == $portfolio_layout || 'masonry' == $portfolio_layout ? esc_attr( ' portfolio-row-' . $portfolio_columns . ' ' . $portfolio_view ) : ''; ?>">

			<?php endif; ?>

				<?php
				$portfolio_num = 0;
				while ( have_posts() ) {
					the_post();
					++$portfolio_num;
					get_template_part( 'content', 'archive-portfolio-' . $portfolio_layout );
				}
				?>

				<?php
				if ( $porto_settings['portfolio-archive-img-lightbox-thumb'] ) :
					$thumbs_carousel_options = array(
						'items'  => 15,
						'loop'   => false,
						'dots'   => false,
						'nav'    => false,
						'margin' => 8,
					);
					?>
					<div class="porto-portfolios-lighbox-thumbnails">
						<div class="owl-carousel owl-theme nav-center" data-plugin-options='<?php echo json_encode( $thumbs_carousel_options ); ?>'>
							<?php echo porto_filter_output( $porto_portfolio_thumbs_html ); ?>
						</div>
					</div>
				<?php endif; ?>

			<?php if ( 'timeline' == $portfolio_layout ) : ?>
				</div>
			</section>
			<?php else : ?>
			</div>
			<?php endif; ?>

			<?php porto_pagination(); ?>

		</div>

		<?php wp_reset_postdata(); ?>

		<?php
		if ( $porto_settings['portfolio-archive-link-zoom'] ) :
			?>
			</div><?php endif; ?>

	<?php else : ?>

		<p><?php esc_html_e( 'Apologies, but no results were found for the requested archive.', 'porto' ); ?></p>

	<?php endif; ?>

</div>

<?php get_footer(); ?>

<?php
global $porto_settings, $porto_layout, $post, $porto_portfolio_columns, $porto_portfolio_view, $porto_portfolio_thumb, $porto_portfolio_thumb_style, $porto_portfolio_slider, $porto_portfolio_image_counter, $porto_portfolio_thumb_bg, $porto_portfolio_thumb_image, $porto_portfolio_ajax_load, $porto_portfolio_ajax_modal, $portfolio_num, $porto_portfolio_thumbs_html;

$portfolio_columns = $porto_settings['portfolio-grid-columns'];
if ( $porto_portfolio_columns ) {
	$portfolio_columns = $porto_portfolio_columns;
}
$portfolio_columns         = (int) $portfolio_columns;
$portfolio_layout          = 'masonry';
$portfolio_view            = $porto_settings['portfolio-grid-view'];
$portfolio_thumb           = $porto_portfolio_thumb ? $porto_portfolio_thumb : $porto_settings['portfolio-archive-thumb'];
$portfolio_thumb_style     = $porto_portfolio_thumb_style ? $porto_portfolio_thumb_style : $porto_settings['portfolio-archive-thumb-style'];
$portfolio_thumb_bg        = $porto_portfolio_thumb_bg ? $porto_portfolio_thumb_bg : $porto_settings['portfolio-archive-thumb-bg'];
$portfolio_thumb_image     = $porto_portfolio_thumb_image ? ( 'zoom' == $porto_portfolio_thumb_image ? '' : $porto_portfolio_thumb_image ) : $porto_settings['portfolio-archive-thumb-image'];
$portfolio_show_link       = $porto_settings['portfolio-archive-link'];
$portfolio_show_all_images = $porto_settings['portfolio-archive-all-images'];
$portfolio_images_count    = $porto_settings['portfolio-archive-images-count'];
$portfolio_show_zoom       = $porto_settings['portfolio-archive-zoom'];
$portfolio_ajax            = $porto_settings['portfolio-archive-ajax'];
$portfolio_ajax_modal      = $porto_settings['portfolio-archive-ajax-modal'];
if ( 'yes' == $porto_portfolio_ajax_load ) {
	$portfolio_ajax = true;
} elseif ( 'no' == $porto_portfolio_ajax_load ) {
	$portfolio_ajax = false;
}

if ( 'yes' == $porto_portfolio_ajax_modal ) {
	$portfolio_ajax_modal = true;
} elseif ( 'no' == $porto_portfolio_ajax_modal ) {
	$portfolio_ajax_modal = false;
}
if ( $porto_portfolio_view && 'classic' != $porto_portfolio_view ) {
	$portfolio_view = $porto_portfolio_view;
}
$post_class   = array();
$post_class[] = 'portfolio';
$post_class[] = 'portfolio-' . $portfolio_layout;
if ( -1 === $portfolio_columns ) {
	global $porto_post_count, $porto_grid_layout;
	$grid_layout  = $porto_grid_layout[ $porto_post_count % count( $porto_grid_layout ) ];
	$post_class[] = 'grid-col-' . $grid_layout['width'] . ' grid-col-md-' . $grid_layout['width_md'] . ( isset( $grid_layout['width_lg'] ) ? ' grid-col-lg-' . $grid_layout['width_lg'] : '' ) . ( isset( $grid_layout['height'] ) ? ' grid-height-' . $grid_layout['height'] : '' );
	$porto_post_count++;
	if ( ! isset( $image_size ) ) {
		$image_size = $grid_layout['size'];
	}
} else {
	$post_class[] = ' portfolio-col-' . $portfolio_columns;
}
$item_cats = get_the_terms( $post->ID, 'portfolio_cat' );
if ( $item_cats ) {
	foreach ( $item_cats as $item_cat ) {
		$post_class[] = urldecode( $item_cat->slug );
	}
}
$archive_image = (int) get_post_meta( $post->ID, 'portfolio_archive_image', true );
if ( $archive_image ) {
	$featured_images   = array();
	$featured_image    = array(
		'thumb'         => wp_get_attachment_thumb_url( $archive_image ),
		'full'          => wp_get_attachment_url( $archive_image ),
		'attachment_id' => $archive_image,
	);
	$featured_images[] = $featured_image;
} else {
	$featured_images = porto_get_featured_images();
}
$portfolio_link             = get_post_meta( $post->ID, 'portfolio_link', true );
$show_external_link         = $porto_settings['portfolio-external-link'];
$options                    = array();
$options['margin']          = 10;
$options['animateOut']      = 'fadeOut';
$options['autoplay']        = true;
$options['autoplayTimeout'] = 3000;
$options                    = json_encode( $options );
$count                      = count( $featured_images );
$classes                    = array();
$classes[]                  = 'thumb-info-no-borders';
if ( $portfolio_thumb_bg ) {
	$classes[] = 'thumb-info-' . $portfolio_thumb_bg;
}
$show_info      = true;
$show_plus_icon = false;
switch ( $portfolio_thumb ) {
	case 'plus-icon':
		$show_info      = false;
		$show_plus_icon = true;
		break;
	case 'left-info-no-bg':
		$classes[]           = 'thumb-info-left-no-bg';
		$portfolio_show_zoom = false;
		break;
	case 'centered-info':
		$classes[]           = 'thumb-info-centered-info';
		$portfolio_show_zoom = false;
		break;
	case 'bottom-info':
		$classes[] = 'thumb-info-bottom-info';
		break;
	case 'bottom-info-dark':
		$classes[] = 'thumb-info-bottom-info thumb-info-bottom-info-dark';
		break;
	case 'hide-info-hover':
		$classes[] = 'thumb-info-centered-info thumb-info-hide-info-hover';
		break;
}

if ( 'alternate-info' == $portfolio_thumb_style || 'alternate-with-plus' == $portfolio_thumb_style ) {
	if ( 0 == $portfolio_num % 2 ) {
		$show_info = false;
		$classes[] = 'alternate-info-hide';
	} else {
		$classes[] = 'alternate-info';
	}
}

if ( 'alternate-with-plus' == $portfolio_thumb_style ) {
	$show_plus_icon = true;
}

$show_counter = $porto_settings['portfolio-archive-image-counter'];
switch ( $porto_portfolio_image_counter ) {
	case 'show':
		$show_counter = true;
		break;
	case 'hide':
		$show_counter = false;
		break;
}
if ( $count > 1 && $portfolio_show_all_images ) {
	$classes[] = 'thumb-info-no-zoom';
} elseif ( $portfolio_thumb_image ) {
	$classes[] = 'thumb-info-' . $portfolio_thumb_image;
}
$ajax_attr_escaped = '';
if ( ! ( $show_external_link && $portfolio_link ) && $portfolio_ajax ) {
	$portfolio_show_zoom       = false;
	$portfolio_show_all_images = false;
	if ( $portfolio_ajax_modal ) {
		$ajax_attr_escaped = ' data-ajax-on-modal';
	} else {
		$ajax_attr_escaped = ' data-ajax-on-page';
	}
}
if ( $portfolio_show_zoom ) {
	$classes[] = 'thumb-info-centered-icons';
}
$class                    = implode( ' ', $classes );
$zoom_src                 = array();
$zoom_title               = array();
$sub_title                = porto_portfolio_sub_title( $post );
$portfolio_show_link_zoom = false;
if ( $porto_settings['portfolio-archive-link-zoom'] ) {
	$portfolio_show_link_zoom  = true;
	$portfolio_show_zoom       = false;
	$portfolio_show_link       = false;
	$portfolio_show_all_images = false;
}
if ( $ajax_attr_escaped ) {
	$portfolio_show_link_zoom = false;
}
if ( $count ) :
	$attachment = porto_get_attachment( $featured_images[0]['attachment_id'] );
	if ( $portfolio_columns > 2 && $attachment ) {
		if ( $attachment['width'] > $attachment['height'] * abs( $porto_settings['portfolio-archive-masonry-ratio'] ) ) {
			$post_class[] = ' w2';
			if ( ! isset( $image_size ) ) {
				$image_size = ( $portfolio_columns >= 6 ? 'portfolio-masonry' : ( $portfolio_columns >= 4 ? 'blog-masonry' : 'full' ) );
			}
		}
	}

	$portfolio_id             = $post->ID;
	$portfolio_slider_ids_arr = explode( ',', $porto_portfolio_slider );
	$carousel_options         = array(
		'items'        => 1,
		'margin'       => 0,
		'loop'         => true,
		'dots'         => false,
		'nav'          => true,
		'stagePadding' => 0,
	);
	$featured_images_all      = porto_get_featured_images();
	if ( isset( $featured_image ) && $featured_image ) {
		$featured_images_all[0] = $featured_image;
	}

	?>
	<article <?php post_class( $post_class ); ?>>
		<?php porto_render_rich_snippets(); ?>
		<div class="portfolio-item <?php echo esc_attr( $portfolio_view ); ?>">
			<?php if ( isset( $show_counter ) && ( $show_counter ) ) : ?>
				<span class="thumb-info-icons position-style-2 text-color-light">
					<span class="thumb-info-icon pictures background-color-primary">
					<?php echo function_exists( 'porto_get_featured_images' ) ? count( porto_get_featured_images() ) : 0; ?>
					<i class="far fa-image"></i>
					</span>
				</span>
			<?php endif; ?>
			<a class="text-decoration-none portfolio-link" href="<?php
			if ( $portfolio_show_link_zoom ) {
				foreach ( $featured_images as $featured_image ) {
					$attachment_id = $featured_image['attachment_id'];
					$attachment    = porto_get_attachment( $attachment_id );
					if ( $attachment ) {
						echo esc_url( $attachment['src'] );
						break;
					}
				}
			} else {
				if ( $show_external_link && $portfolio_link ) {
					echo esc_url( $portfolio_link );
				} else {
					the_permalink();
				}
			}
			?>"<?php echo ! $ajax_attr_escaped ? '' : $ajax_attr_escaped; ?>>
				<span class="thumb-info <?php echo esc_attr( $class ); ?>">
					<span class="thumb-info-wrapper">
						<?php if ( in_array( $portfolio_id, $portfolio_slider_ids_arr ) && ! $porto_settings['portfolio-archive-link-zoom'] ) : ?>
							<div class="porto-carousel owl-carousel m-b-none owl-theme show-nav-hover" data-plugin-options='<?php echo json_encode( $carousel_options ); ?>'>
							<?php
							$featured_images           = $featured_images_all;
							$portfolio_show_all_images = true;
						elseif ( $count > 1 && $portfolio_show_all_images ) :
							?>
							<div class="porto-carousel owl-carousel m-b-none nav-inside show-nav-hover" data-plugin-options="<?php echo esc_attr( $options ); ?>">
							<?php
						endif;

							$i = 0;
						foreach ( $featured_images as $featured_image ) :
							$attachment_id   = $featured_image['attachment_id'];
							$attachment      = porto_get_attachment( $attachment_id, isset( $image_size ) ? $image_size : ( $portfolio_columns >= 3 ? 'portfolio-masonry' : 'full' ) );
							$attachment_full = porto_get_attachment( $attachment_id );
							if ( $attachment && $attachment_full ) :
								$zoom_src[]   = $attachment_full['src'];
								$zoom_title[] = $attachment['caption'];
								?>
									<img class="img-responsive" width="<?php echo esc_attr( $attachment['width'] ); ?>" height="<?php echo esc_attr( $attachment['height'] ); ?>" src="<?php echo esc_url( $attachment['src'] ); ?>" alt="<?php echo esc_attr( $attachment['alt'] ); ?>" />
									<?php
									if ( $porto_settings['portfolio-archive-img-lightbox-thumb'] && $attachment_id ) {
										$attachment_thumb             = porto_get_attachment( $attachment_id, 'widget-thumb-medium' );
										$porto_portfolio_thumbs_html .= '<span><img src="' . esc_url( $attachment_thumb['src'] ) . '" alt="' . esc_attr( $attachment_thumb['alt'] ) . '" ></span>';
									}
									if ( ! $portfolio_show_all_images ) {
										break;
									}
									$i++;
									if ( $i >= $portfolio_images_count ) {
										break;
									}
								endif;
							endforeach;
						?>

						<?php if ( in_array( $portfolio_id, $portfolio_slider_ids_arr ) && ! $porto_settings['portfolio-archive-link-zoom'] ) : ?>
							</div>
						<?php elseif ( $count > 1 && $portfolio_show_all_images ) : ?>
							</div>
						<?php endif; ?>

						<?php if ( 'outimage' != $portfolio_view ) : ?>
							<?php if ( $show_info ) : ?>
							<span class="thumb-info-title">
								<span class="thumb-info-inner<?php echo ( 5 == $portfolio_columns && ( 'fullwidth' == $porto_layout || 'left-sidebar' == $porto_layout || 'right-sidebar' == $porto_layout ) ) ? ' font-size-sm' : '', ( 6 == $portfolio_columns && ( 'fullwidth' == $porto_layout || 'left-sidebar' == $porto_layout || 'right-sidebar' == $porto_layout ) ) ? ' font-size-xs' : ''; ?>"><?php the_title(); ?></span>
									<?php
									if ( $sub_title ) :
										?>
									<span class="thumb-info-type"><?php echo wp_kses_post( $sub_title ); ?></span>
									<?php endif ?>
							</span>
							<?php elseif ( $show_plus_icon ) : ?>
								<span class="thumb-info-plus"></span>
							<?php endif; ?>
							<?php
						else :
							if ( $porto_settings['portfolio-archive-readmore'] ) :
								?>
							<span class="thumb-info-title">
								<span class="thumb-info-inner<?php echo ( (int) $portfolio_columns > 4 && ( 'fullwidth' == $porto_layout || 'left-sidebar' == $porto_layout || 'right-sidebar' == $porto_layout ) ) ? ' font-size-xs line-height-xs' . ( 'bottom-info' == $portfolio_thumb ? ' p-t-xs' : '' ) : ''; ?>"><?php echo ! $porto_settings['portfolio-archive-readmore-label'] ? esc_html__( 'View Project...', 'porto' ) : wp_kses_post( $porto_settings['portfolio-archive-readmore-label'] ); ?></span>
							</span>
								<?php
							endif;
						endif;
						?>
						<?php if ( $portfolio_show_link || $portfolio_show_zoom ) : ?>
							<span class="thumb-info-action">
								<?php if ( $portfolio_show_link ) : ?>
									<span class="thumb-info-action-icon thumb-info-action-icon-<?php echo ! $portfolio_show_zoom ? 'dark opacity-8' : 'primary'; ?>"><i class="fa <?php echo ! $ajax_attr_escaped ? 'fa-link' : 'fa-plus-square'; ?>"></i></span>
								<?php endif; ?>
								<?php if ( $portfolio_show_zoom ) : ?>
									<span class="thumb-info-action-icon thumb-info-action-icon-light thumb-info-zoom" data-src="<?php echo esc_attr( json_encode( $zoom_src ) ); ?>" data-title="<?php echo esc_attr( json_encode( $zoom_title ) ); ?>"><i class="fas fa-search-plus"></i></span>
								<?php endif; ?>
							</span>
						<?php endif; ?>
						<?php
						if ( $portfolio_show_link_zoom ) :
							?>
							<span class="thumb-info-zoom" data-src="<?php echo esc_attr( json_encode( $zoom_src ) ); ?>" data-title="<?php echo esc_attr( json_encode( $zoom_title ) ); ?>"></span><?php endif; ?>
					</span>
				</span>
			</a>
			<?php if ( 'outimage' == $portfolio_view ) : ?>
				<?php if ( $portfolio_columns > 4 ) : ?>
					<h5 class="portfolio-title m-t-md m-b-none"><?php the_title(); ?></h5>
				<?php else : ?>
					<h4 class="portfolio-title m-t-md m-b-none"><?php the_title(); ?></h4>
				<?php endif; ?>
				<?php if ( $sub_title ) : ?>
					<p class="m-b-sm color-body"><?php echo wp_kses_post( $sub_title ); ?></p>
				<?php endif; ?>

				<?php if ( $porto_settings['portfolio-show-content'] ) : ?>
					<div class="portfolio-brief-content m-t p-l-lg p-r-lg">
					<?php
					if ( $porto_settings['portfolio-excerpt'] ) {
						if ( has_excerpt() ) {
							the_excerpt();
						} else {
							echo porto_get_excerpt( $porto_settings['portfolio-excerpt-length'], $porto_settings['portfolio-archive-readmore'] ? true : false );
						}
					} else {
						porto_the_content();
					}
					?>
					</div>
				<?php endif; ?>

				<?php porto_get_template_part( 'views/portfolios/quote' ); ?>
			<?php endif; ?>

			<?php do_action( 'porto_portfolio_after_content' ); ?>
		</div>
	</article>
	<?php
endif;

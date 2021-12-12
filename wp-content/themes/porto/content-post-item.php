<?php
global $porto_settings, $porto_post_view, $porto_post_btn_style, $porto_post_btn_size, $porto_post_btn_color, $porto_post_image_size, $porto_post_author, $porto_post_excerpt_length;
$featured_images    = porto_get_featured_images();
$attachment         = '';
$attachment_related = '';

if ( $porto_post_image_size ) {
	$image_size = $porto_post_image_size;
} elseif ( ! isset( $image_size ) ) {
	$image_size = false;
}
if ( count( $featured_images ) ) {
	$attachment_id = $featured_images[0]['attachment_id'];
	if ( $image_size ) {
		$image_sizes        = get_intermediate_image_sizes();
		$attachment_related = porto_get_attachment( $attachment_id, $image_size, ( 'full' !== $image_size && ! in_array( $image_size, $image_sizes ) ) );
	} else {
		$attachment_related = porto_get_attachment( $attachment_id, 'related-post' );
	}
	$attachment = porto_get_attachment( $attachment_id );
	if ( ! $attachment_related ) {
		$attachment_related = $attachment;
	}
}
$post_style         = $porto_post_view ? $porto_post_view : ( isset( $post_view ) ? $post_view : $porto_settings['post-related-style'] );
$post_thumb_bg      = $porto_settings['post-related-thumb-bg'];
$post_thumb_image   = $porto_settings['post-related-thumb-image'];
$post_thumb_borders = $porto_settings['thumb-padding'] ? $porto_settings['post-related-thumb-borders'] : '';
$post_author        = $porto_post_author ? ( 'show' == $porto_post_author ? true : false ) : $porto_settings['post-related-author'];

if ( isset( $excerpt_length ) && $excerpt_length ) {
	$excerpt_length = (int) $excerpt_length;
} else {
	$excerpt_length = $porto_settings['post-related-excerpt-length'];
}
if ( $porto_post_excerpt_length ) {
	$excerpt_length = (int) $porto_post_excerpt_length;
}
$show_date = in_array( 'date', $porto_settings['post-metas'] );
if ( $post_style && 'style-3' == $post_style ) {
	?>
<div class="post-item with-btn<?php echo porto_filter_output( 'without-icon' == $porto_settings['post-title-style'] ? ' post-title-simple' : '' ); ?>">
	<?php if ( $attachment && $attachment_related ) : ?>
	<a href="<?php the_permalink(); ?>"> <span class="post-image thumb-info<?php echo ( ! empty( $post_thumb_bg ) ? ' thumb-info-' . esc_attr( $post_thumb_bg ) : '' ), ( ! $post_thumb_image ? '' : ' thumb-info-' . esc_attr( $post_thumb_image ) ), ( ! empty( $post_thumb_borders ) ? ' thumb-info-' . esc_attr( $post_thumb_borders ) : '' ); ?> m-b-md"> <span class="thumb-info-wrapper"> <img class="img-responsive" width="<?php echo esc_attr( $attachment_related['width'] ); ?>" height="<?php echo esc_attr( $attachment_related['height'] ); ?>" src="<?php echo esc_url( $attachment_related['src'] ); ?>" alt="<?php echo esc_attr( $attachment_related['alt'] ); ?>" />
		<?php if ( $porto_settings['post-zoom'] ) : ?>
	<span class="zoom" data-src="<?php echo esc_url( $attachment['src'] ); ?>" data-title="<?php echo esc_attr( $attachment['caption'] ); ?>"><i class="fas fa-search"></i></span>
	<?php endif; ?>
	</span> </span> </a>
		<?php
	endif;
	if ( $show_date ) :
		?>
	<div class="post-date">
		<?php
		porto_post_date();
		// porto_post_format();
		?>
	</div>
		<?php
	endif;
	if ( $post_author ) :
		?>
	<h4 class="title-short"><a href="<?php the_permalink(); ?>">
		<?php the_title(); ?>
	</a></h4>
	<p class="author-name"><?php esc_html_e( 'By', 'porto' ); ?><?php the_author_posts_link(); ?></p>
	<?php else : ?>
	<h4><a href="<?php the_permalink(); ?>">
		<?php the_title(); ?>
	</a></h4>
	<?php endif; ?>
	<?php echo porto_get_excerpt( $excerpt_length, false ); ?> <a href="<?php the_permalink(); ?>" class="btn <?php echo esc_attr( $porto_post_btn_style ? $porto_post_btn_style : $porto_settings['post-related-btn-style'] ); ?> <?php echo esc_attr( $porto_post_btn_color ? $porto_post_btn_color : $porto_settings['post-related-btn-color'] ); ?> <?php echo esc_attr( $porto_post_btn_size ? $porto_post_btn_size : $porto_settings['post-related-btn-size'] ); ?> m-t-md m-b-md"><?php esc_html_e( 'Read More', 'porto' ); ?></a> </div>
<?php } elseif ( 'style-2' == $post_style ) { ?>

	<?php
	$post_meta = '';

	$post_meta .= '<div class="post-meta">';

	if ( in_array( 'date', $porto_settings['post-metas'] ) ) {
		$post_meta .= '<span class="meta-date"><i class="far fa-calendar-alt"></i>' . get_the_date() . '</span>';
	}

	if ( in_array( 'author', $porto_settings['post-metas'] ) ) {
		$post_meta .= '<span class="meta-author"><i class="far fa-user"></i> <span>' . esc_html__( 'By ', 'porto' ) . '</span>' . get_the_author_posts_link() . '</span>';
	}

	$cats_list = get_the_category_list( ', ' );
	if ( $cats_list && in_array( 'cats', $porto_settings['post-metas'] ) ) {
		$post_meta .= '<span class="meta-cats"><i class="far fa-folder"></i>' . porto_filter_output( $cats_list ) . '</span>';
	}

	$tags_list = get_the_tag_list( '', ', ' );
	if ( $tags_list && in_array( 'tags', $porto_settings['post-metas'] ) ) {
		$post_meta .= '<span class="meta-tags"><i class="far fa-envelope"></i>' . porto_filter_output( $tags_list ) . '</span>';
	}
	if ( in_array( 'comments', $porto_settings['post-metas'] ) ) {
		$post_meta .= '<span class="meta-comments"><i class="far fa-comments"></i>' . get_comments_popup_link( __( '0 Comments', 'porto' ), __( '1 Comment', 'porto' ), '% ' . __( 'Comments', 'porto' ) ) . '</span>';
	}

	if ( function_exists( 'Post_Views_Counter' ) && 'manual' == Post_Views_Counter()->options['display']['position'] && in_array( 'post', (array) Post_Views_Counter()->options['general']['post_types_count'] ) ) {
		$post_count = do_shortcode( '[post-views]' );
		if ( $post_count ) {
			$post_meta .= $post_count;
		}
	}

	if ( in_array( 'like', $porto_settings['post-metas'] ) ) {
		$post_meta .= '<span class="meta-like">' . porto_blog_like() . '</span>';
	}

	$post_meta .= '</div>';

	$post_share = get_post_meta( $post->ID, 'post_share', true );
	?>


<div class="post-item style-2<?php echo ( 'without-icon' == $porto_settings['post-title-style'] ) ? ' post-title-simple' : ''; ?>">
	<?php if ( $attachment && $attachment_related ) : ?>
	<a href="<?php the_permalink(); ?>"> <span class="post-image thumb-info<?php echo ( ! empty( $post_thumb_bg ) ? ' thumb-info-' . esc_attr( $post_thumb_bg ) : '' ), ( ! empty( $post_thumb_image ) ? ' thumb-info-' . esc_attr( $post_thumb_image ) : '' ), ( ! empty( $post_thumb_borders ) ? ' thumb-info-' . esc_attr( $post_thumb_borders ) : '' ); ?> m-b-md"> <span class="thumb-info-wrapper"> <img class="img-responsive" width="<?php echo esc_attr( $attachment_related['width'] ); ?>" height="<?php echo esc_attr( $attachment_related['height'] ); ?>" src="<?php echo esc_url( $attachment_related['src'] ); ?>" alt="<?php echo esc_attr( $attachment_related['alt'] ); ?>" />
		<?php if ( $porto_settings['post-zoom'] ) : ?>
	<span class="zoom" data-src="<?php echo esc_url( $attachment['src'] ); ?>" data-title="<?php echo esc_attr( $attachment['caption'] ); ?>"><i class="fas fa-search"></i></span>
	<?php endif; ?>
	</span> </span> </a>
	<?php endif; ?>
	<div class="post-recent-main">
	<!-- Post meta before content -->
	<?php
	if ( 'before' === $porto_settings['post-meta-position'] ) {
		echo porto_filter_output( $post_meta );}
	?>
	<div class="post-recent-content"> 
		<h5> <a class="text-<?php echo 'dark' == $porto_settings['css-type'] ? 'light' : 'dark'; ?>" href="<?php the_permalink(); ?>">
		<?php the_title(); ?>
		</a> </h5>
		<?php echo porto_get_excerpt( $excerpt_length, false ); ?>
	</div>
	<!-- Post meta after content -->
	<?php
	if ( 'before' !== $porto_settings['post-meta-position'] ) {
		echo porto_filter_output( $post_meta );}
	?>
	</div>
</div>
<?php } elseif ( 'style-4' == $post_style ) { ?>
<div class="post-item style-4<?php echo 'without-icon' == $porto_settings['post-title-style'] ? ' post-title-simple' : ''; ?>"> <span class="thumb-info thumb-info-side-image thumb-info-no-zoom">
	<?php if ( $attachment && $attachment_related ) : ?>
	<a href="<?php the_permalink(); ?>"> <span class="post-image thumb-info-side-image-wrapper"> <img class="img-responsive" width="<?php echo esc_attr( $attachment_related['width'] ); ?>" height="<?php echo esc_attr( $attachment_related['height'] ); ?>" src="<?php echo esc_url( $attachment_related['src'] ); ?>" alt="<?php echo esc_attr( $attachment_related['alt'] ); ?>" />
		<?php if ( $porto_settings['post-zoom'] ) : ?>
	<span class="zoom" data-src="<?php echo esc_url( $attachment['src'] ); ?>" data-title="<?php echo esc_attr( $attachment['caption'] ); ?>"><i class="fas fa-search"></i></span>
	<?php endif; ?>
	</span> </a>
	<?php endif; ?>
	<span class="thumb-info-caption"> <span class="thumb-info-caption-text"> <a class="post-title" href="<?php the_permalink(); ?>">
			<h2 class="m-b-sm m-t-xs">
			<?php the_title(); ?>
			</h2>
		</a>
		<div class="post-meta m-b-sm<?php echo ( empty( $porto_settings['post-metas'] ) ? ' d-none' : '' ); ?>">
		<?php
			$first = true;
		if ( in_array( 'date', $porto_settings['post-metas'] ) ) :
			?>
			<?php
			if ( $first ) {
				$first = false;
			} else {
				echo ' | ';}
			?>
			<?php echo get_the_date( esc_html( $porto_settings['blog-date-format'] ) ); ?>
		<?php endif; ?>
		<?php if ( in_array( 'author', $porto_settings['post-metas'] ) ) : ?>
			<?php
			if ( $first ) {
				$first = false;
			} else {
				echo ' | ';}
			?>
			<?php the_author_posts_link(); ?>
		<?php endif; ?>
		<?php
			$cats_list = get_the_category_list( ', ' );
		if ( $cats_list && in_array( 'cats', $porto_settings['post-metas'] ) ) :
			?>
			<?php
			if ( $first ) {
				$first = false;
			} else {
				echo ' | ';}
			?>
			<?php echo porto_filter_output( $cats_list ); ?>
		<?php endif; ?>
		<?php
			$tags_list = get_the_tag_list( '', ', ' );
		if ( $tags_list && in_array( 'tags', $porto_settings['post-metas'] ) ) :
			?>
			<?php
			if ( $first ) {
				$first = false;
			} else {
				echo ' | ';}
			?>
			<?php echo porto_filter_output( $tags_list ); ?>
		<?php endif; ?>
		<?php if ( in_array( 'comments', $porto_settings['post-metas'] ) ) : ?>
			<?php
			if ( $first ) {
				$first = false;
			} else {
				echo ' | ';}
			?>
			<?php comments_popup_link( __( '0 Comments', 'porto' ), __( '1 Comment', 'porto' ), '% ' . __( 'Comments', 'porto' ) ); ?>
		<?php endif; ?>
		<?php
		if ( function_exists( 'Post_Views_Counter' ) && 'manual' == Post_Views_Counter()->options['display']['position'] && in_array( 'post', (array) Post_Views_Counter()->options['general']['post_types_count'] ) ) {
			$post_count = do_shortcode( '[post-views]' );
			if ( $post_count ) {
				if ( $first ) {
					$first = false;
				} else {
					echo ' | ';
				}
				echo wp_kses_post( $post_count );
			}
		}
		?>
		</div>
		<?php echo porto_get_excerpt( $excerpt_length, true, true ); ?>
	</span> </span> </span>
</div>
<?php } elseif ( 'style-5' == $post_style ) { ?>
<div class="post-item style-5<?php echo 'without-icon' == $porto_settings['post-title-style'] ? ' post-title-simple' : ''; ?>">
	<?php if ( $attachment && $attachment_related ) : ?>
	<a href="<?php the_permalink(); ?>"> <span class="post-image thumb-info<?php echo ( ! empty( $post_thumb_bg ) ? ' thumb-info-' . esc_attr( $post_thumb_bg ) : '' ), ( ! empty( $post_thumb_image ) ? ' thumb-info-' . esc_attr( $post_thumb_image ) : '' ), ( ! empty( $post_thumb_borders ) ? ' thumb-info-' . esc_attr( $post_thumb_borders ) : '' ); ?> m-b-lg"> <span class="thumb-info-wrapper"> <img class="img-responsive" width="<?php echo esc_attr( $attachment_related['width'] ); ?>" height="<?php echo esc_attr( $attachment_related['height'] ); ?>" src="<?php echo esc_url( $attachment_related['src'] ); ?>" alt="<?php echo esc_attr( $attachment_related['alt'] ); ?>" />
		<?php if ( $porto_settings['post-zoom'] ) : ?>
	<span class="zoom" data-src="<?php echo esc_url( $attachment['src'] ); ?>" data-title="<?php echo esc_attr( $attachment['caption'] ); ?>"><i class="fas fa-search"></i></span>
	<?php endif; ?>
	</span> </span> </a>
	<?php endif; ?>
	<?php
		$cats_list = '';
		$cats      = array();
	foreach ( get_the_category() as $c ) {
		$cat = get_category( $c );
		array_push( $cats, $cat->name );
	}
	if ( sizeof( $cats ) > 0 ) {
		$cats_list = implode( ', ', $cats );
	}
	if ( $cats_list && in_array( 'cats', $porto_settings['post-metas'] ) ) :
		?>
	<span class="cat-names"><?php echo porto_filter_output( $cats_list ); ?></span>
	<?php endif; ?>
	<h3 class="m-b-lg"> <a class="text-decoration-none text-<?php echo 'dark' == $porto_settings['css-type'] ? 'light' : 'dark'; ?>" href="<?php the_permalink(); ?>">
	<?php the_title(); ?>
	</a> </h3>
	<?php echo porto_get_excerpt( $excerpt_length, false ); ?>
	<div class="post-meta clearfix m-t-lg">
	<?php if ( in_array( 'date', $porto_settings['post-metas'] ) ) : ?>
	<span class="meta-date"><i class="far fa-calendar-alt"></i> <?php echo get_the_date(); ?></span>
	<?php endif; ?>
	<?php if ( in_array( 'author', $porto_settings['post-metas'] ) ) : ?>
	<span class="meta-author"><i class="far fa-user"></i> <span><?php esc_html_e( 'By', 'porto' ); ?></span>
		<?php the_author_posts_link(); ?>
	</span>
	<?php endif; ?>
	<?php
			$tags_list = get_the_tag_list( '', ', ' );
	if ( $tags_list && in_array( 'tags', $porto_settings['post-metas'] ) ) :
		?>
	<span class="meta-tags"><i class="far fa-envelope"></i> <?php echo porto_filter_output( $tags_list ); ?></span>
	<?php endif; ?>
	<?php if ( in_array( 'comments', $porto_settings['post-metas'] ) ) : ?>
	<span class="meta-comments"><i class="far fa-comments"></i>
		<?php comments_popup_link( __( '0 Comments', 'porto' ), __( '1 Comment', 'porto' ), '% ' . __( 'Comments', 'porto' ) ); ?>
	</span>
	<?php endif; ?>
	<?php
	if ( function_exists( 'Post_Views_Counter' ) && 'manual' == Post_Views_Counter()->options['display']['position'] && in_array( 'post', (array) Post_Views_Counter()->options['general']['post_types_count'] ) ) {
		$post_count = do_shortcode( '[post-views]' );
		if ( $post_count ) {
			echo wp_kses_post( $post_count );
		}
	}

	if ( in_array( 'like', $porto_settings['post-metas'] ) ) {
		echo '<span class="meta-like">' . porto_blog_like() . '</span>';
	}
	?>
	</div>
</div>
<?php } elseif ( 'style-6' == $post_style ) { ?>
<div class="post-item style-6<?php echo 'without-icon' == $porto_settings['post-title-style'] ? ' post-title-simple' : ''; ?>">
	<?php if ( $attachment && $attachment_related ) : ?>
	<a href="<?php the_permalink(); ?>"> <span class="post-image thumb-info<?php echo ( ! empty( $post_thumb_bg ) ? ' thumb-info-' . esc_attr( $post_thumb_bg ) : '' ), ( ! empty( $post_thumb_image ) ? ' thumb-info-' . esc_attr( $post_thumb_image ) : '' ), ( ! empty( $post_thumb_borders ) ? ' thumb-info-' . esc_attr( $post_thumb_borders ) : '' ); ?> m-b-md"> <span class="thumb-info-wrapper"> <img class="img-responsive" width="<?php echo esc_attr( $attachment_related['width'] ); ?>" height="<?php echo esc_attr( $attachment_related['height'] ); ?>" src="<?php echo esc_url( $attachment_related['src'] ); ?>" alt="<?php echo esc_attr( $attachment_related['alt'] ); ?>" />
		<?php if ( $porto_settings['post-zoom'] ) : ?>
	<span class="zoom" data-src="<?php echo esc_url( $attachment['src'] ); ?>" data-title="<?php echo esc_attr( $attachment['caption'] ); ?>"><i class="fas fa-search"></i></span>
	<?php endif; ?>
	</span> </span> </a>
	<?php endif; ?>
	<span class="meta-date"><i class="far fa-clock"></i> <?php echo get_the_date(); ?></span>
	<h3> <a class="text-decoration-none text-<?php echo 'dark' == $porto_settings['css-type'] ? 'light' : 'dark'; ?>" href="<?php the_permalink(); ?>">
	<?php the_title(); ?>
	</a> </h3>
	<a href="<?php the_permalink(); ?>" class="read-more"><span><?php esc_html_e( 'Read More', 'porto' ); ?></span> <i class="fa fa-play"></i></a>
</div>
<?php } elseif ( 'style-7' == $post_style ) { ?>
	<div class="post-item style-7<?php echo ( 'without-icon' == $porto_settings['post-title-style'] ) ? ' post-title-simple' : ''; ?>">
		<h4><a class="text-decoration-none text-<?php echo 'dark' == $porto_settings['css-type'] ? 'light' : 'dark'; ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
		<?php if ( in_array( 'date', $porto_settings['post-metas'] ) ) : ?>
			<span class="meta-date"><i class="far fa-clock"></i> <?php echo get_the_date(); ?></span>
		<?php endif; ?>
		<?php echo porto_get_excerpt( $excerpt_length, false ); ?>
		<div class="post-meta">
			<span class="meta-author"><?php echo get_avatar( get_the_author_meta( 'email' ), '40' ); ?> <?php esc_html_e( 'by', 'porto' ); ?> <?php the_author_posts_link(); ?></span>
		</div>
	</div>
<?php } else { ?>
<div class="post-item<?php echo 'without-icon' == $porto_settings['post-title-style'] ? ' post-title-simple' : ''; ?>">
	<?php if ( $attachment && $attachment_related ) : ?>
	<a href="<?php the_permalink(); ?>"> <span class="post-image thumb-info<?php echo ( ! empty( $post_thumb_bg ) ? ' thumb-info-' . esc_attr( $post_thumb_bg ) : '' ), ( ! empty( $post_thumb_image ) ? ' thumb-info-' . esc_attr( $post_thumb_image ) : '' ), ( ! empty( $post_thumb_borders ) ? ' thumb-info-' . esc_attr( $post_thumb_borders ) : '' ); ?> m-b-md"> <span class="thumb-info-wrapper"> <img class="img-responsive" width="<?php echo esc_attr( $attachment_related['width'] ); ?>" height="<?php echo esc_attr( $attachment_related['height'] ); ?>" src="<?php echo esc_url( $attachment_related['src'] ); ?>" alt="<?php echo esc_attr( $attachment_related['alt'] ); ?>" />
		<?php if ( $porto_settings['post-zoom'] ) : ?>
	<span class="zoom" data-src="<?php echo esc_url( $attachment['src'] ); ?>" data-title="<?php echo esc_attr( $attachment['caption'] ); ?>"><i class="fas fa-search"></i></span>
	<?php endif; ?>
	</span> </span> </a>
		<?php
	endif;
	if ( $show_date ) :
		?>
	<div class="post-date">
		<?php
			porto_post_date();
			// porto_post_format();
		?>
	</div>
		<?php
		endif;
	if ( $post_author ) :
		?>
	<h4 class="title-short"><a href="<?php the_permalink(); ?>">
		<?php the_title(); ?>
	</a></h4>
	<p class="author-name"><?php esc_html_e( 'By', 'porto' ); ?>
		<?php the_author_posts_link(); ?>
	</p>
	<?php else : ?>
	<h4><a href="<?php the_permalink(); ?>">
		<?php the_title(); ?>
	</a></h4>
	<?php endif; ?>
	<div><?php echo porto_get_excerpt( $excerpt_length ); ?></div> </div>
<?php } ?>

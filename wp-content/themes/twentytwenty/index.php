<head>

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link href="./wp-content/themes/twentytwenty/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />
	<link rel="stylesheet" href="<?php echo get_template_directory_uri() ?>/style-module2.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="<?php echo get_template_directory_uri() ?>/styleModule5.css" type="text/css" media="screen" />
</head>
<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */

get_header();
?>
<link href="./wp-content/themes/twentytwenty/module7.css" rel="stylesheet">
<link href="./wp-content/themes/twentytwenty/style.css" rel="stylesheet">
<link href="./wp-content/themes/twentytwenty/bootstrap.min.css" rel="stylesheet">
<main id="site-content" role="main">

	<?php

	$archive_title    = '';
	$archive_subtitle = '';

	if ( is_search() ) {
		global $wp_query;

		$archive_title = sprintf(
			'%1$s %2$s',
			'<span class="color-accent">' . __( 'Search:', 'twentytwenty' ) . '</span>',
			'&ldquo;' . get_search_query() . '&rdquo;'
		);

		if ( $wp_query->found_posts ) {
			$archive_subtitle = sprintf(
				/* translators: %s: Number of search results. */
				_n(
					'We found %s result for your search.',
					'We found %s results for your search.',
					$wp_query->found_posts,
					'twentytwenty'
				),
				number_format_i18n( $wp_query->found_posts )
			);
		} else {
			$archive_subtitle = __( 'We could not find any results for your search. You can give it another try through the search form below.', 'twentytwenty' );
		}
	} elseif ( is_archive() && ! have_posts() ) {
		$archive_title = __( 'Nothing Found', 'twentytwenty' );
	} elseif ( ! is_home() ) {
		$archive_title    = get_the_archive_title();
		$archive_subtitle = get_the_archive_description();
	}

	if ( $archive_title || $archive_subtitle ) {
		?>

    <header class="archive-header has-text-align-center header-footer-group">

        <div class="archive-header-inner section-inner medium">

            <!-- <?php if ( $archive_title ) { ?>
            <h1 class="archive-title"><?php echo wp_kses_post( $archive_title ); ?></h1>
            <?php } ?> -->


			<div class="archive-header-inner section-inner medium">

				<?php if ( $archive_title ) { ?>
					<h1 class="archive-title"><?php echo wp_kses_post( $archive_title ); ?></h1>
				<?php } ?>

				<?php if ( $archive_subtitle ) { ?>
					<div class="archive-subtitle section-inner thin max-percentage intro-text"><?php echo wp_kses_post( wpautop( $archive_subtitle ) ); ?></div>
				<?php } ?>
                        <!--end of col-->
                    </div>

        </div><!-- .archive-header-inner -->

    </header><!-- .archive-header -->

    <?php
	}

	if ( have_posts() ) {

		$i = 0;

		while ( have_posts() ) {
			// $i++;
			// if ( $i > 1 ) {
			// 	echo '<hr class="post-separator styled-separator is-style-wide section-inner" aria-hidden="true" />';
			// }
			the_post();
			$post = get_post();
			//lay thong tin tu post
			$post_title = $post->post_title;
			$post_date = get_the_date('d', $post->ID);
			$post_month = get_the_date('F', $post->ID);
			$post_content = substr($post->post_content,0,150);
			//get_template_part( 'template-parts/content', get_post_type() );

			//hien thi du lieu da lay
		?>
		<?php if ( get_post() && get_post()!= is_search() ) { ?>
		<div class="container">
			<div class="list_new_post">
				<div class='list_new_view_post'>
					<div class='row'>
						<div class='col-md detail-new_post'>
							<div class='row'>

								<div class='col-md-3 col-xs-3 time_post'>
									<span class='date_post'><?= $post_date ?></span><br>
									<span class='month_post'><?= $post_month ?></span><br>
								</div>
								<div class='col-md-9 col-xs-9 desc_post'>
									<h4>
										<a href='<?= esc_url( get_permalink() )?>'><?= $post_title ?></a>
									</h4>
									<?= $post_content ?>
									<a href='<?= esc_url( get_permalink() )?>'>[...]</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php } ?>
		<?php if ( is_search() ) { ?>
		<div class="container">
			<div class="list_new_search">
				<div class='list_new_view_search'>
					<div class='row'>
						<div class='col-md detail-new_search'>
							<div class='row'>
								<div class='col-md-3 col-xs-3 img_search'>
									<img src="<?php echo catch_that_image() ?>" alt="">
								</div>
								<div class='col-md-3 col-xs-3 time_search'>
									<span class='date_search'><?= $post_date ?></span><br>
									<span class='month_search'><?= $post_month ?></span><br>
								</div>
								<div class='col-md-6 col-xs-6 desc_search'>
									<h4>
										<a href='<?= esc_url( get_permalink() )?>'><?= $post_title ?></a>
									</h4>
									<?= $post_content ?>
									<a href='<?= esc_url( get_permalink() )?>'>[...]</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php } ?>
    <?php
		}	
	} elseif ( is_search() ) {
		?>

    <div class="no-search-results-form section-inner thin">

        <?php
			get_search_form(
				array(
					'aria_label' => __( 'search again', 'twentytwenty' ),
				)
			);
			?> -->
		<!-- Change button search -->
		<div class="row justify-content-center form-search">
    		<div class="col-12 col-md-10 col-lg-8">
        		<form class="card card-sm search-center">
            		<div class="card-body row no-gutters align-items-center item-center">
                		<div class="col-auto">
                    		<i class="fas fa-search icon-search"></i>
                		</div>
                
						<div class="col">
							<input class="form-control form-control-lg form-control-borderless search-input search-field" id="<?php echo esc_attr( $twentytwenty_unique_id ); ?>" type="search" placeholder="Search topics or keywords">
						</div>
                
						<div class="col-auto">
							<button class="btn btn-lg btn-success btn-submit search-submit" type="submit" value="<?php echo esc_attr_x( 'Search', 'submit button', 'twentytwenty' ); ?>">
								Search
							</button>
						</div>
            		</div>
        		</form>
    		</div>
    
		</div>

    </div><!-- .no-search-results -->

    <?php
	}
	?>

    <?php get_template_part( 'template-parts/pagination' ); ?>

</main><!-- #site-content -->

<?php get_template_part( 'template-parts/footer-menus-widgets' ); ?>

<?php
get_footer();
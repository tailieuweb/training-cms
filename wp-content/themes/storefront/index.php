<?php

/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package storefront
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<div class="row">
				<div class="col-md-4 footbest">
					<h4 class="linkfoot best">MÓN ĂN NỔI BẬT</h4>
					<div class="content-foot">
						<a href="#"><img src="https://statics.vinpearl.com/dac-san-viet-nam-01_1635331121.jpg" alt="Am-thuc-Viet"></a>
						<p>Nhắc đến Ẩm thực Việt rất nhiều Đầu bếp nổi tiếng phải trầm trồ vì sự đa dạng, phong phú, nhiều màu sắc. Món ăn Việt Nam với...</p>
					</div>
				</div>
				<div class="col-md-4 footnew">
					<h4 class="linkfoot new">MÓN ĂN MỚI NHẤT</h4>
					<div class="content-foot">
						<a href="#"><img src="https://cdn.vntrip.vn/cam-nang/wp-content/uploads/2020/03/banh-mi-viet-nam.jpg" alt="Banh-mi-Viet-Nam"></a>
						<p>Bánh mì Việt Nam hiện lên đầy màu sắc và hương vị trên từng câu chữ, đúng tinh thần một "món ăn vặt hảo hạng, ăn hoài không chán"...</p>
					</div>
				</div>
				<div class="col-md-4 footall">
					<h4 class="linkfoot all">TẤT CẢ MÓN ĂN</h4>
					<div class="content-foot">
						<a href="#"><img src="https://cdn.daotaobeptruong.vn/wp-content/uploads/2021/03/am-thuc-viet-nam.jpg" alt="mon-an-truyen-thong"></a>
						<p>Quán ăn "NHÓM F" có hầu hết tất cả các món ăn ở Việt Nam, đặc biệt là các món truyền thống lâu đời, gắn liền với ...</p>
					</div>
				</div>
			</div>
		<?php
		if ( have_posts() ) :

			get_template_part( 'loop' );

		else :

			get_template_part( 'content', 'none' );

		endif;
		?>
		</main><!-- #main -->
	</div><!-- #primary -->
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
		<?php
		if ( have_posts() ) :

			get_template_part( 'loop' );

		else :

			get_template_part( 'content', 'none' );

		endif;
		?>
		

		</main><!-- #main -->
	</div><!-- #primary -->
<?php
do_action('storefront_sidebar');
get_footer();

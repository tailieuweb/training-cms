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

$post = get_post();

?>

<!-- Bootstrap CSS -->
<div class="col-md-8">
	<div class="row">
		<div class="col-md-7 top_news_block_desc">
			<div class="row">
				<div class="col-md-3 col-xs-3 topnewstime">
					<span class="topnewsdate"><?php echo date('d', strtotime($post->post_date)) ?></span><br>
					<span class="topnewsmonth">Tháng <?php echo date('m', strtotime($post->post_date)) ?></span><br>
				</div>
				<div class="col-md-9 col-xs-9 shortdesc">
					<?php the_title('<h4><a href="' . esc_url(get_permalink()) . '">', '</a></h4>');
					?>
					<p><?php
						echo substr($post->post_content, 0, 100);
						?></p>
				</div>
			</div>
		</div>
	</div>
</div>
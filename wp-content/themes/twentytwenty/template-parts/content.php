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

<!-- Bootstrap CSS -->
<div class="col-md-8">
	<div class="row">
		<div class="col-md-7 top_news_block_desc">
			<div class="row">
				<div class="col-md-3 col-xs-3 topnewstime">
					<span class="topnewsdate">08</span><br>
					<span class="topnewsmonth">Tháng 10</span><br>
				</div>
				<div class="col-md-9 col-xs-9 shortdesc">
					<?php the_title('<h4><a href="' . esc_url(get_permalink()) . '">', '</a></h4>');
					?>
					<p><?php
						if (is_single()) {
							the_content(__('Continue reading', 'twentytwenty'));
						} else {
							$post = get_post();
							echo substr($post->post_content, 0, 100);
						}
						?></p>
				</div>
			</div>
		</div>
	</div>
</div>
<?php

/**
 * Template used to display post content.
 *
 * @package storefront
 */
$class = 'list_post';
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php
	/**
	 * Functions hooked in to storefront_loop_post action.
	 *
	 * @hooked storefront_post_header          - 10
	 * @hooked storefront_post_content         - 30
	 * @hooked storefront_post_taxonomy        - 40
	 */
	?>
	<div <?php post_class($class); ?>>
		<?php
		do_action('storefront_loop_post');
		?>
	</div>
	<?php
	?>

</article><!-- #post-## -->
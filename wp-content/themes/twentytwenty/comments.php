<?php

/**
 * The template file for displaying the comments and comment form for the
 * Twenty Twenty theme.
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
*/
if (post_password_required()) {
	return;
}

if ($comments) {
?>

	<div class="comments" id="comments">

		<?php
		$comments_number = absint(get_comments_number());
		?>

		<div class="comments-header section-inner small max-percentage">

			<h2 class="comment-reply-title">
				<?php
				if (!have_comments()) {
					_e('Leave a comment', 'twentytwenty');
				} elseif (1 === $comments_number) {
					/* translators: %s: Post title. */
					printf(_x('One reply on &ldquo;%s&rdquo;', 'comments title', 'twentytwenty'), get_the_title());
				} else {
					printf(
						/* translators: 1: Number of comments, 2: Post title. */
						_nx(
							'%1$s reply on &ldquo;%2$s&rdquo;',
							'%1$s replies on &ldquo;%2$s&rdquo;',
							$comments_number,
							'comments title',
							'twentytwenty'
						),
						number_format_i18n($comments_number),
						get_the_title()
					);
				}

				?>
			</h2><!-- .comments-title -->

		</div><!-- .comments-header -->

		<div class="comments-inner section-inner thin max-percentage">

			<?php
			wp_list_comments(
				array(
					'walker'      => new TwentyTwenty_Walker_Comment(),
					'avatar_size' => 120,
					'style'       => 'div',
				)
			);

			$comment_pagination = paginate_comments_links(
				array(
					'echo'      => false,
					'end_size'  => 0,
					'mid_size'  => 0,
					'next_text' => __('Newer Comments', 'twentytwenty') . ' <span aria-hidden="true">&rarr;</span>',
					'prev_text' => '<span aria-hidden="true">&larr;</span> ' . __('Older Comments', 'twentytwenty'),
				)
			);

			if ($comment_pagination) {
				$pagination_classes = '';

				// If we're only showing the "Next" link, add a class indicating so.
				if (false === strpos($comment_pagination, 'prev page-numbers')) {
					$pagination_classes = ' only-next';
				}
			?>

				<nav class="comments-pagination pagination<?php echo $pagination_classes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static output 
															?>" aria-label="<?php esc_attr_e('Comments', 'twentytwenty'); ?>">
					<?php echo wp_kses_post($comment_pagination); ?>
				</nav>

			<?php
			}
			?>

		</div><!-- .comments-inner -->

	</div><!-- comments -->

	<?php
}

if (comments_open() || pings_open()) {

	if ($comments) {
		echo '<hr class="styled-separator is-style-wide" aria-hidden="true" />';
	}
	if (is_user_logged_in()) {
	?>
		<div class="row">
			<div class="col-md-3"></div>
			<div class="col-md-6">
				<!--- Post Form Begins -->
				<section class="card module-8-section-form-search">
					<div class="card-header">
						<ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
							<li class="nav-item">
								<a class="nav-link active" id="posts-tab" data-toggle="tab" href="<?= get_home_url() . '/wp-admin/post-new.php' ?>" role="tab" aria-controls="posts" aria-selected="true">Make
									a Post</a>
							</li>
						</ul>
					</div>

					<form action="<?= get_home_url() . '/wp-comments-post.php' ?>" method="post" id="commentform" novalidate="" class="module-8-form-search">
						<div class="card-body">
							<div class="tab-content" id="myTabContent">
								<div class="tab-pane fade show active" id="posts" role="tabpanel" aria-labelledby="posts-tab">
									<div class="form-group">
										<label class="sr-only" for="message">post</label>
										<textarea class="form-control" id="comment" name="comment" placeholder="What are you thinking..." required></textarea>
									</div>

								</div>
							</div>
							<div class="module-8-hidden-input">
								<input type="hidden" name="comment_post_ID" value="<?php
																					$post = get_post();
																					if ($post) {
																						echo $post->ID;
																					}
																					?>" id="comment_post_ID">
								<input type="hidden" name="comment_parent" id="comment_parent" value="<?php
																										if (isset($_GET['replytocom'])) {
																											echo $_GET['replytocom'];
																										} else {
																											echo 0;
																										}
																										?>">
								<input type="hidden" id="_wp_unfiltered_html_comment_disabled" name="_wp_unfiltered_html_comment" value="24d5adde41">
							</div>
							<div class="text-right">
								<button type="submit" class="btn btn-primary" value="Post Comment">share</button>
							</div>
						</div>
						<script>
							(function() {
								if (window === window.parent) {
									document.getElementById('_wp_unfiltered_html_comment_disabled').name = '_wp_unfiltered_html_comment';
								}
							})();
						</script>
					</form>
				</section>
				<!--- Post Form Ends -->
			</div>
			<div class="col-md-3"></div>
		</div>

	<?php
	} else {
		comment_form(
			array(
				'class_form'         => 'section-inner thin max-percentage',
				'title_reply_before' => '<h2 id="reply-title" class="comment-reply-title">',
				'title_reply_after'  => '</h2>',
			)
		);
	}
} elseif (is_single()) {

	if ($comments) {
		echo '<hr class="styled-separator is-style-wide" aria-hidden="true" />';
	}

	?>

	<div class="comment-respond" id="respond">

		<p class="comments-closed"><?php _e('Comments are closed.', 'twentytwenty'); ?></p>

	</div><!-- #respond -->

<?php
}

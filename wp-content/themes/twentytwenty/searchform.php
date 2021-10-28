<?php

/**
 * The searchform.php template.
 *
 * Used any time that get_search_form() is called.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */

/*
 * Generate a unique ID for each form and a string containing an aria-label
 * if one was passed to get_search_form() in the args array.
 */
$twentytwenty_unique_id = twentytwenty_unique_id('search-form-');

$twentytwenty_aria_label = !empty($args['aria_label']) ? 'aria-label="' . esc_attr($args['aria_label']) . '"' : '';
// Backward compatibility, in case a child theme template uses a `label` argument.
if (empty($twentytwenty_aria_label) && !empty($args['label'])) {
	$twentytwenty_aria_label = 'aria-label="' . esc_attr($args['label']) . '"';
}
?>
<!-- search -->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<link rel="stylesheet" href="./style.css">
<link rel="stylesheet" href="./styleSearch.css">
<div class="container-search">
	<div class="row justify-content-center row-seach">
		<div class="col-12 col-md-10 col-lg-8">
			<form role="search" <?php echo $twentytwenty_aria_label; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped above. 
								?> method="get" class="search-form card card-sm" action="<?php echo esc_url(home_url('/')); ?>">
				<div class="card-body row no-gutters align-items-center" for="<?php echo esc_attr($twentytwenty_unique_id); ?>">
					<div class="col-auto">
						<i class="fa fa-search fa-4x" aria-hidden="true"></i>
					</div>
					<div class="col">
						<input type="search" id="<?php echo esc_attr($twentytwenty_unique_id); ?>" class="search-field form-control form-control-lg form-control-borderless" placeholder="<?php echo esc_attr_x('Search topics or keywords &hellip;', 'placeholder', 'twentytwenty'); ?>" value="<?php echo get_search_query(); ?>" name="s" />
					</div>
					<div class="col-auto">
						<button type="submit" class="search-submit btn btn-lg btn-success" value="<?php echo esc_attr_x('Search', 'submit button', 'twentytwenty'); ?>">Search</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!-- 
		<form role="search" <?php echo $twentytwenty_aria_label; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped above. 
							?> method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
	<label for="<?php echo esc_attr($twentytwenty_unique_id); ?>">
		<span class="screen-reader-text"><?php _e('Search for:', 'twentytwenty'); // phpcs:ignore: WordPress.Security.EscapeOutput.UnsafePrintingFunction -- core trusts translations 
											?></span>
		<input type="search" id="<?php echo esc_attr($twentytwenty_unique_id); ?>" class="search-field" placeholder="<?php echo esc_attr_x('Search &hellip;', 'placeholder', 'twentytwenty'); ?>" value="<?php echo get_search_query(); ?>" name="s" />
	</label>
	<input type="submit" class="search-submit HIHI" value="<?php echo esc_attr_x('Search', 'submit button', 'twentytwenty'); ?>" />
</form> -->
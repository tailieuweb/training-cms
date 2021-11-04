<style>
	.form-control-borderless {
		border: none !important;
	}

	.form-control-borderless:hover,
	.form-control-borderless:active,
	.form-control-borderless:focus {
		border: none !important;
		outline: none;
		box-shadow: none;
	}

	.justify-content-center {
		background-color: white;
	}

	.submitcl {
		background-color: #007b5e !important;
		border-radius: 7px !important;
	}
</style>

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">

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
<div class="row justify-content-center">
	<div class="col-12 col-md-12">
		<form role="search" <?php echo $twentytwenty_aria_label; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped above. 
							?> method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
			<div class="card-body row no-gutters align-items-center">
				<div class="col-auto">
					<i class="fas fa-search h4 text-body"></i>
				</div>
				<!--end of col-->
				<div class="col">
					<label for="<?php echo esc_attr($twentytwenty_unique_id); ?>">
						<span class="screen-reader-text"><?php _e('Search for:', 'twentytwenty'); // phpcs:ignore: WordPress.Security.EscapeOutput.UnsafePrintingFunction -- core trusts translations 
															?></span>
						<input class="form-control form-control-lg form-control-borderless" type="search" id="<?php echo esc_attr($twentytwenty_unique_id); ?>" class="search-field" placeholder="<?php echo esc_attr_x('Search &hellip;', 'placeholder', 'twentytwenty'); ?>" value="<?php echo get_search_query(); ?>" name="s" />
					</label>
				</div>
				<!--end of col-->
				<div class="col-auto">
					<input type="submit" class="search-submit submitcl" value="<?php echo esc_attr_x('Search', 'submit button', 'twentytwenty'); ?>" />
				</div>
				<!--end of col-->
			</div>
		</form>
	</div>
	<!--end of col-->
</div>
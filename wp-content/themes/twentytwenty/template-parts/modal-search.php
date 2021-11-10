<?php

/**
 * Displays the search icon and modal
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */

?>
<div class="search-modal cover-modal header-footer-group" data-modal-target-string=".search-modal">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-12 col-md-10 col-lg-8 py-5">
				<form class="card card-sm" method="get" role="search" action="<?php echo esc_url( home_url( '/' ) ); ?> ">
					<div class="card-body row no-gutters align-items-center">
						<div class="col-auto">
							<i class="fa fa-search text-body"></i>
						</div>
						<!--end of col-->
						<div class="col">
							<input class=" form-control form-control-lg form-control-borderless" value="<?php echo get_search_query(); ?>" name="s" type="search" placeholder="Search topics or keywords">
						</div>
						<!--end of col-->
						<div class="col-auto">
							<button class="btn btn-lg btn-success" type="submit" value="<?php echo esc_attr_x('Search', 'submit button', 'twentytwenty'); ?>">Search</button>
							<input type="submit" class="search-submit" value="<?php echo esc_attr_x( 'Search', 'submit button', 'twentytwenty' ); ?>" />
						</div>
						<!--end of col-->
					</div>
				</form>
			</div>
			<!--end of col-->
		</div>
	</div>
</div>
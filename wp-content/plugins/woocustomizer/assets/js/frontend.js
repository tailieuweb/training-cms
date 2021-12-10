/**
 * StoreCustomizer frontend js.
 *
 *  @package StoreCustomizer/JS
 */
( function( $ ) {
	jQuery( document ).ready( function () {

		jQuery( '.wcz-adminstats-btn' ).on( 'click', function (e) {
			e.preventDefault();
			var wcz_adminstat_id = jQuery( this ).data( 'productid' );
			var wcz_as_block = jQuery( '#wcz-adminstats' );

			wcz_as_block.removeClass( 'wcz-hide' );
			wcz_as_block.addClass( 'wcz-modal-loading' );

			jQuery.ajax({
				type: 'POST',
				url: wcz_admin_stats.ajax_url,
				dataType: 'html',
				data: {
					'action': 'wcz_admin_get_product_stats',
					'product_id': wcz_adminstat_id,
				},
				success: function ( result ) {

					wcz_as_block.removeClass( 'wcz-modal-loading' );
					wcz_as_block.find( '.wcz-adminstats-modal-inner' ).html( result );
		
				},
				error: function () {
					// console.log( "No Posts retrieved" );
				}
			}); // End of ajax function

		});

		jQuery( '.wcz-adminstats-close' ).on( 'click', function (e) {
			e.preventDefault();
			jQuery( this ).parent().addClass( 'wcz-hide' );
			jQuery( '.wcz-adminstats-modal-inner' ).html( '' );
		});

	});
} )( jQuery );

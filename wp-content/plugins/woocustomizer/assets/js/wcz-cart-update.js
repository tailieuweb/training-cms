/**
 * StoreCustomizer frontend js.
 *
 *  @package StoreCustomizer/JS
 */
var timeout;

jQuery( document ).ready( function () {

	jQuery( '.woocommerce' ).on( 'change', 'input.qty', function(){

		if ( timeout !== undefined ) {
			clearTimeout( timeout );
		}

		timeout = setTimeout(function() {
			jQuery( "[name='update_cart']" ).trigger( "click" );
		}, 450 );

	});

});

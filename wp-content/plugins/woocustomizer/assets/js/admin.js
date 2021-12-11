/**
 * Plugin Template admin js.
 *
 *  @package StoreCustomizer/JS
 */
( function( $ ) {
	jQuery( document ).ready( function ( e ) {
        jQuery( 'ul#adminmenu li#toplevel_page_woocommerce ul.wp-submenu li a span.fs-submenu-item.woocustomizer' ).parent().css( 'display', 'none' );

        jQuery( '.wcz-notice-rating-click' ).on( 'click', function (e) {
            jQuery( this ).hide();
            jQuery( '.wcz-notice-rating-options' ).fadeIn();
        });

        // notif : For a notification if another notice is 'on'
        if ( jQuery( 'body' ).hasClass( 'wcz-free' ) && jQuery( 'body' ).hasClass( 'wcz-notif' ) ) {
            jQuery( '.wcznotif' ).text( '1' ).addClass( 'hasnotif' );
        };
    });
} )( jQuery );

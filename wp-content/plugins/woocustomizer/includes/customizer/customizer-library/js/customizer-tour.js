/**
 * WCD Customizer Tour JS
 */
( function( $ ) {
    $( document ).ready( function () {

        var container = $( 'body.wp-customizer .wp-full-overlay' );
        var current_step = 0;

        $( '#sub-accordion-panel-wcz-panel-settings' ).append( `<div class="wcz-tour-wrap"><a href="${wcz_tour.texts.premium_link}" target="_blank">${wcz_tour.texts.premium_set}</a><div class="wcz-tour-btn">${wcz_tour.texts.show}</div><a href="https://storecustomizer.com/#anchor-contact" target="_blank">${wcz_tour.texts.contact}</a></div>` );
        container.prepend( `<div class="wcz-tour-block"><div class="wcz-tour-block-inner"><h3>${wcz_tour.steps[current_step].title}</h3>${linebreakstoparagraphs( wcz_tour.steps[current_step].message )}</div><div class="wcz-tour-nav wcz-tour-start"><div class="wcz-tour-prev"><a>${wcz_tour.texts.prev}</a></div><div class="wcz-tour-next"><a>${wcz_tour.texts.next}</a></div></div></div>` );

        $( '.wcz-tour-btn').click(function() {
            if ( container.hasClass( 'wcz-show-tour' ) ) {
                container.toggleClass( 'wcz-show-tour' );
                $( '.wcz-tour-btn' ).removeClass( 'wcz-tour-on' );
                $( '.wcz-tour-btn' ).html( wcz_tour.texts.show );
            } else {
                container.toggleClass( 'wcz-show-tour' );
                $( '.wcz-tour-btn' ).addClass( 'wcz-tour-on' );
                $( '.wcz-tour-btn' ).html( wcz_tour.texts.hide_tour );
            }
        });

        $( '.wcz-tour-prev a').click(function() {
            current_step = getprevstep( current_step );
            $( '.wcz-tour-block' ).css( 'top', wcz_tour.steps[current_step].top + 'px' );
            $( '.wcz-tour-block-inner' ).html( `<h3>${wcz_tour.steps[current_step].title}</h3>${linebreakstoparagraphs( wcz_tour.steps[current_step].message )}` );
            if ( current_step == 0 ) {
                $( '.wcz-tour-nav' ).addClass( 'wcz-tour-start' );
            } else {
                $( '.wcz-tour-nav' ).removeClass( 'wcz-tour-start' );
                $( '.wcz-tour-nav' ).removeClass( 'wcz-tour-end' );
            }
        });

        $( '.wcz-tour-next a').click(function() {
            current_step = getnextstep( current_step );
            $( '.wcz-tour-block' ).css( 'top', wcz_tour.steps[current_step].top + 'px' );
            $( '.wcz-tour-block-inner' ).html( `<h3>${wcz_tour.steps[current_step].title}</h3>${linebreakstoparagraphs( wcz_tour.steps[current_step].message )}` );
            if ( current_step == ( wcz_tour.steps.length - 1 ) ) {
                $( '.wcz-tour-nav' ).addClass( 'wcz-tour-end' );
            } else {
                $( '.wcz-tour-nav' ).removeClass( 'wcz-tour-start' );
                $( '.wcz-tour-nav' ).removeClass( 'wcz-tour-end' );
            }
        });

        $( '#sub-accordion-panel-wcz-panel-settings .customize-panel-back, #sub-accordion-panel-wcz-panel-settings li.accordion-section' ).click( function(){
            if ( container.hasClass( 'wcz-show-tour' ) ) {
                container.toggleClass( 'wcz-show-tour' );
                $( '.wcz-tour-btn' ).removeClass( 'wcz-tour-on' );
                $( '.wcz-tour-btn' ).html( wcz_tour.texts.show );
                // $( '.wcz-tour-btn' ).click();
            }
        });

    });

    function getnextstep( current_step ) {
        current_step = current_step + 1
        return current_step;
    }
    function getprevstep( current_step ) {
        current_step = current_step - 1
        return current_step;
    }

    function linebreakstoparagraphs( message ) {
        return '<p>' + message.replace( / - /g, '</p><p>' ) + '</p>';
    }
} )( jQuery );

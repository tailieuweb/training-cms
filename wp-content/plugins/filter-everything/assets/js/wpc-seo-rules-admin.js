/*!
 * Filter Everything seo rules admin 1.4.5
 */
(function($) {
    "use strict";
    let seoRulesFormValid = false;

    function validateSeoRulesForm( $el )
    {
        let $spinner = $('#publishing-action .spinner');
        let requestParams          = {};

        $spinner.addClass( 'is-active' );
        /**
         * @todo checkboxes does not validates correctly because they send the same value !!! IMPORTANT
         * independently from checked status
         */

        requestParams.validateData = wpcSerialize( $el );

        wp.ajax.post( 'wpc-validate-seo-rules', requestParams )
            .always( function() {
                $spinner.removeClass( 'is-active' );
            })
            .done( function( response ) {
                seoRulesFormValid = true;
                $el.submit();
            })
            .fail( function( response ) {

                let notices = [];

                if( typeof response.errors !== 'undefined' ){
                    $.each( response.errors, function ( index, error ){
                        notices.push( error.message );
                    });

                    if( notices.length < 1 ){
                        notices.push( 'Error: Set was not saved.' );
                    }

                    addNotice( notices );
                    makeNoticesDismissible();
                }
            });

        return false;
    }

    function addNotice( messages )
    {
        let target = $('form#post');
        let text   = '';
        $.each( messages, function ( index, message ) {
            text += '<p>' + message + '</p>';
        });

        let html = '<div id="message" class="wpc-error notice notice-error is-dismissible">'
            + text +
            '<button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button>' +
            '</div>';
        if( typeof target !== 'undefined' ){
            if( $("#message").length > 0 ){
                $("#message").remove();
            }
            target.before( html );
        }
    }

    function removeElement($el)
    {
        $el.fadeTo(100, 0, function() {
            $el.slideUp(100, function() {
                $el.remove();
            });
        });
    }

    function addFieldError( fieldId, message )
    {
        let target = $('#'+fieldId);
        let html = '<div class="wpc-field-notice wpc-field-notice-error"><p>'+message+'</p></div>';
        if( typeof target !== 'undefined' ){
            target.before( html );
        }
    }

    $.fn.getCursorPosition = function() {
        var input = this.get(0);
        if (!input) return; // No (input) element found
        if ('selectionStart' in input) {
            // Standard-compliant browsers
            return input.selectionStart;
        } else if (document.selection) {
            // IE
            input.focus();
            var sel = document.selection.createRange();
            var selLen = document.selection.createRange().text.length;
            sel.moveStart('character', -input.value.length);
            return sel.text.length - selLen;
        }
    }

    $.fn.createSeoVarsList = function( seoVars )
    {
        let html = '<ul class="wpc-seo-vars-list">';

        if( Object.keys(seoVars).length > 0 ){
            $.each( seoVars, function ( slug, label ){
                html += '<li data-seovar="{'+slug+'}">'+label+'</li>';
            });
        }else{
            html += '<li>'+wpcSeoVars.noSeoVarsMsg+'</li>';
        }

        html += '</ul>';
        $(this).replaceWith(html);
        return true;
    }

    $(document).mouseup(function(e)
    {
        let $wpcContainer = $('.wpc-vars-container');
        if( $wpcContainer.length > 0 ){
            // var container = $('.wpc-vars-container');
            // if the target of the click isn't the container nor a descendant of the container
            if (! $wpcContainer.is(e.target) && $wpcContainer.has(e.target).length === 0)
            {
                $wpcContainer.hide();
            }
        }
    });

    $(document).ready(function (){

        $('form#post').on('submit', function(e){

            // Clear all errors
            removeElement( $('.wpc-field-notice') );

            // Clear Notice
            removeElement( $('#message') );

            if( ! seoRulesFormValid ){
                e.preventDefault();
                // Validate form. We will submit it from validation method
                validateSeoRulesForm($(this));
            }
        });

        $('.wpc-seo-vars-list').createSeoVarsList( wpcSeoVars.seovars );

        $('body').on('click', '.wpc-open-container', function (e){
            e.preventDefault();
            let link = $(this);
            let fieldId = link.data('field');
            let wpcContainer = $('#wpc-vars-container-'+fieldId );
            $('#wpc_seo_rules-'+fieldId).focus();
            wpcContainer.toggle();
        });

        $('body').on('focus keypress blur', '.wpc-vars-insertable', function (e){
            let wpcPosition = $(this).getCursorPosition();
            $(this).data('caret', wpcPosition);
        });

        $('body').on('click', '.wpc-seo-vars-list li', function (){
            let seoVar = $(this).data('seovar');

            let wpcContainer = $(this).parents('.wpc-vars-container');

            if( typeof seoVar !== 'undefined' ){
                let inputField = $('#wpc_seo_rules-'+wpcContainer.data('container'));
                let caretPos   = inputField.data('caret');

                if( caretPos === '' ){
                    caretPos = inputField.val().length;
                }

                if( caretPos === 0 ){
                    seoVar = seoVar+' ';
                }else if( caretPos === inputField.val().length ){
                    seoVar = ' '+seoVar;
                }else{
                    seoVar = ' '+seoVar+' ';
                }

                insertAtCaret( inputField, seoVar, caretPos );
            }

            wpcContainer.hide();
        });

        $('body').on('change', '#wpc_seo_rules-rule_post_type', function (){
            removeElement( $('.wpc-field-notice') );
            let selected = $(this).val();
            let $spinner = $( '.wpc-intersection-fields-wrapper' ).children( '.spinner' );
            $spinner.addClass( 'is-active' );
            let requestParams          = {};
            requestParams._wpnonce = $("#wpc_seo_rule_nonce").val();
            requestParams.postType = selected;
            requestParams.postId   = $("#post_ID").val();

            wp.ajax.post( 'wpc-get-indexed-filters', requestParams )
                .always( function() {
                    $spinner.removeClass( 'is-active' );
                })
                .done( function( response ) {

                    $( '#wpc-intersections-table' ).replaceWith( response.html );
                    $('.wpc-seo-vars-list').createSeoVarsList( response.seovars );
                })

                .fail( function(response) {
                    if( typeof response !== 'undefined'){
                        addFieldError( 'wpc-intersection-fields-container', response.message );
                    }
                });
        });

        makeNoticesDismissible();

    });

    function makeNoticesDismissible() {
        $( '.wpc-error.is-dismissible' ).each( function() {
            var $el = $( this ),
                $button = $el.find('.notice-dismiss');
            // Ensure plain text.
            $button.on( 'click', function( event ) {
                event.preventDefault();
                $el.fadeTo( 100, 0, function() {
                    $el.slideUp( 100, function() {
                        $el.remove();
                    });
                });
            });

            $el.append( $button );
        });
    }

    function wpcSerialize( $el ){

        var obj = {};
        var inputs = $el.find('select, textarea, input').serializeArray();

        for( var i = 0; i < inputs.length; i++ ) {
            wpcBuildObject( obj, inputs[i].name, inputs[i].value );
        }
        return obj;
    };

    function wpcBuildObject( obj, name, value ){
        name = name.replace('[]', '[%%index%%]');

        var keys = name.match(/([^\[\]])+/g);
        if( !keys ) return;
        var length = keys.length;
        var ref = obj;

        for( var i = 0; i < length; i++ ) {
            var key = String( keys[i] );
            if( i == length - 1 ) {
                if( key === '%%index%%' ) {
                    ref.push( value );
                } else {
                    ref[ key ] = value;
                }
            } else {
                if( keys[i+1] === '%%index%%' ) {
                    if( !wpcIsArray(ref[ key ]) ) {
                        ref[ key ] = [];
                    }
                } else {
                    if( !wpcIsObject(ref[ key ]) ) {
                        ref[ key ] = {};
                    }
                }
                ref = ref[ key ];
            }
        }
    };

    function wpcIsArray( a ){
        return Array.isArray(a);
    };

    function wpcIsObject( a ){
        return ( typeof a === 'object' );
    }

})(jQuery);

function insertAtCaret( target, text, caretPos )
{
    let textAreaTxt = target.val();
    let result = textAreaTxt.substring(0, caretPos) + text + textAreaTxt.substring(caretPos);
    result = result.replace(/ +(?= )/g,'');
    target.val(result);

    return true;
}
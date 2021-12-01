/*!
 * Filter Everything set admin 1.4.5
 */
(function($) {
    "use strict";
    let filtersFormValid = false;

    function validateFiltersForm( $el )
    {
        let $spinner = $('#publishing-action .spinner');
        let requestParams          = {};

        $spinner.addClass( 'is-active' );
        /**
         * @todo checkboxes does not validates correctly because they send the same value !!! IMPORTANT
         * independently from checked status
         */

        requestParams.validateData = wpcSerialize( $el );

        wp.ajax.post( 'wpc-validate-filters', requestParams )
            .always( function() {
                $spinner.removeClass( 'is-active' );
            })
            .done( function( response ) {
                filtersFormValid = true;
                $el.submit();
            })
            .fail( function( response ) {

                let notices = [];
                let filterContainer = '';

                if( typeof response.errors !== 'undefined' ){
                    $.each( response.errors, function ( index, error ){

                        if( typeof error.id !== 'undefined'){
                            addFieldError( error.id, error.message );

                            // Open filter container to show error
                            filterContainer = $('#'+error.id).parents('.wpc-filter-item');
                            openFilter(filterContainer);

                            // Open additional fields if errors are there
                            if( $('#'+error.id).parents('.wpc-filter-additional-fields').length > 0 ){
                                openAdditional(filterContainer);
                            }
                        }else{
                            notices.push( error.message );
                        }

                    });

                    if( notices.length < 1 ){
                        notices.push( 'Error: Set was not saved.' );
                    }

                    addNotice( notices );
                }
            });

        return false;
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

    function addNotice( messages )
    {
        let target = $('form#post');
        let text   = '';
        $.each( messages, function ( index, message ) {
            text += '<p>' + message + '</p>';
        });

        let html = '<div id="message" class="error notice notice-error is-dismissible">'
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

    function openFilter($el)
    {
        let head = $el.find('.wpc-filter-head'),
            body = head.next('.wpc-filter-body');
        head.addClass('wpc-opened');
        body.slideDown({
            duration: 200,
            complete: function (){
                body.addClass('wpc-opened');
            }
        });
    }

    function closeFilter($el)
    {
        let head = $el.find('.wpc-filter-head'),
            body = head.next('.wpc-filter-body');

        head.removeClass('wpc-opened');
        body.slideUp({
            duration: 200,
            complete: function (){
                body.removeClass('wpc-opened');
            }
        });
    }

    function closeAdditional($el)
    {
        $el.find('.wpc-filter-additional-fields').slideUp({
            duration: 200,
            complete: function (){
                $(this).removeClass('wpc-opened');
            }
        });
    }

    function openAdditional($el)
    {
        $el.find('.wpc-filter-additional-fields').slideDown({
            duration: 200,
            complete: function (){
                $(this).addClass('wpc-opened');
            }
        });
    }

    function getForbiddenTaxes()
    {
        if( typeof wpcSetVars.postTypesTaxList !== 'undefined'){
            let postType = $('#wpc_set_fields-post_type').val();
            let allowedTaxes   = [];
            let forbiddenTaxes = [];

            if( typeof wpcSetVars.postTypesTaxList[postType] !== 'undefined' ){
                $.each( wpcSetVars.postTypesTaxList[postType], function ( iNdex, taxProps ){
                    allowedTaxes.push(taxProps['name']);
                });
            }

            $.each( wpcSetVars.postTypesTaxList, function ( pType, taxesArray ){
                if( pType !== postType ){
                    $.each( taxesArray, function ( index, theTax ){
                        if( allowedTaxes.includes(theTax['name']) === false ){
                            forbiddenTaxes.push(theTax['name']);
                        }
                    } )
                }
            });

            return forbiddenTaxes;
        }

        return [];
    }

    function getUsedEntities( $inputs, excludeInput )
    {
        let usedEntities = [];
        let currentVal   = '';
        let doNotInclude = ['post_meta', 'post_meta_num', 'post_meta_exists'];

        if( $inputs.length > 0 ){
            $inputs.each(function(){
                currentVal = $(this).val();

                if( $(this).attr('id') == excludeInput.attr('id') ){
                    return;
                }

                if( doNotInclude.includes( currentVal ) ){
                    return;
                }
                usedEntities.push( $(this).val() );
            });

            return usedEntities;
        }
        return false;
    }

    function setAvailableEntities( $el, noChange )
    {
        let currentVal = '';
        let exclude = getUsedEntities( $('.wpc-field-entity'), $el );
        let forbiddenTaxes = getForbiddenTaxes();

        $el.find('option').each( function (){
            currentVal = $(this).val();

            if( currentVal === 'post_meta_exists' && ( wpcSetVars.filtersPro < 1) ){
                return;
            }

            if( exclude.includes( currentVal ) || forbiddenTaxes.includes(currentVal) ){
                $(this).attr( 'disabled', 'disabled' );
            }else{
                $(this).removeAttr( 'disabled' );
            }
        } );

        // If currently selected option is disabled, make first available option selected.
        let disabled = $el.find('option:selected').attr('disabled');
        if( disabled === 'disabled' && ! noChange ){
            $el.find('option:not([disabled]):first').prop('selected', true)
                .trigger('change');
        }

        return true;
    }

    function passNewEntities(select)
    {
        let time = 0;

        $('.wpc-new-filter-item .wpc-field-entity').each(function (){
            let select = $(this);
            let noChange = false;

            if( $(this).attr('id') == select.attr('id') ){
                noChange = true;
            }

            setTimeout( function(){ setAvailableEntities( select, noChange ); }, time);
            time += 100;
        });
    }

    $(document).ready(function (){

        $('form#post').on('submit', function(e){

            // Clear all errors
            removeElement( $('.wpc-field-notice') );

            // Clear Notice
            removeElement( $('#message') );

            // Close All Filters
            closeFilter( $(".wpc-filter-item") );

            if( ! filtersFormValid ){
                e.preventDefault();
                // Validate form. We will submit it from validation method
                validateFiltersForm($(this));
            }
        });

        $('.wpc-add-filter').on('click', function (e){
            e.preventDefault();
            var html = $('#wpc-new-filter').html();
            var $el = $(html);
            var search = 'wpc_new_id';
            var replace = uniqId('filter_');
            var replaceAttr = function(i, value){
                return value.replace( search, replace );
            }

            $el.find('[id*="' + search + '"]').attr('id', replaceAttr);
            $el.find('[for*="' + search + '"]').attr('for', replaceAttr);
            $el.find('[name*="' + search + '"]').attr('name', replaceAttr);
            $el.data('fid', replace);
            $el.attr('id', 'wpc-filter-id-'+replace);
            $('.wpc-filters-list').append($el);

            let select = $el.find('.wpc-field-entity');

            syncEntityWithPrefix(select);
            handleMetaKeyField(select);
            setEntityTableClass(select);
            syncEntityWithView(select);
            syncEntityWithSortTerms(select);

            // Make already used entities unavailable to selection
            setAvailableEntities( select );
            handleHierarchyField( select );
            // handleUsedForVariationsField( select );

            $el.find('.wpc-field-exclude').select2({
                width: '100%',
                placeholder: wpcSetVars.excludePlaceholder,
            });

            // Fire this event to load exclude terms for first filter
            if( $('.wpc-filter-item').length === 1 ){
                select.trigger('change');
            }

            $('.wpc-help-tip').tipTip({
                'attribute': 'data-tip',
                'fadeIn':    50,
                'fadeOut':   50,
                'delay':     200,
                'keepAlive': true,
                'maxWidth': "220px",
            });

            openFilter($el);

            renderMenuOrder();
            handleNoFiltersMessage();
            /**
             * @todo There is problem with down arrow when we adding new filter !!! IMPORTANT
             */

        });

        $('.wpc-form-fields-table:not(.wpc-filter-post_meta_num) .wpc-field-exclude, .wpc-form-fields-table:not(.wpc-filter-post_meta_exists) .wpc-field-exclude').select2({
            width: '100%',
            placeholder: wpcSetVars.excludePlaceholder
        });

        $('body').on('click', '.notice-dismiss', function(e){
            e.preventDefault();
            removeElement( $('#message') );
        });

        // Show delete buttons
        $('body').on('click', '.wpc-button-link-delete', function(e){
            e.preventDefault();
            $(this).parents('.wpc-filter-label-td')
                .next('.wpc-filter-field-td')
                .children('.wpc-filter-delete-wrapper').css('visibility', 'visible');
        });

        $('body').on('click', '.wpc-filter-delete-cancel', function(e){
            e.preventDefault();
            removeElement( $('.wpc-field-notice') );
            $(this).parents('.wpc-filter-delete-wrapper').css('visibility', 'hidden');
        });

        $('body').on('click', '.wpc-done-action', function(e){
            $(this).parents('.wpc-filter-body').slideToggle(200)
                    .toggleClass('wpc-opened')
                .children('.wpc-filter-additional-fields').removeClass('wpc-additional-opened')
                    .hide();
            $(this).parents('.wpc-filter-body').prev('.wpc-filter-head').toggleClass('wpc-opened');
            // Hide delete buttons
            $(this).parents('.wpc-filter-field-td')
                .next('.wpc-filter-field-td')
                .find('.wpc-filter-delete-wrapper').css('visibility', 'hidden');
        });

        $('body').on('click', '.wpc-title-action', function(e){
            let head = $(this).parent('.wpc-filter-head'),
                body = head.next('.wpc-filter-body');
            head.toggleClass('wpc-opened');
            body.slideToggle(200)
                    .toggleClass('wpc-opened')
                .children('.wpc-filter-additional-fields').removeClass('wpc-additional-opened')
                    .hide();
            body.find('.wpc-filter-delete-wrapper').css('visibility', 'hidden');

            let moreOptions = body.find('.wpc-more-options-toggle');
            if( moreOptions.hasClass('wpc-opened') ){
                moreOptions.trigger('click');
            }
        });

        $('body').on('click', '.wpc-more-options-toggle', function(e){
            e.preventDefault();

            let moreText = $(this).text();

            if( moreText === wpcSetVars.moreOptions ){
                $(this).text( wpcSetVars.lessOptions);
            }else{
                $(this).text( wpcSetVars.moreOptions);
            }

            $(this).toggleClass('wpc-opened');
            $(this).parents('.wpc-filter-body').find('.wpc-filter-additional-fields').slideToggle(200)
            .toggleClass('wpc-additional-opened');
        });

        $('body').on('change', '.wpc-field-entity', function(e){
            let select = $(this);

            // Set available entities again
            passNewEntities(select);
            syncEntityWithPrefix(select);
            handleMetaKeyField(select);
            handleLogicField(select);
            setEntityTableClass(select);
            syncEntityWithView(select);
            syncEntityWithSortTerms(select);

            handleHierarchyField(select);
            // handleUsedForVariationsField(select);

            // Load terms for exclude
            let entity = $(this).val();
            let fid   = $(this).parents('.wpc-filter-item').data('fid');

            if( entity === 'post_meta' || entity === 'post_meta_num' || entity === 'post_meta_exists' ){
                let target = $('#wpc_filter_fields-'+fid+'-exclude');
                target.select2({
                    disabled: true,
                    width: '100%'
                });
            }else{
                loadExcludeItems(entity, fid);
            }

            let entityLabel = $(this).find('option:selected').text();
            let target = $(this).parents('.wpc-filter-item').find('.wpc-filter-head li.wpc-filter-entity');
            target.text(entityLabel);
        });

        // Try to prepend slug if it already exists
        $('body').on('input change', '.wpc-field-ename', function(){
                let ename = $(this).val();
                let fid = $(this).parents('.wpc-filter-item').data('fid');
                let entity = $('#wpc_filter_fields-'+fid+'-entity').val();
                let val = '';
                let slugs = wpcSetVars.filterSlugs;

                if( entity === 'post_meta_num' ){
                    val = 'post_meta_num_' + ename;
                }else if( entity === 'post_meta_exists' ){
                    val = 'post_meta_exists_' + ename;
                }else{
                    val = 'post_meta_' + ename;
                }

                if( typeof slugs[val] !== 'undefined' ){
                    $('#wpc_filter_fields-'+fid+'-slug').val( slugs[val] )
                        .trigger('input');

                    // Do not load exclude terms for Post Meta Num and Post Meta Exists
                    if( entity !== 'post_meta_num' ){
                        loadExcludeItems(entity, fid, ename);
                    }

                }else{
                    $('#wpc_filter_fields-'+fid+'-slug').val('')
                        .trigger('input');
                    $('#wpc_filter_fields-'+fid+'-exclude').select2({
                        disabled: true,
                        width: '100%',
                    });
                }
        });

        $('body').on('input', '.wpc-field-value-step', function (){
            $(this).val( $(this).val().replace(/,/g, '.') );
            $(this).val( $(this).val().replace(/[^\d\.]/g, '') );
        });

        $('body').on('input', '.wpc-field-slug', function (){
            let target = $(this).parents('.wpc-filter-item').find('.wpc-filter-head li.wpc-filter-slug');
            cpaLiveWrite( $(this), target );
        });

        $('body').on('input', '.wpc-field-label', function (){
            let target = $(this).parents('.wpc-filter-item').find('.wpc-filter-head li.wpc-filter-label');
            cpaLiveWrite( $(this), target );
        });

        $('body').on('change', '.wpc-field-view', function(){
            let optionName = $(this).find('option:selected').text();
            let optionVal  = $(this).find('option:selected').val();
            let $divFilterItem = $(this).parents('.wpc-filter-item');
            let target = $divFilterItem.find('.wpc-filter-head li.wpc-filter-view');
            let allowedViews = ['checkboxes', 'radio', 'labels'];
            target.text(optionName);

            if( allowedViews.includes(optionVal) ){
                $divFilterItem.find('.wpc-field-search-tr').show();
            }else{
                $divFilterItem.find('.wpc-field-search-tr').hide();
            }
        });

        $( '.wpc-filter-set-wrapper .wpc-filters-list' ).sortable({
            items: "> div.wpc-filter-item",
            delay: 150,
            placeholder: "wpc-filter-item-shadow",
            refreshPositions: true,
            cursor: 'move',
            handle: ".wpc-filter-order",
            axis: 'y',
            update: function( event, ui ) {
                renderMenuOrder();
            },
            start: function ( event, ui ){
                var height, $this = $(this), // .wpc-filters-list
                    head = ui.item.children('.wpc-filter-head'),
                    inside = ui.item.children('.wpc-filter-body');

                if (inside.hasClass('wpc-opened') ) {
                    inside.removeClass('wpc-opened')
                        .hide();
                    head.removeClass('wpc-opened');
                    $(this).sortable('refreshPositions');
                }

                $('.wpc-filter-item-shadow').css('min-height', head.height() + 'px');
            }

        });

        $('.wpc-filter-set-wrapper .wpc-filters-list').keydown(function(e){
            if (e.keyCode == 65 && (e.ctrlKey || e.metaKey) ) {
                e.target.select()
            }
        })

        $( ".wpc-filters-list" ).disableSelection();

        // Deleter filter
        $('body').on('click', '.wpc-filter-delete', function (){
            removeElement( $('.wpc-field-notice') );
            let $spinner = $(this).prev('.spinner');
            $spinner.addClass( 'is-active' );
            let requestParams          = {};
            requestParams._wpnonce = $("#wpc_set_nonce").val();
            requestParams.fid   = $(this).data('fid');

            // @feature localize this var
            if( requestParams.fid === 'wpc_new_id' ){
                let $filterItem = $(this).parents('.wpc-filter-item');
                $filterItem.slideUp({
                    duration: 200,
                    complete: function (){
                        $(this).remove();
                        renderMenuOrder();
                        handleNoFiltersMessage();
                    }
                })
            }

            wp.ajax.post( 'wpc-delete-filter', requestParams )
                .always( function() {
                    $spinner.removeClass( 'is-active' );
                })
                .done( function( response ) {

                    if( typeof response !== 'undefined' && typeof response.fid !== 'undefined' ){
                        $("#wpc-filter-id-"+response.fid).slideUp({
                            duration: 200,
                            complete: function (){
                                $(this).remove();
                                renderMenuOrder();
                                handleNoFiltersMessage();

                                // Set available entities again
                                // @todo doesn't work properly if there are several new filters exists on a page !!! IMPORTANT
                                // doesn't make some entities available, but should.
                                passNewEntities();

                            }
                        })
                    }
                })

                .fail( function(response) {
                    if( typeof response !== 'undefined'){
                        addFieldError( 'wpc-filter-delete-wrapper-'+response.fid, response.message );
                    }
                });

        });

        // Get set location fields
        $('body').on('change', '#wpc_set_fields-post_type', function (){

            $("#wpc-filters-list").attr('data-posttype', $(this).val() );

            if( wpcSetVars.filtersPro < 1){
                return true;
            }
            setAvailableEntities( $('.wpc-new-filter-item .wpc-field-entity') );

            removeElement( $('.wpc-field-notice') );

            // Update Post type related location terms
            let selected = $('#wpc_set_fields-wp_page_type').val();
            if( typeof selected !== 'undefined' /*&& selected === 'common:common'*/ ){
                wpcGetLocationTerms( selected );
            }
        });

        $('body').on('change', '#wpc_set_fields-wp_page_type', function(){
            wpcGetLocationTerms( $(this).val() );
        });

        makeNoticesDismissible();

        $('body').on('change', '#wpc_set_fields-post_name', function (e){
            let filterPagelink = $('option:selected', this).data('link');

            if( typeof filterPagelink !== 'undefined'){
                wpcGetWpQueries( filterPagelink );
            }
        });

        let filterPagelink = $('option:selected', $('#wpc_set_fields-post_name')).data('link');

        if( typeof filterPagelink !== 'undefined' && filterPagelink ){
            wpcGetWpQueries( filterPagelink );
        }

    });

    function wpcGetWpQueries( filterPagelink ){
        if( wpcSetVars.filtersPro < 1){
            return true;
        }

        if( filterPagelink === '' ){
            return true;
        }

        removeElement( $('.wpc-field-notice') );
        // 1 Get current Post type to try to find its query

        // let selected = $('#wpc_set_fields-post_type').val();
        let $spinner = $( '.wpc_set_fields-wp_filter_query-wrap' ).children( '.spinner' );
        let postType = $("#wpc_set_fields-post_type").val();

        // Set up AJAX request
        let requestParams          = {};
        requestParams._wpnonce      = $("#wpc_set_nonce").val();
        requestParams.wpPageType    = $('#wpc_set_fields-wp_page_type').val();
        requestParams.postType      = postType;
        requestParams.postId        = $("#post_ID").val();
        requestParams.action        = 'wpc_get_wp_queries';


        $.ajax({
            'method': 'POST',
            'data': requestParams,
            'url': filterPagelink,
            'dataType': 'html',
            beforeSend: function () {
                $spinner.addClass( 'is-active' );
                $(".wpc-location-preview").attr('href', filterPagelink);
            },
            complete: function () {
                $spinner.removeClass( 'is-active' );
            },
            success: function (response) {
                let wpcWpQueriesSelect = $(response).find('#wpc_set_fields-wp_filter_query');
                let wpcWpQueriesHidden = $(response).find('#wpc_query_vars');

                if( wpcWpQueriesSelect !== '' && wpcWpQueriesSelect.length > 0 ){
                    $("#"+wpcSetVars.wPQuerySelectId).replaceWith(wpcWpQueriesSelect);
                }

                if( wpcWpQueriesHidden.length > 0 ){
                    $('#wpc_query_vars').replaceWith(wpcWpQueriesHidden);
                }
            },

            error: function (response) {
                //
            }
        });
    }

    function wpcGetLocationTerms( selected ){
        let $spinner = $( '.wpc_set_fields-post_name-wrap' ).children( '.spinner' );
        $spinner.addClass( 'is-active' );
        // Clear all errors
        removeElement( $('.wpc-field-notice') );
        let postType = $("#wpc_set_fields-post_type").val();

        // Set up AJAX request
        let requestParams          = {};
        requestParams._wpnonce = $("#wpc_set_nonce").val();
        requestParams.wpPageType = selected;
        requestParams.postType   = postType;
        requestParams.postId     = $("#post_ID").val();

        wp.ajax.post( 'wpc-get-set-location-terms', requestParams )
            .always( function() {
                $spinner.removeClass( 'is-active' );
            })
            .done( function( response ) {
                //
                let locationTermsSelect = $(response.html).find('#wpc_set_fields-post_name');
                $( '#wpc_set_fields-post_name' ).replaceWith(locationTermsSelect);

                let filterPagelink = $('option:selected', $('#wpc_set_fields-post_name') ).data('link');
                if( typeof filterPagelink !== 'undefined'){
                    wpcGetWpQueries( filterPagelink );
                }
            })

            .fail( function(response) {
                // {"success":false}
                if( typeof response !== 'undefined'){
                    addFieldError('wpc_set_fields-post_name', response.message);
                }
            });
    }

    function cpaLiveWrite( readFrom, writeTo ) {
        let cpaText;

        readFrom.on('input', function() {
            cpaText = $(this).val();
            writeTo.text(cpaText);
        });
    }

    /**
     * Calculates correct menu order in accordance with filter position in list
     */
    function renderMenuOrder()
    {
        $(".wpc-filter-item").each( function ( index, element ) {
            var num = index + 1;
            $(element).find('.wpc-menu-order-field').attr('value', num );
            $(element).find('.wpc-filter-sortable-handle').text(num);
        });
    }

    function handleNoFiltersMessage()
    {
        if( $(".wpc-filter-item").length > 0 ){
            $('.wpc-no-filters').hide();
        }else{
            $('.wpc-no-filters').show();
        }
    }

    function setEntityTableClass( entitySelect )
    {
        let val = entitySelect.val();
        let fid = entitySelect.parents('.wpc-filter-item').data('fid');
        let additionalClass = '';

        if( val.startsWith('taxonomy_pa_') ){
            additionalClass = ' taxonomy-product-attribute';
        }

        if( val.indexOf('taxonomy') !== -1 ){
            val = 'taxonomy';
        }

        $("#wpc-filter-id-"+fid+" .wpc-form-fields-table").attr('class', 'wpc-form-fields-table wpc-filter-'+val+additionalClass);
    }

    function syncEntityWithPrefix( entitySelect )
    {
        let val = entitySelect.val();
        let fid = entitySelect.parents('.wpc-filter-item').data('fid');

        if( typeof wpcSetVars.filterSlugs[val] !== 'undefined'){
            let prefix = wpcSetVars.filterSlugs[val];
            $('#wpc_filter_fields-'+fid+'-slug').val(prefix)
                .attr('readonly', 'readonly')
                .trigger('input');
        } else {
            $('#wpc_filter_fields-'+fid+'-slug').val('')
                .removeAttr('readonly')
                .trigger('input');
        }

    }

    function syncEntityWithSortTerms( entitySelect ){
        let val = entitySelect.val();
        let fid = entitySelect.parents('.wpc-filter-item').data('fid');

        if( ! val.includes('taxonomy_pa') ) {
            $('#wpc_filter_fields-'+fid+'-orderby option[value="menuasc"]').attr('disabled', 'disabled');
            $('#wpc_filter_fields-'+fid+'-orderby option[value="menudesc"]').attr('disabled', 'disabled');
        }else{
            $('#wpc_filter_fields-'+fid+'-orderby option[value="menuasc"]').removeAttr('disabled');
            $('#wpc_filter_fields-'+fid+'-orderby option[value="menudesc"]').removeAttr('disabled');
        }
    }

    function syncEntityWithView( entitySelect ){
        let val = entitySelect.val();
        let fid = entitySelect.parents('.wpc-filter-item').data('fid');

        if( val === 'post_meta_num' ) {
            $('#wpc_filter_fields-'+fid+'-view option:not([value="range"])').attr('disabled', 'disabled');
            $('#wpc_filter_fields-'+fid+'-view option[value="range"]').removeAttr('disabled')
                .prop('selected', true);

        }else{
            $('#wpc_filter_fields-'+fid+'-view option').removeAttr('disabled')
            $('#wpc_filter_fields-'+fid+'-view option:not([disabled]):first').prop('selected', true);
            $('#wpc_filter_fields-'+fid+'-view option[value="range"]').attr('disabled', 'disabled');
        }
    }


    function handleLogicField( entitySelect )
    {
        let val = entitySelect.val();
        let fid = entitySelect.parents('.wpc-filter-item').data('fid');

        if( val === 'author_author' || val === 'post_meta_exists' ) {
            $('#wpc_filter_fields-' + fid + '-logic option[value="and"]').attr('disabled', 'disabled');
            $('#wpc_filter_fields-' + fid + '-logic option[value="or"]').prop('selected', true);

        }else if( val === 'post_meta_num' ){
            $('#wpc_filter_fields-' + fid + '-logic option[value="or"]').attr('disabled', 'disabled');
            $('#wpc_filter_fields-' + fid + '-logic option[value="and"]').prop('selected', true);
        }else{
            $('#wpc_filter_fields-'+fid+'-logic option[value="and"]').removeAttr('disabled');
            $('#wpc_filter_fields-'+fid+'-logic option[value="or"]').removeAttr('disabled');
        }

        return true;
    }

    function handleHierarchyField( entitySelect )
    {
        let val = entitySelect.val();
        let fid = entitySelect.parents('.wpc-filter-item').data('fid');
        let posttype = $("#wpc-filters-list").attr('data-posttype');

        if( val.indexOf('taxonomy') !== -1 ){
            $.each( wpcSetVars.postTypesTaxList, function ( pType, taxesArray ){
                $.each( taxesArray, function ( index, theTax ){
                    if( theTax['name'] === val ){
                        if( theTax['hierarchical'] ){
                            $("#wpc-filter-id-"+fid+" .wpc-field-hierarchy-tr").show();
                        }else{
                            $("#wpc-filter-id-"+fid+" .wpc-field-hierarchy-tr").hide();
                        }
                    }
                });
            });
        }
    }

    function handleMetaKeyField( entitySelect )
    {
        let val = entitySelect.val();
        let fid = entitySelect.parents('.wpc-filter-item').data('fid');

        if( val === 'post_meta' || val === 'post_meta_num' || val === 'post_meta_exists' ){
            $('#wpc_filter_fields-'+fid+'-e_name').val('')
                .removeAttr('readonly')
                .parents('.wpc-field-ename-tr').show();
        }else{
            $('#wpc_filter_fields-'+fid+'-e_name').parents('.wpc-field-ename-tr').hide();
        }

        if( val === 'post_meta_num' ){
            $('#wpc_filter_fields-'+fid+'-in_path').prop( "checked", false );
            // $('#wpc_filter_fields-'+fid+'-show_chips').prop( "checked", false );
        }else{
            $('#wpc_filter_fields-'+fid+'-in_path').prop( "checked", true );
            // $('#wpc_filter_fields-'+fid+'-show_chips').prop( "checked", true );
        }
    }

    function loadExcludeItems( entity, fid, ename )
    {
        // let val = entitySelect.val();
        // let fid = entitySelect.parents('.wpc-filter-item').data('fid');
        removeElement( $('.wpc-field-notice') );
        let requestParams          = {};
        let target              = $('#wpc_filter_fields-'+fid+'-exclude');
        requestParams._wpnonce  = $("#wpc_set_nonce").val();
        requestParams.fid       = fid;
        requestParams.entity    = entity;

        if( typeof ename !== 'undefined' ){
            requestParams.ename = ename;
        }

        let $spinner = target.parent('.wpc-after-spinner-container').prev( '.spinner' );
        $spinner.addClass( 'is-active' );

        wp.ajax.post( 'wpc-load-exclude-terms', requestParams )
            .always( function() {
                $spinner.removeClass( 'is-active' );
            })
            .done( function( response ) {
                if( typeof response.fid !== 'undefined' ){
                    target.select2('destroy');
                    target.html('');
                    target.select2({
                        width: '100%',
                        placeholder: wpcSetVars.excludePlaceholder,
                        data: response.terms,
                        disabled: false
                    })
                }
            })

            .fail( function(response) {
                // if( typeof response !== 'undefined'){
                //     addFieldError( 'wpc_filter_fields-'+response.fid+'-exclude', response.message );
                // }
            });

    }

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

// Important!!!
// When field Filter by is selected, it is required to make AJAX request to find the same
// entity in filters already. And if it is exists, to predefine field "slug" defined in previous
// selection of

function uniqId (prefix, moreEntropy) {
    //  discuss at: https://locutus.io/php/uniqid/
    // original by: Kevin van Zonneveld (https://kvz.io)
    //  revised by: Kankrelune (https://www.webfaktory.info/)
    //      note 1: Uses an internal counter (in locutus global) to avoid collision
    //   example 1: var $id = uniqid()
    //   example 1: var $result = $id.length === 13
    //   returns 1: true
    //   example 2: var $id = uniqid('foo')
    //   example 2: var $result = $id.length === (13 + 'foo'.length)
    //   returns 2: true
    //   example 3: var $id = uniqid('bar', true)
    //   example 3: var $result = $id.length === (23 + 'bar'.length)
    //   returns 3: true

    if (typeof prefix === 'undefined') {
        prefix = '';
    }

    var retId;
    var _formatSeed = function (seed, reqWidth) {
        seed = parseInt(seed, 10).toString(16); // to hex str
        if (reqWidth < seed.length) {
            // so long we split
            return seed.slice(seed.length - reqWidth);
        }
        if (reqWidth > seed.length) {
            // so short we pad
            return Array(1 + (reqWidth - seed.length)).join('0') + seed;
        }
        return seed;
    }

    var $global = (typeof window !== 'undefined' ? window : global);
    $global.$locutus = $global.$locutus || {}
    var $locutus = $global.$locutus;
    $locutus.php = $locutus.php || {}

    if (!$locutus.php.uniqidSeed) {
        // init seed with big random int
        $locutus.php.uniqidSeed = Math.floor(Math.random() * 0x75bcd15);
    }
    $locutus.php.uniqidSeed++;

    // start with prefix, add current milliseconds hex string
    retId = prefix;
    retId += _formatSeed(parseInt(new Date().getTime() / 1000, 10), 8);
    // add seed hex string
    retId += _formatSeed($locutus.php.uniqidSeed, 5);
    if (moreEntropy) {
        // for more entropy we add a float lower to 10
        retId += (Math.random() * 10).toFixed(8).toString();
    }

    return retId;
}
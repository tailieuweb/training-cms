/*!
 * Filter Everything 1.4.5
 */
(function ($) {
    "use strict";
    let wpcAjax                     = wpcFilterFront.wpcAjaxEnabled;
    let wpcStatusCookieName         = wpcFilterFront.wpcStatusCookieName;
    let wpcWidgetStatusCookieName   = wpcFilterFront.wpcWidgetStatusCookieName;
    let wpcHierachyListCookieName   = wpcFilterFront.wpcHierarchyListCookieName;
    let wpcMobileWidth              = wpcFilterFront.wpcMobileWidth;
    let wpcPostContainers           = wpcFilterFront.wpcPostContainers;
    let wpcAutoScroll               = wpcFilterFront.wpcAutoScroll;
    let wpcAutoScrollOffset         = wpcFilterFront.wpcAutoScrollOffset;
    let wpcWaitCursor               = wpcFilterFront.wpcWaitCursor;
    let wpcPostsPerPage             = wpcFilterFront.wpcPostsPerPage;
    let wpcUseSelect2               = wpcFilterFront.wpcUseSelect2;
    let wpcPopupCompatMode          = wpcFilterFront.wpcPopupCompatMode;
    let wpcWidgetContainer          = '.wpc-filters-widget-main-wrapper';
    let wpcIsMobile                 = false;

    function removeElement($el)
    {
        $el.fadeTo(100, 0, function() {
            $el.slideUp(100, function() {
                $el.remove();
            });
        });
    }

    $(document).on('click', '.wpc-filter-content input[type="radio"],.wpc-filter-content input[type="checkbox"]', function (e) {
        let wpcLink = $(this).data('wpc-link');
        let $el = $(this).parents(wpcWidgetContainer);
        if( wpcAjax ){
            e.preventDefault();
            wpcSendFilterRequest( wpcLink, $el );
        }else{
            location.href = wpcLink;
        }
    });

    $(document).on('change', '.wpc-orderby-select', function (){
        let wpcSortingForm = $(this).parents('form.wpc-sorting-form');
        let wpcSortingVal  = $(this).val();
        let search = '';
        //@todo bug on mobile force AJAX
        search = '?' + wpcSortingForm.serialize();

        let wpcLink = wpcSortingForm.attr('action') + search;

        if( wpcFilterFront.wpcAjaxEnabled ) {
            $('.wpc-filters-widget-main-wrapper').each(function (index, element) {
                let $el = $(element);
                wpcSendFilterRequest(wpcLink, $el);
            });
        }else{
            wpcSortingForm.attr('action', wpcLink);
            // window.location.href = wpcLink;
            wpcSortingForm.submit();
        }
    });

    $(document).on('change', '.wpc-filter-content select', function (e) {
        var wpcLink = $(this).find('option:selected').data('wpc-link');
        let $el = $(this).parents(wpcWidgetContainer);

        if( wpcAjax ){
            wpcSendFilterRequest( wpcLink, $el );
        }else{
            location.href = wpcLink;
        }
    });

    $(document).on('click', '.wpc-filter-chip a', function (e){
        if( wpcAjax ) {
            let wpcLink = $(this).attr('href');
            let setId = $(this).parents('.wpc-filter-chips-list').data('set');
            let $el = $('.wpc-filter-set-'+setId);
            e.preventDefault();
            wpcSendFilterRequest(wpcLink, $el);
        }else{
            return true;
        }
    });

    $(document).on('click', 'i.wpc-toggle-children-list', function (){
        let _tid = $(this).data('tid');
        let wpcTermContentWrapper = $(this).parent(".wpc-term-item-content-wrapper");
        let wpcTargetUl = wpcTermContentWrapper.parent('li').children('ul.children');

        wpcTermContentWrapper.parent('li').toggleClass('wpc-opened');
        // wpcTermContentWrapper.toggleClass('wpc-opened');

        if( wpcTargetUl.is(':visible' ) ){
            rememberOpened( _tid, wpcHierachyListCookieName );
        }else{
            forgetOpened( _tid, wpcHierachyListCookieName );
        }
    });

    $(document).on('click', '.wpc-filters-overlay', function (){
        let setId = $('body').data('set');
        wpcCloseFiltersContainer(setId);
    })

    $(document).on('change', '.wpc-filter-range-form input[type="number"]', function (e) {
        let form = $(this).parents('.wpc-filter-range-form');

        let $min    = form.find('.wpc-filters-range-min');
        let $max    = form.find('.wpc-filters-range-max');

        var curMinVal = parseFloat($min.val());
        var curMaxVal = parseFloat($max.val());

        var initialMin = $min.data('min');
        var initialMax = $max.data('max');

        if( form.hasClass('wpc-form-has-slider') ){
            let $slider = form.find('.wpc-filters-range-slider-control');
            $slider.slider("option", "values", [curMinVal, curMaxVal]);
        }

        if (curMinVal === initialMin) {
            $min.attr('disabled', true);
        }

        if (curMaxVal === initialMax) {
            $max.attr('disabled', true);
        }

        if( wpcAjax ){
            let search = form.serialize();
            let wpcLink = form.attr('action') + '?' + search;
            let $el = form.parents(wpcWidgetContainer);
            wpcSendFilterRequest(wpcLink, $el);

            $min.attr('disabled', false);
            $max.attr('disabled', false);
        } else {
            form.submit();
        }

    });

    $(document).on( 'click','.wpc-open-close-filters-button', function (e){
        e.preventDefault();
        let openCloseButton = $(this);
        let wpcSetId        = openCloseButton.data('wid');
        let widgetContent   = $('.wpc-filter-set-'+wpcSetId+' .wpc-filters-widget-content');

        if( widgetContent.is(':visible') ){
            widgetContent.slideUp({
                duration: 100,
                complete: function (){
                    $(this).addClass('wpc-closed')
                        .removeClass('wpc-opened');
                    openCloseButton.removeClass('wpc-opened');
                    wpcSetCookie(wpcWidgetStatusCookieName, null, {path: '/', 'max-age': 2592000});
                }
            });
        }else{
            widgetContent.slideDown({
                duration: 100,
                complete: function (){
                    $(this).addClass('wpc-opened')
                        .removeClass('wpc-closed');
                    openCloseButton.addClass('wpc-opened');
                    wpcSetCookie(wpcWidgetStatusCookieName, wpcSetId, {path: '/', 'max-age': 2592000});
                }
            });
        }
    });

    $(document).on('click', '.wpc-widget-close-icon', function (e){
        e.preventDefault();
        let $wrapper    = $( this ).parents( wpcWidgetContainer );
        let setId       = $wrapper.data( 'set' );
        wpcCloseFiltersContainer(setId);
    });
    $(document).on('click', '.wpc-filters-apply-button', function (e){
        e.preventDefault();
        let $wrapper    = $( this ).parents( wpcWidgetContainer );
        let setId       = $wrapper.data( 'set' );
        let $content    = $( '.wpc-filter-set-'+setId+' .wpc-filters-widget-content' );
        let href        = $(this).attr( 'href' );
        let wpcReload   = ! $(this).hasClass('wpc-posts-loaded');
        let wpcZindex   = '';
        let $currentTag = false;

        $wrapper.removeClass('wpc-container-opened');
        $('html').removeClass('wpc-overlay-visible');
        $content.removeClass('wpc-filters-widget-opened');
        $('.wpc-open-button-'+setId+' .wpc-filters-open-widget').removeClass('wpc-opened');

        if( wpcPopupCompatMode ) {
            setTimeout(() => {
                $content.parents().each(function (index, tag) {
                    $currentTag = $(tag);
                    wpcZindex = $currentTag.data('wpczindex');

                    // Saved z-index for
                    if (wpcZindex !== 'undefined') {
                        $currentTag.css('z-index', wpcZindex);
                    }

                    if ($currentTag.hasClass('wpc-force-visibility')) {
                        $currentTag.removeClass('wpc-force-visibility');
                    }
                });

                setTimeout(() => {
                    $(".wpc-was-invisible").css('opacity', '1')
                        .removeClass('wpc-was-invisible');
                }, 300);

            }, 260);
        }

        if( wpcReload ) {
            location.href = href;
        }
    });

    $(document).on('submit', '.wpc-filter-range-form', function (e) {
        submitSliderForm(e, $(this));
    });

    $(document).on('click', '.wpc-filter-content a', function (e) {
        e.preventDefault();
        let wpcInputId = $(this).closest('label').attr('for');
        $(this).closest('label').parent('.wpc-term-item-content-wrapper').parent('.wpc-term-item').find('#'+wpcInputId).trigger('click');
    });

    $(document).on('click', '.wpc-filters-open-widget', function (e) {
        e.preventDefault();
        let setId = $(this).data('wid');
        wpcOpenContainer( setId );
    });

    $(document).on('click', '.wpc-filters-close-button', function (e) {
        e.preventDefault();
        let wrapper = $(this).parents(wpcWidgetContainer);
        let setId   = wrapper.data('set');

        if( wpcAjax && wpcFilterFront.wpcAjaxEnabled ){
            let cancelLink      = $(this).attr('href');
            let applyLink       = $('.wpc-filter-set-'+setId+' .wpc-filters-apply-button').attr('href');

            if( cancelLink !== applyLink ){
                wpcSendFilterRequest( cancelLink, wrapper, 'wpcCloseFiltersContainer' );
                return;
            }
        }

        wpcCloseFiltersContainer(setId);
    });

    $(document).on('click', '.wpc-filter-title button', function (e){
        e.preventDefault();
        let buttonHead = $(this).parents('.wpc-filter-collapsible');
        let filterId   = buttonHead.parents('.wpc-filters-section').data('fid');

        if( $( '.wpc-filters-section-'+filterId+' .wpc-filter-content' ).is( ':visible' ) ){
            closeFilterContentBox(buttonHead);
            forgetOpened(filterId, wpcStatusCookieName);
        }else{
            openFilterContentBox(buttonHead);
            rememberOpened(filterId, wpcStatusCookieName);
        }
    });

    $( window ).resize(function() {
        if( window.innerWidth <= wpcMobileWidth ){
            wpcIsMobile = true;
            if( wpcFilterFront.showBottomWidget === 'yes' ) {
                wpcAjax = true;
            }
        }else{
            wpcAjax     = wpcFilterFront.wpcAjaxEnabled;
            wpcIsMobile = false;
        }

        if( wpcUseSelect2 === 'yes' ){
            $(wpcWidgetContainer).each( function ( index, widget ){
                let widgetSet = $(widget).data('set');
                let widgetClass = 'wpc-filter-set-'+widgetSet;
                wpcInitSelect2(widgetClass);
            });
        }
    });

    if ($.support.pjax) {
        $(document).on('pjax:end', function() {
            setTimeout(() => {
                wpcInitiateAll();
            }, 300);
        });
    }

    $(document).ready(function (){
        wpcInitiateAll();
    });

    $(document).on('input', '.wpc-filter-search-field',function (e){
        let $search = $(this).val().toString().toLowerCase();
        let fid = $(this).parents('.wpc-filters-section').data('fid');

        if( $search !== '' ){
            $(".wpc-filter-search-wrapper-"+fid+" .wpc-search-clear").show();
        }else{
            $(".wpc-filter-search-wrapper-"+fid+" .wpc-search-clear").hide();
        }

        $(".wpc-filters-list-"+fid+" li").each(function( index, value ) {
            let $li = $(value);
            let $termName = $(value).find('label a').text().toLowerCase();
            if ($termName.indexOf($search) > -1) {
                $li.show();
            } else {
                $li.hide();
            }
        });
    });

    $(document).on( 'click', '.wpc-search-clear', function (e){
        e.preventDefault();
        let $searchField = $(this).parent(".wpc-filter-search-wrapper").find(".wpc-filter-search-field");
        $searchField.val('')
            .trigger('input');
        // $(this).hide();
    })

    function wpcInitiateAll(){
        $('.wpc-filter-range-form').each( function ( index, form ){
            $.fn.wpcInitSlider( $(form) );
        });

        if (window.innerWidth <= wpcMobileWidth) {
            wpcIsMobile = true;
            if( wpcFilterFront.showBottomWidget === 'yes' ) {
                wpcAjax = true;
            }
        }

        if( wpcUseSelect2 === 'yes' ){
            $(wpcWidgetContainer).each( function ( index, widget ){
                let widgetSet = $(widget).data('set');
                let widgetClass = 'wpc-filter-set-'+widgetSet;
                wpcInitSelect2(widgetClass);
            });
        }

        $('.wpc-help-tip').tipTip({
            'attribute': 'data-tip',
            'fadeIn':    50,
            'fadeOut':   50,
            'delay':     200,
            'keepAlive': true,
            'maxWidth': "220px",
        });
    }

    function wpcInitSelect2( widgetClass ) {
        if( typeof $.fn.select2 === 'undefined'){
            return;
        }

        let wpcUserAgent = navigator.userAgent.toLowerCase();
        let wpcIsAndroid = wpcUserAgent.indexOf("android") > -1;
        let wpcAllowSearchField = 0;
        if(wpcIsAndroid) {
            wpcAllowSearchField = Infinity;
        }

        $('.wpc-filters-widget-select').select2({
            dropdownCssClass: 'wpc-filter-everything-dropdown',
            dropdownParent: $('.'+widgetClass+' .wpc-filters-widget-content'),
            templateResult: function(data) {
                // We only really care if there is an element to pull classes from
                if (!data.element) {
                    return data.text;
                }
                let $dr_element = $(data.element);
                let $dr_wrapper = $('<span></span>');
                $dr_wrapper.addClass($dr_element[0].className);
                $dr_wrapper.text(data.text);

                return $dr_wrapper;
            },
            minimumResultsForSearch: wpcAllowSearchField
        });

        $('.wpc-orderby-select').select2({
            dropdownCssClass: 'wpc-filter-everything-dropdown',
            dropdownParent: $('.wpc-after-sorting-form'),
            templateResult: function(data) {
                // We only really care if there is an element to pull classes from
                if (!data.element) {
                    return data.text;
                }
                let $dr_element = $(data.element);
                let $dr_wrapper = $('<span></span>');
                $dr_wrapper.addClass($dr_element[0].className);
                $dr_wrapper.text(data.text);

                return $dr_wrapper;
            },
            minimumResultsForSearch: Infinity
        });
    }


    function wpcGetCookie(name) {
        var matches = document.cookie.match(new RegExp(
            "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
        ))
        return matches ? decodeURIComponent(matches[1]) : undefined
    }

    //Example: wpcSetCookie('user', 'John', {secure: true, 'max-age': 3600});
    function wpcSetCookie(name, value, props) {
        props = props || {}
        let exp = props.expires
        if (typeof exp == "number" && exp) {
            let d = new Date()
            d.setTime(d.getTime() + exp*1000)
            exp = props.expires = d
        }

        if(exp && exp.toUTCString) { props.expires = exp.toUTCString() }
        value = encodeURIComponent(value)

        let updatedCookie = name + "=" + value
        for(let propName in props){
            updatedCookie += "; " + propName
            let propValue = props[propName]
            if(propValue !== true){ updatedCookie += "=" + propValue }
        }
        document.cookie = updatedCookie
    }

    function wpcDeleteCookie(name) {
        wpcSetCookie(name, null, { expires: -1 })
    }

    function openFilterContentBox(buttonHead)
    {
        let body  = buttonHead.next('.wpc-filter-content');
        let setId = buttonHead.parents(wpcWidgetContainer).data('set');
        let widgetClass = 'wpc-filter-set-'+setId;

        buttonHead.addClass('wpc-opened')
            .removeClass('wpc-closed');

        body.slideDown({
            duration: 100,
            complete: function (){
                $(this).addClass('wpc-opened')
                    .removeClass('wpc-closed');

                wpcInitSelect2(widgetClass);
            }
        });
    }

    function closeFilterContentBox(buttonHead)
    {
        let body = buttonHead.next('.wpc-filter-content');

        buttonHead.removeClass('wpc-opened')
            .addClass('wpc-closed');

        body.slideUp({
            duration: 100,
            complete: function (){
                $(this).removeClass('wpc-opened')
                    .addClass('wpc-closed');
            }
        });
    }

    function rememberOpened(fid, wpcListCookieName)
    {
        let status = wpcGetCookie(wpcListCookieName);
        let _fids  = new Array();
        fid = fid.toString();

        // In case there is no Cookies yet
        if( typeof status === 'undefined' ){
            status = '';
        }else{
            status = status.trim();
            _fids = status.split(',');
        }

        // Filter from empty elements
        _fids = _fids.filter(function (el) {
            return el != '';
        });

        if( _fids.indexOf(fid) === -1 ){
            _fids.push(fid);

            let newStatus = '';

            if( _fids.length === 0 ){
                newStatus = fid;
            }else{
                newStatus = _fids.join();
            }

            wpcSetCookie( wpcListCookieName, newStatus, {path: '/', 'max-age': 2592000} )
        }

    }

    function forgetOpened(fid, wpcListCookieName)
    {
        let status = wpcGetCookie(wpcListCookieName);
        fid = fid.toString();

        if( typeof status !== 'undefined' ){
            let _fids = status.split(',');
            let pos = _fids.indexOf(fid);
            if( pos !== -1 ){
                _fids.splice(pos, 1);
                let newStatus = _fids.join(',');

                wpcSetCookie( wpcListCookieName, newStatus, {path: '/', 'max-age': 2592000} )
            }
        }
    }

    function wpcSetVisibilityCssValues( $tag )
    {
        let wpcCssDisplay = $tag.css('display');
        let wpcCssOpacity = $tag.css('opacity');

        $tag.data('wpc-display', wpcCssDisplay);
        $tag.data('wpc-opacity', wpcCssOpacity);

    }

    function wpcCloseFiltersContainer(setId)
    {
        let $wrapper = $('.wpc-filter-set-'+setId);
        let $content = $('.wpc-filter-set-'+setId+' .wpc-filters-widget-content');
        $('.wpc-open-button-'+setId+' .wpc-filters-open-widget').removeClass('wpc-opened');
        $('html').removeClass('wpc-overlay-visible');
        $content.removeClass('wpc-filters-widget-opened');

        if( wpcPopupCompatMode ) {
            setTimeout(() => {

                let wpcZindex = '';
                let $currentTag = false;

                $content.parents().each(function (index, tag) {
                    $currentTag = $(tag);
                    wpcZindex = $currentTag.data('wpczindex');
                    // Saved z-index for
                    if (wpcZindex !== 'undefined') {
                        $currentTag.css('z-index', wpcZindex);
                    }

                    if ($currentTag.hasClass('wpc-force-visibility')) {
                        $currentTag.removeClass('wpc-force-visibility');
                    }
                });

                setTimeout(() => {
                    $(".wpc-was-invisible").css('opacity', '1')
                        .removeClass('wpc-was-invisible');
                }, 300);

            }, 260);
        }

        $wrapper.removeClass('wpc-container-opened');
    }

    function wpcOpenFiltersContainer(setId)
    {
        let $wrapper    = $('.wpc-filter-set-'+setId);
        let $content    = $('.wpc-filter-set-'+setId+' .wpc-filters-widget-content');
        let wpcZindex   = '';
        let wpcVisibility = '';
        let wpcTransform = '';
        let $currentTag = false;

        if( $content.length < 1 ){
            return true;
        }

        if( wpcPopupCompatMode ) {
            $content.parents().each(function (index, tag) {
                $currentTag     = $(tag);
                wpcZindex       = $currentTag.css('z-index');
                wpcVisibility   = $currentTag.is(":visible");
                wpcTransform    = $currentTag.css('transform');

                // Save current z-index for future
                if (wpcZindex !== 'auto') {
                    $currentTag.data('wpczindex', wpcZindex);
                }

                $currentTag.css('z-index', 'auto');

                // Save current display, opacity and visibility values
                if (!wpcVisibility || wpcTransform !== 'none') {
                    if (!$currentTag.hasClass('widget_wpc_filters_widget')
                        &&
                        !$currentTag.hasClass('wpc-filters-widget-main-wrapper')
                    ) {
                        $currentTag.css('opacity', '0');
                        $currentTag.addClass('wpc-force-visibility wpc-was-invisible');
                    }
                }
            });

            if( wpcUseSelect2 === 'yes' ){
                wpcInitSelect2( 'wpc-filter-set-'+setId );
            }
        }

        $('.wpc-open-button-'+setId+' .wpc-filters-open-widget').addClass('wpc-opened');
        $('html').addClass('wpc-overlay-visible');
        $('body').data('set', setId);

        $content.addClass('wpc-filters-widget-opened');
        $wrapper.addClass('wpc-container-opened');
        $('.wpc-filter-set-'+setId+' .wpc-filters-close-button').attr('href', window.location.href);

    }

    function wpcOpenContainer( setId ) {
        let $wrapper = $( '.wpc-filter-set-'+setId );

        if( $wrapper.length < 1 ){
            alert('There is no filter widget with ID '+setId+' on this page');
            return;
        }

        if( $wrapper.hasClass('wpc-container-opened') ){
            wpcCloseFiltersContainer(setId);
        }else{
            wpcOpenFiltersContainer(setId);
        }
    }

    function wpcShowSpinner()
    {
        $('.wpc-spinner, html').addClass('is-active');
    }

    function wpcHideSpinner()
    {
        $('.wpc-spinner, html').removeClass('is-active');
    }

    $.fn.wpcInitSlider = function ( form ) {

        // Default valued at start
        let $min = form.find('.wpc-filters-range-min');
        let $max = form.find('.wpc-filters-range-max');
        let $slider = form.find('.wpc-filters-range-slider-control');
        let step = parseFloat( $min.attr('step') );

        let initialMinVal = parseFloat( $min.data('min') );
        let initialMaxVal = parseFloat( $max.data('max') );

        // Values after applying filter
        let curMinVal = parseFloat( $min.val() );
        let curMaxVal = parseFloat( $max.val() );

        // Setting value into form inputs when slider is moving
        $slider.slider({
            min: initialMinVal,
            max: initialMaxVal,
            values: [curMinVal, curMaxVal],
            range: true,
            step: step,
            slide: function (event, elem) {
                let instantMinVal = elem.values[0];
                let instantMaxVal = elem.values[1];

                $min.val(instantMinVal);
                $max.val(instantMaxVal);
            },
            change: function (event) {
                // It is better always to submit slider automatically to avoid empty intersection occurrence
                submitSliderForm(event, form);
            }
        });

        form.submit(function (e) {
            //Remove ? sign if form is empty
            if (($(this).serialize().length === 0)) {
                e.preventDefault();
                window.location.assign(window.location.pathname);
            }
        });
    }

    function submitSliderForm(event, form) {

        if (event.originalEvent) {

            let $min    = form.find('.wpc-filters-range-min');
            let $max    = form.find('.wpc-filters-range-max');
            let $slider = form.find('.wpc-filters-range-slider-control');

            var minVal = parseFloat($min.val());
            var maxVal = parseFloat($max.val());

            var initialMin = $slider.slider('option', 'min');
            var initialMax = $slider.slider('option', 'max');

            if (minVal === initialMin) {
                $min.attr('disabled', true);
            }

            if (maxVal === initialMax) {
                $max.attr('disabled', true);
            }

            if ( wpcAjax ) {
                event.preventDefault();
                let search = form.serialize();
                let wpcLink = form.attr('action') + '?' + search;
                let $el = form.parents(wpcWidgetContainer);
                wpcSendFilterRequest(wpcLink, $el);

                $min.attr('disabled', true);
                $max.attr('disabled', true);

            } else if( event.originalEvent ) {
                form.trigger('submit');
            }

        }
    }

    // Jiboshit' jak treba!
    function wpcSendFilterRequest( link, widget, onComplete ){
        onComplete = (typeof onComplete !== 'undefined') ? onComplete : false;
        removeElement($('.wpc-front-error'));

        let requestParams               = {};
        requestParams.flrt_ajax_link    = link;
        requestParams.wpcAjaxAction     = 'filter';
        let setId                       = widget.data('set');
        let widgetClass                 = 'wpc-filter-set-'+setId;
        let targetPostsContainer        = wpcPostContainers['default'];

        if( typeof wpcPostContainers[setId] !== "undefined" ){
            targetPostsContainer = wpcPostContainers[setId];
        }

        $.ajax({
            'method': 'POST',
            'data': requestParams,
            'url': link,
            'dataType': 'html',
            beforeSend: function () {
                if( wpcWaitCursor ){
                    $('html, body').css("cursor", "wait");
                }

                let $a_el = $(widget).find('.wpc-filters-apply-button');

                $a_el.removeClass('wpc-posts-loaded');

                let oldLink = $a_el.attr('href');

                $a_el.attr('href', link);
                $a_el.data('href', oldLink);
                wpcShowSpinner();

            },
            complete: function () {
                if(onComplete !== false){
                    eval(onComplete+'(setId)');
                }
                if( wpcWaitCursor ) {
                    $('html, body').css("cursor", "auto");
                }

                wpcInitiateAll();

                wpcHideSpinner();

            },
            success: function (response) {
                if (typeof response !== 'undefined' ) {

                    // Products
                    // Wrap response to allow .find method search inner elements.
                    response = '<div class="responseWrapper">'+response+'</div>';
                    let $response = $(response);

                    if( ( $response.find(targetPostsContainer).length > 0 ) && wpcFilterFront.wpcAjaxEnabled ){
                        let responseTitle     = $response.find('title').text();
                        let responseCanonical = $response.find('link[rel="canonical"]').attr('href');

                        // But this works on TV also
                        $(targetPostsContainer).html( $response.find(targetPostsContainer).html() );
                        // wpcPostsWereLoaded = true;

                        // Mark the "Show" button to not reload content
                        $(widget).find('.wpc-filters-apply-button').addClass('wpc-posts-loaded');

                        //@todo update selected terms if them outside of posts container

                        // If h1 outside of posts container
                        if( $response.find(targetPostsContainer).find('h1').length < 1 ){
                            if($response.find('h1').length > 0){
                                $('h1')[0].replaceWith( $response.find('h1')[0] );
                            }
                        }

                        // If seoText container is outside from posts container
                        if( $response.find(targetPostsContainer).find('.wpc-page-seo-description').length < 1 ){
                            let wpcSeoTextContainer = $response.find('.wpc-page-seo-description');
                            let originalSeoTextContainer = $('.wpc-page-seo-description');
                            if( wpcSeoTextContainer.length > 0 && originalSeoTextContainer.length > 0){
                                $('.wpc-page-seo-description')[0].replaceWith( wpcSeoTextContainer[0] );
                            }
                        }

                        // If Filters open button outside of posts container
                        if( $response.find(targetPostsContainer).find('.wpc-open-button-'+setId).length < 1 ){
                            if($response.find('.wpc-open-button-'+setId+' .wpc-button-inner').length > 0){
                                let wpcButtonInnerContent = $response.find('.wpc-open-button-'+setId+' .wpc-button-inner')[0];
                                $('.wpc-open-button-'+setId+' .wpc-button-inner').replaceWith( wpcButtonInnerContent );
                            }
                        }
                        // Replace title
                        if( typeof responseTitle !== 'undefined' && responseTitle !== '' ){
                            $(document).attr( 'title', responseTitle );
                        }

                        // Handle <meta name="description" /> tag
                        handleMetaTag('description', response);

                        // Handle <meta name="robots" /> tag
                        handleMetaTag('robots', response);

                        // Handle Canonical
                        if( typeof responseCanonical !== 'undefined' && responseCanonical !== '' ){
                            // Replace content if tag exists
                            if( $('link[rel="canonical"]').length > 0 ){
                                $('link[rel="canonical"]').attr('href', responseCanonical );
                            } else {
                                // Append meta tag
                                $('head').append('<link rel="canonical" href="'+responseCanonical+'" />');
                            }
                        }else{
                            if( $('link[rel="canonical"]').length > 0 ){
                                $('link[rel="canonical"]').remove();
                            }
                        }

                        window.history.pushState({wpcHandler: 'wpcFilterEverything'}, null, link);
                    }

                    // Chips
                    wpcReloadChips($response);

                    // Filters Widget
                    wpcReloadWidget(response, widgetClass);

                    wpcReloadSorting($response);

                    //trigger events
                    $(document).trigger( 'ready' );
                    $(window).trigger( 'scroll' );
                    $(window).trigger('resize');

                    wpcFixWoocommerceOrder();

                    let wpcPostsFound   = $response.find('.'+widgetClass).find('.wpc-posts-found').data('found');
                    wpcPostsFound       = parseFloat( wpcPostsFound );

                    if( ! wpcIsMobile && wpcAutoScroll && wpcPostsFound < wpcPostsPerPage[setId] ){
                        if( targetPostsContainer.length > 0 ){
                            $('body, html').animate({ scrollTop:$(targetPostsContainer).offset().top - wpcAutoScrollOffset });
                        }
                    }

                    // Reinit Elementor actions
                    if( typeof( elementorFrontend ) !== 'undefined' ){
                        $(targetPostsContainer+' .elementor-element').each(
                            function() {
                                elementorFrontend.elementsHandler.runReadyTrigger( $( this ) );
                            }
                        );
                    }

                }
            },

            error: function (response) {
                wpcHideSpinner();
                let $a_el = $(widget).find('.wpc-filters-apply-button');
                let oldLink = $a_el.data('href');
                $a_el.attr('href', oldLink);
            }
        });

    }

    function handleMetaTag( tagName, response )
    {

        let tagContent = $(response).find('meta[name="'+tagName+'"]').attr('content');
        if( typeof tagContent !== 'undefined' ){
            // Replace content if tag exists
            if( $('meta[name="'+tagName+'"]').length > 0 ){
                $('meta[name="'+tagName+'"]').attr('content', tagContent );
            } else {
                // Append meta tag
                $('head').append('<meta name="'+tagName+'" content="'+tagContent+'" />');
            }
        }else{
            if( $('meta[name="'+tagName+'"]').length > 0 ){
                $('meta[name="'+tagName+'"]').remove();
            }
        }
    }

    function wpcFixWoocommerceOrder() {
        $('.woocommerce-ordering').on('change', 'select.orderby', function () {
            $(this).closest('form').submit();
        });
    }

    function wpcReloadWidget( response, widgetClass ){
        // Replace parts
        let targetWidget = '.'+widgetClass;
        let $response    = $(response);
        // It seems we need to reload all widgets available on the page
        if( wpcIsMobile === true && (wpcFilterFront.showBottomWidget === 'yes') ){

            $(wpcWidgetContainer).each( function ( index, widget ){
                let widgetSet = $(widget).data('set');
                let widgetClass = '.wpc-filter-set-'+widgetSet;

                // .wpc-filters-scroll-container
                // .wpc-filters-widget-containers-wrapper
                let newWidget       = $response.find(widgetClass+' .wpc-filters-scroll-container');
                let newPostsFound   = $response.find(widgetClass+' .wpc-filters-found-posts');

                // Replace all filters and chips
                if( newWidget.length > 0 ){
                    $(widgetClass).find('.wpc-filters-scroll-container').replaceWith( newWidget );
                }
                // Replace found posts number
                if( newPostsFound.length > 0  ){
                    $(widgetClass).find('.wpc-filters-found-posts').replaceWith( newPostsFound );
                }
            });

        } else {
            $(wpcWidgetContainer).each( function ( index, widget ) {
                let widgetSet = $(widget).data('set');
                let widgetClass = '.wpc-filter-set-'+widgetSet;

                let newWidget = $response.find(widgetClass);
                if (newWidget.length > 0) {
                    $(widgetClass).replaceWith(newWidget);
                }
            });
        }
    }

    function wpcReloadSorting( $response ){
        let wpcSortingForms   = $response.find('.wpc-sorting-form');
        let originalSortingForms = $(".wpc-sorting-form");

        if( wpcSortingForms.length > 0 ){
            wpcSortingForms.each(function ( index, elem ){
                originalSortingForms[index].replaceWith(elem);
            });
        }
    }

    function wpcReloadChips( $response ){
        $(".wpc-filter-chips-list").each( function ( index, chipsWidget ) {
            let chipsSet            = $(chipsWidget).data('set');
            let chipsWidgetClass    = '.wpc-filter-chips-'+chipsSet;
            let newWidgets          = $response.find(chipsWidgetClass);

            $(chipsWidgetClass).each( function ( innerIndex, theChipsWidget ) {
                let $theChipsWidget = $(theChipsWidget);

                if (newWidgets.length > 0) {
                    $theChipsWidget.replaceWith(newWidgets[innerIndex]);
                }
            });

        });

        $(".wpc-chips-locked").removeClass("wpc-chips-locked");
    }

    window.addEventListener( 'popstate', function ( e ) {
        // @todo the last history step sometimes doesn't reload
        if( e.state !== null && e.state.hasOwnProperty('wpcHandler') ){
            if( e.state.wpcHandler === 'wpcFilterEverything' ){
                window.location.reload(true);
            }
        }
    });

    $.fn.tipTip = function(options) {
        var defaults = {
            activation: "hover",
            keepAlive: false,
            maxWidth: "200px",
            edgeOffset: 3,
            defaultPosition: "bottom",
            delay: 400,
            fadeIn: 200,
            fadeOut: 200,
            attribute: "title",
            content: false, // HTML or String to fill TipTIp with
            enter: function(){},
            exit: function(){}
        };
        var opts = $.extend(defaults, options);

        // Setup tip tip elements and render them to the DOM
        if($("#tiptip_holder").length <= 0){
            var tiptip_holder = $('<div id="tiptip_holder" style="max-width:'+ opts.maxWidth +';"></div>');
            var tiptip_content = $('<div id="tiptip_content"></div>');
            var tiptip_arrow = $('<div id="tiptip_arrow"></div>');
            $("body").append(tiptip_holder.html(tiptip_content).prepend(tiptip_arrow.html('<div id="tiptip_arrow_inner"></div>')));
        } else {
            var tiptip_holder = $("#tiptip_holder");
            var tiptip_content = $("#tiptip_content");
            var tiptip_arrow = $("#tiptip_arrow");
        }

        return this.each(function(){
            var org_elem = $(this);
            if(opts.content){
                var org_title = opts.content;
            } else {
                var org_title = org_elem.attr(opts.attribute);
            }
            if(org_title != ""){
                if(!opts.content){
                    org_elem.removeAttr(opts.attribute); //remove original Attribute
                }
                var timeout = false;

                if(opts.activation == "hover"){
                    org_elem.hover(function(){
                        active_tiptip();
                    }, function(){
                        if(!opts.keepAlive || !tiptip_holder.is(':hover')){
                            deactive_tiptip();
                        }
                    });
                    if(opts.keepAlive){
                        tiptip_holder.hover(function(){}, function(){
                            deactive_tiptip();
                        });
                    }
                } else if(opts.activation == "focus"){
                    org_elem.focus(function(){
                        active_tiptip();
                    }).blur(function(){
                        deactive_tiptip();
                    });
                } else if(opts.activation == "click"){
                    org_elem.click(function(){
                        active_tiptip();
                        return false;
                    }).hover(function(){},function(){
                        if(!opts.keepAlive){
                            deactive_tiptip();
                        }
                    });
                    if(opts.keepAlive){
                        tiptip_holder.hover(function(){}, function(){
                            deactive_tiptip();
                        });
                    }
                }

                function active_tiptip(){
                    opts.enter.call(this);
                    tiptip_content.html(org_title);
                    tiptip_holder.hide().removeAttr("class").css("margin","0");
                    tiptip_arrow.removeAttr("style");

                    var top = parseInt(org_elem.offset()['top']);
                    var left = parseInt(org_elem.offset()['left']);
                    var org_width = parseInt(org_elem.outerWidth());
                    var org_height = parseInt(org_elem.outerHeight());
                    var tip_w = tiptip_holder.outerWidth();
                    var tip_h = tiptip_holder.outerHeight();
                    var w_compare = Math.round((org_width - tip_w) / 2);
                    var h_compare = Math.round((org_height - tip_h) / 2);
                    var marg_left = Math.round(left + w_compare);
                    var marg_top = Math.round(top + org_height + opts.edgeOffset);
                    var t_class = "";
                    var arrow_top = "";
                    var arrow_left = Math.round(tip_w - 12) / 2;

                    if(opts.defaultPosition == "bottom"){
                        t_class = "_bottom";
                    } else if(opts.defaultPosition == "top"){
                        t_class = "_top";
                    } else if(opts.defaultPosition == "left"){
                        t_class = "_left";
                    } else if(opts.defaultPosition == "right"){
                        t_class = "_right";
                    }

                    var right_compare = (w_compare + left) < parseInt($(window).scrollLeft());
                    var left_compare = (tip_w + left) > parseInt($(window).width());

                    if((right_compare && w_compare < 0) || (t_class == "_right" && !left_compare) || (t_class == "_left" && left < (tip_w + opts.edgeOffset + 5))){
                        t_class = "_right";
                        arrow_top = Math.round(tip_h - 13) / 2;
                        arrow_left = -12;
                        marg_left = Math.round(left + org_width + opts.edgeOffset);
                        marg_top = Math.round(top + h_compare);
                    } else if((left_compare && w_compare < 0) || (t_class == "_left" && !right_compare)){
                        t_class = "_left";
                        arrow_top = Math.round(tip_h - 13) / 2;
                        arrow_left =  Math.round(tip_w);
                        marg_left = Math.round(left - (tip_w + opts.edgeOffset + 5));
                        marg_top = Math.round(top + h_compare);
                    }

                    var top_compare = (top + org_height + opts.edgeOffset + tip_h + 8) > parseInt($(window).height() + $(window).scrollTop());
                    var bottom_compare = ((top + org_height) - (opts.edgeOffset + tip_h + 8)) < 0;

                    if(top_compare || (t_class == "_bottom" && top_compare) || (t_class == "_top" && !bottom_compare)){
                        if(t_class == "_top" || t_class == "_bottom"){
                            t_class = "_top";
                        } else {
                            t_class = t_class+"_top";
                        }
                        arrow_top = tip_h;
                        marg_top = Math.round(top - (tip_h + 5 + opts.edgeOffset));
                    } else if(bottom_compare | (t_class == "_top" && bottom_compare) || (t_class == "_bottom" && !top_compare)){
                        if(t_class == "_top" || t_class == "_bottom"){
                            t_class = "_bottom";
                        } else {
                            t_class = t_class+"_bottom";
                        }
                        arrow_top = -12;
                        marg_top = Math.round(top + org_height + opts.edgeOffset);
                    }

                    if(t_class == "_right_top" || t_class == "_left_top"){
                        marg_top = marg_top + 5;
                    } else if(t_class == "_right_bottom" || t_class == "_left_bottom"){
                        marg_top = marg_top - 5;
                    }
                    if(t_class == "_left_top" || t_class == "_left_bottom"){
                        marg_left = marg_left + 5;
                    }
                    tiptip_arrow.css({"margin-left": arrow_left+"px", "margin-top": arrow_top+"px"});
                    tiptip_holder.css({"margin-left": marg_left+"px", "margin-top": marg_top+"px"}).attr("class","tip"+t_class);

                    if (timeout){ clearTimeout(timeout); }
                    timeout = setTimeout(function(){ tiptip_holder.stop(true,true).fadeIn(opts.fadeIn); }, opts.delay);
                }

                function deactive_tiptip(){
                    opts.exit.call(this);
                    if (timeout){ clearTimeout(timeout); }
                    tiptip_holder.fadeOut(opts.fadeOut);
                }
            }
        });
    }

})(jQuery);
/*!
 * Filter Everything seo rules admin 1.4.5
 */
(function($) {
    "use strict";

    let itemNum = wpcWidgets.wpcItemNum;
    //@todo fix Elementor
    //@todo Create minifined version
    $(document).ready(function (){
        // Sorting widget
        $(document).on('click', '.wpc-sorting-item-title', function (){
            $(this).parent('.wpc-sorting-item-top').toggleClass('wpc-opened');
        });

        $(document).on('click', '.wpc-sorting-item-remove', function (){

            let item        = $(this);
            let sorting     = item.parents('div.wpc-sorting-list');
            let wpcSortingItems = sorting.find('.wpc-sorting-item-wrapper');
            if( wpcSortingItems.length < 2 ){
                return;
            }

            let widget      = item.parents('div.widget');
            let inside      = widget.children('.widget-inside');
            let saveButton  = inside.find( '.widget-control-save' );
            let widgetId    = inside.find( '.widget-id' ).val();
            let toRemove    = item.parents('.wpc-sorting-item-wrapper');

            toRemove.remove();

            wpcSortingItemsOrder(sorting);

            window.wpWidgets.dirtyWidgets[ widgetId ] = true;
            widget.addClass( 'widget-dirty' );
            saveButton.prop( 'disabled', false ).val( wp.i18n.__( 'Save' ) );
        });

        $(document).on('change', '.wpc-orderby-select', function(e){
            let select       = $(this);
            let itemWrapper = select.parents('.wpc-sorting-item-inside');
            let metaKeyWrapper = itemWrapper.find('.wpc-sorting-item-meta-key-wrapper');

            if( select.val() === 'm' || select.val() === 'n' ){
                metaKeyWrapper.addClass('wpc-opened');
            }else{
                metaKeyWrapper.removeClass('wpc-opened');
            }

            return true;
        });

        $(document).on('input change', '.wpc-sorting-item-label', function (){
            let input       = $(this);
            let itemWrapper = input.parents('.wpc-sorting-item-wrapper');
            let itemParent  = itemWrapper.parents('.wpc-sorting-list'); //.find('.wpc-sorting-item-wrapper').length;
            let itemTitle   = itemWrapper.find('.wpc-sorting-item-title');

            if( input.val() === '' ){
                let itemCurPos = itemWrapper.index();
                itemTitle.text( itemTitle.data('title') + (itemCurPos + 1) );
            }else{
                cpaLiveWrite( input, itemTitle );
            }

        });

        $(document).on('widget-added widget-updated', function (){
            wpcMakeSortItemsSortable();
        });

        $(document).on('focus', '.wpc-sorting-item-label', function (){
            let currentVal = $(this).val();
            let wpcRegExp =  new RegExp("^" + itemNum + "[\\d]{1,100}$");
            let newVal = currentVal.replace(wpcRegExp, '');
            $(this).val(newVal);
        });

        $(document).on('click', '.wpc-add-sorting-item', function (e){
            e.preventDefault();
            let widgetContent = $(this).parents('.widget-content');
            let sortingList   = widgetContent.find('.wpc-sorting-list');
            let html          = widgetContent.find('.wpc-new-sorting-item').html();
            let $el           = $(html);
            let label         = $el.find('.wpc-sorting-item-title');
            let search        = 'wpc_new_id';
            let replace       = (sortingList.find('.wpc-sorting-item-wrapper').length + 1);

            let replaceAttr = function(i, value){
                return value.replace( search, replace );
            }

            $el.find('[id*="' + search + '"]').attr('id', replaceAttr);
            $el.find('[for*="' + search + '"]').attr('for', replaceAttr);
            $el.find('[name*="' + search + '"]').attr('name', replaceAttr);
            $el.find('[value*="' + search + '"]').attr('value', replaceAttr);
            //label.attr('data-title', replaceAttr);
            label.text(label.data('title') + replace);
            $el.attr('class', replaceAttr);
            $el.find('.wpc-sorting-item-top').addClass('wpc-opened');

            // Hack to make Save Button active
            $("input.wpc-ballast").trigger('change');

            sortingList.append($el);
        });

        // Elementor compatibility
        if( typeof elementor !== 'undefined'){
            elementor.hooks.addAction( 'panel/widgets/wp-widget-wpc_sorting_widget/controls/wp_widget/loaded', function( widget ) {
                // console.log( widget );
                // console.log( $( '.wpc-sorting-list' ) );

                setTimeout(function() {
                    // console.log( $( '.wpc-sorting-list' ) );
                    wpcMakeSortItemsSortable();
                    $("input.wpc-ballast").trigger('change');
                }, 500);
            } );
        }

        wpcMakeSortItemsSortable();
        // End Sorting widget
    });

    function wpcMakeSortItemsSortable(){

        $( '.wpc-sorting-list' ).sortable({
            items: "> div.wpc-sorting-item-wrapper",
            delay: 75,
            placeholder: "wpc-filter-item-shadow",
            refreshPositions: true,
            cursor: 'move',
            handle: ".wpc-sorting-item-handle",
            axis: 'y',
            update: function( event, ui ) {
                wpcSortingItemsOrder(ui.item.parent('.wpc-sorting-list'));
            },
            start: function ( event, ui ){
                let $this = ui.item,
                    head = ui.item.children('.wpc-sorting-item-top'),
                    wpcSortingItemHeight = (head.height() + 2);

                if (head.hasClass('wpc-opened') ) {
                    head.removeClass('wpc-opened')
                    $this.css('max-height', wpcSortingItemHeight + 'px');
                    $(this).sortable('refreshPositions');
                }
            },
            stop: function ( event, ui ){
                ui.item.css('max-height', 'none');
            }
        });
    }

    function cpaLiveWrite( readFrom, writeTo ) {
        writeTo.text(readFrom.val());
    }

    function wpcSortingItemsOrder( $el ){
        let sortingList = $el; //.parent('.wpc-sorting-list');
        let itemTitles  =  sortingList.find('.wpc-sorting-item-label');
        let titleVal    = '';
        let newTitleVal = '';
        let wpcRegExp =  new RegExp("^" + itemNum + "[\\d]{1,100}$");

        if( itemTitles.length > 0 ){
            itemTitles.each( function ( index, element ) {
                titleVal = $(element).val();
                newTitleVal = titleVal.replace(wpcRegExp, itemNum+(index+1) );
                $(element).val(newTitleVal)
                    .trigger('change');
            });
        }
    }

})(jQuery);
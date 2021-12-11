/**
 * StoreCustomizer Custom JS
 */
( function( $ ) {
    $( document ).ready( function () {

        // Show values for Range Inputs
        $(document).on('input change', 'input[type="range"]', function() {
            $(this).prev().find( '.wcz-rangeval' ).html( $(this).val() );
        });

        // Show / Hide Breadcrumbs
        wcz_wc_bcrumbs();
        $( '#customize-control-wcz-wc-remove-breadcrumbs input[type=checkbox]' ).on( 'change', function() {
            wcz_wc_bcrumbs();
        });
        function wcz_wc_bcrumbs() {
            if ( $( '#customize-control-wcz-wc-remove-breadcrumbs input[type=checkbox]' ).is( ':checked' ) ) {
                $( '#sub-accordion-section-wcz-panel-shop #customize-control-wcz-shop-remove-breadcrumbs' ).hide();
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-remove-product-breadcrumbs' ).hide();
            } else {
                $( '#sub-accordion-section-wcz-panel-shop #customize-control-wcz-shop-remove-breadcrumbs' ).show();
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-remove-product-breadcrumbs' ).show();
            }
        }

        // Show / Hide Product Per Row & Per Page
        wcz_wc_ppr_ppp();
        $( '#customize-control-wcz-shop-edit-pp input[type=checkbox]' ).on( 'change', function() {
            wcz_wc_ppr_ppp();
        });
        function wcz_wc_ppr_ppp() {
            if ( $( '#customize-control-wcz-shop-edit-pp input[type=checkbox]' ).is( ':checked' ) ) {
                $( '#sub-accordion-section-wcz-panel-shop #customize-control-wcz-shop-pppage' ).hide();
                $( '#sub-accordion-section-wcz-panel-shop #customize-control-wcz-shop-pprow' ).hide();
            } else {
                $( '#sub-accordion-section-wcz-panel-shop #customize-control-wcz-shop-pppage' ).show();
                $( '#sub-accordion-section-wcz-panel-shop #customize-control-wcz-shop-pprow' ).show();
            }
        }

        wcz_wc_btn_design();
        $( '#customize-control-wcz-wc-edit-btns input[type=checkbox], #customize-control-wcz-btn-style select' ).on( 'change', function() {
            wcz_wc_btn_design();
        });
        function wcz_wc_btn_design() {
            if ( $( '#customize-control-wcz-wc-edit-btns input[type=checkbox]' ).is( ':checked' ) ) {
                $( '#sub-accordion-section-wcz-panel-shop #customize-control-wcz-btn-style' ).show();
                $( '#sub-accordion-section-wcz-panel-shop #customize-control-wcz-btn-fsize' ).show();
                $( '#sub-accordion-section-wcz-panel-shop #customize-control-wcz-btn-fweight' ).show();
                $( '#sub-accordion-section-wcz-panel-shop #customize-control-wcz-btn-bgcolor' ).show();
                $( '#sub-accordion-section-wcz-panel-shop #customize-control-wcz-btn-fontcolor' ).show();
                $( '#sub-accordion-section-wcz-panel-shop #customize-control-wcz-btn-hovercolor' ).show();
                $( '#sub-accordion-section-wcz-panel-shop #customize-control-wcz-btn-fonthovercolor' ).show();
                $( '#sub-accordion-section-wcz-panel-shop #customize-control-wcz-btn-br' ).show();
                $( '#sub-accordion-section-wcz-panel-shop #customize-control-wcz-btn-padding' ).show();
            } else {
                $( '#sub-accordion-section-wcz-panel-shop #customize-control-wcz-btn-style' ).hide();
                $( '#sub-accordion-section-wcz-panel-shop #customize-control-wcz-btn-fsize' ).hide();
                $( '#sub-accordion-section-wcz-panel-shop #customize-control-wcz-btn-fweight' ).hide();
                $( '#sub-accordion-section-wcz-panel-shop #customize-control-wcz-btn-bgcolor' ).hide();
                $( '#sub-accordion-section-wcz-panel-shop #customize-control-wcz-btn-fontcolor' ).hide();
                $( '#sub-accordion-section-wcz-panel-shop #customize-control-wcz-btn-hovercolor' ).hide();
                $( '#sub-accordion-section-wcz-panel-shop #customize-control-wcz-btn-fonthovercolor' ).hide();
                $( '#sub-accordion-section-wcz-panel-shop #customize-control-wcz-btn-br' ).hide();
                $( '#sub-accordion-section-wcz-panel-shop #customize-control-wcz-btn-padding' ).hide();
            }
        }

        // Show / Hide Sale Banner Design Settings
        wcz_wc_sale_design();
        $( '#customize-control-wcz-wc-edit-sale input[type=checkbox]' ).on( 'change', function() {
            wcz_wc_sale_design();
        });
        function wcz_wc_sale_design() {
            if ( $( '#customize-control-wcz-wc-edit-sale input[type=checkbox]' ).is( ':checked' ) ) {
                $( '#sub-accordion-section-wcz-panel-shop #customize-control-wcz-sale-fsize' ).show();
                $( '#sub-accordion-section-wcz-panel-shop #customize-control-wcz-sale-fweight' ).show();
                $( '#sub-accordion-section-wcz-panel-shop #customize-control-wcz-sale-bgcolor' ).show();
                $( '#sub-accordion-section-wcz-panel-shop #customize-control-wcz-sale-br' ).show();
                $( '#sub-accordion-section-wcz-panel-shop #customize-control-wcz-sale-padding' ).show();
            } else {
                $( '#sub-accordion-section-wcz-panel-shop #customize-control-wcz-sale-fsize' ).hide();
                $( '#sub-accordion-section-wcz-panel-shop #customize-control-wcz-sale-fweight' ).hide();
                $( '#sub-accordion-section-wcz-panel-shop #customize-control-wcz-sale-bgcolor' ).hide();
                $( '#sub-accordion-section-wcz-panel-shop #customize-control-wcz-sale-br' ).hide();
                $( '#sub-accordion-section-wcz-panel-shop #customize-control-wcz-sale-padding' ).hide();
            }
        }

        // Show / Hide Product Title Design Settings
        wcz_wc_shoptitle_design();
        $( '#customize-control-wcz-wc-edit-shop-title input[type=checkbox]' ).on( 'change', function() {
            wcz_wc_shoptitle_design();
        });
        function wcz_wc_shoptitle_design() {
            if ( $( '#customize-control-wcz-wc-edit-shop-title input[type=checkbox]' ).is( ':checked' ) ) {
                $( '#sub-accordion-section-wcz-panel-shop #customize-control-wcz-shop-title-fsize' ).show();
                $( '#sub-accordion-section-wcz-panel-shop #customize-control-wcz-shop-title-fcolor' ).show();
            } else {
                $( '#sub-accordion-section-wcz-panel-shop #customize-control-wcz-shop-title-fsize' ).hide();
                $( '#sub-accordion-section-wcz-panel-shop #customize-control-wcz-shop-title-fcolor' ).hide();
            }
        }
        // Show / Hide Product Price Design Settings
        wcz_wc_shopprice_design();
        $( '#customize-control-wcz-wc-edit-shop-price input[type=checkbox]' ).on( 'change', function() {
            wcz_wc_shopprice_design();
        });
        function wcz_wc_shopprice_design() {
            if ( $( '#customize-control-wcz-wc-edit-shop-price input[type=checkbox]' ).is( ':checked' ) ) {
                $( '#sub-accordion-section-wcz-panel-shop #customize-control-wcz-shop-price-fsize' ).show();
                $( '#sub-accordion-section-wcz-panel-shop #customize-control-wcz-shop-price-fcolor' ).show();
            } else {
                $( '#sub-accordion-section-wcz-panel-shop #customize-control-wcz-shop-price-fsize' ).hide();
                $( '#sub-accordion-section-wcz-panel-shop #customize-control-wcz-shop-price-fcolor' ).hide();
            }
        }

        // Show / Hide Continue Shopping Design Settings
        wcz_wc_contshop_design();
        $( '#customize-control-wcz-wc-edit-contshop-btn input[type=checkbox]' ).on( 'change', function() {
            wcz_wc_contshop_design();
        });
        function wcz_wc_contshop_design() {
            if ( $( '#customize-control-wcz-wc-edit-contshop-btn input[type=checkbox]' ).is( ':checked' ) ) {
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-contshop-bgcolor' ).show();
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-contshop-hovercolor' ).show();
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-contshop-fsize' ).show();
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-contshop-pad' ).show();
            } else {
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-contshop-bgcolor' ).hide();
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-contshop-hovercolor' ).hide();
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-contshop-fsize' ).hide();
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-contshop-pad' ).hide();
            }
        }

        var wcz_loginout = $( '#customize-control-wcz-login-logout-menu select' ).val();
        wcz_loginout_value_check( wcz_loginout );
        $( '#customize-control-wcz-login-logout-menu select' ).on( 'change', function() {
            var wcz_loginout_value = $( this ).val();
            wcz_loginout_value_check( wcz_loginout_value );
        } );
        function wcz_loginout_value_check( wcz_loginout_value ) {
            if ( wcz_loginout_value == 'none' ) {
                $( '#sub-accordion-section-wcz-panel-woocustomizer #customize-control-wcz-login-redirect-page' ).hide();
                $( '#sub-accordion-section-wcz-panel-woocustomizer #customize-control-wcz-logout-redirect-page' ).hide();
                $( '#sub-accordion-section-wcz-panel-woocustomizer #customize-control-wcz-login-text' ).hide();
                $( '#sub-accordion-section-wcz-panel-woocustomizer #customize-control-wcz-login-item-url' ).hide();
                $( '#sub-accordion-section-wcz-panel-woocustomizer #customize-control-wcz-login-at-custom-url' ).hide();
                $( '#sub-accordion-section-wcz-panel-woocustomizer #customize-control-wcz-logout-text' ).hide();
            } else {
                $( '#sub-accordion-section-wcz-panel-woocustomizer #customize-control-wcz-login-redirect-page' ).show();
                $( '#sub-accordion-section-wcz-panel-woocustomizer #customize-control-wcz-logout-redirect-page' ).show();
                $( '#sub-accordion-section-wcz-panel-woocustomizer #customize-control-wcz-login-text' ).show();
                $( '#sub-accordion-section-wcz-panel-woocustomizer #customize-control-wcz-login-item-url' ).show();
                $( '#sub-accordion-section-wcz-panel-woocustomizer #customize-control-wcz-login-at-custom-url' ).show();
                $( '#sub-accordion-section-wcz-panel-woocustomizer #customize-control-wcz-logout-text' ).show();
            }
        }
        var wcz_loginoutcustom = $( '#customize-control-wcz-login-item-url select' ).val();
        wcz_loginoutcustom_value_check( wcz_loginoutcustom );
        $( '#customize-control-wcz-login-item-url select, #customize-control-wcz-login-logout-menu select' ).on( 'change', function() {
            var wcz_loginoutcustom_value = $( this ).val();
            wcz_loginoutcustom_value_check( wcz_loginoutcustom_value );
        } );
        function wcz_loginoutcustom_value_check( wcz_loginoutcustom_value ) {
            if ( $( '#customize-control-wcz-login-logout-menu select' ).val() != 'none' && wcz_loginoutcustom_value == 'custom' ) {
                $( '#sub-accordion-section-wcz-panel-woocustomizer #customize-control-wcz-login-at-custom-url' ).show();
            } else {
                $( '#sub-accordion-section-wcz-panel-woocustomizer #customize-control-wcz-login-at-custom-url' ).hide();
            }
        }

        // Show / Hide Pages Notice
        wcz_wc_main_notice();
        $( '#customize-control-wcz-wc-notice-banner input[type=checkbox]' ).on( 'change', function() {
            wcz_wc_main_notice();
        });
        function wcz_wc_main_notice() {
            if ( $( '#customize-control-wcz-wc-notice-banner input[type=checkbox]' ).is( ':checked' ) ) {
                $( '#sub-accordion-section-wcz-panel-woocustomizer #customize-control-wcz-wc-notice-title' ).show();
                $( '#sub-accordion-section-wcz-panel-woocustomizer #customize-control-wcz-wc-notice-text' ).show();
                $( '#sub-accordion-section-wcz-panel-woocustomizer #customize-control-wcz-wc-notice-banner-shop' ).show();
                $( '#sub-accordion-section-wcz-panel-woocustomizer #customize-control-wcz-wc-notice-banner-archives' ).show();
                $( '#sub-accordion-section-wcz-panel-woocustomizer #customize-control-wcz-wc-notice-banner-product' ).show();
                $( '#sub-accordion-section-wcz-panel-woocustomizer #customize-control-wcz-wc-notice-banner-cart' ).show();
                $( '#sub-accordion-section-wcz-panel-woocustomizer #customize-control-wcz-wc-notice-banner-checkout' ).show();
                $( '#sub-accordion-section-wcz-panel-woocustomizer #customize-control-wcz-wc-notice-design' ).show();
                wcz_wc_main_notice_design();
            } else {
                $( '#sub-accordion-section-wcz-panel-woocustomizer #customize-control-wcz-wc-notice-title' ).hide();
                $( '#sub-accordion-section-wcz-panel-woocustomizer #customize-control-wcz-wc-notice-text' ).hide();
                $( '#sub-accordion-section-wcz-panel-woocustomizer #customize-control-wcz-wc-notice-banner-shop' ).hide();
                $( '#sub-accordion-section-wcz-panel-woocustomizer #customize-control-wcz-wc-notice-banner-archives' ).hide();
                $( '#sub-accordion-section-wcz-panel-woocustomizer #customize-control-wcz-wc-notice-banner-product' ).hide();
                $( '#sub-accordion-section-wcz-panel-woocustomizer #customize-control-wcz-wc-notice-banner-cart' ).hide();
                $( '#sub-accordion-section-wcz-panel-woocustomizer #customize-control-wcz-wc-notice-banner-checkout' ).hide();
                $( '#sub-accordion-section-wcz-panel-woocustomizer #customize-control-wcz-wc-notice-design' ).hide();
                wcz_wc_main_notice_design();
            }
        }
        // Show / Hide Pages Notice Design
        wcz_wc_main_notice_design();
        $( '#customize-control-wcz-wc-notice-design input[type=checkbox]' ).on( 'change', function() {
            wcz_wc_main_notice_design();
        });
        function wcz_wc_main_notice_design() {
            if ( $( '#customize-control-wcz-wc-notice-banner input[type=checkbox]' ).is( ':checked' ) && $( '#customize-control-wcz-wc-notice-design input[type=checkbox]' ).is( ':checked' ) ) {
                $( '#sub-accordion-section-wcz-panel-woocustomizer #customize-control-wcz-wc-notice-style' ).show();
                $( '#sub-accordion-section-wcz-panel-woocustomizer #customize-control-wcz-wc-notice-color' ).show();
                $( '#sub-accordion-section-wcz-panel-woocustomizer #customize-control-wcz-wc-notice-margin' ).show();
                $( '#sub-accordion-section-wcz-panel-woocustomizer #customize-control-wcz-wc-notice-width' ).show();
                $( '#sub-accordion-section-wcz-panel-woocustomizer #customize-control-wcz-wc-notice-titlesize' ).show();
                $( '#sub-accordion-section-wcz-panel-woocustomizer #customize-control-wcz-wc-notice-textsize' ).show();
                $( '#sub-accordion-section-wcz-panel-woocustomizer #customize-control-wcz-wc-notice-center' ).show();
            } else {
                $( '#sub-accordion-section-wcz-panel-woocustomizer #customize-control-wcz-wc-notice-style' ).hide();
                $( '#sub-accordion-section-wcz-panel-woocustomizer #customize-control-wcz-wc-notice-color' ).hide();
                $( '#sub-accordion-section-wcz-panel-woocustomizer #customize-control-wcz-wc-notice-margin' ).hide();
                $( '#sub-accordion-section-wcz-panel-woocustomizer #customize-control-wcz-wc-notice-width' ).hide();
                $( '#sub-accordion-section-wcz-panel-woocustomizer #customize-control-wcz-wc-notice-titlesize' ).hide();
                $( '#sub-accordion-section-wcz-panel-woocustomizer #customize-control-wcz-wc-notice-textsize' ).hide();
                $( '#sub-accordion-section-wcz-panel-woocustomizer #customize-control-wcz-wc-notice-center' ).hide();
            }
        }

        // Show / Hide Sold Out Banner Text
        wcz_shop_soldout_banner();
        $( '#customize-control-wcz-shop-add-soldout input[type=checkbox]' ).on( 'change', function() {
            wcz_shop_soldout_banner();
        });
        function wcz_shop_soldout_banner() {
            if ( $( '#customize-control-wcz-shop-add-soldout input[type=checkbox]' ).is( ':checked' ) ) {
                $( '#sub-accordion-section-wcz-panel-shop #customize-control-wcz-shop-soldout-txt' ).show();
                $( '#sub-accordion-section-wcz-panel-shop #customize-control-wcz-soldout-style' ).show();
            } else {
                $( '#sub-accordion-section-wcz-panel-shop #customize-control-wcz-shop-soldout-txt' ).hide();
                $( '#sub-accordion-section-wcz-panel-shop #customize-control-wcz-soldout-style' ).hide();
            }
        }

        // Show / Hide Sold Out Banner Text
        wcz_shop_show_stock_amount();
        $( '#customize-control-wcz-shop-show-stock input[type=checkbox]' ).on( 'change', function() {
            wcz_shop_show_stock_amount();
        });
        function wcz_shop_show_stock_amount() {
            if ( $( '#customize-control-wcz-shop-show-stock input[type=checkbox]' ).is( ':checked' ) ) {
                $( '#sub-accordion-section-wcz-panel-shop #customize-control-wcz-shop-stock-lowamnt-txt' ).show();
                $( '#sub-accordion-section-wcz-panel-shop #customize-control-wcz-shop-stock-amnt-txt' ).show();
                $( '#sub-accordion-section-wcz-panel-shop #customize-control-wcz-shop-show-stock .customize-control-description' ).show();
            } else {
                $( '#sub-accordion-section-wcz-panel-shop #customize-control-wcz-shop-stock-lowamnt-txt' ).hide();
                $( '#sub-accordion-section-wcz-panel-shop #customize-control-wcz-shop-stock-amnt-txt' ).hide();
                $( '#sub-accordion-section-wcz-panel-shop #customize-control-wcz-shop-show-stock .customize-control-description' ).hide();
            }
        }
        
        // Show / Hide Product Status Texts
        wcz_product_stock_status_edit();
        $( '#customize-control-wcz-edit-stockstatus input[type=checkbox]' ).on( 'change', function() {
            wcz_product_stock_status_edit();
        });
        function wcz_product_stock_status_edit() {
            if ( $( '#customize-control-wcz-edit-stockstatus input[type=checkbox]' ).is( ':checked' ) ) {
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-product-outofstock-txt' ).show();
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-product-instock-txt' ).show();
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-product-onbackorder-txt' ).show();
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-always-show-stockstatus' ).show();
                wcz_product_status_always_edit();
            } else {
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-product-outofstock-txt' ).hide();
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-product-instock-txt' ).hide();
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-product-onbackorder-txt' ).hide();
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-always-show-stockstatus' ).hide();
                wcz_product_status_always_edit();
            }
        }
        // Show / Hide Product Status Texts
        wcz_product_status_always_edit();
        $( '#customize-control-wcz-always-show-stockstatus input[type=checkbox]' ).on( 'change', function() {
            wcz_product_status_always_edit();
        });
        function wcz_product_status_always_edit() {
            if ( $( '#customize-control-wcz-edit-stockstatus input[type=checkbox]' ).is( ':checked' ) && $( '#customize-control-wcz-always-show-stockstatus input[type=checkbox]' ).is( ':checked' ) ) {
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-product-instock-deaf-txt' ).show();
            } else {
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-product-instock-deaf-txt' ).hide();
            }
        }

        // Show / Hide Edit Button Texts
        wcz_shop_edit_btns();
        $( '#customize-control-wcz-shop-edit-btns input[type=checkbox]' ).on( 'change', function() {
            wcz_shop_edit_btns();
        });
        function wcz_shop_edit_btns() {
            if ( $( '#customize-control-wcz-shop-edit-btns input[type=checkbox]' ).is( ':checked' ) ) {
                $( '#sub-accordion-section-wcz-panel-shop #customize-control-wcz-shoplist-button-txt-simple' ).show();
                $( '#sub-accordion-section-wcz-panel-shop #customize-control-wcz-shop-button-txt-variable' ).show();
                $( '#sub-accordion-section-wcz-panel-shop #customize-control-wcz-shop-button-txt-grouped' ).show();
            } else {
                $( '#sub-accordion-section-wcz-panel-shop #customize-control-wcz-shoplist-button-txt-simple' ).hide();
                $( '#sub-accordion-section-wcz-panel-shop #customize-control-wcz-shop-button-txt-variable' ).hide();
                $( '#sub-accordion-section-wcz-panel-shop #customize-control-wcz-shop-button-txt-grouped' ).hide();
            }
        }

        // Show / Hide Product Continue Shopping Button Text
        wcz_product_shop_btn_design();
        $( '#customize-control-wcz-add-shop-button input[type=checkbox]' ).on( 'change', function() {
            wcz_product_shop_btn_design();
        });
        function wcz_product_shop_btn_design() {
            if ( $( '#customize-control-wcz-add-shop-button input[type=checkbox]' ).is( ':checked' ) ) {
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-add-shop-button-txt' ).show();
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-add-shop-button-url' ).show();
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-wc-edit-contshop-btn' ).show();
            } else {
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-add-shop-button-txt' ).hide();
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-add-shop-button-url' ).hide();
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-wc-edit-contshop-btn' ).hide();
            }
        }

        // Show / Hide Variable Product dropdown label
        wcz_var_product_ddl();
        $( '#customize-control-wcz-product-variable-ddo input[type=checkbox]' ).on( 'change', function() {
            wcz_var_product_ddl();
        });
        function wcz_var_product_ddl() {
            if ( $( '#customize-control-wcz-product-variable-ddo input[type=checkbox]' ).is( ':checked' ) ) {
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-product-variable-ddo-txt' ).show();
            } else {
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-product-variable-ddo-txt' ).hide();
            }
        }

        // Show / Hide Price Prefix
        wcz_product_price_prefix();
        $( '#customize-control-wcz-add-price-prefix input[type=checkbox]' ).on( 'change', function() {
            wcz_product_price_prefix();
        });
        function wcz_product_price_prefix() {
            if ( $( '#customize-control-wcz-add-price-prefix input[type=checkbox]' ).is( ':checked' ) ) {
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-add-price-prefix-txt' ).show();
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-add-price-prefix-shop' ).show();
                $( '#customize-control-wcz-add-price-prefix .customize-control-description' ).show();
            } else {
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-add-price-prefix-txt' ).hide();
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-add-price-prefix-shop' ).hide();
                $( '#customize-control-wcz-add-price-prefix .customize-control-description' ).hide();
            }
        }
        // Show / Hide Price Suffix
        wcz_product_price_suffix();
        $( '#customize-control-wcz-add-price-suffix input[type=checkbox]' ).on( 'change', function() {
            wcz_product_price_suffix();
        });
        function wcz_product_price_suffix() {
            if ( $( '#customize-control-wcz-add-price-suffix input[type=checkbox]' ).is( ':checked' ) ) {
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-add-price-suffix-txt' ).show();
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-add-price-suffix-shop' ).show();
                $( '#customize-control-wcz-add-price-suffix .customize-control-description' ).show();
            } else {
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-add-price-suffix-txt' ).hide();
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-add-price-suffix-shop' ).hide();
                $( '#customize-control-wcz-add-price-suffix .customize-control-description' ).hide();
            }
        }

        // Show / Hide Product Status Texts
        wcz_product_btn_text();
        $( '#customize-control-wcz-product-edit-btn input[type=checkbox]' ).on( 'change', function() {
            wcz_product_btn_text();
        });
        function wcz_product_btn_text() {
            if ( $( '#customize-control-wcz-product-edit-btn input[type=checkbox]' ).is( ':checked' ) ) {
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-product-button-txt-simple' ).show();
            } else {
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-product-button-txt-simple' ).hide();
            }
        }

        // Show / Hide New Product Badge details
        wcz_checkout_new_badge();
        $( '#customize-control-wcz-shop-new-badge input[type=checkbox]' ).on( 'change', function() {
            wcz_checkout_new_badge();
        });
        function wcz_checkout_new_badge() {
            if ( $( '#customize-control-wcz-shop-new-badge input[type=checkbox]' ).is( ':checked' ) ) {
                $( '#sub-accordion-section-wcz-panel-shop #customize-control-wcz-shop-new-product-days' ).show();
                $( '#sub-accordion-section-wcz-panel-shop #customize-control-wcz-shop-new-product-badge-text' ).show();
                $( '#sub-accordion-section-wcz-panel-shop #customize-control-wcz-shop-new-badge-pos' ).show();
                $( '#sub-accordion-section-wcz-panel-shop #customize-control-wcz-shop-new-badge-color' ).show();
            } else {
                $( '#sub-accordion-section-wcz-panel-shop #customize-control-wcz-shop-new-product-days' ).hide();
                $( '#sub-accordion-section-wcz-panel-shop #customize-control-wcz-shop-new-product-badge-text' ).hide();
                $( '#sub-accordion-section-wcz-panel-shop #customize-control-wcz-shop-new-badge-pos' ).hide();
                $( '#sub-accordion-section-wcz-panel-shop #customize-control-wcz-shop-new-badge-color' ).hide();
            }
        }

        // Show / Hide Product Amount Sold
        wcz_product_amount_sold();
        $( '#customize-control-wcz-product-show-unitsold input[type=checkbox]' ).on( 'change', function() {
            wcz_product_amount_sold();
        });
        function wcz_product_amount_sold() {
            if ( $( '#customize-control-wcz-product-show-unitsold input[type=checkbox]' ).is( ':checked' ) ) {
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-product-unitsold-txt' ).show();
            } else {
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-product-unitsold-txt' ).hide();
            }
        }

        // Radio Options for Product Page
        wcz_product_recomsection_tab();
        $( '#customize-control-wcz-wcproduct-recomm input[type=radio]' ).on( 'change', function() {
            wcz_product_recomsection_tab();
        });
        function wcz_product_recomsection_tab() {
            if ( $( '#customize-control-wcz-wcproduct-recomm input[type=radio]:checked' ).val() == 'wcz-wcproduct-recomm-edit' ) {
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-wcproduct-recomm-title' ).show();
            } else {
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-wcproduct-recomm-title' ).hide();
            }
        }

        wcz_product_relatedsection_tab();
        $( '#customize-control-wcz-wcproduct-related input[type=radio]' ).on( 'change', function() {
            wcz_product_relatedsection_tab();
        });
        function wcz_product_relatedsection_tab() {
            if ( $( '#customize-control-wcz-wcproduct-related input[type=radio]:checked' ).val() == 'wcz-wcproduct-related-edit' ) {
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-wcproduct-related-title' ).show();
            } else {
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-wcproduct-related-title' ).hide();
            }
        }

        wcz_cart_quantity_disable();
        $( '#customize-control-wcz-cart-disable-cart-quantity input[type=checkbox]' ).on( 'change', function() {
            wcz_cart_quantity_disable();
        });
        function wcz_cart_quantity_disable() {
            if ( $( '#customize-control-wcz-cart-disable-cart-quantity input[type=checkbox]' ).is( ':checked' ) ) {
                $( '#sub-accordion-section-wcz-panel-cart #customize-control-wcz-cart-ajax-update' ).hide();
            } else {
                $( '#sub-accordion-section-wcz-panel-cart #customize-control-wcz-cart-ajax-update' ).show();
            }
        }
        // Show / Hide Add To Cart Increment Values
        wcz_product_inc_values();
        $( '#customize-control-wcz-set-cart-increment-vals input[type=checkbox]' ).on( 'change', function() {
            wcz_product_inc_values();
        });
        function wcz_product_inc_values() {
            if ( $( '#customize-control-wcz-set-cart-increment-vals input[type=checkbox]' ).is( ':checked' ) ) {
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-set-cart-inc-min' ).show();
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-set-cart-inc-max' ).show();
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-set-cart-inc-by' ).show();
            } else {
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-set-cart-inc-min' ).hide();
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-set-cart-inc-max' ).hide();
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-set-cart-inc-by' ).hide();
            }
        }
        // Show / Hide Cart Product Info
        wcz_wccart_prodinfo_btn();
        $( '#customize-control-wcz-cart-add-product-info input[type=checkbox]' ).on( 'change', function() {
            wcz_wccart_prodinfo_btn();
        });
        function wcz_wccart_prodinfo_btn() {
            if ( $( '#customize-control-wcz-cart-add-product-info input[type=checkbox]' ).is( ':checked' ) ) {
                $( '#sub-accordion-section-wcz-panel-cart #customize-control-wcz-cart-add-productinfo-cats' ).show();
                $( '#sub-accordion-section-wcz-panel-cart #customize-control-wcz-cart-add-productinfo-atts' ).show();
                $( '#sub-accordion-section-wcz-panel-cart #customize-control-wcz-cart-add-productinfo-stock' ).show();
            } else {
                $( '#sub-accordion-section-wcz-panel-cart #customize-control-wcz-cart-add-productinfo-cats' ).hide();
                $( '#sub-accordion-section-wcz-panel-cart #customize-control-wcz-cart-add-productinfo-atts' ).hide();
                $( '#sub-accordion-section-wcz-panel-cart #customize-control-wcz-cart-add-productinfo-stock' ).hide();
            }
        }
        // Show / Hide Product Per Row & Per Page
        wcz_wccart_prodinfo_notice();
        $( '#customize-control-wcz-cart-add-productinfo-atts input[type=checkbox]' ).on( 'change', function() {
            wcz_wccart_prodinfo_notice();
        });
        function wcz_wccart_prodinfo_notice() {
            if ( $( '#customize-control-wcz-cart-add-product-info input[type=checkbox]' ).is( ':checked' ) && $( '#customize-control-wcz-cart-add-productinfo-atts input[type=checkbox]' ).is( ':checked' ) ) {
                $( '#sub-accordion-section-wcz-panel-cart #customize-control-wcz-cart-add-productinfo-atts .customize-control-description' ).show();
            } else {
                $( '#sub-accordion-section-wcz-panel-cart #customize-control-wcz-cart-add-productinfo-atts .customize-control-description' ).hide();
            }
        }
        // Show / Hide Cart Back To Shop Button
        wcz_wccart_bts_btn();
        $( '#customize-control-wcz-cart-bts-btn input[type=checkbox]' ).on( 'change', function() {
            wcz_wccart_bts_btn();
        });
        function wcz_wccart_bts_btn() {
            if ( $( '#customize-control-wcz-cart-bts-btn input[type=checkbox]' ).is( ':checked' ) ) {
                $( '#sub-accordion-section-wcz-panel-cart #customize-control-wcz-cart-bts-pos' ).show();
                $( '#sub-accordion-section-wcz-panel-cart #customize-control-wcz-cart-bts-txt' ).show();
                $( '#sub-accordion-section-wcz-panel-cart #customize-control-wcz-cart-bts-type' ).show();
                $( '#sub-accordion-section-wcz-panel-cart #customize-control-wcz-cart-bts-url' ).show();
                $( '#sub-accordion-section-wcz-panel-cart #customize-control-wcz-cart-bts-color' ).show();
                $( '#sub-accordion-section-wcz-panel-cart #customize-control-wcz-cart-bts-fcolor' ).show();
                $( '#sub-accordion-section-wcz-panel-cart #customize-control-wcz-cart-bts-hcolor' ).show();
                $( '#sub-accordion-section-wcz-panel-cart #customize-control-wcz-cart-bts-hfcolor' ).show();
                $( '#sub-accordion-section-wcz-panel-cart #customize-control-wcz-cart-bts-align' ).show();
                wcz_wccart_bts_type();
            } else {
                $( '#sub-accordion-section-wcz-panel-cart #customize-control-wcz-cart-bts-pos' ).hide();
                $( '#sub-accordion-section-wcz-panel-cart #customize-control-wcz-cart-bts-txt' ).hide();
                $( '#sub-accordion-section-wcz-panel-cart #customize-control-wcz-cart-bts-type' ).hide();
                $( '#sub-accordion-section-wcz-panel-cart #customize-control-wcz-cart-bts-url' ).hide();
                $( '#sub-accordion-section-wcz-panel-cart #customize-control-wcz-cart-bts-color' ).hide();
                $( '#sub-accordion-section-wcz-panel-cart #customize-control-wcz-cart-bts-fcolor' ).hide();
                $( '#sub-accordion-section-wcz-panel-cart #customize-control-wcz-cart-bts-hcolor' ).hide();
                $( '#sub-accordion-section-wcz-panel-cart #customize-control-wcz-cart-bts-hfcolor' ).hide();
                $( '#sub-accordion-section-wcz-panel-cart #customize-control-wcz-cart-bts-align' ).hide();
                wcz_wccart_bts_type();
            }
        }
        // Show/hide back button type
        wcz_wccart_bts_type();
        $( '#customize-control-wcz-cart-bts-type select' ).on( 'change', function() {
            wcz_wccart_bts_type();
        });
        function wcz_wccart_bts_type() {
            if ( $( '#customize-control-wcz-cart-bts-btn input[type=checkbox]' ).is( ':checked' ) && $( '#customize-control-wcz-cart-bts-type select' ).val() == 'custom' ) {
                $( '#sub-accordion-section-wcz-panel-cart #customize-control-wcz-cart-bts-url' ).show();
            } else {
                $( '#sub-accordion-section-wcz-panel-cart #customize-control-wcz-cart-bts-url' ).hide();
            }
        }

        // Show / Hide Product Page Title Design Settings
        wcz_wc_producttitle_design();
        $( '#customize-control-wcz-wc-edit-product-title input[type=checkbox]' ).on( 'change', function() {
            wcz_wc_producttitle_design();
        });
        function wcz_wc_producttitle_design() {
            if ( $( '#customize-control-wcz-wc-edit-product-title input[type=checkbox]' ).is( ':checked' ) ) {
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-product-title-fsize' ).show();
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-product-title-fcolor' ).show();
            } else {
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-product-title-fsize' ).hide();
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-product-title-fcolor' ).hide();
            }
        }
        // Show / Hide Product Page Price Design Settings
        wcz_wc_productprice_design();
        $( '#customize-control-wcz-wc-edit-product-price input[type=checkbox]' ).on( 'change', function() {
            wcz_wc_productprice_design();
        });
        function wcz_wc_productprice_design() {
            if ( $( '#customize-control-wcz-wc-edit-product-price input[type=checkbox]' ).is( ':checked' ) ) {
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-product-price-fsize' ).show();
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-product-price-fcolor' ).show();
            } else {
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-product-price-fsize' ).hide();
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-product-price-fcolor' ).hide();
            }
        }
        // Show / Hide Product Page Button Design Settings
        wcz_wc_productbtn_design();
        $( '#customize-control-wcz-wc-edit-prodbtn-color input[type=checkbox]' ).on( 'change', function() {
            wcz_wc_productbtn_design();
        });
        function wcz_wc_productbtn_design() {
            if ( $( '#customize-control-wcz-wc-edit-prodbtn-color input[type=checkbox]' ).is( ':checked' ) ) {
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-prodbtn-bgcolor' ).show();
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-prodbtn-fontcolor' ).show();
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-prodbtn-hovercolor' ).show();
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-prodbtn-fonthovercolor' ).show();
            } else {
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-prodbtn-bgcolor' ).hide();
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-prodbtn-fontcolor' ).hide();
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-prodbtn-hovercolor' ).hide();
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-prodbtn-fonthovercolor' ).hide();
            }
        }

        // Product Page Tabs
        wcz_product_desc_tab();
        $( '#customize-control-wcz-wcproduct-desc-tab input[type=radio]' ).on( 'change', function() {
            wcz_product_desc_tab();
        });
        function wcz_product_desc_tab() {
            if ( $( '#customize-control-wcz-wcproduct-desc-tab input[type=radio]:checked' ).val() == 'wcz-wcproduct-desc-tab-edit' ) {
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-wcproduct-desc-tab-title' ).show();
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-wcproduct-desc-head' ).show();
            } else {
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-wcproduct-desc-tab-title' ).hide();
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-wcproduct-desc-head' ).hide();
            }
        }

        wcz_product_addinfo_tab();
        $( '#customize-control-wcz-wcproduct-addinfo-tab input[type=radio]' ).on( 'change', function() {
            wcz_product_addinfo_tab();
        });
        function wcz_product_addinfo_tab() {
            if ( $( '#customize-control-wcz-wcproduct-addinfo-tab input[type=radio]:checked' ).val() == 'wcz-wcproduct-addinfo-tab-edit' ) {
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-wcproduct-addinfo-tab-title' ).show();
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-wcproduct-addinfo-head' ).show();
            } else {
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-wcproduct-addinfo-tab-title' ).hide();
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-wcproduct-addinfo-head' ).hide();
            }
        }

        wcz_product_reviews_tab();
        $( '#customize-control-wcz-wcproduct-reviews-tab input[type=radio]' ).on( 'change', function() {
            wcz_product_reviews_tab();
        });
        function wcz_product_reviews_tab() {
            if ( $( '#customize-control-wcz-wcproduct-reviews-tab input[type=radio]:checked' ).val() == 'wcz-wcproduct-reviews-tab-edit' ) {
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-wcproduct-reviews-tab-title' ).show();
            } else {
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-wcproduct-reviews-tab-title' ).hide();
            }
        }

        wcz_product_longdesc_add();
        $( '#customize-control-wcz-add-product-long-desc input[type=checkbox]' ).on( 'change', function() {
            wcz_product_longdesc_add();
        });
        function wcz_product_longdesc_add() {
            if ( $( '#customize-control-wcz-add-product-long-desc input[type=checkbox]' ).is( ':checked' ) ) {
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-longdesc-divider' ).show();
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-longdesc-maxwidth' ).show();
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-longdesc-center' ).show();
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-longdesc-top' ).show();
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-longdesc-bottom' ).show();
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-longdesc-botdiv' ).show();
            } else {
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-longdesc-divider' ).hide();
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-longdesc-maxwidth' ).hide();
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-longdesc-center' ).hide();
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-longdesc-top' ).hide();
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-longdesc-bottom' ).hide();
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-longdesc-botdiv' ).hide();
            }
        }
        wcz_product_reviews_add();
        $( '#customize-control-wcz-add-product-reviews input[type=checkbox]' ).on( 'change', function() {
            wcz_product_reviews_add();
        });
        function wcz_product_reviews_add() {
            if ( $( '#customize-control-wcz-add-product-reviews input[type=checkbox]' ).is( ':checked' ) ) {
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-reviews-divider' ).show();
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-reviews-maxwidth' ).show();
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-reviews-top' ).show();
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-reviews-bottom' ).show();
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-reviews-botdiv' ).show();
            } else {
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-reviews-divider' ).hide();
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-reviews-maxwidth' ).hide();
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-reviews-top' ).hide();
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-reviews-bottom' ).hide();
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-reviews-botdiv' ).hide();
            }
        }
        wcz_product_addinfo_add();
        $( '#customize-control-wcz-add-product-addinfo input[type=checkbox]' ).on( 'change', function() {
            wcz_product_addinfo_add();
        });
        function wcz_product_addinfo_add() {
            if ( $( '#customize-control-wcz-add-product-addinfo input[type=checkbox]' ).is( ':checked' ) ) {
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-addinfo-divider' ).show();
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-addinfo-maxwidth' ).show();
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-addinfo-top' ).show();
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-addinfo-bottom' ).show();
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-addinfo-botdiv' ).show();
            } else {
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-addinfo-divider' ).hide();
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-addinfo-maxwidth' ).hide();
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-addinfo-top' ).hide();
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-addinfo-bottom' ).hide();
                $( '#sub-accordion-section-wcz-panel-product #customize-control-wcz-addinfo-botdiv' ).hide();
            }
        }

        // Radio Options for Account Page - Dashboard Tab
        wcz_account_dashboard_tab();
        $( '#customize-control-wcz-account-dashboard-tab input[type=radio]' ).on( 'change', function() {
            wcz_account_dashboard_tab();
        });
        function wcz_account_dashboard_tab() {
            if ( $( '#customize-control-wcz-account-dashboard-tab input[type=radio]:checked' ).val() == 'wcz-account-dashboard-edit' ) {
                $( '#sub-accordion-section-wcz-panel-account #customize-control-wcz-account-tab-dash-tab' ).show();
                $( '#sub-accordion-section-wcz-panel-account #customize-control-wcz-account-dashboard-content' ).show();

                var wcz_accdash_cont = $( '#customize-control-wcz-account-dashboard-content select' ).val();
                wcz_accdashcont_value_check( wcz_accdash_cont );
            } else {
                $( '#sub-accordion-section-wcz-panel-account #customize-control-wcz-account-tab-dash-tab' ).hide();
                $( '#sub-accordion-section-wcz-panel-account #customize-control-wcz-account-dashboard-content' ).hide();

                var wcz_accdash_cont = $( '#customize-control-wcz-account-dashboard-content select' ).val();
                wcz_accdashcont_value_check( wcz_accdash_cont );
            }
        }

        var wcz_accdashcont = $( '#customize-control-wcz-account-dashboard-content select' ).val();
        wcz_accdashcont_value_check( wcz_accdashcont );
        $( '#customize-control-wcz-account-dashboard-content select' ).on( 'change', function() {
            var wcz_accdashcont_value = $( this ).val();
            wcz_accdashcont_value_check( wcz_accdashcont_value );
        } );
        function wcz_accdashcont_value_check( wcz_accdashcont_value ) {
            if ( $( '#customize-control-wcz-account-dashboard-tab input[type=radio]:checked' ).val() == 'wcz-account-dashboard-edit' && wcz_accdashcont_value == 'wcz-accdash-content-page' ) {
                $( '#sub-accordion-section-wcz-panel-account #customize-control-wcz-accdash-text' ).hide();
                $( '#sub-accordion-section-wcz-panel-account #customize-control-wcz-accdash-page' ).show();
                $( '#sub-accordion-section-wcz-panel-account #customize-control-wcz-account-dont-note' ).show();
                $( '#sub-accordion-section-wcz-panel-account #customize-control-wcz-accdash-remdefault' ).show();
            } else if ( $( '#customize-control-wcz-account-dashboard-tab input[type=radio]:checked' ).val() == 'wcz-account-dashboard-edit' && wcz_accdashcont_value == 'wcz-accdash-content-text' ) {
                $( '#sub-accordion-section-wcz-panel-account #customize-control-wcz-account-dont-note' ).hide();
                $( '#sub-accordion-section-wcz-panel-account #customize-control-wcz-accdash-page' ).hide();
                $( '#sub-accordion-section-wcz-panel-account #customize-control-wcz-accdash-text' ).show();
                $( '#sub-accordion-section-wcz-panel-account #customize-control-wcz-accdash-remdefault' ).show();
            } else {
                $( '#sub-accordion-section-wcz-panel-account #customize-control-wcz-accdash-text' ).hide();
                $( '#sub-accordion-section-wcz-panel-account #customize-control-wcz-account-dont-note' ).hide();
                $( '#sub-accordion-section-wcz-panel-account #customize-control-wcz-accdash-page' ).hide();
                $( '#sub-accordion-section-wcz-panel-account #customize-control-wcz-accdash-remdefault' ).hide();
            }
        }

        // Orders Tab
        wcz_account_orders_tab();
        $( '#customize-control-wcz-account-orders-tab input[type=radio]' ).on( 'change', function() {
            wcz_account_orders_tab();
        });
        function wcz_account_orders_tab() {
            if ( $( '#customize-control-wcz-account-orders-tab input[type=radio]:checked' ).val() == 'wcz-account-orders-edit' ) {
                $( '#sub-accordion-section-wcz-panel-account #customize-control-wcz-account-tab-orders-tab' ).show();
                $( '#sub-accordion-section-wcz-panel-account #customize-control-wcz-account-tab-orders-title' ).show();
            } else {
                $( '#sub-accordion-section-wcz-panel-account #customize-control-wcz-account-tab-orders-tab' ).hide();
                $( '#sub-accordion-section-wcz-panel-account #customize-control-wcz-account-tab-orders-title' ).hide();
            }
        }

        // Downloads Tab
        wcz_account_downloads_tab();
        $( '#customize-control-wcz-account-downloads-tab input[type=radio]' ).on( 'change', function() {
            wcz_account_downloads_tab();
        });
        function wcz_account_downloads_tab() {
            if ( $( '#customize-control-wcz-account-downloads-tab input[type=radio]:checked' ).val() == 'wcz-account-downloads-edit' ) {
                $( '#sub-accordion-section-wcz-panel-account #customize-control-wcz-account-tab-downloads-tab' ).show();
                $( '#sub-accordion-section-wcz-panel-account #customize-control-wcz-account-tab-downloads-title' ).show();
            } else {
                $( '#sub-accordion-section-wcz-panel-account #customize-control-wcz-account-tab-downloads-tab' ).hide();
                $( '#sub-accordion-section-wcz-panel-account #customize-control-wcz-account-tab-downloads-title' ).hide();
            }
        }

        // Address Tab
        wcz_account_address_tab();
        $( '#customize-control-wcz-account-address-tab input[type=radio]' ).on( 'change', function() {
            wcz_account_address_tab();
        });
        function wcz_account_address_tab() {
            if ( $( '#customize-control-wcz-account-address-tab input[type=radio]:checked' ).val() == 'wcz-account-address-edit' ) {
                $( '#sub-accordion-section-wcz-panel-account #customize-control-wcz-account-tab-address-tab' ).show();
                $( '#sub-accordion-section-wcz-panel-account #customize-control-wcz-account-tab-address-title' ).show();
            } else {
                $( '#sub-accordion-section-wcz-panel-account #customize-control-wcz-account-tab-address-tab' ).hide();
                $( '#sub-accordion-section-wcz-panel-account #customize-control-wcz-account-tab-address-title' ).hide();
            }
        }

        // Account Details Tab
        wcz_account_details_tab();
        $( '#customize-control-wcz-account-details-tab input[type=radio]' ).on( 'change', function() {
            wcz_account_details_tab();
        });
        function wcz_account_details_tab() {
            if ( $( '#customize-control-wcz-account-details-tab input[type=radio]:checked' ).val() == 'wcz-account-details-edit' ) {
                $( '#sub-accordion-section-wcz-panel-account #customize-control-wcz-account-tab-details-tab' ).show();
                $( '#sub-accordion-section-wcz-panel-account #customize-control-wcz-account-tab-details-title' ).show();
            } else {
                $( '#sub-accordion-section-wcz-panel-account #customize-control-wcz-account-tab-details-tab' ).hide();
                $( '#sub-accordion-section-wcz-panel-account #customize-control-wcz-account-tab-details-title' ).hide();
            }
        }

        // Logout Tab
        wcz_account_logout_tab();
        $( '#customize-control-wcz-account-logout-tab input[name=_customize-radio-wcz-account-logout-tab]' ).on( 'change', function() {
            wcz_account_logout_tab();
        });
        function wcz_account_logout_tab() {
            if ( $( '#customize-control-wcz-account-logout-tab input[name=_customize-radio-wcz-account-logout-tab]:checked' ).val() == 'wcz-account-logout-edit' ) {
                $( '#sub-accordion-section-wcz-panel-account #customize-control-wcz-account-tab-logout-tab' ).show();
            } else {
                $( '#sub-accordion-section-wcz-panel-account #customize-control-wcz-account-tab-logout-tab' ).hide();
            }
        }

        // New Custom Tab - One
        wcz_account_custom_tab_one();
        $( '#customize-control-wcz-accendpoint-one input[type=checkbox]' ).on( 'change', function() {
            wcz_account_custom_tab_one();
        });
        function wcz_account_custom_tab_one() {
            if ( $( '#customize-control-wcz-accendpoint-one input[type=checkbox]' ).is( ':checked' ) ) {
                $( '#sub-accordion-section-wcz-panel-account #customize-control-wcz-account-tab-one-tab' ).show();
                $( '#sub-accordion-section-wcz-panel-account #customize-control-wcz-account-tab-one-title' ).show();
                $( '#sub-accordion-section-wcz-panel-account #customize-control-wcz-account-tab-one-pageid' ).show();
                $( '#customize-control-wcz-accendpoint-one .customize-control-description' ).show();
            } else {
                $( '#sub-accordion-section-wcz-panel-account #customize-control-wcz-account-tab-one-tab' ).hide();
                $( '#sub-accordion-section-wcz-panel-account #customize-control-wcz-account-tab-one-title' ).hide();
                $( '#sub-accordion-section-wcz-panel-account #customize-control-wcz-account-tab-one-pageid' ).hide();
                $( '#customize-control-wcz-accendpoint-one .customize-control-description' ).hide();
            }
        }

        // New Custom Tab - Two
        wcz_account_custom_tab_two();
        $( '#customize-control-wcz-accendpoint-two input[type=checkbox]' ).on( 'change', function() {
            wcz_account_custom_tab_two();
        });
        function wcz_account_custom_tab_two() {
            if ( $( '#customize-control-wcz-accendpoint-two input[type=checkbox]' ).is( ':checked' ) ) {
                $( '#sub-accordion-section-wcz-panel-account #customize-control-wcz-account-tab-two-tab' ).show();
                $( '#sub-accordion-section-wcz-panel-account #customize-control-wcz-account-tab-two-title' ).show();
                $( '#sub-accordion-section-wcz-panel-account #customize-control-wcz-account-tab-two-pageid' ).show();
                $( '#customize-control-wcz-accendpoint-two .customize-control-description' ).show();
            } else {
                $( '#sub-accordion-section-wcz-panel-account #customize-control-wcz-account-tab-two-tab' ).hide();
                $( '#sub-accordion-section-wcz-panel-account #customize-control-wcz-account-tab-two-title' ).hide();
                $( '#sub-accordion-section-wcz-panel-account #customize-control-wcz-account-tab-two-pageid' ).hide();
                $( '#customize-control-wcz-accendpoint-two .customize-control-description' ).hide();
            }
        }
        
        // New Custom Tab - Three
        wcz_account_custom_tab_three();
        $( '#customize-control-wcz-accendpoint-three input[type=checkbox]' ).on( 'change', function() {
            wcz_account_custom_tab_three();
        });
        function wcz_account_custom_tab_three() {
            if ( $( '#customize-control-wcz-accendpoint-three input[type=checkbox]' ).is( ':checked' ) ) {
                $( '#sub-accordion-section-wcz-panel-account #customize-control-wcz-account-tab-three-tab' ).show();
                $( '#sub-accordion-section-wcz-panel-account #customize-control-wcz-account-tab-three-title' ).show();
                $( '#sub-accordion-section-wcz-panel-account #customize-control-wcz-account-tab-three-pageid' ).show();
                $( '#customize-control-wcz-accendpoint-three .customize-control-description' ).show();
            } else {
                $( '#sub-accordion-section-wcz-panel-account #customize-control-wcz-account-tab-three-tab' ).hide();
                $( '#sub-accordion-section-wcz-panel-account #customize-control-wcz-account-tab-three-title' ).hide();
                $( '#sub-accordion-section-wcz-panel-account #customize-control-wcz-account-tab-three-pageid' ).hide();
                $( '#customize-control-wcz-accendpoint-three .customize-control-description' ).hide();
            }
        }

        // New Custom Tab - Four
        wcz_account_custom_tab_four();
        $( '#customize-control-wcz-accendpoint-four input[type=checkbox]' ).on( 'change', function() {
            wcz_account_custom_tab_four();
        });
        function wcz_account_custom_tab_four() {
            if ( $( '#customize-control-wcz-accendpoint-four input[type=checkbox]' ).is( ':checked' ) ) {
                $( '#sub-accordion-section-wcz-panel-account #customize-control-wcz-account-tab-four-tab' ).show();
                $( '#sub-accordion-section-wcz-panel-account #customize-control-wcz-account-tab-four-title' ).show();
                $( '#sub-accordion-section-wcz-panel-account #customize-control-wcz-account-tab-four-pageid' ).show();
                $( '#customize-control-wcz-accendpoint-four .customize-control-description' ).show();
            } else {
                $( '#sub-accordion-section-wcz-panel-account #customize-control-wcz-account-tab-four-tab' ).hide();
                $( '#sub-accordion-section-wcz-panel-account #customize-control-wcz-account-tab-four-title' ).hide();
                $( '#sub-accordion-section-wcz-panel-account #customize-control-wcz-account-tab-four-pageid' ).hide();
                $( '#customize-control-wcz-accendpoint-four .customize-control-description' ).hide();
            }
        }

        // Show / Hide Add Custom Empty Cart Text
        wcz_empty_cart_txt();
        $( '#customize-control-wcz-cart-add-custom-text input[type=checkbox]' ).on( 'change', function() {
            wcz_empty_cart_txt();
        });
        function wcz_empty_cart_txt() {
            if ( $( '#customize-control-wcz-cart-add-custom-text input[type=checkbox]' ).is( ':checked' ) ) {
                $( '#sub-accordion-section-wcz-panel-cart #customize-control-wcz-cart-empty-txt' ).show();
            } else {
                $( '#sub-accordion-section-wcz-panel-cart #customize-control-wcz-cart-empty-txt' ).hide();
            }
        }
        // Show / Hide Empty Cart button text & url
        wcz_cart_edit_rts_btn();
        $( '#customize-control-wcz-cart-edit-rts input[type=checkbox]' ).on( 'change', function() {
            wcz_cart_edit_rts_btn();
        });
        function wcz_cart_edit_rts_btn() {
            if ( $( '#customize-control-wcz-cart-edit-rts input[type=checkbox]' ).is( ':checked' ) ) {
                $( '#sub-accordion-section-wcz-panel-cart #customize-control-wcz-cart-edit-rts-text' ).show();
                $( '#sub-accordion-section-wcz-panel-cart #customize-control-wcz-cart-edit-rts-page' ).show();
            } else {
                $( '#sub-accordion-section-wcz-panel-cart #customize-control-wcz-cart-edit-rts-text' ).hide();
                $( '#sub-accordion-section-wcz-panel-cart #customize-control-wcz-cart-edit-rts-page' ).hide();
            }
        }
        
        // Show / Hide Edit Coupon Text
        wcz_checkout_edit_coupon();
        $( '#customize-control-wcz-checkout-edit-coupon-txt input[type=checkbox]' ).on( 'change', function() {
            wcz_checkout_edit_coupon();
        });
        function wcz_checkout_edit_coupon() {
            if ( $( '#customize-control-wcz-checkout-edit-coupon-txt input[type=checkbox]' ).is( ':checked' ) ) {
                $( '#sub-accordion-section-wcz-panel-checkout #customize-control-wcz-checkout-coupon-text' ).show();
                $( '#sub-accordion-section-wcz-panel-checkout #customize-control-wcz-checkout-coupon-link-text' ).show();
                $( '#sub-accordion-section-wcz-panel-checkout #customize-control-wcz-checkout-coupon-instruction-text' ).show();
            } else {
                $( '#sub-accordion-section-wcz-panel-checkout #customize-control-wcz-checkout-coupon-text' ).hide();
                $( '#sub-accordion-section-wcz-panel-checkout #customize-control-wcz-checkout-coupon-link-text' ).hide();
                $( '#sub-accordion-section-wcz-panel-checkout #customize-control-wcz-checkout-coupon-instruction-text' ).hide();
            }
        }
        // Show / Hide Edit Order Notes Text
        wcz_checkout_edit_ordernotes();
        $( '#customize-control-wcz-checkout-edit-ordernotes-txt input[type=checkbox]' ).on( 'change', function() {
            wcz_checkout_edit_ordernotes();
        });
        function wcz_checkout_edit_ordernotes() {
            if ( $( '#customize-control-wcz-checkout-edit-ordernotes-txt input[type=checkbox]' ).is( ':checked' ) ) {
                $( '#sub-accordion-section-wcz-panel-checkout #customize-control-wcz-checkout-ordernotes-label' ).show();
                $( '#sub-accordion-section-wcz-panel-checkout #customize-control-wcz-checkout-ordernotes-placeholder' ).show();
            } else {
                $( '#sub-accordion-section-wcz-panel-checkout #customize-control-wcz-checkout-ordernotes-label' ).hide();
                $( '#sub-accordion-section-wcz-panel-checkout #customize-control-wcz-checkout-ordernotes-placeholder' ).hide();
            }
        }

        // Show / Hide
        wcz_checkout_po_txt();
        $( '#customize-control-wcz-checkout-add-po-txt input[type=checkbox]' ).on( 'change', function() {
            wcz_checkout_po_txt();
        });
        function wcz_checkout_po_txt() {
            if ( $( '#customize-control-wcz-checkout-add-po-txt input[type=checkbox]' ).is( ':checked' ) ) {
                $( '#sub-accordion-section-wcz-panel-checkout #customize-control-wcz-checkout-po-txt' ).show();
            } else {
                $( '#sub-accordion-section-wcz-panel-checkout #customize-control-wcz-checkout-po-txt' ).hide();
            }
        }

        // Show / Hide checkpout image
        wcz_checkout_secureimage();
        $( '#customize-control-wcz-checkout-add-img input[type=checkbox]' ).on( 'change', function() {
            wcz_checkout_secureimage();
        });
        function wcz_checkout_secureimage() {
            if ( $( '#customize-control-wcz-checkout-add-img input[type=checkbox]' ).is( ':checked' ) ) {
                $( '#sub-accordion-section-wcz-panel-checkout #customize-control-wcz-checkout-img' ).show();
                $( '#sub-accordion-section-wcz-panel-checkout #customize-control-wcz-checkout-img-center' ).show();
            } else {
                $( '#sub-accordion-section-wcz-panel-checkout #customize-control-wcz-checkout-img' ).hide();
                $( '#sub-accordion-section-wcz-panel-checkout #customize-control-wcz-checkout-img-center' ).hide();
            }
        }

        // Show / Hide Direct Checkout Settings
        wcz_direct_checkout();
        $( '#customize-control-wcz-direct-checkout input[type=checkbox]' ).on( 'change', function() {
            wcz_direct_checkout();
        });
        function wcz_direct_checkout() {
            if ( $( '#customize-control-wcz-direct-checkout input[type=checkbox]' ).is( ':checked' ) ) {
                $( '#sub-accordion-section-wcz-panel-checkout #customize-control-wcz-direct-checkout .customize-control-description' ).show();
                $( '#sub-accordion-section-wcz-panel-checkout #customize-control-wcz-directcheckout-addcart' ).show();
                $( '#sub-accordion-section-wcz-panel-checkout #customize-control-wcz-directcheckout-disable-cartout' ).show();
            } else {
                $( '#sub-accordion-section-wcz-panel-checkout #customize-control-wcz-direct-checkout .customize-control-description' ).hide();
                $( '#sub-accordion-section-wcz-panel-checkout #customize-control-wcz-directcheckout-addcart' ).hide();
                $( '#sub-accordion-section-wcz-panel-checkout #customize-control-wcz-directcheckout-disable-cartout' ).hide();
            }
        }
        wcz_direct_checkout_links();
        $( '#customize-control-wcz-direct-checkout input[type=checkbox], #customize-control-wcz-directcheckout-addcart input[type=checkbox]' ).on( 'change', function() {
            wcz_direct_checkout_links();
        });
        function wcz_direct_checkout_links() {
            if ( $( '#customize-control-wcz-direct-checkout input[type=checkbox]' ).is( ':checked' ) && $( '#customize-control-wcz-directcheckout-addcart input[type=checkbox]' ).is( ':checked' ) ) {
                $( '#sub-accordion-section-wcz-panel-checkout #customize-control-wcz-directcheckout-remlinks' ).show();
                $( '#sub-accordion-section-wcz-panel-checkout #customize-control-wcz-directcheckout-spacing' ).show();
            } else {
                $( '#sub-accordion-section-wcz-panel-checkout #customize-control-wcz-directcheckout-remlinks' ).hide();
                $( '#sub-accordion-section-wcz-panel-checkout #customize-control-wcz-directcheckout-spacing' ).hide();
            }
        }
        wcz_direct_checkout_in();
        $( '#customize-control-wcz-direct-checkout input[type=checkbox], #customize-control-wcz-directcheckout-disable-cartout input[type=checkbox]' ).on( 'change', function() {
            wcz_direct_checkout_in();
        });
        function wcz_direct_checkout_in() {
            if ( $( '#customize-control-wcz-direct-checkout input[type=checkbox]' ).is( ':checked' ) && $( '#customize-control-wcz-directcheckout-disable-cartout input[type=checkbox]' ).is( ':checked' ) ) {
                $( '#sub-accordion-section-wcz-panel-checkout #customize-control-wcz-directcheckout-disabled-redirect' ).show();
                $( '#sub-accordion-section-wcz-panel-checkout #customize-control-wcz-directcheckout-notice' ).show();
                $( '#sub-accordion-section-wcz-panel-checkout #customize-control-wcz-directcheckout-notice-txt' ).show();
            } else {
                $( '#sub-accordion-section-wcz-panel-checkout #customize-control-wcz-directcheckout-disabled-redirect' ).hide();
                $( '#sub-accordion-section-wcz-panel-checkout #customize-control-wcz-directcheckout-notice' ).hide();
                $( '#sub-accordion-section-wcz-panel-checkout #customize-control-wcz-directcheckout-notice-txt' ).hide();
            }
        }
        wcz_direct_checkout_inin();
        $( '#customize-control-wcz-direct-checkout input[type=checkbox], #customize-control-wcz-directcheckout-disable-cartout input[type=checkbox], #customize-control-wcz-directcheckout-notice input[type=checkbox]' ).on( 'change', function() {
            wcz_direct_checkout_inin();
        });
        function wcz_direct_checkout_inin() {
            if ( $( '#customize-control-wcz-direct-checkout input[type=checkbox]' ).is( ':checked' ) && $( '#customize-control-wcz-directcheckout-disable-cartout input[type=checkbox]' ).is( ':checked' ) && $( '#customize-control-wcz-directcheckout-notice input[type=checkbox]' ).is( ':checked' ) ) {
                $( '#sub-accordion-section-wcz-panel-checkout #customize-control-wcz-directcheckout-notice-txt' ).show();
                $( '#sub-accordion-section-wcz-panel-checkout #customize-control-wcz-directcheckout-notice-color' ).show();
                $( '#sub-accordion-section-wcz-panel-checkout #customize-control-wcz-directcheckout-notice-fcolor' ).show();
            } else {
                $( '#sub-accordion-section-wcz-panel-checkout #customize-control-wcz-directcheckout-notice-txt' ).hide();
                $( '#sub-accordion-section-wcz-panel-checkout #customize-control-wcz-directcheckout-notice-color' ).hide();
                $( '#sub-accordion-section-wcz-panel-checkout #customize-control-wcz-directcheckout-notice-fcolor' ).hide();
            }
        }

        // Show / Hide Cart Design Elements
        wcz_cart_design_rts_btn();
        $( '#customize-control-wcz-cart-return-btn input[type=checkbox]' ).on( 'change', function() {
            wcz_cart_design_rts_btn();
        });
        function wcz_cart_design_rts_btn() {
            if ( $( '#customize-control-wcz-cart-return-btn input[type=checkbox]' ).is( ':checked' ) ) {
                $( '#sub-accordion-section-wcz-panel-cart #customize-control-wcz-cart-return-btn-align' ).show();
                $( '#sub-accordion-section-wcz-panel-cart #customize-control-wcz-cart-return-btn-fsize' ).show();
                $( '#sub-accordion-section-wcz-panel-cart #customize-control-wcz-cart-return-btn-color' ).show();
                $( '#sub-accordion-section-wcz-panel-cart #customize-control-wcz-cart-return-btn-fcolor' ).show();
                $( '#sub-accordion-section-wcz-panel-cart #customize-control-wcz-cart-return-btn-hcolor' ).show();
                $( '#sub-accordion-section-wcz-panel-cart #customize-control-wcz-cart-return-btn-hfcolor' ).show();
                $( '#sub-accordion-section-wcz-panel-cart #customize-control-wcz-cart-return-btn-pad' ).show();
            } else {
                $( '#sub-accordion-section-wcz-panel-cart #customize-control-wcz-cart-return-btn-align' ).hide();
                $( '#sub-accordion-section-wcz-panel-cart #customize-control-wcz-cart-return-btn-fsize' ).hide();
                $( '#sub-accordion-section-wcz-panel-cart #customize-control-wcz-cart-return-btn-color' ).hide();
                $( '#sub-accordion-section-wcz-panel-cart #customize-control-wcz-cart-return-btn-fcolor' ).hide();
                $( '#sub-accordion-section-wcz-panel-cart #customize-control-wcz-cart-return-btn-hcolor' ).hide();
                $( '#sub-accordion-section-wcz-panel-cart #customize-control-wcz-cart-return-btn-hfcolor' ).hide();
                $( '#sub-accordion-section-wcz-panel-cart #customize-control-wcz-cart-return-btn-pad' ).hide();
            }
        }

        wcz_cart_design_table_btns();
        $( '#customize-control-wcz-cart-table-btn input[type=checkbox]' ).on( 'change', function() {
            wcz_cart_design_table_btns();
        });
        function wcz_cart_design_table_btns() {
            if ( $( '#customize-control-wcz-cart-table-btn input[type=checkbox]' ).is( ':checked' ) ) {
                $( '#sub-accordion-section-wcz-panel-cart #customize-control-wcz-cart-table-btn-color' ).show();
                $( '#sub-accordion-section-wcz-panel-cart #customize-control-wcz-cart-table-btn-fcolor' ).show();
                $( '#sub-accordion-section-wcz-panel-cart #customize-control-wcz-cart-table-btn-hcolor' ).show();
                $( '#sub-accordion-section-wcz-panel-cart #customize-control-wcz-cart-table-btn-hfcolor' ).show();
            } else {
                $( '#sub-accordion-section-wcz-panel-cart #customize-control-wcz-cart-table-btn-color' ).hide();
                $( '#sub-accordion-section-wcz-panel-cart #customize-control-wcz-cart-table-btn-fcolor' ).hide();
                $( '#sub-accordion-section-wcz-panel-cart #customize-control-wcz-cart-table-btn-hcolor' ).hide();
                $( '#sub-accordion-section-wcz-panel-cart #customize-control-wcz-cart-table-btn-hfcolor' ).hide();
            }
        }

        wcz_cart_design_proceed_btn();
        $( '#customize-control-wcz-cart-proceed-btn input[type=checkbox]' ).on( 'change', function() {
            wcz_cart_design_proceed_btn();
        });
        function wcz_cart_design_proceed_btn() {
            if ( $( '#customize-control-wcz-cart-proceed-btn input[type=checkbox]' ).is( ':checked' ) ) {
                $( '#sub-accordion-section-wcz-panel-cart #customize-control-wcz-cart-proceed-btn-txt' ).show();
                $( '#sub-accordion-section-wcz-panel-cart #customize-control-wcz-cart-proceed-btn-fsize' ).show();
                $( '#sub-accordion-section-wcz-panel-cart #customize-control-wcz-cart-proceed-btn-color' ).show();
                $( '#sub-accordion-section-wcz-panel-cart #customize-control-wcz-cart-proceed-btn-fcolor' ).show();
                $( '#sub-accordion-section-wcz-panel-cart #customize-control-wcz-cart-proceed-btn-hcolor' ).show();
                $( '#sub-accordion-section-wcz-panel-cart #customize-control-wcz-cart-proceed-btn-hfcolor' ).show();
                $( '#sub-accordion-section-wcz-panel-cart #customize-control-wcz-cart-proceed-btn-pad' ).show();
            } else {
                $( '#sub-accordion-section-wcz-panel-cart #customize-control-wcz-cart-proceed-btn-txt' ).hide();
                $( '#sub-accordion-section-wcz-panel-cart #customize-control-wcz-cart-proceed-btn-fsize' ).hide();
                $( '#sub-accordion-section-wcz-panel-cart #customize-control-wcz-cart-proceed-btn-color' ).hide();
                $( '#sub-accordion-section-wcz-panel-cart #customize-control-wcz-cart-proceed-btn-fcolor' ).hide();
                $( '#sub-accordion-section-wcz-panel-cart #customize-control-wcz-cart-proceed-btn-hcolor' ).hide();
                $( '#sub-accordion-section-wcz-panel-cart #customize-control-wcz-cart-proceed-btn-hfcolor' ).hide();
                $( '#sub-accordion-section-wcz-panel-cart #customize-control-wcz-cart-proceed-btn-pad' ).hide();
            }
        }

        // Radio Options for Product Page
        wcz_cart_crosssellssection_tab();
        $( '#customize-control-wcz-wccart-recomm input[type=radio]' ).on( 'change', function() {
            wcz_cart_crosssellssection_tab();
        });
        function wcz_cart_crosssellssection_tab() {
            if ( $( '#customize-control-wcz-wccart-recomm input[type=radio]:checked' ).val() == 'wcz-wccart-recomm-edit' ) {
                $( '#sub-accordion-section-wcz-panel-cart #customize-control-wcz-wccart-recomm-title' ).show();
            } else {
                $( '#sub-accordion-section-wcz-panel-cart #customize-control-wcz-wccart-recomm-title' ).hide();
            }
        }
        // Radio Options for Product Page
        wcz_cart_totalssection_tab();
        $( '#customize-control-wcz-wccart-totals input[type=radio]' ).on( 'change', function() {
            wcz_cart_totalssection_tab();
        });
        function wcz_cart_totalssection_tab() {
            if ( $( '#customize-control-wcz-wccart-totals input[type=radio]:checked' ).val() == 'wcz-wccart-totals-edit' ) {
                $( '#sub-accordion-section-wcz-panel-cart #customize-control-wcz-wccart-totals-title' ).show();
            } else {
                $( '#sub-accordion-section-wcz-panel-cart #customize-control-wcz-wccart-totals-title' ).hide();
            }
        }

        wcz_cart_discamount_saved();
        $( '#customize-control-wcz-cart-show-discamount input[type=checkbox]' ).on( 'change', function() {
            wcz_cart_discamount_saved();
        });
        function wcz_cart_discamount_saved() {
            if ( $( '#customize-control-wcz-cart-show-discamount input[type=checkbox]' ).is( ':checked' ) ) {
                $( '#sub-accordion-section-wcz-panel-cart #customize-control-wcz-cart-discamount-txt' ).show();
                $( '#sub-accordion-section-wcz-panel-cart #customize-control-wcz-cart-discamount-bgcolor' ).show();
                $( '#sub-accordion-section-wcz-panel-cart #customize-control-wcz-cart-discamount-color' ).show();
            } else {
                $( '#sub-accordion-section-wcz-panel-cart #customize-control-wcz-cart-discamount-txt' ).hide();
                $( '#sub-accordion-section-wcz-panel-cart #customize-control-wcz-cart-discamount-bgcolor' ).hide();
                $( '#sub-accordion-section-wcz-panel-cart #customize-control-wcz-cart-discamount-color' ).hide();
            }
        }

        wcz_checkout_design_placeorder_btn();
        $( '#customize-control-wcz-checkout-placeorder-btn input[type=checkbox]' ).on( 'change', function() {
            wcz_checkout_design_placeorder_btn();
        });
        function wcz_checkout_design_placeorder_btn() {
            if ( $( '#customize-control-wcz-checkout-placeorder-btn input[type=checkbox]' ).is( ':checked' ) ) {
                $( '#sub-accordion-section-wcz-panel-checkout #customize-control-wcz-checkout-placeorder-btn-txt' ).show();
                $( '#sub-accordion-section-wcz-panel-checkout #customize-control-wcz-checkout-placeorder-btn-fsize' ).show();
                $( '#sub-accordion-section-wcz-panel-checkout #customize-control-wcz-checkout-placeorder-btn-pad' ).show();
                $( '#sub-accordion-section-wcz-panel-checkout #customize-control-wcz-checkout-placeorder-btn-color' ).show();
                $( '#sub-accordion-section-wcz-panel-checkout #customize-control-wcz-checkout-placeorder-btn-fcolor' ).show();
                $( '#sub-accordion-section-wcz-panel-checkout #customize-control-wcz-checkout-placeorder-btn-hcolor' ).show();
                $( '#sub-accordion-section-wcz-panel-checkout #customize-control-wcz-checkout-placeorder-btn-hfcolor' ).show();
            } else {
                $( '#sub-accordion-section-wcz-panel-checkout #customize-control-wcz-checkout-placeorder-btn-txt' ).hide();
                $( '#sub-accordion-section-wcz-panel-checkout #customize-control-wcz-checkout-placeorder-btn-fsize' ).hide();
                $( '#sub-accordion-section-wcz-panel-checkout #customize-control-wcz-checkout-placeorder-btn-pad' ).hide();
                $( '#sub-accordion-section-wcz-panel-checkout #customize-control-wcz-checkout-placeorder-btn-color' ).hide();
                $( '#sub-accordion-section-wcz-panel-checkout #customize-control-wcz-checkout-placeorder-btn-fcolor' ).hide();
                $( '#sub-accordion-section-wcz-panel-checkout #customize-control-wcz-checkout-placeorder-btn-hcolor' ).hide();
                $( '#sub-accordion-section-wcz-panel-checkout #customize-control-wcz-checkout-placeorder-btn-hfcolor' ).hide();
            }
        }

        wcz_checkout_design_heading_btn();
        $( '#customize-control-wcz-checkout-edit-headings input[type=checkbox]' ).on( 'change', function() {
            wcz_checkout_design_heading_btn();
        });
        function wcz_checkout_design_heading_btn() {
            if ( $( '#customize-control-wcz-checkout-edit-headings input[type=checkbox]' ).is( ':checked' ) ) {
                $( '#sub-accordion-section-wcz-panel-checkout #customize-control-wcz-checkout-careful-note' ).show();
                $( '#sub-accordion-section-wcz-panel-checkout #customize-control-wcz-checkout-billing-head' ).show();
                $( '#sub-accordion-section-wcz-panel-checkout #customize-control-wcz-checkout-addinfo-head' ).show();
                $( '#sub-accordion-section-wcz-panel-checkout #customize-control-wcz-checkout-shipping-head' ).show();
                $( '#sub-accordion-section-wcz-panel-checkout #customize-control-wcz-checkout-order-head' ).show();
                $( '#sub-accordion-section-wcz-panel-checkout #customize-control-wcz-checkout-sechead-fsize' ).show();
                $( '#sub-accordion-section-wcz-panel-checkout #customize-control-wcz-checkout-sechead-color' ).show();
            } else {
                $( '#sub-accordion-section-wcz-panel-checkout #customize-control-wcz-checkout-careful-note' ).hide();
                $( '#sub-accordion-section-wcz-panel-checkout #customize-control-wcz-checkout-billing-head' ).hide();
                $( '#sub-accordion-section-wcz-panel-checkout #customize-control-wcz-checkout-addinfo-head' ).hide();
                $( '#sub-accordion-section-wcz-panel-checkout #customize-control-wcz-checkout-shipping-head' ).hide();
                $( '#sub-accordion-section-wcz-panel-checkout #customize-control-wcz-checkout-order-head' ).hide();
                $( '#sub-accordion-section-wcz-panel-checkout #customize-control-wcz-checkout-sechead-fsize' ).hide();
                $( '#sub-accordion-section-wcz-panel-checkout #customize-control-wcz-checkout-sechead-color' ).hide();
            }
        }

        wcz_checkout_discamount_saved();
        $( '#customize-control-wcz-checkout-show-discamount input[type=checkbox]' ).on( 'change', function() {
            wcz_checkout_discamount_saved();
        });
        function wcz_checkout_discamount_saved() {
            if ( $( '#customize-control-wcz-checkout-show-discamount input[type=checkbox]' ).is( ':checked' ) ) {
                $( '#sub-accordion-section-wcz-panel-checkout #customize-control-wcz-checkout-discamount-txt' ).show();
                $( '#sub-accordion-section-wcz-panel-checkout #customize-control-wcz-checkout-discamount-bgcolor' ).show();
                $( '#sub-accordion-section-wcz-panel-checkout #customize-control-wcz-checkout-discamount-color' ).show();
            } else {
                $( '#sub-accordion-section-wcz-panel-checkout #customize-control-wcz-checkout-discamount-txt' ).hide();
                $( '#sub-accordion-section-wcz-panel-checkout #customize-control-wcz-checkout-discamount-bgcolor' ).hide();
                $( '#sub-accordion-section-wcz-panel-checkout #customize-control-wcz-checkout-discamount-color' ).hide();
            }
        }

        wcz_checkout_edit_createacc_txt();
        $( '#customize-control-wcz-checkout-edit-createaccount input[type=checkbox]' ).on( 'change', function() {
            wcz_checkout_edit_createacc_txt();
        });
        function wcz_checkout_edit_createacc_txt() {
            if ( $( '#customize-control-wcz-checkout-edit-createaccount input[type=checkbox]' ).is( ':checked' ) ) {
                $( '#sub-accordion-section-wcz-panel-checkout #customize-control-wcz-checkout-createaccount-txt' ).show();
            } else {
                $( '#sub-accordion-section-wcz-panel-checkout #customize-control-wcz-checkout-createaccount-txt' ).hide();
            }
        }

        

    });
} )( jQuery );

(function ( api ) {

    var api_inter_link = wp.customize;
    api_inter_link.bind('ready', function() {
        jQuery(['control', 'section', 'panel']).each(function(i, type) {
            jQuery('a[rel="wcz-'+type+'"]').click(function(e) {
                e.preventDefault();
                var id = jQuery(this).attr('href').replace('#', '');
                if(api_inter_link[type].has(id)) {
                    api_inter_link[type].instance(id).focus();
                }
            });
        });
    });

    // Auto Change to Page in Customizer
    const pageUrls = Object.entries( page_urls );

    for ( const [page, pageurl] of pageUrls ) {

        api.section( `wcz-panel-${page}`, function( section ) {
            var previousUrl, clearPreviousUrl, previewUrlValue;
            previewUrlValue = api.previewer.previewUrl;
            clearPreviousUrl = function() {
                previousUrl = null;
            };
     
            section.expanded.bind( function( isExpanded ) {
                var url;
                if ( isExpanded ) {
                    url = pageurl;
                    previousUrl = previewUrlValue.get();
                    previewUrlValue.set( url );
                    previewUrlValue.bind( clearPreviousUrl );
                }
            } );
        } );

    }
    
} ( wp.customize ) );

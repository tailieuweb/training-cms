var sucessRequests = 0;
var totalRequests = 0;
var name = "";

(function ($) {

    "use strict";

    $(document).ready(function () {
        envoDemoImport.init();
        envoCustomizer.init();
    });

    var envoDemoImport = {
        importData: {},
        allenvoopupClosing: true,
        init: function () {
            var that = this;

            // Categories filter
            this.categoriesFilter();

            // Search functionality.
            $('.envo-search-input').on('keyup', function () {
                if (0 < $(this).val().length) {
                    // Hide all items.
                    $('.envo-demo-wrap .themes').find('.theme-wrap').hide();

                    // Show just the ones that have a match on the import name.
                    $('.envo-demo-wrap .themes').find('.theme-wrap[data-name*="' + $(this).val().toLowerCase() + '"]').show();
                } else {
                    $('.envo-demo-wrap .themes').find('.theme-wrap').show();
                }
            });

            // Prevent the popup from showing when the live preview button
            $('.envo-demo-wrap .theme-actions a.button').on('click', function (e) {
                e.stopPropagation();
            });

            $('.envo-open-popup').click(function (e) {
                if ($(this).hasClass("active")) {
                    $(this).removeClass('active');
                    $(".install-demos-button").addClass('disabled');
                    $(".install-demos-button").attr("disabled", true);
                } else {
                    $('.envo-open-popup').removeClass('active');
                    $(this).addClass('active');
                    $(".install-demos-button").removeClass('disabled');
                    $(".install-demos-button").attr("disabled", false);
                }
            });
            // Get demo data
            $('.install-demos-button').click(function (e) {
                e.preventDefault();
                if ($('.envo-open-popup.active').length > 0) {
                    // Vars
                    var $selected_demo = $('.envo-open-popup.active:first').data('demo-id'),
                            $loading_icon = $('.preview-' + $selected_demo),
                            $disable_preview = $('.preview-all-' + $selected_demo);

                    $(".demo-import-loader").show();

                    that.getDemoData($selected_demo);
                } else {
                    window.location.href = $(this).attr("data-next_step");
                }
            });

            $(document).on('click', '.install-now', this.installNow);
            $(document).on('click', '.activate-now', this.activatePlugins);
            $(document).on('wp-plugin-install-success', this.installSuccess);
            $(document).on('wp-plugin-installing', this.pluginInstalling);
            $(document).on('wp-plugin-install-error', this.installError);

        },
        // Category filter.
        categoriesFilter: function () {

            // Cache selector to all items
            var $items = $('.envo-demo-wrap .themes').find('.theme-wrap'),
                    fadeoutClass = 'envo-is-fadeout',
                    fadeinClass = 'envo-is-fadein',
                    animationDuration = 200;

            // Hide all items.
            var fadeOut = function () {
                var dfd = $.Deferred();

                $items.addClass(fadeoutClass);

                setTimeout(function () {
                    $items.removeClass(fadeoutClass).hide();

                    dfd.resolve();
                }, animationDuration);

                return dfd.promise();
            };

            var fadeIn = function (category, dfd) {
                var filter = category ? '[data-categories*="' + category + '"]' : 'div';

                if ('all' === category) {
                    filter = 'div';
                }

                $items.filter(filter).show().addClass('envo-is-fadein');

                setTimeout(function () {
                    $items.removeClass(fadeinClass);

                    dfd.resolve();
                }, animationDuration);
            };

            var animate = function (category) {
                var dfd = $.Deferred();

                var promise = fadeOut();

                promise.done(function () {
                    fadeIn(category, dfd);
                });

                return dfd;
            };

            $('.envo-navigation-link').on('click', function (event) {
                event.preventDefault();

                // Remove 'active' class from the previous nav list items.
                $(this).parent().siblings().removeClass('active');

                // Add the 'active' class to this nav list item.
                $(this).parent().addClass('active');

                var category = this.hash.slice(1);

                // show/hide the right items, based on category selected
                var $container = $('.envo-demo-wrap .themes');
                $container.css('min-width', $container.outerHeight());

                var promise = animate(category);

                promise.done(function () {
                    $container.removeAttr('style');
                });
            });

        },
        // Get demo data.
        getDemoData: function (demo_name) {
            var that = this;

            // Get import data
            $.ajax({
                url: envoDemos.ajaxurl,
                type: 'get',
                data: {
                    action: 'envo_ajax_get_import_data',
                    demo_name: demo_name,
                    security: envoDemos.envo_import_data_nonce
                },
                complete: function (data) {
                    $(".demo-import-loader").hide();
                    that.importData = $.parseJSON(data.responseText);
                }
            });

            // Run the import
            $.ajax({
                url: envoDemos.ajaxurl,
                type: 'get',
                data: {
                    action: 'envo_wizard_ajax_get_demo_data',
                    demo_name: demo_name,
                    demo_data_nonce: envoDemos.demo_data_nonce
                },
                complete: function (data) {
                    console.log(data);
                    $(".envo-demo-wrap").html(data.responseText);

                    $('html,body').animate({
                        scrollTop: $("#envo-demo-plugins").offset().top
                    }, 500);

                    that.runPopup(data);

                }

            });

        },
        // Run popup.
        runPopup: function (data) {
            var that = this


            // Close popup
            $('.envo-demo-popup-close, .envo-demo-popup-overlay').on('click', function (e) {
                e.preventDefault();
                if (that.allenvoopupClosing === true) {
                    that.closePopup();
                }
            });

            // Display the step two
            $('.envo-plugins-next').on('click', function (e) {
                e.preventDefault();

                // Hide step one
                $('#envo-demo-plugins').hide();

                // Display step two
                $('#envo-demo-import-form').show();

            });

            // if clicked on import data button
            $('#envo-demo-import-form').submit(function (e) {
                e.preventDefault();

                // Vars
                var demo = $(this).find('[name="envo_import_demo"]').val(),
                        nonce = $(this).find('[name="envo_import_demo_data_nonce"]').val(),
                        contentToImport = [];

                // Check what need to be imported
                $(this).find('input[type="checkbox"]').each(function () {
                    if ($(this).is(':checked') === true) {
                        contentToImport.push($(this).attr('name'));
                    }
                });

                // Hide the checkboxes and show the loader
                $(this).hide();
                $('.envo-loader').show();
                $('#envo-demo-import-form,#envo-demo-plugins').hide();
                // Start importing the content
                totalRequests = contentToImport.length;
                that.importContent({
                    demo: demo,
                    nonce: nonce,
                    contentToImport: contentToImport,
                    isXML: $('#envo_import_xml').is(':checked')
                });
            });

        },
        // importing the content.
        importContent: function (importData) {
            var that = this,
                    currentContent,
                    importingLimit,
                    timerStart = Date.now(),
                    ajaxData = {
                        envo_import_demo: importData.demo,
                        envo_import_demo_data_nonce: importData.nonce
                    };

            this.allenvoopupClosing = false;
            $('.envo-demo-popup-close').fadeOut();

            // When all the selected content has been imported
            if (importData.contentToImport.length === 0) {
                if (sucessRequests != totalRequests) {
                    $('.envo-loader').hide();
                    $(".envo-error").show();
                    $(".wizard-install-demos-buttons-wrapper.final-step").show();

                } else {
                    // Show the imported screen after 1 second
                    setTimeout(function () {
                        $('.envo-loader').hide();
                        $('.envo-last').show();
                        window.location.href = $(".wizard-install-demos-buttons-wrapper.final-step .skip-btn").attr("href");
                    }, 1000);

                    // Notify the server that the importing process is complete
                    $.ajax({
                        url: envoDemos.ajaxurl,
                        type: 'post',
                        data: {
                            action: 'envo_after_import',
                            envo_import_demo: importData.demo,
                            envo_import_demo_data_nonce: importData.nonce,
                            envo_import_is_xml: importData.isXML
                        },
                        complete: function (data) {
                        }
                    });

                    this.allenvoopupClosing = true;
                    $('.envo-demo-popup-close').fadeIn();

                    return;
                }
            }

            // Check the content that was selected to be imported.
            for (var key in this.importData) {

                // Check if the current item in the iteration is in the list of importable content
                var contentIndex = $.inArray(this.importData[ key ][ 'input_name' ], importData.contentToImport);

                // If it is:
                if (contentIndex !== -1) {

                    // Get a reference to the current content
                    currentContent = key;

                    // Remove the current content from the list of remaining importable content
                    importData.contentToImport.splice(contentIndex, 1);

                    // Get the AJAX action name that corresponds to the current content
                    ajaxData.action = this.importData[ key ]['action'];

                    // After an item is found get out of the loop and execute the rest of the function
                    break;
                }
            }

            // Tell the user which content is currently being imported
            $('.envo-import-status').append('<p class="envo-importing">' + this.importData[ currentContent ]['loader'] + '</p>');

            // Tell the server to import the current content
            var ajaxRequest = $.ajax({
                url: envoDemos.ajaxurl,
                type: 'post',
                data: ajaxData,
                complete: function (data) {
                    clearTimeout(importingLimit);

                    // Indicates if the importing of the content can continue
                    var continueProcess = true;

                    // Check if the importing of the content was successful or if there was any error
                    if (data.status === 500 || data.status === 502 || data.status === 503) {
                        $('.envo-importing')
                                .addClass('envo-importing-failed')
                                .removeClass('envo-importing')
                                .text(envoDemos.content_importing_error + ' ' + data.status);
                    } else if (data.responseText.indexOf('successful import') !== -1) {
                        $('.envo-importing').addClass('envo-imported').removeClass('envo-importing');
                        sucessRequests++;
                    } else {

                        var errors = $.parseJSON(data.responseText),
                                errorMessage = '';

                        // Iterate through the list of errors
                        for (var error in errors) {
                            errorMessage += errors[ error ];

                            // If there was an error with the importing of the XML file, stop the process
                            if (error === 'xml_import_error') {
                                continueProcess = false;
                            }
                        }

                        // Display the error message
                        $('.envo-importing')
                                .addClass('envo-importing-failed')
                                .removeClass('envo-importing')
                                .text(errorMessage);

                        that.allenvoopupClosing = true;
                        $('.envo-demo-popup-close').fadeIn();
                    }

                    // Continue with the loading only if an important error was not encountered
                    if (continueProcess === true) {

                        // Load the next content in the list
                        that.importContent(importData);
                    }

                }
            });

            // Set a time limit of 15 minutes for the importing process.
            importingLimit = setTimeout(function () {

                // Abort the AJAX request
                ajaxRequest.abort();

                // Allow the popup to be closed
                that.allenvoopupClosing = true;
                $('.envo-demo-popup-close').fadeIn();

                $('.envo-importing')
                        .addClass('envo-importing-failed')
                        .removeClass('envo-importing')
                        .text(envoDemos.content_importing_error);
            }, 15 * 60 * 1000);

        },
        // Close demo popup.
        closePopup: function () {
            $('html').css({
                'overflow': '',
                'margin-right': ''
            });

            // Hide loader
            $('.preview-icon').hide();
            $('.preview-all').hide();

            // Hide demo popup
            $('#envo-demo-popup-wrap').fadeOut();

            // Remove content in the popup
            setTimeout(function () {
                $('#envo-demo-popup-content').html('');
            }, 600);
        },
        // Install required plugins.
        installNow: function (e) {
            e.preventDefault();

            // Vars
            var $button = $(e.target),
                    $document = $(document);

            if ($button.hasClass('updating-message') || $button.hasClass('button-disabled')) {
                return;
            }

            if (wp.updates.shouldRequestFilesystemCredentials && !wp.updates.ajaxLocked) {
                wp.updates.requestFilesystemCredentials(e);

                $document.on('credential-modal-cancel', function () {
                    var $message = $('.install-now.updating-message');

                    $message
                            .removeClass('updating-message')
                            .text(wp.updates.l10n.installNow);

                    wp.a11y.speak(wp.updates.l10n.updateCancel, 'polite');
                });
            }

            wp.updates.installPlugin({
                slug: $button.data('slug')
            });
        },
        // Activate required plugins.
        activatePlugins: function (e) {
            e.preventDefault();

            // Vars
            var $button = $(e.target),
                    $init = $button.data('init'),
                    $slug = $button.data('slug');

            if ($button.hasClass('updating-message') || $button.hasClass('button-disabled')) {
                return;
            }

            $button.addClass('updating-message button-primary').html(envoDemos.button_activating);

            $.ajax({
                url: envoDemos.ajaxurl,
                type: 'POST',
                data: {
                    action: 'envo_ajax_required_plugins_activate',
                    init: $init,
                },
            }).done(function (result) {

                if (result.success) {

                    $button.removeClass('button-primary install-now activate-now updating-message')
                            .attr('disabled', 'disabled')
                            .addClass('disabled')
                            .text(envoDemos.button_active);

                }

            });
        },
        // Install success.
        installSuccess: function (e, response) {
            e.preventDefault();

            var $message = $('.envo-plugin-' + response.slug).find('.button');

            // Transform the 'Install' button into an 'Activate' button.
            var $init = $message.data('init');

            $message.removeClass('install-now installed button-disabled updated-message')
                    .addClass('updating-message')
                    .html(envoDemos.button_activating);

            // WordPress adds "Activate" button after waiting for 1000ms. So we will run our activation after that.
            setTimeout(function () {

                $.ajax({
                    url: envoDemos.ajaxurl,
                    type: 'POST',
                    data: {
                        action: 'envo_ajax_required_plugins_activate',
                        init: $init,
                    },
                }).done(function (result) {

                    if (result.success) {

                        $message.removeClass('button-primary install-now activate-now updating-message')
                                .attr('disabled', 'disabled')
                                .addClass('disabled')
                                .text(envoDemos.button_active);

                    } else {
                        $message.removeClass('updating-message');
                    }

                });

            }, 1200);
        },
        // Plugin installing.
        pluginInstalling: function (e, args) {
            e.preventDefault();

            var $card = $('.envo-plugin-' + args.slug),
                    $button = $card.find('.button');

            $button.addClass('updating-message');
        },
        // Plugin install error.
        installError: function (e, response) {
            e.preventDefault();

            var $card = $('.envo-plugin-' + response.slug);

            $card.removeClass('button-primary').addClass('disabled').html(wp.updates.l10n.installFailedShort);
        }

    };

    var envoCustomizer = {
        init: function () {

            var custom_uploader;

            $('.upload_image_button').on("click", function (e) {
                e.preventDefault();
                var element = $(this);
                name = element.attr("data-name");

                //If the uploader object has already been created, reopen the dialog
                if (custom_uploader) {
                    custom_uploader.open();
                    return;
                }

                //Extend the wp.media object
                custom_uploader = wp.media.frames.file_frame = wp.media({
                    title: 'Choose Image',
                    button: {
                        text: 'Choose Image'
                    },
                    multiple: false
                });

                //When a file is selected, grab the URL and set it as the text field's value
                custom_uploader.on('select', function () {
                    var attachment = custom_uploader.state().get('selection').first().toJSON();
                    console.log(attachment);
                    $('#' + name).val(attachment.id);
                    $('#' + name + "-img").attr("src", attachment.url).show();
                    $('.remove_image_button[data-name="' + name + '"]').show();
                });

                //Open the uploader dialog
                custom_uploader.open();
            });

            // The "Remove" button (remove the value from input type='hidden')
            $('.remove_image_button').on('click', function (e) {
                e.preventDefault();
                var element = $(this);
                var name = element.attr("data-name");
                $('#' + name).val('');
                $('#' + name + "-img").attr("src", "").hide();
                element.hide();
                return false;
            });


            if ($(".color-picker-field").length > 0) {
                $(".color-picker-field").each(function (){
                    $(this).wpColorPicker();
                });

            }
        }
    };

})(jQuery);
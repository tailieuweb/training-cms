jQuery(document).ready(function($) {
  $("#pffw_default_values_reset").on("click", function() {
    swal("Default values restored !", { buttons: false });
  });
  $("#filter_shortcode").on("click", function() {
    var cls = document.getElementById("filter_shortcode");

    cls.select();

    cls.setSelectionRange(0, 99999);

    document.execCommand("copy");

    $(".mwb-pffw_success-general").css("visibility", "visible");
    setTimeout(function() {
      $(".mwb-pffw_success-general").css("visibility", "hidden");
    }, 300);
  });
  $("#reset_filter_shortcode").on("click", function() {
    var cls = document.getElementById("reset_filter_shortcode");

    cls.select();

    cls.setSelectionRange(0, 99999);

    document.execCommand("copy");

    $(".mwb-pffw_success-general").css("visibility", "visible");
    setTimeout(function() {
      $(".mwb-pffw_success-general").css("visibility", "hidden");
    }, 300);
  });
  $("#attribute").on("change", function() {
    if ($(".colors-listing").length > 0) {
      $(".colors-listing").remove();
    }
  });
  $("#filter_type").on("change", function() {
    $(".colors-listing").remove();
    var value = $("#filter_type option:selected").val();
    var avalue = $("#attribute option:selected").val();
    if (value == "Color-rectangle" || value == "Color-circle") {
      $.ajax({
        type: "POST",

        url: pffw_admin_param.ajaxurl,

        data: {
          filter_name: avalue,

          action: "filter_form_data",

          nonce: pffw_admin_param.nonce,
        },

        success: function(response) {
          response = JSON.parse(response);
          $(".colors-listing").show();
          var colordiv = '<div class="colors-listing"></div>';
          colordiv = $(colordiv);
          for (var i = 0; i < response.length; i++) {
            if (value == "Color-rectangle") {
              colordiv.append(
                '<div class="color-wrapper-element"><input type="color" name="' +
                  response[i].name +
                  '" value="#000000"><label for="' +
                  response[i].name +
                  '">' +
                  response[i].name +
                  "</label></div>"
              );
            }
            if (value == "Color-circle") {
              colordiv.append(
                '<div class="color-wrapper-element"><input style="clip-path: circle(9px at center); width: 30px; height: 30px;" type="color" name="' +
                  response[i].name +
                  '" value="#000000"><label for="' +
                  response[i].name +
                  '">' +
                  response[i].name +
                  "</label></div>"
              );
            }
          }
          colordiv.insertAfter($(".mwb-form-group:last"));
        },
      });
    }
  });
  $(".div-two-form").hide();
  $(".div-one-form").show();
  filter_data = pffw_admin_param.filter_data;
  $(document).on("submit", "form#filter_form", function(e) {
    if('cus' == $('#mwb_pf_type').val()) {
      $('#filter_form').submit();
    } else {
      e.preventDefault();
    }
    
    var attributeCheck = false;
    for (var i = 0; i < filter_data.length; i++) {
      var vak = $("#attribute option:selected").val();
      if (vak == filter_data[i].attribute) {
        attributeCheck = true;
      }
    }
    var val = $(".title_form").val();
    var Valid = val.match(/^[a-zA-Z0-9]+/);
    if (Valid != null) {
      if (!attributeCheck) {
        var value = $("#filter_type option:selected").val();
        if (
          (value == "Color-rectangle" || value == "Color-circle") &&
          $(".colors-listing").length == 0
        ) {
          swal("Please reselect filter type", { buttons: false });
        } else {
          var form_data = new FormData(this);
          form_data.append("action", "filter_form_data");
          form_data.append("nonce", pffw_admin_param.nonce);

          $.ajax({
            url: pffw_admin_param.ajaxurl,

            type: "POST",

            dataType: "json",

            data: form_data,

            contentType: false,

            processData: false,

            success: function(response) {
              $(".div-two-form").show();
              $(".err-message-div").hide();
              $(".div-one-form").hide();
              $(".message-div").html("New Filter Added!");
              setTimeout(function() {
                window.location["reload"]();
              }, 300);
            },
          });
        }
      } else {
        if('cus' != $('#mwb_pf_type').val()) {
          swal("Attribute already added !", { buttons: false });
        }
      }
    } else {
      swal("Only Number and Letters are allowed in title.", { buttons: false });
    }
  });

  var filter_data = [];
  filter_data = pffw_admin_param.filter_data;
  for (var i in filter_data) {
    filter_rows(filter_data[i], i);
  }

  function filter_rows(filter_data, id) {
    $(".filter_table").append(
      '<tr id="' +
        id +
        '" ><td>' +
        filter_data.title +
        "</td><td>" +
        filter_data.filter_type.toUpperCase() +
        "</td><td>" +
        filter_data.query_type.toUpperCase() +
        "</td><td>" +
        filter_data.attribute.toUpperCase() +
        '</td><td><a href="#" class="operation" id="' +
        id +
        '" >Delete</a></td></tr>'
    );
  }

  $(".operation").on("click", function(e) {
    var custom_id = $(this).attr("id");
    var id_delete = $(this)[0].id;
    var custom_fil_del = '';
    if ( custom_id == 'custom_fil' ) {
      id_delete = $(this).attr("data-id");
      custom_fil_del = 'yes';
    }
    e.preventDefault();
    
    swal({
      title: "Are you sure?",
      text: "Once clicked, this will be deleted!",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    }).then((willDelete) => {
      if (willDelete) {
        $.ajax({
          type: "POST",

          url: pffw_admin_param.ajaxurl,

          data: {
            custom_fil_del:custom_fil_del,
            id_value: id_delete,
            action: "filter_form_data",
            nonce: pffw_admin_param.nonce,
          },
          success: function(response) {
            if (response == '"Deleted"') {
              swal("Deleted!", {
                buttons: false,
              });
            }
            window.location["reload"]();
          },
        });
      } else {
        swal("Your data is safe!", {
          buttons: false,
        });
      }
    });
  });
});

(function($) {
  "use strict";

  $(document).ready(function() {
    const MDCText = mdc.textField.MDCTextField;
    const textField = [].map.call(
      document.querySelectorAll(".mdc-text-field"),
      function(el) {
        return new MDCText(el);
      }
    );
    const MDCRipple = mdc.ripple.MDCRipple;
    const buttonRipple = [].map.call(
      document.querySelectorAll(".mdc-button"),
      function(el) {
        return new MDCRipple(el);
      }
    );
    const MDCSwitch = mdc.switchControl.MDCSwitch;
    const switchControl = [].map.call(
      document.querySelectorAll(".mdc-switch"),
      function(el) {
        return new MDCSwitch(el);
      }
    );

    $(".mwb-password-hidden").on("click", function() {
      if ($(".mwb-form__password").attr("type") == "text") {
        $(".mwb-form__password").attr("type", "password");
      } else {
        $(".mwb-form__password").attr("type", "text");
      }
    });
  });

  $(window).load(function() {
    // add select2 for multiselect.
    if ($(document).find(".mwb-defaut-multiselect").length > 0) {
      $(document)
        .find(".mwb-defaut-multiselect")
        .select2();
    }
  });
})(jQuery);
jQuery(document).ready(function($) {
  $(".filter_addition").on("click", function() {
    const dialog = mdc.dialog.MDCDialog.attachTo(
      document.querySelector(".mdc-dialog")
    );
    dialog.open();
    if (!jQuery("body").hasClass("mobile-device")) {
      jQuery("body").addClass("mwb-on-boarding-wrapper-control");
    }
  });

  // overview page animation

  jQuery(document).on("click", ".pffw-overview__help-icon", function() {
    jQuery(".pffw-overview__help").toggleClass("pffw-help__out");
  });

  // success modal animation
  mwb_pffw_success();
});

// success modal animation function

function mwb_pffw_success() {
  jQuery("#pffw_save_filter_classes").on("click", function() {
    jQuery(".mwb-pffw_success").css("visibility", "visible");
  });
  jQuery(".success_close").on("click", function() {
    jQuery(".mwb-pffw_success").css("visibility", "hidden");
  });
}

jQuery(function($){
$('#mwb_pf_custom_loader-rmv').hide();

	$('body').on( 'click', '#mwb_pf_custom_loader', function(e){

		e.preventDefault();

		var button = $(this),
		custom_uploader = wp.media({
			title: 'Upload custom loader',
			button: {
				text: 'Use this loader'
			},
			multiple: false
		}).on('select', function() {
      var attachment = custom_uploader.state().get('selection').first().toJSON();
      button.hide();
      $('.selected_loader').html('<img class="mwb_pf_loader_gif" src="' + attachment.url + '" width="50" height="60">');
      button.next().next().val(attachment.url);
      $('#mwb_pf_custom_loader-rmv').show();

		
		}).open();
	
	});

	// on remove button click
	$(document).on('click', '#mwb_pf_custom_loader-rmv', function(e){

		e.preventDefault();

		var button = $(this);
    button.prev().val('');
    $('.mwb_pf_upld').show();
    $('.mwb_pf_loader_gif').remove();
    button.hide();
  });
  if (pffw_admin_param.mwb_pf_loader_gif != '') {
    $('#mwb_pf_custom_loader-rmv').show();
    $('.mwb_pf_upld').hide();
    $('.selected_loader').html('<img class="mwb_pf_loader_gif" src="' + pffw_admin_param.mwb_pf_loader_gif + '" width="50" height="60">');
  }

  $(document).on('change','#attribute', function(){
    if ($(this).val()=='rating' || $(this).val()=='price_slider') {
      $('#filter_type').closest('.mwb-form-group').hide();
      $('#query_type').closest('.mwb-form-group').hide();
      if ($(this).val()=='price_slider') {
        $('#filter_type').val('slider');
      } else {
        $('#filter_type').val('na');
      }
      $('#query_type').val('na');
      $('#query_type').removeAttr('required');
      $('#filter_type').removeAttr('required');
    } else if ($(this).val()!='rating' && $(this).val()!='price_slider' && $(this).val()!='price_range_tags') {
      $('#filter_type').closest('.mwb-form-group').show();
      $('#query_type').closest('.mwb-form-group').show();
      $('#query_type').val('or');
      $('#filter_type').val('List');
    }
  });
  $('#pffw_select_for_meta_filter').closest('.mwb-form-group').hide();
  $('#mwb_pf_meta_val').closest('.mwb-form-group').hide();
  $(document).on('change','#mwb_pf_type',function() {
    if ( 'cus' == $(this).val() ) {
      $('#pffw_select_for_meta_filter').closest('.mwb-form-group').show();
      $('#mwb_pf_meta_val').closest('.mwb-form-group').show();
      $('#attribute').closest('.mwb-form-group').hide();
    } else {
      $('#attribute').closest('.mwb-form-group').show();
      $('#pffw_select_for_meta_filter').closest('.mwb-form-group').hide();
      $('#mwb_pf_meta_val').closest('.mwb-form-group').hide();
    }
  });


  $(document).on('change','#mwb_pf_type',function() {
  if ($('#mwb_pf_type').val() == 'cus') {
    $("#filter_type option[value=Checkbox]").hide();
    $("#filter_type option[value=Color-circle]").hide();
    $("#filter_type option[value=Color-rectangle]").hide();
    $("#filter_type option[value=slider]").hide();
    $("#filter_type option[value=na]").hide();
  } else {
    $("#filter_type option[value=Checkbox]").show();
    $("#filter_type option[value=Color-circle]").show();
    $("#filter_type option[value=Color-rectangle]").show();
    $("#filter_type option[value=slider]").show();
    $("#filter_type option[value=na]").show();
  }
});

});

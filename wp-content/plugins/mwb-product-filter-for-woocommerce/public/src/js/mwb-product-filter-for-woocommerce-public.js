const div = '<div class="{classname}" id="{idname}"></div>';

const display_list = "<ul class={type}></ul>";

const display_select = '<select class="{classname}"></select>';

const display_div = "<div class={classname}></div>";

const label = '<label class="filter-heading-label"><b>{label-text}</b></label>';

jQuery(document).ready(function($) {
  var urllink = window.location.href.split("?");
  var termnames = [];
  if (urllink[1]) {
    var splitted = urllink[1].split("&");
    if (splitted.length > 1) {
      for (var i = 0; i < splitted.length; i = i + 2) {
        var termname = splitted[i].split("=");
        var tern = termname[1].split(",");
        if (tern.length > 1) {
          for (var j = 0; j < tern.length; j++) {
            termnames.push(tern[j]);
          }
        } else {
          termnames.push(termname[1]);
        }
      }
    }
  }

  var filter_data = mwb_pffw_classes.filters;

  var filter_attr_data = mwb_pffw_classes.attr_term;

  if (filter_attr_data != "" && filter_data != "") {
    for (var i = 0; i < filter_data.length; i++) {
      data_to_show(filter_data[i], i, filter_attr_data, termnames);
    }
  }

  function data_to_show(filter_data, index, filter_attr_data, termnames) {
    if (filter_data.title != "") {
      newlabel = label.replace("{label-text}", filter_data.title);
    }

    if (filter_data.filter_type != "") {
      if (filter_data.filter_type == "List") {
        var list_element = $(display_list.replace("{type}", "List"));

        for (var i = 0; i < filter_attr_data[index].length; i++) {
          if (termnames.length > 0) {
            var flag = false;

            for (var j = 0; j < termnames.length; j++) {
              if (filter_attr_data[index][i].name == termnames[j]) {
                flag = true;
              }
            }
            if (flag == true) {
              list_element.append(
                '<li class="list_item" data-attribute="' +
                  filter_data.attribute +
                  '" data-querytype="' +
                  filter_data.query_type +
                  '" data-labelname="' +
                  filter_attr_data[index][i].name +
                  '"><a href="javascript:void(0)" title="' +
                  filter_attr_data[index][i].name +
                  '" class="'+mwb_pf_highlight_class+'">' +
                  filter_attr_data[index][i].name +
                  "</a></li>"
              );
            } else {
              list_element.append(
                '<li class="list_item" data-attribute="' +
                  filter_data.attribute +
                  '" data-querytype="' +
                  filter_data.query_type +
                  '" data-labelname="' +
                  filter_attr_data[index][i].name +
                  '"><a href="javascript:void(0)" title="' +
                  filter_attr_data[index][i].name +
                  '">' +
                  filter_attr_data[index][i].name +
                  "</a></li>"
              );
            }
          } else {
            list_element.append(
              '<li class="list_item" data-attribute="' +
                filter_data.attribute +
                '" data-querytype="' +
                filter_data.query_type +
                '" data-labelname="' +
                filter_attr_data[index][i].name +
                '"><a href="javascript:void(0)" title="' +
                filter_attr_data[index][i].name +
                '">' +
                filter_attr_data[index][i].name +
                "</a></li>"
            );
          }
        }

        var div = $(display_div.replace("{classname}", "List-div"));

        var element_div = $(
          display_div.replace("{classname}", "List-elements-div")
        );

        div.append(newlabel);

        element_div.append(list_element);

        div.append(element_div);

        $(".wrapper").append(div);
      } else if (filter_data.filter_type == "Label") {
        var label_element = $(display_div.replace("{classname}", "Label-div"));

        var element_div = $(
          display_div.replace("{classname}", "Label-elements-div")
        );

        label_element.append(newlabel);
        var mwb_pf_highlight_class = (mwb_pffw_classes.mwb_pf_filter_type=="1")?"element_highlight":"";
        for (var i = 0; i < filter_attr_data[index].length; i++) {
          if (termnames.length > 0) {
            var flag = false;

            for (var j = 0; j < termnames.length; j++) {
              if (filter_attr_data[index][i].name == termnames[j]) {
                flag = true;
              }
            }
            if (flag == true) {
              element_div.append(
                '<label class="label_item" data-attribute="' +
                  filter_data.attribute +
                  '" data-querytype="' +
                  filter_data.query_type +
                  '" data-labelname="' +
                  filter_attr_data[index][i].name +
                  '"><a href="javascript:void(0)" title="' +
                  filter_attr_data[index][i].name +
                  '" class="'+mwb_pf_highlight_class+'">' +
                  filter_attr_data[index][i].name +
                  "</a></label>"
              );
            } else {
              element_div.append(
                '<label class="label_item" data-attribute="' +
                  filter_data.attribute +
                  '" data-querytype="' +
                  filter_data.query_type +
                  '" data-labelname="' +
                  filter_attr_data[index][i].name +
                  '"><a href="javascript:void(0)" title="' +
                  filter_attr_data[index][i].name +
                  '">' +
                  filter_attr_data[index][i].name +
                  "</a></label>"
              );
            }
          } else {
            element_div.append(
              '<label class="label_item" data-attribute="' +
                filter_data.attribute +
                '" data-querytype="' +
                filter_data.query_type +
                '" data-labelname="' +
                filter_attr_data[index][i].name +
                '"><a href="javascript:void(0)" title="' +
                filter_attr_data[index][i].name +
                '">' +
                filter_attr_data[index][i].name +
                "</a></label>"
            );
          }
        }

        label_element.append(element_div);

        $(".wrapper").append(label_element);
      } else if (
        filter_data.filter_type == "Color-circle" ||
        filter_data.filter_type == "Color-rectangle"
      ) {
        var color_element = $(display_div.replace("{classname}", "color-div"));

        var element_div = $(
          display_div.replace("{classname}", "color-elements-div")
        );

        color_element.append(newlabel);

        var val = "";

        for (var i = 0; i < filter_attr_data[index].length; i++) {
          var val = filter_attr_data[index][i].name;
          if (filter_data.filter_type == "Color-circle") {
            if (termnames.length > 0) {
              var flag = false;

              for (var j = 0; j < termnames.length; j++) {
                if (filter_attr_data[index][i].name == termnames[j]) {
                  flag = true;
                }
              }
              if (flag == true) {
                element_div.append(
                  '<a href="javascript:void(0)" data-attribute="' +
                    filter_data.attribute +
                    '" data-querytype="' +
                    filter_data.query_type +
                    '" style="background-color:' +
                    filter_data[val] +
                    '; clip-path: circle(9px at center); width: 30px; height: 30px;" class="color_item element_border" title="' +
                    filter_attr_data[index][i].name +
                    '"></a>'
                );
              } else {
                element_div.append(
                  '<a href="javascript:void(0)" data-attribute="' +
                    filter_data.attribute +
                    '" data-querytype="' +
                    filter_data.query_type +
                    '" style="background-color:' +
                    filter_data[val] +
                    '; clip-path: circle(9px at center); width: 30px; height: 30px;" class="color_item" title="' +
                    filter_attr_data[index][i].name +
                    '"></a>'
                );
              }
            } else {
              element_div.append(
                '<a href="javascript:void(0)" data-attribute="' +
                  filter_data.attribute +
                  '" data-querytype="' +
                  filter_data.query_type +
                  '" style="background-color:' +
                  filter_data[val] +
                  '; clip-path: circle(9px at center); width: 30px; height: 30px;" class="color_item" title="' +
                  filter_attr_data[index][i].name +
                  '"></a>'
              );
            }
          } else {
            if (termnames.length > 0) {
              var flag = false;

              for (var j = 0; j < termnames.length; j++) {
                if (filter_attr_data[index][i].name == termnames[j]) {
                  flag = true;
                }
              }
              if (flag == true) {
                element_div.append(
                  '<a href="javascript:void(0)" data-attribute="' +
                    filter_data.attribute +
                    '" data-querytype="' +
                    filter_data.query_type +
                    '" style="background-color:' +
                    filter_data[val] +
                    '; " class="color_item element_border" title="' +
                    filter_attr_data[index][i].name +
                    '"></a>'
                );
              } else {
                element_div.append(
                  '<a href="javascript:void(0)" data-attribute="' +
                    filter_data.attribute +
                    '" data-querytype="' +
                    filter_data.query_type +
                    '" style="background-color:' +
                    filter_data[val] +
                    '; " class="color_item" title="' +
                    filter_attr_data[index][i].name +
                    '"></a>'
                );
              }
            } else {
              element_div.append(
                '<a href="javascript:void(0)" data-attribute="' +
                  filter_data.attribute +
                  '" data-querytype="' +
                  filter_data.query_type +
                  '" style="background-color:' +
                  filter_data[val] +
                  '; " class="color_item" title="' +
                  filter_attr_data[index][i].name +
                  '"></a>'
              );
            }
          }
        }
        if (filter_data[val] != undefined) {
          color_element.append(element_div);

          $(".wrapper").append(color_element);
        }
      } else if (filter_data.filter_type == "Dropdown") {
        var select_element = $(
          display_select.replace("{classname}", "mwb-Dropdown")
        );

        for (var i = 0; i < filter_attr_data[index].length; i++) {
          select_element.append(
            '<option class="dropdown_item" data-attribute="' +
              filter_data.attribute +
              '" data-querytype="' +
              filter_data.query_type +
              '">' +
              filter_attr_data[index][i].name +
              "</option>"
          );
        }

        var div = $(display_div.replace("{classname}", "dropdown-div"));

        var element_div = $(
          display_div.replace("{classname}", "dropdown-elements-div")
        );

        div.append(newlabel);

        element_div.append(select_element);

        div.append(element_div);

        $(".wrapper").append(div);
      } else if (filter_data.filter_type == "Checkbox") {
        var checkbox_element = $(
          display_div.replace("{classname}", "checkboxs-div")
        );

        var element_div = $(
          display_div.replace("{classname}", "checkboxs-elements-div")
        );

        checkbox_element.append(newlabel);

        for (var i = 0; i < filter_attr_data[index].length; i++) {
          if (termnames.length > 0) {
            var flag = false;

            for (var j = 0; j < termnames.length; j++) {
              if (filter_attr_data[index][i].name == termnames[j]) {
                flag = true;
              }
            }
            if (flag == true) {
              element_div.append(
                '<div class="pffw_inner_checkbox"><input type="checkbox" data-attribute="' +
                  filter_data.attribute +
                  '" data-querytype="' +
                  filter_data.query_type +
                  '" id="' +
                  filter_attr_data[index][i].name +
                  '" class="checkbox_item" value="' +
                  filter_attr_data[index][i].name +
                  '" checked><label for="' +
                  filter_attr_data[index][i].name +
                  '"> ' +
                  filter_attr_data[index][i].name +
                  "</label></div>"
              );
            } else {
              element_div.append(
                '<div class="pffw_inner_checkbox"><input type="checkbox" data-attribute="' +
                  filter_data.attribute +
                  '" data-querytype="' +
                  filter_data.query_type +
                  '" id="' +
                  filter_attr_data[index][i].name +
                  '" class="checkbox_item" value="' +
                  filter_attr_data[index][i].name +
                  '"><label for="' +
                  filter_attr_data[index][i].name +
                  '"> ' +
                  filter_attr_data[index][i].name +
                  "</label></div>"
              );
            }
          } else {
            element_div.append(
              '<div class="pffw_inner_checkbox"><input type="checkbox" data-attribute="' +
                filter_data.attribute +
                '" data-querytype="' +
                filter_data.query_type +
                '" id="' +
                filter_attr_data[index][i].name +
                '" class="checkbox_item" value="' +
                filter_attr_data[index][i].name +
                '"><label for="' +
                filter_attr_data[index][i].name +
                '"> ' +
                filter_attr_data[index][i].name +
                "</label></div>"
            );
          }
        }

        checkbox_element.append(element_div);

        $(".wrapper").append(checkbox_element);
      }
    }
  }

  //JS for front end animations

  $(".filter-heading-label")
    .after()
    .append('<div class="pf-plus">+</div>');
  $(".filter-heading-label")
    .nextAll()
    .hide();
  $(".filter-heading-label").on("click", function() {
    $(this)
      .nextAll()
      .slideToggle("specialEasing");
    $(this).toggleClass("pf-up");
    if (
      $(this)
        .children(".pf-plus")
        .html() === "+"
    ) {
      $(this)
        .children(".pf-plus")
        .empty()
        .html("-");
    } else {
      $(this)
        .children(".pf-plus")
        .empty()
        .html("+");
    }
  });

  if ($(window).width() <= 768) {
    $('.mwb_pf_wrapper-mobile').hide();
    $(".pf-complete-mobile").css("left", "-100%");
    $(".pf-title_wrapper").on("click", function() {
      $('.mwb_pf_wrapper-mobile').show();
      $(".pf-complete-mobile").css("left", "0%");
    });
    $(
      ".pf-cross, .list_item, .label_item, .color_item, .dropdown_item, .pffw_inner_checkbox"
    ).on("click", function() {
      $(".pf-complete-mobile").css("left", "-100%");
    });
  } else if ($(window).width() > 768) {
    $('.mwb_pf_wrapper-mobile').hide();
    $(".pf-complete-mobile").css("left", "0%");
  }

  // JS for preloader
  $(
    ".list_item, .label_item, .color_item, .dropdown_item, .pffw_inner_checkbox, .pf-reset_button"
  ).on("click", function() {
    var show_img = setTimeout(function pre() {
      $("#primary").css("display", "none");
      $(".mwb-pffw-dialog-wrapper").css("display", "block");
    }, 300);
    setTimeout(function preloaded() {
      clearTimeout(show_img);
      $("#primary").css("display", "block");
      $(".mwb-pffw-dialog-wrapper").css("display", "none");
    }, 3000);
  });

  // JS for Selected element highlighting
  $(
    ".list_item, .label_item, .dropdown_item, .pffw_inner_checkbox, .pf-reset_button"
  ).on("click", function() {
    if (mwb_pffw_classes.mwb_pf_filter_type=="1") {
      $(this)
      .children("a")
      .toggleClass("element_highlight");
    }
  });
  $(".color_item").on("click", function() {
    if (mwb_pffw_classes.mwb_pf_filter_type=="1") {
      $(this).toggleClass("element_border");
    }
  });

  //JS for front end animations ended
});

function filter_array(label, element_array, attr, qtype) {
  
  if (!jQuery.isEmptyObject(element_array)) {
    if (element_array[attr] != undefined) {
      var value = jQuery.inArray(label, element_array[attr]);

      if (value >= 0) {
        element_array[attr].splice(value, 1);

        return element_array;
      } else {
        element_array[attr].push(label);

        filter_flag = 1;

        return element_array;
      }
    } else {
      element_array[attr] = [label];

      attr = attr + "_query_type";

      element_array[attr] = qtype;

      return element_array;
    }
  } else {
    if (element_array[attr] != undefined) {
      element_array = "";

      return element_array;
    } else {
      element_array[attr] = [label];

      attr = attr + "_query_type";

      element_array[attr] = qtype;

      return element_array;
    }
  }
}

jQuery(document).ready(function($) {
  var all_elements = {};

  $(".list_item").on("click", function() {
    var attr = $(this).data("attribute");

    var lbl = $(this).data("labelname");

    var qtype = $(this).data("querytype");

    all_elements = filter_array(lbl, all_elements, attr, qtype);

    call_ajax_filter(all_elements);
  });

  $(".label_item").on("click", function(e) {
    var attr = $(this).data("attribute");

    var lbl = $(this).data("labelname");

    var qtype = $(this).data("querytype");

    all_elements = filter_array(lbl, all_elements, attr, qtype);

    call_ajax_filter(all_elements);
  });

  $(".color_item").on("click", function(e) {
    var attr = $(this).data("attribute");

    var lbl = $(this)[0].title;

    var qtype = $(this).data("querytype");

    all_elements = filter_array(lbl, all_elements, attr, qtype);

    call_ajax_filter(all_elements);
  });

  $(".mwb-Dropdown").on("change", function() {
    var qtype = $(".mwb-Dropdown option:selected").data("querytype");

    var attr = $(".mwb-Dropdown option:selected").data("attribute");

    var lbl = $(".mwb-Dropdown option:selected").val();

    all_elements = filter_array(lbl, all_elements, attr, qtype);

    call_ajax_filter(all_elements);
  });

  $(".checkbox_item").on("click", function() {
    if ($(".checkbox_item").is(":checked")) {
      var attr = $(this).data("attribute");

      var qtype = $(this).data("querytype");

      var lbl = $(this).val();

      all_elements = filter_array(lbl, all_elements, attr, qtype);

      call_ajax_filter(all_elements);
    } else {
      var attr = $(this).data("attribute");

      all_elements[attr] = [];

      call_ajax_filter(all_elements);
    }
  });
});

function call_ajax_filter(all_elements) {
  var mwb_pffw = mwb_pffw_classes.classnames;
  var link = "";
  var qlink = "";
  objectLength = Object.keys(all_elements).length;

  if (objectLength == 2) {
    var attr = Object.keys(all_elements)[0];

    var fil = all_elements[attr];

    link =
      filter_link_creation(fil, attr) == ""
        ? ""
        : filter_link_creation(fil, attr);

    var qtype = all_elements[attr + "_query_type"];

    if (jQuery.isArray(qtype) == false && qtype != undefined) {
      qlink = query_type_filter(qtype, attr);
      link = link + "&" + qlink;
    }
  } else if (objectLength > 2) {
    var link = "";

    var link2 = "";

    for (var i = 0; i < objectLength; i++) {
      if (link == "") {
        var attr = Object.keys(all_elements)[i];

        var fil = all_elements[attr];

        var qtype = all_elements[attr + "_query_type"];

        if (jQuery.isArray(fil) == true) {
          link =
            filter_link_creation(fil, attr) == ""
              ? ""
              : filter_link_creation(fil, attr);
        }

        if (
          jQuery.isArray(qtype) == false &&
          qtype != undefined &&
          link != ""
        ) {
          qlink = query_type_filter(qtype, attr);

          link = link + "&" + qlink;
        }
      } else {
        var attr = Object.keys(all_elements)[i];

        var fil = all_elements[attr];

        var qtype = all_elements[attr + "_query_type"];

        if (jQuery.isArray(fil) == true) {
          if (filter_link_creation(fil, attr) == "") {
            link = link;
          } else {
            link2 = filter_link_creation(fil, attr);

            link2 = link2.replace("?", "");

            link = link + "&" + link2;
          }
        }

        if (
          jQuery.isArray(qtype) == false &&
          qtype != undefined &&
          link != ""
        ) {
          qlink = query_type_filter(qtype, attr);
          link = link + "&" + qlink;
        }
      }
    }
  } else {
    link = "";

    all_elements[attr] = "";

    all_elements[attr + "_query_type"] = "";

    Object.keys(all_elements)[0] = "";
  }
  if (link == "" || link == "&" + qlink) {
    link = window.location.origin + "/shop/";
  }

  jQuery(".mwb-pffw-dialog-wrapper").show();

  jQuery.ajax({
    url: link,

    success(response) {
      jQuery(".mwb-pffw-dialog-wrapper").hide();

      window.history.pushState("filter", "", link);

      // Container div.
      if (jQuery(response).find(mwb_pffw.product_container).length != 0) {
        jQuery(mwb_pffw.product_container).wrap(
          '<div class="mwb_pffw_container"></div>'
        );

        jQuery(".mwb_pffw_container").html(
          jQuery(response).find(mwb_pffw.product_container)
        );

        jQuery(".orderby").show();
      } else {
        jQuery(mwb_pffw.product_container).html(
          jQuery(response).find(".woocommerce-info")
        );
        jQuery(mwb_pffw.result_count).hide();
        jQuery(".orderby").hide();
      }

      // pagination
      if (jQuery(response).find(mwb_pffw.shop_pagination).length > 0) {
        if (!jQuery(mwb_pffw.shop_pagination).length) {
          jQuery
            .jseldom(mwb_pffw.shop_pagination)
            .insertAfter(jQuery(mwb_pffw.product_container));
        }

        jQuery(mwb_pffw.shop_pagination)
          .html(
            jQuery(response)
              .find(mwb_pffw.shop_pagination)
              .html()
          )
          .show();
      } else {
        jQuery(mwb_pffw.shop_pagination).empty();
      }

      //result count
      if (jQuery(response).find(mwb_pffw.result_count).length > 0) {
        jQuery(mwb_pffw.result_count)
          .html(
            jQuery(response)
              .find(mwb_pffw.result_count)
              .html()
          )
          .show();
      }
    },
  });
}



function call_custom_ajax_filter(fil_link) {
  var mwb_pffw = mwb_pffw_classes.classnames;
  jQuery(".mwb-pffw-dialog-wrapper").show();

  jQuery.ajax({
    url: fil_link,

    success(response) {
      jQuery(".mwb-pffw-dialog-wrapper").hide();

      window.history.pushState("filter", "", fil_link);

      // Container div.
      if (jQuery(response).find(mwb_pffw.product_container).length != 0) {
        jQuery(mwb_pffw.product_container).wrap(
          '<div class="mwb_pffw_container"></div>'
        );

        jQuery(".mwb_pffw_container").html(
          jQuery(response).find(mwb_pffw.product_container)
        );

        jQuery(".orderby").show();
      } else {
        jQuery(mwb_pffw.product_container).html(
          jQuery(response).find(".woocommerce-info")
        );
        jQuery(mwb_pffw.result_count).hide();
        jQuery(".orderby").hide();
      }

      // pagination
      if (jQuery(response).find(mwb_pffw.shop_pagination).length > 0) {
        if (!jQuery(mwb_pffw.shop_pagination).length) {
          jQuery
            .jseldom(mwb_pffw.shop_pagination)
            .insertAfter(jQuery(mwb_pffw.product_container));
        }

        jQuery(mwb_pffw.shop_pagination)
          .html(
            jQuery(response)
              .find(mwb_pffw.shop_pagination)
              .html()
          )
          .show();
      } else {
        jQuery(mwb_pffw.shop_pagination).empty();
      }

      //result count
      if (jQuery(response).find(mwb_pffw.result_count).length > 0) {
        jQuery(mwb_pffw.result_count)
          .html(
            jQuery(response)
              .find(mwb_pffw.result_count)
              .html()
          )
          .show();
      }
    },
  });
}



function call_custom_price_filter(fil_link) {
  var mwb_pffw = mwb_pffw_classes.classnames;
  jQuery(".mwb-pffw-dialog-wrapper").show();

  jQuery.ajax({
    url: fil_link,

    success(response) {
      jQuery(".mwb-pffw-dialog-wrapper").hide();

      // Container div.
      if (jQuery(response).find(mwb_pffw.product_container).length != 0) {
        jQuery(mwb_pffw.product_container).wrap(
          '<div class="mwb_pffw_container"></div>'
        );

        jQuery(".mwb_pffw_container").html(
          jQuery(response).find(mwb_pffw.product_container)
        );

        jQuery(".orderby").show();
      } else {
        jQuery(mwb_pffw.product_container).html(
          jQuery(response).find(".woocommerce-info")
        );
        jQuery(mwb_pffw.result_count).hide();
        jQuery(".orderby").hide();
      }

      // pagination
      if (jQuery(response).find(mwb_pffw.shop_pagination).length > 0) {
        if (!jQuery(mwb_pffw.shop_pagination).length) {
          jQuery
            .jseldom(mwb_pffw.shop_pagination)
            .insertAfter(jQuery(mwb_pffw.product_container));
        }

        jQuery(mwb_pffw.shop_pagination)
          .html(
            jQuery(response)
              .find(mwb_pffw.shop_pagination)
              .html()
          )
          .show();
      } else {
        jQuery(mwb_pffw.shop_pagination).empty();
      }

      //result count
      if (jQuery(response).find(mwb_pffw.result_count).length > 0) {
        jQuery(mwb_pffw.result_count)
          .html(
            jQuery(response)
              .find(mwb_pffw.result_count)
              .html()
          )
          .show();
      }
    },
  });
}

function query_type_filter(qtype, attr) {
  var query_link = "query_type_" + attr + "=" + qtype;
  return query_link;
}

function filter_link_creation(fil, attr) {
  var filter_link = "";

  var term = "";

  if (fil.length == 1) {
    filter_link = "?filter_" + attr + "=" + fil[0];

    return filter_link;
  } else if (fil.length > 1) {
    for (var j = 0; j < fil.length; j++) {
      if (term == "") {
        term = fil[j];
      } else {
        term = term + "," + fil[j];
      }
    }

    filter_link = "?filter_" + attr + "=" + term;

    return filter_link;
  } else {
    filter_link = "";

    return filter_link;
  }
}


jQuery(document).ready(function($) {
  var all_elements = {};
  var elem_arr = [];
  // JS for Selected element highlighting
  $(
    ".list_item, .label_item, .dropdown_item, .pffw_inner_checkbox, .color_item"
  ).on("click", function() {
    if (mwb_pffw_classes.mwb_pf_filter_type=="2") {
      
      var attr = $(this).attr('data-attribute');
      var labelname = $(this).attr('data-labelname');
      var qtype = $(this).data("querytype");
      if (attr == undefined || labelname == undefined || qtype == undefined) {
        var attr = $(this).find('input').attr('data-attribute');
        var labelname = $(this).find('input').attr('id');
        var qtype = $(this).find('input').data("querytype");
        if (attr == undefined || labelname == undefined || qtype == undefined) {
          var attr = $(this).attr('data-attribute');
          var labelname = $(this).attr('title');
          var qtype = $(this).data("querytype");
        }
      }
      if (!elem_arr.includes(labelname)) {
        $('.mwb_pf_separate_filter').append('<li class="mwb_pf_filtered_items" data-attribute="'+attr+'" data-labelname="'+labelname+'"><span class="mwb_pf_content">'+labelname+'</span><span class="mwb_pf_remove_filter">&#10005;</span></li>'); 
      }

      elem_arr.push(labelname);
      all_elements = filter_array(labelname, all_elements, attr, qtype);
      
    }
  });
  $(document).on('change','.mwb-Dropdown',function(){
    if (mwb_pffw_classes.mwb_pf_filter_type=="2") {
      var qtype = $(".mwb-Dropdown option:selected").data("querytype");

      var attr = $(".mwb-Dropdown option:selected").data("attribute");

      var labelname = $(".mwb-Dropdown option:selected").val();

      if (!elem_arr.includes(labelname)) {
        $('.mwb_pf_separate_filter').append('<li class="mwb_pf_filtered_items" data-attribute="'+attr+'" data-labelname="'+labelname+'"><span class="mwb_pf_content">'+labelname+'</span><span class="mwb_pf_remove_filter">&#10005;</span></li>'); 
      }
      elem_arr.push(labelname);
      all_elements = filter_array(labelname, all_elements, attr, qtype);
    }
  });
  $(document).on('click', '.mwb_pf_filtered_items',function(){
    var attr = $(this).attr('data-attribute');
    var labelname = $(this).attr('data-labelname');
    all_elements[attr].splice(labelname, 1);
    $('#'+labelname).prop('checked', false);
    $(this).remove();
    call_ajax_filter(all_elements);
  });

  objectLength = Object.keys(mwb_pffw_classes.filters).length;

  for (let i = 0; i < Object.keys(mwb_pffw_classes.filters).length; i++) {
    if ( 'rating' == mwb_pffw_classes.filters[i].attribute ) {
      var rating_index = i;
      $('.mwb_pf_wrapper').append('<button id="mwb_pf_sort_by_rating">'+mwb_pffw_classes.filters[rating_index].title+'</button>');
      break;
    }
  }
  $('.mwb_pf_wrapper').append('<a id="mwb_pf_sort_by_instock" href="?mwb_show_only_items=instock">'+mwb_pffw_classes.label_for_link+'</a>');

  $(document).on('click','#mwb_pf_sort_by_rating',function() {
    var url = window.location.href;
    if (url.indexOf("?") > -1 && url.indexOf("orderby=rating") == -1) {
      url = url + '&orderby=rating';
      call_custom_ajax_filter(url);
    } else if( url.indexOf("?") == -1 && url.indexOf("?orderby=rating") == -1) {
      url = url + '?orderby=rating';
      call_custom_ajax_filter(url);
    }
  });

  for (let i = 0; i < Object.keys(mwb_pffw_classes.filters).length; i++) {
    if ( 'price_slider' == mwb_pffw_classes.filters[i].attribute ) {
      var price_slider_index = i;
      $('.mwb_pf_wrapper').append('<div id="mwb-range-slider" class="mwb-rs"></div><div class="mwb-rs__content"><label for="mwb-range-slider">'+mwb_pffw_classes.filters[price_slider_index].title+':</label><input type="text" id="mwb-range-slider__input" readonly style="border:0; color:#f6931f; font-weight:bold;"><div>');
      break;
    }
  }


  $(function($) {
    $("#mwb-range-slider").slider({
        range: true,
        min: 0,
        max: 500,
        values: [5, 70],
        slide: function(event, ui) {
            $("#mwb-range-slider__input").val(pffw_public_param.mwb_pf_currency_symbol + ui.values[0] + " -"+ pffw_public_param.mwb_pf_currency_symbol + ui.values[1]);
        }
    });
    $("#mwb-range-slider__input").val(pffw_public_param.mwb_pf_currency_symbol + $("#mwb-range-slider").slider("values", 0) +
        " - "+pffw_public_param.mwb_pf_currency_symbol + $("#mwb-range-slider").slider("values", 1));
  });


  var count = 0;
  var replaceWith = '';
  $(document).on('slidestop','#mwb-range-slider',function(){
    
    var min = $("#mwb-range-slider").slider("values", 0);
    var max = $("#mwb-range-slider").slider("values", 1);
    var url = window.location.pathname;

    if (url.indexOf("?") > -1) {
      url = url + '&';
    } else if( url.indexOf("?") == -1 ) {
      url = url + '?';
    }


    if (count == 0) {
      var new_min = min;
      var new_max = max;
      replaceWith = 'min_price='+new_min+'&max_price='+new_max;
      url = url + replaceWith;
      count =1;
    } else {
      count = 0;
      url = url.replace(replaceWith ,'min_price='+min+'&max_price='+max);
      url = url + 'min_price='+min+'&max_price='+max;
    }


    window.history.replaceState({},'',url);


    call_custom_price_filter(url);


  });


  $('.mwb-accordian__inner--content').hide();
  $('.mwb-accordian__inner--label').on('click', function() {
      if (jQuery(this).children('span').text() == '+') {
          jQuery(this).children('span').text('-');
      } else {
          jQuery(this).children('span').text('+');
      }
      $(this).next('.mwb-accordian__inner--content').slideToggle();
  });

      if ($('.mwb-sm__content').children().is('p:nth-of-type(5)')) {
      $('.mwb-sm__content').children('p:nth-of-type(4)').addClass('mwb-sm__stop');
  }
  if ($('.mwb-sm__content').children().is('.mwb-sm__stop')) {
      $('.mwb-sm__btn--wrap').show();
      $('.mwb-sm__content').children('.mwb-sm__stop').nextUntil('.mwb-sm__btn--wrap').hide();
      $('.mwb-sm__btn--wrap').on('click', function() {
          $(this).prevUntil('.mwb-sm__stop').slideToggle();
          if (jQuery(this).children('.mwb-sm__btn').text() == 'See more...') {
              jQuery(this).children('.mwb-sm__btn').text('See less...');
          } else {
              jQuery(this).children('.mwb-sm__btn').text('See more...');
          }
      });
  } else {
      $('.mwb-sm__btn').hide();
  }


  $(function($) {
    $("#mwb-range-slider-mobile").slider({
        range: true,
        min: 0,
        max: 500,
        values: [5, 100],
        slide: function(event, ui) {
            $("#mwb-range-slider__input-mobile").val(pffw_public_param.mwb_pf_currency_symbol + ui.values[0] + " -"+ pffw_public_param.mwb_pf_currency_symbol + ui.values[1]);
        }
    });
    $("#mwb-range-slider__input-mobile").val(pffw_public_param.mwb_pf_currency_symbol + $("#mwb-range-slider-mobile").slider("values", 0) +
        " - "+pffw_public_param.mwb_pf_currency_symbol + $("#mwb-range-slider-mobile").slider("values", 1));
  });

$(document).on('slidestop','#mwb-range-slider-mobile',function(){
    
  var min = $("#mwb-range-slider").slider("values", 0);
  var max = $("#mwb-range-slider").slider("values", 1);

  $('#mwb_pf_min_price').val(min);
  $('#mwb_pf_max_price').val(max);

});

});
// Additional JS for Product filter update
jQuery(document).ready(function() {
  jQuery(".mwb-accordian__inner label").on('click',function() {
    jQuery(this).toggleClass('pf-up');
  });
});

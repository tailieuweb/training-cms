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

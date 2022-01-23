; (function ($) {
  'use strict';
  $(document).ready(function () {

    var handle = $(".uacf7-slider-handle").data("handle");
    var min = $(".uacf7-slider-handle").data("min");
    var max = $(".uacf7-slider-handle").data("max");
    var def = $(".uacf7-slider-handle").data("default");
   
 if (handle == 2) {
      $("#uacf7-slider-range").slider({
        range: true,
        min: min,
        max: max,
        values: [min, def],
        slide: function (event, ui) {
          $("#uacf7-amount").val(ui.values[0] + " - " + ui.values[1]);
          $(".uacf7-amount").html(ui.values[0] + " - " + ui.values[1]);
        }
      });
      $("#uacf7-amount").val($("#uacf7-slider-range").slider("values", 0) + " - " + $("#uacf7-slider-range").slider("values", 1));
      $(".uacf7-amount").val($("#uacf7-slider-range").slider("values", 0) + " - " + $("#uacf7-slider-range").slider("values", 1));

    }
  })
})(jQuery);
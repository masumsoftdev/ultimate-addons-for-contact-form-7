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

  $( document ).ready(function() {
 
//     var range_parent = (parseFloat(90) / parseInt(90))*100;
// alert(range_parent)

    $(document).on('input', '.range_slider', function() {
        var range_value = $(this).val();
        var max = $(this).attr("max");
        var min = $(this).attr("min"); 
        var range_parent_max = (parseFloat(range_value) / parseInt(max) )*100;
        var range_parent_min = (parseFloat(min) / parseInt(max) )*100;
        var range_parent = range_parent_max-range_parent_min;
        // alert(range_parent );
        
        $(this).parent().parent().find('#range_value').html( range_value );
        $(this).css( 'background', 'linear-gradient(to right, #3C7EE1 0%, #3C7EE1 '+range_parent_max +'%, #d3d3d3 ' + range_parent_max + '%, #d3d3d3 100%)' );
    });
}); 
})(jQuery);
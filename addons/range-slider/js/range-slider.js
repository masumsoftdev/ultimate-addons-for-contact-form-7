; (function ($) {
  'use strict';
  $(document).ready(function () {
    $( ".multistep_slide" ).each(function() {
      var handle = $(this).parent().parent().find(".uacf7-slider-handle").data("handle"); 
      var min = $(this).parent().parent().find(".uacf7-slider-handle").data("min");
      var max = $(this).parent().parent().find(".uacf7-slider-handle").data("max");
      var def = $(this).parent().parent().find(".uacf7-slider-handle").data("default");
      if (handle == 2) { 
          $(this).slider({
            range: true,
            min: min,
            max: max,
            values: [min, def],
            slide: function (event, ui) {
              $(this).parent().parent().find("#uacf7-amount").val(ui.values[0] + " - " + ui.values[1]);
              $(this).parent().parent().find(".uacf7-amount").html(ui.values[0] + " - " + ui.values[1]);
            }
          });
          $(this).parent().parent().find("#uacf7-amount").val($(this).slider("values", 0) + " - " + $(this).slider("values", 1));
          $(this).parent().parent().find(".uacf7-amount").val($(this).slider("values", 0) + " - " + $(this).slider("values", 1));
      }
    });
    $( ".mutli_range_slide" ).each(function() {
      var handle = $(this).parent().parent().find(".uacf7-slider-handle").data("handle");
      var min = $(this).parent().parent().find(".uacf7-slider-handle").data("min");
      var style = $(this).parent().parent().find(".uacf7-slider-handle").data("style");
      var max = $(this).parent().parent().find(".uacf7-slider-handle").data("max");
      var def = $(this).parent().parent().find(".uacf7-slider-handle").data("default");
      if (handle == 2) { 
           $(this).slider({
            range: true,
            min: min,
            max: max,
            values: [min, def],
            slide: function (event, ui) {
              $(this).parent().parent().find("#uacf7-amount").val(ui.values[0] + " - " + ui.values[1]); 
              $(this).parent().parent().parent().find(".min-value-"+style+"").html(ui.values[0]);
              $(this).parent().parent().parent().find(".max-value-"+style+"").html(ui.values[1]);
            }
          });
          $(this).parent().parent().find("#uacf7-amount").val($(this).slider("values", 0) + " - " + $(this).slider("values", 1));
          $(this).parent().parent().find(".uacf7-amount").val($(this).slider("values", 0) + " - " + $(this).slider("values", 1));
      }
    });

    
  })

  $( document ).ready(function() {
 
    // Style One
    $(document).on('input', '.range_slider', function() {
        var range_value = $(this).val();
        var max = $(this).attr("max");
        var min = $(this).attr("min"); 
        var newValue = Number( (range_value - min) * 100 / (max - min) );  
        $(this).parent().parent().find('#range_value').html( range_value );
        $(this).css( 'background', 'linear-gradient(to right, var(--uacf7-slider-Selection-Color) 0%, var(--uacf7-slider-Selection-Color) '+newValue +'%, #d3d3d3 ' + newValue + '%, #d3d3d3 100%)' );
    });
    // Style Two
    $(document).on('input', '.style-2 .range_slider', function() {
      var range_value = $(this).val();
      var max = $(this).attr("max");
      var min = $(this).attr("min"); 
      var newValue = Number( (range_value - min) * 100 / (max - min) );
      $(this).parent().parent().find('#range_value').css( 'left',  newValue + '%' );  
      $(this).parent().parent().find('#range_value').html( range_value );
      $(this).css( 'background', 'linear-gradient(to right, var(--uacf7-slider-Selection-Color) 0%, var(--uacf7-slider-Selection-Color) '+newValue +'%, #d3d3d3 ' + newValue + '%, #d3d3d3 100%)' );
  });

  // style 3 with step
  $( ".single-slider" ).each(function() {
       var handle = $(this).data("handle"); 
      var min = $(this).data("min");
      var max = $(this).data("max");
      var def = $(this).data("default");
      var steps = $(this).data("steps");
      var scale  = steps.split(",") 
      var step = $(this).data("step");
      if(handle == 2){
          $(this).jRange({
            from: 0,
            to: max,
            step: step,
            scale: scale,
            format: '%s',
            width: 700,
            showLabels: true,
            isRange : true
        });
      }else{
          $(this).jRange({
            from: 0,
            to: max,
            step: step,
            scale: scale,
            format: '%s',
            width: 700,
            showLabels: true,
            snap: true
        });
      }
  });
 
 
  
}); 
})(jQuery);
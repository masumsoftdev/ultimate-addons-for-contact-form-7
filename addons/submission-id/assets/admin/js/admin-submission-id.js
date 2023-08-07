;(function ($) {
 
//Passing Data to Form TAG
  var predefined_value = $('#uacf7_submission_id').val();

  $('#uacf7_submission_id_res').attr('value', predefined_value);



//Submission ID Duplication Message

    $(document).ready(function () {

    var filter_area = $('#wpcf7-form').val();

    var target_id = 'uacf7_submission_id';

    var get_id = filter_area.includes(target_id);

    function existance_trigger (get_id) {
      if(get_id === true){
        $('#prevent_multiple').click(function(){
          return confirm('You have already used the Submission ID. It is fair enough for this Form');
        });
      }
    }
    existance_trigger(get_id);

    });
 
})(jQuery);











;(function ($) {
    'use strict';
    // document.addEventListener( 'wpcf7mailsent', function( event ) {
    //     location = 'http://example.com/';
    //   }, false );

      $("#button1").click(function(){
        e.preventDefault();
        var clone_field = $(this).parent.find('.single_data_shifting_field').html();
        console.log(clone_field);
      });
 
})(jQuery);

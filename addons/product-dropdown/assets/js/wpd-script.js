;(function ($) {
    'use strict';

    $(document).ready(function () {
        $("input[type='checkbox']").click(function () {  
            $(this).parent().toggleClass("active");
        });
        $("input[type='radio']").click(function () {  
            $('.absulate-hover').removeClass("active");
            $(this).parent().toggleClass("active");
        });
    });
    
})(jQuery);

(function($){

        var forms = $('.wpcf7-form'); 
        forms.each(function(){
        var   formId                = $(this).find('input[name="_wpcf7"]').val();
        var   uacf7_spam_protection = $('.uacf7-form-'+formId).find('.uacf7_spam_recognation');
        var   form_div              = $(this).find('.uacf7-form-'+formId);
        const refreshButton         = form_div.find("#refresh");
        const captcha               = form_div.find("#captcha");
        const validate              = form_div.find("#validate");
        let   protection_method     = $(uacf7_spam_protection).attr('protection-method');

        
        

        //Generate Image captcha
        const captchaCodes = [];

        function generateRandomString(length) {
            const characters = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!#$%&()*+,-./:;< = >?@[\]^_{|}~";
            let   result     = '';
            for (let i = 0; i < length; i++) {
                result += characters.charAt(Math.floor(Math.random() * characters.length));
            }
            return result;
        }
        
        for (let i = 0; i < 50; i++) {
            const code = generateRandomString(6);
            captchaCodes.push(code);
        }

        function generateCaptcha() {
            const randomIndex = Math.floor(Math.random() * captchaCodes.length);
            const captcha     = captchaCodes[randomIndex];

            form_div.find("#captcha").text(captcha);
        }
        generateCaptcha();

            //Refresh button action
            refreshButton.click(function (e) {
                $(this).find('i').addClass('spin-rotate');
                setTimeout(() => {
                  $(this).find('i').removeClass('spin-rotate');
                }, 1000);
                e.preventDefault();
                generateCaptcha();
                form_div.find("#userInput").val('');
                const resultDiv = form_div.find("#result");
                resultDiv.text('');
          
            });



            //Conditionally make submission event false
            $(window).on('load', function() {
   
                var form_submit = uacf7_spam_protection.closest(`.uacf7-form-${formId}`).find('.wpcf7-submit');

                form_submit.on('click', function (e) {


                    const userInput = form_div.find("#userInput").val();
                    const captcha   = form_div.find("#captcha").text();
                    const resultDiv = form_div.find("#result");
                    
                    if (userInput === captcha) {
                        refreshButton.trigger('click');
                        resultDiv.text("CAPTCHA validated successfully!").css("color", "#46b450");
                        
                    } else {
       
                        e.preventDefault();
                        refreshButton.trigger('click');
                        resultDiv.text("CAPTCHA validation failed. Please try again.").css("color", "#DC2626");
           
                    }



                });
       
               
            });
  

        });


 
         
 
})(jQuery);


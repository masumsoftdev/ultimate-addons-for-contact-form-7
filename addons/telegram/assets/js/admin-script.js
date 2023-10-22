;(function ($) {


  var botToken = $('#uacf7_form_opt\\[uacf7_telegram_bot_token\\]').val();

  console.log(botToken);

  var apiUrl = `https://api.telegram.org/bot${botToken}/getMe`;

  // Retrieve bot information
  $.ajax({
    url: apiUrl,
    type: 'GET',
    success: function(data) {
      const botName = data.result.first_name;
      const botUsername = data.result.username;
      $('.online').css('display', 'block');
      $('.offline').css('display', 'none');
      $('.bot_name').html('<strong>Bot Name:</strong> ' + botName);
      $('.bot_username').html('<strong>Bot Username:</strong> @' + botUsername);
      
    }
  });

})(jQuery);
  
  
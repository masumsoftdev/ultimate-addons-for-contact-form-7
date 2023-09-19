<?php 
if(!defined('ABSPATH')){
  exit();
}

class UACF7_TELEGRAM{

  public function __construct(){
    require_once 'inc/telegram.php';
    add_action( 'admin_enqueue_scripts', [$this, 'uacf7_telegram_styles'] );
    add_action('wpcf7_mail_sent', [$this,'uacf7_send_contact_form_to_telegram']);



  }

  public function uacf7_telegram_styles(){
    wp_enqueue_style('telegram_admin_style', UACF7_URL . '/addons/telegram/assets/css/admin-style.css', [], 'UAFC7_VERSION', true, 'all');
  }


  public function uacf7_send_contact_form_to_telegram(){

     $submission = WPCF7_Submission::get_instance();
     if ($submission) {
         $posted_data = $submission->get_posted_data();
 
         $message = "New form submission:\n";
         foreach ($posted_data as $field_name => $field_value) {
             $message .= "$field_name: $field_value\n";
         }
 
         // Send the message to Telegram
         send_message_to_telegram($message);
     }
  }

  function send_message_to_telegram($message) {
    $bot_token = '6372209921:AAFy96X4MtvTaQT4BfeVGPsvdjG77X1TAJ8';
    $chat_id = '6608527573';

    $api_url = "https://api.telegram.org/bot$bot_token/sendMessage";
    $args = array(
        'chat_id' => $chat_id,
        'text' => $message,
    );

    $response = wp_remote_post($api_url, array(
        'body' => json_encode($args),
        'headers' => array('Content-Type' => 'application/json'),
    ));

    // Check for errors
    if (is_wp_error($response)) {
        error_log('Telegram API request failed: ' . $response->get_error_message());
    }
}
 

}


new UACF7_TELEGRAM();
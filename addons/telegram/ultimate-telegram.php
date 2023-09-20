<?php 
if(!defined('ABSPATH')){
  exit();
}


class UACF7_TELEGRAM {

  public function __construct() {

      require_once 'inc/telegram.php';

      add_action('wpcf7_mail_sent', [$this, 'uacf7_send_contact_form_data_to_telegram']);
      add_action('admin_enqueue_scripts', [$this, 'uacf7_telegram_admin_js_script']);
  }


  public function uacf7_telegram_admin_js_script(){
    wp_enqueue_script( 'uacf7-telegram-scripts', UACF7_ADDONS. '/telegram/assets/js/admin-script.js', ['jquery'], 'UACF7_VERSION', true );
    wp_enqueue_style( 'uacf7-telegram-styles', UACF7_ADDONS. '/telegram/assets/css/admin-style.css', [], 'UACF7_VERSION', 'all' );
  }

  public function uacf7_send_contact_form_data_to_telegram($contact_form) {

  
      $submission = WPCF7_Submission::get_instance();
      if ($submission) {
          $posted_data = $submission->get_posted_data();
          $form_id = $contact_form->id();
          $form_name = $contact_form->title();

          $message = "Message from: $form_name:\n";
          foreach ($posted_data as $field_name => $field_value) {
              $message .= "$field_name: $field_value\n";
          }

          $this->uacf7_send_message_to_telegram($message, $form_id);
      }
  }


  public function uacf7_send_message_to_telegram($message, $form_id) {

    /**
     * Getting Bot Token & Chat ID from the Database
     */

     $uacf7_telegram_settings = get_post_meta($form_id, 'uacf7_telegram_settings', true);


     if (!empty($uacf7_telegram_settings)) {
         $uacf7_telegram_enable = $uacf7_telegram_settings['uacf7_telegram_enable'];
         $uacf7_telegram_bot_token = $uacf7_telegram_settings['uacf7_telegram_bot_token'];
         $uacf7_telegram_chat_id = $uacf7_telegram_settings['uacf7_telegram_chat_id'];
      
     }

 
      $bot_token = $uacf7_telegram_bot_token;
      $chat_id =  $uacf7_telegram_chat_id;

     if($uacf7_telegram_enable === 'on'){
        $api_url = "https://api.telegram.org/bot$bot_token/sendMessage";
     }

   


      $args = array(
          'chat_id' => $chat_id,
          'text' => $message,
      );

      $response = wp_remote_post($api_url, array(
          'body' => json_encode($args),
          'headers' => array('Content-Type' => 'application/json'),
      ));

   
      if (is_wp_error($response)) {
          error_log('Telegram API request failed: ' . $response->get_error_message());
      }
  }

}




$UACF7_TELEGRAM = new UACF7_TELEGRAM();



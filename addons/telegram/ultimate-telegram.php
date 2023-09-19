<?php 
if(!defined('ABSPATH')){
  exit();
}


class UACF7_TELEGRAM {

  public function __construct() {

      require_once 'inc/telegram.php';

      add_action('wpcf7_mail_sent', [$this, 'uacf7_send_contact_form_data_to_telegram']);
  }

  public function uacf7_send_contact_form_data_to_telegram($contact_form) {
  
      $submission = WPCF7_Submission::get_instance();
      if ($submission) {
          $posted_data = $submission->get_posted_data();

          $message = "New form submission:\n";
          foreach ($posted_data as $field_name => $field_value) {
              $message .= "$field_name: $field_value\n";
          }

          $this->uacf7_send_message_to_telegram($message);
      }
  }


  public function uacf7_send_message_to_telegram($message) {

      $bot_token = '';
      $chat_id = '';

      $api_url = "https://api.telegram.org/bot$bot_token/sendMessage";
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



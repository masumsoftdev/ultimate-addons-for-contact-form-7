<?php 
if(!defined('ABSPATH')){
  exit();
}

class UACF7_TELEGRAM{

  public function __construct(){
    require_once 'inc/telegram.php';
    add_action( 'admin_enqueue_scripts', [$this, 'uacf7_telegram_styles'] );
    add_action( 'wpcf7_mail_sent', [$this, 'uacf7_send_contact_form_data_to_telegram'] );



  }

  public function uacf7_telegram_styles(){
    wp_enqueue_style('telegram_admin_style', UACF7_URL . '/addons/telegram/assets/css/admin-style.css', [], 'UAFC7_VERSION', true, 'all');
  }

 

}


new UACF7_TELEGRAM();
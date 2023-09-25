<?php

/** Prevent direct access */
if (!defined('ABSPATH')) {
  echo "You are not allowed to access directly";
  exit();
}


class UACF7_SIGNATURE{

  public function __construct(){
    require_once('inc/signature.php');
    add_action( 'wp_enqueue_scripts', [$this, 'uacf7_signature_public_scripts'] );
  }





  /** Loading Scripts */

  public function uacf7_signature_public_scripts(){

    wp_enqueue_script( 'uacf7-signature-public-assets', UACF7_URL .'/addons/signature/assets/public/js/signature.js', ['jquery'], 'UACF7_VERSION', true );

  }

}

new UACF7_SIGNATURE;
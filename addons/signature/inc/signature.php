<?php

// Do not access directly

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class UACF7_SIGNATURE_PANEL{

  public function __construct(){
    add_action( 'wpcf7_editor_panels', [$this, 'uacf7_signature_panel_add'] );
    // add_action( 'wpcf7_after_save', [$this, 'uacf7_submission_id_save_form'] );
  }



  /** Signature Panel Adding */

  public function uacf7_signature_panel_add($panels){
    $panels['uacf7-signature-panel'] = array(
      'title'    => __( 'UACF7 Signature', 'ultimate-addons-cf7' ),
      'callback' => [ $this, 'uacf7_create_uacf7_signature_panel_fields' ],
      );
      return $panels;
  }

  public function uacf7_create_uacf7_signature_panel_fields(){

    ?> 

      <h2><?php echo esc_html__( 'Signature Settings', 'ultimate-addons-cf7' ); ?></h2>  
      <p><?php echo esc_html__('This feature will help you to add the signature in form .','ultimate-addons-cf7'); ?>  </p>
      <div class="uacf7-doc-notice"> 
            <?php echo sprintf( 
                __( 'Not sure how to set this? Check our step by step  %1s.', 'ultimate-addons-cf7' ),
                '<a href="https://themefic.com/docs/uacf7/free-addons/uacf7-signature/" target="_blank">documentation</a>'
            ); ?> 
        </div>

      <label for="uacf7_signature_enable"> 
      <input class="uacf7_signature_enable" id="uacf7_signature_enable" name="uacf7_signature_enable" type="checkbox" <?php checked( 'on', $uacf7_signature_enable, true ); ?>> <?php _e( 'Enable Submission ID fields', 'ultimate-addons-cf7' ); ?>
      </label>

      <div class="ultimate-submission-id-wrapper">
        <fieldset>
               
        </fieldset> 
      </div>
     
   <?php 

    wp_nonce_field( 'uacf7_signature_nonce_action', 'uacf7_signature_nonce' );

  }


}

new UACF7_SIGNATURE_PANEL;
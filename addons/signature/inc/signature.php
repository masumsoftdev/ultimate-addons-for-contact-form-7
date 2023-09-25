<?php

// Do not access directly

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class UACF7_SIGNATURE_PANEL{

  public $uacf7_signature_enable;

  public function __construct(){
    add_action( 'wpcf7_editor_panels', [$this, 'uacf7_signature_panel_add'] );
    add_action( 'wpcf7_after_save', [$this, 'uacf7_signature_save_form'] );
  }



  /** Signature Panel Adding */

  public function uacf7_signature_panel_add($panels){
    $panels['uacf7-signature-panel'] = array(
      'title'    => __( 'UACF7 Signature', 'ultimate-addons-cf7' ),
      'callback' => [ $this, 'uacf7_create_uacf7_signature_panel_fields' ],
      );
      return $panels;
  }

  public function uacf7_create_uacf7_signature_panel_fields( $form){

    $uacf7_signature_settings = get_post_meta( $form->id(), 'uacf7_signature_settings', true );



    if(!empty($uacf7_signature_settings)){
      $this->uacf7_signature_enable = $uacf7_signature_settings['uacf7_signature_enable'];

    }

   


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
      <input class="uacf7_signature_enable" id="uacf7_signature_enable" name="uacf7_signature_enable" type="checkbox" <?php checked( 'on',  $this->uacf7_signature_enable, true ); ?>> <?php _e( 'Enable Signature for Form', 'ultimate-addons-cf7' ); ?>
      </label>

      <div class="uacf7_signature_wrapper">
        <fieldset>
               
        </fieldset> 
      </div>
     
   <?php 

    wp_nonce_field( 'uacf7_signature_nonce_action', 'uacf7_signature_nonce' );

  }

  /** Form Save */

  public function uacf7_signature_save_form($form){
    if ( ! isset( $_POST ) || empty( $_POST ) ) {
      return;
  }

    if ( !wp_verify_nonce( $_POST['uacf7_signature_nonce'], 'uacf7_signature_nonce_action' ) ) {
        return;
    }

    $uacf7_signature_settings = [
      'uacf7_signature_enable' =>  sanitize_text_field($_POST['uacf7_signature_enable']),
    ];

    update_post_meta( $form->id(), 'uacf7_signature_settings', $uacf7_signature_settings);


  }


}

new UACF7_SIGNATURE_PANEL;
<?php

// Do not access directly

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class UACF7_SIGNATURE_PANEL{

  public $uacf7_signature_enable;
  public $uacf7_signature_height;
  public $uacf7_signature_width;

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
      $this->uacf7_signature_height = $uacf7_signature_settings['uacf7_signature_height'];
      $this->uacf7_signature_width = $uacf7_signature_settings['uacf7_signature_width'];

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
             <h3><?php _e('Signature Height', 'ultimate-addons-cf7' ) ?></h3>
            <input type="number" min="1" placeholder="100" value="<?php echo $this->uacf7_signature_height; ?>" id="uacf7_signature_height" name="uacf7_signature_height">
            <br>
            <small><?php _e(' E.g. do not use px or rem', 'ultimate-addons-cf7' ) ?></small>
            
            <h3><?php _e('Signature Width', 'ultimate-addons-cf7' ) ?></h3>
            <input type="number" min="1" placeholder="300" value="<?php echo $this->uacf7_signature_width; ?>" id="uacf7_signature_width" name="uacf7_signature_width">
            <br>
            <small><?php _e(' E.g. do not use px or rem. The default value is compatible with all kind of devices', 'ultimate-addons-cf7' ) ?></small>
               
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
      'uacf7_signature_height' =>  sanitize_text_field($_POST['uacf7_signature_height']),
      'uacf7_signature_width' =>  sanitize_text_field($_POST['uacf7_signature_width'])
    ];

    update_post_meta( $form->id(), 'uacf7_signature_settings', $uacf7_signature_settings);


  }


}

new UACF7_SIGNATURE_PANEL;
<?php

// Do not access directly

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class UACF7_SIGNATURE_PANEL{

  public $uacf7_signature_enable;
  public $uacf7_signature_bg_color;
  public $uacf7_signature_border_color;
  public $uacf7_signature_pen_color;

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
      $this->uacf7_signature_enable = $uacf7_signature_settings['uacf7_signature_enable'] ?? '';
      $this->uacf7_signature_bg_color = $uacf7_signature_settings['uacf7_signature_bg_color'] ?? '#ffffff';
      $this->uacf7_signature_pen_color = $uacf7_signature_settings['uacf7_signature_pen_color'] ?? '#dddddd';
      $this->uacf7_signature_border_color = $uacf7_signature_settings['uacf7_signature_border_color'] ?? '#000000';
      
    } 

    ?> 

      <h2><?php echo esc_html__( 'Signature Settings', 'ultimate-addons-cf7' ); ?></h2>  
      <p><?php echo esc_html__('This feature will help you to add the signature in form .','ultimate-addons-cf7'); ?>  </p>
      <div class="uacf7-doc-notice"> 
            <?php echo sprintf( 
                __( 'Not sure how to set this? Check our step by step  %1s.', 'ultimate-addons-cf7' ),
                '<a href="https://themefic.com/docs/uacf7/free-addons/signature-field/" target="_blank">documentation</a>'
            ); ?> 
        </div>

      <label for="uacf7_signature_enable"> 
      <input class="uacf7_signature_enable" id="uacf7_signature_enable" name="uacf7_signature_enable" type="checkbox" <?php checked( 'on',  $this->uacf7_signature_enable, true ); ?>> <?php _e( 'Enable Signature for Form', 'ultimate-addons-cf7' ); ?>
      </label>

      <div class="uacf7_signature_wrapper">
        <fieldset>
        <h3><?php _e('Signature Pad Background Color', 'ultimate-addons-cf7' ) ?></h3>
            <input type="color"  value="<?php echo $this->uacf7_signature_bg_color; ?>" id="uacf7_signature_bg_color" name="uacf7_signature_bg_color">
            <br>
            <small><?php _e(' E.g. Default is #ffffff', 'ultimate-addons-cf7' ) ?></small>
            
            <h3><?php _e('Signature Pad Border Color', 'ultimate-addons-cf7' ) ?></h3>
            <input type="color" value="<?php echo $this->uacf7_signature_border_color; ?>" id="uacf7_signature_border_color" name="uacf7_signature_border_color">
            <br>
            <small><?php _e(' E.g. Default is #dddddd', 'ultimate-addons-cf7' ) ?></small> 
            <h3><?php _e('Signature Pen Color', 'ultimate-addons-cf7' ) ?></h3>
            <input type="color" value="<?php echo $this->uacf7_signature_pen_color; ?>" id="uacf7_signature_pen_color" name="uacf7_signature_pen_color">
            <br>
            <small><?php _e(' E.g. Default is #000000', 'ultimate-addons-cf7' ) ?></small> 
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
      'uacf7_signature_bg_color' =>  sanitize_text_field($_POST['uacf7_signature_bg_color']),
      'uacf7_signature_border_color' =>  sanitize_text_field($_POST['uacf7_signature_border_color']),
      'uacf7_signature_pen_color' =>  sanitize_text_field($_POST['uacf7_signature_pen_color']),
    ];

    update_post_meta( $form->id(), 'uacf7_signature_settings', $uacf7_signature_settings);


  }


}

new UACF7_SIGNATURE_PANEL;
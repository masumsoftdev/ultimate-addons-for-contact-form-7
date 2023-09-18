<?php

// Do not access directly

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class UACF7_TELEGRAM_TAG_PANEL{

  public function __construct(){
    add_action( 'wpcf7_editor_panels', [$this, 'uacf7_telegram_tag_panel_add'] );
    add_action( 'wpcf7_after_save', [$this, 'uacf7_telegram_save_form'] );
  }


  /** 
   * Telegram Tag Panel Adding
   */
  public function uacf7_telegram_tag_panel_add($panels){

    $panels['uacf7-telegram-panel'] = array(
      'title'    => __( 'UACF7 Telegram', 'ultimate-addons-cf7' ),
      'callback' => [ $this, 'uacf7_create_telegram_panel_fields' ],
      );
      return $panels;
  }



   public function uacf7_create_telegram_panel_fields($post){   


    // $uacf7_telegram_apply_settings = 'telegram_apply_settings';
    $uacf7_telegram = [
      'telegram_enable'
    ];

    $uacf7_telegram_is_enable = get_post_meta( $post->id(), $uacf7_telegram['telegram_enable'], true );

    // Save the array as post meta
    update_post_meta($post->id(),  'telegram_settings', $uacf7_telegram);


    
    ?> 

      <h2><?php echo esc_html__( 'Telegram Settings', 'ultimate-addons-cf7' ); ?></h2>  
      <p><?php echo esc_html__('This feature will help you to send the form data to the Telegram BOT.','ultimate-addons-cf7'); ?>  </p>
      <div class="uacf7-doc-notice"> 
            <?php echo sprintf( 
                __( 'Not sure how to set this? Check our step by step  %1s.', 'ultimate-addons-cf7' ),
                '<a href="https://themefic.com/docs/uacf7/free-addons/uacf7-telegram/" target="_blank">documentation</a>'
            ); ?> 
        </div>

      <label for="uacf7_telegram_enable"> 
      <input class="uacf7_telegram_enable" id="uacf7_telegram_enable" name="uacf7_telegram[teletam_enable]" type="checkbox" <?php checked( 'on', $uacf7_telegram_is_enable, true ); ?>> <?php _e( 'Enable Telegram Settings', 'ultimate-addons-cf7' ); ?>
      </label>

      <div class="ultimate-submission-id-wrapper">
        <fieldset>
                <h3><?php echo esc_html__( 'Add Telegram BOT', 'ultimate-addons-cf7' ); ?></h3>
                
                <br><small> <?php esc_html_e( 'E.g. default 1', 'ultimate-addons-cf7' ) ?> </small> 
              </fieldset> 
      </div>
     
   <?php 

    wp_nonce_field( 'uacf7_telegram_nonce_action', 'uacf7_telegram_nonce' );
  }

  /**
   * Saving Form Data
   */

   public function uacf7_telegram_save_form($form){
    if ( ! isset( $_POST ) || empty( $_POST ) ) {
      return;
    }

    if ( !wp_verify_nonce( $_POST['uacf7_telegram_nonce'], 'uacf7_telegram_nonce_action' ) ) {
        return;
    }

   }

}


new UACF7_TELEGRAM_TAG_PANEL;
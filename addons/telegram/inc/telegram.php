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

    
    $result = get_post_meta( $post->id(), 'uacf7_telegram_settings', true );

    $uacf7_telegram_enable = $result['uacf7_telegram_enable'];
   


    
    ?> 
      <h2><?php echo esc_html__( 'Telegram Settings', 'ultimate-addons-cf7' ); ?></h2>  
      <p><?php echo esc_html__('This feature will help you to send the form data to the Telegram BOT.','ultimate-addons-cf7'); ?>  </p>
      <div class="uacf7-doc-notice"> 
            <?php echo sprintf( 
                __( 'Not sure how to set this? Check our step by step  %1s.', 'ultimate-addons-cf7' ),
                '<a href="https://themefic.com/docs/uacf7/free-addons/uacf7-telegram/" target="_blank">documentation</a>'
            ); ?> 
      </div>

      <div class="telegram_panel_wrapper">
          <div class="telegram_wrapper_first_col">
            <label for="uacf7_telegram_enable"> 
            <input class="uacf7_telegram_enable" id="uacf7_telegram_enable" name="uacf7_telegram_enable"  type="checkbox" <?php checked( 'on', $uacf7_telegram_enable, true ); ?>> <?php _e( 'Enable Telegram Settings', 'ultimate-addons-cf7' ); ?>
            </label>

            <div class="ultimate-telegram-wrapper">
              <fieldset>
                      <h3><?php echo esc_html__( 'Telegram BOT Token', 'ultimate-addons-cf7' ); ?></h3>
                      <input type="text" name="uacf7_telegram_bot_token" placeholder="paste here"> 
                      <br><small> <?php esc_html_e( 'You need to create your own Telegram-Bot. Learn how to create & get Token', 'ultimate-addons-cf7' ) ?> </small> 
              </fieldset> 
            </div>
          </div>
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

    $uacf7_telegram_settings = [
      'uacf7_telegram_enable' => $_POST['uacf7_telegram_enable'],
      'uacf7_telegram_bot_token' => $_POST['uacf7_telegram_bot_token']
    ];

    update_post_meta( $form->id(), 'uacf7_telegram_settings', $uacf7_telegram_settings );

   }

}


new UACF7_TELEGRAM_TAG_PANEL;
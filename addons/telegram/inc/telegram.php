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


    $uacf7_telegram_settings = get_post_meta($post->id(), 'uacf7_telegram_settings', true);


    if (!empty($uacf7_telegram_settings)) {
        $uacf7_telegram_enable = $uacf7_telegram_settings['uacf7_telegram_enable'];
        $uacf7_telegram_bot_token = $uacf7_telegram_settings['uacf7_telegram_bot_token'];
        $uacf7_telegram_chat_id = $uacf7_telegram_settings['uacf7_telegram_chat_id'];
    }

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
            <input class="uacf7_telegram_enable" id="uacf7_telegram_enable" name="uacf7_telegram_enable"  type="checkbox" <?php checked( 'on', $uacf7_telegram_enable, true ); ?>> <?php _e( 'Enable Telegram Settings', 'ultimate-addons-cf7' ); ?>
      </label>

      <div class="telegram_panel_wrapper">
        <!-- First Column Start -->
          <div class="telegram_wrapper_first_col">
            

            <div class="ultimate-telegram-wrapper">
              <fieldset>
                <div class="bot_title_and_status">
                    <div class="bot_title">
                      <h3><?php echo esc_html__( 'Telegram BOT Token', 'ultimate-addons-cf7' ); ?></h3>
                    </div>
                    <div class="bot_status">
                      <!-- <div class="check_bot offline">
                        <strong class="status">Bot is Offline</strong>
                      </div> -->
                       <div class="check_bot online">
                        <strong class="status">Bot is Online</strong>
                        <div>Bot username: <code class="bot_username">@kiditambot</code></div>
                      </div>
                    </div>
                </div>    
                     <div class="bot_token_input_box">
                      <input type="text" name="uacf7_telegram_bot_token" placeholder="Paste here....."> 
                        <br> <small>
                                <?php esc_html_e( 'You need to create your own Telegram-Bot. Learn how to create & get Token', 'ultimate-addons-cf7' ); ?>
                                <a target="_blank" href="https://core.telegram.org/bots#3-how-do-i-create-a-bot"><?php esc_html_e( 'here', 'ultimate-addons-cf7' ); ?></a>
                            </small>
                     </div>


                    <div class="chat_title_div">
                      <div class="chat_title">
                        <h3><?php echo esc_html__( 'Telegram Chat ID', 'ultimate-addons-cf7' ); ?></h3>
                      </div>
                    </div>    
                     <div class="chat_id_input_box">
                      <input type="text" name="uacf7_telegram_chat_id" placeholder="<?php echo  $result ?>"> 
                        <br> <small>
                                <?php esc_html_e( 'You need to create your own Telegram-Bot. Learn how to create & get Token', 'ultimate-addons-cf7' ); ?>
                                <a target="_blank" href="https://core.telegram.org/bots#3-how-do-i-create-a-bot"><?php esc_html_e( 'here', 'ultimate-addons-cf7' ); ?></a>
                            </small>
                     </div>

              </fieldset> 
            </div>
          </div>
          <!-- Second Column Start -->
          <div class="telegram_wrapper_second_col">
            <div class="ultimate-telegram-wrapper">
              <fieldset>
                      <h3><?php echo esc_html__( 'Subscribers List', 'ultimate-addons-cf7' ); ?></h3>
                     
                      <ul>
                        <li><a href="">Subscriber 1</a> Pasue | Delete</li>
                        <li><a href="">Subscriber 2</a> Active | Delete</li>
                        <li><a href="">Subscriber 3</a> Pasue | Delete</li>
                        <li><a href="">Subscriber 4</a> Active | Delete</li>
                        <li><a href="">Subscriber 5</a> Active | Delete</li>
                      </ul>

 
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
          'uacf7_telegram_bot_token' => $_POST['uacf7_telegram_bot_token'],
          'uacf7_telegram_chat_id' => $_POST['uacf7_telegram_chat_id']
        ];

        update_post_meta( $form->id(), 'uacf7_telegram_settings', $uacf7_telegram_settings );

      }

}



  


new UACF7_TELEGRAM_TAG_PANEL;
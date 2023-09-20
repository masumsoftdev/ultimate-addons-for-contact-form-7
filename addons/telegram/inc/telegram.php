<?php

// Do not access directly

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class UACF7_TELEGRAM_TAG_PANEL{

  public $bot_name;
  public $bot_username;


  public $uacf7_telegram_enable;
  public $uacf7_telegram_bot_token;
  public $uacf7_telegram_chat_id;

  public function __construct(){
    add_action( 'wpcf7_editor_panels', [$this, 'uacf7_telegram_tag_panel_add'] );
    add_action( 'wpcf7_after_save', [$this, 'uacf7_telegram_save_form'] );
    add_action( 'admin_init', [$this, 'uacf7_get_telegram_boot_info'] );
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

    if (!empty($uacf7_telegram_settings) && isset($uacf7_telegram_settings['uacf7_telegram_enable'], $uacf7_telegram_settings['uacf7_telegram_bot_token'], $uacf7_telegram_settings['uacf7_telegram_chat_id'])) {
      $this->uacf7_telegram_enable = $uacf7_telegram_settings['uacf7_telegram_enable'];
      $this->uacf7_telegram_bot_token = $uacf7_telegram_settings['uacf7_telegram_bot_token'];
      $this->uacf7_telegram_chat_id = $uacf7_telegram_settings['uacf7_telegram_chat_id'];
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
            <input class="uacf7_telegram_enable" id="uacf7_telegram_enable" name="uacf7_telegram_enable"  type="checkbox" <?php checked( 'on', $this->uacf7_telegram_enable, true ); ?>> <?php _e( 'Enable Telegram Settings', 'ultimate-addons-cf7' ); ?>
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
                       <div class="check_bot online">
                        <strong class="status">Bot is Online<code class="bot_username"> username: @<?php  echo $this->bot_name; ?></code></strong>
                        <?php  echo $this->uacf7_telegram_bot_token; ?>
                      </div>
                      <!-- <div class="check_bot offline">
                        <strong class="status">Bot is Offline</strong>
                      </div> -->
                    </div>
                </div>    
                     <div class="bot_token_input_box">

                      <input type="text" name="uacf7_telegram_bot_token" placeholder="Paste here Telegram BOT TOKEN....."> 
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
                      <input type="text" name="uacf7_telegram_chat_id" placeholder="Paste here Telegram Chat ID....."> 
                        <br> <small>
                                <?php esc_html_e( 'You need to create your own Telegram-Chat ID. Learn how to get', 'ultimate-addons-cf7' ); ?>
                                <a target="_blank" href="https://www.google.com/search?q=%22how+to+get+telegram+chat+id"><?php esc_html_e( 'here', 'ultimate-addons-cf7' ); ?></a>
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
                        <li><a href="">Subscriber 1</a> Pasue | Delete </li>
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


      /**
       * Getting Telegram Bot Info
       */


       public function uacf7_get_telegram_boot_info(){

        $botToken = $this->uacf7_telegram_bot_token;


        $apiUrl = "https://api.telegram.org/bot$botToken/getMe";
        
        $response = file_get_contents($apiUrl);
        if ($response === false) {
            die('Failed to fetch data from Telegram API');
        }
        
        $botData = json_decode($response, true);
        
        if (!$botData || !isset($botData['ok']) || $botData['ok'] !== true) {
            die('Failed to retrieve bot data');
        }
        
        $botUsername = $botData['result']['username'];
        $botName = $botData['result']['first_name'];
        
        $this->bot_name = $botName;
        $this->bot_username = $botUsername;


       }





      

}



  


new UACF7_TELEGRAM_TAG_PANEL;
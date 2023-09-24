<?php

// Do not access directly

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class UACF7_TELEGRAM_TAG_PANEL{

  public $form_id;
  public $telegram_mse = 'updated';

  public $uacf7_telegram_enable;
  public $uacf7_telegram_message_sending_enable;
  public $uacf7_telegram_bot_token;
  public $uacf7_telegram_chat_id;
  public $uacf7_telegram_bot_name;
  public $uacf7_telegram_bot_username;
  public $uacf7_telegram_connection_error_message;

  public function __construct(){
    add_action( 'wpcf7_editor_panels', [$this, 'uacf7_telegram_tag_panel_add']);
    add_action( 'wpcf7_after_save', [$this, 'uacf7_telegram_save_form'] );

    add_action('wp_ajax_uacf7_telegram_post_meta', [$this,'uacf7_telegram_update_is_sending_message']);
    add_action('wp_ajax_nopriv_uacf7_telegram_post_meta', [$this, 'uacf7_telegram_update_is_sending_message']); 

  
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
    
  

    $uacf7_telegram_message_sending_enable = get_post_meta($post->id(), 'uacf7_telegram_message_sending_enable', true);

    if(isset($uacf7_telegram_message_sending_enable) && !empty($uacf7_telegram_message_sending_enable)){
    $this->uacf7_telegram_message_sending_enable =  $uacf7_telegram_message_sending_enable;
    }

    $uacf7_telegram_settings = get_post_meta($post->id(), 'uacf7_telegram_settings', true);

    if (!empty($uacf7_telegram_settings) && isset($uacf7_telegram_settings['uacf7_telegram_enable'], $uacf7_telegram_settings['uacf7_telegram_bot_token'], $uacf7_telegram_settings['uacf7_telegram_chat_id'] , $uacf7_telegram_settings['uacf7_telegram_bot_name'], $uacf7_telegram_settings['uacf7_telegram_bot_username'], $uacf7_telegram_settings['uacf7_telegram_connection_error_message'], )) {
      $this->uacf7_telegram_enable = $uacf7_telegram_settings['uacf7_telegram_enable'];
      $this->uacf7_telegram_bot_token = $uacf7_telegram_settings['uacf7_telegram_bot_token'];
      $this->uacf7_telegram_chat_id = $uacf7_telegram_settings['uacf7_telegram_chat_id'];
      $this->uacf7_telegram_bot_name = $uacf7_telegram_settings['uacf7_telegram_bot_name'];
      $this->uacf7_telegram_bot_username = $uacf7_telegram_settings['uacf7_telegram_bot_username'];
      $this->uacf7_telegram_connection_error_message = $uacf7_telegram_settings['uacf7_telegram_connection_error_message'];
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
            <input class="uacf7_telegram_enable" id="uacf7_telegram_enable"  name="uacf7_telegram_enable"  type="checkbox" <?php checked( 'on', $this->uacf7_telegram_enable, true ); ?>> <?php _e( 'Enable Telegram Settings', 'ultimate-addons-cf7' ); ?>
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

                    <?php if(!empty($this->uacf7_telegram_bot_name) && !empty($this->uacf7_telegram_bot_username)){ ?>
                       <div class="check_bot online">
                        <strong class="status">Bot is Online</strong>
                        <code class="bot_username">name: <?php  echo $this->uacf7_telegram_bot_name; ?>  </code>
                        <code class="bot_username">username: @<?php  echo $this->uacf7_telegram_bot_username; ?></code>
                      </div>

                    <?php }else{ ?>
                      <div class="check_bot offline">
                        <strong class="status">Bot is Offline</strong>
                      </div>
                    </div>
                    <?php } ?>
                </div>    
                     <div class="bot_token_input_box">

                      <input type="password" name="uacf7_telegram_bot_token" value="<?php echo isset($this->uacf7_telegram_bot_token) ? $this->uacf7_telegram_bot_token : ''; ?>"
                        placeholder="Paste here Telegram BOT TOKEN....."> 
                        <br> <small>
                                <?php esc_html_e( 'You need to create your own Telegram-Bot. Learn how to create & get Token', 'ultimate-addons-cf7' ); ?>
                                <a target="_blank" rel="nofollow" href="https://core.telegram.org/bots#3-how-do-i-create-a-bot"><?php esc_html_e( 'here', 'ultimate-addons-cf7' ); ?></a>
                            </small>
                     </div>


                    <div class="chat_title_div">
                      <div class="chat_title">
                        <h3><?php echo esc_html__( 'Telegram Chat ID', 'ultimate-addons-cf7' ); ?></h3>
                      </div>
                    </div>    
                     <div class="chat_id_input_box">
                      <input type="password" name="uacf7_telegram_chat_id" value="<?php echo isset($this->uacf7_telegram_chat_id) ? $this->uacf7_telegram_chat_id : ''; ?>"
                        placeholder="Paste here Telegram Chat ID....."> 
                        <br> <small>
                                <?php esc_html_e( 'You need to create your own Telegram-Chat ID. Learn how to get', 'ultimate-addons-cf7' ); ?>
                                <a target="_blank" rel="nofollow" href="https://www.google.com/search?q=%22how+to+get+telegram+chat+id"><?php esc_html_e( 'here', 'ultimate-addons-cf7' ); ?></a>
                            </small>
                     </div>

              </fieldset> 
            </div>
          </div>
          <!-- Second Column Start -->
          <div class="telegram_wrapper_second_col">
            <div class="ultimate-telegram-wrapper">
              <fieldset>
                    <h3><?php echo esc_html__( 'Sending Message to Telegram', 'ultimate-addons-cf7' ); ?></h3>
                    <div class="swtichdiv">
                      <label class="toggle" for="uacf7_telegram_message_sending_enable">
                        <span class="onoff">OFF</span>
                        <input id="uacf7_telegram_message_sending_enable" name="uacf7_telegram_message_sending_enable" type="checkbox" <?php checked( 'on', $this->uacf7_telegram_message_sending_enable, true ); ?>>
                        <span class="slider round"></span>
                      </label>
                    </div>
                    <p id="showing_success_message"></p>

                    <!-- <label class="uacf7-admin-toggle" for="uacf7_telegram_message_sending_enable">
                    <input type="checkbox" class="uacf7_telegram_message_sending_enable" name="uacf7_telegram_message_sending_enable" id="uacf7_telegram_message_sending_enable" %s>
                    <span class="uacf7-admin-toggle-track"><span class="uacf7-admin-toggle-indicator"><span class="checkMark"><svg viewBox="0 0 24 24" id="ghq-svg-check" role="presentation" aria-hidden="true"><path d="M9.86 18a1 1 0 01-.73-.32l-4.86-5.17a1.001 1.001 0 011.46-1.37l4.12 4.39 8.41-9.2a1 1 0 111.48 1.34l-9.14 10a1 1 0 01-.73.33h-.01z"></path></svg></span></span></span>
                  </label> -->
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


        $bot_token = !empty($_POST['uacf7_telegram_bot_token']) ? sanitize_text_field($_POST['uacf7_telegram_bot_token']) : $this->uacf7_telegram_bot_token;

        $error_messages = '';

        if ($bot_token) {
            $apiUrl = "https://api.telegram.org/bot$bot_token/getMe";
            
        
            $context = stream_context_create([
                'http' => [
                    'ignore_errors' => true, // 
                ],
            ]);
            
            $response = file_get_contents($apiUrl, false, $context);

            if ($response === false) {
                $error_messages = 'your telegram bot token or telegram chat id is not valid';
            }
            
      
            $http_response_code = explode(' ', $http_response_header[0])[1];

            if ($http_response_code === '404') {
                $error_messages = 'your telegram bot token or telegram chat id is not valid';
            }

        
            $botData = json_decode($response, true);
            
            if (json_last_error() !== JSON_ERROR_NONE) {
                $error_messages = 'your telegram bot token or telegram chat id is not valid';
            }
            
            if (!$botData || !isset($botData['ok']) || $botData['ok'] !== true) {
                $error_messages = 'your telegram bot token or telegram chat id is not valid';
            }
            
            $botUsername = $botData['result']['username'];
            $botName = $botData['result']['first_name'];
        }


          $uacf7_telegram_settings = [
            'uacf7_telegram_enable' => sanitize_text_field($_POST['uacf7_telegram_enable']),
            'uacf7_telegram_bot_token' => sanitize_text_field($_POST['uacf7_telegram_bot_token']),
            'uacf7_telegram_chat_id' => sanitize_text_field($_POST['uacf7_telegram_chat_id']),
            'uacf7_telegram_bot_name' => sanitize_text_field($botName),
            'uacf7_telegram_bot_username' => sanitize_text_field($botUsername),
            'uacf7_telegram_connection_error_message' => sanitize_text_field($error_messages)
          ];

          update_post_meta( $form->id(), 'uacf7_telegram_settings', $uacf7_telegram_settings );


          /** Saving Is willing to send message Switcher */

          // $uacf7_telegram_message_sending_enable = sanitize_text_field($_POST['uacf7_telegram_message_sending_enable']);
          // update_post_meta( $form->id(), 'uacf7_telegram_message_sending_enable', 'onek');




  

  }



  public function uacf7_telegram_update_is_sending_message(){

  
    $form_id = $_POST['form_id'];
    $new_value = sanitize_text_field($_POST['new_value']);


    // Update the post meta.
    update_post_meta($form_id, 'uacf7_telegram_message_sending_enable', $new_value);

  

   
    die();
  }
}






new UACF7_TELEGRAM_TAG_PANEL;
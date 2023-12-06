<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class UACF7_PROMO_NOTICE {

    // private $api_url = 'http://uacf7-api.test/';
    private $api_url = 'https://api.themefic.com/';
    private $args = array();
    private $responsed = false; 
    private $uacf7_promo_option = false; 
    private $error_message = ''; 

    public function __construct() {

 
        
        add_filter('cron_schedules', array($this, 'uacf7_custom_cron_interval'));
       
        if (!wp_next_scheduled('my_custom_task__schudle')) {
            wp_schedule_event(time(), 'every_day', 'uacf7_promo__schudle');
        }
        
        add_action('uacf7_promo__schudle', array($this, 'uacf7_promo__schudle_callback'));
        
        
        if(get_option( 'uacf7_promo__schudle_option' )){
            $this->uacf7_promo_option = get_option( 'uacf7_promo__schudle_option' );
        }
        
        // Admin Notice 
        if(is_array($this->uacf7_promo_option) && strtotime($this->uacf7_promo_option['end_date']) > time() && strtotime($this->uacf7_promo_option['start_date']) < time()){
            add_action( 'admin_notices', array( $this, 'tf_black_friday_2023_admin_notice' ) );
            add_action( 'wp_ajax_tf_black_friday_notice_dismiss_callback', array($this, 'tf_black_friday_notice_dismiss_callback') );
        }
        
        // side Notice 
        if(is_array($this->uacf7_promo_option) && strtotime($this->uacf7_promo_option['end_date']) > time() && strtotime($this->uacf7_promo_option['start_date']) < time()){ 
            add_action( 'wpcf7_admin_misc_pub_section', array( $this, 'uacf7_black_friday_2022_callback' ) );
            add_action( 'wp_ajax_uacf7_black_friday_notice_cf7_dismiss_callback', array($this, 'uacf7_black_friday_notice_cf7_dismiss_callback') ); 
        }
       
    }

    public function uacf7_get_api_response(){
        $query_params = array(
            'plugin' => 'uacf7', 
        );
        $response = wp_remote_post($this->api_url, array(
            'body'    => json_encode($query_params),
            'headers' => array('Content-Type' => 'application/json'),
        )); 
        if (is_wp_error($response)) {
            // Handle API request error
            $this->responsed = false;
            $this->error_message = esc_html($response->get_error_message());
 
        } else {
            // API request successful, handle the response content
            $data = wp_remote_retrieve_body($response);
           
            $this->responsed = json_decode($data, true); 
            
        } 
    }

    // Define the custom interval
    public function uacf7_custom_cron_interval($schedules) {
        $schedules['every_day'] = array(
            'interval' => 86400, // Every 24 hours
            // 'interval' => 5, // Every 24 hours
            'display' => __('Every 24 hours')
        );
        return $schedules;
    }

    public function uacf7_promo__schudle_callback() {  
        $this->uacf7_get_api_response();

        update_option( 'uacf7_promo__schudle_option', $this->responsed);
    }
 

    /**
     * Black Friday Deals 2023
     */
    
    public function tf_black_friday_2023_admin_notice(){ 
        
        $image_url = isset($this->uacf7_promo_option['dasboard_url']) ? esc_url($this->uacf7_promo_option['dasboard_url']) : '';
        $deal_link = isset($this->uacf7_promo_option['promo_url']) ? esc_url($this->uacf7_promo_option['promo_url']) : ''; 

        $tf_display_admin_notice_time = get_option( 'tf_display_admin_notice_time' );
        $get_current_screen = get_current_screen();  
        if(!isset($_COOKIE['tf_dismiss_admin_notice']) && $get_current_screen->base == 'dashboard'   ){ 
            ?>
            <style> 
                .tf_black_friday_20222_admin_notice a:focus {
                    box-shadow: none;
                } 
                .tf_black_friday_20222_admin_notice {
                    padding: 7px;
                    position: relative;
                    z-index: 10;
                    max-width: 825px;
                } 
                .tf_black_friday_20222_admin_notice button:before {
                    color: #fff !important;
                }
                .tf_black_friday_20222_admin_notice button:hover::before {
                    color: #d63638 !important;
                }
            </style>
            <div class="notice notice-success tf_black_friday_20222_admin_notice"> 
                <a href="<?php echo esc_attr( $deal_link ); ?>" style="display: block; line-height: 0;" target="_blank" >
                    <img  style="width: 100%;" src="<?php echo esc_attr($image_url) ?>" alt="">
                </a> 
                <?php if( isset($this->uacf7_promo_option['dasboard_dismiss']) && $this->uacf7_promo_option['dasboard_dismiss'] == true): ?>
                <button type="button" class="notice-dismiss tf_black_friday_notice_dismiss"><span class="screen-reader-text"><?php echo __('Dismiss this notice.', 'ultimate-addons-cf7' ) ?></span></button>
                <?php  endif; ?>
            </div>
            <script>
                jQuery(document).ready(function($) {
                    $(document).on('click', '.tf_black_friday_notice_dismiss', function( event ) {
                        jQuery('.tf_black_friday_20222_admin_notice').css('display', 'none')
                        data = {
                            action : 'tf_black_friday_notice_dismiss_callback',
                        };

                        $.ajax({
                            url: ajaxurl,
                            type: 'post',
                            data: data,
                            success: function (data) { ;
                            },
                            error: function (data) { 
                            }
                        });
                    });
                });
            </script>
        
        <?php 
        }
        
    } 


    public function tf_black_friday_notice_dismiss_callback() { 
		$cookie_name = "tf_dismiss_admin_notice";
		$cookie_value = "1";  
        $uacf7_promo_option = get_option( 'uacf7_promo__schudle_option' );
        $restart = isset($uacf7_promo_option['dasboard_restart']) && $uacf7_promo_option['dasboard_restart'] != false ? $uacf7_promo_option['dasboard_restart'] : false;
        if($restart == false){
            
            setcookie($cookie_name, $cookie_value, strtotime($uacf7_promo_option['end_date']), "/"); 
        }else{
            setcookie($cookie_name, $cookie_value, strtotime($uacf7_promo_option['start_date']) + (86400 * $restart), "/"); 
        }
        update_option( 'tf_display_admin_notice_time', '1' );
		wp_die();
	}


    public function uacf7_black_friday_2022_callback(){
        $image_url = isset($this->uacf7_promo_option['side_url']) ? esc_url($this->uacf7_promo_option['side_url']) : '';
        $deal_link = isset($this->uacf7_promo_option['promo_url']) ? esc_url($this->uacf7_promo_option['promo_url']) : ''; 

        ?> 
            <style> 
                .back_friday_2022_preview a:focus {
                    box-shadow: none;
                } 
                .back_friday_2022_preview a {
                    display: inline-block;
                }
                #uacf7_black_friday_docs .inside {
                    padding: 0;
                    margin-top: 0;
                }
                #uacf7_black_friday_docs .postbox-header {
                    display: none;
                    visibility: hidden;
                }
                .back_friday_2022_preview {
                    position: relative;
                }
                .tf_black_friday_cf7_notice_dismiss {
                    position: ;
                    z-index: 1;
                }
            
            </style>
            <?php if(!isset($_COOKIE['uacf7_dismiss_post_notice'])): ?>
            <div class="back_friday_2022_preview" style="text-align: center; overflow: hidden; margin: 10px;">
                <a href="<?php echo esc_attr($deal_link); ?>" target="_blank" >
                    <img  style="width: 100%;" src="<?php echo esc_attr($image_url); ?>" alt="">
                </a>  
                <?php if( isset($this->uacf7_promo_option['side_dismiss']) && $this->uacf7_promo_option['side_dismiss'] == true): ?>
                    <button type="button" class="notice-dismiss tf_black_friday_cf7_notice_dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button>
                <?php  endif; ?>
                
            </div>
            <script>
                jQuery(document).ready(function($) {
                    $(document).on('click', '.tf_black_friday_cf7_notice_dismiss', function( event ) { 
                        jQuery('.back_friday_2022_preview').css('display', 'none')
                        data = {
                            action : 'uacf7_black_friday_notice_cf7_dismiss_callback', 
                        };

                        $.ajax({
                            url: ajaxurl,
                            type: 'post',
                            data: data,
                            success: function (data) { ;
                            },
                            error: function (data) { 
                            }
                        });
                    });
                });
            </script>
            <?php endif; ?>
        <?php
	}

    public  function uacf7_black_friday_notice_cf7_dismiss_callback() { 
        $cookie_name = "uacf7_dismiss_post_notice";
        $cookie_value = "1";
        $uacf7_promo_option = get_option( 'uacf7_promo__schudle_option' );
        $start_date = isset($uacf7_promo_option['start_date']) ? strtotime($uacf7_promo_option['start_date']) : time();
        $restart = isset($uacf7_promo_option['side_restart']) && $uacf7_promo_option['side_restart'] != false ? $uacf7_promo_option['side_restart'] : 5;
  
        setcookie($cookie_name, $cookie_value, time() + (86400 * $restart), "/"); 
        wp_die();
    }
}

new UACF7_PROMO_NOTICE();
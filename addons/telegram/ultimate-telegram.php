<?php 
if(!defined('ABSPATH')){
  exit();
}

class UACF7_TELEGRAM{

  public function __construct(){
    add_action('wpcf7_editor_panels', array($this, 'uacf7_cf_add_panel'));
    add_action('uacf7_admin_tab_button', array($this, 'add_telegram_tab'), 10);
    add_action('uacf7_admin_tab_content', array($this, 'add_telegram_tab_content'));
    add_action('admin_enqueue_scripts', array($this, 'admin_scripts_loading')); 
  }

  public function admin_scripts_loading(){
    wp_enqueue_style('telegram-css', UACF7_ADDONS . '/telegram/assets/css/admin-style.css');
  }




   /* Telegram tab */
   public function add_telegram_tab()
   {
   ?>
     <a class="tablinks" onclick="uacf7_settings_tab(event, 'uacf7_telegram')"><?php echo esc_html__( 'Telegram', 'ultimate-addons-cf7' ); ?></a>
   <?php
   }

   /* Telegram tab content */
  public function add_telegram_tab_content(){
  ?>
    <div id="uacf7_telegram" class="uacf7-tabcontent uacf7-telegram">

      <form method="post" action="options.php">
        <?php
        settings_fields('uacf7_telegram_option');
        do_settings_sections('ultimate-telegram-admin');

        submit_button();
        ?>
      </form>

      </div>
  <?php
  }

    /* Create tab panel */
    public function uacf7_cf_add_panel($panels){
  
      $panels['uacf7-telegram-panel'] = array(
        'title'    => __('Telegram', 'ultimate-addons-cf7'),
        'callback' => array($this, 'uacf7_create_telegram_panel_fields'),
      );
      return $panels;
    }

      /* Telegram settings fields */
    public function uacf7_create_telegram_panel_fields($post){
      // require_once( 'inc/template/form-fields.php' );

      echo 'hello';
    }

    public function connection_status(){
     
    }
}


new UACF7_TELEGRAM();
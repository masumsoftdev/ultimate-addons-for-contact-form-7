<?php

// Do not access directly

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class UACF7_SUBMISSION_ID_PANEL{

  public function __construct(){
    add_action( 'wpcf7_editor_panels', [$this, 'uacf7_submission_panel_add'] );
    add_action( 'wpcf7_after_save', [$this, 'uacf7_submission_id_save_form'] );
    add_action( 'admin_init', [$this, 'uacf7_create_submission_id_database_col'] );

  }


  /**
   * Ultimate Submission ID Panel Adding
   */

   public function uacf7_submission_panel_add($panels){
    $panels['uacf7-submission-id-panel'] = array(
      'title'    => __( 'UACF7 Submission ID', 'ultimate-addons-cf7' ),
      'callback' => [ $this, 'uacf7_create_uacf7submission_id_panel_fields' ],
      );
      return $panels;
   }


   public function uacf7_create_uacf7submission_id_panel_fields($post){   

    $uacf7_submission_id = get_post_meta( $post->id(), 'uacf7_submission_id', true ); 
    $uacf7_submission_id_step = get_post_meta( $post->id(), 'uacf7_submission_id_step', true ); 
    $uacf7_submission_id_enable = get_post_meta( $post->id(), 'uacf7_submission_id_enable', true ); 
    
    ?> 
                
      

      <h2><?php echo esc_html__( 'Submission ID Settings', 'ultimate-addons-cf7' ); ?></h2>  
      <p><?php echo esc_html__('This feature will help you to pass a custom range of Submission ID','ultimate-addons-cf7'); ?>  </p>
      <div class="uacf7-doc-notice"> 
            <?php echo sprintf( 
                __( 'Not sure how to set this? Check our step by step  %1s.', 'ultimate-addons-cf7' ),
                '<a href="https://themefic.com/docs/ultimate-addons-for-contact-form-7/" target="_blank">documentation</a>'
            ); ?> 
        </div>

      <label for="uacf7_submission_id_enable">
      <input class="pre-populate" id="pre_populate_enable" name="uacf7_submission_id_enable" type="checkbox" value="1" <?php checked( '1', $uacf7_submission_id_enable, true ); ?>> <?php _e( 'Enable Submission ID fields', 'ultimate-addons-cf7' ); ?>
      </label>

      <div class="ultimate-submission-id-wrapper">
        <fieldset>
                <h3><?php echo esc_html__( 'Submission ID Starts from', 'ultimate-addons-cf7' ); ?></h3>
                <input type="number" min="1" name="uacf7_submission_id" id="uacf7_submission_id" value="<?php  esc_attr_e($uacf7_submission_id) ?>" >

                <h3><?php echo esc_html__( 'Submission ID Step Counter', 'ultimate-addons-cf7' ); ?></h3>
                <input type="number" min="0" name="uacf7_submission_id_step" id="uacf7_submission_id_step" value="<?php  esc_attr_e($uacf7_submission_id_step) ?>" >
        </fieldset> 
      </div>
     
   <?php 

    wp_nonce_field( 'uacf7_submission_id_nonce_action', 'uacf7_submission_id_nonce' );
  }



/**
 * Save Form
 */

 public function uacf7_submission_id_save_form($form){
  if ( ! isset( $_POST ) || empty( $_POST ) ) {
    return;
}

  if ( !wp_verify_nonce( $_POST['uacf7_submission_id_nonce'], 'uacf7_submission_id_nonce_action' ) ) {
      return;
  }

  update_post_meta( $form->id(), 'uacf7_submission_id', $_POST['uacf7_submission_id'] );
  update_post_meta( $form->id(), 'uacf7_submission_id_step', $_POST['uacf7_submission_id_step']);
  update_post_meta( $form->id(), 'uacf7_submission_id_enable', $_POST['uacf7_submission_id_enable']); 
 }


 /**
  * Create a Database column named "submission_id"
  */


  public function uacf7_create_submission_id_database_col() { 
    global $wpdb; 
    $table_name = $wpdb->prefix.'uacf7_form';

    $charset_collate = $wpdb->get_charset_collate();

    $tableName = $wpdb->prefix . 'leaguemanager_person_status';
        $sql_checked = "SELECT *  FROM information_schema.COLUMNS  WHERE 
                            TABLE_SCHEMA = '$wpdb->dbname' 
                        AND TABLE_NAME = '$table_name' 
                        AND COLUMN_NAME = 'submission_id'";

    $checked_status = $wpdb->query( $sql_checked ); 
    if($checked_status != true){ 
      $sql = "ALTER TABLE $table_name 
      MODIFY COLUMN form_date DATETIME NULL,
      ADD submission_id VARCHAR(255) DEFAULT 0 NULL AFTER form_value"; 
      $wpdb->query( $sql );
    }
} 


}


new UACF7_SUBMISSION_ID_PANEL();



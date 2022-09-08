<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
* Pre Populate Classs
*/
class UACF7_DATABASE {
    
    /*
    * Construct function
    */
    public function __construct() {
        
        // add_action( 'wp_enqueue_scripts', array($this, 'wp_enqueue_script' ) );  
        // add_action( 'admin_enqueue_scripts', array($this, 'wp_enqueue_admin_script' ) );       
        add_action( 'wpcf7_before_send_mail', array($this, 'uacf7_save_to_database' ) );       
    } 
 
    /*
    * Enqueue script Backend
    */
    
    public function wp_enqueue_admin_script() {
        wp_enqueue_style( 'uacf7-multistep-style', UACF7_ADDONS . '/pre-populate-field/assets/css/admin-pre-populate.css' );
		wp_enqueue_script( 'admin-pre-populate', UACF7_ADDONS . '/pre-populate-field/assets/js/admin-pre-populate.js', array('jquery'), null, true ); 
    }
 

    /*
    * Ultimate form save into the database
    */
    public function uacf7_save_to_database($form){ 
        require_once( ABSPATH . 'wp-admin/includes/file.php' );
        global $wpdb; 
        $table_name = $wpdb->prefix.'uacf7_form'; 

        $submission   = WPCF7_Submission::get_instance();

        $contact_form = $submission->get_contact_form();
        $contact_form_data = $submission->get_posted_data();
        $files            = $submission->uploaded_files();
        $upload_dir    = wp_upload_dir();
        $dir = $upload_dir['basedir'];
        $uploaded_files = [];
        $time_now      = time();
        $data_file      = []; 

        foreach ($_FILES as $file_key => $file) {
            array_push($uploaded_files, $file_key);
        }

        foreach ($files as $file_key => $file) {
            if(in_array($file_key, $uploaded_files)){ 
                $file = is_array( $file ) ? reset( $file ) : $file; 
                $dir_link = '/uacf7-uploads/'.$time_now.'-'.$file_key.'-'.basename($file);
                copy($file, $dir.$dir_link); 
                array_push($data_file, [$file_key=> $dir_link]);
            } 
        } 
        foreach($contact_form_data as $key => $value){
            
            if(in_array($file_key, $uploaded_files)){
                echo $file_key;
            }
        }

        $data = [
            'status' => 'unread', 
        ];
        
        $data = json_encode(array_merge($data, $contact_form_data)) ; 

        echo "<pre>"; 
        print_r($dir);
        echo "</pre>";
        // $wpdb->insert($table_name, array(
        //     'form_id' => $form->id(),
        //     'form_value' =>  $data, 
        //     'form_date' => current_time('Y-m-d H:i:s'), 
        // ));
        exit;
    }

    
   
   
}
new UACF7_DATABASE();
<?php
if (!defined('ABSPATH')) {
  exit;
}
class UACF7_MAILCHIMP
{

  public $mailchimlConnection = '';
  public static $mailchimp = null;
  private $mailchimp_api = '';

  public function __construct()
  {
    require_once('inc/functions.php'); 
  
    add_action("wpcf7_before_send_mail", array($this, 'send_data'));
    add_action('wpcf7_after_save', array($this, 'uacf7_save_contact_form'));
    add_filter( 'uacf7_post_meta_options', array($this, 'uacf7_post_meta_options_mailchimp'), 17, 2 );  
    add_filter( 'uacf7_settings_options', array($this, 'uacf7_settings_options_mailchimp'), 17, 2 );  
    // add_filter( 'wpcf7_load_js', '__return_false' );

    $this->get_api_key();
    
    require_once( 'inc/functions.php' );
  }

  function uacf7_settings_options_mailchimp($value){ 
    $status = $this->connection_status();
    $value['mailchimp']['fields']['uacf7_mailchimp_api_status'] = array(
      'id'        => 'uacf7_mailchimp_api_status',
      'type'     => 'callback',
      'function' => 'uacf7_mailchimp_api_status_callback',
      'argument' => $status,
  
    );
    return $value;
} 

  public function uacf7_post_meta_options_mailchimp( $value, $post_id){
    $status = $this->connection_status();

    //get audience
      $api_key = $this->mailchimp_api;
      $audience = array();
      if ($api_key != '') {

          $response = $this->set_config($api_key, 'lists');

          $response = json_decode($response, true);
          $x = 0;
          if($response != null){
            foreach ($response['lists'] as $list) {
              $audience[$list['id']] = $list['name'];
                // echo '<option value="' . $list['id'] . '" ' . selected($audience, $list['id']) . '>' . $list['name'] . '</option>'; 
                $x++;
            }
          }
          
      } 

    $mailchimp = apply_filters('uacf7_post_meta_options_mailchimp_pro', $data = array(
        'title'  => __( 'Mailchimp', 'ultimate-addons-cf7' ),
        'icon'   => 'fa-brands fa-mailchimp',
        'fields' => array(
            'uacf7_mailchimp_label' => array(
              'id'    => 'uacf7_mailchimp_label',
              'type'  => 'notice',
              'notice' => 'info',
              'label' => __( 'Mailchimp Form Settings', 'ultimate-addons-cf7' ),
              'title' => __( 'This addon will help you to Intergrate with Mailchimp.', 'ultimate-addons-cf7' ),
              'content' => sprintf( 
                  __( 'Not sure how to set this? Check our step by step  %1s.', 'ultimate-addons-cf7' ),
                  '<a href="https://themefic.com/docs/uacf7/free-addons/contact-form-7-mailchimp/" target="_blank">documentation</a>'
              )
          ),  
            'uacf7_mailchimp_form_enable' => array(
                'id'        => 'uacf7_mailchimp_form_enable',
                'type'      => 'switch',
                'label'     => __( ' Enable/Disable Mailchimp ', 'ultimate-addons-cf7' ),
                'label_on'  => __( 'Yes', 'ultimate-addons-cf7' ),
                'label_off' => __( 'No', 'ultimate-addons-cf7' ),
                'default'   => false
            ),
            
            'uacf7_mailchimp_api_status' => array(
              'id'        => 'uacf7_mailchimp_api_status',
              'type'     => 'callback',
              'function' => 'uacf7_mailchimp_api_status_callback',
              'argument' => $status,
          
            ), 
            'uacf7_mailchimp_form_type' => array(
              'id'        => 'uacf7_mailchimp_form_type',
              'type'      => 'radio',
              'label'     => __( ' Type of Form ', 'ultimate-addons-cf7' ),
              'options' => array(
                'subscribe' => 'Subscribe Form',
                // 'unsubscribe' => 'Unsubscribe Form',
              ),
              'default'   => 'subscribe',
              'inline'  => true
            ),
            'uacf7_mailchimp_audience' => array(
              'id'        => 'uacf7_mailchimp_audience',
              'type'      => 'select',
              'label'     => __( ' Select Audience ', 'ultimate-addons-cf7' ),
              'options' => $audience,
            ),
            'uacf7_mailchimp_subscriber_email' => array(
              'id'        => 'uacf7_mailchimp_subscriber_email',
              'type'      => 'select',
              'label'     => __( ' Subscriber Email ', 'ultimate-addons-cf7' ),
              'query_args' => array(
                'post_id'      => $post_id,  
                'specific'      => 'email', 
              ), 
              'options'   => 'uacf7',
              'field_width' => '33'
            ),
            'uacf7_mailchimp_subscriber_fname' => array(
              'id'        => 'uacf7_mailchimp_subscriber_fname',
              'type'      => 'select',
              'label'     => __( ' Subscriber First Name ', 'ultimate-addons-cf7' ),
              'query_args' => array(
                'post_id'      => $post_id,  
                'specific'      => 'text', 
              ), 
              'options'   => 'uacf7',
              'field_width' => '33'
          ),
            'uacf7_mailchimp_subscriber_lname' => array(
              'id'        => 'uacf7_mailchimp_subscriber_lname',
              'type'      => 'select',
              'label'     => __( ' Subscriber Last Name ', 'ultimate-addons-cf7' ),
              'query_args' => array(
                'post_id'      => $post_id,  
                'specific'      => 'text', 
              ), 
              'options'   => 'uacf7',
              'field_width' => '33'
          ),
          // 'uacf7_mailchimp_custom_field_headding' => array(
          //   'id'        => 'uacf7_mailchimp_custom_field_headding',
          //   'type'      => 'heading',
          //   'label'     => __( ' Custom Fields ', 'ultimate-addons-cf7' ),
  
          // ),

          'uacf7_mailchimp_merge_fields' => array(
            'id' => 'uacf7_mailchimp_merge_fields',
            'type' => 'repeater',
            'label' => 'Add New Custom Field',
            'class' => 'tf-field-class',
            'fields' => array(
               'mailtag' =>  array(
                    'id' => 'mailtag',
                    'label' => 'Contact Form Tag',
                    'type' => 'select',
                    'field_width' => '50',
                    'query_args' => array(
                      'post_id'      => $post_id,   
                      'exclude' => ['submit']
                    ), 
                    'options'   => 'uacf7',
                 ),
                'mergefield' =>  array(
                    'id' => 'mergefield',
                    'label' => 'Mailchimp Field',
                    'type' => 'text',
                    'field_width' => '50',
        
                 ),
             ),
        )
                
          



        ),
            

    ), $post_id);

    $value['mailchimp'] = $mailchimp; 
    return $value;
}


 
 

  /* Check Internet connection */
  public static function is_internet_connected()
  {
    $connected = @fsockopen("www.example.com", 80);
    if ($connected) {
      return true;
      fclose($connected);
    } else {
      return false;
    }
  }

  /* Get mailchimp api key */
  public function get_api_key() {
    
    $uacf7_mailchimp_api_key = uacf7_settings('uacf7_mailchimp_api_key');

    if( $uacf7_mailchimp_api_key != false ) {
      return $this->mailchimp_api = $uacf7_mailchimp_api_key;
    }

    $this->mailchimp_connection();

  }

  /* mailchimp Connection check */
  public function mailchimp_connection()
  {

    $api_key = $this->mailchimp_api;

    if ($api_key != '') {

      $response = $this->set_config($api_key, 'ping');
      $response = json_decode($response);

      if (isset($response->health_status)) { //Display success message
        $this->mailchimlConnection = true;
      } else {
        $this->mailchimlConnection = false;
      }
    } 
  }

  /* Mailchimp config set */
  private function set_config($api_key = '', $path = '')
  {
    $server_prefix = explode("-",$api_key);
    $server_prefix = $server_prefix[1];

    $url = "https://$server_prefix.api.mailchimp.com/3.0/$path";

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $headers = array(
      "Authorization: Bearer $api_key"
    );
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    //for debug only!
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

    $resp = curl_exec($curl);
    curl_close($curl);

    return $resp;
  }

  /* Mailchimp connection status */
  public function connection_status()
  {
    $api_key = $this->mailchimp_api;
    $status = '';
    if ($api_key != '') {

      $response = $this->set_config($api_key, 'ping');
      $response = json_decode($response);

      
      $status .= '<span class="status-title"><strong>' . esc_html__('Status: ', 'ultimate-addons-cf7') . '</strong>';

      if ($this->is_internet_connected() == false) { //Checking internet connection
        $status .= '<span class="status-error">' . esc_html__('Can\'t connect to the server. Please check internet connection.', 'ultimate-addons-cf7') . '</span>';
      }

      if (isset($response->health_status)) { //Display success message
        $status .= '<span class="status-success">' . esc_html($response->health_status) . '</span>';
      }

      if (isset($response->title)) { //Display error title
        $status .= '<span class="status-error">' . esc_html($response->title) . '</span>';
      }

      $status .= '</span>';

      if (isset($response->detail)) { //Display error mdetails
        $status .= '<span class="status-details status-error">' . esc_html($response->detail) . '</span>';
      }
    } else {
      $status .= '<span class="status-details">' . esc_html('Please enter your Mailchimp API key.', 'ultimate-addons-cf7') . '</span>';
    }

    return $status;
  }

 
 

  /* Save form data */
  public function uacf7_save_contact_form($post)
  {
    if (!isset($_POST) || empty($_POST)) {
      return;
    }

    if (!wp_verify_nonce($_POST['uacf7_mailchimp_nonce'], 'uacf7_mailchimp_nonce_action')) {
      return;
    }

    if(isset($_POST['uacf7_mailchimp_form_enable'])){
      update_post_meta( $post->id(), 'uacf7_mailchimp_form_enable', sanitize_text_field($_POST['uacf7_mailchimp_form_enable']) );
    }else{
      update_post_meta( $post->id(), 'uacf7_mailchimp_form_enable', 'off' );
    }
    update_post_meta( $post->id(), 'uacf7_mailchimp_form_type', sanitize_text_field($_POST['uacf7_mailchimp_form_type']) );

    if(isset($_POST['uacf7_mailchimp_audience'])){
      update_post_meta( $post->id(), 'uacf7_mailchimp_audience', sanitize_text_field($_POST['uacf7_mailchimp_audience']) );
    }

    update_post_meta( $post->id(), 'uacf7_mailchimp_subscriber_email', sanitize_text_field($_POST['uacf7_mailchimp_subscriber_email']) );

    if(isset($_POST['uacf7_mailchimp_subscriber_fname'])){
      update_post_meta( $post->id(), 'uacf7_mailchimp_subscriber_fname', sanitize_text_field($_POST['uacf7_mailchimp_subscriber_fname']) );
    }
    update_post_meta( $post->id(), 'uacf7_mailchimp_subscriber_lname', sanitize_text_field($_POST['uacf7_mailchimp_subscriber_lname']) );

    $all_fields = $post->scan_form_tags();
    $x = 1;
    $data = [];
    foreach( $all_fields as $field ) {
      if( $field['type'] != 'submit' ){
        if( !empty( $_POST['uacf7_mailchimp_extra_field_mailtag_'.$x] ) && !empty( $_POST['uacf7_mailchimp_extra_field_mergefield_'.$x] ) ){

          $data[$x] = array(
            'mailtag' => sanitize_text_field($_POST['uacf7_mailchimp_extra_field_mailtag_'.$x]),
            'mergefield' => sanitize_text_field($_POST['uacf7_mailchimp_extra_field_mergefield_'.$x])
          );

        }

        $x++;
      }
    }

    update_post_meta( $post->id(), 'uacf7_mailchimp_merge_fields', $data );

  }

  /* Add members to mailchimp */
  public function add_members( $id, $audience, $posted_data ) {
    $this->mailchimp_connection();

    $api_key = $this->mailchimp_api;
    
    // get mailchimp Post Data
    $mailchimp = uacf7_get_form_option( $id, 'mailchimp' );

    $subscriber_email = isset($mailchimp['uacf7_mailchimp_subscriber_email']) ? $mailchimp['uacf7_mailchimp_subscriber_email'] : '';
    $subscriber_email = !empty($subscriber_email) ? $posted_data[$subscriber_email] : '';

    if( $this->mailchimlConnection == true && $api_key != '' && $subscriber_email != '' ) {
      $server_prefix = explode("-",$api_key);
      $server_prefix = $server_prefix[1];
      $subscriber_fname = isset($mailchimp['uacf7_mailchimp_subscriber_fname']) ? $mailchimp['uacf7_mailchimp_subscriber_fname'] : '';
      $subscriber_fname = !empty($subscriber_fname) ? $posted_data[$subscriber_fname] : '';

      $subscriber_lname = isset($mailchimp['uacf7_mailchimp_subscriber_lname']) ? $mailchimp['uacf7_mailchimp_subscriber_lname'] : '';
      $subscriber_lname = !empty($subscriber_lname) ? $posted_data[$subscriber_lname] : '';

      $extra_fields = isset($mailchimp['uacf7_mailchimp_merge_fields']) && is_array($mailchimp['uacf7_mailchimp_merge_fields']) ? $mailchimp['uacf7_mailchimp_merge_fields'] : array(); 

      $extra_merge_fields = '';
      foreach( $extra_fields as $extra_field ){
        $extra_merge_fields .= '"'.$extra_field['mergefield'] . '": "' . $posted_data[$extra_field['mailtag']].'",';
      }
      $extra_merge_fields = trim($extra_merge_fields,',');

      if( $extra_merge_fields != '' ){
        $extra_merge_fields = ','.$extra_merge_fields;
      }

      $url = "https://$server_prefix.api.mailchimp.com/3.0/lists/".$audience."/members";

      $curl = curl_init($url);
      curl_setopt($curl, CURLOPT_URL, $url);
      curl_setopt($curl, CURLOPT_POST, true);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

      $headers = array(
        "Authorization: Bearer $api_key",
        "Content-Type: application/json",
      );
      curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

      //Mailchimp data
      $data = '{"email_address":"'.sanitize_email($subscriber_email).'","status":"subscribed","merge_fields":{"FNAME": "'.sanitize_text_field($subscriber_fname).'", "LNAME": "'.sanitize_text_field($subscriber_lname).'"'.$extra_merge_fields.'},"vip":false,"location":{"latitude":0,"longitude":0}}';
      
     
      curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

      //for debug only!
      curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
      curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

      $resp = curl_exec($curl); 
      curl_close($curl);  
      // return $url; 
    }
    
  }

  /* Send data before sent email */
  public function send_data($cf7)
  {
    // get the contact form object
    $wpcf = WPCF7_Submission::get_instance();

    $posted_data = $wpcf->get_posted_data();

    $id = $cf7->id();
    
    // get mailchimp Post Data
    $mailchimp = uacf7_get_form_option( $id, 'mailchimp' ); 

    $form_enable = isset($mailchimp['uacf7_mailchimp_form_enable']) ? $mailchimp['uacf7_mailchimp_form_enable'] : '';
    $form_type = isset($mailchimp['uacf7_mailchimp_form_type']) ? $mailchimp['uacf7_mailchimp_form_type'] : '';
    $audience = isset($mailchimp['uacf7_mailchimp_audience']) ? $mailchimp['uacf7_mailchimp_audience'] : '';

    if( $form_enable == true && $form_type == 'subscribe' && $audience != '' ){
      // uacf7_print_r($data);
      
      //$wpcf->skip_mail = true;
      $response = $this->add_members( $id, $audience, $posted_data );   
    } 
  }

 
}
new UACF7_MAILCHIMP();

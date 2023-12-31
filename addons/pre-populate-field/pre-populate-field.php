<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
* Pre Populate Classs
*/
class UACF7_PRE_POPULATE {
    
    /*
    * Construct function
    */
    public function __construct() {
        
        add_action( 'wp_enqueue_scripts', array($this, 'wp_enqueue_script' ) );    
        add_action( 'wp_ajax_uacf7_ajax_pre_populate_redirect', array( $this, 'uacf7_ajax_pre_populate_redirect' ) ); 
        add_action( 'wp_ajax_nopriv_uacf7_ajax_pre_populate_redirect', array( $this, 'uacf7_ajax_pre_populate_redirect' ) ); 
        add_filter( 'uacf7_post_meta_options', array($this, 'uacf7_post_meta_options_pre_populated'), 22, 2 ); 
        
    } 


    public function uacf7_post_meta_options_pre_populated( $value, $post_id){
        $list_forms = get_posts(array(
            'post_type'     => 'wpcf7_contact_form',
            'posts_per_page'   => -1
        ));
        $all_forms = array();
        foreach ($list_forms as $form) { 
            $all_forms[$form->ID] = $form->post_title; 
        }
        $pre_populated = apply_filters('uacf7_post_meta_options_pre_populated_pro', $data = array(
            'title'  => __( 'Pre Populated', 'ultimate-addons-cf7' ),
            'icon'   => 'fa-solid fa-arrow-up-right-dots',
            'fields' => array(
                
                'uacf7_pre_populated_heading' => array(
                    'id'    => 'uacf7_pre_populated_heading',
                    'type'  => 'heading', 
                    'label' => __( 'Pre Populated Settings', 'ultimate-addons-cf7' ),
                    'subtitle' => __( 'This addon will help you form pre-populate.', 'ultimate-addons-cf7' ),
                    'content' => sprintf( 
                        __( 'Not sure how to set this? Check our step by step  %1s.', 'ultimate-addons-cf7' ),
                        '<a href="https://themefic.com/docs/uacf7/free-addons/contact-form-7-pre-populate-fields/" target="_blank">documentation</a>'
                    )
                ),
             
                'pre_populate_enable' => array(
                    'id'        => 'pre_populate_enable',
                    'type'      => 'switch',
                    'label'     => __( ' Pre-Populate', 'ultimate-addons-cf7' ),
                    'label_on'  => __( 'Yes', 'ultimate-addons-cf7' ),
                    'label_off' => __( 'No', 'ultimate-addons-cf7' ),
                    'default'   => false,
                    'field_width' => 33,
                ),
                'data_redirect_url' => array(
                    'id'        => 'data_redirect_url',
                    'type'      => 'text',
                    'label'     => __( ' Redirect URL ', 'ultimate-addons-cf7' ),
                    'placeholder'     => __( ' Redirect URL ', 'ultimate-addons-cf7' ),
                    'field_width' => 33,
                ),
                'pre_populate_form' => array(
                  'id'        => 'pre_populate_form',
                  'type'      => 'select',
                  'label'     => __( ' Select Pre-Populate Form', 'ultimate-addons-cf7' ),
                  'options'     => $all_forms,
                  'field_width' => 33,
              ),

              'pre_populate_passing_field' => array(
                'id' => 'pre_populate_passing_field',
                'type' => 'repeater',
                'label' => 'Select Pre-Populate Field',
                'class' => 'tf-field-class',
                'fields' => array(
                    'field_name' => array(
                        'id' => 'field_name',
                        'type' => 'select',
                        'options'  => 'uacf7',
                        'query_args' => array(
                            'post_id'      => $post_id,  
                            'exclude'      => ['submit'], 
                        ), 
                     )
                 ),
            )
    
            ),
                
    
        ), $post_id);
    
        $value['pre_populated'] = $pre_populated; 
        return $value;
    }

    /*
    * Enqueue script Forntend
    */
    
    public function wp_enqueue_script() {
		wp_enqueue_script( 'pre-populate-script', UACF7_ADDONS . '/pre-populate-field/assets/js/pre-populate.js', array('jquery'), null, true ); 
        wp_localize_script( 'pre-populate-script', 'pre_populate_url',
            array( 
                    'ajaxurl' => admin_url( 'admin-ajax.php' ),
                    'nonce' => wp_create_nonce('uacf7-pre-populate')
                )
        );
    }
 
 
    /*
    * Product Pre-populate redirect with value after submiting form by ajax
    */
    
    public function uacf7_ajax_pre_populate_redirect() { 
        if ( ! isset( $_POST ) || empty( $_POST ) ) {
			return;
		}
        
        if ( !wp_verify_nonce($_POST['ajax_nonce'], 'uacf7-pre-populate')) {
            exit(esc_html__("Security error", 'ultimate-addons-cf7'));
        }

        $form_id = $_POST['form_id']; 
        $pre_populate = uacf7_get_form_option( $form_id, 'pre_populated' );
        $pre_populate_enable = isset($pre_populate['pre_populate_enable']) ? $pre_populate['pre_populate_enable'] : false;
        if($pre_populate_enable == true){
            $data_redirect_url = isset($pre_populate['data_redirect_url']) ? $pre_populate['data_redirect_url'] : '#';
            $pre_populate_passing_field = isset($pre_populate['pre_populate_passing_field']) ? $pre_populate['pre_populate_passing_field'] : '';
            $pre_populate_form = isset($pre_populate['pre_populate_form']) ? $pre_populate['pre_populate_form'] : '';
            $field_name = array();
            if(is_array($pre_populate_passing_field)){
                foreach($pre_populate_passing_field as $key => $value){
                    $field_name[$key] = $value['field_name'];
                }
            }
            $data = [
                'form_id' => $form_id,
                'pre_populate_enable' => $pre_populate_enable,
                'data_redirect_url' => $data_redirect_url,
                'pre_populate_passing_field' => $field_name,
                'pre_populate_form' => $pre_populate_form,
            ];
            
            echo wp_send_json($data);
        }else{
            echo false;
        }  
        wp_die();
    }
   
}
new UACF7_PRE_POPULATE();
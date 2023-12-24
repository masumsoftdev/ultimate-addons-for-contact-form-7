<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
* Pre Populate Classs
*/
class UACF7_PDF_GENERATOR {
    
    /*
    * Construct function
    */
    public function __construct() {
        
        add_action( 'admin_enqueue_scripts', array($this, 'wp_enqueue_admin_script' ) );
        add_filter( 'wpcf7_mail_components', array( $this, 'uacf7_wpcf7_mail_components' ), 10, 3 );    
        // add_filter( 'wpcf7_load_js', '__return_false' );
        add_action( 'wp_ajax_uacf7_get_generated_pdf', array( $this, 'uacf7_get_generated_pdf' ) );  
        add_filter( 'uacf7_post_meta_options', array($this, 'uacf7_post_meta_options_pdf_generator'), 18, 2 );  
        add_filter( 'uacf7_post_meta_import_export', array($this, 'uacf7_post_meta_import_export_pdf_generator'), 18, 2 );  

        require_once( 'inc/functions.php' );
 
        
    } 

     /*
    * Enqueue script Backend
    */
    
    public function wp_enqueue_admin_script() { 
         
		wp_enqueue_script( 'pdf-generator-admin', UACF7_ADDONS . '/pdf-generator/assets/js/pdf-generator-admin.js', array('jquery'),  true ); 
        $pdf_settings['codeEditor'] = wp_enqueue_code_editor(array('type' => 'text/css'));
        $pdf_settings['ajaxurl'] = admin_url( 'admin-ajax.php' );
        $pdf_settings['nonce'] = wp_create_nonce('uacf7-pdf-generator');
        wp_localize_script('jquery', 'pdf_settings', $pdf_settings);
        
        // require UACF7_PATH . 'third-party/vendor/autoload.php';

    } 
  
    public function uacf7_post_meta_options_pdf_generator( $value, $post_id){
 
        
        $pdf_generator = apply_filters('uacf7_post_meta_options_pdf_generator_pro', $data = array(
            'title'  => __( 'PDF Generator', 'ultimate-addons-cf7' ),
            'icon'   => 'fa-solid fa-file-pdf',
            'fields' => array(
                 
                'uacf7_pdf_label' => array(
                    'id'    => 'uacf7_pdf_label',
                    'type'  => 'notice',
                    'notice' => 'info',
                    'label' => __( 'PDF Generator Settings', 'ultimate-addons-cf7' ),
                    'title' => __( 'This addon will help you to create PDF using form Data.', 'ultimate-addons-cf7' ),
                    'content' => sprintf( 
                        __( 'Not sure how to set this? Check our step by step  %1s.', 'ultimate-addons-cf7' ),
                        '<a href="https://themefic.com/docs/uacf7/free-addons/contact-form-7-pdf-generator/" target="_blank">documentation</a>'
                    )
                ),  
                'uacf7_enable_pdf_generator' => array(
                    'id'        => 'uacf7_enable_pdf_generator',
                    'type'      => 'switch',
                    'label'     => __( ' Enable/Disable PDF Generator ', 'ultimate-addons-cf7' ),
                    'label_on'  => __( 'Yes', 'ultimate-addons-cf7' ),
                    'label_off' => __( 'No', 'ultimate-addons-cf7' ),
                    'default'   => false,
                    'field_width' => 50,
                ),
              
                'uacf7_pdf_name' => array(
                    'id'        => 'uacf7_pdf_name',
                    'type'      => 'text',
                    'label'     => __( 'PDF Name ', 'ultimate-addons-cf7' ),
                    'placeholder'     => __( 'Ex: pdf-name ', 'ultimate-addons-cf7' ),
                    'field_width' => 50,
            
                ),
                'pdf_send_to' => array(
                    'id'        => 'pdf_send_to',
                    'type'      => 'select',
                    'label'     => __( 'PDF Send To ', 'ultimate-addons-cf7' ),
                    'options'   => array(
                        'option 1' => 'Default',
                        'option 2' => 'Mail 1',
                        'option 3' => 'Mail 2',
                    ),
                    'field_width' => '50'
                ),
                'uacf7_pdf_disable_header_footer' => array(
                    'id'        => 'uacf7_pdf_disable_header_footer',
                    'type'      => 'checkbox',
                    'label'     => __( 'Disable Header and Footer ', 'ultimate-addons-cf7' ),
                    'options'   => array(
                        'header' => 'Disable Header',
                        'footer' => 'Disable Footer'
                    ),
                    'field_width' => '50',
                    'inline'      => true
                ),
                'uacf7_customize_pdf_body' => array(
                    'id'        => 'uacf7_customize_pdf_body',
                    'type'      => 'heading',
                    'label'     => __( ' Customize PDF Body', 'ultimate-addons-cf7' ),
                ),

                'pdf_bg_upload_image' => array(
                    'id'        => 'pdf_bg_upload_image',
                    'type'      => 'image',
                    'label'     => __( 'PDF Background Image ', 'ultimate-addons-cf7' ),

                ), 
                'pdf_content_bg_color' => array(
                    'id'        => 'pdf_content_bg_color',
                    'type'      => 'color',
                    'label'     => __( 'PDF Background Color ', 'ultimate-addons-cf7' ),
                    'field_width' => 50,
                    'class' => 'tf-field-class',
                    // 'default' => '#ffffff',
                    'multiple' => false,
                    'inline' => true,   
                ),
                'pdf_content_color' => array(
                    'id'        => 'pdf_content_color',
                    'type'      => 'color',
                    'label'     => __( 'PDF Content Color ', 'ultimate-addons-cf7' ),
                    'field_width' => 50,
                    'class' => 'tf-field-class',
                    // 'default' => '#ffffff',
                    'multiple' => false,
                    'inline' => true,   
                ),
                
                'uacf7_pdf_form_tags' => array(
                    'id'        => 'uacf7_pdf_form_tags',
                    'type'     => 'callback', 
                    'function' => 'uacf7_pdf_form_tags_callback',
                    'argument' => $post_id,
                
                ),  
                'customize_pdf' => array(
                    'id'        => 'customize_pdf',
                    'label'        => __( 'Customize PDF Content ', 'ultimate-addons-cf7' ),
                    'type'      => 'editor',

                ),
                'uacf7_customize_pdf_header' => array(
                    'id'        => 'uacf7_customize_pdf_header',
                    'type'      => 'heading',
                    'label'     => __( ' Customize PDF Header', 'ultimate-addons-cf7' ),
                    'sub_title' => __( ' header and footer page numbers & date Tags : {PAGENO}, {DATE j-m-Y}, {nb}, {nbpg} ', 'ultimate-addons-cf7' ),
                ),
                // 'uacf7_pdf_generator_mpdf_tags' => array(
                //     'id'        => 'uacf7_pdf_generator_mpdf_tags',
                //     'type'      => 'notice',
                //     'label'     => __( 'm-PDF Tags ', 'ultimate-addons-cf7' ),
                //     'class' => 'tf-field-class',
                //     'content' => '
                //     {PAGENO}, {DATE j-m-Y}, {nb}, {nbpg}
                //     ',
                // ),
                'pdf_header_upload_image' => array(
                    'id'        => 'pdf_header_upload_image',
                    'type'      => 'image',
                    'label'     => __( 'Header Image ', 'ultimate-addons-cf7' ),

                ),
 
                'pdf_header_color' => array(
                    'id'        => 'pdf_header_color',
                    'type'      => 'color',
                    'label'     => __( 'PDF Header Color ', 'ultimate-addons-cf7' ),
                    'field_width' => 50,
                    'class' => 'tf-field-class',
                    // 'default' => '#ffffff',
                    'multiple' => false,
                    'inline' => true,   
                ),
                'pdf_header_bg_color' => array(
                    'id'        => 'pdf_header_bg_color',
                    'type'      => 'color',
                    'label'     => __( 'PDF Header Background Color ', 'ultimate-addons-cf7' ),
                    'field_width' => 50,
                    'class' => 'tf-field-class',
                    // 'default' => '#ffffff',
                    'multiple' => false,
                    'inline' => true,   
                ),
                'customize_pdf_header' => array(
                    'id'        => 'customize_pdf_header',
                    'type'      => 'editor',

                ),
                'uacf7_customize_pdf_footer' => array(
                    'id'        => 'uacf7_customize_pdf_footer',
                    'type'      => 'heading',
                    'label'     => __( ' Customize PDF Footer', 'ultimate-addons-cf7' ),
                ),

                // 'uacf7_pdf_footer_background_image' => array(
                //     'id'        => 'uacf7_pdf_footer_background_image',
                //     'type'      => 'image',
                //     'label'     => __( 'PDF Footer Background Image ', 'ultimate-addons-cf7' ),

                // ),

                 
                'pdf_footer_color' => array(
                    'id'        => 'pdf_footer_color',
                    'type'      => 'color',
                    'label'     => __( 'PDF footer Content Color ', 'ultimate-addons-cf7' ), 
                    'class' => 'tf-field-class',
                    // 'default' => '#ffffff',
                    'multiple' => false,
                    'inline' => true,  
                    'field_width' => 50, 
                ),
 
                'pdf_footer_bg_color' => array(
                    'id'        => 'pdf_footer_bg_color',
                    'type'      => 'color',
                    'label'     => __( 'PDF footer Background Color ', 'ultimate-addons-cf7' ),
                    'field_width' => 50,
                    'class' => 'tf-field-class',
                    // 'default' => '#ffffff',
                    'multiple' => false,
                    'inline' => true,   
                ),

                'customize_pdf_footer' => array(
                    'id'        => 'customize_pdf_footer',
                    'type'      => 'editor',

                ),
                'uacf7_pdf_custom_css' => array(
                    'id'        => 'uacf7_pdf_custom_css',
                    'type'      => 'heading',
                    'label'     => __( 'PDF Custom CSS', 'ultimate-addons-cf7' ),
                ),
                'custom_pdf_css' => array(
                    'id'        => 'custom_pdf_css',
                    'type'      => 'code_editor',

                ), 
            ),
                
    
        ), $post_id);
    
        $value['pdf_generator'] = $pdf_generator; 
        return $value;
    }

 
 
    // Generate PDF and export form ultimate db
    public function uacf7_get_generated_pdf(){ 
        if ( ! isset( $_POST ) || empty( $_POST ) ) {
			return;
		}
        
        if ( !wp_verify_nonce($_POST['ajax_nonce'], 'uacf7-pdf-generator')) {
            exit(esc_html__("Security error", 'ultimate-addons-cf7'));
        }

        $form_id = !empty($_POST['form_id']) ? $_POST['form_id'] : '';
        $data_id = !empty($_POST['id']) ? $_POST['id'] : '';
        require UACF7_PATH . 'third-party/vendor/autoload.php';
       
        // Pdf get Meta Option
        $pdf = uacf7_get_form_option( $form_id, 'pdf_generator' );
      
        $enable_pdf = isset($pdf['uacf7_enable_pdf_generator']) ? $pdf['uacf7_enable_pdf_generator'] : 0;
        if( $enable_pdf != true){ die; }
   
        $upload_dir    = wp_upload_dir(); 
        $dir = $upload_dir['basedir'];
        $url = $upload_dir['baseurl'];
        global $wpdb; 
        $data = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM ".$wpdb->prefix."uacf7_form WHERE id = %s AND form_id = %s", $data_id, $form_id ) ); 
  
        $uacf7_pdf_name = !empty($pdf['uacf7_pdf_name']) ? $pdf['uacf7_pdf_name'] : get_the_title( $form_id );
        $disable_header = !empty($pdf['uacf7_pdf_disable_header_footer']) && in_array('header', $pdf['uacf7_pdf_disable_header_footer']) ? true : false;
        $disable_footer = !empty($pdf['uacf7_pdf_disable_header_footer']) && in_array('footer', $pdf['uacf7_pdf_disable_header_footer']) ? true : false; 
        $customize_pdf = !empty($pdf['customize_pdf']) ? $pdf['customize_pdf'] : '';
        $pdf_bg_upload_image = !empty($pdf['pdf_bg_upload_image']) ? $pdf['pdf_bg_upload_image'] : '';
        $customize_pdf_header = !empty($pdf['customize_pdf_header']) ? $pdf['customize_pdf_header'] : '';
        $pdf_header_upload_image = !empty($pdf['pdf_header_upload_image']) ? $pdf['pdf_header_upload_image'] : '';
        $pdf_header_img_height = !empty($pdf['pdf_header_img_height']) ? $pdf['pdf_header_img_height'] : '';
        $pdf_header_img_width = !empty($pdf['pdf_header_img_width']) ? $pdf['pdf_header_img_width'] : '';
        $pdf_header_img_aline = !empty($pdf['pdf_header_img_aline']) ? $pdf['pdf_header_img_aline'] : '';
        $customize_pdf_footer = !empty($pdf['customize_pdf_footer']) ? $pdf['customize_pdf_footer'] : '';
        $custom_pdf_css = !empty($pdf['custom_pdf_css']) ? $pdf['custom_pdf_css'] : ''; 
        $pdf_content_color = !empty($pdf['pdf_content_color']) ? $pdf['pdf_content_color'] : ''; 
        $pdf_content_bg_color = !empty($pdf['pdf_content_bg_color']) ? $pdf['pdf_content_bg_color'] : '';  
        $pdf_header_color = !empty($pdf['pdf_header_color']) ? $pdf['pdf_header_color'] : ''; 
        $pdf_header_bg_color = !empty($pdf['pdf_header_bg_color']) ? $pdf['pdf_header_bg_color'] : '';  
        $pdf_footer_color = !empty($pdf['pdf_footer_color']) ? $pdf['pdf_footer_color'] : ''; 
        $pdf_footer_bg_color = !empty($pdf['pdf_footer_bg_color']) ? $pdf['pdf_footer_bg_color'] : '';  
        $pdf_bg_upload_image =  !empty($pdf_bg_upload_image) ? 'background-image: url("'.esc_attr($pdf_bg_upload_image).'");' : '';
        $pdf_header_upload_image =  !empty($pdf_header_upload_image) ? '<img src="'.esc_attr( $pdf_header_upload_image ).'" style="height: 60; max-width: 100%; ">' : '';
        
        $mpdf = new \Mpdf\Mpdf([ 
            'fontdata' => [ // lowercase letters only in font key
                'dejavuserifcond' => [
                    'R' => 'DejaVuSansCondensed.ttf',
                ]
            ],
            'mode' => 'utf-8',
            'default_font' => 'dejavusanscond',
            'margin_header' => 0,
            'margin_footer' => 0,
            'format' => 'A4', 
            'margin_left' => 0,
            'margin_right' => 0
        ]); 
        

        // PDF Style
        $pdf_style = ' <style>
            body {
                 '.esc_attr( $pdf_bg_upload_image ).'
                background-repeat:no-repeat;
                background-image-resize: 6; 
            }
            .pdf-header{
                height: 60px;   
                background-color: '.esc_attr( $pdf_header_bg_color ).';
                color : '.esc_attr( $pdf_header_color ).'; 
            }
            .pdf-footer{ 
                background-color: '.esc_attr( $pdf_footer_bg_color ).';
                color : '.esc_attr( $pdf_footer_color ).'; 
            }
            .pdf-content{ 
                background-color: '.esc_attr($pdf_content_bg_color).';
                color : '.esc_attr( $pdf_content_color ).';
                padding: 20px;
                height: 100%;
            }
            .header-logo{
                text-align: '.esc_attr( $pdf_header_img_aline ).'; 
                float: left; 
                width: 20%;
            }
            .header-content{
                float: right; 
                width: 80%
                
            }
            '.$custom_pdf_css.'
        </style>';
     

        // PDF Header checked( 'on', $disable_header );
        if( $disable_header != true ){
            $mpdf->SetHTMLHeader('
            <div class="pdf-header"  >
                    <div class="header-logo"  >
                        '.$pdf_header_upload_image.'
                    </div>    
                    <div class="header-content">
                    '.$customize_pdf_header.'
                    </div>
            </div>
            ');
        }
        

        // PDF Footer
        if( $disable_footer != true ){
            $mpdf->SetHTMLFooter('<div class="pdf-footer">'.$customize_pdf_footer.'</div>');
        }
        
        $replace_key = [];
        $repeaters = [];
        $repeater_value = [];
        $replace_value = []; 
        $uploaded_files = [];
        
       $form_value =  json_decode($data->form_value); 
        foreach($form_value as $key => $value){
            // Repeater value gate
            if (strpos($key, '__') !== false) {
                $name_parts = explode('__', $key); 
                if(is_array($name_parts)){
                    $repeater_value[$name_parts[0]][$name_parts[1]] = $name_parts[0];  
                }
            }

            if(strpos($key,"_count") !== false){ 
                $repeaters[] = str_replace('_count', '', $key) ;
            }

            $replace_key[] = '['.$key.']';
            if( is_array($value)){
                $data = '';
                $count_value = count($value);
                for ($x = 0; $x < $count_value ; $x++) {
                    if($x == 0){ 
                        $data .= $value[$x];
                    }else{
                        $data .= ', '.$value[$x]; 
                    }
                    
                } 
                $value = $data;
            }
            $replace_value[] = $value;
        }   

        // Repeater value
        if(isset($repeaters) || is_array($repeaters)){
            $repeater_data = apply_filters('uacf7_pdf_generator_replace_data', $repeater_value, $repeaters, $customize_pdf); 
            $customize_pdf = str_replace($repeater_data['replace_re_key'], $repeater_data['replace_re_value'], $customize_pdf); 
        }  

        $pdf_content = str_replace($replace_key, $replace_value, $customize_pdf);
 
        $mpdf->SetTitle($uacf7_pdf_name);

        // PDF Footer Content
        $mpdf->WriteHTML($pdf_style.'<div class="pdf-content">'.nl2br($pdf_content).'   </div>');
        
        $pdf_dir = $dir.'/uacf7-uploads/'.$uacf7_pdf_name.'_db_.pdf';
        $pdf_url = $url.'/uacf7-uploads/'.$uacf7_pdf_name.'_db_.pdf';
        $mpdf->Output($pdf_dir, 'F'); // Dwonload
        
        wp_send_json( 
            array(
                'status' => 'success',
                'url' => $pdf_url
            )
        );
       
        die();
    }

    function uacf7_wpcf7_mail_components( $components, $form = null, $mail = null  ) { 
       

        $wpcf7 = WPCF7_ContactForm::get_current(); 

        // Pdf get Meta Option
        $pdf = uacf7_get_form_option( $wpcf7->id(), 'pdf_generator' );

        $enable_pdf = isset($pdf['uacf7_enable_pdf_generator']) ? $pdf['uacf7_enable_pdf_generator'] : 0;
        $pdf_send_to = isset($pdf['pdf_send_to']) ? $pdf['pdf_send_to'] : '';
        if(($pdf_send_to == 'mail-1' && $mail->name() == 'mail_2') || ($pdf_send_to == 'mail-2' && $mail->name() == 'mail') ){
            return $components;
        }
        if($enable_pdf == true){ 
            $submission = WPCF7_Submission::get_instance();
            $contact_form_data = $submission->get_posted_data();
            $files            = $submission->uploaded_files();
           
            require UACF7_PATH . 'third-party/vendor/autoload.php';
            $upload_dir    = wp_upload_dir(); 
            $time_now      = time();
            $dir = $upload_dir['basedir'];
            $uploaded_files = [];
            $uacf7_dirname = $upload_dir['basedir'].'/uacf7-uploads';
            if ( ! file_exists( $uacf7_dirname ) ) {
                wp_mkdir_p( $uacf7_dirname ); 
            } 
            foreach ($_FILES as $file_key => $file) {
                array_push($uploaded_files, $file_key);
            }

            //  
            $uacf7_pdf_name = !empty($pdf['uacf7_pdf_name']) ? $pdf['uacf7_pdf_name'] : get_the_title( $wpcf7->id() );
            $disable_header = !empty($pdf['uacf7_pdf_disable_header_footer']) && in_array('header', $pdf['uacf7_pdf_disable_header_footer']) ? true : false;
            $disable_footer = !empty($pdf['uacf7_pdf_disable_header_footer']) &&  in_array('footer', $pdf['uacf7_pdf_disable_header_footer']) ? true : false; 
            $customize_pdf = !empty($pdf['customize_pdf']) ? $pdf['customize_pdf'] : '';
            $pdf_bg_upload_image = !empty($pdf['pdf_bg_upload_image']) ? $pdf['pdf_bg_upload_image'] : '';
            $customize_pdf_header = !empty($pdf['customize_pdf_header']) ? $pdf['customize_pdf_header'] : '';
            $pdf_header_upload_image = !empty($pdf['pdf_header_upload_image']) ? $pdf['pdf_header_upload_image'] : '';
            $pdf_header_img_height = !empty($pdf['pdf_header_img_height']) ? $pdf['pdf_header_img_height'] : '';
            $pdf_header_img_width = !empty($pdf['pdf_header_img_width']) ? $pdf['pdf_header_img_width'] : '';
            $pdf_header_img_aline = !empty($pdf['pdf_header_img_aline']) ? $pdf['pdf_header_img_aline'] : '';
            $customize_pdf_footer = !empty($pdf['customize_pdf_footer']) ? $pdf['customize_pdf_footer'] : '';
            $custom_pdf_css = !empty($pdf['custom_pdf_css']) ? $pdf['custom_pdf_css'] : ''; 
            $pdf_content_color = !empty($pdf['pdf_content_color']) ? $pdf['pdf_content_color'] : ''; 
            $pdf_content_bg_color = !empty($pdf['pdf_content_bg_color']) ? $pdf['pdf_content_bg_color'] : '';  
            $pdf_header_color = !empty($pdf['pdf_header_color']) ? $pdf['pdf_header_color'] : ''; 
            $pdf_header_bg_color = !empty($pdf['pdf_header_bg_color']) ? $pdf['pdf_header_bg_color'] : '';  
            $pdf_footer_color = !empty($pdf['pdf_footer_color']) ? $pdf['pdf_footer_color'] : ''; 
            $pdf_footer_bg_color = !empty($pdf['pdf_footer_bg_color']) ? $pdf['pdf_footer_bg_color'] : '';  
            $pdf_bg_upload_image =  !empty($pdf_bg_upload_image) ? 'background-image: url("'.esc_attr( $pdf_bg_upload_image ).'");' : '';
            $pdf_header_upload_image =  !empty($pdf_header_upload_image) ? '<img src="'.esc_attr( $pdf_header_upload_image ).'" style="height: 60; max-width: 100%; ">' : ''; 
            $mpdf = new \Mpdf\Mpdf([ 
                'fontdata' => [ // lowercase letters only in font key
                    'dejavuserifcond' => [
                        'R' => 'DejaVuSansCondensed.ttf',
                    ]
                ],
                'mode' => 'utf-8',
                'default_font' => 'dejavusanscond',
                'margin_header' => 0,
                'margin_footer' => 0,
                'format' => 'A4', 
                'margin_left' => 0,
                'margin_right' => 0
            ]); 
            $replace_key = [];

            // PDF Style
            $pdf_style = ' <style>
                body {
                     '.$pdf_bg_upload_image.'
                    background-repeat:no-repeat;
                    background-image-resize: 6; 
                }
                .pdf-header{
                    height: 60px;   
                    background-color: '.esc_attr( $pdf_header_bg_color ).';
                    color : '.esc_attr( $pdf_header_color ).'; 
                }
                .pdf-footer{ 
                    background-color: '.esc_attr( $pdf_footer_bg_color ).';
                    color : '.esc_attr( $pdf_footer_color ).'; 
                }
                .pdf-content{ 
                    background-color: '.esc_attr( $pdf_content_bg_color ).';
                    color : '.esc_attr( $pdf_content_color ).';
                    padding: 20px;
                    height: 100%;
                }
                .header-logo{
                    text-align: '.esc_attr( $pdf_header_img_aline ).'; 
                    float: left; 
                    width: 20%;
                }
                .header-content{
                    float: right; 
                    width: 80%
                    
                }
                '.$custom_pdf_css.'
            </style>';
            $replace_value = []; 

            // PDF Header
            if($disable_header != true){
                $mpdf->SetHTMLHeader('
                <div class="pdf-header"  >
                        <div class="header-logo"  >
                            '.$pdf_header_upload_image.'
                        </div>    
                        <div class="header-content">
                        '.$customize_pdf_header.'
                        </div>
                </div>
                ');
            }
             
            // PDF Footer
            if($disable_footer != true){ 
                $mpdf->SetHTMLFooter('<div class="pdf-footer">'.$customize_pdf_footer.'</div>');
            }

            $repeater_value = []; 
            foreach($contact_form_data as $key => $value){
                if(!in_array($key, $uploaded_files)){ 
                    $replace_key[] = '['.$key.']';
                    
                    // Repeater value gate
                    if (strpos($key, '__') !== false) {
                        $name_parts = explode('__', $key); 
                        if(is_array($name_parts)){
                            $repeater_value[$name_parts[0]][$name_parts[1]] = $name_parts[0];  
                        }
                    }
                    
                    if( is_array($value)){
                        
                        $data = '';
                        $count_value = count($value);
                        for ($x = 0; $x < $count_value ; $x++) {
                            if($x == 0){ 
                                $data .= $value[$x];
                            }else{
                                $data .= ', '.$value[$x]; 
                            }
                            
                        } 
                        $value = $data;
                    } 
                    $replace_value[] = $value;
                }
                
            } 
            foreach ($files as $file_key => $file) {
                if(!empty($file)){
                    if(in_array($file_key, $uploaded_files)){ 
                        $file = is_array( $file ) ? reset( $file ) : $file; 
                        $dir_link = '/uacf7-uploads/'.$time_now.'-'.$file_key.'-'.basename($file);
                        copy($file, $dir.$dir_link); 
                        $replace_key[] = '['.$file_key.']';
                        $replace_value[] = $upload_dir['baseurl'].$dir_link; 
                    }  
                }
                
            } 
 
            // Repeater value
            if(isset($_POST['_uacf7_repeaters'])){
                $repeaters = json_decode(stripslashes($_POST['_uacf7_repeaters'])); 
                
                if(isset($repeaters) || is_array($repeaters)){
                    $repeater_data = apply_filters('uacf7_pdf_generator_replace_data', $repeater_value, $repeaters, $customize_pdf);
                    
                    $customize_pdf = str_replace($repeater_data['replace_re_key'], $repeater_data['replace_re_value'], $customize_pdf);
                } 
            } 

            $pdf_content = str_replace($replace_key, $replace_value, $customize_pdf);
           
            // Replace PDF Name
            $uacf7_pdf_name = str_replace($replace_key, $replace_value, $uacf7_pdf_name);
         
            $mpdf->SetTitle($uacf7_pdf_name);

             // PDF Footer Content
            $mpdf->WriteHTML($pdf_style.'<div class="pdf-content">'.nl2br($pdf_content).'   </div>');

            $pdf_url = $dir.'/uacf7-uploads/'.$uacf7_pdf_name.'.pdf';
            
            $mpdf->Output($pdf_url, 'F'); // save to databaes 
           
            $components['attachments'][] = $pdf_url; 
        }
        return $components;
      
    }

    // Import Export 
    public function uacf7_post_meta_import_export_pdf_generator( $imported_data, $form_id ) {
        if ( isset( $imported_data['pdf_generator'] ) && function_exists('uacf7_import_export_file_upload') ) {
            $imported_data['pdf_generator']['pdf_bg_upload_image'] = uacf7_import_export_file_upload( $imported_data['pdf_generator']['pdf_bg_upload_image'] );
        } 
        if ( isset( $imported_data['pdf_generator'] ) && function_exists('uacf7_import_export_file_upload') ) {
            $imported_data['pdf_generator']['pdf_header_upload_image'] = uacf7_import_export_file_upload( $imported_data['pdf_generator']['pdf_header_upload_image'] );
        } 
        return $imported_data;
    }
   
     
}
 
new UACF7_PDF_GENERATOR();
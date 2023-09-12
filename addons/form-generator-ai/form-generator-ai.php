<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class UACF7_FORM_GENERATOR{

    /*
    * Construct function
    */
    public function __construct() { 
        //
        define( 'UACF7_FORM_AI_PATH', UACF7_PATH.'/addons/form-generator-ai' );
        // admin scripts
        add_action('admin_enqueue_scripts', array($this, 'admin_scripts'));

        // form tab panel
        // add_action( 'wpcf7_editor_panels', array( $this, 'uacf7_add_panel' ) );

        // add Popup Contact form 7 admin footer
        add_action( 'wpcf7_admin_footer', array( $this, 'uacf7_form_admin_footer_popup' ) );

        // Ai form generator Ajax Function
        add_action( 'wp_ajax_uacf7_form_generator_ai', array( $this, 'uacf7_form_generator_ai' ) ); 
    }


    // Add Admin Scripts
    public function admin_scripts(){  
        wp_enqueue_script( 'uacf7-form-generator-ai-choices-js', UACF7_ADDONS . '/form-generator-ai/assets/js/choices.min.js', array(), null, true );  
        wp_enqueue_script( 'uacf7-form-generator-ai-admin-js', UACF7_ADDONS . '/form-generator-ai/assets/js/admin-form-generator-ai.js', array('jquery'), null, true ); 
        wp_enqueue_style( 'uacf7-form-generator-ai-choices-css', UACF7_ADDONS . '/form-generator-ai/assets/css/choices.css' ); 
        wp_enqueue_style( 'uacf7-form-generator-ai-admin-css', UACF7_ADDONS . '/form-generator-ai/assets/css/admin-form-generator-ai.css' );

        wp_localize_script( 'uacf7-form-generator-ai-admin-js', 'uacf7_form_ai',
            array( 
                'ajaxurl' => admin_url( 'admin-ajax.php' ),
                'nonce' => wp_create_nonce( 'uacf7-form-generator-ai-nonce' ),
            ) 
        );
    }


    // Add Form Tab Panel
    public function uacf7_add_panel( $panels ) {
        $panels['uacf7-form-generator-ai-panel'] = array(
            'title' => __( 'Form Generator AI', 'contact-form-7' ),
            'callback' => array( $this, 'uacf7_form_generatorform_generator_ai_panel' ),
        );
        return $panels;
    }

    public function uacf7_form_generatorform_generator_ai_panel(){ 
           
    }


    public function uacf7_form_admin_footer_popup(){
        ob_start();
        
        ?>
            <div class="uacf7-form-ai-popup">
                <div class="uacf7-form-ai-wrap"> 
                    <div class="uacf7-form-ai-inner"> 
                        <div class="close" title="Exit Full Screen">╳</div>
                        <div class="uacf7-ai-form-column"> 
                            <div class="uacf7-form-input-wrap">
                                
                                <h4>Create a</h4>
                               <div class="uacf7-form-input-inner">
                                <select class="form-control" data-trigger name="uacf7-form-generator-ai" id="uacf7-form-generator-ai"
                                    placeholder="This is a placeholder" multiple> 
                                </select>
                                <p class="uacf7-ai-hins">hins: Create a Multistep Form</p>
                                
                                <button class="uacf7_ai_search_button">Generate With AI</button>
                               </div>
                                
                            </div>
                        </div> 
                        <div class="uacf7-ai-form-column"> 
                            <div class="uacf7-ai-codeblock"> 
                                <div class="uacf7-ai-navigation">
                                    <span class="uacf7-ai-code-copy"> <?php echo _e( 'Copy', 'ultimate-addons-cf7' ); ?></span>
                                    <span class="uacf7-ai-code-insert"> <?php echo _e( 'Insert', 'ultimate-addons-cf7' ); ?></span>
                                </div>
                                <textarea name="uacf7_ai_code_content" disable id="uacf7_ai_code_content" ></textarea>
                            </div>
                        </div> 
                        
                    </div>
                </div>
            </div> 
        <?php
        echo ob_get_clean();
    }

    public function uacf7_form_generator_ai(){
        if ( !wp_verify_nonce($_POST['ajax_nonce'], 'uacf7-form-generator-ai-nonce')) {
            exit(esc_html__("Security error", 'ultimate-addons-cf7'));
        }
        $vaue = '';
        $uacf7_default = $_POST['searchValue']; 
        if(count($uacf7_default) > 0 || $uacf7_default[0] == 'form'){ 
            $value=  require_once  apply_filters( 'uacf7_ai_form_generator_template', UACF7_FORM_AI_PATH . '/templates/'.$uacf7_default[1].'.php', $uacf7_default);
        } 
        $data = [
            'status' => 'success',
            'value' => $value,
        ];
        echo wp_send_json($data);
        die();
    }
}

new UACF7_FORM_GENERATOR();


?>
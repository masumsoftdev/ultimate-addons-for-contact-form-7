<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class UACF7_FORM_GENERATOR{

    /*
    * Construct function
    */
    public function __construct() {
        // add_action( 'wpcf7_init', array($this, 'add_shortcodes') );

        // add_action( 'admin_init', array( $this, 'tag_generator' ) );

        // add_filter( 'wpcf7_validate_uacf7_form_generator', array($this, 'uacf7_form_generator_validation_filter'), 10, 2 );
        
        // add_filter( 'wpcf7_validate_uacf7_form_generator*', array($this,'uacf7_form_generator_validation_filter'), 10, 2 );

        // admin scripts
        add_action('admin_enqueue_scripts', array($this, 'admin_scripts'));

        // form tab panel
        add_action( 'wpcf7_editor_panels', array( $this, 'uacf7_add_panel' ) );

        // add Popup Contact form 7 admin footer
        add_action( 'wpcf7_admin_footer', array( $this, 'uacf7_form_admin_footer_popup' ) );
    }


    // Add Admin Scripts
    public function admin_scripts(){  
        wp_enqueue_script( 'uacf7-form-generator-ai-typeahead-js', UACF7_ADDONS . '/form-generator-ai/assets/js/typeahead.jquery.min.js', array('jquery'), null, true ); 
        wp_enqueue_script( 'uacf7-form-generator-ai-admin-js', UACF7_ADDONS . '/form-generator-ai/assets/js/admin-form-generator-ai.js', array('jquery'), null, true ); 
        wp_enqueue_style( 'uacf7-form-generator-ai-admin-cs', UACF7_ADDONS . '/form-generator-ai/assets/css/admin-form-generator-ai.css' );
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
                <div class="uacf7-form-input">
                    <input type="text" id="uacf7_ai_serach" name="uacf7_ai_serach">
                    <button class="uacf7_ai_search_button">Generate With AI</button>
                </div>
                <span class="uacf7-ai-hins">hins: Create a Multistep Form</span>
            </div>
        </div>

        <?php
        echo ob_get_clean();

    }
}

new UACF7_FORM_GENERATOR();


?>
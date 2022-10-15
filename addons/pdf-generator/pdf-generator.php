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
        
        // add_action( 'wp_enqueue_scripts', array($this, 'wp_enqueue_script' ) );  
        add_action( 'admin_enqueue_scripts', array($this, 'wp_enqueue_admin_script' ) );    
        add_action( 'wpcf7_editor_panels', array( $this, 'uacf7_add_panel' ) );     
        add_action( 'wpcf7_after_save', array( $this, 'uacf7_save_contact_form' ) );   
       
    } 

 
    /*
    * Enqueue script Backend
    */
    
    public function wp_enqueue_admin_script() {
        wp_enqueue_style( 'pdf-generator-admin-style', UACF7_ADDONS . '/pdf-generator/assets/css/pdf-generator-admin.css' );
		wp_enqueue_script( 'pdf-generator-admin', UACF7_ADDONS . '/pdf-generator/assets/js/pdf-generator.js', array('jquery'), null, true ); 
         
    } 

    /*
    * Function create tab panel
    */
    public function uacf7_add_panel( $panels ) {
		$panels['uacf7-pdf-generator-panel'] = array(
            'title'    => __( 'UACF7 PDF Generator', 'ultimate-addons-cf7' ),
			'callback' => array( $this, 'uacf7_create_pdf_generator_panel_fields' ),
		);
		return $panels;
	}
    
   
    /*
    * Function PDF Generator fields
    */
    public function uacf7_create_pdf_generator_panel_fields($post) {

         // get existing value 
         $uacf7_enable_pdf_generator = get_post_meta( $post->id(), 'uacf7_enable_pdf_generator', true ); 
        ?>
        <h2><?php echo esc_html__( 'PDF Generator', 'ultimate-addons-cf7' ); ?></h2>
        <p><?php echo esc_html__('This feature will help you to create pdf after form submission, send to mail, stored pdf into the server and export pdf form the admin.','ultimate-addons-cf7'); ?></p>
        <div class="uacf7-doc-notice">Not sure how to set this? Check our step by step <a href="https://themefic.com/docs/ultimate-addons-for-contact-form-7/pdf-generator/" target="_blank">documentation</a>.</div>
        <fieldset>
           <div class="ultimate-placeholder-admin">
               <div class="ultimate-placeholder-wrapper">
                 
                  <?php $placeholder_styles = get_post_meta( $post->id(), 'uacf7_enable_placeholder_styles', true ); ?>
                  <h3>Enable PDF Generator</h3>
                  <label for="uacf7_enable_pdf_generator">  
                       <input id="uacf7_enable_pdf_generator" type="checkbox" name="uacf7_enable_pdf_generator" <?php checked( 'on', $uacf7_enable_pdf_generator ); ?> > Enable
                   </label><br><br>
                  <hr>
                   <h3>Color and Font Options</h3>
                      
               </div>
                <p>Need more placeholder or other options? Let us know <a href="https://themefic.com/contact/" target="_blank">here</a>.</p>
           </div>
        </fieldset>
        <?php
        wp_nonce_field( 'uacf7_pdf_generator_nonce_action', 'uacf7_pdf_generator_nonce' );
	}
    public function uacf7_save_contact_form( $form ) {
        
        if ( ! isset( $_POST ) || empty( $_POST ) ) {
			return;
		}
        if ( ! wp_verify_nonce( $_POST['uacf7_pdf_generator_nonce'], 'uacf7_pdf_generator_nonce_action' ) ) {
            return;
        }

        update_post_meta( $form->id(), 'uacf7_enable_pdf_generator', $_POST['uacf7_enable_pdf_generator'] );
         
    }
   
     
}
 
new UACF7_PDF_GENERATOR();
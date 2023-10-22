<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class UACF7_Placeholder {
    
    /*
    * Construct function
    */
    public function __construct() {
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_placeholder_style' ) );
		// add_action( 'wpcf7_editor_panels', array( $this, 'uacf7_add_panel' ) );
        // add_action( 'wpcf7_after_save', array( $this, 'uacf7_save_contact_form' ) );
        add_filter( 'wpcf7_contact_form_properties', array( $this, 'uacf7_properties' ), 10, 2 );
        add_filter( 'uacf7_post_meta_options', array( $this, 'uacf7_post_meta_options_placeholder' ), 12, 2 );  
    }
	
	public function admin_enqueue_placeholder_styles() {
        wp_enqueue_style( 'uacf7-placeholder-style', UACF7_URL . 'addons/', array(), null, true );
    }
    
    public function enqueue_placeholder_style() {
        wp_enqueue_style( 'uacf7-placeholder', UACF7_ADDONS . '/placeholder/css/placeholder-style.css' );
        wp_enqueue_script( 'uacf7-placeholder-script', UACF7_ADDONS . '/placeholder/js/color-pickr.js', array('jquery', 'wp-color-picker' ), '', true );
    }

    // Add Placeholder Options
    public function uacf7_post_meta_options_placeholder($value, $post_id){
        $redirection = apply_filters('uacf7_post_meta_options_placeholder_pro', $data = array(
			'title'  => __( 'Placeholder', 'ultimate-addons-cf7' ),
			'icon'   => 'fa-solid fa-italic',
			'fields' => array(
				'placeholder_headding' => array(
					'id'    => 'placeholder_headding',
					'type'  => 'heading',
					'label' => __( 'Placeholder Styles', 'ultimate-addons-cf7' ),
					'sub_title' => __( 'This feature will help you to edit the Styles of Placeholder of your form. Note that, all below fields are optional. If any field is not needed, leave them blank.', 'ultimate-addons-cf7' ),
				),
				'uacf7_enable_placeholder_styles' => array(
					'id'        => 'uacf7_enable_placeholder_styles',
					'type'      => 'switch',
					'label'     => __( ' Enable Placeholder ', 'ultimate-addons-cf7' ),
					'label_on'  => __( 'Yes', 'ultimate-addons-cf7' ),
					'label_off' => __( 'No', 'ultimate-addons-cf7' ),
					'default'   => false
				),
                'uacf7_placeholder_color_option' => array(
                    'id' => 'uacf7_placeholder_color_option',
                    'type' => 'color',
                    'label'     => __( 'Color Options', 'ultimate-addons-cf7' ), 
                    'subtitle'     => __( 'Customize Placeholder Color Options', 'ultimate-addons-cf7' ), 
                    'class' => 'tf-field-class',
                    'default' => '#ffffff',
                    'multiple' => true,
                    'inline' => true,
                    'colors' => array(
                        'uacf7_placeholder_color' => 'Color',
                        'uacf7_placeholder_background_color' => 'Background Color', 
                    ), 
                ),
                'uacf7_placeholder_fontstyle' => array(
					'id'        => 'uacf7_placeholder_fontstyle',
					'type'      => 'select',
					'label'     => __( 'Font Style', 'ultimate-addons-cf7' ),  
					'subtitle'     => __( 'Select form style', 'ultimate-addons-cf7' ),  
					'options'     => array(
						'normal'      => 'Normal',
						'italic' => "Italic",
					), 
				),
                'uacf7_placeholder_fontweight' => array(
					'id'        => 'uacf7_placeholder_fontweight',
					'type'      => 'select',
					'label'     => __( 'Font Weight ', 'ultimate-addons-cf7' ),  
					'subtitle'     => __( 'Select form Weight', 'ultimate-addons-cf7' ),  
					'options'     => array(
						'normal'      => 'Normal / 400',
						'300' => "300",
						'500' => "500",
						'700' => "700",
						'900' => "900",
					), 
				), 
				'uacf7_placeholder_fontsize' => array(
					'id'        => 'uacf7_placeholder_fontsize',
					'type'      => 'number',
					'label'     => __( 'Font Size (in px)', 'ultimate-addons-cf7' ),  
					'subtitle'     => __( 'E.g. 16 (Do not add px or em ).', 'ultimate-addons-cf7' ),  
                    'placeholder'     => __( 'Enter Placeholder Font Size (in px)', 'ultimate-addons-cf7' ), 
				),
				'uacf7_placeholder_fontfamily' => array(
					'id'        => 'uacf7_placeholder_fontfamily',
					'type'      => 'text',
					'label'     => __( 'Font Name ', 'ultimate-addons-cf7' ),  
					'subtitle'     => __( " E.g. Roboto, sans-serif (Do not add special characters like '' or ; ) ", "ultimate-addons-cf7" ),  
                    'placeholder'     => __( 'Enter Placeholder Font Name ', 'ultimate-addons-cf7' ), 
				),
                array(
                    'id' => 'uacf7_placeholder_notice',
                    'type' => 'notice',
                    'content' => __( " Need more placeholder or other options? Let us know here . ", "ultimate-addons-cf7" ),  
                    'class' => 'tf-field-class',   
                    'notice' => 'info',
                )  
			),
		), $post_id);
		$value['placeholder'] = $redirection; 
		return $value;
    }   
    
    /*
    * Function create tab panel
    */
    public function uacf7_add_panel( $panels ) {
		$panels['uacf7-placeholder-panel'] = array(
            'title'    => __( 'UACF7 Placeholder', 'ultimate-addons-cf7' ),
			'callback' => array( $this, 'uacf7_create_placeholder_panel_fields' ),
		);
		return $panels;
	}
    
    /*
    * Function Placeholder fields
    */
    public function uacf7_create_placeholder_panel_fields( $post ) {
        // get existing value
        $fontfamily = get_post_meta( $post->id(), 'uacf7_placeholder_fontfamily', true );
        $fontsize = get_post_meta( $post->id(), 'uacf7_placeholder_fontsize', true );
        $fontstyle = get_post_meta( $post->id(), 'uacf7_placeholder_fontstyle', true );
        $fontweight = get_post_meta( $post->id(), 'uacf7_placeholder_fontweight', true );
        $color = get_post_meta( $post->id(), 'uacf7_placeholder_color', true );
        $background_color = get_post_meta( $post->id(), 'uacf7_placeholder_background_color', true );
        ?>
        <h2><?php echo esc_html__( 'Placeholder Styles', 'ultimate-addons-cf7' ); ?></h2>
        <p><?php echo esc_html__('This feature will help you to edit the Styles of Placeholder of your form. Note that, all below fields are optional. If any field is not needed, leave them blank.','ultimate-addons-cf7'); ?></p>
        <div class="uacf7-doc-notice">
            <?php echo sprintf( 
                __( 'Not sure how to set this? Check our step by step %1s .', 'ultimate-addons-cf7' ),
                '<a href="https://themefic.com/docs/uacf7/free-addons/contact-form-7-placeholder-styling/" target="_blank">documentation</a>'   
            ); ?>
            </div>
        <fieldset>
           <div class="ultimate-placeholder-admin">
               <div class="ultimate-placeholder-wrapper">
                 
                  <?php $placeholder_styles = get_post_meta( $post->id(), 'uacf7_enable_placeholder_styles', true ); ?>
                  <h3><?php echo esc_html__( "Placeholder Styles", "ultimate-addons-cf7" ); ?> </h3>
                  <label for="uacf7_enable_placeholder_styles">  
                       <input id="uacf7_enable_placeholder_styles" type="checkbox" name="uacf7_enable_placeholder_styles" <?php checked( 'on', $placeholder_styles ); ?> > Enable
                   </label><br><br>
                  <hr>
                   <h3><?php echo esc_html__( "Color and Font Options", "ultimate-addons-cf7" ); ?> </h3>
                    <div class="placeholder-fourcolumns">
                        <h4>Color</h4>
                        <input type="text" id="uacf7-placeholder-color" name="uacf7_placeholder_color" class="uacf7-color-picker" value="<?php echo esc_attr_e($color); ?>" placeholder="<?php echo esc_html__( 'Enter Placeholder Color', 'ultimate-addons-cf7' ); ?>"><br><br>
                    </div>
                    <div class="placeholder-fourcolumns">
                        <h4> <?php echo esc_html__( "Background Color", "ultimate-addons-cf7" ); ?> </h4>
                        <input type="text" id="uacf7-placeholder-background-color" name="uacf7_placeholder_background_color" class="uacf7-color-picker" value="<?php echo esc_attr_e($background_color); ?>" placeholder="<?php echo esc_html__( 'Enter Placeholder Background Color', 'ultimate-addons-cf7' ); ?>"><br><br>
                    </div>
                    <div class="placeholder-fourcolumns">
                        <h4>Font Style</h4>
                        <select name="uacf7_placeholder_fontstyle" id="uacf7-placeholder-fontstyle">
                            <option value="<?php esc_attr_e('normal'); ?>" <?php selected( 'normal', esc_attr($fontstyle), true ); ?>><?php echo esc_html('Normal'); ?></option>
                            <option value="<?php esc_attr_e('italic'); ?>" <?php selected( 'italic', esc_attr($fontstyle), true ); ?> ><?php echo esc_html('Italic'); ?></option>
                        </select>
                    </div>
                    <div class="placeholder-fourcolumns">
                        <h4><?php echo esc_html__( "Font Weight", "ultimate-addons-cf7" ); ?> </h4>
                        <select name="uacf7_placeholder_fontweight" id="uacf7-placeholder-fontweight">
                            <option value="<?php esc_attr_e('normal'); ?>" <?php selected( 'normal', esc_attr($fontweight), true ); ?>><?php echo esc_html('Normal / 400'); ?></option>
                            <option value="<?php esc_attr_e('300'); ?>" <?php selected( '300', esc_attr($fontweight), true ); ?>><?php echo esc_html('300'); ?></option>
                            <option value="<?php esc_attr_e('500'); ?>" <?php selected( '500', esc_attr($fontweight), true ); ?>><?php echo esc_html('500'); ?></option>
                            <option value="<?php esc_attr_e('700'); ?>" <?php selected( '700', esc_attr($fontweight), true ); ?>><?php echo esc_html('700'); ?></option>
                            <option value="<?php esc_attr_e('900'); ?>" <?php selected( '900', esc_attr($fontweight), true ); ?>><?php echo esc_html('900'); ?></option>
                        </select>
                        <br><br>
                    </div>
                    <div class="clear"></div>
                    <hr>
                    <div class="placeholder-columns">
                        <h4><?php echo esc_html__( " Font Size (in px)", "ultimate-addons-cf7" ); ?></h4>
                        <input type="number" id="uacf7-placeholder-fontsize" name="uacf7_placeholder_fontsize" class="large-text" value="<?php echo esc_attr_e($fontsize); ?>" placeholder="<?php echo esc_html__( 'Enter Placeholder Font Size (in px)', 'ultimate-addons-cf7' ); ?>"><small>E.g. <span>16</span> (Do not add px or em ).</small><br><br>
                    </div>
                    <div class="placeholder-columns">
                        <h4><?php echo esc_html__( "Font Name", "ultimate-addons-cf7" ); ?> </h4>
                        <input type="text" id="uacf7-placeholder-fontfamily" name="uacf7_placeholder_fontfamily" class="large-text" value="<?php echo esc_attr_e($fontfamily); ?>" placeholder="<?php echo esc_html__( 'Enter Placeholder Font Name', 'ultimate-addons-cf7' ); ?>"><small>E.g. <span>Roboto, sans-serif</span> <?php echo esc_html__( "(Do not add special characters like '' or ; )", "ultimate-addons-cf7" ); ?> </small><br><br>
                    </div>
                    <div class="clear"></div>
               </div>
                <p>
                    <?php echo sprintf( 
                        __( 'Need more placeholder or other options? Let us know %1s .', 'ultimate-addons-cf7' ),
                        '<a href="https://themefic.com/contact/" target="_blank">here</a>'  
                    ); ?>
                </p>
           </div>
        </fieldset>
        <?php
         wp_nonce_field( 'uacf7_placeholder_nonce_action', 'uacf7_placeholder_nonce' );
    }
    
    public function uacf7_save_contact_form( $form ) {
        
        if ( ! isset( $_POST ) || empty( $_POST ) ) {
			return;
		}
        if ( ! wp_verify_nonce( $_POST['uacf7_placeholder_nonce'], 'uacf7_placeholder_nonce_action' ) ) {
            return;
        }
 
        if(isset($_POST['uacf7_enable_placeholder_styles'])){
            update_post_meta( $form->id(), 'uacf7_enable_placeholder_styles', sanitize_text_field($_POST['uacf7_enable_placeholder_styles']) );
        }else{
            update_post_meta( $form->id(), 'uacf7_enable_placeholder_styles', 'off' );
        }
        if(isset($_POST['uacf7_placeholder_fontfamily'])){ 
            update_post_meta( $form->id(), 'uacf7_placeholder_fontfamily', sanitize_text_field($_POST['uacf7_placeholder_fontfamily']) );
        }
        if(isset($_POST['uacf7_placeholder_fontsize'])){ 
            update_post_meta( $form->id(), 'uacf7_placeholder_fontsize', sanitize_text_field($_POST['uacf7_placeholder_fontsize']) );
        } 
        if(isset($_POST['uacf7_placeholder_fontstyle'])){ 
            update_post_meta( $form->id(), 'uacf7_placeholder_fontstyle', sanitize_text_field($_POST['uacf7_placeholder_fontstyle']) );
        }   
        if(isset($_POST['uacf7_placeholder_fontweight'])){ 
            update_post_meta( $form->id(), 'uacf7_placeholder_fontweight', sanitize_text_field($_POST['uacf7_placeholder_fontweight']) );
        }   
        if(isset($_POST['uacf7_placeholder_color'])){ 
            update_post_meta( $form->id(), 'uacf7_placeholder_color', sanitize_text_field($_POST['uacf7_placeholder_color']) );
        }     
        if(isset($_POST['uacf7_placeholder_background_color'])){ 
            update_post_meta( $form->id(), 'uacf7_placeholder_background_color', sanitize_text_field($_POST['uacf7_placeholder_background_color']) );
        }
    }
    
    public function uacf7_properties($properties, $cfform) {
	
        if (!is_admin() || (defined('DOING_AJAX') && DOING_AJAX)) { 

            $form = $properties['form'];
            
            $form_meta = uacf7_get_form_option( $cfform->id(), 'placeholder' );

            $placeholder_styles = isset($form_meta['uacf7_enable_placeholder_styles']) ? $form_meta['uacf7_enable_placeholder_styles'] : false ;
            
            if( $placeholder_styles == true ) :
            
            ob_start(); 

            $fontfamily = $form_meta['uacf7_placeholder_fontfamily'];
            $fontsize = $form_meta['uacf7_placeholder_fontsize'];
            $fontstyle = $form_meta['uacf7_placeholder_fontstyle'];
            $fontweight = $form_meta['uacf7_placeholder_fontweight'];
            $color = isset($form_meta['uacf7_placeholder_color_option']) ? $form_meta['uacf7_placeholder_color_option']['uacf7_placeholder_color'] : '';
            $background_color = isset($form_meta['uacf7_placeholder_color_option']) ? $form_meta['uacf7_placeholder_color_option']['uacf7_placeholder_background_color'] : '';
            ?>
            <style>
                .uacf7-form-<?php esc_attr_e( $cfform->id() ); ?> ::placeholder {
                    color: <?php echo esc_attr_e($color); ?>;
                    background-color: <?php echo esc_attr_e($background_color); ?>;
                    font-size: <?php echo esc_attr_e($fontsize).'px'; ?>;
                    font-family: <?php echo esc_attr_e($fontfamily); ?>;
                    font-style: <?php echo esc_attr_e($fontstyle); ?>;
                    font-weight: <?php echo esc_attr_e($fontweight); ?>;
                }
                .uacf7-form-<?php esc_attr_e( $cfform->id() ); ?> ::-webkit-input-placeholder { /* Edge */
                    color: <?php echo esc_attr_e($color); ?>;
                    background-color: <?php echo esc_attr_e($background_color); ?>;
                    font-size: <?php echo esc_attr_e($fontsize).'px'; ?>;
                    font-family: <?php echo esc_attr_e($fontfamily); ?>;
                    font-style: <?php echo esc_attr_e($fontstyle); ?>;
                    font-weight: <?php echo esc_attr_e($fontweight); ?>;
                }
                .uacf7-form-<?php esc_attr_e( $cfform->id() ); ?> :-ms-input-placeholder { /* Internet Explorer 10-11 */
                    color: <?php echo esc_attr_e($color); ?>;
                    background-color: <?php echo esc_attr_e($background_color); ?>;
                    font-size: <?php echo esc_attr_e($fontsize).'px'; ?>;
                    font-family: <?php echo esc_attr_e($fontfamily); ?>;
                    font-style: <?php echo esc_attr_e($fontstyle); ?>;
                    font-weight: <?php echo esc_attr_e($fontweight); ?>;
                }
            </style>
            <?php
            echo $form;
            $properties['form'] = ob_get_clean();
            
            endif;
        }

        return $properties;
    }
   
}
new UACF7_Placeholder();
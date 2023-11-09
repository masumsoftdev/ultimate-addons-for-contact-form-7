<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class UACF7_uacf7style {
    
    /*
    * Construct function
    */
    public function __construct() {
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_uacf7style_style' ) );
		// add_action( 'wpcf7_editor_panels', array( $this, 'uacf7_add_panel' ) );
        // add_action( 'wpcf7_after_save', array( $this, 'uacf7_save_contact_form' ) );
        add_filter( 'wpcf7_contact_form_properties', array( $this, 'uacf7_properties' ), 10, 2 );
        add_filter( 'uacf7_post_meta_options', array( $this, 'uacf7_post_meta_options_styler' ), 13, 2 );  
    }
	
	public function admin_enqueue_uacf7style_styles() {
        wp_enqueue_style( 'uacf7-uacf7style-style', UACF7_URL . 'addons/', array(), null, true );
    }
    
    public function enqueue_uacf7style_style() {
        wp_enqueue_style( 'uacf7-uacf7style', UACF7_ADDONS . '/styler/css/uacf7styler.css' );
         
        
		global $pagenow;
		if( isset($_GET['page']) ){
			if ( ($pagenow == 'admin.php') && ($_GET['page'] == 'wpcf7') || ($_GET['page'] == 'wpcf7-new') ) {
				$cm_settings['codeEditor'] = wp_enqueue_code_editor(array('type' => 'text/css'));
        		wp_localize_script('jquery', 'cm_settings', $cm_settings);
        		wp_enqueue_script('wp-theme-plugin-editor');
        		wp_enqueue_style('wp-codemirror');
				wp_enqueue_script( 'uacf7-uacf7style-script', UACF7_ADDONS . '/styler/js/custom.js', array('jquery', 'wp-color-picker' ), '', true );
			}
		}
		
    }
    

    // Add Placeholder Options
    public function uacf7_post_meta_options_styler($value, $post_id){
        $redirection = apply_filters('uacf7_post_meta_options_styler_pro', $data = array(
            'title'  => __( 'Form Styles', 'ultimate-addons-cf7' ),
            'icon'   => 'fa-solid fa-italic',
            'fields' => array(
                'styler_headding' => array(
					'id'    => 'styler_headding',
					'type'  => 'notice',
					'notice' => 'info',
					'label' => __( 'Form Styles', 'ultimate-addons-cf7' ),
					'title' => __( 'This addon will help you to edit the Styles of your form. Note that, all below fields are optional. If any field is not needed, leave them blank.', 'ultimate-addons-cf7' ),
                    'content' => sprintf( 
                        __( 'Not sure how to set this? Check our step by step  %1s.', 'ultimate-addons-cf7' ),
                        '<a href="https://themefic.com/docs/uacf7/free-addons/contact-form-7-style/" target="_blank">documentation</a>'
                    )
				),  
                'uacf7_enable_form_styles' => array(
                    'id'        => 'uacf7_enable_form_styles',
                    'type'      => 'switch',
                    'label'     => __( 'Enable Form Styles', 'ultimate-addons-cf7' ),
                    'label_on'  => __( 'Yes', 'ultimate-addons-cf7' ),
                    'label_off' => __( 'No', 'ultimate-addons-cf7' ),
                    'default'   => false
                ),
                'styler_headding_label' => array(
                    'id'    => 'styler_headding_label',
                    'type'  => 'heading',
                    'label' => __( 'Label Options', 'ultimate-addons-cf7' ), 
                ),
                'uacf7_uacf7style_label_color_option' => array(
                    'id' => 'uacf7_uacf7style_label_color_option',
                    'type' => 'color',
                    'label'     => __( 'Color Options', 'ultimate-addons-cf7' ), 
                    'subtitle'     => __( 'Customize Placeholder Color Options', 'ultimate-addons-cf7' ), 
                    'class' => 'tf-field-class',
                    // 'default' => '#ffffff',
                    'multiple' => true,
                    'inline' => true,
                    'colors' => array(
                        'uacf7_uacf7style_label_color' => 'Color',
                        'uacf7_uacf7style_label_background_color' => 'Background Color', 
                    ), 
                ),
                'uacf7_uacf7style_label_font_style' => array(
                    'id'        => 'uacf7_uacf7style_label_font_style',
                    'type'      => 'select',
                    'label'     => __( 'Font Style', 'ultimate-addons-cf7' ),  
                    'subtitle'     => __( 'Select form style', 'ultimate-addons-cf7' ),  
                    'options'     => array(
                        'normal'      => 'Normal',
                        'italic' => "Italic",
                    ),
                    'field_width' => 50,
                ),
                'uacf7_uacf7style_label_font_weight' => array(
                    'id'        => 'uacf7_uacf7style_label_font_weight',
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
                    'field_width' => 50,
                ), 
                'uacf7_uacf7style_label_font_size' => array(
                    'id'        => 'uacf7_uacf7style_label_font_size',
                    'type'      => 'number',
                    'label'     => __( 'Font Size (in px)', 'ultimate-addons-cf7' ),  
                    'subtitle'     => __( 'E.g. 16 (Do not add px or em ).', 'ultimate-addons-cf7' ),  
                    'placeholder'     => __( 'Enter Placeholder Font Size (in px)', 'ultimate-addons-cf7' ),
                    'field_width' => 50,
                ),
                'uacf7_uacf7style_label_font_family' => array(
                    'id'        => 'uacf7_uacf7style_label_font_family',
                    'type'      => 'text',
                    'label'     => __( 'Font Name ', 'ultimate-addons-cf7' ),  
                    'subtitle'     => __( " E.g. Roboto, sans-serif (Do not add special characters like '' or ; ) ", "ultimate-addons-cf7" ),  
                    'placeholder'     => __( 'Enter Placeholder Font Name ', 'ultimate-addons-cf7' ),
                    'field_width' => 50, 
                ),
                'styler_headding_label_padding' => array(
                    'id'    => 'styler_headding_label_padding',
                    'type'  => 'heading',
                    'title' => __( 'Padding (in px)', 'ultimate-addons-cf7' ), 
                    'content' => __( ' E.g. 16 (Do not add px or em ).', 'ultimate-addons-cf7' ), 
                ),
                'uacf7_uacf7style_label_padding_top' => array(
                    'id'        => 'uacf7_uacf7style_input_padding_top',
                    'type'      => 'number',
                    'label'     => __( 'Top', 'ultimate-addons-cf7' ),   
                    'placeholder'     => __( 'Top', 'ultimate-addons-cf7' ), 
                    'field_width' => 20,
                ),
                'uacf7_uacf7style_label_padding_right' => array(
                    'id'        => 'uacf7_uacf7style_label_padding_right',
                    'type'      => 'number',
                    'label'     => __( 'Right', 'ultimate-addons-cf7' ),   
                    'placeholder'     => __( 'Right', 'ultimate-addons-cf7' ), 
                    'field_width' => 20,
                ), 
                'uacf7_uacf7style_label_padding_bottom' => array(
                    'id'        => 'uacf7_uacf7style_label_padding_bottom',
                    'type'      => 'number',
                    'label'     => __( 'Bottom', 'ultimate-addons-cf7' ),   
                    'placeholder'     => __( 'Bottom', 'ultimate-addons-cf7' ), 
                    'field_width' => 20,
                ), 
                'uacf7_uacf7style_label_padding_left' => array(
                    'id'        => 'uacf7_uacf7style_label_padding_left',
                    'type'      => 'number',
                    'label'     => __( 'Left', 'ultimate-addons-cf7' ),   
                    'placeholder'     => __( 'Left', 'ultimate-addons-cf7' ), 
                    'field_width' => 20,
                ), 
                'styler_headding_label_margin' => array(
                    'id'    => 'styler_headding_label_margin',
                    'type'  => 'heading',
                    'title' => __( 'Margin (in px)', 'ultimate-addons-cf7' ), 
                    'content' => __( ' E.g. 16(Do not add px or em ). ', 'ultimate-addons-cf7' ), 
                ),
                'uacf7_uacf7style_label_margin_top' => array(
                    'id'        => 'uacf7_uacf7style_label_margin_top',
                    'type'      => 'number',
                    'label'     => __( 'Top', 'ultimate-addons-cf7' ),   
                    'placeholder'     => __( 'Top', 'ultimate-addons-cf7' ), 
                    'field_width' => 20,
                ),
                'uacf7_uacf7style_label_margin_right' => array(
                    'id'        => 'uacf7_uacf7style_label_margin_right',
                    'type'      => 'number',
                    'label'     => __( 'Right', 'ultimate-addons-cf7' ),   
                    'placeholder'     => __( 'Right', 'ultimate-addons-cf7' ), 
                    'field_width' => 20,
                ), 
                'uacf7_uacf7style_label_margin_bottom' => array(
                    'id'        => 'uacf7_uacf7style_label_margin_bottom',
                    'type'      => 'number',
                    'label'     => __( 'Bottom', 'ultimate-addons-cf7' ),   
                    'placeholder'     => __( 'Bottom', 'ultimate-addons-cf7' ), 
                    'field_width' => 20,
                ), 
                'uacf7_uacf7style_label_margin_left' => array(
                    'id'        => 'uacf7_uacf7style_label_margin_left',
                    'type'      => 'number',
                    'label'     => __( 'Left', 'ultimate-addons-cf7' ),   
                    'placeholder'     => __( 'Left', 'ultimate-addons-cf7' ), 
                    'field_width' => 20,
                ),  
                'styler_headding_input' => array(
                    'id'    => 'styler_headding_label',
                    'type'  => 'heading',
                    'label' => __( 'Input Field Options', 'ultimate-addons-cf7' ), 
                ),
                'uacf7_uacf7style_input_color_option' => array(
                    'id' => 'uacf7_uacf7style_input_color_option',
                    'type' => 'color',
                    'label'     => __( 'Color Options', 'ultimate-addons-cf7' ), 
                    'subtitle'     => __( 'Customize Placeholder Color Options', 'ultimate-addons-cf7' ), 
                    'class' => 'tf-field-class',
                    // 'default' => '#ffffff',
                    'multiple' => true,
                    'inline' => true,
                    'colors' => array(
                        'uacf7_uacf7style_input_color' => 'Color',
                        'uacf7_uacf7style_input_background_color' => 'Background Color', 
                    ), 
                ), 
                'uacf7_uacf7style_input_font_style' => array(
                    'id'        => 'uacf7_uacf7style_input_font_style',
                    'type'      => 'select',
                    'label'     => __( 'Font Style', 'ultimate-addons-cf7' ),  
                    'subtitle'     => __( 'Select form style', 'ultimate-addons-cf7' ),  
                    'options'     => array(
                        'normal'      => 'Normal',
                        'italic' => "Italic",
                    ), 
                    'field_width' => 50,
                ),
                'uacf7_uacf7style_input_font_weight' => array(
                    'id'        => 'uacf7_uacf7style_input_font_weight',
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
                    'field_width' => 50,
                ), 
                'uacf7_uacf7style_input_font_size' => array(
                    'id'        => 'uacf7_uacf7style_input_font_size',
                    'type'      => 'number',
                    'label'     => __( 'Font Size (in px)', 'ultimate-addons-cf7' ),  
                    'subtitle'     => __( 'E.g. 16 (Do not add px or em ).', 'ultimate-addons-cf7' ),  
                    'placeholder'     => __( 'Enter Input Font Size', 'ultimate-addons-cf7' ),
                    'field_width' => 50,
                ),
                'uacf7_uacf7style_input_font_family' => array(
                    'id'        => 'uacf7_uacf7style_input_font_family',
                    'type'      => 'text',
                    'label'     => __( 'Font Name ', 'ultimate-addons-cf7' ),  
                    'subtitle'     => __( " E.g. Roboto, sans-serif (Do not add special characters like '' or ; ) ", "ultimate-addons-cf7" ),  
                    'placeholder'     => __( 'Enter Input Font Name ', 'ultimate-addons-cf7' ), 
                    'field_width' => 50,
                ),
                'uacf7_uacf7style_input_height' => array(
                    'id'        => 'uacf7_uacf7style_input_height',
                    'type'      => 'number',
                    'label'     => __( 'Input Height (in px)', 'ultimate-addons-cf7' ),  
                    'subtitle'     => __( 'E.g. 16 (Do not add px or em ).', 'ultimate-addons-cf7' ),  
                    'placeholder'     => __( 'Enter Input Height', 'ultimate-addons-cf7' ), 
                    'field_width' => 50,
                ),
                
                'uacf7_uacf7style_textarea_input_height' => array(
                    'id'        => 'uacf7_uacf7style_textarea_input_height',
                    'type'      => 'number',
                    'label'     => __( 'Input (Textarea) Height (in px)', 'ultimate-addons-cf7' ),  
                    'subtitle'     => __( 'E.g. 16 (Do not add px or em ).', 'ultimate-addons-cf7' ),  
                    'placeholder'     => __( 'Enter Textarea Height', 'ultimate-addons-cf7' ),
                    'field_width' => 50,
                ),
                'styler_headding_input_padding' => array(
                    'id'    => 'styler_headding_input_padding',
                    'type'  => 'heading',
                    'title' => __( 'Padding (in px)', 'ultimate-addons-cf7' ), 
                    'content' => __( ' E.g. 16 (Do not add px or em ).', 'ultimate-addons-cf7' ), 
                ),
                'uacf7_uacf7style_input_padding_top' => array(
                    'id'        => 'uacf7_uacf7style_input_padding_top',
                    'type'      => 'number',
                    'label'     => __( 'Top', 'ultimate-addons-cf7' ),   
                    'placeholder'     => __( 'Top', 'ultimate-addons-cf7' ), 
                    'field_width' => 20,
                ),
                'uacf7_uacf7style_input_padding_right' => array(
                    'id'        => 'uacf7_uacf7style_input_padding_right',
                    'type'      => 'number',
                    'label'     => __( 'Right', 'ultimate-addons-cf7' ),   
                    'placeholder'     => __( 'Right', 'ultimate-addons-cf7' ), 
                    'field_width' => 20,
                ), 
                'uacf7_uacf7style_input_padding_bottom' => array(
                    'id'        => 'uacf7_uacf7style_input_padding_bottom',
                    'type'      => 'number',
                    'label'     => __( 'Bottom', 'ultimate-addons-cf7' ),   
                    'placeholder'     => __( 'Bottom', 'ultimate-addons-cf7' ), 
                    'field_width' => 20,
                ), 
                'uacf7_uacf7style_input_padding_left' => array(
                    'id'        => 'uacf7_uacf7style_input_padding_left',
                    'type'      => 'number',
                    'label'     => __( 'Left', 'ultimate-addons-cf7' ),   
                    'placeholder'     => __( 'Left', 'ultimate-addons-cf7' ), 
                    'field_width' => 20,
                ), 
                'styler_headding_input_margin' => array(
                    'id'    => 'styler_headding_input_margin',
                    'type'  => 'heading',
                    'title' => __( 'Margin (in px)', 'ultimate-addons-cf7' ), 
                    'content' => __( ' E.g. 16(Do not add px or em ). ', 'ultimate-addons-cf7' ), 
                ),
                'uacf7_uacf7style_input_margin_top' => array(
                    'id'        => 'uacf7_uacf7style_input_margin_top',
                    'type'      => 'number',
                    'label'     => __( 'Top', 'ultimate-addons-cf7' ),   
                    'placeholder'     => __( 'Top', 'ultimate-addons-cf7' ), 
                    'field_width' => 20,
                ),
                'uacf7_uacf7style_input_margin_right' => array(
                    'id'        => 'uacf7_uacf7style_input_margin_right',
                    'type'      => 'number',
                    'label'     => __( 'Right', 'ultimate-addons-cf7' ),   
                    'placeholder'     => __( 'Right', 'ultimate-addons-cf7' ), 
                    'field_width' => 20,
                ), 
                'uacf7_uacf7style_input_margin_bottom' => array(
                    'id'        => 'uacf7_uacf7style_input_margin_bottom',
                    'type'      => 'number',
                    'label'     => __( 'Bottom', 'ultimate-addons-cf7' ),   
                    'placeholder'     => __( 'Bottom', 'ultimate-addons-cf7' ), 
                    'field_width' => 20,
                ), 
                'uacf7_uacf7style_input_margin_left' => array(
                    'id'        => 'uacf7_uacf7style_input_margin_left',
                    'type'      => 'number',
                    'label'     => __( 'Left', 'ultimate-addons-cf7' ),   
                    'placeholder'     => __( 'Left', 'ultimate-addons-cf7' ), 
                    'field_width' => 20,
                ), 
                'styler_headding_input_border' => array(
                    'id'    => 'styler_headding_input_border',
                    'type'  => 'heading',
                    'title' => __( 'Border ', 'ultimate-addons-cf7' ),  
                ),
                'uacf7_uacf7style_input_border_width' => array(
                    'id'        => 'uacf7_uacf7style_input_border_width',
                    'type'      => 'number',
                    'label'     => __( 'Border Width (in px)', 'ultimate-addons-cf7' ),   
                    'placeholder'     => __( 'Enter input border width', 'ultimate-addons-cf7' ), 
                    'content' => __( ' E.g. 16(Do not add px or em ). ', 'ultimate-addons-cf7' ), 
                    'field_width' => 33,
                ), 
                'uacf7_uacf7style_input_border_style' => array(
                    'id'        => 'uacf7_uacf7style_input_border_style',
                    'type'      => 'select',
                    'label'     => __( 'Border Style ', 'ultimate-addons-cf7' ),   
                    'options'     => array(
                        'none'      => 'None',
                        'dotted' => "Dotted",
                        'dashed' => "Dashed",
                        'solid' => "Solid",
                        'double' => "Double",
                    ),
                    'field_width' => 33,
                ), 
                'uacf7_uacf7style_input_border_radius' => array(
                    'id'        => 'uacf7_uacf7style_input_border_radius',
                    'type'      => 'number',
                    'label'     => __( 'Border Radius (in px)', 'ultimate-addons-cf7' ),   
                    'placeholder'     => __( 'Enter input border radius', 'ultimate-addons-cf7' ), 
                    'content' => __( ' E.g. 16(Do not add px or em ). ', 'ultimate-addons-cf7' ), 
                    'field_width' => 33,
                ),
                'uacf7_uacf7style_input_border_color' => array(
                    'id' => 'uacf7_uacf7style_input_border_color',
                    'type' => 'color',
                    'label'     => __( 'Border Color', 'ultimate-addons-cf7' ), 
                    // 'subtitle'     => __( 'Customize Placeholder Color Options', 'ultimate-addons-cf7' ), 
                    'class' => 'tf-field-class',
                    // 'default' => '#ffffff',
                    'multiple' => false,
                    'inline' => true,
                    // 'colors' => array(
                    //     'uacf7_uacf7style_label_color' => 'Color',
                    //     'uacf7_uacf7style_label_background_color' => 'Background Color', 
                    // ), 
                ), 
                'styler_headding_button' => array(
                    'id'    => 'styler_headding_label',
                    'type'  => 'heading',
                    'label' => __( 'Submit Button Options', 'ultimate-addons-cf7' ), 
                ),
                'uacf7_uacf7style_btn_color_option' => array(
                    'id' => 'uacf7_uacf7style_btn_color_option',
                    'type' => 'color',
                    'label'     => __( 'Border Color', 'ultimate-addons-cf7' ),  
                    'class' => 'tf-field-class',
                    // 'default' => '#ffffff',
                    'multiple' => true,
                    'inline' => true,
                    'colors' => array(
                        'uacf7_uacf7style_btn_color' => 'Color',
                        'uacf7_uacf7style_btn_color_hover' => 'Color (hover)', 
                        'uacf7_uacf7style_btn_background_color' => 'Background Color (hover)', 
                        'uacf7_uacf7style_btn_background_color_hover' => 'Background Color (hover)', 
                    ),  
                ),
                'uacf7_uacf7style_btn_font_size' => array(
                    'id'        => 'uacf7_uacf7style_btn_font_size',
                    'type'      => 'number',
                    'label'     => __( 'Font Size (in px)', 'ultimate-addons-cf7' ),   
                    'placeholder'     => __( 'Enter input border width', 'ultimate-addons-cf7' ), 
                    'content' => __( 'E.g. 16 (Do not add px or em ).', 'ultimate-addons-cf7' ), 
                    'field_width' => 50,
                ), 
                'uacf7_uacf7style_btn_font_style' => array(
                    'id'        => 'uacf7_uacf7style_btn_font_style',
                    'type'      => 'select',
                    'label'     => __( 'Font Style', 'ultimate-addons-cf7' ),   
                    'options'     => array(
                        'normal'      => 'Normal',
                        'italic' => "Italic", 
                    ),
                    'field_width' => 50,
                ), 
                'uacf7_uacf7style_btn_font_weight' => array(
                    'id'        => 'uacf7_uacf7style_btn_font_weight',
                    'type'      => 'select',
                    'label'     => __( 'Font Weight', 'ultimate-addons-cf7' ),   
                    'options'     => array(
                        'normal'      => 'Normal / 400',
                        '300' => "300",
                        '500' => "500",
                        '700' => "700",
                        '900' => "900",
                    ),
                    'field_width' => 50,
                ), 
                'uacf7_uacf7style_btn_width' => array(
                    'id'        => 'uacf7_uacf7style_btn_width',
                    'type'      => 'text',
                    'label'     => __( 'Width (in px or %)', 'ultimate-addons-cf7' ),   
                    'placeholder'     => __( 'Enter input border width', 'ultimate-addons-cf7' ), 
                    'content' => __( ' E.g. 100px or 100%.', 'ultimate-addons-cf7' ), 
                    'field_width' => 50,
                ), 
                'uacf7_uacf7style_btn_border_style' => array(
                    'id'        => 'uacf7_uacf7style_btn_border_style',
                    'type'      => 'select',
                    'label'     => __( 'Border Style ', 'ultimate-addons-cf7' ),   
                    'options'     => array(
                        'none'      => 'None',
                        'dotted' => "Dotted",
                        'dashed' => "Dashed",
                        'solid' => "Solid",
                        'double' => "Double",
                    ),
                    'field_width' => 33,
                ),
                'uacf7_uacf7style_btn_border_width' => array(
                    'id'        => 'uacf7_uacf7style_btn_border_width',
                    'type'      => 'number',
                    'label'     => __( 'Border Width (in px)', 'ultimate-addons-cf7' ),   
                    'placeholder'     => __( 'Enter Button border width', 'ultimate-addons-cf7' ), 
                    'content' => __( ' E.g. 16 (Do not add px or em ).', 'ultimate-addons-cf7' ), 
                    'field_width' => 50,
                ), 
                'uacf7_uacf7style_btn_border_radius' => array(
                    'id'        => 'uacf7_uacf7style_btn_border_radius',
                    'type'      => 'number',
                    'label'     => __( 'Border Radius (in px)', 'ultimate-addons-cf7' ),   
                    'placeholder'     => __( 'Enter Button border radius', 'ultimate-addons-cf7' ), 
                    'content' => __( ' E.g. 16 (Do not add px or em ).', 'ultimate-addons-cf7' ), 
                    'field_width' => 50,
                ), 
                'uacf7_uacf7style_btn_border_color' => array(
                    'id' => 'uacf7_uacf7style_btn_border_color',
                    'type' => 'color',
                    'label'     => __( 'Border Color', 'ultimate-addons-cf7' ),  
                    'class' => 'tf-field-class',
                    // 'default' => '#ffffff',
                    'multiple' => false,
                    'inline' => false,
                    // 'colors' => array(
                    //     'uacf7_uacf7style_btn_color' => 'Color',
                    //     'uacf7_uacf7style_btn_color_hover' => 'Color (hover)', 
                    //     'uacf7_uacf7style_btn_background_color' => 'Background Color (hover)', 
                    //     'uacf7_uacf7style_btn_background_color_hover' => 'Background Color (hover)', 
                    // ),  
                    'field_width' => 33,
                ),
                'uacf7_uacf7style_btn_border_color_hover' => array(
                    'id' => 'uacf7_uacf7style_btn_border_color_hover',
                    'type' => 'color',
                    'label'     => __( 'Border Color (Hover)', 'ultimate-addons-cf7' ),  
                    'class' => 'tf-field-class',
                    // 'default' => '#ffffff',
                    'multiple' => false,
                    'inline' => true,
                    // 'colors' => array(
                    //     'uacf7_uacf7style_btn_color' => 'Color',
                    //     'uacf7_uacf7style_btn_color_hover' => 'Color (hover)', 
                    //     'uacf7_uacf7style_btn_background_color' => 'Background Color (hover)', 
                    //     'uacf7_uacf7style_btn_background_color_hover' => 'Background Color (hover)', 
                    // ),  
                    'field_width' => 33, 
                ),
                'uacf7_uacf7style_btn_padding' => array(
                    'id'    => 'uacf7_uacf7style_btn_padding',
                    'type'  => 'heading',
                    'title' => __( 'Padding (in px)', 'ultimate-addons-cf7' ), 
                    'content' => __( ' E.g. 16 (Do not add px or em ).', 'ultimate-addons-cf7' ), 
                ),
                'uacf7_uacf7style_btn_padding_top' => array(
                    'id'        => 'uacf7_uacf7style_btn_padding_top',
                    'type'      => 'number',
                    'label'     => __( 'Top', 'ultimate-addons-cf7' ),   
                    'placeholder'     => __( 'Top', 'ultimate-addons-cf7' ), 
                    'field_width' => 20,
                ),
                'uacf7_uacf7style_btn_padding_right' => array(
                    'id'        => 'uacf7_uacf7style_btn_padding_right',
                    'type'      => 'number',
                    'label'     => __( 'Right', 'ultimate-addons-cf7' ),   
                    'placeholder'     => __( 'Right', 'ultimate-addons-cf7' ), 
                    'field_width' => 20,
                ), 
                'uacf7_uacf7style_btn_padding_bottom' => array(
                    'id'        => 'uacf7_uacf7style_btn_padding_bottom',
                    'type'      => 'number',
                    'label'     => __( 'Bottom', 'ultimate-addons-cf7' ),   
                    'placeholder'     => __( 'Bottom', 'ultimate-addons-cf7' ), 
                    'field_width' => 20,
                ), 
                'uacf7_uacf7style_btn_padding_left' => array(
                    'id'        => 'uacf7_uacf7style_btn_padding_left',
                    'type'      => 'number',
                    'label'     => __( 'Left', 'ultimate-addons-cf7' ),   
                    'placeholder'     => __( 'Left', 'ultimate-addons-cf7' ), 
                    'field_width' => 20,
                ), 
                'uacf7_uacf7style_btn_margin' => array(
                    'id'    => 'uacf7_uacf7style_btn_margin',
                    'type'  => 'heading',
                    'title' => __( 'Margin (in px)', 'ultimate-addons-cf7' ), 
                    'content' => __( ' E.g. 16(Do not add px or em ). ', 'ultimate-addons-cf7' ), 
                ),
                'uacf7_uacf7style_btn_margin_top' => array(
                    'id'        => 'uacf7_uacf7style_btn_margin_top',
                    'type'      => 'number',
                    'label'     => __( 'Top', 'ultimate-addons-cf7' ),   
                    'placeholder'     => __( 'Top', 'ultimate-addons-cf7' ), 
                    'field_width' => 20,
                ),
                'uacf7_uacf7style_btn_margin_right' => array(
                    'id'        => 'uacf7_uacf7style_btn_margin_right',
                    'type'      => 'number',
                    'label'     => __( 'Right', 'ultimate-addons-cf7' ),   
                    'placeholder'     => __( 'Right', 'ultimate-addons-cf7' ), 
                    'field_width' => 20,
                ), 
                'uacf7_uacf7style_btn_margin_bottom' => array(
                    'id'        => 'uacf7_uacf7style_btn_margin_bottom',
                    'type'      => 'number',
                    'label'     => __( 'Bottom', 'ultimate-addons-cf7' ),   
                    'placeholder'     => __( 'Bottom', 'ultimate-addons-cf7' ), 
                    'field_width' => 20,
                ), 
                'uacf7_uacf7style_btn_margin_left' => array(
                    'id'        => 'uacf7_uacf7style_btn_margin_left',
                    'type'      => 'number',
                    'label'     => __( 'Left', 'ultimate-addons-cf7' ),   
                    'placeholder'     => __( 'Left', 'ultimate-addons-cf7' ), 
                    'field_width' => 20,
                ), 
                // array(
                //     'id' => 'tf-editor',
                //     'type' => 'editor',
                //     'label' => 'Enter your label',
                //     'subtitle' => 'Enter your subtitle',
                //     'description' => 'Enter your description',
                //     'class' => 'tf-field-class',
                // ) 
            ),
        ), $post_id);
        $value['styler'] = $redirection; 
        return $value;
    }   


    /*
    * Function create tab panel
    */
    public function uacf7_add_panel( $panels ) {
		$panels['uacf7-uacf7style-panel'] = array(
            'title'    => __( 'UACF7 Form Styler', 'ultimate-addons-cf7' ),
			'callback' => array( $this, 'uacf7_create_uacf7style_panel_fields' ),
		);
		return $panels;
	}
    
    /*
    * Function uacf7style fields
    */
    public function uacf7_create_uacf7style_panel_fields( $post ) {
        // get existing value
        $label_color = get_post_meta( $post->id(), 'uacf7_uacf7style_label_color', true );
        $label_background_color = get_post_meta( $post->id(), 'uacf7_uacf7style_label_background_color', true );
        $label_font_size = get_post_meta( $post->id(), 'uacf7_uacf7style_label_font_size', true );
        $label_font_family = get_post_meta( $post->id(), 'uacf7_uacf7style_label_font_family', true );
        $label_font_style = get_post_meta( $post->id(), 'uacf7_uacf7style_label_font_style', true );
        $label_font_weight = get_post_meta( $post->id(), 'uacf7_uacf7style_label_font_weight', true );
        $label_padding_top = get_post_meta( $post->id(), 'uacf7_uacf7style_label_padding_top', true );
        $label_padding_right = get_post_meta( $post->id(), 'uacf7_uacf7style_label_padding_right', true );
        $label_padding_bottom = get_post_meta( $post->id(), 'uacf7_uacf7style_label_padding_bottom', true );
        $label_padding_left = get_post_meta( $post->id(), 'uacf7_uacf7style_label_padding_left', true );
        $label_margin_top = get_post_meta( $post->id(), 'uacf7_uacf7style_label_margin_top', true );
        $label_margin_right = get_post_meta( $post->id(), 'uacf7_uacf7style_label_margin_right', true );
        $label_margin_bottom = get_post_meta( $post->id(), 'uacf7_uacf7style_label_margin_bottom', true );
        $label_margin_left = get_post_meta( $post->id(), 'uacf7_uacf7style_label_margin_left', true );
        
        $input_color = get_post_meta( $post->id(), 'uacf7_uacf7style_input_color', true );
        $input_background_color = get_post_meta( $post->id(), 'uacf7_uacf7style_input_background_color', true );
        $input_font_size = get_post_meta( $post->id(), 'uacf7_uacf7style_input_font_size', true );
        $input_font_family = get_post_meta( $post->id(), 'uacf7_uacf7style_input_font_family', true );
        $input_font_style = get_post_meta( $post->id(), 'uacf7_uacf7style_input_font_style', true );
        $input_font_weight = get_post_meta( $post->id(), 'uacf7_uacf7style_input_font_weight', true );
        $input_height = get_post_meta( $post->id(), 'uacf7_uacf7style_input_height', true );
        $input_border_width = get_post_meta( $post->id(), 'uacf7_uacf7style_input_border_width', true );
        $input_border_color = get_post_meta( $post->id(), 'uacf7_uacf7style_input_border_color', true );
        $input_border_style = get_post_meta( $post->id(), 'uacf7_uacf7style_input_border_style', true );
        $input_border_radius = get_post_meta( $post->id(), 'uacf7_uacf7style_input_border_radius', true );
        $textarea_input_height = get_post_meta( $post->id(), 'uacf7_uacf7style_textarea_input_height', true );
        $input_padding_top = get_post_meta( $post->id(), 'uacf7_uacf7style_input_padding_top', true );
        $input_padding_right = get_post_meta( $post->id(), 'uacf7_uacf7style_input_padding_right', true );
        $input_padding_bottom = get_post_meta( $post->id(), 'uacf7_uacf7style_input_padding_bottom', true );
        $input_padding_left = get_post_meta( $post->id(), 'uacf7_uacf7style_input_padding_left', true );
        $input_margin_top = get_post_meta( $post->id(), 'uacf7_uacf7style_input_margin_top', true );
        $input_margin_right = get_post_meta( $post->id(), 'uacf7_uacf7style_input_margin_right', true );
        $input_margin_bottom = get_post_meta( $post->id(), 'uacf7_uacf7style_input_margin_bottom', true );
        $input_margin_left = get_post_meta( $post->id(), 'uacf7_uacf7style_input_margin_left', true );
        
        $btn_color = get_post_meta( $post->id(), 'uacf7_uacf7style_btn_color', true );
        $btn_background_color = get_post_meta( $post->id(), 'uacf7_uacf7style_btn_background_color', true );
        $btn_font_size = get_post_meta( $post->id(), 'uacf7_uacf7style_btn_font_size', true );
        $btn_font_style = get_post_meta( $post->id(), 'uacf7_uacf7style_btn_font_style', true );
        $btn_font_weight = get_post_meta( $post->id(), 'uacf7_uacf7style_btn_font_weight', true );
        $btn_border_width = get_post_meta( $post->id(), 'uacf7_uacf7style_btn_border_width', true );
        $btn_border_color = get_post_meta( $post->id(), 'uacf7_uacf7style_btn_border_color', true );
        $btn_border_style = get_post_meta( $post->id(), 'uacf7_uacf7style_btn_border_style', true );
        $btn_border_radius = get_post_meta( $post->id(), 'uacf7_uacf7style_btn_border_radius', true );
        $btn_width = get_post_meta( $post->id(), 'uacf7_uacf7style_btn_width', true );
        $btn_color_hover = get_post_meta( $post->id(), 'uacf7_uacf7style_btn_color_hover', true );
        $btn_background_color_hover = get_post_meta( $post->id(), 'uacf7_uacf7style_btn_background_color_hover', true );
        $btn_border_color_hover = get_post_meta( $post->id(), 'uacf7_uacf7style_btn_border_color_hover', true );
        $btn_padding_top = get_post_meta( $post->id(), 'uacf7_uacf7style_btn_padding_top', true );
        $btn_padding_right = get_post_meta( $post->id(), 'uacf7_uacf7style_btn_padding_right', true );
        $btn_padding_bottom = get_post_meta( $post->id(), 'uacf7_uacf7style_btn_padding_bottom', true );
        $btn_padding_left = get_post_meta( $post->id(), 'uacf7_uacf7style_btn_padding_left', true );
        $btn_margin_top = get_post_meta( $post->id(), 'uacf7_uacf7style_btn_margin_top', true );
        $btn_margin_right = get_post_meta( $post->id(), 'uacf7_uacf7style_btn_margin_right', true );
        $btn_margin_bottom = get_post_meta( $post->id(), 'uacf7_uacf7style_btn_margin_bottom', true );
        $btn_margin_left = get_post_meta( $post->id(), 'uacf7_uacf7style_btn_margin_left', true );
        
        $ua_custom_css = get_post_meta( $post->id(), 'uacf7_uacf7style_ua_custom_css', true );
        ?>
        <h2><?php echo esc_html__( 'Form Styles', 'ultimate-addons-cf7' ); ?></h2>
        <p><?php echo esc_html__('This feature will help you to edit the Styles of your form. Note that, all below fields are optional. If any field is not needed, leave them blank.','ultimate-addons-cf7'); ?></p>
        <div class="uacf7-doc-notice">
            <?php echo sprintf( 
                __( 'Not sure how to set this? Check our step by step  %1s.', 'ultimate-addons-cf7' ),
                '<a href="https://themefic.com/docs/uacf7/free-addons/contact-form-7-style/" target="_blank">documentation</a>'
            ); ?>  
        </div>
        <fieldset>
           <div class="ultimate-uacf7style-admin">
               <div class="ultimate-uacf7style-wrapper">
                    <?php $form_styles = get_post_meta( $post->id(), 'uacf7_enable_form_styles', true ); ?>
                    <h3><?php echo esc_html__( "Form Styles", "ultimate-addons-cf7" ); ?> </h3>
                    <label for="uacf7_enable_form_styles">  
                        <input id="uacf7_enable_form_styles" type="checkbox" name="uacf7_enable_form_styles" <?php checked( 'on', $form_styles ); ?> > Enable
                    </label><br><br>
                    <hr>
                   <h3><?php echo esc_html__( 'Label Options', 'ultimate-addons-cf7' ); ?></h3>
                   <div class="uacf7style-fourcolumns">
                       <h4><?php echo esc_html__( 'Color', 'ultimate-addons-cf7' ); ?></h4>
                       <input type="text" id="uacf7-uacf7style-label-color" name="uacf7_uacf7style_label_color" class="uacf7-color-picker" value="<?php echo esc_attr_e($label_color); ?>" placeholder="<?php echo esc_html__( 'Enter Label Color', 'ultimate-addons-cf7' ); ?>"><br><br>
                   </div>
                    <div class="uacf7style-fourcolumns">
                       <h4><?php echo esc_html__( 'Background Color', 'ultimate-addons-cf7' ); ?></h4>
                       <input type="text" id="uacf7-uacf7style-label-background-color" name="uacf7_uacf7style_label_background_color" class="uacf7-color-picker" value="<?php echo esc_attr_e($label_background_color); ?>" placeholder="<?php echo esc_html__( 'Enter Label Background Color', 'ultimate-addons-cf7' ); ?>"><br><br>
                   </div>
                   <div class="uacf7style-fourcolumns">
                       <h4><?php echo esc_html__( 'Font Style', 'ultimate-addons-cf7' ); ?></h4>
                       <select name="uacf7_uacf7style_label_font_style" id="uacf7-uacf7style-label-font-style">
                            <option value="<?php esc_attr_e('normal'); ?>" <?php selected( 'normal', esc_attr($label_font_style), true ); ?>><?php echo esc_html('Normal'); ?></option>
                            <option value="<?php esc_attr_e('italic'); ?>" <?php selected( 'italic', esc_attr($label_font_style), true ); ?> ><?php echo esc_html('Italic'); ?></option>
                        </select>
                   </div>
                    <div class="uacf7style-fourcolumns">
                       <h4><?php echo esc_html__( 'Font Weight', 'ultimate-addons-cf7' ); ?></h4>
                       <select name="uacf7_uacf7style_label_font_weight" id="uacf7-uacf7style-label-font_weight">
                            <option value="<?php esc_attr_e('normal'); ?>" <?php selected( 'normal', esc_attr($label_font_weight), true ); ?>><?php echo esc_html('Normal / 400'); ?></option>
                            <option value="<?php esc_attr_e('300'); ?>" <?php selected( '300', esc_attr($label_font_weight), true ); ?>><?php echo esc_html('300'); ?></option>
                            <option value="<?php esc_attr_e('500'); ?>" <?php selected( '500', esc_attr($label_font_weight), true ); ?>><?php echo esc_html('500'); ?></option>
                            <option value="<?php esc_attr_e('700'); ?>" <?php selected( '700', esc_attr($label_font_weight), true ); ?>><?php echo esc_html('700'); ?></option>
                            <option value="<?php esc_attr_e('900'); ?>" <?php selected( '900', esc_attr($label_font_weight), true ); ?>><?php echo esc_html('900'); ?></option>
                        </select>
                        <br><br>
                   </div>
                   <div class="clear"></div>
                   <div class="uacf7style-columns">
                       <h4><?php echo esc_html__( 'Font Size (in px)', 'ultimate-addons-cf7' ); ?></h4>
                       <input type="number" id="uacf7-uacf7style-label-font-size" name="uacf7_uacf7style_label_font_size" class="large-text" value="<?php echo esc_attr_e($label_font_size); ?>" placeholder="<?php echo esc_html__( 'Enter Label Font Size', 'ultimate-addons-cf7' ); ?>"><small>E.g. <span>16</span> <?php echo esc_html__( '(Do not add px or em ).', 'ultimate-addons-cf7' ); ?></small><br><br>
                   </div>
                    <div class="uacf7style-columns">
                       <h4><?php echo esc_html__( 'Font Family', 'ultimate-addons-cf7' ); ?></h4>
                       <input type="text" id="uacf7-uacf7style-label-font-family" name="uacf7_uacf7style_label_font_family" class="large-text" value="<?php echo esc_attr_e($label_font_family); ?>" placeholder="<?php echo esc_html__( 'Enter Label Font Family', 'ultimate-addons-cf7' ); ?>"><small>E.g. <span>Roboto, sans-serif</span><?php echo esc_html__( "(Do not add special characters like '' or  ; )", "ultimate-addons-cf7" ); ?> </small><br><br>
                   </div>
                   <div class="uacf7style-columns">
                       <h4><?php echo esc_html__( 'Padding (in px)', 'ultimate-addons-cf7' ); ?></h4>
                       <div class="four-input">
                           <input type="number" id="uacf7-uacf7style-label-padding-top" name="uacf7_uacf7style_label_padding_top" class="large-text" value="<?php echo esc_attr_e($label_padding_top); ?>" placeholder="<?php echo esc_html__( 'Top', 'ultimate-addons-cf7' ); ?>">
                           <input type="number" id="uacf7-uacf7style-label-padding-right" name="uacf7_uacf7style_label_padding_right" class="large-text" value="<?php echo esc_attr_e($label_padding_right); ?>" placeholder="<?php echo esc_html__( 'Right', 'ultimate-addons-cf7' ); ?>">
                           <input type="number" id="uacf7-uacf7style-label-padding-bottom" name="uacf7_uacf7style_label_padding_bottom" class="large-text" value="<?php echo esc_attr_e($label_padding_bottom); ?>" placeholder="<?php echo esc_html__( 'Bottom', 'ultimate-addons-cf7' ); ?>">
                           <input type="number" id="uacf7-uacf7style-label-padding-left" name="uacf7_uacf7style_label_padding_left" class="large-text" value="<?php echo esc_attr_e($label_padding_left); ?>" placeholder="<?php echo esc_html__( 'Left', 'ultimate-addons-cf7' ); ?>">
                        </div>
                        <small>E.g. <span>16</span><?php echo esc_html__( ' (Do not add px or em ).', 'ultimate-addons-cf7' ); ?></small><br><br>
                   </div>
                    <div class="uacf7style-columns">
                       <h4><?php echo esc_html__( 'Margin (in px)', 'ultimate-addons-cf7' ); ?></h4>
                       <div class="four-input">
                           <input type="number" id="uacf7-uacf7style-label-margin-top" name="uacf7_uacf7style_label_margin_top" class="large-text" value="<?php echo esc_attr_e($label_margin_top); ?>" placeholder="<?php echo esc_html__( 'Top', 'ultimate-addons-cf7' ); ?>">
                           <input type="number" id="uacf7-uacf7style-label-margin-right" name="uacf7_uacf7style_label_margin_right" class="large-text" value="<?php echo esc_attr_e($label_margin_right); ?>" placeholder="<?php echo esc_html__( 'Right', 'ultimate-addons-cf7' ); ?>">
                           <input type="number" id="uacf7-uacf7style-label-margin-bottom" name="uacf7_uacf7style_label_margin_bottom" class="large-text" value="<?php echo esc_attr_e($label_margin_bottom); ?>" placeholder="<?php echo esc_html__( 'Bottom', 'ultimate-addons-cf7' ); ?>">
                           <input type="number" id="uacf7-uacf7style-label-margin-left" name="uacf7_uacf7style_label_margin_left" class="large-text" value="<?php echo esc_attr_e($label_margin_left); ?>" placeholder="<?php echo esc_html__( 'Left', 'ultimate-addons-cf7' ); ?>">
                       </div>
                       <small>E.g. <span>16</span><?php echo esc_html__( '(Do not add px or em ).', 'ultimate-addons-cf7' ); ?> </small><br><br>
                   </div>
                   <div class="clear"></div>
               </div>
               
                <div class="clear"></div>
                
            <div class="ultimate-uacf7style-wrapper">
                <h3><?php echo esc_html__( 'Input Field Options', 'ultimate-addons-cf7' ); ?></h3>
                <div class="uacf7style-fourcolumns">
                   <h4><?php echo esc_html__( 'Color', 'ultimate-addons-cf7' ); ?></h4>
                   <input type="text" id="uacf7-uacf7style-input-color" name="uacf7_uacf7style_input_color" class="uacf7-color-picker" value="<?php echo esc_attr_e($input_color); ?>" placeholder="<?php echo esc_html__( 'Enter Input Color', 'ultimate-addons-cf7' ); ?>"><br><br>
               </div>
                <div class="uacf7style-fourcolumns">
                   <h4><?php echo esc_html__( 'Background Color', 'ultimate-addons-cf7' ); ?></h4>
                   <input type="text" id="uacf7-uacf7style-input-background-color" name="uacf7_uacf7style_input_background_color" class="uacf7-color-picker" value="<?php echo esc_attr_e($input_background_color); ?>" placeholder="<?php echo esc_html__( 'Enter input Background Color', 'ultimate-addons-cf7' ); ?>"><br><br>
               </div>
               <div class="uacf7style-fourcolumns">
                   <h4><?php echo esc_html__( 'Font Style', 'ultimate-addons-cf7' ); ?></h4>
                   <select name="uacf7_uacf7style_input_font_style" id="uacf7-uacf7style-input-font-style">
                        <option value="<?php esc_attr_e('normal'); ?>" <?php selected( 'normal', esc_attr($input_font_style), true ); ?>><?php echo esc_html('Normal'); ?></option>
                    	<option value="<?php esc_attr_e('italic'); ?>" <?php selected( 'italic', esc_attr($input_font_style), true ); ?> ><?php echo esc_html('Italic'); ?></option>
                    </select>
               </div>
                <div class="uacf7style-fourcolumns">
                   <h4><?php echo esc_html__( 'Font Weight', 'ultimate-addons-cf7' ); ?></h4>
                   <select name="uacf7_uacf7style_input_font_weight" id="uacf7-uacf7style-input-font_weight">
                    	<option value="<?php esc_attr_e('normal'); ?>" <?php selected( 'normal', esc_attr($input_font_weight), true ); ?>><?php echo esc_html('Normal / 400'); ?></option>
                    	<option value="<?php esc_attr_e('300'); ?>" <?php selected( '300', esc_attr($input_font_weight), true ); ?>><?php echo esc_html('300'); ?></option>
                    	<option value="<?php esc_attr_e('500'); ?>" <?php selected( '500', esc_attr($input_font_weight), true ); ?>><?php echo esc_html('500'); ?></option>
                    	<option value="<?php esc_attr_e('700'); ?>" <?php selected( '700', esc_attr($input_font_weight), true ); ?>><?php echo esc_html('700'); ?></option>
                    	<option value="<?php esc_attr_e('900'); ?>" <?php selected( '900', esc_attr($input_font_weight), true ); ?>><?php echo esc_html('900'); ?></option>
                    </select>
                    <br><br>
               </div>
               <div class="clear"></div>
               <div class="uacf7style-fourcolumns">
                   <h4><?php echo esc_html__( 'Font Size (in px)', 'ultimate-addons-cf7' ); ?></h4>
                   <input type="number" id="uacf7-uacf7style-input-font-size" name="uacf7_uacf7style_input_font_size" class="large-text" value="<?php echo esc_attr_e($input_font_size); ?>" placeholder="<?php echo esc_html__( 'Enter input Font Size', 'ultimate-addons-cf7' ); ?>"><small>E.g. <span>16</span> (Do not add px or em ).</small><br><br>
               </div>
                <div class="uacf7style-fourcolumns">
                   <h4><?php echo esc_html__( 'Font Family', 'ultimate-addons-cf7' ); ?></h4>
                   <input type="text" id="uacf7-uacf7style-input-font-family" name="uacf7_uacf7style_input_font_family" class="large-text" value="<?php echo esc_attr_e($input_font_family); ?>" placeholder="<?php echo esc_html__( 'Enter input Font Family', 'ultimate-addons-cf7' ); ?>"><small>E.g. <span>Roboto, sans-serif</span> <?php echo esc_html__( '(Do not add special characters like  "or" ; )', 'ultimate-addons-cf7' ); ?></small><br><br>
               </div>
               <div class="uacf7style-fourcolumns">
                   <h4><?php echo esc_html__( 'Input Height (in px)', 'ultimate-addons-cf7' ); ?></h4>
                   <input type="number" id="uacf7-uacf7style-input-height" name="uacf7_uacf7style_input_height" class="large-text" value="<?php echo esc_attr_e($input_height); ?>" placeholder="<?php echo esc_html__( 'Enter input Height', 'ultimate-addons-cf7' ); ?>"><small>E.g. <span>16</span><?php echo esc_html__( ' (Do not add px or em ).' ); ?></small><br><br>
               </div>
                <div class="uacf7style-fourcolumns">
                   <h4><?php echo esc_html__( 'Input (Textarea) Height (in px)', 'ultimate-addons-cf7' ); ?></h4>
                   <input type="number" id="uacf7-uacf7style-textarea-input-height" name="uacf7_uacf7style_textarea_input_height" class="large-text" value="<?php echo esc_attr_e($textarea_input_height); ?>" placeholder="<?php echo esc_html__( 'Enter textarea input Height', 'ultimate-addons-cf7' ); ?>"><small>E.g. <span>16</span><?php echo esc_html__( '(Do not add px or em ).', 'ultimate-addons-cf7' ); ?> </small><br><br>
               </div>
               <div class="clear"></div>
               <div class="uacf7style-columns">
                   <h4><?php echo esc_html__( 'Padding (in px)', 'ultimate-addons-cf7' ); ?></h4>
                   <div class="four-input">
                       <input type="number" id="uacf7-uacf7style-input-padding-top" name="uacf7_uacf7style_input_padding_top" class="large-text" value="<?php echo esc_attr_e($input_padding_top); ?>" placeholder="<?php echo esc_html__( 'Top', 'ultimate-addons-cf7' ); ?>">
                       <input type="number" id="uacf7-uacf7style-input-padding-right" name="uacf7_uacf7style_input_padding_right" class="large-text" value="<?php echo esc_attr_e($input_padding_right); ?>" placeholder="<?php echo esc_html__( 'Right', 'ultimate-addons-cf7' ); ?>">
                       <input type="number" id="uacf7-uacf7style-input-padding-bottom" name="uacf7_uacf7style_input_padding_bottom" class="large-text" value="<?php echo esc_attr_e($input_padding_bottom); ?>" placeholder="<?php echo esc_html__( 'Bottom', 'ultimate-addons-cf7' ); ?>">
                       <input type="number" id="uacf7-uacf7style-input-padding-left" name="uacf7_uacf7style_input_padding_left" class="large-text" value="<?php echo esc_attr_e($input_padding_left); ?>" placeholder="<?php echo esc_html__( 'Left', 'ultimate-addons-cf7' ); ?>">
                    </div>
                    <small>E.g. <span>16</span> <?php echo esc_html__( '(Do not add px or em ).', 'ultimate-addons-cf7' ); ?></small><br><br>
               </div>
                <div class="uacf7style-columns">
                   <h4><?php echo esc_html__( 'Margin (in px)', 'ultimate-addons-cf7' ); ?></h4>
                   <div class="four-input">
                       <input type="number" id="uacf7-uacf7style-input-margin-top" name="uacf7_uacf7style_input_margin_top" class="large-text" value="<?php echo esc_attr_e($input_margin_top); ?>" placeholder="<?php echo esc_html__( 'Top', 'ultimate-addons-cf7' ); ?>">
                       <input type="number" id="uacf7-uacf7style-input-margin-right" name="uacf7_uacf7style_input_margin_right" class="large-text" value="<?php echo esc_attr_e($input_margin_right); ?>" placeholder="<?php echo esc_html__( 'Right', 'ultimate-addons-cf7' ); ?>">
                       <input type="number" id="uacf7-uacf7style-input-margin-bottom" name="uacf7_uacf7style_input_margin_bottom" class="large-text" value="<?php echo esc_attr_e($input_margin_bottom); ?>" placeholder="<?php echo esc_html__( 'Bottom', 'ultimate-addons-cf7' ); ?>">
                       <input type="number" id="uacf7-uacf7style-input-margin-left" name="uacf7_uacf7style_input_margin_left" class="large-text" value="<?php echo esc_attr_e($input_margin_left); ?>" placeholder="<?php echo esc_html__( 'Left', 'ultimate-addons-cf7' ); ?>">
                   </div>
                   <small>E.g. <span>16</span><?php echo esc_html__( '(Do not add px or em ).', 'ultimate-addons-cf7' ); ?> </small><br><br>
               </div>
               <div class="uacf7style-fourcolumns">
                   <h4><?php echo esc_html__( 'Border Width (in px)', 'ultimate-addons-cf7' ); ?></h4>
                   <input type="number" id="uacf7-uacf7style-input-border-width" name="uacf7_uacf7style_input_border_width" class="large-text" value="<?php echo esc_attr_e($input_border_width); ?>" placeholder="<?php echo esc_html__( 'Enter input border width', 'ultimate-addons-cf7' ); ?>"><small>E.g. <span>16</span> (Do not add px or em ).</small><br><br>
               </div>
               <div class="uacf7style-fourcolumns">
                   <h4><?php echo esc_html__( 'Border Style', 'ultimate-addons-cf7' ); ?></h4>
                   <select name="uacf7_uacf7style_input_border_style" id="uacf7-uacf7style-input-border-style">
                    	<option value="<?php esc_attr_e('none'); ?>" <?php selected( 'none', esc_attr($input_border_style), true ); ?>><?php echo esc_html('None'); ?></option>
                    	<option value="<?php esc_attr_e('dotted'); ?>" <?php selected( 'dotted', esc_attr($input_border_style), true ); ?>><?php echo esc_html('Dotted'); ?></option>
                    	<option value="<?php esc_attr_e('dashed'); ?>" <?php selected( 'dashed', esc_attr($input_border_style), true ); ?>><?php echo esc_html('Dashed'); ?></option>
                    	<option value="<?php esc_attr_e('solid'); ?>" <?php selected( 'solid', esc_attr($input_border_style), true ); ?>><?php echo esc_html('Solid'); ?></option>
                    	<option value="<?php esc_attr_e('double'); ?>" <?php selected( 'double', esc_attr($input_border_style), true ); ?>><?php echo esc_html('Double'); ?></option>
                    </select>
               </div>
                <div class="uacf7style-fourcolumns">
                   <h4><?php echo esc_html__( 'Border Radius (in px)', 'ultimate-addons-cf7' ); ?></h4>
                   <input type="number" id="uacf7-uacf7style-input-border-radius" name="uacf7_uacf7style_input_border_radius" class="large-text" value="<?php echo esc_attr_e($input_border_radius); ?>" placeholder="<?php echo esc_html__( 'Enter input border radius', 'ultimate-addons-cf7' ); ?>"><small>E.g. <span>16</span> <?php echo esc_html__( '(Do not add px or em ).', 'ultimate-addons-cf7' ); ?></small><br><br>
               </div>
               <div class="uacf7style-fourcolumns">
                   <h4><?php echo esc_html__( 'Border Color', 'ultimate-addons-cf7' ); ?></h4>
                   <input type="text" id="uacf7-uacf7style-input-border-color" name="uacf7_uacf7style_input_border_color" class="uacf7-color-picker" value="<?php echo esc_attr_e($input_border_color); ?>" placeholder="<?php echo esc_html__( 'Enter input border color', 'ultimate-addons-cf7' ); ?>">
               </div>
               <div class="clear"></div>
            </div>
                
                <div class="clear"></div>
                
            <div class="ultimate-uacf7style-wrapper">
                <h3><?php echo esc_html__( 'Submit Button Options', 'ultimate-addons-cf7' ); ?></h3>
                <div class="uacf7style-fourcolumns">
                   <h4><?php echo esc_html__( 'Color', 'ultimate-addons-cf7' ); ?></h4>
                   <input type="text" id="uacf7-uacf7style-btn-color" name="uacf7_uacf7style_btn_color" class="uacf7-color-picker" value="<?php echo esc_attr_e($btn_color); ?>" placeholder="<?php echo esc_html__( 'Enter Button Color', 'ultimate-addons-cf7' ); ?>"><br><br>
               </div>
               <div class="uacf7style-fourcolumns">
                   <h4><?php echo esc_html__( 'Color (hover)', 'ultimate-addons-cf7' ); ?></h4>
                  <input type="text" id="uacf7-uacf7style-btn-color-hover" name="uacf7_uacf7style_btn_color_hover" class="uacf7-color-picker" value="<?php echo esc_attr_e($btn_color_hover); ?>" placeholder="<?php echo esc_html__( 'Enter Button Color hover', 'ultimate-addons-cf7' ); ?>"><br><br>
               </div>
                <div class="uacf7style-fourcolumns">
                   <h4><?php echo esc_html__( 'Background Color', 'ultimate-addons-cf7' ); ?></h4>
                   <input type="text" id="uacf7-uacf7style-btn-background-color" name="uacf7_uacf7style_btn_background_color" class="uacf7-color-picker" value="<?php echo esc_attr_e($btn_background_color); ?>" placeholder="<?php echo esc_html__( 'Enter Button Background Color', 'ultimate-addons-cf7' ); ?>"><br><br>
               </div>
               <div class="uacf7style-fourcolumns">
                   <h4><?php echo esc_html__( 'Background Color (Hover)', 'ultimate-addons-cf7' ); ?></h4>
                   <input type="text" id="uacf7-uacf7style-btn-background-color-hover" name="uacf7_uacf7style_btn_background_color_hover" class="uacf7-color-picker" value="<?php echo esc_attr_e($btn_background_color_hover); ?>" placeholder="<?php echo esc_html__( 'Enter Button Background Color hover', 'ultimate-addons-cf7' ); ?>"><br><br>
               </div>
               <div class="uacf7style-fourcolumns">
                   <h4><?php echo esc_html__( 'Font Size (in px)', 'ultimate-addons-cf7' ); ?></h4>
                   <input type="number" id="uacf7-uacf7style-btn-font-size" name="uacf7_uacf7style_btn_font_size" class="large-text" value="<?php echo esc_attr_e($btn_font_size); ?>" placeholder="<?php echo esc_html__( 'Enter Button Font Size', 'ultimate-addons-cf7' ); ?>"><small>E.g. <span>16</span> <?php echo esc_html__( '(Do not add px or em ).', 'ultimate-addons-cf7' ); ?></small><br><br>
               </div>
               <div class="uacf7style-fourcolumns">
                   <h4><?php echo esc_html__( 'Font Style', 'ultimate-addons-cf7' ); ?></h4>
                   <select name="uacf7_uacf7style_btn_font_style" id="uacf7-uacf7style-btn-font-style">
                        <option value="<?php esc_attr_e('normal'); ?>" <?php selected( 'normal', esc_attr($btn_font_style), true ); ?>><?php echo esc_html('Normal'); ?></option>
                    	<option value="<?php esc_attr_e('italic'); ?>" <?php selected( 'italic', esc_attr($btn_font_style), true ); ?> ><?php echo esc_html('Italic'); ?></option>
                    </select>
               </div>
                <div class="uacf7style-fourcolumns">
                   <h4><?php echo esc_html__( 'Font Weight', 'ultimate-addons-cf7' ); ?></h4>
                   <select name="uacf7_uacf7style_btn_font_weight" id="uacf7-uacf7style-btn-font_weight">
                    	<option value="<?php esc_attr_e('normal'); ?>" <?php selected( 'normal', esc_attr($btn_font_weight), true ); ?>><?php echo esc_html('Normal / 400'); ?></option>
                    	<option value="<?php esc_attr_e('300'); ?>" <?php selected( '300', esc_attr($btn_font_weight), true ); ?>><?php echo esc_html('300'); ?></option>
                    	<option value="<?php esc_attr_e('500'); ?>" <?php selected( '500', esc_attr($btn_font_weight), true ); ?>><?php echo esc_html('500'); ?></option>
                    	<option value="<?php esc_attr_e('700'); ?>" <?php selected( '700', esc_attr($btn_font_weight), true ); ?>><?php echo esc_html('700'); ?></option>
                    	<option value="<?php esc_attr_e('900'); ?>" <?php selected( '900', esc_attr($btn_font_weight), true ); ?>><?php echo esc_html('900'); ?></option>
                    </select>
               </div>
               <div class="uacf7style-fourcolumns">
                   <h4><?php echo esc_html__( 'Width (in px or %)', 'ultimate-addons-cf7' ); ?></h4>
                   <input type="text" id="uacf7-uacf7style-btn-width" name="uacf7_uacf7style_btn_width" class="large-text" value="<?php echo esc_attr_e($btn_width); ?>" placeholder="<?php echo esc_html__( 'Enter Button width', 'ultimate-addons-cf7' ); ?>"><small>E.g. <span>100px or 100%</span>.</small><br><br>
               </div>
               <div class="clear"></div>
               <div class="uacf7style-fivecolumns">
                   <h4><?php echo esc_html__( 'Border Width (in px)', 'ultimate-addons-cf7' ); ?></h4>
                   <input type="number" id="uacf7-uacf7style-btn-border-width" name="uacf7_uacf7style_btn_border_width" class="large-text" value="<?php echo esc_attr_e($btn_border_width); ?>" placeholder="<?php echo esc_html__( 'Enter Button border width', 'ultimate-addons-cf7' ); ?>"><small>E.g. <span>16</span> <?php echo esc_html__( '(Do not add px or em ).', 'ultimate-addons-cf7' ); ?></small><br><br>
               </div>
               <div class="uacf7style-fivecolumns">
                   <h4><?php echo esc_html__( 'Border Style', 'ultimate-addons-cf7' ); ?></h4>
                   <select name="uacf7_uacf7style_btn_border_style" id="uacf7-uacf7style-btn-border-style">
                    	<option value="<?php esc_attr_e('none'); ?>" <?php selected( 'none', esc_attr($btn_border_style), true ); ?>><?php echo esc_html('None'); ?></option>
                    	<option value="<?php esc_attr_e('dotted'); ?>" <?php selected( 'dotted', esc_attr($btn_border_style), true ); ?>><?php echo esc_html('Dotted'); ?></option>
                    	<option value="<?php esc_attr_e('dashed'); ?>" <?php selected( 'dashed', esc_attr($btn_border_style), true ); ?>><?php echo esc_html('Dashed'); ?></option>
                    	<option value="<?php esc_attr_e('solid'); ?>" <?php selected( 'solid', esc_attr($btn_border_style), true ); ?>><?php echo esc_html('Solid'); ?></option>
                    	<option value="<?php esc_attr_e('double'); ?>" <?php selected( 'double', esc_attr($btn_border_style), true ); ?>><?php echo esc_html('Double'); ?></option>
                    </select>
               </div>
                <div class="uacf7style-fivecolumns">
                   <h4><?php echo esc_html__( 'Border Radius (in px)', 'ultimate-addons-cf7' ); ?></h4>
                   <input type="number" id="uacf7-uacf7style-btn-border-radius" name="uacf7_uacf7style_btn_border_radius" class="large-text" value="<?php echo esc_attr_e($btn_border_radius); ?>" placeholder="<?php echo esc_html__( 'Enter Button border radius', 'ultimate-addons-cf7' ); ?>"><small>E.g. <span>16</span><?php echo esc_html__( '(Do not add px or em ).', 'ultimate-addons-cf7' ); ?> </small><br><br>
               </div>
               <div class="uacf7style-fivecolumns">
                   <h4><?php echo esc_html__( 'Border Color', 'ultimate-addons-cf7' ); ?></h4>
                   <input type="text" id="uacf7-uacf7style-btn-border-color" name="uacf7_uacf7style_btn_border_color" class="uacf7-color-picker" value="<?php echo esc_attr_e($btn_border_color); ?>" placeholder="<?php echo esc_html__( 'Enter Button border color', 'ultimate-addons-cf7' ); ?>"><br><br>
               </div>
               <div class="uacf7style-fivecolumns">
                   <h4><?php echo esc_html__( 'Border Color (Hover)', 'ultimate-addons-cf7' ); ?></h4>
                   <input type="text" id="uacf7-uacf7style-btn-border-color-hover" name="uacf7_uacf7style_btn_border_color_hover" class="uacf7-color-picker" value="<?php echo esc_attr_e($btn_border_color_hover); ?>" placeholder="<?php echo esc_html__( 'Enter Button border color hover', 'ultimate-addons-cf7' ); ?>"><br><br>
               </div>
               <div class="clear"></div>
               <div class="uacf7style-columns">
                   <h4><?php echo esc_html__( 'Padding (in px)', 'ultimate-addons-cf7' ); ?></h4>
                   <div class="four-input">
                       <input type="number" id="uacf7-uacf7style-btn-padding-top" name="uacf7_uacf7style_btn_padding_top" class="large-text" value="<?php echo esc_attr_e($btn_padding_top); ?>" placeholder="<?php echo esc_html__( 'Top', 'ultimate-addons-cf7' ); ?>">
                       <input type="number" id="uacf7-uacf7style-btn-padding-right" name="uacf7_uacf7style_btn_padding_right" class="large-text" value="<?php echo esc_attr_e($btn_padding_right); ?>" placeholder="<?php echo esc_html__( 'Right', 'ultimate-addons-cf7' ); ?>">
                       <input type="number" id="uacf7-uacf7style-btn-padding-bottom" name="uacf7_uacf7style_btn_padding_bottom" class="large-text" value="<?php echo esc_attr_e($btn_padding_bottom); ?>" placeholder="<?php echo esc_html__( 'Bottom', 'ultimate-addons-cf7' ); ?>">
                       <input type="number" id="uacf7-uacf7style-btn-padding-left" name="uacf7_uacf7style_btn_padding_left" class="large-text" value="<?php echo esc_attr_e($btn_padding_left); ?>" placeholder="<?php echo esc_html__( 'Left', 'ultimate-addons-cf7' ); ?>">
                    </div>
                    <small>E.g. <span>16</span> <?php echo esc_html__( '(Do not add px or em ).', 'ultimate-addons-cf7' ); ?></small><br><br>
               </div>
                <div class="uacf7style-columns">
                   <h4><?php echo esc_html__( 'Margin (in px)', 'ultimate-addons-cf7' ); ?></h4>
                   <div class="four-input">
                       <input type="number" id="uacf7-uacf7style-btn-margin-top" name="uacf7_uacf7style_btn_margin_top" class="large-text" value="<?php echo esc_attr_e($btn_margin_top); ?>" placeholder="<?php echo esc_html__( 'Top', 'ultimate-addons-cf7' ); ?>">
                       <input type="number" id="uacf7-uacf7style-btn-margin-right" name="uacf7_uacf7style_btn_margin_right" class="large-text" value="<?php echo esc_attr_e($btn_margin_right); ?>" placeholder="<?php echo esc_html__( 'Right', 'ultimate-addons-cf7' ); ?>">
                       <input type="number" id="uacf7-uacf7style-btn-margin-bottom" name="uacf7_uacf7style_btn_margin_bottom" class="large-text" value="<?php echo esc_attr_e($btn_margin_bottom); ?>" placeholder="<?php echo esc_html__( 'Bottom', 'ultimate-addons-cf7' ); ?>">
                       <input type="number" id="uacf7-uacf7style-btn-margin-left" name="uacf7_uacf7style_btn_margin_left" class="large-text" value="<?php echo esc_attr_e($btn_margin_left); ?>" placeholder="<?php echo esc_html__( 'Left', 'ultimate-addons-cf7' ); ?>">
                   </div>
                   <small>E.g. <span>16</span><?php echo esc_html__( '(Do not add px or em ).', 'ultimate-addons-cf7' ); ?></small><br><br>
               </div>
               <div class="clear"></div>
            </div>
                  
                   <div class="clear"></div>
            <div class="ultimate-uacf7style-wrapper">
                <h3><?php echo esc_html__( 'Custom CSS Option', 'ultimate-addons-cf7' ); ?></h3>
               <input type="text" id="uacf7-customcss" name="uacf7_uacf7style_ua_custom_css" class="large-text" value="<?php echo esc_attr_e($ua_custom_css); ?>" placeholder="<?php echo esc_html__( 'Enter Your Custom CSS', 'ultimate-addons-cf7' ); ?>">
               <div class="clear"></div>
            </div>
                
               <div class="clear"></div>
                <p><?php echo esc_html__( 'Need more options? Let us know ', 'ultimate-addons-cf7' ); ?><a href="https://themefic.com/contact/" target="_blank"><?php echo esc_html__( 'here', 'ultimate-addons-cf7' ); ?></a>.</p>
           </div>
        <?php
         wp_nonce_field( 'uacf7_uacf7style_nonce_action', 'uacf7_uacf7style_nonce' );
    }
    
    public function uacf7_save_contact_form( $form ) {
        
        if ( ! isset( $_POST ) || empty( $_POST ) ) {
			return;
		}
        if ( ! wp_verify_nonce( $_POST['uacf7_uacf7style_nonce'], 'uacf7_uacf7style_nonce_action' ) ) {
            return;
        } 

        if(isset($_POST['uacf7_enable_form_styles'])){
            update_post_meta( $form->id(), 'uacf7_enable_form_styles', sanitize_text_field($_POST['uacf7_enable_form_styles']) );
        }else{
            update_post_meta( $form->id(), 'uacf7_enable_form_styles', 'off' );
        }

        update_post_meta( $form->id(), 'uacf7_uacf7style_label_color', sanitize_text_field($_POST['uacf7_uacf7style_label_color']) );
        update_post_meta( $form->id(), 'uacf7_uacf7style_label_background_color', sanitize_text_field($_POST['uacf7_uacf7style_label_background_color']) );
        update_post_meta( $form->id(), 'uacf7_uacf7style_label_font_size', sanitize_text_field($_POST['uacf7_uacf7style_label_font_size']) );
        update_post_meta( $form->id(), 'uacf7_uacf7style_label_font_family', sanitize_text_field($_POST['uacf7_uacf7style_label_font_family']) );
        update_post_meta( $form->id(), 'uacf7_uacf7style_label_font_style', sanitize_text_field($_POST['uacf7_uacf7style_label_font_style']) );
        update_post_meta( $form->id(), 'uacf7_uacf7style_label_font_weight', sanitize_text_field($_POST['uacf7_uacf7style_label_font_weight']) );
        update_post_meta( $form->id(), 'uacf7_uacf7style_label_padding_top', sanitize_text_field($_POST['uacf7_uacf7style_label_padding_top']) );
        update_post_meta( $form->id(), 'uacf7_uacf7style_label_padding_right', sanitize_text_field($_POST['uacf7_uacf7style_label_padding_right']) );
        update_post_meta( $form->id(), 'uacf7_uacf7style_label_padding_bottom', sanitize_text_field($_POST['uacf7_uacf7style_label_padding_bottom']) );
        update_post_meta( $form->id(), 'uacf7_uacf7style_label_padding_left', sanitize_text_field($_POST['uacf7_uacf7style_label_padding_left']) );
        update_post_meta( $form->id(), 'uacf7_uacf7style_label_margin_top', sanitize_text_field($_POST['uacf7_uacf7style_label_margin_top']) );
        update_post_meta( $form->id(), 'uacf7_uacf7style_label_margin_right', sanitize_text_field($_POST['uacf7_uacf7style_label_margin_right']) );
        update_post_meta( $form->id(), 'uacf7_uacf7style_label_margin_bottom', sanitize_text_field($_POST['uacf7_uacf7style_label_margin_bottom']) );
        update_post_meta( $form->id(), 'uacf7_uacf7style_label_margin_left', sanitize_text_field($_POST['uacf7_uacf7style_label_margin_left']) ); 

        update_post_meta( $form->id(), 'uacf7_uacf7style_input_color', sanitize_text_field($_POST['uacf7_uacf7style_input_color']) ); 
        update_post_meta( $form->id(), 'uacf7_uacf7style_input_background_color', sanitize_text_field($_POST['uacf7_uacf7style_input_background_color']) ); 
        update_post_meta( $form->id(), 'uacf7_uacf7style_input_font_size', sanitize_text_field($_POST['uacf7_uacf7style_input_font_size']) ); 
        update_post_meta( $form->id(), 'uacf7_uacf7style_input_font_family', sanitize_text_field($_POST['uacf7_uacf7style_input_font_family']) ); 
        update_post_meta( $form->id(), 'uacf7_uacf7style_input_font_style', sanitize_text_field($_POST['uacf7_uacf7style_input_font_style']) ); 
        update_post_meta( $form->id(), 'uacf7_uacf7style_input_font_weight', sanitize_text_field($_POST['uacf7_uacf7style_input_font_weight']) ); 
        update_post_meta( $form->id(), 'uacf7_uacf7style_input_height', sanitize_text_field($_POST['uacf7_uacf7style_input_height']) ); 
        update_post_meta( $form->id(), 'uacf7_uacf7style_input_border_width', sanitize_text_field($_POST['uacf7_uacf7style_input_border_width']) ); 
        update_post_meta( $form->id(), 'uacf7_uacf7style_input_border_color', sanitize_text_field($_POST['uacf7_uacf7style_input_border_color']) ); 
        update_post_meta( $form->id(), 'uacf7_uacf7style_input_border_style', sanitize_text_field($_POST['uacf7_uacf7style_input_border_style']) ); 
        update_post_meta( $form->id(), 'uacf7_uacf7style_input_border_radius', sanitize_text_field($_POST['uacf7_uacf7style_input_border_radius']) ); 
        update_post_meta( $form->id(), 'uacf7_uacf7style_textarea_input_height', sanitize_text_field($_POST['uacf7_uacf7style_textarea_input_height']) ); 
        update_post_meta( $form->id(), 'uacf7_uacf7style_input_padding_top', sanitize_text_field($_POST['uacf7_uacf7style_input_padding_top']) ); 
        update_post_meta( $form->id(), 'uacf7_uacf7style_input_padding_right', sanitize_text_field($_POST['uacf7_uacf7style_input_padding_right']) ); 
        update_post_meta( $form->id(), 'uacf7_uacf7style_input_padding_bottom', sanitize_text_field($_POST['uacf7_uacf7style_input_padding_bottom']) ); 
        update_post_meta( $form->id(), 'uacf7_uacf7style_input_padding_left', sanitize_text_field($_POST['uacf7_uacf7style_input_padding_left']) ); 
        update_post_meta( $form->id(), 'uacf7_uacf7style_input_margin_top', sanitize_text_field($_POST['uacf7_uacf7style_input_margin_top']) ); 
        update_post_meta( $form->id(), 'uacf7_uacf7style_input_margin_right', sanitize_text_field($_POST['uacf7_uacf7style_input_margin_right']) ); 
        update_post_meta( $form->id(), 'uacf7_uacf7style_input_margin_bottom', sanitize_text_field($_POST['uacf7_uacf7style_input_margin_bottom']) ); 
        update_post_meta( $form->id(), 'uacf7_uacf7style_input_margin_left', sanitize_text_field($_POST['uacf7_uacf7style_input_margin_left']) ); 

        update_post_meta( $form->id(), 'uacf7_uacf7style_btn_color', sanitize_text_field($_POST['uacf7_uacf7style_btn_color']) ); 
        update_post_meta( $form->id(), 'uacf7_uacf7style_btn_background_color', sanitize_text_field($_POST['uacf7_uacf7style_btn_background_color']) ); 
        update_post_meta( $form->id(), 'uacf7_uacf7style_btn_font_size', sanitize_text_field($_POST['uacf7_uacf7style_btn_font_size']) ); 
        update_post_meta( $form->id(), 'uacf7_uacf7style_btn_font_style', sanitize_text_field($_POST['uacf7_uacf7style_btn_font_style']) ); 
        update_post_meta( $form->id(), 'uacf7_uacf7style_btn_font_weight', sanitize_text_field($_POST['uacf7_uacf7style_btn_font_weight']) ); 
        update_post_meta( $form->id(), 'uacf7_uacf7style_btn_border_width', sanitize_text_field($_POST['uacf7_uacf7style_btn_border_width']) ); 
        update_post_meta( $form->id(), 'uacf7_uacf7style_btn_border_color', sanitize_text_field($_POST['uacf7_uacf7style_btn_border_color']) ); 
        update_post_meta( $form->id(), 'uacf7_uacf7style_btn_border_style', sanitize_text_field($_POST['uacf7_uacf7style_btn_border_style']) ); 
        update_post_meta( $form->id(), 'uacf7_uacf7style_btn_border_radius', sanitize_text_field($_POST['uacf7_uacf7style_btn_border_radius']) ); 
        update_post_meta( $form->id(), 'uacf7_uacf7style_btn_width', sanitize_text_field($_POST['uacf7_uacf7style_btn_width']) ); 
        update_post_meta( $form->id(), 'uacf7_uacf7style_btn_color_hover', sanitize_text_field($_POST['uacf7_uacf7style_btn_color_hover']) ); 
        update_post_meta( $form->id(), 'uacf7_uacf7style_btn_background_color_hover', sanitize_text_field($_POST['uacf7_uacf7style_btn_background_color_hover']) ); 
        update_post_meta( $form->id(), 'uacf7_uacf7style_btn_border_color_hover', sanitize_text_field($_POST['uacf7_uacf7style_btn_border_color_hover']) ); 
        update_post_meta( $form->id(), 'uacf7_uacf7style_btn_padding_top', sanitize_text_field($_POST['uacf7_uacf7style_btn_padding_top']) ); 
        update_post_meta( $form->id(), 'uacf7_uacf7style_btn_padding_right', sanitize_text_field($_POST['uacf7_uacf7style_btn_padding_right']) ); 
        update_post_meta( $form->id(), 'uacf7_uacf7style_btn_padding_bottom', sanitize_text_field($_POST['uacf7_uacf7style_btn_padding_bottom']) ); 
        update_post_meta( $form->id(), 'uacf7_uacf7style_btn_padding_left', sanitize_text_field($_POST['uacf7_uacf7style_btn_padding_left']) ); 
        update_post_meta( $form->id(), 'uacf7_uacf7style_btn_margin_top', sanitize_text_field($_POST['uacf7_uacf7style_btn_margin_top']) ); 
        update_post_meta( $form->id(), 'uacf7_uacf7style_btn_margin_right', sanitize_text_field($_POST['uacf7_uacf7style_btn_margin_right']) ); 
        update_post_meta( $form->id(), 'uacf7_uacf7style_btn_margin_bottom', sanitize_text_field($_POST['uacf7_uacf7style_btn_margin_bottom']) ); 
        update_post_meta( $form->id(), 'uacf7_uacf7style_btn_margin_left', sanitize_text_field($_POST['uacf7_uacf7style_btn_margin_left']) ); 
        update_post_meta( $form->id(), 'uacf7_uacf7style_ua_custom_css', sanitize_text_field($_POST['uacf7_uacf7style_ua_custom_css']) );  
         
    }
    
    public function uacf7_properties($properties, $cfform) {
	
        if (!is_admin() || (defined('DOING_AJAX') && DOING_AJAX)) { 

            $form = $properties['form'];
            $form_meta = uacf7_get_form_option( $cfform->id(), 'styler' );

            $form_styles = isset($form_meta['uacf7_enable_form_styles']) ? $form_meta['uacf7_enable_form_styles'] : false ; 

            if( $form_styles == true ) :

                ob_start(); 

                $label_color = $form_meta['uacf7_uacf7style_label_color_option']['uacf7_uacf7style_label_color'];
                $label_background_color = $form_meta['uacf7_uacf7style_label_color_option']['uacf7_uacf7style_label_background_color'];
                $label_font_size = $form_meta['uacf7_uacf7style_label_font_size'];
                $label_font_family = $form_meta['uacf7_uacf7style_label_font_family'];
                $label_font_style = $form_meta['uacf7_uacf7style_label_font_style'];
                $label_font_weight = $form_meta['uacf7_uacf7style_label_font_weight'];
                $label_padding_top = $form_meta['uacf7_uacf7style_label_padding_top'];
                $label_padding_right = $form_meta['uacf7_uacf7style_label_padding_right'];
                $label_padding_bottom = $form_meta['uacf7_uacf7style_label_padding_bottom'];
                $label_padding_left = $form_meta['uacf7_uacf7style_label_padding_left'];
                $label_margin_top = $form_meta['uacf7_uacf7style_label_margin_top'];
                $label_margin_right = $form_meta['uacf7_uacf7style_label_margin_right'];
                $label_margin_bottom = $form_meta['uacf7_uacf7style_label_margin_bottom'];
                $label_margin_left = $form_meta['uacf7_uacf7style_label_margin_left'];
                
                $input_color = $form_meta['uacf7_uacf7style_input_color_option']['uacf7_uacf7style_input_color'];
                $input_background_color = $form_meta['uacf7_uacf7style_input_color_option']['uacf7_uacf7style_input_background_color'];
                $input_font_size = $form_meta['uacf7_uacf7style_input_font_size'];
                $input_font_family = $form_meta['uacf7_uacf7style_input_font_family'];
                $input_font_style = $form_meta['uacf7_uacf7style_input_font_style'];
                $input_font_weight = $form_meta['uacf7_uacf7style_input_font_weight'];
                $input_height = $form_meta['uacf7_uacf7style_input_height'];
                $input_border_width = $form_meta['uacf7_uacf7style_input_border_width'];
                $input_border_color = $form_meta['uacf7_uacf7style_input_border_color'];
                $input_border_style = $form_meta['uacf7_uacf7style_input_border_style'];
                $input_border_radius = $form_meta['uacf7_uacf7style_input_border_radius'];
                $textarea_input_height = $form_meta['uacf7_uacf7style_textarea_input_height'];
                $input_padding_top = $form_meta['uacf7_uacf7style_input_padding_top'];
                $input_padding_right = $form_meta['uacf7_uacf7style_input_padding_right'];
                $input_padding_bottom = $form_meta['uacf7_uacf7style_input_padding_bottom'];
                $input_padding_left = $form_meta['uacf7_uacf7style_input_padding_left'];
                $input_margin_top = $form_meta['uacf7_uacf7style_input_margin_top'];
                $input_margin_right = $form_meta['uacf7_uacf7style_input_margin_right'];
                $input_margin_bottom = $form_meta['uacf7_uacf7style_input_margin_bottom'];
                $input_margin_left = $form_meta['uacf7_uacf7style_input_margin_left'];
                
                $btn_color = $form_meta['uacf7_uacf7style_btn_color_option']['uacf7_uacf7style_btn_color'];
                $btn_background_color = $form_meta['uacf7_uacf7style_btn_color_option']['uacf7_uacf7style_btn_background_color'];
                $btn_font_size = $form_meta['uacf7_uacf7style_btn_font_size'];
                $btn_font_style = $form_meta['uacf7_uacf7style_btn_font_style'];
                $btn_font_weight = $form_meta['uacf7_uacf7style_btn_font_weight'];
                $btn_width = $form_meta['uacf7_uacf7style_btn_width'];
                $btn_border_color = $form_meta['uacf7_uacf7style_btn_border_color'];
                $btn_border_style = $form_meta['uacf7_uacf7style_btn_border_style'];
                $btn_border_radius = $form_meta['uacf7_uacf7style_btn_border_radius'];
                $btn_border_width = $form_meta['uacf7_uacf7style_btn_border_width'];
                $btn_color_hover = $form_meta['uacf7_uacf7style_btn_color_option']['uacf7_uacf7style_btn_color_hover'];
                $btn_background_color_hover = $form_meta['uacf7_uacf7style_btn_color_option']['uacf7_uacf7style_btn_background_color_hover'];
                $btn_border_color_hover = $form_meta['uacf7_uacf7style_btn_border_color_hover'];
                $btn_padding_top = $form_meta['uacf7_uacf7style_btn_padding_top'];
                $btn_padding_right = $form_meta['uacf7_uacf7style_btn_padding_right'];
                $btn_padding_bottom = $form_meta['uacf7_uacf7style_btn_padding_bottom'];
                $btn_padding_left = $form_meta['uacf7_uacf7style_btn_padding_left'];
                $btn_margin_top = $form_meta['uacf7_uacf7style_btn_margin_top'];
                $btn_margin_right = $form_meta['uacf7_uacf7style_btn_margin_right'];
                $btn_margin_bottom = $form_meta['uacf7_uacf7style_btn_margin_bottom'];
                $btn_margin_left = $form_meta['uacf7_uacf7style_btn_margin_left'];
                
                // $ua_custom_css = $form_meta['uacf7_uacf7style_ua_custom_css'];
                ?>
                <style>
                    .uacf7-uacf7style-<?php esc_attr_e( $cfform->id() ); ?> label {
                        color: <?php echo esc_attr_e($label_color); ?>;
                        background-color: <?php echo esc_attr_e($label_background_color); ?>;
                        font-size: <?php echo esc_attr_e($label_font_size).'px'; ?>;
                        font-family: <?php echo esc_attr_e($label_font_family); ?>;
                        font-style: <?php echo esc_attr_e($label_font_style); ?>;
                        font-weight: <?php echo esc_attr_e($label_font_weight); ?>;
                        padding-top: <?php echo esc_attr_e($label_padding_top).'px'; ?>;
                        padding-right: <?php echo esc_attr_e($label_padding_right).'px'; ?>;
                        padding-bottom: <?php echo esc_attr_e($label_padding_bottom).'px'; ?>;
                        padding-left: <?php echo esc_attr_e($label_padding_left).'px'; ?>;
                        margin-top: <?php echo esc_attr_e($label_margin_top).'px'; ?>;
                        margin-right: <?php echo esc_attr_e($label_margin_right).'px'; ?>;
                        margin-bottom: <?php echo esc_attr_e($label_margin_bottom).'px'; ?>;
                        margin-left: <?php echo esc_attr_e($label_margin_left).'px'; ?>;
                    }
                    .uacf7-uacf7style-<?php esc_attr_e( $cfform->id() ); ?> input[type="email"],
                    .uacf7-uacf7style-<?php esc_attr_e( $cfform->id() ); ?> input[type="number"],
                    .uacf7-uacf7style-<?php esc_attr_e( $cfform->id() ); ?> input[type="password"],
                    .uacf7-uacf7style-<?php esc_attr_e( $cfform->id() ); ?> input[type="search"],
                    .uacf7-uacf7style-<?php esc_attr_e( $cfform->id() ); ?> input[type="tel"],
                    .uacf7-uacf7style-<?php esc_attr_e( $cfform->id() ); ?> input[type="text"],
                    .uacf7-uacf7style-<?php esc_attr_e( $cfform->id() ); ?> input[type="url"],
                    .uacf7-uacf7style-<?php esc_attr_e( $cfform->id() ); ?> input[type="date"],
                    .uacf7-uacf7style-<?php esc_attr_e( $cfform->id() ); ?> select,
                    .uacf7-uacf7style-<?php esc_attr_e( $cfform->id() ); ?> textarea {
                        color: <?php echo esc_attr_e($input_color); ?>;
                        background-color: <?php echo esc_attr_e($input_background_color); ?>;
                        font-size: <?php echo esc_attr_e($input_font_size).'px'; ?>;
                        font-family: <?php echo esc_attr_e($input_font_family); ?>;
                        font-style: <?php echo esc_attr_e($input_font_style); ?>;
                        font-weight: <?php echo esc_attr_e($input_font_weight); ?>;
                        height: <?php echo esc_attr_e($input_height).'px'; ?>;
                        border-width: <?php echo esc_attr_e($input_border_width).'px'; ?>;
                        border-color: <?php echo esc_attr_e($input_border_color); ?>;
                        border-style: <?php echo esc_attr_e($input_border_style); ?>;
                        border-radius: <?php echo esc_attr_e($input_border_radius).'px'; ?>;
                        padding-top: <?php echo esc_attr_e($input_padding_top).'px'; ?>;
                        padding-right: <?php echo esc_attr_e($input_padding_right).'px'; ?>;
                        padding-bottom: <?php echo esc_attr_e($input_padding_bottom).'px'; ?>;
                        padding-left: <?php echo esc_attr_e($input_padding_left).'px'; ?>;
                        margin-top: <?php echo esc_attr_e($input_margin_top).'px'; ?>;
                        margin-right: <?php echo esc_attr_e($input_margin_right).'px'; ?>;
                        margin-bottom: <?php echo esc_attr_e($input_margin_bottom).'px'; ?>;
                        margin-left: <?php echo esc_attr_e($input_margin_left).'px'; ?>;
                    }
                    .uacf7-uacf7style-<?php esc_attr_e( $cfform->id() ); ?> .wpcf7-radio span,
                    .uacf7-uacf7style-<?php esc_attr_e( $cfform->id() ); ?> .wpcf7-checkbox span {
                        color: <?php echo esc_attr_e($input_color); ?>;
                        font-size: <?php echo esc_attr_e($input_font_size).'px'; ?>;
                        font-family: <?php echo esc_attr_e($input_font_family); ?>;
                        font-style: <?php echo esc_attr_e($input_font_style); ?>;
                        font-weight: <?php echo esc_attr_e($input_font_weight); ?>;
                    }
                    .uacf7-uacf7style-<?php esc_attr_e( $cfform->id() ); ?> textarea {
                        height: <?php echo esc_attr_e($textarea_input_height).'px'; ?>;
                    }
                    .wpcf7-form-control-wrap select {
                        width: 100%;
                    }
                    .uacf7-uacf7style-<?php esc_attr_e( $cfform->id() ); ?> input[type="submit"] {
                        color: <?php echo esc_attr_e($btn_color); ?>;
                        background-color: <?php echo esc_attr_e($btn_background_color); ?>;
                        font-size: <?php echo esc_attr_e($btn_font_size).'px'; ?>;
                        font-family: <?php echo esc_attr_e($input_font_family); ?>;
                        font-style: <?php echo esc_attr_e($btn_font_style); ?>;
                        font-weight: <?php echo esc_attr_e($btn_font_weight); ?>;
                        border-width: <?php echo esc_attr_e($btn_border_width).'px'; ?>;
                        border-color: <?php echo esc_attr_e($btn_border_color); ?>;
                        border-style: <?php echo esc_attr_e($btn_border_style); ?>;
                        border-radius: <?php echo esc_attr_e($btn_border_radius).'px'; ?>;
                        width: <?php echo esc_attr_e($btn_width); ?>;
                        padding-top: <?php echo esc_attr_e($btn_padding_top).'px'; ?>;
                        padding-right: <?php echo esc_attr_e($btn_padding_right).'px'; ?>;
                        padding-bottom: <?php echo esc_attr_e($btn_padding_bottom).'px'; ?>;
                        padding-left: <?php echo esc_attr_e($btn_padding_left).'px'; ?>;
                        margin-top: <?php echo esc_attr_e($btn_margin_top).'px'; ?>;
                        margin-right: <?php echo esc_attr_e($btn_margin_right).'px'; ?>;
                        margin-bottom: <?php echo esc_attr_e($btn_margin_bottom).'px'; ?>;
                        margin-left: <?php echo esc_attr_e($btn_margin_left).'px'; ?>;
                    }
                    .uacf7-uacf7style-<?php esc_attr_e( $cfform->id() ); ?> input[type="submit"]:hover {
                        color: <?php echo esc_attr_e($btn_color_hover); ?>;
                        background-color: <?php echo esc_attr_e($btn_background_color_hover); ?>;
                        border-color: <?php echo esc_attr_e($btn_border_color_hover); ?>;
                    }
                    <?php echo $ua_custom_css ?>
                </style>
                <?php
                echo '<div class="uacf7-uacf7style uacf7-uacf7style-'.esc_attr($cfform->id()).'">'.$form.'</div>';
                $properties['form'] = ob_get_clean();
            endif;
        }

        return $properties;
    }
   
}
new UACF7_uacf7style();
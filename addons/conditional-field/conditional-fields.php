<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class UACF7_CF {
    
    private $hidden_fields = array();
    /*
    * Construct function
    */
    public function __construct() {
		global $pagenow;
		if( isset($_GET['page']) ){
			if ( ($pagenow == 'admin.php') && ($_GET['page'] == 'wpcf7') || ($_GET['page'] == 'wpcf7-new') ) {
				add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_cf_admin_script' ) );
			}
		}

		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_cf_frontend_script' ) );
        add_action('wpcf7_init', array(__CLASS__, 'add_shortcodes'));
        add_action( 'admin_init', array( $this, 'tag_generator' ) );
		// add_action( 'wpcf7_editor_panels', array( $this, 'uacf7_cf_add_panel' ) );
        
		// add_action( 'wpcf7_after_save', array( $this, 'uacf7_save_meta' ) );
        // add_action( 'wpcf7_after_save', array( $this, 'uacf7_save_contact_form' ) );
        
        add_filter( 'wpcf7_contact_form_properties', array( $this, 'uacf7_properties' ), 10, 2 );
        
        add_action('wpcf7_form_hidden_fields', array( $this, 'uacf7_form_hidden_fields' ), 10, 1);
        
        add_filter( 'wpcf7_posted_data', array($this, 'remove_hidden_post_data') );
        add_filter( 'wpcf7_validate', array($this, 'skip_validation_for_hidden_fields'), 2, 2 );
        
        add_filter( 'wpcf7_validate_file*', array($this, 'skip_validation_for_hidden_file_field'), 30, 3);
        add_filter( 'wpcf7_validate_multifile*', array($this, 'skip_validation_for_hidden_file_field'), 30, 3);

        add_action('wpcf7_config_validator_validate', array($this,'uacf7_config_validator_validate'));

        add_action( 'wpcf7_before_send_mail', array($this, 'uacf7_conditional_mail_properties'));

        add_filter( 'uacf7_post_meta_options', array( $this, 'uacf7_post_meta_options_conditional_field' ), 11, 2 ); 

        //    add_filter( 'wpcf7_load_js', '__return_false' );
     

    }
    
    public function enqueue_cf_admin_script() {
        wp_enqueue_script( 'uacf7-cf-script', UACF7_ADDONS . '/conditional-field/js/cf-script.js', array('jquery'), null, true ); 
        wp_enqueue_style( 'uacf7-cf-style', UACF7_ADDONS . '/conditional-field/css/cf-style.css' );
    }
    
    public function enqueue_cf_frontend_script() {
        wp_enqueue_script( 'uacf7-cf-script', UACF7_ADDONS . '/conditional-field/js/uacf7-cf-script.js', array('jquery') );  
        wp_localize_script( 'uacf7-cf-script', 'uacf7_cf_object', $this->get_forms() );    
    }


    public function uacf7_post_meta_options_conditional_field($value, $post_id) {

		

		$conditional = apply_filters('uacf7_post_meta_options_conditional_field_pro', $data = array(
			'title'  => __( 'Conditional Field', 'ultimate-addons-cf7' ),
			'icon'   => 'fa-solid fa-fan',
			'fields' => array(
				'conditional_headding' => array(
					'id'    => 'conditional_headding',
					'type'  => 'heading',
					'label' => __( 'Conditional Fields Settings', 'ultimate-addons-cf7' ),
					'sub_title' => __( 'With this feature, you can show or hide form fields depending on Contact form 7 Conditional Logic. You can check this video to learn more.', 'ultimate-addons-cf7' ),
					'description' => __( 'Not sure how to set this? Check our step by step documentation.', 'ultimate-addons-cf7' ),
				),
               'conditional_repeater' => array(
                    'id' => 'conditional_repeater',
                    'type' => 'repeater',
                    'label' => __( 'Conditional Rule', 'ultimate-addons-cf7' ),
                    'subtitle' => __( 'Add Rule', 'ultimate-addons-cf7' ),
                    'class' => 'tf-field-class',
                    'fields' => array( 
                           'uacf7_cf_group' => array(
                                'id' => 'uacf7_cf_group',
                                'type' => 'select',
                                'label' => __( 'Following Field', 'ultimate-addons-cf7' ),
                                'class' => 'tf-field-class',
                                'options' => 'uacf7',
                                'query_args' => array(
                                    'post_id'      => $post_id, 
                                    'specific'      => 'conditional', 
                                ), 
                                'field_width' => '33',
                            ),
                            'uacf7_cf_hs' => array(
                                'id' => 'uacf7_cf_hs',
                                'type' => 'select',
                                'label' => __( 'Visibility', 'ultimate-addons-cf7' ),
                                'class' => 'tf-field-class',
                                'options' => array(
                                    'show' => 'Show',
                                    'hide' => 'Hide',
                                 ),
                                 'field_width' => '33',
                            ),
                            'uacf7_cf_condition_for' => array(
                                'id' => 'uacf7_cf_condition_for',
                                'type' => 'select',
                                'label' => __( 'If', 'ultimate-addons-cf7' ),
                                'class' => 'tf-field-class',
                                'options' => array(
                                    'any' => 'Any',
                                    'all' => 'All',
                                 ),
                                 'field_width' => '33',
                                 
                            ),
                            'uacf7_cf_conditions' => array(
                                'id' => 'uacf7_cf_conditions',
                                'type' => 'repeater',
                                'label' => __( 'Add Condition', 'ultimate-addons-cf7' ),
                                'class' => 'tf-field-class',
                                'fields' => array(

                                    'uacf7_cf_tn' => array(
                                        'id' => 'uacf7_cf_tn',
                                        'type' => 'select',
                                        'label' => __( 'Coditional Field', 'ultimate-addons-cf7' ),
                                        'class' => 'tf-field-class',
                                        'options' => 'uacf7',
                                        'query_args' => array(
                                            'post_id'      => $post_id, 
                                            'exclude'      => ['submit'], 
                                        ),
                                        'field_width' => '50', 
                                    ), 
                                      'uacf7_cf_operator' => array(
                                        'id' => 'uacf7_cf_operator',
                                        'type' => 'select',
                                        'label' => __( 'If', 'ultimate-addons-cf7' ),
                                        'class' => 'tf-field-class',
                                        'options' => array(
                                            'equal' => 'equal',
                                            'not_equal' => 'Not Equal',
                                            'greater_than' => 'Greater than',
                                            'less_than' => 'Less than',
                                            'greater_than_or_equal_to' => 'Greater than or equal to',
                                            'less_than_or_equal_to' => 'Less than or equal to', 
                                        ),
                                        'field_width' => '50', 
                                    ),
                                      'uacf7_cf_val' =>   array(
                                            'id' => 'uacf7_cf_val',
                                            'type' => 'text',
                                            'label' => 'Conditional Value',
                                            'description' => '',
                                            'class' => 'tf-field-class',
                                        )
                                 ),
                            )
                     ),
                )
				
			),
		), $post_id);
		$value['conditional'] = $conditional;
		return $value;
	}


   
 
    /*
    * Create tab panel
    */
    public function uacf7_cf_add_panel( $panels ) {

		$panels['uacf7-cf-panel'] = array(
			'title'    => __( 'UACF7 Conditional Fields', 'ultimate-addons-cf7' ),
			'callback' => array( $this, 'uacf7_create_conditional_panel_fields' ),
		);
		return $panels;
	}
    
    /*
    * Form tag
    */
    public static function add_shortcodes() {
        if( function_exists('wpcf7_add_form_tag') ){
            wpcf7_add_form_tag( 'conditional', array( __CLASS__, 'custom_conditional_form_tag_handler' ), true );
        }
    }
    
    public static function custom_conditional_form_tag_handler( $tag ) {
        ob_start();
        $tag = new WPCF7_FormTag( $tag );
        ?>
        <div> 
        <?php $tag->content; ?>
        </div>
        <?php
        return ob_get_clean();
    }
    
    /*
    * Generate tag - conditional
    */
    public function tag_generator() {
        if (! function_exists( 'wpcf7_add_tag_generator'))
            return;

        wpcf7_add_tag_generator('conditional',
            __('Conditional Wraper', 'ultimate-addons-cf7'),
            'uacf7-tg-pane-conditional',
            array($this, 'tg_pane_conditional')
        );

    }
    
    static function tg_pane_conditional( $contact_form, $args = '' ) {
        $args = wp_parse_args( $args, array() );
        $uacf7_field_type = 'conditional';
        ?>
        <div class="control-box">
            <fieldset>
                <div class="uacf7-doc-notice">
                    <?php echo sprintf( 
                        __( 'Not sure how to set this? Check our step by step  %1s.', 'ultimate-addons-cf7' ),
                        '<a href="https://themefic.com/docs/uacf7/free-addons/contact-form-7-conditional-fields/" target="_blank">documentation</a>'
                    ); ?>  
                </div>
                <legend><?php echo esc_html__( "Generate a conditional tag to wrap the elements that can be shown conditionally.", "ultimate-addons-cf7" ); ?></legend>
                <table class="form-table">
                    <tbody>
                        <tr>
                            <th scope="row"><label for="<?php echo esc_attr( $args['content'] . '-name' ); ?>"><?php echo esc_html( __( 'Name', 'ultimate-addons-cf7' ) ); ?></label></th>
                            <td><input type="text" name="name" class="tg-name oneline" id="<?php echo esc_attr( $args['content'] . '-name' ); ?>" /></td>
                        </tr>
                    </tbody>
                </table>
                <div class="uacf7-doc-notice uacf7-guide"><?php echo esc_html__( "There are additional settings on the 'UACF7 Conditional Fields' tab. Make sure you set those, otherwise the conditions may not work correctly.", "ultimate-addons-cf7" ); ?></div>
            </fieldset>
        </div>

        <div class="insert-box">
            <input type="text" name="<?php echo esc_attr($uacf7_field_type); ?>" class="tag code" readonly="readonly" onfocus="this.select()" />

            <div class="submitbox">
                <input type="button" class="button button-primary insert-tag" value="<?php echo esc_attr( __( 'Insert Tag', 'ultimate-addons-cf7' ) ); ?>" />
            </div>
        </div>
        <?php
    }
    
    /*
    * Redirect fields
    */
    public function uacf7_create_conditional_panel_fields( $post ) {
        ?>
        <h2><?php echo esc_html( 'Conditional Fields Settings', 'ultimate-addons-cf7' ) ?></h2>
        
        <p><?php echo esc_html__('With this feature, you can show or hide form fields depending on Contact form 7 Conditional Logic. You can check this','ultimate-addons-cf7'); ?> <a target="_blank" href="<?php echo esc_url('https://youtu.be/mxcC1eQXxEI?t=253'); ?>"><?php echo esc_html__('video','ultimate-addons-cf7'); ?></a> <?php echo esc_html__('to learn more.','ultimate-addons-cf7'); ?></p>
        
        <fieldset>
            
            <div class="uacf7-conditional-fields">
               <!--New entry-->
               <div id="uacf7-new-entry">
                   <hr>
                    <select class="uacf7-field" name="uacf7_cf_hs_uacf7id">
                        <option value="show"><?php echo esc_html( 'Show', 'ultimate-addons-cf7' ) ?></option>
                        <option value="hide"><?php echo esc_html( 'Hide', 'ultimate-addons-cf7' ) ?></option>
                    </select>
                    
                    <select class="uacf7-field" name="uacf7_cf_group_uacf7id">
                        <?php 
                        $all_groups = $post->scan_form_tags(array('type'=>'conditional'));
                        ?>
                        <option value=""><?php echo esc_html( '-- Select element --', 'ultimate-addons-cf7' ) ?></option>
                        <?php
                        foreach ($all_groups as $tag) {
                        ?>
                        <option value="<?php echo esc_attr($tag['name']); ?>"><?php echo esc_html($tag['name']); ?></option>
                        <?php
                        }
                        ?>
                    </select>
                    
                    <label class="uacf7-field-label"> <?php echo esc_html( 'If', 'ultimate-addons-cf7' ) ?> </label>
                    
                    <select class="uacf7-field" name="uacf7_cf_condition_for_uacf7id">
                        <option value="any"><?php echo esc_html( 'Any', 'ultimate-addons-cf7' ) ?></option>
                        <option value="all"><?php echo esc_html( 'All', 'ultimate-addons-cf7' ) ?></option>
                    </select>
                    <a class="uacf7-add-condition button-primary" href="#" title="<?php echo esc_html( 'Add Condition', 'ultimate-addons-cf7' ) ?>" data-rule-id="uacf7id"><?php echo esc_html__('Add Condition', 'ultimate-addons-cf7'); ?></a>
                    <a class="uacf7-remove button-primary" href="#" title="<?php echo esc_html( 'Remove', 'ultimate-addons-cf7' ) ?>"><?php echo esc_html__('Remove Rule', 'ultimate-addons-cf7'); ?></a>
                    <br>
                    <br>

                    <div class="uacf7-condition-group" style="text-indent:320px">
                       <div class="uacf7-conditions-wraper" data-rule-id="uacf7id">
                           <div class="uacf7-condition-wrap">
                                <select class="uacf7-field" name="uacf7_cf_tn_uacf7id_[]">
                                    <?php
                                    $all_fields = $post->scan_form_tags();
                                    ?>
                                    <option value=""><?php echo esc_html( '-- Select field --', 'ultimate-addons-cf7' ) ?></option>
                                    <?php

                                    foreach ($all_fields as $tag) {
                                        if ($tag['type'] == 'conditional' || $tag['name'] == ''  || $tag['type'] == 'uacf7_conversational_start' || $tag['type'] == 'uacf7_conversational_end' ) continue;
                                    ?>
                                    <?php 

                                    if( !in_array('exclusive', $tag['options']) && $tag['type'] == 'checkbox' || $tag['type'] == 'checkbox*' ) { 
                                        
                                        $tag_name = $tag['name'].'[]';
                                        
                                    }else {
                                        
                                        $tag_name = $tag['name'];
                                    }
                                    ?>
                                    <option value="<?php echo esc_attr($tag_name); ?>"><?php echo esc_html($tag_name); ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>

                                <select class="uacf7-field" name="uacf7_cf_operator_uacf7id_[]">
                                    <option value="equal"><?php echo esc_html( 'Equal', 'ultimate-addons-cf7' ) ?></option>
                                    
                                    <option value="not_equal"><?php echo esc_html( 'Not Equal', 'ultimate-addons-cf7' ) ?></option>
                                    
                                    <option value="greater_than"><?php echo esc_html( 'Greater than', 'ultimate-addons-cf7' ) ?></option>
                                    
                                    <option value="less_than"><?php echo esc_html( 'Less than', 'ultimate-addons-cf7' ) ?></option>
                                    
                                    <option value="greater_than_or_equal_to"><?php echo esc_html( 'Greater than or equal to', 'ultimate-addons-cf7' ) ?></option>
                                    
                                    <option value="less_than_or_equal_to"><?php echo esc_html( 'Less than or equal to', 'ultimate-addons-cf7' ) ?></option>
                                </select>

                                <input class="uacf7-field uacf7-condition-value" name="uacf7_cf_val_uacf7id_[]" type="text" placeholder="Value">
                                <a class="uacf7-remove-group" href="#" title="<?php echo esc_html( 'Remove', 'ultimate-addons-cf7' ) ?>">×</a>
                            </div>
                        </div>
                        <input id="uacf7_conditions_count_ruleid" type="hidden" name="uacf7_conditions_count_ruleid_uacf7id" value="1">
                    </div>
                    <br>
                    
                </div>
                <div class="uacf7-doc-notice">
                    <?php echo sprintf( 
                        __( 'Not sure how to set this? Check our step by step  %1s.', 'ultimate-addons-cf7' ),
                        '<a href="https://themefic.com/docs/uacf7/free-addons/contact-form-7-conditional-fields/" target="_blank">documentation</a>'
                    ); ?>  
                </div>
               <!--New entry-->
               <?php        
                $uacf7_cf_count = get_post_meta( $post->id(), 'uacf7_cf_count', true );
        
                $uacf7_conditions = !empty( get_post_meta( $post->id(), 'uacf7_conditions', true ) ) ? get_post_meta( $post->id(), 'uacf7_conditions', true ) : array();
        
                for( $i = 0; $i < $uacf7_cf_count; $i++ ) :
                
                $uacf7_cf_id = is_array( $uacf7_conditions[ $i ] ) ? $uacf7_conditions[ $i ] : array();
        
                $uacf7_cf_hs = !empty( $uacf7_cf_id['uacf7_cf_hs'] ) ? $uacf7_cf_id['uacf7_cf_hs'] : '';
        
                $uacf7_cf_group = !empty( $uacf7_cf_id['uacf7_cf_group'] ) ? $uacf7_cf_id['uacf7_cf_group'] : '';
        
                $uacf7_cf_conditions_for = !empty( $uacf7_cf_id['uacf_cf_condition_for'] ) ? $uacf7_cf_id['uacf_cf_condition_for'] : '';
		
                $uacf7_cf_conditions = is_array( $uacf7_cf_id['uacf7_cf_conditions'] ) ? $uacf7_cf_id['uacf7_cf_conditions'] : array();
                
				$uacf7_cf_all_tags_array = is_array( $uacf7_cf_conditions['uacf7_cf_tn'] ) ? $uacf7_cf_conditions['uacf7_cf_tn'] : array();
					
				$uacf7_cf_conditions_quantity = count( $uacf7_cf_all_tags_array );
		
				$uacf7_cf_conditions_tag_name = $uacf7_cf_conditions['uacf7_cf_tn'];
				$uacf7_cf_conditions_operator = $uacf7_cf_conditions['uacf7_cf_operator'];
				$uacf7_cf_conditions_value = $uacf7_cf_conditions['uacf7_cf_val'];
        
                ?>
                
                <div id="uacf7-cf-<?php echo esc_attr($i); ?>" class="uacf7-cf">
                   <hr>
                    <select class="uacf7-field" name="uacf7_cf_hs_<?php echo esc_attr($i); ?>">
                        <option value="show" <?php selected( $uacf7_cf_hs, 'show' ); ?>><?php echo esc_html( 'Show', 'ultimate-addons-cf7' ) ?></option>
                        <option value="hide" <?php selected( $uacf7_cf_hs, 'hide' ); ?>><?php echo esc_html( 'Hide', 'ultimate-addons-cf7' ) ?></option>
                    </select>
                    
                    <select class="uacf7-field" name="uacf7_cf_group_<?php echo esc_attr($i); ?>">
                        <?php 
                        $all_groups = $post->scan_form_tags(array('type'=>'conditional'));
                        ?>
                        <option value=""><?php echo esc_html( '-- Select element --', 'ultimate-addons-cf7' ) ?></option>
                        <?php
                        foreach ($all_groups as $tag) {
                            $class = wpcf7_form_controls_class( 'text' );
                        ?>
                        <option value="<?php echo esc_attr($tag['name']); ?>" <?php selected( $uacf7_cf_group, $tag['name'] ); ?>><?php echo esc_html($tag['name']); ?></option>
                        <?php
                        }
                        ?>
                    </select>
                    
                    <label class="uacf7-field-label"><?php echo esc_html( 'If', 'ultimate-addons-cf7' ) ?></label>
                    
                    <select class="uacf7-field" name="uacf7_cf_condition_for_<?php echo esc_attr($i); ?>">
                        <option value="any" <?php selected( $uacf7_cf_conditions_for, 'any' ); ?>><?php echo esc_html( 'Any', 'ultimate-addons-cf7' ) ?></option>
                        <option value="all" <?php selected( $uacf7_cf_conditions_for, 'all' ); ?>><?php echo esc_html( 'All', 'ultimate-addons-cf7' ) ?></option>
                    </select>
                    <a class="uacf7-add-condition button-primary" href="#" title="<?php echo esc_html( 'Add Condition', 'ultimate-addons-cf7' ) ?>" data-rule-id="<?php echo esc_attr($i); ?>"><?php echo esc_html__('Add Condition', 'ultimate-addons-cf7'); ?></a>
                    <a class="uacf7-remove button-primary" href="#" title="<?php echo esc_html( 'Remove', 'ultimate-addons-cf7' ) ?>"><?php echo esc_html__('Remove Rule', 'ultimate-addons-cf7'); ?></a>
                    <br>
                    <br>
                    
                    <div class="uacf7-condition-group" style="text-indent:320px">
                      
                      <?php $uacf7_conditions_count = get_post_meta( $post->id(), 'uacf7_conditions_count_ruleid_'.esc_attr($i).'', true ); ?>
                      
                       <div class="uacf7-conditions-wraper">

                          <?php for( $x = 0; $x < $uacf7_cf_conditions_quantity; $x++ ) : ?>
                          
                           <div class="uacf7-condition-wrap">
                                <select class="uacf7-field" name="uacf7_cf_tn_<?php echo esc_attr($i); ?>_[]">
                                    <?php
                                    $all_fields = $post->scan_form_tags();
                                    ?>
                                    <option value=""><?php echo esc_html( '-- Select field --', 'ultimate-addons-cf7' ) ?></option>
                                    <?php
                                    foreach ($all_fields as $tag) {
                                        if ($tag['type'] == 'conditional' || $tag['name'] == ''  || $tag['type'] == 'uacf7_conversational_start' || $tag['type'] == 'uacf7_conversational_end' ) continue;
                                    ?>
                                    <?php 
                                     if( !in_array('exclusive', $tag['options']) && $tag['type'] == 'checkbox' || $tag['type'] == 'checkbox*' ) { 
                                        
                                        $tag_name = $tag['name'].'[]';
                                        
                                    }else {
                                        
                                        $tag_name = $tag['name'];
                                    }
                                    ?>
                                    <option value="<?php echo esc_attr($tag_name); ?>" <?php selected( $uacf7_cf_conditions_tag_name[$x], $tag_name ); ?>><?php echo esc_html($tag['name']); ?></option>

                                    <?php
                                    }
                                    ?>
                                </select>

                                <select class="uacf7-field" name="uacf7_cf_operator_<?php echo esc_attr($i); ?>_[]">
                                   
                                    <option value="equal" <?php selected( esc_attr($uacf7_cf_conditions_operator[$x]), 'equal', true ); ?>><?php echo esc_html( 'Equal', 'ultimate-addons-cf7' ) ?></option>
                                    
                                    <option value="not_equal" <?php selected( esc_attr($uacf7_cf_conditions_operator[$x]), 'not_equal', true ); ?>><?php echo esc_html( 'Not Equal', 'ultimate-addons-cf7' ) ?></option>
                                    
                                    <option value="greater_than" <?php selected( esc_attr($uacf7_cf_conditions_operator[$x]), 'greater_than', true ); ?>><?php echo esc_html( 'Greater than', 'ultimate-addons-cf7' ) ?></option>
                                    
                                    <option value="less_than" <?php selected( esc_attr($uacf7_cf_conditions_operator[$x]), 'less_than', true ); ?>><?php echo esc_html( 'Less than', 'ultimate-addons-cf7' ) ?></option>
                                    
                                    <option value="greater_than_or_equal_to" <?php selected( esc_attr($uacf7_cf_conditions_operator[$x]), 'greater_than_or_equal_to', true ); ?>><?php echo esc_html( 'Greater than or equal to', 'ultimate-addons-cf7' ) ?></option>
                                    
                                    <option value="less_than_or_equal_to" <?php selected( esc_attr($uacf7_cf_conditions_operator[$x]), 'less_than_or_equal_to', true ); ?>><?php echo esc_html( 'Less than or equal to', 'ultimate-addons-cf7' ) ?></option>
                                    
                                </select>

                                <input class="uacf7-field uacf7-condition-value" type="text" name="uacf7_cf_val_<?php echo esc_attr($i); ?>_[]" placeholder="Value" value="<?php echo esc_html($uacf7_cf_conditions_value[$x]); ?>">
                                <a class="uacf7-remove-group" href="#" title="<?php echo esc_html( 'Remove', 'ultimate-addons-cf7' ) ?>">×</a>
                            </div>
                            
                            <?php endfor; ?>
                            
                        </div>
                        <input id="uacf7_conditions_count_ruleid" type="hidden" name="uacf7_conditions_count_ruleid_<?php echo esc_attr($i); ?>" value="<?php echo esc_attr($uacf7_conditions_count); ?>">
                    </div>
                    
                    <br>
                </div>
                
                <?php
                endfor;
                ?>
            </div>
            <?php
            $uacf7_cf_count = get_post_meta( $post->id(), 'uacf7_cf_count', true );
            ?>
            <input type="hidden" name="uacf7_cf_count" id="uacf7-cf-count" value="<?php echo esc_attr( $uacf7_cf_count ); ?>">
            <div id="uacf7-new-cf" class="button-primary"><?php echo esc_html( 'Add New Rule', 'ultimate-addons-cf7' ) ?></div>

        </fieldset>
        
        <?php
         wp_nonce_field( 'uacf7_cf_nonce_action', 'uacf7_cf_nonce' );
    }
    
    /*
    * Save meta
    */
    public function uacf7_save_meta( $post ) {
        if ( ! isset( $_POST ) || empty( $_POST ) ) {
			return;
		}
        if ( ! wp_verify_nonce( $_POST['uacf7_cf_nonce'], 'uacf7_cf_nonce_action' ) ) {
            return;
        }
        
        for( $i = 0; $i < $_POST['uacf7_cf_count']; $i++ ) {

            /*
            * Save Conditions
            */
			$tag_names = array();
            foreach($_POST['uacf7_cf_tn_'.$i.'_'] as $tag_name) {
				$tag_names[] = sanitize_text_field( $tag_name );
			}
			
			$operators = array();
            foreach( $_POST['uacf7_cf_operator_'.$i.'_'] as $operator ) {
				$operators[] = sanitize_text_field( $operator );
			}
			
			$filed_values = array();
            foreach( $_POST['uacf7_cf_val_'.$i.'_'] as $filed_value ) {
				$filed_values[] = sanitize_text_field( $filed_value );
			}
			
            //Condition rules and conditions
            $data[ $i ] = array(

                'uacf7_cf_hs' => sanitize_text_field($_POST['uacf7_cf_hs_'.$i.'']),

                'uacf7_cf_group' => sanitize_text_field($_POST['uacf7_cf_group_'.$i.'']),
                
                'uacf_cf_condition_for' => sanitize_text_field($_POST['uacf7_cf_condition_for_'.$i.'']),
                
                'uacf7_cf_conditions' => array(
                    
                    'uacf7_cf_tn' => $tag_names,
                    
                    'uacf7_cf_operator' => $operators,
					
                    'uacf7_cf_val' => $filed_values,
                ),
                
            );
            
            //Update rule condition quantity
            update_post_meta( $post->id(), 'uacf7_conditions_count_ruleid_'.$i.'', intval($_POST['uacf7_conditions_count_ruleid_'.$i.'']) );
            
        }

        if(isset($data)){
            update_post_meta( $post->id(), 'uacf7_conditions', $data );
        }
       
        
    }
    
    public function uacf7_save_contact_form( $form ) {
        
        if ( ! isset( $_POST ) || empty( $_POST ) ) {
			return;
		}
        if ( ! wp_verify_nonce( $_POST['uacf7_cf_nonce'], 'uacf7_cf_nonce_action' ) ) {
            return;
        }
        
        update_post_meta( $form->id(), 'uacf7_cf_count', intval($_POST['uacf7_cf_count']) );
    }
    
    public function get_forms() {
		$args  = array(
			'post_type'        => 'wpcf7_contact_form',
			'posts_per_page'   => -1,
		);
		$query = new WP_Query( $args );

		$forms = array();

		if ( $query->have_posts() ) :

			while ( $query->have_posts() ) :
				$query->the_post();

                $post_id = get_the_ID();

                // if($post_id != 128) continue;
                
                $conditional = uacf7_get_form_option($post_id, 'conditional');
                if($conditional != false){
                    $conditional_repeater = $conditional['conditional_repeater'];
                if($conditional_repeater != false){ 
                    $count = 0 ;
                    $data = [];

                    foreach ($conditional_repeater as $item) {
                        $newItem = [
                            'uacf7_cf_hs' => $item['uacf7_cf_hs'],
                            'uacf7_cf_group' => $item['uacf7_cf_group'],
                            'uacf7_cf_condition_for' => isset($item['uacf7_cf_condition_for']) ? $item['uacf7_cf_condition_for'] : 'any',
                            'uacf7_cf_conditions' => [
                                'uacf7_cf_tn' => [],
                                'uacf7_cf_operator' => [],
                                'uacf7_cf_val' => [],
                            ],
                        ];

                        foreach ($item['uacf7_cf_conditions'] as $condition) {
                            $newItem['uacf7_cf_conditions']['uacf7_cf_tn'][] = $condition['uacf7_cf_tn'];
                            $newItem['uacf7_cf_conditions']['uacf7_cf_operator'][] = $condition['uacf7_cf_operator'];
                            $newItem['uacf7_cf_conditions']['uacf7_cf_val'][] = $condition['uacf7_cf_val'];
                        }

                        $data[] = $newItem;
                    }
                    // uacf7_print_r($data);
                    // $data = get_post_meta( get_the_ID(), 'uacf7_conditions', true );
                    $forms[ $post_id ] = $data;
                } 
                }
                
        
			endwhile;
			wp_reset_postdata();
		endif;

		return $forms;
	}
    
    public function uacf7_properties($properties, $cfform) {
	
        if (!is_admin() || (defined('DOING_AJAX') && DOING_AJAX)) { 

            $form = $properties['form'];

            $form_parts = preg_split('/(\[\/?conditional(?:\]|\s.*?\]))/',$form, -1,PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);

            ob_start();

            $stack = array();

            foreach ($form_parts as $form_part) {
                if (substr($form_part,0,13) == '[conditional ') {
                    $tag_parts = explode(' ',rtrim($form_part,']'));

                    array_shift($tag_parts);

                    $tag_id = $tag_parts[0];
                    $tag_html_type = 'div';

                    array_push($stack,$tag_html_type);

                    echo '<'.$tag_html_type.' class="uacf7_conditional '.esc_attr($tag_id).'">';
                } else if ($form_part == '[/conditional]') {
                    echo '</'.array_pop($stack).'>';
                } else {
                    echo $form_part;
                }
            }

            $properties['form'] = ob_get_clean();
        }
        return $properties;
    }
    
    function skip_validation_for_hidden_fields($result, $tags) {

        if(isset($_POST)) {
            $this->set_hidden_fields_arrays($_POST);
        }

        $invalid_fields = $result->get_invalid_fields();
        $return_result = new WPCF7_Validation();

        if (count($this->hidden_fields) == 0 || !is_array($invalid_fields) || count($invalid_fields) == 0) {
            $return_result = $result;
        } else {
            foreach ($invalid_fields as $invalid_field_key => $invalid_field_data) {
                if (!in_array($invalid_field_key, $this->hidden_fields)) {
                    $return_result->invalidate($invalid_field_key, $invalid_field_data['reason']);
                }
            }
        }

        return apply_filters('uacf7_validate', $return_result, $tags);

    }
    
    public function uacf7_form_hidden_fields($hidden_fields) {

        $current_form = wpcf7_get_current_contact_form();
        $current_form_id = $current_form->id();

        return array_merge($hidden_fields, array(
            '_uacf7_hidden_conditional_fields' => '',
        ));
    }    
    
    public function remove_hidden_post_data($posted_data) {
        
        $this->set_hidden_fields_arrays($posted_data);
        
        foreach( $this->hidden_fields as $name => $value ) {
            unset( $posted_data[$name] );
        }

        return $posted_data;
        
    }
    
    public function set_hidden_fields_arrays($posted_data = false) {

        if (!$posted_data) {
            $posted_data = WPCF7_Submission::get_instance()->get_posted_data();
        }
        if(isset($posted_data['_uacf7_hidden_conditional_fields'])){ 
            $hidden_fields = json_decode(stripslashes($posted_data['_uacf7_hidden_conditional_fields']));
        }else{
            $hidden_fields = [];
        }
        if (is_array($hidden_fields) && count($hidden_fields) > 0) {
            foreach ($hidden_fields as $field) {
                
                $this->hidden_fields[] = $field;
            }
        }
        
    }

    /* Skip validation for hidden file field */
    function skip_validation_for_hidden_file_field($result, $tag, $args=[]) {

        if (!count($result->get_invalid_fields())) {
            return $result;
        }
        if(isset($_POST)) {
            $this->set_hidden_fields_arrays($_POST);
        }

        $invalid_field_keys = array_keys($result->get_invalid_fields());

        if (isset($this->hidden_fields) && is_array($this->hidden_fields) && in_array($tag->name, $this->hidden_fields) && count($invalid_field_keys) == 1) {
            return new WPCF7_Validation();
        }

        return $result;
    }
    
    public function uacf7_config_validator_validate(WPCF7_ConfigValidator $wpcf7_config_validator) {

	    $cf = $wpcf7_config_validator->contact_form();
	    $all_group_tags = $cf->scan_form_tags();

    	foreach ($wpcf7_config_validator->collect_error_messages() as $err_type => $err) {

		    $parts = explode('.',$err_type);

		    $property = $parts[0];

		    if ($property == 'form') continue; 

		    $sub_prop = $parts[1];
		    $prop_val = $cf->prop($property)[$sub_prop];

		    if (strpos($prop_val, '[/') !== false) {
			    $wpcf7_config_validator->remove_error($err_type, WPCF7_ConfigValidator::error_invalid_mailbox_syntax);
				continue;
		    }
	    }

    	return new WPCF7_ConfigValidator($wpcf7_config_validator->contact_form());
    }


    /**
     * uacf7_conditional_mail_properties Function
     * @author Sydur Rahman
     * @since 3.2.1
     */ 
    public function uacf7_conditional_mail_properties($WPCF7_ContactForm){
        $wpcf7 = WPCF7_ContactForm :: get_current() ;
        $submission = WPCF7_Submission :: get_instance() ;

        // Get the conditional fields
        $uacf7_conditions = get_post_meta( $wpcf7->id(), 'uacf7_conditions', true );

        if ($submission && is_array($uacf7_conditions) && !empty($uacf7_conditions)){
            $posted_data = $submission->get_posted_data();
            $form_tags = $submission->get_contact_form()->form_scan_shortcode();

            // Set the email body in the mail properties
            $properties = $submission->get_contact_form()->get_properties();

            // Get the email body
            $mail_body = $properties['mail']['body'];
            $mail_body_2 = $properties['mail_2']['body'];
           
            // Loop through the conditional fields
            foreach($uacf7_conditions as $key => $condition){
                $uacf7_cf_hs = $condition['uacf7_cf_hs'];
                $uacf7_cf_group = $condition['uacf7_cf_group'];
                $uacf7_cf_conditions_for = $condition['uacf_cf_condition_for'];
                $uacf7_cf_conditions = $condition['uacf7_cf_conditions'];
                $condition_status = [];

                // Check if the conditional field is hidden or shown
                foreach($uacf7_cf_conditions['uacf7_cf_tn'] as $key => $value){
                    
                    $posted_value  = is_array($posted_data[$value]) && in_array($uacf7_cf_conditions['uacf7_cf_val'][$key], $posted_data[$value]) ? $uacf7_cf_conditions['uacf7_cf_val'][$key] : $posted_data[$value];

                    // Condition for Equal  
                    if($uacf7_cf_conditions['uacf7_cf_operator'][$key] == 'equal' && $posted_value == $uacf7_cf_conditions['uacf7_cf_val'][$key]){
                        $condition_status[] = 'true';
                    }
                    // Condition for Not Equal
                    else if($uacf7_cf_conditions['uacf7_cf_operator'][$key] == 'not_equal' && $posted_value != $uacf7_cf_conditions['uacf7_cf_val'][$key]){
                    
                        $condition_status[] = 'true';
                    } 
                    // Condition for Greater than
                    else if($uacf7_cf_conditions['uacf7_cf_operator'][$key] == 'greater_than' && $posted_value > $uacf7_cf_conditions['uacf7_cf_val'][$key]){
                        $condition_status[] = 'true';
                    }  
                    // Condition for Less than
                    else if($uacf7_cf_conditions['uacf7_cf_operator'][$key] == 'less_than' && $posted_value < $uacf7_cf_conditions['uacf7_cf_val'][$key]){
                        $condition_status[] = 'true';
                    }  
                    // Condition for Greater than or equal to
                    else if($uacf7_cf_conditions['uacf7_cf_operator'][$key] == 'greater_than_or_equal_to' && $posted_value >= $uacf7_cf_conditions['uacf7_cf_val'][$key]){
                        $condition_status[] = 'true';
                    }  
                    // Condition for Less than or equal to
                    else if($uacf7_cf_conditions['uacf7_cf_operator'][$key] == 'less_than_or_equal_to' && $posted_value <= $uacf7_cf_conditions['uacf7_cf_val'][$key]){
                        $condition_status[] = 'true';
                    }else{
                        $condition_status[] = 'false';
                    }
                }; 

                // Check if the conditions for all  
                if($uacf7_cf_conditions_for == 'all'){
                    if( !in_array('false', $condition_status) ){ 
                        if( $uacf7_cf_hs == 'show'){
                                $mail_body = preg_replace('/\['.$uacf7_cf_group.'\]/s', '', $mail_body); 
                                $mail_body = preg_replace('/\[\/'.$uacf7_cf_group.'\]/s', '', $mail_body);

                                // Mail 2 
                                $mail_body_2 = preg_replace('/\['.$uacf7_cf_group.'\]/s', '', $mail_body_2); 
                                $mail_body_2 = preg_replace('/\[\/'.$uacf7_cf_group.'\]/s', '', $mail_body_2);
                        }
                    } 
                    else{
                        $mail_body = preg_replace('/\['.$uacf7_cf_group.'\].*?\[\/'.$uacf7_cf_group.'\]/s', '', $mail_body); 
    
                        // Mail 2 
                        $mail_body_2 = preg_replace('/\['.$uacf7_cf_group.'\].*?\[\/'.$uacf7_cf_group.'\]/s', '', $mail_body_2);  
                    } 
                } 
                // Check if the conditions for all 
                if($uacf7_cf_conditions_for == 'any'){
                    if( !in_array('false', $condition_status) ){ 
                        if( $uacf7_cf_hs == 'show'){
                                $mail_body = preg_replace('/\['.$uacf7_cf_group.'\]/s', '', $mail_body); 
                                $mail_body = preg_replace('/\[\/'.$uacf7_cf_group.'\]/s', '', $mail_body);

                                // Mail 2 
                                $mail_body_2 = preg_replace('/\['.$uacf7_cf_group.'\]/s', '', $mail_body_2); 
                                $mail_body_2 = preg_replace('/\[\/'.$uacf7_cf_group.'\]/s', '', $mail_body_2);
                        }
                    } 
                    else{
                        $mail_body = preg_replace('/\['.$uacf7_cf_group.'\].*?\[\/'.$uacf7_cf_group.'\]/s', '', $mail_body); 
    
                        // Mail 2 
                        $mail_body_2 = preg_replace('/\['.$uacf7_cf_group.'\].*?\[\/'.$uacf7_cf_group.'\]/s', '', $mail_body_2);  
                    } 
                } 
            } 
          
            // Set the email body in the mail properties
            $properties['mail']['body'] = $mail_body;

            // Mail 2
            $properties['mail_2']['body'] = $mail_body_2;
    
            $submission->get_contact_form()->set_properties($properties);
    
        }
    } 
    

}
new UACF7_CF();
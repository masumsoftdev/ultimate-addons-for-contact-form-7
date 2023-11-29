<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

 /**
 * Include Classes  
 */
if ( file_exists( UACF7_PATH . 'inc/class-setup-wizard.php' ) ) {
    require_once UACF7_PATH . 'inc/class-setup-wizard.php';
} 



 /**
 * Global Admin Get Option
 */
if ( ! function_exists( 'uacf7_settings' ) ) {
    add_filter('uacf7_settings', 'uacf7_settings', 10, 2);
    function uacf7_settings( $option = '') {

        $value = get_option( 'uacf7_settings' );

         
        if( empty($option) ) {
            return $value;
        }

        if( isset( $value[$option] ) ) {
            return $value[$option];
        }else{
            return false;
        }
    }
}


/*
Function: uacf7_checked
Return: checked
*/
if( !function_exists('uacf7_checked') ){
    function uacf7_checked( $name ){
    
        //Get settings option
        $uacf7_options = get_option( apply_filters( 'uacf7_option_name', 'uacf7_option_name' ) );

        if( isset( $uacf7_options[$name] ) && $uacf7_options[$name] === 'on' ) {
            return 'checked';
        }
    }
}

/*
Function: uacf7_print_r
Return: checked
*/
if( !function_exists('uacf7_print_r') ){
    function uacf7_print_r( $value ){
        echo '<pre>';
        print_r($value);
        echo '</pre>';
        // exit;
    }
}


/*
Function: uacf7_get_form_option
Return: checked
*/
if( !function_exists('uacf7_get_form_option') ){
    function uacf7_get_form_option( $id, $key ){
        $value = get_post_meta( $id, 'uacf7_form_opt', true );  
        
        if( empty($key) ) {
            return $value;
        } 
        if( isset( $value[$key] ) ) {
            return $value[$key];
        }else{
            return false;
        }
       
    }
}

/*
* Hook: uacf7_multistep_pro_features
* Multistep pro features demo
*/
add_action( 'uacf7_multistep_pro_features', 'uacf7_multistep_pro_features_demo', 5, 2 );
function uacf7_multistep_pro_features_demo( $all_steps, $form_id ){ 
    if(!isset($all_steps[0])) return;
    if( empty(array_filter($all_steps))) return;
    ?>
    <div class="multistep_fields_row" style="display: flex; flex-direction: column;">
    <?php
    $step_count = 1;
    foreach( $all_steps as $step ) {
        ?>
        <h3><strong>Step <?php echo $step_count; ?> <a style="color:red" target="_blank" href="https://cf7addons.com/preview/pro">(Pro)</a></strong></h3>
        <?php
        if( $step_count == 1 ){
            ?>
            <div>
               <p><label for="<?php echo 'next_btn_'.$step->name; ?>"><?php echo __('Change next button text for this Step', 'ultimate-addons-cf7' ) ?></label></p>
               <input id="<?php echo 'next_btn_'.$step->name; ?>" type="text" name="" value="" placeholder="<?php echo esc_html__('Next','ultimate-addons-cf7-pro') ?>">
            </div>
            <?php
        } else {

            if( count($all_steps) == $step_count ) {
                ?>
                <div>
                   <p><label for="<?php echo 'prev_btn_'.$step->name; ?>"><?php echo __('Change previous button text for this Step', 'ultimate-addons-cf7' ) ?></label></p>
                   <input id="<?php echo 'prev_btn_'.$step->name; ?>" type="text" name="" value="" placeholder="<?php echo esc_html__('Previous','ultimate-addons-cf7-pro') ?>">
                </div>
                <?php

            } else {
                ?>
                <div class="multistep_fields_row-">
                    <div class="multistep_field_column">
                       <p><label for="<?php echo 'prev_btn_'.$step->name; ?>"><?php echo __('Change previous button text for this Step', 'ultimate-addons-cf7' ) ?></label></p>
                       <input id="<?php echo 'prev_btn_'.$step->name; ?>" type="text" name="" value="" placeholder="<?php echo esc_html__('Previous','ultimate-addons-cf7-pro') ?>">
                    </div>

                    <div class="multistep_field_column">
                       <p><label for="<?php echo 'next_btn_'.$step->name; ?>"><?php echo __('Change next button text for this Step', 'ultimate-addons-cf7' ) ?></label></p>
                       <input id="<?php echo 'next_btn_'.$step->name; ?>" type="text" name="" value="" placeholder="<?php echo esc_html__('Next','ultimate-addons-cf7-pro') ?>">
                    </div>
                </div>
                <?php
            }

        }
        ?>
        <div class="uacf7_multistep_progressbar_image_row">
           <p><label for="<?php echo esc_attr('uacf7_progressbar_image_'.$step->name); ?>"><?php echo __('Add progressbar image for this step', 'ultimate-addons-cf7' ) ?></label></p>
           <input class="uacf7_multistep_progressbar_image" id="<?php echo esc_attr('uacf7_progressbar_image_'.$step->name); ?>" type="url" name="" value=""> <a class="button-primary" href="#"><?php echo __('Add or Upload Image', 'ultimate-addons-cf7' ) ?></a>
           
           <div class="multistep_fields_row step-title-description col-50">
                <div class="multistep_field_column">
                   <p><label for="<?php echo 'step_desc_'.$step->name; ?>"><?php echo __('Step description', 'ultimate-addons-cf7' ) ?></label></p>
                   <textarea id="<?php echo 'step_desc_'.$step->name; ?>" type="text" name="" cols="40" rows="3" placeholder="<?php echo esc_html__('Step description','ultimate-addons-cf7-pro') ?>"></textarea>
                </div>
    
                <div class="multistep_field_column">
                   <p><label for="<?php echo 'desc_title_'.$step->name; ?>"><?php echo __('Description title', 'ultimate-addons-cf7' ) ?></label></p>
                   <input id="<?php echo 'desc_title_'.$step->name; ?>" type="text" name="" value="" placeholder="<?php echo esc_html__('Description title','ultimate-addons-cf7-pro') ?>">
                </div>
            </div>
        </div>
        <?php
        $step_count++;
    }
    ?>
    </div>
    <?php
}

/*
* Progressbar style
*/
add_action( 'uacf7_multistep_before_form', 'uacf7_multistep_progressbar_style', 10 );
function uacf7_multistep_progressbar_style( $form_id ) {
    $uacf7_multistep_circle_width = get_post_meta( $form_id, 'uacf7_multistep_circle_width', true ); 
    $uacf7_multistep_circle_height = get_post_meta( $form_id, 'uacf7_multistep_circle_height', true ); 
    $uacf7_multistep_circle_bg_color = get_post_meta( $form_id, 'uacf7_multistep_circle_bg_color', true ); 
    $uacf7_multistep_circle_font_color = get_post_meta( $form_id, 'uacf7_multistep_circle_font_color', true ); 
    $uacf7_multistep_circle_border_radious = get_post_meta( $form_id, 'uacf7_multistep_circle_border_radious', true ); 
    $uacf7_multistep_font_size = get_post_meta( $form_id, 'uacf7_multistep_font_size', true ); 
    $uacf7_multistep_circle_active_color = get_post_meta( $form_id, 'uacf7_multistep_circle_active_color', true );
    $uacf7_multistep_progress_line_color = get_post_meta( $form_id, 'uacf7_multistep_progress_line_color', true );
    ?>
    <style>
    .steps-form .steps-row .steps-step .btn-circle {
        <?php if(!empty($uacf7_multistep_circle_width)) echo 'width: '.esc_attr($uacf7_multistep_circle_width).'px;'; ?>
        <?php if(!empty($uacf7_multistep_circle_height)) echo 'height: '.esc_attr($uacf7_multistep_circle_height).'px;'; ?>
        <?php if($uacf7_multistep_circle_border_radious != '' ) echo 'border-radius: '.$uacf7_multistep_circle_border_radious.'px;'; ?>
        <?php if(!empty($uacf7_multistep_circle_height)) echo 'line-height: '.esc_attr($uacf7_multistep_circle_height).'px;'; ?>
        <?php if(!empty($uacf7_multistep_circle_bg_color)) echo 'background-color: '.esc_attr($uacf7_multistep_circle_bg_color).' !important;'; ?>
        <?php if(!empty($uacf7_multistep_circle_font_color)) echo 'color: '.esc_attr($uacf7_multistep_circle_font_color).' !important;'; ?>
        <?php if(!empty($uacf7_multistep_font_size)) echo 'font-size: '.esc_attr($uacf7_multistep_font_size).'px;'; ?>
    }
	.steps-form .steps-row .steps-step .btn-circle img {
		<?php if( $uacf7_multistep_circle_border_radious != 0 ) echo 'border-radius: '.$uacf7_multistep_circle_border_radious.'px !important;'; ?>
	}
    .steps-form .steps-row .steps-step .btn-circle.uacf7-btn-active,
    .steps-form .steps-row .steps-step .btn-circle:hover,
    .steps-form .steps-row .steps-step .btn-circle:focus,
    .steps-form .steps-row .steps-step .btn-circle:active{
        <?php if(!empty($uacf7_multistep_circle_active_color)) echo 'background-color: '.esc_attr($uacf7_multistep_circle_active_color).' !important;'; ?>
        <?php if(!empty($uacf7_multistep_circle_font_color)) echo 'color: '.esc_attr($uacf7_multistep_circle_font_color).';'; ?>
    }
    .steps-form .steps-row .steps-step p {
        <?php if(!empty($uacf7_multistep_font_size)) echo 'font-size: '.esc_attr($uacf7_multistep_font_size).'px;'; ?>
    }
    .steps-form .steps-row::before {
        <?php if(!empty($uacf7_multistep_circle_height)) echo 'top: '.esc_attr($uacf7_multistep_circle_height / 2).'px;'; ?>
    }
    <?php if(!empty($uacf7_multistep_progress_line_color)): ?>
    .steps-form .steps-row::before {
    	background-color: <?php echo esc_attr($uacf7_multistep_progress_line_color); ?>;
    }
    <?php endif; ?>
    </style>
    <?php
}


//Dispal repeater pro feature

if( !function_exists('uacf7_tg_pane_repeater') ) {
    add_action( 'admin_init', 'uacf7_repeater_pro_tag_generator' );
}

function uacf7_repeater_pro_tag_generator() {
    if (! function_exists( 'wpcf7_add_tag_generator'))
        return;

    wpcf7_add_tag_generator('repeater',
        __('Ultimate Repeater (pro)', 'ultimate-addons-cf7'),
        'uacf7-tg-pane-repeater',
        'uacf7_tg_pane_repeater_pro'
    );

}

function uacf7_tg_pane_repeater_pro( $contact_form, $args = '' ) {
    $args = wp_parse_args( $args, array() );
    $uacf7_field_type = 'repeater';
    ?>
    <div class="control-box">
        <fieldset>
            <legend>
                <?php echo esc_html__( "This is a Pro feature of Ultimate Addons for contact form 7. You can add repeatable field and repeatable fields group with this addon.", "ultimate-addons-cf7" ); ?> <a href="https://cf7addons.com/preview/repeater-field/" target="_blank">Check Preview</a>
            </legend>
            <table class="form-table">
                <tbody>
                    <tr>
                        <th scope="row"><label for="<?php echo esc_attr( $args['content'] . '-name' ); ?>"><?php echo esc_html( __( 'Name', 'ultimate-addons-cf7' ) ); ?></label></th>
                        <td><input type="text" name="name" class="tg-name oneline" id="<?php echo esc_attr( $args['content'] . '-name' ); ?>" /></td>
                    </tr>
                    <tr>
                    	<th scope="row"><label for="tag-generator-panel-text-values"><?php echo __('Add Button Text', 'ultimate-addons-cf7' ) ?></label></th>
                    	<td><input type="text" name="" class="tg-name oneline uarepeater-add" value="Add more" id="tag-generator-panel-uarepeater-nae"></td>
                	</tr>
                	<tr>
                    	<th scope="row"><label for="tag-generator-panel-text-values-remove"><?php echo __('Remove Button Text', 'ultimate-addons-cf7' ) ?></label></th>
                    	<td><input type="text" name="" class="tg-name oneline uarepeater-remove" value="Remove" id="tag-generator-panel-uarepeater-n"></td>
                	</tr>
                    
                </tbody>
            </table>
        </fieldset>
    </div>
    <?php
}

//Add wrapper to contact form 7
add_filter( 'wpcf7_contact_form_properties', 'uacf7_add_wrapper_to_cf7_form', 10, 2 );
function uacf7_add_wrapper_to_cf7_form($properties, $cfform) {
    if (!is_admin() || (defined('DOING_AJAX') && DOING_AJAX)) {
    
        $form = $properties['form'];
        ob_start();
        echo '<div class="uacf7-form-'.$cfform->id().'">'.$form.'</div>';
        $properties['form'] = ob_get_clean();
        
    }
	return $properties;
}

/**
 * Black Friday Deals 2023
 */
 
if(!function_exists('tf_black_friday_2023_admin_notice') && !class_exists('Ultimate_Addons_CF7_PRO')){
	function tf_black_friday_2023_admin_notice(){ 
        
        // Set the expiration time to 3 hours from the current time
        $expiration_time = time() + 3 * 60 * 60;  
        $tf_display_admin_notice_time = get_option( 'tf_display_admin_notice_time' );
        if($tf_display_admin_notice_time == ''){
            update_option( 'tf_display_admin_notice_time', $expiration_time );
        }

		$deal_link =sanitize_url('https://themefic.com/deals/');
        $tf_display_admin_notice_time = get_option( 'tf_display_admin_notice_time' );
		$get_current_screen = get_current_screen();  
		if(!isset($_COOKIE['tf_dismiss_admin_notice']) && $get_current_screen->base == 'dashboard' && time() > $tf_display_admin_notice_time  ){ 
            ?>
            <style> 
                .tf_black_friday_20222_admin_notice a:focus {
                    box-shadow: none;
                } 
                .tf_black_friday_20222_admin_notice {
                    padding: 7px;
                    position: relative;
                    z-index: 10;
                    max-width: 825px;
                } 
                .tf_black_friday_20222_admin_notice button:before {
                    color: #fff !important;
                }
                .tf_black_friday_20222_admin_notice button:hover::before {
                    color: #d63638 !important;
                }
            </style>
            <div class="notice notice-success tf_black_friday_20222_admin_notice"> 
                <a href="<?php echo $deal_link; ?>" style="display: block; line-height: 0;" target="_blank" >
                    <img  style="width: 100%;" src="<?php echo sanitize_url( 'https://themefic.com/wp-content/uploads/2023/11/Themefic_BlackFriday_rectangle_banner.png') ?>" alt="">
                </a> 
                <button type="button" class="notice-dismiss tf_black_friday_notice_dismiss"><span class="screen-reader-text"><?php echo __('Dismiss this notice.', 'ultimate-addons-cf7' ) ?></span></button>
            </div>
            <script>
                jQuery(document).ready(function($) {
                    $(document).on('click', '.tf_black_friday_notice_dismiss', function( event ) {
                        jQuery('.tf_black_friday_20222_admin_notice').css('display', 'none')
                        data = {
                            action : 'tf_black_friday_notice_dismiss_callback',
                        };

                        $.ajax({
                            url: ajaxurl,
                            type: 'post',
                            data: data,
                            success: function (data) { ;
                            },
                            error: function (data) { 
                            }
                        });
                    });
                });
            </script>
        
        <?php 
		}
		
	} 
	if (strtotime('2023-12-01') > time()) {
		add_action( 'admin_notices', 'tf_black_friday_2023_admin_notice' );  
	}   
}

if(!function_exists('tf_black_friday_notice_dismiss_callback')){
	function tf_black_friday_notice_dismiss_callback() { 
		$cookie_name = "tf_dismiss_admin_notice";
		$cookie_value = "1"; 
		setcookie($cookie_name, $cookie_value, strtotime('2023-12-01'), "/"); 
        update_option( 'tf_display_admin_notice_time', '1' );
		wp_die();
	}
	add_action( 'wp_ajax_tf_black_friday_notice_dismiss_callback', 'tf_black_friday_notice_dismiss_callback' );
}

if(!function_exists('uacf7_black_friday_2022_callback') && !class_exists('Ultimate_Addons_CF7_PRO')){
	 
	if (strtotime('2023-12-01') > time()) { 
		add_action( 'wpcf7_admin_misc_pub_section', 'uacf7_black_friday_2022_callback' );
	}    
	function uacf7_black_friday_2022_callback(){
		$deal_link =sanitize_url('https://themefic.com/deals/');
	?> 
		<style> 
			.back_friday_2022_preview a:focus {
				box-shadow: none;
			} 
			.back_friday_2022_preview a {
				display: inline-block;
			}
			#uacf7_black_friday_docs .inside {
				padding: 0;
				margin-top: 0;
			}
            #uacf7_black_friday_docs .postbox-header {
				display: none;
				visibility: hidden;
			}
            .back_friday_2022_preview {
                position: relative;
            }
            .tf_black_friday_cf7_notice_dismiss {
                position: ;
                z-index: 1;
            }
		 
		</style>
        <?php if(!isset($_COOKIE['uacf7_dismiss_post_notice'])): ?>
		<div class="back_friday_2022_preview" style="text-align: center; overflow: hidden; margin: 10px;">
			<a href="<?php echo $deal_link; ?>" target="_blank" >
				<img  style="width: 100%;" src="<?php echo sanitize_url( 'https://themefic.com/wp-content/uploads/2023/11/UACF7_BlackFriday_Square_banner.png' ) ?>" alt="">
			</a>  
            <button type="button" class="notice-dismiss tf_black_friday_cf7_notice_dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button>
		</div>
        <script>
            jQuery(document).ready(function($) {
                $(document).on('click', '.tf_black_friday_cf7_notice_dismiss', function( event ) { 
                    jQuery('.back_friday_2022_preview').css('display', 'none')
                    data = {
                        action : 'uacf7_black_friday_notice_cf7_dismiss_callback', 
                    };

                    $.ajax({
                        url: ajaxurl,
                        type: 'post',
                        data: data,
                        success: function (data) { ;
                        },
                        error: function (data) { 
                        }
                    });
                });
            });
        </script>
        <?php endif; ?>
	<?php
	}  
    function uacf7_black_friday_notice_cf7_dismiss_callback() { 
        $cookie_name = "uacf7_dismiss_post_notice";
        $cookie_value = "1";
        setcookie($cookie_name, $cookie_value, time() + (86400 * 5), "/"); 
        wp_die();
    }
    add_action( 'wp_ajax_uacf7_black_friday_notice_cf7_dismiss_callback', 'uacf7_black_friday_notice_cf7_dismiss_callback' );
     
}


// Themefic Plugin Set Admin Notice Status
if(!function_exists('uacf7_review_activation_status')){

    function uacf7_review_activation_status(){ 
        $uacf7_installation_date = get_option('uacf7_installation_date'); 
        if( !isset($_COOKIE['uacf7_installation_date']) && empty($uacf7_installation_date) && $uacf7_installation_date == 0){
            setcookie('uacf7_installation_date', 1, time() + (86400 * 7), "/"); 
        }else{
            update_option( 'uacf7_installation_date', '1' );
        }
    }
    add_action('admin_init', 'uacf7_review_activation_status');
}

// Themefic Plugin Review Admin Notice
if(!function_exists('uacf7_review_notice')){
    
     function uacf7_review_notice(){ 
        $get_current_screen = get_current_screen();  
        if($get_current_screen->base == 'dashboard'){
            $current_user = wp_get_current_user();
        ?>
            <div class="notice notice-info themefic_review_notice"> 
               
                <?php echo sprintf( 
                        __( ' <p>Hey %1$s 👋, You have been using <b>%2$s</b> for quite a while. If you feel %2$s is helping your business to grow in any way, would you please help %2$s to grow by simply leaving a 5* review on the WordPress Forum?', 'ultimate-addons-cf7' ),
                        $current_user->display_name,
                        'Ultimate Addons for Contact Form 7'
                    ); ?> 
                
                <ul>
                    <li><a target="_blank" href="<?php echo esc_url('https://wordpress.org/plugins/ultimate-addons-for-contact-form-7/#reviews') ?>" class=""><span class="dashicons dashicons-external"></span><?php _e(' Ok, you deserve it!', 'ultimate-addons-cf7' ) ?></a></li>
                    <li><a href="#" class="already_done" data-status="already"><span class="dashicons dashicons-smiley"></span> <?php _e('I already did', 'ultimate-addons-cf7') ?></a></li>
                    <li><a href="#" class="later" data-status="later"><span class="dashicons dashicons-calendar-alt"></span> <?php _e('Maybe Later', 'ultimate-addons-cf7') ?></a></li>
                    <li><a target="_blank"  href="<?php echo esc_url('https://themefic.com/docs/ultimate-addons-for-contact-form-7/') ?>" class=""><span class="dashicons dashicons-sos"></span> <?php _e('I need help', 'ultimate-addons-cf7') ?></a></li>
                    <li><a href="#" class="never" data-status="never"><span class="dashicons dashicons-dismiss"></span><?php _e('Never show again', 'ultimate-addons-cf7') ?> </a></li> 
                </ul>
                <button type="button" class="notice-dismiss review_notice_dismiss"><span class="screen-reader-text"><?php _e('Dismiss this notice.', 'ultimate-addons-cf7') ?></span></button>
            </div>

            <!--   Themefic Plugin Review Admin Notice Script -->
            <script>
                jQuery(document).ready(function($) {
                    $(document).on('click', '.already_done, .later, .never', function( event ) {
                        event.preventDefault();
                        var $this = $(this);
                        var status = $this.attr('data-status'); 
                        $this.closest('.themefic_review_notice').css('display', 'none')
                        data = {
                            action : 'uacf7_review_notice_callback',
                            status : status,
                        };

                        $.ajax({
                            url: ajaxurl,
                            type: 'post',
                            data: data,
                            success: function (data) { ;
                            },
                            error: function (data) { 
                            }
                        });
                    });

                    $(document).on('click', '.review_notice_dismiss', function( event ) {
                        event.preventDefault(); 
						var $this = $(this);
                        $this.closest('.themefic_review_notice').css('display', 'none')
                        
                    });
                });

            </script>
        <?php  
        }
     }
     $uacf7_review_notice_status = get_option('uacf7_review_notice_status'); 
     $uacf7_installation_date = get_option('uacf7_installation_date'); 
     if(isset($uacf7_review_notice_status) && $uacf7_review_notice_status <= 0 && $uacf7_installation_date == 1 && !isset($_COOKIE['uacf7_review_notice_status']) && !isset($_COOKIE['uacf7_installation_date'])){ 
        add_action( 'admin_notices', 'uacf7_review_notice' );  
     }
     
}

 
// Themefic Plugin Review Admin Notice Ajax Callback 
if(!function_exists('uacf7_review_notice_callback')){

    function uacf7_review_notice_callback(){
        $status = $_POST['status'];
        if( $status == 'already'){ 
            update_option( 'uacf7_review_notice_status', '1' );
        }else if($status == 'never'){ 
            update_option( 'uacf7_review_notice_status', '2' );
        }else if($status == 'later'){
            $cookie_name = "uacf7_review_notice_status";
            $cookie_value = "1";
            setcookie($cookie_name, $cookie_value, time() + (86400 * 7), "/"); 
            update_option( 'uacf7_review_notice_status', '0' ); 
        }  
        wp_die();
    }
    add_action( 'wp_ajax_uacf7_review_notice_callback', 'uacf7_review_notice_callback' );

}

// Themefic Plugin Review Admin Notice Ajax Callback 
if(!function_exists('uacf7_form_option_Migration_callback')){
   
    function uacf7_form_option_Migration_callback(){
        $migration_status = get_option('uacf7_settings_migration_status');

        if($migration_status != true){
           
            // Meta settings_migration migration 
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
                        // $uacf7_redirect_tag_support = get_post_meta( get_the_ID(), 'uacf7_redirect_tag_support', true );
                        // $meta = uacf7_get_form_option($post_id, '');  
                    
                    // Current Contact Form tags
                    $form_current = WPCF7_ContactForm::get_instance($post_id);
                                    
                    $meta =  get_post_meta( $post_id, 'uacf7_form_opt', true ) !='' ? get_post_meta( $post_id, 'uacf7_form_opt', true ) : array();

                        //  Redirection addon Migration
                        $uacf7_redirect_enable = get_post_meta( get_the_ID(), 'uacf7_redirect_enable', true ) == 'yes' ? 1 : 0;
                        if($uacf7_redirect_enable == true){
                            $uacf7_redirect_uacf7_redirect_to_type = get_post_meta( get_the_ID(), 'uacf7_redirect_uacf7_redirect_to_type', true );
                            $uacf7_redirect_page_id = get_post_meta( get_the_ID(), 'uacf7_redirect_page_id', true );
                            $uacf7_redirect_external_url = get_post_meta( get_the_ID(), 'uacf7_redirect_external_url', true );
                            $uacf7_conditional_redirect_conditions = get_post_meta( get_the_ID(), 'uacf7_conditional_redirect_conditions', true );
                            $uacf7_redirect_target = get_post_meta( get_the_ID(), 'uacf7_redirect_target', true ) == 'yes' ? 1 : 0;
                            $uacf7_redirect_type = get_post_meta( get_the_ID(), 'uacf7_redirect_type', true ) == 'yes' ? 1 : 0;
                            $uacf7_redirect_tag_support = get_post_meta( get_the_ID(), 'uacf7_redirect_tag_support', true ) == 'on' ? 1 : 0; 
                        
                            $meta['uacf7_redirect_enable'] = $uacf7_redirect_enable;
                            $meta['uacf7_redirect_to_type'] = $uacf7_redirect_uacf7_redirect_to_type;
                            $meta['page_id'] = $uacf7_redirect_page_id;
                            $meta['external_url'] = $uacf7_redirect_external_url;
                            $meta['target'] = $uacf7_redirect_target;
                            $meta['uacf7_redirect_type'] = $uacf7_redirect_type;
                            $meta['uacf7_redirect_tag_support'] = $uacf7_redirect_tag_support;
                            $i = 0;
                            if($uacf7_redirect_type == 1){
                                foreach( $uacf7_conditional_redirect_conditions['uacf7_cr_tn'] as $key => $value ){ 
                                    $meta['conditional_redirect'][$i]['uacf7_cr_tn'] = $uacf7_conditional_redirect_conditions['uacf7_cr_tn'][$i];
                                    $meta['conditional_redirect'][$i]['uacf7_cr_field_val'] = $uacf7_conditional_redirect_conditions['uacf7_cr_field_val'][$i];
                                    $meta['conditional_redirect'][$i]['uacf7_cr_redirect_to_url'] = $uacf7_conditional_redirect_conditions['uacf7_cr_redirect_to_url'][$i];
        
                                    $i++; 
                                
                                }
                            }
                            
                        }
                        
                        //  Conditional addon Migration 
                        
                        $condition = get_post_meta( get_the_ID(), 'uacf7_conditions', true );
                        if(is_array($condition)){
                            $count = 0 ;
                            foreach($condition as $value){
                                $meta['conditional_repeater'][$count]['uacf7_cf_group'] = $value['uacf7_cf_group']; 
                                $meta['conditional_repeater'][$count]['uacf7_cf_hs'] = $value['uacf7_cf_hs']; 
                                $meta['conditional_repeater'][$count]['uacf_cf_condition_for'] = $value['uacf_cf_condition_for']; 

                                if(!empty($value['uacf7_cf_conditions']) && isset($value['uacf7_cf_conditions'])){
                                    $i = 0;
                                    foreach($value['uacf7_cf_conditions']['uacf7_cf_tn'] as $cf_key => $cf_value ){
                                        $meta['conditional_repeater'][$count]['uacf7_cf_conditions'][$i]['uacf7_cf_tn'] = $value['uacf7_cf_conditions']['uacf7_cf_tn'][$i];
                                        $meta['conditional_repeater'][$count]['uacf7_cf_conditions'][$i]['uacf7_cf_operator'] = $value['uacf7_cf_conditions']['uacf7_cf_operator'][$i];
                                        $meta['conditional_repeater'][$count]['uacf7_cf_conditions'][$i]['uacf7_cf_val'] = $value['uacf7_cf_conditions']['uacf7_cf_val'][$i];

                                        $i++;
                                    }
                                }
                                
                            $count++;
                            }
                            
                        } 



                    
                        // Placehoder addon Migration
                        $uacf7_enable_placeholder_styles = get_post_meta( get_the_ID(), 'uacf7_enable_placeholder_styles', true ) == 'on' ? 1 : 0;
                        if($uacf7_enable_placeholder_styles == true){
                            $uacf7_placeholder_fontsize = get_post_meta( get_the_ID(), 'uacf7_placeholder_fontsize', true );
                            $uacf7_placeholder_fontstyle = get_post_meta( get_the_ID(), 'uacf7_placeholder_fontstyle', true );
                            $uacf7_placeholder_fontfamily = get_post_meta( get_the_ID(), 'uacf7_placeholder_fontfamily', true );
                            $uacf7_placeholder_fontweight = get_post_meta( get_the_ID(), 'uacf7_placeholder_fontweight', true );
                            $uacf7_placeholder_color = get_post_meta( get_the_ID(), 'uacf7_placeholder_color', true );
                            $uacf7_placeholder_background_color = get_post_meta( get_the_ID(), 'uacf7_placeholder_background_color', true );

                            $meta['uacf7_enable_placeholder_styles'] = $uacf7_enable_placeholder_styles;
                            $meta['uacf7_placeholder_fontsize'] = $uacf7_placeholder_fontsize;
                            $meta['uacf7_placeholder_fontstyle'] = $uacf7_placeholder_fontstyle;
                            $meta['uacf7_placeholder_fontfamily'] = $uacf7_placeholder_fontfamily;
                            $meta['uacf7_placeholder_fontweight'] = $uacf7_placeholder_fontweight;
                            $meta['uacf7_placeholder_color_option']['uacf7_placeholder_color'] = $uacf7_placeholder_color;
                            $meta['uacf7_placeholder_color_option']['uacf7_placeholder_background_color'] = $uacf7_placeholder_background_color;
                        }


                    
                
                        // // styler addon Migration
                        $uacf7_enable_form_styles = get_post_meta( get_the_ID(), 'uacf7_enable_form_styles', true ) == 'on' ? 1 : 0;
                        if($uacf7_enable_form_styles == true){
                            $uacf7_uacf7style_label_color = get_post_meta( get_the_ID(), 'uacf7_uacf7style_label_color', true );
                            $uacf7_uacf7style_label_background_color = get_post_meta( get_the_ID(), 'uacf7_uacf7style_label_background_color', true );
                            $uacf7_uacf7style_label_font_size = get_post_meta( get_the_ID(), 'uacf7_uacf7style_label_font_size', true );
                            $uacf7_uacf7style_label_font_family = get_post_meta( get_the_ID(), 'uacf7_uacf7style_label_font_family', true );
                            $uacf7_uacf7style_label_font_style = get_post_meta( get_the_ID(), 'uacf7_uacf7style_label_font_style', true );
                            $uacf7_uacf7style_label_font_weight = get_post_meta( get_the_ID(), 'uacf7_uacf7style_label_font_weight', true );
                            $uacf7_uacf7style_label_padding_top = get_post_meta( get_the_ID(), 'uacf7_uacf7style_label_padding_top', true );
                            $uacf7_uacf7style_label_padding_right = get_post_meta( get_the_ID(), 'uacf7_uacf7style_label_padding_right', true );
                            $uacf7_uacf7style_label_padding_bottom = get_post_meta( get_the_ID(), 'uacf7_uacf7style_label_padding_bottom', true );
                            $uacf7_uacf7style_label_padding_left = get_post_meta( get_the_ID(), 'uacf7_uacf7style_label_padding_left', true );
                            $uacf7_uacf7style_label_margin_top = get_post_meta( get_the_ID(), 'uacf7_uacf7style_label_margin_top', true );
                            $uacf7_uacf7style_label_margin_right = get_post_meta( get_the_ID(), 'uacf7_uacf7style_label_margin_right', true );
                            $uacf7_uacf7style_label_margin_bottom = get_post_meta( get_the_ID(), 'uacf7_uacf7style_label_margin_bottom', true );
                            $uacf7_uacf7style_label_margin_left = get_post_meta( get_the_ID(), 'uacf7_uacf7style_label_margin_left', true );
                            $uacf7_uacf7style_input_color = get_post_meta( get_the_ID(), 'uacf7_uacf7style_input_color', true );
                            $uacf7_uacf7style_input_background_color = get_post_meta( get_the_ID(), 'uacf7_uacf7style_input_background_color', true );
                            $uacf7_uacf7style_input_font_size = get_post_meta( get_the_ID(), 'uacf7_uacf7style_input_font_size', true );
                            $uacf7_uacf7style_input_font_family = get_post_meta( get_the_ID(), 'uacf7_uacf7style_input_font_family', true );
                            $uacf7_uacf7style_input_font_style = get_post_meta( get_the_ID(), 'uacf7_uacf7style_input_font_style', true );
                            $uacf7_uacf7style_input_font_weight = get_post_meta( get_the_ID(), 'uacf7_uacf7style_input_font_weight', true );
                            $uacf7_uacf7style_input_height = get_post_meta( get_the_ID(), 'uacf7_uacf7style_input_height', true );
                            $uacf7_uacf7style_input_border_width = get_post_meta( get_the_ID(), 'uacf7_uacf7style_input_border_width', true );

                            $uacf7_uacf7style_input_border_color = get_post_meta( get_the_ID(), 'uacf7_uacf7style_input_border_color', true );

                            $uacf7_uacf7style_input_border_style = get_post_meta( get_the_ID(), 'uacf7_uacf7style_input_border_style', true );
                            $uacf7_uacf7style_input_border_radius = get_post_meta( get_the_ID(), 'uacf7_uacf7style_input_border_radius', true );
                            $uacf7_uacf7style_textarea_input_height = get_post_meta( get_the_ID(), 'uacf7_uacf7style_textarea_input_height', true );
                            $uacf7_uacf7style_input_padding_top = get_post_meta( get_the_ID(), 'uacf7_uacf7style_input_padding_top', true );
                            $uacf7_uacf7style_input_padding_right = get_post_meta( get_the_ID(), 'uacf7_uacf7style_input_padding_right', true );
                            $uacf7_uacf7style_input_padding_bottom = get_post_meta( get_the_ID(), 'uacf7_uacf7style_input_padding_bottom', true );
                            $uacf7_uacf7style_input_padding_left = get_post_meta( get_the_ID(), 'uacf7_uacf7style_input_padding_left', true );
                            $uacf7_uacf7style_input_margin_top = get_post_meta( get_the_ID(), 'uacf7_uacf7style_input_margin_top', true );
                            $uacf7_uacf7style_input_margin_right = get_post_meta( get_the_ID(), 'uacf7_uacf7style_input_margin_right', true );
                            $uacf7_uacf7style_input_margin_bottom = get_post_meta( get_the_ID(), 'uacf7_uacf7style_input_margin_bottom', true );
                            $uacf7_uacf7style_input_margin_left = get_post_meta( get_the_ID(), 'uacf7_uacf7style_input_margin_left', true );
                            $uacf7_uacf7style_btn_color = get_post_meta( get_the_ID(), 'uacf7_uacf7style_btn_color', true );
                            $uacf7_uacf7style_btn_background_color = get_post_meta( get_the_ID(), 'uacf7_uacf7style_btn_background_color', true ); 
                            $uacf7_uacf7style_btn_color_hover = get_post_meta( get_the_ID(), 'uacf7_uacf7style_btn_color_hover', true );
                            $uacf7_uacf7style_btn_background_color_hover = get_post_meta( get_the_ID(), 'uacf7_uacf7style_btn_background_color_hover', true );
                            $uacf7_uacf7style_btn_font_size = get_post_meta( get_the_ID(), 'uacf7_uacf7style_btn_font_size', true );
                            $uacf7_uacf7style_btn_font_style = get_post_meta( get_the_ID(), 'uacf7_uacf7style_btn_font_style', true );
                            $uacf7_uacf7style_btn_font_weight = get_post_meta( get_the_ID(), 'uacf7_uacf7style_btn_font_weight', true );
                            $uacf7_uacf7style_btn_border_width = get_post_meta( get_the_ID(), 'uacf7_uacf7style_btn_border_width', true );
                            $uacf7_uacf7style_btn_border_color = get_post_meta( get_the_ID(), 'uacf7_uacf7style_btn_border_color', true );
                            $uacf7_uacf7style_btn_border_style = get_post_meta( get_the_ID(), 'uacf7_uacf7style_btn_border_style', true );
                            $uacf7_uacf7style_btn_border_radius = get_post_meta( get_the_ID(), 'uacf7_uacf7style_btn_border_radius', true );
                            $uacf7_uacf7style_btn_width = get_post_meta( get_the_ID(), 'uacf7_uacf7style_btn_width', true );
                            $uacf7_uacf7style_btn_border_color_hover = get_post_meta( get_the_ID(), 'uacf7_uacf7style_btn_border_color_hover', true );
                            $uacf7_uacf7style_btn_padding_top = get_post_meta( get_the_ID(), 'uacf7_uacf7style_btn_padding_top', true );
                            $uacf7_uacf7style_btn_padding_right = get_post_meta( get_the_ID(), 'uacf7_uacf7style_btn_padding_right', true );
                            $uacf7_uacf7style_btn_padding_bottom = get_post_meta( get_the_ID(), 'uacf7_uacf7style_btn_padding_bottom', true );
                            $uacf7_uacf7style_btn_padding_left = get_post_meta( get_the_ID(), 'uacf7_uacf7style_btn_padding_left', true );
                            $uacf7_uacf7style_btn_margin_top = get_post_meta( get_the_ID(), 'uacf7_uacf7style_btn_margin_top', true );
                            $uacf7_uacf7style_btn_margin_right = get_post_meta( get_the_ID(), 'uacf7_uacf7style_btn_margin_right', true );
                            $uacf7_uacf7style_btn_margin_bottom = get_post_meta( get_the_ID(), 'uacf7_uacf7style_btn_margin_bottom', true );
                            $uacf7_uacf7style_btn_margin_left = get_post_meta( get_the_ID(), 'uacf7_uacf7style_btn_margin_left', true );
                            $uacf7_uacf7style_ua_custom_css = get_post_meta( get_the_ID(), 'uacf7_uacf7style_ua_custom_css', true );


                        //     //  Migration 
                            $meta['uacf7_enable_form_styles'] = $uacf7_enable_form_styles;
                            $meta['uacf7_uacf7style_label_color_option']['uacf7_uacf7style_label_color'] = $uacf7_uacf7style_label_color;
                            $meta['uacf7_uacf7style_label_color_option']['uacf7_uacf7style_label_background_color'] = $uacf7_uacf7style_label_background_color;
                            $meta['uacf7_uacf7style_label_font_style'] = $uacf7_uacf7style_label_font_style;
                            $meta['uacf7_uacf7style_label_font_weight'] = $uacf7_uacf7style_label_font_weight;
                            $meta['uacf7_uacf7style_label_font_size'] = $uacf7_uacf7style_label_font_size;
                            $meta['uacf7_uacf7style_label_font_family'] = $uacf7_uacf7style_label_font_family; 
                            $meta['uacf7_uacf7style_label_padding_top'] = $uacf7_uacf7style_label_padding_top;
                            $meta['uacf7_uacf7style_label_padding_right'] = $uacf7_uacf7style_label_padding_right;
                            $meta['uacf7_uacf7style_label_padding_bottom'] = $uacf7_uacf7style_label_padding_bottom;
                            $meta['uacf7_uacf7style_label_padding_left'] = $uacf7_uacf7style_label_padding_left;
                            $meta['uacf7_uacf7style_label_margin_top'] = $uacf7_uacf7style_label_margin_top;
                            $meta['uacf7_uacf7style_label_margin_right'] = $uacf7_uacf7style_label_margin_right;
                            $meta['uacf7_uacf7style_label_margin_bottom'] = $uacf7_uacf7style_label_margin_bottom;
                            $meta['uacf7_uacf7style_label_margin_left'] = $uacf7_uacf7style_label_margin_left;


                            $meta['uacf7_uacf7style_input_color_option']['uacf7_uacf7style_input_color'] = $uacf7_uacf7style_input_color;
                            $meta['uacf7_uacf7style_input_color_option']['uacf7_uacf7style_input_background_color'] = $uacf7_uacf7style_input_background_color;
                            $meta['uacf7_uacf7style_input_font_style'] = $uacf7_uacf7style_input_font_style;
                            $meta['uacf7_uacf7style_input_font_weight'] = $uacf7_uacf7style_input_font_weight;
                            $meta['uacf7_uacf7style_input_font_size'] = $uacf7_uacf7style_input_font_size;
                            $meta['uacf7_uacf7style_input_font_family'] = $uacf7_uacf7style_input_font_family;
                            $meta['uacf7_uacf7style_input_height'] = $uacf7_uacf7style_input_height;
                            $meta['uacf7_uacf7style_textarea_input_height'] = $uacf7_uacf7style_textarea_input_height; 
                            $meta['uacf7_uacf7style_input_padding_top'] = $uacf7_uacf7style_input_padding_top;
                            $meta['uacf7_uacf7style_input_padding_right'] = $uacf7_uacf7style_input_padding_right;
                            $meta['uacf7_uacf7style_input_padding_bottom'] = $uacf7_uacf7style_input_padding_bottom;
                            $meta['uacf7_uacf7style_input_padding_left'] = $uacf7_uacf7style_input_padding_left;
                            $meta['uacf7_uacf7style_input_margin_top'] = $uacf7_uacf7style_input_margin_top;
                            $meta['uacf7_uacf7style_input_margin_right'] = $uacf7_uacf7style_input_margin_right;
                            $meta['uacf7_uacf7style_input_margin_bottom'] = $uacf7_uacf7style_input_margin_bottom;
                            $meta['uacf7_uacf7style_input_margin_left'] = $uacf7_uacf7style_input_margin_left; 
                            $meta['uacf7_uacf7style_input_border_width'] = $uacf7_uacf7style_input_border_width; 
                            $meta['uacf7_uacf7style_input_border_style'] = $uacf7_uacf7style_input_border_style;
                            $meta['uacf7_uacf7style_input_border_radius'] = $uacf7_uacf7style_input_border_radius;
                            $meta['uacf7_uacf7style_input_border_color'] = $uacf7_uacf7style_input_border_color;
                            $meta['uacf7_uacf7style_btn_color_option']['uacf7_uacf7style_btn_color'] = $uacf7_uacf7style_btn_color;
                            $meta['uacf7_uacf7style_btn_color_option']['uacf7_uacf7style_btn_background_color'] = $uacf7_uacf7style_btn_background_color;
                            $meta['uacf7_uacf7style_btn_color_option']['uacf7_uacf7style_btn_color_hover'] = $uacf7_uacf7style_btn_color_hover;
                            $meta['uacf7_uacf7style_btn_color_option']['uacf7_uacf7style_btn_background_color_hover'] = $uacf7_uacf7style_btn_background_color_hover;

                            $meta['uacf7_uacf7style_btn_font_size'] = $uacf7_uacf7style_btn_font_size;
                            $meta['uacf7_uacf7style_btn_font_style'] = $uacf7_uacf7style_btn_font_style;
                            $meta['uacf7_uacf7style_btn_font_weight'] = $uacf7_uacf7style_btn_font_weight;
                            $meta['uacf7_uacf7style_btn_width'] = $uacf7_uacf7style_btn_width;
                            $meta['uacf7_uacf7style_btn_border_style'] = $uacf7_uacf7style_btn_border_style;
                            $meta['uacf7_uacf7style_btn_border_color'] = $uacf7_uacf7style_btn_border_color;
                            $meta['uacf7_uacf7style_btn_border_color_hover'] = $uacf7_uacf7style_btn_border_color_hover;
                            $meta['uacf7_uacf7style_btn_border_width'] = $uacf7_uacf7style_btn_border_width;
                            $meta['uacf7_uacf7style_btn_border_radius'] = $uacf7_uacf7style_btn_border_radius; 
                            $meta['uacf7_uacf7style_btn_padding_top'] = $uacf7_uacf7style_btn_padding_top;
                            $meta['uacf7_uacf7style_btn_padding_right'] = $uacf7_uacf7style_btn_padding_right;
                            $meta['uacf7_uacf7style_btn_padding_bottom'] = $uacf7_uacf7style_btn_padding_bottom;
                            $meta['uacf7_uacf7style_btn_padding_left'] = $uacf7_uacf7style_btn_padding_left;
                            $meta['uacf7_uacf7style_btn_margin_top'] = $uacf7_uacf7style_btn_margin_top;
                            $meta['uacf7_uacf7style_btn_margin_right'] = $uacf7_uacf7style_btn_margin_right;
                            $meta['uacf7_uacf7style_btn_margin_bottom'] = $uacf7_uacf7style_btn_margin_bottom;
                            $meta['uacf7_uacf7style_btn_margin_left'] = $uacf7_uacf7style_btn_margin_left;
                            $meta['uacf7_uacf7style_ua_custom_css'] = $uacf7_uacf7style_ua_custom_css; 
                        }

                        


                        // Multistep addon Migration
                        $uacf7_multistep_is_multistep = get_post_meta( $post_id, 'uacf7_multistep_is_multistep', true ) == 'on' ? 1 : 0;
                        if($uacf7_multistep_is_multistep == true){
                            $multistep = $meta['multistep'];
                            $multistep['uacf7_multistep_is_multistep'] = $uacf7_multistep_is_multistep;
                            $multistep['uacf7_enable_multistep_progressbar'] = get_post_meta( $post_id, 'uacf7_enable_multistep_progressbar', true ) == 'on' ? 1 : 0;
                            $multistep['uacf7_enable_multistep_scroll'] = get_post_meta( $post_id, 'uacf7_enable_multistep_scroll', true ) == 'on' ? 1 : 0;
                            $multistep['uacf7_progressbar_style'] = get_post_meta( $post_id, 'uacf7_progressbar_style', true ); 
                            $multistep['uacf7_multistep_use_step_labels'] = get_post_meta( $post_id, 'uacf7_multistep_use_step_labels', true ) == 'on' ? 1 : 0;
                            $multistep['uacf7_multistep_circle_width'] = get_post_meta( $post_id, 'uacf7_multistep_circle_width', true ) ;
                            $multistep['uacf7_multistep_circle_height'] = get_post_meta( $post_id, 'uacf7_multistep_circle_height', true ) ;
                            $multistep['uacf7_multistep_circle_bg_color'] = get_post_meta( $post_id, 'uacf7_multistep_circle_bg_color', true ) ;
                            $multistep['uacf7_multistep_circle_font_color'] = get_post_meta( $post_id, 'uacf7_multistep_circle_font_color', true ) ;
                            $multistep['uacf7_multistep_circle_border_radious'] = get_post_meta( $post_id, 'uacf7_multistep_circle_border_radious', true ) ;
                            $multistep['uacf7_multistep_font_size'] = get_post_meta( $post_id, 'uacf7_multistep_font_size', true ) ;
                            $multistep['uacf7_multistep_progressbar_color_option']['uacf7_multistep_circle_bg_color'] = get_post_meta( $post_id, 'uacf7_multistep_circle_bg_color', true ) ;
                            $multistep['uacf7_multistep_progressbar_color_option']['uacf7_multistep_circle_active_color'] = get_post_meta( $post_id, 'uacf7_multistep_circle_active_color', true ) ;
                            $multistep['uacf7_multistep_progressbar_color_option']['uacf7_multistep_circle_font_color'] = get_post_meta( $post_id, 'uacf7_multistep_circle_font_color', true ) ;
                            $multistep['uacf7_multistep_progressbar_color_option']['uacf7_multistep_progress_bg_color'] = get_post_meta( $post_id, 'uacf7_multistep_progress_bg_color', true ) ;
                            $multistep['uacf7_multistep_progressbar_color_option']['uacf7_multistep_progress_line_color'] = get_post_meta( $post_id, 'uacf7_multistep_progress_line_color', true ) ;
                            $multistep['uacf7_multistep_progressbar_color_option']['uacf7_multistep_step_title_color'] = get_post_meta( $post_id, 'uacf7_multistep_step_title_color', true ) ;
                            $multistep['uacf7_multistep_progressbar_color_option']['uacf7_multistep_progressbar_title_color'] = get_post_meta( $post_id, 'uacf7_multistep_progressbar_title_color', true ) ;
                            $multistep['uacf7_multistep_progressbar_color_option']['uacf7_multistep_step_description_color'] = get_post_meta( $post_id, 'uacf7_multistep_step_description_color', true ) ;
                            $multistep['uacf7_multistep_step_height'] = get_post_meta( $post_id, 'uacf7_multistep_step_height', true ) ;
                            $multistep['uacf7_multistep_button_padding_tb'] = get_post_meta( $post_id, 'uacf7_multistep_button_padding_tb', true ) ;
                            $multistep['uacf7_multistep_button_padding_lr'] = get_post_meta( $post_id, 'uacf7_multistep_button_padding_lr', true ) ;
                            $multistep['uacf7_multistep_next_prev_option']['uacf7_multistep_button_bg'] = get_post_meta( $post_id, 'uacf7_multistep_button_bg', true ) ;
                            $multistep['uacf7_multistep_next_prev_option']['uacf7_multistep_button_color'] = get_post_meta( $post_id, 'uacf7_multistep_button_color', true ) ;
                            $multistep['uacf7_multistep_next_prev_option']['uacf7_multistep_button_border_color'] = get_post_meta( $post_id, 'uacf7_multistep_button_border_color', true ) ;
                            $multistep['uacf7_multistep_next_prev_option']['uacf7_multistep_button_hover_bg'] = get_post_meta( $post_id, 'uacf7_multistep_button_hover_bg', true ) ;
                            $multistep['uacf7_multistep_next_prev_option']['uacf7_multistep_button_hover_color'] = get_post_meta( $post_id, 'uacf7_multistep_button_hover_color', true ) ;
                            $multistep['uacf7_multistep_next_prev_option']['uacf7_multistep_button_border_hover_color'] = get_post_meta( $post_id, 'uacf7_multistep_button_border_hover_color', true ) ;
                            $multistep['uacf7_multistep_button_border_radius'] = get_post_meta( $post_id, 'uacf7_multistep_button_border_radius', true ) ; 


                        
                            $all_steps = $form_current->scan_form_tags( array('type'=>'uacf7_step_start') );

                            $step_count = 1;
                            foreach( $all_steps as $step ) { 
                                
                                if($step_count == 1){ 
                                    $multistep['next_btn_'.$step->name.''] = get_post_meta( $post_id, 'next_btn_'.$step->name.'', true );
                                }else{
                                    if( count($all_steps) == $step_count ) {
                                        $multistep['prev_btn_'.$step->name.''] = get_post_meta( $post_id, 'prev_btn_'.$step->name.'', true );
                                    }else{
                                        $multistep['next_btn_'.$step->name.''] = get_post_meta( $post_id, 'next_btn_'.$step->name.'', true );
                                        $multistep['prev_btn_'.$step->name.''] = get_post_meta( $post_id, 'prev_btn_'.$step->name.'', true );
                                    }
                                }
                                
                                $multistep['uacf7_progressbar_image_'.$step->name.''] = get_post_meta( $post_id, 'uacf7_progressbar_image_'.$step->name.'', true );
                                $multistep['desc_title_'.$step->name.''] = get_post_meta( $post_id, 'desc_title_'.$step->name.'', true );
                                $multistep['step_desc_'.$step->name.''] = get_post_meta( $post_id, 'step_desc_'.$step->name.'', true );
                                
                                $step_count++;
                            }

                        }

                    // Booking addon Migration
                    $bf_enable = get_post_meta( $post_id, 'bf_enable', true ) == 'on' ? 1: get_post_meta( $post_id, 'bf_enable', true );
                    $booking = isset($meta['booking']) ? $meta['booking'] : array();  
                    if($bf_enable == true){
                        $booking['bf_enable'] = $bf_enable;
                        $booking['bf_duplicate_status'] = get_post_meta( $post_id, 'bf_duplicate_status', true ) == 'on' ? 1 : 0;
                        $booking['calendar_event_enable'] = get_post_meta( $post_id, 'calendar_event_enable', true ) == 'on' ? 1 : 0;
                        $booking['event_email'] = get_post_meta( $post_id, 'event_email', true );
                        $booking['event_summary'] = get_post_meta( $post_id, 'event_summary', true );
                        $booking['event_date'] = get_post_meta( $post_id, 'event_date', true );
                        $booking['event_time'] = get_post_meta( $post_id, 'event_time', true );
                        $booking['date_mode_front'] = get_post_meta( $post_id, 'date_mode_front', true );
                        $booking['bf_date_theme'] = get_post_meta( $post_id, 'bf_date_theme', true );
                        $booking['bf_allowed_date'] = get_post_meta( $post_id, 'bf_allowed_date', true );
                        $booking['allowed_min_max_date']['from'] = get_post_meta( $post_id, 'min_date', true );
                        $booking['allowed_min_max_date']['to'] = get_post_meta( $post_id, 'max_date', true );
                        $booking['allowed_specific_date'] = get_post_meta( $post_id, 'allowed_specific_date', true );
                        $booking['disable_day'][0] = get_post_meta( $post_id, 'disable_day_1', true );
                        $booking['disable_day'][1] = get_post_meta( $post_id, 'disable_day_2', true );
                        $booking['disable_day'][2] = get_post_meta( $post_id, 'disable_day_3', true );
                        $booking['disable_day'][3] = get_post_meta( $post_id, 'disable_day_4', true );
                        $booking['disable_day'][4] = get_post_meta( $post_id, 'disable_day_5', true );
                        $booking['disable_day'][5] = get_post_meta( $post_id, 'disable_day_6', true );
                        $booking['disable_day'][6] = get_post_meta( $post_id, 'disable_day_0', true );
                        $booking['disabled_date']['from'] = get_post_meta( $post_id, 'disabled_start_date', true );
                        $booking['disabled_date']['to'] = get_post_meta( $post_id, 'disabled_end_date', true );
                        $booking['disabled_specific_date'] = get_post_meta( $post_id, 'disabled_specific_date', true ); 
                        $booking['time_format_front'] = get_post_meta( $post_id, 'time_format_front', true );
                        $booking['min_time'] = get_post_meta( $post_id, 'min_time', true );
                        $booking['max_time'] = get_post_meta( $post_id, 'max_time', true );
                        $booking['from_dis_time'] = get_post_meta( $post_id, 'from_dis_time', true );
                        $booking['to_dis_time'] = get_post_meta( $post_id, 'to_dis_time', true );
                        $booking['uacf7_time_interval'] = get_post_meta( $post_id, 'uacf7_time_interval', true );
                        $booking['time_one_step'] = get_post_meta( $post_id, 'time_one_step', true );
                        $booking['time_two_step'] = get_post_meta( $post_id, 'time_two_step', true );
                        $booking['bf_allowed_time'] = get_post_meta( $post_id, 'bf_allowed_time', true );
                        $booking['allowed_time_day'][0] = get_post_meta( $post_id, 'time_day_1', true );
                        $booking['allowed_time_day'][1] = get_post_meta( $post_id, 'time_day_2', true );
                        $booking['allowed_time_day'][2] = get_post_meta( $post_id, 'time_day_3', true );
                        $booking['allowed_time_day'][3] = get_post_meta( $post_id, 'time_day_4', true );
                        $booking['allowed_time_day'][4] = get_post_meta( $post_id, 'time_day_5', true );
                        $booking['allowed_time_day'][5] = get_post_meta( $post_id, 'time_day_6', true );
                        $booking['allowed_time_day'][6] = get_post_meta( $post_id, 'time_day_0', true ); 
                        $booking['specific_date_time'] = get_post_meta( $post_id, 'specific_date_time', true );
                        $booking['min_day_time'] = get_post_meta( $post_id, 'min_day_time', true );
                        $booking['max_day_time'] = get_post_meta( $post_id, 'max_day_time', true );
                        $booking['bf_woo'] = get_post_meta( $post_id, 'bf_woo', true );
                        $booking['bf_product'] = get_post_meta( $post_id, 'bf_product', true );
                        $booking['bf_product_id'] = get_post_meta( $post_id, 'bf_product_id', true );
                        $booking['bf_product_name'] = get_post_meta( $post_id, 'bf_product_name', true );
                        $booking['bf_product_price'] = get_post_meta( $post_id, 'bf_product_name', true );  
                        $meta['booking'] = $booking;
                    }

                    // Post Submission addon Migration
                    $enable_post_submission = get_post_meta( $post_id, 'enable_post_submission', true ) == 'yes' ? 1 : 0;
                    $post_submission = isset($meta['post_submission']) ? $meta['post_submission'] : array();
                    if($enable_post_submission == true){
                        $post_submission['enable_post_submission'] =  $enable_post_submission;
                        $post_submission['post_submission_post_type'] = get_post_meta( $post_id, 'post_submission_post_type', true );
                        $post_submission['post_submission_post_status'] = get_post_meta( $post_id, 'post_submission_post_status', true );
                        $meta['post_submission'] = $post_submission;
                    }

                    // Mailchimp addon Migration
                    $uacf7_mailchimp_form_enable = get_post_meta( $post_id, 'uacf7_mailchimp_form_enable', true ) == 'enable' ? 1 : 0;
                    $mailchimp = isset($meta['mailchimp']) ? $meta['mailchimp'] : array();
                    if($uacf7_mailchimp_form_enable == true){
                        $mailchimp['uacf7_mailchimp_form_enable'] = $uacf7_mailchimp_form_enable;
                        $mailchimp['uacf7_mailchimp_form_type'] = get_post_meta( $post_id, 'uacf7_mailchimp_form_type', true );
                        $mailchimp['uacf7_mailchimp_audience'] = get_post_meta( $post_id, 'uacf7_mailchimp_audience', true );
                        $mailchimp['uacf7_mailchimp_subscriber_email'] = get_post_meta( $post_id, 'uacf7_mailchimp_subscriber_email', true );
                        $mailchimp['uacf7_mailchimp_subscriber_fname'] = get_post_meta( $post_id, 'uacf7_mailchimp_subscriber_fname', true );
                        $mailchimp['uacf7_mailchimp_subscriber_lname'] = get_post_meta( $post_id, 'uacf7_mailchimp_subscriber_lname', true );
                        $mailchimp['uacf7_mailchimp_merge_fields'] = get_post_meta( $post_id, 'uacf7_mailchimp_merge_fields', true );
                        $meta['mailchimp'] = $mailchimp; 
                        
                    }


                    // PDF Generator Enable
                    $pdf = isset($meta['pdf_generator']) ? $meta['pdf_generator'] : array();
                    $uacf7_enable_pdf_generator = get_post_meta( $post_id, 'uacf7_enable_pdf_generator', true ) == 'on' ? 1 : get_post_meta( $post_id, 'uacf7_enable_pdf_generator', true );

                    if($uacf7_enable_pdf_generator == true){
                        $pdf['uacf7_enable_pdf_generator'] = $uacf7_enable_pdf_generator;
                        $pdf['uacf7_pdf_name'] = get_post_meta( $post_id, 'uacf7_pdf_name', true );
                        $pdf['pdf_send_to'] = get_post_meta( $post_id, 'pdf_send_to', true );
                        $pdf['uacf7_pdf_disable_header_footer'][0] = get_post_meta( $post_id, 'uacf7_pdf_disable_header', true ) == true ? 'header' : 0;
                        $pdf['uacf7_pdf_disable_header_footer'][1] = get_post_meta( $post_id, 'uacf7_pdf_disable_footer', true ) == true ? 'footer' : 0; 
                        $pdf['pdf_bg_upload_image'] = get_post_meta( $post_id, 'pdf_bg_upload_image', true );
                        $pdf['pdf_content_bg_color'] = get_post_meta( $post_id, 'pdf_content_bg_color', true );
                        $pdf['customize_pdf'] = get_post_meta( $post_id, 'customize_pdf', true );
                        $pdf['pdf_header_upload_image'] = get_post_meta( $post_id, 'pdf_header_upload_image', true );
                        $pdf['pdf_header_color'] = get_post_meta( $post_id, 'pdf_header_color', true );
                        $pdf['pdf_header_bg_color'] = get_post_meta( $post_id, 'pdf_header_bg_color', true );
                        $pdf['customize_pdf_header'] = get_post_meta( $post_id, 'customize_pdf_header', true );
                        $pdf['pdf_footer_color'] = get_post_meta( $post_id, 'pdf_footer_color', true );
                        $pdf['pdf_footer_bg_color'] = get_post_meta( $post_id, 'pdf_footer_bg_color', true );
                        $pdf['customize_pdf_footer'] = get_post_meta( $post_id, 'customize_pdf_footer', true );
                        $pdf['custom_pdf_css'] = get_post_meta( $post_id, 'custom_pdf_css', true );
                        $meta['pdf_generator'] = $pdf; 
                    }


                    // Conversation form addon Migration
                    $conversational = isset($meta['conversational_form']) ? $meta['conversational_form'] : array();
                    $uacf7_conversation_form_enable = get_post_meta( $post_id, 'uacf7_is_conversational', true ) == 'on' ? 1 : get_post_meta( $post_id, 'uacf7_is_conversational', true );
                    if($uacf7_conversation_form_enable == true){
                        $conversational['uacf7_is_conversational'] = $uacf7_conversation_form_enable;
                        $conversational['uacf7_full_screen'] = get_post_meta( $post_id, 'uacf7_full_screen', true );
                        $conversational['uacf7_enable_progress_bar'] = get_post_meta( $post_id, 'uacf7_enable_progress_bar', true );
                        $conversational['uacf7_conversational_intro'] = get_post_meta( $post_id, 'uacf7_conversational_intro', true );
                        $conversational['uacf7_conversational_thankyou'] = get_post_meta( $post_id, 'uacf7_conversational_thankyou', true );
                        $conversational['uacf7_conversational_style'] = get_post_meta( $post_id, 'uacf7_conversational_style', true );
                        $conversational['uacf7_conversational_bg_color'] = get_post_meta( $post_id, 'uacf7_conversational_bg_color', true );
                        $conversational['uacf7_conversational_button_color'] = get_post_meta( $post_id, 'uacf7_conversational_button_color', true );
                        $conversational['uacf7_conversational_button_bg_color'] = get_post_meta( $post_id, 'uacf7_conversational_button_bg_color', true );
                        $conversational['uacf7_conversational_bg_image'] = get_post_meta( $post_id, 'uacf7_conversational_bg_image', true );
                        $conversational['uacf7_progress_bar_height'] = get_post_meta( $post_id, 'uacf7_progress_bar_height', true );
                        $conversational['uacf7_progress_bar_bg_color'] = get_post_meta( $post_id, 'uacf7_progress_bar_bg_color', true );
                        $conversational['uacf7_progress_bar_completed_bg_color'] = get_post_meta( $post_id, 'uacf7_progress_bar_completed_bg_color', true );
                        $conversational['uacf7_conversational_intro_title'] = get_post_meta( $post_id, 'uacf7_conversational_intro_title', true );
                        $conversational['uacf7_conversational_intro_button'] = get_post_meta( $post_id, 'uacf7_conversational_intro_button', true );
                        $conversational['uacf7_conversational_intro_bg_color'] = get_post_meta( $post_id, 'uacf7_conversational_intro_bg_color', true );
                        $conversational['uacf7_conversational_intro_text_color'] = get_post_meta( $post_id, 'uacf7_conversational_intro_text_color', true );
                        $conversational['uacf7_conversational_intro_image'] = get_post_meta( $post_id, 'uacf7_conversational_intro_image', true );
                        $conversational['uacf7_conversational_intro_message'] = get_post_meta( $post_id, 'uacf7_conversational_intro_message', true );
                        $conversational['uacf7_conversational_thank_you_title'] = get_post_meta( $post_id, 'uacf7_conversational_thank_you_title', true );
                        $conversational['uacf7_conversational_thank_you_button'] = get_post_meta( $post_id, 'uacf7_conversational_thank_you_button', true );
                        $conversational['uacf7_conversational_thank_you_url'] = get_post_meta( $post_id, 'uacf7_conversational_thank_you_url', true );
                        $conversational['uacf7_conversational_thankyou_bg_color'] = get_post_meta( $post_id, 'uacf7_conversational_thankyou_bg_color', true );
                        $conversational['uacf7_conversational_thankyou_text_color'] = get_post_meta( $post_id, 'uacf7_conversational_thankyou_text_color', true );
                        $conversational['uacf7_conversational_thankyou_image'] = get_post_meta( $post_id, 'uacf7_conversational_thankyou_image', true );
                        $conversational['uacf7_conversational_thank_you_message'] = get_post_meta( $post_id, 'uacf7_conversational_thank_you_message', true );
                        $conversational['custom_conv_css'] = get_post_meta( $post_id, 'custom_conv_css', true );

                        $uacf7_conversational_field = get_post_meta( $post_id, 'uacf7_conversational_field', true );
                        $count = 0;
                        foreach($uacf7_conversational_field as $field_key => $field_value){
                            $conversational['uacf7_conversational_steps'][$count] = $field_value;  
                            $conversational['uacf7_conversational_steps'][$count]['steps_name'] = $field_key;  
                            $count++;
                        }

                        $meta['conversational_form'] = $conversational; 
                    }

                    // Submission ID addon Migration
                    $submission = isset($meta['submission_id']) ? $meta['submission_id'] : array();
                    $uacf7_submission_id_enable = get_post_meta( $post_id, 'uacf7_submission_id_enable', true ) == 'on' ? 1 : 0;
                    if($uacf7_submission_id_enable == true){

                        $uacf7_submission_id = get_post_meta( $post_id, 'uacf7_submission_id', true );
                        $uacf7_submission_id_step = get_post_meta( $post_id, 'uacf7_submission_id_step', true );
                        $submission['uacf7_submission_id_enable'] = $uacf7_submission_id_enable;
                        $submission['uacf7_submission_id'] = $uacf7_submission_id;
                        $submission['uacf7_submission_id_step'] = $uacf7_submission_id_step;
                        $meta['submission_id'] = $submission;
                    }
                    
                    //Telegram Addon Migration 
                    $telegram = isset($meta['telegram']) ? $meta['telegram'] : array();
                    $uacf7_telegram_settings = get_post_meta($post_id, 'uacf7_telegram_settings', true);
                    $uacf7_telegram_enable = is_array($uacf7_telegram_settings) && isset($uacf7_telegram_settings['uacf7_telegram_enable']) ? $uacf7_telegram_settings['uacf7_telegram_enable'] : 0;

                    if($uacf7_telegram_enable == true){ 
                        $uacf7_telegram_bot_token = isset($uacf7_telegram_settings['uacf7_telegram_bot_token']) ? $uacf7_telegram_settings['uacf7_telegram_bot_token'] : '';
                        $uacf7_telegram_chat_id = isset($uacf7_telegram_settings['uacf7_telegram_chat_id']) ? $uacf7_telegram_settings['uacf7_telegram_chat_id'] : '';  
                        $telegram['uacf7_telegram_enable'] = $uacf7_telegram_enable;
                        $telegram['uacf7_telegram_bot_token'] = $uacf7_telegram_bot_token;
                        $telegram['uacf7_telegram_chat_id'] = $uacf7_telegram_chat_id;
                        $meta['telegram'] = $telegram; 

                    }

                      //Signature Addon 
                    $telegram = isset($meta['signature']) ? $meta['signature'] : array();
                    $uacf7_signature_settings = get_post_meta($post_id, 'uacf7_signature_settings', true);
                    $uacf7_signature_enable = is_array($uacf7_signature_settings) && isset($uacf7_signature_settings['uacf7_signature_enable']) ? $uacf7_signature_settings['uacf7_signature_enable'] : 0;

                    if($uacf7_signature_enable == true){ 
                        $uacf7_signature_bg_color = isset($uacf7_signature_settings['uacf7_signature_bg_color']) ? $uacf7_signature_settings['uacf7_signature_bg_color'] : '';
                        $uacf7_signature_bg_color = isset($uacf7_signature_settings['uacf7_signature_bg_color']) ? $uacf7_signature_settings['uacf7_signature_bg_color'] : '';
                        $telegram['uacf7_telegram_enable'] = $uacf7_telegram_enable;
                        $telegram['uacf7_telegram_bot_token'] = $uacf7_telegram_bot_token;
                        $telegram['uacf7_telegram_chat_id'] = $uacf7_telegram_chat_id;
                        $meta['telegram'] = $telegram; 

                    }

                    // Pre Populate addon Migration
                    $pre_populated = isset($meta['pre_populated']) ? $meta['pre_populated'] : array(); 
                        
                    $pre_populate_enable = get_post_meta( $post_id, 'pre_populate_enable', true ) == 'on' ? 1 : get_post_meta( $post_id, 'pre_populate_enable', true );

                    if($pre_populate_enable == true){ 
                        $pre_populated['pre_populate_enable'] = $pre_populate_enable;
                        $pre_populated['data_redirect_url'] = get_post_meta( $post_id, 'data_redirect_url', true );
                        $pre_populated['pre_populate_form'] = get_post_meta( $post_id, 'pre_populate_form', true );

                        $pre_populate_passing_field = get_post_meta( $post_id, 'pre_populate_passing_field', true );  
                        $count = 0;
                        foreach($pre_populate_passing_field as $field_key => $field_value){
                            // $pre_populated['pre_populate_passing_field'][$count] = $field_value;  
                            $pre_populated['pre_populate_passing_field'][$count]['field_name'] = $field_value;  
                            $count++;
                        }
                        $meta['pre_populated'] = $pre_populated;

                    }

                    // Range Slider Filter addon Migration
                        $range_slider = isset($meta['range_slider']) ? $meta['range_slider'] : array(); 
                        $range_slider['uacf7_range_selection_color'] = get_post_meta( $post_id, 'uacf7_range_selection_color', true );
                        $range_slider['uacf7_range_handle_color'] = get_post_meta( $post_id, 'uacf7_range_handle_color', true );
                        $range_slider['uacf7_range_handle_width'] = get_post_meta( $post_id, 'uacf7_range_handle_width', true );
                        $range_slider['uacf7_range_handle_height'] = get_post_meta( $post_id, 'uacf7_range_handle_height', true );
                        $range_slider['uacf7_range_handle_border_radius'] = get_post_meta( $post_id, 'uacf7_range_handle_border_radius', true );
                        $range_slider['uacf7_range_slider_height'] = get_post_meta( $post_id, 'uacf7_range_slider_height', true );
                        $meta['range_slider'] = $range_slider;
                        
                        // Auto Cart Checkout addon Migration
                        $auto_cart = isset($meta['auto_cart']) ? $meta['auto_cart'] : array();
                        $uacf7_enable_product_auto_cart = get_post_meta( $post_id, 'uacf7_enable_product_auto_cart', true ) == 'on' ? 1 : get_post_meta( $post_id, 'uacf7_enable_product_auto_cart', true );

                        if($uacf7_enable_product_auto_cart == true){
                            $auto_cart['uacf7_enable_product_auto_cart'] = $uacf7_enable_product_auto_cart;
                            $auto_cart['uacf7_product_auto_cart_redirect_to'] = get_post_meta( $post_id, 'uacf7_product_auto_cart_redirect_to', true );
                            $auto_cart['uacf7_enable_track_order'] =get_post_meta( $post_id, 'uacf7_enable_track_order', true ) == 'on' ? 1 : get_post_meta( $post_id, 'uacf7_enable_track_order', true );
                            $meta['auto_cart'] = $auto_cart;
                        }
                
                
                        
                    update_post_meta( $post_id, 'uacf7_form_opt', $meta ); 
                    
            
                endwhile;
                wp_reset_postdata();
            endif; 



            // Option Migration
            $old_option = get_option('uacf7_option_name');
            $new_option = get_option('uacf7_settings');
            $new_option['uacf7_enable_redirection'] = isset($old_option['uacf7_enable_redirection']) && $old_option['uacf7_enable_redirection'] == 'on' ? 1 : 0;
            $new_option['uacf7_enable_conditional_field'] = isset($old_option['uacf7_enable_conditional_field']) && $old_option['uacf7_enable_conditional_field'] == 'on' ? 1 : 0;
            $new_option['uacf7_enable_field_column'] = isset($old_option['uacf7_enable_field_column']) && $old_option['uacf7_enable_field_column'] == 'on' ? 1 : 0;
            $new_option['uacf7_enable_placeholder'] = isset($old_option['uacf7_enable_placeholder']) && $old_option['uacf7_enable_placeholder'] == 'on' ? 1 : 0;
            $new_option['uacf7_enable_uacf7style'] = isset($old_option['uacf7_enable_uacf7style']) && $old_option['uacf7_enable_uacf7style'] == 'on' ? 1 : 0;
            $new_option['uacf7_enable_multistep'] = isset($old_option['uacf7_enable_multistep']) && $old_option['uacf7_enable_multistep'] == 'on' ? 1 : 0;
            $new_option['uacf7_enable_booking_form'] = isset($old_option['uacf7_enable_booking_form']) && $old_option['uacf7_enable_booking_form'] == 'on' ? 1 : 0;
            $new_option['uacf7_enable_post_submission'] = isset($old_option['uacf7_enable_post_submission']) && $old_option['uacf7_enable_post_submission'] == 'on' ? 1 : 0;
            $new_option['uacf7_enable_mailchimp'] = isset($old_option['uacf7_enable_mailchimp']) && $old_option['uacf7_enable_mailchimp'] == 'on' ? 1 : 0;
            $new_option['uacf7_enable_database_field'] = isset($old_option['uacf7_enable_database_field']) && $old_option['uacf7_enable_database_field'] == 'on' ? 1 : 0;
            $new_option['uacf7_enable_pdf_generator_field'] = isset($old_option['uacf7_enable_pdf_generator_field']) && $old_option['uacf7_enable_pdf_generator_field'] == 'on' ? 1 : 0;
            $new_option['uacf7_enable_conversational_form'] = isset($old_option['uacf7_enable_conversational_form']) && $old_option['uacf7_enable_conversational_form'] == 'on' ? 1 : 0;
            $new_option['uacf7_enable_submission_id_field'] = isset($old_option['uacf7_enable_submission_id_field']) && $old_option['uacf7_enable_submission_id_field'] == 'on' ? 1 : 0;
            $new_option['uacf7_enable_telegram_field'] = isset($old_option['uacf7_enable_telegram_field']) && $old_option['uacf7_enable_telegram_field'] == 'on' ? 1 : 0;
            $new_option['uacf7_enable_signature_field'] = isset($old_option['uacf7_enable_signature_field']) && $old_option['uacf7_enable_signature_field'] == 'on' ? 1 : 0;
            $new_option['uacf7_enable_dynamic_text'] = isset($old_option['uacf7_enable_dynamic_text']) && $old_option['uacf7_enable_dynamic_text'] == 'on' ? 1 : 0;
            $new_option['uacf7_enable_pre_populate_field'] = isset($old_option['uacf7_enable_pre_populate_field']) && $old_option['uacf7_enable_pre_populate_field'] == 'on' ? 1 : 0;
            $new_option['uacf7_enable_star_rating'] = isset($old_option['uacf7_enable_star_rating']) && $old_option['uacf7_enable_star_rating'] == 'on' ? 1 : 0;
            $new_option['uacf7_enable_range_slider'] = isset($old_option['uacf7_enable_range_slider']) && $old_option['uacf7_enable_range_slider'] == 'on' ? 1 : 0;
            $new_option['uacf7_enable_repeater_field'] = isset($old_option['uacf7_enable_repeater_field']) && $old_option['uacf7_enable_repeater_field'] == 'on' ? 1 : 0;
            $new_option['uacf7_enable_country_dropdown_field'] = isset($old_option['uacf7_enable_country_dropdown_field']) && $old_option['uacf7_enable_country_dropdown_field'] == 'on' ? 1 : 0;
            $new_option['uacf7_enable_ip_geo_fields'] = isset($old_option['uacf7_enable_ip_geo_fields']) && $old_option['uacf7_enable_ip_geo_fields'] == 'on' ? 1 : 0;
            $new_option['uacf7_enable_product_dropdown'] = isset($old_option['uacf7_enable_product_dropdown']) && $old_option['uacf7_enable_product_dropdown'] == 'on' ? 1 : 0;
            $new_option['uacf7_enable_product_auto_cart'] = isset($old_option['uacf7_enable_product_auto_cart']) && $old_option['uacf7_enable_product_auto_cart'] == 'on' ? 1 : 0;
            $new_option['uacf7_booking_calendar_key'] = isset($old_option['uacf7_booking_calendar_key']) ? $old_option['uacf7_booking_calendar_key'] : '';
            $new_option['uacf7_booking_calendar_id'] = isset($old_option['uacf7_booking_calendar_id']) ? $old_option['uacf7_booking_calendar_id'] : '';
            
            // Mailchim api key
            $uacf7_mailchimp_option_name = get_option('uacf7_mailchimp_option_name');
            $new_option['uacf7_mailchimp_api_key'] = isset($uacf7_mailchimp_option_name['uacf7_mailchimp_api_key']) ? $uacf7_mailchimp_option_name['uacf7_mailchimp_api_key'] : '';

            //  golobal form style
            $uacf7_global_form_style = get_option('uacf7_global_settings_styles');
        
            if(isset($uacf7_global_form_style) && !empty($uacf7_global_form_style)){
                $uacf7_global_settings_styles_migrate = [];
                foreach($uacf7_global_form_style as $key => $value){
                    $uacf7_global_settings_styles_migrate[$key] = $value;
                }
                $new_option = array_merge($new_option, $uacf7_global_settings_styles_migrate);
            
            } 

            // update migration option
            update_option('uacf7_settings', $new_option);

            // update migration status
            update_option( 'uacf7_settings_migration_status', true );
        }
        
  
    }
    // add_action( 'admin_init', 'uacf7_form_option_Migration_callback' );

}


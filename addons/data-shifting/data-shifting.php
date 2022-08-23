<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class UACF7_DATA_SHIFT {
    
    /*
    * Construct function
    */
    public function __construct() {
        
        add_action( 'wp_enqueue_scripts', array($this, 'wp_enqueue_script' ) );  
        add_action( 'admin_enqueue_scripts', array($this, 'wp_enqueue_admin_script' ) );  
        add_action( 'wpcf7_editor_panels', array( $this, 'uacf7_add_panel' ) );
        add_action( 'wpcf7_after_save', array( $this, 'uacf7_bf_save_contact_form' ) );
        add_action( 'wp_footer', array( $this, 'uacf7_bf_add_to_footer' ) ); 
        
    } 

    public function wp_enqueue_script() {
		wp_enqueue_script( 'data-shifting-script', UACF7_ADDONS . '/data-shifting/assets/js/data-shifting.js', array('jquery'), null, true ); 
    }
    public function wp_enqueue_admin_script() {
        wp_enqueue_style( 'uacf7-multistep-style', UACF7_ADDONS . '/data-shifting/assets/css/admin-data-shifting.css' );
		wp_enqueue_script( 'admin-data-shifting', UACF7_ADDONS . '/data-shifting/assets/js/admin-data-shifting.js', array('jquery'), null, true ); 
    }
    

    public function uacf7_add_panel($panels){
        $panels['uacf7-data-shifting-panel'] = array(
            'title'    => __( 'UACF7 Form Shipting Form', 'ultimate-addons-cf7' ),
			'callback' => array( $this, 'uacf7_create_form_shifting_panel_fields' ),
		);
		return $panels;
    }


    /*
    * Form Panel Field
    */

    public function uacf7_create_form_shifting_panel_fields( $post ) {
        $form_current = \WPCF7_ContactForm::get_current();
        
        $all_steps = $form_current->scan_form_tags( array('type'=>'uacf7_step_start') );
        $all_fields = $post->scan_form_tags();
        
        // Event Calendar Issue : 
        $data_shifting_enable = !empty(get_post_meta( $post->id(), 'data_shifting_enable', true )) ? get_post_meta( $post->id(), 'data_shifting_enable', true ) : '';
        $data_redirect_url = !empty(get_post_meta( $post->id(), 'data_redirect_url', true )) ? get_post_meta( $post->id(), 'data_redirect_url', true ) : ''; 
        $data_shifting_passing_field = !empty(get_post_meta( $post->id(), 'data_shifting_passing_field', true )) ? get_post_meta( $post->id(), 'data_shifting_passing_field', true ) : []; 
        $data_shifting_form = !empty(get_post_meta( $post->id(), 'data_shifting_form', true )) ? get_post_meta( $post->id(), 'data_shifting_form', true ) : []; 
        $count_shifting = count($data_shifting_passing_field);
   
        $list_forms = get_posts(array(
            'post_type'     => 'wpcf7_contact_form',
            'posts_per_page'   => -1
        )); 
        ?>  
        
        <fieldset>
           <div class="ultimate-data-shifting-admin"> 
               <div class="main-block">
                    <div class="sub-block">
                        <label for="data_shifting_enable">
                        <h3><?php _e( 'Enable/Disable Data Shifting', 'ultimate-addons-cf7' ); ?></h3>
                        </label> 
                       
                        <label for="data_shifting_enable">
                            <input class="data-shifting" id="data_shifting_enable" name="data_shifting_enable" type="checkbox" value="1" <?php checked( '1', $data_shifting_enable, true ); ?>> <?php _e( 'Enable Data Shifting', 'ultimate-addons-cf7' ); ?>
                        </label> 
                        <div class="uacf7-doc-notice">Not sure how to set this? Check our step by step <a href="https://themefic.com/docs/ultimate-addons-for-contact-form-7/booking-appointment-form/" target="_blank">documentation</a>.</div>
                        <?php if($data_shifting_enable != '' || $data_shifting_enable != 0): ?>
                       
                         
                        <div class="sub-block "> 
                            <h3><?php _e( 'Redirect URL', 'ultimate-addons-cf7' ); ?></h3> 
                            <label for="bf-enable">
                                <input class="data-redirect-url" id="data_redirect_url" name="data_redirect_url" type="input" value="<?php echo $data_redirect_url; ?>"> 
                            </label> 
                        </div> 
                        <div class="sub-block "> 
                            <label><h3><?php _e( 'Select Shifting Form', 'ultimate-addons-cf7' ); ?></h3></label>  
                            <div class="data_shifting_field">
                                <div class="single_data_shifting_field_wrap">
                                    <div class="single_data_shifting_field_inner">
                                        <select name="data_shifting_form" id="data_shifting_form">
                                            <?php 
                                            foreach ($list_forms as $form) { 
                                                if($data_shifting_form == $form->ID){$selected = "selected"; }else{$selected = "";}
                                                echo '<option value="' . esc_attr($form->ID) . '" '.esc_attr($selected).'>' . esc_attr($form->post_title) . '</option>'; 
                                            }
                                            ?>
                                        </select>  
                                    </div>
                                </div> 
                                
                            </div>   
                        </div> 

                        <div class="sub-block "> 
                            <label><h3><?php _e( 'Select Passing Data Field', 'ultimate-addons-cf7' ); ?></h3></label>   
                            <div class="data_shifting_field">
                                <div class="single_data_shifting_field_wrap" style="display: none !important;">
                                    <div class="single_data_shifting_field_inner">
                                        <select name="data_shifting_passing[]" id="data_shifting_passing_field">
                                            <?php
                                            $all_fields = $post->scan_form_tags();
                                            foreach ($all_fields as $tag) {
                                                if ($tag['type'] != 'submit') {
                                                    echo '<option value="' . esc_attr($tag['name']) . '" ' . selected($event_date, $tag['name']) . '>' . esc_attr($tag['name']) . '</option>';
                                                }
                                            }
                                            ?>
                                        </select> 
                                        <span class="close" style="display: none !important;"><a class="uacf7-remove-data-shift button-primary" href="#" title="Remove">Remove Field</a></span>
                                    </div>
                                </div>
                                <?php  
                                    $count_sifting = count($data_shifting_passing_field);
                                    ?>
                                <div class="single_data_shifting_field_wrap_2"> 
                                <?php for( $i = 0; $i < $count_shifting; $i++ ) : ?>
                                    <div class="single_data_shifting_field_inner">
                                        
                                        <select name="data_shifting_passing_field[]" id="data_shifting_passing_field">
                                            <?php 
                                            $all_fields = $post->scan_form_tags();
                                            foreach ($all_fields as $tag) {
                                                if ($tag['type'] != 'submit') {
                                                    if($data_shifting_passing_field[$i] == $tag['name']){$selected = "selected"; }else{$selected = "";}
                                                    echo '<option value="' . esc_attr($tag['name']) . '" ' . esc_attr($selected) . '>' . esc_attr($tag['name']) . '</option>';
                                                }
                                            }
                                            ?>
                                        </select> 
                                        <span class="close" style=""><a class="uacf7-remove-data-shift button-primary" href="#" title="Remove">Remove Field</a></span>
                                    </div>
                                <?php endfor; ?>
                                </div>
                                
                            </div>  
                            <br>
                            <a class="uacf7-add-data-shift button-primary" href="#" title="Add">Add Field</a>
                        </div> 
                        <?php endif; ?>
                    </div>
                </div>
            </div> 
        </fieldset> 
        <?php 
    }
    
    
    /*
    * Form Save Meta Data
    */

    public function uacf7_bf_save_contact_form($post){
        if ( ! isset( $_POST ) || empty( $_POST ) ) {
            return;
        }
      
        // Event Calendar
        update_post_meta( $post->id(), 'data_shifting_enable', $_POST['data_shifting_enable'] );
        update_post_meta( $post->id(), 'data_redirect_url', $_POST['data_redirect_url'] ); 
        update_post_meta( $post->id(), 'data_shifting_form', $_POST['data_shifting_form'] ); 

        $filed_values = array();
        foreach( $_POST['data_shifting_passing_field'] as $filed_value ) {
            $filed_values[] = sanitize_text_field( $filed_value );
        }
        update_post_meta( $post->id(), 'data_shifting_passing_field', $filed_values );

    }
 
    /*
    * After form Submit
    */

    public function uacf7_bf_add_to_footer($post){
        $post = WPCF7_ContactForm::get_current();
        if($post){
            $data_shifting_enable = !empty(get_post_meta( $post->id(), 'data_shifting_enable', true )) ? get_post_meta( $post->id(), 'data_shifting_enable', true ) : '';
            $data_redirect_url = !empty(get_post_meta( $post->id(), 'data_redirect_url', true )) ? get_post_meta( $post->id(), 'data_redirect_url', true ) : ''; 
            $data_shifting_passing_field = !empty(get_post_meta( $post->id(), 'data_shifting_passing_field', true )) ? get_post_meta( $post->id(), 'data_shifting_passing_field', true ) : []; 
            $data_shifting_form = !empty(get_post_meta( $post->id(), 'data_shifting_form', true )) ? get_post_meta( $post->id(), 'data_shifting_form', true ) : [];   
            $data_shifting_passing_field = json_encode($data_shifting_passing_field);
    
            if($data_shifting_enable != '' && $data_shifting_enable != 0):
                
                wp_localize_script( 'data-shifting-script', 'data_shifting_script',
                    array( 
                        'data_redirect_url' => $data_redirect_url,
                        'data_shifting_passing_field' => $data_shifting_passing_field, 
                        'data_shifting_form' => $data_shifting_form, 
                    )
                );
           ?>
            <script type="text/javascript">
            ;(function ($) {
                    'use strict';
                $ ( document ).ready(function() {
                    $(".wpcf7-submit").click(function(e){ 
                        
                        var shifting_field = JSON.parse(data_shifting_script.data_shifting_passing_field);
                        var count_field = shifting_field.length;
                        var redirect_data = '?form='+data_shifting_script.data_shifting_form+'';
                        for (var i = 0; i < count_field; i++) {
                            var type = $("form [name='"+shifting_field[i]+"']").attr('type'); 
                            var multiple= $("form [name='"+shifting_field[i]+"[]']").attr('type')
                            if(type == 'radio' || type == 'checkbox'){ 
                                var value = $("form [name='"+shifting_field[i]+"']:checked").val() 
                            }else if( multiple == 'checkbox' ){
                                var value = $("form [name='"+shifting_field[i]+"[]']:checked").val() 
                                alert(value);
                            }else{
                                var value = $("form [name='"+shifting_field[i]+"']").val()  
                            }
                             
                            redirect_data += '&'+shifting_field[i]+'='+value+'';
                           
                        }  
                       
                        document.addEventListener( 'wpcf7mailsent', function( event ) {
                        console.log(shifting_field.length);
                            location = data_shifting_script.data_redirect_url+redirect_data;
                        }, false );
                    }); 
                });
             })(jQuery);
            </script> 
           <?php  
          else:
            ?>
            <script type="text/javascript"> 
                ;(function ($) {
                    'use strict';
                    $ ( document ).ready(function() { 
                        var form_id = new URLSearchParams(window.location.search).get('form'); 
                         
                        if(form_id != '' && form_id != 0){
                            var url = document.location.href;
                            var value = url.substring(url.indexOf('?') + 1).split('&');
                            for(var i = 0, result = {}; i < value.length; i++){
                                
                                value[i] = value[i].split('='); 

                                var type = $("form [name='"+value[i][0]+"']").attr('type'); 
                                var multiple = $("form [name='"+value[i][0]+"[]']").attr('type');
                                
                                if(type == 'radio' || type == 'checkbox'){  
                                    $("form [name='"+value[i][0]+"'][value="+decodeURIComponent(value[i][1])+"]").attr("checked", true); 
                                }else if( multiple == 'checkbox' ){  
                                    $("form [name='"+value[i][0]+"[]'][value="+decodeURIComponent(value[i][1])+"]").attr("checked", true); 
                                }else{
                                    $("form [name='"+value[i][0]+"']").val(decodeURIComponent(value[i][1])); 
                                }
                                
                            } 
                        }  
                    });
                    
                })(jQuery);
            </script> 
            <?php 
            endif;
        }
       
    }
   
}
new UACF7_DATA_SHIFT();
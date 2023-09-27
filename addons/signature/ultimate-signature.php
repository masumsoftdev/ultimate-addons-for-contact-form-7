<?php

/** Prevent direct access */
if (!defined('ABSPATH')) {
  echo "You are not allowed to access directly";
  exit();
}


class UACF7_SIGNATURE{

  public function __construct(){
    require_once('inc/signature.php');
    add_action( 'wp_enqueue_scripts', [$this, 'uacf7_signature_public_scripts'] );

    add_action('admin_init', [$this, 'uacf7_signature_tag_generator']);
    add_action('wpcf7_init', [$this, 'uacf7_signature_add_shortcodes']);
  }





  /** Loading Scripts */

  public function uacf7_signature_public_scripts(){

    wp_enqueue_script( 'uacf7-signature-public-assets', UACF7_URL .'/addons/signature/assets/public/js/signature.js', ['jquery'], 'UACF7_VERSION', true );

  }

  /** Signature Tag Generator */

  public function uacf7_signature_tag_generator(){
    if (!function_exists('wpcf7_add_tag_generator')) {
      return;
  }

  wpcf7_add_tag_generator('uacf7_signature',
      __('Signature', 'ultimate-addons-cf7'),
      'uacf7-tg-pane-signature',
      array($this, 'tg_pane_signature')
  );
  }

  public static function tg_pane_signature($contact_form, $args = ''){
    $args = wp_parse_args($args, array());
    $uacf7_field_type = 'uacf7_signature';
    ?>
      <div class="control-box">
      <fieldset>
                <table class="form-table">
                  <tbody>
                        <div class="uacf7-doc-notice"> 
                            <?php echo sprintf( 
                                __( 'Not sure how to set this? Check our step by step  %1s.', 'ultimate-addons-cf7' ),
                                '<a href="https://themefic.com/docs/uacf7/free-addons/unique-submission-id/" target="_blank">documentation</a>'
                            ); ?> 
                        </div>
                        <tr>
                            <th scope="row"><label for="<?php echo esc_attr($args['content'] . '-name'); ?>"><?php echo esc_html(__('Name', 'ultimate-addons-cf7')); ?></label></th>
                            <td><input type="text" name="name" class="tg-name oneline" id="<?php echo esc_attr($args['content'] . '-name'); ?>" /></td>
                        </tr> 
                        <tr>
                            <th scope="row"><label for="tag-generator-panel-text-class"><?php echo esc_html__('Class attribute', 'ultimate-addons-cf7'); ?></label></th>
                            <td><input type="text" name="class" class="classvalue oneline option" id="tag-generator-panel-text-class"></td>
                        </tr>
                    </tbody>
                </table>
            </fieldset>
      </div>

      <div class="insert-box">
          <input type="text" name="<?php echo esc_attr($uacf7_field_type); ?>" class="tag code" readonly="readonly" onfocus="this.select()" />

          <div class="submitbox">
              <input type="button" class="button button-primary insert-tag" id="prevent_multiple" value="<?php echo esc_attr(__('Insert Tag', 'ultimate-addons-cf7')); ?>" />
          </div>
      </div>
      <?php
  }


  /** Add Signature Shortcode */

  public function uacf7_signature_add_shortcodes(){
    wpcf7_add_form_tag(array('uacf7_signature', 'uacf7_signature*'),
    array($this, 'uacf7_signature_tag_handler_callback'), array('name-attr' => true,
    'file-uploading' => true));
  }

  public function uacf7_signature_tag_handler_callback($tag){
    if (empty($tag->name)) {
      return '';
    }

      /** Enable / Disable Submission ID */
      $wpcf7 = WPCF7_ContactForm::get_current(); 
      $formid = $wpcf7->id();
      $uacf7_signature_settings = get_post_meta( $formid, 'uacf7_signature_settings', true ); 

      $uacf7_signature_enable = $uacf7_signature_settings['uacf7_signature_enable'];

      
      if($uacf7_signature_enable != 'on'){
          return;
      }

      $validation_error = wpcf7_get_validation_error($tag->name);

        $class = wpcf7_form_controls_class($tag->type);


        if ($validation_error) {
            $class .= 'wpcf7-not-valid';
        }

        $atts = array();

        $atts['class'] = $tag->get_class_option($class);
        $atts['id'] = $tag->get_id_option();
        $atts['tabindex'] = $tag->get_option('tabindex', 'signed_int', true);

        if ($tag->is_required()) {
            $atts['aria-required'] = 'true';
        }

        $atts['aria-invalid'] = $validation_error ? 'true' : 'false';

        $atts['name'] = $tag->name;

        // input size
        $size = $tag->get_option('size', 'int', true);
        if ($size) {
            $atts['size'] = $size;
        } else {
            $atts['size'] = 40;
        } 
        $value = $tag->values;
        $default_value = $tag->get_default_option($value);


      
        $atts['value'] = $value;
    


        $atts['name'] = $tag->name;

        $atts = wpcf7_format_atts($atts);

        ob_start();

        ?> 
        <span  class="wpcf7-form-control-wrap <?php echo sanitize_html_class($tag->name); ?>" data-name="<?php echo sanitize_html_class($tag->name); ?>">

            <input hidden id="uacf7_<?php echo esc_attr($tag->name); ?>" <?php echo $atts;?> >
            <input type="file" id="img_id_special" <?php echo $atts;?> >
            <div>
            <div id="signature-pad">
                <canvas id="signature-canvas"></canvas>
            </div>
            <button id="clear-button">Clear</button>
            <button id="convertButton">Confirm Signature</button>
            </div>
            <span><?php echo $validation_error; ?></span>

        </span>
        
       <?php 
        $signature_buffer = ob_get_clean();

        return $signature_buffer;

   
  }

}

new UACF7_SIGNATURE;
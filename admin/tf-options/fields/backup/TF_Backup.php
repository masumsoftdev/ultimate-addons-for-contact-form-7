<?php 
//don't load directly
defined( 'ABSPATH' ) || exit;
//backup import export field
if ( ! class_exists( 'TF_Backup' ) ) {
    class TF_Backup extends UACF7_Fields {
        public function __construct( $field, $value = '', $settings_id = '', $parent_field = '' ) {
            parent::__construct( $field, $value, $settings_id, $parent_field  );
        }
        public function render() { 
              
            $current_settings = get_option($this->settings_id); 
            $current_settings = isset($current_settings) && !empty($current_settings) ? serialize( $current_settings ) : '';        
          
            $placeholder = ( ! empty( $this->field['placeholder'] ) ) ? 'placeholder="' . $this->field['placeholder'] . '"' : '';
            echo '<textarea class="tf-exp-imp-field" cols="50" rows="15" name="tf_import_option" id="' . esc_attr( $this->field_name() ) . '"' . $placeholder . ' '. $this->field_attributes() .'> </textarea>';
            echo '<a href="#" class="tf-import-btn button button-primary">' . __( 'Import', 'tourfic' ) . '</a>';
            echo '<hr>';
            echo '<textarea cols="50" rows="15" class="tf-exp-imp-field"  data-option="'.esc_attr( $this->settings_id ).'" name="tf_export_option" id="' . esc_attr( $this->field_name() ) . '"' . $placeholder . ' '. $this->field_attributes() .'disabled >' . $current_settings . '</textarea>';
            echo '<a href="#" class="tf-export-btn button button-primary">' . __( 'Export', 'tourfic' ) . '</a>';

        }
    }
}
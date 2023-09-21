<?php
defined( 'ABSPATH' ) || exit;

/**
 * Template for the Form Generator AI tags.
 *
 * @package   UACF7
 * @subpackage Form Generator AI
 * @since     1.0.0
 * @Author:  Sydur Rahman
 * @variable :  $uacf7_default, $form_step, $form_field, $form_label
 *
 */ 
$manager = WPCF7_FormTagsManager::get_instance();

// $reflector = new ReflectionClass('WPCF7_TagGenerator');
// $property = $reflector->getProperty('panels');
// $property->setAccessible(true);

// $panels = $property->getValue($tag_generator); 
ob_start();
    $field = '';
    if(isset($uacf7_default[1]) && !empty($uacf7_default[1])){
        
        if($form_field > 1){
            for($i = 1; $i <= $form_field; $i++){
                if($form_label == 1){ 
                    $field .=  '<label> \n'.$uacf7_default[1].' '.$i.'['.$uacf7_default[1].' '.$uacf7_default[1].'-'.$i.'] </label> \n ';
                }else{
                    $field .=  '['.$uacf7_default[1].' '.$uacf7_default[1].'-'.$i.'] \n';

                }
            }
        }else{

            $field = '['.$uacf7_default[1].' '.$uacf7_default[1].'] \n';
        }
 
    }
    echo $field;
    


 return ob_get_clean();
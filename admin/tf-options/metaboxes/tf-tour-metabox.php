<?php
// don't load directly
defined( 'ABSPATH' ) || exit;

/**
 * Get all the meals from glabal settings
 * @author AbuHena
 * @since 1.7.0
 */
function tf_tour_meals() {
	$itinerary_options = ! empty( tf_data_types( tfopt( 'itinerary-builder-setings' ) ) ) ? tf_data_types( tfopt( 'itinerary-builder-setings' ) ) : '';
	$all_meals         = [];
	if ( ! empty( $itinerary_options['meals'] ) && is_array( $itinerary_options['meals'] ) ) {
		$meals = $itinerary_options['meals'];
		foreach ( $meals as $key => $meal ) {
			$all_meals[ $meal['meal'] . $key ] = $meal['meal'];
		}
	}

	return $all_meals;
} 
if(isset($_GET['post'])){
	 $post_id = $_GET['post'];
} else{
	$post_id = 0;
}
 
// exit;
TF_Metabox::metabox( 'uacf7_form_opt', array(
	'title'     => __( 'Tour Setting', 'tourfic' ),
	'post_type' => 'tf_tours',
	// 'sections'  =>    array(
	// 	'settings'             => array(
	// 		'title'  => __( 'Settings', 'tourfic' ),
	// 		'icon'   => 'fa-solid fa-viruses',
	// 		'fields' => array(
	// 			array(
	// 				'id'    => 'settings_headding',
	// 				'type'  => 'heading',
	// 				'label' => __( 'Settings', 'tourfic' ),
	// 			),
	// 			array(
	// 				'id'        => 't-review',
	// 				'type'      => 'switch',
	// 				'label'     => __( 'Disable Review Section', 'tourfic' ),
	// 				'label_on'  => __( 'Yes', 'tourfic' ),
	// 				'label_off' => __( 'No', 'tourfic' ),
	// 				'default'   => false
	// 			),
				
	// 		),
	// 	),
	// ),
	'sections'  =>    apply_filters('uacf7_post_meta_options', $value = array( ), $post_id),
	
	// 'sections'  => array(
	// 	// General 
	// 	do_action('uacf7_post_meta_options'),
		
	// 	// // Settings
		
	// ),
) );

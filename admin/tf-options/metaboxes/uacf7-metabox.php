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
	'post_type' => 'uacf7',
 
	'sections'  =>    apply_filters('uacf7_post_meta_options', $value = array( ), $post_id), 
) );

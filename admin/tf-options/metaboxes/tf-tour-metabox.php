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

TF_Metabox::metabox( 'uacf7_form_opt', array(
	'title'     => __( 'Tour Setting', 'tourfic' ),
	'post_type' => 'tf_tours',
	'sections'  => array(
		// General
		'Redirection'              => array(
			'title'  => __( 'General', 'tourfic' ),
			'icon'   => 'fa fa-cog',
			'fields' => array(
				apply_filters('redirection_pro_feature', array(
					'id'       => 'tour_as_featured',
					'type'     => 'switch',
					'label'    => __( 'Set as featured', 'tourfic' ),
					'subtitle' => __( 'This tour will be highlighted at the top of the search result and tour archive page', 'tourfic' ),
					'is_pro'   => true,
				)),
				array(
					'id'          => 'featured_text',
					'type'        => 'text',
					'label'       => __( 'Tour Featured Text', 'tourfic' ),
					'subtitle'    => __( 'Enter Featured Tour Text', 'tourfic' ),
					'placeholder' => __( 'Enter Featured Tour Text', 'tourfic' ),
					'default' => __( 'Hot Deal', 'tourfic' ),
					'dependency'  => array( 'tour_as_featured', '==', true ),
				),
				array(
					'id'       => 'tf_single_tour_layout_opt',
					'type'     => 'select',
					'label'    => __( 'Tour Page Layout', 'tourfic' ),
					'subtitle' => __( 'Select your Layout logic', 'tourfic' ),
					'options'  => [
						'global' => __( 'Global Settings', 'tourfic' ),
						'single' => __( 'Single Settings', 'tourfic' ),
					],
					'default'  => 'global',
				), 

				array(
					'id'    => 'tour_gallery',
					'type'  => 'gallery',
					'label' => __( 'Tour Gallery', 'tourfic' ),
				),

				array(
					'id'     => 'tour_video',
					'type'   => 'text',
					'label'  => __( 'Tour Video', 'tourfic' ),
				),
			),
		), 
		// // Settings
		'settings'             => array(
			'title'  => __( 'Settings', 'tourfic' ),
			'icon'   => 'fa-solid fa-viruses',
			'fields' => array(
				array(
					'id'    => 'settings_headding',
					'type'  => 'heading',
					'label' => __( 'Settings', 'tourfic' ),
				),
				array(
					'id'        => 't-review',
					'type'      => 'switch',
					'label'     => __( 'Disable Review Section', 'tourfic' ),
					'label_on'  => __( 'Yes', 'tourfic' ),
					'label_off' => __( 'No', 'tourfic' ),
					'default'   => false
				),
				array(
					'id'        => 't-share',
					'type'      => 'switch',
					'label'     => __( 'Disable Share Option', 'tourfic' ),
					'label_on'  => __( 'Yes', 'tourfic' ),
					'label_off' => __( 'No', 'tourfic' ),
					'default'   => false
				),
				array(
					'id'        => 't-related',
					'type'      => 'switch',
					'label'     => __( 'Disable Related Tour Section', 'tourfic' ),
					'label_on'  => __( 'Yes', 'tourfic' ),
					'label_off' => __( 'No', 'tourfic' ),
					'default'   => false
				),

				array(
					'id'      => 'notice',
					'type'    => 'notice',
					'notice'  => 'info',
					'content' => __( 'These settings will overwrite global settings', 'tourfic' ),
				),

				array(
					'id'      => 'tour-booking-section',
					'type'    => 'heading',
					'content' => __( 'Booking Section', 'tourfic' ),
					'class'   => 'tf-field-class',
				),
				array(
					'id'    => 'booking-section-title',
					'type'  => 'text',
					'label' => __( 'Booking Section Title', 'tourfic' ),
					'default' => "Book This Tour"
				),
				array(
					'id'      => 'tour-description-section',
					'type'    => 'heading',
					'content' => __( 'Description', 'tourfic' ),
					'class'   => 'tf-field-class',
				),
				array(
					'id'    => 'description-section-title',
					'type'  => 'text',
					'label' => __( 'Description Section Title', 'tourfic' ),
					'default' => "Description"
				),
				array(
					'id'      => 'popular-map',
					'type'    => 'heading',
					'content' => __( 'Map', 'tourfic' ),
					'class'   => 'tf-field-class',
				),
				array(
					'id'    => 'map-section-title',
					'type'  => 'text',
					'label' => __( 'Map Section Title', 'tourfic' ),
					'default' => "Maps"
				),
				array(
					'id'      => 'review-sections',
					'type'    => 'heading',
					'content' => __( 'Review', 'tourfic' ),
					'class'   => 'tf-field-class',
				),
				array(
					'id'    => 'review-section-title',
					'type'  => 'text',
					'label' => __( 'Reviews Section Title', 'tourfic' ),
					'default' => "Average Guest Reviews"
				),
				array(
					'id'      => 'enquiry-section',
					'type'    => 'heading',
					'content' => __( 'Enquiry', 'tourfic' ),
					'class'   => 'tf-field-class',
				),
				array(
					'id'        => 't-enquiry-section',
					'type'      => 'switch',
					'label'     => __( 'Tour Enquiry Option', 'tourfic' ),
					'label_on'  => __( 'Yes', 'tourfic' ),
					'label_off' => __( 'No', 'tourfic' ),
					'default'   => true
				),
				array(
					'id'    => 't-enquiry-option-title',
					'type'  => 'text',
					'label' => __( 'Tour Enquiry Title Text', 'tourfic' ),
					'default' => "Have a question in mind",
					'dependency' => array( 't-enquiry-section', '==', '1' ),
				),
				array(
					'id'    => 't-enquiry-option-content',
					'type'  => 'text',
					'label' => __( 'Tour Enquiry Short Text', 'tourfic' ),
					'default' => "Looking for more info? Send a question to the property to find out more.",
					'dependency' => array( 't-enquiry-section', '==', '1' ),
				),
				array(
					'id'    => 't-enquiry-option-btn',
					'type'  => 'text',
					'label' => __( 'Tour Enquiry Button Text', 'tourfic' ),
					'default' => "Ask a Question",
					'dependency' => array( 't-enquiry-section', '==', '1' ),
				),
			),
		),
	),
) );

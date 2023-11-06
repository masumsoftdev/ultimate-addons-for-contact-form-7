<?php
// don't load directly
defined( 'ABSPATH' ) || exit;

if ( file_exists( UACF7_PATH . 'admin/tf-options/options/tf-menu-icon.php' ) ) {
	require_once UACF7_PATH . 'admin/tf-options/options/tf-menu-icon.php';
} else {
	$menu_icon = 'dashicons-palmtree';
}

TF_Settings::option( 'uacf7_settings', array(
	'title'    => __( 'Ultimate Addons', 'tourfic' ),
	'icon'     => $menu_icon,
	'position' => 25,
	'sections' => 
		apply_filters('uacf7_settings_options', array(
			'addons_settings'	=> array(
				'title'  => __( 'Addons Settings', 'tourfic' ),
				'icon'   => 'fa fa-cog',
				'fields' => array( 
				),
			),
			'general_addons' => array(
				'title'  => __( 'General Addons', 'tourfic' ),
				'parent' => 'addons_settings',
				'icon'   => 'fa fa-cog',
				'fields' => array(
					'uacf7_enable_redirection' => array(
						'id'        => 'uacf7_enable_redirection',
						'type'      => 'switch',
						'label'     => __( ' Redirection ', 'ultimate-addons-cf7' ),
						'subtitle' => __( 'Redirect users to a Thank you page or external page after form submission. Option to open in a new tab.', 'ultimate-addons-cf7' ),
						'label_on'  => __( 'Yes', 'ultimate-addons-cf7' ),
						'label_off' => __( 'No', 'ultimate-addons-cf7' ),
						'default'   => false,
						
					),
					'uacf7_enable_conditional_field' => array(
						'id'        => 'uacf7_enable_conditional_field',
						'type'      => 'switch',
						'label'     => __( ' Conditional Field', 'ultimate-addons-cf7' ),
						'label_on'  => __( 'Yes', 'ultimate-addons-cf7' ),
						'label_off' => __( 'No', 'ultimate-addons-cf7' ),
						'default'   => false,
						
					),
					'uacf7_enable_field_column' => array(
						'id'        => 'uacf7_enable_field_column',
						'type'      => 'switch',
						'label'     => __( ' Column or Grid', 'ultimate-addons-cf7' ),
						'label_on'  => __( 'Yes', 'ultimate-addons-cf7' ),
						'label_off' => __( 'No', 'ultimate-addons-cf7' ),
						'default'   => false,
						
					),
					'uacf7_enable_placeholder' => array(
						'id'        => 'uacf7_enable_placeholder',
						'type'      => 'switch',
						'label'     => __( 'Placeholder Styling', 'ultimate-addons-cf7' ),
						'label_on'  => __( 'Yes', 'ultimate-addons-cf7' ),
						'label_off' => __( 'No', 'ultimate-addons-cf7' ),
						'default'   => false,
						
					),
					'uacf7_enable_uacf7style' => array(
						'id'        => 'uacf7_enable_uacf7style',
						'type'      => 'switch',
						'label'     => __( 'Complete Form Styler', 'ultimate-addons-cf7' ),
						'label_on'  => __( 'Yes', 'ultimate-addons-cf7' ),
						'label_off' => __( 'No', 'ultimate-addons-cf7' ),
						'default'   => false,
						
					),
					'uacf7_enable_multistep' => array(
						'id'        => 'uacf7_enable_multistep',
						'type'      => 'switch',
						'label'     => __( 'Multistep Form', 'ultimate-addons-cf7' ),
						'label_on'  => __( 'Yes', 'ultimate-addons-cf7' ),
						'label_off' => __( 'No', 'ultimate-addons-cf7' ),
						'default'   => false,
						
					),
					'uacf7_enable_booking_form' => array(
						'id'        => 'uacf7_enable_booking_form',
						'type'      => 'switch',
						'label'     => __( 'Booking/Appointment Form', 'ultimate-addons-cf7' ),
						'label_on'  => __( 'Yes', 'ultimate-addons-cf7' ),
						'label_off' => __( 'No', 'ultimate-addons-cf7' ),
						'default'   => false, 
						'is_pro' => true,
					),
					'uacf7_enable_post_submission' => array(
						'id'        => 'uacf7_enable_post_submission',
						'type'      => 'switch',
						'label'     => __( 'Frontend Post Submission', 'ultimate-addons-cf7' ),
						'label_on'  => __( 'Yes', 'ultimate-addons-cf7' ),
						'label_off' => __( 'No', 'ultimate-addons-cf7' ),
						'default'   => false,
						
						'is_pro' => true,
					),
					'uacf7_enable_mailchimp' => array(
						'id'        => 'uacf7_enable_mailchimp',
						'type'      => 'switch',
						'label'     => __( 'Mailchimp', 'ultimate-addons-cf7' ),
						'label_on'  => __( 'Yes', 'ultimate-addons-cf7' ),
						'label_off' => __( 'No', 'ultimate-addons-cf7' ),
						'default'   => false,
						
					),
					'uacf7_enable_database_field' => array(
						'id'        => 'uacf7_enable_database_field',
						'type'      => 'switch',
						'label'     => __( 'Database', 'ultimate-addons-cf7' ),
						'label_on'  => __( 'Yes', 'ultimate-addons-cf7' ),
						'label_off' => __( 'No', 'ultimate-addons-cf7' ),
						'default'   => false,
						
					),
					'uacf7_enable_pdf_generator_field' => array(
						'id'        => 'uacf7_enable_pdf_generator_field',
						'type'      => 'switch',
						'label'     => __( 'PDF Generator', 'ultimate-addons-cf7' ),
						'label_on'  => __( 'Yes', 'ultimate-addons-cf7' ),
						'label_off' => __( 'No', 'ultimate-addons-cf7' ),
						'default'   => false,
						
					),
					'uacf7_enable_conversational_form' => array(
						'id'        => 'uacf7_enable_conversational_form',
						'type'      => 'switch',
						'label'     => __( 'Conversational Form', 'ultimate-addons-cf7' ),
						'label_on'  => __( 'Yes', 'ultimate-addons-cf7' ),
						'label_off' => __( 'No', 'ultimate-addons-cf7' ),
						'default'   => false,
						
						'is_pro' => true,
					),
					'uacf7_enable_submission_id_field' => array(
						'id'        => 'uacf7_enable_submission_id_field',
						'type'      => 'switch',
						'label'     => __( 'Submission ID', 'ultimate-addons-cf7' ),
						'label_on'  => __( 'Yes', 'ultimate-addons-cf7' ),
						'label_off' => __( 'No', 'ultimate-addons-cf7' ),
						'default'   => false,
						
					),
					'uacf7_enable_telegram_field' => array(
						'id'        => 'uacf7_enable_telegram_field',
						'type'      => 'switch',
						'label'     => __( 'Telegram', 'ultimate-addons-cf7' ),
						'label_on'  => __( 'Yes', 'ultimate-addons-cf7' ),
						'label_off' => __( 'No', 'ultimate-addons-cf7' ),
						'default'   => false,
						
					),
				),
			), 
			'extra_fields_addons' => array(
				'title'  => __( 'Extra Fields Addons', 'ultimate-addons-cf7' ),
				'parent' => 'addons_settings',
				'icon'   => 'fa fa-cog',
				'fields' => array(
					'uacf7_enable_dynamic_text' => array(
						'id'        => 'uacf7_enable_dynamic_text',
						'type'      => 'switch',
						'label'     => __( ' Dynamic Text ', 'ultimate-addons-cf7' ),
						'label_on'  => __( 'Yes', 'ultimate-addons-cf7' ),
						'label_off' => __( 'No', 'ultimate-addons-cf7' ),
						'default'   => false,
						
					),
					'uacf7_enable_pre_populate_field' => array(
						'id'        => 'uacf7_enable_pre_populate_field',
						'type'      => 'switch',
						'label'     => __( 'Pre-populate Field', 'ultimate-addons-cf7' ),
						'label_on'  => __( 'Yes', 'ultimate-addons-cf7' ),
						'label_off' => __( 'No', 'ultimate-addons-cf7' ),
						'default'   => false,
						
					),
					'uacf7_enable_star_rating' => array(
						'id'        => 'uacf7_enable_star_rating',
						'type'      => 'switch',
						'label'     => __( 'Star Rating', 'ultimate-addons-cf7' ),
						'label_on'  => __( 'Yes', 'ultimate-addons-cf7' ),
						'label_off' => __( 'No', 'ultimate-addons-cf7' ),
						'default'   => false,
						
					),
					'uacf7_enable_range_slider' => array(
						'id'        => 'uacf7_enable_range_slider',
						'type'      => 'switch',
						'label'     => __( 'Range Slider', 'ultimate-addons-cf7' ),
						'label_on'  => __( 'Yes', 'ultimate-addons-cf7' ),
						'label_off' => __( 'No', 'ultimate-addons-cf7' ),
						'default'   => false,
						
					),
					'uacf7_enable_repeater_field' => array(
						'id'        => 'uacf7_enable_repeater_field',
						'type'      => 'switch',
						'label'     => __( 'Repeater Field', 'ultimate-addons-cf7' ),
						'label_on'  => __( 'Yes', 'ultimate-addons-cf7' ),
						'label_off' => __( 'No', 'ultimate-addons-cf7' ),
						'default'   => false,
						
						'is_pro' => true,
					),
					'uacf7_enable_country_dropdown_field' => array(
						'id'        => 'uacf7_enable_country_dropdown_field',
						'type'      => 'switch',
						'label'     => __( 'Country Dropdown Field', 'ultimate-addons-cf7' ),
						'label_on'  => __( 'Yes', 'ultimate-addons-cf7' ),
						'label_off' => __( 'No', 'ultimate-addons-cf7' ),
						'default'   => false,
						
					),
					'uacf7_enable_ip_geo_fields' => array(
						'id'        => 'uacf7_enable_ip_geo_fields',
						'type'      => 'switch',
						'label'     => __( 'IP Geo Fields (Autocomplete Country, City, State, Zip Fields)', 'ultimate-addons-cf7' ),
						'label_on'  => __( 'Yes', 'ultimate-addons-cf7' ),
						'label_off' => __( 'No', 'ultimate-addons-cf7' ),
						'default'   => false,
						
						'is_pro' => true,
					),    
				),
			), 
			'wooCommerce_integration' => array(
				'title'  => __( 'WooCommerce Integration', 'ultimate-addons-cf7' ),
				'parent' => 'addons_settings',
				'icon'   => 'fa fa-cog',
				'fields' => array(
					'uacf7_enable_product_dropdown' => array(
						'id'        => 'uacf7_enable_product_dropdown',
						'type'      => 'switch',
						'label'     => __( 'Product Dropdown Menu', 'ultimate-addons-cf7' ),
						'label_on'  => __( 'Yes', 'ultimate-addons-cf7' ),
						'label_off' => __( 'No', 'ultimate-addons-cf7' ),
						'default'   => false,
						
					),
					'uacf7_enable_product_auto_cart' => array(
						'id'        => 'uacf7_enable_product_auto_cart',
						'type'      => 'switch',
						'label'     => __( 'Auto Add to Cart & Checkout after Form Submission', 'ultimate-addons-cf7' ),
						'label_on'  => __( 'Yes', 'ultimate-addons-cf7' ),
						'label_off' => __( 'No', 'ultimate-addons-cf7' ),
						'default'   => false,
						
						'is_pro' => true,
					), 
				),
			), 
			'api_integration' => array(
				'title'  => __( 'API Integration', 'ultimate-addons-cf7' ), 
				'icon'   => 'fa fa-cog',
				'fields' => array( 
				),
			), 
			
			
			/**
			 * Import/Export
			 *
			 * Main menu
			 */
			// 'import_export' => array(
			// 	'title' => __( 'Import/Export', 'tourfic' ),
			// 	'icon' => 'fas fa-hdd',
			// 	'fields' => array(
			// 		array(
			// 			'id' => 'backup',
			// 			'type' => 'backup',
			// 		),  

			// 	),
			// ),
		),
	) 
) );

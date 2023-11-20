<?php
// don't load directly
defined( 'ABSPATH' ) || exit;

if ( file_exists( UACF7_PATH . 'options/tf-menu-icon.php' ) ) {
	require_once UACF7_PATH . 'options/tf-menu-icon.php';
} else {
	$menu_icon = 'dashicons-palmtree';
}

TF_Settings::option( 'uacf7_settings', array(
	'title'    => __( 'Ultimate Addons', 'tourfic' ),
	'icon'     => 'dashicons-palmtree',
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
						'image_url' => UACF7_URL . 'assets/admin/images/addons/Redirection@2x.png',
						'subtitle' => __( 'Redirect users to a Thank you page or external page after form submission. Option to open in a new tab.', 'ultimate-addons-cf7' ),
						'demo_link' => 'https://demo.brainstormforce.com/ultimate-addons-for-contact-form-7/redirection/', 
						'documentation_link' => 'https://docs.brainstormforce.com/how-to-redirect-users-to-a-thank-you-page-after-form-submission/', 
						'default'   => false,
						
					),
					'uacf7_enable_redirection_pro' => array(
						'id'        => 'uacf7_enable_redirection_pro',
						'type'      => 'switch',
						'label'     => __( 'Conditional Redirect + Whatsapp Integration + CF7 Tag Support ', 'ultimate-addons-cf7' ),
						'image_url' => UACF7_URL . 'assets/admin/images/addons/Conditional-Field@2x.png',
						'subtitle' => __( 'Redirect user to a URL after submission based on condition. e.g. A user goes to abc.com and B user goes to xyz.com.  Tag support for CF7 fields to be used on redirect URL to pass data. You can also pass submission data to Whatsapp.', 'ultimate-addons-cf7' ),
						'demo_link' => 'https://cf7addons.com/preview/conditional-redirect-for-contact-form-7/', 
						'documentation_link' => 'https://themefic.com/docs/ultimate-addons-for-contact-form-7/conditional-redirect-for-contact-form-7/', 
						'default'   => false,
						'is_pro' => true,
						
					),
					'uacf7_enable_conditional_field' => array(
						'id'        => 'uacf7_enable_conditional_field',
						'type'      => 'switch',
						'label'     => __( ' Conditional Field', 'ultimate-addons-cf7' ),
						'image_url' => UACF7_URL . 'assets/admin/images/addons/Conditional-Field@2x.png',
						'subtitle' => __( 'Show or hide Contact form 7 form fields depending on Conditional Logic. Works with Checkbox and Range Slider also.', 'ultimate-addons-cf7' ),
						'demo_link' => 'https://cf7addons.com/preview/contact-form-7-conditional-fields/', 
						'documentation_link' => 'https://themefic.com/docs/uacf7/free-addons/contact-form-7-conditional-fields/', 
						'default'   => false,
						
					),
					'uacf7_enable_conditional_field_pro' => array(
						'id'        => 'uacf7_enable_conditional_field_pro',
						'type'      => 'switch',
						'label'     => __( 'Conditional Field (Pro)', 'ultimate-addons-cf7' ),
						'image_url' => UACF7_URL . 'assets/admin/images/addons/Conditional-Field@2x.png',
						'subtitle' => __( ' Advanced Conditional Logic for Range Slider, Star Rating, Country Dropdown, IP Geolocation etc.', 'ultimate-addons-cf7' ),
						'demo_link' => 'https://cf7addons.com/preview/conditional-field-pro/', 
						'documentation_link' => 'https://themefic.com/docs/uacf7/free-addons/contact-form-7-conditional-fields/', 
						'default'   => false,
						'is_pro' => true,
						
					),
					'uacf7_enable_field_column' => array(
						'id'        => 'uacf7_enable_field_column',
						'type'      => 'switch',
						'label'     => __( ' Column or Grid', 'ultimate-addons-cf7' ),
						'image_url' => UACF7_URL . 'assets/admin/images/addons/Column-or-Grid-Layout@2x.png',
						'subtitle' => __( ' Advanced Conditional Logic for Range Slider, Star Rating, Country Dropdown, IP Geolocation etc.', 'ultimate-addons-cf7' ),
						'demo_link' => 'https://cf7addons.com/preview/contact-form-7-columns-or-grid/', 
						'documentation_link' => 'https://themefic.com/docs/uacf7/free-addons/contact-form-7-columns/', 
						'label_on'  => __( 'Yes', 'ultimate-addons-cf7' ),
						'label_off' => __( 'No', 'ultimate-addons-cf7' ),
						'default'   => false,
						
					),
					'uacf7_enable_field_column_pro' => array(
						'id'        => 'uacf7_enable_field_column_pro',
						'type'      => 'switch',
						'label'     => __( 'Custom Column Width', 'ultimate-addons-cf7' ),
						'image_url' => UACF7_URL . 'assets/admin/images/addons/Conditional-Field@2x.png',
						'subtitle' => __( 'Set forms column at a desired width e.g. Create three columns form with one column width of 12%, one is 27% and other 61%.', 'ultimate-addons-cf7' ),
						'demo_link' => 'https://cf7addons.com/preview/custom-columns-for-contact-form-7/', 
						'documentation_link' => 'https://themefic.com/docs/ultimate-addons-for-contact-form-7/custom-columns-for-contact-form-7/',  
						'default'   => false,
						'is_pro' => true,
						
					),
					'uacf7_enable_placeholder' => array(
						'id'        => 'uacf7_enable_placeholder',
						'type'      => 'switch',
						'label'     => __( 'Placeholder Styling', 'ultimate-addons-cf7' ), 
						'image_url' => UACF7_URL . 'assets/admin/images/addons/Placeholder-Styling@2x.png',
						'default'   => false, 
						'subtitle' => __( 'Styling form’s placeholder text (e.g. color, background color) without writing any css code.', 'ultimate-addons-cf7' ),
						'demo_link' => 'https://cf7addons.com/preview/contact-form-7-placeholder-styling/', 
						'documentation_link' => 'https://themefic.com/docs/uacf7/free-addons/contact-form-7-placeholder-styling/',  
					),
					'uacf7_enable_uacf7style' => array(
						'id'        => 'uacf7_enable_uacf7style',
						'type'      => 'switch',
						'label'     => __( 'Complete Form Styler', 'ultimate-addons-cf7' ), 
						'image_url' => UACF7_URL . 'assets/admin/images/addons/Form-Styler@2x.png',
						'default'   => false, 
						'subtitle' => __( 'Completely style the whole form without a single line of css code. For example: Color, Margin, button style, font size etc.', 'ultimate-addons-cf7' ),
						'demo_link' => 'https://cf7addons.com/preview/contact-form-7-style-addon/', 
						'documentation_link' => 'https://themefic.com/docs/uacf7/free-addons/contact-form-7-style/',  
					),
					'uacf7_enable_uacf7style_global' => array(
						'id'        => 'uacf7_enable_uacf7style_global',
						'type'      => 'switch',
						'label'     => __( ' Global Form Styler', 'ultimate-addons-cf7' ), 
						'image_url' => UACF7_URL . 'assets/admin/images/addons/Global-Form-Styler@2x.png',
						'default'   => false, 
						'is_pro'   => true, 
						'subtitle' => __( 'Completely style all your Forms without a single line of css code & from One Place.', 'ultimate-addons-cf7' ),
						'demo_link' => 'https://cf7addons.com/preview/global-form-styler/', 
						'documentation_link' => 'https://themefic.com/docs/uacf7/pro-addons/global-form-styler-for-contact-form-7/',  
					),
					'uacf7_enable_multistep' => array(
						'id'        => 'uacf7_enable_multistep',
						'type'      => 'switch',
						'label'     => __( 'Multistep Form', 'ultimate-addons-cf7' ),
						'image_url' => UACF7_URL . 'assets/admin/images/addons/Multi-Step-Form@2x.png',
						'default'   => false, 
						'subtitle' => __( 'Create Stunning multi-step form with Contact form 7. Perfect for long forms. Fully responsive.', 'ultimate-addons-cf7' ),
						'demo_link' => 'https://cf7addons.com/preview/contact-form-7-multi-step-forms/', 
						'documentation_link' => 'https://themefic.com/docs/ultimate-addons-for-contact-form-7/contact-form-7-multi-step-forms/', 
					),
					'uacf7_enable_multistep_pro' => array(
						'id'        => 'uacf7_enable_multistep_pro',
						'type'      => 'switch',
						'label'     => __( 'Multi Step Form Pro Skins', 'ultimate-addons-cf7' ),
						'image_url' => UACF7_URL . 'assets/admin/images/addons/Multi-Step-Form-Pro-Skins@2x.png',
						'default'   => false, 
						'subtitle' => __( 'Premium skin for multi-step forms. Users will be able to select any design skin and it will generate a pre-design form to a contact form.', 'ultimate-addons-cf7' ),
						'demo_link' => 'https://cf7addons.com/preview/contact-form-7-multi-step-forms/pro/', 
						'documentation_link' => 'https://themefic.com/docs/ultimate-addons-for-contact-form-7/premium-skins/', 
						'is_pro' => true,
					),
					'uacf7_enable_booking_form' => array(
						'id'        => 'uacf7_enable_booking_form',
						'type'      => 'switch',
						'label'     => __( 'Booking/Appointment Form', 'ultimate-addons-cf7' ),
						'image_url' => UACF7_URL . 'assets/admin/images/addons/Booking-or-Appointment-Form@2x.png',
						'default'   => false, 
						'subtitle' => __( 'Create a booking / Appointment Form using Contact Form 7. Insert Calendar & Time. User can pay using WooCommerce.', 'ultimate-addons-cf7' ),
						'demo_link' => 'https://cf7addons.com/preview/booking-or-appointment-form-for-contact-form-7/', 
						'documentation_link' => 'https://themefic.com/docs/ultimate-addons-for-contact-form-7/booking-or-appointment-form-for-contact-form-7/', 
						'is_pro' => true,
					),
					'uacf7_enable_post_submission' => array(
						'id'        => 'uacf7_enable_post_submission',
						'type'      => 'switch',
						'label'     => __( 'Frontend Post Submission', 'ultimate-addons-cf7' ),
						'image_url' => UACF7_URL . 'assets/admin/images/addons/Frontend-Post-Submission@2x.png',
						'default'   => false, 
						'subtitle' => __( 'Submitted forms gets automatically published as a new post and display on the front end. Custom Field Supported.', 'ultimate-addons-cf7' ),
						'demo_link' => 'https://cf7addons.com/preview/contact-form-7-to-post-type/', 
						'documentation_link' => 'https://themefic.com/docs/ultimate-addons-for-contact-form-7/contact-form-7-to-post-type/', 
						'is_pro' => true,
					),
					'uacf7_enable_mailchimp' => array(
						'id'        => 'uacf7_enable_mailchimp',
						'type'      => 'switch',
						'label'     => __( 'Connect with Mailchimp', 'ultimate-addons-cf7' ),
						'image_url' => UACF7_URL . 'assets/admin/images/addons/Connect-with-Mailchimp@2x.png',
						'default'   => false, 
						'subtitle' => __( ' Integrate Contact Form 7 with Mailchimp. Automatically add your Contact Form 7 submissions to predetermined lists in Mailchimp, using Mailchimp’s latest API.', 'ultimate-addons-cf7' ),
						'demo_link' => 'https://cf7addons.com/preview/mailchimp-for-contact-form-7/', 
						'documentation_link' => 'https://themefic.com/docs/uacf7/free-addons/mailchimp-for-contact-form-7/', 
						
					),
					'uacf7_enable_database_field' => array(
						'id'        => 'uacf7_enable_database_field',
						'type'      => 'switch',
						'label'     => __( 'Save to Database ', 'ultimate-addons-cf7' ),
						'image_url' => UACF7_URL . 'assets/admin/images/addons/Save-to-Database.png',
						'default'   => false, 
						'subtitle' => __( 'Our Database addon will help you to store form data in to the database, View data in the admin backend, and Export data as CSV format.', 'ultimate-addons-cf7' ),
						'demo_link' => 'https://cf7addons.com/preview/contact-form-7-database/', 
						'documentation_link' => 'https://themefic.com/docs/uacf7/free-addons/contact-form-7-database/', 
						
					),
					'uacf7_enable_pdf_generator_field' => array(
						'id'        => 'uacf7_enable_pdf_generator_field',
						'type'      => 'switch',
						'label'     => __( 'Send PDF Using Contact form 7 ', 'ultimate-addons-cf7' ),
						'image_url' => UACF7_URL . 'assets/admin/images/addons/Send-PDF-Using-Contact-form-8.png.png',
						'default'   => false, 
						'subtitle' => __( 'It will create PDF through Contact form 7. When someone will submit the Contact form then it will generate a pdf and the pdf will send to the admin and submited mail.', 'ultimate-addons-cf7' ),
						'demo_link' => 'https://cf7addons.com/preview/contact-form-7-pdf-generator/', 
						'documentation_link' => 'https://themefic.com/docs/uacf7/free-addons/contact-form-7-pdf-generator/', 
						
					),
					'uacf7_enable_form_generator_ai_field' => array(
						'id'        => 'uacf7_enable_form_generator_ai_field',
						'type'      => 'switch',
						'label'     => __( 'Form Generator AI', 'ultimate-addons-cf7' ),
						'image_url' => UACF7_URL . 'assets/admin/images/addons/Generate-Al-Forms.png',
						'default'   => false, 
						'subtitle' => __( 'The Form Generator AI Addon streamlines the process of generating forms or tags with just a few simple steps.', 'ultimate-addons-cf7' ),
						'demo_link' => 'https://themefic.com/docs/uacf7/free-addons/ai-form-generator/', 
						'documentation_link' => 'https://themefic.com/docs/uacf7/free-addons/ai-form-generator/', 
						
					),
					'uacf7_enable_conversational_form' => array(
						'id'        => 'uacf7_enable_conversational_form',
						'type'      => 'switch',
						'label'     => __( 'Conversational Form', 'ultimate-addons-cf7' ),
						'image_url' => UACF7_URL . 'assets/admin/images/addons/Conversational-Form.png',
						'default'   => false, 
						'subtitle' => __( 'Ultimate Conversational Forms allows you to create interactive forms on your website that mimic a conversational experience, making them more engaging for users and potentially increasing conversions. This addon makes it easy to create these types of forms.', 'ultimate-addons-cf7' ),
						'demo_link' => 'https://cf7addons.com/preview/contact-form-7-conversational-form/', 
						'documentation_link' => 'https://themefic.com/docs/uacf7/pro-addons/conversational-form/', 
						'is_pro' => true,
					),
					'uacf7_enable_submission_id_field' => array(
						'id'        => 'uacf7_enable_submission_id_field',
						'type'      => 'switch',
						'label'     => __( 'Submission ID', 'ultimate-addons-cf7' ),
						'image_url' => UACF7_URL . 'assets/admin/images/addons/Unique-Submission-ID.png',
						'default'   => false, 
						'subtitle' => __( ' Our submission addon will help you to track submission data in to the database.', 'ultimate-addons-cf7' ),
						'demo_link' => 'https://cf7addons.com/preview/contact-form-7-unique-submission-id/', 
						'documentation_link' => 'https://themefic.com/docs/uacf7/free-addons/unique-submission-id/', 
						
					),
					'uacf7_enable_telegram_field' => array(
						'id'        => 'uacf7_enable_telegram_field',
						'type'      => 'switch',
						'label'     => __( 'Telegram Integration', 'ultimate-addons-cf7' ),
						'image_url' => UACF7_URL . 'assets/admin/images/addons/Telegram-Integration-1.png',
						'default'   => false, 
						'subtitle' => __( 'The Telegram integration capability allows you to forward the form submission data to Telegram.', 'ultimate-addons-cf7' ),
						'demo_link' => 'https://cf7addons.com/preview/telegram-integration-with-contact-form-7/', 
						'documentation_link' => 'https://themefic.com/docs/uacf7/free-addons/uacf7-telegram/', 
						
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
						'image_url' => UACF7_URL . 'assets/admin/images/addons/Dynamic-Text-Editor@1x-1.png',
						'default'   => false, 
						'subtitle' => __( 'Dynamic text will help you to get dynamic data from a website. You can get data in a hidden field. You can get dynamic value from current URL, blog info, current post info, current user info, and custom fields.', 'ultimate-addons-cf7' ),
						'demo_link' => 'https://cf7addons.com/preview/contact-form-7-dynamic-text-extension/', 
						'documentation_link' => 'https://themefic.com/docs/uacf7/free-addons/contact-form-7-dynamic-text-extension/', 
						
					),
					'uacf7_enable_pre_populate_field' => array(
						'id'        => 'uacf7_enable_pre_populate_field',
						'type'      => 'switch',
						'label'     => __( 'Pre-populate Field', 'ultimate-addons-cf7' ),
						'image_url' => UACF7_URL . 'assets/admin/images/addons/Woocomerce-Product-Dropdown@2x.png',
						'default'   => false, 
						'subtitle' => __( ' The pre-populate field will help you to send data from one form to another form. when you will submit the first form then the form will redirect you to another form where the first form data will be populated.', 'ultimate-addons-cf7' ),
						'demo_link' => 'https://cf7addons.com/preview/contact-form-7-pre-populate-fields/', 
						'documentation_link' => 'https://themefic.com/docs/uacf7/free-addons/contact-form-7-pre-populate-fields/', 
						
					),
					'uacf7_enable_star_rating' => array(
						'id'        => 'uacf7_enable_star_rating',
						'type'      => 'switch',
						'label'     => __( 'Star Rating', 'ultimate-addons-cf7' ),
						'image_url' => UACF7_URL . 'assets/admin/images/addons/Star-Rating-Field@2x.png',
						'default'   => false, 
						'subtitle' => __( 'Get feedback from customers for your website by adding a star rating field to your Contact form 7.', 'ultimate-addons-cf7' ),
						'demo_link' => 'https://cf7addons.com/preview/star-rating/', 
						'documentation_link' => 'https://themefic.com/docs/ultimate-addons-for-contact-form-7/star-rating-feedback/', 
						
					),
					'uacf7_enable_star_rating_pro' => array(
						'id'        => 'uacf7_enable_star_rating_pro',
						'type'      => 'switch',
						'label'     => __( 'Star Rating Field (Pro)', 'ultimate-addons-cf7' ),
						'image_url' => UACF7_URL . 'assets/admin/images/addons/Star-Rating-Field-Pro@2x.png',
						'default'   => false, 
						'subtitle' => __( 'Get 5 Built in Star Rating Styles. Do not like them? No worries. Just get any icon from Font Awesome and add them.', 'ultimate-addons-cf7' ),
						'demo_link' => 'https://cf7addons.com/preview/star-rating-pro/', 
						'documentation_link' => 'https://themefic.com/docs/ultimate-addons-for-contact-form-7/contact-form-7-star-rating-field/', 
						'is_pro' => true,
						
					),
					'uacf7_enable_range_slider' => array(
						'id'        => 'uacf7_enable_range_slider',
						'type'      => 'switch',
						'label'     => __( 'Range Slider', 'ultimate-addons-cf7' ),
						'image_url' => UACF7_URL . 'assets/admin/images/addons/Range-Slider@2x.png',
						'default'   => false, 
						'subtitle' => __( 'Add beautiful Range slider fields to Contact Form 7. Multiple Preview Layout Available.', 'ultimate-addons-cf7' ),
						'demo_link' => 'https://cf7addons.com/preview/contact-form-7-range-slider/', 
						'documentation_link' => 'https://themefic.com/docs/ultimate-addons-for-contact-form-7/contact-form-7-range-slider/', 
						
					),
					'uacf7_enable_range_slider_pro' => array(
						'id'        => 'uacf7_enable_range_slider_pro',
						'type'      => 'switch',
						'label'     => __( 'Range Slider Pro', 'ultimate-addons-cf7' ),
						'image_url' => UACF7_URL . 'assets/admin/images/addons/Range-Slider-Pro@2x.png',
						'default'   => false, 
						'subtitle' => __( 'Add beautiful Range slider fields to Contact Form 7. Select from 3 Premium pre-built Range Slider layouts.', 'ultimate-addons-cf7' ),
						'demo_link' => 'https://cf7addons.com/preview/range-slider-pro/', 
						'documentation_link' => 'https://themefic.com/docs/ultimate-addons-for-contact-form-7/contact-form-7-range-slider/', 
						'is_pro' => true,
						
					),
					'uacf7_enable_repeater_field' => array(
						'id'        => 'uacf7_enable_repeater_field',
						'type'      => 'switch',
						'label'     => __( 'Repeater Field', 'ultimate-addons-cf7' ), 
						'image_url' => UACF7_URL . 'assets/admin/images/addons/Repeater-Field@2x.png',
						'default'   => false, 
						'subtitle' => __( 'Repeater field for Contact form 7. Repeat all kinds of fields (text, files, check-boxes, text-area etc). Mail tag supported.', 'ultimate-addons-cf7' ),
						'demo_link' => 'https://cf7addons.com/preview/repeater-field-for-contact-form-7/', 
						'documentation_link' => 'https://themefic.com/docs/ultimate-addons-for-contact-form-7/repeater-field-for-contact-form-7/',  
						'is_pro' => true,
					),
					'uacf7_enable_country_dropdown_field' => array(
						'id'        => 'uacf7_enable_country_dropdown_field',
						'type'      => 'switch',
						'label'     => __( 'Country Dropdown Field', 'ultimate-addons-cf7' ),
						'image_url' => UACF7_URL . 'assets/admin/images/addons/All-Country-List-with-Flag@2x.png',
						'default'   => false, 
						'subtitle' => __( 'Add a country drop-down list with country flags. The tag field will automatically add countries name as drop-down field.', 'ultimate-addons-cf7' ),
						'demo_link' => 'https://cf7addons.com/preview/contact-form-7-country-dropdown/', 
						'documentation_link' => 'https://themefic.com/docs/uacf7/free-addons/contact-form-7-country-dropdown-with-flag/', 
						
					),
					'uacf7_enable_ip_geo_fields' => array(
						'id'        => 'uacf7_enable_ip_geo_fields',
						'type'      => 'switch',
						'label'     => __( 'IP Geo Fields (Autocomplete Country, City, State, Zip Fields)', 'ultimate-addons-cf7' ),
						'image_url' => UACF7_URL . 'assets/admin/images/addons/IP-Geolocation@2x.png',
						'default'   => false, 
						'subtitle' => __( 'This features will help you to set IP Geolocation based Auto Complete Country, City, State, Zip Fields on Contact Form 7.', 'ultimate-addons-cf7' ),
						
						'demo_link' => 'https://themefic.com/docs/ultimate-addons-for-contact-form-7/contact-form-7-autocomplete/', 
						'documentation_link' => 'https://cf7addons.com/preview/contact-form-7-autocomplete/', 
						
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
						'image_url' => UACF7_URL . 'assets/admin/images/addons/Woocomerce-Product-Dropdown@2x.png',
						'default'   => false, 
						'subtitle' => __( 'Show WooCommerce Product easily on the form with a dropdown. Customer can select and inquiry about the product.', 'ultimate-addons-cf7' ),
						'demo_link' => 'https://cf7addons.com/preview/contact-form-7-woocommerce/', 
						'documentation_link' => 'https://themefic.com/docs/uacf7/free-addons/contact-form-7-woocommerce/', 
						
						
					),
					'uacf7_enable_product_dropdown_pro' => array(
						'id'        => 'uacf7_enable_product_dropdown_pro',
						'type'      => 'switch',
						'label'     => __( 'WooCommerce Product Dropdown (Pro)', 'ultimate-addons-cf7' ),
						'image_url' => UACF7_URL . 'assets/admin/images/addons/Woo-Categorized-Product@2x.png',
						'default'   => false, 
						'subtitle' => __( ' Add specific WooCommerce Product as Dropdown. Add the Products based on Product ID. Connect with Cart/Checkout If Needed. Show product Drop-down field based on specific WooCommerce Category. Option to Show Product based on ID. Ability to choose Multiple WooCommerce Product from the Dropdown Field. Option to Show Product based on ID.', 'ultimate-addons-cf7' ),
						'demo_link' => 'https://cf7addons.com/preview/woocommerce-product-dropdown/', 
						'documentation_link' => 'https://themefic.com/docs/uacf7/free-addons/contact-form-7-woocommerce/', 
						
						
					),
					'uacf7_enable_product_auto_cart' => array(
						'id'        => 'uacf7_enable_product_auto_cart',
						'type'      => 'switch',
						'label'     => __( 'Auto Add to Cart & Checkout after Form Submission', 'ultimate-addons-cf7' ),
						'image_url' => UACF7_URL . 'assets/admin/images/addons/WooCommerce-Checkout@2x.png',
						'default'   => false, 
						'subtitle' => __( ' Select a product from Drop-down field, submit the form. Users will be redirected to a WooCommerce Cart page and product gets added to the cart automatically.', 'ultimate-addons-cf7' ),
						'demo_link' => 'https://themefic.com/docs/uacf7/pro-addons/contact-form-7-woocommerce-checkout/', 
						'documentation_link' => 'https://themefic.com/docs/uacf7/pro-addons/contact-form-7-woocommerce-checkout/', 
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
			'mailchimp' => array(
				'title'  => __( 'Mailchimp API', 'ultimate-addons-cf7' ), 
				'icon'   => 'fa fa-cog',
				'parent' => 'api_integration',
				'fields' => array(
					'uacf7_mailchimp_api_key' => array(
						'id'        => 'uacf7_mailchimp_api_key',
						'type'      => 'text',
						'label'     => __( 'Mailchimp API', 'ultimate-addons-cf7' ),  
					), 
					'uacf7_mailchimp_api_status' => array(
						'id'    => 'uacf7_mailchimp_api_status',
						'type'  => 'notice',
						'notice' => 'info', 
						'title' => __( 'To begin, you must enable the Mailchimp add-on.', 'ultimate-addons-cf7' ), 
					),
				),
			)
			
			
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

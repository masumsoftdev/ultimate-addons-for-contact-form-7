<?php
// don't load directly
defined( 'ABSPATH' ) || exit;

if ( file_exists( UACF7_PATH . 'admin/tf-options/options/tf-menu-icon.php' ) ) {

	require_once UACF7_PATH . 'admin/tf-options/options/tf-menu-icon.php';
} else {
	$menu_icon = 'dashicons-palmtree';
}
UACF7_Settings::option( 'uacf7_settings', array(
	'title' => __( 'Ultimate Addons', 'ultimate-addons-cf7' ),
	'icon' => $menu_icon,
	'position' => 25,
	'sections' =>
		apply_filters( 'uacf7_settings_options', array(
			'addons_settings' => array(
				'title' => __( 'Addons Settings', 'ultimate-addons-cf7' ),
				'icon' => 'fa fa-cog',
				'fields' => array(
				),
			),
			'general_addons' => array(
				'title' => __( 'General Addons', 'ultimate-addons-cf7' ),
				'parent' => 'addons_settings',
				'icon' => 'fa fa-cog',
				'fields' => array(
					'uacf7_enable_redirection' => array(
						'id' => 'uacf7_enable_redirection',
						'type' => 'switch',
						'label' => __( ' Redirection ', 'ultimate-addons-cf7' ),
						'image_url' => UACF7_URL . 'assets/admin/images/addons/Redirection@2x.png',
						'subtitle' => __( 'Redirect users to a Thank You or external page post form submission, with an option to open in a new tab.', 'ultimate-addons-cf7' ),
						'demo_link' => 'https://cf7addons.com/preview/redirection-for-contact-form-7/',
						'documentation_link' => 'https://themefic.com/docs/ultimate-addons-for-contact-form-7/redirection-for-contact-form-7/',
						'default' => false,

					),
					'uacf7_enable_redirection_pro' => array(
						'id' => 'uacf7_enable_redirection_pro',
						'type' => 'switch',
						'label' => __( 'Conditional Redirect + Whatsapp Integration + CF7 Tag Support ', 'ultimate-addons-cf7' ),
						'image_url' => UACF7_URL . 'assets/admin/images/addons/Conditional-Field@2x.png',
						'subtitle' => __( 'Redirect user to a URL after submission based on condition. e.g. A user goes to abc.com and B user goes to xyz.com.', 'ultimate-addons-cf7' ),
						'demo_link' => 'https://cf7addons.com/preview/conditional-redirect-for-contact-form-7/',
						'documentation_link' => 'https://themefic.com/docs/ultimate-addons-for-contact-form-7/conditional-redirect-for-contact-form-7/',
						'default' => false,
						'is_pro' => true,

					),
					'uacf7_enable_conditional_field' => array(
						'id' => 'uacf7_enable_conditional_field',
						'type' => 'switch',
						'label' => __( ' Conditional Field', 'ultimate-addons-cf7' ),
						'image_url' => UACF7_URL . 'assets/admin/images/addons/Conditional-Field@2x.png',
						'subtitle' => __( 'Show or hide Contact form 7 form fields depending on Conditional Logic. Works with Checkbox and Range Slider also.', 'ultimate-addons-cf7' ),
						'demo_link' => 'https://cf7addons.com/preview/contact-form-7-conditional-fields/',
						'documentation_link' => 'https://themefic.com/docs/ultimate-addons-for-contact-form-7/contact-form-7-conditional-fields/',
						'default' => false,

					),
					'uacf7_enable_conditional_field_pro' => array(
						'id' => 'uacf7_enable_conditional_field_pro',
						'type' => 'switch',
						'label' => __( 'Conditional Field (Pro)', 'ultimate-addons-cf7' ),
						'image_url' => UACF7_URL . 'assets/admin/images/addons/Conditional-Field@2x.png',
						'subtitle' => __( 'Utilize advanced conditional logic for range sliders, star ratings, country dropdowns, and IP geolocation in your forms.', 'ultimate-addons-cf7' ),
						'demo_link' => 'https://cf7addons.com/preview/conditional-field-pro/',
						'documentation_link' => 'https://themefic.com/docs/ultimate-addons-for-contact-form-7/contact-form-7-conditional-fields/',
						'default' => false,
						'is_pro' => true,

					),
					'uacf7_enable_field_column' => array(
						'id' => 'uacf7_enable_field_column',
						'type' => 'switch',
						'label' => __( ' Column or Grid', 'ultimate-addons-cf7' ),
						'image_url' => UACF7_URL . 'assets/admin/images/addons/Column-or-Grid-Layout@2x.png',
						'subtitle' => __( 'Create two columns, three Columns; even Four columns form with Contact form 7. Completely Responsive.', 'ultimate-addons-cf7' ),
						'demo_link' => 'https://cf7addons.com/preview/contact-form-7-columns-or-grid/',
						'documentation_link' => 'https://themefic.com/docs/ultimate-addons-for-contact-form-7/contact-form-7-columns/',
						'label_on' => __( 'Yes', 'ultimate-addons-cf7' ),
						'label_off' => __( 'No', 'ultimate-addons-cf7' ),
						'default' => false,

					),
					'uacf7_enable_field_column_pro' => array(
						'id' => 'uacf7_enable_field_column_pro',
						'type' => 'switch',
						'label' => __( 'Custom Column Width', 'ultimate-addons-cf7' ),
						'image_url' => UACF7_URL . 'assets/admin/images/addons/Conditional-Field@2x.png',
						'subtitle' => __( 'Set form column at a desired width e.g. Create three columns form with one column width of 12%, one is 27% and other 61%. ', 'ultimate-addons-cf7' ),
						'demo_link' => 'https://cf7addons.com/preview/custom-columns-for-contact-form-7/',
						'documentation_link' => 'https://themefic.com/docs/ultimate-addons-for-contact-form-7/custom-columns-for-contact-form-7/',
						'default' => false,
						'is_pro' => true,

					),
					'uacf7_enable_placeholder' => array(
						'id' => 'uacf7_enable_placeholder',
						'type' => 'switch',
						'label' => __( 'Placeholder Styling', 'ultimate-addons-cf7' ),
						'image_url' => UACF7_URL . 'assets/admin/images/addons/Placeholder-Styling@2x.png',
						'default' => false,
						'subtitle' => __( 'Effortlessly style form placeholders (like text color and background) without needing to write any CSS code.', 'ultimate-addons-cf7' ),
						'demo_link' => 'https://cf7addons.com/preview/contact-form-7-placeholder-styling/',
						'documentation_link' => 'https://themefic.com/docs/ultimate-addons-for-contact-form-7/contact-form-7-placeholder-styling/',
					),
					'uacf7_enable_uacf7style' => array(
						'id' => 'uacf7_enable_uacf7style',
						'type' => 'switch',
						'label' => __( 'Complete Form Styler', 'ultimate-addons-cf7' ),
						'image_url' => UACF7_URL . 'assets/admin/images/addons/Form-Styler@2x.png',
						'default' => false,
						'subtitle' => __( 'Completely style the whole form without a single line of css code. ex: Color, Margin, button style, font size etc.', 'ultimate-addons-cf7' ),
						'demo_link' => 'https://cf7addons.com/preview/contact-form-7-style-addon/',
						'documentation_link' => 'https://themefic.com/docs/ultimate-addons-for-contact-form-7/contact-form-7-style/',
					),
					'uacf7_enable_uacf7style_global' => array(
						'id' => 'uacf7_enable_uacf7style_global',
						'type' => 'switch',
						'label' => __( ' Global Form Styler', 'ultimate-addons-cf7' ),
						'image_url' => UACF7_URL . 'assets/admin/images/addons/Global-Form-Styler@2x.png',
						'default' => false,
						'is_pro' => true,
						'subtitle' => __( 'Style all your forms seamlessly from one place, without writing a single line of CSS code.', 'ultimate-addons-cf7' ),
						'demo_link' => 'https://cf7addons.com/preview/global-form-styler/',
						'documentation_link' => 'https://themefic.com/docs/ultimate-addons-for-contact-form-7/pro-addons/global-form-styler-for-contact-form-7/',
					),
					'uacf7_enable_multistep' => array(
						'id' => 'uacf7_enable_multistep',
						'type' => 'switch',
						'label' => __( 'Multistep Form', 'ultimate-addons-cf7' ),
						'image_url' => UACF7_URL . 'assets/admin/images/addons/Multi-Step-Form@2x.png',
						'default' => false,
						'subtitle' => __( 'Create stunning, fully responsive multi-step forms with Contact Form 7, ideal for longer forms. ', 'ultimate-addons-cf7' ),
						'demo_link' => 'https://cf7addons.com/preview/contact-form-7-multi-step-forms/',
						'documentation_link' => 'https://themefic.com/docs/ultimate-addons-for-contact-form-7/contact-form-7-multi-step-forms/',
					),
					'uacf7_enable_multistep_pro' => array(
						'id' => 'uacf7_enable_multistep_pro',
						'type' => 'switch',
						'label' => __( 'Multi Step Form Pro Skins', 'ultimate-addons-cf7' ),
						'image_url' => UACF7_URL . 'assets/admin/images/addons/Multi-Step-Form-Pro-Skins@2x.png',
						'default' => false,
						'subtitle' => __( 'Choose from premium skins for multi-step forms, easily generating pre-designed contact forms with your selected style.', 'ultimate-addons-cf7' ),
						'demo_link' => 'https://cf7addons.com/preview/contact-form-7-multi-step-forms/pro/',
						'documentation_link' => 'https://themefic.com/docs/ultimate-addons-for-contact-form-7/premium-skins/',
						'is_pro' => true,
					),
					'uacf7_enable_booking_form' => array(
						'id' => 'uacf7_enable_booking_form',
						'type' => 'switch',
						'label' => __( 'Booking/Appointment Form', 'ultimate-addons-cf7' ),
						'image_url' => UACF7_URL . 'assets/admin/images/addons/Booking-or-Appointment-Form@2x.png',
						'default' => false,
						'subtitle' => __( 'Create a booking / Appointment Form using Contact Form 7. Insert Calendar & Time. User can pay using WooCommerce.', 'ultimate-addons-cf7' ),
						'demo_link' => 'https://cf7addons.com/preview/booking-or-appointment-form-for-contact-form-7/',
						'documentation_link' => 'https://themefic.com/docs/ultimate-addons-for-contact-form-7/booking-or-appointment-form-for-contact-form-7/',
						'is_pro' => true,
					),
					'uacf7_enable_post_submission' => array(
						'id' => 'uacf7_enable_post_submission',
						'type' => 'switch',
						'label' => __( 'Frontend Post Submission', 'ultimate-addons-cf7' ),
						'image_url' => UACF7_URL . 'assets/admin/images/addons/Frontend-Post-Submission@2x.png',
						'default' => false,
						'subtitle' => __( 'Automatically publish submitted forms as new posts with custom field support, displayed on the front end. ', 'ultimate-addons-cf7' ),
						'demo_link' => 'https://cf7addons.com/preview/contact-form-7-to-post-type/',
						'documentation_link' => 'https://themefic.com/docs/ultimate-addons-for-contact-form-7/contact-form-7-to-post-type/',
						'is_pro' => true,
					),
					'uacf7_enable_mailchimp' => array(
						'id' => 'uacf7_enable_mailchimp',
						'type' => 'switch',
						'label' => __( 'Connect with Mailchimp', 'ultimate-addons-cf7' ),
						'image_url' => UACF7_URL . 'assets/admin/images/addons/Connect-with-Mailchimp@2x.png',
						'default' => false,
						'subtitle' => __( 'Easily integrate Contact Form 7 with Mailchimp; automatically sync submissions to specific lists using Mailchimp advanced API.', 'ultimate-addons-cf7' ),
						'demo_link' => 'https://cf7addons.com/preview/mailchimp-for-contact-form-7/',
						'documentation_link' => 'https://themefic.com/docs/ultimate-addons-for-contact-form-7/contact-form-7-mailchimp/',

					),
					'uacf7_enable_database_field' => array(
						'id' => 'uacf7_enable_database_field',
						'type' => 'switch',
						'label' => __( 'Save to Database ', 'ultimate-addons-cf7' ),
						'image_url' => UACF7_URL . 'assets/admin/images/addons/Save-to-Database.png',
						'default' => false,
						'subtitle' => __( 'Our Database addon will help you to store form data in to the database, View data in the admin backend, and Export data as CSV format.', 'ultimate-addons-cf7' ),
						'demo_link' => 'https://cf7addons.com/preview/contact-form-7-database/',
						'documentation_link' => 'https://themefic.com/docs/ultimate-addons-for-contact-form-7/contact-form-7-database/',

					),
					'uacf7_enable_pdf_generator_field' => array(
						'id' => 'uacf7_enable_pdf_generator_field',
						'type' => 'switch',
						'label' => __( 'Send PDF Using Contact form 7 ', 'ultimate-addons-cf7' ),
						'image_url' => UACF7_URL . 'assets/admin/images/addons/Send-PDF-Using-Contact-form-8.png',
						'default' => false,
						'subtitle' => __( "Generate a PDF from Contact Form 7 submissions, automatically sending it to both the admin and the submitter's email.", 'ultimate-addons-cf7' ),
						'demo_link' => 'https://cf7addons.com/preview/contact-form-7-pdf-generator/',
						'documentation_link' => 'https://themefic.com/docs/ultimate-addons-for-contact-form-7/contact-form-7-pdf-generator/',

					),
					'uacf7_enable_form_generator_ai_field' => array(
						'id' => 'uacf7_enable_form_generator_ai_field',
						'type' => 'switch',
						'label' => __( 'Form Generator AI', 'ultimate-addons-cf7' ),
						'image_url' => UACF7_URL . 'assets/admin/images/addons/Generate-Al-Forms.png',
						'default' => false,
						'subtitle' => __( 'Effortlessly generate forms or tags with the Form Generator AI Addon in just a few simple steps. ', 'ultimate-addons-cf7' ),
						'demo_link' => 'https://themefic.com/docs/ultimate-addons-for-contact-form-7/ai-form-generator/',
						'documentation_link' => 'https://themefic.com/docs/ultimate-addons-for-contact-form-7/ai-form-generator/',

					),
					'uacf7_enable_conversational_form' => array(
						'id' => 'uacf7_enable_conversational_form',
						'type' => 'switch',
						'label' => __( 'Conversational Form', 'ultimate-addons-cf7' ),
						'image_url' => UACF7_URL . 'assets/admin/images/addons/Conversational-Form.png',
						'default' => false,
						'subtitle' => __( 'Create engaging, conversational forms on your website with UACF7, enhancing user interaction and boosting conversions.', 'ultimate-addons-cf7' ),
						'demo_link' => 'https://cf7addons.com/preview/contact-form-7-conversational-form/',
						'documentation_link' => 'https://themefic.com/docs/ultimate-addons-for-contact-form-7/pro-addons/conversational-form/',
						'is_pro' => true,
					),
					'uacf7_enable_submission_id_field' => array(
						'id' => 'uacf7_enable_submission_id_field',
						'type' => 'switch',
						'label' => __( 'Submission ID', 'ultimate-addons-cf7' ),
						'image_url' => UACF7_URL . 'assets/admin/images/addons/Unique-Submission-ID.png',
						'default' => false,
						'subtitle' => __( 'Ultimate Addons for Contact Form 7’s Submission ID addon makes it possible to provide unique IDs to submitted forms.', 'ultimate-addons-cf7' ),
						'demo_link' => 'https://cf7addons.com/preview/contact-form-7-unique-submission-id/',
						'documentation_link' => 'https://themefic.com/docs/ultimate-addons-for-contact-form-7/unique-submission-id/',

					),
					'uacf7_enable_telegram_field' => array(
						'id' => 'uacf7_enable_telegram_field',
						'type' => 'switch',
						'label' => __( 'Telegram Integration', 'ultimate-addons-cf7' ),
						'image_url' => UACF7_URL . 'assets/admin/images/addons/Telegram-Integration-1.png',
						'default' => false,
						'subtitle' => __( 'The Telegram integration capability allows you to forward the form submission data to Telegram. ', 'ultimate-addons-cf7' ),
						'demo_link' => 'https://cf7addons.com/preview/telegram-integration-with-contact-form-7/',
						'documentation_link' => 'https://themefic.com/docs/ultimate-addons-for-contact-form-7/uacf7-telegram/',

					),

					'uacf7_enable_signature_field' => array(
						'id' => 'uacf7_enable_signature_field',
						'type' => 'switch',
						'label' => __( 'Digital Signature', 'ultimate-addons-cf7' ),
						'image_url' => UACF7_URL . 'assets/admin/images/addons/digital-signature.png',
						'default' => false,
						'subtitle' => __( 'The Signature Field Addon seamlessly integrates a digital signature feature into your Contact Form 7 form. ', 'ultimate-addons-cf7' ),
						'demo_link' => 'https://cf7addons.com/preview/create-best-digital-signature-form-with-contact-form-7/',
						'documentation_link' => 'https://themefic.com/docs/ultimate-addons-for-contact-form-7/signature-field//',

					),

					'uacf7_enable_opt_web_hook' => array(
						'id' => 'uacf7_enable_opt_web_hook',
						'type' => 'switch',
						'label' => __( 'Web Hook', 'ultimate-addons-cf7' ),
						'image_url' => UACF7_URL . 'assets/admin/images/addons/digital-signature.png',
						'default' => false,
						'subtitle' => __( 'This feature will help you to add the signature in form.', 'ultimate-addons-cf7' ),
						'demo_link' => 'https://cf7addons.com/preview/create-best-digital-signature-form-with-contact-form-7/',
						'documentation_link' => 'https://themefic.com/docs/ultimate-addons-for-contact-form-7/signature-field//',

					),
				),
			),
			'extra_fields_addons' => array(
				'title' => __( 'Extra Fields Addons', 'ultimate-addons-cf7' ),
				'parent' => 'addons_settings',
				'icon' => 'fa fa-cog',
				'fields' => array(
					'uacf7_enable_dynamic_text' => array(
						'id' => 'uacf7_enable_dynamic_text',
						'type' => 'switch',
						'label' => __( ' Dynamic Text ', 'ultimate-addons-cf7' ),
						'image_url' => UACF7_URL . 'assets/admin/images/addons/Dynamic-Text-Editor@1x-1.png',
						'default' => false,
						'subtitle' => __( 'Dynamic text captures website data dynamically, including URL, blog, post, user info, and custom fields, for hidden field integration.', 'ultimate-addons-cf7' ),
						'demo_link' => 'https://cf7addons.com/preview/contact-form-7-dynamic-text-extension/',
						'documentation_link' => 'https://themefic.com/docs/ultimate-addons-for-contact-form-7/contact-form-7-dynamic-text-extension/',

					),
					'uacf7_enable_pre_populate_field' => array(
						'id' => 'uacf7_enable_pre_populate_field',
						'type' => 'switch',
						'label' => __( 'Pre-populate Field', 'ultimate-addons-cf7' ),
						'image_url' => UACF7_URL . 'assets/admin/images/addons/Woocomerce-Product-Dropdown@2x.png',
						'default' => false,
						'subtitle' => __( ' The pre-populate field will help you to send data from one form to another form. when you will submit the first form then the form will redirect you to another form where the first form data will be populated.', 'ultimate-addons-cf7' ),
						'demo_link' => 'https://cf7addons.com/preview/contact-form-7-pre-populate-fields/',
						'documentation_link' => 'https://themefic.com/docs/ultimate-addons-for-contact-form-7/contact-form-7-pre-populate-fields/',

					),
					'uacf7_enable_star_rating' => array(
						'id' => 'uacf7_enable_star_rating',
						'type' => 'switch',
						'label' => __( 'Star Rating', 'ultimate-addons-cf7' ),
						'image_url' => UACF7_URL . 'assets/admin/images/addons/Star-Rating-Field@2x.png',
						'default' => false,
						'subtitle' => __( 'Get feedback from customers for your website by adding a star rating field to your Contact form 7. ', 'ultimate-addons-cf7' ),
						'demo_link' => 'https://cf7addons.com/preview/star-rating/',
						'documentation_link' => 'https://themefic.com/docs/ultimate-addons-for-contact-form-7/star-rating-feedback/',

					),
					'uacf7_enable_star_rating_pro' => array(
						'id' => 'uacf7_enable_star_rating_pro',
						'type' => 'switch',
						'label' => __( 'Star Rating Field (Pro)', 'ultimate-addons-cf7' ),
						'image_url' => UACF7_URL . 'assets/admin/images/addons/Star-Rating-Field-Pro@2x.png',
						'default' => false,
						'subtitle' => __( "Get 5 Built in Star Rating Styles. Don't  like them? No worries. Just get any icon from Font Awesome and add them.", 'ultimate-addons-cf7' ),
						'demo_link' => 'https://cf7addons.com/preview/star-rating-pro/',
						'documentation_link' => 'https://themefic.com/docs/ultimate-addons-for-contact-form-7/contact-form-7-star-rating-field/',
						'is_pro' => true,

					),
					'uacf7_enable_range_slider' => array(
						'id' => 'uacf7_enable_range_slider',
						'type' => 'switch',
						'label' => __( 'Range Slider', 'ultimate-addons-cf7' ),
						'image_url' => UACF7_URL . 'assets/admin/images/addons/Range-Slider@2x.png',
						'default' => false,
						'subtitle' => __( 'Easily set up a numeric range slider with minimum and maximum values in CF7 for your WordPress site using the Range Slider addon.', 'ultimate-addons-cf7' ),
						'demo_link' => 'https://cf7addons.com/preview/contact-form-7-range-slider/',
						'documentation_link' => 'https://themefic.com/docs/ultimate-addons-for-contact-form-7/contact-form-7-range-slider/',

					),
					'uacf7_enable_range_slider_pro' => array(
						'id' => 'uacf7_enable_range_slider_pro',
						'type' => 'switch',
						'label' => __( 'Range Slider Pro', 'ultimate-addons-cf7' ),
						'image_url' => UACF7_URL . 'assets/admin/images/addons/Range-Slider-Pro@2x.png',
						'default' => false,
						'subtitle' => __( 'Add beautiful Range slider fields to Contact Form 7. Select from 3 Premium pre-built Range Slider layouts.', 'ultimate-addons-cf7' ),
						'demo_link' => 'https://cf7addons.com/preview/range-slider-pro/',
						'documentation_link' => 'https://themefic.com/docs/ultimate-addons-for-contact-form-7/contact-form-7-range-slider/',
						'is_pro' => true,

					),
					'uacf7_enable_repeater_field' => array(
						'id' => 'uacf7_enable_repeater_field',
						'type' => 'switch',
						'label' => __( 'Repeater Field', 'ultimate-addons-cf7' ),
						'image_url' => UACF7_URL . 'assets/admin/images/addons/Repeater-Field@2x.png',
						'default' => false,
						'subtitle' => __( 'Repeater field for Contact form 7. Repeat all kinds of fields (text, files, check-boxes, text-area etc). Mail tag supported.', 'ultimate-addons-cf7' ),
						'demo_link' => 'https://cf7addons.com/preview/repeater-field-for-contact-form-7/',
						'documentation_link' => 'https://themefic.com/docs/ultimate-addons-for-contact-form-7/contact-form-7-repeatable-fields/',
						'is_pro' => true,
					),
					'uacf7_enable_country_dropdown_field' => array(
						'id' => 'uacf7_enable_country_dropdown_field',
						'type' => 'switch',
						'label' => __( 'Country Dropdown Field', 'ultimate-addons-cf7' ),
						'image_url' => UACF7_URL . 'assets/admin/images/addons/All-Country-List-with-Flag@2x.png',
						'default' => false,
						'subtitle' => __( 'Add a country drop-down list with country flags. The tag field will automatically add countries name as drop-down field.', 'ultimate-addons-cf7' ),
						'demo_link' => 'https://cf7addons.com/preview/contact-form-7-country-dropdown/',
						'documentation_link' => 'https://themefic.com/docs/ultimate-addons-for-contact-form-7/contact-form-7-country-dropdown-with-flag/',

					),
					'uacf7_enable_ip_geo_fields' => array(
						'id' => 'uacf7_enable_ip_geo_fields',
						'type' => 'switch',
						'label' => __( 'IP Geo Fields (Autocomplete Country, City, State, Zip Fields)', 'ultimate-addons-cf7' ),
						'image_url' => UACF7_URL . 'assets/admin/images/addons/IP-Geolocation@2x.png',
						'default' => false,
						'subtitle' => __( 'Set IP geolocation-based auto-completion for country, city, state, and zip fields in Contact Form 7.', 'ultimate-addons-cf7' ),

						'demo_link' => 'https://themefic.com/docs/ultimate-addons-for-contact-form-7/contact-form-7-autocomplete/',
						'documentation_link' => 'https://cf7addons.com/preview/contact-form-7-autocomplete/',

						'is_pro' => true,
					),
				),
			),
			'wooCommerce_integration' => array(
				'title' => __( 'WooCommerce Integration', 'ultimate-addons-cf7' ),
				'parent' => 'addons_settings',
				'icon' => 'fa fa-cog',
				'fields' => array(
					'uacf7_enable_product_dropdown' => array(
						'id' => 'uacf7_enable_product_dropdown',
						'type' => 'switch',
						'label' => __( 'WooCommerce Product Dropdown', 'ultimate-addons-cf7' ),
						'image_url' => UACF7_URL . 'assets/admin/images/addons/Woocomerce-Product-Dropdown@2x.png',
						'default' => false,
						'subtitle' => __( 'Show WooCommerce Product easily on the form with a dropdown. Customer can select and inquiry about the product.', 'ultimate-addons-cf7' ),
						'demo_link' => 'https://cf7addons.com/preview/contact-form-7-woocommerce/',
						'documentation_link' => 'https://themefic.com/docs/ultimate-addons-for-contact-form-7/contact-form-7-woocommerce/',


					),
					'uacf7_enable_product_dropdown_pro' => array(
						'id' => 'uacf7_enable_product_dropdown_pro',
						'type' => 'switch',
						'label' => __( 'WooCommerce Product Dropdown (Pro)', 'ultimate-addons-cf7' ),
						'image_url' => UACF7_URL . 'assets/admin/images/addons/Woo-Categorized-Product@2x.png',
						'default' => false,
						'is_pro' => true,
						'subtitle' => __( 'Add specific WooCommerce Product as Dropdown. Add the Products based on Product ID. Connect with Cart/Checkout If Needed.', 'ultimate-addons-cf7' ),
						'demo_link' => 'https://cf7addons.com/preview/woocommerce-product-dropdown/',
						'documentation_link' => 'https://themefic.com/docs/ultimate-addons-for-contact-form-7/contact-form-7-woocommerce/',


					),
					'uacf7_enable_product_auto_cart' => array(
						'id' => 'uacf7_enable_product_auto_cart',
						'type' => 'switch',
						'label' => __( 'Auto Add to Cart & Checkout after Form Submission', 'ultimate-addons-cf7' ),
						'image_url' => UACF7_URL . 'assets/admin/images/addons/WooCommerce-Checkout@2x.png',
						'default' => false,
						'subtitle' => __( ' Effortlessly select a product, submit, and get redirected to WooCommerce with the item automatically added to your cart.', 'ultimate-addons-cf7' ),
						'demo_link' => 'https://themefic.com/docs/ultimate-addons-for-contact-form-7/pro-addons/contact-form-7-woocommerce-checkout/',
						'documentation_link' => 'https://themefic.com/docs/ultimate-addons-for-contact-form-7/pro-addons/contact-form-7-woocommerce-checkout/',
						'is_pro' => true,
					),
				),
			),
			'api_integration' => array(
				'title' => __( 'API Integration', 'ultimate-addons-cf7' ),
				'icon' => 'fa fa-cog',
				'fields' => array(

				),
			),
			'mailchimp' => array(
				'title' => __( 'Mailchimp API', 'ultimate-addons-cf7' ),
				'icon' => 'fa fa-cog',
				'parent' => 'api_integration',
				'fields' => array(
					'uacf7_mailchimp_api_key' => array(
						'id' => 'uacf7_mailchimp_api_key',
						'type' => 'text',
						'label' => __( 'Mailchimp API', 'ultimate-addons-cf7' ),
					),
					'uacf7_mailchimp_api_status' => array(
						'id' => 'uacf7_mailchimp_api_status',
						'type' => 'notice',
						'notice' => 'info',
						'title' => __( 'To begin, you must enable the Mailchimp add-on.', 'ultimate-addons-cf7' ),
					),
				),
			),


			/**
			 * Import/Export
			 *
			 * Main menu
			 */
			'uacf7_import_export_data' => array(
				'title' => __( 'Import/Export', 'ultimate-addons-cf7' ),
				'icon' => 'fa fa-cog',
				'fields' => array(
				),
			),
			'uacf7_import_export' => array(
				'title' => __( 'Import/Export', 'ultimate-addons-cf7' ),
				'parent' => 'uacf7_import_export_data',
				'icon' => 'fas fa-hdd',
				'fields' => array(
					'uacf7_import_export_backup' => array(
						'id' => 'uacf7_import_export_backup',
						'type' => 'backup',
					),

				),
			),
		),
		)
) );

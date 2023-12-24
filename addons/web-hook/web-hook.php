<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class UACF7_WEB_HOOK {

	/*
	 * Construct function
	 */
	public function __construct() {
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_webhook_style' ) );
		// add_filter( 'wpcf7_contact_form_properties', array( $this, 'uacf7_properties' ), 10, 2 );
		add_filter( 'uacf7_post_meta_options', array( $this, 'uacf7_post_meta_options_placeholder' ), 12, 2 );

		add_action( 'wpcf7_before_send_mail', array( $this, 'uacf7_send_data_by_web_hook' ) );
	}


	public function enqueue_webhook_style() {
		wp_enqueue_style( 'uacf7-web-hook', UACF7_ADDONS . '/web-hook/css/web-hook.css' );
		wp_enqueue_script( 'uacf7-web-hook-script', UACF7_ADDONS . '/web-hook/js/web-hook.js', array( 'jquery' ), '', true );
	}

	// Add Placeholder Options
	public function uacf7_post_meta_options_placeholder( $value, $post_id ) {

		// $form_id = $_POST['form_id'];
		// $ContactForm = WPCF7_ContactForm::get_instance( $form_id );
		// $tags = $ContactForm->scan_form_tags();
		// $wpcf7 = WPCF7_ContactForm::get_current();
		// $submission = WPCF7_Submission::get_instance();

		// var_dump($post_id);

		$WebHook = apply_filters( 'uacf7_post_meta_options_placeholder_pro', $data = array(
			'title' => __( 'Web Hook', 'ultimate-addons-cf7' ),
			'icon' => 'fa-solid fa-italic',
			'fields' => [
				'uacf7_Web_hook_headding' => [
					'id' => 'uacf7_web_hook_headding',
					'type' => 'notice',
					'notice' => 'info',
					'label' => __( 'Web Hook', 'ultimate-addons-cf7' ),
					'title' => __( 'This addon will help you to add the web hook of your form. Note that, all below fields are optional. If any field is not needed, leave them blank.', 'ultimate-addons-cf7' ),
					'content' => sprintf(
						__( 'Not sure how to set this? Check our step by step  %1s.', 'ultimate-addons-cf7' ),
						'<a href="https://themefic.com/docs/uacf7/free-addons/contact-form-7-placeholder-styling/" target="_blank">documentation</a>'
					)
				],
				'uacf7_enable_web_hook' => [
					'id' => 'uacf7_enable_web_hook',
					'type' => 'switch',
					'label' => __( ' Enable Web Hook ', 'ultimate-addons-cf7' ),
					'label_on' => __( 'Yes', 'ultimate-addons-cf7' ),
					'label_off' => __( 'No', 'ultimate-addons-cf7' ),
					'default' => false
				],

				'uacf7_web_hook_init' => [ 
					'id' => 'uacf7_web_hook_init',
					'class' => 'uacf7_web_hook_field_group',
					'type' => 'fieldset',
					'label' => __( 'Setup Your Web Hook', 'ultimate-addons-cf7' ),
					'subtitle' => __( 'Here you can configure all your settings', 'ultimate-addons-cf7' ),
					'dependency' => [ 'uacf7_enable_web_hook', '==', 1 ],
					'fields' => [

						'uacf7_web_hook_api' => [
							'id'	=> 'uacf7_web_hook_api',
							'type'	=> 'text',
							'label'	=> __('Request URL', 'ultimate-addons-cf7'),
							'placeholder'=> __('Enter a Request URL', 'ultimate-addons-cf7'),
						],

						'uacf7_web_hook_api_secret' => [
							'id' => 'uacf7_web_hook_api_secret',
							'type' => 'text',
							'label' => __( 'Secrct', 'ultimate-addons-cf7' ),
							'subtitle' => __( "API key value or Secrct value", "ultimate-addons-cf7" ),
							'placeholder' => __( 'Enter a key value', 'ultimate-addons-cf7' ),
							'field_width' => 70,
						],

						'uacf7_web_hook_request_method' => [
							'id' => 'uacf7_web_hook_request_method',
							'type' => 'select',
							'label' => __( 'Request Method', 'ultimate-addons-cf7' ),
							'options' 	=> array(
								'get' 		=> 'get',
								'post' 		=> 'post',
								'put' 		=> 'put',
								'delete' 	=> 'delete',
								'patch' 	=> 'patch',
							),
							'field_width' => 30,
						],

						'uacf7_web_hook_request_format' => [
							'id' => 'uacf7_web_hook_request_format',
							'type' => 'select',
							'label' => __( 'Request Format', 'ultimate-addons-cf7' ),
							'options' 	=> array(
								'json' 		=> 'JSON',
								'formdata' 		=> 'FORMDATA',
							),
							'field_width' => 30,
						],

						'uacf7_web_hook_header_request' => [
							'id'	=> 'uacf7_web_hook_header_request',
							'type'	=> 'repeater',
							'label' => __( 'Request Headers', 'ultimate-addons-cf7' ),
							'fields' => [
								'uacf7_web_hook_header_request_value' => [
									'id' => 'uacf7_web_hook_header_request_value',
									'type' => 'text',
									'placeholder' => __( 'Enter a parameter key', 'ultimate-addons-cf7' ),
									'field_width' => 50,
								],

								'uacf7_web_hook_header_request_parameter' => [
									'id' => 'uacf7_web_hook_header_request_parameter',
									'type' => 'select',
									// 'label' => __( 'Request Format', 'ultimate-addons-cf7' ),
									'options' => 'uacf7',
									'query_args' => array(
										'post_id' => $post_id,
										'exclude' => [ 'submit', 'conditional' ],
									),
									'field_width' => 50,
								],
							]

						],

						'uacf7_web_hook_body_request' => [
							'id'	=> 'uacf7_web_hook_body_request',
							'type'	=> 'repeater',
							'label' => __( 'Request Body', 'ultimate-addons-cf7' ),
							'fields' => [
								'uacf7_web_hook_body_request_value' => [
									'id' => 'uacf7_web_hook_body_request_value',
									'type' => 'text',
									'placeholder' => __( 'Enter a parameter key', 'ultimate-addons-cf7' ),
									'field_width' => 50,
								],

								'uacf7_web_hook_body_request_parameter' => [
									'id' => 'uacf7_web_hook_body_request_parameter',
									'type' => 'select',
									// 'label' => __( 'Request Format', 'ultimate-addons-cf7' ),
									'options' => 'uacf7',
									'query_args' => array(
										'post_id' => $post_id,
										'exclude' => [ 'submit', 'conditional' ],
									),
									'field_width' => 50,
								],
							]

						]

						

					]
				]
			],
		), $post_id );

		$value['Web_hook'] = $WebHook;
		return $value;
	}


	public function uacf7_properties( $properties, $cfform ) {

		if ( ! is_admin() || ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {

			$form = $properties['form'];

			$form_meta = uacf7_get_form_option( $cfform->id(), 'placeholder' );

			$placeholder_styles = isset( $form_meta['uacf7_enable_placeholder_styles'] ) ? $form_meta['uacf7_enable_placeholder_styles'] : false;

			if ( $placeholder_styles == true ) :

				ob_start();

				$fontfamily = $form_meta['uacf7_placeholder_fontfamily'];
				$fontsize = $form_meta['uacf7_placeholder_fontsize'];
				$fontstyle = $form_meta['uacf7_placeholder_fontstyle'];
				$fontweight = $form_meta['uacf7_placeholder_fontweight'];
				$color = isset( $form_meta['uacf7_placeholder_color_option'] ) ? $form_meta['uacf7_placeholder_color_option']['uacf7_placeholder_color'] : '';
				$background_color = isset( $form_meta['uacf7_placeholder_color_option'] ) ? $form_meta['uacf7_placeholder_color_option']['uacf7_placeholder_background_color'] : '';
				?>
				<style>
					.uacf7-form-

					<?php esc_attr_e( $cfform->id() ); ?>
					::placeholder {
						color:
							<?php echo esc_attr_e( $color ); ?>
						;
						background-color:
							<?php echo esc_attr_e( $background_color ); ?>
						;
						font-size:
							<?php echo esc_attr_e( $fontsize ) . 'px'; ?>
						;
						font-family:
							<?php echo esc_attr_e( $fontfamily ); ?>
						;
						font-style:
							<?php echo esc_attr_e( $fontstyle ); ?>
						;
						font-weight:
							<?php echo esc_attr_e( $fontweight ); ?>
						;
					}

					.uacf7-form-

					<?php esc_attr_e( $cfform->id() ); ?>
					::-webkit-input-placeholder {
						/* Edge */
						color:
							<?php echo esc_attr_e( $color ); ?>
						;
						background-color:
							<?php echo esc_attr_e( $background_color ); ?>
						;
						font-size:
							<?php echo esc_attr_e( $fontsize ) . 'px'; ?>
						;
						font-family:
							<?php echo esc_attr_e( $fontfamily ); ?>
						;
						font-style:
							<?php echo esc_attr_e( $fontstyle ); ?>
						;
						font-weight:
							<?php echo esc_attr_e( $fontweight ); ?>
						;
					}

					.uacf7-form-

					<?php esc_attr_e( $cfform->id() ); ?>
					:-ms-input-placeholder {
						/* Internet Explorer 10-11 */
						color:
							<?php echo esc_attr_e( $color ); ?>
						;
						background-color:
							<?php echo esc_attr_e( $background_color ); ?>
						;
						font-size:
							<?php echo esc_attr_e( $fontsize ) . 'px'; ?>
						;
						font-family:
							<?php echo esc_attr_e( $fontfamily ); ?>
						;
						font-style:
							<?php echo esc_attr_e( $fontstyle ); ?>
						;
						font-weight:
							<?php echo esc_attr_e( $fontweight ); ?>
						;
					}
				</style>
				<?php
				echo $form;
				$properties['form'] = ob_get_clean();

			endif;
		}

		return $properties;
	}

	public function uacf7_send_data_by_web_hook($form){

		$submission = WPCF7_Submission::get_instance();
		$ContactForm = WPCF7_ContactForm::get_instance( $form->id() );

		$contact_form_data = $submission->get_posted_data();
		$tags = $ContactForm->scan_form_tags();

		var_dump($contact_form_data);
		var_dump($tags);

		// die();
		$api_endpoint = '';
		$request_method = '';

		// Define the data to send in the POST request
		$post_data = array(
			// Add other fields as needed
			'from tags' => 'value',
			'from tags' => 'value',
		);

		// Set up the request arguments
		$request_args = array(
			'body' => json_encode($post_data),
			'headers' => array(
				'Content-Type' => 'application/json',
				//Need loop for additional input
			),
			'method' => $request_method,
		);

		// Make the POST request
		// $response = wp_remote_request($api_endpoint, $request_args);

		// // Check if the request was successful
		// if (is_wp_error($response)) {
		// 	// Handle error
		// 	echo 'Error: ' . $response->get_error_message();
		// } else {
		// 	// Request was successful, and $response contains the API response
		// 	$api_response = wp_remote_retrieve_body($response);
		// 	echo 'API Response: ' . $api_response;
		// }
	}

}
new UACF7_WEB_HOOK();
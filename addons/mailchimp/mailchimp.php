<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
class UACF7_MAILCHIMP {

	public $mailchimlConnection = '';
	public static $mailchimp = null;
	private $mailchimp_api = '';

	public function __construct() {
		require_once( 'inc/functions.php' );
		add_action( "wpcf7_before_send_mail", array( $this, 'send_data' ) );
		add_filter( 'uacf7_post_meta_options', array( $this, 'uacf7_post_meta_options_mailchimp' ), 17, 2 );
		add_filter( 'uacf7_settings_options', array( $this, 'uacf7_settings_options_mailchimp' ), 17, 2 );
		add_action( 'admin_enqueue_scripts', array( $this, 'wp_enqueue_admin_script' ) );
		add_action( 'wp_ajax_uacf7_ajax_mailchimp', array( $this, 'uacf7_ajax_mailchimp' ) );

		// Form tag ShortCodes
		add_action( 'wpcf7_init', array( $this, 'add_shortcodes' ) );
		// Tag Generator 
		add_action( 'admin_init', array( $this, 'tag_generator' ) );
		// Tag Validation
		add_filter( 'wpcf7_validate_uacf7_mailchimp_acceptance', array( $this, 'uacf7_mailchimp_checkbox_validation_filter' ), 10, 2 );
		add_filter( 'wpcf7_validate_uacf7_mailchimp_acceptance*', array( $this, 'uacf7_mailchimp_checkbox_validation_filter' ), 10, 2 );

		add_filter( 'wpcf7_load_js', '__return_false' );


		$this->get_api_key();

		require_once( 'inc/functions.php' );
	}

	/**
	 * Form tag ShortCode
	 * @param array $options
	 * @return array
	 * @since 1.7.2
	 */
	public function add_shortcodes() {
		wpcf7_add_form_tag( [ 'uacf7_mailchimp_acceptance', 'uacf7_mailchimp_acceptance*' ],
			[ $this, 'tag_handler_callback' ], [ 'name-attr' => true ] );
	}

	/**
	 * Form tag ShortCode Call back handler
	 * @return array
	 * @since 1.7.2
	 */
	public function tag_handler_callback( $tag ) {

		if ( empty( $tag->name ) ) {
			return '';
		}

		$validation_error = wpcf7_get_validation_error( $tag->name );
		$class = wpcf7_form_controls_class( $tag->type );

		if ( $validation_error ) {
			$class .= ' wpcf7-not-valid';
		}

		$atts = array();

		if ( in_array( 'checked', $tag->options ) ) {
			$atts['checked'] = 'checked';
		}
		$atts[''] = $tag->get_class_option( $class );
		$atts['class'] = $tag->get_class_option( $class );
		$atts['id'] = $tag->get_id_option();
		$atts['tabindex'] = $tag->get_option( 'tabindex', 'signed_int', true );

		if ( $tag->is_required() ) {
			$atts['aria-required'] = 'true';
		}

		$atts['aria-invalid'] = $validation_error ? 'true' : 'false';

		$atts['name'] = $tag->name;

		$size = $tag->get_option( 'size', 'int', true );

		if ( $size ) {
			$atts['size'] = $size;
		}

		$value = ! empty( $tag->get_option( 'value', '', true ) ) ? $tag->get_option( 'value', '', true ) : '1';
		$checked = ( in_array( 'checked', $tag->options ) ) ? 'checked' : '';

		$mailchimp_attr = apply_filters( 'uacf7_get_country_attr', $atts, $tag );
		$atts = wpcf7_format_atts( $mailchimp_attr );

		ob_start(); ?>

		<span class="wpcf7-form-control-wrap" data-name="<?php echo esc_attr( $tag->name ) ?>" style="display: inline-block;">
			<span <?php echo esc_attr( $atts ) ?>>
				<span class=" wpcf7-list-item first last">
					<input class="<?php echo esc_attr( $tag->get_class_option( $class ) ) ?>" type="checkbox" <?php echo esc_attr( $checked ) ?> name="<?php echo esc_attr( $tag->name ) ?>"
						value="<?php echo esc_attr( $value ) ?>">
				</span>
			</span>
		</span>

		<?php
		return ob_get_clean();
	}

	/**
	 * Form tag generator
	 * @since 1.7.2
	 */
	public function tag_generator() {
		if ( ! function_exists( 'wpcf7_add_tag_generator' ) )
			return;

		wpcf7_add_tag_generator( 'uacf7_mailchimp_acceptance',
			__( 'Mailchimp Acceptance', 'ultimate-addons-cf7' ),
			'uacf7-tg-pane-step',
			array( $this, 'tg_panel_mailchimp_subscribe_checkbox' )
		);

	}

	/**
	 * Mailchimp Subscribe Checkbox Tag Generator Panel
	 * @since 1.7.2
	 */
	public function tg_panel_mailchimp_subscribe_checkbox( $contact_form, $args = '' ) {
		$args = wp_parse_args( $args, array() );
		$uacf7_field_type = 'uacf7_mailchimp_acceptance';

		?>
		<div class="control-box">
			<fieldset>
				<div class="uacf7-doc-notice">
					<?php echo sprintf(
						__( 'Not sure how to set this? Check our step by step %1s.', 'ultimate-addons-cf7' ),
						'<a href="https://themefic.com/docs/uacf7/free-addons/contact-form-7-star-rating-field/" target="_blank">documentation</a>'
					); ?>
				</div>
				<table class="form-table">
					<tbody>
						<tr>
							<th scope="row"><?php _e( 'Field Type', 'ultimate-addons-cf7' ); ?></th>
							<td>
								<fieldset>
									<legend class="screen-reader-text"><?php _e( 'Field Type', 'ultimate-addons-cf7' ); ?>
									</legend>
									<label><input type="checkbox" name="required"
											value="on"><?php _e( 'Required Field', 'ultimate-addons-cf7' ); ?></label>
								</fieldset>
							</td>
						</tr>
						<tr>
							<th scope="row"><?php _e( 'Name', 'ultimate-addons-cf7' ); ?></th>
							<td>
								<fieldset>
									<legend class="screen-reader-text"><?php _e( 'Name', 'ultimate-addons-cf7' ); ?></legend>
									<label><input id="tag-generator-panel-text-name" class="tg-name oneline" name="name"
											type="text"></label>
								</fieldset>
							</td>
						</tr>
						<tr>
							<th scope="row"></th>
							<td>
								<fieldset>
									<legend class="screen-reader-text">
										<?php _e( 'Make checked by default', 'ultimate-addons-cf7' ); ?>
									</legend>
									<label><input class="option" type="checkbox" name="checked"
											value="on"><?php _e( 'Make checked by default', 'ultimate-addons-cf7' ); ?></label>
								</fieldset>
							</td>
						</tr>

					</tbody>
				</table>

			</fieldset>
		</div>

		<div class="insert-box">
			<input type="text" name="<?php echo esc_attr( $uacf7_field_type ); ?>" class="tag code" readonly="readonly"
				onfocus="this.select()" />

			<div class="submitbox">
				<input type="button" class="button button-primary insert-tag"
					value="<?php echo esc_attr( __( 'Insert Tag', 'ultimate-addons-cf7' ) ); ?>" />
			</div>
		</div>
		<?php
	}

	/**
	 * Tag Validation
	 * @since 1.7.2
	 */
	public function uacf7_mailchimp_checkbox_validation_filter( $result, $tag ) {
		$name = $tag->name;

		if ( isset( $_POST[ $name ] )
			and is_array( $_POST[ $name ] ) ) {
			foreach ( $_POST[ $name ] as $key => $value ) {
				if ( '' === $value ) {
					unset( $_POST[ $name ][ $key ] );
				}
			}
		}

		$empty = ! isset( $_POST[ $name ] ) || empty( $_POST[ $name ] ) && '0' !== $_POST[ $name ];

		if ( $tag->is_required() and $empty ) {
			$result->invalidate( $tag, wpcf7_get_message( 'invalid_required' ) );
		}

		return $result;
	}

	/**
	 * Check if this checked or not
	 * @since 1.7.2
	 */
	public function uacf7_mailchimp_subscribe_checkbox_status( $wpcf, $posted_data ) {

		$tags = $wpcf->get_contact_form()->scan_form_tags();
		$tag_name = '';
		foreach ( $tags as $tag ) {
			if ( $tag->basetype == 'uacf7_mailchimp_acceptance' ) {
				$tag_name = $tag->name;
			}
		}

		if ( $tag_name != '' && isset( $posted_data[ $tag_name ] ) && $posted_data[ $tag_name ] != '' ) {
			$status = true;
		} else {
			$status = false;
		}


		return $status;
	}


	/*
	 * Enqueue script Backend
	 */

	public function wp_enqueue_admin_script() {
		wp_enqueue_script( 'mailchimp_admin', UACF7_ADDONS . '/mailchimp/assets/js/mailchimp_admin.js', array( 'jquery' ), null, true );
		wp_localize_script(
			'mailchimp_admin',
			'mailchimp_peram',
			array(
				'admin_url' => get_admin_url() . 'admin.php',
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				'plugin_dir_url' => plugin_dir_url( __FILE__ ),
				'nonce' => wp_create_nonce( 'uacf7_mailchimp_admin_nonce' ),
			)
		);
	}

	public function uacf7_ajax_mailchimp() {
		// Capability check
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( 'You do not have permission to perform this action.' );
			wp_die(); // Terminate execution
		}

		// Verify nonce
		if ( ! isset( $_POST['ajax_nonce'] ) || ! wp_verify_nonce( $_POST['ajax_nonce'], 'uacf7_mailchimp_admin_nonce' ) ) {
			wp_send_json_error( esc_html__( "Security error", 'ultimate-addons-cf7' ) );
			wp_die(); // Terminate execution
		}

		// Check if POST data is set and not empty
		if ( empty( $_POST['inputKey'] ) ) {
			wp_send_json_error( 'No API key provided.' );
			wp_die(); // Terminate execution
		}

		$uacf7_mailchimp_api_key = sanitize_text_field( $_POST['inputKey'] );

		if ( $uacf7_mailchimp_api_key ) {
			$api_key = $uacf7_mailchimp_api_key;
		}

		$status = '';
		if ( $api_key != '' ) {

			$response = $this->set_config( $api_key, 'ping' );
			$response = json_decode( $response );

			if ( $response !== null ) {
				$status .= '<span class="status-title"><strong>' . esc_html__( 'Status: ', 'ultimate-addons-cf7' ) . '</strong>';

				if ( $this->is_internet_connected() == false ) { //Checking internet connection
					$status .= '<span class="status-error">' . esc_html__( 'Can\'t connect to the server. Please check internet connection.', 'ultimate-addons-cf7' ) . '</span>';
				}

				if ( isset( $response->health_status ) ) { //Display success message
					$status .= '<span class="status-success">' . esc_html( $response->health_status, 'ultimate-addons-cf7' ) . '</span>';
				}

				if ( isset( $response->title ) ) { //Display error title
					$status .= '<span class="status-error">' . esc_html( $response->title, 'ultimate-addons-cf7' ) . '</span>';
				}

				$status .= '</span>';

				if ( isset( $response->detail ) ) { //Display error mdetails
					$status .= '<span class="status-details status-error">' . esc_html( $response->detail, 'ultimate-addons-cf7' ) . '</span>';
				}
			} else {
				$status .= '<span class="status-error">' . esc_html( 'Not Connected! invalid API Key', 'ultimate-addons-cf7' ) . '</span>';
			}

		} else {
			$status .= '<span class="status-error">' . esc_html( 'Empty! Please fill the API key', 'ultimate-addons-cf7' ) . '</span>';
		}

		// Send response back to the AJAX request
		wp_send_json_success(
			array(
				'status' => $status,
				'res' => $response
			)
		);

		wp_die(); // Terminate execution
	}

	function uacf7_settings_options_mailchimp( $value ) {
		$status = $this->connection_status();
		$value['mailchimp']['fields']['uacf7_mailchimp_api_status'] = array(
			'id' => 'uacf7_mailchimp_api_status',
			'type' => 'callback',
			'function' => 'uacf7_mailchimp_api_status_callback',
			'argument' => $status,

		);
		return $value;
	}

	public function uacf7_post_meta_options_mailchimp( $value, $post_id ) {
		$status = $this->connection_status();

		//get audience
		$api_key = $this->mailchimp_api;
		$audience = array();
		if ( $api_key != '' ) {

			$response = $this->set_config( $api_key, 'lists' );

			$response = json_decode( $response, true );
			$x = 0;
			if ( isset( $response['lists'] ) && $response != null ) {
				foreach ( $response['lists'] as $list ) {
					$audience[ $list['id'] ] = $list['name'];
					$x++;
				}
			}

		}

		$mailchimp = apply_filters( 'uacf7_post_meta_options_mailchimp_pro', $data = array(
			'title' => __( 'Mailchimp', 'ultimate-addons-cf7' ),
			'icon' => 'fa-brands fa-mailchimp',
			'checked_field' => 'uacf7_mailchimp_form_enable',
			'fields' => array(
				'uacf7_mailchimp_label' => array(
					'id' => 'uacf7_mailchimp_label',
					'type' => 'heading',
					'label' => __( 'Mailchimp Integration', 'ultimate-addons-cf7' ),
					'subtitle' => sprintf(
						__( 'Send form submissions to your Mailchimp lists automatically. See Demo %1s.', 'ultimate-addons-cf7' ),
						'<a href="https://cf7addons.com/preview/mailchimp-for-contact-form-7/" target="_blank" rel="noopener">Example</a>'
					)
				),
				'mailchimp_docs' => array(
					'id' => 'mailchimp_docs',
					'type' => 'notice',
					'style' => 'success',
					'content' => sprintf(
						__( 'Confused? Check our Documentation on  %1s.', 'ultimate-addons-cf7' ),
						'<a href="https://themefic.com/docs/uacf7/free-addons/contact-form-7-mailchimp/" target="_blank" rel="noopener">Mailchimp Integration</a>'
					)
				),
				'uacf7_mailchimp_form_enable' => array(
					'id' => 'uacf7_mailchimp_form_enable',
					'type' => 'switch',
					'label' => __( ' Enable Mailchimp ', 'ultimate-addons-cf7' ),
					'label_on' => __( 'Yes', 'ultimate-addons-cf7' ),
					'label_off' => __( 'No', 'ultimate-addons-cf7' ),
					'field_width' => '50',
					'subtitle' => sprintf(
						__( 'Before enabling, ensure you have added your Mailchimp API key %1s.', 'ultimate-addons-cf7' ),
						'<a href="admin.php?page=uacf7_settings#tab=mailchimp" target="_blank" rel="noopener">here</a>'
					),
					'default' => false
				),
				'uacf7_mailchimp_form_options_heading' => array(
					'id' => 'uacf7_mailchimp_form_options_heading',
					'type' => 'heading',
					'label' => __( 'Mailchimp Option ', 'ultimate-addons-cf7' ),
				),

				'mailchimp_uacf7_help' => array(
					'id' => 'mailchimp_uacf7_help',
					'type' => 'notice',
					'style' => 'success',
					'content' => sprintf(
						__( 'Note: If you dont see the field names in the field selection, please save the form and try again.', 'ultimate-addons-cf7' )
					)
				),

				'uacf7_mailchimp_api_status' => array(
					'id' => 'uacf7_mailchimp_api_status',
					'type' => 'callback',
					'function' => 'uacf7_mailchimp_api_status_callback',
					'argument' => $status,
				),

				'uacf7_mailchimp_form_type' => array(
					'id' => 'uacf7_mailchimp_form_type',
					'type' => 'radio',
					'label' => __( 'Type of Form', 'ultimate-addons-cf7' ),
					// 'field_width' => '50',
					'options' => array(
						'subscribe' => 'Subscription Form',
						// 'unsubscribe' => 'Unsubscribe Form',
					),
					'default' => 'subscribe',
					'inline' => true
				),
				'uacf7_mailchimp_audience' => array(
					'id' => 'uacf7_mailchimp_audience',
					'type' => 'select',
					'label' => __( ' Select Mailchimp Audience ', 'ultimate-addons-cf7' ),
					'field_width' => '25',
					'options' => $audience,
				),
				'uacf7_mailchimp_subscriber_email' => array(
					'id' => 'uacf7_mailchimp_subscriber_email',
					'type' => 'select',
					'label' => __( ' Subscriber Email ', 'ultimate-addons-cf7' ),
					'query_args' => array(
						'post_id' => $post_id,
						'specific' => 'email',
					),
					'options' => 'uacf7',
					'field_width' => '25'
				),
				'uacf7_mailchimp_subscriber_fname' => array(
					'id' => 'uacf7_mailchimp_subscriber_fname',
					'type' => 'select',
					'label' => __( ' Subscriber First Name ', 'ultimate-addons-cf7' ),
					'query_args' => array(
						'post_id' => $post_id,
						'specific' => 'text',
					),
					'options' => 'uacf7',
					'field_width' => '25'
				),
				'uacf7_mailchimp_subscriber_lname' => array(
					'id' => 'uacf7_mailchimp_subscriber_lname',
					'type' => 'select',
					'label' => __( ' Subscriber Last Name ', 'ultimate-addons-cf7' ),
					'query_args' => array(
						'post_id' => $post_id,
						'specific' => 'text',
					),
					'options' => 'uacf7',
					'field_width' => '25'
				),
				'uacf7_mailchimp_merge_fields' => array(
					'id' => 'uacf7_mailchimp_merge_fields',
					'type' => 'repeater',
					'label' => 'Add New Custom Field',
					'subtitle' => 'Use this option to send your additional field data to Mailchimp, excluding Email and Name.',
					'class' => 'tf-field-class',
					'fields' => array(
						'mailtag' => array(
							'id' => 'mailtag',
							'label' => 'Contact Form Tag',
							'subtitle' => 'Contact Form Tag to Mailchimp fields and *|MERGE|* tags',
							'type' => 'select',
							'field_width' => '50',
							'query_args' => array(
								'post_id' => $post_id,
								'exclude' => [ 'submit' ]
							),
							'options' => 'uacf7',
						),
						'mergefield' => array(
							'id' => 'mergefield',
							'label' => 'Mailchimp Field',
							'subtitle' => 'Audience fields and *|MERGE|* tags, Put those tag here',
							'type' => 'text',
							'field_width' => '50',
						),
					),
				),
			),


		), $post_id );

		$value['mailchimp'] = $mailchimp;
		return $value;
	}

	/* Check Internet connection */
	public static function is_internet_connected() {
		$connected = @fsockopen( "www.google.com", 80 );
		if ( $connected ) {
			return true;
			fclose( $connected );
		} else {
			return false;
		}
	}

	/* Get mailchimp api key */
	public function get_api_key() {

		$uacf7_mailchimp_api_key = uacf7_settings( 'uacf7_mailchimp_api_key' );

		if ( $uacf7_mailchimp_api_key != false ) {
			return $this->mailchimp_api = $uacf7_mailchimp_api_key;
		}

		$this->mailchimp_connection();

	}

	/* mailchimp Connection check */
	public function mailchimp_connection() {

		$api_key = $this->mailchimp_api;

		if ( $api_key != '' ) {

			$response = $this->set_config( $api_key, 'ping' );
			$response = json_decode( $response );

			if ( isset( $response->health_status ) ) { //Display success message
				$this->mailchimlConnection = true;
			} else {
				$this->mailchimlConnection = false;
			}
		}
	}

	/* Mailchimp config set */
	private function set_config( $api_key = '', $path = '' ) {


		$server_prefix = explode( "-", $api_key );

		if ( ! isset( $server_prefix[1] ) ) {
			return;
		}
		$server_prefix = $server_prefix[1];

		$url = "https://$server_prefix.api.mailchimp.com/3.0/$path";

		$curl = curl_init( $url );
		curl_setopt( $curl, CURLOPT_URL, $url );
		curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );

		$headers = array(
			"Authorization: Bearer $api_key"
		);
		curl_setopt( $curl, CURLOPT_HTTPHEADER, $headers );
		//for debug only!
		curl_setopt( $curl, CURLOPT_SSL_VERIFYHOST, false );
		curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER, false );

		$resp = curl_exec( $curl );
		curl_close( $curl );

		return $resp;
	}

	/* Mailchimp connection status */
	public function connection_status() {
		$api_key = $this->mailchimp_api;
		$status = '';
		if ( $api_key != '' ) {

			$response = $this->set_config( $api_key, 'ping' );
			$response = json_decode( $response );

			$status .= '<span class="status-title"><strong>' . esc_html__( 'Status: ', 'ultimate-addons-cf7' ) . '</strong>';

			if ( $this->is_internet_connected() == false ) { //Checking internet connection
				$status .= '<span class="status-error">' . esc_html__( 'Can\'t connect to the server. Please check internet connection.', 'ultimate-addons-cf7' ) . '</span>';
			}

			if ( isset( $response->health_status ) ) { //Display success message
				$status .= '<span class="status-success">' . esc_html( $response->health_status, 'ultimate-addons-cf7' ) . '</span>';
			}

			if ( isset( $response->title ) ) { //Display error title
				$status .= '<span class="status-error">' . esc_html( $response->title, 'ultimate-addons-cf7' ) . '</span>';
			}

			$status .= '</span>';

			if ( isset( $response->detail ) ) { //Display error mdetails
				$status .= '<span class="status-details status-error">' . esc_html( $response->detail, 'ultimate-addons-cf7' ) . '</span>';
			}
		} else {
			$status .= '<span class="status-details">' . esc_html( '', 'ultimate-addons-cf7' ) . '</span>';
		}

		return $status;
	}

	/* Add members to mailchimp */
	public function add_members( $id, $audience, $posted_data ) {
		$this->mailchimp_connection();
		$api_key = $this->mailchimp_api;

		// get mailchimp Post Data
		$mailchimp = uacf7_get_form_option( $id, 'mailchimp' );

		$subscriber_email = isset( $mailchimp['uacf7_mailchimp_subscriber_email'] ) ? $mailchimp['uacf7_mailchimp_subscriber_email'] : '';

		$subscriber_email = ! empty( $subscriber_email ) ? $posted_data[ $subscriber_email ] : '';

		if ( $this->mailchimlConnection && ! empty( $api_key ) && ! empty( $subscriber_email ) ) {
			$server_prefix = explode( "-", $api_key );
			$server_prefix = $server_prefix[1];

			$subscriber_fname = isset( $mailchimp['uacf7_mailchimp_subscriber_fname'] ) ? $mailchimp['uacf7_mailchimp_subscriber_fname'] : '';
			$subscriber_fname = ! empty( $subscriber_fname ) ? $posted_data[ $subscriber_fname ] : '';

			$subscriber_lname = isset( $mailchimp['uacf7_mailchimp_subscriber_lname'] ) ? $mailchimp['uacf7_mailchimp_subscriber_lname'] : '';
			$subscriber_lname = ! empty( $subscriber_lname ) ? $posted_data[ $subscriber_lname ] : '';

			$extra_fields = isset( $mailchimp['uacf7_mailchimp_merge_fields'] ) && is_array( $mailchimp['uacf7_mailchimp_merge_fields'] ) ? $mailchimp['uacf7_mailchimp_merge_fields'] : array();

			$extra_merge_fields = '';
			foreach ( $extra_fields as $extra_field ) {
				$extra_merge_fields .= '"' . $extra_field['mergefield'] . '": "' . $posted_data[ $extra_field['mailtag'] ] . '",';
			}
			$extra_merge_fields = trim( $extra_merge_fields, ',' );

			if ( $extra_merge_fields != '' ) {
				$extra_merge_fields = ',' . $extra_merge_fields;
			}

			$url = "https://$server_prefix.api.mailchimp.com/3.0/lists/" . $audience . "/members";


			//Mailchimp data
			$data = '{"email_address":"' . sanitize_email( $subscriber_email ) . '","status":"subscribed","merge_fields":{"FNAME": "' . sanitize_text_field( $subscriber_fname ) . '", "LNAME": "' . sanitize_text_field( $subscriber_lname ) . '"' . $extra_merge_fields . '},"vip":false,"location":{"latitude":0,"longitude":0}}';

			$curl = curl_init( $url );
			curl_setopt( $curl, CURLOPT_URL, $url );
			curl_setopt( $curl, CURLOPT_POST, true );
			curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );

			$headers = array(
				"Authorization: Bearer $api_key",
				"Content-Type: application/json",
			);

			curl_setopt( $curl, CURLOPT_HTTPHEADER, $headers );
			curl_setopt( $curl, CURLOPT_POSTFIELDS, $data );

			//for debug only!
			curl_setopt( $curl, CURLOPT_SSL_VERIFYHOST, false );
			curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER, false );

			$resp = curl_exec( $curl );

			if ( curl_errno( $curl ) ) {
				error_log( 'cURL error: ' . curl_error( $curl ) );
			} else {
				error_log( 'Mailchimp response: ' . $resp );
			}

			curl_close( $curl );
			return $resp;
		} else {
			error_log( 'Mailchimp connection failed or missing subscriber email.' );
		}

	}

	/* Send data before sent email */
	public function send_data( $cf7 ) {

		// get the contact form object
		$wpcf = WPCF7_Submission::get_instance();

		// Check if submission instance exists
		if ( ! $wpcf ) {
			return;
		}

		$posted_data = $wpcf->get_posted_data();
		$id = $cf7->id();


		// checking 
		$uacf7_mailchimp_checkbox = $this->uacf7_mailchimp_subscribe_checkbox_status( $wpcf, $posted_data );

		var_dump( $posted_data );
		var_dump( $uacf7_mailchimp_checkbox );

		die();

		// Get Mailchimp settings from the form options
		$mailchimp = uacf7_get_form_option( $id, 'mailchimp' );

		$form_enable = isset( $mailchimp['uacf7_mailchimp_form_enable'] ) ? $mailchimp['uacf7_mailchimp_form_enable'] : '';
		$form_type = isset( $mailchimp['uacf7_mailchimp_form_type'] ) ? $mailchimp['uacf7_mailchimp_form_type'] : '';
		$audience = isset( $mailchimp['uacf7_mailchimp_audience'] ) ? $mailchimp['uacf7_mailchimp_audience'] : '';

		// Validate Mailchimp settings before proceeding
		if ( $form_enable && $form_type === 'subscribe' && ! empty( $audience ) ) {
			// Add members to Mailchimp audience
			$this->add_members( $id, $audience, $posted_data );

			// Optionally, you can skip sending the email by uncommenting the following line
			// $wpcf->skip_mail = true;

		}
	}


}
new UACF7_MAILCHIMP();

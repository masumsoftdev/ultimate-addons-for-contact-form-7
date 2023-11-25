<?php
defined( 'ABSPATH' ) || exit;
/**
 * Setup Wizard Class
 * @since 2.9.3
 * @author Foysal
 */
if ( ! class_exists( 'UACF7_Setup_Wizard' ) ) {
	class UACF7_Setup_Wizard {

		private static $instance = null;
		private static $current_step = null;
		
		private $addons = [];
		/**
		 * Singleton instance
		 * @since 1.0.0
		 */
		public static function instance() {
			if ( self::$instance == null ) {
				self::$instance = new self;
			}

			return self::$instance;
		}

		public function __construct() {
			add_action( 'admin_menu', [ $this, 'uacf7_wizard_menu' ], 100 );
			add_filter( 'uacf7_settings_options', [ $this, 'uacf7_settings_options_wizard' ], 100 );
			add_filter( 'woocommerce_enable_setup_wizard', '__return_false' );
			add_action( 'admin_init', [ $this, 'tf_activation_redirect' ] );
			add_action( 'wp_ajax_uacf7_setup_wizard_submit', [ $this, 'wp_ajax_uacf7_setup_wizard_submit' ] );
			add_action( 'wp_ajax_uacf7_onclick_ajax_activate_plugin', [ $this, 'uacf7_onclick_ajax_activate_plugin' ] );
			add_action( 'in_admin_header', [ $this, 'remove_notice' ], 1000 );

			if(! is_plugin_active( 'woocommerce/woocommerce.php' )){
				add_action('wp_ajax_woocommerce_ajax_install_plugin', 'wp_ajax_install_plugin');
			}

			self::$current_step = isset( $_GET['step'] ) ? sanitize_key( $_GET['step'] ) : 'welcome';
		}
		
		public function uacf7_settings_options_wizard($option){
			$this->addons = $option;

			return $option;
		}

		/**
		 * Add wizard submenu
		 */
		public function uacf7_wizard_menu() {

			if ( current_user_can( 'manage_options' ) ) {
				add_submenu_page(
					'',
					esc_html__( 'TF Setup Wizard', 'tourfic' ),
					esc_html__( 'TF Setup Wizard', 'tourfic' ),
					'manage_options',
					'uacf7-setup-wizard',
					[ $this, 'uacf7_wizard_page' ],
					99
				);
			}
		}

		/**
		 * Remove all notice in setup wizard page
		 */
		public function remove_notice() {
			if ( isset( $_GET['page'] ) && $_GET['page'] == 'uacf7-setup-wizard' ) {
				remove_all_actions( 'admin_notices' );
				remove_all_actions( 'all_admin_notices' );
			}
		}


		/**
		 * One Click CF7 Plugin Install
		 */
		public function uacf7_onclick_ajax_activate_plugin() {  
			
			// check_ajax_referer('updates', '_ajax_nonce');
			// Check user capabilities
			if (!current_user_can('install_plugins')) {
				wp_send_json_error('Permission denied');
			}

			// activate the plugin
			$plugin_slug = sanitize_text_field( wp_unslash($_POST['slug']) );
			$file_name = sanitize_text_field( wp_unslash($_POST['file_name']) );
			$result = activate_plugin($plugin_slug.'/'.$file_name.'.php');

			if (is_wp_error($result)) {
				wp_send_json_error('Error: ' . $result->get_error_message());
			} else {
				wp_send_json_success('Plugin installed and activated successfully!');
			}

			wp_die();

		}

		/**
		 * Setup wizard page
		 */
		public function uacf7_wizard_page() {
			require_once ABSPATH.'wp-admin/includes/plugin.php';
			$plugin_to_check =  'contact-form-7/wp-contact-form-7.php';

			if(file_exists(WP_PLUGIN_DIR . '/' . $plugin_to_check)){
				$uacf7_plugin_status = ( is_plugin_active( $plugin_to_check) ) ? 'activate' : 'not_active';
			}else{
				$uacf7_plugin_status = 'not_installed';
			}
			
			?>
				<div class="uacf7-setup-wizard">
					<div class="uacf7-wizard-header">
						<div class="uacf7-step-items-container">
							<div class="uacf7-single-step-item step-first  active" data-step="1">
								<span class="step-item-dots ">
									<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
										<rect width="24" height="24" rx="12" fill="#F9F5FF"/>
										<circle cx="12" cy="12" r="4" fill="#7F56D9"/>
									</svg>  
								</span>
								<span class="step-item-title"><?php echo esc_html('Installation') ?></span>
							</div>
							<div class="uacf7-single-step-item" data-step="2">
								<span class="step-item-dots">
									<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
										<circle cx="12" cy="12" r="4" fill="#EAECF0"/>
									</svg> 
								</span>
								<span class="step-item-title"><?php echo esc_html('Choose addon') ?> </span>
							</div>
							<div class="uacf7-single-step-item" data-step="3">
								<span class="step-item-dots">
									<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
										<circle cx="12" cy="12" r="4" fill="#EAECF0"/>
									</svg>
								</span>
								<span class="step-item-title"><?php echo esc_html( 'Form type' ) ?></span>
							</div>
							<div class="uacf7-single-step-item step-last" data-step="4">
								<span class="step-item-dots">
									<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
										<circle cx="12" cy="12" r="4" fill="#EAECF0"/>
									</svg> 
								</span>
								<span class="step-item-title"><?php echo esc_html('Generate & Preview') ?></span>
							</div>
						</div> 
					</div>
					<div class="uacf7-step-content-container">
						<div class="uacf7-single-step-content installation active" data-step="1">
							<div class="uacf7-single-step-content-wrap">
								<span class="uacf7-wizard-logo">
									<svg width="72" height="72" viewBox="0 0 72 72" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M72.0022 35.9989C72.0022 41.5348 70.7528 46.7771 68.519 51.4632C67.7553 53.0701 66.8746 54.6086 65.8901 56.0721C65.4354 56.7475 64.9587 57.4097 64.4598 58.052H7.54455C6.50271 56.7078 5.54915 55.2885 4.70376 53.8008C1.71066 48.5496 0 42.4751 0 36.0011C0 16.1199 16.1199 2.26657e-07 36.0011 2.26657e-07C55.8844 -0.00220707 72.0022 16.1177 72.0022 35.9989Z" fill="#382673"/>
										<path d="M66.1972 35.9991C66.1972 44.7003 62.5176 52.5406 56.6285 58.05H15.3763C9.48498 52.5406 5.80762 44.7003 5.80762 35.9991C5.80762 19.3229 19.3273 5.80542 36.0013 5.80542C52.6774 5.80542 66.1972 19.3229 66.1972 35.9991Z" fill="#473080"/>
										<path d="M36.0607 29.5049H35.9923C35.6259 29.5049 35.3301 29.2091 35.3301 28.8427V14.7535C35.3301 14.3871 35.6259 14.0913 35.9923 14.0913H36.0607C36.4271 14.0913 36.7229 14.3871 36.7229 14.7535V28.8427C36.7229 29.2091 36.4271 29.5049 36.0607 29.5049Z" fill="#F9A74E"/>
										<path d="M50.808 20.6186H43.376V12.2573H50.808L48.4859 16.438L50.808 20.6186Z" fill="#D44A90"/>
										<path d="M45.0844 14.78H36.7231V23.1413H45.0844V14.78Z" fill="#F15A9E"/>
										<path d="M45.0844 14.7803L43.376 12.2573V14.7803H45.0844Z" fill="#A62973"/>
										<path d="M62.7095 47.7859L57.5665 44.433L54.4476 46.9229L51.0991 45.4903L57.8424 35.1072L62.7095 47.7859Z" fill="white"/>
										<path d="M65.8879 56.072C65.4332 56.7474 64.9564 57.4096 64.4576 58.0519C64.1353 58.4669 63.802 58.8774 63.4643 59.277C62.3231 60.6212 61.0892 61.8816 59.7648 63.0448L56.5223 58.0497L55.3944 56.3103L49.7349 47.5937L51.1012 45.4902L54.4497 46.9227L57.5686 44.4329L62.7116 47.7858L63.2149 49.0991L65.8879 56.072Z" fill="#F9A74E"/>
										<path d="M64.6275 45.4726L62.7094 47.7859L57.8423 35.1071L57.8688 35.0674L64.6275 45.4726Z" fill="#D7D4E3"/>
										<path d="M68.5188 51.463C67.7551 53.0699 66.8744 54.6084 65.8899 56.0719L63.2147 49.099L62.7114 47.7857L64.6296 45.4724L64.6649 45.5232L68.5188 51.463Z" fill="#D28E55"/>
										<path d="M63.464 59.2748C62.3228 60.619 61.0889 61.8794 59.7645 63.0426C59.1421 63.59 58.5019 64.1154 57.8442 64.6186C57.2305 64.7003 56.5882 64.7444 55.926 64.7444C53.6768 64.7444 51.6483 64.2412 50.2091 63.4311C48.8605 62.6762 48.0327 61.6498 48.0327 60.5219C48.0327 60.0032 48.2071 59.5087 48.5249 59.0518C48.7766 58.692 49.1121 58.3565 49.5271 58.0497C50.8625 57.063 52.9793 56.3964 55.3941 56.3104C55.5706 56.3037 55.7472 56.3015 55.926 56.3015C56.7118 56.3015 57.4711 56.3633 58.1885 56.4781H58.1907C59.8749 56.7474 61.3185 57.3081 62.325 58.0497C62.8194 58.4183 63.2101 58.8311 63.464 59.2748Z" fill="#00C2A9"/>
										<path d="M45.8459 41.6056V45.2829L41.9942 42.0338L36.0278 26.49L45.8459 41.6056Z" fill="#D7D4E3"/>
										<path d="M59.7649 63.0406C59.1424 63.588 58.5023 64.1133 57.8445 64.6166C56.0389 65.9961 54.1009 67.208 52.0526 68.2299L50.2117 63.4291L48.5275 59.0476L48.1434 58.0454L46.2142 53.0172V53.015L41.9961 42.0293L45.8478 45.2784V41.6055L49.7349 47.5939L55.3944 56.3105L56.5223 58.0499L59.7649 63.0406Z" fill="#FEC632"/>
										<path d="M41.9916 42.0311L38.6608 49.8516L34.628 41.8788L30.4055 44.969L26.7656 40.7421L36.0252 26.4851L36.0275 26.4895L41.9916 42.0311Z" fill="white"/>
										<path d="M52.0503 68.2322C47.2163 70.6425 41.7686 72 36.001 72C26.9069 72 18.6052 68.6273 12.2681 63.0671L15.526 58.0499L18.2476 53.8604L20.0135 51.141L26.7656 40.7424L30.4055 44.9694L34.628 41.8814L38.6608 49.852L41.9916 42.0315L41.9938 42.0337L46.2119 53.0194V53.0216L48.1411 58.0499L48.5252 59.052L50.2094 63.4335L52.0503 68.2322Z" fill="#FFDE39"/>
										<path d="M18.2501 53.8603L15.5285 58.0497L12.2705 63.0669C10.5422 61.5505 8.95732 59.8685 7.54685 58.0497C6.505 56.7055 5.55145 55.2862 4.70605 53.7985L8.35914 48.1676L9.98812 45.6624L12.5574 48.2316L15.407 46.4592H15.4093L18.2501 53.8603Z" fill="#FEC632"/>
										<path d="M17.9783 48.0047L15.409 46.4574H15.4068L13.2017 40.714L13.2237 40.6809L17.9783 48.0047Z" fill="#D7D4E3"/>
										<path d="M20.0136 51.1409L18.25 53.8603L15.4092 46.457L17.9785 48.0044L20.0136 51.1409Z" fill="#F9A74E"/>
										<path d="M15.4072 46.4573L12.5576 48.2297L9.98828 45.6626L13.2021 40.7139L15.4072 46.4573Z" fill="white"/>
										<path d="M26.3969 64.1862C30.1808 64.1862 33.2483 62.5457 33.2483 60.522C33.2483 58.4984 30.1808 56.8579 26.3969 56.8579C22.6129 56.8579 19.5454 58.4984 19.5454 60.522C19.5454 62.5457 22.6129 64.1862 26.3969 64.1862Z" fill="#00C2A9"/>
										<path d="M64.4577 58.0498C64.1355 58.4648 63.8022 58.8753 63.4644 59.2749C62.3233 60.6191 61.0894 61.8795 59.765 63.0427C59.1425 63.5901 58.5024 64.1155 57.8446 64.6187C56.0391 65.9983 54.1011 67.2101 52.0527 68.2321C47.2187 70.6425 41.7711 71.9999 36.0034 71.9999C26.9093 71.9999 18.6077 68.6272 12.2705 63.067C10.5422 61.5506 8.95734 59.8686 7.54688 58.0498H64.4577Z" fill="#00A58C"/>
									</svg>
								</span>

								<div class="uacf7-single-step-content-inner">
									<h1><?php echo esc_html('Welcome to UACF7') ?></h1>

									<p><?php echo esc_html("UACF7 stands for Ultimate Addons for Contact Form 7. It's a WordPress plugin that contains over 25 features. It's developed by Themefic, a WordPress plugins and themes company") ?></p>

									<div class="uacf7-step-plugin-required">
										<p>To continue it requires Contact from 7 <br> to be install & activate</p> 
										<button class="required-plugin-button uacf7-setup-widzard-btn <?php  if($uacf7_plugin_status== 'activate' ){ echo 'disabled'; }?>" <?php  if($uacf7_plugin_status== 'activate' ){ echo 'disabled ="disabled"'; }?> data-plugin-status="<?php echo esc_attr( $uacf7_plugin_status ) ?>">
										
											<?php 
												if('activate' == $uacf7_plugin_status){
													echo esc_html('Activated');
												}else if('not_installed' == $uacf7_plugin_status){
													echo esc_html('Install & Activate');
												}else{
													echo esc_html('Activate');
												}
											?> 

											<!-- <svg width="14" height="10" viewBox="0 0 14 10" fill="none" xmlns="http://www.w3.org/2000/svg">
												<path d="M12.3337 5L1.66699 5" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
												<path d="M9.00051 8.33341C9.00051 8.33341 12.3338 5.87845 12.3338 5.00006C12.3338 4.12166 9.00049 1.66675 9.00049 1.66675" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
											</svg> -->
										</button>
									</div>
								</div>
							</div>
						</div>
						<div class="uacf7-single-step-content chooes-addon " data-step="2">
							<div class="uacf7-single-step-content-wrap">
								 <h2>Choose your addons</h2>
								 <div class="uacf7-addon-setting-content">  
									
									<?php 
										$data = get_option( 'uacf7_settings', true );


										foreach($this->addons as $section_key => $section): 
											
										if($section_key == 'general_addons' || $section_key == 'extra_fields_addons' || $section_key == 'wooCommerce_integration'):
										
										foreach ($section['fields'] as $field_key => $field ):
											$id = 'uacf7_settings'.'['.$field['id'].']';
									?> 
									<div class="uacf7-single-addon-setting uacf7-fields-<?php echo esc_attr($field['id']) ?>" data-parent="<?php echo esc_attr($section_key) ?>" data-filter="<?php echo esc_html( strtolower($field['label']) ) ?>">
										<?php 
											$label_class = '';
											if(isset($field['is_pro'])){
												$label_class .= $field['is_pro'] == true ? 'tf-field-disable tf-field-pro' : '';
												$badge = '<span class="addon-status pro">'.esc_html('Pro').'</span>';
											}else{
												$badge = '<span class="addon-status">'.esc_html('Free').'</span>';
											}
											$default = $field['default'] == true ? 'checked' : '';
											$default = isset($data[$field['id']]) && $data[$field['id']] == 1  ? 'checked' : $default;
											$value = isset($data[$field['id']]) ? $data[$field['id']] : 0;
											$demo_link = isset($field['demo_link']) ? $field['demo_link'] : '#';
											$documentation_link = isset($field['documentation_link']) ? $field['documentation_link'] : '#';

											// echo $default; 
										?>
											<div class="uacf7-single-addons-wrap"> 
												<?php echo $badge; ?>
												<h2 class="uacf7-single-addon-title"><?php echo esc_html( $field['label'] ) ?></h2>
												<div class="uacf7-addon-toggle-wrap">
													<input type="checkbox" id="<?php echo esc_attr($field['id']) ?>" <?php echo esc_attr( $default ) ?> value="<?php echo esc_html($value); ?>" class="uacf7-addon-input-field" name="<?php echo esc_attr( $id ) ?>" id="uacf7_enable_redirection" >
														
													<label class="uacf7-addon-toggle-inner <?php echo esc_attr( $label_class ) ?> " for="<?php echo esc_attr($field['id']) ?>">
														<span class="uacf7-addon-toggle-track"><svg width="16" height="17" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg">
															<rect y="0.5" width="16" height="16" rx="8" fill="#79757F"/>
														</svg> 
														</span>
													</label>
												</div>
											</div>  
										</div>

									<?php 
										endforeach;  
										endif;
										endforeach; 
									?>
								</div>
							</div>
						</div>
						<div class="uacf7-single-step-content form-type" data-step="3">
							<div class="uacf7-single-step-content-wrap"> 
								<div class="uacf7-single-step-content-inner">
									 <div class="uacf7-form-generate">
											<h3><b>Thank you!</b> Now create your <span>Form</span></h3>
											<label for="uacf7-select-form">Describe your 
												<select name="uacf7-select-form" id="uacf7-select-form">
													<option value="0">Choose Form type</option>
													<option value="0">Choose Form type</option>
													<option value="0">Choose Form type</option>
													<option value="0">Choose Form type</option>
												</select>
											</label> 
									 </div>
									 <button class="uacf7-generate-form uacf7-setup-widzard-btn" data-current-step="1" data-next-step="2">Generate with AI

										<svg width="15" height="16" viewBox="0 0 15 16" fill="none" xmlns="http://www.w3.org/2000/svg">
											<g clip-path="url(#clip0_143_4913)">
												<path d="M9.58008 3.39453L11.25 2.75L11.8652 1.10938C11.8945 0.962891 12.041 0.875 12.1875 0.875C12.3047 0.875 12.4512 0.962891 12.4805 1.10938L13.125 2.75L14.7656 3.39453C14.9121 3.42383 15 3.57031 15 3.6875C15 3.83398 14.9121 3.98047 14.7656 4.00977L13.125 4.625L12.4805 6.29492C12.4512 6.41211 12.3047 6.5 12.1875 6.5C12.041 6.5 11.8945 6.41211 11.8652 6.29492L11.25 4.625L9.58008 4.00977C9.43359 3.98047 9.375 3.83398 9.375 3.6875C9.375 3.57031 9.43359 3.42383 9.58008 3.39453ZM7.5293 6.38281L10.8691 7.90625C11.0449 7.99414 11.1621 8.16992 11.1621 8.3457C11.1621 8.52148 11.0449 8.69727 10.8691 8.78516L7.5293 10.3086L6.00586 13.6484C5.91797 13.8242 5.74219 13.9414 5.56641 13.9414C5.39062 13.9414 5.21484 13.8242 5.15625 13.6484L3.60352 10.3086L0.263672 8.78516C0.0878906 8.69727 0 8.52148 0 8.3457C0 8.16992 0.0878906 7.99414 0.263672 7.90625L3.60352 6.38281L5.15625 3.04297C5.21484 2.86719 5.39062 2.75 5.56641 2.75C5.74219 2.75 5.91797 2.86719 6.00586 3.04297L7.5293 6.38281ZM11.8652 10.4844C11.8945 10.3379 12.041 10.25 12.1875 10.25C12.3047 10.25 12.4512 10.3379 12.4805 10.4844L13.125 12.125L14.7656 12.7695C14.9121 12.7988 15 12.9453 15 13.0625C15 13.209 14.9121 13.3555 14.7656 13.3848L13.125 14L12.4805 15.6699C12.4512 15.7871 12.3047 15.875 12.1875 15.875C12.041 15.875 11.8945 15.7871 11.8652 15.6699L11.25 14L9.58008 13.3848C9.43359 13.3555 9.375 13.209 9.375 13.0625C9.375 12.9453 9.43359 12.7988 9.58008 12.7695L11.25 12.125L11.8652 10.4844Z" fill="white"/>
											</g>
											<defs>
												<clipPath id="clip0_143_4913">
												<rect width="15" height="16" fill="white"/>
												</clipPath>
											</defs>
										</svg>
									</button>
								</div>
								<div class="uacf7-single-step-content-inner">
									 <!-- <img src="<?php echo UACF7_URL ?>assets/admin/images/quick-setup.svg" alt="quick-setup"> -->

									<div class="uacf7-generated-template">
										<textarea name="uacf7-generated-form" id="uacf7-generated-form" cols="30" rows="10"></textarea>
										<button class="uacf7-generate-form uacf7-setup-widzard-btn uacf7-">Create your form</button>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="uacf7-wizard-footer">
						<div class="uacf7-wizard-footer-inner">
							<div class="uacf7-wizard-footer-left">
								<a href="#" class="uacf7-wizard-footer-left-link uacf7-back-dashboard">Back to dashboard</a>
							</div>

							<div class="uacf7-wizard-footer-right">
								<button class="uacf7-wizard-footer-right-button uacf7-next uacf7-setup-widzard-btn <?php  if($uacf7_plugin_status != 'activate' ){ echo 'disabled'; }?>" <?php  if($uacf7_plugin_status != 'activate' ){ echo 'disabled ="disabled"'; }?> data-current-step="1" data-next-step="2">Next

								<svg width="14" height="10" viewBox="0 0 14 10" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M12.3337 4.99951L1.66699 4.99951" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
									<path d="M9.00051 8.33317C9.00051 8.33317 12.3338 5.87821 12.3338 4.99981C12.3338 4.12141 9.00049 1.6665 9.00049 1.6665" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
								</svg>
								</button>
							</div>
						</div>
					</div>
				</div>
			<?php
		}
 

		/**
		 * redirect to set up wizard when active plugin
		 */
		public function tf_activation_redirect() {
			if ( ! get_option( 'tf_setup_wizard' ) && ! get_option( 'tf_settings' ) ) {
				update_option( 'tf_setup_wizard', 'active' );
				wp_redirect( admin_url( 'admin.php?page=tf-setup-wizard' ) );
				exit;
			}
		}
 

		function uacf7_setup_wizard_submit() {

			// Add nonce for security and authentication.
			$nonce_name   = isset( $_POST['tf_setup_wizard_nonce'] ) ? $_POST['tf_setup_wizard_nonce'] : '';
			$nonce_action = 'tf_setup_wizard_action';

			// Check if a nonce is set.
			if ( ! isset( $nonce_name ) ) {
				return;
			}

			// Check if a nonce is valid.
			if ( ! wp_verify_nonce( $nonce_name, $nonce_action ) ) {
				return;
			}

			 
			$response = [
				'success'      => true,
				'redirect_url' => esc_url( admin_url( 'admin.php?page=tf_settings' ) )
			];

			echo json_encode( $response );
			wp_die();
		}
	}
}

UACF7_Setup_Wizard::instance();
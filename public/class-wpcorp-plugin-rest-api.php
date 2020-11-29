<?php

/**
 * The WPCorp Plugin REST API functionality of the plugin.
 *
 * @link       #
 * @since      1.0.0
 *
 * @package    WPCorp_Plugin
 * @subpackage WPCorp_Plugin/public
 */

/**
 * The Custom Post Types functionality of the plugin.
 *
 *
 * @package    WPCorp_Plugin
 * @subpackage WPCorp_Plugin/public
 * @author     Chandra Prakash Thapa <cpthapa@gmail.com>
 */
class WPCorp_Plugin_REST_API {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

  }
  
  /**
   * Register REST Route
   * 
   */
  public function wpcorp_register_rest_api(){
  
		register_rest_route('wpcorp/v1','nonce', array(
			'methods' => 'GET',
			'callback' => array($this, 'wpcorp_nonce_rest_api_callback_function')
		));

		register_rest_route('wpcorp/v1','message', array(
			'methods' => 'POST',
			'callback' => array($this, 'wpcorp_message_rest_api_callback_function')
		));

  }

  /**
   * REST API Message Callback funciton
   * 
   */
  public function wpcorp_message_rest_api_callback_function(WP_REST_Request $request) {

		$data = $request->get_params();	

		$wp_error = new WP_Error(null, null, null);

		if (isset( $data["nonce"] ) && wp_verify_nonce($data["nonce"], 'wp_rest')) {

			$sanitized_data = array();
			$sanitized_data['companyname']		   = sanitize_text_field($data['companyname']);	
			$sanitized_data['firstname']		     = sanitize_text_field($data['firstname']);
			$sanitized_data['lastname']		       = sanitize_text_field($data['lastname']);
			$sanitized_data['jobtitle']	         = sanitize_text_field($data['jobtitle']);
			$sanitized_data['phonenumber']		   = sanitize_text_field($data['phonenumber']);
			$sanitized_data['email']		         = sanitize_email($data['email']);

			if($sanitized_data['companyname'] == '') {
					// empty username
					$wp_error->add('comapny_name', __('Please enter a company name'));
			}
			if(!is_email($sanitized_data['email'])) {
					//invalid email
					$wp_error->add('email_invalid', __('Invalid email'));
			}

			if($sanitized_data['phonenumber'] == '') {
					// passwords do not match
					$wp_error->add('phonenumber_empty', __('Please enter a phone number'));
			}
			
			$errors = $wp_error->get_error_messages();

			$acceptable_fields = [
				'companyname'  => 'wpcorp_company_name',
				'firstname'    => 'wpcorp_first_name',
				'lastname'     => 'wpcorp_last_name',
				'jobtitle'     => 'wpcorp_job_title',
				'email'        => 'wpcorp_email',
				'phonenumber'  => 'wpcorp_phone_number',
			];
			
			// if no errors then create new message entry
			if(empty($errors)) {
					
				$form_submission = wp_insert_post(array(
								'post_type'		=> 'message',
								'status'		  => 'publish',
				), true );
	
				if (is_wp_error($form_submission)) return [
					'success' => false,
					'sumbiterror' => true,
					'data' => $form_submission->get_error_message()
				];
	
				foreach ($acceptable_fields as $field_key => $cmb_key) {

					// Enter all field value
					update_post_meta($form_submission, $cmb_key, $sanitized_data[$field_key]);
				}

				if($form_submission) {
						// TODO: send an email to the admin
						$data['id'] = $form_submission;
						$data['success'] = true;
							
						return $data;
				}
			} else {
				return [
					'success' => false,
					'sumbiterror' => true,
					'data' => $errors
				];
			}
		}
  
    return $data;
	}
	
	/**
   * REST API Nonce Callback funciton
   * 
   */
  public function wpcorp_nonce_rest_api_callback_function() {

		$data['nonce'] = wp_create_nonce('wp_rest');   
		
    return $data;
	}

	/**
	 * FIX CORS Issue
	 * 
	 */
	public function wpcorp_rest_send_cors_headers( $value ) {   
			header( 'Access-Control-Allow-Origin: *' );
			header( 'Access-Control-Allow-Origin: http://localhost:3000');
			header( 'Access-Control-Allow-Methods: OPTIONS, GET, POST, PUT, PATCH, DELETE' );
			header( 'Access-Control-Allow-Credentials: true' );
			return $value;
	}
	//add_filter( 'rest_pre_serve_request', 'wpcorp_rest_send_cors_headers', 11 );

}

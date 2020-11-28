<?php

/**
 * The WPCorp Custom Field functionality.
 *
 * @link       #
 * @since      1.0.0
 *
 * @package    WPCorp_Plugin
 * @subpackage WPCorp_Plugin/admin
 */

/**
 * The  Custom Field functionality.
 *
 *
 * @package    WPCorp_Plugin
 * @subpackage WPCorp_Plugin/admin
 * @author     Chandra Prakash Thapa <cpthapa@gmail.com>
 */
class WPCorp_Plugin_Meta_Box {

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
	 * Only show this box in the CMB2 REST API if the user is logged in.
	 *
	 * @param  bool                 $is_allowed     Whether this box and its fields are allowed to be viewed.
	 * @param  CMB2_REST_Controller $cmb_controller The controller object.
	 *                                              CMB2 object available via `$cmb_controller->rest_box->cmb`.
	 *
	 * @return bool                 Whether this box and its fields are allowed to be viewed.
	 */
	public function wpcorp_limit_rest_view_to_logged_in_users( $is_allowed, $cmb_controller ) {

		if ( ! is_user_logged_in() ) {
			$is_allowed = false;
		}

		return $is_allowed;
	}

	/**
	 * Hook in and add a box to be available in the CMB2 REST API. Can only happen on the 'cmb2_init' hook.
	 * More info: https://github.com/CMB2/CMB2/wiki/REST-API
	 */
	public function wpcorp_register_rest_api_box() {

		$cmb_rest = new_cmb2_box( array(

			'id'            => 'wpcorp',
			'title'         => esc_html__( 'Message Data', 'wpcorp' ),
			'object_types'  => array( 'message' ), // Post type
			'show_in_rest'  => false, //WP_REST_Server::ALLMETHODS, // WP_REST_Server::READABLE|WP_REST_Server::EDITABLE, // Determines which HTTP methods the box is visible in.
			// Optional callback to limit box visibility.
			// See: https://github.com/CMB2/CMB2/wiki/REST-API#permissions
			'get_box_permissions_check_cb' => array( $this, 'wpcorp_limit_rest_view_to_logged_in_users'),
		) );

		$cmb_rest->add_field( array(

			'name' => 'Company Name',
			'desc' => 'Add your company name.',
			'default' => '',
			'id' => 'wpcorp_company_name',
			'type' => 'text'
		));

		$cmb_rest->add_field( array(

			'name' => 'First Name (optional)',
			'desc' => 'Add your first name.',
			'default' => '',
			'id' => 'wpcorp_first_name',
			'type' => 'text'
		));

		$cmb_rest->add_field( array(

			'name' => 'Last Name (optional)',
			'desc' => 'Add your last name.',
			'default' => '',
			'id' => 'wpcorp_last_name',
			'type' => 'text'
		));

		$cmb_rest->add_field( array(

			'name' => 'Job Title (optional)',
			'desc' => 'Add your job title.',
			'default' => '',
			'id' => 'wpcorp_job_title',
			'type' => 'text'
		));

		$cmb_rest->add_field( array(

			'name' => 'Email Address',
			'desc' => 'Add your email address.',
			'default' => '',
			'id' => 'wpcorp_email',
			'type' => 'text_email'
		));

		// $cmb_rest->add_field( array(
		// 	'name' => 'Phone Number',
		// 	'desc' => 'Add your phone number name.',
		// 	'default' => '',
		// 	'id' => 'wpcorp_phone_number',
		// 	'type' => 'text'
		// ));

		$cmb_rest->add_field( array(
			
			'name' => __( 'Phone Number', 'wpcorp' ),
			'desc' => __( 'Add your phone number', 'wpcrop' ),
			'id'   => 'wpcorp_phone_number',
			'type' => 'text',
			'attributes' => array(
				'type' => 'number',
				'pattern' => '\d*',
			),
			'sanitization_cb' => 'absint',
				'escape_cb'       => 'absint',
		));

	}

}
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
    register_rest_route('wpcorp/v1','message', array(
        'methods' => 'GET',
        'callback' => array($this, 'wpcorp_rest_api_callback_function')
    ));
  }

  /**
   * REST API Callback funciton
   * 
   */
  public function wpcorp_rest_api_callback_function() {
    $data['id'] = 12;
    $data['company_name'] = " ABC pty LTd.";
    $data['first_name'] = "Chandra";
    $data["email"] = "cpthapa@gmail.com";
    
    return $data;
  }

}

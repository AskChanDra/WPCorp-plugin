<?php

/**
 * The WPCorp Plugin Custom Post Type functionality of the plugin.
 *
 * @link       #
 * @since      1.0.0
 *
 * @package    WPCorp_Plugin
 * @subpackage WPCorp_Plugin/admin
 */

/**
 * The Custom Post Types functionality of the plugin.
 *
 *
 * @package    WPCorp_Plugin
 * @subpackage WPCorp_Plugin/admin
 * @author     Chandra Prakash Thapa <cpthapa@gmail.com>
 */
class WPCorp_Plugin_CPT {

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
	 * Register Custom Post Types
	 * 
	 * @since		1.0.0
	 */
	public function register_message_post_type() {

		$labels = array(
			'name'                  => _x( 'Message Types', 'Post Type General Name', 'wpcorp' ),
			'singular_name'         => _x( 'Message Type', 'Post Type Singular Name', 'wpcorp' ),
			'menu_name'             => __( 'Messages', 'wpcorp' ),
			'name_admin_bar'        => __( 'Message Type', 'wpcorp' ),
			'archives'              => __( 'Item Archives', 'wpcorp' ),
			'attributes'            => __( 'Item Attributes', 'wpcorp' ),
			'parent_item_colon'     => __( 'Parent Item:', 'wpcorp' ),
			'all_items'             => __( 'All Messages', 'wpcorp' ),
			'add_new_item'          => __( 'Add New Item', 'wpcorp' ),
			'add_new'               => __( 'Add New', 'wpcorp' ),
			'new_item'              => __( 'New Item', 'wpcorp' ),
			'edit_item'             => __( 'Edit Item', 'wpcorp' ),
			'update_item'           => __( 'Update Item', 'wpcorp' ),
			'view_item'             => __( 'View Item', 'wpcorp' ),
			'view_items'            => __( 'View Items', 'wpcorp' ),
			'search_items'          => __( 'Search Item', 'wpcorp' ),
			'not_found'             => __( 'Not found', 'wpcorp' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'wpcorp' ),
			'featured_image'        => __( 'Featured Image', 'wpcorp' ),
			'set_featured_image'    => __( 'Set featured image', 'wpcorp' ),
			'remove_featured_image' => __( 'Remove featured image', 'wpcorp' ),
			'use_featured_image'    => __( 'Use as featured image', 'wpcorp' ),
			'insert_into_item'      => __( 'Insert into item', 'wpcorp' ),
			'uploaded_to_this_item' => __( 'Uploaded to this item', 'wpcorp' ),
			'items_list'            => __( 'Items list', 'wpcorp' ),
			'items_list_navigation' => __( 'Items list navigation', 'wpcorp' ),
			'filter_items_list'     => __( 'Filter items list', 'wpcorp' ),
		);
		$args = array(
			'label'                 => __( 'Message Type', 'wpcorp' ),
			'description'           => __( 'Message Post Type Description', 'wpcorp' ),
			'labels'                => $labels,
			'supports'              => array( 'author' ),
			'hierarchical'          => false,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 5,
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => true,
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
			'capability_type'       => 'post',
			'menu_icon'							=> 'dashicons-email',
			'show_in_rest'          => false,
		//	'rest_controller_class' => 'WP_REST_WPCorp_Plugin_Controller',
		);
		register_post_type( 'message', $args );
	
  }
  
  /**
   * Rewrite Flush
   */
  public function wpcorp_rewrite_flush() {
    // Rewrite flush
		$this->register_message_post_type();
		flush_rewrite_rules();
	}
	
	/**
	 * Add Column to table
	 * 
	 */
	public function wpcorp_message_edit_columns( $columns ) {
		unset($columns['title']);
		$columns = array(
      'cb' => $columns['cb'],
			'company' => __( 'Company Name', 'wpcorp' ),
			'firstname' => __( 'First Name', 'wpcorp' ),
      'lastname' => __( 'Last Name', 'wpcorp' ),
			'jobtitle' => __( 'Job Title', 'wpcorp' ),
			'email' => __( 'Email Address', 'wpcorp' ),
			'phone' => __( 'Phone Number', 'wpcorp' ),
      
    );
		return $columns;

	}
	 
	/**
	 * Add Column field to WordPress Admin table
	 * 
	 */
	public function wpcorp_message_add_column_field($column_key, $post_id) {
		switch ($column_key) {
			
			case 'company':
				$company = get_post_meta($post_id, 'wpcorp_company_name', true);
				if ($company) {
					echo '<span>' . $company . '</span>';
				}
				break;
			case 'firstname':
				$firstname = get_post_meta($post_id, 'wpcorp_first_name', true);
				if ($firstname) {
					echo '<span>' . $firstname . '</span>';
				}
				break;
			case 'lastname':
				$lastname = get_post_meta($post_id, 'wpcorp_last_name', true);
				if ($lastname) {
					echo '<span>' . $lastname . '</span>';
				}
				break;
			case 'jobtitle':
				$jobtitle = get_post_meta($post_id, 'wpcorp_job_title', true);
				if ($jobtitle) {
					echo '<span>' . $jobtitle . '</span>';
				}
				break;
			case 'email':
				$email = get_post_meta($post_id, 'wpcorp_email', true);
				if ($email) {
					echo '<span>' . $email . '</span>';
				}
				break;
			case 'phone':
				$phone = get_post_meta($post_id, 'wpcorp_phone_number', true);
				if ($phone) {
					echo '<span>' . $phone . '</span>';
				}
				break;
			default:
				# code...
				break;
		}
	}

	/**
	 * Remove Quick Edit, View feature from CPT
	 */
	function wpcorp_message_remove_quick_edit( $actions ) {   
		
		unset($actions['view']);
		unset($actions['inline hide-if-no-js']);
		return $actions;
	}
}

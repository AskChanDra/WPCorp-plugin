<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       #
 * @since      1.0.0
 *
 * @package    WPCorp_Plugin
 * @subpackage WPCorp_Plugin/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    WPCorp_Plugin
 * @subpackage WPCorp_Plugin/includes
 * @author     Chandra Prakash Thapa <cpthapa@gmail.com>
 */
class WPCorp_Plugin {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      WPCorp_Plugin_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'WPCorp_Plugin_VERSION' ) ) {
			$this->version = WPCorp_Plugin_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'wpcorp-plugin';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_cpt_hooks();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		$this->define_meta_box_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - WPCorp_Plugin_Loader. Orchestrates the hooks of the plugin.
	 * - WPCorp_Plugin_i18n. Defines internationalization functionality.
	 * - WPCorp_Plugin_Admin. Defines all hooks for the admin area.
	 * - WPCorp_Plugin_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wpcorp-plugin-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wpcorp-plugin-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wpcorp-plugin-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-wpcorp-plugin-public.php';

		/**
		 * The class responsible for registering custom post types
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wpcorp-plugin-cpt.php';

		/**
		 * The class responsible for creating custom feild with meta box.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wpcorp-plugin-meta-box.php';

		$this->loader = new WPCorp_Plugin_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the WPCorp_Plugin_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new WPCorp_Plugin_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new WPCorp_Plugin_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new WPCorp_Plugin_Public( $this->get_plugin_name(), $this->get_version() );

		// Actions
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		$this->loader->add_action( 'init', $plugin_public, 'wpcorp_create_cra_page' );

		// Filter
		$this->loader->add_filter( 'template_include', $plugin_public, 'wpcorp_cra_template' );		

	}

	/**
	 * Register all of the hooks related to the custom post type functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_cpt_hooks() {

		$plugin_cpt = new WPCorp_Plugin_CPT( $this->get_plugin_name(), $this->get_version() );

		// Actions
		$this->loader->add_action( 'init', $plugin_cpt, 'register_message_post_type');
		$this->loader->add_action( 'wpcorp_plugin_activate', $plugin_cpt, 'wpcorp_rewrite_flush');
		$this->loader->add_action( 'manage_message_posts_custom_column', $plugin_cpt, 'wpcorp_message_add_column_field', 10, 2 );

		// Filters
		$this->loader->add_filter( 'manage_message_posts_columns', $plugin_cpt, 'wpcorp_message_edit_columns', 10, 2 );
		$this->loader->add_filter( 'post_row_actions', $plugin_cpt, 'wpcorp_message_remove_quick_edit', 10, 1 );

	}

	/**
	 * Register all of the hooks related to the meta box functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_meta_box_hooks() {

		$plugin_meta_box = new WPCorp_Plugin_Meta_Box( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'cmb2_init', $plugin_meta_box, 'wpcorp_register_rest_api_box');

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    WPCorp_Plugin_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}

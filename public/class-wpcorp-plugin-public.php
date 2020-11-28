<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       #
 * @since      1.0.0
 *
 * @package    WPCorp_Plugin
 * @subpackage WPCorp_Plugin/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    WPCorp_Plugin
 * @subpackage WPCorp_Plugin/public
 * @author     Chandra Prakash Thapa <cpthapa@gmail.com>
 */
class WPCorp_Plugin_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in WPCorp_Plugin_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The WPCorp_Plugin_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wpcorp-plugin-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in WPCorp_Plugin_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The WPCorp_Plugin_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wpcorp-plugin-public.js', array( 'jquery' ), $this->version, false );

	}
	
	/**
	 * Creating custom CRA app page template
	 *
	 * @since    1.0.0
	 */
	public function wpcorp_cra_template( $template ) {
		$my_page = get_option('wpcorp_page');
		$file_name = 'wpcorp-plugin-contact-page-template.php';

    if ( $my_page && is_page( $my_page ) ) {
        if ( locate_template( $file_name ) ) {
            $template = locate_template( $file_name );
        } else {
            // Template not found in theme's folder, use plugin's template as a fallback
						//$template = plugin_dir_path( __FILE__ ) . $file_name;
						$template = plugin_dir_path( __FILE__ ) . 'templates/' . $file_name;
        }
    }

    return $template;
	}

	/**
	 * Create custom CRA page if not exists
	 *
	 * @since    1.0.0
	 */
	public function wpcorp_create_cra_page() {
		$my_page = get_option('wpcorp_page');
		if (!$my_page||FALSE === get_post_status( $my_page )) {
				// Create post/page object
				$my_new_page = array(
						'post_title' => 'Request a Quote',
						'post_content' => '<div id="root" ></div>',
						'post_status' => 'publish',
						'post_type' => 'page'
				);
				// Insert the post into the database
				$my_page = wp_insert_post( $my_new_page );
				update_option('wpcorp_page',$my_page);
		}
 }

}

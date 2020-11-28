<?php
/**
 *
 *
 * @since      1.0.0
 * @package    WPCorp_Plugin
 * @subpackage WPCorp_Plugin/includes
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://cmb2.io
 * @link     https://github.com/CMB2/CMB2
 */

/**
 * Call the CMB2 plugin from within the WPCorp Plugin.
 */

if ( file_exists( dirname( __FILE__ ) . '/cmb2/init.php' ) ) {
	require_once dirname( __FILE__ ) . '/cmb2/init.php';
} elseif ( file_exists( dirname( __FILE__ ) . '/CMB2/init.php' ) ) {
	require_once dirname( __FILE__ ) . '/CMB2/init.php';
}
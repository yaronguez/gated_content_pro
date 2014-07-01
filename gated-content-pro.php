<?php
/**
 * Gated Content Pro
 *
 * @package   gated-content-pro
 * @author    Yaron Guez <yaron@trestian.com>
 * @license   GPL-2.0+
 * @link      http://trestian.com
 * @copyright 2014 Trestian LLC
 *
 * @wordpress-plugin
 * Plugin Name:       Gated Content Pro
 * Plugin URI:        http://trestian.com
 * Description:       Hide content on a post or page until user completes action
 * Version:           1.0.0
 * Author:            yaronguez
 * Author URI:        http://yaronguez.com
 * Text Domain:       gated-content-pro-locale
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 * GitHub Plugin URI: https://github.com/yaronguez/gated_content_pro
 * WordPress-Plugin-Boilerplate: v2.6.1
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/*----------------------------------------------------------------------------*
 * Public-Facing Functionality
 *----------------------------------------------------------------------------*/

/*
 * @TODO:
 *
 * - replace `class-plugin-name.php` with the name of the plugin's class file
 *
 */
require_once( plugin_dir_path( __FILE__ ) . 'public/class-gated-content-pro.php' );

/*
 * Register hooks that are fired when the plugin is activated or deactivated.
 * When the plugin is deleted, the uninstall.php file is loaded.
 *
 * @TODO:
 *
 * - replace Plugin_Name with the name of the class defined in
 *   `class-plugin-name.php`
 */
register_activation_hook( __FILE__, array( 'Gated_Content_Pro', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'Gated_Content_Pro', 'deactivate' ) );

/*
 * @TODO:
 *
 * - replace Plugin_Name with the name of the class defined in
 *   `class-plugin-name.php`
 */
add_action( 'plugins_loaded', array( 'Gated_Content_Pro', 'get_instance' ) );

/*----------------------------------------------------------------------------*
 * Dashboard and Administrative Functionality
 *----------------------------------------------------------------------------*/

/*
 * @TODO:
 *
 * - replace `class-plugin-name-admin.php` with the name of the plugin's admin file
 * - replace Plugin_Name_Admin with the name of the class defined in
 *   `class-plugin-name-admin.php`
 *
 * If you want to include Ajax within the dashboard, change the following
 * conditional to:
 *
 * if ( is_admin() ) {
 *   ...
 * }
 *
 * The code below is intended to to give the lightest footprint possible.
 */
if ( is_admin() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {

	require_once( plugin_dir_path( __FILE__ ) . 'admin/class-plugin-name-admin.php' );
	add_action( 'plugins_loaded', array( 'Gated_Content_Pro_Admin', 'get_instance' ) );

}

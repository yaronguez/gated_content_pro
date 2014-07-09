<?php
/**
 * Gated Content Pro
 *
 * @package   gated-content-pro
 * @author    Yaron Guez <yaron@trestian.com>
 * @license   GPL-2.0+
 * @link      http://trestian.com
 * @copyright 2014 Trestian LLC
 */

/**
 * Plugin class. This class should is used to work with the
 * public-facing side of the WordPress site.
 *
 *
 * @package Gated_Content_Pro
 * @author    Yaron Guez <yaron@trestian.com>
 */
class Gated_Content_Pro {

	/**
	 * Plugin version, used for cache-busting of style and script file references.
	 *
	 * @since   1.0.0
	 *
	 * @var     string
	 */
	const VERSION = '1.0.0';

	/**
	 *
	 * Unique identifier for your plugin.
	 *
	 *
	 * The variable name is used as the text domain when internationalizing strings
	 * of text. Its value should match the Text Domain file header in the main
	 * plugin file.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_slug = 'gated-content-pro';

	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Initialize the plugin by setting localization and loading public scripts
	 * and styles.
	 *
	 * @since     1.0.0
	 */
	private function __construct() {

		// Load plugin text domain
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );

		// Activate plugin when new blog is added
		add_action( 'wpmu_new_blog', array( $this, 'activate_new_site' ) );

		// Set cookie when gravity forms are submitted
		add_filter('gform_pre_validation', array($this, 'set_cookie_form_submission'), 10, 2);

		// Short code to hide gated content unless action is completed
		add_shortcode( 'gated_content', array( $this, 'shortcode_gated_content' ) );

	}

	/**
	 * Return the plugin slug.
	 *
	 * @since    1.0.0
	 *
	 * @return    Plugin slug variable.
	 */
	public function get_plugin_slug() {
		return $this->plugin_slug;
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Fired when the plugin is activated.
	 *
	 * @since    1.0.0
	 *
	 * @param    boolean    $network_wide    True if WPMU superadmin uses
	 *                                       "Network Activate" action, false if
	 *                                       WPMU is disabled or plugin is
	 *                                       activated on an individual blog.
	 */
	public static function activate( $network_wide ) {

		if ( function_exists( 'is_multisite' ) && is_multisite() ) {

			if ( $network_wide  ) {

				// Get all blog ids
				$blog_ids = self::get_blog_ids();

				foreach ( $blog_ids as $blog_id ) {

					switch_to_blog( $blog_id );
					self::single_activate();

					restore_current_blog();
				}

			} else {
				self::single_activate();
			}

		} else {
			self::single_activate();
		}

	}

	/**
	 * Fired when the plugin is deactivated.
	 *
	 * @since    1.0.0
	 *
	 * @param    boolean    $network_wide    True if WPMU superadmin uses
	 *                                       "Network Deactivate" action, false if
	 *                                       WPMU is disabled or plugin is
	 *                                       deactivated on an individual blog.
	 */
	public static function deactivate( $network_wide ) {

		if ( function_exists( 'is_multisite' ) && is_multisite() ) {

			if ( $network_wide ) {

				// Get all blog ids
				$blog_ids = self::get_blog_ids();

				foreach ( $blog_ids as $blog_id ) {

					switch_to_blog( $blog_id );
					self::single_deactivate();

					restore_current_blog();

				}

			} else {
				self::single_deactivate();
			}

		} else {
			self::single_deactivate();
		}

	}

	/**
	 * Fired when a new site is activated with a WPMU environment.
	 *
	 * @since    1.0.0
	 *
	 * @param    int    $blog_id    ID of the new blog.
	 */
	public function activate_new_site( $blog_id ) {

		if ( 1 !== did_action( 'wpmu_new_blog' ) ) {
			return;
		}

		switch_to_blog( $blog_id );
		self::single_activate();
		restore_current_blog();

	}

	/**
	 * Get all blog ids of blogs in the current network that are:
	 * - not archived
	 * - not spam
	 * - not deleted
	 *
	 * @since    1.0.0
	 *
	 * @return   array|false    The blog ids, false if no matches.
	 */
	private static function get_blog_ids() {

		global $wpdb;

		// get an array of blog ids
		$sql = "SELECT blog_id FROM $wpdb->blogs
			WHERE archived = '0' AND spam = '0'
			AND deleted = '0'";

		return $wpdb->get_col( $sql );

	}

	/**
	 * Fired for each blog when the plugin is activated.
	 *
	 * @since    1.0.0
	 */
	private static function single_activate() {
		// @TODO: Define activation functionality here
	}

	/**
	 * Fired for each blog when the plugin is deactivated.
	 *
	 * @since    1.0.0
	 */
	private static function single_deactivate() {
		// @TODO: Define deactivation functionality here
	}

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		$domain = $this->plugin_slug;
		$locale = apply_filters( 'plugin_locale', get_locale(), $domain );

		load_textdomain( $domain, trailingslashit( WP_LANG_DIR ) . $domain . '/' . $domain . '-' . $locale . '.mo' );
		load_plugin_textdomain( $domain, FALSE, basename( plugin_dir_path( dirname( __FILE__ ) ) ) . '/languages/' );

	}

	/**
	 * Register and enqueue public-facing style sheet.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_slug . '-plugin-styles', plugins_url( 'assets/css/public.css', __FILE__ ), array(), self::VERSION );
	}

	/**
	 * Register and enqueues public-facing JavaScript files.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( $this->plugin_slug . '-plugin-script', plugins_url( 'assets/js/public.js', __FILE__ ), array( 'jquery' ), self::VERSION );
	}

	/**
	 * Method to render gated content shortcode
	 * @param $atts Short code arguments
	 * 		gf => gravity form id, required
	 * 		gf_display_title => whether to display gravity form title or not, optional
	 * 		gf_field_values => array of field values to preset
	 * @param null $content content to hide until form is submitted
	 * @return string HTML to output
	 */
	public function shortcode_gated_content($atts, $content=null){
		// Set defaults
		$atts = shortcode_atts( array(
			'gf' => false,
			'gf_display_title' => true,
			'gf_display_description' => true,
			'gf_field_values' => null
		), $atts );

		$gf = $atts['gf'];
		$result = '';

		// Ensure gravity form is provided
		if($gf == false){
			if(defined('WP_DEBUG') && WP_DEBUG){
				$result .= 'GATED CONTENT ERROR: No gravity form specified<br/><br/>';
			}
			$result .= $content;
			return $result;
		}

		// Check for cookie indicating gravity form was submitted and return content if so
		$cookie = 'gated_content_gf_' . $gf;
		if(isset($_COOKIE[$cookie]) && $_COOKIE[$cookie]){
			return $content;
		}

		// Ensure gravity forms is installed
		if(!function_exists('gravity_form')){
			if(defined('WP_DEBUG') && WP_DEBUG){
				$result .= 'GATED CONTENT ERROR: Gravity Forms is not installed<br/><br/>';
			}
			$result .= $content;
			return $result;
		}


		// Display form with attributes passed on as arguments
		gravity_form_enqueue_scripts($gf, false);
		return gravity_form($gf, $atts['gf_display_title'], $atts['gf_display_description'], false, $atts['gf_field_values'], false, 1, false);
	}

	/**
	 * Stores coookie when a gravity form is submitted
	 * @param $entry
	 * @param $form
	 */
	public function set_cookie_form_submission($form){
		setcookie('gated_content_gf_' . $form['id'], true);
		return $form;
	}


}

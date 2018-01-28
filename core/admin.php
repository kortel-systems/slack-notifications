<?php
/**
 * Declare admin settings page, and plugin admin assets.
 *
 * @package     SlackNotifications
 * @subpackage  Admin
 * @author      Dor Zuberi <webmaster@dorzki.co.il>
 * @link        https://www.dorzki.co.il
 * @since       2.0.0
 * @version     2.0.0
 */

namespace SlackNotifications;

// Block direct access to the file via url.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Class Admin
 *
 * @package SlackNotifications
 */
class Admin {

	/**
	 * Admin constructor.
	 */
	public function __construct() {

		add_action( 'admin_menu', [ $this, 'register_settings_menu' ] );
		add_action( 'admin_menu', [ $this, 'remove_settings_submenu' ], 11 );
		add_action( 'admin_enqueue_scripts', [ $this, 'register_scripts' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'register_styles' ] );

		$this->register_settings_pages();

	}


	/**
	 * Register the plugin's admin menu root.
	 */
	public function register_settings_menu() {

		// Register plugin settings menu item.
		add_menu_page( __( 'Slack Notifications', 'dorzki-notifications-to-slack' ), __( 'Slack Notifications', 'dorzki-notifications-to-slack' ), 'manage_options', SN_SLUG, null, 'dashicons-cloud', 100 );

	}


	/**
	 * Remove the default top level plugin page.
	 */
	public function remove_settings_submenu() {

		remove_submenu_page( SN_SLUG, SN_SLUG );

	}


	/**
	 * Declares a new settings page for the plugin.
	 */
	public function register_settings_pages() {

		new Settings\General();

	}


	/**
	 * Load plugin scripts.
	 */
	public function register_scripts() {

		// Load plugin assets only on the plugin's settings page.
		if ( - 1 !== strpos( get_current_screen()->id, SN_SLUG ) ) {

			// Load WordPress media uploader scripts.
			wp_enqueue_media();

			// Load plugin scripts.
			wp_enqueue_script( SN_SLUG . '-scripts', SN_URL . 'assets/admin-scripts.min.js', [ 'jquery' ], SN_VERSION, true );

			// Allow JS strings localization.
			wp_localize_script( SN_SLUG . '-scripts', 'sn_lang', [
				'media_frame_title'  => __( 'Choose or upload a new image', 'dorzki-notifications-to-slack' ),
				'media_frame_button' => __( 'Select Image', 'dorzki-notifications-to-slack' ),
			] );

		}

	}


	/**
	 * Load plugin styles.
	 */
	public function register_styles() {

		// Load plugin assets only on the plugin's settings page.
		if ( - 1 !== strpos( get_current_screen()->id, SN_SLUG ) ) {

			// Load plugin styles.
			wp_enqueue_style( SN_SLUG . '-styles', SN_URL . 'assets/admin-styles.min.css', false, SN_VERSION );

		}

	}

}
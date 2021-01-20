<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( 'You are not allowed to call this page directly.' );
}

class FrmWelcomeScreenController {
	private static $menu_slug   = 'formidable-welcome-screen';
	private static $option_name = 'frm_activation_redirect';

	/**
	 * Register all of the hooks related to the welcome screen functionality
	 *
	 * @access   public
	 */
	public static function load_hooks() {
		add_action( 'admin_init', __CLASS__ . '::redirect' );

		if ( ! FrmAppHelper::is_admin_page( self::$menu_slug ) ) {
			return;
		}

		add_action( 'admin_menu', __CLASS__ . '::screen_page' );
		add_action( 'admin_head', __CLASS__ . '::remove_menu' );
		add_action( 'admin_enqueue_scripts', __CLASS__ . '::enqueue_styles' );
	}

	/**
	 * Performs a safe (local) redirect to the welcome screen
	 * when the plugin is activated
	 *
	 * @return void
	 */
	public static function redirect() {
		$current_page = FrmAppHelper::simple_get( 'page', 'sanitize_title' );
		if ( $current_page === self::$menu_slug ) {
			// Prevent endless loop.
			return;
		}

		// Only do this for single site installs.
		if ( isset( $_GET['activate-multi'] ) || is_network_admin() ) { // WPCS: CSRF ok.
			return;
		}

		// Check if we should consider redirection.
		if ( ! self::is_welcome_screen() ) {
			return;
		}

		delete_transient( self::$option_name );

		// Initial install.
		wp_safe_redirect( self::settings_link() );
		exit;
	}

	/**
	 * Add a submenu welcome screen for the formidable parent menu
	 *
	 * @return void
	 */
	public static function screen_page() {
		add_submenu_page( 'formidable', 'Formidable | ' . __( 'Welcome Screen', 'formidable' ), __( 'Welcome Screen', 'formidable' ), 'read', self::$menu_slug, __CLASS__ . '::screen_content' );
	}

	/**
	 * Include html content for the welcome screem
	 *
	 * @return void
	 */
	public static function screen_content() {
		FrmAppHelper::include_svg();
		include( FrmAppHelper::plugin_path() . '/classes/views/welcome/screen.php' );
	}

	/**
	 * Remove the welcome screen submenu page from the formidable parent menu
	 * since it is not necessary to show that link there
	 *
	 * @return void
	 */
	public static function remove_menu() {
		remove_submenu_page( 'formidable', self::$menu_slug );
	}

	/**
	 * Register the stylesheets for the welcome screen.
	 *
	 * @return void
	 */
	public static function enqueue_styles() {
		$version = FrmAppHelper::plugin_version();
		wp_enqueue_style( 'frm_welcome-screen', FrmAppHelper::plugin_url() . '/css/welcome_screen.css', array(), $version );
	}

	/**
	 * Helps to confirm if the user is currently on the welcome screen
	 *
	 * @return bool
	 */
	public static function is_welcome_screen() {
		$to_redirect = get_transient( self::$option_name );
		return $to_redirect === self::$menu_slug;
	}

	/**
	 * Build the admin URL link for the welcome screen
	 *
	 * @return string
	 */
	public static function settings_link() {
		return admin_url( 'admin.php?page=' . self::$menu_slug );
	}
}
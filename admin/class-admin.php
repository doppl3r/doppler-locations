<?php

class Doppler_Locator_Admin {
	private $doppler_locator;

	public function __construct($doppler_locator) {
		$this->doppler_locator = $doppler_locator;
		add_action( 'admin_menu', array( $this, 'add_menu_page' ) ); /* Add admin menu and page */
	}

	public function add_menu_page() {
		// Top level menu
		$page_title = 'Locations';
		$menu_title = 'Locations';
		$capability = 'manage_options';
		$menu_slug = $this->doppler_locator;
		$function = array($this, 'render');
		$icon_url = 'dashicons-location-alt';
		//$icon_url = plugin_dir_url(__FILE__) . 'images/icon_wporg.png';
		add_menu_page($page_title, $menu_title, $capability, $menu_slug, $function, $icon_url);
		
		// Sub level menu
		$parent_slug = $menu_slug;
		$page_title = 'Templates';
		$menu_title = 'Templates';
		$capability = 'manage_options';
		$menu_slug = $menu_slug . "-template";
		$function = array($this, 'render_template');
		add_submenu_page($parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function);
	}

	public function enqueue_styles() {
		// Register stylesheets
		wp_register_style('grix', plugin_dir_url(__FILE__) . 'assets/css/grix.css');
		wp_register_style('stylesheet', plugin_dir_url(__FILE__) . 'assets/css/stylesheet.css');

		// Enqueue stylesheets
		wp_enqueue_style('grix');
		wp_enqueue_style('stylesheet');
	}

	public function enqueue_scripts() {
		// Register scripts
		wp_register_script('scripts', plugin_dir_url(__FILE__) . 'assets/js/scripts.js');
		
		// Enqueue scripts
		wp_enqueue_script('scripts');
	}

	public function render() {
		require_once(plugin_dir_path(dirname(__FILE__)) . 'admin/assets/php/locations.php');
	}

	public function render_template() {
		require_once(plugin_dir_path(dirname(__FILE__)) . 'admin/assets/php/templates.php');
	}
}
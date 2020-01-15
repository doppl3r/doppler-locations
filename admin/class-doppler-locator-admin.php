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
		wp_enqueue_style( $this->doppler_locator, plugin_dir_url( __FILE__ ) . 'css/doppler-locator-admin.css', array(), false, 'all' );
	}

	public function enqueue_scripts() {
		wp_enqueue_script( $this->doppler_locator, plugin_dir_url( __FILE__ ) . 'js/doppler-locator-admin.js', array( 'jquery' ), false, false );
	}

	public function render() {
		echo '<div class="doppler-locator-body">test</div>';
	}

	public function render_template() {
		echo '<div class="doppler-locator-template-body">template</div>';
	}
}
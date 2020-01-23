<?php

class Doppler_Locator_Public {
	private $doppler_locator;

	public function __construct($doppler_locator) {
		$this->doppler_locator = $doppler_locator;
	}

	public function enqueue_styles() {
		// Register stylesheets
		wp_register_style('stylesheet', plugin_dir_url(__FILE__) . 'assets/css/stylesheet.css');

		// Enqueue is in the shortcode
		wp_register_style('leaflet', plugin_dir_url(__FILE__) . 'assets/css/leaflet.css');
		wp_register_style('leaflet-doppler-locator', plugin_dir_url(__FILE__) . 'assets/css/leaflet-doppler-locator.css');

		// Enqueue stylesheets
		wp_enqueue_style('stylesheet');
	}

	public function enqueue_scripts() {
		// Register scripts
		wp_register_script('scripts', plugin_dir_url(__FILE__) . 'assets/js/scripts.js', array( 'jquery' ));

		// Enqueue is in the shortcode
		wp_register_script('leaflet', plugin_dir_url(__FILE__) . 'assets/js/leaflet.js');
		wp_register_script('leaflet-doppler-locator', plugin_dir_url(__FILE__) . 'assets/js/leaflet-doppler-locator.js');

		// Enqueue scripts
		wp_enqueue_script('scripts');
	}
}

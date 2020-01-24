<?php

class Doppler_Locator_Public {
	private $doppler_locator;

	public function __construct($doppler_locator) {
		$this->doppler_locator = $doppler_locator;
	}

	public function apply_template() {
		$post_id = get_the_ID();
		$post_type = get_post_type($post_id);
		$template_id = get_post_meta($post_id, 'template')[0];

		// If post_type = 'location', use the associated template, else use default post content
		$content_id = ($post_type == 'location') ? $template_id : $post_id;
		return get_post_field('post_content', $content_id);
	}

	public function enqueue_styles() {
		// Register stylesheets
		wp_register_style('stylesheet', plugin_dir_url(__FILE__) . 'assets/css/stylesheet.css');

		// Enqueue is in the shortcode
		wp_register_style('grix', plugin_dir_url(__FILE__) . 'assets/css/grix.css');
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

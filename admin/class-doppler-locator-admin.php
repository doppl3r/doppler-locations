<?php

class Doppler_Locator_Admin {
	private $doppler_locator;

	public function __construct($doppler_locator) {
		$this->doppler_locator = $doppler_locator;
	}

	public function enqueue_styles() {
		wp_enqueue_style( $this->doppler_locator, plugin_dir_url( __FILE__ ) . 'css/doppler-locator-admin.css', array(), false, 'all' );
	}

	public function enqueue_scripts() {
		wp_enqueue_script( $this->doppler_locator, plugin_dir_url( __FILE__ ) . 'js/doppler-locator-admin.js', array( 'jquery' ), false, false );
	}
}
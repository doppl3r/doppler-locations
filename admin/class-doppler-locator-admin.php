<?php

class Doppler_Locator_Admin {
	private $doppler_locator;
	private $version;

	public function __construct( $doppler_locator, $version ) {
		$this->doppler_locator = $doppler_locator;
		$this->version = $version;
	}

	public function enqueue_styles() {
		wp_enqueue_style( $this->doppler_locator, plugin_dir_url( __FILE__ ) . 'css/doppler-locator-admin.css', array(), $this->version, 'all' );
	}

	public function enqueue_scripts() {
		wp_enqueue_script( $this->doppler_locator, plugin_dir_url( __FILE__ ) . 'js/doppler-locator-admin.js', array( 'jquery' ), $this->version, false );
	}
}
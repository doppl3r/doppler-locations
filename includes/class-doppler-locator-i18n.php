<?php

class Doppler_Locator_i18n {
	public function load_plugin_textdomain() {
		load_plugin_textdomain(
			'doppler-locator',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);
	}
}
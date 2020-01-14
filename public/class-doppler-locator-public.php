<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Doppler_Locator
 * @subpackage Doppler_Locator/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Doppler_Locator
 * @subpackage Doppler_Locator/public
 * @author     Your Name <email@example.com>
 */
class Doppler_Locator_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $doppler_locator    The ID of this plugin.
	 */
	private $doppler_locator;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $doppler_locator       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $doppler_locator, $version ) {

		$this->doppler_locator = $doppler_locator;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Doppler_Locator_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Doppler_Locator_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->doppler_locator, plugin_dir_url( __FILE__ ) . 'css/doppler-locator-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Doppler_Locator_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Doppler_Locator_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->doppler_locator, plugin_dir_url( __FILE__ ) . 'js/doppler-locator-public.js', array( 'jquery' ), $this->version, false );

	}

}

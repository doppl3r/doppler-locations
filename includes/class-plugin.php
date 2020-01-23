<?php

class Doppler_Locator {
	protected $loader;
	protected $doppler_locator;
	protected $plugin_admin;
	protected $plugin_public;

	public function __construct() {
		$this->doppler_locator = 'doppler-locator';
		$this->load_dependencies();
		$this->define_admin_hooks();
		$this->define_public_hooks();
	}

	private function load_dependencies() {
		require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-loader.php';
		require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-admin.php';
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-public.php';
		$this->loader = new Doppler_Locator_Loader();
	}

	private function define_admin_hooks() {
		$this->plugin_admin = new Doppler_Locator_Admin($this->get_doppler_locator());
		$this->loader->add_action('admin_enqueue_scripts', $this->plugin_admin, 'enqueue_styles');
		$this->loader->add_action('admin_enqueue_scripts', $this->plugin_admin, 'enqueue_scripts');

		// Add custom post features (also for public)
		$this->loader->add_action('init', $this->plugin_admin, 'register_custom_posts'); // Register custom post type
		
		// TODO: Make this an option to write URL
		//$this->loader->add_action('post_type_link', $this->plugin_admin, 'remove_custom_slug', 10, 3); // Change URL
		//$this->loader->add_action('pre_get_posts', $this->plugin_admin, 'parse_custom_request'); // Resolve 404 error
	}
	
	private function define_public_hooks() {
		$this->plugin_public = new Doppler_Locator_Public($this->get_doppler_locator());
		$this->loader->add_action('wp_enqueue_scripts', $this->plugin_public, 'enqueue_styles');
		$this->loader->add_action('wp_enqueue_scripts', $this->plugin_public, 'enqueue_scripts');
		
		// Replace location content with associated template content
		$this->loader->add_filter('the_content', $this->plugin_public, 'apply_template');
	}

	public function run() {
		$this->loader->run();
	}

	public function get_doppler_locator() {
		return $this->doppler_locator;
	}

	public function get_loader() {
		return $this->loader;
	}

	public function get_plugin_admin() {
		return $this->plugin_admin;
	}

	public function get_plugin_public() {
		return $this->plugin_public;
	}
}

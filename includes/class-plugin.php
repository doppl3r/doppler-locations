<?php

class Doppler_Locations {
	protected $loader;
	protected $doppler_locations;
	protected $post_type_location;
	protected $post_type_template;
	protected $plugin_admin;
	protected $plugin_public;

	public function __construct() {
		$this->doppler_locations = 'doppler-locations'; // Slug
		$this->post_type_location = 'doppler_location'; // DB 'post_type' value
		$this->post_type_template = 'doppler_template'; // DB 'post_type' value
		$this->load_dependencies();
		$this->define_admin_hooks();
		$this->define_public_hooks();
	}

	private function load_dependencies() {
		require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-loader.php';
		require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-admin.php';
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-public.php';
		$this->loader = new Doppler_Locations_Loader();
	}

	private function define_admin_hooks() {
		$this->plugin_admin = new Doppler_Locations_Admin($this->get_doppler_locations());
		$this->loader->add_action('admin_enqueue_scripts', $this->plugin_admin, 'enqueue_styles');
		$this->loader->add_action('admin_enqueue_scripts', $this->plugin_admin, 'enqueue_scripts');
		$this->loader->add_action('the_post', $this->plugin_admin, 'redirect_location');
	}
	
	private function define_public_hooks() {
		$this->plugin_public = new Doppler_Locations_Public($this->get_doppler_locations());
		$this->loader->add_action('wp_enqueue_scripts', $this->plugin_public, 'enqueue_styles');
		$this->loader->add_action('wp_enqueue_scripts', $this->plugin_public, 'enqueue_scripts');
		
		// Register custom posts and replace location content with associated template content
		$this->loader->add_action('init', $this->plugin_public, 'register_custom_posts'); // Register custom post type
		$this->loader->add_filter('the_content', $this->plugin_public, 'apply_template');
		$this->loader->add_action('post_type_link', $this->plugin_public, 'remove_custom_slug', 10, 3); // Change URL
		$this->loader->add_action('pre_get_posts', $this->plugin_public, 'parse_custom_request'); // Resolve 404 error
	}

	public function run() {
		$this->loader->run();
	}

	public function get_doppler_locations() {
		return $this->doppler_locations;
	}

	public function get_post_type_location() {
		return $this->post_type_location;
	}

	public function get_post_type_template() {
		return $this->post_type_template;
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

<?php

class Doppler_Locator_Admin {
	private $doppler_locator;

	public function __construct($doppler_locator) {
		$this->doppler_locator = $doppler_locator;
		add_action('admin_menu', array($this, 'add_menu_page')); /* Add admin menu and page */
		add_action('wp_ajax_add_location', array($this, 'add_location'));
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
		wp_register_script('scripts', plugin_dir_url(__FILE__) . 'assets/js/scripts.js', array( 'jquery' ));
		
		// Enqueue scripts
		wp_enqueue_script('scripts');
	}

	public function render() {
		require_once(plugin_dir_path(dirname(__FILE__)) . 'admin/assets/php/locations.php');
	}

	public function render_template() {
		require_once(plugin_dir_path(dirname(__FILE__)) . 'admin/assets/php/templates.php');
	}

	public function get_template_count() {
		// Initialize post query
        global $wpdb;
        $post_type = 'template';
        $results = $wpdb->get_results( 
            $wpdb->prepare("
                SELECT post_type
                    FROM wp_posts
                    WHERE post_type = %s
                ", 
                $post_type
            ) 
		);
		return count($results);
	}

	public function add_template() {
		// Initialize variables
        $post_type = 'template';
        
		// Add new page with default template
		$json = file_get_contents(plugin_dir_path(dirname(__FILE__)) . 'admin/assets/json/default-template.json');
		$default = json_decode($json, true);
		$postarr = array(
			'post_type'             => $post_type,
			'post_title'            => $default['title'],
			'post_excerpt'          => $default['description'],
			'post_content'          => $default['content']
		);
		wp_insert_post($postarr);
	}

	public function add_location() {
		// Add new page with default template
		$post_type = 'location';
		$json = file_get_contents(plugin_dir_path(dirname(__FILE__)) . 'admin/assets/json/default-location.json');
		$default = json_decode($json, true);
		$post_arr = array(
			'post_type'             => $post_type,
			'post_status'			=> 'publish',
			'post_title' 			=> $default['title']
		);
		$post_id = wp_insert_post($post_arr);

		// Add postmeta to newly inserted page
		add_post_meta($post_id, 'template', $default['template']);
		add_post_meta($post_id, 'status', $default['status']);
		

		echo $post_id; // Return post ID
	}

	public function delete_posts_by_type($post_type) {
		global $wpdb;
		$result = $wpdb->query( 
			$wpdb->prepare("
				DELETE posts, terms, meta
				FROM wp_posts posts
				LEFT JOIN wp_term_relationships terms ON terms.object_id = posts.ID
				LEFT JOIN wp_postmeta meta ON meta.post_id = posts.ID
				WHERE posts.post_type = %s
				",
				$post_type
			) 
		);
	}
}
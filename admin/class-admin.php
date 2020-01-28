<?php

class Doppler_Locations_Admin {
	private $doppler_locations;

	public function __construct($doppler_locations) {
		$this->doppler_locations = $doppler_locations;
		add_action('admin_menu', array($this, 'add_menu_page')); /* Add admin menu and page */
		add_action('wp_ajax_add_post', array($this, 'add_post'));
		add_action('wp_ajax_delete_post', array($this, 'delete_post'));
		add_action('wp_ajax_add_meta_row', array($this, 'add_meta_row'));
	}

	public function add_menu_page() {
		// Top level menu
		$page_title = 'Locations';
		$menu_title = 'Locations';
		$capability = 'edit_others_posts';
		$menu_slug = $this->doppler_locations;
		$function = array($this, 'render_locations');
		$icon_url = 'dashicons-location-alt';
		//$icon_url = plugin_dir_url(__FILE__) . 'images/icon_wporg.png';
		$position = 5;
		add_menu_page($page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position);
		
		// Sub level menu
		if (current_user_can('administrator')) {
			$parent_slug = $menu_slug;
			$page_title = 'Templates';
			$menu_title = 'Templates';
			$capability = 'manage_options';
			$menu_slug = $menu_slug . "-template";
			$function = array($this, 'render_template');
			add_submenu_page($parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function);
		}

		//$this->redirect_location();
	}

	public function enqueue_styles() {
		// Register stylesheets
		wp_register_style('grix', plugin_dir_url(__FILE__) . 'assets/css/grix.css');
		wp_register_style('codemirror', plugin_dir_url(__FILE__) . 'assets/css/codemirror.css');
		wp_register_style('stylesheet', plugin_dir_url(__FILE__) . 'assets/css/stylesheet.css');

		// Enqueue stylesheets
		wp_enqueue_style('grix');
		wp_enqueue_style('stylesheet');

		// Enqueue stylesheets (for template editor)
		if ($this->has_codemirror()) {
			wp_enqueue_style('codemirror');
		}
	}

	public function enqueue_scripts() {
		// Register scripts
		wp_register_script('codemirror', plugin_dir_url(__FILE__) . 'assets/js/codemirror.js');
		wp_register_script('codemirror-xml', plugin_dir_url(__FILE__) . 'assets/js/codemirror-xml.js');
		wp_register_script('codemirror-css', plugin_dir_url(__FILE__) . 'assets/js/codemirror-css.js');
		wp_register_script('codemirror-javascript', plugin_dir_url(__FILE__) . 'assets/js/codemirror-javascript.js');
		wp_register_script('codemirror-htmlmixed', plugin_dir_url(__FILE__) . 'assets/js/codemirror-htmlmixed.js');
		wp_register_script('codemirror-init', plugin_dir_url(__FILE__) . 'assets/js/codemirror-init.js');
		wp_register_script('scripts', plugin_dir_url(__FILE__) . 'assets/js/scripts.js', array( 'jquery' ));
		
		// Enqueue global (admin) scripts
		wp_enqueue_script('scripts');

		// Enqueue scripts (for template editor)
		if ($this->has_codemirror()) {
			wp_enqueue_script('codemirror');
			wp_enqueue_script('codemirror-xml');
			wp_enqueue_script('codemirror-css');
			wp_enqueue_script('codemirror-javascript');
			wp_enqueue_script('codemirror-htmlmixed');
			wp_enqueue_script('codemirror-init');
		}
	}

	public function render_locations() {
		// Render single location if id exists, else render location list
		if (isset($_GET['id'])) { require_once(plugin_dir_path(dirname(__FILE__)) . 'admin/assets/php/location-single.php'); }
		else { require_once(plugin_dir_path(dirname(__FILE__)) . 'admin/assets/php/locations.php'); }
	}

	public function render_template() {
		// Render single template if id exists, else render template list
		if (isset($_GET['id'])) {require_once(plugin_dir_path(dirname(__FILE__)) . 'admin/assets/php/template-single.php'); }
		else { require_once(plugin_dir_path(dirname(__FILE__)) . 'admin/assets/php/templates.php'); }
	}

	public function add_post($post_type, $allow_data = true) {
		global $doppler_locations_plugin;
        $post_type_template = $doppler_locations_plugin->get_post_type_template();
        $post_type_location = $doppler_locations_plugin->get_post_type_location();

		// Define post_type by AJAX post value
		if (isset($_POST['post_type'])) $post_type = $_POST['post_type'];

		// Determine specific post_type
		if ($post_type == $post_type_template) {
			// Add new page with default template
			$json = file_get_contents(plugin_dir_path(dirname(__FILE__)) . 'admin/assets/json/default-template.json');
			$default = json_decode($json, true);
			$post_arr = array(
				'post_status'			=> 'publish',
				'post_type'             => $post_type,
				'post_title'            => $default['post_title'],
				'post_excerpt'          => $default['post_excerpt'],
				'post_content'          => $default['post_content']
			);
			$post_id = wp_insert_post($post_arr);
		}
		else if ($post_type == $post_type_location) {
			// Add new page with default template
			$json = file_get_contents(plugin_dir_path(dirname(__FILE__)) . 'admin/assets/json/default-location.json');
			$default = json_decode($json, true);
			$post_arr = array(
				'post_status'			=> 'publish',
				'post_type'             => $post_type,
				'post_title' 			=> $default['post_title']
			);
			$post_id = wp_insert_post($post_arr);

			// Add postmeta to newly inserted page
			add_post_meta($post_id, 'template_id', $default['template_id']);
			add_post_meta($post_id, 'status', $default['status']);
			add_post_meta($post_id, 'display_name', $default['display_name']);
			add_post_meta($post_id, 'hours', json_encode($default['hours']));
			add_post_meta($post_id, 'city', $default['city']);
			add_post_meta($post_id, 'state', $default['state']);
			add_post_meta($post_id, 'zip', $default['zip']);
			add_post_meta($post_id, 'phone', $default['phone']);
			add_post_meta($post_id, 'street', $default['street']);
			add_post_meta($post_id, 'latitude', $default['latitude']);
			add_post_meta($post_id, 'longitude', $default['longitude']);
			add_post_meta($post_id, 'guide', $default['guide']);
			add_post_meta($post_id, 'media', json_encode($default['media']));
			add_post_meta($post_id, 'custom_posts', json_encode($default['custom_posts']));
			add_post_meta($post_id, 'links', json_encode($default['links']));
			add_post_meta($post_id, 'scripts', json_encode($default['scripts']));
			add_post_meta($post_id, 'users', json_encode($default['users']));
			flush_rewrite_rules();
		}
		// Return row HTML/PHP template
		if ($allow_data == true) {
			$row = get_post($post_id);
			echo $this->render_row($post_type, $row);
			wp_die();
		}
	}

	public function render_row($post_type, $row) {
		$type = explode('_', $post_type); // Ex: Convert "doppler_location" to "location"
		include(plugin_dir_path(dirname(__FILE__)) . 'admin/assets/php/' . $type[1] . '-row.php');
	}
	
	public function add_meta_row($postmeta) { 
		if (isset($_POST['pm_type'])) $pm_type = $_POST['pm_type'];
		echo $this->render_meta_row($pm_type, $postmeta); wp_die();
	}
	
	public function render_meta_row($pm_type, $postmeta) {
		include(plugin_dir_path(dirname(__FILE__)) . 'admin/assets/php/location-' . $pm_type . '.php');
	}

	public function delete_post($post_id) {
		// Define post_type by AJAX post value and delete post
		if (isset($_POST['post_id'])) $post_id = $_POST['post_id'];
		wp_delete_post($post_id);
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

	public function get_post_count($post_type) {
		// Initialize post query
        global $wpdb;
        $count = $wpdb->get_var($wpdb->prepare("SELECT COUNT(post_type) FROM wp_posts WHERE post_type = %s", $post_type));
		return $count;
	}

	public function has_codemirror() {
		return (strpos($_GET['page'], 'template') !== false && !empty($_GET['id']));
	}

	public function redirect_location() {
		global $doppler_locations_plugin;
        $post_type_location = $doppler_locations_plugin->get_post_type_location();
		$post_id = $_GET['post'];
		$post_type = get_post_type($post_id);

		// Change where the admin bar 'edit location' goes to
		if (!empty($post_id) && $post_type == $post_type_location) {
			wp_redirect(get_site_url() . '/wp-admin/admin.php?page=' . $this->doppler_locations . '&id=' . $_GET['post']);
		}
	}
}
<?php

class Doppler_Locations_Admin {
	private $doppler_locations;
	private $doppler_save;

	public function __construct($doppler_locations) {
		$this->doppler_locations = $doppler_locations;

		// Initialize save class
		require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-save.php';
		$this->doppler_save = new Doppler_Save($doppler_locations);

		// Add menu and ajax functions for admin page
		add_action('admin_menu', array($this, 'add_menu_page')); /* Add admin menu and page */
		add_action('wp_ajax_add_post', array($this, 'add_post'));
		add_action('wp_ajax_trash_post', array($this, 'trash_post'));
		add_action('wp_ajax_restore_post', array($this, 'restore_post'));
		add_action('wp_ajax_delete_post', array($this, 'delete_post'));
		add_action('wp_ajax_add_meta_row', array($this, 'add_meta_row'));
		add_action('wp_ajax_save_template', array($this->doppler_save, 'save_template'));
		add_action('wp_ajax_save_settings', array($this->doppler_save, 'save_settings'));
		add_action('wp_ajax_save_all_post_content', array($this->doppler_save, 'save_all_post_content'));
	}

	public function get_doppler_save() {
		return $this->doppler_save;
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
			// Default child settings
			$parent_slug = $menu_slug;
			$capability = 'manage_options';

			// Templates
			$page_title = 'Templates';
			$menu_title = 'Templates';
			$menu_slug = $parent_slug . "-template";
			$function = array($this, 'render_template');
			add_submenu_page($parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function);

			// Settings
			$page_title = 'Settings';
			$menu_title = 'Settings';
			$menu_slug = $parent_slug . "-settings";
			$function = array($this, 'render_settings');
			add_submenu_page($parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function);
		}
	}

	public function enqueue_styles() {
		// Register stylesheets
		wp_register_style('grix', plugin_dir_url(__FILE__) . 'assets/css/grix.css');
		wp_register_style('jquery-ui-datepicker', plugin_dir_url(__FILE__) . 'assets/css/jquery-ui-datepicker.css');
		wp_register_style('codemirror', plugin_dir_url(__FILE__) . 'assets/css/codemirror.css');
		wp_register_style('stylesheet', plugin_dir_url(__FILE__) . 'assets/css/stylesheet.css');

		// Enqueue stylesheets
		wp_enqueue_style('grix');
		wp_enqueue_style('jquery-ui-datepicker');
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

		// Enqueue datepicker scripts
		wp_enqueue_script('jquery-ui-datepicker');

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

	public function render_settings() {
		require_once(plugin_dir_path(dirname(__FILE__)) . 'admin/assets/php/settings.php');
	}

	public function add_post($post_type, $allow_data = true) {
		global $doppler_locations_plugin;
        $post_type_template = $doppler_locations_plugin->get_post_type_template();
		$post_type_location = $doppler_locations_plugin->get_post_type_location();
		$post_status = 'publish';

		// Define post_type by AJAX post value
		if (isset($_POST['post_type'])) $post_type = $_POST['post_type'];

		// Determine specific post_type
		if ($post_type == $post_type_template) {
			// Add new page with default template
			$json = file_get_contents(plugin_dir_path(dirname(__FILE__)) . 'admin/assets/json/default-template.json');
			$default = json_decode($json, true);
			$post_arr = array(
				'post_status'			=> $post_status,
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
				'post_type'             => $post_type,
				'post_status'			=> $post_status,
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
			echo $this->render_row($post_type, $post_status, $row);
			wp_die();
		}
	}

	public function render_row($post_type, $post_status_filter, $row) {
		$type = explode('_', $post_type); // Ex: Convert "doppler_location" to "location"
		require(plugin_dir_path(dirname(__FILE__)) . 'admin/assets/php/' . $type[1] . '-row.php');
	}
	
	public function add_meta_row($postmeta) { 
		if (isset($_POST['pm_type'])) $pm_type = $_POST['pm_type'];
		echo $this->render_meta_row($pm_type, $postmeta); wp_die();
	}
	
	public function render_meta_row($pm_type, $postmeta) {
		require(plugin_dir_path(dirname(__FILE__)) . 'admin/assets/php/location-' . $pm_type . '.php');
	}

	public function trash_post($post_id) {
		// Define post_type by AJAX post value and trash post
		if (isset($_POST['post_id'])) $post_id = $_POST['post_id'];
		wp_trash_post($post_id);
	}

	public function restore_post($post_id) {
		// Define post_type by AJAX post value and restore (untrash) post
		if (isset($_POST['post_id'])) $post_id = $_POST['post_id'];
		wp_untrash_post($post_id);
	}

	public function delete_post($post_id) {
		// Define post_type by AJAX post value and delete post
		if (isset($_POST['post_id'])) $post_id = $_POST['post_id'];
		wp_delete_post($post_id, true);
	}

	public function delete_posts_by_type($post_type) {
		global $wpdb;
		$prefix = $wpdb->prefix;
		$result = $wpdb->query(
			$wpdb->prepare("
				DELETE posts, terms, meta
				FROM " . $prefix . "posts posts
				LEFT JOIN " . $prefix . "term_relationships terms ON terms.object_id = posts.ID
				LEFT JOIN " . $prefix . "postmeta meta ON meta.post_id = posts.ID
				WHERE posts.post_type = %s
				",
				$post_type
			) 
		);
	}

	public function get_post_count($post_type, $post_status = 'publish') {
		// Initialize post query
		global $wpdb;
		$prefix = $wpdb->prefix;
        $count = $wpdb->get_var($wpdb->prepare("SELECT COUNT(post_type) FROM " . $prefix . "posts WHERE post_type = %s AND post_status = %s", $post_type, $post_status));
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
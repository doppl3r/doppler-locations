<?php

class Doppler_Locator_Admin {
	private $doppler_locator;

	public function __construct($doppler_locator) {
		$this->doppler_locator = $doppler_locator;
		add_action('admin_menu', array($this, 'add_menu_page')); /* Add admin menu and page */
		add_action('wp_ajax_add_post', array($this, 'add_post'));
		add_action('wp_ajax_delete_post', array($this, 'delete_post'));
	}

	public function add_menu_page() {
		// Top level menu
		$page_title = 'Locations';
		$menu_title = 'Locations';
		$capability = 'manage_options';
		$menu_slug = $this->doppler_locator;
		$function = array($this, 'render_locations');
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

	public function render_locations() {
		require_once(plugin_dir_path(dirname(__FILE__)) . 'admin/assets/php/locations.php');
	}

	public function render_template() {
		require_once(plugin_dir_path(dirname(__FILE__)) . 'admin/assets/php/templates.php');
	}

	public function add_post($post_type) {
		// Define post_type by AJAX post value
		if (isset($_POST['post_type'])) $post_type = $_POST['post_type'];

		// Determine specific post_type
		if ($post_type == "template") {
			// Add new page with default template
			$json = file_get_contents(plugin_dir_path(dirname(__FILE__)) . 'admin/assets/json/default-template.json');
			$default = json_decode($json, true);
			$post_arr = array(
				'post_status'			=> 'publish',
				'post_type'             => $post_type,
				'post_title'            => $default['title'],
				'post_excerpt'          => $default['description'],
				'post_content'          => $default['content']
			);
			$post_id = wp_insert_post($post_arr);
		}
		else if ($post_type == "location") {
			// Add new page with default template
			$json = file_get_contents(plugin_dir_path(dirname(__FILE__)) . 'admin/assets/json/default-location.json');
			$default = json_decode($json, true);
			$post_arr = array(
				'post_status'			=> 'publish',
				'post_type'             => $post_type,
				'post_title' 			=> $default['title']
			);
			$post_id = wp_insert_post($post_arr);

			// Add postmeta to newly inserted page
			add_post_meta($post_id, 'template', $default['template']);
			add_post_meta($post_id, 'status', $default['status']);
			add_post_meta($post_id, 'name', $default['name']);
			add_post_meta($post_id, 'hours', json_encode($default['hours'])); // TODO - might need to use json_encode()
			add_post_meta($post_id, 'city', $default['city']);
			add_post_meta($post_id, 'state', $default['state']);
			add_post_meta($post_id, 'zip', $default['zip']);
			add_post_meta($post_id, 'phone', $default['phone']);
			add_post_meta($post_id, 'street', $default['street']);
			add_post_meta($post_id, 'latitude', $default['latitude']);
			add_post_meta($post_id, 'longitude', $default['longitude']);
			add_post_meta($post_id, 'guide', $default['guide']);
			add_post_meta($post_id, 'posts', json_encode($default['posts']));
			add_post_meta($post_id, 'links', json_encode($default['links']));
			add_post_meta($post_id, 'users', json_encode($default['users']));

			// Return row HTML/PHP template
			$row = get_post($post_id);
			echo $this->render_location_row($row);
			wp_die();
		}
	}

	public function render_location_row($row) {
		include(plugin_dir_path(dirname(__FILE__)) . 'admin/assets/php/location-row.php');
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

	public function register_custom_posts() {
		// Loop through types of custom posts
		$post_types = array('template', 'location');
		foreach ($post_types as $post_type) {
			// Define strings by post type
			$plural = $post_type . 's';
			$uppercaseSingular = ucfirst($post_type);
			$uppercasePlural = ucfirst($plural);

			// Create labels
			$labels = array(
				'name'                  => $uppercasePlural,
				'singular_name'         => $uppercaseSingular,
				'menu_name'             => $uppercaseSingular,
				'name_admin_bar'        => $uppercaseSingular,
				'archives'              => $uppercaseSingular . ' Archives',
				'attributes'            => $uppercaseSingular . ' Attributes',
				'parent_item_colon'     => 'Parent ' . $uppercaseSingular . ':',
				'all_items'             => 'All ' . $uppercasePlural,
				'add_new_item'          => 'Add New ' . $uppercaseSingular,
				'add_new'               => 'Add New',
				'new_item'              => 'New ' . $uppercaseSingular,
				'edit_item'             => 'Edit ' . $uppercaseSingular,
				'update_item'           => 'Update ' . $uppercaseSingular,
				'view_item'             => 'View ' . $uppercaseSingular,
				'view_items'            => 'View ' . $uppercaseSingular,
				'search_items'          => 'Search ' . $uppercaseSingular,
				'not_found'             => 'Not found',
				'not_found_in_trash'    => 'Not found in Trash',
				'featured_image'        => 'Featured Image',
				'set_featured_image'    => 'Set featured image',
				'remove_featured_image' => 'Remove featured image',
				'use_featured_image'    => 'Use as featured image',
				'insert_into_item'      => 'Insert into ' . $post_type,
				'uploaded_to_this_item' => 'Uploaded to this ' . $post_type,
				'items_list'            => $uppercasePlural . ' list',
				'items_list_navigation' => $uppercasePlural . ' list navigation',
				'filter_items_list'     => 'Filter ' . $uppercaseSingular . ' list',
			);
			$args = array(
				'label'                 => $uppercaseSingular,
				'description'           => $uppercaseSingular,
				'labels'                => $labels,
				'supports'              => array('title', 'editor'),
				'taxonomies'            => array($post_type),
				'hierarchical'          => false,
				'public'                => true,
				'show_ui'               => true,
				'show_in_menu'          => true,
				'menu_position'         => 5,
				'show_in_admin_bar'     => true,
				'show_in_nav_menus'     => true,
				'can_export'            => true,
				'has_archive'           => true,
				'exclude_from_search'   => false,
				'publicly_queryable'    => true,
				'capability_type'       => 'page',
				'show_in_rest'          => true,
			);
			register_post_type($post_type, $args);
		}
	}

	function remove_custom_slug( $post_link, $post, $leavename) {
		if ('location' != $post->post_type || 'publish' != $post->post_status) { return $post_link; }
		$post_link = str_replace( '/' . $post->post_type . '/', '/', $post_link );
		return $post_link;
	}

	function parse_custom_request($query) {
		if (!$query->is_main_query() || 2 != count( $query->query ) || ! isset( $query->query['page'] )) { return; }
		if (!empty( $query->query['name'])) {
			$query->set( 'post_type', array( 'post', 'location', 'page' ) );
		}
	}
}
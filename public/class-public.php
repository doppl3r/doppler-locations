<?php

class Doppler_Locations_Public {
	private $doppler_locations;

	public function __construct($doppler_locations) {
		$this->doppler_locations = $doppler_locations;
	}

	public function apply_template() {
		global $doppler_locations_plugin;
		$post_id = get_the_ID();
		$post_type = get_post_type($post_id);
		$post_type_location = $doppler_locations_plugin->get_post_type_location();
		$template_id = get_post_meta($post_id, 'template_id')[0];

		// If post_type = 'location', use the associated template, else use default post content
		$content_id = ($post_type == $post_type_location) ? $template_id : $post_id;
		return get_post_field('post_content', $content_id);
	}

	public function enqueue_styles() {
		// Register stylesheets
		wp_register_style('stylesheet', plugin_dir_url(__FILE__) . 'assets/css/stylesheet.css');

		// Enqueue is in the shortcode
		wp_register_style('grix', plugin_dir_url(__FILE__) . 'assets/css/grix.css');
		wp_register_style('leaflet', plugin_dir_url(__FILE__) . 'assets/css/leaflet.css');
		wp_register_style('leaflet-doppler-locations', plugin_dir_url(__FILE__) . 'assets/css/leaflet-doppler-locations.css');

		// Enqueue stylesheets
		wp_enqueue_style('stylesheet');
	}

	public function enqueue_scripts() {
		// Register scripts
		wp_register_script('scripts', plugin_dir_url(__FILE__) . 'assets/js/scripts.js', array( 'jquery' ));
		wp_register_script('scripts-shortcode', '');

		// Enqueue is in the shortcode
		wp_register_script('leaflet', plugin_dir_url(__FILE__) . 'assets/js/leaflet.js');
		wp_register_script('leaflet-doppler-locations', plugin_dir_url(__FILE__) . 'assets/js/leaflet-doppler-locations.js');

		// Enqueue scripts
		wp_enqueue_script('scripts');
	}

	public function register_custom_posts() {
		
		global $doppler_locations_plugin;
		$post_type_location = $doppler_locations_plugin->get_post_type_location();
		$post_types = array($post_type_location);

		// Loop through types of custom posts
		foreach ($post_types as $post_type) {
			// Define strings by post type
			$singular = str_replace('_', ' ', $post_type);
			$plural = $singular . 's';
			$uppercaseSingular = ucwords($singular);
			$uppercasePlural = ucwords($plural);

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
				'insert_into_item'      => 'Insert into ' . $singular,
				'uploaded_to_this_item' => 'Uploaded to this ' . $singular,
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
				'show_in_menu'          => false,
				'menu_position'         => 5,
				'show_in_admin_bar'     => true,
				'show_in_nav_menus'     => false,
				'can_export'            => true,
				'has_archive'           => true,
				'rewrite'            	=> array( 'slug' => '/' ),
				'exclude_from_search'   => false,
				'publicly_queryable'    => true,
				'capability_type'       => 'page',
				'show_in_rest'          => true,
			);
			// echo '<pre>';
			// var_dump($args);
			// echo '</pre>'; die;
			register_post_type($post_type, $args);
		}
	}

	public function remove_custom_slug($post_link, $post) {
		global $doppler_locations_plugin;
		$post_type_location = $doppler_locations_plugin->get_post_type_location();
		if ($post_type_location === $post->post_type && 'publish' === $post->post_status) { $post_link = str_replace( '/' . $post->post_type . '/', '/', $post_link ); }
		return $post_link;
	}

	public function parse_custom_request($query) {
		global $doppler_locations_plugin;
		$post_type_location = $doppler_locations_plugin->get_post_type_location();
		if (!$query->is_main_query()) { return; }
		if (!isset( $query->query['page']) || 2 !== count($query->query)) { return; }
		if (empty($query->query['name'])) { return; }
		$query->set('post_type', array( 'post', 'page', $post_type_location));
	}
}

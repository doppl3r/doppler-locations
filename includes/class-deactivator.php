<?php

class Doppler_Locator_Deactivator {
	public static function deactivate() {
		$post_types = array('location', 'template');

		// Delete all posts with post_type "location" or "template"
		foreach($post_types as $post_type) {
			$args = array('numberposts' => -1, 'post_type' => $post_type);
			$posts = get_posts($args);
			echo count($posts);
			echo 'id: ' . $post->ID;
			foreach($posts as $post) { wp_delete_post($post->ID, true); }

			// Unregister post types
			unregister_post_type($post_type);
		}

		// Clear the permalinks after the post type has been registered
        flush_rewrite_rules();
		//die;
	}
}
<?php

class Doppler_Locator_Uninstaller {
	public static function uninstall() {
		// Declare variables
		global $wpdb;
		$post_types = array('location', 'template');

		// Delete all posts with post_type "location" or "template" - https://gist.github.com/jazibsawar/a8c94a7361b47f507a23c2620e69b3c3
		foreach($post_types as $post_type) {
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
}
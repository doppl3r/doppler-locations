<?php

class Doppler_Locator_Activator {
	public static function activate() {
        // Initialize post query
        $post_type = 'template';
        $args = array('numberposts' => -1, 'post_type' => $post_type);
        $template_count = count(get_posts($args));

        // Register post types
        $post_types = array('location', 'template');
        foreach($post_types as $post_type) {
            register_post_type($post_type);
        }

        // Check if no post_type "template" exists
        if ($template_count <= 0) {
            // Add new post with post_type "template"
            $json = file_get_contents(plugin_dir_path(dirname(__FILE__)) . 'admin/assets/default-template.json');
            $default = json_decode($json, true);
            $postarr = array(
                'post_type'             => $post_type,
                'post_title'            => $default['title'],
                'post_excerpt'          => $default['description'],
                'post_content'          => $default['content']
            );
            wp_insert_post($postarr);
        }

        // Clear the permalinks after the post type has been registered
        flush_rewrite_rules();
	}
}
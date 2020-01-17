<?php

class Doppler_Locator_Activator {
	public static function activate() {
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

        // Check if any templates exist
        if (count($results) <= 0) {
            // Add new page with default template
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
    }
}
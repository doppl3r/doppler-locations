<?php

class Doppler_Save {

    public function __construct($doppler_locations) {
        $this->doppler_locations = $doppler_locations;
    }

    public function save_all_post_content() {
        $this->save_general();
        $this->save_posts();
        $this->save_media();
        $this->save_links();
        $this->save_scripts();
        $this->save_users();
    }

    public function get_post_data() {
        $data = $_POST;
        if (isset($_POST['data'])) parse_str($_POST['data'], $data);
        return $data;
    }

    public function save_general() {
        // Update post data
        $data = $this->get_post_data();
        $post_id = $data['id'];
        $template_id = $data['template_id'];
        //$template_content = ''; // Set empty, the content will come from the template
        $template_content = get_post_field('post_content', $template_id);
        $post_arr = array(
            'ID' => $post_id,
            'post_title' => $data['post_title'],
            'post_name' => '',
            'post_content' => $template_content
        );
        wp_update_post($post_arr);

        // Add postmeta to newly inserted page
        update_post_meta($post_id, 'template_id', $template_id);
        update_post_meta($post_id, 'status', $data['status']);
        update_post_meta($post_id, 'display_name', $data['display_name']);
        update_post_meta($post_id, 'city', $data['city']);
        update_post_meta($post_id, 'state', $data['state']);
        update_post_meta($post_id, 'zip', $data['zip']);
        update_post_meta($post_id, 'street', $data['street']);
        update_post_meta($post_id, 'phone', $data['phone']);
        update_post_meta($post_id, 'email', $data['email']);
        update_post_meta($post_id, 'latitude', $data['latitude']);
        update_post_meta($post_id, 'longitude', $data['longitude']);
        update_post_meta($post_id, 'guide', $data['guide']);

        // Convert hours into array
        $hours = array();
        $days = array('mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun');
        foreach($days as $day) { $hours[$day] = $data[$day . '_open'] . '-' . $data[$day . '_close']; }
        update_post_meta($post_id, 'hours', json_encode($hours));

        // Flush rewrite rules when page data is saved
        flush_rewrite_rules();
    }

    public function save_posts() {
        // Parse custom posts
        $data = $this->get_post_data();
        $post_id = $data['id'];
        $custom_posts = array();
        if (!empty($data['custom_post_type'])) {
            foreach($data['custom_post_type'] as $key=>$value) {
                $custom_post_content = $data['custom_post_content'][$key];
                $custom_post_content = stripcslashes($custom_post_content); // Remove single slashes
                $custom_post_content = str_replace("\r\n", "\\n", $custom_post_content); // Double encode lines
                $custom_post_content = iconv('UTF-8', 'ASCII//TRANSLIT', $custom_post_content); // Convert to UTF-8
                $custom_post_content = esc_textarea($custom_post_content); // Escape to HTML codes

                $custom_posts[$key] = array(
                    'type' => $data['custom_post_type'][$key],
                    'title' => $data['custom_post_title'][$key],
                    'medium_id' => $data['custom_post_medium_id'][$key],
                    'link' => $data['custom_post_link'][$key],
                    'date' => $data['custom_post_date'][$key],
                    'time' => $data['custom_post_time'][$key],
                    'content' => $custom_post_content
                );
            }
        }
        update_post_meta($post_id, 'custom_posts', json_encode($custom_posts));
    }

    public function save_media() {
        // Parse media
        $data = $this->get_post_data();
        $post_id = $data['id'];
        $media = array();
        if (!empty($data['medium_post_id'])) {
            foreach($data['medium_post_id'] as $key=>$value) {
                $media[$key] = array(
                    'post_id' => $data['medium_post_id'][$key],
                    'group' => $data['medium_group'][$key]
                );
            }
        }
        update_post_meta($post_id, 'media', json_encode($media));
    }

    public function save_links() {
        // Parse links
        $data = $this->get_post_data();
        $post_id = $data['id'];
        $links = array();
        if (!empty($data['link_title'])) {
            foreach($data['link_title'] as $key=>$value) {
                $links[$key] = array(
                    'title' => $data['link_title'][$key],
                    'url' => $data['link_url'][$key],
                    'target' => $data['link_target'][$key],
                    'group' => $data['link_group'][$key]
                );
            }
        }
        update_post_meta($post_id, 'links', json_encode($links));
    }

    public function save_scripts() {
        // Parse scripts
        $data = $this->get_post_data();
        $post_id = $data['id'];
        $scripts = array();
        if (!empty($data['script_content'])) {
            foreach($data['script_content'] as $key=>$value) {
                // Prevent json_encode from converting Javascript
                $script = $data['script_content'][$key];
                $script = str_replace("\\", "\\\\", $script);
                $script = str_replace("\r\n", "\\n", $script);
                $script = esc_textarea($script);

                // Add script to list
                $scripts[$key] = array(
                    'script_load' => $data['script_load'][$key],
                    'script_content' => $script
                );
            }
        }
        update_post_meta($post_id, 'scripts', json_encode($scripts));
    }

    public function save_users() {
        // Parse users
        $data = $this->get_post_data();
        $post_id = $data['id'];
        $users = array();
        if (!empty($data['user_login'])) {
            foreach($data['user_login'] as $key=>$value) {
                $users[$key] = array(
                    'user_login' => $data['user_login'][$key]
                );
            }
        }
        update_post_meta($post_id, 'users', json_encode($users));
    }

    public function save_template() {
        // Update post data
        $data = $this->get_post_data();
        $post_id = $data['id'];
        $post_arr = array(
            'ID' => $post_id,
            'post_title' => $data['post_title'],
            'post_excerpt' => $data['post_excerpt'],
            'post_content' => $data['post_content'],
            'post_name' => ''
        );
        wp_update_post($post_arr);
        var_dump($data);
    }

    public function save_settings() {
        $data = $this->get_post_data();
        $doppler_location_slug = !empty($data['doppler_location_slug']) ? $data['doppler_location_slug'] : '';
        $doppler_location_slug = ltrim($doppler_location_slug, '/');
        $doppler_location_slug = rtrim($doppler_location_slug, '/');
        $doppler_location_public = !empty($data['doppler_location_public']) ? $data['doppler_location_public'] : true;
        update_option('doppler_location_slug', $doppler_location_slug);
        update_option('doppler_location_public', $doppler_location_public);
        flush_rewrite_rules();
    }
}
?>
<?php
    // Update post data
    $post_id = $_GET['id'];
    $template_id = $_POST['template_id'];
    //$template_content = ''; // Set empty, the content will come from the template
    $template_content = get_post_field('post_content', $template_id);
    $post_arr = array(
        'ID' => $post_id,
        'post_title' => $_POST['post_title'],
        'post_name' => '',
        'post_content' => $template_content
    );
    wp_update_post($post_arr);

    // Add postmeta to newly inserted page
    update_post_meta($post_id, 'template_id', $template_id);
    update_post_meta($post_id, 'status', $_POST['status']);
    update_post_meta($post_id, 'display_name', $_POST['display_name']);
    update_post_meta($post_id, 'city', $_POST['city']);
    update_post_meta($post_id, 'state', $_POST['state']);
    update_post_meta($post_id, 'zip', $_POST['zip']);
    update_post_meta($post_id, 'street', $_POST['street']);
    update_post_meta($post_id, 'phone', $_POST['phone']);
    update_post_meta($post_id, 'email', $_POST['email']);
    update_post_meta($post_id, 'latitude', $_POST['latitude']);
    update_post_meta($post_id, 'longitude', $_POST['longitude']);
    update_post_meta($post_id, 'guide', $_POST['guide']);

    // Convert hours into array
    $hours = array();
    $days = array('mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun');
    foreach($days as $day) { $hours[$day] = $_POST[$day . '_open'] . '-' . $_POST[$day . '_close']; }
    update_post_meta($post_id, 'hours', json_encode($hours));

    // Parse media
    $media = array();
    if (!empty($_POST['medium_post_id'])) {
        foreach($_POST['medium_post_id'] as $key=>$value) {
            $media[$key] = array(
                'post_id' => $_POST['medium_post_id'][$key],
                'group' => $_POST['medium_group'][$key]
            );
        }
    }
    update_post_meta($post_id, 'media', json_encode($media));

    // Parse custom posts
    $custom_posts = array();
    if (!empty($_POST['custom_post_type'])) {
        foreach($_POST['custom_post_type'] as $key=>$value) {
            $custom_post_content = $_POST['custom_post_content'][$key];
            $custom_post_content = stripcslashes($custom_post_content); // Remove single slashes
            $custom_post_content = str_replace("\r\n", "\\n", $custom_post_content); // Double encode lines
            $custom_post_content = iconv('UTF-8', 'ASCII//TRANSLIT', $custom_post_content); // Convert to UTF-8
            $custom_post_content = esc_textarea($custom_post_content); // Escape to HTML codes

            $custom_posts[$key] = array(
                'type' => $_POST['custom_post_type'][$key],
                'title' => $_POST['custom_post_title'][$key],
                'medium_id' => $_POST['custom_post_medium_id'][$key],
                'link' => $_POST['custom_post_link'][$key],
                'date' => $_POST['custom_post_date'][$key],
                'time' => $_POST['custom_post_time'][$key],
                'content' => $custom_post_content
            );
        }
    }
    update_post_meta($post_id, 'custom_posts', json_encode($custom_posts));

    // Parse links
    $links = array();
    if (!empty($_POST['link_title'])) {
        foreach($_POST['link_title'] as $key=>$value) {
            $links[$key] = array(
                'title' => $_POST['link_title'][$key],
                'url' => $_POST['link_url'][$key],
                'target' => $_POST['link_target'][$key],
                'group' => $_POST['link_group'][$key]
            );
        }
    }
    update_post_meta($post_id, 'links', json_encode($links));

    // Parse scripts
    $scripts = array();
    if (!empty($_POST['script_content'])) {
        foreach($_POST['script_content'] as $key=>$value) {
            // Prevent json_encode from converting Javascript
            $script = $_POST['script_content'][$key];
            $script = str_replace("\\", "\\\\", $script);
            $script = str_replace("\r\n", "\\n", $script);
            $script = esc_textarea($script);

            // Add script to list
            $scripts[$key] = array(
                'script_load' => $_POST['script_load'][$key],
                'script_content' => $script
            );
        }
    }
    update_post_meta($post_id, 'scripts', json_encode($scripts));

    // Parse users
    $users = array();
    if (!empty($_POST['user_login'])) {
        foreach($_POST['user_login'] as $key=>$value) {
            $users[$key] = array(
                'user_login' => $_POST['user_login'][$key]
            );
        }
    }
    update_post_meta($post_id, 'users', json_encode($users));
    flush_rewrite_rules();
?>
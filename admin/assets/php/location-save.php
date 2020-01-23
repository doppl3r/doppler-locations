<?php
    // Update post data
    $post_id = $_GET['id'];
    $template_id = $_POST['template'];
    $template_content = get_post_field('post_content', $template_id);
    $post_arr = array(
        'ID' => $post_id,
        'post_title' => $_POST['post_title'],
        'post_name' => '',
        'post_content' => $template_content
    );
    wp_update_post($post_arr);

    // Add postmeta to newly inserted page
    update_post_meta($post_id, 'template', $template_id);
    update_post_meta($post_id, 'status', $_POST['status']);
    update_post_meta($post_id, 'display_name', $_POST['display_name']);
    update_post_meta($post_id, 'city', $_POST['city']);
    update_post_meta($post_id, 'state', $_POST['state']);
    update_post_meta($post_id, 'zip', $_POST['zip']);
    update_post_meta($post_id, 'phone', $_POST['phone']);
    update_post_meta($post_id, 'street', $_POST['street']);
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
    if (!empty($_POST['medium_id'])) {
        foreach($_POST['medium_id'] as $key=>$value) {
            $medium_post_id = $_POST['medium_post_id'][$key];
            $medium_post_title = $_POST['medium_title'][$key];
            $media[$key] = array(
                'post_id' => $medium_post_id,
                'id' => $_POST['medium_id'][$key]
            );
            if (isset($medium_post_title)) {
                $medium_post_arr = array(
                    'ID' => $medium_post_id,
                    'post_title' => $medium_post_title,
                    'post_name' => ''
                );
                wp_update_post($medium_post_arr);
            }
        }
    }
    update_post_meta($post_id, 'media', json_encode($media));

    // Parse custom posts
    $custom_posts = array();
    if (!empty($_POST['custom_post_type'])) {
        foreach($_POST['custom_post_type'] as $key=>$value) {
            $custom_posts[$key] = array(
                'type' => $_POST['custom_post_type'][$key],
                'title' => $_POST['custom_post_title'][$key],
                'date' => $_POST['custom_post_date'][$key],
                'link' => $_POST['custom_post_link'][$key],
                'content' => $_POST['custom_post_content'][$key]
            );
        }
    }
    update_post_meta($post_id, 'custom_posts', json_encode($custom_posts));

    // Parse links
    $links = array();
    if (!empty($_POST['link_text'])) {
        foreach($_POST['link_text'] as $key=>$value) {
            $links[$key] = array(
                'text' => $_POST['link_text'][$key],
                'url' => $_POST['link_url'][$key],
                'target' => $_POST['link_target'][$key],
                'id' => $_POST['link_id'][$key]
            );
        }
    }
    update_post_meta($post_id, 'links', json_encode($links));

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

?>
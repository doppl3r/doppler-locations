<?php
    // Update post data
    $post_id = $_GET['id'];
    $post_arr = array(
        'ID' => $post_id,
        'post_title' => $_POST["post_title"],
        'post_name' => ''
    );
    wp_update_post($post_arr);

    // Add postmeta to newly inserted page
    update_post_meta($post_id, 'template', $_POST['post_template']);
    update_post_meta($post_id, 'status', $_POST['status']);
    update_post_meta($post_id, 'display_name', $_POST['display_name']);

    // Convert hours into array
    $hours = array('hours');
    $days = array('mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun');
    foreach($days as $day) { $hours[$day] = $_POST[$day . '_open'] . '-' . $_POST[$day . '_close']; }
    update_post_meta($post_id, 'hours', json_encode($hours));

    // More post meta
    update_post_meta($post_id, 'city', $_POST['city']);
    update_post_meta($post_id, 'state', $_POST['state']);
    update_post_meta($post_id, 'zip', $_POST['zip']);
    update_post_meta($post_id, 'phone', $_POST['phone']);
    update_post_meta($post_id, 'street', $_POST['street']);
    update_post_meta($post_id, 'latitude', $_POST['latitude']);
    update_post_meta($post_id, 'longitude', $_POST['longitude']);
    update_post_meta($post_id, 'guide', $_POST['guide']);
    update_post_meta($post_id, 'posts', json_encode($_POST['posts']));
    update_post_meta($post_id, 'links', json_encode($_POST['links']));
    update_post_meta($post_id, 'users', json_encode($_POST['users']));
?>
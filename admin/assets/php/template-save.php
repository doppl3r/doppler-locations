<?php
    // Update post data
    $post_id = $_GET['id'];
    $post_arr = array(
        'ID' => $post_id,
        'post_title' => $_POST['post_title'],
        'post_excerpt' => $_POST['post_excerpt'],
        'post_content' => $_POST['post_content'],
        'post_name' => ''
    );
    wp_update_post($post_arr);

?>
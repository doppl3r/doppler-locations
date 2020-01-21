<?php
    // Save data if form was submitted to this post
    if (isset($_POST['action'])) {
        require(plugin_dir_path(dirname(__FILE__)) . 'php/location-save.php');
    }

    // Get location data
    global $current_user;
    $post_id = $_GET['id'];
    $post = get_post($post_id);
    $template = get_post_meta($post_id, 'template')[0];
    $status = get_post_meta($post_id, 'status')[0];
    $display_name = get_post_meta($post_id, 'display_name')[0];
    $hours = json_decode(get_post_meta($post_id, 'hours')[0]);
    $city = get_post_meta($post_id, 'city')[0];
    $state = get_post_meta($post_id, 'state')[0];
    $zip = get_post_meta($post_id, 'zip')[0];
    $phone = get_post_meta($post_id, 'phone')[0];
    $street = get_post_meta($post_id, 'street')[0];
    $latitude = get_post_meta($post_id, 'latitude')[0];
    $longitude = get_post_meta($post_id, 'longitude')[0];
    $guide = get_post_meta($post_id, 'guide')[0];
    $custom_posts = json_decode(get_post_meta($post_id, 'custom_posts')[0]);
    $links = json_decode(get_post_meta($post_id, 'links')[0]);
    $users = json_decode(get_post_meta($post_id, 'users')[0]);
    $permission = current_user_can('administrator') ? true : false;

    // Check users to see if they have permission to edit the page ID
    if (!empty($users)) {
        foreach($users as $user) {
            if ($user->user_login == $current_user->data->user_login) {
                $permission = true; break;
            }
        }
    }

    if ($permission == false) {
        require(plugin_dir_path(dirname(__FILE__)) . 'php/location-error.php'); wp_die();
    }
?>
<div class="doppler-body loading">
    <div class="nav row">
        <div class="col-6-m">
            <h1>Location Details</h1>
        </div>
        <div class="col-6-m">
            <a class="btn" href="admin.php?page=doppler-locator">Back <span class="dashicons-before dashicons-undo"></a>
            <a class="btn blue" href="#save-location">Save</a>
        </div>
    </div>
    <form action="" method="post">
        <input type="hidden" name="action" value="save">
        <div class="tabs">
            <div class="tab active"><span class="dashicons-before dashicons-location"></span> <span class="text">General</span></div>
            <div class="tab"><span class="dashicons-before dashicons-welcome-write-blog"></span> <span class="text">Posts</span></div>
            <div class="tab"><span class="dashicons-before dashicons-admin-links"></span> <span class="text">Links</span></div>
            <div class="tab"><span class="dashicons-before dashicons-admin-users"></span> <span class="text">Users</span></div>
        </div>
        <div class="containers">
            <div class="container active"><?php require(plugin_dir_path(dirname(__FILE__)) . 'php/location-details.php'); ?></div>
            <div class="container"><?php require(plugin_dir_path(dirname(__FILE__)) . 'php/location-custom-posts.php'); ?></div>
            <div class="container"><?php require(plugin_dir_path(dirname(__FILE__)) . 'php/location-links.php'); ?></div>
            <div class="container"><?php require(plugin_dir_path(dirname(__FILE__)) . 'php/location-users.php'); ?></div>
        </div>
    </form>
</div>
<?php
    global $current_user;
    $user_list = get_users();
    $user_login = $current_user->data->user_login;
    $post_id = $_GET['id'];
    $post = get_post($post_id);
    $admin = array();

    // Search for first admin in the list
    foreach($user_list as $u){
        foreach($u->roles as $role) {
            if ($role == 'administrator') { $admin = $u; break 2; }
        }
    }
    $admin_email = $admin->data->user_email;
    $subject = "Request to edit page";
    $body = $current_user->data->user_email;

    // Update subject line
    if (isset($post_id) && $post != null) { $subject = "Request to edit location " . $post->post_title; }
?>
<div class="doppler-body loading">
    <div class="nav row">
        <div class="col-6">
            <h1>Access Denied</h1>
        </div>
        <div class="col-6">
            <a class="btn" href="admin.php?page=doppler-locations">Back <span class="dashicons-before dashicons-undo"></a>
        </div>
    </div>
    <div class="container">
        <p>You do not have permission to edit this page. Please email <a href="mailto:<?php echo $admin_email; ?>?subject=<?php echo $subject; ?>&body=<?php echo $body; ?>"><?php echo $admin_email; ?></a> for permission.</p>
    </div>
</div>
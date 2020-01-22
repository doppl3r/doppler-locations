<?php 
    // Requires location-users.php to generate variables
    $user_list = get_users();
    $user_login = $postmeta->user_login;

    // Get first user_login if none is set
    if (empty($user_login)) $user_login = $user_list[0]->data->user_login;

    $user = get_user_by('login', $user_login);
    $user_display_name = $user->data->display_name;
    $user_email = $user->data->user_email;
    $user_roles = $user->roles;
?>
<div class="row post-meta">
    <div class="col-3">
        <label class="small">Username</label>
        <select name="user_login[]">
            <?php
                
                foreach($user_list as $u){
                    $selected = '';
                    $u_login = $u->data->user_login;
                    if ($user_login == $u_login) $selected = ' selected';
                    echo '<option value="' . $u_login . '"' . $selected . '>' . $u_login . '</option>';
                }
            ?>
        </select>
    </div>
    <div class="col-3">
        <label class="small">Display Name</label>
        <input type="text" value="<?php echo $user_display_name; ?>" disabled>
    </div>
    <div class="col-3">
        <label class="small">Email</label>
        <input type="text" value="<?php echo $user_email; ?>" disabled>
    </div>
    <div class="col-3">
        <div class="row justify">
            <div class="col"><label class="small">Role(s)</label></div>
            <div class="col"><label class="small"><a href="#order-post-meta-up" class="dashicons-before dashicons-arrow-up-alt"></a></label></div>
            <div class="col"><label class="small"><a href="#order-post-meta-down" class="dashicons-before dashicons-arrow-down-alt"></a></label></div>
            <div class="col"><label class="small"><a href="#delete-post-meta-user" class="dashicons-before dashicons-trash"></a></label></div>
        </div>
        <input type="text" value="<?php echo implode(', ', $user_roles); ?>" disabled>
    </div>
</div>
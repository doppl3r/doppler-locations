<div class="row">
    <div class="col-12">
        <label>Users</label>
    </div>
</div>
<div class="post-meta-group">
    <?php
        // Declare global variables
        global $doppler_locations_plugin;

        // Loop through each user
        foreach($users as $user) {
            $doppler_locations_plugin->get_plugin_admin()->render_meta_row('user', $user);
        }
    ?>
</div>
<a class="btn" href="#add-post-meta-user">Add New User</a>
<div class="row">
    <div class="col-12">
        <label>Posts</label>
    </div>
</div>
<div class="post-meta-group">
    <?php
        // Declare global variables
        global $doppler_locations_plugin;

        // Loop through each custom post
        foreach($custom_posts as $custom_post) {
            $doppler_locations_plugin->get_plugin_admin()->render_meta_row('custom-post', $custom_post);
        }
    ?>
</div>
<a class="btn" href="#add-post-meta-custom-post">Add New Post</a>
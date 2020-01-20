<div class="row">
    <div class="col-12">
        <label>Posts</label>
    </div>
</div>
<div class="custom-posts">
    <?php
        // Declare global variables
        global $doppler_locator_plugin;

        // Loop through each custom post
        foreach($custom_posts as $custom_post) {
            $doppler_locator_plugin->get_plugin_admin()->render_custom_post($custom_post);
        }
    ?>
</div>
<a class="btn" href="#add-custom-post">Add New Post</a>
<div class="row">
    <div class="col-12">
        <label>Media</label>
    </div>
</div>
<div class="post-meta-group">
    <?php
        // Declare global variables
        global $doppler_locator_plugin;
        wp_enqueue_media();

        // Loop through each link
        foreach($media as $medium) {
            $doppler_locator_plugin->get_plugin_admin()->render_meta_row('medium', $medium);
        }
    ?>
</div>
<a class="btn" href="add-post-meta-medium">Add New Media</a>
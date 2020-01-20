<div class="row">
    <div class="col-12">
        <label>Links</label>
    </div>
</div>
<div class="post-meta-group">
    <?php
        // Declare global variables
        global $doppler_locator_plugin;

        // Loop through each link
        foreach($links as $link) {
            $doppler_locator_plugin->get_plugin_admin()->render_meta_row('link', $link);
        }
    ?>
</div>
<a class="btn" href="#add-post-meta-link">Add New Link</a>
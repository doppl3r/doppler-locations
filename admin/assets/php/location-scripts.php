<div class="row">
    <div class="col-12">
        <label>Scripts</label>
    </div>
</div>
<div class="post-meta-group">
    <?php
        // Declare global variables
        global $doppler_locations_plugin;

        // Loop through each script
        foreach($scripts as $script) {
            $doppler_locations_plugin->get_plugin_admin()->render_meta_row('script', $script);
        }
    ?>
</div>
<a class="btn" href="#add-post-meta-script">Add New Script</a>
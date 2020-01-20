<div class="doppler-body loading">
    <div class="nav row">
        <div class="col-6-m">
            <h1>Locations</h1>
        </div>
        <div class="col-6-m">
            <a class="btn" href="#add-location">Add</a>
        </div>
    </div>
    <div class="container">
        <label>Locations</label>
        <div class="row">
            <label class="small col-3-m">Status</label>
            <label class="small col-3-m">Page Title</label>
            <label class="small col-6-m">Options</label>
        </div>
        <div class="posts">
            <?php
                // Query for results
                global $doppler_locator_plugin;
                $post_type = 'location';
                $results = get_posts([ 'post_type' => $post_type, 'post_status' => 'any', 'numberposts' => -1 ]);

                // Render each row using a basic template
                foreach ($results as $row) {
                    $doppler_locator_plugin->get_plugin_admin()->render_row($post_type, $row);
                }
            ?>
        </div>
        <a class="btn" href="#add-location">Add New Location</a>
    </div>
</div>
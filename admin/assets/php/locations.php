<div class="doppler-body">
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
        <div class="locations">
            <?php
                // Query for results
                global $doppler_locator_plugin;
                $results = $doppler_locator_plugin->get_plugin_admin()->get_posts_by_type("location");

                // Render each row using a basic template
                foreach ($results as $row) {
                    $status = get_post_meta($row->ID, "status")[0];
                    $doppler_locator_plugin->get_plugin_admin()->render_location_row($row->ID, $status, $row->post_title);
                }
            ?>
        </div>
        <a class="btn" href="#add-location">Add New Location</a>
    </div>
</div>
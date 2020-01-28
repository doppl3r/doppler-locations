<div class="doppler-body loading">
    <div class="nav row">
        <div class="col-6">
            <h1>Templates</h1>
        </div>
        <div class="col-6">
            <a class="btn blue" href="#add-template">Add</a>
        </div>
    </div>
    <div class="container">
        <label>Templates</label>
        <div class="row">
            <label class="small col-3-m">Title</label>
            <label class="small col-3-m">Descriptions</label>
            <label class="small col-6-m">Options</label>
        </div>
        <div class="posts">
            <?php
                // Query for results
                global $doppler_locations_plugin;
                $post_type_template = $doppler_locations_plugin->get_post_type_template();
                $results = get_posts([ 'post_type' => $post_type_template, 'post_status' => 'any', 'numberposts' => -1 ]);

                // Render each row using a basic template
                foreach ($results as $row) {
                    $doppler_locations_plugin->get_plugin_admin()->render_row($post_type_template, $row);
                }
            ?>
        </div>
        <a class="btn" href="#add-template" value="doppler_template">Add New Template</a>
    </div>
</div>
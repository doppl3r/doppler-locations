<div class="doppler-body">
    <div class="nav row">
        <div class="col-6-m">
            <h1>Templates</h1>
        </div>
        <div class="col-6-m">
            <a class="btn" href="#add-template">Add</a>
        </div>
    </div>
    <div class="container">
        <label>Templates</label>
        <div class="row">
            <label class="small col-3-m">Title</label>
            <label class="small col-6-m">Descriptions</label>
            <label class="small col-3-m">Options</label>
        </div>
        <div class="posts">
            <?php
                // Query for results
                global $doppler_locator_plugin;
                $results = get_posts([ 'post_type' => 'template', 'post_status' => 'any', 'numberposts' => -1 ]);

                // Render each row using a basic template
                foreach ($results as $row) {
                    $doppler_locator_plugin->get_plugin_admin()->render_template_row($row);
                }
            ?>
        </div>
        <a class="btn" href="#add-template">Add New Template</a>
    </div>
</div>
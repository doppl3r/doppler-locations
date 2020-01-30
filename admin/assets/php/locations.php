<?php
    // Render page if user has permission
    $permission = current_user_can('administrator') ? true : false;
    if ($permission == false) {
        require(plugin_dir_path(dirname(__FILE__)) . 'php/location-error.php'); wp_die();
    }
?>
<div class="doppler-body loading">
    <div class="nav row">
        <div class="col-6">
            <h1>Locations</h1>
        </div>
        <div class="col-6">
            <a class="btn" href="?page=doppler-locations&post_status=trash">Trash Bin</a>
            <a class="btn blue" href="#add-location">Add</a>
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
                global $doppler_locations_plugin;
                $order_by = !empty($_GET['orderby']) ? $_GET['orderby'] : 'title';
                $order = !empty($_GET['order']) ? $_GET['order'] : 'ASC';
                $post_type = $doppler_locations_plugin->get_post_type_location();
                $results = get_posts([ 
                    'post_type' => $post_type, 
                    'post_status' => 'any', 
                    'numberposts' => -1,
                    'orderby' => $order_by,
                    'order' => $order
                ]);

                // Render each row using a basic template
                foreach ($results as $row) {
                    $doppler_locations_plugin->get_plugin_admin()->render_row($post_type, $row);
                }
            ?>
        </div>
        <a class="btn" href="#add-location" value="<?php echo $post_type; ?>">Add New Location</a>
    </div>
</div>
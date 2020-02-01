<?php
    // Render page if user has permission
    $permission = current_user_can('administrator') ? true : false;
    if ($permission == false) {
        require_once(plugin_dir_path(dirname(__FILE__)) . 'php/location-error.php'); wp_die();
    }

    // Query for results
    global $doppler_locations_plugin;
    $order_by = !empty($_GET['orderby']) ? $_GET['orderby'] : 'title';
    $order = !empty($_GET['order']) ? $_GET['order'] : 'ASC';
    $post_type = $doppler_locations_plugin->get_post_type_location();
    $post_status_filter = $doppler_locations_plugin->get_post_status();
    $trash_count = $doppler_locations_plugin->get_plugin_admin()->get_post_count($post_type, 'trash');
    $publish_count = $doppler_locations_plugin->get_plugin_admin()->get_post_count($post_type, 'publish');
    $results = get_posts([
        'post_type' => $post_type,
        'post_status' => $post_status_filter,
        'numberposts' => -1,
        'orderby' => $order_by,
        'order' => $order
    ]);
?>
<div class="doppler-body loading">
    <div class="nav row">
        <div class="col-6">
            <h1>Locations</h1>
        </div>
        <div class="col-6">
            <?php if ($post_status_filter == 'publish') : ?>
                <a class="btn" href="?page=doppler-locations&post_status=trash">Trash Bin <?php echo '(' . $trash_count . ')'; ?></a>
                <a class="btn blue" href="#add-location" value="doppler_location">Add</a>
            <?php else : ?>
                <a class="btn" href="?page=doppler-locations">Published <?php echo '(' . $publish_count . ')'; ?></a>
            <?php endif; ?>
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
                // Show volume status
                if ($post_status_filter == 'trash' && $trash_count <= 0) echo '<div class="row empty">Trash is empty</div>';
                
                // Loop through each result
                foreach ($results as $row) {
                    $doppler_locations_plugin->get_plugin_admin()->render_row($post_type, $post_status_filter, $row);
                }
            ?>
        </div>
        <?php if ($post_status_filter == 'publish') : ?><a class="btn" href="#add-location" value="doppler_location">Add New Location</a><?php endif; ?>
    </div>
</div>
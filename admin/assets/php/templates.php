<?php
    // Query for results
    global $doppler_locations_plugin;
    $post_type_template = $doppler_locations_plugin->get_post_type_template();
    $post_status = $doppler_locations_plugin->get_post_status();
    $trash_count = $doppler_locations_plugin->get_plugin_admin()->get_post_count($post_type_template, 'trash');
    $publish_count = $doppler_locations_plugin->get_plugin_admin()->get_post_count($post_type_template, 'publish');
    $results = get_posts([
        'post_type' => $post_type_template,
        'post_status' => $post_status,
        'numberposts' => -1
    ]);
?>
<div class="doppler-body loading">
    <div class="nav row">
        <div class="col-6">
            <h1>Templates</h1>
        </div>
        <div class="col-6">
        <?php if ($post_status == 'any') : ?><a class="btn" href="?page=doppler-locations-template&post_status=trash">Trash Bin <?php echo '(' . $trash_count . ')'; ?></a>
            <?php else : ?><a class="btn" href="?page=doppler-locations-template">Published <?php echo '(' . $publish_count . ')'; ?></a><?php endif; ?>
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
                // Show volume status
                if ($post_status == 'any' && $publish_count <= 0) echo '<div class="row empty">No locations</div>';
                else if ($post_status == 'trash' && $trash_count <= 0) echo '<div class="row empty">Trash is empty</div>';

                // Loop through each result
                foreach ($results as $row) {
                    $doppler_locations_plugin->get_plugin_admin()->render_row($post_type_template, $post_status, $row);
                }
            ?>
        </div>
        <?php if ($post_status == 'any') : ?><a class="btn" href="#add-template" value="doppler_template">Add New Template</a><?php endif; ?>
    </div>
</div>
<?php
    // Get plugin object
    global $doppler_locations_plugin;

    // Save data if form was submitted to this post
    if (isset($_POST['action'])) {
        $doppler_locations_plugin->get_plugin_admin()->get_doppler_save()->save_template();
    }

    // Get template data
    $post_id = $_GET['id'];
    $post = get_post($post_id);
    $post_title = $post->post_title;
    $post_excerpt = get_the_excerpt($post_id);
    $post_content = $post->post_content;
?>
<div class="doppler-body loading">
    <div class="nav row">
        <div class="col-6">
            <h1>Template Details</h1>
        </div>
        <div class="col-6">
            <a class="btn" href="?page=doppler-locations-template">Back</a>
            <a class="btn blue" href="#save-location">Save</a>
        </div>
    </div>
    <form action="" method="post">
        <input type="hidden" name="action" value="save">
        <div class="container">
            <?php require_once(plugin_dir_path(dirname(__FILE__)) . 'php/template-details.php'); ?>
        </div>
    </form>
</div>
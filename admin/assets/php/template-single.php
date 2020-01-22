<?php
    // Save data if form was submitted to this post
    if (isset($_POST['action'])) {
        require(plugin_dir_path(dirname(__FILE__)) . 'php/template-save.php');
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
        <div class="col-6-m">
            <h1>Template Details</h1>
        </div>
        <div class="col-6-m">
            <a class="btn" href="admin.php?page=doppler-locator-template">Back</a>
            <a class="btn blue" href="#save-location">Save</a>
        </div>
    </div>
    <form action="" method="post">
        <input type="hidden" name="action" value="save">
        <div class="container">
            <?php require(plugin_dir_path(dirname(__FILE__)) . 'php/template-details.php'); ?>
        </div>
    </form>
</div>
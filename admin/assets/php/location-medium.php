<?php 
    // Requires location-links.php to generate variables
    $post_id = $postmeta->post_id;
    $title = get_the_title($post_id);
    $url = wp_get_attachment_image_src($post_id)[0];
    $id = $postmeta->id;
?>
<div class="row post-meta">
    <input type="hidden" name="medium_post_id[]" value="<?php echo $post_id; ?>">
    <div class="col-6">
        <div class="row">
            <div class="col thumbnail">
                <label class="small">Type</label>
                <div style="background-image: url('<?php echo $url; ?>');"></div>
            </div>
            <div class="col">
                <label class="small">URL</label>
                <input type="text" value="<?php echo $url; ?>" disabled>
            </div>
        </div>
    </div>
    <div class="col-3">
        <label class="small">Title</label>
        <input type="text" value="<?php echo $title; ?>" disabled>
    </div>
    <div class="col-3">
        <div class="row justify">
            <div class="col"><label class="small">ID</label></div>
            <div class="col"><label class="small"><a href="#delete-post-meta-medium" class="dashicons-before dashicons-trash"></a></label></div>
        </div>
        <input type="text" value="<?php echo $id; ?>" name="medium_id[]">
    </div>
</div>
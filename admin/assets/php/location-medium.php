<?php 
    // Requires location-links.php to generate variables
    $post_id = $postmeta->post_id;
    $title = get_the_title($post_id);
    $url = wp_get_attachment_url($post_id);
    $type = end(explode('.', $url));
    $id = $postmeta->id;
?>
<div class="row post-meta">
    <input type="hidden" name="medium_post_id[]" value="<?php echo $post_id; ?>">
    <div class="col-6">
        <div class="row">
            <div class="col thumbnail">
                <label class="small">Type</label>
                <div class="upload_image_button" style="background-image: url('<?php echo $url; ?>');"><?php if ($type == 'pdf') echo $type; ?></div>
            </div>
            <div class="col">
                <label class="small">URL</label>
                <input class="upload_image_button" type="text" name="medium_url[]" value="<?php echo $url; ?>" placeholder="Click to add media">
            </div>
        </div>
    </div>
    <div class="col-3">
        <label class="small">Title</label>
        <input type="text" name="medium_title[]" value="<?php echo $title; ?>">
    </div>
    <div class="col-3">
        <div class="row justify">
            <div class="col"><label class="small">ID</label></div>
            <div class="col"><label class="small"><a href="#order-post-meta-up" class="dashicons-before dashicons-arrow-up-alt"></a></label></div>
            <div class="col"><label class="small"><a href="#order-post-meta-down" class="dashicons-before dashicons-arrow-down-alt"></a></label></div>
            <div class="col"><label class="small"><a href="#delete-post-meta-medium" class="dashicons-before dashicons-trash"></a></label></div>
        </div>
        <input type="text" name="medium_id[]" value="<?php echo $id; ?>">
    </div>
</div>
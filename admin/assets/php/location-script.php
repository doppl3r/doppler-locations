<?php 
    // Requires location-scripts.php to generate variables
    $content = $postmeta->script_content;
    $content = str_replace('\\', '', $content);
?>
<div class="row post-meta">
    <div class="col-12">
        <div class="row justify">
            <div class="col"><label class="small">Script</label></div>
            <div class="col"><label class="small"><a href="#order-post-meta-up" class="dashicons-before dashicons-arrow-up-alt"></a></label></div>
            <div class="col"><label class="small"><a href="#order-post-meta-down" class="dashicons-before dashicons-arrow-down-alt"></a></label></div>
            <div class="col"><label class="small"><a href="#delete-post-meta-script" class="dashicons-before dashicons-trash"></a></label></div>
        </div>
        <textarea name="script_content[]"><?php echo $content; ?></textarea>
    </div>
</div>
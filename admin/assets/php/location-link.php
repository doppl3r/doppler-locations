<?php 
    // Requires location-links.php to generate variables
    $text = $postmeta->text;
    $url = $postmeta->url;
    $target = $postmeta->target;
    $id = $postmeta->id;
?>
<div class="row post-meta">
    <div class="col-3">
        <label class="small">Text</label>
        <input type="text" name="link_text[]" value="<?php echo $text; ?>">
    </div>
    <div class="col-3">
        <label class="small">URL</label>
        <input type="text" name="link_url[]" value="<?php echo $url; ?>">
    </div>
    <div class="col-3">
        <label class="small">Target</label>
        <select name="link_target[]">
            <?php
                $t_arr = array('_self', '_blank');
                foreach($t_arr as $t) {
                    $selected = '';
                    if ($target == $t) $selected = ' selected';
                    echo '<option value="' . $t . '"' . $selected . '>' . ucfirst($t) . '</option>';
                }
            ?>
        </select>
    </div>
    <div class="col-3">
        <div class="row justify">
            <div class="col"><label class="small">ID</label></div>
            <div class="col"><label class="small"><a href="#order-post-meta-up" class="dashicons-before dashicons-arrow-up-alt"></a></label></div>
            <div class="col"><label class="small"><a href="#order-post-meta-down" class="dashicons-before dashicons-arrow-down-alt"></a></label></div>
            <div class="col"><label class="small"><a href="#delete-post-meta-link" class="dashicons-before dashicons-trash"></a></label></div>
        </div>
        <input type="text" name="link_id[]" value="<?php echo $id; ?>">
    </div>
</div>
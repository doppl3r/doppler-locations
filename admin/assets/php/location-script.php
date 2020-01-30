<?php 
    // Requires location-scripts.php to generate variables
    $script_load = $postmeta->script_load;
    $script_content = str_replace('\\', '', $postmeta->script_content);
?>
<div class="row post-meta">
    <div class="col-3">
        <label class="small">Load</label>
        <select name="script_load[]">
            <?php
                $script_load_options = array('footer', 'body', 'inline');
                foreach($script_load_options as $s) {
                    $selected = '';
                    if ($script_load == $s) $selected = ' selected';
                    echo '<option value="' . $s . '"' . $selected . '>' . ucfirst($s) . '</option>';
                }
            ?>
        </select>
    </div>
    <div class="col-9">
        <div class="row justify">
            <div class="col"><label class="small">Script</label></div>
            <div class="col"><label class="small"><a href="#order-post-meta-up" class="dashicons-before dashicons-arrow-up-alt"></a></label></div>
            <div class="col"><label class="small"><a href="#order-post-meta-down" class="dashicons-before dashicons-arrow-down-alt"></a></label></div>
            <div class="col"><label class="small"><a href="#delete-post-meta-script" class="dashicons-before dashicons-trash"></a></label></div>
        </div>
        <textarea name="script_content[]"><?php echo $script_content; ?></textarea>
    </div>
</div>
<?php 
    // Requires location-links.php to generate variables
    $text = $postmeta->text;
    $url = $postmeta->url;
    $target = $postmeta->target;
    $class = $postmeta->class;
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
            <div class="col"><label class="small">Class</label></div>
            <div class="col"><label class="small"><a href="#delete-post-meta-link">Delete</a></label></div>
        </div>
        <input type="text" name="link_class[]" value="<?php echo $class; ?>">
    </div>
</div>
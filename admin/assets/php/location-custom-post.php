<?php 
    // Requires location-custom-posts.php to generate variables
    $type = $postmeta->type;
    $title = $postmeta->title;
    $date = $postmeta->date;
    $link = $postmeta->link;
    $content = $postmeta->content;
?>
<div class="row post-meta">
    <div class="col-6">
        <div class="row">
            <div class="col-6">
                <label class="small">Type</label>
                <select name="custom_post_type[]">
                    <?php
                        $p_arr = array('news', 'event');
                        foreach($p_arr as $p) {
                            $selected = '';
                            if ($type == $p) $selected = ' selected';
                            echo '<option value="' . $p . '"' . $selected . '>' . ucfirst($p) . '</option>';
                        }
                    ?>
                </select>
            </div>
            <div class="col-6">
                <label class="small">Title</label>
                <input type="text" name="custom_post_title[]" value="<?php echo $title; ?>">
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <label class="small">Date</label>
                <input type="text" name="custom_post_date[]" value="<?php echo $date; ?>">
            </div>
            <div class="col-6">
                <label class="small">Link</label>
                <input type="text" name="custom_post_link[]" value="<?php echo $link; ?>">
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="row justify">
            <div class="col"><label class="small">Content</label></div>
            <div class="col"><label class="small"><a href="#delete-post-meta-custom-post" class="dashicons-before dashicons-trash"></a></label></div>
        </div>
        <textarea name="custom_post_content[]"><?php echo $content; ?></textarea>
    </div>
</div>
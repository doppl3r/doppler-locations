<?php 
    // Requires location-custom-posts.php to generate variables
    $type = $postmeta->type;
    $title = $postmeta->title;
    $medium_id = $postmeta->medium_id;
    $link = $postmeta->link;
    $date = $postmeta->date;
    $time = $postmeta->time;
    $content = $postmeta->content;
?>
<div class="row post-meta">
    <div class="col-6">
        <div class="row">
            <div class="col-6">
                <label class="small">Type</label>
                <select name="custom_post_type[]">
                    <?php
                        $p_arr = array('event', 'news', 'other');
                        foreach($p_arr as $p) {
                            $selected = '';
                            if ($type == $p) $selected = ' selected';
                            echo '<option value="' . $p . '"' . $selected . '>' . $p . '</option>';
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
                <label class="small"><span class="dashicons-before dashicons-admin-media"></span> Media ID</label>
                <select name="custom_post_medium_id[]" data="<?php echo $medium_id; ?>"></select>
            </div>
            <div class="col-6">
                <label class="small"><span class="dashicons-before dashicons-admin-links"></span> Link</label>
                <input type="text" name="custom_post_link[]" value="<?php echo $link; ?>">
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <label class="small"><span class="dashicons-before dashicons-calendar-alt"></span> Date</label>
                <input type="text" name="custom_post_date[]" value="<?php echo $date; ?>" autocomplete="off">
            </div>
            <div class="col-6">
                <label class="small"><span class="dashicons-before dashicons-clock"></span> Time</label>
                <input type="text" name="custom_post_time[]" value="<?php echo $time; ?>" placeholder="ex: 2-3pm">
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="row justify">
            <div class="col"><label class="small">Content</label></div>
            <div class="col"><label class="small"><a href="#order-post-meta-up" class="dashicons-before dashicons-arrow-up-alt"></a></label></div>
            <div class="col"><label class="small"><a href="#order-post-meta-down" class="dashicons-before dashicons-arrow-down-alt"></a></label></div>
            <div class="col"><label class="small"><a href="#delete-post-meta-custom-post" class="dashicons-before dashicons-trash"></a></label></div>
        </div>
        <textarea name="custom_post_content[]"><?php echo $content; ?></textarea>
    </div>
</div>
<?php 
    /* Required variables: $post_status, $row (query results) */
    $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
    $url_edit = site_url() . '/wp-admin/admin.php?page=doppler-locations-template';
?>
<div class="row" data-post="<?php echo $row->ID; ?>">
    <div class="col-3-m title"><?php echo $row->post_title; ?></div>
    <div class="col-3-m description"><?php echo $row->post_excerpt; ?></div>
    <div class="col-6-m options">
        <?php if ($post_status == 'any') : ?>
            <label class="small"><a href="<?php echo $url_edit; ?>&id=<?php echo $row->ID; ?>">Edit</a></label>
            <label class="small"><a href="#trash-post">Trash</a></label>
        <?php else : ?>
            <label class="small"><a href="#restore-post">Restore</a></label>
            <label class="small"><a href="#delete-post">Delete</a></label>
        <?php endif; ?>
    </div>
</div>
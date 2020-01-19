<?php 
    /* Required variables: $row (query results) */
    $status = get_post_meta($row->ID, "status")[0];
    $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
    $url_edit = site_url() . '/wp-admin/admin.php?page=doppler-locator';
    $url_view = get_post_permalink($row->ID);
?>
<div class="row" data-post="<?php echo $row->ID; ?>">
    <div class="col-3-m status <?php echo strtolower($status); ?>"><label class="small"><?php echo $status; ?></label></div>
    <div class="col-3-m title"><?php echo $row->post_title; ?></div>
    <div class="col-6-m options">
        <label class="small"><a href="<?php echo $url_edit; ?>&id=<?php echo $row->ID; ?>">Edit</a></label>
        <label class="small"><a href="<?php echo $url_view; ?>" target="_blank">View</a></label>
        <label class="small"><a href="#delete">Delete</a></label>
    </div>
</div>
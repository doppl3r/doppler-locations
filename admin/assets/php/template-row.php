<?php 
    /* Required variables: $row (query results) */
    $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
    $url_full = $url . "$_SERVER[REQUEST_URI]";
?>
<div class="row" data-post="<?php echo $row->ID; ?>">
    <div class="col-3-m title"><?php echo $row->post_title; ?></div>
    <div class="col-6-m description"><?php echo $row->post_excerpt; ?></div>
    <div class="col-3-m options">
        <label class="small"><a href="<?php echo $url_full; ?>&id=<?php echo $row->ID; ?>">Edit</a></label>
        <label class="small"><a href="#delete">Delete</a></label>
    </div>
</div>
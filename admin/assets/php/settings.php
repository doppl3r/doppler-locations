<?php
    // Save data if form was submitted to this post
    if (isset($_POST['action'])) {
        $doppler_location_slug = !empty($_POST['doppler_location_slug']) ? $_POST['doppler_location_slug'] : '';
        $doppler_location_slug = ltrim($doppler_location_slug, '/');
        $doppler_location_slug = rtrim($doppler_location_slug, '/');
        update_option('doppler_location_slug', $doppler_location_slug);
        flush_rewrite_rules();
    }

    // Initialize variables
    $doppler_location_slug = get_option('doppler_location_slug');
?>
<div class="doppler-body loading">
    <div class="nav row">
        <div class="col-6">
            <h1>Settings</h1>
        </div>
        <div class="col-6">
            <a class="btn blue" href="#save-settings">Save</a>
        </div>
    </div>
    <form action="" method="post">
        <input type="hidden" name="action" value="save">
        <div class="container">
            <label>Settings</label>
            <div class="row">
                <label class="small col-6-m">Option Name</label>
                <label class="small col-6-m">Option Value</label>
            </div>
            <div class="posts options">
                <div class="row option">
                    <div class="col-6-m name">doppler_location_slug</div>
                    <div class="col-6-m value">
                    <input type="text" name="doppler_location_slug" placeholder="ex: locations" value="<?php echo $doppler_location_slug; ?>">
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
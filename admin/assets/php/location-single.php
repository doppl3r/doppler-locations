<?php
    $post_id = $_GET['id'];
    $post = get_post($post_id);
    $template = get_post_meta($post_id, 'template');
    $status = get_post_meta($post_id, 'status');
    $name = get_post_meta($post_id, 'name');
    $hours = json_decode(get_post_meta($post_id, 'hours')[0]);
    $city = get_post_meta($post_id, 'city');
    $state = get_post_meta($post_id, 'state');
    $zip = get_post_meta($post_id, 'zip');
    $phone = get_post_meta($post_id, 'phone');
    $street = get_post_meta($post_id, 'street');
    $latitude = get_post_meta($post_id, 'latitude');
    $longitude = get_post_meta($post_id, 'longitude');
    $guide = get_post_meta($post_id, 'guide');
    $posts = json_decode(get_post_meta($post_id, 'posts')[0]);
    $links = json_decode(get_post_meta($post_id, 'links')[0]);
    $users = json_decode(get_post_meta($post_id, 'users')[0]);
?>
<div class="doppler-body">
    <div class="nav row">
        <div class="col-6-m">
            <h1>Location Details</h1>
        </div>
        <div class="col-6-m">
            <a class="btn" href="#save-location">Save</a>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-6 page-title">
                <label for="page-title">Title</label>
                <input id="page-title" name="page-title" type="text" value="<?php echo $post->post_title; ?>">
            </div>
            <div class="col-3 page-template">
                <label for="page-template">Template</label>
                <!-- TODO: populate from template types -->
                <select id="page-template" name="page-template">
                    <option value="Default">Default</option>
                </select>
            </div>
            <div class="col-3 page-status">
                <label for="page-status">Status</label>
                <select id="page-status" name="page-status">
                    <option value="Open">Open</option>
                    <option value="Open">Coming Soon</option>
                    <option value="Open">Closed</option>
                    <option value="Open">Other</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <div class="row">
                    <div class="col-12 page-name">
                        <label for="page-name">Name</label>
                        <input id="page-name" name="page-name" type="text">
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 hours">
                        <label>Hours</label>
                        <div class="row">
                            <div class="col-2-m"><label class="small">Day</label></div>
                            <div class="col-5-m"><label class="small">Open</label></div>
                            <div class="col-5-m"><label class="small">Close</label></div>
                        </div>
                        <?php
                            $days = array('mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun');
                            foreach($days as $day) {
                        ?>
                        <div class="row">
                            <div class="col-2-m"><label><?php echo ucfirst($day); ?></label></div>
                            <div class="col-5-m"><select name="<?php echo $day; ?>-open" id="<?php echo $day; ?>-open"><?php require(plugin_dir_path(dirname(__FILE__)) . 'php/hours.php'); ?></select></div>
                            <div class="col-5-m"><select name="<?php echo $day; ?>-close" id="<?php echo $day; ?>-close"><?php require(plugin_dir_path(dirname(__FILE__)) . 'php/hours.php'); ?></select></div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="row">
                    <div class="col-6 city">
                        <label for="city">City</label>
                        <input name="city" id="city" type="text">
                    </div>
                    <div class="col-6 state">
                        <label for="state">State</label>
                        <select name="state" id="state">
                            <?php require(plugin_dir_path(dirname(__FILE__)) . 'php/states.php'); ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 zip">
                        <label for="zip">Zip</label>
                        <input name="zip" id="zip" type="text">
                    </div>
                    <div class="col-6 phone">
                        <label for="phone">Phone</label>
                        <input name="phone" id="phone" type="tel">
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <label for="street">Street</label>
                        <input name="street" id="street" type="text">
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <label for="latitude">Latitude</label>
                        <input name="latitude" id="latitude" type="text">
                    </div>
                    <div class="col-6">
                        <label for="longitude">Longitude</label>
                        <input name="longitude" id="longitude" type="text">
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <label for="guide">Guide</label>
                        <input name="guide" id="guide" type="text">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
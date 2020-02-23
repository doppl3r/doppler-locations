<div class="row">
    <div class="col-3 post-title">
        <label for="post-title">Page Title</label>
        <input id="post-title" name="post_title" type="text" value="<?php echo $post->post_title; ?>">
    </div>
    <div class="col-3 display-name">
        <label for="display-name">Display Name</label>
        <input id="display-name" name="display_name" type="text" value="<?php echo $display_name; ?>">
    </div>
    <div class="col-3 template-id">
        <label for="template-id">Template</label>
        <select id="template-id" name="template_id">
            <?php
                $templates = get_posts([ 'post_type' => $post_type_template, 'post_status' => 'publish', 'numberposts' => -1 ]);
                foreach ($templates as $t) {
                    $selected = '';
                    if ($template == $t->ID) $selected = ' selected';
                    echo '<option value="' . $t->ID . '"' . $selected . '>' . $t->post_title . '</option>';
                }
            ?>
        </select>
    </div>
    <div class="col-3 status">
        <label for="status">Status</label>
        <select id="status" name="status">
            <?php
                $status_arr = array('open', 'closed', 'coming soon', 'other');
                foreach($status_arr as $s) {
                    $selected = '';
                    if ($status == $s) $selected = ' selected';
                    echo '<option value="' . $s . '"' . $selected . '>' . ucfirst($s) . '</option>';
                }
            ?>
        </select>
    </div>
</div>
<div class="row">
    <div class="col-6">
        <div class="row">
            
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
                    <div class="col-5-m"><select name="<?php echo $day; ?>_open"><?php $interval = 0; require(plugin_dir_path(dirname(__FILE__)) . 'php/hours.php'); ?></select></div>
                    <div class="col-5-m"><select name="<?php echo $day; ?>_close"><?php $interval = 1; require(plugin_dir_path(dirname(__FILE__)) . 'php/hours.php'); ?></select></div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="row">
            <div class="col-6 city">
                <label for="city">City</label>
                <input name="city" id="city" type="text" value="<?php echo $city; ?>">
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
                <input name="zip" id="zip" type="text" value="<?php echo $zip; ?>">
            </div>
            <div class="col-6">
                <label for="street">Street</label>
                <input name="street" id="street" type="text" value="<?php echo $street; ?>">
            </div>
            
        </div>
        <div class="row">
            <div class="col-6 phone">
                <label for="phone">Phone</label>
                <input name="phone" id="phone" type="tel" value="<?php echo $phone; ?>">
            </div>
            <div class="col-6 email">
                <label for="email">Email</label>
                <input name="email" id="email" type="email" value="<?php echo $email; ?>">
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <label for="latitude">Latitude</label>
                <input name="latitude" id="latitude" type="text" value="<?php echo $latitude; ?>">
            </div>
            <div class="col-6">
                <label for="longitude">Longitude</label>
                <input name="longitude" id="longitude" type="text" value="<?php echo $longitude; ?>">
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <label for="guide">Guide</label>
                <input name="guide" id="guide" type="text" value="<?php echo $guide; ?>">
            </div>
            <div class="col-6 map-link">
                <label for="map-link">Map Link</label>
                <input id="map-link" name="map_link" type="text" value="<?php echo $map_link; ?>">
            </div>
        </div>
    </div>
</div>
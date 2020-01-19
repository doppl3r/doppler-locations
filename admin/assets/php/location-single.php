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
                <input id="page-title" name="page-title" type="text">
            </div>
            <div class="col-3 page-template">
                <label for="page-template">Template</label>
                <!-- TODO: populate from template types -->
                <select id="page-template" name="page-template">
                    <option value="Default">Default</option>
                </select>
            </div>
            <div class="col-3 page-title">
                <label for="page-title">Title</label>
                <input id="page-title" name="page-title" type="text">
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
                        <?php // TODO: Loop through each day and select from database ?>
                        <div class="row">
                            <div class="col-2-m"><label class="small">Day</label></div>
                            <div class="col-5-m"><label class="small">Open</label></div>
                            <div class="col-5-m"><label class="small">Close</label></div>
                        </div>
                        <div class="row">
                            <div class="col-2-m"><label>Mon</label></div>
                            <div class="col-5-m"><select name="mon-open" id="mon-open"><?php require(plugin_dir_path(dirname(__FILE__)) . 'php/hours.php'); ?></select></div>
                            <div class="col-5-m"><select name="mon-close" id="mon-close"><?php require(plugin_dir_path(dirname(__FILE__)) . 'php/hours.php'); ?></select></div>
                        </div>
                        <div class="row">
                            <div class="col-2-m"><label>Tue</label></div>
                            <div class="col-5-m"><select name="tue-open" id="tuev-open"><?php require(plugin_dir_path(dirname(__FILE__)) . 'php/hours.php'); ?></select></div>
                            <div class="col-5-m"><select name="tue-close" id="tue-close"><?php require(plugin_dir_path(dirname(__FILE__)) . 'php/hours.php'); ?></select></div>
                        </div>
                        <div class="row">
                            <div class="col-2-m"><label>Wed</label></div>
                            <div class="col-5-m"><select name="wed-open" id="wed-open"><?php require(plugin_dir_path(dirname(__FILE__)) . 'php/hours.php'); ?></select></div>
                            <div class="col-5-m"><select name="wed-close" id="wed-close"><?php require(plugin_dir_path(dirname(__FILE__)) . 'php/hours.php'); ?></select></div>
                        </div>
                        <div class="row">
                            <div class="col-2-m"><label>Thu</label></div>
                            <div class="col-5-m"><select name="thu-open" id="thu-open"><?php require(plugin_dir_path(dirname(__FILE__)) . 'php/hours.php'); ?></select></div>
                            <div class="col-5-m"><select name="thu-close" id="thu-close"><?php require(plugin_dir_path(dirname(__FILE__)) . 'php/hours.php'); ?></select></div>
                        </div>
                        <div class="row">
                            <div class="col-2-m"><label>Fri</label></div>
                            <div class="col-5-m"><select name="fri-open" id="fri-open"><?php require(plugin_dir_path(dirname(__FILE__)) . 'php/hours.php'); ?></select></div>
                            <div class="col-5-m"><select name="fri-close" id="fri-close"><?php require(plugin_dir_path(dirname(__FILE__)) . 'php/hours.php'); ?></select></div>
                        </div>
                        <div class="row">
                            <div class="col-2-m"><label>Sat</label></div>
                            <div class="col-5-m"><select name="sat-open" id="sat-open"><?php require(plugin_dir_path(dirname(__FILE__)) . 'php/hours.php'); ?></select></div>
                            <div class="col-5-m"><select name="sat-close" id="sat-close"><?php require(plugin_dir_path(dirname(__FILE__)) . 'php/hours.php'); ?></select></div>
                        </div>
                        <div class="row">
                            <div class="col-2-m"><label>Sun</label></div>
                            <div class="col-5-m"><select name="sun-open" id="sun-open"><?php require(plugin_dir_path(dirname(__FILE__)) . 'php/hours.php'); ?></select></div>
                            <div class="col-5-m"><select name="sun-close" id="sun-close"><?php require(plugin_dir_path(dirname(__FILE__)) . 'php/hours.php'); ?></select></div>
                        </div>
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
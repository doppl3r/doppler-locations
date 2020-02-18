<div class="row">
    <div class="col-6 post-title">
        <label for="post-title">Title</label>
        <input id="post-title" name="post_title" type="text" value="<?php echo $post_title; ?>">
    </div>
    <div class="col-6 post-excerpt">
        <label for="post-excerpt">Description</label>
        <input id="post-excerpt-title" name="post_excerpt" type="text" value="<?php echo $post_excerpt; ?>">
    </div>
</div>
<div class="row">
    <div class="col-6 post-content">
        <label for="post-content">Content</label>
        <textarea id="post-content" name="post_content" type="text"><?php echo $post_content; ?></textarea>
    </div>
    <div class="col-6 post-options">
        <label for="post-options">Shortcode Options</label>
        <div class="short-codes">
            <label>Location Details</label>
            <p>
                [doppler_locations data="title"]<br>
                [doppler_locations data="status"]<br>
                [doppler_locations data="display_name"]<br>
                [doppler_locations data="hours"]<br>
                [doppler_locations data="city"]<br>
                [doppler_locations data="state"]<br>
                [doppler_locations data="zip"]<br>
                [doppler_locations data="phone"]<br>
                [doppler_locations data="street"]<br>
                [doppler_locations data="latitude"]<br>
                [doppler_locations data="longitude"]<br>
                [doppler_locations data="guide"]
            </p>
            <label>Media</label>
            <p>
                [doppler_locations data="media" group="slider"]
                [doppler_locations data="media" group="gallery"]
            </p>
            <label>Posts</label>
            <p>
                [doppler_locations data="list" type="event"]<br>
                [doppler_locations data="list" type="news"]
            </p>
            <label>Links</label>
            <p>
                [doppler_locations data="links" group="email"]
            </p>
            <label>Scripts</label>
            <p>
                [doppler_locations data="scripts"]
            </p>
            <label>List</label>
            <p>
                [doppler_locations data="list"]<br>
                [doppler_locations data="list" type="location" group="state"]<br>
                [doppler_locations data="list" type="event" group="state"]<br>
                [doppler_locations data="list" type="post group="state"]
            </p>
            <label>Map</label>
            <p>
                [doppler_locations data="map"]
            </p>
        </div>
    </div>
</div>
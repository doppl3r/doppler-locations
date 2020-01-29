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
                [dl data="title"]<br>
                [dl data="status"]<br>
                [dl data="display_name"]<br>
                [dl data="hours"]<br>
                [dl data="city"]<br>
                [dl data="state"]<br>
                [dl data="zip"]<br>
                [dl data="phone"]<br>
                [dl data="street"]<br>
                [dl data="latitude"]<br>
                [dl data="longitude"]<br>
                [dl data="guide"]
            </p>
            <label>Media</label>
            <p>
                [dl data="media" id="your-id"]<br>
                [dl data="media" id="group-id"]
            </p>
            <label>Posts</label>
            <p>
                [dl data="posts" type="news"]<br>
                [dl data="posts" type="event"]
            </p>
            <label>Links</label>
            <p>[dl data="links" id="email"]</p>
            <label>Scripts</label>
            <p>[dl data="scripts"]</p>
            <label>List</label>
            <p>[dl data="list"]</p>
            <p>[dl data="list" group="state"]</p>
            <label>Map</label>
            <p>[dl data="map"]</p>
        </div>
    </div>
</div>
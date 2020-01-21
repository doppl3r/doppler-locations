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
            <p>[title] [template] [status] [name] [hours] [city] [state] [zip] [phone] [street] [latitude] [longitude] [guide]</p>
            <label>Media</label>
            <p>[media id="your-id"]</p>
            <label>Posts</label>
            <p>[posts type="event"] [posts type="news"]</p>
            <label>Links</label>
            <p>[link text="your-text"]</p>
            <label>Map</label>
            <p>[map]</p>
        </div>
    </div>
</div>
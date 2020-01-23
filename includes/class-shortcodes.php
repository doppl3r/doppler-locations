<?php
    //echo get_the_ID(); die;
    function doppler_shortcode($atts, $content = null) {
        $post_id = get_the_ID();
        $post_meta = get_post_meta($post_id);
        $data = $atts['data'];
        $type = $atts['type'];
        $id = $atts['id'];

        //var_dump($post_meta); die;

        switch ($data) {
            case 'title': return get_the_title($post_id); break;
            case 'hours':
                $output = '';
                $hours = json_decode($post_meta['hours'][0]);
                foreach($hours as $key=>$day) {
                    $output .= '<li><span>'. $key. '</span> <span>' . $hours->$key . '</span></li>';
                }
                $output = '<ul>' . $output . '</ul>';
                return $output;
            break;
            case 'media':
                $output = '';
                $media = json_decode($post_meta['media'][0]);
                foreach($media as $medium) {
                    $medium_id = $medium->id;
                    $medium_post_id = $medium->post_id;
                    $medium_url = wp_get_attachment_url($medium_post_id);
                    $medium_title = get_the_title($medium_post_id);
                    $medium_alt = get_post_meta($medium_post_id, '_wp_attachment_image_alt')[0];
                    $medium_type = explode("/", get_post_mime_type($medium_post_id))[0];
                    
                    // Loop through all assets or by group id
                    if (!isset($id) || $id == $medium_id) {
                        switch ($medium_type) {
                            case "image": $output .= '<img alt="' . $medium_alt . '" src="' . $medium_url . '" />'; break;
                            case "audio": $output .= '<audio src="' . $medium_url . '" controls>' . $medium_title . '</audio>'; break;
                            case "video": $output .= '<video src="' . $medium_url . '" controls>' . $medium_title . '</video>'; break;
                            default: $output .= '<a href="' . $medium_url . '" target="_blank">' . $medium_title . '</a>'; break;
                        }
                    }
                }
                return $output;
            break;
            case 'posts':
                $output = '';
                $posts = json_decode($post_meta['custom_posts'][0]);
                foreach($posts as $post) {
                    $post_type = $post->type;
                    $post_title = $post->title;
                    $post_date = $post->date;
                    $post_link = $post->link;
                    $post_content = $post->content;
                    
                    if (!isset($type) || $type == $post_type) {
                        $output .= '
                            <ul class="row '. $post_type .'">
                                <li class="col">' . $post_title . '</li>
                                <li class="col">' . $post_date . '</li>
                                <li class="col">' . $post_link . '</li>
                                <li class="col">' . $post_content . '</li>
                            </ul>
                        ';
                    }
                }
                return $output;
            break;
            case 'links':
                $output = '';
                $links = json_decode($post_meta['links'][0]);
                foreach($links as $link) {
                    $link_text = $link->text;
                    $link_url = $link->url;
                    $link_target = $link->target;
                    $link_id = $link->id;
                    
                    if (!isset($id) || $id == $link_id) {
                        $output .= '<a href="'. $link_url .'" target="' . $link_target . '">' . $link_text . '</a>';
                    }
                }
                return $output;
            break;
            case 'map':
                $output = '';
                return $output; break;
            default: return $post_meta[$data][0]; break;
        }
    }
    add_shortcode('dl', 'doppler_shortcode');
?>
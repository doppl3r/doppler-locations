<?php
    function doppler_shortcode($atts, $content = null) {
        global $doppler_locations_plugin;
        $post_id = get_the_ID();
        $post_meta = get_post_meta($post_id);
        $post_type = get_post_type($post_id);
        $post_type_location = $doppler_locations_plugin->get_post_type_location();
        $data = $atts['data'];
        $type = $atts['type'];
        $id = $atts['id'];
        $width = $atts['width'];
        $height = $atts['height'];
        $group = $atts['group'];
        $style = '';
        $output = '';

        // Apply grix grid system if shortcode is used
        wp_enqueue_style('grix');

        if ($data == 'title') { return get_the_title($post_id); }
        else if ($data == 'hours') {
            $hours = json_decode($post_meta['hours'][0]);
            foreach($hours as $key=>$day) {
                $time = explode('-', $hours->$key);
                $open = $time[0];
                $close = $time[1];
                $output .= '<li><span>'. $key. '</span> <span>' . $open . ' - ' . $close . '</span></li>';
            }
            $output = '<ul>' . $output . '</ul>';
            return $output;
        }
        else if ($data == 'media') {
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
        }
        else if ($data == 'posts') {
            $posts = json_decode($post_meta['custom_posts'][0]);
            foreach($posts as $post) {
                $custom_post_type = $post->type;
                $custom_post_title = $post->title;
                $custom_post_date = $post->date;
                $custom_post_link = $post->link;
                $custom_post_content = $post->content;
                
                if (!isset($type) || $type == $custom_post_type) {
                    $output .= '
                        <ul class="'. $custom_post_type .'">
                            <li class="title">' . $custom_post_title . '</li>
                            <li class="date">' . $custom_post_date . '</li>
                            <li class="link">' . $custom_post_link . '</li>
                            <li class="content">' . $custom_post_content . '</li>
                        </ul>
                    ';
                }
            }
            return $output;
        }
        else if ($data == 'links' || $data == 'link') {
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
        }
        else if ($data == 'scripts' || $data == 'script') {
            //wp_enqueue_script('scripts-shortcode');
            global $scripts;
            $scripts = json_decode($post_meta['scripts'][0]);
            add_action('wp_footer', function() { global $scripts; add_inline_scripts($scripts); });
        }
        else if ($data == 'list') {
            // Generate JSON array for later
            $json_locations = get_locations([
                'post_id' => $post_id, 
                'post_type' => $post_type, 
                'post_type_location' => $post_type_location
            ]); 

            // Populate group_array by list value
            $group_array = array();
            foreach($json_locations as $group_key => $element) {
                if (empty($group)) $group_id = $group_key;
                else $group_id = $group;
                $group_array[$element[$group_id]][] = $element;
            }

            // Loop through each list group. Ex: states
            foreach($group_array as $group_key => $group_item) {
                if (empty($group)) $group_title = 'Locations';
                else $group_title = $group_key;
                $output .= '<li><a class="title" aria-selected="false" href="#">' . $group_title . '</a><ul class="container">';
                // Loop through each group item
                foreach($group_item as $loc_key => $loc) {
                    $output .=
                        '<li>' .
                            '<ul class="location">' .
                                '<li class="location-title"><a href="' . $group_item[$loc_key]['link'] . '">' . $group_item[$loc_key]['display_name'] . '</a></li>' .
                                '<li class="location-phone"><a href="tel:' . $group_item[$loc_key]['phone'] . '">' . $group_item[$loc_key]['phone'] . '</a></li>' .
                                '<li class="location-address"><a href="https://www.google.com/maps/place/' . $group_item[$loc_key]['address'] . '" target="_blank">' . $group_item[$loc_key]['address'] . '</a></li>' .
                            '</ul>' .
                        '</li>';
                }
                $output .= '</ul></li>';
            }
            $output = '<ul class="doppler-list">' .  $output . '</ul>';
            return $output;
        }
        else if ($data == 'map') {
            // Build style attribute
            if (!empty($width) || !empty($height)) {
                if (!empty($width)) $width = 'width: ' . $width . '; ';
                if (!empty($height)) $height = 'height: ' . $height . '; ';
                $style = 'style="' . $width . $height . '"';
            }

            // Enqueue data if map exists
            wp_enqueue_style('leaflet');
            wp_enqueue_script('leaflet');
            wp_enqueue_script('leaflet-doppler-locations');
            wp_enqueue_style('leaflet-doppler-locations');

            // Update URL for front-end icon path
            $url = explode('/', plugin_dir_url( __FILE__ ));
            array_pop($url);
            array_pop($url);
            $dir = implode('/', $url) . '/public/assets/';

            // Generate JSON array for later
            $json_locations = get_locations([
                'post_id' => $post_id, 
                'post_type' => $post_type, 
                'post_type_location' => $post_type_location
            ]);

            // Send array to the front end
            wp_localize_script( 'leaflet-doppler-locations', 'locations', $json_locations );
            wp_localize_script( 'leaflet-doppler-locations', 'path', $dir );

            // Render leaflet map HTML
            $output .= '<div id="leaflet-map" ' . $style . '></div>';
            
            return $output;
        }
        else { 
            // Default condition assumes a post meta tag search by $data value
            return $post_meta[$data][0]; 
        }
    }
    add_shortcode('dl', 'doppler_shortcode');

    function get_locations($arr){
        // Use single location if 'location' is set, default = all
        if ($arr['post_type'] == $arr['post_type_location']) $post__in = array($arr['post_id']);

        // Get posts by location and matching ID
        $locations = get_posts([
            'post_type' => $arr['post_type_location'],
            'post_status' => 'any',
            'numberposts' => -1,
            'post__in' => $post__in
        ]);

        // Generate JSON for Javascript object
        foreach($locations as $index => $loc) {
            $loc_title = get_the_title($loc->ID);
            $loc_url = get_post_permalink($loc->ID);;
            $loc_display_name = get_post_meta($loc->ID, 'display_name')[0];
            $loc_phone = get_post_meta($loc->ID, 'phone')[0];
            $loc_street = get_post_meta($loc->ID, 'street')[0];
            $loc_city = get_post_meta($loc->ID, 'city')[0];
            $loc_state = get_post_meta($loc->ID, 'state')[0];
            $loc_zip = get_post_meta($loc->ID, 'zip')[0];
            $loc_addr = $loc_street . ', ' . $loc_city . ', ' . $loc_state . ' ' . $loc_zip;
            $loc_lat = get_post_meta($loc->ID, 'latitude')[0];
            $loc_long = get_post_meta($loc->ID, 'longitude')[0];
            $loc_geo = array($loc_lat, $loc_long);

            // Fix any missing names
            if (empty($loc_display_name)) $loc_display_name = $loc_title;

            // Populate JSON array
            $json_locations[$index]['display_name'] = $loc_display_name;
            $json_locations[$index]['link'] = $loc_url;
            $json_locations[$index]['phone'] = $loc_phone;
            $json_locations[$index]['street'] = $loc_street;
            $json_locations[$index]['city'] = $loc_city;
            $json_locations[$index]['state'] = $loc_state;
            $json_locations[$index]['zip'] = $loc_zip;
            $json_locations[$index]['address'] = $loc_addr;
            $json_locations[$index]['geo'] = $loc_geo;
        }
        return $json_locations;
    }

    function add_inline_scripts($scripts) {
        foreach($scripts as $script) {
            $script_content = $script->script_content;
            $script_content = str_replace('\\', '', $script_content);
            $script_content = htmlspecialchars_decode($script_content, ENT_QUOTES);
            // wp_add_inline_script( 'scripts-shortcode', $script_content );

            // Resolve missing script tags
            if (strpos($script_content, '<script>') !== false) { $output .= $script_content; }
            else { $output .= '<script>' . $script_content . '</script>'; }
            echo $output;
        }
    }
?>
<?php
################### PODCASTS FROM JSON FILE
add_action('init', 'podcasts_from_json');
function podcasts_from_json() {
    $json = plugin_dir_path( __FILE__ ) . 'assets/podcasts-by-genre.json';
    $podcasts = json_decode(file_get_contents($json), false); // "False" returns an Object and "True" returns an associative array

    // Check if it's emtpy
    if(empty($podcasts)) { return; }

    // If syncronization is turned off
    $sync = get_option('options_force_json');
    if($sync == 'no') { return; }

    // List of IDs to set featured image - Starts as an empty array
    $ids_to_set_featured_images = array();

    // Looping through categories
    foreach($podcasts as $podcast) {

        // Firstly, let's grab the 'name' property to be added as a taxonomy term
        $category = $podcast->name;

        // Getting all podcasts inside the category
        foreach($podcast->podcasts as $list) {

            // All values (check if property exists in the JSON to avoid errors like 'not defined') because a few seem to be optional
            if(property_exists($list, 'id')) { $external_id = $list->id; }
            if(property_exists($list, 'title')) { $title = $list->title; }
            if(property_exists($list, 'publisher')) { $publisher = $list->publisher; }
            if(property_exists($list, 'thumbnail')) { $thumbnail = $list->thumbnail; }
            if(property_exists($list, 'listennotes_url')) { $listennotes = $list->listennotes_url; }
            if(property_exists($list, 'total_episodes')) { $episodes = $list->total_episodes; }
            if(property_exists($list, 'description')) { $description = $list->description; }
            if(property_exists($list, 'explicit_content')) { $explicit = ( $list->explicit_content == true ) ? 'yes' : 'no'; }
            if(property_exists($list, 'itunes_id')) { $itunes = $list->itunes_id; }
            if(property_exists($list, 'rss')) { $rss = $list->rss; }
            if(property_exists($list, 'country')) { $country = $list->country; }
            if(property_exists($list, 'language')) { $language = $list->language; }
            if(property_exists($list, 'website')) { $website = $list->website; }
            if(property_exists($list, 'is_claimed')) { $is_claimed = ( $list->is_claimed == true ) ? 'yes' : 'no'; }
            if(property_exists($list, 'type')) { $type = $list->type; }
            if(property_exists($list, 'genre_ids')) { $genres = $list->genre_ids; }

            // If the external ID already exists inside a post, let's skip it and add the other ones (it needs to be removed from the TRASH as well)
            global $wpdb;
            $podcast_exists = $wpdb->get_results("select * from $wpdb->postmeta where meta_key='podcast_external_id' and meta_value='$external_id'");
            if(count($podcast_exists) == 0) {
                // Inserting post
                $podcast_id = wp_insert_post(array(
                    'post_title'=> ucfirst($title),
                    'post_type'=> 'podcasts',
                    'post_status' => 'publish'
                ));
                // Updating values for the existing fields
                if(isset($external_id)) { update_post_meta($podcast_id, 'podcast_external_id', $external_id); }
                if(isset($thumbnail)) { update_post_meta($podcast_id, 'podcast_thumbnail_url', $thumbnail); }
                if(isset($publisher)) { update_post_meta($podcast_id, 'podcast_publisher', $publisher); }
                if(isset($listennotes)) { update_post_meta($podcast_id, 'podcast_listennotes', $listennotes); }
                if(isset($episodes)) { update_post_meta($podcast_id, 'podcast_total_episodes', $episodes); }
                if(isset($explicit)) { update_post_meta($podcast_id, 'podcast_explicit', $explicit); }
                if(isset($description)) { update_post_meta($podcast_id, 'podcast_description', $description); }
                if(isset($itunes)) { update_post_meta($podcast_id, 'podcast_itunes_id', $itunes); }
                if(isset($rss)) { update_post_meta($podcast_id, 'podcast_rss', $rss); }
                if(isset($language)) { update_post_meta($podcast_id, 'podcast_language', $language); }
                if(isset($country)) { update_post_meta($podcast_id, 'podcast_country', $country); }
                if(isset($website)) { update_post_meta($podcast_id, 'podcast_website', $website); }
                if(isset($is_claimed)) { update_post_meta($podcast_id, 'podcast_claimed', $is_claimed); }
                if(isset($genres)) { update_post_meta($podcast_id, 'podcast_genres', $genres); }

                // Setting taxonomy term for the PodCast (category) - Created above: Line 15
                wp_set_object_terms($podcast_id, $category, 'podcasts_cat'); // Technology, Web Design

                // Setting taxonomy term for the PodCast (Type)
                wp_set_object_terms($podcast_id, ucfirst($type), 'podcasts_type'); // Episodic 
                
                // Add this new post ID to the list of IDs to set featurd image
                $ids_to_set_featured_images[] = $podcast_id;
                
            } // Checked if podcast already exists by its external ID

        } // End foreach for podcasts

    } // End foreach for all podcast categories

    // If list of new IDs is not empty, runs custom function and set featured images for them
    if(!empty($ids_to_set_featured_images)) {
        upload_image_to_library($ids_to_set_featured_images);                                     
    }

} // End of main function
?>
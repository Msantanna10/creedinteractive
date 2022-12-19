<?php
################### ENDPOINT - REST API
add_action('rest_api_init', 'add_custom_login_api');
function add_custom_login_api(){
  register_rest_route('podcasts/v1',
    'all/',
    array(
        'methods' => 'GET',
        'callback' => 'podcasts_api',
    )
  );
}

// Callback function
function podcasts_api($request) {

    $data = array();

    // Custom parameters
    $count = ($request['count']) ? $request['count'] : -1; // 'count' retrieves a specific number of podcasts. Otherwise, shows all
    $paged = ($request['page']) ? intval($request['page']) : 1; // 'page' allows pagination. Otherwise, shows all or only a specific number of podcasts

    // GET POSTS
    $args = array(
        'post_type' => 'podcasts',
        'posts_per_page' => $count,
        'orderby' => 'date',
        'order' => 'DESC',
        'paged' => $paged
    );
    $the_query = new WP_Query( $args );
    
    if ( $the_query->have_posts() ) {
        $i = 0;
        while ( $the_query->have_posts() ) : $the_query->the_post();
        $data['podcasts'][$i]['title'] = get_the_title();
        $data['podcasts'][$i]['external_id'] = get_post_meta(get_the_ID(), 'podcast_external_id', true);
        $data['podcasts'][$i]['publisher'] = get_post_meta(get_the_ID(), 'podcast_publisher', true);
        $data['podcasts'][$i]['listennotes'] = get_post_meta(get_the_ID(), 'podcast_listennotes', true);
        $data['podcasts'][$i]['total_episodes'] = get_post_meta(get_the_ID(), 'podcast_total_episodes', true);
        $data['podcasts'][$i]['explicit'] = get_post_meta(get_the_ID(), 'podcast_explicit', true);
        $data['podcasts'][$i]['description'] = get_post_meta(get_the_ID(), 'podcast_description', true);
        $data['podcasts'][$i]['itunes_id'] = get_post_meta(get_the_ID(), 'podcast_itunes_id', true);
        $data['podcasts'][$i]['rss'] = get_post_meta(get_the_ID(), 'podcast_rss', true);
        $data['podcasts'][$i]['language'] = get_post_meta(get_the_ID(), 'podcast_language', true);
        $data['podcasts'][$i]['country'] = get_post_meta(get_the_ID(), 'podcast_country', true);
        $data['podcasts'][$i]['website'] = get_post_meta(get_the_ID(), 'podcast_website', true);
        $data['podcasts'][$i]['claimed'] = get_post_meta(get_the_ID(), 'podcast_claimed', true);
        $data['podcasts'][$i]['thumbnail'] = wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()), 'thumbnail' );
        $data['podcasts'][$i]['thumbnail_small'] = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'square' )[0];
        $data['podcasts'][$i]['genres'] = get_post_meta(get_the_ID(), 'podcast_genres', true);
        $i++;
        endwhile;        
        wp_reset_postdata();

        $data['total'] = $the_query->found_posts;
        $data['all_pages'] = (!$request['count']) ? 1 : ceil($the_query->found_posts / $count); // Rounds up
        $data['current_page'] = $paged;
        $status = 200; // Ok
    }
    else {
        $status = 403; // Forbidden
        $data['message'] = 'There\'s no podcast available';
    }

    // Returns response
    $data['status'] = $status;
    $response = new WP_REST_Response($data);    
    $response->set_status($status);

    return $response;

    // Examples:
    // mysite.com/wp-json/podcasts/v1/all
    // mysite.com/wp-json/podcasts/v1/all?count=10
    // mysite.com/wp-json/podcasts/v1/all?count=5&page=2

}
?>
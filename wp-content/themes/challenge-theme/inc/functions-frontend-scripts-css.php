<?php
##################### SCRIPTS
function custom_script_frontend() {
    // De-register the built in jQuery
    wp_deregister_script('jquery');
    // Register the CDN version
    wp_register_script('jquery', 'https://code.jquery.com/jquery-3.6.2.min.js', array(), null, false); 
    // Load new jquery
    wp_enqueue_script( 'jquery' );
    // Global scripts
    wp_enqueue_script('global', get_template_directory_uri() .'/src/js/global.js?' . date('l jS \of F Y h:i:s A'), array('jquery'), null, true);
    // Style CSS
    wp_enqueue_style( 'style', get_template_directory_uri() .'/style.css?' . date('l jS \of F Y h:i:s A'), false, '1.0', 'all' );

    // Homepage
    if(is_home() || is_front_page()) {
        wp_enqueue_script('homepage-js', get_template_directory_uri() .'/src/js/homepage.js?' . date('l jS \of F Y h:i:s A'), array('jquery'), null, true);
        // Pass PHP variables to the JS file
        wp_localize_script('homepage-js', 'objVars', [
            'site_url' => home_url(),
            'theme_url' => get_bloginfo('template_url'),
        ]);
    }

}
add_action( 'wp_enqueue_scripts', 'custom_script_frontend' );
?>
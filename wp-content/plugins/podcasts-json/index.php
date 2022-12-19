<?php
/**
* Plugin Name: Podcasts from JSON
* Plugin URI: http://www.creedinteractive.com
* Description: Awesome custom plugin to add PodCasts from a JSON file.
* Version: 1.0
* Author: Creed Interactive
* Author URI: http://www.creedinteractive.com
**/

// Create custom post type and custom fields
require_once(plugin_dir_path( __FILE__ ) . 'post-type.php');

// Custom function to set featured image from external URL
require_once(plugin_dir_path( __FILE__ ) . 'upload-image-to-library.php');

// Add podcasts from JSON
require_once(plugin_dir_path( __FILE__ ) . 'podcasts-from-json.php');

// Custom column for featured image
require_once(plugin_dir_path( __FILE__ ) . 'custom-columns.php');

// Custom endpoint - Rest API
require_once(plugin_dir_path( __FILE__ ) . 'custom-endpoint.php');

// Custom options page - "Global options" in the left menu
require_once(plugin_dir_path( __FILE__ ) . 'options-page.php');
?>
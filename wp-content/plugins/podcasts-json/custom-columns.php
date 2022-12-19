<?php
#################### CUSTOM COLUMN (Featured Image)

// Set custom image sizes
add_image_size('image_1920', 1920); // Max width + auto height
add_image_size('image_700', 700);
add_image_size('image_500', 500);
add_image_size('square', 150, 150);

// Adds thumbnail
add_action('manage_posts_custom_column', 'posts_custom_columns', 5, 2);
function posts_custom_columns($column_name, $id){
    $thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $id ), 'square' );
    if($column_name === 'Thumbnail' && !empty($thumb)){
        echo '<div id="thumb" style="background-image: url(' . $thumb[0] . ');"></div>';
    }
}

// Move the new column to the first place.
add_filter('manage_posts_columns', 'podcasts_column_order');
function podcasts_column_order($columns) {
  $n_columns = array();
  $move = 'Thumbnail'; // Which column to move
  $before = 'title'; // Move it before this column

  foreach($columns as $key => $value) {
    if ($key == $before){
      $n_columns[$move] = $move;
    }
    $n_columns[$key] = $value;
  }
  return $n_columns;
}

// Format the column width with CSS
add_action('admin_head', 'podcasts_add_admin_styles');
function podcasts_add_admin_styles() { ?>
<style>
.column-Thumbnail {width: 150px;}
.column-Thumbnail #thumb {width: 100px;height: 100px;background-size: cover;background-position: center;background-color: #e8e8e8;}
</style>
<?php } ?>
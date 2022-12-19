<?php
################### CUSTOM CPT - Podcast
add_action( 'init', 'cpt_podcast' );
function cpt_podcast() {

  $labels = array(
    'name'               => 'Podcasts',
    'singular_name'      => 'Podcasts',
    'add_new'            => 'Add podcast',
    'add_new_item'       => 'Add new podcast',
    'edit_item'          => 'Edit podcast',
    'new_item'           => 'New podcast',
    'all_items'          => 'All podcasts',
    'view_item'          => 'View podcast',
    'search_items'       => 'Search podcast',
    'featured_image'        => 'Featured image',
    'set_featured_image'    => 'Select an image',
    'remove_featured_image' => 'Remove image',
    'use_featured_image'    => 'Use as image',
  );
 
  $args = array(
    'labels'            => $labels,
    'public'            => true,
    'menu_position'     => 5,
    'supports'          => array( 'title', 'thumbnail', 'editor' ),
    'has_archive'       => false,
    'show_in_admin_bar' => true,
    'show_in_nav_menus' => false,
    'publicly_queryable'  => false,
    'show_in_rest'       => true, // To use Gutenberg editor.
    'menu_icon'         => 'dashicons-microphone',    
  );
  register_post_type( 'podcasts', $args);
}

################### ADD THUMBNAIL SUPPORT
add_theme_support('post-thumbnails', array('podcasts'));

################### PODCAST - "TYPE" TAXONOMY
add_action( 'init', 'add_type_taxonomy_podcast', 0 );
function add_type_taxonomy_podcast() {
	register_taxonomy('podcasts_type', 'podcasts', array(
    'hierarchical' => true,
    'show_admin_column' => true,
    'labels' => array(
    'name' => 'Type',
    'singular_name' => 'Type',
    'search_items' =>  'Search',
    'all_items' => 'All types',
    'parent_item' => 'Parent',
    'parent_item_colon' => 'Parent',		
    'edit_item' => 'Edit type',
    'update_item' => 'Update type',
    'add_new_item' => 'Add type',
    'new_item_name' => 'New type',
    'menu_name' => 'Types',    
    ),
    'rewrite' => array('with_front' => false),
    'public' => false,
    'show_ui' => true,
    'show_in_rest' => true
    )
	);
}

################### PODCAST - "CATEGORY" TAXONOMY
add_action( 'init', 'add_category_taxonomy_podcast', 0 );
function add_category_taxonomy_podcast() {
	register_taxonomy('podcasts_cat', 'podcasts', array(
    'hierarchical' => true,
    'show_admin_column' => true,
    'labels' => array(
    'name' => 'Category',
    'singular_name' => 'Category',
    'search_items' =>  'Search',
    'all_items' => 'All categories',
    'parent_item' => 'Parent',
    'parent_item_colon' => 'Parent',		
    'edit_item' => 'Edit category',
    'update_item' => 'Update category',
    'add_new_item' => 'Add category',
    'new_item_name' => 'New category',
    'menu_name' => 'Category',    
    ),
    'rewrite' => array('with_front' => false),
    'public' => false,
    'show_ui' => true,
    'show_in_rest' => true
    )
	);
}

################### CUSTOM FIELDS
// Adds custom metabox
add_action( 'add_meta_boxes', 'podcast_meta_box' );
function podcast_meta_box() {
  add_meta_box(
    'podcast_id', // Metabox ID
    'Podcast Details', // Metabox title
    'podcast_meta_box_callback', // Metabox function callback
    'podcasts' // Post type
  );
}

// Callback
function podcast_meta_box_callback( $post ) {

  // Add a nonce field so we can check for it later.
  wp_nonce_field( 'podcast_save_meta_box_data', 'podcast_meta_box_nonce' );

  // Get current field values
  $external_id = get_post_meta( $post->ID, 'podcast_external_id', true );
  $thumbnail_url = get_post_meta( $post->ID, 'podcast_thumbnail_url', true );
  $publisher = get_post_meta( $post->ID, 'podcast_publisher', true );
  $listennotes = get_post_meta( $post->ID, 'podcast_listennotes', true );
  $total_episodes = get_post_meta( $post->ID, 'podcast_total_episodes', true );
  $explicit = get_post_meta( $post->ID, 'podcast_explicit', true );
  $description = get_post_meta( $post->ID, 'podcast_description', true );
  $itunesId = get_post_meta( $post->ID, 'podcast_itunes_id', true );
  $rss = get_post_meta( $post->ID, 'podcast_rss', true );
  $language = get_post_meta( $post->ID, 'podcast_language', true );
  $country = get_post_meta( $post->ID, 'podcast_country', true );
  $website = get_post_meta( $post->ID, 'podcast_website', true );
  $is_claimed = get_post_meta( $post->ID, 'podcast_claimed', true );
  $genres = get_post_meta( $post->ID, 'podcast_genres', true );
  
  // DISPLAY FIELDS
  ?>
  
  <table class="form-table">
    <!-- FIELD -->
    <tr valign="top">
      <th scope="row">
        <label for="podcast_external_id">External ID</label>
      </th>
      <td>                  
        <input type="text" id="podcast_external_id" name="podcast_external_id" value="<?php echo esc_attr( $external_id ) ?>" readonly/>
        <input type="hidden" id="podcast_thumbnail_url" name="podcast_thumbnail_url" value="<?php echo esc_attr( $thumbnail_url ) ?>" readonly/>
      </td>                
    </tr>
    <!-- FIELD -->
    <tr valign="top">
      <th scope="row">
        <label for="podcast_publisher">Publisher</label>
      </th>
      <td>                  
        <input type="text" id="podcast_publisher" name="podcast_publisher" value="<?php echo esc_attr( $publisher ) ?>"/>
      </td>                
    </tr>
    <!-- FIELD -->
    <tr valign="top">
      <th scope="row">
        <label for="podcast_listennotes">Listen Notes URL</label>
      </th>
      <td>                  
        <input type="url" id="podcast_listennotes" name="podcast_listennotes" value="<?php echo esc_attr( $listennotes ) ?>" pattern="https://.*"/>
        <p class="description">https://</p>
      </td>                
    </tr>
    <!-- FIELD -->
    <tr valign="top">
      <th scope="row">
        <label for="podcast_total_episodes">Total Episodes</label>
      </th>
      <td>                  
        <input type="number" id="podcast_total_episodes" name="podcast_total_episodes" value="<?php echo esc_attr( $total_episodes ) ?>" min="0" oninput="validity.valid||(value='');"/>
      </td>                
    </tr>
    <!-- FIELD -->
    <tr valign="top">
      <th scope="row">
        <label for="podcast_explicit">Explicit Content</label>
      </th>
      <td>         
        <select name="podcast_explicit" id="podcast_explicit">
          <option value="no" <?php selected( esc_attr( $explicit ) , 'no' ); ?>>No</option>
          <option value="yes" <?php selected( esc_attr( $explicit ) , 'yes' ); ?>>Yes</option>
        </select>                 
      </td>                
    </tr>
    <!-- FIELD -->
    <tr valign="top">
      <th scope="row">
        <label for="podcast_description">Description</label>
      </th>
      <td>         
        <textarea name="podcast_description" id="podcast_description" cols="30" rows="5"><?php echo esc_attr( $description ); ?></textarea>                 
      </td>                
    </tr>
    <!-- FIELD -->
    <tr valign="top">
      <th scope="row">
        <label for="podcast_itunes_id">Itunes ID</label>
      </th>
      <td>         
      <input type="number" id="podcast_itunes_id" name="podcast_itunes_id" value="<?php echo esc_attr( $itunesId ) ?>" min="0" oninput="validity.valid||(value='');"/>
      </td>                
    </tr>
    <!-- FIELD -->
    <tr valign="top">
      <th scope="row">
        <label for="podcast_rss">RSS</label>
      </th>
      <td>                  
        <input type="url" id="podcast_rss" name="podcast_rss" value="<?php echo esc_attr( $rss ) ?>" pattern="https://.*"/>
        <p class="description">https://</p>
      </td>                
    </tr>
    <!-- COUNTRY -->
    <tr valign="top">
      <th scope="row">
        <label for="podcast_country">Country</label>
      </th>
      <td>                  
        <input type="text" id="podcast_country" name="podcast_country" value="<?php echo esc_attr( $country ) ?>"/>
      </td>                
    </tr>
    <!-- COUNTRY -->
    <tr valign="top">
      <th scope="row">
        <label for="podcast_language">Language</label>
      </th>
      <td>                  
        <input type="text" id="podcast_language" name="podcast_language" value="<?php echo esc_attr( $language ) ?>"/>
      </td>                
    </tr>
    <!-- FIELD -->
    <tr valign="top">
      <th scope="row">
        <label for="podcast_website">Website</label>
      </th>
      <td>                  
        <input type="url" id="podcast_website" name="podcast_website" value="<?php echo esc_attr( $website ) ?>" pattern="https://.*"/>
        <p class="description">https://</p>
      </td>                
    </tr>
    <!-- FIELD -->
    <tr valign="top">
      <th scope="row">
        <label for="podcast_claimed">Claimed?</label>
      </th>
      <td>         
        <select name="podcast_claimed" id="podcast_claimed">
          <option value="no" <?php selected( esc_attr( $explicit ) , 'no' ); ?>>No</option>
          <option value="yes" <?php selected( esc_attr( $explicit ) , 'yes' ); ?>>Yes</option>
        </select>                 
      </td>                
    </tr>
    <!-- FIELD -->
    <tr valign="top">
      <th scope="row">
        <label for="podcast_genres">Genres</label>
      </th>
      <td>         
        <div id="genres">
          <?php

          // If "Genres" is not empty, loops through each ID and add fields
          if(!empty($genres)) {            
            // Array total count
            $genres = (count($genres) > 1) ? array_filter($genres) : $genres; // Remove empty values only if it has more than one ID (we'll always need at least one field)
            $count = 0; // Starts custom counter for the loop
            foreach($genres as $id) { $count++; ?>
            <div id="singleID">
              <input type="number" id="podcast_genres" name="podcast_genres[]" value="<?php echo $id; ?>" min="0" oninput="validity.valid||(value='');" />              
              <?php // If it's not the first one, adds the 'Remove ID' button
              if($count > 1) { echo '<span>Remove ID</span>'; }?>
            </div>
          <?php } // End foreach
          } // End If

          // If has no ID on the list, shows an empty field
          else { ?>
            <div id="singleID">
              <input type="number" id="podcast_genres" name="podcast_genres[]" value="" min="0" oninput="validity.valid||(value='');" />
            </div>
          <?php } ?>      
        </div> 
        <button onClick="newGenreID(); return false;">Add new ID</button>              
      </td>                
    </tr>
  </table>  

  <?php }

  // VALIDATION & UPDATE
  function podcast_save_meta_box_data( $post_id ) {

    // Check if nonce exists
    if ( ! isset( $_POST['podcast_meta_box_nonce'] ) ) {
        return;
    }
    
    // If none exists, check if it's a valid nonce
    if ( ! wp_verify_nonce( $_POST['podcast_meta_box_nonce'], 'podcast_save_meta_box_data' ) ) {
      return;
    }
    
    // Stop WP from clearing custom fields on autosave
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
      return;
    }
     
    // Saves field values  
    update_post_meta( $post_id, 'podcast_external_id', sanitize_text_field( $_POST['podcast_external_id'] ) ); // External ID (sanitized value)
    update_post_meta( $post_id, 'podcast_thumbnail_url', sanitize_text_field( $_POST['thumbnail_url'] ) ); // Thumbnail URL (sanitized value)
    update_post_meta( $post_id, 'podcast_publisher', sanitize_text_field( $_POST['podcast_publisher'] ) ); // Publisher (sanitized value)
    update_post_meta( $post_id, 'podcast_listennotes', sanitize_text_field( $_POST['podcast_listennotes'] ) ); // Listen Notes (sanitized value)
    update_post_meta( $post_id, 'podcast_total_episodes', sanitize_text_field( $_POST['podcast_total_episodes'] ) ); // Total Episodes (sanitized value)
    update_post_meta( $post_id, 'podcast_explicit', sanitize_text_field( $_POST['podcast_explicit'] ) ); // Explicit Content (sanitized value)
    update_post_meta( $post_id, 'podcast_description', sanitize_textarea_field( $_POST['podcast_description'] ) ); // Description (sanitized value)
    update_post_meta( $post_id, 'podcast_itunes_id', sanitize_text_field( $_POST['podcast_itunes_id'] ) ); // Itunes ID (sanitized value)
    update_post_meta( $post_id, 'podcast_rss', sanitize_text_field( $_POST['podcast_rss'] ) ); // RSS (sanitized value)
    update_post_meta( $post_id, 'podcast_country', sanitize_text_field( $_POST['podcast_country'] ) ); // Country (sanitized value)
    update_post_meta( $post_id, 'podcast_language', sanitize_text_field( $_POST['podcast_language'] ) ); // Language (sanitized value)
    update_post_meta( $post_id, 'podcast_website', sanitize_text_field( $_POST['podcast_website'] ) ); // Website (sanitized value)
    update_post_meta( $post_id, 'podcast_claimed', sanitize_text_field( $_POST['podcast_claimed'] ) ); // Is Claimed? (sanitized value)
    update_post_meta( $post_id, 'podcast_genres', $_POST['podcast_genres'] ); // Genres Array

}
add_action( 'save_post', 'podcast_save_meta_box_data' );

################### CUSTOM SCRIPT TO ADD NEW FIELDS (Genre IDs)
add_action('admin_footer', 'custom_js_new_genre_id');
function custom_js_new_genre_id() { ?>
<script>
// Adds new field
function newGenreID() {
  var input = '<div id="singleID"><input type="number" id="podcast_genres" name="podcast_genres[]" value="" min="0" oninput="validity.valid||(value=\'\');" /><span>Remove ID</span></div>';
  jQuery('#genres').append(input);
}

// Removes field
jQuery('body').on('click','#singleID span', function(){
  jQuery(this).closest('#singleID').remove();
});
</script>
<?php
}

################### CUSTOM CSS (Genre IDs)
add_action('admin_head', 'custom_css_new_genre_id');
function custom_css_new_genre_id() { ?>
<style>
/* Removes arrows from number fields */
input::-webkit-outer-spin-button, input::-webkit-inner-spin-button, input[type=number] {-webkit-appearance: none;-moz-appearance: textfield;margin: 0;}

/* All inputs */
#podcast_id input, #podcast_id select, #podcast_id textarea {width: 100%;max-width: 400px;}
#podcast_id #singleID input {max-width: 100px}

/* Genre IDs fields */
#singleID {margin-bottom: 5px;display: flex;}
#singleID span {display: grid;align-content: center;margin-left: 10px;cursor: pointer;font-style: italic;}

/* Add New Button */
#genres + button {background-color: #1d2327;border: 0px;border-radius: 5px;padding: 8px 14.5px;color: white;cursor: pointer;}
#genres + button:hover {opacity: 0.7;}
</style>
<?php } ?>
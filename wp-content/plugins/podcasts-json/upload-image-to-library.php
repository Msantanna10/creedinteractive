<?php 
function upload_image_to_library($ids_to_set_featured_images) {

    // Required files
    require_once( ABSPATH . "/wp-load.php");
	require_once( ABSPATH . "/wp-admin/includes/image.php");
	require_once( ABSPATH . "/wp-admin/includes/file.php");
	require_once( ABSPATH . "/wp-admin/includes/media.php");

	// Loops through IDs
	foreach($ids_to_set_featured_images as $podcast_id) {

		// Get Thumbnail URL
		$thumbnail = get_post_meta($podcast_id, 'podcast_thumbnail_url', true);
		$title = get_the_title($podcast_id);
		
		// Download URL to a temp file
		$tmp = download_url( $thumbnail );

		if ( is_wp_error( $tmp ) ) return false;
		
		// Get the filename and extension ("photo.png" => "photo", "png")
		$filename = pathinfo($thumbnail, PATHINFO_FILENAME);
		$extension = pathinfo($thumbnail, PATHINFO_EXTENSION);
		
		// An extension is required or else WordPress will reject the upload
		if ( ! $extension ) {
			// Look up mime type, example: "/photo.png" -> "image/png"
			$mime = mime_content_type( $tmp );
			$mime = is_string($mime) ? sanitize_mime_type( $mime ) : false;
			
			// Only allow certain mime types because mime types do not always end in a valid extension (see the .doc example below)
			$mime_extensions = array(
				'image/jpg'          => 'jpg',
				'image/jpeg'         => 'jpeg',
				'image/gif'          => 'gif',
				'image/png'          => 'png',
			);
			
			if ( isset( $mime_extensions[$mime] ) ) {
				// Use the mapped extension
				$extension = $mime_extensions[$mime];
			} else{
				// Could not identify extension
				@unlink($tmp);
				return false;
			}
		}
		
		// Upload it the same way as an uploaded file is handled by media_handle_upload
		$args = array(
			'name' => "$filename.$extension",
			'tmp_name' => $tmp,
		);
		
		// Do the upload
		$attachment_id = media_handle_sideload( $args, 0 );
		
		// Cleanup temp file
		@unlink($tmp);
		
		// Error uploading
		if ( is_wp_error($attachment_id) ) return false;
		
		// Set Featured Image
		set_post_thumbnail( $podcast_id, $attachment_id );  
       
    }

}
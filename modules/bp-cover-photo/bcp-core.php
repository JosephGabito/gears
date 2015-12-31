<?php
/**
 * Crop an uploaded avatar.
 * 
 * originally from bp file <>. It was copied since naming it does not have any filters
 * for renaming and changing the cropped avatae
 *
 *  $args has the following parameters:
 *  object - What component the avatar is for, e.g. "user"
 *  avatar_dir  The absolute path to the avatar
 *  item_id - Item ID
 *  original_file - The absolute path to the original avatar file
 *  crop_w - Crop width
 *  crop_h - Crop height
 *  crop_x - The horizontal starting point of the crop
 *  crop_y - The vertical starting point of the crop
 *
 * @param array $args {
 *     Array of function parameters.
 *     @type string $object Object type of the item whose avatar you're
 *           handling. 'user', 'group', 'blog', or custom. Default: 'user'.
 *     @type string $avatar_dir Subdirectory where avatar should be stored.
 *           Default: 'avatars'.
 *     @type bool|int $item_id ID of the item that the avatar belongs to.
 *     @type bool|string $original_file Absolute papth to the original avatar
 *           file.
 *     @type int $crop_w Crop width. Default: the global 'full' avatar width,
 *           as retrieved by bp_core_avatar_full_width().
 *     @type int $crop_h Crop height. Default: the global 'full' avatar height,
 *           as retrieved by bp_core_avatar_full_height().
 *     @type int $crop_x The horizontal starting point of the crop. Default: 0.
 *     @type int $crop_y The vertical starting point of the crop. Default: 0.
 * }
 * @return bool True on success, false on failure.
 */
function bcp_core_avatar_handle_crop( $args = '' ) {

	$existing_avatar = '';

	$coverphoto_full_width = BCP_MAX_WIDTH;
	$coverphoto_full_height = BCP_MAX_HEIGHT;

	$coverphoto_thumb_full_width = BCP_THUMB_MAX_WIDTH;
	$coverphoto_thumb_full_height = BCP_THUMB_MAX_HEIGHT;

	$r = wp_parse_args( $args, array(
		'object'        => 'user',
		'avatar_dir'    => 'avatars',
		'item_id'       => false,
		'original_file' => false,
		'crop_w'        => bp_core_avatar_full_width(),
		'crop_h'        => bp_core_avatar_full_height(),
		'crop_x'        => 0,
		'crop_y'        => 0
	) );

	/***
	 * You may want to hook into this filter if you want to override this function.
	 * Make sure you return false.
	 */
	if ( !apply_filters( 'bp_core_pre_avatar_handle_crop', true, $r ) )
		return true;

	extract( $r, EXTR_SKIP );

	if ( empty( $original_file ) )
		return false;

	$original_file = bp_core_avatar_upload_path() . $original_file;

	if ( !file_exists( $original_file ) )
		return false;

	if ( empty( $item_id ) ) {
		$avatar_folder_dir = apply_filters( 'bp_core_avatar_folder_dir', dirname( $original_file ), $item_id, $object, $avatar_dir );
	} else {
			
		$avatar_folder_dir = apply_filters( 'bp_core_avatar_folder_dir', bp_core_avatar_upload_path() . '/' . $avatar_dir . '/' . $item_id, $item_id, $object, $avatar_dir );

	}


	if ( !file_exists( $avatar_folder_dir ) )
		return false;


	require_once( ABSPATH . '/wp-admin/includes/image.php' );
	require_once( ABSPATH . '/wp-admin/includes/file.php' );

	// Delete the existing avatar files for the object
	$args = array('object_id' => $item_id, 'type' => 'user');

	//change object type to groups for groups

	if ('group-avatars' == $avatar_dir){

		$args['type'] = 'groups';
	}

	$existing_covers = bcp_fetch_cover_photo($args);

	if ( ! empty( $existing_covers ) ) {
		// Check that the new avatar doesn't have the same name as the
		// old one before deleting
		$upload_dir           = wp_upload_dir();
		$existing_avatar_path = str_replace( $upload_dir['baseurl'], '', $existing_avatar );
		$new_avatar_path      = str_replace( $upload_dir['basedir'], '', $original_file );
		
		if ( $existing_avatar_path !== $new_avatar_path ) {

			if ($handle = opendir($avatar_folder_dir)) {
				while (false !== ($entry = readdir($handle))) {
			        if ($entry != "." && $entry != "..") {

			           $file_info = pathinfo($entry);
			           $file_name = $file_info['filename'];
			           $file_ext  = $file_info['extension'];

			           $cover_photos = array('coverphoto-full','coverphoto-thumb');

			           if (in_array($file_name, $cover_photos)) {
			           		// cover photo exists
			           		$file = $avatar_folder_dir . '/' . $file_name . '.' . $file_ext;
			           		@unlink($file);
			           } 
			        }
			    }
			    // close the directory
				closedir($handle);
			}
		}
	}



	// Make sure we at least have a width and height for cropping
	if ( empty( $crop_w ) ) {
		$crop_w = bp_core_avatar_full_width();
	}

	if ( empty( $crop_h ) ) {
		$crop_h = bp_core_avatar_full_height();
	}

	// Get the file extension
	$data = @getimagesize( $original_file );
	$ext  = $data['mime'] == 'image/png' ? 'png' : 'jpg';

	// Set the full and thumb filenames
	$full_filename  = 'coverphoto-full.'  . $ext;
	$thumb_filename = 'coverphoto-thumb.' . $ext;

	// Crop the image
	$full_cropped  = wp_crop_image( 
		$original_file, 
		(int) $crop_x, 
		(int) $crop_y, 
		(int) $crop_w, 
		(int) $crop_h, 
		BCP_MAX_WIDTH, 
		BCP_MAX_HEIGHT,  
		false, 
		$avatar_folder_dir . '/' . $full_filename  
	);
	
	$thumb_cropped = wp_crop_image( $original_file, 
		(int) $crop_x, 
		(int) $crop_y, 
		(int) $crop_w, 
		(int) $crop_h, 
		BCP_THUMB_MAX_WIDTH, 
		BCP_THUMB_MAX_HEIGHT, 
		false, 
		$avatar_folder_dir . '/' . 
		$thumb_filename );

	// Check for errors
	if ( empty( $full_cropped ) || empty( $thumb_cropped ) || is_wp_error( $full_cropped ) || is_wp_error( $thumb_cropped ) )
		return false;

	// Remove the original
	@unlink( $original_file );

	return true;
}

/**
 * fetch the cover photo of group/user
 *
 * @return string url
 */
function bcp_fetch_cover_photo($args){
	
	$cover_photos_collection = array();

	$r = wp_parse_args( $args, array(
			'object_id' => 0,
			'type' => 'user'
		));
	

	extract($r, EXTR_SKIP);

	if (0 == $object_id){
		return $cover_photos_collection;
	}
	
	$upload_dir = wp_upload_dir();
	$avatars_dir = $type == 'user' ? 'avatars' : 'group-avatars';
		
	// begin fetching avatar
		$avatar_upload_dir = bp_core_avatar_upload_path() . '/'.$avatars_dir.'/' . $object_id . '/';
		$avatar_upload_url = $upload_dir['baseurl'] . '/'.$avatars_dir.'/' . $object_id . '/';

		// open the dir
		if (!file_exists($avatar_upload_dir)){
			return $cover_photos_collection;
		}
		
		if ($handle = opendir($avatar_upload_dir)) {
			while (false !== ($entry = readdir($handle))) {
		        if ($entry != "." && $entry != "..") {

		           $file_info = pathinfo($entry);
		           $file_name = $file_info['filename'];
		           $file_ext  = $file_info['extension'];

		           $cover_photos = array('coverphoto-full','coverphoto-thumb');

		           if (in_array($file_name, $cover_photos)) {
		           		// cover photo exists
		           		$cover_photo_url =  $avatar_upload_url . $file_name . '.' . $file_ext;
		           		$cover_timestamp = '?bcp_cover=' . get_user_meta($object_id, 'cover-photo-timestamp', true);
		           		
		           		if ('user' !== $type) {
		           			$cover_timestamp = '?bcp_group_cover=' . groups_get_groupmeta($object_id, 'cover-photo-timestamp');
		           		}

		           		if ('coverphoto-full' == $file_name){
		           			$cover_photos_collection['full']  = $cover_photo_url . $cover_timestamp;
		           		} else {
		           			$cover_photos_collection['thumb'] = $cover_photo_url . $cover_timestamp;
		           		}
		           } 
		        }
		    }

		    // close the directory
			closedir($handle);
		}

	return $cover_photos_collection;

}

/**
 * get user/group cover photo
 * 
 * @uses bcp_fetch_cover_photo
 * @return array 
 * @param $args array
 */
function bcp_get_cover_photo($args = array()){
	
	// fetch cover photo
	$cover_photo = bcp_fetch_cover_photo($args);
	$cover_photo_src = "";

	// assign image size
	$size = isset($args['size']) ? $args['size'] : 'full';
	$allowed_size = array('thumb', 'full');

	// assign component (user/group)
	$allowed_component = array('user', 'group');
	$type = isset($args['type']) ? $args['type'] : 'user';

	// assign user component as default
	if (!in_array($type, $allowed_component)) {
		$type = 'user';
	}
	// check if the size entere is allowed
	// use 'full' size for non valid size
	if (!in_array($size, $allowed_size)){
		$size = 'full';
	}

	if (!empty($cover_photo)){ 

		if(isset($cover_photo)) {
			$cover_photo_src = $cover_photo[$size];
		}

	} else {
		
		// use the default cover photo settings if there are no cover photo
		$theme_default = plugin_dir_url(__FILE__) . 'img/default.jpg';
		$cover_photo_option = '__bcp_default_'.$type.'_cover_photo';

		$saved_default_cover_photo = get_option($cover_photo_option);
		// if there are are cover photo set by the admin, use it.
		$default_cover_photo = empty($saved_default_cover_photo) ? /*use theme default*/ $theme_default : $saved_default_cover_photo;

		$cover_photo_src = $default_cover_photo;
	}

	return $cover_photo_src;

}
?>
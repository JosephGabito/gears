<?php
/**
 * Returns the current slug of the group
 *
 * @return string the slug of the page selected as groups screen
 */
function bcp_get_groups_slug()
{
    $bp = buddypress();

    $groups_slug = $bp->groups->slug;

    $bp_groups_page_slug = '';

    // incase the user selected a different page for groups
    // get the page that is assigned to groups and catch the slug
    $bp_pages = get_option('bp-pages');

    if (!empty($bp_pages)) {

        $bp_groups_page = get_post($bp_pages['groups']);

        $bp_groups_page_id = intval( $bp_groups_page->ID );

        if ( 0 !== $bp_groups_page_id ) {

            $bp_groups_page_slug = get_permalink( $bp_groups_page_id );

        }
    }

    if (!empty($bp_groups_page_slug)) {
        $groups_slug = $bp_groups_page_slug;
    }

    return $groups_slug;
}

/**
 * cover photo subnav callback function. renders the title content and the template
 * files that are needed to process the upload and cropping of the photo
 *
 * @author dunhakdis<codehaiku.io@gmail.com>
 * @package bp-cover-photo
 * @since 1.0
 * @return void
 */

function bcp_cover_photo_screen(){

    // store buddypress object to $bp
    // same as global $bp;
    $bp = buddypress();

    // template directory
    $template = 'members';

    // filter function for uploading images
    $upload_filter = 'xprofile_avatar_upload_dir';

    // BuddyPress 6.0 and above.
    if ( ! function_exists('xprofile_avatar_upload_dir')) {
    	$upload_filter = 'bp_members_avatar_upload_dir';
    }

    // the id of the user
    $item_id = bp_displayed_user_id();

    if ( bp_is_group_single() ) {
        $template = 'groups';
        $upload_filter = 'groups_avatar_upload_dir';
        $item_id = $bp->groups->current_group->id;
    }

    // load jcrop
    add_action('wp_enqueue_scripts', 'bp_cover_photo_scripts');
    //add title and content here - last is to call the members plugin.php template
    add_action( 'bp_template_title', 'bp_cover_photo_screen_title' );
    add_action( 'bp_template_content', 'bp_cover_photo_screen_content' );

    // handle uploading of cover photo
    if ( ! empty( $_FILES ) ) {

        // Check the nonce
        check_admin_referer( 'bp_avatar_upload' );

        // create avatar_admin object to prevent notices
        // from empty variables and objects
        if ( ! isset( $bp->avatar_admin ) )
           $bp->avatar_admin = new stdClass();

        // Pass the file to the avatar upload handler
        $bp = buddypress();

        if ( bp_core_avatar_handle_upload( $_FILES, $upload_filter) )
        {
            //echo '<pre>'; print_r($_COOKIE); echo '</pre>'; 
            if ( isset( $bp->template_message_type ) ) {
                if ( 'error' === $bp->template_message_type ) {
                    $small_image_resu_warning =  __( 'The uploaded cover photo image\'s resolution is too small. Consider uploading an image with a higher resolution for better results.', 'buddypress' );
                    // Modify the error message to correct
                    $bp->template_message = $small_image_resu_warning;
                    // Repeat for consitency, incase the user refresh the screen.
                    bp_core_add_message( $small_image_resu_warning, 'error' );
                }
            }
            // Make some progress to the current step
            $bp->avatar_admin->step = 'crop-image';
        }

    }

    // If the image cropping is done, crop the image and save a full/thumb version
    if ( isset( $_POST['avatar-crop-submit'] ) ) {

        // Check the nonce
        check_admin_referer( 'bp_avatar_cropstore' );

        $groups_slug = trailingslashit( bcp_get_groups_slug() );

        $args = array(
            'item_id'       => $item_id,
            'original_file' => $_POST['image_src'],
            'crop_x'        => $_POST['x'],
            'crop_y'        => $_POST['y'],
            'crop_w'        => $_POST['width'],
            'crop_h'        => $_POST['height']
        );

        // change avatar path for groups
        if ( bp_is_group_single() ) {
            $args['avatar_dir'] = 'group-avatars';
        }
        
        if ( ! bcp_core_avatar_handle_crop( $args ) ) {

            bp_core_add_message( __( 'There was a problem cropping your cover photo.', 'buddypress' ), 'error' );

        } else {

            // update the default cover photo image for groups
            if (isset($_POST['global-coverphoto']))
            {
                $type = wp_kses($_POST['global-coverphoto'], array());
                $args = array(
                    'object_id' => $item_id,
                    'type' => $type
                );

                $new_cover_photo = bcp_fetch_cover_photo($args);

                update_option('__bcp_default_'.$type.'_cover_photo', $new_cover_photo['full']);
            }

            if ( bp_is_group_single() ) {
                // if its a single group
                // redirect to group home page

                $current_displayed_group_url = trailingslashit( $groups_slug . $bp->groups->current_group->slug . '/');

                groups_update_groupmeta($item_id, 'cover-photo-timestamp', md5(time()));

                bp_core_add_message( __( 'The new group cover photo was uploaded successfully.', 'buddypress' ) );

                bp_core_redirect( $current_displayed_group_url );

            } else {
                //otherwise, redirect to members profile
                update_user_meta($item_id, 'cover-photo-timestamp', md5(time()));

                bp_core_add_message( __( 'Your new cover photo was uploaded successfully.', 'buddypress' ) );

                bp_core_redirect( bp_displayed_user_domain() );
            }

            

        }
    }

    bp_core_load_template( apply_filters( 'bp_core_template_plugin', $template . '/single/plugins' ) );

    return;

}

/**
 * loads jcrop stylesheet and javascript
 *
 * @author dunhakdis<codehaiku.io@gmail.com>
 * @since 2.0
 * @return void
 */
function bp_cover_photo_scripts()
{

    wp_enqueue_script('jcrop');
    wp_enqueue_style('jcrop');

    return;
}

/**
 * renders cover photo title
 */
function bp_cover_photo_screen_title()
{
    echo __('Cover Photo','gears');

    return;
}

/**
 * renders the template for adding/cropping cover photo
 */
function bp_cover_photo_screen_content() {

    $template = plugin_dir_path( __FILE__ ) . 'templates/cover-photo.php';

    require_once $template;

    return;
}
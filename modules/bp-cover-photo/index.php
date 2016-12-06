<?php
/**
 * BP Cover Photo
 *
 * Adds Cover Photo functionality
 *
 * @buddypress version 2.+
 * @author dunhakdis
 */

if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Define global configurations
 */
DEFINE('BCP_MAX_WIDTH',  1140);
DEFINE('BCP_MAX_HEIGHT', 452);
DEFINE('BCP_THUMB_MAX_WIDTH',  570);
DEFINE('BCP_THUMB_MAX_HEIGHT', 226);
DEFINE('BCP_ENABLE_CUSTOMISE', false);

require_once 'bcp-core.php';
require_once 'bcp-filters.php';

global $bp;

if (!isset($bp)) return;


    if ( current_user_can('manage_options') || bp_displayed_user_id() == bp_loggedin_user_id()){
        // create cover photo tab in user's profile
        bp_core_new_subnav_item(
            array(
               'name' => __('Cover Photo', 'gears'),
               'slug' => 'cover-photo',
               'parent_url' => trailingslashit($bp->displayed_user->domain . $bp->profile->slug . '/'),
               'parent_slug' => $bp->profile->slug,
               'screen_function' => 'bcp_cover_photo_screen',
               'position' => 40
           )
        );

        // create skin tab under profile
        if (BCP_ENABLE_CUSTOMISE) {
            bp_core_new_subnav_item(
                array(
                   'name' => __('Customize', 'gears'),
                   'slug' => 'bcp-customize',
                   'parent_url' => trailingslashit($bp->displayed_user->domain . $bp->profile->slug . '/'),
                   'parent_slug' => $bp->profile->slug,
                   'screen_function' => 'bcp_profile_skin_screen',
                   'position' => 41
               )
            );
        }

    }

    if (bp_is_group_single()) {

        $current_group_id = (int)$bp->groups->current_group->id;
        $group_creator_id = (int)$bp->groups->current_group->creator_id;

        $current_user = get_current_user_id();

        if ( current_user_can('manage_options') || $group_creator_id == $current_user || groups_is_user_admin( $current_user, $current_group_id ) )
        {
            $groups_slug = trailingslashit( bcp_get_groups_slug() );
            /**
             * Create cover photo tab inside groups.
             */
            $groups_url = trailingslashit ( $groups_slug .  $bp->groups->current_group->slug );
            bp_core_new_subnav_item(
                array(
                   'name' => __('Cover Photo', 'gears'),
                   'slug' => 'cover-photo',
                   'parent_url' => $groups_url,
                   'parent_slug' =>  $bp->groups->current_group->slug,
                   'screen_function' => 'bcp_cover_photo_screen',
                   'position' => 1000
               )
            );
        }
    }

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
     * Renders cover photo title
     * @return  void
     */
    function bcp_profile_skin_title()
    {
        echo __('Customise','gears');

        return;
    }

    /**
     * renders the template for adding/cropping cover photo
     */
    function bcp_profile_skin_body() {

        $template = plugin_dir_path( __FILE__ ) . 'templates/customise.php';

        require_once $template;

        return;
    }

    /**
     * callback function for the skin menu
     *
     * @return void
     */
    function bcp_profile_skin_screen()
    {
        add_action('wp_enqueue_scripts', 'bcp_profile_skin_screen_scripts');
        add_action('bp_template_title', 'bcp_profile_skin_title' );
        add_action( 'bp_template_content', 'bcp_profile_skin_body' );

        $user_id = get_current_user_id();

        if(current_user_can('manage_options')){
            $user_id = bp_displayed_user_id();
        }

        if(isset($_POST['user-profile-customisation'])){

            if(wp_verify_nonce($_POST['user-customisation'],'user-customisation-action')){

                $mode = wp_kses($_POST['bp-cover-photo-user-background-mode'], array());
                $color_1 = wp_kses($_POST['color-stop-1'], array());
                $color_2 = wp_kses($_POST['color-stop-2'], array());
                $foreground = wp_kses($_POST['foreground'], array());

                update_user_meta( $user_id, '__bp-cover-photo-customisation-mode',   $mode       );
                update_user_meta( $user_id, '__bp-cover-photo-customisation-color1', $color_1    );
                update_user_meta( $user_id, '__bp-cover-photo-customisation-color2', $color_2    );
                update_user_meta( $user_id, '__bp-cover-photo-customisation-foreground', $foreground );

                bp_core_add_message( __( 'Profile customisation saved.', 'bp-cover-photo' ), 'success' );

            } else {
                bp_core_add_message( __('There was an error saving your customisation. Authorization Required.','bp-cover-photo'), 'error');
            }
        }

        // reset customisation

        if($_POST['user-profile-customisation-reset'] == 'Reset'){
            delete_user_meta( $user_id, '__bp-cover-photo-customisation-mode');
            delete_user_meta( $user_id, '__bp-cover-photo-customisation-color1');
            delete_user_meta( $user_id, '__bp-cover-photo-customisation-color2');
            delete_user_meta( $user_id, '__bp-cover-photo-customisation-foreground');

             bp_core_add_message( __('Profile customisation has been successfully reset.','bp-cover-photo'), 'success');
        }

        bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'members/single/plugins' ) );

        return;
    }

    function bcp_profile_skin_screen_scripts(){
        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_script(
            'iris',
            admin_url( 'js/iris.min.js' ),
            array( 'jquery-ui-draggable', 'jquery-ui-slider', 'jquery-touch-punch' ),
            false,
            1
        );
        wp_enqueue_script(
            'wp-color-picker',
            admin_url( 'js/color-picker.min.js' ),
            array( 'iris' ),
            false,
            1
        );
        $colorpicker_l10n = array(
            'clear' => __( 'Clear' ),
            'defaultString' => __( 'Default' ),
            'pick' => __( 'Select Color' )
        );
        wp_localize_script( 'wp-color-picker', 'wpColorPickerL10n', $colorpicker_l10n );

        return;
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
        if (!empty($_FILES)) {

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
                // adjust current step
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
                'crop_w'        => $_POST['w'],
                'crop_h'        => $_POST['h']
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

                    bp_core_redirect( $current_displayed_group_url );

                } else {
                    //otherwise, redirect to members profile
                    update_user_meta($item_id, 'cover-photo-timestamp', md5(time()));
                    bp_core_redirect( bp_displayed_user_domain() );
                }

                bp_core_add_message( __( 'Your new cover photo was uploaded successfully.', 'buddypress' ) );

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

?>

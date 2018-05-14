<?php
/**
 * BP Cover Photo
 *
 * Adds Cover Photo functionality
 *
 * @buddypress version 2.+
 * @author dunhakdis
 */

if ( !DEFINED( 'ABSPATH' ) ) exit;

require_once 'bcp-core.php';
require_once 'bcp-filters.php';
require_once 'screen-functions.php';

/**
 * Define global configurations
 */
if ( ! DEFINED('BCP_MAX_WIDTH') ) {
    DEFINE('BCP_MAX_WIDTH',  1140);
}
if ( ! DEFINED('BCP_MAX_HEIGHT') ) {
    DEFINE('BCP_MAX_HEIGHT', 452);
}

if ( ! DEFINED('BCP_THUMB_MAX_WIDTH') ) {
    DEFINE('BCP_THUMB_MAX_WIDTH',  570);
}

if ( ! DEFINED('BCP_THUMB_MAX_HEIGHT') ) {
    DEFINE('BCP_THUMB_MAX_HEIGHT', 226);
}

if ( ! DEFINED('BCP_ENABLE_CUSTOMISE') ) {
    DEFINE('BCP_ENABLE_CUSTOMISE', false);
}

$bp = '';

if ( function_exists( 'buddypress' ) ) {
    $bp = buddypress();
}

if ( function_exists( 'bp_displayed_user_id' ) ) {
    if ( current_user_can('manage_options') || bp_displayed_user_id() == bp_loggedin_user_id()){
        // create cover photo tab in user's profile
        bp_core_new_subnav_item(
            array(
               'name' => __('Cover Photo', 'gears'),
               'slug' => 'cover-photo',
               'parent_url' => trailingslashit( $bp->displayed_user->domain . $bp->profile->slug . '/' ),
               'parent_slug' => $bp->profile->slug,
               'screen_function' => 'bcp_cover_photo_screen',
               'position' => 40
           )
        );
    }
}

/**
 * Single Group
 */
if ( function_exists( 'bp_is_group_single' ) ) {
    if ( bp_is_group_single() ) {

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
}



?>

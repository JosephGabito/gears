<?php
// check if buddypres component is loaded
if (!function_exists('bp_has_groups')) {

    return __('<div class="alert alert-warning">Oops! BuddyPress Groups Component is not currently enabled.</div>', 'gears');
}

extract(
    shortcode_atts( array(
        'type' => 'active',
        'max_item' => 10,
        'max_slides' => 7,
        'min_slides' => 1,
        'slide_margin' => 20,
        'item_width' => 220
    ), $atts )
);

$params = array(
    'type' => $type,
    'per_page' => $max_item
);

$output = '';
if( function_exists( 'bp_has_groups' ) ){
    if( bp_has_groups( $params ) ){
        $output .= '<div class="clearfix">';
            $output .= '<ul data-slide-margin="'.$slide_margin.'" data-max-slides="'.$max_slides.'"
            data-min-slides="'.$min_slides.'" data-item-width="'.$item_width.'"
            class="gears-carousel-standard bp-groups-carousel">';

                while ( bp_groups() ){
                    bp_the_group();

                    $permalink = esc_url(bp_get_group_permalink());
                    $group_title = esc_attr(bp_get_group_name());
                    $member_count = esc_attr(bp_get_group_member_count());
                    $last_active = sprintf( __( 'active %s', 'buddypress' ), bp_get_group_last_active() );

                    $output .= '<li class="carousel-item gears-bp-groups-carousel-2">';

                            $output .= '<a class="gears-linked-image" href="'. $permalink.'" title="'. $group_title .'">';
                                $output .= bp_get_group_avatar( array(	'type' => 'full' ) );
                            $output .= '</a>';
                            $output .= '<div class="item-details">';
                                $output .= '<a href="'.$permalink.'" title="'.$group_title.'">';
                                    $output .= '<h4 class="group-title">'.$group_title.'</h4>';
                                $output .= '</a>';
                                $output .= '<p>'.$member_count.'<br/><span class="activity">'.$last_active.'</span></p>';
                            $output .= '</div>';


                    $output .= '</li>';
                }
            $output .= '</ul>';
        $output .= '</div>';
    }else{
        $output .= '<div class="alert alert-info">' . __( 'There are no groups to display. Please try again soon.', 'gears' ) . '</div>';
    }
    echo $output;
}else{
    echo $this->bp_not_installed;
}


<?php
$output = '';
extract(
    shortcode_atts( array(
        'type' => 'active',
        'max_item' => 10
    ), $atts )
);

// available columns are 1, 2, 3, and 4
$params = array(
    'type' => $type,
    'per_page' => $max_item
);

if ( function_exists( 'bp_has_members' ) ) {

    // begin bp members loop
    if ( bp_has_members( $params ) ) {

            $output .= '<div class="clearfix">';
                $output .= '<ul class="gears-bp-members-list clear">';
                    while( bp_members() ){
                        $output .= '<li class="clearfix bp-members-list-item ">';
                            bp_the_member();

                                $output .= bp_get_member_avatar( array(	'type' => 'full', 'class' => 'col-md-3 col-xs-3 col-sm-3 trans avatar' ));

                                $output .= '<div class="col-md-9 col-sm-9 col-xs-9">';
                                    $output .= '<h5><a href="'.bp_get_member_permalink().'" title="'.bp_get_member_name().'">'. bp_get_member_name() .'</a></h5>';
                                    $output .= '<div class="item-meta"><span class="small activity">' . bp_get_member_last_active() . '</span></div>';
                                            do_action( 'bp_directory_members_item' );
                                $output .= '</div>';
                        $output .= '</li>';
                    }
                $output .= '</ul>';
            $output .= '</div>';

            echo  $output;
        }

}else{

    echo  $this->bp_not_installed;

}

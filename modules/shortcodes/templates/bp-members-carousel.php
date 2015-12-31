<?php
$output = '';

extract( 
	shortcode_atts( array(
		'type' => '',
		'max_item' => 10,
		'max_slides' => 7,
		'min_slides' => 1,
		'item_width' => 175
		), $atts ) 
	);

$params = array(
	'type' => $type,
	'per_page' => $max_item
	);

if( function_exists('bp_has_members') ){
			// begin bp members loop
	if ( bp_has_members( $params ) ){

		$output .= '<div class="clearfix">';
		$output .= '<ul data-max-slides="'.$max_slides.'" data-min-slides="'.$min_slides.'" 
		data-item-width="'.$item_width.'" class="gears-carousel-standard bp-members-carousel">';

		while (bp_members()) {

			bp_the_member();

			$output .= '<li class="carousel-item">';

			$name = bp_get_member_name();
			$permalink = bp_get_member_permalink();
			$last_active = bp_get_member_last_active();

			$output .= '<a class="members-name" href="'. esc_url($permalink) .'" title="'. esc_attr($name) .'">';
				$output .= esc_attr($name);
			$output .= '</a>';

			$output .= '<a href="'. esc_url($permalink) .'" title="'. esc_attr($name) .'">';
				$output .= bp_get_member_avatar( array(	'type' => 'full' ));
			$output .= '</a>';

			if (class_exists('BP_Follow')) {
				if (method_exists('BP_Follow', 'get_counts')) {
					$follow_count = BP_Follow::get_counts(bp_get_member_user_id());
					$follow_label = $follow_count['followers'] == 1 ? 'Follower' : 'Followers';
					$output .= '<p><strong>'.$follow_count['followers']. ' ' . $follow_label . '</strong></p>';
				}
			}
			$output .= '</li>';
		}
		$output .= '</ul>';	
		$output .= '</div>';

		echo $output;
	}

}else{
	echo $this->bp_not_installed;
}
?>
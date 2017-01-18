<?php
/**
 * Gears BP Activity Stream
 *
 * @since 1.0
 */
vc_map(
	array(
		"name" => __("Activity Stream"),
		"base" => "gears_bp_activity_stream",
		"class" => "",
		"admin_label" => true,
		"category" => __('Gears'),
		"icon" => plugins_url('../../../assets/images/activity-stream.png', __FILE__),
		'admin_enqueue_js' => array(),
		'admin_enqueue_css' => array(),
		"params" => array(
				array(
					"type" => "textfield",
					"holder" => "",
					"class" => "",
					"admin_label" => true,
					"heading" => __("Title", "gears"),
					"param_name" => "title",
					"value" => __('Members Activity Stream'),
					"description" => __("Leave blank to disable widget title.", "gears")
				)
			)
	)
);
?>

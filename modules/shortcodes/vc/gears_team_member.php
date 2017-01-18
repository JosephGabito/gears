<?php
vc_map(
	array(
		"name" => __("Gears Team Member"),
		"base" => "gears_team_member",
		"class" => "",
		"admin_label" => true,
		"category" => __('Gears'),
		"icon" => plugins_url('../../../assets/images/gears-icon.png', __FILE__),
		"admin_enqueue_js" => array(),
		"admin_enqueue_css" => array(),
		"params" => array(
			array(
				"type" => "vc_link",
				"holder" => "",
				"class" => "",
				"admin_label" => false,
				"heading" => __("Team Member URL", "gears"),
				"param_name" => "team_member_website",
				"value" => "",
				"description" => __("Enter the website or the page url of your staff or team member", "gears")
			),
			array(
				"type" => "attach_image",
				"holder" => "",
				"class" => "",
				"admin_label" => false,
				"heading" => __("Team Member Avatar", "gears"),
				"param_name" => "team_member_avatar_url",
				"value" => "",
				"description" => __("Upload an image avatar for your staff or team member", "gears")
			),
			array(
				"type" => "textfield",
				"holder" => "",
				"class" => "",
				"admin_label" => true,
				"heading" => __("Team Member Name", "gears"),
				"param_name" => "team_member_name",
				"value" => "",
				"description" => __("Enter the name of your staff or team member", "gears")
			),
			array(
				"type" => "textfield",
				"holder" => "",
				"class" => "",
				"admin_label" => false,
				"heading" => __("Team Member Identification", "gears"),
				"param_name" => "team_member_identification",
				"value" => "",
				"description" => __("Enter the position of the staff or the team member", "gears")
			)
		)
	)
);
<?php
/**
 * Gears Testimonial Module
 * @since 4.1.1
 */

if ( ! defined( 'ABSPATH' ) ) exit;

class Gears_Testimonials {

    public function __construct() {

        $this->register_post_type();

        add_shortcode( 'gears_testimonials', array( $this, 'register_shortcode' ) );

        return $this;
    }

    public function register_post_type() {

        /**
         * Register a Testimonial post type.
         */
    	$labels = array(
    		'name'               => _x( 'Testimonials', 'post type general name', 'gears' ),
    		'singular_name'      => _x( 'Testimonial', 'post type singular name', 'gears' ),
    		'menu_name'          => _x( 'Testimonials', 'admin menu', 'gears' ),
    		'name_admin_bar'     => _x( 'Testimonial', 'add new on admin bar', 'gears' ),
    		'add_new'            => _x( 'Add New', 'Testimonial', 'gears' ),
    		'add_new_item'       => __( 'Add New Testimonial', 'gears' ),
    		'new_item'           => __( 'New Testimonial', 'gears' ),
    		'edit_item'          => __( 'Edit Testimonial', 'gears' ),
    		'view_item'          => __( 'View Testimonial', 'gears' ),
    		'all_items'          => __( 'All Testimonials', 'gears' ),
    		'search_items'       => __( 'Search Testimonials', 'gears' ),
    		'parent_item_colon'  => __( 'Parent Testimonials:', 'gears' ),
    		'not_found'          => __( 'No Testimonials found.', 'gears' ),
    		'not_found_in_trash' => __( 'No Testimonials found in Trash.', 'gears' )
    	);

    	$args = array(
    		'labels'             => $labels,
            'description'        => __( 'Description.', 'gears' ),
    		'public'             => false,
    		'publicly_queryable' => true,
    		'show_ui'            => true,
    		'show_in_menu'       => true,
    		'query_var'          => true,
    		'rewrite'            => array( 'slug' => 'testimonial' ),
    		'capability_type'    => 'post',
    		'has_archive'        => false,
    		'hierarchical'       => false,
    		'menu_position'      => null,
    		'supports'           => array( 'custom-fields', 'title', 'editor', 'author', 'thumbnail' )
    	);

    	register_post_type( 'gears-testimonial', $args );

        return $this;

    }

    public function register_shortcode( $atts ) {

        return $this->display( $atts );

    }

    public function display( $atts ) {

        ob_start();

		$template = GEARS_APP_PATH . 'modules/shortcodes/templates/testimonials.php';

		if ( $theme_template = locate_template( array( 'gears/shortcodes/testimonials.php' ) ) ) {

        	$template = $theme_template;

    	}

    	include $template;

    	return ob_get_clean();

    }

}

new Gears_Testimonials();
?>

<?php
/**
 * Gears Portfolio Module
 *
 * @package Gears
 * @version 4.1.1
 * @since   4.1.1
 */

if ( ! defined( 'ABSPATH' ) ) { exit;
}

class Gears_Portfolio {


	public function __construct() {

		$this->register_post_type();

		$this->post_type_updated_messages( $messages = array() );

		$this->post_type_taxonomy();

		$this->gears_get_portfolio_category();

		add_action( 'wp_enqueue_scripts', array( $this, 'gears_portfolio_enqueue_style' ) );

		add_image_size( 'gears-portfolio-thumbnail', 550, 550, true );

		add_shortcode( 'gears_portfolio', array( $this, 'register_shortcode' ) );

		return $this;
	}

	public function register_post_type() {

		/**
		 * Register a Testimonial post type.
		 */
		$labels = array(
		'name'               => __( 'Portfolios', 'Portfolio', 'gears' ),
		'singular_name'      => __( 'Portfolio', 'Portfolio', 'gears' ),
		'menu_name'          => __( 'Porfolios', 'admin menu', 'gears' ),
		'name_admin_bar'     => __( 'Portfolio', 'add new on admin bar', 'gears' ),
		'add_new'            => __( 'Add New', 'portfolio', 'gears' ),
		'add_new_item'       => __( 'Add New Portfolio', 'gears' ),
		'new_item'           => __( 'New Portfolio', 'gears' ),
		'edit_item'          => __( 'Edit Portfolio', 'gears' ),
		'view_item'          => __( 'View Portfolio', 'gears' ),
		'all_items'          => __( 'All Portfolios', 'gears' ),
		'search_items'       => __( 'Search Portfolios', 'gears' ),
		'parent_item_colon'  => __( 'Parent Portfolios:', 'gears' ),
		'not_found'          => __( 'No portfolio found.', 'gears' ),
		'not_found_in_trash' => __( 'No portfolio found in trash.', 'gears' ),
		);

		$args = array(
		'labels'             => $labels,
		'description'        => __( 'Description.', 'gears' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'menu_icon'             => 'dashicons-portfolio',
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'portfolio' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
		);

		register_post_type( 'gears-portfolio', $args );

		return $this;

	}

	/**
	 * Book update messages.
	 *
	 * See /wp-admin/edit-form-advanced.php
	 *
	 * @param array $messages Existing post update messages.
	 *
	 * @return array Amended post update messages with new CPT update messages.
	 */
	public function post_type_updated_messages( $messages ) {

		$post             = get_post();
		$post_type        = get_post_type( $post );
		$post_type_object = get_post_type_object( $post_type );

		if ( 'gears-portfolio' !== $post_type ) {
			return $messages;
		}

		$messages['gears-portfolio'] = array(
		'', // Unused. Messages start at index 1.
		__( 'Portfolio updated.', 'gears' ),
		__( 'Custom field updated.', 'gears' ),
		__( 'Custom field deleted.', 'gears' ),
		__( 'Portfolio updated.', 'gears' ),
		/* translators: %s: date and time of the revision */
		isset( $_GET['revision'] ) ? sprintf( __( 'Portfolio restored to revision from %s', 'gears' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		__( 'Portfolio published.', 'gears' ),
		__( 'Portfolio saved.', 'gears' ),
		__( 'Portfolio submitted.', 'gears' ),
		sprintf(
			__( 'Portfolio scheduled for: <strong>%1$s</strong>.', 'gears' ),
			// translators: Publish box date format, see http://php.net/date
			date_i18n( __( 'M j, Y @ G:i', 'gears' ), strtotime( $post->post_date ) )
		),
		__( 'Portfolio draft updated.', 'gears' ),
		);

		if ( $post_type_object->publicly_queryable ) {

			$permalink = get_permalink( $post->ID );

			$view_link = sprintf( ' <a href="%s">%s</a>', esc_url( $permalink ), __( 'View portfolio', 'gears' ) );
			$messages[ $post_type ][1] .= $view_link;
			$messages[ $post_type ][6] .= $view_link;
			$messages[ $post_type ][9] .= $view_link;

			$preview_permalink = add_query_arg( 'preview', 'true', $permalink );
			$preview_link = sprintf( ' <a target="_blank" href="%s">%s</a>', esc_url( $preview_permalink ), __( 'Preview portfolio', 'dutility' ) );
			$messages[ $post_type ][8]  .= $preview_link;
			$messages[ $post_type ][10] .= $preview_link;

		}

		return $messages;
	}

	/**
	 * Portfolio Taxonomy
	 *
	 * Registers our portfolio taxonomy
	 *
	 * @return void
	 */
	public function post_type_taxonomy() {
		register_taxonomy(
			'gears-portfolio-category',
			'gears-portfolio',
			array(
			'label' => __( 'Categories' ),
			'rewrite' => array( 'slug' => 'portfolio-category' ),
			'hierarchical' => true,
			)
		);

		return;
	}

	public function register_shortcode( $atts ) {

		$atts = shortcode_atts(
			array(
				'id' => '',
				'columns' => 3, // Select: 1,2,3,4,5: The number of columns(items) to show.
				'style' => 'classic', // Select: masonry, grid, wide, masonry-grid, masonry-wide, classic, modern, minimalist, masonry-classic, masonry-modern, masonry-minimalist.
				'posts_per_page' => 0, // Any numbers: Default '0' to display number of page base on the user reading settings.
				'sort' => '',  // Select: default(''), alphabetical, random.
				'show_category' => 'true',
				'tile_layout' => 'true',
			), $atts, 'gears_portfolio'
		);

		return $this->display( $atts );

	}

	public function display( $atts ) {

		ob_start();

		$template = GEARS_APP_PATH . 'modules/shortcodes/templates/portfolio.php';

		if ( $theme_template = locate_template( array( 'gears/shortcodes/portfolio.php' ) ) ) {

			   $template = $theme_template;

		}

		include $template;

		return ob_get_clean();

	}

	function gears_portfolio_enqueue_style() {

		global $post;

		if ( is_a( $post, 'WP_Post' ) && has_shortcode( $post->post_content, 'gears_portfolio' ) ) {

			wp_enqueue_style( 'gears-portfolio-stylesheet', plugins_url( 'assets/gears-portfolio.css', dirname( dirname( __FILE__ ) ) ), array(), 1 );

		}

		return $this;

	}


	public static function gears_get_portfolio_category() {

		global $post;

		if ( ! empty( $post->ID ) ) {

			$post = get_post( $post->ID );

			// Get post type by post.
			$post_type = $post->post_type;

			// Get post type taxonomies.
			$taxonomies = get_object_taxonomies( $post_type, 'objects' );

			return $taxonomies;
		}

		return false;

	}

	public static function gears_display_portfolio_category() {

		global $post;

		$taxonomies = self::gears_get_portfolio_category();

		$categories = array();

		if ( ! $taxonomies  ) {

			return;

		}

		foreach ( $taxonomies as $taxonomy_slug => $taxonomy ) {

			// Get the terms related to post.
			$terms = get_the_terms( $post->ID, $taxonomy_slug );

			if ( ! empty( $terms ) ) {

				$categories[] = '';

				foreach ( $terms as $term ) {

					$categories[] = sprintf( '%2$s %s', esc_html( $term->slug ), '' );

				}
			}

			return implode( '', $categories );

		}
	}

	public static function gears_display_portfolio_category_list() {

		global $post;

		$taxonomies = self::gears_get_portfolio_category();

		$categories = array();

		if ( ! $taxonomies ) {

			return;

		}

		foreach ( $taxonomies as $taxonomy_slug => $taxonomy ) {

			// Get the terms related to post.
			$terms = get_the_terms( $post->ID, $taxonomy_slug );

			if ( ! empty( $terms ) ) {

				$categories[] = '<ul>';

				foreach ( $terms as $term ) {

					$categories[] = sprintf(
						'<li><a href="%1$s">%2$s</a></li>',
						esc_url( get_term_link( $term->slug, $taxonomy_slug ) ),
						esc_html( $term->name )
					);

				}

				$categories[] = '</ul>';
			}

			return implode( '', $categories );

		}
	}

}

new Gears_Portfolio();


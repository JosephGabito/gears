<?php
/**
 * Portfolio Template
 *
 * @since  4.1.1
 * @package gears\modules\shortcodes\templates
 */

if ( ! defined( 'ABSPATH' ) ) { exit;
}

extract( $atts );

if ( empty( $id ) ) {

	$id = 'gears-portfolio-' . uniqid();

}

$portfolio_classes = '';

if ( 'masonry-grid' === $style || 'masonry-wide' === $style ) {
	$portfolio_classes = 'gears-masonry-portfolio';
}

// Filter allowed columns.
$allowed_columns = array( "1", "2", "3", "4", "5", "6" );

if ( ! in_array( $columns, $allowed_columns, true ) ) {
	$columns = 3;
}

// Filter allowed style.
$allowed_style = array(
	'masonry-grid',
	'masonry-modern',
	'masonry-minimalist',
	'masonry-classic',
	'masonry-border',
	'masonry-wide',
	'grid',
	'modern',
	'minimalist',
	'classic',
	'border',
	'wide'
);

if ( ! in_array( $style, $allowed_style, true ) ) {
	$style = 'classic';
}

// Filter allowed sort.
$allowed_sort = array( '', 'alphabetical', 'random' );

if ( ! in_array( $sort, $allowed_sort, true ) ) {
	$sort = '';
}

if ( 'true' === $tile_layout ) {

	$class_tile_layout = 'tile';

}

$args = array(
	'post_type' => 'gears-portfolio',
	'posts_per_page' => $posts_per_page,
);

// Filter orders.
// Random.
if ( 'random' === $sort ) {
	$args['orderby'] = 'rand';
}
// Alphabetical.
if ( 'alphabetical' === $sort ) {
	$args['orderby'] = 'title';
	$args['order'] = 'ASC';
}

$portfolio = new WP_Query( $args );

$filtered_style = apply_filters( 'gears_portfolio_filtered_style', array(
	'masonry-grid',
	'masonry-wide',
	'masonry-border',
	'masonry-classic',
	'masonry-minimalist',
	'masonry-modern',
));

?>

<?php if ( $portfolio->have_posts() ) : ?>

	<?php $terms = get_terms( 'gears-portfolio-category' ); ?>

	<?php if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) { ?>

		<?php if ( in_array( $style, $filtered_style, true ) ) { ?>

			<div class="gears-porfolio-filters-wrapper">

				<div class="gears-porfolio-filters-inner-wrap">

					<ul id="filters-<?php echo esc_attr( $id ); ?>" class="gears-porfolio-filters">

						<li>

							<a href="#" data-filter="*" class="active"><?php esc_attr_e( 'All', 'gears' ); ?></a>

						</li>

						<?php foreach ( (array) $terms as $term ) { ?>

							<li>

								<a href="#" data-filter=".<?php echo esc_html( $term->slug ); ?>">
									
									<?php echo esc_html( $term->name ); ?>
										
								</a>

							</li>

						<?php } ?>

					</ul>

				</div>

			</div>

		<?php } ?>

	<?php } ?>

	<div class="gears-portfolio gears-portfolio-<?php echo intval( $columns ); ?>-column style-<?php echo esc_attr( $style ); ?> gears-shortcode-element gears-clearfix">

		<?php

			$masonry_id = '';

		if ( in_array( $style, $filtered_style, true ) ) {

			$masonry_id = 'masonry-' . $id;

		}

		?>

		<ul id="<?php echo esc_attr( $masonry_id ); ?>" data-items="<?php echo intval( $columns ); ?>" class="gears-portfolio-wrapper <?php echo esc_attr( $portfolio_classes ); ?> <?php echo esc_attr( $class_tile_layout ); ?>">

			<?php while ( $portfolio->have_posts() ) : ?>

				<?php $portfolio->the_post(); ?>

				<li class="item<?php echo esc_attr( Gears_Portfolio::gears_display_portfolio_category() ); ?>">

					<a class="gears-portfolio-link" href="<?php echo esc_url( the_permalink() ); ?>" title="<?php echo esc_attr( the_title() ); ?>" target="_self"></a>

					<div class="gears-portfolio-wrap">

						<div class="gears-portfolio-thumbnail">

							<div class="gears-portfolio-thumbnail-overlay"></div>

							<?php if ( has_post_thumbnail() ) { ?>

								<?php

								the_post_thumbnail( 'gears-portfolio-thumbnail' );

								?>

							<?php } else { ?>

								<img src="<?php echo esc_url( plugins_url( 'gears/assets/images/default-thumbnail.png' ) ); ?>" alt="<?php echo esc_attr( the_title() ); ?>">

							<?php } ?>

						</div>

						<div class="gears-portfolio-details">

							<div class="gears-portfolio-details-title-wrapper">

								<div class="gears-portfolio-details-title">
									<h5>

										<a href="<?php echo esc_url( the_permalink() ); ?>" title="<?php echo esc_attr( the_title() ); ?>">

											<?php the_title();?>

										</a>

									</h5>

									<?php


									if ( 'true' === $show_category ) {

										echo Gears_Portfolio::gears_display_portfolio_category_list(); /* WPCS: xss ok. */

									}

									?>

								</div>

							</div>

						</div>

					</div>

				</li>

			<?php endwhile; ?>

		</ul>

	</div>

    <?php wp_reset_postdata(); ?>

	<div class="gears-clearfix"></div>

	<script type="text/javascript">

		jQuery( document ).ready( function( $ ) {

			"use strict";

			var gears_portfolio_masonry_container = $( '#<?php echo esc_js( $masonry_id ); ?>' );

			gears_portfolio_masonry_container.imagesLoaded( function(){

				gears_portfolio_masonry_container.isotope({

				  itemSelector: '.item',

				  layoutMode: 'masonry'

				});

			});

			var gears_portfolio_masonry_options = $( '#filters-<?php echo esc_attr( $id ); ?>' ),

			gears_portfolio_masonry_options_links = gears_portfolio_masonry_options.find( 'a' );

			gears_portfolio_masonry_options_links.click(function() {

				var $this = $( this );

				// Return false if option is already active
				if ( $this.hasClass( 'active' ) ) {

				  return false;

				}

				var gears_portfolio_masonry_option = $this.parents( '#filters-<?php echo esc_js( $id ); ?>' );

				gears_portfolio_masonry_options.find( '.active' ).removeClass( 'active' );

				$this.addClass( 'active' );

				// Sort the items when the category is clicked
				var gears_portfolio_masonry_selector = $( this ).attr( 'data-filter' );

				gears_portfolio_masonry_container.isotope( { filter: gears_portfolio_masonry_selector } );

				return false;
			});

		});

	</script>

<?php else : ?>

    <div class="alert alert-info">
        <p>
            <?php esc_html_e( 'There are no items found in your portfolio', 'gears' ); ?>
        </p>
    </div>

    <div class="gears-clearfix"></div>

<?php endif; ?>

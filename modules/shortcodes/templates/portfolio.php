<?php
if ( ! defined( 'ABSPATH' ) ) exit;

extract( $atts );

if( null == $id ) {

   $id = 'gears-portfolio-' . uniqid();

}

//$gears_portfolio = new Gears_Portfolio();

$portfolio_classes = '';
    if ( $style == 'masonry-grid' || $style == 'masonry-wide' ) {
        $portfolio_classes = 'gears-masonry-portfolio';
    }

// Filter allowed columns.
$allowed_columns = array( 1, 2, 3, 4, 5, 6 );
    if ( ! in_array( $columns, $allowed_columns ) ) {
        $columns = 3;
    }

// Filter allowed style.
$allowed_style = array( 'masonry-grid', 'grid', 'masonry-wide', 'wide', 'masonry-border', 'border', 'masonry-classic', 'classic', 'masonry-minimalist', 'minimalist', 'masonry-modern', 'modern' );
    if ( ! in_array( $style, $allowed_style ) ) {
        $style = 'classic';
    }

// Filter allowed sort.
$allowed_sort = array( '', 'alphabetical', 'random' );
    if ( !in_array( $sort, $allowed_sort ) ) {
        $sort = '';
    }
if ( $tile_layout == 'true' ) {
    $class_tile_layout = 'tile';
}


$args = array(
        'post_type' => 'gears-portfolio',
        'posts_per_page' => $posts_per_page,
    );

//Filter orders.
    //Random.
    if ( 'random' === $sort ) {
        $args['orderby'] = 'rand';
    }
    //Alphabetical
    if ( 'alphabetical' === $sort ) {
        $args['orderby'] = 'title';
        $args['order'] = 'ASC';
    }

$portfolio = new WP_Query( $args );

?>

<?php if ( $portfolio->have_posts() ): ?>

    <?php $terms = get_terms( 'gears-portfolio-category' ); ?>

    <?php if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) { ?>

        <?php if ( $style == 'masonry-grid' || $style == 'masonry-wide' || $style == 'masonry-border' || $style == 'masonry-classic' || $style == 'masonry-minimalist' || $style == 'masonry-modern' ) { ?>

            <div class="gears-porfolio-filters-wrapper">

                <div class="gears-porfolio-filters-inner-wrap">

                    <ul id="filters-<?php echo esc_attr( $id ); ?>" class="gears-porfolio-filters">

                        <li>

                            <a href="#" data-filter="*" class="active"><?php echo __( 'All', 'gears' ); ?></a>

                        </li>

                        <?php foreach ( $terms as $term ) { ?>

                            <li>

                                <a href="#" data-filter=".<?php echo esc_html( $term->slug ); ?>"><?php echo esc_html( $term->name ); ?></a>

                            </li>

                        <?php } ?>

                    </ul>

                </div>

            </div>

        <?php } ?>

    <?php } ?>

    <div class="gears-portfolio gears-portfolio-<?php echo intval( $columns ); ?>-column style-<?php echo esc_attr( $style ); ?> gears-shortcode-element gears-clearfix">

        <?php
            if ( $style == 'masonry-grid' || $style == 'masonry-wide' || $style == 'masonry-border' || $style == 'masonry-classic' || $style == 'masonry-minimalist' || $style == 'masonry-modern' ) {

                $masonry_id = 'masonry-' . $id;

            } else {

                $masonry_id = '';

            }
        ?>

        <ul id="<?php echo esc_attr( $masonry_id ); ?>" data-items="<?php echo intval( $columns ); ?>" class="gears-portfolio-wrapper <?php echo esc_attr( $portfolio_classes ); ?> <?php echo esc_attr( $class_tile_layout ); ?>">

            <?php while ( $portfolio->have_posts() ): ?>

                <?php $portfolio->the_post(); ?>

                <li class="item<?php echo esc_attr( Gears_Portfolio::gears_display_portfolio_category() ); ?>">

                    <a class="gears-portfolio-link" href="<?php echo esc_url( the_permalink() ); ?>" title="<?php echo esc_attr( the_title() ); ?>" target="_self"></a>

                    <div class="gears-portfolio-wrap">

                        <div class="gears-portfolio-thumbnail">

                            <div class="gears-portfolio-thumbnail-overlay"></div>

                            <?php if ( has_post_thumbnail() ) { ?>

                                <?php
                                    if ( $style == 'masonry-grid' || $style == 'masonry-wide' || $style == 'masonry-border' || $style == 'masonry-classic' || $style == 'masonry-minimalist' || $style == 'masonry-modern' ) {

                                        if ( $tile_layout == 'true' ) {

                                            echo the_post_thumbnail( 'large' );

                                        } else {

                                            echo the_post_thumbnail( 'gears-portfolio-thumbnail' );

                                        }

                                    } else {

                                        echo the_post_thumbnail( 'gears-portfolio-thumbnail' );

                                    }
                                ?>

                            <?php } else { ?>

                                <img src="<?php echo plugins_url('gears/assets/images/default-thumbnail.png'); ?>" alt="<?php echo esc_attr( the_title() ); ?>">

                            <?php } ?>

                        </div>

                        <div class="gears-portfolio-details">

                            <div class="gears-portfolio-details-title-wrapper">

                                <div class="gears-portfolio-details-title">
                                    <h5>

                                        <a href="<?php echo esc_url( the_permalink() ); ?>" title="<?php echo esc_attr( the_title() ); ?>">

                                            <?php the_title() ;?>

                                        </a>

                                    </h5>

                                    <?php


                                    if ( $show_category == 'true' ) {

                                        echo Gears_Portfolio::gears_display_portfolio_category_list();

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

<?php else: ?>

    <div class="alert alert-info">
        <p>
            <?php _e('There are no items found in your portfolio','gears'); ?>
        </p>
    </div>

    <div class="gears-clearfix"></div>

<?php endif; ?>

<?php wp_reset_query(); ?>

<?php
$args = array(
    'posts_per_page' => 3,
    'ignore_sticky_posts' => 'true',
    'post_type' => 'gears-testimonial'
);

$testimonials = new WP_Query( $args );
?>

<?php if ( $testimonials->have_posts() ): ?>

    <ul class="gears-testimonial-carousel">

        <?php while ( $testimonials->have_posts() ): ?>

            <li <?php post_class(); ?>>

                <?php $testimonials->the_post(); ?>

                <?php $rating   = get_post_meta( get_the_ID(), 'gears_testimonial_rating', true ); ?>

                <?php $author   = get_post_meta( get_the_ID(), 'gears_testimonial_author', true ); ?>

                <?php $title    = get_post_meta( get_the_ID(), 'gears_testimonial_position', true ); ?>

                <?php $company  = get_post_meta( get_the_ID(), 'gears_testimonial_company', true ); ?>

                <div class="gears-testimonials">

                    <div class="gears-testimonials-rating">

                        <?php esc_html_e( (int) $rating ); ?>

                    </div>

                    <div class="gears-testimonials-title">

                        <?php the_title('<h3>', '</h3>', true ) ;?>

                    </div>

                    <div class="gears-testimonials-content">

                        <?php the_content(); ?>

                    </div>

                    <div class="gears-testimonials-author">

                        <div class="gears-testimonials-author-photo">

                            <?php if ( has_post_thumbnail() ) { ?>

                                <?php the_post_thumbnail( 'thumbnail' ); ?>
                                
                            <?php } ?>

                        </div>

                        <div class="gears-testimonial-author-name">

                            <?php esc_html_e( $author );?>

                        </div>

                        <div class="gears-testimonial-author-title">

                            <?php esc_html_e( $title ); ?>

                        </div>

                        <div class="gears-testimonial-author-company">

                            <?php esc_html_e( $company ); ?>

                        </div>

                    </div>
                </div>

            </li>

        <?php endwhile; ?>

    </ul>

<?php endif; ?>

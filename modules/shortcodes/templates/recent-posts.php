<?php
extract(
    shortcode_atts( 
        array(
            'posts_per_page' => 3,
        ), $atts 
    )
);

$args = array(
    'ignore_sticky_posts' => 'true',
    'posts_per_page' => $posts_per_page
);
?>

<?php $gears_rp_query = new WP_Query( $args ); ?>

<?php if ( $gears_rp_query->have_posts() ) { ?>

        <?php while ( $gears_rp_query->have_posts() ) { ?>


                <article <?php echo post_class( array( 'gears-article-recent-posts' ) ); ?>>

                    <?php $gears_rp_query->the_post(); ?>

                    <header>
                        <div class="entry-thumbnail">
                            <?php if ( has_post_thumbnail() ) { ?>

                                <?php the_post_thumbnail( 'medium_large' ); ?>

                            <?php } else { ?>

                                <?php $default_thumb = plugins_url( '../../../assets/images/default-thumbnail.png', __FILE__ ); ?>

                                <img class="attachment-post-thumbnail" src="<?php echo esc_url( $default_thumb ); ?>" alt="<?php esc_attr_e('Post Thumbnail', 'flocks'); ?>" />

                            <?php } ?>
                        </div>
                        <div class="entry-meta">
                            <ul>
                                <li><?php the_author_link(); ?></li>
                                <li><?php the_date(); ?></li>
                                <li><?php comments_number(); ?></li>
                            </ul>
                        </div>
                        <div class="entry-title">
                            <h3>
                                <a href="<?php echo esc_url( the_permalink() );?>" title="<?php echo esc_attr( the_title() ); ?>">
                                    <?php the_title(); ?>
                                </a>
                            </h3>
                        </div>

                    </header>

                    <div class="entry-content">
                        <?php $excerpt = get_the_excerpt(); ?>
                        <?php if ( strlen( $excerpt ) <= 150 ) { ?>
                            <?php echo substr( $excerpt, 0, 150 ); ?>
                        <?php } else { ?>
                            <?php echo substr( $excerpt, 0, 150 ); ?>&hellip;
                        <?php } ?>
                    </div>

                    <div class="entry-footer">
                        <a class="readmore" href="<?php echo esc_url( the_permalink() ); ?>">
                            <?php _e('Read More', 'flocks'); ?>
                            <i class="fa fa-caret-right"></i>
                        </a>
                    </div>

                    <?php wp_reset_postdata(); ?>

                </article>

        <?php } ?>
    </ul>
<?php } ?>

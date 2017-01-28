<?php
/**
 * Gears Widgets Loader
 *
 * This file includes all the widgets in Gears. By using apply_filters, we
 * can decide if we want to enable or disable the widgets. By default, we
 * are disabling widgets and let the theme enable theme.
 *
 * Themes can also overwrite widgets display.
 *
 * @since 4.1.1
 */

if ( ! defined( 'ABSPATH' ) ) exit;


$widgets = array(
    'recent-posts' => array(
        'name' => 'recent-posts'
    ),
    'social-media-links' => array(
        'name' => 'social-media-links'
    )
);

foreach ( $widgets as $widget ):

    $widget_file = GEARS_APP_PATH . 'modules/widgets/' . $widget['name'] . '/' . $widget['name'] . '.php';

    if ( file_exists( $widget_file ) ):

        include_once  $widget_file;

    else:

        esc_html_e( "Unable to find widget file for: $widget", 'gears' );

    endif;

endforeach;
?>

<?php
extract(
	shortcode_atts( array(
		'style' => 'simple', // or circular
	), $atts )
);
?>

<span class="gears-dropcap-letter <?php echo sanitize_html_class( $style ); ?>">

	<?php echo do_shortcode( $content ); ?>
	
</span>

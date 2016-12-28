<?php
extract(
	shortcode_atts( array(
		'style' => 'simple', // or circular
	), $atts )
);
?>

<div class="gears-shortcode-element gears-dropcap-element-wrap clearfix <?php echo sanitize_html_class( $style ); ?>">
	<div class="gears-dropcap-element">
		<?php
			echo do_shortcode( wpautop( $content ) );
		?>
	</div>
</div>
<div class="clearfix"></div>

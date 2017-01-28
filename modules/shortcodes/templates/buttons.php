<?php
extract(
	shortcode_atts( array(
		'text' => __('Button', 'gears'),
		'link' => '#',
		'size' => 'sm', 
		'style' => 'solid', // transparent
	), $atts )
);
?>
<div class="gears-shortcode-element gears-button-element gears-clearfix">
	<a title="<?php echo esc_attr( $text ); ?>" class="<?php echo sanitize_html_class( $style ); ?> gears-button gears-button-<?php echo sanitize_html_class( $size ); ?> primary" href="<?php echo esc_url( $link ); ?>">
		<?php echo esc_html( $text ); ?>
	</a>
</div>

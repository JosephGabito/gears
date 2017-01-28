<?php
extract(
	shortcode_atts( array(
		'text' => 'I am an alert message. Use me to highlight any important text or messages.',
		'type' => 'info',
	), $atts )
);
?>

<div class="gears-clearfix gears-alert-element gears-shortcode-element">
	<div class="gears-alert gears-alert-<?php echo esc_attr( $type ); ?>">
		<p>
			<?php echo esc_html( $text ); ?>
		</p>
		<div class="gears-alert-close">&times;</div>
	</div>
</div>


<script>
jQuery(document).ready(function($){
	$('.gears-alert-close').on('click', function(){
		$(this).parent().remove();
	});
});
</script>
<?php 

$count_id = 'gears-count-up-' . uniqid(); 

extract( 
	shortcode_atts( array(
		'value' => 1000,
		'symbol' => '$',
		'unit' => '%',
		'description' => __('This is a text that you can use to explain what this counter is all about.', 'gears'),
		'style' => 'solid', // or transparent
		'color' => '#444',
		'background_color' => '#eee',
		'border_color' => '#222',
		), $atts ) 
	);

?>

<div id="<?php echo esc_attr( $count_id ); ?>-wrap" class="gears-counter gears-shortcode-element gears-clearfix <?php echo sanitize_html_class( $style ); ?>">
	
	<div id="<?php echo esc_attr( $count_id ); ?>-vars" data-color="<?php echo esc_attr( $color ); ?>" data-bg="<?php echo esc_attr( $background_color ); ?>" data-bc="<?php echo esc_attr( $border_color ); ?>"></div>

	<div class="gears-counter-numerical-data">

		<span class="gears-counter-symbol">
			<?php echo esc_html__( $symbol ); ?>
		</span>

		<span class="gears-counter-value" id="<?php echo esc_attr( $count_id ); ?>"></span>

		<span class="gears-counter-unit">
			<?php echo esc_html__( $unit ); ?>
		</span>
		
	</div>

	<div class="gears-counter-desciption">
		<p>
			<?php echo esc_html__( $description ); ?>
		</p>
	</div>

</div>

<div class="gears-clearfix"></div>

<script>

jQuery( document ).ready( function( $ ) {

	var count_value = '<?php echo intval( $value ); ?>';

	var options = {
		useEasing : true, 
		useGrouping : true, 
		separator : ',', 
		decimal : '.', 
		prefix : '', 
	 	suffix : '' 
	};

	var gears_count_up = new CountUp( "<?php echo esc_attr( $count_id ); ?>", 0, count_value, 0, 2.5, options );
	
	var count_up_section = $('#<?php echo esc_attr( $count_id ); ?>-wrap');

		count_up_section.css({
			color: '<?php echo $color; ?>',
			'background-color': '<?php echo $background_color; ?>',
			'border-color': '<?php echo $border_color; ?>',
		});

	gears_count_up.start();

} );
	
</script>
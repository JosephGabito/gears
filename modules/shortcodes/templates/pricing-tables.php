<?php
extract(
	shortcode_atts( array(
		'title' => '',
		'price_label' => '0.00',
		'price_currency' => '$',
		'payment_type_text' => __( 'Per Month', 'flocks' ),
		'features' => '',
		'button_label' => __('Purchase', 'flocks'),
		'button_link' => '#',
		'popular' => 'false',
		'color' => 'alizarin',
		'test_param' => 'alizarin'
		
	), $atts )
);

if ( !empty( $features ) ) {
	
	$features = explode( ',', $features );

} else {

	$features = array();

}

$output = '';

if ( 'true' == $popular ) { ?>

	<span class="glyphicon glyphicon-star"></span>

<?php } ?>


<div class="gears-pricing-table">
	
	<div class="gears-pricing-table-title widget-title-wrap">

		<h3 class="widget-title">

			<?php echo esc_html__( $title ); ?>

		</h3>

	</div>

	<div class="gears-pricing-table-price-label">

		<h3>

			<?php echo esc_html__( $price_label ); ?>	

		</h3>

	</div>

	<div class="gears-pricing-table-features">

		<?php if ( ! empty( $features ) ) { ?>

			<ul class="gears-pricing-table-features-list-wrap">

				<?php foreach ( ( array ) $features as $feature ) { ?>

					<?php $feature = trim( $feature ); ?>

					<?php if ( '!' == substr( $feature, 0, 1 ) ) { ?>
						
						<li class="gears-pricing-table-features-list">

							<span class="text-danger glyphicon glyphicon-remove-circle"></span> 

							<?php echo esc_html__( substr( $feature, 1 ) ); ?>

						</li>

					<?php } else { ?>
						
						<li class="gears-pricing-table-features-list">

							<span class="text-success glyphicon glyphicon-ok-circle"></span>

							<?php echo esc_html__( $feature ); ?>

						</li>

					<?php } ?>

				<?php } ?>
			
			</ul>

		<?php } ?>
	</div>

	<div class="gears-pricing-table-btn">

		<a href="<?php echo esc_url( $button_link ); ?>" class="btn btn-primary btn-lg">
			
			<?php echo esc_html__( $button_label ); ?>

		</a>

	</div>

</div>
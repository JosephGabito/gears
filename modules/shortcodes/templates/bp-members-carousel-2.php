<?php
$output = '';

extract(
	shortcode_atts( array(
		'type' => '',
		'max_item' => 10,
		'max_slides' => 7,
		'min_slides' => 1,
		'item_width' => 320,
		'slide_margin' => 20
	), $atts )
);

$params = array(
	'type' => $type,
	'per_page' => $max_item
);

if ( function_exists( 'bp_has_members' ) ) {

	// begin bp members loop
	if ( bp_has_members( $params ) ) { ?>

		   	<ul data-slide-margin="<?php echo intval( $slide_margin ); ?>"
		   		data-max-slides="<?php echo intval( $max_slides ); ?>" 
		   		data-min-slides="<?php echo intval( $min_slides ); ?>"
				data-item-width="<?php echo intval( $item_width ); ?>" 
				class="gears-carousel-standard bp-members-carousel-2">

		    	<?php while ( bp_members() ) { ?>

		    		<?php bp_the_member(); ?>

			    	<li class="carousel-item gears-members-carousel-2-item">

			    		<div class="gears-members-carousel-2-wrap">

			    			<div class="cover-photo">

			    				<?php if ( function_exists( 'bcp_get_cover_photo' ) ) { ?>

			    				<?php
			    					$args = array(
			    							'size' => 'thumb',
			    							'object_id' => bp_get_member_user_id()
			    						);

			    					$src = bcp_get_cover_photo( $args );
			    				?>
			    					<img src="<?php echo esc_url( $src ); ?>" alt="<?php esc_attr_e('Cover Photo','gears'); ?>"/>

								<?php } ?>

			    			</div>

			    			<div class="member-avatar">

			    				<a href="<?php bp_member_permalink(); ?>" title="<?php bp_member_name();?>">

			    					<?php bp_member_avatar( array('type' => 'thumb' ) ); ?>

			    				</a>

			    			</div>

			    			<div class="member-name">

			    				<a href="<?php bp_member_permalink(); ?>" title="<?php bp_member_name();?>">

			    					<h3><?php bp_member_name();?></h3>

			    				</a>

			    			</div>

			    			<div class="spacer"></div>

			    		</div>

			    	</li>

			    <?php } // end while ?>
	    
	    </ul>

	<?php } ?>

<?php } else { ?>
	
	<?php echo $this->bp_not_installed; ?>

<?php } ?>
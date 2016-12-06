<?php
/**
 * Gears shortcode collection
 *
 * @version 2.0
 * @since 2.0
 */

class Gears_Shortcodes{

	var $bp_not_installed = '';

	function __construct(){

		// configure default message for not complete bp installation
		$not_installed_tpl = '<div class="alert alert-warning">%s</div>';
		$not_installed_message = __('Sorry, BuddyPress must be enabled for this shortcode to work properly. If you have already installed and activated BuddyPress plugin, please make sure to enable this component inside "Settings" &rarr; "BuddyPress" &rarr; "Components".', 'gears');
		$not_installed_message = sprintf($not_installed_tpl, $not_installed_message);
		$this->bp_not_installed = $not_installed_message;

		// if visual composer is present integrate our modules to it
		if (function_exists('vc_map')) {
			$this->vc_integration();
		}

		$shortcode_list = array(
				'gears_bp_groups_carousel' => 'bp_groups_carousel',
				'gears_bp_groups_carousel_2' => 'bp_groups_carousel_2',
				'gears_bp_groups_grid' => 'bp_groups_grid',
				'gears_bp_groups_list' => 'bp_groups_list',
				'gears_bp_members_carousel' => 'bp_members_carousel',
				'gears_bp_members_carousel_2' => 'bp_members_carousel_2',
				'gears_bp_members_grid' => 'bp_members_grid',
				'gears_bp_members_list' => 'bp_members_list',
				'gears_bp_activity_stream' => 'gears_activity_stream',
				'gears_pricing_table' => 'gears_pricing_table',
				'gears_login' => 'gears_login',
				'gears_row' => 'gears_row',
				'gears_column' => 'gears_column',
				'gears_recent_posts' => 'gears_recent_posts',
			);

		// register all the shortcodes
		foreach ( $shortcode_list as $shortcode_id => $shortcode_callback ) {
			add_shortcode( $shortcode_id, array( $this, $shortcode_callback ) );
		}

		return $this;
	}

	function gears_recent_posts( $atts, $content )
	{
		$output = '';
		return $this->get_template_file( $atts, 'recent-posts.php');
	}
	/**
	 * Login form shortcode
	 * @param  array  $atts    [description]
	 * @param  string $content [description]
	 * @return string          [description]
	 */
	function gears_login($atts, $content)
	{

		$args = array('echo' => false);
		ob_start();
		?>
		<?php if ( ! is_user_logged_in() ) { ?>
			
		<div class="gears-login-wrap">
			<div class="gears-login-links">
				<ul>
					<li class="current">
						<?php _e('Sign in', 'gears'); ?>
					</li>
					<li>
						<a href="<?php echo wp_registration_url(); ?>" title="<?php _e('Create New Account','gears'); ?>">
							<?php _e('Create New Account', 'gears'); ?>
						</a>
					</li>
				</ul>
			</div>
			<div class="gears-login well">
				<?php echo wp_login_form($args); ?>
			</div>
		</div>
		<?php } ?>
		<?php
		$output = ob_get_clean();
		return $output;
	}

	/**
	 * Adds row to content
	 */
	function gears_row($atts, $content){
		// remove all annoying <br> and p
		$content = (do_shortcode($content));
		$content = str_replace("<br />", "\n", $content);
		$content = str_replace("<br>", "\n", $content);
		$content = str_replace("</p>\n<p>", "\n", $content);
		$content = str_replace("<p></p>", "\n", $content);

		return '<div class="row">'.$content.'</div>';
	}

	/**
	 * Adds columns to raw contnet
	 */
	function gears_column($atts, $content){

		$configs = array('size' => 12);
		extract(shortcode_atts($configs, $atts));
		$output = '<div class="col-md-'.$size.'">'.$content.'</div>';

		return $output;
	}

	/**
	 * shows members list
	 */
	function bp_members_carousel($atts)
	{
		return $this->get_template_file($atts, 'bp-members-carousel.php');
	}

	function bp_members_carousel_2($atts)
	{
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

		if( function_exists( 'bp_has_members' ) ){
			// begin bp members loop
			if ( bp_has_members( $params ) ){
			    ob_start();
				   	$output .= '<ul data-slide-margin="'.$slide_margin.'"';
				   	$output .= 'data-max-slides="'.$max_slides.'" data-min-slides="'.$min_slides.'"';
					$output .= 'data-item-width="'.$item_width.'" class="gears-carousel-standard bp-members-carousel-2">';
				    	while ( bp_members() ) {
				    		bp_the_member();
					    ?>
					    	<li class="carousel-item gears-members-carousel-2-item">
					    		<div class="gears-members-carousel-2-wrap">
					    			<div class="cover-photo">
					    				<?php
					    				if(function_exists('bcp_get_cover_photo')){

					    					$args = array(
					    							'size' => 'thumb',
					    							'object_id' => bp_get_member_user_id()
					    						);

					    					$src = bcp_get_cover_photo($args);

					    					echo '<img src="'.$src.'" alt="'.__('Cover Photo','gears').'"/>';

					    				}
					    				?>
					    			</div>
					    			<div class="member-avatar">
					    				<a href="<?php bp_member_permalink(); ?>" title="<?php bp_member_name();?>">
					    					<?php bp_member_avatar( array('type' => 'thumb' )); ?>
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
					    <?php
				    	} // end while

			    $output .= ob_get_clean();
			    $output .= '</ul>';
			}

			return $output;

		}else{
			return $this->bp_not_installed;
		}
	}

	/**
	 * BP Members Grid
	 */
	function bp_members_grid( $atts ) {

		$output = '';
		$default_columns = 3; // 4 columns
		$allowed_columns = array(2, 3, 4, 6);

		extract(
			shortcode_atts( array(
				'type' => '',
				'max_item' => 10,
				'columns' => $default_columns // allowed 2, 3, 4, 6
			), $atts )
		);

		$columns = floor(12 / $columns);


		// catch invalid columns
		if (!in_array($columns, $allowed_columns)) {
			$columns = $default_columns;
		}

		// available columns are  2, 3, 4, and 6
		$columns_classes = ' col-md-'.$columns.' col-sm-'.$columns.' col-xs-6';

		$params = array(
			'type' => $type,
			'per_page' => $max_item
		);

		if( function_exists( 'bp_has_members' ) ){
			if (bp_has_members($params)){
				ob_start();
				?>
				<ul class="ul-bp-members-grid">
					<?php
					while(bp_members()){

						bp_the_member();

						$name = bp_get_member_name();
						$permalink = bp_get_member_permalink();
						$last_active = bp_get_member_last_active();
						$status_update = "";

							$membersStatusUpdate = bp_get_member_latest_update();

							if (!empty($membersStatusUpdate)) {
								$status_update = $membersStatusUpdate;
							}

						$content = '<p>'.$status_update.'</p><p>'.$last_active.'</p>';
						?>
						<li class="bp-members-grid-item <?php echo $columns_classes; ?>">
							<div class="gears-bp-members-grid">
								<a href="<?php echo esc_url($permalink); ?>" title="<?php echo esc_attr($name);?>">
									<span class="members-name"><?php echo esc_attr($name);?></span>
								</a>
								<a href="<?php echo esc_url($permalink); ?>" title="<?php echo esc_attr($name);?>">
									<?php echo bp_get_member_avatar( array('type' => 'full', 'class' => 'avatar')); ?>
								</a>

							</div>
						</li>
						<?php
					}
					?>
				</ul>
				<?php
			}
			$output = ob_get_clean();

			return $output;
		}else{
			return $this->bp_not_installed;
		}
	}

	/**
	 * BP Members List
	 */
	function bp_members_list($atts) {

		return $this->get_template_file($atts, 'bp-members-list.php');

	}

	/**
	 * BP Groups Carousel
	 */

	function bp_groups_carousel( $atts ){

		// check if buddypres component is loaded
		if (!function_exists('bp_has_groups')) {
			return __('<div class="alert alert-warning">Oops! BuddyPress Groups Component is not currently enabled.</div>', 'gears');
		}

		extract(
			shortcode_atts( array(
				'type' => 'active',
				'max_item' => 10,
				'max_slides' => 7,
				'min_slides' => 1,
				'slide_margin' => 0,
				'item_width' => 100
			), $atts )
		);

		$params = array(
			'type' => $type,
			'per_page' => $max_item
		);

		$output = '';
		if( function_exists( 'bp_has_groups' ) ){
			if( bp_has_groups( $params ) ){
				$output .= '<div class="clearfix">';
					$output .= '<ul data-slide-margin="'.$slide_margin.'" data-max-slides="'.$max_slides.'"
					data-min-slides="'.$min_slides.'" data-item-width="'.$item_width.'"
					class="gears-carousel-standard bp-groups-carousel">';

						while ( bp_groups() ){
							bp_the_group();

							$permalink = esc_url(bp_get_group_permalink());
							$group_title = esc_attr(bp_get_group_name());
							$member_count = intval(bp_get_group_member_count());
							$last_active = sprintf( __( 'active %s', 'buddypress' ), bp_get_group_last_active() );
							$content = $member_count . ' &middot; ' . $last_active;

							$output .= '<li class="carousel-item gears-bp-groups-carousel center">';
								$output .= '<a class="group-title" href="'. esc_url($permalink).'" title="'. esc_attr($group_title) .'">';
									$output .= '<span class="groups-name">';
											$output .= esc_attr($group_title);
											$output .= '<span class="groups-count">';
												$output .= $member_count . ' ';
													if ($member_count == 1) {
														$output .= __('Member', 'gears');
													} else {
														$output .= __('Members', 'gears');
													}
											$output .= '</span>';
										$output .= '</span>';
								$output .= '</a>';

									$output .= '<a href="'. esc_url($permalink).'" title="'. esc_attr($group_title) .'">';
										$output .= bp_get_group_avatar( array(	'type' => 'full' ));
									$output .= '</a>';
							$output .= '</li>';
						}
					$output .= '</ul>';
				$output .= '</div>';
			}else{
				$output .= '<div class="alert alert-info">' . __( 'There are no groups to display. Please try again soon.', 'gears' ) . '</div>';
			}
			return $output;
		}else{
			return $this->bp_not_installed;
		}
	}

	/**
	 * BP Groups Carousel
	 */

	function bp_groups_carousel_2( $atts ) {

		return $this->get_template_file( $atts, 'bp-groups-carousel-2.php' );

	}

	/**
	 * BP Groups Grid
	 */

	function bp_groups_grid( $atts ){

		$default_columns = 3; //four columns
		$allowed_columns = array(2, 3, 4, 6);

		extract(
			shortcode_atts( array(
				'type' => 'active',
				'max_item' => 10,
				'columns' => $default_columns
			), $atts )
		);

		$columns = floor(12/$columns);

		// ensure that columns is scalable
		if (!in_array($columns, $allowed_columns)) {
			// default to default columns settings, just in case
			$columns = $default_columns;
		}

		$columns_classes = 'col-md-'.$columns.' col-sm-'.$columns.' col-xs-6';

		$params = array(
			'type' => $type,
			'per_page' => $max_item
		);

		$output = '';


		if( function_exists( 'bp_has_groups' ) ){
			if( bp_has_groups( $params ) ){
					ob_start();
					?>
					<ul class="clearfix gears-bp-groups-grid">
						<?php while( bp_groups() ){ ?>
						<?php bp_the_group(); ?>
							<li class="bp-groups-grid-item <?php echo $columns_classes; ?>">
								<?php $name = bp_get_group_name(); ?>
								<?php $permalink = bp_get_group_permalink(); ?>
								<?php $last_active = bp_get_group_last_active(); ?>
								<?php $members_count = bp_get_group_member_count(); ?>
								<?php $modal_content = esc_attr($members_count . ' &middot; ' . __('Active ','gears') . $last_active . ''); ?>

								<a title="<?php echo esc_attr($name); ?>" href="<?php echo esc_url($permalink); ?>">
									<span class="groups-name">
										<?php echo esc_attr($name);?>
											<span class="groups-count">
												<?php echo intval($members_count); ?>
												<?php if ($members_count == 1) { ?>
													<?php _e('Member', 'gears'); ?>
												<?php } else { ?>
													<?php _e('Members', 'gears'); ?>
												<?php } ?>
											</span>
									</span>

								</a>

								<a title="<?php echo esc_attr($name); ?>" href="<?php echo esc_url($permalink); ?>">
									<?php echo bp_get_group_avatar( array(	'type' => 'full' )); ?>
								</a>
							</li>
						<?php } ?>
					</ul>
				<?php
				$output = ob_get_clean();
				return $output;
			}else{
				return '<div class="alert alert-info">' . __( 'There are no groups to display. Please try again soon.', 'gears' ) . '</div>';
			}

		}else{
				return $this->bp_not_installed;
			}
	} // end function

	/**
	 * BP Groups List
	 */
	function bp_groups_list($atts, $content = "")
	{
		return $this->get_template_file($atts, 'bp-groups-list.php');
	}

	/**
	 * Shows activity stream
	 */
	function gears_activity_stream( $atts ){

		// start buffering output
		ob_start();

		extract(
			shortcode_atts(
				array(
					'title' => ''
				), $atts
			)
		);

		if (function_exists('bp_activity_directory_permalink')) {

			$output = '';
			$params = array(
				'title' => $title
			);

			echo '<div class="buddypress">';

			echo '<h3>'.esc_attr($title).'</h3>';

				bp_get_template_part( 'buddypress/activity/index' );

			echo '</div>';

            $output = ob_get_contents();

            ob_end_clean();

			return $output;

		}else{
			return $this->bp_not_installed;
		}
	}

	/**
	 * @deprecated gears_get_activity_stream
	 */
		function gears_get_activity_stream(){

			$output = '';
				$output .= '<li class="'. bp_get_activity_css_class() .'" id="activity-'. bp_get_activity_id() .'">';
					$output .= '<div class="activity-avatar">';
						$output .= '<a class="gears-activity-avatar" title="'.__( 'View Profile','gears' ).'" href="'. bp_get_activity_user_link() .'">';
							$output .=  bp_get_activity_avatar();
						$output .= '</a>';
					$output .= '</div>';
					// activity content
					$output .= '<div class="activity-content">';
						$output .= '<div class="activity-header">';
							$output .= bp_get_activity_action();
						$output .= '</div>';

						$output .= '<div class="activity-inner">';
							if( bp_activity_has_content() ){
								$output .= bp_get_activity_content_body();
							}
						$output .= '</div>';

						do_action( 'bp_activity_entry_content' );

						$output .= '<div class="activity-meta">';
							if ( bp_get_activity_type() == 'activity_comment' ){
								$output .= '<a href="'.bp_get_activity_thread_permalink(). '" class="view bp-secondary-action" title="'.__( 'View Conversation', 'gears' ). '">'.__( 'View Conversation', 'gears' ).'</a>';
							}

							if ( is_user_logged_in() ){

								if ( bp_activity_can_favorite() ){
									if ( !bp_get_activity_is_favorite() ){
										$output .= '<a href="'.bp_get_activity_favorite_link().'" class="fav bp-secondary-action" title="'.esc_attr( __('Mark as Favorite', 'gears') ).'">'.__( 'Favorite', 'gears' ).'</a>';
									}else{
										$output .= '<a href="'.bp_get_activity_unfavorite_link().'" class="unfav bp-secondary-action" title="'.esc_attr( __('Remove Favorite', 'gears') ).'">'.__( 'Remove Favorite', 'gears' ).'</a>';
									}
								}

								if ( bp_activity_user_can_delete() ){
									$output .= bp_get_activity_delete_link();
								}
								do_action( 'bp_activity_entry_meta' );

							}
						$output .= '</div>';

						if ( bp_get_activity_type() == 'activity_comment' ){
							$output .= '<a href="'. bp_get_activity_thread_permalink() . '" class="view bp-secondary-action" title="'. __( 'View Conversation', 'gears' ) .'">'. __( 'View Conversation', 'gears' );
						} // end bp_get_activity_type()

					$output .= '</div>';
					// end activity content
				$output .= '</li>';

			return $output;

		}

	/**
	 * gears pricing table
	 *
	 *	Title
	 *	Price Label
	 *	Features/Services Offered (separated by comma).
	 *  	Append '[x]' in the feature list to suggest a feature which is not available.
	 *	  	Otherwise, append '[/]' in the feature list to suggest that the feature is
	 *	  	available.
	 *	Button Label
	 *	Button Link
	 *	Color Scheme
	 *
	 */

	function gears_pricing_table( $atts ){

		extract(
			shortcode_atts( array(
				'title' => '',
				'price_label' => '$0.00',
				'features' => '',
				'button_label' => 'Purchase',
				'button_link' => '#',
				'popular' => 'false',
				'color' => 'alizarin'
			), $atts )
		);

		if( !empty( $features ) ){
			$features = explode( ',', $features );
		}else{
			$features = array();
		}

		$output = '';

		if( 'true' == $popular ){
			$title .= ' <span class="glyphicon glyphicon-star"></span>';
		}
		$output .= '<div class="clearfix">';
			$output .= '<div class="gears-pricing-table">';
				$output .= '<div class="gears-pricing-table-title widget-title-wrap"><h3 class="widget-title">'.$title.'</h3></div>';
				$output .= '<div class="gears-pricing-table-price-label"><h3>'.$price_label.'</h3></div>';
				$output .= '<div class="gears-pricing-table-features">';
					if( !empty( $features ) ){
						foreach( (array) $features as $feature){
							$feature = trim( $feature );

							if( '!' == substr( $feature, 0, 1 ) ){
								$output .= '<li class="gears-pricing-table-features-list"><span class="text-danger glyphicon glyphicon-remove-circle"></span> '.substr( $feature, 1 ).'</li>';
							}else{
								$output .= '<li class="gears-pricing-table-features-list"><span class="text-success glyphicon glyphicon-ok-circle"></span> '.$feature.'</li>';
							}
						}
					}
				$output .= '</div>';
				$output .= '<div class="gears-pricing-table-btn">';
					$output .= '<a href="'.$button_link.'" class="btn btn-success btn-lg">'.$button_label.'</a>';
				$output .= '</div>';
			$output .= '</div>';
		$output .= '</div>';

		return $output;
	}

	function get_template_file($atts, $file = '') {

		ob_start();

		if (empty($file)) {
			return;
		}

		$template = GEARS_APP_PATH.'modules/shortcodes/templates/'.$file;

		if ($theme_template = locate_template(array('gears/shortcodes/'.$file))) {
        	$template = $theme_template;
    	}

    	include $template;

    	return ob_get_clean();
	}

	/**
	 * Integrates our shortcode into Visual Composer Screen
	 *
	 * @since 1.0
	 */
	 function vc_integration(){

		require_once GEARS_APP_PATH . '/modules/shortcodes/vc.php';

		$vc_modules = new Gears_Visual_Composer();
		// members carousel
		$vc_modules->load( 'gears_bp_members_carousel' );
		// members carousel 2
		$vc_modules->load( 'gears_bp_members_carousel_2' );

		// members grid
		$vc_modules->load( 'gears_bp_members_grid' );
		// members list
		$vc_modules->load( 'gears_bp_members_list' );
		// groups carousel
		$vc_modules->load( 'gears_bp_groups_carousel' );
		// groups caoursel 2
		$vc_modules->load( 'gears_bp_groups_carousel_2' );
		// groups grid
		$vc_modules->load( 'gears_bp_groups_grid' );
		// groups list
		$vc_modules->load( 'gears_bp_groups_list' );
		// pricing table
		$vc_modules->load( 'gears_pricing_table' );
		// activity stream
		$vc_modules->load( 'gears_bp_activity_stream' );
	 }
}

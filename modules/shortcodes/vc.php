<?php
if( !class_exists( 'Gears_Visual_Composer' ) ){

	class Gears_Visual_Composer{
	
		/**
		 * Module Loader
		 */
		public function load( $module = '' ){
			require_once GEARS_APP_PATH . '/modules/shortcodes/vc/' . $module . '.php';
		}
		
	}
}
?>
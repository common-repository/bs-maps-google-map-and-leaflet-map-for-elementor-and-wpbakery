<?php
/**
 * GMAP Shortcode  block
 *
 * @author  Balcomsoft
 * @package Bsmaps
 * @version 1.0.0
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

if ( ! class_exists( 'Bsmaps_Shortcode_Gmap' ) ) {
	/**
	 * MAP shortcode class
	 *
	 * @return void
	 */
	class Bsmaps_Shortcode_Gmap {
		/**
		 * Slug
		 *
		 * @var string
		 */
		protected $slug = 'bsmaps-vc-gmap';



		/**
		 *  Constructor
		 */
		public function __construct() {

			add_shortcode( $this->slug . '-shortcode', array( $this, 'render' ) );
		}


		/**
		 * Render
		 *
		 * @param array  $atts Array of attributes.
		 * @param string $content Content body.
		 * @return string
		 */
		public function render( $atts, $content ) {

			ob_start();
			if ( ! empty( $content ) ) {
				$atts['content'] = $content;
			}

			include bsmaps_shortcode_locate_template( $this->slug, $atts );
			return ob_get_clean();
		}
	}

	new Bsmaps_Shortcode_Gmap();
}

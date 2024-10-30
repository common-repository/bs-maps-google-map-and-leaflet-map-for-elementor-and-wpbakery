<?php
/**
 * BMI VC block
 *
 * @author  Balcomsoft
 * @package Bsmaps
 * @version 1.0.0
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	die();
}
if ( ! class_exists( 'Bsmaps_VC_Gmap' ) ) {
	/**
	 * BMI shortcode class
	 *
	 * @return void
	 */
	class Bsmaps_VC_Gmap extends WPBakeryShortCode {
		/**
		 * Slug
		 *
		 * @var string
		 */
		protected $slug = 'bsmaps-vc-gmap';

		/**
		 * Name escaped
		 *
		 * @var string
		 */
		protected $name_escaped;

		/**
		 *  Constructor
		 */
		public function __construct() {
			$this->set_name();
			add_action( 'init', array( $this, 'mapping' ), 999 );
		}

		/**
		 * Register script styles
		 */
		public function jsScripts() {
			if ( file_exists( BSMAPS_PATH . '/assets/dist/components/' . $this->slug . '/css/app.css' ) ) {
				wp_register_style( $this->slug, BSMAPS_ASSETS . '/dist/components/' . $this->slug . '/css/app.css', array(), BSMAPS_VERSION );
			}
			if ( file_exists( BSMAPS_PATH . '/assets/dist/components/' . $this->slug . '/js/wpbackery/app.js' ) ) {
				wp_register_script( $this->slug, BSMAPS_ASSETS . '/dist/components/' . $this->slug . '/js/wpbackery/app.js', array( 'jquery' ), BSMAPS_VERSION, true );
			}
		}

		/**
		 *  Set name
		 */
		private function set_name() {
			$this->name_escaped = esc_html__( 'BS Google Map', 'bsmaps' );
		}

		/**
		 * Mapping
		 *
		 * @return void
		 */
		public function mapping() {
			$this->jsScripts();
			vc_map(
				array(
					'base'     => $this->slug . '-shortcode',
					'name'     => $this->name_escaped,
					'category' => esc_html__( 'Balcomsoft Widgets', 'bsmaps' ),
					'icon'     => 'bsmaps-vc-icon',
					'params'   => array(
						array(
							'type'       => 'param_group',
							'heading'    => '',
							'param_name' => 'markers',
							'group'      => 'Markers',
							'params'     => array(
								array(
									'type'        => 'textfield',
									'value'       => '',
									'heading'     => esc_html__( 'Latitude', 'bsmaps' ),
									'param_name'  => 'lat',
									'description' => esc_html__( 'Example: 51.507351. You can use <a href="https://www.latlong.net/" target="_blank">this tool</a> to look up Latitude and Longitude for a location.', 'bsmaps' ),
								),
								array(
									'type'        => 'textfield',
									'value'       => '',
									'heading'     => esc_html__( 'Longitude', 'bsmaps' ),
									'param_name'  => 'lng',
									'description' => esc_html__( 'Example: -0.127758. You can use <a href="https://www.latlong.net/" target="_blank">this tool</a> to look up Latitude and Longitude for a location.', 'bsmaps' ),
								),
								array(
									'type'        => 'textfield',
									'value'       => '',
									'heading'     => esc_html__( 'Location Name', 'bsmaps' ),
									'param_name'  => 'name',
									'description' => esc_html__( 'Enter Location Name', 'bsmaps' ),
								),
								array(
									'type'        => 'textfield',
									'value'       => '',
									'heading'     => esc_html__( 'Location description', 'bsmaps' ),
									'param_name'  => 'description',
									'description' => esc_html__( 'Enter description', 'bsmaps' ),
								),
							),
						),
						array(
							'type'        => 'dropdown',
							'heading'     => esc_html__( 'Style Mode', 'bsmaps' ),
							'param_name'  => 'activemode',
							'group'       => 'Map',
							'value'       => array(
								esc_attr__( 'Default Mode', 'bsmaps' ) => 'defaultMode',
								esc_attr__( 'Silver Mode', 'bsmaps' )  => 'silverMode',
								esc_attr__( 'Dark Mode', 'bsmaps' )    => 'darkMode',
								esc_attr__( 'Retro Mode', 'bsmaps' )   => 'retroMode',
							),
							'description' => esc_html__( 'Style Mode', 'bsmaps' ),
						),
						array(
							'type'        => 'textfield',
							'heading'     => esc_html__( 'Map center coordinates', 'bsmaps' ),
							'param_name'  => 'map_center',
							'group'       => 'Map',
							'value'       => '',
							'description' => esc_html__( 'Example: 41.881832, -87.623177. Show this location as center of the map', 'bsmaps' ),
						),
						array(
							'type'        => 'bsmaps_number',
							'heading'     => esc_html__( 'Map zoom', 'bsmaps' ),
							'param_name'  => 'zoom',
							'group'       => 'Map',
							'value'       => 15,
							'description' => esc_html__( 'Map zoom level', 'bsmaps' ),
						),
						bsmaps_vc_regular_fields( 'element_class' ),
						bsmaps_vc_regular_fields( 'element_id' ),
						bsmaps_vc_regular_fields( 'css' ),
					),
				)
			);
		}
	}

	new Bsmaps_VC_Gmap();
}

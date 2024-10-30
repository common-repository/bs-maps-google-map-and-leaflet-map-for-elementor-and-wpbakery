<?php
/**
 * BsMap Elementor Leaflet Map
 *
 * @author  Balcomsoft
 * @package BsMap
 * @version 1.0.0
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

use Elementor\Widget_Base;
use Elementor\Repeater;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;
use Elementor\Icons_Manager;

if ( ! class_exists( 'Bsmaps_Elementor_Lmap' ) ) {
	/**
	 * Bs_Map shortcode class
	 *
	 * @return void
	 */
	class Bsmaps_Elementor_Lmap extends Widget_Base {
		/**
		 * Slug
		 *
		 * @var string
		 */
		protected $slug = 'bsmaps-elementor-lmap';

		/**
		 * Handler Stiles, Javascript files.
		 *
		 * @var string
		 */
		protected $handler = 'bsmaps-vc-lmap';

		/**
		 * Name escaped
		 *
		 * @var string
		 */
		protected $name_escaped;

		/**
		 * Constructor .
		 *
		 * @param array $data Data.
		 * @param null  $args Args.
		 */
		public function __construct( $data = array(), $args = null ) {
			parent::__construct( $data, $args );
			$this->wp_register_script_style();
		}

		/**
		 * Get style depends
		 *
		 * @return string[]
		 */
		public function wp_register_script_style() {
			if ( file_exists( BSMAPS_PATH . '/assets/dist/components/' . $this->handler . '/css/app.css' ) ) {
				wp_register_style( $this->handler, BSMAPS_ASSETS . '/dist/components/' . $this->handler . '/css/app.css', array(), BSMAPS_VERSION );
			}
			if ( file_exists( BSMAPS_PATH . '/assets/dist/components/' . $this->handler . '/js/elementor/app.js' ) ) {
				wp_deregister_script( $this->handler );
				wp_register_script( $this->handler, BSMAPS_ASSETS . '/dist/components/' . $this->handler . '/js/elementor/app.js', array( 'jquery' ), BSMAPS_VERSION, true );
			}

			return array( $this->handler );
		}

		/**
		 * Get style depends
		 *
		 * @return string[]
		 */
		public function get_style_depends() {
			return array( $this->handler );
		}

		/**
		 * Get javascript depends
		 *
		 * @return string[]
		 */
		public function get_script_depends() {
			return array( $this->handler );
		}

		/**
		 * Get Name.
		 *
		 * @return string
		 */
		public function get_name() {
			return $this->slug;
		}

		/**
		 *  Get Title
		 */
		public function get_title() {
			return esc_html__( 'BS Leaflet Map', 'bsmaps' );
		}

		/**
		 * Get Icon.
		 *
		 * @return string
		 */
		public function get_icon() {
			return 'eicon-google-maps';
		}

		/**
		 * Get Categories.
		 *
		 * @return string[]
		 */
		public function get_categories() {
			return array( 'bsmaps-widgets' );
		}

		/**
		 * Get General options.
		 *
		 * @author Balcomsoft
		 */
		protected function get_general_options() {
			$this->start_controls_section(
				'general_section',
				array(
					'label' => esc_html__( 'General Settings', 'bsmaps' ),
					'tab'   => Controls_Manager::TAB_CONTENT,
				)
			);

			$repeater = new Repeater();
			$repeater->add_control(
				'lat',
				array(
					'label'       => esc_html__( 'Latitude', 'bsmaps' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => array(
						'active' => true,
					),
					'default'     => '28.612912',
					'placeholder' => esc_html__( 'Enter Latitude', 'bsmaps' ),
				)
			);
			$repeater->add_control(
				'lng',
				array(
					'label'       => esc_html__( 'Longtitute', 'bsmaps' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => array(
						'active' => true,
					),
					'default'     => '77.229510',
					'placeholder' => esc_html__( 'Enter Longtitute', 'bsmaps' ),
				)
			);
			$repeater->add_control(
				'name',
				array(
					'label'       => esc_html__( 'Location Name', 'bsmaps' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => array(
						'active' => true,
					),
					'default'     => 'Some Location',
					'placeholder' => esc_html__( 'Enter Location Name', 'bsmaps' ),
				)
			);
			$repeater->add_control(
				'description',
				array(
					'label'       => esc_html__( 'Location description', 'bsmaps' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => array(
						'active' => true,
					),
					'default'     => 'Some description',
					'placeholder' => esc_html__( 'Enter description', 'bsmaps' ),
				)
			);

			$this->add_control(
				'markers',
				array(
					'label'   => esc_html__( 'Markers', 'bsmaps' ),
					'type'    => Controls_Manager::REPEATER,
					'fields'  => $repeater->get_controls(),
					'default' => array(
						array(
							'lat'     => '28.612912',
							'lng'     => '77.229510',
							'address' => esc_html__( 'Put Address Here', 'bsmaps' ),
						),
					),
				)
			);
			$this->add_control(
				'map_center',
				array(
					'label'       => esc_html__( 'Map center coordinates', 'bsmaps' ),
					'type'        => \Elementor\Controls_Manager::TEXTAREA,
					'row'         => '1',
					'default'     => '41.881832,-87.623177',
					'description' => esc_html__( 'Show this location as center of the map', 'bsmaps' ),
				)
			);
			$this->add_control(
				'activemode',
				array(
					'label'   => esc_html__( 'Style Mode', 'bsmaps' ),
					'type'    => Controls_Manager::SELECT,
					'options' => array(
						'defaultMode' => esc_html__( 'Default Mode', 'bsmaps' ),
						'silverMode'  => esc_html__( 'Silver Mode', 'bsmaps' ),
						'darkMode'    => esc_html__( 'Dark Mode', 'bsmaps' ),
						'retroMode'   => esc_html__( 'Retro Mode', 'bsmaps' ),
					),
					'default' => 'defaultMode',
				)
			);
			$this->add_control(
				'zoom',
				array(
					'label'   => esc_html__( 'Zoom', 'bsmaps' ),
					'type'    => Controls_Manager::SLIDER,
					'range'   => array(
						'px' => array(
							'min' => 6,
							'max' => 20,
						),
					),
					'default' => array(
						'unit' => 'px',
						'size' => 10,
					),
				)
			);
			$this->end_controls_section();

		}

		/**
		 * Register Controls.
		 *
		 * @author Balcomsoft
		 */
		protected function register_controls() {
			$this->get_general_options();

		}

		/**
		 * Render.
		 */
		protected function render() {
			$atts = $this->get_settings_for_display();
			if ( ! empty( $content ) ) {
				$atts['content'] = $content;
			}

			$arg_strings = bsmaps_elementor_args( $atts );

			echo do_shortcode( '[bsmaps-vc-lmap-shortcode ' . $arg_strings . ']' );
		}
	}

	\Elementor\Plugin::instance()->widgets_manager->register( new Bsmaps_Elementor_Lmap() );

}

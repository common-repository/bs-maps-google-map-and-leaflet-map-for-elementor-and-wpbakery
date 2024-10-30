<?php
/**
 * Autoload.
 *
 * @author  Balcomsoft
 * @package Bsmaps
 * @version 1.0.0
 * @since   1.0.0
 */

if ( ! function_exists( 'bsmaps_core_autoload' ) ) {
	/**
	 * Locate class files to load
	 *
	 * @param string $path path to class file.
	 *
	 * @return void
	 */
	function bsmaps_core_autoload( $path ) {
		$items = glob( $path . DIRECTORY_SEPARATOR . '*' );
		foreach ( $items as $item ) {
			if ( is_file( $item ) ) {
				$basename = basename( $item );
				if ( 'php' === pathinfo( $item )['extension']
					&& ( false !== strpos( $basename, 'class-bsmaps-' ) || strpos( $basename, 'bsmaps-' ) !== false )
				) {
					require_once $item;
				}
			}
		}
		// Load files in subdirectories.
		foreach ( $items as $item ) {
			if ( is_dir( $item ) ) {
				bsmaps_core_autoload( $item );
			}
		}
	}
}
if ( ! function_exists( 'bsmaps_vc_regular_fields' ) ) {
	/**
	 * BS MAPS VC function
	 *
	 * @param string $asset   Asset.
	 * @param array  $options Array of options.
	 *
	 * @return mixed
	 */
	function bsmaps_vc_regular_fields( $asset, $options = array() ) {
		$response = array();
		switch ( $asset ) {

			case 'element_class':
				$response = array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'HTML Class', 'bsmaps' ),
					'param_name'  => 'element_class',
					'admin_label' => true,
					'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'bsmaps' ),
				);
				break;
			case 'element_id':
				$response = array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'HTML ID', 'bsmaps' ),
					'param_name'  => 'element_id',
					'admin_label' => true,
				);
				break;
			case 'css':
				$response = array(
					'type'       => 'css_editor',
					'heading'    => esc_html__( 'CSS', 'bsmaps' ),
					'param_name' => 'css',
					'group'      => esc_html__( 'Design options', 'bsmaps' ),
				);
				break;

		}

		return array_merge( $response, $options );
	}
}
if ( ! function_exists( 'bsmaps_shortcode_locate_template' ) ) {
	/**
	 * BS MAPS Shortcode template view function
	 *
	 * @param string $template_name Template name.
	 * @param array  $args          Hide Arguments.
	 *
	 * @return mixed
	 */
	function bsmaps_shortcode_locate_template( $template_name, $args ) {
		$plugin_path         = BSMAPS_PATH . '/includes/shortcodes/output/' . $template_name . '.php';
		$theme_template_name = 'bsmaps/' . $template_name . '.php';

		return ( locate_template( $theme_template_name ) ) ? locate_template( $theme_template_name ) : $plugin_path;
	}
}
if ( ! function_exists( 'bsmaps_views_template' ) ) {
	/**
	 * BS MAPS VC function
	 *
	 * @param string $template_name Template name.
	 *
	 * @return mixed
	 */
	function bsmaps_views_template( $template_name ) {
		return BSMAPS_VIEWS_OUTPUT_PATH . '/' . $template_name . '.php';
	}
}
if ( ! function_exists( 'bsmaps_shortcode_custom_css_class' ) ) {

	/**
	 *
	 * Filter Css class.
	 *
	 * @param string $params parameters.
	 * @param string $pr     prefix.
	 *
	 * @return string
	 */
	function bsmaps_shortcode_custom_css_class( $params, $pr = '' ) {
		$filtered_css = preg_match( '/\s*\.([^\{]+)\s*\{\s*([^\}]+)\s*\}\s*/', $params ) ? $pr . preg_replace( '/\s*\.([^\{]+)\s*\{\s*([^\}]+)\s*\}\s*/', '$1', $params ) : '';

		return $filtered_css;
	}
}
if ( ! function_exists( 'bsmaps_elementor_regular_fields' ) ) {
	/**
	 * Bs Maps Elementor function
	 *
	 * @param string $asset   Asset.
	 * @param array  $options Array of options.
	 * @param string $element Element.
	 *
	 * @return mixed
	 */
	function bsmaps_elementor_regular_fields( $asset, $options = array(), $element = '' ) {
		switch ( $asset ) {
			case 'element_class':
				$element->add_control(
					'element_class',
					array(
						'label'       => esc_html__( 'HTML Class', 'bsmaps' ),
						'type'        => \Elementor\Controls_Manager::TEXT,
						'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'bsmaps' ),
					)
				);
				break;
			case 'element_id':
				$element->add_control(
					'element_id',
					array(
						'label'       => esc_html__( 'HTML ID', 'bsmaps' ),
						'type'        => \Elementor\Controls_Manager::TEXT,
						'description' => esc_html__( 'Style particular content element differently - add a ID and refer to it in custom ID.', 'bsmaps' ),
					)
				);
				break;
			case 'css':
				$element->add_control(
					'css',
					array(
						'label' => esc_html__( 'CSS', 'bsmaps' ),
						'type'  => \Elementor\Controls_Manager::TEXTAREA,
					)
				);
				break;
		}
	}
}
if ( ! function_exists( 'bsmaps_elementor_status' ) ) {
	/**
	 * Elementor status check
	 *
	 * @return bool
	 * @author Balcomsoft
	 */
	function bsmaps_elementor_status() {
		$elementor_path    = 'elementor/elementor.php';
		$installed_plugins = get_plugins();

		return isset( $installed_plugins[ $elementor_path ] );
	}
}
if ( ! function_exists( 'bsmaps_elementor_args' ) ) {
	/**
	 * Parcing elementor arguments.
	 *
	 * @param array $args arguments.
	 *
	 * @return string
	 * @author Balcomsoft
	 */
	function bsmaps_elementor_args( $args ) {
		$arg_strings = '';
		foreach ( $args as $key => $value ) {
			if ( ! empty( $value ) ) {
				if ( is_array( $value ) ) {
					$arg_strings .= $key . '="' . rawurlencode( wp_json_encode( $value ) ) . '" ';
				} else {
					$arg_strings .= $key . '="' . $value . '" ';
				}
			}
		}

		return $arg_strings;
	}
}
if ( ! function_exists( 'bsmaps_vc_enqueue_scripts_styles' ) ) {
	/**
	 * Bs BMI Enqueue Scripts & Styles
	 *
	 * @param string $shortcode_slug VC shortcode slug.
	 *
	 * @return void
	 */
	function bsmaps_vc_enqueue_scripts_styles( $shortcode_slug ) {

		if ( file_exists( BSMAPS_ASSETS . '/dist/components/' . $shortcode_slug . '/css/app.css' ) ) {
			wp_register_style( $shortcode_slug, BSMAPS_ASSETS . '/dist/components/' . $shortcode_slug . '/css/app.css', array(), BSMAPS_VERSION );
		}
		if ( file_exists( BSMAPS_ASSETS . '/dist/components/' . $shortcode_slug . '/js/app.js' ) ) {
			wp_register_script( $shortcode_slug, BSMAPS_ASSETS . '/dist/components/' . $shortcode_slug . '/js/app.js', array( 'jquery' ), BSMAPS_VERSION, true );
		}
	}
}
if ( ! function_exists( 'bsmaps_vc_number_field' ) ) {
	/**
	 * BSmaps VC function
	 *
	 * @param array  $settings Array of options.
	 * @param string $value    Value.
	 *
	 * @return string
	 */
	function bsmaps_vc_number_field( $settings, $value ) {
		$param_name = isset( $settings['param_name'] ) ? $settings['param_name'] : '';
		$type       = isset( $settings['type'] ) ? $settings['type'] : '';
		$class      = 'bsmaps-vc-number-container';
		$output     = '<div class="' . esc_attr( $class ) . '">';
		ob_start();
		?>
		<label>
			<input type="number" name="<?php echo esc_attr( $param_name ); ?>"
				class="wpb_vc_param_value <?php echo esc_attr( $param_name ) . ' ' . esc_attr( $type ); ?>_field bsmaps-vc-number"
				value="<?php echo esc_attr( $value ); ?>"/>
		</label>
		<?php
		$output .= ob_get_clean();
		$output .= '</div>';

		return $output;
	}
}
add_action( 'init', 'bsmaps_vc_fields' );
/**
 * BSmaps VC function.
 */
function bsmaps_vc_fields() {
	if ( function_exists( 'vc_add_shortcode_param' ) ) {
		vc_add_shortcode_param( 'bsmaps_number', 'bsmaps_vc_number_field' );
	}
}

/**
 * BSmaps Enqueue function.
 */
function bsmaps_enqueue_scripts() {
	$bsmaps_options = get_option( 'bsmaps_options' );
	if ( file_exists( BSMAPS_PATH . '/assets/dist/components/bsmaps-vc-gmap/js/elementor/app.js' ) ) {

		wp_register_script( 'bsmaps-vc-gmap', BSMAPS_ASSETS . '/dist/components/bsmaps-vc-gmap/js/elementor/app.js', array( 'jquery' ), BSMAPS_VERSION, true );
	}
	wp_localize_script(
		'bsmaps-vc-gmap',
		'bsmaps_gmap_obj',
		array( 'key' => esc_attr( $bsmaps_options['bsmaps_google_key'] ) )
	);
	wp_enqueue_script( 'bsmaps-vc-gmap' );
}

add_action( 'wp_enqueue_scripts', 'bsmaps_enqueue_scripts', 99 );

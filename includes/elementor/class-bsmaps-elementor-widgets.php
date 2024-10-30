<?php
/**
 * Elementor Widgets.
 *
 * @author  Balcomsoft
 * @package Bsmaps
 * @version 1.0.0
 * @since   1.0.0
 */

/**
 *  Bsmaps_Elementor_widgets.
 *
 * @return void
 */
final class Bsmaps_Elementor_Widgets {

	/**
	 * Instance
	 *
	 * @var Elementor_Test_Extension The single instance of the class.
	 */
	private static $instance = null;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Constructor
	 */
	public function __construct() {

		add_action( 'plugins_loaded', array( $this, 'bsmaps_elementor_init' ) );
		add_action(
			'elementor/elements/categories_registered',
			array( $this, 'bsmaps_elementor_widgets_category' )
		);
	}

	/**
	 * Load text domain
	 */
	public function i18n() {
		load_plugin_textdomain( 'bsmaps' );
	}

	/**
	 * On Plugins Loaded
	 *
	 * Checks if Elementor has loaded, and performs some compatibility checks.
	 * If All checks pass, inits the plugin.
	 *
	 * Fired by `plugins_loaded` action hook.
	 */
	public function bsmaps_elementor_init() {

		if ( $this->is_compatible() ) {
			add_action( 'elementor/init', array( $this, 'bsmaps_elementor_widgets_registered' ) );
		}
	}

	/**
	 * Compatibility Check
	 *
	 * Check if Elementor installed and activated.
	 */
	public function is_compatible() {
		if ( ! did_action( 'elementor/loaded' ) ) {
			return false;
		}

		return true;
	}

	/**
	 * Initialize Elementor
	 *
	 * Load the plugin only after Elementor (and other plugins) are loaded.
	 *
	 * Fired by `plugins_loaded` action hook.
	 */
	public function bsmaps_elementor_widgets_registered() {
		$this->i18n();
		add_action( 'elementor/widgets/register', array( $this, 'bsmaps_elementor_widgets' ) );
	}

	/**
	 * Init Widgets Category
	 *
	 * @param string $bsmaps_category category.
	 *
	 * @return string.
	 */
	public function bsmaps_elementor_widgets_category( $bsmaps_category ) {
		$category = esc_html__( 'Balcomsoft Widgets', 'bsmaps' );
		$bsmaps_category->add_category(
			'bsmaps-widgets',
			array(
				'title' => $category,
				'icon'  => 'eicon-font',
			)
		);

		return $bsmaps_category;
	}

	/**
	 * Init Widgets
	 *
	 * Include widgets files and register them
	 */
	public function bsmaps_elementor_widgets() {
		// Include Widget files.
		bsmaps_core_autoload( BSMAPS_ELEMENTOR_PATH . '/elementor/widgets/' );
	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have Elementor installed or activated.
	 *
	 * @since  1.0.0
	 *
	 * @access public
	 */
	public function bsmaps_elementor_admin_notice_missing_elementor_plugin() {
		$elementor_path = 'elementor/elementor.php';
		if ( bsmaps_elementor_status() ) {
			if ( ! current_user_can( 'activate_plugins' ) ) {
				return;
			}
			$activation_url
					= wp_nonce_url(
						'plugins.php?action=activate&amp;plugin='
						. $elementor_path
						. '&amp;plugin_status=all&amp;paged=1&amp;s',
						'activate-plugin_' . $elementor_path
					);
			$message        = '<p>'
					. esc_html__(
						'Elementor Website Builder is required to start using the  Elementor Widgets. Please activate the Elementor Website Builder.',
						'bsmaps'
					) . '</p>';
			$message       .= '<p>'
						. sprintf(
							'<a href="%s" class="button-primary">%s</a>',
							$activation_url,
							esc_html__( 'Activate Elementor Now', 'bsmaps' )
						)
						. '</p>';
		} else {
			if ( ! current_user_can( 'install_plugins' ) ) {
				return;
			}
			$install_url
					= wp_nonce_url(
						self_admin_url( 'update.php?action=install-plugin&plugin=elementor' ),
						'install-plugin_elementor'
					);
			$message     = '<p>'
					. esc_html__(
						'Elementor Website Builder is required to start using Elementor Widgets. Please install and activate the Elementor Website Builder.',
						'bsmaps'
					) . '</p>';
			$message    .= '<p>'
						. sprintf(
							'<a href="%s" class="button-primary">%s</a>',
							$install_url,
							esc_html__( 'Install Elementor Now', 'bsmaps' )
						)
						. '</p>';
		}
		echo '<div class="notice notice-error is-dismissible">'
			. wp_kses_post( $message ) . '</div>';
	}
}

Bsmaps_Elementor_Widgets::instance();

<?php
/**
 * Register all actions and filters for the plugin
 *
 * @link       https://www.balcomsoft.com/
 * @since      1.0.0
 *
 * @package    Bsmaps
 * @subpackage Bsmaps/includes
 */

/**
 * Register all actions and filters for the plugin.
 *
 * Maintain a list of all hooks that are registered throughout
 * the plugin, and register them with the WordPress API. Call the
 * run function to execute the list of actions and filters.
 *
 * @package    Bsmaps
 * @subpackage Bsmaps/includes
 * @author     Balcomsoft <info@balcomsoft.com>
 */
class Bsmaps_Loader {

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string $plugin_name The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string $version The current version of the plugin.
	 */
	protected $version;

	/**
	 * Initialize the collections used to maintain the actions and filters.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		if ( defined( 'BSMAPS_VERSION' ) ) {
			$this->version = BSMAPS_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'bsmaps';

		require_once BSMAPS_PATH . '/includes/helpers.php';
		require_once BSMAPS_PATH . '/includes/settings.php';
		require_once BSMAPS_PATH . '/includes/ad-banner.php';
		if ( ! class_exists( 'Bsmaps_Elementor_Widgets' ) ) {
			require_once BSMAPS_PATH . '/includes/elementor/class-bsmaps-elementor-widgets.php';
		}
		add_action( 'plugins_loaded', array( $this, 'plugins_loaded' ) );
	}

	/**
	 * PLugins loaded.
	 *
	 * @since    1.0.0
	 */
	public function plugins_loaded() {
		$this->load_plugin_textdomain();
		bsmaps_core_autoload( BSMAPS_PATH . '/includes/shortcodes/mapping' );
		if ( defined( 'WPB_VC_VERSION' ) ) {
			bsmaps_core_autoload( BSMAPS_PATH . '/includes/vc-components' );
		}
	}

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'bsmaps',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}
}

new Bsmaps_Loader();

<?php
/**
 * BS Maps - Google Map and Leaflet Map WordPress Plugin for Elementor and WPBackery
 *
 * @link              https://www.balcomsoft.com/
 * @since             1.1.0
 * @package           Bsmaps
 *
 * @wordpress-plugin
 * Plugin Name:       BS Maps - Google Map and Leaflet Map WordPress Plugin for Elementor and WPBackery
 * Plugin URI:        https://bsmaps.balcomsoft.com
 * Description:       BS Maps - Google Map and Leaflet Map WordPress Plugin for Elementor and WPBackery
 * Version:           1.2.0
 * Author:            Balcomsoft
 * Author URI:        https://www.balcomsoft.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       bsmaps
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
define( 'BSMAPS_VERSION', '1.2.0' );
define( 'BSMAPS_FILE', __FILE__ );
define( 'BSMAPS_PATH', dirname( BSMAPS_FILE ) );
define( 'BSMAPS_URL', plugin_dir_url( BSMAPS_FILE ) );
define( 'BSMAPS_ASSETS', BSMAPS_URL . 'assets' );
define( 'BSMAPS_ELEMENTOR_PATH', BSMAPS_PATH . '/includes' );
/**
 * The core plugin class that is used to load.
 */
require plugin_dir_path( __FILE__ ) . '/includes/class-bsmaps-loader.php';

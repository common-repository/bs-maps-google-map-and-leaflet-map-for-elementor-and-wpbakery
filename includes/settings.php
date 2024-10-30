<?php
/**
 * Settings page.
 *
 * @author  Balcomsoft
 * @package Bsmaps
 * @version 1.0.0
 * @since   1.0.0
 */

/**
 * Custom option and settings.
 */
function bsmaps_settings_init() {
	// Register a new setting for "bsmaps" page.
	register_setting( 'bsmaps', 'bsmaps_options' );

	// Register a new section in the "bsmaps" page.
	add_settings_section(
		'bsmaps_section_developers',
		esc_html__( 'Google Map Settings.', 'bsmaps' ),
		'bsmaps_section_developers_callback',
		'bsmaps'
	);

	// Register a new field in the "bsmaps_section_developers" section, inside the "bsmaps" page.
	add_settings_field(
		'bsmaps_field_pill',
		esc_html__( 'Google Map Api Key', 'bsmaps' ),
		'bsmaps_field_pill_cb',
		'bsmaps',
		'bsmaps_section_developers',
		array(
			'label_for'          => 'bsmaps_google_key',
			'class'              => 'bsmaps_row',
			'bsmaps_custom_data' => 'custom',
		)
	);
}

/**
 * Register our bsmaps_settings_init to the admin_init action hook.
 */
add_action( 'admin_init', 'bsmaps_settings_init' );


/**
 * Custom option and settings:
 *  - callback functions
 */


/**
 * Developers section callback function.
 *
 * @param array $args  The settings array, defining title, id, callback.
 */
function bsmaps_section_developers_callback( $args ) {
	?>
	<p id="<?php echo esc_attr( $args['id'] ); ?>"><?php echo esc_html__( 'Google Api Key.', 'bsmaps' ); ?></p>
	<?php
}

/**
 * Pill field callbakc function.
 *
 * WordPress has magic interaction with the following keys: label_for, class.
 * - the "label_for" key value is used for the "for" attribute of the <label>.
 * - the "class" key value is used for the "class" attribute of the <tr> containing the field.
 * Note: you can add custom key value pairs to be used inside your callbacks.
 *
 * @param array $args Args.
 */
function bsmaps_field_pill_cb( $args ) {
	// Get the value of the setting we've registered with register_setting().
	$options = get_option( 'bsmaps_options' );
	?>
	<input type="text"  style="width: 400px;max-width: 100%;"
			id="<?php echo esc_attr( $args['label_for'] ); ?>"
			data-custom="<?php echo esc_attr( $args['bsmaps_custom_data'] ); ?>"
			name="bsmaps_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
	value="<?php echo esc_attr( $options[ $args['label_for'] ] ); ?>"
	/>
	<p class="bsmaps_description">
		<?php echo esc_html__( 'Please Enter Google Map Api Key.', 'bsmaps' ); ?>
	</p>

	<?php
}

/**
 * Add the top level menu page.
 */
function bsmaps_options_page() {
	add_menu_page(
		'BS Maps',
		'BS Maps Options',
		'manage_options',
		'bsmaps',
		'bsmaps_options_page_html'
	);
}


/**
 * Register our bsmaps_options_page to the admin_menu action hook.
 */
add_action( 'admin_menu', 'bsmaps_options_page' );


/**
 * Top level menu callback function
 */
function bsmaps_options_page_html() {
	// check user capabilities.
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	?>
	<div class="wrap">
		<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
		<form action="options.php" method="post">
			<?php
			// output security fields for the registered setting "bsmaps".
			settings_fields( 'bsmaps' );
			// output setting sections and their fields
			// (sections are registered for "bsmaps", each field is registered to a specific section).
			do_settings_sections( 'bsmaps' );
			// output save settings button.
			submit_button( 'Save Settings' );
			?>
		</form>
	</div>
	<?php
}

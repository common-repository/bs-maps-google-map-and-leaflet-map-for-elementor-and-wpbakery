<?php
/**
 * Gmap Shortcode output
 *
 * @author  Balcomsoft
 * @package BsMaps
 * @version 1.0.0
 * @since   1.0.0
 */

$result = shortcode_atts(
	array(
		'unique_class'  => '',
		'element_class' => '',
		'element_id'    => '',
		'markers'       => array(),
		'map_center'    => '47, -101',
		'activemode'    => 'defaultMode',
		'zoom'          => 3,
	),
	$atts
);
extract( $result ); // phpcs:ignore WordPress.PHP.DontExtract.extract_extract
$classes    = array(
	$element_class,
	$unique_class,
);
$markers    = ( ! empty( $markers ) ) ? json_decode( rawurldecode( $markers ) ) : array();
$map_center = explode( ',', $map_center );
$position   = array();
foreach ( $markers as $key => $marker ) {
	foreach ( $marker as $k => $mark ) {
		$position[ $key ]['id'] = $key + 1;
		if ( 'name' === $k ) {
			$position[ $key ]['name'] = $mark;
		}
		if ( 'description' === $k ) {
			$position[ $key ]['description'] = $mark;
		}
		if ( in_array( $k, array( 'lng', 'lat' ), true ) ) {
			$position[ $key ]['position'][ $k ] = floatval( $mark );
		}
		$position[ $key ]['isActive'] = false;
	}
}
$position = wp_json_encode( $position );
$zoom     = json_decode( rawurldecode( $zoom ) );

$zoom = ( ! empty( $zoom->size ) ) ? (int) $zoom->size : ( ( empty( $zoom ) ) ? 1 : $zoom );


$bsmaps_options = get_option( 'bsmaps_options' );
wp_localize_script(
	'bsmaps-vc-gmap',
	'bsmaps_gmap_obj',
	array( 'key' => esc_attr( $bsmaps_options['bsmaps_google_key'] ) )
);
wp_enqueue_script( 'bsmaps-vc-gmap' );
wp_enqueue_style( 'bsmaps-vc-gmap' );
$center_lat = ( ! empty( $map_center[0] ) ) ? $map_center[0] : 0;
$center_lng = ( ! empty( $map_center[1] ) ) ? $map_center[1] : 0;
?>

<div <?php echo ( ! empty( $element_id ) ) ? 'id="' . esc_attr( $element_id ) . '"' : ''; ?>
		class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
	<div class="section">
		<noscript>You need to enable JavaScript to run this app.</noscript>
		<div
				data-activemode="<?php echo esc_attr( $activemode ); ?>"
				class="bsmaps-gmap"
				data-basic='<?php echo esc_attr( $position ); ?>'
				data-zoom='<?php echo esc_attr( $zoom ); ?>'
				data-center='{"lat": <?php echo esc_attr( $center_lat ); ?>,"lng": <?php echo esc_attr( $center_lng ); ?>}'
		></div>
	</div>
</div>

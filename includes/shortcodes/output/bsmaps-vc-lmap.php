<?php
/**
 * Lmap Shortcode output
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

$map_center = explode( ',', $map_center );
$position   = array();


$markers = ( ! empty( $markers ) ) ? json_decode( rawurldecode( $markers ) ) : array();
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
			$position[ $key ]['position'][ $k ] = $mark;
		}
		$position[ $key ]['isActive'] = false;
	}
}
$position = wp_json_encode( $position );
$zoom     = json_decode( rawurldecode( $zoom ) );

$zoom = ( ! empty( $zoom->size ) ) ? (int) $zoom->size : ( ( empty( $zoom ) ) ? 1 : $zoom );

$classes = array(
	$element_class,
	$unique_class,
);
wp_enqueue_script( 'bsmaps-vc-lmap' );
wp_localize_script(
	'bsmaps-vc-lmap',
	'bsmaps_lmap_obj',
	array()
);
wp_enqueue_style( 'bsmaps-vc-lmap' );
?>
<div <?php echo ( ! empty( $element_id ) ) ? 'id="' . esc_attr( $element_id ) . '"' : ''; ?>
		class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
	<div class="section">
		<noscript>You need to enable JavaScript to run this app.</noscript>
		<div
				data-activemode="<?php echo esc_attr( $activemode ); ?>"
				class="bsmaps-lmap"
				data-basic='<?php echo esc_attr( $position ); ?>'
				data-zoom='<?php echo esc_attr( $zoom ); ?>'
				data-center='{"lat": <?php echo esc_attr( $map_center[0] ); ?>,"lng": <?php echo esc_attr( $map_center[1] ); ?>}'
				data-modes='{
	"defaultMode": "https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png",
	"silverMode": "https://tiles.stadiamaps.com/tiles/alidade_smooth/{z}/{x}/{y}{r}.png",
	"darkMode": "https://tiles.stadiamaps.com/tiles/alidade_smooth_dark/{z}/{x}/{y}{r}.png",
	"retroMode": "https://tiles.stadiamaps.com/tiles/osm_bright/{z}/{x}/{y}{r}.png"
}'
		></div>
	</div>
</div>

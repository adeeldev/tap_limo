<?php
/**
 * Plugin Name: OffTheShelf Map
 * Plugin URI: http://www.shapingrain.com
 * Description: Displays a map.
 * Version: 1.0
 * License: GPLv2
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

if ( ! class_exists( 'OffTheShelf_Map_Widget' ) ) {
	class OffTheShelf_Map_Widget extends SR_Widget {

		function __construct() {

			// Configure widget array
			$args = array(
				// Widget Backend label
				'label'       => esc_html__( 'OtS Map', 'offtheshelf' ),
				// Widget Backend Description								
				'description' => esc_html__( 'Displays a map.', 'offtheshelf' ),
				'options' => array ( 'classname' => 'ots-map' )
			);

			// Configure the widget fields

			// fields array
			$args['fields'] = array(

				// Title field
				array(
					'name'     => esc_html__( 'Title', 'offtheshelf' ),
					'desc'     => esc_html__( 'Enter the widget title.', 'offtheshelf' ),
					'id'       => 'title',
					'type'     => 'text',
					// class, rows, cols
					'class'    => 'widefat',
					'std'      => esc_html__( 'Map', 'offtheshelf' ),
					'validate' => 'alpha_dash',
					'filter'   => ''
				),
				array(
					'name'        => esc_html__( 'Address or Coordinates', 'offtheshelf' ),
					'desc'        => esc_html__( 'Enter an address or geographical coordinates here.', 'offtheshelf' ),
					'id'          => 'address',
					'type'        => 'textarea',
					'rows'        => '5',
					// class, rows, cols
					'class'       => 'widefat',
					'std'         => '',
					'placeholder' => esc_html__( '1600 Amphitheatre Pkwy, Mountain View, CA 94043', 'offtheshelf' ),
					'validate'    => 'alpha_dash',
					'filter'      => 'esc_textarea'
				),
				array(
					'name'     => esc_html__( 'Map Type', 'offtheshelf' ),
					'desc'     => esc_html__( 'Select which map type to use for this widget.', 'offtheshelf' ),
					'id'       => 'type',
					'type'     => 'select',
					'fields'   => array(
						array(
							'name'  => esc_html__( 'Hybrid', 'offtheshelf' ),
							'value' => 'hybrid'
						),
						array(
							'name'  => esc_html__( 'Roadmap', 'offtheshelf' ),
							'value' => 'roadmap'
						),
						array(
							'name'  => esc_html__( 'Satellite', 'offtheshelf' ),
							'value' => 'satellite'
						),
						array(
							'name'  => esc_html__( 'Terrain', 'offtheshelf' ),
							'value' => 'terrain'
						)
					),
					'std'      => 'hybrid',
					'validate' => 'alpha_dash',
					'filter'   => ''
				),
				array(
					'name'     => esc_html__( 'Zoom Level', 'offtheshelf' ),
					'desc'     => esc_html__( 'Enter a value.', 'offtheshelf' ),
					'id'       => 'zoom',
					'type'     => 'number',
					// class, rows, cols
					'class'    => 'widefat',
					'std'      => 10,
					'validate' => 'numeric',
					'filter'   => ''
				),
				array(
					'name'     => esc_html__( 'Height', 'offtheshelf' ),
					'desc'     => esc_html__( 'Define the default height of this map in pixels.', 'offtheshelf' ),
					'id'       => 'height',
					'type'     => 'text',
					'class'    => 'widefat',
					'std'      => '300',
					'validate' => 'numeric',
					'filter'   => ''
				),
			); // fields array

			$this->create_widget( $args );
		}


		// Output function
		function widget( $args, $instance ) {

			$out = $args['before_widget'];

			if ( offtheshelf_array_option( 'title', $instance, false ) && ! offtheshelf_is_pagebuilder() ) {
				$out .= $args['before_title'];
				$out .= esc_html( $instance['title'] );
				$out .= $args['after_title'];
			}

			$id = offtheshelf_get_widget_uid( 'map' );

			$out .= '<div id="' . $id . '-container" class="map-container"><div id="' . $id . '" class="map-widget-canvas" data-zoom="' . offtheshelf_array_option( 'zoom', $instance, 10 ) . '" data-type="' . offtheshelf_array_option( 'type', $instance, 'hybrid' ) . '" data-location="' . esc_attr( offtheshelf_array_option( 'address', $instance, '' ) ) . '"></div></div>';

			$out .= $args['after_widget'];

			echo $out;

			$style = '#' . $id . '-container .map-widget-canvas { height:' . offtheshelf_array_option( 'height', $instance, '300' ) . 'px; }';
			offtheshelf_add_custom_style( 'map', $style );


			wp_enqueue_script( 'googlemaps', 'https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false', array(), '3.0', true );
			wp_enqueue_script( 'offtheshelf-initmap', get_template_directory_uri() . '/js/initmap.min.js', array(
				'jquery',
				'googlemaps'
			), OFFTHESHELF_THEME_VERSION );

		}

	} // class

	// Register widget
	if ( ! function_exists( 'register_offtheshelf_map_widget' ) ) {
		function register_offtheshelf_map_widget() {
			register_widget( 'OffTheShelf_Map_Widget' );
		}

		add_action( 'widgets_init', 'register_offtheshelf_map_widget', 1 );
	}
}
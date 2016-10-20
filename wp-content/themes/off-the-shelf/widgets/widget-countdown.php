<?php
/**
 * Plugin Name: OffTheShelf Countdown
 * Plugin URI: http://www.shapingrain.com
 * Description: Displays a countdown.
 * Version: 1.0
 * License: GPLv2
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

if ( ! class_exists( 'OffTheShelf_Countdown_Widget' ) ) {
	class OffTheShelf_Countdown_Widget extends SR_Widget {

		function __construct() {

			// Configure widget array
			$args = array(
				// Widget Backend label
				'label'       => esc_html__( 'OtS Countdown', 'offtheshelf' ),
				// Widget Backend Description
				'description' => esc_html__( 'Displays a countdown.', 'offtheshelf' ),
				'options' => array ( 'classname' => 'ots-countdown' )
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
					'std'      => esc_html__( 'Countdown', 'offtheshelf' ),
					'validate' => 'alpha_dash',
					'filter'   => ''
				),
				array(
					'name'     => esc_html__( 'Date', 'offtheshelf' ),
					'desc'     => esc_html__( 'Define the date to count down to.', 'offtheshelf' ),
					'id'       => 'date',
					'type'     => 'date',
					'class'    => 'at-datepicker',
					'std'      => '',
					'validate' => 'alpha_dash',
					'filter'   => ''
				),
				array(
					'name'     => esc_html__( 'Style', 'offtheshelf' ),
					'desc'     => esc_html__( 'Select what style you would like to apply to this countdown.', 'offtheshelf' ),
					'id'       => 'style',
					'type'     => 'select',
					'fields'   => array(
						array(
							'name'  => esc_html__( 'White', 'offtheshelf' ),
							'value' => 'white'
						),
						array(
							'name'  => esc_html__( 'Black', 'offtheshelf' ),
							'value' => 'black'
						),
						array(
							'name'  => esc_html__( 'Transparent', 'offtheshelf' ),
							'value' => 'transparent'
						)
					),
					'std'      => 'transparent',
					'validate' => 'alpha_dash',
					'filter'   => ''
				),
				array(
					'name'     => esc_html__( 'Size', 'offtheshelf' ),
					'desc'     => esc_html__( 'Select the relative size of the countdown.', 'offtheshelf' ),
					'id'       => 'size',
					'type'     => 'select',
					'fields'   => array(
						array(
							'name'  => esc_html__( 'Small', 'offtheshelf' ),
							'value' => 'small'
						),
						array(
							'name'  => esc_html__( 'Medium', 'offtheshelf' ),
							'value' => 'medium'
						),
						array(
							'name'  => esc_html__( 'Large', 'offtheshelf' ),
							'value' => 'large'
						)
					),
					'std'      => 'medium',
					'validate' => 'alpha_dash',
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

			$style      = offtheshelf_array_option( 'style', $instance, 'transparent' );
			$size       = offtheshelf_array_option( 'size', $instance, 'medium' );
			$date_end   = offtheshelf_array_option( 'date', $instance, '' );
			$date_parts = explode( "/", $date_end );

			if ( substr_count( $date_end, "/" ) == 2 ) {
				$year  = $date_parts[0];
				$month = $date_parts[1];
				$day   = $date_parts[2];
				$out .= '<div class="countdown wd style-' . esc_attr( $style ) . ' size-' . esc_attr( $size ) . '" data-days="' . esc_attr__( 'Days', 'offtheshelf' ) . '" data-hours="' . esc_attr__( 'Hours', 'offtheshelf' ) . '" data-minutes="' . esc_attr__( 'Minutes', 'offtheshelf' ) . '" data-seconds="' . esc_attr__( 'Seconds', 'offtheshelf' ) . '" data-end="' . esc_attr( $year ) . ',' . esc_attr( $month ) . ',' . esc_attr( $day ) . '"></div>';
			}

			$out .= $args['after_widget'];
			echo $out;
			wp_enqueue_script( 'offtheshelf-countdown', get_template_directory_uri() . '/js/countdown.min.js', array( 'jquery' ), OFFTHESHELF_THEME_VERSION, true );

		}

	} // class

	// Register widget
	if ( ! function_exists( 'register_offtheshelf_countdown_widget' ) ) {
		function register_offtheshelf_countdown_widget() {
			register_widget( 'OffTheShelf_Countdown_Widget' );
		}

		add_action( 'widgets_init', 'register_offtheshelf_countdown_widget', 1 );
	}
}
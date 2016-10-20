<?php
/**
 * Plugin Name: OffTheShelf Event
 * Plugin URI: http://www.shapingrain.com
 * Description: Displays an event block.
 * Version: 1.0
 * License: GPLv2
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

if ( ! class_exists( 'OffTheShelf_Event_Widget' ) ) {
	class OffTheShelf_Event_Widget extends SR_Widget {

		function __construct() {

			// Configure widget array
			$args = array(
				// Widget Backend label
				'label'       => esc_html__( 'OtS Event Block', 'offtheshelf' ),
				// Widget Backend Description
				'description' => esc_html__( 'Displays a block to advertise an upcoming event, including title, description, a link, date and time.', 'offtheshelf' ),
				'options' => array ( 'classname' => 'ots-event-block' )
			);


			// Configure the widget fields
			// fields array
			$args['fields'] = array(

				// Title field
				array(
					'name'     => esc_html__( 'Title', 'offtheshelf' ),
					'desc'     => esc_html__( 'Enter the event title here.', 'offtheshelf' ),
					'id'       => 'title',
					'type'     => 'text',
					'rows'     => '5',
					'class'    => 'widefat',
					'std'      => '',
					'validate' => 'alpha_dash',
					'filter'   => ''
				),
				array(
					'name'     => esc_html__( 'Description', 'offtheshelf' ),
					'desc'     => esc_html__( 'Enter a short description here.', 'offtheshelf' ),
					'id'       => 'description',
					'type'     => 'textarea',
					'rows'     => '5',
					// class, rows, cols
					'class'    => 'widefat',
					'std'      => '',
					'validate' => 'alpha_dash',
					'filter'   => ''
				),
				array(
					'name'  => esc_html__( 'Image', 'offtheshelf' ),
					'desc'  => esc_html__( 'Upload an image to be displayed .', 'offtheshelf' ),
					'class' => 'img',
					'id'    => 'image',
					'type'  => 'image',
					'std'   => '',
					//'validate' => '',
					//'filter' => ''
				),
				array(
					'name'     => esc_html__( 'Start Date', 'offtheshelf' ),
					'desc'     => esc_html__( 'Date, in any format.', 'offtheshelf' ),
					'id'       => 'start_date',
					'type'     => 'text',
					'class'    => 'short',
					'std'      => '',
					'validate' => 'alpha_dash',
					'filter'   => ''
				),
				array(
					'name'     => esc_html__( 'Start Time', 'offtheshelf' ),
					'desc'     => esc_html__( 'Time, in any format.', 'offtheshelf' ),
					'id'       => 'start_time',
					'type'     => 'text',
					'class'    => 'short',
					'std'      => '',
					'validate' => 'alpha_dash',
					'filter'   => ''
				),
				array(
					'name'     => esc_html__( 'End Date', 'offtheshelf' ),
					'desc'     => esc_html__( 'Date, in any format.', 'offtheshelf' ),
					'id'       => 'end_date',
					'type'     => 'text',
					'class'    => 'short',
					'std'      => '',
					'validate' => 'alpha_dash',
					'filter'   => ''
				),
				array(
					'name'     => esc_html__( 'End Time', 'offtheshelf' ),
					'desc'     => esc_html__( 'Time, in any format.', 'offtheshelf' ),
					'id'       => 'end_time',
					'type'     => 'text',
					'class'    => 'short',
					'std'      => '',
					'validate' => 'alpha_dash',
					'filter'   => ''
				),
				array(
					'name'     => esc_html__( 'Speaker', 'offtheshelf' ),
					'desc'     => esc_html__( 'Enter the name of a speaker here.', 'offtheshelf' ),
					'id'       => 'speaker',
					'type'     => 'text',
					'class'    => 'widefat',
					'std'      => '',
					'validate' => 'alpha_dash',
					'filter'   => ''
				),
				array(
					'name'  => esc_html__( 'Speaker Picture', 'offtheshelf' ),
					'desc'  => esc_html__( 'Upload a speaker photo.', 'offtheshelf' ),
					'class' => 'img',
					'id'    => 'speaker_picture',
					'type'  => 'image',
					'std'   => '',
				),
				array(
					'name'     => esc_html__( 'Link URL', 'offtheshelf' ),
					'desc'     => esc_html__( 'Define a link to point this button to.', 'offtheshelf' ),
					'id'       => 'link',
					'type'     => 'text',
					'class'    => 'widefat',
					'std'      => '',
					'validate' => 'alpha_dash',
					'filter'   => ''
				),
				array(
					'name'     => esc_html__( 'Link Text', 'offtheshelf' ),
					'desc'     => esc_html__( 'Define a caption for this link.', 'offtheshelf' ),
					'id'       => 'link_text',
					'type'     => 'text',
					'class'    => 'widefat',
					'std'      => 'View Details',
					'validate' => 'alpha_dash',
					'filter'   => ''
				),

			); // fields array

			$this->create_widget( $args );
		}


		// Output function
		function widget( $args, $instance ) {

			$out = $args['before_widget'];

			$image         = offtheshelf_array_option( 'image', $instance, false );
			$title         = offtheshelf_array_option( 'title', $instance, false );
			$description   = offtheshelf_array_option( 'description', $instance, false );

			$start_date    = offtheshelf_array_option( 'start_date', $instance, false );
			$start_time    = offtheshelf_array_option( 'start_time', $instance, false );

			$end_date      = offtheshelf_array_option( 'end_date', $instance, false );
			$end_time      = offtheshelf_array_option( 'end_time', $instance, false );

			$speaker       = offtheshelf_array_option( 'speaker', $instance, false );
			$speaker_image = offtheshelf_array_option( 'speaker_picture', $instance, false );

			$link          = offtheshelf_array_option( 'link', $instance, false );
			$link_text     = offtheshelf_array_option( 'link_text', $instance, false );

			$out .= '<div class="ots-event">';


			if ( $image ) {
				$image = intval( $image );
				if ( $image != 0 ) {
					$image_array = wp_get_attachment_image_src( $image, 'event-image' );
					if ( $image_array ) {
						$out .= '<div class="event-image"><img src="' . esc_url( $image_array[0] ) . '" class="event-image" alt="' . esc_attr( offtheshelf_array_option( 'title', $instance, '' ) ) . '"></div>';
					}
				}
			}

			if ( $speaker_image ) {
				$image = intval( $speaker_image );
				if ( $image != 0 ) {
					$image_array = wp_get_attachment_image_src( $image, 'event-speaker-image' );
					if ( $image_array ) {
						$out .= '<img src="' . esc_url( $image_array[0] ) . '" class="event-speaker-image" alt="' . esc_attr( $speaker ) . '">';
					}
				}
			}

			$out .= '<ul>';

			if ( !empty ( $speaker ) ) {
				$out .= '<li class="event-speaker">' . esc_html( $speaker ) . '</li>';
			}


			if ( !empty ( $start_date ) ) {

				$out .= '<li class="event-date">';
				$out .= esc_html( $start_date );
				if ( !empty ( $start_time ) ) {
					$out .= ' ' . esc_html( $start_time );
				}

				if (  !empty ( $start_date ) && !empty ( $start_time ) ) {
					$out .= ' &mdash; ';
				}

				if ( !empty ( $end_date ) ) {
					if ( $start_date != $end_date ) {
						$out .= ' ' . esc_html( $end_date );
					}
				}

				if ( !empty ( $end_time ) ) {
					$out .= ' ' . esc_html( $end_time );
				}

				$out .= '</li>';
			}

			$out .= '</ul>';

			if ( !empty ( $title ) ) {
				$out .= '<h3>' . esc_html( $title ) . '</h3>';
			}

			if ( !empty ( $description ) ) {
				$out .= '<p>' . esc_html( $description ) . '</p>';
			}

			if ( !empty ( $link ) ) {
				$out .= '<a href="' . esc_url( $link ) . '">' . esc_html ( $link_text ) . '</a>';
			}

			$out .= '</div>';

			$out .= $args['after_widget'];

			echo $out;
		}

	} // class

	// Register widget
	if ( ! function_exists( 'register_offtheshelf_event_widget' ) ) {
		function register_offtheshelf_event_widget() {
			register_widget( 'OffTheShelf_Event_Widget' );
		}

		add_action( 'widgets_init', 'register_offtheshelf_event_widget', 1 );
	}
}
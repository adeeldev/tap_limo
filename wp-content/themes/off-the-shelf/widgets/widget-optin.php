<?php
/**
 * Plugin Name: OffTheShelf Opt-In Form
 * Plugin URI: http://www.shapingrain.com
 * Description: Displays an opt-in form.
 * Version: 1.0
 * License: GPLv2
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

if ( ! class_exists( 'OffTheShelf_Optin_Widget' ) ) {
	class OffTheShelf_Optin_Widget extends SR_Widget {

		function __construct() {

			// Configure widget array
			$args = array(
				// Widget Backend label
				'label'       => esc_html__( 'OtS Opt-In Form', 'offtheshelf' ),
				// Widget Backend Description
				'description' => esc_html__( 'Displays an opt-in form.', 'offtheshelf' ),
				'options' => array ( 'classname' => 'ots-opt-in-form' )
			);


			// Get available forms from options
			$forms      = array();
			$forms_temp = offtheshelf_option( 'forms' );
			if ( is_array( $forms_temp ) && count( $forms_temp ) > 0 ) {
				foreach ( $forms_temp as $form ) {
					if ( $form['form_name'] == '' ) {
						$name = $form['form_uid'];
					} else {
						$name = $form['form_name'];
					}
					$forms[] = array(
						'name'  => $name,
						'value' => $form['form_uid']
					);
				}
			}

			// Configure the widget fields

			// fields array
			$args['fields'] = array(
				array(
					'type' => 'paragraph',
					'id'   => 'info_optin',
					'desc' => esc_html__( 'Forms are retrieved from Theme Options &#8594; Forms.', 'offtheshelf' ),
				),
				array(
					'name'     => esc_html__( 'Title', 'offtheshelf' ),
					'desc'     => esc_html__( 'Enter the headline title.', 'offtheshelf' ),
					'id'       => 'title',
					'type'     => 'text',
					// class, rows, cols
					'class'    => 'widefat',
					'std'      => esc_html__( 'Sign up now for updates', 'offtheshelf' ),
					'validate' => 'alpha_dash',
					'filter'   => ''
				),
				array(
					'name'     => esc_html__( 'Form', 'offtheshelf' ),
					'desc'     => esc_html__( 'Select an opt-in form to use for this widget.', 'offtheshelf' ),
					'id'       => 'form',
					'type'     => 'select',
					'fields'   => $forms,
					'std'      => '',
					'validate' => 'alpha_dash',
					'filter'   => ''
				),
				array(
					'name'     => esc_html__( 'Display as', 'offtheshelf' ),
					'desc'     => esc_html__( 'Select whether you would like form fields to be displayed in rows (stacked) or columns (next to each other). If you opt to display form fields in columns, make sure that all fields fit into the widget container.', 'offtheshelf' ),
					'id'       => 'display_as',
					'type'     => 'select',
					'fields'   => array(
						array(
							'name'  => esc_html__( 'Rows', 'offtheshelf' ),
							'value' => 'rows'
						),
						array(
							'name'  => esc_html__( 'Columns', 'offtheshelf' ),
							'value' => 'columns'
						)
					),
					'std'      => 'rows',
					'validate' => 'alpha_dash',
					'filter'   => ''
				),
				array(
					'name'     => esc_html__( 'Field Alignment', 'offtheshelf' ),
					'desc'     => esc_html__( 'Select how to align the form fields within the widget container.', 'offtheshelf' ),
					'id'       => 'field_alignment',
					'type'     => 'select',
					'fields'   => array(
						array(
							'name'  => esc_html__( 'Left', 'offtheshelf' ),
							'value' => 'left'
						),
						array(
							'name'  => esc_html__( 'Center', 'offtheshelf' ),
							'value' => 'center'
						),
						array(
							'name'  => esc_html__( 'Right', 'offtheshelf' ),
							'value' => 'right'
						)
					),
					'std'      => 'left',
					'validate' => 'alpha_dash',
					'filter'   => ''
				),
				array(
					'name'     => esc_html__( 'Rounded Corners', 'offtheshelf' ),
					'desc'     => esc_html__( 'Define border radius for form fields in px.', 'offtheshelf' ),
					'id'       => 'border_radius',
					'type'     => 'number',
					'class'    => 'widefat',
					'std'      => 0,
					'validate' => 'numeric',
					'filter'   => ''
				),
				array(
					'name'     => esc_html__( 'Hint', 'offtheshelf' ),
					'desc'     => esc_html__( 'Enter a hint to be displayed below the opt-in form.', 'offtheshelf' ),
					'id'       => 'hint',
					'type'     => 'textarea',
					'rows'     => '3',
					// class, rows, cols
					'class'    => 'widefat',
					'std'      => '',
					'validate' => 'alpha_dash',
					'filter'   => 'esc_textarea'
				),
			); // fields array

			$this->create_widget( $args );
		}

		// Output function
		function widget( $args, $instance ) {
			$out = $args['before_widget'];

			$display_as = offtheshelf_array_option( 'display_as', $instance, "rows" );
			$alignment  = offtheshelf_array_option( 'field_alignment', $instance, "left" );

			$wid    = offtheshelf_get_widget_uid( 'optin' );
			$radius = offtheshelf_array_option( 'border_radius', $instance, 0 );
			if ( $radius > 0 ) {
				$style = '.' . $wid . ' input, .' . $wid . ' textarea  { border-radius:' . $radius . 'px; }';
				offtheshelf_add_custom_style( 'optin', $style );
			}

			$out .= '<div class="form-optin ' . $wid . ' optin-' . $display_as . ' optin-' . $alignment . '">';

			if ( offtheshelf_array_option( 'title', $instance, false ) ) {
				$out .= $args['before_title'];
				$out .= esc_html( $instance['title'] );
				$out .= $args['after_title'];
			}

			$forms_temp = offtheshelf_option( 'forms' );
			$code       = '';
			if ( is_array( $forms_temp ) && count( $forms_temp ) > 0 ) { // see if we can find a form that matches the selection
				foreach ( $forms_temp as $form ) {
					if ( $form['form_uid'] == offtheshelf_array_option( 'form', $instance ) ) { // form found
						$code = $form['form_code'];
						break;
					}
				}

				if ( ! empty( $code ) ) { // if there is a form code to be rendered, execute shortcodes within form code
					$out .= offtheshelf_esc_html( do_shortcode( stripslashes( $code ) ) );
				}
			}

			$hint = offtheshelf_array_option( 'hint', $instance, '' );
			if ( ! empty( $hint ) ) {
				$out .= '<p class="hint">' . esc_html( $hint ) . '</p>';
			}


			$out .= '</div>';

			$out .= $args['after_widget'];
			echo $out;
		}

	} // class

	// Register widget
	if ( ! function_exists( 'register_offtheshelf_optin_widget' ) ) {
		function register_offtheshelf_optin_widget() {
			register_widget( 'OffTheShelf_Optin_Widget' );
		}

		add_action( 'widgets_init', 'register_offtheshelf_optin_widget', 1 );
	}
}
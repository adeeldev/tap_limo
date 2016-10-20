<?php
/**
 * Plugin Name: OffTheShelf Call To Action Box
 * Plugin URI: http://www.shapingrain.com
 * Description: Displays a colored box.
 * Version: 1.0
 * License: GPLv2
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

if ( ! class_exists( 'OffTheShelf_CTA_Box_Widget' ) ) {
	class OffTheShelf_CTA_Box_Widget extends SR_Widget {

		function __construct() {
			// Get available button styles from options
			$styles      = array();
			$styles_temp = offtheshelf_option( 'global_button_styles' );
			$std_style   = '';
			if ( is_array( $styles_temp ) && count( $styles_temp ) > 0 ) {
				foreach ( $styles_temp as $style ) {
					if ( $style['name'] == '' ) {
						$name = $style['uid'];
					} else {
						$name = $style['name'];
					}
					$styles[] = array(
						'name'  => $name,
						'value' => $style['uid']
					);
				}
				$std_style = $styles[0]['value'];
			}

			// Configure widget array
			$args = array(
				// Widget Backend label
				'label'       => esc_html__( 'OtS Call To Action Box', 'offtheshelf' ),
				// Widget Backend Description
				'description' => esc_html__( 'Displays a call to action box with text and a button.', 'offtheshelf' ),
				'options' => array ( 'classname' => 'ots-call-to-action-box' )
			);

			// Configure the widget fields

			// fields array
			$args['fields'] = array(
				array(
					'name'     => esc_html__( 'Text', 'offtheshelf' ),
					'desc'     => esc_html__( 'Enter text or custom mark-up here.', 'offtheshelf' ),
					'id'       => 'text',
					'type'     => 'textarea',
					'rows'     => '5',
					'class'    => 'widefat',
					'std'      => '',
					'validate' => 'alpha_dash',
					'filter'   => ''
				),
				array(
					'name'     => esc_html__( 'Font Size', 'offtheshelf' ),
					'desc'     => esc_html__( 'Enter font size in pixels.', 'offtheshelf' ),
					'id'       => 'size',
					'type'     => 'number',
					'rows'     => '5',
					'class'    => '',
					'std'      => '13',
					'validate' => 'numeric',
					'filter'   => ''
				),
				array(
					'name'     => esc_html__( 'Call to Action Style', 'offtheshelf' ),
					'desc'     => esc_html__( 'You can create and edit button styles via the theme\'s options panel.', 'offtheshelf' ),
					'id'       => 'style',
					'type'     => 'select',
					'fields'   => $styles,
					'std'      => $std_style,
					'validate' => 'alpha_dash',
					'filter'   => ''
				),
				array(
					'name'     => esc_html__( 'Call to Action Position', 'offtheshelf' ),
					'id'       => 'position',
					'type'     => 'select',
					'fields'   => array(
						array(
							'name'  => esc_html__( 'Left of text', 'offtheshelf' ),
							'value' => 'left'
						),
						array(
							'name'  => esc_html__( 'Right of text', 'offtheshelf' ),
							'value' => 'right'
						),
						array(
							'name'  => esc_html__( 'Above text', 'offtheshelf' ),
							'value' => 'above'
						),
						array(
							'name'  => esc_html__( 'Below text', 'offtheshelf' ),
							'value' => 'below'
						),
					),
					'std'      => 'left',
					'validate' => 'alpha_dash',
					'filter'   => ''
				),
				array(
					'name'     => esc_html__( 'Call to Action', 'offtheshelf' ),
					'desc'     => esc_html__( 'Enter the button caption or call to action here.', 'offtheshelf' ),
					'id'       => 'action',
					'type'     => 'text',
					// class, rows, cols
					'class'    => 'widefat',
					'std'      => '',
					'validate' => 'alpha_dash',
					'filter'   => ''
				),
				array(
					'name'     => esc_html__( 'Call to Action Link URL', 'offtheshelf' ),
					'id'       => 'link',
					'type'     => 'text',
					// class, rows, cols
					'class'    => 'widefat',
					'std'      => '',
					'validate' => 'alpha_dash',
					'filter'   => ''
				),
				array(
					'name'     => esc_html__( 'Open Link in New Window', 'offtheshelf' ),
					//'desc' => esc_html__( 'Select, whether this link should be opened in a new window.', 'offtheshelf' ),
					'id'       => 'link_target',
					'type'     => 'checkbox',
					'class'    => 'widefat',
					'std'      => 0,
					'validate' => 'alpha_dash',
					'filter'   => ''
				),
				array(
					'name'     => esc_html__( 'Add "nofollow" attribute to link.', 'offtheshelf' ),
					'desc'     => esc_html__( 'Instruct search engines not to follow this link.', 'offtheshelf' ),
					'id'       => 'nofollow',
					'type'     => 'checkbox',
					'class'    => 'widefat',
					'std'      => 0,
					'validate' => 'alpha_dash',
					'filter'   => ''
				),
				array(
					'name'      => esc_html__( 'Open Modal Window', 'offtheshelf' ),
					'desc'      => esc_html__( 'Optional modal window to open instead of using a link. The feature pack plug-in is required.', 'offtheshelf' ),
					'id'        => 'modal',
					'group'     => 'button',
					'type'      => 'posts',
					'post_type' => 'modal',
					'std'       => 0,
					'validate'  => 'alpha_dash',
					'filter'    => ''
				),
			); // fields array

			$this->create_widget( $args );
		}

		// Output function
		function widget( $args, $instance ) {
			$out = $args['before_widget'];

			$id = offtheshelf_get_widget_uid( 'cta-box' );

			// custom css
			$style = '.' . $id . ' p { font-size:' . offtheshelf_array_option( 'size', $instance, '13' ) . 'px; }' . "\n";
			offtheshelf_add_custom_style( 'cta-box', $style );

			// button position
			$cta_position = offtheshelf_array_option( 'position', $instance, 'left' );


			// nofollow attribute
			if ( offtheshelf_array_option( 'nofollow', $instance, false ) ) {
				$nofollow = ' rel="nofollow"';
			} else {
				$nofollow = '';
			}

			// button style
			$button_style_uid = offtheshelf_array_option( 'style', $instance, false );
			$button_style     = 'button-style-none';
			if ( $button_style_uid ) {
				$button_style_attrs = offtheshelf_get_button_style( $button_style_uid );
				if ( $button_style_attrs ) {
					$button_style = 'button-style-' . $button_style_uid . ' ots-' . $button_style_attrs['default']['background_mode'] . ' ots-' . $button_style_attrs['hover']['background_mode'];
				}
			}

			// link
			$link = esc_url ( offtheshelf_array_option( 'link', $instance, '#' ) );
			if ( empty ($link) ) $link = "#";

			// llink tagets
 			$link_target = offtheshelf_array_option( 'link_target', $instance, 0 );

			if ( $link_target == 1 ) {
				$link_target = '_blank';
			} else {
				$link_target = '_self';
			}


			// modal window
			$modal     = offtheshelf_array_option( 'modal', $instance, false );
			$link_data = '';
			if (defined('OFFTHESHELF_MODALS' ) ) {
				if ( $modal ) {
					offtheshelf_add_modal( $modal );
					$link_data = ' data-featherlight="#modal-' . $modal . '" data-featherlight-variant="modal-style-' . $modal . '"';
					$link      = 'javascript:void(0);';
				}
			}

			// button HTML code
			$cta = '<div class="cta-link button_type_single"><a class="' . $button_style . '" href="' . esc_attr ( $link ) . '" target="' . esc_attr ( $link_target ) . '" title="' . esc_attr( offtheshelf_array_option( 'action', $instance, '#' ) ) . '"' . $nofollow . $link_data . '>' . offtheshelf_array_option( 'action', $instance, '#' ) . '</a></div>';

			$out .= '<div class="cta-box ' . $id . ' cta-position-' . $cta_position . '">';

			if ( $cta_position == "above" || $cta_position == "left" ) {
				$out .= $cta;
			}

			$out .= '<div class="cta-box-text">';

			$out .= '<p>' . offtheshelf_esc_html( offtheshelf_array_option( 'text', $instance ), false, true ) . '</p>';

			$out .= '</div>';

			if ( $cta_position == "below" || $cta_position == "right" ) {
				$out .= $cta;
			}

			$out .= '</div>';

			$out .= $args['after_widget'];

			echo $out;
		}

	} // class

	// Register widget
	if ( ! function_exists( 'register_offtheshelf_cta_box_widget' ) ) {
		function register_offtheshelf_cta_box_widget() {
			register_widget( 'OffTheShelf_CTA_Box_Widget' );
		}

		add_action( 'widgets_init', 'register_offtheshelf_cta_box_widget', 1 );
	}
}
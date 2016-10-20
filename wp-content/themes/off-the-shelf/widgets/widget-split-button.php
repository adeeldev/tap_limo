<?php
/**
 * Plugin Name: OffTheShelf Split Button
 * Plugin URI: http://www.shapingrain.com
 * Description: Displays a split button
 * Version: 1.0
 * License: GPLv2
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

if ( ! class_exists( 'OffTheShelf_Split_Button_Widget' ) ) {
	class OffTheShelf_Split_Button_Widget extends SR_Widget {

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
				'label'       => esc_html__( 'OtS Split Button', 'offtheshelf' ),
				// Widget Backend Description
				'description' => esc_html__( 'Displays a split button.', 'offtheshelf' ),
				'options' => array ( 'classname' => 'ots-split-button' )

			);

			// Tab groups
			$args['groups'] = array(
				'button_left'  => esc_html__( 'Left Button', 'offtheshelf' ),
				'button_right' => esc_html__( 'Right Button', 'offtheshelf' ),
				'other'        => esc_html__( 'Other', 'offtheshelf' ),
			);

			// Configure the widget fields

			// fields array
			$args['fields'] = array(
				/*
				 * Other Options
				 */
				array(
					'name'     => esc_html__( 'Render as two separate buttons', 'offtheshelf' ),
					'desc'     => esc_html__( 'If this option is selected, the two buttons will be visually separated.', 'offtheshelf' ),
					'id'       => 'separate_buttons',
					'group'    => 'other',
					'type'     => 'checkbox',
					'class'    => 'widefat',
					'std'      => 0,
					'validate' => 'alpha_dash',
					'filter'   => ''
				),
				array(
					'name'     => esc_html__( 'Hint or Notice', 'offtheshelf' ),
					'desc'     => esc_html__( 'Optional hint to be displayed below the button.', 'offtheshelf' ),
					'id'       => 'hint',
					'group'    => 'other',
					'type'     => 'textarea',
					'rows'     => '3',
					// class, rows, cols
					'class'    => 'widefat',
					'std'      => '',
					'validate' => 'alpha_dash',
					'filter'   => 'esc_textarea'
				),
				/*
				 * Left Button
				 */
				array(
					'name'     => esc_html__( 'Style', 'offtheshelf' ),
					'desc'     => esc_html__( 'You can create and edit button styles via the theme\'s options panel.', 'offtheshelf' ),
					'id'       => 'style_left',
					'group'    => 'button_left',
					'type'     => 'select',
					'fields'   => $styles,
					'std'      => $std_style,
					'validate' => 'alpha_dash',
					'filter'   => ''
				),
				array(
					'name'     => esc_html__( 'Left Button Caption', 'offtheshelf' ),
					// 'desc' => esc_html__( 'Price, or left part of the button.', 'offtheshelf' ),
					'id'       => 'caption_left',
					'group'    => 'button_left',
					'type'     => 'text',
					// class, rows, cols
					'class'    => 'widefat',
					'std'      => '',
					'validate' => 'alpha_dash',
					'filter'   => ''
				),
				array(
					'name'     => esc_html__( 'Icon', 'offtheshelf' ),
					'desc'     => esc_html__( 'Select an icon for this item.', 'offtheshelf' ),
					'group'    => 'button_left',
					'id'       => 'left_icon',
					'type'     => 'fontawesome',
					'class'    => 'widefat',
					'std'      => '',
					'validate' => 'alpha_dash',
					'filter'   => ''
				),
				array(
					'name'     => esc_html__( 'Icon Position', 'offtheshelf' ),
					'desc'     => esc_html__( 'Select where you would like the icon to be displayed.', 'offtheshelf' ),
					'group'    => 'button_left',
					'id'       => 'left_icon_position',
					'type'     => 'select',
					'fields'   => array(
						array(
							'name'  => esc_html__( 'Left of caption', 'offtheshelf' ),
							'value' => 'left'
						),
						array(
							'name'  => esc_html__( 'Right of caption', 'offtheshelf' ),
							'value' => 'right'
						)
					),
					'std'      => 'left',
					'validate' => 'alpha_dash',
					'filter'   => ''
				),
				array(
					'name'     => esc_html__( 'Left Button Link URL', 'offtheshelf' ),
					'desc'     => esc_html__( 'Define a link to point this button to.', 'offtheshelf' ),
					'id'       => 'link_left',
					'group'    => 'button_left',
					'type'     => 'text',
					'class'    => 'widefat',
					'std'      => '',
					'validate' => 'alpha_dash',
					'filter'   => ''
				),
				array(
					'name'     => esc_html__( 'Open Link in New Window', 'offtheshelf' ),
					//'desc' => esc_html__( 'Select, whether this link should be opened in a new window.', 'offtheshelf' ),
					'id'       => 'link_left_target',
					'group'    => 'button_left',
					'type'     => 'checkbox',
					'class'    => 'widefat',
					'std'      => 0,
					'validate' => 'alpha_dash',
					'filter'   => ''
				),
				array(
					'name'     => esc_html__( 'Add "nofollow" attribute to link.', 'offtheshelf' ),
					//'desc' => esc_html__( 'Instruct search engines not to follow this link.', 'offtheshelf' ),
					'id'       => 'link_left_nofollow',
					'group'    => 'button_left',
					'type'     => 'checkbox',
					'class'    => 'widefat',
					'std'      => 0,
					'validate' => 'alpha_dash',
					'filter'   => ''
				),
				array(
					'name'      => esc_html__( 'Open Modal Window', 'offtheshelf' ),
					'desc'      => esc_html__( 'Optional modal window to open instead of using a link. The feature pack plug-in is required.', 'offtheshelf' ),
					'id'        => 'modal_left',
					'group'     => 'button_left',
					'type'      => 'posts',
					'post_type' => 'modal',
					'std'       => 0,
					'validate'  => 'alpha_dash',
					'filter'    => ''
				),
				/*
				 * Right Button
				 */
				array(
					'name'     => esc_html__( 'Style', 'offtheshelf' ),
					'desc'     => esc_html__( 'You can create and edit button styles via the theme\'s options panel.', 'offtheshelf' ),
					'id'       => 'style_right',
					'group'    => 'button_right',
					'type'     => 'select',
					'fields'   => $styles,
					'std'      => $std_style,
					'validate' => 'alpha_dash',
					'filter'   => ''
				),
				array(
					'name'     => esc_html__( 'Right Button Caption', 'offtheshelf' ),
					// 'desc' => esc_html__( 'Caption, or right part of the button.', 'offtheshelf' ),
					'id'       => 'caption_right',
					'group'    => 'button_right',
					'type'     => 'text',
					// class, rows, cols
					'class'    => 'widefat',
					'std'      => '',
					'validate' => 'alpha_dash',
					'filter'   => ''
				),
				array(
					'name'     => esc_html__( 'Icon', 'offtheshelf' ),
					'desc'     => esc_html__( 'Select an icon for this item.', 'offtheshelf' ),
					'group'    => 'button_right',
					'id'       => 'right_icon',
					'type'     => 'fontawesome',
					'class'    => 'widefat',
					'std'      => '',
					'validate' => 'alpha_dash',
					'filter'   => ''
				),
				array(
					'name'     => esc_html__( 'Icon Position', 'offtheshelf' ),
					'desc'     => esc_html__( 'Select where you would like the icon to be displayed.', 'offtheshelf' ),
					'group'    => 'button_right',
					'id'       => 'right_icon_position',
					'type'     => 'select',
					'fields'   => array(
						array(
							'name'  => esc_html__( 'Left of caption', 'offtheshelf' ),
							'value' => 'left'
						),
						array(
							'name'  => esc_html__( 'Right of caption', 'offtheshelf' ),
							'value' => 'right'
						)
					),
					'std'      => 'left',
					'validate' => 'alpha_dash',
					'filter'   => ''
				),
				array(
					'name'     => esc_html__( 'Right Button Link URL', 'offtheshelf' ),
					'desc'     => esc_html__( 'Define a link to point this button to.', 'offtheshelf' ),
					'id'       => 'link_right',
					'group'    => 'button_right',
					'type'     => 'text',
					'class'    => 'widefat',
					'std'      => '',
					'validate' => 'alpha_dash',
					'filter'   => ''
				),
				array(
					'name'     => esc_html__( 'Open Link in New Window', 'offtheshelf' ),
					//'desc' => esc_html__( 'Select, whether this link should be opened in a new window.', 'offtheshelf' ),
					'id'       => 'link_right_target',
					'group'    => 'button_right',
					'type'     => 'checkbox',
					'class'    => 'widefat',
					'std'      => 0,
					'validate' => 'alpha_dash',
					'filter'   => ''
				),
				array(
					'name'     => esc_html__( 'Add "nofollow" attribute to link.', 'offtheshelf' ),
					//'desc' => esc_html__( 'Instruct search engines not to follow this link.', 'offtheshelf' ),
					'id'       => 'link_right_nofollow',
					'group'    => 'button_right',
					'type'     => 'checkbox',
					'class'    => 'widefat',
					'std'      => 0,
					'validate' => 'alpha_dash',
					'filter'   => ''
				),
				array(
					'name'      => esc_html__( 'Open Modal Window', 'offtheshelf' ),
					'desc'      => esc_html__( 'Optional modal window to open instead of using a link. The modals plug-in is required.', 'offtheshelf' ),
					'id'        => 'modal_right',
					'group'     => 'button_right',
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
			$is_pagebuilder = offtheshelf_is_pagebuilder( $args );

			/*
			 * Captions
			 */
			$caption_left  = offtheshelf_array_option( 'caption_left', $instance, '' );
			$caption_right = offtheshelf_array_option( 'caption_right', $instance, '' );

			/*
			 * Links
			 */
			$link_left  = esc_url( offtheshelf_array_option( 'link_left', $instance, '' ) );
			if ( empty ($link_left) ) $link_left = "#";

			$link_right = esc_url( offtheshelf_array_option( 'link_right', $instance, '' ) );
			if ( empty ($link_right) ) $link_right = "#";


			/*
			 * Link Tagets
			 */
			$link_left_target  = offtheshelf_array_option( 'link_left_target', $instance, 0 );
			$link_right_target = offtheshelf_array_option( 'link_left_target', $instance, 0 );

			/*
			 * No Follow
			 */
			if ( offtheshelf_array_option( 'link_left_nofollow', $instance, false ) ) {
				$link_left_nofollow = ' rel="nofollow"';
			} else {
				$link_left_nofollow = '';
			}

			if ( offtheshelf_array_option( 'link_right_nofollow', $instance, false ) ) {
				$link_right_nofollow = ' rel="nofollow"';
			} else {
				$link_right_nofollow = '';
			}

			/*
			 * Modal Windows
			 */
			$modal_left  = offtheshelf_array_option( 'modal_left', $instance, false );
			$modal_right = offtheshelf_array_option( 'modal_right', $instance, false );

			$link_left_data  = '';
			$link_right_data = '';

			if (defined('OFFTHESHELF_MODALS' ) ) {
				if ( $modal_left ) {
					offtheshelf_add_modal( $modal_left );
					$link_left_data = ' data-featherlight="#modal-' . $modal_left . '" data-featherlight-variant="modal-style-' . $modal_left . '"';
					$link_left      = 'javascript:void(0);';
				}

				if ( $modal_right ) {
					offtheshelf_add_modal( $modal_right );
					$link_right_data = ' data-featherlight="#modal-' . $modal_right . '" data-featherlight-variant="modal-style-' . $modal_right . '"';
					$link_right      = 'javascript:void(0);';
				}
			}

			/*
			 * Output
			 */
			$id = offtheshelf_get_widget_uid( 'button' );

			$icon_left  = esc_html ( offtheshelf_array_option( 'left_icon', $instance, '' ) );
			$icon_right = esc_html ( offtheshelf_array_option( 'right_icon', $instance, '' ) );

			$icon_position_left  = offtheshelf_array_option( 'left_icon_position', $instance, 'left' );
			$icon_position_right = offtheshelf_array_option( 'right_icon_position', $instance, 'right' );

			$add_classes = "";
			$out         = $args['before_widget'];

			$type = offtheshelf_array_option( 'type', $instance, 'single' );

			$is_sep = offtheshelf_array_option( 'separate_buttons', $instance, false );
			if ( $is_sep ) {
				$separate = ' split-button-separate';
			} else {
				$separate = ' split-button-connected';
			}

			$out .= '<div class="split-button' . $separate . '">';

			if ( $link_left_target == 1 ) {
				$link_left_target = '_blank';
			} else {
				$link_left_target = '_self';
			}

			if ( $link_right_target == 1 ) {
				$link_right_target = '_blank';
			} else {
				$link_right_target = '_self';
			}

			if ( $button_style_tag = offtheshelf_array_option( 'style_left', $instance, false ) ) {
				$button_style_left = 'button-style-' . $button_style_tag;
				$button_style      = offtheshelf_get_button_style( $button_style_tag );
				if ( $button_style ) {
					$button_style_left .= ' ots-' . esc_attr( $button_style['default']['background_mode'] ). ' ots-' . esc_attr( $button_style['hover']['background_mode'] );
				}
			} else {
				$button_style_left = 'button-style-none';
			}

			if ( $button_style_tag = offtheshelf_array_option( 'style_right', $instance, false ) ) {
				$button_style_right = 'button-style-' . $button_style_tag;
				$button_style       = offtheshelf_get_button_style( $button_style_tag );
				if ( $button_style ) {
					$button_style_right .= ' ots-' . esc_attr( $button_style['default']['background_mode'] ) . ' ots-' . esc_attr( $button_style['hover']['background_mode'] );
				}
			} else {
				$button_style_right = 'button-style-none';
			}

			// Link output

			// Left
			if ( ! empty( $caption_left ) ) {
				if ( ! empty( $icon_left ) && $icon_position_left == "left" ) {
					$button_style_left .= ' button-icon-left';
				}
				if ( ! empty( $icon_left ) && $icon_position_left == "right" ) {
					$button_style_left .= ' button-icon-right';
				}

				if ( $link_left ) {
					// link URLs are escaped as such while retrieved from database
					$out .= '<a href="' . esc_attr( $link_left ) . '" target="' . esc_attr( $link_left_target ) . '"' . $link_left_nofollow . $link_left_data . '>';
				}
				$out .= '<div class="split-left ' . $button_style_left . '">';
				if ( ! empty( $icon_left ) && $icon_position_left == "left" ) {
					$out .= '<i class="' . $id . '_left fa ' . $icon_left . '"></i> ';
				}
				$out .= $caption_left;
				if ( ! empty( $icon_left ) && $icon_position_left == "right" ) {
					$out .= ' <i class="' . $id . '_left fa ' . $icon_left . '"></i>';
				}
				$out .= '</div>';
				if ( $link_left ) {
					$out .= '</a>';
				}
			}

			// Right
			if ( ! empty( $caption_right ) ) {
				if ( ! empty( $icon_right ) && $icon_position_right == "left" ) {
					$button_style_right .= ' button-icon-left';
				}
				if ( ! empty( $icon_right ) && $icon_position_right == "right" ) {
					$button_style_right .= ' button-icon-right';
				}

				if ( $link_right ) {
					// link URLs are escaped as such while retrieved from database
					$out .= '<a href="' . esc_attr( $link_right ) . '" target="' . esc_attr ( $link_right_target ) . '"' . $link_right_nofollow . $link_right_data . '>';
				}
				$out .= '<div class="split-right ' . $button_style_right . '">';
				if ( ! empty( $icon_right ) && $icon_position_right == "left" ) {
					$out .= '<i class="' . $id . '_right fa ' . $icon_right . '"></i> ';
				}
				$out .= $caption_right;
				if ( ! empty( $icon_right ) && $icon_position_right == "right" ) {
					$out .= ' <i class="' . $id . '_right fa ' . $icon_right . '"></i>';
				}
				$out .= '</div>';
				if ( $link_right ) {
					$out .= '</a>';
				}
			}


			if ( isset( $instance['hint'] ) && trim( $instance['hint'] ) != "" ) {
				$out .= '<p class="hint">' . offtheshelf_esc_html( offtheshelf_array_option( 'hint', $instance, '' ), false, true ) . '</p>';
			}

			$out .= '</div>'; // class = split-button

			$out .= $args['after_widget'];

			echo $out;
		}

	} // class

	// Register widget
	if ( ! function_exists( 'register_offtheshelf_split_button_widget' ) ) {
		function register_offtheshelf_split_button_widget() {
			register_widget( 'OffTheShelf_Split_Button_Widget' );
		}

		add_action( 'widgets_init', 'register_offtheshelf_split_button_widget', 1 );
	}
}
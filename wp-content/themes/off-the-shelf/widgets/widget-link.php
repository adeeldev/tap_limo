<?php
/**
 * Plugin Name: OffTheShelf Link
 * Plugin URI: http://www.shapingrain.com
 * Description: Displays a text link.
 * Version: 1.0
 * License: GPLv2
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

if ( ! class_exists( 'OffTheShelf_Link_Widget' ) ) {
	class OffTheShelf_Link_Widget extends SR_Widget {

		function __construct() {

			// Configure widget array
			$args = array(
				// Widget Backend label
				'label'       => esc_html__( 'OtS Link', 'offtheshelf' ),
				// Widget Backend Description
				'description' => esc_html__( 'Displays a text link.', 'offtheshelf' ),
				'options' => array ( 'classname' => 'ots-link' )
			);

			// Configure the widget fields

			// fields array
			$args['fields'] = array(

				array(
					'name'     => esc_html__( 'Link Text', 'offtheshelf' ),
					'id'       => 'caption',
					'type'     => 'text',
					'desc'     => esc_html__( 'This is the actual anchor text.', 'offtheshelf' ),
					// class, rows, cols
					'class'    => 'widefat',
					'std'      => '',
					'validate' => 'alpha_dash',
					'filter'   => ''
				),
				array(
					'name'     => esc_html__( 'Font Size', 'offtheshelf' ),
					'desc'     => esc_html__( 'Define the font size for this link in px.', 'offtheshelf' ),
					'id'       => 'font_size',
					'type'     => 'number',
					'class'    => 'widefat',
					'std'      => 13,
					'validate' => 'numeric',
					'filter'   => ''
				),
				array(
					'name'     => esc_html__( 'Icon', 'offtheshelf' ),
					'desc'     => esc_html__( 'Select an icon for this item.', 'offtheshelf' ),
					'id'       => 'icon',
					'type'     => 'fontawesome',
					'class'    => 'widefat',
					'std'      => '',
					'validate' => 'alpha_dash',
					'filter'   => ''
				),
				array(
					'name'     => esc_html__( 'Icon Position', 'offtheshelf' ),
					'desc'     => esc_html__( 'Select where you would like the icon to be displayed.', 'offtheshelf' ),
					'id'       => 'icon_position',
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
					'name'     => esc_html__( 'Link URL', 'offtheshelf' ),
					'desc'     => esc_html__( 'Define a URL to point this link to.', 'offtheshelf' ),
					'id'       => 'link',
					'type'     => 'text',
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
					'id'       => 'link_nofollow',
					'group'    => 'button',
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
			$is_pagebuilder = offtheshelf_is_pagebuilder( $args );

			/*
			 * Captions
			 */
			$caption = offtheshelf_esc_html( offtheshelf_array_option( 'caption', $instance, '' ), false, true );

			/*
			 * Links
			 */
			$link = esc_url( offtheshelf_array_option( 'link', $instance, '' ) );

			/*
			 * Link Tagets
			 */
			$link_target = offtheshelf_array_option( 'link_target', $instance, 0 );
			/*
			 * No Follow
			 */
			if ( offtheshelf_array_option( 'link_nofollow', $instance, false ) ) {
				$link_nofollow = ' rel="nofollow"';
			} else {
				$link_nofollow = '';
			}

			/*
			 * Modal Windows
			 */
			$modal = offtheshelf_array_option( 'modal', $instance, false );

			$link_data = '';

			if (defined('OFFTHESHELF_MODALS' ) ) {
				if ( $modal ) {
					offtheshelf_add_modal( $modal );
					$link_data = ' data-featherlight="#modal-' . $modal . '" data-featherlight-variant="modal-style-' . $modal . '"';
					$link      = 'javascript:void(0);';
				}
			}


			/*
			 * Output
			 */
			$id = offtheshelf_get_widget_uid( 'link' );

			$size = offtheshelf_array_option( 'font_size', $instance, 0 );
			if ( $size > 0 ) {
				$style = '#' . $id . ' { font-size:' . $size . 'px; }';
				offtheshelf_add_custom_style( 'cf7', $style );
			}


			$icon = offtheshelf_array_option( 'icon', $instance, '' );

			$icon_position = offtheshelf_array_option( 'icon_position', $instance, 'left' );

			$add_classes = "";
			$out         = $args['before_widget'];

			$type = offtheshelf_array_option( 'type', $instance, 'single' );


			if ( $link_target == 1 ) {
				$link_target = '_blank';
			} else {
				$link_target = '_self';
			}

			// Link output
			$button_style_class = "text-link";

			// Left
			if ( ! empty( $caption ) ) {
				if ( ! empty( $icon ) && $icon_position == "left" ) {
					$button_style_class .= ' link-icon-left';
				}
				if ( ! empty( $icon ) && $icon_position == "right" ) {
					$button_style_class .= ' link-icon-right';
				}

				if ( $link ) {
					// link URLs are escaped as such while retrieved from database
					$out .= '<a href="' . esc_attr( $link ) . '" id="' . $id . '" class="' . $button_style_class . '" target="' . esc_attr ( $link_target ) . '"' . $link_nofollow . $link_data . '>';
				}
				if ( ! empty( $icon ) && $icon_position == "left" ) {
					$out .= '<i class="fa ' . esc_attr( $icon ) . '"></i> ';
				}
				$out .= $caption;
				if ( ! empty( $icon ) && $icon_position == "right" ) {
					$out .= ' <i class="fa ' . esc_attr( $icon ) . '"></i>';
				}
				if ( $link ) {
					$out .= '</a>';
				}
			}

			$out .= $args['after_widget'];

			echo $out;
		}

	} // class

	// Register widget
	if ( ! function_exists( 'register_offtheshelf_link_widget' ) ) {
		function register_offtheshelf_link_widget() {
			register_widget( 'OffTheShelf_Link_Widget' );
		}

		add_action( 'widgets_init', 'register_offtheshelf_link_widget', 1 );
	}
}
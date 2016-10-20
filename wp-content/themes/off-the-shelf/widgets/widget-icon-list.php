<?php
/**
 * Plugin Name: OffTheShelf Icon List
 * Plugin URI: http://www.shapingrain.com
 * Description: Displays an unordered list with an icon for the list elements
 * Version: 1.0
 * License: GPLv2
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

if ( ! class_exists( 'OffTheShelf_Icon_List_Widget' ) ) {
	class OffTheShelf_Icon_List_Widget extends SR_Widget {

		function __construct() {

			// Configure widget array
			$args = array(
				// Widget Backend label
				'label'       => esc_html__( 'OtS Icon List', 'offtheshelf' ),
				// Widget Backend Description
				'description' => esc_html__( 'Displays an unordered list with an icon for each list element.', 'offtheshelf' ),
				'options' => array ( 'classname' => 'ots-icon-list' )
			);

			// Configure the widget fields

			// fields array
			$args['fields'] = array(
				array(
					'name'     => esc_html__( 'Icon', 'offtheshelf' ),
					'desc'     => esc_html__( 'Select an icon to be used for all elements in this list.', 'offtheshelf' ),
					'id'       => 'icon',
					'type'     => 'fontawesome',
					'class'    => 'widefat',
					'std'      => '',
					'validate' => 'alpha_dash',
					'filter'   => ''
				),
				array(
					'name'     => esc_html__( 'Icon Color', 'offtheshelf' ),
					'desc'     => esc_html__( 'Select a list icon color.', 'offtheshelf' ),
					'id'       => 'icon_color',
					'type'     => 'color',
					// class, rows, cols
					'std'      => '#000000',
					'validate' => 'alpha_dash',
					'filter'   => ''
				),
				array(
					'name'     => esc_html__( 'List Items', 'offtheshelf' ),
					'desc'     => esc_html__( 'One item per row.', 'offtheshelf' ),
					'id'       => 'items',
					'type'     => 'textarea',
					'rows'     => '10',
					'class'    => 'widefat',
					'std'      => '',
					'validate' => 'alpha_dash',
					'filter'   => ''
				),

			); // fields array

			$this->create_widget( $args );
		}

		// Output function
		function widget( $args, $instance ) {
			$is_pagebuilder = offtheshelf_is_pagebuilder( $args );

			$id    = offtheshelf_get_widget_uid( 'icon-list' );
			$style = '.' . $id . ' li i.fa { color:' . offtheshelf_array_option( 'icon_color', $instance, '#dca400' ) . '; }';
			offtheshelf_add_custom_style( 'icon-block', $style );


			$add_classes = "";
			$out         = $args['before_widget'];

			if ( isset( $instance['items'] ) ) {
				$out .= '<ul class="icon-list fa-ul ' . $id . '">';
				$items = explode( "\n", trim( $instance['items'] ) );
				if ( is_array( $items ) ) {
					foreach ( $items as $item ) {
						$out .= '<li><i class="fa-li fa ' . esc_attr( $instance['icon'] ) . '"></i>' . offtheshelf_esc_html ( $item, false, true ) . '</li>';
					}
				}
				$out .= '</ul>';
			}

			$out .= $args['after_widget'];

			echo $out;
		}

	} // class

	// Register widget
	if ( ! function_exists( 'register_offtheshelf_icon_list_widget' ) ) {
		function register_offtheshelf_icon_list_widget() {
			register_widget( 'OffTheShelf_Icon_List_Widget' );
		}

		add_action( 'widgets_init', 'register_offtheshelf_icon_list_widget', 1 );
	}
}


/*
 * Provide widget features as shortcode for third party implementation
 */
if ( ! function_exists( 'offtheshelf_unordered_list_shortcode' ) ) {
	function offtheshelf_unordered_list_shortcode( $attrs, $content = null ) {
		if (!isset ($attrs['icon'])) $icon = 'fa-check'; else $icon = $attrs['icon'];

		$totrim = array (
			'<br />' => ''
		);

		$content = strtr( trim ( $content ), $totrim);

		$output = '<div class="offtheshelf-ul ots-icon-list">';

		if ( substr_count($content, '<ul') ) {
			$content = str_replace ('<ul', '<ul class="icon-list fa-ul"', $content);
			$content = str_replace ('<li>', '<li><i class="fa-li fa ' . $icon . '"></i> ', $content);
			$output .= $content;
		} else {
			$output .= '<ul class="icon-list fa-ul">';
			$items = explode("\n", trim ( $content ) );
			if ( $items && is_array($items) ) {
				foreach ( $items as $item ) {
					if (!empty ($item) ) {
						$output .= '<li><i class="fa-li fa ' . $icon . '"></i> ' . trim ( $item ) .  '</li>';
					}
				}
			}
			$output .= '</ul>';
		}

		$output .= '</div>';

		return $output;
	}
}
add_shortcode ('offtheshelf_unordered_list', 'offtheshelf_unordered_list_shortcode');

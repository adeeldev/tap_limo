<?php
/**
 * Plugin Name: OffTheShelf Blog Posts
 * Plugin URI: http://www.shapingrain.com
 * Description: Displays the latest blog posts
 * Version: 1.0
 * License: GPLv2
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

if ( ! class_exists( 'OffTheShelf_Blog_Posts_Widget' ) ) {
	class OffTheShelf_Blog_Posts_Widget extends SR_Widget {

		function __construct() {

			// Configure widget array
			$args = array(
				// Widget Backend label
				'label'       => esc_html__( 'OtS Blog Posts', 'offtheshelf' ),
				// Widget Backend Description
				'description' => esc_html__( 'Displays the latest blog posts.', 'offtheshelf' ),
				'options' => array ( 'classname' => 'ots-blog-posts' )
			);

			// Configure the widget fields

			// fields array
			$args['fields'] = array(
				array(
					'name'     => esc_html__( 'Title', 'offtheshelf' ),
					'desc'     => esc_html__( 'Enter the widget title.', 'offtheshelf' ),
					'id'       => 'title',
					'type'     => 'text',
					// class, rows, cols
					'class'    => 'widefat',
					'std'      => esc_html__( 'Latest News', 'offtheshelf' ),
					'validate' => 'alpha_dash',
					'filter'   => ''
				),
				array(
					'name'      => 'Categories',
					'type'      => 'categories',
					'id'        => 'categories',
					'taxonomy'  => 'category',
					'post_type' => 'posts',
					'multiple'  => true,
					'validate'  => null,
					'filter'    => ''
				),
				array(
					'name'     => esc_html__( 'Amount of posts to display', 'offtheshelf' ),
					'desc'     => esc_html__( 'Select how many blog posts you would like this widget to display.', 'offtheshelf' ),
					'id'       => 'amount',
					'type'     => 'number',
					'std'      => 15,
					'validate' => 'numeric',
					'filter'   => ''
				),
				array(
					'name'           => esc_html__( 'Layout', 'offtheshelf' ),
					'desc'           => esc_html__( 'Select a layout to be used for this block.', 'offtheshelf' ),
					'id'             => 'layout',
					'group-selector' => true,
					'type'           => 'select',
					'fields'         => array(
						array(
							'name'  => esc_html__( 'List (Large)', 'offtheshelf' ),
							'value' => 'list'
						),
						array(
							'name'  => esc_html__( 'List (Medium)', 'offtheshelf' ),
							'value' => 'medium'
						),
						array(
							'name'  => esc_html__( 'Grid', 'offtheshelf' ),
							'value' => 'grid'
						),
						array(
							'name'  => esc_html__( 'Masonry', 'offtheshelf' ),
							'value' => 'masonry'
						),
						array(
							'name'  => esc_html__( 'Timeline', 'offtheshelf' ),
							'value' => 'timeline'
						),
						array(
							'name'  => esc_html__( 'Minimal', 'offtheshelf' ),
							'value' => 'minimal'
						),
					),
					'std'            => 'list',
					'validate'       => 'alpha_dash',
					'filter'         => ''
				),
				array(
					'name'        => esc_html__( 'Group by', 'offtheshelf' ),
					'desc'        => esc_html__( 'Select how you would like to group posts in the timeline view.', 'offtheshelf' ),
					'id'          => 'group_by',
					'is-group'    => 'layout',
					'group-value' => array( 'timeline' ),
					'type'        => 'select',
					'fields'      => array(
						array(
							'name'  => esc_html__( 'Day', 'offtheshelf' ),
							'value' => 'day'
						),
						array(
							'name'  => esc_html__( 'Month', 'offtheshelf' ),
							'value' => 'month'
						),
						array(
							'name'  => esc_html__( 'Year', 'offtheshelf' ),
							'value' => 'year'
						),
					),
					'std'         => 'day',
					'validate'    => 'alpha_dash',
					'filter'      => ''
				),
				array(
					'name'        => esc_html__( 'Columns', 'offtheshelf' ),
					'desc'        => esc_html__( 'Select how many columns you would like to have for views that support columns.', 'offtheshelf' ),
					'id'          => 'columns',
					'is-group'    => 'layout',
					'group-value' => array( 'grid', 'masonry' ),
					'type'        => 'select',
					'fields'      => array(
						array(
							'name'  => '2',
							'value' => '2'
						),
						array(
							'name'  => '3',
							'value' => '3'
						),
						array(
							'name'  => '4',
							'value' => '4'
						),
						array(
							'name'  => '5',
							'value' => '5'
						),
					),
					'std'         => '3',
					'validate'    => 'numeric',
					'filter'      => ''
				),
				array(
					'name'     => esc_html__( 'Excerpt length', 'offtheshelf' ),
					'desc'     => esc_html__( 'Define how many words you would like to display in the excerpt.', 'offtheshelf' ),
					'id'       => 'excerpt_length',
					'type'     => 'number',
					'std'      => 25,
					'validate' => 'numeric',
					'filter'   => ''
				)


			); // fields array

			$this->create_widget( $args );
		}

		// Output function
		function widget( $args, $instance ) {
			global $offtheshelf_widget_group_by,
			       $offtheshelf_widget_cols_per_row,
			       $offtheshelf_widget_excerpt_length;

			$id    = offtheshelf_get_widget_uid( 'posts' );
			$cache = wp_cache_get( $id, 'widget' );

			$offtheshelf_widget_group_by       = offtheshelf_array_option( 'group_by', $instance, 'day' );
			$offtheshelf_widget_cols_per_row   = offtheshelf_array_option( 'columns', $instance, '3' );
			$offtheshelf_widget_excerpt_length = offtheshelf_array_option( 'excerpt_length', $instance, '25' );

			$add_classes = "";
			$out         = $args['before_widget'];

			$out .= '<section>';

			$categories_tmp = offtheshelf_array_option( 'categories', $instance );
			$categories     = array();
			if ( $categories_tmp ) {
				foreach ( $categories_tmp as $slug => $cat ) {
					$categories[] = $slug;
				}
			}

			$r = new WP_Query( apply_filters( 'widget_posts_args',
					array(
						'post_type'      => 'post',
						'posts_per_page' => $instance['amount'],
						'no_found_rows'  => true,
						'category_name'  => implode( ",", $categories ),
						'post_status'    => 'publish'
					)
				)
			);

			if ( $r->have_posts() ) {
				ob_start();
				$template = locate_template( 'templates/blog/widget/blog-' . offtheshelf_array_option( 'layout', $instance, 'list' ) . '.php' );
				if ( $template ) {
					include( $template );
				} else {
					$out .= esc_html__( 'Template not available.', 'offtheshelf' );
				}
				$out .= ob_get_contents();
				ob_end_clean();
			}

			wp_reset_postdata();

			$out .= '</section>';

			$out .= $args['after_widget'];

			echo $out;
		}

	} // class

	// Register widget
	if ( ! function_exists( 'register_offtheshelf_blog_posts_widget' ) ) {
		function register_offtheshelf_blog_posts_widget() {
			register_widget( 'OffTheShelf_Blog_Posts_Widget' );
		}

		add_action( 'widgets_init', 'register_offtheshelf_blog_posts_widget', 1 );
	}
}
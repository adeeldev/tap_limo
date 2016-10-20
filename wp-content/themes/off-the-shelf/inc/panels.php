<?php
/**
 * Configure page builder settings.
 */
function offtheshelf_panels_settings($old_settings){
	$supported_types = offtheshelf_option('pagebuilder_post_types', array ( 'page', 'post', 'banner', 'modal' ) );

	$supported_types = array_merge ( $supported_types, array( 'page', 'post', 'banner', 'modal' ) );
	$supported_types = array_unique ( $supported_types );

	$settings = array (
		'home-page' => false,
		'home-page-default' => false,
		'post-types' => $supported_types,
		'bundled-widgets' => offtheshelf_option('pagebuilder_bundled_widgets', false),
		'responsive' => true,
		'tablet-layout' => offtheshelf_option('pagebuilder_tablet_layout', false),
		'tablet-width' => offtheshelf_option('pagebuilder_tablet_width', 1024),
		'mobile-width' => offtheshelf_option('pagebuilder_mobile_width', 780),
		'margin-bottom' => offtheshelf_option('pagebuilder_row_bottom_margin', 0),
		'margin-sides' => offtheshelf_option('pagebuilder_cell_side_margins', 30),
		'affiliate-id' => '',
		'copy-content' => offtheshelf_option('pagebuilder_copy_content', true),
		'animations' => false,
		'inline-css' => offtheshelf_option('pagebuilder_inline_css', true),
		'add-widget-class' => false
	);

	if ( is_array ( $old_settings ) )
		$settings = array_merge( $old_settings, $settings );

	return $settings;
}
add_filter('siteorigin_panels_settings', 'offtheshelf_panels_settings');

/*
 * Page builder processing
 */

function offtheshelf_siteorigin_panels_css_object ( $css, $panels_data, $post_id ) {
	$settings = siteorigin_panels_setting();
	foreach ( $panels_data['grids'] as $gi => $grid ) {
		// Ony apply gutters to rows with only one cell
		if($grid['cells'] == 0) continue;

		// Let other themes and plugins change the gutter.
		$gutter = apply_filters('siteorigin_panels_css_row_gutter', $settings['margin-sides'].'px', $grid, $gi, $panels_data);

		if( !empty($gutter) ) {
			// We actually need to find half the gutter.
			preg_match('/([0-9\.,]+)(.*)/', $gutter, $match);
			if( !empty( $match[1] ) ) {
				$margin_half = (floatval($match[1])/2) . $match[2];
				$css->add_row_css($post_id, $gi, '', array(
						'margin-left' => '-' . $margin_half,
						'margin-right' => '-' . $margin_half,
				) );
				$css->add_cell_css($post_id, $gi, false, '', array(
						'padding-left' => $margin_half,
						'padding-right' => $margin_half,
				) );

			}
		}
	}
	return $css;
}
add_filter('siteorigin_panels_css_object', 'offtheshelf_siteorigin_panels_css_object', 10, 3);


function offtheshelf_panels_row_style_fields($fields) {

	if (isset($fields['padding'])) unset($fields['padding']);

	$fields['bottom_margin']['priority'] = 1;

	/* Layout Options */

	$fields['row_justification'] = array(
		'group' => 'layout',
		'name' => esc_html__('Row Text Alignment', 'offtheshelf'),
		'type' => 'select',
		'options' => array(
			'left'   => esc_html__('Left', 'offtheshelf'),
			'center' => esc_html__('Center', 'offtheshelf'),
			'right'  => esc_html__('Right', 'offtheshelf'),
		),
		'default' => 'left'
	);

	$fields['row_flexbox'] = array(
		'group' => 'layout',
		'name' => esc_html__('Equal widget height (experimental)', 'offtheshelf'),
		'type' => 'checkbox',
		'description' => esc_html__('If this option is checked, all widgets in this row will have the same height. Does not work with stacked widgets.', 'offtheshelf'),
	);

	$fields['row_stretch'] = array(
		'name' => esc_html__('Row Layout', 'offtheshelf'),
		'type' => 'select',
		'group' => 'layout',
		'options' => array(
			'' => esc_html__('Standard', 'offtheshelf'),
			'full' => esc_html__('Full Width', 'offtheshelf'),
			'full-stretched' => esc_html__('Full Width (stretched)', 'offtheshelf'),
		),
		'priority' => 10,
	);
	
	$fields['padding_top'] = array(
		'name' => esc_html__('Padding (Top)', 'offtheshelf'),
		'type' => 'measurement',
		'group' => 'layout',
		'description' => esc_html__('Padding at the top of the row.', 'offtheshelf'),
		'priority' => 2,
	);

	$fields['padding_bottom'] = array(
		'name' => esc_html__('Padding (Bottom)', 'offtheshelf'),
		'type' => 'measurement',
		'group' => 'layout',
		'description' => esc_html__('Padding at the bottom of the row.', 'offtheshelf'),
		'priority' => 3,
	);

	$fields['padding_left'] = array(
		'name' => esc_html__('Padding (Left)', 'offtheshelf'),
		'type' => 'measurement',
		'group' => 'layout',
		'description' => esc_html__('Padding at the left of the row.', 'offtheshelf'),
		'priority' => 4,
	);

	$fields['padding_right'] = array(
		'name' => esc_html__('Padding (Right)', 'offtheshelf'),
		'type' => 'measurement',
		'group' => 'layout',
		'description' => esc_html__('Padding at the right of the row.', 'offtheshelf'),
		'priority' => 5,
	);

	$fields['background_display']['options'] = array (
		'fixed' => esc_html__('Fixed', 'offtheshelf'),
		'cover' => esc_html__('Cover', 'offtheshelf'),
		'center' => esc_html__('Centered, with original size', 'offtheshelf'),
		'ots-parallax' => esc_html__('Parallax', 'offtheshelf'),
		'tile' => esc_html__('Tile', 'offtheshelf'),
	);

	/* Responsiveness */

	$fields['hide_on_mobile'] = array(
		'name' => esc_html__('Hide on mobile phones', 'offtheshelf'),
		'type' => 'checkbox',
		'group' => 'responsiveness',
		'description' => esc_html__('Hides the entire row on smartphones or other devices with very small screens.', 'offtheshelf'),
		'priority' => 1,
	);

	$fields['hide_on_tablet'] = array(
		'name' => esc_html__('Hide on tablets', 'offtheshelf'),
		'type' => 'checkbox',
		'group' => 'responsiveness',
		'description' => esc_html__('Hides the entire row on tablets or laptops with small screens.', 'offtheshelf'),
		'priority' => 2,
	);

	$fields['hide_on_desktop'] = array(
		'name' => esc_html__('Hide on desktops', 'offtheshelf'),
		'type' => 'checkbox',
		'group' => 'responsiveness',
		'description' => esc_html__('Hides the entire row on desktop or laptop computers with large screens.', 'offtheshelf'),
		'priority' => 3,
	);


	/* Animations */
	if ( ! defined ( 'OFFTHESHELF_DISABLE_ANIMATIONS' )) {

		$fields['animation_type'] = array(
			'name'     => esc_html__( 'Type', 'offtheshelf' ),
			'type'     => 'select',
			'group'    => 'animation',
			'options'  => array(
				''                   => esc_html__( 'None', 'offtheshelf' ),
				'bounce'             => esc_html__( 'bounce', 'offtheshelf' ),
				'flash'              => esc_html__( 'flash', 'offtheshelf' ),
				'pulse'              => esc_html__( 'pulse', 'offtheshelf' ),
				'rubberBand'         => esc_html__( 'rubberBand', 'offtheshelf' ),
				'shake'              => esc_html__( 'shake', 'offtheshelf' ),
				'swing'              => esc_html__( 'swing', 'offtheshelf' ),
				'tada'               => esc_html__( 'tada', 'offtheshelf' ),
				'wobble'             => esc_html__( 'wobble', 'offtheshelf' ),
				'jello'              => esc_html__( 'jello', 'offtheshelf' ),
				'bounceIn'           => esc_html__( 'bounceIn', 'offtheshelf' ),
				'bounceInDown'       => esc_html__( 'bounceInDown', 'offtheshelf' ),
				'bounceInLeft'       => esc_html__( 'bounceInLeft', 'offtheshelf' ),
				'bounceInRight'      => esc_html__( 'bounceInRight', 'offtheshelf' ),
				'bounceInUp'         => esc_html__( 'bounceInUp', 'offtheshelf' ),
				'bounceOut'          => esc_html__( 'bounceOut', 'offtheshelf' ),
				'bounceOutDown'      => esc_html__( 'bounceOutDown', 'offtheshelf' ),
				'bounceOutLeft'      => esc_html__( 'bounceOutLeft', 'offtheshelf' ),
				'bounceOutRight'     => esc_html__( 'bounceOutRight', 'offtheshelf' ),
				'bounceOutUp'        => esc_html__( 'bounceOutUp', 'offtheshelf' ),
				'fadeIn'             => esc_html__( 'fadeIn', 'offtheshelf' ),
				'fadeInDown'         => esc_html__( 'fadeInDown', 'offtheshelf' ),
				'fadeInDownBig'      => esc_html__( 'fadeInDownBig', 'offtheshelf' ),
				'fadeInLeft'         => esc_html__( 'fadeInLeft', 'offtheshelf' ),
				'fadeInLeftBig'      => esc_html__( 'fadeInLeftBig', 'offtheshelf' ),
				'fadeInRight'        => esc_html__( 'fadeInRight', 'offtheshelf' ),
				'fadeInRightBig'     => esc_html__( 'fadeInRightBig', 'offtheshelf' ),
				'fadeInUp'           => esc_html__( 'fadeInUp', 'offtheshelf' ),
				'fadeInUpBig'        => esc_html__( 'fadeInUpBig', 'offtheshelf' ),
				'fadeOut'            => esc_html__( 'fadeOut', 'offtheshelf' ),
				'fadeOutDown'        => esc_html__( 'fadeOutDown', 'offtheshelf' ),
				'fadeOutDownBig'     => esc_html__( 'fadeOutDownBig', 'offtheshelf' ),
				'fadeOutLeft'        => esc_html__( 'fadeOutLeft', 'offtheshelf' ),
				'fadeOutLeftBig'     => esc_html__( 'fadeOutLeftBig', 'offtheshelf' ),
				'fadeOutRight'       => esc_html__( 'fadeOutRight', 'offtheshelf' ),
				'fadeOutRightBig'    => esc_html__( 'fadeOutRightBig', 'offtheshelf' ),
				'fadeOutUp'          => esc_html__( 'fadeOutUp', 'offtheshelf' ),
				'fadeOutUpBig'       => esc_html__( 'fadeOutUpBig', 'offtheshelf' ),
				'flipInX'            => esc_html__( 'flipInX', 'offtheshelf' ),
				'flipInY'            => esc_html__( 'flipInY', 'offtheshelf' ),
				'flipOutX'           => esc_html__( 'flipOutX', 'offtheshelf' ),
				'flipOutY'           => esc_html__( 'flipOutY', 'offtheshelf' ),
				'lightSpeedIn'       => esc_html__( 'lightSpeedIn', 'offtheshelf' ),
				'lightSpeedOut'      => esc_html__( 'lightSpeedOut', 'offtheshelf' ),
				'rotateIn'           => esc_html__( 'None', 'offtheshelf' ),
				'rotateInDownLeft'   => esc_html__( 'rotateInDownLeft', 'offtheshelf' ),
				'rotateInDownRight'  => esc_html__( 'rotateInDownRight', 'offtheshelf' ),
				'rotateInUpLeft'     => esc_html__( 'rotateInUpLeft', 'offtheshelf' ),
				'rotateInUpRight'    => esc_html__( 'rotateInUpRight', 'offtheshelf' ),
				'rotateOut'          => esc_html__( 'rotateOut', 'offtheshelf' ),
				'rotateOutDownLeft'  => esc_html__( 'rotateOutDownLeft', 'offtheshelf' ),
				'rotateOutDownRight' => esc_html__( 'rotateOutDownRight', 'offtheshelf' ),
				'rotateOutUpLeft'    => esc_html__( 'rotateOutUpLeft', 'offtheshelf' ),
				'rotateOutUpRight'   => esc_html__( 'rotateOutUpRight', 'offtheshelf' ),
				'hinge'              => esc_html__( 'hinge', 'offtheshelf' ),
				'rollIn'             => esc_html__( 'rollIn', 'offtheshelf' ),
				'rollOut'            => esc_html__( 'rollOut', 'offtheshelf' ),
				'zoomIn'             => esc_html__( 'zoomIn', 'offtheshelf' ),
				'zoomInDown'         => esc_html__( 'zoomInDown', 'offtheshelf' ),
				'zoomInLeft'         => esc_html__( 'zoomInLeft', 'offtheshelf' ),
				'zoomInRight'        => esc_html__( 'zoomInRight', 'offtheshelf' ),
				'zoomInUp'           => esc_html__( 'zoomInUp', 'offtheshelf' ),
				'zoomOut'            => esc_html__( 'zoomOut', 'offtheshelf' ),
				'zoomOutDown'        => esc_html__( 'zoomOutDown', 'offtheshelf' ),
				'zoomOutLeft'        => esc_html__( 'zoomOutLeft', 'offtheshelf' ),
				'zoomOutRight'       => esc_html__( 'zoomOutRight', 'offtheshelf' ),
				'zoomOutUp'          => esc_html__( 'zoomOutUp', 'offtheshelf' ),
				'slideInDown'        => esc_html__( 'slideInDown', 'offtheshelf' ),
				'slideInLeft'        => esc_html__( 'slideInLeft', 'offtheshelf' ),
				'slideInRight'       => esc_html__( 'slideInRight', 'offtheshelf' ),
				'slideInUp'          => esc_html__( 'slideInUp', 'offtheshelf' ),
				'slideOutDown'       => esc_html__( 'slideOutDown', 'offtheshelf' ),
				'slideOutLeft'       => esc_html__( 'slideOutLeft', 'offtheshelf' ),
				'slideOutRight'      => esc_html__( 'slideOutRight', 'offtheshelf' ),
				'slideOutUp'         => esc_html__( 'slideOutUp', 'offtheshelf' ),
			),
			'priority' => 1
		);

		$fields['animation_duration'] = array(
			'name'        => esc_html__( 'Duration', 'offtheshelf' ),
			'type'        => 'text',
			'group'       => 'animation',
			'description' => esc_html__( 'Duration of animation in milliseconds (e.g. 1000).', 'offtheshelf' ),
			'priority'    => 5,
		);

		$fields['animation_delay'] = array(
			'name'        => esc_html__( 'Delay', 'offtheshelf' ),
			'type'        => 'text',
			'group'       => 'animation',
			'description' => esc_html__( 'Delay before the animation starts in milliseconds (e.g. 1000).', 'offtheshelf' ),
			'priority'    => 5,
		);
	}

	return $fields;
}
add_filter('siteorigin_panels_row_style_fields', 'offtheshelf_panels_row_style_fields');


function offtheshelf_panels_widget_style_fields( $fields ) {
	if (isset($fields['padding'])) unset($fields['padding']);

	$fields['text_alignment'] = array(
		'group' => 'layout',
		'name' => esc_html__('Text Alignment', 'offtheshelf'),
		'type' => 'select',
		'options' => array(
			'default'=> esc_html__('Row Default', 'offtheshelf'),
			'left'   => esc_html__('Left', 'offtheshelf'),
			'center' => esc_html__('Center', 'offtheshelf'),
			'right'  => esc_html__('Right', 'offtheshelf'),
		),
		'default' => 'default'
	);

	$fields['font_color']['name'] = esc_html__('Text Color', 'offtheshelf');

	$fields['padding_top'] = array(
		'name' => esc_html__('Padding (Top)', 'offtheshelf'),
		'type' => 'measurement',
		'group' => 'layout',
		'description' => esc_html__('Padding at the top of the widget.', 'offtheshelf'),
		'priority' => 2,
	);

	$fields['padding_bottom'] = array(
		'name' => esc_html__('Padding (Bottom)', 'offtheshelf'),
		'type' => 'measurement',
		'group' => 'layout',
		'description' => esc_html__('Padding at the bottom of the widget.', 'offtheshelf'),
		'priority' => 3,
	);

	$fields['padding_left'] = array(
		'name' => esc_html__('Padding (Left)', 'offtheshelf'),
		'type' => 'measurement',
		'group' => 'layout',
		'description' => esc_html__('Padding at the left of the widget.', 'offtheshelf'),
		'priority' => 4,
	);

	$fields['padding_right'] = array(
		'name' => esc_html__('Padding (Right)', 'offtheshelf'),
		'type' => 'measurement',
		'group' => 'layout',
		'description' => esc_html__('Padding at the right of the widget.', 'offtheshelf'),
		'priority' => 5,
	);

	/* Reponsiveness */
	$fields['hide_on_mobile'] = array(
		'name' => esc_html__('Hide on mobile devices', 'offtheshelf'),
		'type' => 'checkbox',
		'group' => 'responsiveness',
		'description' => esc_html__('Hides this widget on mobile devices.', 'offtheshelf'),
		'priority' => 1,
	);

	$fields['hide_on_tablet'] = array(
		'name' => esc_html__('Hide on tablets', 'offtheshelf'),
		'type' => 'checkbox',
		'group' => 'responsiveness',
		'description' => esc_html__('Hides this widget on tablets or laptops with small screens.', 'offtheshelf'),
		'priority' => 2,
	);

	$fields['hide_on_desktop'] = array(
		'name' => esc_html__('Hide on desktops', 'offtheshelf'),
		'type' => 'checkbox',
		'group' => 'responsiveness',
		'description' => esc_html__('Hides this widget on desktop or laptop computers with large screens.', 'offtheshelf'),
		'priority' => 3,
	);


	/* Animations */
	if ( ! defined ( 'OFFTHESHELF_DISABLE_ANIMATIONS' )) {

		$fields['animation_type'] = array(
			'name'     => esc_html__( 'Type', 'offtheshelf' ),
			'type'     => 'select',
			'group'    => 'animation',
			'options'  => array(
				''                   => esc_html__( 'None', 'offtheshelf' ),
				'bounce'             => esc_html__( 'bounce', 'offtheshelf' ),
				'flash'              => esc_html__( 'flash', 'offtheshelf' ),
				'pulse'              => esc_html__( 'pulse', 'offtheshelf' ),
				'rubberBand'         => esc_html__( 'rubberBand', 'offtheshelf' ),
				'shake'              => esc_html__( 'shake', 'offtheshelf' ),
				'swing'              => esc_html__( 'swing', 'offtheshelf' ),
				'tada'               => esc_html__( 'tada', 'offtheshelf' ),
				'wobble'             => esc_html__( 'wobble', 'offtheshelf' ),
				'jello'              => esc_html__( 'jello', 'offtheshelf' ),
				'bounceIn'           => esc_html__( 'bounceIn', 'offtheshelf' ),
				'bounceInDown'       => esc_html__( 'bounceInDown', 'offtheshelf' ),
				'bounceInLeft'       => esc_html__( 'bounceInLeft', 'offtheshelf' ),
				'bounceInRight'      => esc_html__( 'bounceInRight', 'offtheshelf' ),
				'bounceInUp'         => esc_html__( 'bounceInUp', 'offtheshelf' ),
				'bounceOut'          => esc_html__( 'bounceOut', 'offtheshelf' ),
				'bounceOutDown'      => esc_html__( 'bounceOutDown', 'offtheshelf' ),
				'bounceOutLeft'      => esc_html__( 'bounceOutLeft', 'offtheshelf' ),
				'bounceOutRight'     => esc_html__( 'bounceOutRight', 'offtheshelf' ),
				'bounceOutUp'        => esc_html__( 'bounceOutUp', 'offtheshelf' ),
				'fadeIn'             => esc_html__( 'fadeIn', 'offtheshelf' ),
				'fadeInDown'         => esc_html__( 'fadeInDown', 'offtheshelf' ),
				'fadeInDownBig'      => esc_html__( 'fadeInDownBig', 'offtheshelf' ),
				'fadeInLeft'         => esc_html__( 'fadeInLeft', 'offtheshelf' ),
				'fadeInLeftBig'      => esc_html__( 'fadeInLeftBig', 'offtheshelf' ),
				'fadeInRight'        => esc_html__( 'fadeInRight', 'offtheshelf' ),
				'fadeInRightBig'     => esc_html__( 'fadeInRightBig', 'offtheshelf' ),
				'fadeInUp'           => esc_html__( 'fadeInUp', 'offtheshelf' ),
				'fadeInUpBig'        => esc_html__( 'fadeInUpBig', 'offtheshelf' ),
				'fadeOut'            => esc_html__( 'fadeOut', 'offtheshelf' ),
				'fadeOutDown'        => esc_html__( 'fadeOutDown', 'offtheshelf' ),
				'fadeOutDownBig'     => esc_html__( 'fadeOutDownBig', 'offtheshelf' ),
				'fadeOutLeft'        => esc_html__( 'fadeOutLeft', 'offtheshelf' ),
				'fadeOutLeftBig'     => esc_html__( 'fadeOutLeftBig', 'offtheshelf' ),
				'fadeOutRight'       => esc_html__( 'fadeOutRight', 'offtheshelf' ),
				'fadeOutRightBig'    => esc_html__( 'fadeOutRightBig', 'offtheshelf' ),
				'fadeOutUp'          => esc_html__( 'fadeOutUp', 'offtheshelf' ),
				'fadeOutUpBig'       => esc_html__( 'fadeOutUpBig', 'offtheshelf' ),
				'flipInX'            => esc_html__( 'flipInX', 'offtheshelf' ),
				'flipInY'            => esc_html__( 'flipInY', 'offtheshelf' ),
				'flipOutX'           => esc_html__( 'flipOutX', 'offtheshelf' ),
				'flipOutY'           => esc_html__( 'flipOutY', 'offtheshelf' ),
				'lightSpeedIn'       => esc_html__( 'lightSpeedIn', 'offtheshelf' ),
				'lightSpeedOut'      => esc_html__( 'lightSpeedOut', 'offtheshelf' ),
				'rotateIn'           => esc_html__( 'None', 'offtheshelf' ),
				'rotateInDownLeft'   => esc_html__( 'rotateInDownLeft', 'offtheshelf' ),
				'rotateInDownRight'  => esc_html__( 'rotateInDownRight', 'offtheshelf' ),
				'rotateInUpLeft'     => esc_html__( 'rotateInUpLeft', 'offtheshelf' ),
				'rotateInUpRight'    => esc_html__( 'rotateInUpRight', 'offtheshelf' ),
				'rotateOut'          => esc_html__( 'rotateOut', 'offtheshelf' ),
				'rotateOutDownLeft'  => esc_html__( 'rotateOutDownLeft', 'offtheshelf' ),
				'rotateOutDownRight' => esc_html__( 'rotateOutDownRight', 'offtheshelf' ),
				'rotateOutUpLeft'    => esc_html__( 'rotateOutUpLeft', 'offtheshelf' ),
				'rotateOutUpRight'   => esc_html__( 'rotateOutUpRight', 'offtheshelf' ),
				'hinge'              => esc_html__( 'hinge', 'offtheshelf' ),
				'rollIn'             => esc_html__( 'rollIn', 'offtheshelf' ),
				'rollOut'            => esc_html__( 'rollOut', 'offtheshelf' ),
				'zoomIn'             => esc_html__( 'zoomIn', 'offtheshelf' ),
				'zoomInDown'         => esc_html__( 'zoomInDown', 'offtheshelf' ),
				'zoomInLeft'         => esc_html__( 'zoomInLeft', 'offtheshelf' ),
				'zoomInRight'        => esc_html__( 'zoomInRight', 'offtheshelf' ),
				'zoomInUp'           => esc_html__( 'zoomInUp', 'offtheshelf' ),
				'zoomOut'            => esc_html__( 'zoomOut', 'offtheshelf' ),
				'zoomOutDown'        => esc_html__( 'zoomOutDown', 'offtheshelf' ),
				'zoomOutLeft'        => esc_html__( 'zoomOutLeft', 'offtheshelf' ),
				'zoomOutRight'       => esc_html__( 'zoomOutRight', 'offtheshelf' ),
				'zoomOutUp'          => esc_html__( 'zoomOutUp', 'offtheshelf' ),
				'slideInDown'        => esc_html__( 'slideInDown', 'offtheshelf' ),
				'slideInLeft'        => esc_html__( 'slideInLeft', 'offtheshelf' ),
				'slideInRight'       => esc_html__( 'slideInRight', 'offtheshelf' ),
				'slideInUp'          => esc_html__( 'slideInUp', 'offtheshelf' ),
				'slideOutDown'       => esc_html__( 'slideOutDown', 'offtheshelf' ),
				'slideOutLeft'       => esc_html__( 'slideOutLeft', 'offtheshelf' ),
				'slideOutRight'      => esc_html__( 'slideOutRight', 'offtheshelf' ),
				'slideOutUp'         => esc_html__( 'slideOutUp', 'offtheshelf' ),
			),
			'priority' => 1
		);

		$fields['animation_duration'] = array(
			'name'        => esc_html__( 'Duration', 'offtheshelf' ),
			'type'        => 'text',
			'group'       => 'animation',
			'description' => esc_html__( 'Duration of animation in milliseconds (e.g. 1000).', 'offtheshelf' ),
			'priority'    => 5,
		);

		$fields['animation_delay'] = array(
			'name'        => esc_html__( 'Delay', 'offtheshelf' ),
			'type'        => 'text',
			'group'       => 'animation',
			'description' => esc_html__( 'Delay before the animation starts in milliseconds (e.g. 1000).', 'offtheshelf' ),
			'priority'    => 5,
		);

	}

	return $fields;

}
add_filter('siteorigin_panels_widget_style_fields', 'offtheshelf_panels_widget_style_fields');


function offtheshelf_panels_row_style_attributes($attr, $style) {
	if ( ! empty( $style['top_border'] ) ) {
		$attr['style'] .= 'border-top: 1px solid ' . $style['top_border'] . '; ';
	}
	if ( ! empty( $style['bottom_border'] ) ) {
		$attr['style'] .= 'border-bottom: 1px solid ' . $style['bottom_border'] . '; ';
	}

	// row bottom margin
	$margin_bottom = 0;
	if ( ! empty( $style['bottom_margin'] ) ) {
		$margin_bottom = esc_attr( $style['bottom_margin'] );
		$attr['style'] .= 'margin-bottom: ' . $margin_bottom . '; ';
	} else {
		$margin_bottom = offtheshelf_option( 'pagebuilder_row_margin_bottom', '0' );
		if ( $margin_bottom != 0 ) {
			$margin_bottom .= 'px';
		}
		$attr['style'] .= 'margin-bottom: ' . $margin_bottom . '; ';
	}

	// row padding
	$pad_left   = 0;
	$pad_right  = 0;
	$pad_top    = 0;
	$pad_bottom = 0;

	if ( ! empty( $style['padding_top'] ) ) {
		$pad_top = esc_attr( $style['padding_top'] );
	} else {
		$pad_top = offtheshelf_option( 'pagebuilder_row_padding_top', '0' );
		if ( $pad_top != 0 ) {
			$pad_top .= 'px';
		}
	}

	if ( ! empty( $style['padding_bottom'] ) ) {
		$pad_bottom = esc_attr( $style['padding_bottom'] );
	} else {
		$pad_bottom = offtheshelf_option( 'pagebuilder_row_padding_bottom', '0' );
		if ( $pad_bottom != 0 ) {
			$pad_bottom .= 'px';
		}
	}

	if ( ! empty( $style['padding_left'] ) ) {
		$pad_left = esc_attr( $style['padding_left'] );
	} else {
		$pad_left = offtheshelf_option( 'pagebuilder_row_padding_left', '0' );
		if ( $pad_left != 0 ) {
			$pad_left .= 'px';
		}
	}

	if ( ! empty( $style['padding_right'] ) ) {
		$pad_right = esc_attr( $style['padding_right'] );
	} else {
		$pad_right = offtheshelf_option( 'pagebuilder_row_padding_right', '0' );
		if ( $pad_right != 0 ) {
			$pad_right .= 'px';
		}
	}

	$attr['style'] .= 'padding: ' . $pad_top . " " . $pad_right . " " . $pad_bottom . " " . $pad_left . '; ';

	// row justification
	if ( ! empty( $style['row_justification'] ) ) {
		if ( $style['row_justification'] == 'left' ) {
			$attr['class'][] = 'row-justification-left';
		} elseif ( $style['row_justification'] == 'center' ) {
			$attr['class'][] = 'row-justification-center';
		} elseif ( $style['row_justification'] == 'right' ) {
			$attr['class'][] = 'row-justification-right';
		}
	} else {
		$attr['class'][] = 'row-justification-left';
	}

	// flexbox model
	if ( ! empty( $style['row_flexbox'] ) ) {
		$attr['class'][] = 'ots-flexbox';
	}

	//  background image options
	if( !empty( $style['background_image_attachment'] ) && !empty( $style['background_display']  ) ) {
		switch( $style['background_display'] ) {
			case 'ots-parallax':
				$attr['style'] .= 'background-size: cover;';
				$attr['class'][] = 'row-parallax';
				$attr['data-top'] = 'background-position:0px 0%;';
				$attr['data-300-bottom'] = 'background-position:0px 100%;';
				break;
			case 'fixed':
				$attr['style'] .= 'background-attachment: fixed; background-size: cover; background-position:center;';
				break;
		}
	}

	// animations
	if ( ! defined ( 'OFFTHESHELF_DISABLE_ANIMATIONS' )) {
		if ( ! empty( $style['animation_type'] ) ) {
			// type
			$animation_type = $style['animation_type'];

			// duration
			if ( empty( $style['animation_duration'] ) ) {
				$animation_duration = 1000;
			} else {
				$animation_duration = intval( $style['animation_duration'] );
			}

			// delay
			if ( empty( $style['animation_delay'] ) ) {
				$animation_delay = 0;
			} else {
				$animation_delay = intval( $style['animation_delay'] );
			}

			$attr['data-wow-duration'] = $animation_duration . 'ms';
			$attr['data-wow-delay']    = $animation_delay . 'ms';
			$attr['class'][]           = 'ots-wow';
			$attr['class'][]           = esc_attr( $animation_type );

		} // animation_type set
	}

	if(empty($attr['style'])) unset($attr['style']);
	return $attr;
}
add_filter('siteorigin_panels_row_style_attributes', 'offtheshelf_panels_row_style_attributes', 10, 2);


add_filter('siteorigin_panels_row_attributes', 'offtheshelf_panels_row_attributes', 10, 2);
function offtheshelf_panels_row_attributes($attrs, $options) {
	if ( isset($options['style']) && isset($options['style']['hide_on_mobile']) && $options['style']['hide_on_mobile'] == 1) {
		if ( isset($attrs['class']) ) {
			$attrs['class'] .= " hide-on-mobile";
		} else {
			$attrs['class'] = "hide-on-mobile";
		}
	}
	if ( isset($options['style']) && isset($options['style']['hide_on_tablet']) && $options['style']['hide_on_tablet'] == 1) {
		if ( isset($attrs['class']) ) {
			$attrs['class'] .= " hide-on-tablet";
		} else {
			$attrs['class'] = "hide-on-tablet";
		}
	}
	if ( isset($options['style']) && isset($options['style']['hide_on_desktop']) && $options['style']['hide_on_desktop'] == 1) {
		if ( isset($attrs['class']) ) {
			$attrs['class'] .= " hide-on-desktop";
		} else {
			$attrs['class'] = "hide-on-desktop";
		}
	}

	return $attrs;
}

function offtheshelf_panels_widget_style_attributes($attr, $style) {

	// padding
	$pad_left = 0;
	$pad_right = 0;
	$pad_top = 0;
	$pad_bottom = 0;
	if(!empty($style['padding_top']))
		$pad_top = esc_attr($style['padding_top']);
	if(!empty($style['padding_bottom']))
		$pad_bottom = esc_attr($style['padding_bottom']);
	if(!empty($style['padding_left']))
		$pad_left = esc_attr($style['padding_left']);
	if(!empty($style['padding_right']))
		$pad_right = esc_attr($style['padding_right']);

	if ( $pad_left != 0 || $pad_right != 0 || $pad_top != 0 || $pad_bottom != 0) {
		$attr['style'] .= 'padding: ' . $pad_top . " " . $pad_right . " " . $pad_bottom . " " . $pad_left . '; ';
	}

	// font color for widget
	if(!empty($style['font_color'])) {
		$wid = "ws-" . offtheshelf_panels_get_widget_id();
		$attr['id'] = $wid;
		$widget_style = '#wid p, #wid blockquote, #wid q, #wid span, #wid h1, #wid h2, #wid h3, #wid h4, #wid h5, #wid h6, #wid .testimonials footer, #wid .testimonial footer, .social-widget a { color:' .  $style['font_color'] . ' !important; }';
		$widget_style = str_replace("#wid", '#' . $wid, $widget_style );
		offtheshelf_add_custom_style('panel-widget', $widget_style);
	}

	// text alignment
	if(!empty($style['text_alignment'])) {
		if ( $style['text_alignment'] == 'left' ) {
			$attr['class'][] = 'text-align-left';
		} elseif ( $style['text_alignment'] == 'center' ) {
			$attr['class'][] = 'text-align-center';
		} elseif ( $style['text_alignment'] == 'right' ) {
			$attr['class'][] = 'text-align-right';
		}
	} else {
		// We need nothing done here, the row default will be applied.
		//$attr['class'][] = 'text-align-default';
	}

	if (isset($style['hide_on_mobile']) && $style['hide_on_mobile'] == 1) $attr['class'][] = "hide-on-mobile";
	if (isset($style['hide_on_tablet']) && $style['hide_on_tablet'] == 1) $attr['class'][] = "hide-on-tablet";
	if (isset($style['hide_on_desktop']) && $style['hide_on_desktop'] == 1) $attr['class'][] = "hide-on-desktop";


	// animations
	if ( ! defined ( 'OFFTHESHELF_DISABLE_ANIMATIONS' )) {
		if ( ! empty( $style['animation_type'] ) ) {
			// type
			$animation_type = $style['animation_type'];

			// duration
			if ( empty( $style['animation_duration'] ) ) {
				$animation_duration = 1000;
			} else {
				$animation_duration = intval( $style['animation_duration'] );
			}

			// delay
			if ( empty( $style['animation_delay'] ) ) {
				$animation_delay = 0;
			} else {
				$animation_delay = intval( $style['animation_delay'] );
			}

			$attr['data-wow-duration'] = $animation_duration . 'ms';
			$attr['data-wow-delay']    = $animation_delay . 'ms';
			$attr['class'][]           = 'ots-wow';
			$attr['class'][]           = esc_attr( $animation_type );

		} // animation_type set
	}

	return $attr;
}
add_filter('siteorigin_panels_widget_style_attributes', 'offtheshelf_panels_widget_style_attributes', 10, 2);


function offtheshelf_panels_get_widget_id() {
	global $offtheshelf_last_widget_id;
	if (empty($offtheshelf_last_widget_id)) $offtheshelf_last_widget_id = 0;
	$offtheshelf_last_widget_id++;
	return $offtheshelf_last_widget_id;
}

function offtheshelf_panels_widget_style_groups( $groups ) {
	if (isset($groups['theme'])) unset($groups['theme']);

	if ( ! defined ( 'OFFTHESHELF_DISABLE_ANIMATIONS' )) {
		$groups['animation'] = array(
			'name'     => esc_html__( 'Animation', 'offtheshelf' ),
			'priority' => 20
		);
	}

	$groups['responsiveness'] = array(
		'name' => esc_html__('Responsiveness', 'offtheshelf'),
		'priority' => 25
	);

	return $groups;
}
add_filter('siteorigin_panels_widget_style_groups', 'offtheshelf_panels_widget_style_groups');

function offtheshelf_panels_row_style_groups( $groups ) {
	if (isset($groups['theme'])) unset($groups['theme']);

	if ( ! defined ( 'OFFTHESHELF_DISABLE_ANIMATIONS' )) {
		$groups['animation'] = array(
			'name'     => esc_html__( 'Animation', 'offtheshelf' ),
			'priority' => 20
		);
	}

	$groups['responsiveness'] = array(
		'name' => esc_html__('Responsiveness', 'offtheshelf'),
		'priority' => 25
	);

	return $groups;
}
add_filter('siteorigin_panels_row_style_groups', 'offtheshelf_panels_row_style_groups');


function offtheshelf_panels_widget_tabs($tabs) {
	$offtheshelf_tabs[] = array(
			'title' => esc_html__('Off the Shelf', 'offtheshelf'),
			'filter' => array(
				'groups' => array('offtheshelf-widgets')
			)
		);

	array_splice($tabs, 1, 0, $offtheshelf_tabs);
	$tabs = array_values($tabs);
	return $tabs;
}
add_filter('siteorigin_panels_widget_dialog_tabs', 'offtheshelf_panels_widget_tabs', 20);


function offtheshelf_panels_add_recommended_widgets($widgets){
	global $offtheshelf_custom_widgets;

	// Off the Shelf Widgets
	foreach($offtheshelf_custom_widgets as $slug => $widget) {
		if( isset( $widgets[$widget] ) ) {
			$icon = strtolower(str_replace('_', '-', $widget));
			$widgets[$widget]['groups'] = array('offtheshelf-widgets');
			$widgets[$widget]['icon'] = 'dashicons ' . $icon;
		}
	}


	if (function_exists('is_woocommerce')) {
		// WooCommerce Widgets
		$woocommerce_widgets = array(
			'WC_Widget_Cart',
			'WC_Widget_Layered_Nav_Filters',
			'WC_Widget_Layered_Nav',
			'WC_Widget_Price_Filter',
			'WC_Widget_Product_Categories',
			'WC_Widget_Product_Search',
			'WC_Widget_Product_Tag_Cloud',
			'WC_Widget_Products',
			'WC_Widget_Recent_Reviews',
			'WC_Widget_Recently_Viewed',
			'WC_Widget_Top_Rated_Products'
		);
		foreach ($woocommerce_widgets as $widget) {
			if (class_exists($widget)) {
				$widgets[$widget]['icon'] = 'woocommerce-icon';
			}
		}
	}

	return $widgets;
}
add_filter('siteorigin_panels_widgets', 'offtheshelf_panels_add_recommended_widgets');


function offtheshelf_panels_options_admin_menu() {
	remove_submenu_page('options-general.php', 'siteorigin_panels');
}
add_action( 'admin_menu', 'offtheshelf_panels_options_admin_menu', 99);


function offtheshelf_panels_widget_classes ( $classes, $widget, $instance ) {
	$x=0;
	foreach ($classes as $class) {
		$classes[$x] = str_replace("widget_ots", "ots", $class);
		$x++;
	}
	return $classes;
}
add_filter('siteorigin_panels_widget_classes', 'offtheshelf_panels_widget_classes', 10, 3);




add_filter( 'body_class', 'offtheshelf_panels_add_body_classes' );
function offtheshelf_panels_add_body_classes( $classes ) {
	if ( offtheshelf_is_panel() && ! get_post_meta( get_the_ID(), OFFTHESHELF_OPTIONS_PREFIX . 'bypass_page_builder', false ) ) {
		$classes[] = 'ots-panels';
	} else {
		$classes[] = 'ots-no-panels';
	}
	return $classes;
}



function offtheshelf_panels_filter_content( $content ) {
	if ( !offtheshelf_is_woocommerce() && ( is_single() || is_page() ) && offtheshelf_is_panel() && !get_post_meta( get_the_ID(), OFFTHESHELF_OPTIONS_PREFIX . 'bypass_page_builder', false ) )
		$panel_content = offtheshelf_option('post_content', '');
	else
		$panel_content = $content;

	return $panel_content;
}

function offtheshelf_pre_the_content () {
	global $post;
	$content = '';

	if ( siteorigin_panels_is_panel() ) {
		if ( post_password_required() )
		{
			$content = get_the_password_form();
		} else {
			$panel_content = siteorigin_panels_render( $post->ID );
		}
		if ( !empty( $panel_content ) ) $content = $panel_content;
	}
	offtheshelf_set_option('post_content', $content);
}

if (!is_admin() && function_exists('siteorigin_panels_render')) {
	remove_filter( 'the_content', 'siteorigin_panels_filter_content' );
	add_action( 'wp', 'offtheshelf_pre_the_content', 9999 );
	add_filter( 'the_content', 'offtheshelf_panels_filter_content' );
}



function offtheshelf_panels_enqueue_styling_script() {
	wp_enqueue_script('siteorigin-panels-front-styles');

	if ( is_category() || is_archive() ) {
		wp_enqueue_style('siteorigin-panels-front');
	}
}
add_action('wp_enqueue_scripts', 'offtheshelf_panels_enqueue_styling_script', 99);

function offtheshelf_is_panel() {
	return get_post_meta(get_the_ID(), 'panels_data', false);
}
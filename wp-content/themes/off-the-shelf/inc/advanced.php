<?php
/**
 * Custom shortcodes and filter replacements
 *
 * @package offtheshelf
 */


if ( ! function_exists( 'offtheshelf_custom_gallery_shortcode' ) ) {
	function offtheshelf_custom_gallery_shortcode( $output, $attr ) {
		$post = get_post();

		if ( empty( $post ) ) {
			return;
		}

		static $instance = 0;
		$instance ++;

		if ( ! empty( $attr['ids'] ) ) {
			// 'ids' is explicitly ordered, unless you specify otherwise.
			if ( empty( $attr['orderby'] ) ) {
				$attr['orderby'] = 'post__in';
			}
			$attr['include'] = $attr['ids'];
		}


		// We're trusting author input, so let's at least make sure it looks like a valid orderby statement
		if ( isset( $attr['orderby'] ) ) {
			$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
			if ( ! $attr['orderby'] ) {
				unset( $attr['orderby'] );
			}
		}

		extract( shortcode_atts( array(
			'order'      => 'ASC',
			'orderby'    => 'menu_order ID',
			'id'         => $post->ID,
			'itemtag'    => 'dl',
			'icontag'    => 'dt',
			'captiontag' => 'dd',
			'columns'    => 3,
			'size'       => 'thumbnail',
			'include'    => '',
			'exclude'    => ''
		), $attr ) );

		$id = intval( $id );
		if ( 'RAND' == $order ) {
			$orderby = 'none';
		}

		if ( ! empty( $include ) ) {
			$_attachments = get_posts( array(
				'include'        => $include,
				'post_status'    => 'inherit',
				'post_type'      => 'attachment',
				'post_mime_type' => 'image',
				'order'          => $order,
				'orderby'        => $orderby
			) );

			$attachments = array();
			foreach ( $_attachments as $key => $val ) {
				$attachments[ $val->ID ] = $_attachments[ $key ];
			}
		} elseif ( ! empty( $exclude ) ) {
			$attachments = get_children( array(
				'post_parent'    => $id,
				'exclude'        => $exclude,
				'post_status'    => 'inherit',
				'post_type'      => 'attachment',
				'post_mime_type' => 'image',
				'order'          => $order,
				'orderby'        => $orderby
			) );
		} else {
			$attachments = get_children( array(
				'post_parent'    => $id,
				'post_status'    => 'inherit',
				'post_type'      => 'attachment',
				'post_mime_type' => 'image',
				'order'          => $order,
				'orderby'        => $orderby
			) );
		}

		if ( empty( $attachments ) ) {
			return '';
		}

		if ( is_feed() ) {
			$output = "\n";
			foreach ( $attachments as $att_id => $attachment ) {
				$output .= wp_get_attachment_link( $att_id, $size, true ) . "\n";
			}

			return $output;
		}

		$itemtag    = tag_escape( $itemtag );
		$captiontag = tag_escape( $captiontag );
		$icontag    = tag_escape( $icontag );
		$valid_tags = wp_kses_allowed_html( 'post' );
		if ( ! isset( $valid_tags[ $itemtag ] ) ) {
			$itemtag = 'dl';
		}
		if ( ! isset( $valid_tags[ $captiontag ] ) ) {
			$captiontag = 'dd';
		}
		if ( ! isset( $valid_tags[ $icontag ] ) ) {
			$icontag = 'dt';
		}

		$columns   = intval( $columns );
		$itemwidth = $columns > 0 ? floor( 100 / $columns ) : 100;
		$float     = is_rtl() ? 'right' : 'left';

		$selector = "gallery-{$instance}";

		$size_class  = sanitize_html_class( $size );
		$gallery_div = "<div id='$selector' class='gallery galleryid-{$id} gallery-columns-{$columns} gallery-size-{$size_class}'>";

		$output .= $gallery_div . "\n";
		$output .= '<ul>';

		$i = 0;
		foreach ( $attachments as $id => $attachment ) {
			$link = isset( $attr['link'] ) && 'file' == $attr['link'] ? wp_get_attachment_link( $id, $size, false, false ) : wp_get_attachment_link( $id, $size, true, false );

			$output .= "<li>";
			$output .= "{$link}";
			$output .= "</li>";
		}

		$output .= '</ul>';

		$output .= "</div>\n";

		return $output;
	}
}
add_filter( "post_gallery", "offtheshelf_custom_gallery_shortcode", 10, 2 );

if ( ! function_exists( 'offtheshelf_add_attachment_attributes' ) ) {
	function offtheshelf_add_attachment_attributes( $link, $id ) {
		global $post;

		if ( empty( $post ) ) {
			return;
		}

		$attachment = get_post( $id );
		$caption    = trim( wptexturize( $attachment->post_excerpt ) );

		if ( $caption ) {
			return str_replace( '<a href', '<a data-rel="gallery-' . $post->ID . '" title="' . esc_attr( $caption ) . '" href', $link );
		} else {
			return str_replace( '<a href', '<a data-rel="gallery-' . $post->ID . '" href', $link );
		}
	}
}
add_filter( 'wp_get_attachment_link', 'offtheshelf_add_attachment_attributes', 10, 2 );

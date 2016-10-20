<?php
/**
 * The Main Header
 *
 * Displays all of the <head> section and everything up until the start of the actual page content
 *
 * @package offtheshelf
 */
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">

	<!--Page Title-->
	<?php
	if ( ! function_exists( '_wp_render_title_tag' ) ) {
		function offtheshelf_render_title() {
			?>
			<title><?php wp_title( '|', true, 'right' ); ?></title>
			<?php
		}
		add_action( 'wp_head', 'offtheshelf_render_title' );
	}
	?>

	<!--Device Width Check-->
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no"/>

	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<?php
	/* for WP lower than 4.3 */
	if ( ! function_exists( 'has_site_icon' ) || ! has_site_icon() ) {
		offtheshelf_favicon();
	}
	?>

	<?php wp_head(); ?>
</head>
<body <?php body_class(offtheshelf_get_header_body_classes('')); ?>>
<div id="skrollr-body">
<?php do_action('offtheshelf_after_body'); ?>
<?php if (offtheshelf_is_layout('boxed')) : ?><div id="wrapper"><?php endif; ?>

	<?php offtheshelf_banner(); ?>

	<!--Start of Main Content-->
	<main>
		<div id="main_content" class="clearfix">

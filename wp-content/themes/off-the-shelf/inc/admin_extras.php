<?php
/*
 * Provides additional back-end tools
 * based on http://rudrastyh.com/wordpress/duplicate-post.html by Misha
 * @package offtheshelf
 */

/*
 * Admin Panel Extensions
 */

add_action( 'load-post.php', 'offtheshelf_remove_editor', 10 );
function offtheshelf_remove_editor(){
	if( !is_admin() ){ return; }
	$frontpage_id = intval( get_option('page_for_posts') );

	if( $frontpage_id != 0 && isset( $_GET['post'] ) && intval( $_GET['post'] ) == $frontpage_id ){
		remove_post_type_support( 'page', 'editor' );
		add_action('admin_notices', 'offtheshelf_display_posts_page_notice' );
		add_action('admin_head','offtheshelf_remove_post_metaboxes', 99);
	}
}

function offtheshelf_remove_post_metaboxes() {
	if ( ! is_admin() ) {
		return;
	}

	remove_meta_box( 'postcustom', 'page', 'normal' );
	remove_meta_box( 'postexcerpt', 'page', 'normal' );
	remove_meta_box( 'commentsdiv', 'page', 'normal' ); //removes comments
	remove_meta_box( 'commentstatusdiv', 'page', 'normal' );
	remove_meta_box( 'trackbacksdiv', 'page', 'normal' );
	remove_meta_box( 'slugdiv', 'page', 'normal' );
	remove_meta_box( 'authordiv', 'page', 'normal' );
	remove_meta_box( 'postimagediv', 'page', 'side' );

	remove_meta_box( 'offtheshelf_pagebuilder', 'page', 'normal' );
	remove_meta_box( 'offtheshelf_page_advanced', 'page', 'normal' );
	remove_meta_box( 'offtheshelf_title', 'page', 'normal' );
	remove_meta_box( 'offtheshelf_layout', 'page', 'normal' );
	remove_meta_box( 'offtheshelf_profile', 'page', 'side' );
	remove_meta_box( 'offtheshelf_layout_template', 'page', 'side' );

	remove_meta_box( 'so-panels-panels', 'page', 'advanced' );
}

function offtheshelf_display_posts_page_notice(){
	echo '<div class="updated"><p>';
	printf( offtheshelf_esc_html( __( '<p>This page is currently set as the <a href="%s">posts page</a>. Because it will display your most recent posts, the content editor is hidden. The purpose of this page is to reserve a URL for your posts page.</p><p>To change how this page is displayed, edit the <a href="%s">Theme Options</a>. </p>', 'offtheshelf' ) ), esc_url( admin_url('options-reading.php') ), esc_url ( admin_url('themes.php?page=offtheshelf_admin_page') ) );
	echo '</p></div>';
}


/*
 * Misc Tools
 */
add_filter( 'gettext', 'offtheshelf_profile_change_publish_button', 10, 2 );

function offtheshelf_profile_change_publish_button( $translation, $text ) {
	if ( 'profile' == get_post_type())
		if ( $text == 'Publish' )
			return esc_html__('Save Settings', 'offtheshelf');

	return $translation;
}


add_action( 'edit_form_top', 'offtheshelf_add_profile_tabs' );
function offtheshelf_add_profile_tabs() {
	$scr = get_current_screen();
	if ($scr->post_type !== 'profile')
		return;
?>
	<h2 class="nav-tab-wrapper" id="#profile-nav-tabs">
		<a class="nav-tab group-tab group-all nav-tab-active" data-group="all" href="#"><?php esc_html_e('All', 'offtheshelf'); ?></a>
		<a class="nav-tab group-tab group-general" href="#" data-group="general" ><?php esc_html_e('Layout &amp; Design', 'offtheshelf'); ?></a>
		<a class="nav-tab group-tab group-header" href="#" data-group="header" ><?php esc_html_e('Header', 'offtheshelf'); ?></a>
		<a class="nav-tab group-tab group-footer" href="#" data-group="footer" ><?php esc_html_e('Footer', 'offtheshelf'); ?></a>
		<a class="nav-tab group-tab group-typography" href="#" data-group="typography" ><?php esc_html_e('Typography', 'offtheshelf'); ?></a>
		<a class="nav-tab group-tab group-social" href="#" data-group="social" ><?php esc_html_e('Social Media', 'offtheshelf'); ?></a>
		<a class="nav-tab group-tab group-advanced" href="#" data-group="advanced" ><?php esc_html_e('Advanced', 'offtheshelf'); ?></a>
	</h2>
<?php
}


/*
 * Additional editor links in admin bar
 */
add_action( 'admin_bar_menu', 'offtheshelf_toolbar_links', 999 );

function offtheshelf_toolbar_links( $wp_admin_bar ) {

	if ($banner_id = offtheshelf_option('the_banner_id')) {
		// we have a banner id
	} else {
		$banner_id = false;
	}

	if ($profile_id = offtheshelf_option('the_profile_id')) {
		// have a profile id
	} else {
		$profile_id = false;
	}

	if ($profile_id) {
		$args = array(
			'id'    => 'ots_edit_profile',
			'title' => esc_html__('Edit Profile', 'offtheshelf'),
			'href'  => admin_url ('post.php?post=' . $profile_id . '&action=edit'),
			'meta'  => array( 'class' => 'ots-edit-profile'),
			'parent' => 'edit'
		);
		$wp_admin_bar->add_node( $args );
	}

	if ($banner_id) {
		$args = array(
			'id'    => 'ots_edit_banner',
			'title' => esc_html__('Edit Banner', 'offtheshelf'),
			'href'  => admin_url ('post.php?post=' . $banner_id . '&action=edit'),
			'meta'  => array( 'class' => 'ots-edit-banner'),
			'parent' => 'edit'
		);
		$wp_admin_bar->add_node( $args );
	}


}




/*
 * Toolbox links in editor
 */
function offtheshelf_editor_toolbox() {
	global $post;
	$type = get_post_type( $post->ID );
	if ( in_array( $type, array ('post', 'page', 'product') ) ) {
		$this_profile = get_post_meta($post->ID, 'sr_ots_profile', true);
		$this_banner  = get_post_meta($post->ID, 'sr_ots_custom_banner', true);
		?>
			<div class="inside">
				<?php if ( $this_profile ) : ?>
					<a href="<?php echo admin_url ('post.php?post=' . $this_profile . '&action=edit') ?>" class="button button-small"><?php esc_html_e('Edit Profile', 'offtheshelf'); ?></a>
				<?php endif; ?>

				<?php if ( $this_banner ) : ?>
					<a href="<?php echo admin_url ('post.php?post=' . $this_banner . '&action=edit') ?>" class="button button-small"><?php esc_html_e('Edit Banner', 'offtheshelf'); ?></a>
				<?php endif; ?>

			</div>
		<?php
	}
}
if ( defined ('OFFTHESHELF_FEATURE_PACK') ) {
	add_action('edit_form_after_title', 'offtheshelf_editor_toolbox');
}

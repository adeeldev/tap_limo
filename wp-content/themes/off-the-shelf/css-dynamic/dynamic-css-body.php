<?php
$offtheshelf_body = array(
	'boxed' => offtheshelf_is_layout('boxed'),
	'background_mode' => offtheshelf_option('body_background_mode'),
	'color' => offtheshelf_option('color_body_background'),
	'color_wrapper' => offtheshelf_option('color_body_background_boxed_wrapper'),
	'image' => offtheshelf_option('body_background_image')
);

$offtheshelf_body_css = '';

$offtheshelf_background_color = $offtheshelf_body['color'] . ';';

if ( $offtheshelf_body['background_mode'] == 'image-fixed' || $offtheshelf_body['background_mode'] == 'image-tile' || $offtheshelf_body['background_mode'] == 'image-parallax' ) {
	$image = $offtheshelf_body['image'];
	if ($image && is_serialized($image)) {
		$image = unserialize($image);
		if ($offtheshelf_body['background_mode'] == 'image-fixed') {
			$offtheshelf_body_css = 'background:' . $offtheshelf_body['color'] . ' url(' . $image['url'] . ') no-repeat;' . "\n";
			$offtheshelf_body_css .= 'background-attachment:fixed; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover; background-position:center;';
		}
		elseif ($offtheshelf_body['background_mode'] == 'image-parallax') {
			$offtheshelf_body_css = 'background:' . $offtheshelf_body['color'] . ' url(' . $image['url'] . ') no-repeat;' . "\n";
			$offtheshelf_body_css .= '-webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover; background-position:center;';
		}
		else
		{
			$offtheshelf_body_css = 'background:' . $offtheshelf_body['color'] . ' url(' . $image['url'] . ') repeat;';
		}
	} else { // no image set or does not exist
		$offtheshelf_body_css = 'background:' . $offtheshelf_body['color'] . ';';
	}
} elseif ( $offtheshelf_body['background_mode'] == 'solid' ) {
	$offtheshelf_body_css = 'background:' . $offtheshelf_body['color'] . ';';
}
?>

html, body, body.boxed {
<?php echo $offtheshelf_body_css; ?>
}

<?php if ( $offtheshelf_body['boxed'] ) : ?>
	#wrapper {
	background: <?php echo $offtheshelf_body['color_wrapper']; ?>;
	}
<?php endif; ?>

a, .product .price, .order-total .amount, .tagcloud a {
color: <?php echo offtheshelf_option('color_body_link'); ?>;
}

.widget_tag_cloud a {
font-size:<?php echo $f->get_font_color('font_body'); ?> !important;
}

a:hover, .header_meta a:hover,  .meta_data a:hover,
.product-options a.add_to_cart_button:hover, .product-options a.view-product-details:hover, .products a h3:hover {
color: <?php echo offtheshelf_option('color_body_link_hover'); ?>;
}

.blog_post.teaser h3 a:hover, .blog_post.teaser h2 a:hover, .format-quote a:hover blockquote q, .post_format-post-format-link a h2:hover {
color: <?php echo offtheshelf_option('color_body_link_hover'); ?>!important;
}

.off-the-shelf-recent-comments .comment-author, .widget_date, .woocommerce-tabs a, .payment_methods p, .woocommerce.widget_layered_nav small
{
color: <?php echo $body_font_color; ?>!important;
}

#header-cart .widget_shopping_cart, #header-cart .quantity, #header-cart .total, #header-cart .variation, #header-cart .widget_shopping_cart_content, #header-cart .widget_shopping_cart_content a, #header-cart h2, #header-cart .woocommerce-result-count,  #header-cart .widget_shopping_cart_content p.total, #header-region .search-form, .ots-language-switcher ul {
background: <?php echo offtheshelf_option('header_background'); ?>;
color: <?php echo offtheshelf_option('header_text');?>!important;
}

#header-cart li {
border-bottom:1px solid <?php echo offtheshelf_hex2rgba(offtheshelf_option('header_text'), .15) ?>;
}

#header-cart .total {
border-top:3px solid <?php echo offtheshelf_hex2rgba(offtheshelf_option('header_text'), .15) ?>;
}

#header-cart-trigger:before, #header-search-trigger:before, .ots-language-switcher ul:before {
color: <?php echo offtheshelf_option('header_background'); ?>;
}


.post-thumbnail:before,.format-image a:before, .gallery a:before, .blog-layout-minimal .post h2:before, .format-link a.format-link-content:before, .format-quote a blockquote q:before,
.ots-recent-posts li.format-link a:before, .ots-recent-posts li.format-video a:before, .ots-recent-posts li.format-quote a:before, .ots-recent-posts li.format-gallery a:before,
.ots-recent-posts li.format-image a:before, .navigation-posts-num li.active a, .page-numbers li span.current, .page-link span, #post_tags a:hover, .tagcloud a:hover, #header-cart-total,
#sub_footer .tagcloud a:hover {
background: <?php echo offtheshelf_option('color_body_link'); ?> !important;
<?php if (offtheshelf_is_layout('boxed')) : ?>
color: <?php echo offtheshelf_option('color_body_background_boxed_wrapper'); ?> !important;
<?php else : ?>
color: <?php echo offtheshelf_option('color_body_background'); ?> !important;
<?php endif; ?>
}

#header-cart-total:after {
color: <?php echo offtheshelf_option('color_body_link'); ?>;
}

#post_tags a:hover, #post_tags a:hover, .tagcloud a:hover {
border: 1px solid <?php echo offtheshelf_option('color_body_link'); ?>;
}

#header-top {
background: <?php echo offtheshelf_option('header_multipurpose_background'); ?>;
color: <?php echo offtheshelf_option('header_multipurpose_text'); ?> !important;
}

#header-top a, #header-top p {
color: <?php echo offtheshelf_option('header_multipurpose_text'); ?> !important;
}

#header-region {
color: <?php echo offtheshelf_option('header_text'); ?>;
}

.has-transparent-menu .animated-header-shrink #header-region, .has-solid-menu #header-region, .no-banner #header-region
{
background: <?php echo offtheshelf_hex2rgba(offtheshelf_option('header_background'), 1); ?>;
}

#main_navigation .sub-menu  {
background: <?php echo offtheshelf_option('header_background'); ?>;
border-top: 3px solid <?php echo offtheshelf_hex2rgba(offtheshelf_option('menu_link_hover'), 1); ?>;
}

#main_navigation a, #tool-navigation-lower, #tool-navigation-lower a,
.has-transparent-menu #banner.animated-header-shrink #header-region ul li a,
.has-transparent-menu #banner.animated-header-shrink #header-region #tool-navigation-lower,
.has-transparent-menu #banner #header-region ul li ul.sub-menu li a,
.has-transparent-menu #banner.animated-header-shrink #header-region #tool-navigation-lower a,
.has-transparent-menu #banner #header-region #tool-navigation-lower .ots-language-switcher ul li a {
color: <?php echo offtheshelf_option('header_text'); ?>;
}

#main_navigation a:hover,
.has-transparent-menu #banner #header-region ul li ul.sub-menu li a:hover,
.has-transparent-menu #banner #header-region ul li a:hover,
.sub-menu .current-menu-item a,
.has-transparent-menu #banner #header-region ul li ul.sub-menu li.current-menu-item a,
.has-transparent-menu #banner.animated-header-shrink #header-region ul li a:hover,
.has-solid-menu #banner .sub-menu li.current-menu-item a,
.ots-language-switcher li.active
{
color: <?php echo offtheshelf_option('menu_link_hover'); ?>;
}

#main_navigation a:hover, #main_navigation a.highlighted, #main_navigation .current-menu-item a,
.has-transparent-menu #banner.animated-header-shrink #header-region ul li a:hover,
.has-transparent-menu #banner.animated-header-shrink #main_navigation .current-menu-item a {
border-bottom: 3px solid <?php echo offtheshelf_hex2rgba(offtheshelf_option('menu_link_hover'), 1); ?>;
}

.has-transparent-menu #banner #header-region ul li a:hover,
.has-transparent-menu #banner #main_navigation .current-menu-item a {
border-bottom: 3px solid <?php echo offtheshelf_hex2rgba(offtheshelf_option('menu_link_hover'), 0); ?>;
}

#sub_footer  {
background: <?php echo offtheshelf_option('subfooter_background'); ?>;
color: <?php echo offtheshelf_option('subfooter_text'); ?>;
}

#sub_footer a, #sub_footer .widget h3, #sub_footer li p span.widget_date {
color: <?php echo offtheshelf_option('subfooter_text'); ?>!important;
}

#page_footer, #page_footer a {
background: <?php echo offtheshelf_option('footer_background'); ?>;
color: <?php echo offtheshelf_option('footer_text'); ?>;
}

@media (max-width: 980px) {
#main_navigation a, #tool-navigation-lower, #tool-navigation-lower a, .has-transparent-menu #banner.animated-header-shrink #header-region ul li a, .has-transparent-menu #banner.animated-header-shrink #header-region #tool-navigation-lower, .has-transparent-menu #banner #header-region ul li ul.sub-menu li a, .has-transparent-menu #banner.animated-header-shrink #header-region #tool-navigation-lower a  {
color: <?php echo offtheshelf_option('header_text');?>;
}
.sm li, #header-search {
border-bottom:1px solid <?php echo offtheshelf_hex2rgba(offtheshelf_option('header_text'), .3); ?> !important;
}
.has-transparent-menu  #header-region, .has-solid-menu #header-region, .no-banner #header-region
{
background: <?php echo offtheshelf_hex2rgba(offtheshelf_option('header_background'), 1); ?>;
}
#main_navigation a, #tool-navigation-lower, #tool-navigation-lower a,
.has-transparent-menu #banner #header-region ul li a,
.has-transparent-menu #banner #header-region #tool-navigation-lower,
.has-transparent-menu #banner #header-region ul li ul.sub-menu li a,
.has-transparent-menu #banner #header-region #tool-navigation-lower a {
color: <?php echo offtheshelf_option('header_text'); ?> !important;
}
#banner #header-region #logo h1 a {
color: <?php echo $f->get_font_color('font_logo'); ?> !important;
}
.has-transparent-menu #banner #header-region #logo h2 {
color: <?php echo $f->get_font_color('font_logo_tagline'); ?> !important;
}
}
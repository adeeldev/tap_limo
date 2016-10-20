<?php
/**
 * The sub banner used on all WooCommerce pages
 * @package offtheshelf
 */
?>
<?php if ( ! offtheshelf_custom_block('sub_banner_woocommerce') ) : ?>
	<header id="page-header">
		<div class="row<?php if (offtheshelf_option('header_sub_banner_full_width', false)) echo ' row-full-width'; ?>">
			<?php
			$title = "";
			if(is_shop()) $title  = get_option('woocommerce_shop_page_title');

			$shop_id = woocommerce_get_page_id('shop');
			if($shop_id && $shop_id != -1)
			{
				if(empty($title)) $title = get_the_title($shop_id);
			}

			if (is_cart() || is_checkout()) $title = get_the_title();

			if(!$title) $title  = esc_html__("Shop", 'offtheshelf');

			echo '<h1 class="page-title">' . esc_html( $title ) . '</h1>';
			?>

			<?php if (!is_home()) : ?>
				<div id="breadcrumb">
					<span><?php esc_html_e('You are here:', 'offtheshelf'); ?></span>
					<?php woocommerce_breadcrumb(); ?>
				</div>
			<?php endif; ?>
		</div>
	</header>
<?php endif; ?>